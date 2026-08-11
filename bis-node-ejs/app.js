const path = require('path');
const express = require('express');
const morgan = require('morgan');
const dashboardRouter = require('./routes/dashboard');

const app = express();
const port = process.env.PORT || 3000;

app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'ejs');
app.use(morgan('dev'));
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', dashboardRouter);

app.use((req, res) => {
  res.status(404).render('404', { url: req.originalUrl });
});

app.listen(port, () => {
  console.log(BIS Node app running at http://localhost:);
});
