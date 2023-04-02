<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'first_name' => [
                'type' => 'TEXT'
            ],
            'last_name' => [
                'type' => 'TEXT'
            ],
            'username' => [
                'type' => 'TEXT',
                'unique' => true
            ],
            'email' => [
                'type' => 'TEXT',
                'unique' => true
            ],
            'admin' => [
                'type' => 'BOOL',
                'default' => false
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
