<?php namespace App\Domain\Requests;


use App\Domain\Util\Notification;
use App\Infrastructure\Repositories\NotificationsRepository;

class RequestChangeListener
{
    public function handle($event)
    {
        $notification = new Notification($event->user, $event->text);

        $repository = new NotificationsRepository();
        $repository->store($notification);

//        // If it's cancelled
//        if ($event instanceof RequestCancelled) {
//            $data['is_cancelled'] = true;
//            $data['is_closed'] = true;
//        }
//
//        // If it's delivered
//        if ($event instanceof RequestDelivered) {
//            $data['is_closed'] = true;
//        }

//        $request->update($data);
    }
}