<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class UserGroup
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class UserGroup extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addField(
            [
                'userSId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ],
                'groupSId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ]
            ]
        );
        $this->forge->addKey(['userSId', 'groupSId'], true);
        $this->forge->addForeignKey('userSId', 'user', 'sId', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('groupSId', 'group', 'sId', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_group');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('user_group');
    }
}
