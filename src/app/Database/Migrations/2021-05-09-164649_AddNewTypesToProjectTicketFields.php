<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddNewTypesToProjectTicketFields
 *
 * @package App\Database\Migrations
 */
class AddNewTypesToProjectTicketFields extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->modifyColumn(
            'project_ticket_fields',
            [
                'type' => [
                    'type' => 'ENUM',
                    'constraint' => [
                        'text',
                        'number',
                        'type',
                        'status',
                        'user',
                        'textarea',
                        'radioBox',
                        'checkBox',
                        'predefinedLink',
                    ],
                ],
            ]
        );
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->modifyColumn(
            'project_ticket_fields',
            [
                'type' => [
                    'type' => 'ENUM',
                    'constraint' => [
                        'text',
                        'number',
                        'type',
                        'status',
                        'user',
                        'textarea',
                    ],
                ],
            ]
        );
    }
}
