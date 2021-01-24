<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class Tickets
 *
 * @package App\Database\Migrations
 * @author  Lars Riße <me@elyday.net>
 */
class Tickets extends Migration
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
                'projectId' => [
                    'type' => 'INT',
                    'constraint' => 5
                ],
                'userSId' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100',
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
        $this->forge->addForeignKey('projectId', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('userSId', 'user', 'sId', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');

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
                    'constraint' => ['textField', 'textArea', 'userField'],
                ],
                'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255
                ],
                'description' => [
                    'type' => 'TEXT'
                ],
                'systemField' => [
                    'type' => 'BOOL'
                ]
            ]
        );
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('projectId', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticket_fields');

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
                ]
            ]
        );
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('projectId', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ticketId', 'tickets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fieldId', 'ticket_fields', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ticket_entries');
    }

    public function down(): void
    {
        $this->forge->dropTable('tickets');
        $this->forge->dropTable('ticket_fields');
        $this->forge->dropTable('ticket_entries');
    }
}
