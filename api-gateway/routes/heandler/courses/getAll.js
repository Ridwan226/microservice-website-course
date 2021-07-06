require('dotenv').config();
const apiAdapter = require('../../apiAdapter');
const {URL_SERVICE_COURSE, URL_HOSTNAME} = process.env;

const api = apiAdapter();

module.exports = async (req, res) => {
  try {
    const courses = await api.get(`${URL_SERVICE_COURSE}/api/courses`, {
      params: {...req.query, status: 'published'},
    });

    const coursesData = courses.data;

    const firstPage = coursesData.data.first_page_url.split('?').pop();
    const lastPage = coursesData.data.last_page_url.split('?').pop();

    coursesData.data.first_page_url = `${URL_HOSTNAME}/api/courses?${firstPage}`;
    coursesData.data.last_page_url = `${URL_HOSTNAME}/api/courses?${lastPage}`;

    if (coursesData.data.next_page_url) {
      const nextPage = coursesData.data.next_page_url.split('?').pop();
      coursesData.data.next_page_url = `${URL_HOSTNAME}/api/courses?${nextPage}`;
    }

    if (coursesData.data.prev_page_url) {
      const prevPage = coursesData.data.prev_page_url.split('?').pop();
      coursesData.data.prev_page_url = `${URL_HOSTNAME}/api/courses?${prevPage}`;
    }

    if (coursesData.data.path) {
      coursesData.data.path = `${URL_HOSTNAME}/courses`;
    }
    return res.json(coursesData);
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
