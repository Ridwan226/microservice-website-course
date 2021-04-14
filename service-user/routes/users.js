const express = require('express');
const router = express.Router();

const usersHendler = require('./hendler/users');

/* GET users listing. */
// router.get('/', function (req, res, next) {
//   res.send('respond with a resource');
// });

router.post('/register', usersHendler.register);
router.post('/login', usersHendler.login);
router.put('/update/:id', usersHendler.update);

module.exports = router;
