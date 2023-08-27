@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <ul id="board">
                            @foreach($posts as $post)
                                <li>{{ $post->text }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="card-body">
                        <input type="text" id="text">
                        <input type="submit" value="送信" id="submit">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">        
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#submit").click(function () {
                const url = "/posts/create";
                $.ajax({
                    url: url,
                    data: {
                        text: $("#text").val()
                    },
                    method: "POST"
                });
                return false;
            });
            window.Echo.channel('message')
                .listen('MessageSent', (e) => {
                    console.log(e);
                    $("#board").append('<li>' + e.message.text + '</li>');
                });
        });
    </script>
@endsection
