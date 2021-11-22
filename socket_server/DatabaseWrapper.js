var mysql = require("mysql");
const Logger = require("./Logger");
class DatabaseWrapper {
    constructor(url, tempLogMessageNum, logger) {
        this.dbConnected = false;
        this.dbConnection = mysql.createConnection(url);

        this.dbConnection.connect((err) => {
            if (err) {
                logger.error("SERVICE", "MYSQL", "", err.toString());
                return;
            }
            logger.info("SERVICE", "MYSQL", "", "connected as id " + this.dbConnection.threadId);
        });
        this.temporaryLogs = [];
        this.tempLogMessageNum = tempLogMessageNum;
    }

    /**
     * add message to temporary and check if num of message reach
     * message = {
     * 	fromUser, toUser, content, time, read
     * }
     * @param {Object} message
     */
    addMessage(message) {
        this.temporaryLogs.push(message);

        if (this.temporaryLogs.length >= this.tempLogMessageNum) {
            //TODO: add message list to DB and empty temp list
        }
    }

    /**
     *
     * @param {Number} timestamp nullable, if timestamp is null, get newest message
     */
    getGlobalMessage(timestamp) {
        var returnMessage = this.temporaryLogs.filter((m) => {
            if (m.toUser) {
                return;
            }
            if (timestamp) {
                return Number(timestamp) > m.time;
            } else {
                return true;
            }
        });
        //TODO: get 10 more message in db if has depend on timestamp (if null, get 10 newest message)
        return returnMessage;
    }

    /**
     *
     * @param {String} fromUser from User Id
     * @param {*} toUser  to User Id
     * @param {*} timestamp query time (use when using DB to get 10 nearest message)
     */
    getMessage(user1Id, user2Id, timestamp) {
        var returnMessage = this.temporaryLogs.filter((m) => {
            if ((m.fromUser == user1Id && m.toUser == user2Id) || (m.fromUser == user2Id && m.toUser == user1Id)) {
                if (timestamp) {
                    return Number(timestamp) > m.time;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        });
        //TODO: get 10 more message in db if has depend on timestamp (if null, get 10 newest message)
        return returnMessage;
    }

    countUnreadMessage(fromUser, toUser) {
        var returnMessage = this.temporaryLogs.filter((m) => {
            if (m.fromUser == fromUser && m.toUser == toUser) {
                return m.read;
            } else {
                return false;
            }
        });
        //TODO: get 10 more message in db if has depend on timestamp (if null, get 10 newest message)
        return returnMessage;
    }

    /**
     *
     * @param {String} fromUser
     * @param {String} toUser
     */
    setReadMessage(fromUser, toUser) {
        this.temporaryLogs.forEach((m) => {
            if (m.fromUser == fromUser && m.toUser == toUser) {
                m.read = true;
            }
        });
        //TODO: set read to message fromUser to toUser
    }
}

module.exports = DatabaseWrapper;
