const express = require('express');
const router = express.Router();

const refreshTokensHendler = require('./heandler/refresh-tokens');

/* GET home page. */
router.post('/gettoken', refreshTokensHendler.refreshToken);

module.exports = router;
