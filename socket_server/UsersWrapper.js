var UserConnection = require("./UserConnection.js");

/**
 * This callback is displayed as a global member.
 * @callback userCallback
 * @param {UserConnection} user
 */

class UsersWrapper {
    /**
     * Constructor
     */
    constructor() {
        this.localStorage = {};
    }
    async get(key, callback) {
        callback(null, this.localStorage[key]);
    }

    /**
     *
     * @param {String} key
     * @param {userCallback} callback
     */
    async getUser(key, callback) {
        await this.get(`nodejs-socket-user-${key}`, (err, val) => {
            if (err) {
                callback(null);
                return;
            }
            return callback(val);
        });
    }

    async getOnlineUser() {
        return Object.values(this.localStorage);
    }

    async setUserData(key, data) {
        await this.set(`nodejs-socket-user-${key}`, data);
    }

    async del(key) {
        delete this.localStorage[key];
    }

    async set(key, val) {
        this.localStorage[key] = val;
    }

    async deleteUser(key) {
        await this.del(`nodejs-socket-user-${key}`);
    }
}
module.exports = UsersWrapper;
