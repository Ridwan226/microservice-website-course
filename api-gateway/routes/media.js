const express = require('express');
const router = express.Router();

const mediaHendler = require('./heandler/media');

/* GET home page. */
router.post('/', mediaHendler.create);
router.get('/', mediaHendler.getAll);
router.delete('/:id', mediaHendler.destroy);

module.exports = router;
