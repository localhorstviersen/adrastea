<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class ProjectTicketFieldValues
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class ProjectTicketFieldValues extends Migration
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
                'ticketId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ],
                'fieldId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ],
                'value' => [
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
        $this->forge->addForeignKey(
            'projectId',
            'projects',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->addForeignKey(
            'ticketId',
            'project_tickets',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->addForeignKey(
            'fieldId',
            'project_ticket_fields',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->forge->createTable('project_ticket_field_values');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('project_ticket_field_values');
    }
}
