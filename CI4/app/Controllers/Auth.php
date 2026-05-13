<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('layouts/header', ['title' => 'Login'])
            . view('auth/login')
            . view('layouts/footer');
    }

    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $db  = \Config\Database::connect();
        $row = $db->query("SELECT * FROM users WHERE username = ?", [$username])->getRowArray();

        if ($row && password_verify($password, $row['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'user'       => [
                    'id'       => $row['id'],
                    'name'     => $row['name'],
                    'username' => $row['username'],
                    'role'     => $row['role'],
                ],
            ]);
            return redirect()->to('/');
        }

        return redirect()->to('/login')->with('error', 'Username atau password salah.');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('layouts/header', ['title' => 'Register'])
            . view('auth/register')
            . view('layouts/footer');
    }

    public function processRegister()
    {
        $name     = trim($this->request->getPost('name'));
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        if ($name === '' || $username === '' || $password === '') {
            return redirect()->to('/register')->with('error', 'Semua field wajib diisi.');
        }

        $db    = \Config\Database::connect();
        $exist = $db->query("SELECT id FROM users WHERE username = ?", [$username])->getRowArray();
        if ($exist) {
            return redirect()->to('/register')->with('error', 'Username sudah digunakan.');
        }

        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $db->query("INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, 'user')", [$name, $username, $hashed]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}