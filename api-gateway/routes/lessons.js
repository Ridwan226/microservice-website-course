const express = require('express');
const router = express.Router();

const lessonsHendler = require('./heandler/lessons');
const verifyToken = require('../middlewares/verifyToken');

router.post('/', lessonsHendler.create);
router.put('/:id', lessonsHendler.update);
router.delete('/:id', lessonsHendler.destroy);
router.get('/:id', lessonsHendler.get);
router.get('/', lessonsHendler.getAll);

module.exports = router;
