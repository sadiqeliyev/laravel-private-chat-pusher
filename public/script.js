'use strict';

let chatList = document.querySelectorAll('.people-list .clearfix');
let token = document.querySelector('meta[name="token"]').getAttribute('content');

let pusher = new Pusher("37e1b1b01f4376fefb19", {
    cluster: 'mt1'
});

chatList.forEach(item => {
    item.addEventListener('click', function () {
        removeActive();
        item.classList.add('active');
        let user_id = item.getAttribute('data-id');
        let url = `/get-user/${user_id}`;
        fetch(url)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.status) {
                    document.querySelector('.chat').innerHTML = data.result;
                    let messageBtn = document.getElementById('send-message');
                    let messageInput = document.getElementById('message-text');
                    let session_id = document.querySelector('.chat-history').getAttribute('data-session-id');

                    let channel = pusher.subscribe('chat');

                    channel.bind('chatting.' + session_id, function (data) {
                        fetch('/receive', {
                            method: 'post',
                            headers: {
                                'accept': 'application/json',
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({
                                '_token': token,
                                message: data.message
                            })
                        })
                            .then(res => res.text())
                            .then(data => {
                                document.querySelector('.chat-history ul').insertAdjacentHTML('beforeend', data);
                                console.log(data);
                            });
                    });

                    messageBtn.addEventListener('click', function () {
                        let message = messageInput.value.trim();
                        let user_id = this.getAttribute('data-id');
                        fetch('/send-message', {
                            method: 'post',
                            headers: {
                                'accept': 'application/json',
                                'content-type': 'application/json',
                                'X-Socket-Id': pusher.connection.socket_id
                            },
                            body: JSON.stringify({
                                '_token': token,
                                'message': message,
                                'user_id': user_id,
                                'session_id': session_id,
                            })
                        })
                            .then(res => res.text())
                            .then(data => {
                                messageInput.value = '';
                                document.querySelector('.chat-history ul').insertAdjacentHTML('beforeend', data);
                            });
                    });
                }
            })
    });
});

function removeActive() {
    chatList.forEach(item => {
        item.classList.remove('active');
    });
}


