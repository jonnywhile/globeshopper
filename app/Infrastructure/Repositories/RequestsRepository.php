<?php namespace App\Infrastructure\Repositories;

use App\Domain\Requests\Request;
use App\Infrastructure\Models\Request as RequestModel;
use App\Infrastructure\Models\Rating as RatingModel;

class RequestsRepository {

    public function all($filter = []) {
        $requests = RequestModel::with([
            'user',
            'globshopper',
            'category',
            'offer',
            'rating',
            'charge',
            'complaint'
        ]);

        if (!empty($filter)) {
            $requests->where(
                function ($query) use ($filter) {
                    foreach ($filter as $key => $value) {
                        if (!empty($value)) {
                            $query->where($key, $value);
                        }
                    }
                }
            );
        }

        $requests = $requests->get();

        $result = collect();

        foreach ($requests as $request) {
            $result->push(Request::makeFromModel($request));
        }

        return $result;
    }

    public function get($id) {
        return Request::makeFromModel((new RequestModel)->find($id));
    }

    public function store(Request $request) {
        $request = (new RequestModel())->updateOrCreate(
            ['id' => $request->id],
            [
                'from_user_id' => $request->user->id,
                'to_globshopper_id' => $request->globshopper->id,
                'name' => $request->name,
                'description' => $request->description,
                'category_id' => $request->category->id,
                'amount' => $request->amount,
                'price_from' => $request->priceRange->priceFrom,
                'price_to' => $request->priceRange->priceTo,
                'picture' => $request->picture->name ?? '',
                'status' => $request->status,
                'is_cancelled' => $request->isCancelled,
                'is_closed' => $request->isClosed
            ]
        );

        return Request::makeFromModel($request);
    }

    public function saveRating(Request $request) {
        return (new RatingModel())->updateOrCreate(
            ['request_id' => $request->id],
            [
                'rating' => $request->rating->rating,
                'comment' => $request->rating->comment
            ]
        );
    }
}