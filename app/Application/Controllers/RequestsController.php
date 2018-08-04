<?php namespace App\Application\Controllers;

use App\Domain\Requests\PriceRange;
use App\Domain\Requests\RequestAccepted;
use App\Domain\Requests\RequestCancelled;
use App\Domain\Requests\RequestDelivered;
use App\Domain\Users\User;
use App\Domain\Util\Picture;
use App\Infrastructure\Repositories\CategoriesRepository;
use App\Infrastructure\Repositories\ComplaintsRepository;
use App\Infrastructure\Repositories\GlobshopperRepository;
use App\Infrastructure\Repositories\OffersRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use Illuminate\Http\Request;
use App\Domain\Requests\Request as RequestDomain;
use Illuminate\Support\Facades\Auth;

class RequestsController extends BaseController
{
    private $requestsRepository;
    /**
     * @var GlobshopperRepository
     */
    private $globshopperRepository;
    /**
     * @var CategoriesRepository
     */
    private $categoriesRepository;
    /**
     * @var ComplaintsRepository
     */
    private $complaintsRepository;
    /**
     * @var OffersRepository
     */
    private $offersRepository;

    public function __construct(
        RequestsRepository $requestsRepository,
        GlobshopperRepository $globshopperRepository,
        CategoriesRepository $categoriesRepository,
        ComplaintsRepository $complaintsRepository,
        OffersRepository $offersRepository
    )
    {
        parent::__construct();
        $this->requestsRepository = $requestsRepository;
        $this->globshopperRepository = $globshopperRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->complaintsRepository = $complaintsRepository;
        $this->offersRepository = $offersRepository;
    }

    public function index() {

        if (Auth::user()->type === 'buyer') {

            $requests = $this->requestsRepository->all([
                'from_user_id' => Auth::user()->id
            ]);

        } elseif (Auth::user()->type === 'globshopper') {
            // Get requests for globshopper
            $globshopper = $this->globshopperRepository->getByUserId(Auth::user()->id);

            $requests = $this->requestsRepository->all([
                'to_globshopper_id' => $globshopper->id
            ]);
        } else {
            // If user is admin, get all
            $requests = $this->requestsRepository->all();
        }

        return view('requests/index', [
           'requests' => $requests
        ]);
    }

    public function view($requestId) {
        // Get Request
        $request = $this->requestsRepository->get($requestId);

        $categories = $this->categoriesRepository->all();
        // If user is buyer
        if (Auth::user()->is('buyer') && $request->status === 'CREATED') {
            return view('requests/edit', [
                'request' => $request,
                'categories' => $categories
            ]);
        } else {
            // If conditions for placing complaint are met
            $user = User::makeFromModel(Auth::user());
            $offer = $this->offersRepository->get($requestId);
            $complaint = $this->complaintsRepository->getForRequest($requestId);

            return view(
                'requests/view',
                [
                    'request' => $request,
                    'offer' => $offer,
                    'categories' => $categories,
                    'complaint' => $complaint,
                    'canMakeComplaint' => $user->canMakeComplaint($request, $offer)
                ]
            );
        }
    }

    public function create($globshopperId, Request $request) {
        $categories = $this->categoriesRepository->all();
        $globshopper = $this->globshopperRepository->get($globshopperId);

        if ($request->isMethod('get')) {
            return view('requests/create', [
                'categories' => $categories,
                'globshopper' => $globshopper
            ]);
        } else {
            $data = $request->post();
            $user = User::makeFromModel(Auth::user());

            $category = $this->categoriesRepository->get($data['category_id']);
            $priceRange = new PriceRange($data['price_from'], $data['price_to']);
            $picture = new Picture('/requests/');
            $picture->save($request->file('request_image'));

            $requestItem = new RequestDomain(
                null,
                $user,
                $globshopper,
                $data['name'] ?? '',
                $data['description'] ?? '',
                $category,
                $data['amount'],
                $priceRange,
                $picture,
                'CREATED');

            $created = $this->requestsRepository->store($requestItem);

            return response($created);
        }
    }

    public function saveRequest($requestId, Request $requestInput) {
        $requestDomain = $this->requestsRepository->get($requestId);

        $data = $requestInput->post();

        if (! empty($data['category_id'])) {
            $category = $this->categoriesRepository->get($data['category_id']);
        }

        $priceRange = new PriceRange($data['price_from'], $data['price_to']);

        if ($requestInput->file('request_image')) {
            $picture = new Picture('/requests/');
            $picture->save($requestInput->file('request_image'));
        }

        $request = new RequestDomain(
            $requestId,
            $requestDomain->user,
            $requestDomain->globshopper,
            $data['name'] ?? '',
            $data['description'] ?? '',
            $category ?? null,
            $data['amount'],
            $priceRange,
            $picture ?? null,
            $requestDomain->status
        );

        $this->requestsRepository->store($request);

        return response($request);
    }

    public function acceptRequest($requestId) {
        $request = $this->requestsRepository->get($requestId);
        $request->accepted();
        $this->requestsRepository->store($request);

        event(new RequestAccepted($request));

        return response('OK', 200);
    }

    public function cancelRequest($requestId) {
        $request = $this->requestsRepository->get($requestId);
        $request->cancelled();
        $this->requestsRepository->store($request);

        event(new RequestCancelled($request));

        return response('OK', 200);
    }

    public function setDelivered($requestId) {
        $request = $this->requestsRepository->get($requestId);
        $request->delivered();
        $this->requestsRepository->store($request);

        event(new RequestDelivered($request));

        return response('OK', 200);
    }
}