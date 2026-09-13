<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTargetPendapatanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tahun_anggaran_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => true,
            ],
            'skpd_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'sub_rincian_objek_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'target_murni' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'default'    => '0.00',
            ],
            'target_pergeseran' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'default'    => '0.00',
            ],
            'target_perubahan' => [
                'type'       => 'DECIMAL',
                'constraint' => '18,2',
                'default'    => '0.00',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tahun_anggaran_id', 'tahun_anggaran', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('skpd_id', 'master_skpd', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sub_rincian_objek_id', 'master_sub_rincian_objek', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('target_pendapatan', true);
    }

    public function down()
    {
        $this->forge->dropTable('target_pendapatan', true);
    }
}
