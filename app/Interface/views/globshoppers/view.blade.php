@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="/{{$globshopper->user->avatar->url}}" class="avatar">
                <h2>{{$globshopper->user->firstName}} {{$globshopper->user->lastName}}</h2>
            </div>
        </div>
        <div class="row top-buffer">
            <div id="portfolio">{!! $globshopper->portfolio->html !!}</div>
        </div>
        <div class="row top-buffer">
            <div class="col-md-12">
                <h3>Location</h3>
                <hr>
                <div class="col-md-6">
                    <dl>
                        <dt>Address</dt>
                        <dd>{{ $globshopper->location->data->formatted_address }}</dd>
                        <dt>Email</dt>
                        <dd><a href="mailto:{{ $globshopper->user->email }}">{{ $globshopper->user->email }}</a></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="row top-buffer">
            <h3>Requests</h3>
            <hr>
            <table class="table" id="requests-table">
                <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Buyer</th>
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
                        <td>{{ $request->priceRange->priceFrom }} - {{ $request->priceRange->priceFrom }}</td>
                        <td>{{ trans('general.request_status.' . $request->status) }}</td>
                        <td><input type="number" name="rating" id="rating" class="rating" @if ($request->rating) value="{{ $request->rating->rating }}" @endif  data-readonly /></td>
                        <td><a class="btn btn-sm btn-primary" href="/requests/view/{{ $request->id }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var map, marker;
        function initMap() {

            var location = { lat: {{ $globshopper->location->data->geometry->location->lat }},
                   lng: {{ $globshopper->location->data->geometry->location->lng }} };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: location
            });

            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVWfcCElV7S-7YUBevIEK9FfkBKCrjTGE&libraries=places&callback=initMap">
    </script>
@endsection