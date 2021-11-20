class UserConnection {
    constructor(userId, socketId, name, company, position) {
        this.userId = userId;
        this.socketId = socketId;
        this.name = name;
        this.company = company;
        this.position = position;
    }

    static fromJSON(data) {
        return Object.assign(new UserConnection(), data);
    }

    toJSON() {
        var json = {
            userId: this.userId,
            name: this.name
        };
        if (this.company) {
            json.company = this.company;
        }
        if (this.position) {
            json.position = this.position;
        }

        return json;
    }

    isSameSocketId(socketId) {
        return this.socketId == socketId;
    }
}

module.exports = UserConnection;
