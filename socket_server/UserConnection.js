class UserConnection {
    constructor(userId, socketId) {
        this.userId = userId;
        this.socketId = socketId;
    }

    static fromJSON(data) {
        return Object.assign(new UserConnection(), data);
    }

    isSameSocketId(socketId) {
        return this.socketId == socketId;
    }
}

module.exports = UserConnection;
