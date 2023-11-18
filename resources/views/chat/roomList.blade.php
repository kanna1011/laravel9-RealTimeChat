@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>ルーム一覧</h2>

            <ul>
                @foreach($roomLists as $room)
                    <li>
                        Room ID: {{ $room['room_id'] }}<br>
                        To User ID: {{ $room['to_user_id'] }}<br>
                        Icon Path: {{ $room['icon_path'] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection