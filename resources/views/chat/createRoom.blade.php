@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>チャットルーム作成</h2>

        <div class="col-md-8">
            <form action="{{ route('room.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="room_name">ルーム名</label>
                    <input type="text" class="form-control" name="room_name" id="room_name" placeholder="ルーム名を入力" required>
                </div>
                <div>
                    <label for="selected_users[]">参加ユーザー</label>
                    @foreach ($users as $user)
                    <div>
                        <label>
                            <input type="checkbox" name="selected_users[]" value="{{ $user['id'] }}" required>
                            {{ $user['name'] }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection