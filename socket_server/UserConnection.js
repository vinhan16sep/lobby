class UserConnection {
    constructor(userId, socketId, name) {
        this.userId = userId;
        this.socketId = socketId;
        this.name = name;
    }

    static fromJSON(data) {
        return Object.assign(new UserConnection(), data);
    }

    toJSON() {
        return {
            userId: this.userId,
            name: this.name
        };
    }

    isSameSocketId(socketId) {
        return this.socketId == socketId;
    }
}

module.exports = UserConnection;
