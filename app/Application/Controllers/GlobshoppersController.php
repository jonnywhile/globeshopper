<?php namespace App\Application\Controllers;

use App\Domain\Globshoppers\Portfolio;
use App\Infrastructure\Repositories\GlobshopperRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GlobshoppersController extends BaseController
{
    /**
     * @var GlobshopperRepository
     */
    private $globshopperRepository;

    private $requestsRepository;

    public function __construct(
        GlobshopperRepository $globshopperRepository,
        RequestsRepository $requestsRepository)
    {
        parent::__construct();

        $this->globshopperRepository = $globshopperRepository;
        $this->requestsRepository = $requestsRepository;
    }

    public function index()
    {
        $globshoppers = $this->globshopperRepository->all();
        return view('globshoppers/index', ['globshoppers' => $globshoppers]);
    }
    /**
     * Search globshoppers
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function search(Request $request)
    {
        $globshoppers = $this->globshopperRepository->search(array_only($request->input(), ['first_name', 'last_name', 'email']));

        return response(domains_to_array($globshoppers));
    }

    public function view($globshopperId) {

        $globshopper = $this->globshopperRepository->get($globshopperId);
        $requests = $this->requestsRepository->all(['to_globshopper_id' => $globshopperId]);

        return view('globshoppers/view', [
            'globshopper' => $globshopper,
            'requests' => $requests
        ]);
    }

    public function editPortfolio() {
        $globshopper = $this->globshopperRepository->getByUserId(Auth::user()->id);

        return view('globshoppers/edit_portfolio', [
            'globshopper' => $globshopper
        ]);
    }

    public function savePortfolio($globshopperId, Request $request) {
        $globshopper = $this->globshopperRepository->get($globshopperId);

        $portfolio = new Portfolio($request->input('html'));
        $globshopper->changePortfolio($portfolio);

        $this->globshopperRepository->savePortfolio($globshopper);

        return response($portfolio);
    }
}