<?php namespace App\Application\Controllers;

use App\Domain\Offers\Offer;
use App\Domain\Offers\OfferCreated;
use App\Domain\Offers\OfferService;
use App\Domain\Requests\Request as RequestModel;
use App\Domain\Util\Picture;
use App\Infrastructure\Repositories\OffersRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OffersController extends BaseController
{
    /**
     * @var RequestsRepository
     */
    private $requestsRepository;
    /**
     * @var OffersRepository
     */
    private $offersRepository;

    public function __construct(
        RequestsRepository $requestsRepository,
        OffersRepository $offersRepository
    ) {
        parent::__construct();
        $this->requestsRepository = $requestsRepository;
        $this->offersRepository = $offersRepository;
    }

    public function create($requestId, Request $requestInput) {
        $data = $requestInput->post();

        $request = $this->requestsRepository->get($requestId);
        $picture = new Picture('/offers/');
        $picture->save($requestInput->file('offer_image'));

        $offer = new Offer(
            $request,
            null,
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['amount'],
            $data['price'],
            $data['delivery_fee'],
            Carbon::createFromFormat('m/d/Y', $data['delivery_date']),
            $data['delivery_type'],
            $picture
        );

        $this->offersRepository->store($offer);
        // Set request created offer
        $request->createOffer($offer);
        $this->requestsRepository->store($request);

        event(new OfferCreated($offer));

        return response($offer);
    }

    public function update($offerId, Request $request) {
        $data = $request->post();

        $offer = $this->offersRepository->getById($offerId);

        $data['delivery_date'] = Carbon::createFromFormat('m/d/Y', $request->input('delivery_date'));

        if ($request->file('offer_image')) {
            $picture = new Picture('/offers/');
            $picture->save($request->file('offer_image'));
        }

        $offer = new Offer(
            $offer->request,
            $offerId,
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['amount'],
            $data['price'],
            $data['delivery_fee'],
            $data['delivery_date'],
            $data['delivery_type'],
            $picture ?? null
        );

        $this->offersRepository->store($offer);

        return response($offer);
    }
}