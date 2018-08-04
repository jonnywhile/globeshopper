<?php namespace App\Domain\Requests;

use Illuminate\Queue\SerializesModels;

class RequestCharged
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
        $this->user = $request->globshopper->user;
        $this->text = trans('general.notifications.request_charged', [
            'requestId' => $request->id
        ]);
    }
}