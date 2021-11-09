<?php

declare(strict_types = 1);

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Class UserDeactivatedAt
 *
 * @package App\Database\Migrations
 */
class UserDeactivatedAt extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn(
            'user',
            [
                'deactivatedAt' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]
        );
    }

    public function down(): void
    {
        $this->forge->dropColumn('user', 'deactivatedAt');
    }
}
