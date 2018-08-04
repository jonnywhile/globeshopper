<?php namespace App\Domain\Requests;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class RequestCancelled
{
    use SerializesModels;

    public $user;
    public $text;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        if ($request->status === 'CLOSED_GLOBSHOPPER_CANCELLED') {
            $this->user = $request->user;
        } elseif ($request->status === 'CLOSED_BUYER_CANCELLED') {
            $this->user = $request->globshopper->user;
        }

        $this->text = trans('general.notifications.request_cancelled', [
            'requestId' => $request->id,
            'name' => Auth::user()->name
        ]);
    }
}