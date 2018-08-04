<?php namespace App\Domain\Requests;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Domain\Globshoppers\Globshopper;
use App\Domain\Offers\Offer;
use App\Domain\Users\User;
use App\Domain\Util\Picture;
use Illuminate\Support\Facades\Auth;

class Request
{
    use PropertiesTrait, JsonableTrait;

    private $id;
    private $user;
    private $globshopper;
    private $name;
    private $description;
    private $category;
    private $amount;
    // PriceRange
    private $priceRange;
    // Picture
    private $picture;
    private $status;
    private $isCancelled;
    private $isClosed;
    // Offer
    private $offer;
    // Rating
    private $rating;

    public function __construct(
        $id,
        User $user,
        Globshopper $globshopper,
        $name,
        $description,
        Category $category,
        $amount,
        PriceRange $priceRange,
        Picture $picture = null,
        $status,
        $isCancelled = false,
        $isClosed = false,
        $rating = null
    )
    {
        $this->id = $id;
        $this->user = $user;
        $this->globshopper = $globshopper;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->amount = $amount;
        $this->priceRange = $priceRange;
        $this->picture = $picture;
        $this->status = $status;
        $this->isCancelled = $isCancelled;
        $this->isClosed = $isClosed;
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Globshopper
     */
    public function getGlobshopper()
    {
        return $this->globshopper;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return PriceRange
     */
    public function getPriceRange()
    {
        return $this->priceRange;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getIsCancelled()
    {
        return $this->isCancelled;
    }

    /**
     * @return mixed
     */
    public function getIsClosed()
    {
        return $this->isClosed;
    }

    /**
     * @return null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @return null
     */
    public function getOffer()
    {
        return $this->offer;
    }

    public function createOffer($offer) {
        $this->offer = $offer;
        $this->status = 'OFFER_CREATED';
    }

    public function rate($rating) {
        $this->rating = $rating;
    }

    public function accepted() {
        $this->status = 'ACCEPTED';
    }

    public function cancelled() {
        if (Auth::user()->is('globshopper')) {
            $this->status = 'CLOSED_GLOBSHOPPER_CANCELLED';
        } else {
            $this->status = 'CLOSED_BUYER_CANCELLED';
        }

        $this->isCancelled = true;
        $this->isClosed = true;
    }

    public function offerAccepted() {
        $this->status = 'OFFER_ACCEPTED';
    }

    public function delivered() {
        $this->status = 'CLOSED_DELIVERED';
        $this->isClosed = true;
    }

    public function closeWithStatus($status) {
        $this->status = $status;
        $this->isClosed = true;
    }

    public static function makeFromModel(\App\Infrastructure\Models\Request $request) {
        $request->load(['user', 'globshopper', 'category', 'rating', 'offer']);

        $user = User::makeFromModel($request->user);
        $globshopper = Globshopper::makeFromModel($request->globshopper);
        $category = Category::makeFromModel($request->category);
        $priceRange = new PriceRange($request->price_from, $request->price_to);
        $picture = new Picture('/requests/', $request->picture);
        $rating = ($request->rating) ? Rating::makeFromModel($request->rating) : null;

        return new self(
            $request->id,
            $user,
            $globshopper,
            $request->name,
            $request->description,
            $category,
            $request->amount,
            $priceRange,
            $picture,
            $request->status,
            $request->is_cancelled,
            $request->is_closed,
            $rating);
    }

}