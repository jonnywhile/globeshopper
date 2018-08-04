@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row top-buffer">
            <div class="col-md-10 col-md-offset-1">
                <h3 class="center-block">Edit Request for {{ $request->globshopper->user->firstName }} {{ $request->globshopper->user->lastName }} #{{ $request->id }}</h3>
                <hr>
                <form class="form-horizontal" id="edit-request-form" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="col-md-2 control-label">Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" required autofocus value="{{ $request->name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="col-md-2 control-label">Description</label>

                        <div class="col-md-6">
                            <textarea name="description" id="description" class="form-control">{{ $request->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="category" class="col-md-2 control-label">Category</label>

                        <div class="col-md-6">
                            <select name="category_id" id="category" class="selectpicker">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id === $request->category->id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-md-2 control-label">Amount</label>

                        <div class="col-md-6">
                            <input id="amount" type="text" class="form-control" name="amount" value="{{ $request->amount }}" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price-from" class="col-md-2 control-label">Price</label>
                        <div class="col-md-3">
                            <input id="price-from" type="text" class="form-control" name="price_from" placeholder="From" required autofocus value="{{ $request->priceRange->priceFrom }}">
                        </div>
                        <div class="col-md-3">
                            <input id="price-to" type="text" class="form-control" name="price_to" placeholder="To" required autofocus value="{{ $request->priceRange->priceTo }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            @if (! empty($request->picture->name) )
                            <img src="{{ $request->picture->folder }}{{ $request->picture->name }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="request-image" class="col-md-2 control-label">Upload New Image</label>
                        <div class="col-md-6">
                            <input id="request-image" type="file" class="form-control" name="request_image">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row top-buffer">
                <div class="col-md-10 col-md-offset-1">
                    <div class="col-md-8">
                        <button class="btn btn-primary save-request pull-right" data-request-id="{{ $request->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
