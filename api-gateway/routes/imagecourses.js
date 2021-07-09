const express = require('express');
const router = express.Router();

const imagecoursesHendler = require('./heandler/imagecourses');
const verifyToken = require('../middlewares/verifyToken');

router.post('/', imagecoursesHendler.create);
router.delete('/:id', imagecoursesHendler.destroy);

module.exports = router;
