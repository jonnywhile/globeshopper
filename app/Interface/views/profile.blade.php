@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <img src="{{$user->avatar->url}}" class="avatar">
                <h2>{{$user->firstName}} {{$user->lastName}}</h2>
                <form enctype="multipart/form-data" action="/avatar" method="POST">
                    <label>Update Profile Image</label>
                    <input type="file" name="avatar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-sm btn-primary">
                </form>
            </div>
        </div>
        <div class="row top-buffer">
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" id="profile-form">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">First Name</label>

                        <div class="col-md-6">
                            <input id="first-name" type="text" class="form-control" name="first_name" value="{{ $user->firstName }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Last Name</label>

                        <div class="col-md-6">
                            <input id="last-name" type="text" class="form-control" name="last_name" value="{{ $user->lastName }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label"></label>
                        <div class="form-check col-md-6">
                            <label class="form-check-label">
                                <input class="form-check-input make-globshopper" type="checkbox" @if ($user->type === 'globshopper') checked @endif>  Upgrade to Globshopper
                            </label>
                        </div>
                    </div>
                    <div class="globshopper-data @if ($user->type !== 'globshopper') hidden @endif">
                        <div class="form-group">
                            <label for="stripe" class="col-md-2 control-label">Stripe Public API Token</label>
                            <div class="col-md-6">
                                <input id="stripe" name="stripe_public_key" type="text" class="form-control" @if ($globshopper) value="{{$globshopper->stripePublicKey}}"@endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stripe" class="col-md-2 control-label">Stripe Secret API Token</label>
                            <div class="col-md-6">
                                <input id="stripe" name="stripe_secret_key" type="text" class="form-control" @if ($globshopper) value="{{$globshopper->stripeSecretKey}}"@endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="map-search" class="col-md-2 control-label">Search Address</label>
                            <div class="col-md-6">
                                <input id="map-search" type="text" class="form-control" @if ($globshopper && $globshopper->location->data->formatted_address)) value="{{ $globshopper->location->data->formatted_address }}" @endif>
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-8">
                    <button class="btn btn-primary save-profile pull-right">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var map, marker, searchBox;
        function initMap() {
            var location = null;
            @if ($globshopper && $globshopper->location && $globshopper->location->data)
               location = { lat: {{ $globshopper->location->data->geometry->location->lat }},
                   lng: {{ $globshopper->location->data->geometry->location->lng }} };
                    @endif;
            var uluru = location !== null ? location : {lat: -25.363, lng: 131.044};
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: uluru
            });

            marker = new google.maps.Marker({
                position: uluru,
                map: map,
                draggable: true
            });

            searchBox = new google.maps.places.SearchBox(document.getElementById('map-search'));

            google.maps.event.addListener(searchBox, 'places_changed', function() {
                var places = searchBox.getPlaces();

                var bounds = new google.maps.LatLngBounds();
                var i, place;

                for (i = 0; place = places[i]; i++) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }
                map.fitBounds(bounds);
                map.setZoom(15);
            });

            {{--google.maps.event.trigger(searchBox, 'places_changed');--}}
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVWfcCElV7S-7YUBevIEK9FfkBKCrjTGE&libraries=places&callback=initMap">
    </script>
@endsection
