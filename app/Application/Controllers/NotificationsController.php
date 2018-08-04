<?php namespace App\Application\Controllers;

use App\Infrastructure\Repositories\NotificationsRepository;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends BaseController {

    /**
     * @var NotificationsRepository
     */
    private $notificationsRepository;

    public function __construct(NotificationsRepository $notificationsRepository) {
        parent::__construct();
        $this->notificationsRepository = $notificationsRepository;
    }

    public function index() {
        $notifications = $this->notificationsRepository->all(Auth::user()->id);

        return view('/notifications/index', [
            'notifications' => $notifications
        ]);
    }
}