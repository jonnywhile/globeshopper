<?php namespace App\Domain\Offers;

use Intervention\Image\Facades\Image;

class OfferService
{

    public function uploadOfferImage($file) {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $image = Image::make($file)->resize(300, 300)->save(public_path('/offers/' . $filename));

        return $image;
    }
}