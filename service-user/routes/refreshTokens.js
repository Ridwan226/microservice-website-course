const express = require('express');
const router = express.Router();

const refreshTokensHendeler = require('./hendler/refreshTokens');

router.post('/', refreshTokensHendeler.create);
router.get('/gettoken', refreshTokensHendeler.getToken);
router.post('/logout', refreshTokensHendeler.logout);

module.exports = router;
