const express = require('express');
const bcrypt = require('bcryptjs');
const pool = require('../database');
const router = express.Router();

router.get('/login', (req, res) => {
  if (req.session.user) return res.redirect('/');
  res.render('auth/login', { title: 'Login' });
});

router.post('/login', async (req, res) => {
  try {
    const { username, password } = req.body;
    const [rows] = await pool.query('SELECT * FROM users WHERE username = ?', [username]);
    if (rows.length && bcrypt.compareSync(password, rows[0].password)) {
      req.session.user = {
        id: rows[0].id,
        name: rows[0].name,
        username: rows[0].username,
        role: rows[0].role,
      };
      return res.redirect('/');
    }
    req.session.error = 'Username atau password salah.';
    res.redirect('/login');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/login');
  }
});

router.get('/register', (req, res) => {
  if (req.session.user) return res.redirect('/');
  res.render('auth/register', { title: 'Register' });
});

router.post('/register', async (req, res) => {
  try {
    const { name, username, password } = req.body;
    if (!name || !username || !password) {
      req.session.error = 'Semua field wajib diisi.';
      return res.redirect('/register');
    }
    const [exist] = await pool.query('SELECT id FROM users WHERE username = ?', [username]);
    if (exist.length) {
      req.session.error = 'Username sudah digunakan.';
      return res.redirect('/register');
    }
    const hash = bcrypt.hashSync(password, 10);
    await pool.query("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, 'user')", [name, username, hash]);
    req.session.success = 'Registrasi berhasil. Silakan login.';
    res.redirect('/login');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/register');
  }
});

router.get('/logout', (req, res) => {
  req.session.destroy();
  res.redirect('/login');
});

module.exports = router;