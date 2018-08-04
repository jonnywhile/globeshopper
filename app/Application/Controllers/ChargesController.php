<?php namespace App\Application\Controllers;

use App\Domain\Charges\Charge;
use App\Domain\Requests\Request as RequestModel;
use App\Domain\Requests\RequestCharged;
use App\Infrastructure\Repositories\ChargesRepository;
use App\Infrastructure\Repositories\OffersRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class ChargesController extends BaseController
{

    /**
     * @var RequestsRepository
     */
    private $requestsRepository;
    /**
     * @var ChargesRepository
     */
    private $chargesRepository;
    /**
     * @var OffersRepository
     */
    private $offersRepository;

    public function __construct(
        RequestsRepository $requestsRepository,
        ChargesRepository $chargesRepository,
        OffersRepository $offersRepository)
    {
        parent::__construct();
        $this->requestsRepository = $requestsRepository;
        $this->chargesRepository = $chargesRepository;
        $this->offersRepository = $offersRepository;
    }

    public function pay($requestId) {
        $request = $this->requestsRepository->get($requestId);

        return view('requests/checkout', [
            'request' => $request
        ]);
    }

    public function createCharge($requestId, Request $requestInput) {
        $token = $requestInput->input('stripeToken');

        $request = $this->requestsRepository->get($requestId);
        $offer = $this->offersRepository->get($requestId);

        $stripe = Stripe::make($request->globshopper->stripeSecretKey);

        $customer = $stripe->customers()->create([
            'email' => $request->user->email,
            'source' => $token
        ]);

        $chargeData = $stripe->charges()->create([
            'customer' => $customer['id'],
            'currency' => 'USD',
            'amount'   => $offer->price,
        ]);
        // Make domain object
        $charge = new Charge($request, $chargeData['id'], $customer['id'], $offer->price);
        $this->chargesRepository->store($charge);

        $request->offerAccepted();

        $this->requestsRepository->store($request);

        event(new RequestCharged($request));

        return response($charge);
    }

}