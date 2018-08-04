@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form class="form-horizontal" id="user-search-form">
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
                            <input id="username" type="text" class="form-control" name="username" required autofocus>
                        </div>
                    </div>
                </form>
                <div class="col-md-8">
                    <button class="btn btn-primary search-users pull-right">Search</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-15">
            <div class="col-md-12">
                <table class="table" id="users-table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->firstName }} {{ $user->lastName }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ trans('general.user_type.' . $user->type) }}</td>
                            <td><a class="btn btn-sm btn-primary" href="/users/view/{{ $user->id }}">View</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection