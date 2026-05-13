const express = require('express');
const pool = require('../database');
const { requireAuth } = require('../middleware/auth');
const router = express.Router();

router.get('/', requireAuth, async (req, res) => {
  try {
    const [[{ users }]] = await pool.query('SELECT COUNT(*) AS users FROM users');
    const [[{ employees }]] = await pool.query('SELECT COUNT(*) AS employees FROM employees');
    res.render('index', { title: 'Dashboard', users, employees });
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.render('index', { title: 'Dashboard', users: 0, employees: 0 });
  }
});

module.exports = router;