@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row top-buffer">
            <div class="col-md-12">
                <h3>Request</h3>
                <hr>
                @if ($request->picture->name)
                <div class="col-md-6">
                    <img src="{{ $request->picture->folder }}{{ $request->picture->name }}" alt="">
                </div>
                @endif
                <div class="col-md-6">
                    <dl>
                        <dt>User</dt>
                        <dd>{{ $request->user->firstName }}</dd>
                        <dt>Name</dt>
                        <dd>{{ $request->name }}</dd>
                        <dt>Description</dt>
                        <dd>{{ $request->description }}</dd>
                        <dt>Category</dt>
                        <dd>{{ $request->category->name }}</dd>
                        <dt>Amount</dt>
                        <dd>{{ $request->amount }}</dd>
                        <dt>Price Range</dt>
                        <dd>{{ $request->priceRange->priceFrom }} - {{ $request->priceRange->priceTo }}</dd>
                        <dt>Status</dt>
                        <dd>{{ trans('general.request_status.' . $request->status) }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-12">
                @if (! $request->isClosed)
                <div class="btn-toolbar">
                    @if (Auth::user()->is('globshopper'))
                        @if($request->status === 'CREATED')
                        <button class="btn btn-primary accept-request pull-right" data-request-id="{{ $request->id }}">Accept Request</button>
                        @endif
                    @endif
                </div>
                @endif
            </div>
        </div>
        @if (Auth::user()->is('globshopper') && in_array($request->status, ['CREATED', 'ACCEPTED', 'OFFER_CREATED']))
        <div class="row top-buffer @if ($request->status === 'CREATED') hidden @endif request-offer-section">
            <div class="col-md-12">
                <h3 class="center-block">@if ($offer) Update @else Create @endif Offer for Request #{{ $request->id }}</h3>
                <hr>
                <form class="form-horizontal" id="offer-form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-md-3 control-label">Name</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control" name="name" required autofocus value="@if ($offer){{ $offer->name }} @else {{ $request->name }} @endif">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-3 control-label">Description</label>

                            <div class="col-md-9">
                                <textarea name="description" id="description" class="form-control">@if ($offer){{ $offer->description }} @else {{ $request->description }} @endif</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="amount" class="col-md-3 control-label">Amount</label>

                            <div class="col-md-9">
                                <input id="amount" type="text" class="form-control" name="amount" value="@if ($offer){{ $offer->amount }} @else {{ $request->amount }} @endif" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-md-3 control-label">Price</label>
                            <div class="col-md-9">
                                <input id="price" type="text" class="form-control" name="price" placeholder="Price" @if ($offer) value="{{ $offer->price }}" @endif required autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delivery-fee" class="col-md-3 control-label">Delivery Fee</label>
                            <div class="col-md-9">
                                <input id="delivery-fee" type="text" class="form-control" name="delivery_fee" placeholder="Delivery Fee" @if ($offer) value="{{ $offer->deliveryFee }}" @endif required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="delivery-type" class="col-md-3 control-label">Delivery Type</label>

                            <div class="col-md-9">
                                <textarea name="delivery_type" id="delivery-type" class="form-control" required>@if ($offer) {{ $offer->deliveryType }} @endif</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="delivery-date" class="col-md-3 control-label" required>Delivery Date</label>

                            <div class="col-md-9">
                                <input name="delivery_date" id="delivery-date" class="form-control datepicker" @if ($offer) value="{{ $offer->deliveryDate->format('m/d/Y') }}" @endif/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="offer-image" class="col-md-3 control-label">Upload Image</label>
                            <div class="col-md-9">
                                <input id="offer-image" type="file" class="form-control" name="offer_image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3"></label>
                            <div class="col-md-9">
                                @if ($offer && $offer->picture)
                                    <img src="{{ $offer->picture->folder }}{{ $offer->picture->name }}" alt="">
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-12">
                    <div class="btn-toolbar">
                        <button class="btn btn-primary save-offer pull-right" data-request-id="{{ $request->id }}" @if ($offer) data-offer-id="{{ $offer->id }}" @endif>Save</button>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($offer)
        <div class="row top-buffer">
            <div class="col-md-12">
                <h3>Offer</h3>
                <hr>
                @if ($offer->picture)
                <div class="col-md-6">
                    <img src="{{ $offer->picture->folder }}{{ $offer->picture->name }}" alt="">
                </div>
                @endif
                <div class="col-md-6">
                    <dl>
                        <dt>Name</dt>
                        <dd>{{ $offer->name }}</dd>
                        <dt>Description</dt>
                        <dd>{{ $offer->description }}</dd>
                        <dt>Amount</dt>
                        <dd>{{ $offer->amount }}</dd>
                        <dt>Price</dt>
                        <dd>{{ $offer->price }}</dd>
                        <dt>Delivery Fee</dt>
                        <dd>{{ $offer->deliveryFee }}</dd>
                        <dt>Delivery Type</dt>
                        <dd>{{ $offer->deliveryType }}</dd>
                        <dt>Delivery Date</dt>
                        <dd>{{ $offer->deliveryDate->format('m/d/Y') }}</dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-12">
                @if (Auth::user()->is('buyer'))
                    @if ($request->status === 'OFFER_ACCEPTED')
                        <div class="btn-toolbar">
                        @if (! $complaint)
                            <button class="btn btn-primary set-delivered pull-right" data-request-id="{{ $request->id }}">Set Delivered</button>
                            @if ($canMakeComplaint)
                                <button class="btn btn-danger make-complaint pull-right" data-request-id="{{ $request->id }}">Make Complaint</button>
                            @endif
                        @endif
                        </div>
                    @elseif (! $request->isClosed)
                        <button class="btn btn-primary accept-offer pull-right">Accept Offer</button>
                        <form  method="POST" class="pull-right hidden stripe-pay" id="stripe-pay-form" data-request-id="{{ $request->id }}">
                            <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="{{ $request->globshopper->stripePublicKey }}"
                                    data-amount="{{ $offer->price * 100 }}"
                                    {{--data-name="Demo Site"--}}
                                    {{--data-description="Widget"--}}
                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                    data-locale="auto">
                            </script>
                        </form>
                    @elseif ($request->status === 'CLOSED_DELIVERED')
                        <div class="row top-buffer">
                            <div class="col-md-12">
                                <h3>Ranking</h3>
                                <hr>
                                <form class="form-horizontal" id="rating-form">
                                    {{ csrf_field() }}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="number" name="rating" id="rating" class="rating" @if ($request->rating) value="{{ $request->rating->rating }}" data-readonly @endif/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <textarea name="comment" id="comment" class="form-control" placeholder="Comment" @if ($request->rating) disabled @endif>@if ($request->rating) {{ $request->rating->comment }}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if (! $request->rating)
                        <div class="col-md-12">
                            <button class="btn btn-primary save-rating pull-right" data-request-id="{{ $request->id }}">Save</button>
                        </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
        @endif
        @if (! $request->isClosed && $request->status !== 'OFFER_ACCEPTED')
            <div class="row top-buffer">
                <div class="col-md-12">
                    <button class="btn btn-primary cancel-request pull-right" data-request-id="{{ $request->id }}">Cancel Request</button>
                </div>
            </div>
        @else
            <div class="row top-buffer">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        Request is in status <strong>{{ trans('general.request_status.' . $request->status) }}</strong>
                    </div>
                </div>
            </div>
        @endif
        <div class="row top-buffer @if (! $complaint) hidden @endif" id="complaint">
            @include('requests.complaint', [
                'request' => $request,
                'complaint' => $complaint
            ])
        </div>
    </div>
@endsection