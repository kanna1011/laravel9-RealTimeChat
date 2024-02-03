@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <!-- メッセージ一覧切り替えラジオボタン -->
                <label class="button-radio">
                    <input type="radio" name="options" value="option1" id="option1" checked>
                    <span class="radio-label">メッセージ中　記事一覧</span>
                </label>
                <label class="button-radio">
                    <input type="radio" name="options" value="option2" id="option2">
                    <span class="radio-label">お知らせ</span>
                </label>
                <!-- 設定モーダル -->
                <button id="settingsButton" class="buttonStyle">設定</button>
                <div id="settingsModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <span>設定を以下に変更してください</span>
                        <form id="settingsForm">
                            <!-- チェックボックス -->
                            <label>
                                <input type="checkbox" name="option1"> 他の人が私にメッセージを送ることを許可しますか ?
                            </label>
                            <label>
                                <input type="checkbox" name="option2"> 新しいメッセージを受け取ったら通知メール送りますか ?
                            </label>
                            <label>
                                <input type="checkbox" name="option2"> 新しいお知らせが公開されたら通知メールを送りますか ?
                            </label>
                            <!-- 設定保存ボタン -->
                            <button type="submit" class="buttonStyle">設定を保存</button>
                        </form>
                    </div>
                </div>
            </div>
            <div>
                <button class="buttonStyle">一括削除</button>
                <button class="buttonStyle">一括アーカイブ</button>
            </div>
            <!-- ルームリスト -->
            <div class="room-list">
                <!-- 一括チェック on/off -->
                <div>
                    <input type="checkbox" id="checkAll"> すべてチェック/チェック解除
                </div>

                @foreach ($roomLists as $room)
                    <div class="room">
                        <!-- 一括処理用チェックボックス -->
                        <input type="checkbox" class="room-check" name="rooms[]" value="{{ $room['room_id'] }}">

                        <!-- アイコン画像と記事タイトル -->
                        <div class="room-info">
                            <a href="{{ route('messageRoom.index', $room['room_id']) }}">
                                <img src="{{ $room['icon_path'] }}" alt="アイコン" class="room-icon">
                                <span class="room-title">{{ $room['room_name'] }}</span>
                            </a>
                        </div>

                        <!-- 削除ボタン -->
                        <button class="delete-room" data-room-id="{{ $room['room_id'] }}">
                            <img src="{{ asset('storage/delete_icon.png') }}" alt="削除" style="width: 30px;">
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // 要素の取得
        var modal = document.getElementById("settingsModal");
        var btn = document.getElementById("settingsButton");
        var span = document.getElementsByClassName("close")[0];

        // 設定ボタンをクリックするとモーダルを開く
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // 閉じるボタンをクリックするとモーダルを閉じる
        span.onclick = function() {
            modal.style.display = "none";
        }

        // モーダル外をクリックすると閉じる
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        // 一括チェック
        document.getElementById('checkAll').addEventListener('change', function(e) {
            var checkboxes = document.querySelectorAll('.room-check');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = e.target.checked;
            }
        });
    </script>
@endsection