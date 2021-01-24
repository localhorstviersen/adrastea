<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Groups
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class Groups extends Migration
{
    /** @inheritDoc */
    public function up(): void
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

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('group');
    }
}
