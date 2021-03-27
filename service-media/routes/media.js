const express = require('express');
const router = express.Router();
const isBase64 = require('is-base64');
const base64Img = require('base64-img');
const {Media} = require('../models');

/* post users listing. */
router.post('/', function (req, res, next) {
  const image = req.body.image;
  if (!isBase64(image, {mimeRequired: true})) {
    return res.status(400).json({status: 'error', massage: 'Invalid Mesage'});
  }

  base64Img.img(image, './public/images', Date.now(), async (err, filepath) => {
    if (err) {
      return res.status(400).json({status: 'error', message: err});
    }
    const path = require('path');
    const filename = path.parse(filepath).base;

    const media = await Media.create({image: `image/${filename}`});

    return res.json({
      status: 'success',
      data: {
        id: media.id,
        image: `${req.get('host')}/image/${filename}`,
      },
    });
  });

  // return res.send('oke');
});

module.exports = router;
