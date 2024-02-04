@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>チャットサンプルページ</h2>

        <div class="col-md-8">
            <h3>ログイン</h3>
            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="メールアドレスを入力" required>
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="メールアドレスを入力" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">ログイン</button>
                </div>
            </form>
        </div>
        <div>
            <a href="{{ route('register.create') }}">登録はこちら</a>
        </div>
    </div>
</div>
@endsection