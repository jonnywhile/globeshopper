<?php namespace App\Domain\Requests;

use Illuminate\Queue\SerializesModels;

class RequestAccepted
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
        $this->user = $request->user;
        $this->text = trans('general.notifications.request_accepted', [
            'requestId' => $request->id
        ]);
    }
}