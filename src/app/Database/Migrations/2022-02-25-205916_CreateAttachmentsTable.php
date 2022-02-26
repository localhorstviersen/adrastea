<?php

namespace App\Database\Migrations;

use App\Models\Attachment;
use CodeIgniter\Database\Migration;

/**
 * Class CreateAttachmentsTable
 *
 * @package App\Database\Migrations
 */
class CreateAttachmentsTable extends Migration
{
    /** @inheritDoc */
    public function up(): void
    {
        $this->forge->addField(
            [
                'id' => ['type' => 'INT', 'constraint' => 5, 'auto_increment' => true],
                'referenceType' => ['type' => 'ENUM', 'constraint' => [Attachment::REFERENCE_TYPE_TICKET]],
                'referenceId' => ['type' => 'VARCHAR', 'constraint' => 20],
                'fileName' => ['type' => 'TEXT'],
                'path' => ['type' => 'TEXT'],
                'uploadedBy' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
                'created_at' => ['type' => 'DATETIME'],
                'updated_at' => ['type' => 'DATETIME'],
            ]
        );
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('uploadedBy', 'user', 'sId', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attachments');
    }

    /** @inheritDoc */
    public function down(): void
    {
        $this->forge->dropTable('attachments');
    }
}
