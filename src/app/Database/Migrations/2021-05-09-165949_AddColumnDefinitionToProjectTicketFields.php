<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddColumnDefinitionToProjectTicketFields
 *
 * @package App\Database\Migrations
 */
class AddColumnDefinitionToProjectTicketFields extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addColumn(
            'project_ticket_fields',
            [
                'definition' => [
                    'type' => 'TEXT',
                    'after' => 'description',
                ],
            ]
        );
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropColumn('project_ticket_fields', 'definition');
    }
}
