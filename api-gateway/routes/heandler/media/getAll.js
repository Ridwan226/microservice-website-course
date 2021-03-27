require('dotenv').config();
const apiAdapter = require('../../apiAdapter');
const {URL_SERVICE_MEDIA} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const media = await api.get(`${URL_SERVICE_MEDIA}/media`);
    return res.json(media.data);
  } catch (error) {
    if (error.code === 'ECONNREFUSED') {
      return res
        .status(500)
        .json({status: 'error', message: 'Service Tidak Tersedia'});
    }

    const {status, data} = error.response;
    return res.status(status).json(data);
  }
};
