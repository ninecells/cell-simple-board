@extends('app')

@section('content')

<style>
    .well {
        background-color: #f4f4f4;
        margin-bottom: 50px;
    }

    .well hr {
        margin: 10px 0px;
    }

    .vote.arrow {
        cursor: pointer;
        cursor: hand;
    }
</style>

<!-- 질문내용 -->
<div class="well well-sm">
    <!-- 수정/삭제 버튼 -->
    <h1 style="margin-top: 0px;">{{ $post->title }}</h1>
    <form method="POST" action="/sboards/{{ $board_key }}/{{ $post->id }}/delete">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <img src="{{ $post->writer->avatar }}" width="16" height="16"/> <b>{{ $post->writer->name }}</b>
        {{ $post->created_at }}
        @can('sboard-edit', $post)
        | <a class="btn btn-xs btn-default" href="/sboards/{{ $board_key }}/{{ $post->id }}/edit">수정</a>
        <button class="btn btn-xs btn-danger">삭제</button>
        @endcan
    </form>
    <hr/>
    {!! $post->md_content !!}
    <p class="text-right">
    <span style="display: inline-block;">
        <img src="{{ $post->writer->avatar }}" width="64" height="64"/>
        <span><b style="vertical-align: top;">{{ $post->writer->name }}</b></span>
    </span>
    </p>
</div>

<hr/>

<!-- 답변내용 -->
@foreach($post->comments as $a)
<div class="well well-sm">

    <a name="{{ $a->id }}"></a>

    <!-- 수정/삭제 버튼 -->
    <form method="POST" action="/sboards/{{ $board_key }}/comments/{{ $a->id }}/delete">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <img src="{{ $a->writer->avatar }}" width="16" height="16"/> <b>{{ $a->writer->name }}</b>
        <a href="{{ '#'.$a->id }}">{{ $a->created_at }}</a>
        @can('sboard-edit', $a)
        | <a class="btn btn-xs btn-default" href="/sboards/{{ $board_key }}/comments/{{ $a->id }}/edit">수정</a>
        <button class="btn btn-xs btn-danger">삭제</button>
        @endcan
    </form>
    <hr/>
    {!! $a->md_content !!}
    <p class="text-right">
    <span style="display: inline-block;">
        <img src="{{ $a->writer->avatar }}" width="64" height="64"/>
        <span><b style="vertical-align: top;">{{ $a->writer->name }}</b></span>
    </span>
    </p>
</div>
@endforeach

<!-- 답변하기 창 -->
@can('sboard-write')
<form method="POST" action="/sboards/{{ $board_key }}/comments/write">
    {{ csrf_field() }}
    <input type="hidden" name="post_id" value="{{ $post->id }}"/>
    <div class="form-group">
        <label for="content">답변</label>
        <textarea class="form-control" id="content" name="content" placeholder="답변" rows="4"></textarea>
    </div>
    <button type="submit" class="btn btn-default">답변하기</button>
</form>
@endcan

@endsection
