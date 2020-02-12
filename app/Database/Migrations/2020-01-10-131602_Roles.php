<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Roles
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class Roles extends Migration
{
    public function up(): void
    {
        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'auto_increment' => true
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100
                ],
                'created_at' => [
                    'type' => 'DATETIME'
                ],
                'updated_at' => [
                    'type' => 'DATETIME'
                ]
            ]
        );
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('roles');

        $this->forge->addField(
            [
                'groupSId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ],
                'roleId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ]
            ]
        );
        $this->forge->addKey(['groupSId', 'roleId'], true);
        $this->forge->addForeignKey('groupSId', 'group', 'sId', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('roleId', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('group_roles');

        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'roleId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ],
                'right' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ]
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('roleId', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('roles_rights');
    }

    public function down(): void
    {
        $this->forge->dropTable('roles');
        $this->forge->dropTable('user_roles');
        $this->forge->dropTable('group_roles');
        $this->forge->dropTable('roles_rights');
    }
}
