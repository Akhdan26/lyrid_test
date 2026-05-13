const express = require('express');
const bcrypt = require('bcryptjs');
const pool = require('../database');
const { requireAuth } = require('../middleware/auth');
const router = express.Router();

router.use(requireAuth);

// List
router.get('/', async (req, res) => {
  try {
    const search = req.query.search || '';
    let query = 'SELECT * FROM users';
    const params = [];
    if (search) {
      query += ' WHERE name LIKE ? OR username LIKE ?';
      params.push(`%${search}%`, `%${search}%`);
    }
    query += ' ORDER BY id DESC';
    const [users] = await pool.query(query, params);
    res.render('users/index', { title: 'Manajemen User', users, search });
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.render('users/index', { title: 'Manajemen User', users: [], search: '' });
  }
});

// Create form
router.get('/create', (req, res) => {
  res.render('users/create', { title: 'Tambah User' });
});

// Store
router.post('/store', async (req, res) => {
  try {
    const { name, username, password, role } = req.body;
    if (!name || !username || !password || !role) {
      req.session.error = 'Semua field wajib diisi.';
      return res.redirect('/users/create');
    }
    const [exist] = await pool.query('SELECT id FROM users WHERE username = ?', [username]);
    if (exist.length) {
      req.session.error = 'Username sudah digunakan.';
      return res.redirect('/users/create');
    }
    const hash = bcrypt.hashSync(password, 10);
    await pool.query('INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)', [name, username, hash, role]);
    req.session.success = 'User berhasil ditambahkan.';
    res.redirect('/users');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/users/create');
  }
});

// Edit form
router.get('/edit/:id', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM users WHERE id = ?', [req.params.id]);
    if (!rows.length) return res.redirect('/users');
    res.render('users/edit', { title: 'Edit User', user: rows[0] });
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/users');
  }
});

// Update
router.post('/update/:id', async (req, res) => {
  try {
    const { id } = req.params;
    const { name, username, password, role } = req.body;
    if (!name || !username || !role) {
      req.session.error = 'Field wajib diisi.';
      return res.redirect(`/users/edit/${id}`);
    }
    const [exist] = await pool.query('SELECT id FROM users WHERE username = ? AND id != ?', [username, id]);
    if (exist.length) {
      req.session.error = 'Username sudah digunakan.';
      return res.redirect(`/users/edit/${id}`);
    }
    if (password) {
      const hash = bcrypt.hashSync(password, 10);
      await pool.query('UPDATE users SET name=?, username=?, password=?, role=? WHERE id=?', [name, username, hash, role, id]);
    } else {
      await pool.query('UPDATE users SET name=?, username=?, role=? WHERE id=?', [name, username, role, id]);
    }
    // Update session if self
    if (req.session.user && req.session.user.id == id) {
      req.session.user.name = name;
      req.session.user.username = username;
      req.session.user.role = role;
    }
    req.session.success = 'User berhasil diupdate.';
    res.redirect('/users');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect(`/users/edit/${req.params.id}`);
  }
});

// Delete
router.get('/delete/:id', async (req, res) => {
  try {
    const { id } = req.params;
    if (req.session.user && req.session.user.id == id) {
      req.session.error = 'Tidak bisa menghapus diri sendiri.';
      return res.redirect('/users');
    }
    await pool.query('DELETE FROM users WHERE id = ?', [id]);
    req.session.success = 'User berhasil dihapus.';
    res.redirect('/users');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/users');
  }
});

module.exports = router;