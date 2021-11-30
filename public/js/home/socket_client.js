const SocketMessageType = {
    JOIN: 'JOIN',
    SEND_MESSAGE: 'SEND_MESSAGE',
    RECV_MESSAGE: 'RECV_MESSAGE',
    USER_LEAVE: 'USER_LEAVE',
    USER_JOIN: 'USER_JOIN'
};

$().ready(() => {
    const socket = io.connect(SOCKET_URL, {
        reconnection: true,
        autoConnect: true,
        reconnectionDelay: 1000,
        reconnectionDelayMax: 5000,
        timeout: 5000,
        // transports: ['websocket'],
        // upgrade: false
        reconnectionAttempts: Infinity
    });

    socket.on('connect', () => {
        socket.emit(SocketMessageType.JOIN, {
            userId: currentUser.id,
            name: currentUser.name,
            company: currentUser.company,
            position: currentUser.position
        });

        blockChatBox(false);
    });

    socket.on('disconnect', () => {
        // console.log('disconnect');

        blockChatBox();
    });

    socket.on(SocketMessageType.JOIN, (data) => {
        // console.log('join', data);

        recvListUser(data);
    });

    socket.on(SocketMessageType.RECV_MESSAGE, (data) => {
        // console.log('recv', data);

        let message = {
            id: parseInt(data.sender),
            message: data.content
        };

        if (currentUser.id != parseInt(data.sender)) {
            if (data.isGlobal) {
                receiveChatMessage('.chat-public', message);
            } else {
                receiveChatMessage('.chat-private', message);
            }
        }
    });

    socket.on(SocketMessageType.USER_LEAVE, (data) => {
        // console.log('user leave', data);

        removeUser(data);
    });

    socket.on(SocketMessageType.USER_JOIN, (data) => {
        // console.log('user join', data);

        addUser(data);
    });

    window.socket = socket;
});

function sendGlobalMessage(data) {
    socket.emit(SocketMessageType.SEND_MESSAGE, {
        content: data
    });
}

function sendPrivateMessage(data, to) {
    socket.emit(SocketMessageType.SEND_MESSAGE, {
        content: data,
        to: to
    });
}
