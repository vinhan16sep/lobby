var log4js = require("log4js");
var path = require("path");
var dateFormat = require("date-format");
class Logger {
    constructor(isDebug) {
        var _this = this;
        this.isDebug = isDebug;
        log4js.addLayout("json", function (config) {
            return function (logEvent) {
                if (logEvent.data[0] == "PLAIN") {
                    return logEvent.data[3];
                } else {
                    return JSON.stringify({
                        time: dateFormat("yyyy-MM-dd hh:mm:ss.SSS", new Date()),
                        host: _this.hostAddress || "",
                        action: logEvent.data[0],
                        type: logEvent.data[1],
                        sessionId: logEvent.data[2],
                        desc: logEvent.data[3],
                        level: logEvent.level.levelStr
                    });
                }
            };
        });
        log4js.configure(path.join(path.dirname(process.execPath), "/log4js-config.json"));
        // log4js.configure("log4js-config.json");
        this.logger = log4js.getLogger("logfile");
        this.consoleLogger = log4js.getLogger("consoleout");
    }

    trace(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.trace(action, type, sessionId, desc.join(" "));
        }
        this.logger.trace(action, type, sessionId, desc.join(" "));
    }
    debug(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.debug(action, type, sessionId, desc.join(" "));
        }
        this.logger.debug(action, type, sessionId, desc.join(" "));
    }
    info(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.info(action, type, sessionId, desc.join(" "));
        }
        this.logger.info(action, type, sessionId, desc.join(" "));
    }
    warn(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.warn(action, type, sessionId, desc.join(" "));
            // console.log(msg);
        }
        this.logger.warn(action, type, sessionId, desc.join(" "));
    }
    error(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.error(action, type, sessionId, desc.join(" "));
            // console.log(msg);
        }
        this.logger.error(action, type, sessionId, desc.join(" "));
    }
    fatal(action, type, sessionId, ...desc) {
        if (this.isDebug) {
            this.consoleLogger.fatal(action, type, sessionId, desc.join(" "));
            // console.log(msg);
        }
        this.logger.fatal(action, type, sessionId, desc.join(" "));
    }
}
module.exports = Logger;
