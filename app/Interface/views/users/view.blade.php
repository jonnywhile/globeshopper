@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="avatars/{{$user->avatar->name}}" class="avatar">
                <h2>{{$user->firstName}} {{$user->lastName}}</h2>
                <dl>
                    <dt>Email</dt>
                    <dd><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>
                </dl>
            </div>
        </div>
        @if ($user->type == 'buyer')
        <hr>
        <div class="row top-buffer">
            <h3>Requests</h3>
            <hr>
            <table class="table" id="requests-table">
                <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Globshopper</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Price Range</th>
                    <th>Status</th>
                    <th>Ranking</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->user->firstName }} {{ $request->user->lastName }}</td>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->category->name }}</td>
                        <td>{{ $request->amount }}</td>
                        <td>{{ $request->priceRange->priceFrom }} - {{ $request->priceRange->priceTo }}</td>
                        <td>{{ trans('general.request_status.' . $request->status) }}</td>
                        <td><input type="number" name="rating" id="rating" class="rating" @if ($request->rating) value="{{ $request->rating->rating }}" @endif data-readonly /></td>
                        <td><a class="btn btn-sm btn-primary" href="/requests/view/{{ $request->id }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection