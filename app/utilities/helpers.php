<?php

use Illuminate\Filesystem\Filesystem;
use Intervention\Image\Facades\Image;

if (!function_exists('ensureMediaDirectoryExists')) {
    /**
     * ensure directory exists for upload media and then
     * create index file for avoid directory listing
     */
    function ensureMediaDirectoryExists($media_dir): void
    {
        $filesystem = new Filesystem();
        $filesystem->ensureDirectoryExists(public_path($media_dir));
        $index_file_path = public_path($media_dir . DIRECTORY_SEPARATOR . 'index.php');
        if ($filesystem->missing($index_file_path)) {
            $filesystem->put($index_file_path, '<?php');
        }
    }

}


if (!function_exists('uploadImage')) {

    /**
     * uploads given file and returns name of file
     */
    function uploadImage(
        mixed $image, string $directory, string $name, string $format = 'jpg',
        int                           $quality = 95, ?int $resize_to = null
    ): string|bool
    {
        if (!isset($image)) return false;

        ensureMediaDirectoryExists($directory);

        if (isset($resize_to))
            $image = resizeWithAspectRatio($image, $resize_to);

        if(!$image instanceof Image)
            $image = Image::make($image);

        $image = $image->encode($format, $quality);

        $image->save(public_path($directory . $name . '.' . $format));
        return $name. '.' . $format;
    }
}


if (!function_exists('resizeWithAspectRatio')) {
    /**
     * resize image without deforming.
     */
    function resizeWithAspectRatio($image, $size): mixed
    {
        if ($image->getWidth() > $image->getHeight()) {
            $image->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $image->resize(null, $size, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $image;
    }
}

if (!function_exists('allTopics')) {
    /**
     * returns all tag sorted by articles count
     */
    function allTopics(): \Illuminate\Database\Eloquent\Collection
    {
        return \App\Models\Tag::withCount(['articles' => function ($query) {
            $query->where('status', \App\Models\Article::STATUS_PUBLIC);
        }])->orderBy('articles_count', 'desc')->get();
    }
}

if (!function_exists('thumbnailTailwindClass')) {

    /*
     * return class names that fit image placeholder
     */
    function thumbnailTailwindClass(string $image_src): string
    {

        $img_info = getimagesize($image_src);
        return ($img_info[0] > $img_info[1]) ? 'h-full w-fit' : 'h-fit w-full';
    }
}

if (!function_exists('uniqueNameGenerator')) {
    /*
     * generates random unique name
     */
    function uniqueNameGenerator(string $directory): string
    {
        $i = 0;
        do {
            $i++;
            if ($i < 2)
                $name = substr(str_shuffle(sha1(time()) . str_shuffle(time())), 0, 10);
            elseif ($i < 3)
                $name = substr(str_shuffle(sha1(time()) . str_shuffle(time())), 0, 15);
            elseif ($i < 5)
                $name = substr(str_shuffle(sha1(time()) . str_shuffle(time())), 0, 20);
            else
                $name = str_shuffle(sha1(time()) . str_shuffle(time()));

            $path = $directory . DIRECTORY_SEPARATOR . $name;

            if ((!is_dir($path)) && (!file_exists($path)))
                break;
        } while (true);
        return $name;
    }
}
