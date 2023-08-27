@extends('layouts.app')

@section('content')
    <h1>Create a Chat Room</h1>
    <form action="{{ route('chat.store') }}" method="post">
        @csrf
        <label for="name">Chat Room Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Create Chat Room</button>
    </form>
@endsection
