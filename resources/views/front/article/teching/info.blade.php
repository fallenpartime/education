@extends('front.article.infomain')
@section('title', "文章详情")
@section('body_content')
    <div class="container">
        <div class="main">
            <div class="note">
                <h1 class="title">{{ array_get($record, "title") }}</h1>
                <div class="article-info">
                    <div class="meta">
                        @if(!empty(array_get($record, "author")))<span>{{ array_get($record, "author") }}</span>@endif<span>{{ array_get($record, "published_at") }}</span>
                    </div>
                </div>
                <div class="content">
                    {!! array_get($record, "content") !!}
                </div>
                <div class="vote">
                    <a class="vote-btn" href="vote.html">我要投票</a>
                </div>
                <div class="article-footer">
                    <ul class="operation">
                        <li class="read-num"><i class="iconfont">&#xe639;</i>{{ array_get($record, "read_count") }}</li>
                        <li class="like-num"><i class="iconfont">&#xe60e;</i>{{ array_get($record, "like_count") }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection