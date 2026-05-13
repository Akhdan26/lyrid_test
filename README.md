# Tes Project — CRUD Manajemen User & Pegawai

Dear HR PT Lyrid Prima Indonesia,

Berikut hasil pengerjaan test case untuk tiga aplikasi fullstack CRUD User & Pegawai, saya buat dalam 3 jenis aplikasi yang berbeda:

- **php-native** — PHP Native
- **CI4** — CodeIgniter 4
- **Node.Js** — Express + EJS

Ketiganya menggunakan Bootstrap 5 + Bootstrap Icons untuk tampilan.

---

## Persiapan Database

Pastikan MySQL sudah berjalan, lalu buat database:

```sql
CREATE DATABASE test_lyrid;
USE test_lyrid;
```

Kemudian import kedua tabel berikut (file Schema SQL juga tersedia di folder `php-native/database/`):

```sql
-- users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    username VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- employees
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

> Jika tabel sudah ada di local, lewati langkah ini.

---

## 1. PHP Native

Aplikasi PHP polos tanpa framework, cukup running di web server.

### Setup
1. Buka `php-native/config/database.php`, sesuaikan username/password MySQL jika diperlukan
2. Arahkan web server ke folder `php-native/`, atau bisa menggunakan command `php -S localhost:{port}, ex. 1234`
3. Akses dari browser, contoh: `http://localhost:1234/php-native/auth/login.php`

### Struktur Folder
```
php-native/
├── config/          → koneksi database
├── database/        → file .sql untuk membuat tabel
├── auth/            → login, register, logout
├── users/           → CRUD user (index, create, edit, store, update, delete)
├── employees/       → CRUD pegawai + upload foto (JPG/JPEG, max 300KB)
├── layouts/         → Templating view berisi header, footer, navbar, sidebar
├── middleware/      → pengecekan session (tidak bisa akses tanpa login)
├── uploads/         → tempat menyimpan foto pegawai
└── index.php        → dashboard
```

### Detail Teknis
- Seluruh halaman CRUD membutuhkan login terlebih dahulu
- Upload foto divalidasi: hanya JPG/JPEG, ukuran maksimal 300KB
- Password di-hash menggunakan `password_hash()` (bcrypt)
- Menggunakan `mysqli_` untuk koneksi database

---

## 2. CodeIgniter 4

Aplikasi sudah ada di folder `CI4/`, tinggal dijalankan.

### Setup
1. `cd CI4`
2. Buka `app/Config/Database.php`, atur bagian `development` sesuai koneksi MySQL:
   ```php
   'hostname' => 'localhost',
   'username' => 'root',
   'password' => '',
   'database' => 'test_lyrid',
   ```
3. Jika belum menginstall vendor: `composer install`
4. Jalankan: `php spark serve`
5. Buka `http://localhost:8080`

### Struktur Folder
```
CI4/app/
├── Controllers/Auth.php      → login, register, logout
├── Controllers/Dashboard.php → dashboard + menampilkan total user & pegawai
├── Controllers/User.php      → CRUD user
├── Controllers/Employee.php  → CRUD pegawai + upload foto
├── Filters/Auth.php          → filter untuk proteksi route
├── Config/Routes.php         → seluruh routing aplikasi
└── Views/
    ├── layouts/              → header, footer, navbar, sidebar
    ├── auth/                 → halaman login & register
    ├── users/                → index, create, edit
    ├── employees/            → index, create, edit
    └── dashboard.php
```

### Detail Teknis
- Auth filter berlaku di seluruh route kecuali login dan register
- Upload foto disimpan di `public/uploads/`
- Validasi upload: ukuran maksimal 300KB, hanya format JPG/JPEG
- Saat pegawai dihapus, file foto juga ikut dihapus

---

## 3. Node.js

Aplikasi menggunakan Express + EJS + MySQL2.

### Setup
1. `cd Node.Js`
2. Install dependencies: `npm install` (jika belum)
3. Buka `database.js`, periksa koneksi MySQL:
   ```js
   host: 'localhost',
   user: 'root',
   password: '',
   database: 'test_lyrid',
   ```
4. Jalankan: `npm start` (atau `npm run dev` untuk auto-reload saat development)
5. Buka `http://localhost:3000`

### Struktur Folder
```
Node.Js/
├── server.js            → entry point (Express config + routing)
├── database.js          → pool connection MySQL2
├── middleware/auth.js   → session guard
├── routes/
│   ├── auth.js          → login, register, logout
│   ├── index.js         → dashboard
│   ├── users.js         → CRUD user
│   └── employees.js     → CRUD pegawai + upload (multer)
├── views/
│   ├── layouts/         → head, foot, navbar, sidebar
│   ├── auth/            → login & register
│   ├── users/           → index, create, edit
│   ├── employees/       → index, create, edit
│   ├── index.ejs        → dashboard
│   └── error.ejs        → halaman 404
└── public/uploads/      → tempat menyimpan foto pegawai
```

### Detail Teknis
- Session menggunakan `express-session`
- Upload foto menggunakan `multer`, validasi JPG/JPEG + maksimal 300KB
- Password di-hash menggunakan `bcryptjs`
- User tidak dapat menghapus akunnya sendiri (ada pengecekan)
- Halaman list dilengkapi fitur search sederhana

---

## Hal yang Perlu Diperhatikan

- **Database**: Ketiga aplikasi menggunakan database yang sama (`test_lyrid`), tabel `users` dan `employees`
- **Session**: Masing-masing aplikasi memiliki session sendiri, jadi login di satu aplikasi tidak mempengaruhi aplikasi lain
- **Upload**: Jika upload gagal, pastikan folder `uploads/` sudah ada dan memiliki permission writable
- **PHP Version**: Minimal 7.4 (untuk PHP Native), CI4 membutuhkan 7.4+, Node.js membutuhkan versi 14+
- **User Awal**: Jika belum ada user, lakukan registrasi terlebih dahulu melalui halaman register

---

## Langkah Pengujian

1. **PHP Native**: Buka `http://localhost:1234/php-native/auth/register.php` → daftar → login → uji CRUD
2. **CI4**: Buka `http://localhost:8080/register` → daftar → login → uji CRUD
3. **Node.js**: Buka `http://localhost:3000/register` → daftar → login → uji CRUD