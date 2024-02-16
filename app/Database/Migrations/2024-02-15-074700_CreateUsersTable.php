<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'              => 'INT',
                'constraint'        => 15,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'name'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100
            ],
            'email'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100
            ],
            'password'    => [
                'type'              => 'VARCHAR',
                'constraint'        => 100
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
