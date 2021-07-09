require('dotenv').config();
const apiAdapter = require('../../apiAdapter');
const {URL_SERVICE_COURSE} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const userId = req.user.data.id;
    const coursesId = req.body.course_id;

    const myCourses = await api.post(`${URL_SERVICE_COURSE}/api/mycourses`, {
      user_id: userId,
      course_id: coursesId,
    });
    return res.json(myCourses.data);
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
