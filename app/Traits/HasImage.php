<?php

namespace App\Traits;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterImage;

trait HasImage
{
    protected int $max_width = 1024;
    protected int $max_height = 1024;
    protected string $image_format = 'webp';
    protected int $image_quality = 95;
    protected array $thumb_sizes = [512, 256];

    /*
     * make thumbnail photo by given file.
     */
    public function syncThumbnail(?UploadedFile $thumbnail_file): void
    {
        if (!$thumbnail_path = $this->uploadImage($thumbnail_file)) return;

        $this->deleteThumbnail($this->thumbnail, $this->thumb_sizes);
        $this->makeThumbnail($thumbnail_path, $this->thumb_sizes);
        $this->update(['thumbnail' => $thumbnail_path]);

    }


    /**
     * make smaller thumbnails by given sizes.
     */
    protected function makeThumbnail(string $image_path, array $sizes): void
    {
        $user_directory = $this->author->mediaDir();
        foreach ($sizes as $size) {
            $image = image::make(public_path($this->author->mediaPath($image_path)));
            $image = resizeWithAspectRatio($image, $size);
            $image->save(public_path($user_directory . $size . $image_path));
        }
    }

    /*
     * delete thumbnail photo and thumbnails from storage
     */
    protected function deleteThumbnail(?string $image_path, array $sizes): void
    {
        if (!isset($image_path))
            return;

        $user_directory = $this->author->mediaDir();

        if (file_exists($thumbnail = public_path($this->author->mediaPath($image_path))))
            unlink($thumbnail);

        foreach ($sizes as $size) {
            if (file_exists($thumbnail = public_path($this->author->mediaPath($size . $image_path))))
                unlink($thumbnail);
        }
    }


    /**
     * resize big images to maximum size it can be.
     */
    protected function resizeImageToMaxSize(UploadedFile|InterImage $image): UploadedFile|InterImage
    {
        if ($image->getWidth() < $this->max_width && $image->getHeight() < $this->max_height) {
            return $image; // don't resize image if it's smaller than expected
        }

        return resizeWithAspectRatio($image, $this->max_width);
    }

    /**
     * generate unique name for image.
     */
    protected function imageFilename(UploadedFile $image): string
    {
        return mt_rand(0,100).substr(time(),0, mt_rand()) . $image->getClientOriginalName();
    }

    /**
     * uploads given file and returns name of file
     */
    protected function uploadImage(?UploadedFile $image): string|bool
    {
        if (!isset($image)) return false;

        $upload_directory = $this->author->mediaDir();
        $file_name = uniqueNameGenerator($upload_directory);
        $resize = null;
        $image = Image::make($image);
        if (!$image->getWidth() < $this->max_width && $image->getHeight() < $this->max_height) {
            $resize = $this->max_width;
        }

        return uploadImage($image, $upload_directory, $file_name, $this->image_format, $this->image_quality, $resize);
    }
}
