@if (count($topics))
<ul class="list-group">
    @foreach ($topics as $topic)
        <li class="list-group-item">
            {{-- 照葫芦画瓢, 还老是手误, 不明觉历, 每次写错要花N倍的时间来找错, 一直做这种不动脑的重复工作有什么用呢? --}}
            <a href="{{-- route('topics.show', $topic->id) --}} {{ $topic->link() }}">{{ $topic->title }}</a>
            <span class="meta pull-right">
                {{ $topic->reply_count }} 回复
                <span> . </span>
                {{ $topic->created_at->diffForHumans() }}
            </span>
        </li>
    @endforeach
</ul>
@else
<div class="empty-block">暂无数据...</div>
@endif

{!! $topics->render() !!}