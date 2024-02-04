@extends('layouts.app')

@section('content')
<div class="container top">
    <div class="row justify-content-center">
        <h2>ユーザー登録</h2>

        <div class="col-md-8">
            <form action="{{ route('register.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">ユーザー名</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="ユーザー名を入力" required>
                </div>
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="メールアドレスを入力" required>
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="パスワードを入力" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">パスワード確認</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="パスワードを入力" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection