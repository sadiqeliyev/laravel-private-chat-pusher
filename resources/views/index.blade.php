<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Chat</title>
</head>

<body>

    <div class="chat">
        <div class="top">
            <img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">
            <div>
                <p>Sadig Aliyev</p>
                <small>Online</small>
            </div>
        </div>

        <div class="messages">
            @include('receive', ['message' => 'Hey what\'s app nigga?'])
        </div>

        <div class="bottom">
            <form action="">
                <input type="text" placeholder="Enter message..." class="message" id="message">
                <button></button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"
        integrity="sha512-tXL5mrkSoP49uQf2jO0LbvzMyFgki//znmq0wYXGq94gVF6TU0QlrSbwGuPpKTeN1mIjReeqKZ4/NJPjHN1d2Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: 'mt1'
        });
        const channel = pusher.subscribe('public');

        // receive message

        channel.bind('chat', function(data) {
            fetch('/receive', {
                    method: 'post',
                    headers: {
                        'accept': 'application/json',
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        '_token': "{{ csrf_token() }}",
                        message: data.message
                    })
                })
                .then(res => res.text())
                .then(data => {
                    Array.from(document.querySelectorAll('.messages > .message')).at(-1).insertAdjacentHTML(
                        'beforeend',
                        data);
                })
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            fetch('/broadcast', {
                    method: 'post',
                    headers: {
                        'accept': 'application/json',
                        'content-type': 'application/json',
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    body: JSON.stringify({
                        '_token': "{{ csrf_token() }}",
                        message: document.querySelector('#message').value
                    })
                })
                .then(res => res.text())
                .then(data => {
                    Array.from(document.querySelectorAll('.messages > .message')).at(-1).insertAdjacentHTML(
                        'beforeend', data);
                    document.querySelector('#message').value = '';
                });
        })
    </script>
</body>

</html>
