<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthTables extends Migration
{
    public function up()
    {
        // Users table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 254,
                'unique' => true,
            ],
            'activation_selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'activation_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'forgotten_password_selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'forgotten_password_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'forgotten_password_time' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'remember_selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'remember_code' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_on' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'last_login' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => true,
                'default' => 0,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'company' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');

        // Groups table
        $this->forge->addField([
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('groups');

        // Users Groups table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'group_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => 8,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users_groups');

        // Login Attempts table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
            ],
            'login' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'time' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('login_attempts');

        // Insert default data
        $this->insertDefaultData();
    }

    public function down()
    {
        $this->forge->dropTable('login_attempts', true);
        $this->forge->dropTable('users_groups', true);
        $this->forge->dropTable('groups', true);
        $this->forge->dropTable('users', true);
    }

    private function insertDefaultData()
    {
        // Insert default groups
        $groups = [
            [
                'name' => 'admin',
                'description' => 'Administrator'
            ],
            [
                'name' => 'members',
                'description' => 'General User'
            ],
            [
                'name' => 'manager',
                'description' => 'Manager'
            ]
        ];

        foreach ($groups as $group) {
            $this->db->table('groups')->insert($group);
        }

        // Insert default admin user
        $adminData = [
            'ip_address' => '127.0.0.1',
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'email' => 'admin@phamanager.gr',
            'created_on' => time(),
            'active' => 1,
            'first_name' => 'Administrator',
            'last_name' => 'User',
            'company' => 'PHA Manager',
            'phone' => '2101234567'
        ];

        $adminUserId = $this->db->table('users')->insert($adminData);

        // Add admin user to admin group
        $adminGroupId = $this->db->table('groups')->where('name', 'admin')->get()->getRow()->id;

        $this->db->table('users_groups')->insert([
            'user_id' => $adminUserId,
            'group_id' => $adminGroupId
        ]);

        // Insert demo manager user
        $managerData = [
            'ip_address' => '127.0.0.1',
            'username' => 'manager',
            'password' => password_hash('manager123', PASSWORD_DEFAULT),
            'email' => 'manager@phamanager.gr',
            'created_on' => time(),
            'active' => 1,
            'first_name' => 'Διευθυντής',
            'last_name' => 'Χρήστης',
            'company' => 'PHA Manager',
            'phone' => '2101234568'
        ];

        $managerUserId = $this->db->table('users')->insert($managerData);

        // Add manager user to manager group
        $managerGroupId = $this->db->table('groups')->where('name', 'manager')->get()->getRow()->id;

        $this->db->table('users_groups')->insert([
            'user_id' => $managerUserId,
            'group_id' => $managerGroupId
        ]);
    }
}