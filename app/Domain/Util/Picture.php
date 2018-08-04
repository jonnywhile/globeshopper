<?php namespace App\Domain\Util;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use Intervention\Image\Facades\Image;

class Picture
{
    use PropertiesTrait, JsonableTrait;

    private $folder;
    private $name;
    private $path;

    /**
     * Picture constructor.
     * @param $path
     */
    public function __construct($folder, $name = null)
    {
        $this->folder = $folder;
        $this->name = $name;
        $this->path = public_path($folder . $name);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getFolder()
    {
        return $this->folder;
    }

    public function save($file) {
        if ($file !== null) {
            $this->name = time() . '.' . $file->getClientOriginalExtension();
            $this->path = public_path($this->folder . $this->name);

            $image = Image::make($file)->resize(300, 300)->save($this->path);

            return $image;
        } else {
            return null;
        }
    }


}