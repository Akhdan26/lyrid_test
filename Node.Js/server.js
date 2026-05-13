const express = require('express');
const session = require('express-session');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));
app.use(session({
  secret: 'lyrid-secret-key-2026',
  resave: false,
  saveUninitialized: true,
  cookie: { maxAge: 86400000 },
}));

// Flash messages
app.use((req, res, next) => {
  res.locals.success = req.session.success;
  res.locals.error = req.session.error;
  res.locals.user = req.session.user || null;
  delete req.session.success;
  delete req.session.error;
  next();
});

// View engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Routes
app.use('/', require('./routes/auth'));
app.use('/', require('./routes/index'));
app.use('/users', require('./routes/users'));
app.use('/employees', require('./routes/employees'));

// 404
app.use((req, res) => {
  res.status(404).render('error', { title: '404 Not Found', message: 'Halaman tidak ditemukan.' });
});

app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});