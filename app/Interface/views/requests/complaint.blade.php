<div class="col-md-12">
    <h3 class="center-block">Complaint</h3>
    <hr>
    <ul class="complaint-comments">
        @if ($complaint)
            @foreach($complaint->comments as $comment)
            <li>
                <div class="comment-main-level">
                    <div class="comment-box">
                        <div class="comment-head">
                            <h6 class="comment-name">{{ $comment->user->firstName }} {{ $comment->user->lastName }}</h6>
                            <span>on {{ $comment->createdAt }}</span>
                        </div>
                        <div class="comment-content">
                            {{ $comment->text }}
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        @endif
    </ul>
    @if (($complaint && ! $complaint->isResolved) || !$complaint)
    <form class="form-horizontal" id="complaint-form">
        {{ csrf_field() }}
        <div class="form-group">
            <div class="col-md-12">
                <textarea name="comment" id="comment" class="form-control" placeholder="Comment"></textarea>
            </div>
        </div>
    </form>
</div>
<div class="col-md-12">
    <div class="btn-toolbar">
        <button class="btn btn-primary save-comment pull-right" @if ($complaint) data-complaint-id="{{ $complaint->id }}" @else data-request-id="{{ $request->id }}" @endif>Save</button>
    </div>
</div>

@if (Auth::user()->is('admin') && $complaint)
    <div class="col-md-12 top-buffer">
        <hr/>
        <div class="btn-toolbar">
            <button class="btn btn-primary resolve-complaint pull-right" data-user-type="globshopper" data-complaint-id="{{ $complaint->id }}">Resolve in favor of Globshopper</button>
            <button class="btn btn-primary resolve-complaint pull-right" data-user-type="buyer" data-complaint-id="{{ $complaint->id }}">Resolve in favor of Buyer</button>
        </div>
    </div>
@endif
@else
    </div>
@endif