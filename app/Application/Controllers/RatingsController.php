<?php namespace App\Application\Controllers;

use App\Domain\Requests\Rating;
use App\Infrastructure\Repositories\RequestsRepository;
use Illuminate\Http\Request;

class RatingsController extends BaseController
{
    private $requestsRepository;

    public function __construct(
        RequestsRepository $requestsRepository
    )
    {
        parent::__construct();
        $this->requestsRepository = $requestsRepository;
    }

    public function create($requestId, Request $requestInput) {
        $data = $requestInput->input();

        $request = $this->requestsRepository->get($requestId);
        $rating = new Rating($data['rating'], $data['comment'] ?? '');

        $request->rate($rating);

        $this->requestsRepository->saveRating($request);

        return response($rating);
    }
}