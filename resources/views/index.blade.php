<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="stylesheet" href="https://chat.laravel.pusher.edlin.app/style.css">
</head>
<body>
<div class="chat">
    <div class="top">
        <img src="https://e7.pngegg.com/pngimages/799/987/png-clipart-computer-icons-avatar-icon-design-avatar-heroes-computer-wallpaper-thumbnail.png" alt="Avatar">
        <div>
            <p>Ross Edlin</p>
            <small>Online</small>
        </div>
    </div>

    <div class="messages">
        @include('receive', ['message' => "Hey! What's up!  👋"])
        @include('receive', ['message' => "Ask a friend to open this link and you can chat with them!"])
    </div>

    <div class="bottom">
        <form>
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>
    </div>
</div>
</body>

<script>
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {cluster: 'ap2'});
    const channel = pusher.subscribe('public');

    channel.bind('pusher:subscription_succeeded', function () {
        console.log('Subscription to channel successful');
    });

    channel.bind('chat', function (data) {
        console.log('Received message:', data.message);
    });

    pusher.connection.bind('error', function (err) {
        console.error('Pusher connection error:', err);
    });

    pusher.connection.bind('connected', function () {
        console.log('Pusher connected');
    });

    pusher.connection.bind('disconnected', function () {
        console.log('Pusher disconnected');
    });

    pusher.connection.bind('reconnected', function () {
        console.log('Pusher reconnected');
    });

    channel.bind('chat', function (data) {
        console.log('data', data)
        $.post("receive", {
            _token: '{{ csrf_token() }}',
            message: data.message,
        }).done(function (res) {
            console.log('res', res)
            $(".messages > .message").last().after(res);
            $(document).scrollTop($(document).height());
        });
    });

    $("form").submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: "broadcast",
            method: 'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data: {
                _token: '{{ csrf_token() }}',
                message: $("form #message").val(),
            }
        }).done(function (res) {
            $(".messages > .message").last().after(res);
            $("form #message").val('');
            $(document).scrollTop($(document).height());
        });
    });
</script>
</html>
