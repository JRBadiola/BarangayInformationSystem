<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeds the initial Secretary account (super admin).
 * Run once during first-time setup:
 *   php spark db:seed AdminSeeder
 *
 * Default credentials:
 *   username : secretary_admin
 *   password : ChangeMe@2024
 *
 * The secretary logs in first, then creates the Captain and Treasurer accounts
 * via /secretary/create-account. Change the password immediately after first login.
 */
class AdminSeeder extends Seeder
{
    public function run()
    {
        // Skip if already seeded
        if ($this->db->table('users')->where('username', 'secretary_admin')->countAllResults() > 0) {
            return;
        }

        $this->db->table('users')->insert([
            'last_name'      => 'Secretary',
            'first_name'     => 'Barangay',
            'middle_name'    => null,
            'email'          => 'secretary@barangay.gov.ph',
            'username'       => 'secretary_admin',
            'password'       => password_hash('ChangeMe@2024', PASSWORD_BCRYPT),
            'role'           => 'secretary',
            'status'         => 'active',
            'email_verified' => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }
}
