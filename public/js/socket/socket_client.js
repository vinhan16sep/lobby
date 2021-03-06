const SocketMessageType = {
    JOIN: 'JOIN',
    SEND_MESSAGE: 'SEND_MESSAGE',
    RECV_MESSAGE: 'RECV_MESSAGE',
    USER_LEAVE: 'USER_LEAVE',
    USER_JOIN: 'USER_JOIN'
};

let socket;
$().ready(() => {
    socket = io.connect(SOCKET_URL, {
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
    });

    socket.on(SocketMessageType.JOIN, (data) => {
        //handle list online user
    });

    socket.on(SocketMessageType.RECV_MESSAGE, (data) => {
        console.log(data);
    });

    socket.on(SocketMessageType.USER_LEAVE, (data) => {
        //remove user from online list
    });

    socket.on(SocketMessageType.USER_JOIN, (data) => {
        //add user to online list
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
