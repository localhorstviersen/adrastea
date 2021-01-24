<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class TicketTypes
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class ProjectTicketTypes extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->createTableTicketTypes();
    }

    private function createTableTicketTypes(): void
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
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
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
        $this->forge->createTable('project_ticket_types');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('project_ticket_types');
    }
}
