<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTargetPergeseranSetelahPerubahanToTargetPendapatan extends Migration
{
    public function up()
    {
        $fields = [
            'target_pergeseran_setelah_perubahan' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'default'    => '0.00',
                'after'      => 'target_perubahan',
            ],
        ];

        $this->forge->addColumn('target_pendapatan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('target_pendapatan', 'target_pergeseran_setelah_perubahan');
    }
}
