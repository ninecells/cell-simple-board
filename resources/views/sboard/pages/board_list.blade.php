@extends('ncells::jumbotron.app')

@section('content')
<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Key</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($boards as $board)
    <tr>
        <th scope="row">{{ $board->id }}</th>
        <td><a href="/sboards/{{ $board->key }}">/{{ $board->key }}</a></td>
        <td>{{ $board->created_at }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
{!! $boards->links() !!}
@endsection
