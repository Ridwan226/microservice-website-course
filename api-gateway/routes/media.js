const express = require('express');
const router = express.Router();

const mediaHendler = require('./heandler/media');

/* GET home page. */
router.post('/', mediaHendler.create);

module.exports = router;
