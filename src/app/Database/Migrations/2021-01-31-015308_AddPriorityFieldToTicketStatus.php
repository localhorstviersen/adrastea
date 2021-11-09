<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class AddPriorityFieldToTicketStatus
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class AddPriorityFieldToTicketStatus extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addColumn(
            'project_ticket_status',
            [
                'priority' => [
                    'type' => 'INT',
                    'constraint' => 5
                ]
            ]
        );
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropColumn('project_ticket_status', 'priority');
    }
}
