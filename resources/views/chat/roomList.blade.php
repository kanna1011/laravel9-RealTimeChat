@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <!-- ルーム作成 -->
        <div class="buttonStyle">
            <a href="{{ route('room.create') }}">チャットルーム作成</a>
        </div>
        <!-- ルームリスト -->
        <div class="room-list">
            @foreach ($roomLists as $room)
            <div class="room">
                <div class="room-info buttonStyle2">
                    <a href="{{ route('messageRoom.index', $room['room_id']) }}">
                        <span class="room-title">{{ $room['room_name'] }}</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection