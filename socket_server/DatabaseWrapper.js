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

            let insertArr = [];
            this.temporaryLogs.forEach(function(item) {
                let toUser = 0;
                if (item.toUser) {
                    toUser = parseInt(item.toUser);
                }
                insertArr.push([parseInt(item.fromUser), toUser, item.content, item.time, item.read]);
            });
            let query = `INSERT INTO chat_logs(from_user, to_user, message, created_at, read)  VALUES ? `;
            // execute the insert statment
            this.dbConnection.query(query, [insertArr], (err, results) => {
                if (err) {
                    return console.error(err.message);
                }
                this.temporaryLogs = [];
                logger.info("SERVICE", "MYSQL", "", "Row inserted " + results.affectedRows);
            });
            // connection.end();
        }
    }

    /**
     *
     * @param {Number} timestamp nullable, if timestamp is null, get newest message
     */
    async getGlobalMessage(timestamp) {
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

        if (timestamp) {
            timestamp = Number(timestamp);
        } else {
            timestamp = Date.now();
        }

        let sql = 'SELECT * FROM chat_logs WHERE to_user = 0 AND created_at <= ? ORDER BY created_at DESC LIMIT 10';
        let resultDB = await new Promise((resolve) => {
            this.dbConnection.query(sql, [timestamp], function (err, result) {
                if (err) throw err;
                resolve(result);
              });
        });
        if (resultDB.length) {
            resultDB.forEach(function(item) {
                returnMessage.push({
                    fromUser: item.from_user,
                    toUser: 0,
                    content: item.message,
                    time: item.created_at,
                    read: item.read
                });
            });
        }

        return returnMessage.sort(function(a, b) {
            return b.time - a.time;
        });
    }

    /**
     *
     * @param {String} fromUser from User Id
     * @param {*} toUser  to User Id
     * @param {*} timestamp query time (use when using DB to get 10 nearest message)
     */
    async getMessage(user1Id, user2Id, timestamp) {
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
        if (timestamp) {
            timestamp = Number(timestamp);
        } else {
            timestamp = Date.now();
        }

        let sql = 'SELECT * FROM chat_logs WHERE ((to_user = ? AND from_user = ?) OR (to_user = ? AND from_user = ?)) AND created_at <= ? ORDER BY created_at DESC LIMIT 10';
        let resultDB = await new Promise((resolve) => {
            this.dbConnection.query(sql, [user1Id, user2Id, user2Id, user1Id, timestamp], function (err, result) {
                if (err) throw err;
                resolve(result);
              });
        });
        if (resultDB.length) {
            resultDB.forEach(function(item) {
                returnMessage.push({
                    fromUser: item.from_user,
                    toUser: 0,
                    content: item.message,
                    time: item.created_at,
                    read: item.read
                });
            });
        }

        return returnMessage.sort(function(a, b) {
            return b.time - a.time;
        });
    }

    async countUnreadMessage(fromUser, toUser) {
        var returnMessage = this.temporaryLogs.filter((m) => {
            if (m.fromUser == fromUser && m.toUser == toUser) {
                return m.read;
            } else {
                return false;
            }
        });
        let sql = 'SELECT * FROM chat_logs WHERE to_user = ? AND from_user = ? AND read = 0';
        let resultDB = await new Promise((resolve) => {
            this.dbConnection.query(sql, [toUser, fromUser], function (err, result) {
                if (err) throw err;
                resolve(result);
              });
        });
        if (resultDB.length) {
            resultDB.forEach(function(item) {
                returnMessage.push({
                    fromUser: item.from_user,
                    toUser: 0,
                    content: item.message,
                    time: item.created_at,
                    read: item.read
                });
            });
        }
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
        let sql = 'UPDATE chat_logs SET read = 1 WHERE to_user = ? AND from_user = ? AND read = 0';
        this.dbConnection.query(sql, [toUser, fromUser], function (err, result) {
            if (err) throw err;
            logger.info("SERVICE", "MYSQL", "", "Row updated " + result.affectedRows);
        });
    }
}

module.exports = DatabaseWrapper;
