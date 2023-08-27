@extends('layouts.app')

@section('content')
    <h1>Chat Room: {{ $chatRoom->name }}</h1>

    <div id="chat-room">
        <div id="messages">
            @foreach ($messages as $message)
                <div class="message">
                    {{ $message->content }}
                </div>
            @endforeach
        </div>
        <input type="text" id="message-input" placeholder="Type your message" />
        <button id="send-button">Send</button>
    </div>
    <script>
        const chatRoomId = {{ $chatRoom->id }};
        window.Echo.private(`chat.${chatRoomId}`)
        .listen('MessageSent', (e) => {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message';
            messageDiv.innerText = e.message.content;
            document.getElementById('messages').appendChild(messageDiv);
        });
        const messageInput = document.getElementById('message-input');

        messageInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();

                const content = messageInput.value.trim();
                if (content !== '') {
                    axios.post(`/chat/${chatRoomId}/messages`, { content: content })
                        .then(() => {
                            messageInput.value = '';
                        })
                        .catch((error) => {
                            console.error('Message sending error:', error);
                        });
                }
            }
        });
        const sendButton = document.getElementById('send-button');

        sendButton.addEventListener('click', () => {
            const content = messageInput.value.trim();
            if (content !== '') {
                axios.post(`/chat/${chatRoomId}/messages`, { content: content })
                    .then(() => {
                        messageInput.value = '';
                    })
                    .catch((error) => {
                        console.error('Message sending error:', error);
                    });
            }
        });
    </script>
@endsection
