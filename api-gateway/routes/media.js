const express = require('express');
const router = express.Router();

const verifyToken = require('../middlewares/verifyToken');

const mediaHendler = require('./heandler/media');

/* GET home page. */
router.post('/', mediaHendler.create);
router.get('/', verifyToken, mediaHendler.getAll);
router.delete('/:id', mediaHendler.destroy);

module.exports = router;
