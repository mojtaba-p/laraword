<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CommentNotification;
use App\Notifications\LikeNotification;
use App\Traits\Followable;
use App\Traits\HasFollowing;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Followable, HasFollowing;

    protected const MEDIA_ROOT = 'media';

    const USER = 'user';
    const EDITOR = 'editor';
    const MANAGER = 'manager';
    const ADMIN = 'admin';
    const ROLES = [self::ADMIN, self::MANAGER, self::EDITOR, self::USER];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'username', 'email', 'bio', 'social', 'password', 'photo'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token',];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social' => 'array'
    ];

    public function getRouteKeyName(): string
    {
        return 'username';
    }


    public function profileLink(): string
    {
        return url('/@' . $this->username);
    }

    public static function boot()
    {
        parent::boot();
        static::created(fn(User $user) => $user->boxes()->create([
            'name' => 'Reading List',
            'slug' => $user->username . '-reading-List',
            'private' => true
        ]));
    }

    /**
     * returns users notification cache key for access to cache
     * @return string
     */
    public function notificationsCacheKey(): string
    {
        return 'user-' . $this->id . '-notifications';
    }

    // order options for generate select input
    public static function orderOptions(): array
    {
        return [
            'articles_count' => __('Articles Count'),
            'email_verified_at' => __('Verification Date'),
            'comments_count' => __('Comments Count'),
            'likes_count' => __('Likes Count'),
        ];
    }

    /** filter results by given request */
    public static function scopeFilterResults(Builder $query, $request): void
    {
        if (isset($request['name']) && !empty($request['name'])) {
            $query->where('name', 'like', "%{$request['name']}%")
                ->orWhere('username', 'like', "%{$request['name']}%");
        }

        if (isset($request['role']) && !empty($request['role'])) {
            if (in_array($request['role'], self::ROLES))
                $query->where('role', $request['role']);
        }

        if (isset($request['order']))
            $query->orderResults($request['order'], $request['sort']);
        else
            $query->orderBy('updated_at', 'desc');
    }

    /**
     * sorts users by given column
     */
    public static function scopeOrderResults(Builder $query, string $order, string $sort = 'desc'): void
    {
        if (in_array($order, array_keys(self::orderOptions()))) {
            $query->orderBy($order, $sort);
        }
    }

    /**
     * limits users to the given date period
     */
    public static function scopeLimitToDate(Builder $query, string $order, string $period = null): void
    {
        $day = $period == 'today' ? 1 : ($period == 'last_week' ? 7 : ($period == 'last_month' ? 30 : null));
        if (!isset($day)) {
            return;
        }
        $query->where('created_at', '>=', now()->subDay($day)->endOfDay());

        $limiter = function ($query) use ($day) {
            $query->where('created_at', '>=', now()->subDay($day)->endOfDay());
        };

        $query->withCount(['likes' => $limiter, 'comments' => $limiter, 'articles' => $limiter]);
    }

    /**
     * returns is user has given role or not.
     */
    public function hasRole(string|array $role): bool
    {
        if (in_array($this->email, config('laraword.admins'))) {
            $this->role = self::ADMIN;
            $this->save();
        }

        if($this->role == self::ADMIN && !in_array($this->email, config('laraword.admins'))){
            $this->role = self::USER; // role changes when user not in list
            $this->save();
        }

        if (is_string($role)) {
            return $this->role == $role;
        }

        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return false;
    }

    /**
     * changes role of user.
     * @throws Exception
     */
    public function setRole(string $role): bool
    {
        if (!in_array($role, self::ROLES)) {
            throw new Exception('INVALID ROLE');
        }

        $this->role = $role;
        $this->save();
        return true;
    }


    /**
     * return path
     * @return string
     */
    public function getPhotoPath(): string
    {
        return 'profiles' . DIRECTORY_SEPARATOR . $this->photo;
    }


    // return media directory path of user
    public function mediaDir($with_separator = true): string
    {
        if (!isset($this->media_directory)) {
            $this->generateMediaDirectory();
        }

        $path = $this->media_directory;

        if ($with_separator)
            return $path . DIRECTORY_SEPARATOR;

        return $path;
    }

    /** Generates Unique Directory For User Media */
    public function generateMediaDirectory(): void
    {
        do {
            $unique_name = uniqueNameGenerator(self::MEDIA_ROOT);
            $directory_path = self::MEDIA_ROOT . DIRECTORY_SEPARATOR . $unique_name;
            if (!is_dir($directory_path)) {
                ensureMediaDirectoryExists($directory_path);
                $this->media_directory = $directory_path;
                $this->save();
                break;
            }
        } while (true);
    }

    // local path of media
    public function mediaPath($media_name): string
    {
        return str_replace('\\', '/', $this->mediaDir() . $media_name);
    }


    /**
     * user articles relationship.
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * like and user relationship.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * comment and user relationship.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function boxes(): HasMany
    {
        return $this->hasMany(Box::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }
}
