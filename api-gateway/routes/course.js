const express = require('express');
const router = express.Router();

const coursesHendler = require('./heandler/courses');
const verifyToken = require('../middlewares/verifyToken');

router.get('/', coursesHendler.getAll);
router.get('/:id', coursesHendler.get);

router.post('/', verifyToken, coursesHendler.create);
router.put('/:id', verifyToken, coursesHendler.update);
router.delete('/:id', verifyToken, coursesHendler.destroy);

module.exports = router;
