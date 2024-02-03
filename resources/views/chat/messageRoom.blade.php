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
            <div class="room_title_text">
                <div>
                    <span class="room_name">{{ $room['room_name'] }} のメッセージルーム</span>
                </div>
                <div>
                    <span class="article_link"><a href="{{ $room['article_url'] }}" target="_blank">記事ページ：{{ $room['room_name'] }}</a></span>
                </div>
                <div>
                    <span class="user_list">参加中のユーザ：{{ $to_user }}</span>
                </div>
            </div>
            <!-- チャット -->
            <div id="chat-room">
                <div id="messages">
                    @foreach ($messages as $message)
                        @if ($message['user_id'] === $from_user)
                            <div class="message right_message">
                                <div>
                                    <span>{{ \Carbon\CarbonImmutable::parse($message['created_at'])->format('Y年m月d日 H:i') }}&emsp;{{ $message['user_name'] }}</span>
                                </div>
                                <span class="from_user_message">
                                    {{ $message['content'] }}
                                </span>
                            </div>
                        @else
                            <div class="message">
                                <div>
                                    <span>{{ \Carbon\CarbonImmutable::parse($message['created_at'])->format('Y年m月d日 H:i') }}&emsp;{{ $message['user_name'] }}</span>
                                </div>
                                <span class="to_user_message">
                                    {{ $message['content'] }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="card-body">
                    <input type="text" id="text">
                    <input type="submit" value="送信" id="submit">
                </div>
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
        };

        // 閉じるボタンをクリックするとモーダルを閉じる
        span.onclick = function() {
            modal.style.display = "none";
        };

        // モーダル外をクリックすると閉じる
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
        // チャット
        const roomId = <?php echo $room['id']; ?>;
        const fromUser = '<?php echo $from_user; ?>';
        const fromUserName = '<?php echo $from_user_name; ?>';
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#submit").click(function () {
                const url = "/chat/messageRoom/" + roomId + "/create";
                $.ajax({
                    url: url,
                    data: {
                        room_id: roomId,
                        user_id: fromUser,
                        user_name: fromUserName,
                        content: $("#text").val()
                    },
                    method: "POST"
                });
                return false;
            });
            window.Echo.channel('message')
                .listen('MessageSent', (e) => {
                    if (e.message.user_id == fromUser) {
                        $("#messages").append('<div class="message right_message"><div><span>'+ e.message.created_at + '&emsp;' + e.message.user_name +'</span></div><span class="from_user_message">' + e.message.content + '</span></div>');
                    }
                    else {
                        $("#messages").append('<div class="message"><div><span>'+ e.message.created_at + '&emsp;' + e.message.user_name +'</span></div><span class="to_user_message">' + e.message.content + '</span></div>');
                    }
                    
                });
        });
    </script>
@endsection