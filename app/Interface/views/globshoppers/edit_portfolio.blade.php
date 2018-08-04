@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div id="editor">@if ($globshopper->portfolio){!! $globshopper->portfolio->html !!}@endif</div>
        </div>
        <div class="row top-buffer">
            <button class="btn btn-primary save-portfolio pull-right" data-globshopper-id="{{ $globshopper->id }}">Save</button>
        </div>
    </div>
@endsection