@extends('layouts.app')

@section('content')
<div class="container top">
    <div class="row justify-content-center">
        <h2>ログイン</h2>

        <div class="col-md-8">
            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="メールアドレスを入力" required>
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="パスワードを入力" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">ログイン</button>
                    <span class="buttonStyle">
                        <a href="{{ route('register.create') }}">登録はこちら</a>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection