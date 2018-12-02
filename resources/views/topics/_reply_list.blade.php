<div class="reply-list">
@foreach($replies as $index => $reply )
    <div class=" media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
        <div class="avatar pull-left" >
            <a href="{{ route('users.show', [$reply->user_id]) }}">
            	<img class="media-object img-thumbnail" alt="{{ $reply->user->name }}" src="{{ $reply->user->avatar }}" style="width:48px;height:48px;">
            </a>
        </div>

        <div class="infos">
            <div class="media-heading">
                {{-- 老是手误, 干嘛呢? 不明白实际意义, 只是照葫芦画瓢! --}}
                <a href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">{{ $reply->user->name }}</a>
                <span> . </span>
                <span class="meta" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

                {{-- 回复删除按钮 --}}
                <span class="meta pull-right">
                    <a title="删除回复">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                </span>
            </div>

            <div class="reply-content">
                {{-- 非转义打印数据, 是一个安全隐患 --}}
                {!! $reply->content !!}
            </div>
        </div>
    </div>
    <hr>
@endforeach
</div>
