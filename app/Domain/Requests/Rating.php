<?php namespace App\Domain\Requests;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Infrastructure\Models\Rating as RatingModel;

class Rating
{
    use PropertiesTrait, JsonableTrait;

    private $rating;
    private $comment;

    public function __construct($rating, $comment)
    {
        $this->rating = $rating;
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    public static function makeFromModel(RatingModel $rating) {

        return new self($rating->rating, $rating->comment);
    }
}