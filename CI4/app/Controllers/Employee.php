<?php

namespace App\Controllers;

class Employee extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $builder = $this->db->table('employees');

        if ($search !== '') {
            $builder->groupStart()->like('name', $search)->orLike('email', $search)->groupEnd();
        }

        $data = [
            'title'     => 'Manajemen Pegawai',
            'employees' => $builder->orderBy('id', 'DESC')->get()->getResultArray(),
            'search'    => $search,
            'success'   => $this->request->getGet('success'),
            'error'     => $this->request->getGet('error'),
        ];

        return view('layouts/header', $data)
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('employees/index', $data)
            . view('layouts/footer');
    }

    public function create()
    {
        return view('layouts/header', ['title' => 'Tambah Pegawai'])
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('employees/create')
            . view('layouts/footer');
    }

    public function store()
    {
        $name    = trim($this->request->getPost('name'));
        $email   = trim($this->request->getPost('email'));
        $phone   = trim($this->request->getPost('phone'));
        $address = trim($this->request->getPost('address'));

        if ($name === '' || $email === '' || $phone === '') {
            return redirect()->to('/employees/create')->with('error', 'Field wajib diisi.');
        }

        $photoName = '';

        // handle upload
        $file = $this->request->getFile('photo');
        if ($file !== null && $file->isValid() && ! $file->hasMoved()) {
            $maxSize = 300 * 1024;
            $allowed = ['image/jpeg', 'image/jpg'];

            if ($file->getSize() > $maxSize) {
                return redirect()->to('/employees/create')->with('error', 'Ukuran file terlalu besar (maks 300KB).');
            }
            if (! in_array($file->getMimeType(), $allowed)) {
                return redirect()->to('/employees/create')->with('error', 'Format file harus JPG/JPEG.');
            }

            $photoName = time() . '_' . uniqid() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads', $photoName);
        }

        $this->db->query(
            "INSERT INTO employees (name, email, phone, address, photo) VALUES (?, ?, ?, ?, ?)",
            [$name, $email, $phone, $address, $photoName]
        );

        return redirect()->to('/employees?success=1');
    }

    public function edit($id)
    {
        $employee = $this->db->query("SELECT * FROM employees WHERE id = ?", [$id])->getRowArray();
        if (! $employee) {
            return redirect()->to('/employees');
        }

        return view('layouts/header', ['title' => 'Edit Pegawai'])
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('employees/edit', ['employee' => $employee])
            . view('layouts/footer');
    }

    public function update($id)
    {
        $name    = trim($this->request->getPost('name'));
        $email   = trim($this->request->getPost('email'));
        $phone   = trim($this->request->getPost('phone'));
        $address = trim($this->request->getPost('address'));

        if ($name === '' || $email === '' || $phone === '') {
            return redirect()->to("/employees/edit/$id")->with('error', 'Field wajib diisi.');
        }

        // ambil foto existing
        $old = $this->db->query("SELECT photo FROM employees WHERE id = ?", [$id])->getRowArray();
        $photoName = $old['photo'] ?? '';

        // handle upload baru
        $file = $this->request->getFile('photo');
        if ($file !== null && $file->isValid() && ! $file->hasMoved()) {
            $maxSize = 300 * 1024;
            $allowed = ['image/jpeg', 'image/jpg'];

            if ($file->getSize() > $maxSize) {
                return redirect()->to("/employees/edit/$id")->with('error', 'Ukuran file terlalu besar (maks 300KB).');
            }
            if (! in_array($file->getMimeType(), $allowed)) {
                return redirect()->to("/employees/edit/$id")->with('error', 'Format file harus JPG/JPEG.');
            }

            // hapus foto lama
            if ($photoName && file_exists(FCPATH . 'uploads/' . $photoName)) {
                unlink(FCPATH . 'uploads/' . $photoName);
            }

            $photoName = time() . '_' . uniqid() . '.' . $file->getExtension();
            $file->move(FCPATH . 'uploads', $photoName);
        }

        $this->db->query(
            "UPDATE employees SET name=?, email=?, phone=?, address=?, photo=? WHERE id=?",
            [$name, $email, $phone, $address, $photoName, $id]
        );

        return redirect()->to('/employees?success=2');
    }

    public function delete($id)
    {
        $row = $this->db->query("SELECT photo FROM employees WHERE id = ?", [$id])->getRowArray();
        if ($row && $row['photo']) {
            $path = FCPATH . 'uploads/' . $row['photo'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->db->query("DELETE FROM employees WHERE id = ?", [$id]);
        return redirect()->to('/employees?success=3');
    }
}