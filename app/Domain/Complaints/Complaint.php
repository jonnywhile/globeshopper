<?php namespace App\Domain\Complaints;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Domain\Requests\Request;
use App\Domain\Users\User;
use App\Infrastructure\Models\Complaint as ComplaintModel;

class Complaint
{
    use PropertiesTrait, JsonableTrait;

    private $id;
    private $request;
    private $isResolved;
    // Collection of $comment
    private $comments;

    public function __construct($id, $request, $comments = [], $isResolved = false)
    {
        $this->id = $id;
        $this->request = $request;
        $this->comments = collect($comments);
        $this->isResolved = $isResolved;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @return bool
     */
    public function isIsResolved() {
        return $this->isResolved;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getComments() {
        return $this->comments;
    }

    public function resolve() {
        $this->isResolved = true;
    }

    public static function makeFromModel(ComplaintModel $complaint) {

        $complaint->load(['request', 'comments', 'comments.createdBy']);
        $request = Request::makeFromModel($complaint->request);

        $comments = collect();
        foreach ($complaint->comments as $comment) {
            $comments->push(Comment::makeFromModel($comment));
        }

        return new self($complaint->id, $request, $comments, $complaint->isResolved);
    }
}