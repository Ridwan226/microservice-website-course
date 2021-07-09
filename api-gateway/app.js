require('dotenv').config();
const express = require('express');
const path = require('path');
const cookieParser = require('cookie-parser');
const logger = require('morgan');

const indexRouter = require('./routes/index');
const usersRouter = require('./routes/users');
const courseRouter = require('./routes/course');
const mediaRouter = require('./routes/media');
const paymentRouter = require('./routes/payment');
const orderRouter = require('./routes/order');
const mentorsRouter = require('./routes/mentors');
const chaptersRouter = require('./routes/chapters');
const lessonsRouter = require('./routes/lessons');
const imagecoursesRouter = require('./routes/imagecourses');
const myCoursesRouter = require('./routes/myCourses');

const refreshTokenRouter = require('./routes/refreshTokens');

const verifyToken = require('./middlewares/verifyToken');

const app = express();

app.use(logger('dev'));
app.use(express.json({limit: '50mb'}));
app.use(express.urlencoded({extended: false, limit: '50mb'}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', indexRouter);
app.use('/refreshtoken', refreshTokenRouter);
app.use('/users', usersRouter);
app.use('/course', courseRouter);
app.use('/media', mediaRouter);
app.use('/payment', paymentRouter);
app.use('/order', orderRouter);
app.use('/mentors', verifyToken, mentorsRouter);
app.use('/chapters', verifyToken, chaptersRouter);
app.use('/lessons', verifyToken, lessonsRouter);
app.use('/imagecourses', verifyToken, imagecoursesRouter);
app.use('/mycourses', verifyToken, myCoursesRouter);

module.exports = app;
