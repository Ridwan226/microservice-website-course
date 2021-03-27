const express = require('express');
const router = express.Router();
const isBase64 = require('is-base64');
const base64Img = require('base64-img');
const {Media} = require('../models');
const fs = require('fs');

router.get('/', async (req, res) => {
  const media = await Media.findAll({
    attributes: ['id', 'image'],
  });

  const meappedMedia = media.map((m) => {
    m.image = `${req.get('host')}/${m.image}`;
    return m;
  });

  return res.json({
    status: 'success',
    data: meappedMedia,
  });
});

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

    const media = await Media.create({image: `images/${filename}`});

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

router.delete('/:id', async (req, res) => {
  const id = req.params.id;

  const media = await Media.findByPk(id);

  if (!media) {
    return res
      .status(400)
      .json({status: 'error', massage: 'Data Tidak Tersedia'});
  }

  fs.unlink(`./public/${media.image}`, async (err) => {
    if (err) {
      return res.status(400).json({status: 'error', massage: err.message});
    }
    await media.destroy();

    return res.json({
      status: 'success',
      massage: 'image Deleted',
    });
  });
});

module.exports = router;
