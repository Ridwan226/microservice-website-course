const express = require('express');
const router = express.Router();

const reviewsHendler = require('./heandler/reviews');

router.post('/', reviewsHendler.create);
router.put('/:id', reviewsHendler.update);
router.delete('/:id', reviewsHendler.destroy);

module.exports = router;
