@extends('layouts.app')

@section('title', $topic->title)

@section('description', $topic->excerpt)

@section('content')

<div class="row">
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    作者: {{ $topic->user->name }}
                </div>
                <hr>
                <div class="media">
                    <div align="center">
                        <a href="{{-- route('users.show', $topic->user->id) --}} {{ $topic->link() }}">
                            <img class="thumbnail img-response" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="text-center">{{ $topic->title }}</h1>

                <div class="article-meta text-center">
                    {{ $topic->created_at->diffForHumans() }}
                    .
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    {{ $topic->reply_count }}
                </div>

                {{-- XSS攻击, https://www.ibm.com/developerworks/cn/rational/08/0325_segal/ --}}
                {{-- blade模板会调用php中htmlspecialchars() --}}
                {{-- 引用的simdior中js也会作转义过滤处理 --}}
                {{-- 为了双保险, 使用HTMLPurifier对html文本进行XSS过滤, http://htmlpurifier.org/ --}}
                <div class="topic-body">
                    {!! $topic->body !!}
                </div>

                {{-- 对编辑/删除增加显示条件, 只有当用户有权限时显示. 使用laravel授权策略提供的@can Blade命令 --}}
                @can('update', $topic)
                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default btn-xs pull-left" role="button">
                            <i class="glyphicon glyphicon-edit"></i> 编辑
                        </a>

                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px">
                                <i class="glyphicon glyphicon-trash"></i>
                                删除
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>

        {{-- 用户回复列表 --}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @include('topics._reply_box', ['topic' => $topic])
                {{-- 手误, 仅仅是临摹, 照抄照搬, 还写错这么多? 拼错, 写错... --}}
                @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
            </div>
        </div>

    </div>
</div>
@stop
