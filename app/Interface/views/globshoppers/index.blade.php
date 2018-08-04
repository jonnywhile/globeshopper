@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form class="form-horizontal" id="search-form">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="first-name" class="col-md-2 control-label">First Name</label>

                        <div class="col-md-6">
                            <input id="first-name" type="text" class="form-control" name="first_name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last-name" class="col-md-2 control-label">Last Name</label>

                        <div class="col-md-6">
                            <input id="last-name" type="text" class="form-control" name="last_name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username" class="col-md-2 control-label">Username (Email)</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="email" required autofocus>
                        </div>
                    </div>
                </form>
                <div class="col-md-8">
                    <button class="btn btn-primary search-globshoppers pull-right">Search</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-15">
            <div class="col-md-10 col-md-offset-1 globshoppers-cards">
                @foreach ($globshoppers as $globshopper)
                <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
                    <div class="card" style="width: 20rem;">
                        <div class="card-block">
                            <h4 class="card-title"><a href="/globshoppers/view/{{$globshopper->id}}">{{ $globshopper->user->firstName }} {{ $globshopper->user->lastName }}</a></h4>
                            @if ($globshopper->location && $globshopper->location->data)
                            {{ $globshopper->location->data->formatted_address }}
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="/requests/create/{{ $globshopper->id }}" class="btn btn-primary">Create Request</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection