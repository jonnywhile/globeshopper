<?php namespace App\Domain\Util;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Infrastructure\Models\Notification as NotificationModel;

class Notification
{
    use PropertiesTrait, JsonableTrait;

    private $user;
    private $text;

    public function __construct($user, $text)
    {
        $this->user = $user;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    public static function makeFromModel(NotificationModel $notification) {
        $notification->load('user');
        return new self($notification->user, $notification->text);
    }
}