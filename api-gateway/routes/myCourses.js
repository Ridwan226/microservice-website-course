const express = require('express');
const router = express.Router();

const myCoursesHendler = require('./heandler/my-courses');
const verifyToken = require('../middlewares/verifyToken');

router.post('/', myCoursesHendler.create);
router.get('/', myCoursesHendler.get);

module.exports = router;
