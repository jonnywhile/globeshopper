<?php namespace App\Domain\Offers;

use Illuminate\Queue\SerializesModels;

class OfferCreated
{
    use SerializesModels;

    public $user;
    public $text;

    /**
     * Create a new event instance.
     *
     * @param Offer $offer
     */
    public function __construct(Offer $offer)
    {
        $this->user = $offer->request->user;
        $this->text = trans(
            'general.notifications.offer_created',
            [
                'requestId' => $offer->request->id
            ]
        );
    }
}