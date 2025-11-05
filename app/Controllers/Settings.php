<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Settings extends BaseController
{
    public function __construct()
    {
        helper(['form']);
    }

    public function general()
    {
        $data = [
            'title' => 'Γενικές Ρυθμίσεις - PHA Manager v4',
            'page_title' => 'Γενικές Ρυθμίσεις',
            'page_description' => 'Διαχείριση γενικών ρυθμίσεων συστήματος',
            'breadcrumbs' => ['Ρυθμίσεις', 'Γενικές Ρυθμίσεις']
        ];

        return view('layouts/main', $data, ['content' => view('settings/general', $data)]);
    }

    public function updateGeneral()
    {
        // Implement settings update logic here
        session()->setFlashdata('success', 'Οι ρυθμίσεις ενημερώθηκαν επιτυχώς.');
        return redirect()->to('settings/general');
    }

    public function security()
    {
        $data = [
            'title' => 'Ρυθμίσεις Ασφαλείας - PHA Manager v4',
            'page_title' => 'Ρυθμίσεις Ασφαλείας',
            'page_description' => 'Διαχείριση ρυθμίσεων ασφαλείας συστήματος',
            'breadcrumbs' => ['Ρυθμίσεις', 'Ασφάλεια']
        ];

        return view('layouts/main', $data, ['content' => view('settings/security', $data)]);
    }

    public function updateSecurity()
    {
        // Implement security settings update logic here
        session()->setFlashdata('success', 'Οι ρυθμίσεις ασφαλείας ενημερώθηκαν επιτυχώς.');
        return redirect()->to('settings/security');
    }

    public function account()
    {
        $data = [
            'title' => 'Ρυθμίσεις Λογαριασμού - PHA Manager v4',
            'page_title' => 'Ρυθμίσεις Λογαριασμού',
            'page_description' => 'Διαχείριση ρυθμίσεων λογαριασμού χρήστη',
            'breadcrumbs' => ['Ρυθμίσεις', 'Λογαριασμός']
        ];

        return view('layouts/main', $data, ['content' => view('settings/account', $data)]);
    }

    public function updateAccount()
    {
        // Implement account settings update logic here
        session()->setFlashdata('success', 'Οι ρυθμίσεις λογαριασμού ενημερώθηκαν επιτυχώς.');
        return redirect()->to('settings/account');
    }

    public function backup()
    {
        $data = [
            'title' => 'Αντίγραφα Ασφαλείας - PHA Manager v4',
            'page_title' => 'Αντίγραφα Ασφαλείας',
            'page_description' => 'Διαχείριση αντιγράφων ασφαλείας συστήματος',
            'breadcrumbs' => ['Ρυθμίσεις', 'Αντίγραφα Ασφαλείας']
        ];

        return view('layouts/main', $data, ['content' => view('settings/backup', $data)]);
    }

    public function createBackup()
    {
        // Implement backup creation logic here
        session()->setFlashdata('success', 'Το αντίγραφο ασφαλείας δημιουργήθηκε επιτυχώς.');
        return redirect()->to('settings/backup');
    }
}