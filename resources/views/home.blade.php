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
                        <button type="submit" class="btn btn-primary">メッセージ一覧ページに入る</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
@endsection