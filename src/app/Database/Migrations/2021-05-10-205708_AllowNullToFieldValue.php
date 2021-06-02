<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AllowNullToFieldValue
 *
 * @package App\Database\Migrations
 */
class AllowNullToFieldValue extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->modifyColumn(
            'project_ticket_field_values',
            [
                'value' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]
        );
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->modifyColumn(
            'project_ticket_field_values',
            [
                'value' => [
                    'type' => 'TEXT',
                    'null' => false,
                ],
            ]
        );
    }
}
