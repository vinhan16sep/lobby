class UserConnection {
    constructor(connectJsonData, userId) {
        if (!connectJsonData) {
            return;
        }
        this.userId = userId;
        this.connectJsonData = connectJsonData;
    }

    static fromJSON(data) {
        return Object.assign(new UserConnection(), data);
    }

    isSameSocketId(socketId) {
        return this.socketId == socketId;
    }
}

module.exports = UserConnection;
