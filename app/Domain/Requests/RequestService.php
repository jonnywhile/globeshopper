<?php namespace App\Domain\Requests;

use Intervention\Image\Facades\Image;

class RequestService
{
    public function uploadRequestImage($file) {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file)->resize(300, 300)->save(public_path('/requests/' . $filename));

        return $image;
    }
}