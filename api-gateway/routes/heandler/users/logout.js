require('dotenv').config();
const apiAdapter = require('../../apiAdapter');
const {URL_SERVICE_USER} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const id = req.user.data.id;

    // return res.json(req.user);

    const user = await api.post(`${URL_SERVICE_USER}/refreshtoken/logout`, {
      user_id: id,
    });
    return res.json(user.data);
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
