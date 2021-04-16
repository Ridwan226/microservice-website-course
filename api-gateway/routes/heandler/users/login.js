require('dotenv').config();
const jwt = require('jsonwebtoken');
const apiAdapter = require('../../apiAdapter');
const {
  URL_SERVICE_USER,
  JWT_SECRET,
  JWT_SECRET_REFRESH_TOKEN,
  JWT_ACCESS_TOKEN_EXPIRED,
  JWT_REFRESH_TOKEN_EXPIRED,
} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const user = await api.post(`${URL_SERVICE_USER}/users/login`, req.body);

    const data = user.data.data;

    const token = jwt.sign({data}, JWT_SECRET, {
      expiresIn: JWT_ACCESS_TOKEN_EXPIRED,
    });

    const refreshToken = jwt.sign({data}, JWT_SECRET_REFRESH_TOKEN, {
      expiresIn: JWT_REFRESH_TOKEN_EXPIRED,
    });

    await api.post(`${URL_SERVICE_USER}/refreshtoken`, {
      refresh_token: refreshToken,
      user_id: data.id,
    });

    return res.json({status: 'success', token, refreshToken});

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
