@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div>
            <form action="{{ route('roomList.index') }}" method="post">
                @csrf
                <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{ $from_user }}">
                <input type="hidden" class="form-control" name="user_name" id="user_name" value="{{ $from_user_name }}">
                <button type="submit" class="buttonStyle">一覧に戻る</button>
            </form>
        </div>
        <div class="room_title_text">
            <div>
                <span class="room_name">{{ $room['room_name'] }} のメッセージルーム</span>
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
                    <span class="message_info">
                        {{ \Carbon\CarbonImmutable::parse($message['created_at'])->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}&emsp;{{ $message['user_name'] }}
                    </span>
                    <span class="from_user_message">
                        {{ $message['content'] }}
                    </span>
                </div>
                @else
                <div class="message">
                    <div>
                        <span class="message_info">
                            {{ \Carbon\CarbonImmutable::parse($message['created_at'])->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}&emsp;{{ $message['user_name'] }}
                        </span>
                    </div>
                    <span class="to_user_message">
                        {{ $message['content'] }}
                    </span>
                </div>
                @endif
                @endforeach
            </div>
            <div class="send_message_area">
                <input class="text_area" type="text" id="text">
                <input class="buttonStyle" type="submit" value="送信" id="submit">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
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
        $("#submit").click(function() {
            const url = "/chat/messageRoom/" + roomId + "/create";
            $.ajax({
                url: url,
                data: {
                    room_id: roomId,
                    user_id: fromUser,
                    user_name: fromUserName,
                    content: $("#text").val()
                },
                method: "POST",
                success: function() {
                    $("#text").val('');
                }
            });
            return false;
        });
        window.Echo.channel('message')
            .listen('MessageSent', (e) => {
                if (e.message.user_id == fromUser) {
                    $("#messages").append('<div class="message right_message"><span class="message_info">' + e.message.created_at + '&emsp;' + e.message.user_name + '</span><span class="from_user_message">' + e.message.content + '</span></div>');
                } else {
                    $("#messages").append('<div class="message"><span class="message_info">' + e.message.created_at + '&emsp;' + e.message.user_name + '</span><span class="to_user_message">' + e.message.content + '</span></div>');
                }
            });
    });
</script>
@endsection