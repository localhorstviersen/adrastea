<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class User
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class User extends Migration
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
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ],
                'firstName' => [
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
            ]
        );
        $this->forge->addKey('sId', true);
        $this->forge->createTable('user');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('user');
    }
}
