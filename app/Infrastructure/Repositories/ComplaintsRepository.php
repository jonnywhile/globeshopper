<?php namespace App\Infrastructure\Repositories;

use App\Domain\Complaints\Comment;
use App\Domain\Complaints\Complaint;
use App\Infrastructure\Models\Comment as CommentModel;
use App\Infrastructure\Models\Complaint as ComplaintModel;
use Illuminate\Support\Facades\Auth;

class ComplaintsRepository
{
    public function get($id) {
        return Complaint::makeFromModel((new ComplaintModel())->find($id));
    }

    public function getForRequest($requestId) {
        $complaint = (new ComplaintModel())->where('request_id', $requestId)->first();

        if ($complaint) {
            return Complaint::makeFromModel($complaint);
        } else {
            return null;
        }

    }

    public function store($complaint) {
        $complaint = (new ComplaintModel())->updateOrCreate(
            ['request_id' => $complaint->request->id],
            [
                'is_resolved' => $complaint->isResolved
            ]
        );

        return Complaint::makeFromModel($complaint);
    }

    public function storeComment($comment) {
        $comment = (new CommentModel())->create([
            'comment' => $comment->text,
            'complaint_id' => $comment->complaintId,
            'created_by' => $comment->user->id
        ]);

        return Comment::makeFromModel($comment);
    }
}