const express = require('express');
const router = express.Router();

const chaptersHendler = require('./heandler/chapters');
const verifyToken = require('../middlewares/verifyToken');

router.post('/', chaptersHendler.create);
router.put('/:id', chaptersHendler.update);
router.delete('/:id', chaptersHendler.destroy);
router.get('/:id', chaptersHendler.get);
router.get('/', chaptersHendler.getAll);

module.exports = router;
