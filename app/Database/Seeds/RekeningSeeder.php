<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RekeningSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. Seed Master Akun (Level 1) berdasarkan Kepmen 900.1-861 Tahun 2026 / Permendagri 90
        $akuns = [
            [
                'id'         => 1,
                'kode_akun'  => '1',
                'nama_akun'  => 'ASET',
                'deskripsi'  => 'Sumber daya ekonomi yang dikuasai dan/atau dimiliki oleh pemerintah daerah sebagai akibat dari peristiwa masa lalu dan dari mana manfaat ekonomi dan/atau sosial di masa depan diharapkan dapat diperoleh oleh pemerintah daerah maupun masyarakat, serta dapat diukur dalam satuan uang.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 2,
                'kode_akun'  => '2',
                'nama_akun'  => 'KEWAJIBAN',
                'deskripsi'  => 'Utang yang timbul dari peristiwa masa lalu yang penyelesaiannya mengakibatkan aliran keluar sumber daya ekonomi pemerintah daerah.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 3,
                'kode_akun'  => '3',
                'nama_akun'  => 'EKUITAS',
                'deskripsi'  => 'Kekayaan bersih pemerintah daerah yang merupakan selisih antara aset dan kewajiban pemerintah daerah.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 4,
                'kode_akun'  => '4',
                'nama_akun'  => 'PENDAPATAN DAERAH - LRA',
                'deskripsi'  => 'Semua penerimaan Rekening Kas Umum Daerah yang menambah Saldo Anggaran Lebih dalam periode tahun anggaran yang bersangkutan yang menjadi hak pemerintah daerah, dan tidak perlu dibayar kembali oleh pemerintah daerah.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 5,
                'kode_akun'  => '5',
                'nama_akun'  => 'BELANJA DAERAH',
                'deskripsi'  => 'Semua pengeluaran dari Rekening Kas Umum Daerah yang mengurangi Saldo Anggaran Lebih dalam periode tahun anggaran yang bersangkutan yang tidak akan diperoleh pembayarannya kembali oleh pemerintah daerah.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 6,
                'kode_akun'  => '6',
                'nama_akun'  => 'PEMBIAYAAN DAERAH',
                'deskripsi'  => 'Setiap penerimaan yang perlu dibayar kembali dan/atau pengeluaran yang akan diterima kembali, baik pada tahun anggaran bersangkutan maupun tahun-tahun anggaran berikutnya, yang dalam penganggaran pemerintah daerah terutama dimaksudkan untuk menutup defisit atau memanfaatkan surplus anggaran.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 7,
                'kode_akun'  => '7',
                'nama_akun'  => 'PENDAPATAN DAERAH - LO',
                'deskripsi'  => 'Hak pemerintah daerah yang diakui sebagai penambah ekuitas dalam periode tahun anggaran yang bersangkutan dan tidak perlu dibayar kembali.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id'         => 8,
                'kode_akun'  => '8',
                'nama_akun'  => 'BEBAN DAERAH',
                'deskripsi'  => 'Penurunan manfaat ekonomi atau potensi jasa dalam periode pelaporan yang menurunkan ekuitas, yang dapat berupa pengeluaran atau konsumsi aset atau timbulnya kewajiban.',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($akuns as $akun) {
            $this->db->table('master_akun')->upsert($akun);
        }

        // 2. Seed Master Kelompok (Level 2) berdasarkan Kepmen 900.1-861 Tahun 2026 / Permendagri 90
        $kelompoks = [
            // Akun 1: ASET
            [
                'id'            => 1,
                'akun_id'       => 1,
                'kode_kelompok' => '1.1',
                'nama_kelompok' => 'ASET LANCAR',
                'deskripsi'     => 'Aset yang diharapkan segera untuk direalisasikan, dipakai, atau dijual dalam waktu 12 bulan sejak tanggal pelaporan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 2,
                'akun_id'       => 1,
                'kode_kelompok' => '1.2',
                'nama_kelompok' => 'INVESTASI JANGKA PANJANG',
                'deskripsi'     => 'Investasi yang dimaksudkan untuk dimiliki lebih dari 12 bulan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 3,
                'akun_id'       => 1,
                'kode_kelompok' => '1.3',
                'nama_kelompok' => 'ASET TETAP',
                'deskripsi'     => 'Aset berwujud yang mempunyai masa manfaat lebih dari 12 bulan untuk digunakan dalam kegiatan pemerintah daerah atau dimanfaatkan oleh masyarakat umum.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 4,
                'akun_id'       => 1,
                'kode_kelompok' => '1.4',
                'nama_kelompok' => 'DANA CADANGAN',
                'deskripsi'     => 'Dana yang disisihkan untuk menampung kebutuhan yang memerlukan dana relatif besar yang tidak dapat dipenuhi dalam satu tahun anggaran.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 5,
                'akun_id'       => 1,
                'kode_kelompok' => '1.5',
                'nama_kelompok' => 'ASET LAINNYA',
                'deskripsi'     => 'Aset pemerintah daerah yang tidak dapat dikelompokkan dalam aset lancar, investasi jangka panjang, aset tetap, dan dana cadangan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 2: KEWAJIBAN
            [
                'id'            => 6,
                'akun_id'       => 2,
                'kode_kelompok' => '2.1',
                'nama_kelompok' => 'KEWAJIBAN JANGKA PENDEK',
                'deskripsi'     => 'Kewajiban yang diharapkan dibayar atau jatuh tempo dalam waktu 12 bulan setelah tanggal pelaporan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 7,
                'akun_id'       => 2,
                'kode_kelompok' => '2.2',
                'nama_kelompok' => 'KEWAJIBAN JANGKA PANJANG',
                'deskripsi'     => 'Kewajiban yang diharapkan dibayar atau jatuh tempo lebih dari 12 bulan setelah tanggal pelaporan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 3: EKUITAS
            [
                'id'            => 8,
                'akun_id'       => 3,
                'kode_kelompok' => '3.1',
                'nama_kelompok' => 'EKUITAS',
                'deskripsi'     => 'Kekayaan bersih pemerintah daerah yang merupakan selisih antara aset dan kewajiban pemerintah daerah.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 4: PENDAPATAN DAERAH - LRA
            [
                'id'            => 9,
                'akun_id'       => 4,
                'kode_kelompok' => '4.1',
                'nama_kelompok' => 'PENDAPATAN ASLI DAERAH (PAD) - LRA',
                'deskripsi'     => 'Pendapatan yang diperoleh daerah yang dipungut berdasarkan Peraturan Daerah sesuai dengan peraturan perundang-undangan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 10,
                'akun_id'       => 4,
                'kode_kelompok' => '4.2',
                'nama_kelompok' => 'PENDAPATAN TRANSFER - LRA',
                'deskripsi'     => 'Pendapatan yang berasal dari Pemerintah Pusat, Pemerintah Provinsi, atau Daerah lainnya.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 11,
                'akun_id'       => 4,
                'kode_kelompok' => '4.3',
                'nama_kelompok' => 'LAIN-LAIN PENDAPATAN DAERAH YANG SAH - LRA',
                'deskripsi'     => 'Pendapatan daerah lainnya selain PAD dan Pendapatan Transfer.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 5: BELANJA DAERAH
            [
                'id'            => 12,
                'akun_id'       => 5,
                'kode_kelompok' => '5.1',
                'nama_kelompok' => 'BELANJA OPERASI',
                'deskripsi'     => 'Pengeluaran anggaran untuk kegiatan sehari-hari pemerintah daerah yang memberikan manfaat jangka pendek.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 13,
                'akun_id'       => 5,
                'kode_kelompok' => '5.2',
                'nama_kelompok' => 'BELANJA MODAL',
                'deskripsi'     => 'Pengeluaran anggaran untuk perolehan aset tetap dan aset lainnya yang memberi manfaat lebih dari satu periode akuntansi.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 14,
                'akun_id'       => 5,
                'kode_kelompok' => '5.3',
                'nama_kelompok' => 'BELANJA TIDAK TERDUGA',
                'deskripsi'     => 'Pengeluaran anggaran untuk kegiatan yang bersifat tidak biasa dan tidak diharapkan berulang seperti penanganan bencana alam, bencana sosial, dan pengeluaran tidak terduga lainnya.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 15,
                'akun_id'       => 5,
                'kode_kelompok' => '5.4',
                'nama_kelompok' => 'BELANJA TRANSFER',
                'deskripsi'     => 'Pengeluaran uang dari Pemerintah Daerah kepada Pemerintah Daerah lainnya atau Desa.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 6: PEMBIAYAAN DAERAH
            [
                'id'            => 16,
                'akun_id'       => 6,
                'kode_kelompok' => '6.1',
                'nama_kelompok' => 'PENERIMAAN PEMBIAYAAN',
                'deskripsi'     => 'Semua penerimaan Rekening Kas Umum Daerah antara lain berasal dari SiLPA, pencairan dana cadangan, hasil penjualan kekayaan daerah yang dipisahkan, penerimaan pinjaman daerah, dan penerimaan kembali pemberian pinjaman.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 17,
                'akun_id'       => 6,
                'kode_kelompok' => '6.2',
                'nama_kelompok' => 'PENGELUARAN PEMBIAYAAN',
                'deskripsi'     => 'Semua pengeluaran Rekening Kas Umum Daerah antara lain untuk pembentukan dana cadangan, penyertaan modal pemerintah daerah, pembayaran pokok pinjaman, dan pemberian pinjaman daerah.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 7: PENDAPATAN DAERAH - LO
            [
                'id'            => 18,
                'akun_id'       => 7,
                'kode_kelompok' => '7.1',
                'nama_kelompok' => 'PENDAPATAN ASLI DAERAH (PAD) - LO',
                'deskripsi'     => 'Hak pemerintah daerah yang diakui sebagai penambah ekuitas dari PAD dalam periode tahun anggaran bersangkutan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 19,
                'akun_id'       => 7,
                'kode_kelompok' => '7.2',
                'nama_kelompok' => 'PENDAPATAN TRANSFER - LO',
                'deskripsi'     => 'Hak pemerintah daerah yang diakui sebagai penambah ekuitas dari pendapatan transfer dalam periode tahun anggaran bersangkutan.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 20,
                'akun_id'       => 7,
                'kode_kelompok' => '7.3',
                'nama_kelompok' => 'LAIN-LAIN PENDAPATAN DAERAH YANG SAH - LO',
                'deskripsi'     => 'Hak pemerintah daerah yang diakui sebagai penambah ekuitas dari lain-lain pendapatan daerah yang sah.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],

            // Akun 8: BEBAN DAERAH
            [
                'id'            => 21,
                'akun_id'       => 8,
                'kode_kelompok' => '8.1',
                'nama_kelompok' => 'BEBAN OPERASI',
                'deskripsi'     => 'Penurunan manfaat ekonomi atau potensi jasa dalam periode pelaporan yang menurunkan ekuitas untuk kegiatan operasional sehari-hari.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 22,
                'akun_id'       => 8,
                'kode_kelompok' => '8.2',
                'nama_kelompok' => 'BEBAN TRANSFER',
                'deskripsi'     => 'Penurunan manfaat ekonomi atau potensi jasa dalam periode pelaporan yang menurunkan ekuitas untuk beban transfer.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 23,
                'akun_id'       => 8,
                'kode_kelompok' => '8.3',
                'nama_kelompok' => 'BEBAN TIDAK TERDUGA',
                'deskripsi'     => 'Penurunan manfaat ekonomi atau potensi jasa dalam periode pelaporan yang menurunkan ekuitas untuk kegiatan tidak terduga/bencana.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 24,
                'akun_id'       => 8,
                'kode_kelompok' => '8.4',
                'nama_kelompok' => 'BEBAN LUAR BIASA',
                'deskripsi'     => 'Penurunan manfaat ekonomi atau potensi jasa yang timbul dari kejadian atau transaksi yang berada di luar kendali dan aktivitas normal pemerintah daerah.',
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        foreach ($kelompoks as $kelompok) {
            $this->db->table('master_kelompok')->upsert($kelompok);
        }
    }
}
