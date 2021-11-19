var UserConnection = require("./UserConnection.js");

/**
 * This callback is displayed as a global member.
 * @callback userCallback
 * @param {UserConnection} user
 */

class DataWrapper {
    /**
     * Constructor
     * @param {object} options
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
            if (!val) {
                callback(null);
                return;
            }
            let userJson = JSON.parse(val);
            var returnVal = UserConnection.fromJSON(userJson);
            callback(returnVal);
        });
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
module.exports = DataWrapper;
