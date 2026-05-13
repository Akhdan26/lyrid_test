<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db    = \Config\Database::connect();
        $users = $db->table('users')->countAllResults();
        $employees = $db->table('employees')->countAllResults();

        return view('layouts/header', ['title' => 'Dashboard'])
            . view('layouts/sidebar')
            . view('layouts/navbar')
            . view('dashboard', ['users' => $users, 'employees' => $employees])
            . view('layouts/footer');
    }
}