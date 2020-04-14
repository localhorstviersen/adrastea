<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Project
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class Project extends Migration
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
                'description' => [
                    'type' => 'TEXT'
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
        $this->forge->createTable('projects');

        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'projectId' => [
                    'type' => 'INT',
                    'constraint' => 5
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('projectId', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('roleId', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_role_rights');
    }

    public function down(): void
    {
        $this->forge->dropTable('project_role_rights');
        $this->forge->dropTable('projects');
    }
}
