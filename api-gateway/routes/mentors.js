const express = require('express');
const router = express.Router();

const mentorsHendler = require('./heandler/mentors');

router.get('/', mentorsHendler.getAll);
router.get('/:id', mentorsHendler.get);
router.post('/', mentorsHendler.create);
router.put('/:id', mentorsHendler.update);
router.delete('/:id', mentorsHendler.destroy);

module.exports = router;
