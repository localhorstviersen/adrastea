<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddTypeIdToProjectTicketFields
 *
 * @package App\Database\Migrations
 */
class AddTicketFieldTypeRelationTable extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addField(
            [
                'fieldId' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'after' => 'type',
                ],
                'typeId' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'after' => 'type',
                ],
            ]
        );
        $this->forge->addPrimaryKey(['fieldId', 'typeId']);
        $this->forge->addForeignKey('fieldId', 'project_ticket_fields', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('typeId', 'project_ticket_types', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_ticket_field_type_relation');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('project_ticket_field_type_relation');
    }
}
