<?php namespace App\Application\Controllers;

use App\Domain\Complaints\Comment;
use App\Infrastructure\Models\Comment as CommentModel;
use App\Domain\Complaints\Complaint;
use App\Domain\Users\User;
use App\Infrastructure\Repositories\ComplaintsRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintsController extends BaseController
{
    /**
     * @var ComplaintsRepository
     */
    private $complaintsRepository;
    /**
     * @var RequestsRepository
     */
    private $requestsRepository;

    public function __construct(
        ComplaintsRepository $complaintsRepository,
        RequestsRepository $requestsRepository)
    {
        parent::__construct();
        $this->complaintsRepository = $complaintsRepository;
        $this->requestsRepository = $requestsRepository;
    }

    public function createComplaint($requestId) {
        $request = $this->requestsRepository->get($requestId);
        $complaint = new Complaint(null, $request);

        $complaint = $this->complaintsRepository->store($complaint);

        return response($complaint);
    }

    public function createComment($complaintId, Request $requestInput) {
        $comment = new Comment($complaintId, $requestInput->input('comment'), User::makeFromModel(Auth::user()), Carbon::now());

        $comment = $this->complaintsRepository->storeComment($comment);

        return response($comment);
    }

    public function resolve($complaintId, $userType) {
        $complaint = $this->complaintsRepository->get($complaintId);
        // If it's resolved in favor of globshopper
        if ($userType === 'globshopper') {
            $complaint->request->closeWithStatus('CLOSED_DELIVERED');
        } else {
            $complaint->request->closeWithStatus('CLOSED_NOT_DELIVERED');

            $stripe = Stripe::make($complaint->request->globshopper->stripe_secret_key);
            $refund = $stripe->refunds()->create($complaint->request->charge->charge_id);
        }

        $this->requestsRepository->store($complaint->request);

        $complaint->resolve();
        $this->complaintsRepository->store($complaint);

        return response('OK', 200);
    }
}