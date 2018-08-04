<?php namespace App\Infrastructure\Repositories;

use App\Domain\Util\Notification;
use App\Infrastructure\Models\Notification as NotificationModel;

class NotificationsRepository
{
    public function all($userId = null) {
        $notifications = (new NotificationModel);

        if ($userId) {
            $notifications->where('user_id', $userId);
        }

        $notifications = $notifications
            ->orderBy('created_at', 'desc')
            ->get();

        $this->updateAllSeen($userId);

        return $notifications;
    }

    public function updateAllSeen($userId) {
        (new NotificationModel)->where('user_id', $userId)->update(['is_seen' => true]);
    }

    public function store($notification) {
        return (new NotificationModel())->create([
            'user_id' => $notification->user->id,
            'text' => $notification->text
        ]);
    }
}