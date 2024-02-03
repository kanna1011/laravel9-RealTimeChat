@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2>サンプルページ</h2>

            <div class="col-md-8">
                <form action="{{ route('roomList.index') }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="user_id">ユーザーID</label>
                        <input type="text" class="form-control" name="user_id" id="user_id" placeholder="ユーザーIDを入力" required>
                    </div>
                    <div class="form-group">
                        <label for="user_name">ユーザー名</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" placeholder="ユーザー名を入力" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">メッセージ一覧ページに入る</button>
                    </div>
                </form>
            </div>
            
            <div class="col-md-8">
                <form action="{{ route('messageRoom.roomCreate') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">ユーザーID</label>
                        <input type="text" class="form-control" name="user_id" id="user_id" placeholder="ユーザーIDを入力" required>
                    </div>
                    <div class="form-group">
                        <label for="user_name">ユーザー名</label>
                        <input type="text" class="form-control" name="user_name" id="user_name" placeholder="ユーザー名を入力" required>
                    </div>
                    <div class="form-group">
                        <label for="con_id">相手ID</label>
                        <input type="text" class="form-control" name="con_id" id="con_id" placeholder="相手IDを入力" required>
                    </div>
                    <div class="form-group">
                        <label for="con_user_name">相手名</label>
                        <input type="text" class="form-control" name="con_user_name" id="con_user_name" placeholder="相手名を入力" required>
                    </div>
                    <div class="form-group">
                        <label for="room_name">記事タイトル</label>
                        <input type="text" class="form-control" name="room_name" id="room_name" placeholder="記事タイトルを入力" required>
                    </div>
                    <div class="form-group">
                        <label for="article_url">記事URL</label>
                        <input type="text" class="form-control" name="article_url" id="article_url" placeholder="記事URLを入力" required>
                    </div>
                    <div>
                        <label for="content">最初のメッセージ</label>
                        <input type="text" class="form-control" name="content" id="content" placeholder="最初のメッセージを入力" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">メッセージルーム作成</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection