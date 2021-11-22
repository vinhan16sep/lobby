const express = require("express");
const DatabaseWrapper = require("../DatabaseWrapper");
const UsersWrapper = require("../UsersWrapper");
const router = express.Router();

/**
 *
 * @param {DatabaseWrapper} dbWrapper
 * @param {UsersWrapper} usersWrapper
 * @returns
 */
module.exports = function (dbWrapper, usersWrapper, logger) {
    //PARAMS: timestamp(n)
    router.get("/getGlobalMessage", async function (req, res) {
        // console.log(req.query);
        let paramUserId = req.query.userId;
        let paramSocketId = req.query.socketId;
        let user = await new Promise((resolve) => {
            usersWrapper.getUser(paramUserId, (user) => {
                resolve(user);
            });
        });
        if (!user || user.socketId != paramSocketId) {
            //unauthorized
            res.send({ response: "unauthorized" }).status(403);
            return;
        }
        // authorized
        let paramTime = req.query.time;
        if (!paramTime) {
            paramTime = Date.now();
        }

        let result = await dbWrapper.getGlobalMessage(paramTime);
        res.send({ response: result }).status(200);
    });
    //PARAMS: user
    router.get("/getMessage", async function (req, res) {
        let paramUserId = req.query.userId;
        let paramSocketId = req.query.socketId;
        let user = await new Promise((resolve) => {
            usersWrapper.getUser(paramUserId, (user) => {
                resolve(user);
            });
        });
        if (!user || user.socketId != paramSocketId) {
            //unauthorized
            res.send({ response: "unauthorized" }).status(403);
            return;
        }
        // authorized
        let userPartner = req.query.userPartner;
        let paramTime = req.query.time;
        if (!paramTime) {
            paramTime = Date.now();
        }

        let result = await dbWrapper.getMessage(paramUserId, userPartner, paramTime);
        res.send({ response: result }).status(200);
    });
    router.post("/setReadMessage", async function (req, res) {
        let paramUserId = req.query.userId;
        let paramSocketId = req.query.socketId;
        let user = await new Promise((resolve) => {
            usersWrapper.getUser(paramUserId, (user) => {
                resolve(user);
            });
        });
        if (!user || user.socketId != paramSocketId) {
            //unauthorized
            res.send({ response: "unauthorized" }).status(403);
            return;
        }
        // authorized
        let userPartner = req.query.userPartner;
        dbWrapper.setReadMessage(paramUserId, userPartner);
        res.send({ response: "Success" }).status(200);
    });
    return router;
};
