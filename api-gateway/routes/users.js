const express = require('express');
const router = express.Router();

const verifyToken = require('../middlewares/verifyToken');
const userHendler = require('./heandler/users');

/* GET home page. */
router.post('/register', userHendler.register);
router.post('/login', userHendler.login);
router.put('/update', verifyToken, userHendler.update);
router.get('/detail', verifyToken, userHendler.getUser);
router.post('/logout', verifyToken, userHendler.logout);

// router.get('/', userHendler.getAll);
// router.delete('/:id', userHendler.destroy);

module.exports = router;
