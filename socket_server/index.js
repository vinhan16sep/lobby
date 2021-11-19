var Config = require("./config.js");
var Logger = require("./Logger.js");
var express = require("express");
var app = express();
var fs = require("fs");
var DataWrapper = require("./DataWrapper.js");
var os = require("os");
var socketType = require("./SocketMessageType.js");
const UserConnection = require("./UserConnection.js");

var cfg = new Config();

console.log(cfg);
var hostAddress = os.hostname();

var logger = new Logger(cfg.debug);
logger.hostAddress = hostAddress;

var onSocketStarted = function () {
    logger.info("PLAIN", "", "", "******************************************");
    logger.info("PLAIN", "", "", "*                                        *");
    logger.info("PLAIN", "", "", "*          SOCKET SERVER STARTED         *");
    logger.info("PLAIN", "", "", `* AT HOST: ${hostAddress.padStart(29, " ")} *`);
    logger.info("PLAIN", "", "", "******************************************");
};
var httpServ = cfg.ssl ? require("https") : require("http");
if (cfg.ssl) {
    httpsServer = httpServ.createServer(
        {
            key: fs.readFileSync(cfg.ssl_key),
            cert: fs.readFileSync(cfg.ssl_cert)
        },
        app
    );
} else {
    httpsServer = httpServ.createServer(app);
}
var io = require("socket.io")(httpsServer);
var dataWrapper = new DataWrapper();
io.set("heartbeat timeout", 60000);
io.set("heartbeat interval", 25000);

io.sockets.on("connection", function (socket) {
    var userId = null;
    logger.info("RECV", "CONNECTION", socket.id, "CONNECTED");
    socket.on(socketType.JOIN, (message) => {
        try {
            logger.info("RECV", "JOIN", socket.id, JSON.stringify(message));
            if (!message.userId) {
                logger.info("SERVIVE", "JOIN", socket.id, "invalid message");
            }
            userId = message.userId;
            dataWrapper.getUser(`${userId}`, (user) => {
                if (!user) {
                    var newUser = new UserConnection(userId, socket.id);

                    logger.info("INFO", "JOIN", socket.id, JSON.stringify(message));
                    dataWrapper.setUserData(`${userId}`, JSON.stringify(newUser));
                } else {
                    user.socketId = socket.id;
                }
            });
            //todo: send list online user
        } catch (error) {
            logger.error("EXCEPTION", "START_TRACKING", socket.id, error.toString());
        }
    });

    socket.on(socketType.SEND_MESSAGE, (message) => {
        try {
            logger.info("RECV", "SEND_MESSAGE", socket.id, JSON.stringify(message));
            if (!userId) {
                logger.info("SERVIVE", "SEND_MESSAGE", socket.id, "userId invalid");
                return;
            }
            var time = Date.now();
            var m = {
                sender: userId,
                time: time,
                content: message.content,
                isGlobal: true
            };
            if (message.to) {
                m.isGlobal = false;
                io.to(socket.id).emit(socketType.RECV_MESSAGE, m);
                io.to(message.to).emit(socketType.RECV_MESSAGE, m);
            } else {
                io.emit(socketType.RECV_MESSAGE, m);
            }
            logger.info("SEND", "RECV_MESSAGE", socket.id, JSON.stringify(m));
        } catch (error) {
            logger.error("EXCEPTION", "SEND_MESSAGE", socket.id, error.toString());
        }
    });

    socket.on("disconnect", function (reason) {
        try {
            logger.info("RECV", "CONNECTION", socket.id, "DISCONNECTED Reason:", reason);
            if (!userId) {
                logger.info("SERVIVE", "disconnect", socket.id, "userId invalid");
                return;
            }

            dataWrapper.getUser(`${userId}`, (user) => {
                if (!user) {
                    logger.info("SERVIVE", "HANDLE DISCONNECT", socket.id, `user ${userId} not found`);
                    return;
                }
                logger.info("INFO", "DISCONNECT", socket.id, "");
                delete user.openingContent[socket.id];
                if (Object.keys(user.openingContent).length === 0) {
                    //delete user
                    dataWrapper.deleteUserDoNotLock(`${userId}`);
                } else {
                    dataWrapper.setUserDataDoNotLock(`${userId}`, JSON.stringify(user));
                }
            });
        } catch (error) {
            logger.error("EXCEPTION", "disconnect", socket.id, error.toString());
        }
    });
});
httpsServer.listen(cfg.port, onSocketStarted);
