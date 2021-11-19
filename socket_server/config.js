var path = require("path");
var fs = require("fs");

class Config {
    constructor() {
        // var settingData = fs.readFileSync(path.join(path.dirname(process.execPath), "/Setting"), "utf8");
        var settingData = fs.readFileSync("Setting", "utf8");
        var json = JSON.parse(settingData);
        this.ssl = json.SSL == "true" ? true : false;
        this.debug = json.DEBUG == "true" ? true : false;
        this.port = parseInt(json.PORT, 10);
        if (this.ssl) {
            this.ssl_key = json.SSL_KEY_PATH;
            this.ssl_cert = json.SSL_CERT_PATH;
        } else {
            this.ssl_key = "";
            this.ssl_cert = "";
        }
        this.socketPrivateKey = json.SOCKET_PRIVATE_KEY;
    }
}

module.exports = Config;
