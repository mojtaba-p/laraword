<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }




    /**
     * set current category as a subcategory to another category.
     *
     * @param Category $category
     * @return void
     */
    public function setParent(Category $category)
    {
        $this->parent_id = $category->id;
        $this->save();
    }

    public function subCategories(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * adds subcategory to this category.
     *
     * @param Category $category
     * @return void
     */
    public function addSubCategory(Category $category)
    {
        $category->parent_id = $this->id;
        $category->save();
    }

    /**
     * returns articles with public status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publishedArticles()
    {
        return $this->articles()->where('status', Article::STATUS_PUBLIC);
    }


    /**
     * category and article relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
