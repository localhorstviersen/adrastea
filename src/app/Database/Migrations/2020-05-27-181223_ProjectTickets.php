<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class TicketStatus
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class ProjectTickets extends Migration
{
    public function up(): void
    {
        $this->createTableTickets();
    }

    public function createTableTickets(): void
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
                'userSId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                    'null' => true
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
            'userSId',
            'user',
            'sId',
            'CASCADE',
            'SET NULL'
        );
        $this->forge->createTable('project_tickets');
    }

    public function down(): void
    {
        $this->forge->dropTable('project_tickets');
    }
}
