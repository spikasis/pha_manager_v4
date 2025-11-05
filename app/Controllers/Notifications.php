<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Notifications extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Ειδοποιήσεις - PHA Manager v4',
            'page_title' => 'Ειδοποιήσεις Συστήματος',
            'page_description' => 'Προβολή και διαχείριση ειδοποιήσεων',
            'breadcrumbs' => ['Ειδοποιήσεις'],
            'notifications' => [
                [
                    'id' => 1,
                    'type' => 'warning',
                    'title' => 'Χαμηλά Αποθέματα',
                    'message' => 'Υπάρχουν προϊόντα με χαμηλό απόθεμα',
                    'link' => 'stocks/low-stock',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                    'read' => false
                ],
                [
                    'id' => 2,
                    'type' => 'info',
                    'title' => 'Νέος Πελάτης',
                    'message' => 'Εγγράφηκε νέος πελάτης στο σύστημα',
                    'link' => 'customers',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                    'read' => true
                ],
                [
                    'id' => 3,
                    'type' => 'success',
                    'title' => 'Backup Completed',
                    'message' => 'Το αντίγραφο ασφαλείας ολοκληρώθηκε επιτυχώς',
                    'link' => 'settings/backup',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                    'read' => true
                ]
            ]
        ];

        return view('layouts/main', $data, ['content' => view('notifications/index', $data)]);
    }

    public function markRead($id)
    {
        // In a real system, this would update the database
        session()->setFlashdata('success', 'Η ειδοποίηση σημειώθηκε ως διαβασμένη.');
        return redirect()->to('notifications');
    }
}