require('dotenv').config();
const apiAdapter = require('../../apiAdapter');
const {URL_SERVICE_COURSE} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const id = req.params.id;
    const chapter = await api.delete(
      `${URL_SERVICE_COURSE}/api/chapter/delete/${id}`,
    );
    return res.json(chapter.data);
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
