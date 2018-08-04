<?php namespace App\Application\Controllers;

use App\Application\Mapper;
use App\Domain\Globshoppers\Globshopper;
use App\Domain\Globshoppers\Location;
use App\Infrastructure\Repositories\GlobshopperRepository;
use App\Infrastructure\Repositories\RequestsRepository;
use App\Infrastructure\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class UserController extends BaseController
{
    /**
     * @var GlobshopperRepository
     */
    private $globshopperRepository;
    /**
 * @var UsersRepository
 */
    private $usersRepository;
    /**
     * @var RequestsRepository
     */
    private $requestsRepository;

    public function __construct(
        
        UsersRepository $usersRepository,
        GlobshopperRepository $globshopperRepository,
        RequestsRepository $requestsRepository
    )
    {
        parent::__construct();
        $this->globshopperRepository = $globshopperRepository;
        $this->usersRepository = $usersRepository;
        $this->requestsRepository = $requestsRepository;
    }

    public function index() {

        if (! Auth::user()->is('admin')) {
            return redirect('/home');
        }

        $users = $this->usersRepository->getAll();

        return view('users/index', ['users' => $users]);
    }

    public function view($userId) {

        $user = $this->usersRepository->get($userId);
        $globshopper = $this->globshopperRepository->getByUserId($userId);

        if ($user->type == 'globshopper') {
            $requests = $this->requestsRepository->all(['to_globshopper_id' => $globshopper->id]);

            return view('globshoppers/view', [
                'globshopper' => $globshopper,
                'requests' => $requests
            ]);
        } else {
            $requests = $this->requestsRepository->all(['from_user_id' => $user->id]);

            return view('users/view', [
                'user' => $user,
                'requests' => $requests
            ]);
        }
    }

    public function search(Request $request)
    {
        $users = $this->usersRepository->getAll(
            array_only($request->input(), ['first_name', 'last_name', 'username'])
        );

        return response($users);
    }

    public function profile()
    {
        $user = $this->usersRepository->get(Auth::user()->id);
        // Get Globshopper if user is globshopper
        $globshopper = ($user->type === 'globshopper') ?
            $this->globshopperRepository->getByUserId(Auth::user()->id) : null;

        return view('profile', [
            'user' => $user,
            'globshopper' => $globshopper
        ]);
    }

    public function updateAvatar(Request $request)
    {
        // Upload of avatar
        if ($request->hasFile('avatar')) {
            $user = $this->usersRepository->get(Auth::user()->id);
            $user->changeAvatar($request->file('avatar'));

            $this->usersRepository->store($user);
        }

        return redirect('profile');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function updateProfile(Request $request)
    {
        $isGlobshopper = $request->get('is_globshopper', false);
        $userData = $request->only(['first_name', 'last_name']);
        $userData['type'] = ($isGlobshopper) ? 'globshopper' : 'buyer';

        $user = $this->usersRepository->get(Auth::user()->id);
        // Set new values
        $user->updateProfile($userData);
        // Store user
        $this->usersRepository->store($user);

        // If is set to globshopper
        if ($isGlobshopper) {
            $location = new Location($request->input('location'));

            $globshopper = new Globshopper(
                null,
                $user,
                $request->input('stripe_public_key', ''),
                $request->input('stripe_secret_key', ''),
                $location
            );

            $this->globshopperRepository->store($globshopper);
        } else {
            // If it's set to buyer
            $globshopper = $this->globshopperRepository->getByUserId($user->id);

            if ($globshopper) {
                $this->globshopperRepository->remove($globshopper);
            }
        }

        return response($user);
    }
}