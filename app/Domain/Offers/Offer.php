<?php namespace App\Domain\Offers;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Domain\Requests\Request;
use App\Domain\Util\Picture;

class Offer
{
    use PropertiesTrait, JsonableTrait;

    private $request;
    private $id;
    private $name;
    private $description;
    private $amount;
    private $price;
    private $deliveryFee;
    // Carbon
    private $deliveryDate;
    private $deliveryType;
    // Picture
    private $picture;

    public function __construct(
        Request $request,
        $id,
        $name,
        $description,
        $amount,
        $price,
        $deliveryFee,
        $deliveryDate,
        $deliveryType,
        Picture $picture = null
    )
    {
        $this->request = $request;
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->amount = $amount;
        $this->price = $price;
        $this->deliveryFee = $deliveryFee;
        $this->deliveryDate = $deliveryDate;
        $this->deliveryType = $deliveryType;
        $this->picture = $picture;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
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
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
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
    public function getDeliveryFee()
    {
        return $this->deliveryFee;
    }

    /**
     * @return mixed
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @return mixed
     */
    public function getDeliveryType()
    {
        return $this->deliveryType;
    }

    public static function makeFromModel(\App\Infrastructure\Models\Offer $offer) {
        $offer->load([
            'request',
            'request.user'
        ]);

        $request = Request::makeFromModel($offer->request);
        $picture = new Picture('/offers/', $offer->picture);

        return new self(
            $request,
            $offer->id,
            $offer->name,
            $offer->description,
            $offer->amount,
            $offer->price,
            $offer->delivery_fee,
            $offer->delivery_date,
            $offer->delivery_type,
            $picture);
    }
}