@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row top-buffer">
            <h3>Requests</h3>
            <hr>
            <table class="table" id="requests-table">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        @if (Auth::user()->is('buyer') || Auth::user()->is('admin'))
                        <th>Globshopper</th>
                        @endif
                        @if (Auth::user()->is('globshopper') || Auth::user()->is('admin'))
                            <th>Buyer</th>
                        @endif
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Price Range</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        @if (Auth::user()->is('buyer') || Auth::user()->is('admin'))
                            <td>
                                <a href="/globshoppers/view/{{ $request->globshopper->id }}">
                                {{ $request->globshopper->user->firstName }} {{ $request->globshopper->user->lastName }}
                                </a>
                            </td>
                        @endif
                        @if (Auth::user()->is('globshopper') || Auth::user()->is('admin'))
                            <td>
                                <a href="/users/view/{{ $request->user->id }}">
                                {{ $request->user->firstName }} {{ $request->user->lastName }}
                                </a>
                            </td>
                        @endif
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->description }}</td>
                        <td>{{ $request->category->name }}</td>
                        <td>{{ $request->amount }}</td>
                        <td>{{ $request->priceRange->priceFrom }} - {{ $request->priceRange->priceTo }}</td>
                        <td>{{ trans('general.request_status.' . $request->status) }}</td>
                        <td><a class="btn btn-sm btn-primary" href="/requests/view/{{ $request->id }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection