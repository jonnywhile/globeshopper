@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row top-buffer">
            <h3>Notifications</h3>
            <hr>
            <ul class="notifications">
                @foreach ($notifications as $notification)
                    <li>
                        @if (! $notification->is_seen)
                            <strong>
                            {{ $notification->created_at->format('m/d/Y') }} - {!! $notification->text !!}
                            </strong>
                        @else
                            {{ $notification->created_at->format('m/d/Y') }} - {!! $notification->text !!}
                        @endif
                            <hr>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection