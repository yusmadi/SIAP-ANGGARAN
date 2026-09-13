<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterRekeningDetailTables extends Migration
{
    public function up()
    {
        // 1. master_jenis (Level 3)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kelompok_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'kode_jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'unique'     => true,
            ],
            'nama_jenis' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('kelompok_id', 'master_kelompok', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_jenis', true);

        // 2. master_objek (Level 4)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'kode_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '40',
                'unique'     => true,
            ],
            'nama_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('jenis_id', 'master_jenis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_objek', true);

        // 3. master_rincian_objek (Level 5)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'objek_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'kode_rincian_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'nama_rincian_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('objek_id', 'master_objek', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_rincian_objek', true);

        // 4. master_sub_rincian_objek (Level 6)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rincian_objek_id' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'kode_sub_rincian_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '60',
                'unique'     => true,
            ],
            'nama_sub_rincian_objek' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('rincian_objek_id', 'master_rincian_objek', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_sub_rincian_objek', true);
    }

    public function down()
    {
        $this->forge->dropTable('master_sub_rincian_objek', true);
        $this->forge->dropTable('master_rincian_objek', true);
        $this->forge->dropTable('master_objek', true);
        $this->forge->dropTable('master_jenis', true);
    }
}
