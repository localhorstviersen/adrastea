<?php


namespace App\Database\Migrations;


use CodeIgniter\Database\Migration;

class AddUser extends Migration
{

    /**
     * Perform a migration step.
     */
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'sid' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'surname' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'mail' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
            'updated_at' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user');
    }

    /**
     * Revert a migration step.
     */
    public function down()
    {
        $this->forge->dropTable('user');
    }
}