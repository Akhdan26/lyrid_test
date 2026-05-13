const express = require('express');
const multer = require('multer');
const path = require('path');
const fs = require('fs');
const pool = require('../database');
const { requireAuth } = require('../middleware/auth');
const router = express.Router();

router.use(requireAuth);

// Multer config
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    const dir = path.join(__dirname, '..', 'public', 'uploads');
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    cb(null, dir);
  },
  filename: (req, file, cb) => {
    cb(null, Date.now() + '_' + Math.round(Math.random() * 1e9) + path.extname(file.originalname));
  },
});

const fileFilter = (req, file, cb) => {
  const allowed = ['image/jpeg', 'image/jpg'];
  if (allowed.includes(file.mimetype)) {
    cb(null, true);
  } else {
    cb(new Error('Format harus JPG/JPEG.'), false);
  }
};

const upload = multer({
  storage,
  fileFilter,
  limits: { fileSize: 300 * 1024 },
});

// List
router.get('/', async (req, res) => {
  try {
    const search = req.query.search || '';
    let query = 'SELECT * FROM employees';
    const params = [];
    if (search) {
      query += ' WHERE name LIKE ? OR email LIKE ?';
      params.push(`%${search}%`, `%${search}%`);
    }
    query += ' ORDER BY id DESC';
    const [employees] = await pool.query(query, params);
    res.render('employees/index', { title: 'Manajemen Pegawai', employees, search });
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.render('employees/index', { title: 'Manajemen Pegawai', employees: [], search: '' });
  }
});

// Create form
router.get('/create', (req, res) => {
  res.render('employees/create', { title: 'Tambah Pegawai' });
});

// Store
router.post('/store', (req, res) => {
  upload.single('photo')(req, res, async (err) => {
    if (err instanceof multer.MulterError) {
      if (err.code === 'LIMIT_FILE_SIZE') {
        req.session.error = 'Ukuran file terlalu besar (maks 300KB).';
      } else {
        req.session.error = 'Error upload: ' + err.message;
      }
      return res.redirect('/employees/create');
    } else if (err) {
      req.session.error = err.message;
      return res.redirect('/employees/create');
    }

    try {
      const { name, email, phone, address } = req.body;
      if (!name || !email || !phone) {
        req.session.error = 'Field wajib diisi.';
        return res.redirect('/employees/create');
      }
      const photoName = req.file ? req.file.filename : '';
      await pool.query('INSERT INTO employees (name, email, phone, address, photo) VALUES (?, ?, ?, ?, ?)', [name, email, phone, address, photoName]);
      req.session.success = 'Pegawai berhasil ditambahkan.';
      res.redirect('/employees');
    } catch (err2) {
      req.session.error = 'Error: ' + err2.message;
      res.redirect('/employees/create');
    }
  });
});

// Edit form
router.get('/edit/:id', async (req, res) => {
  try {
    const [rows] = await pool.query('SELECT * FROM employees WHERE id = ?', [req.params.id]);
    if (!rows.length) return res.redirect('/employees');
    res.render('employees/edit', { title: 'Edit Pegawai', employee: rows[0] });
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/employees');
  }
});

// Update
router.post('/update/:id', (req, res) => {
  upload.single('photo')(req, res, async (err) => {
    if (err instanceof multer.MulterError) {
      if (err.code === 'LIMIT_FILE_SIZE') {
        req.session.error = 'Ukuran file terlalu besar (maks 300KB).';
      } else {
        req.session.error = 'Error upload: ' + err.message;
      }
      return res.redirect(`/employees/edit/${req.params.id}`);
    } else if (err) {
      req.session.error = err.message;
      return res.redirect(`/employees/edit/${req.params.id}`);
    }

    try {
      const { id } = req.params;
      const { name, email, phone, address } = req.body;
      if (!name || !email || !phone) {
        req.session.error = 'Field wajib diisi.';
        return res.redirect(`/employees/edit/${id}`);
      }

      const [oldRows] = await pool.query('SELECT photo FROM employees WHERE id = ?', [id]);
      let photoName = oldRows.length ? oldRows[0].photo : '';

      if (req.file) {
        // Delete old photo
        if (photoName) {
          const oldPath = path.join(__dirname, '..', 'public', 'uploads', photoName);
          if (fs.existsSync(oldPath)) fs.unlinkSync(oldPath);
        }
        photoName = req.file.filename;
      }

      await pool.query('UPDATE employees SET name=?, email=?, phone=?, address=?, photo=? WHERE id=?', [name, email, phone, address, photoName, id]);
      req.session.success = 'Pegawai berhasil diupdate.';
      res.redirect('/employees');
    } catch (err2) {
      req.session.error = 'Error: ' + err2.message;
      res.redirect(`/employees/edit/${req.params.id}`);
    }
  });
});

// Delete
router.get('/delete/:id', async (req, res) => {
  try {
    const { id } = req.params;
    const [rows] = await pool.query('SELECT photo FROM employees WHERE id = ?', [id]);
    if (rows.length && rows[0].photo) {
      const filePath = path.join(__dirname, '..', 'public', 'uploads', rows[0].photo);
      if (fs.existsSync(filePath)) fs.unlinkSync(filePath);
    }
    await pool.query('DELETE FROM employees WHERE id = ?', [id]);
    req.session.success = 'Pegawai berhasil dihapus.';
    res.redirect('/employees');
  } catch (err) {
    req.session.error = 'Error: ' + err.message;
    res.redirect('/employees');
  }
});

module.exports = router;