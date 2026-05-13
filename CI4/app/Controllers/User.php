<?php

namespace App\Controllers;

class User extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $builder = $this->db->table('users');

        if ($search !== '') {
            $builder->groupStart()->like('name', $search)->orLike('username', $search)->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen User',
            'users'   => $builder->orderBy('id', 'DESC')->get()->getResultArray(),
            'search'  => $search,
            'success' => $this->request->getGet('success'),
            'error'   => $this->request->getGet('error'),
        ];

        return view('layouts/header', $data)
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('users/index', $data)
            . view('layouts/footer');
    }

    public function create()
    {
        return view('layouts/header', ['title' => 'Tambah User'])
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('users/create')
            . view('layouts/footer');
    }

    public function store()
    {
        $name     = trim($this->request->getPost('name'));
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        if ($name === '' || $username === '' || $password === '' || $role === '') {
            return redirect()->to('/users/create')->with('error', 'Semua field wajib diisi.');
        }

        $exist = $this->db->query("SELECT id FROM users WHERE username = ?", [$username])->getRowArray();
        if ($exist) {
            return redirect()->to('/users/create')->with('error', 'Username sudah digunakan.');
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $this->db->query("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)", [$name, $username, $hashed, $role]);

        return redirect()->to('/users?success=1');
    }

    public function edit($id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id = ?", [$id])->getRowArray();
        if (!$user) return redirect()->to('/users');

        return view('layouts/header', ['title' => 'Edit User'])
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('users/edit', ['user' => $user])
            . view('layouts/footer');
    }

    public function update($id)
    {
        $name     = trim($this->request->getPost('name'));
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        if ($name === '' || $username === '' || $role === '') {
            return redirect()->to("/users/edit/$id")->with('error', 'Field wajib diisi.');
        }

        // cek username exist kecuali dirinya
        $exist = $this->db->query("SELECT id FROM users WHERE username = ? AND id != ?", [$username, $id])->getRowArray();
        if ($exist) {
            return redirect()->to("/users/edit/$id")->with('error', 'Username sudah digunakan.');
        }

        if ($password !== '') {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $this->db->query("UPDATE users SET name=?, username=?, password=?, role=? WHERE id=?", [$name, $username, $hashed, $role, $id]);
        } else {
            $this->db->query("UPDATE users SET name=?, username=?, role=? WHERE id=?", [$name, $username, $role, $id]);
        }

        // update session jika yg edit dirinya sendiri
        if ($id == session('user')['id']) {
            $sessionData = session('user');
            $sessionData['name'] = $name;
            $sessionData['role'] = $role;
            $sessionData['username'] = $username;
            session()->set('user', $sessionData);
        }

        return redirect()->to('/users?success=2');
    }

    public function delete($id)
    {
        if ($id == session('user')['id']) {
            return redirect()->to('/users?error=self_delete');
        }

        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        return redirect()->to('/users?success=3');
    }
}