@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row top-buffer">
            <div class="col-md-10 col-md-offset-1">
                <h3 class="center-block">Create Request for {{ $globshopper->user->firstName }} {{ $globshopper->user->lastName }}</h3>
                <hr>
                <form class="form-horizontal" id="create-request-form" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-2 control-label">Description</label>

                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category" class="col-md-2 control-label">Category</label>

                        <div class="col-md-6">
                            <select name="category_id" id="category" class="selectpicker">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-md-2 control-label">Amount</label>

                        <div class="col-md-6">
                            <input id="amount" type="text" class="form-control" name="amount" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price-from" class="col-md-2 control-label">Price</label>
                        <div class="col-md-3">
                            <input id="price-from" type="text" class="form-control" name="price_from" placeholder="From" required autofocus>
                        </div>
                        <div class="col-md-3">
                            <input id="price-to" type="text" class="form-control" name="price_to" placeholder="To" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="request-image" class="col-md-2 control-label">Upload Image</label>
                        <div class="col-md-6">
                            <input id="request-image" type="file" class="form-control" name="request_image">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row top-buffer">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-8">
                <button class="btn btn-primary create-request pull-right" data-globshopper-id="{{ $globshopper->id }}">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
