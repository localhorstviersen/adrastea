<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Groups extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'sId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ],
                'created_at' => [
                    'type' => 'DATETIME'
                ],
                'updated_at' => [
                    'type' => 'DATETIME'
                ]
            ]
        );
        $this->forge->addKey('sId', true);
        $this->forge->createTable('group');
    }

    public function down()
    {
        $this->forge->dropTable('group');
    }
}
