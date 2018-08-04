<?php namespace App\Domain\Complaints;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Domain\Users\User;
use App\Infrastructure\Models\Comment as CommentModel;

class Comment
{
    use PropertiesTrait, JsonableTrait;

    private $complaintId;
    private $text;
    private $user;
    private $createdAt;

    public function __construct($complaintId, $text, User $createdBy, $createdAt = null)
    {
        $this->complaintId = $complaintId;
        $this->text = $text;
        $this->user = $createdBy;
        $this->createdAt = ($createdAt) ? $createdAt->format('m/d/Y') : null;
    }

    /**
     * @return mixed
     */
    public function getComplaintId()
    {
        return $this->complaintId;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public static function makeFromModel(CommentModel $comment) {
        $comment->load('createdBy');
        $user = User::makeFromModel($comment->createdBy);

        return new self($comment->complaint_id, $comment->comment, $user, $comment->created_at);
    }
}