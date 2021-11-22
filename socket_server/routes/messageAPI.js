const express = require("express");
const DatabaseWrapper = require("../DatabaseWrapper");
const router = express.Router();

/**
 *
 * @param {DatabaseWrapper} dbWrapper
 * @returns
 */
module.exports = function (dbWrapper, logger) {
    router.get("/getGlobalMessage", function (req, res) {
        console.log(req);
        res.send({ response: "TEST getGlobalMessage" }).status(200);
    });
    router.get("/getMessage", function (req, res) {
        console.log(req);
        res.send({ response: "TEST getMessage" }).status(200);
    });
    router.post("/setReadMessage", function (req, res) {
        console.log(req);
        res.send({ response: "TEST setReadMessage" }).status(200);
    });
    return router;
};
