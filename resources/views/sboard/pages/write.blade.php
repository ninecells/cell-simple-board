@extends('ncells::app')

@section('content')

<h2>글 작성</h2>

<form method="post" action="/sboards/{{ $board_key }}/write">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="title">제목</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="제목">
    </div>
    <div class="form-group">
        <label for="content">내용</label>
        <textarea class="form-control" id="content" name="content" placeholder="제목" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-default">저장</button>
</form>

@endsection