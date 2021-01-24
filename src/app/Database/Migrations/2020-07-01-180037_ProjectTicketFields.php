<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class ProjectTicketFields
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class ProjectTicketFields extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addField(
            [
                'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'auto_increment' => true
                ],
                'projectId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ],
                'type' => [
                    'type' => 'ENUM',
                    'constraint' => [
                        'text',
                        'number',
                        'type',
                        'status',
                        'user',
                        'textarea'
                    ],
                ],
                'identification' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'description' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'required' => [
                    'type' => 'INT',
                    'constraint' => 1,
                    'default' => 0
                ],
                'systemField' => [
                    'type' => 'INT',
                    'constraint' => 1,
                    'default' => 0
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
        $this->forge->addForeignKey(
            'projectId',
            'projects',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->createTable('project_ticket_fields');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('project_ticket_fields');
    }
}
