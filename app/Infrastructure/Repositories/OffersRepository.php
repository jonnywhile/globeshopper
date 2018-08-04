<?php namespace App\Infrastructure\Repositories;

use App\Domain\Offers\Offer;
use App\Infrastructure\Models\Offer as OfferModel;

class OffersRepository
{
    public function get($requestId) {
        $offer = (new OfferModel())
            ->where('request_id', $requestId)
            ->get()->first();

        return ($offer) ? Offer::makeFromModel($offer) : null;
    }

    public function getById($id) {
        return Offer::makeFromModel((new OfferModel())->find($id));
    }

    public function store($offer) {
        return (new OfferModel())->updateOrCreate(
            ['id' => $offer->id],
            [
                'request_id' => $offer->request->id,
                'name' => $offer->name,
                'description' => $offer->description,
                'amount' => $offer->amount,
                'price' => $offer->price,
                'delivery_fee' => $offer->deliveryFee,
                'delivery_date' => $offer->deliveryDate,
                'delivery_type' => $offer->deliveryType,
                'picture' => $offer->picture->name ?? ''
            ]
        );
    }
}