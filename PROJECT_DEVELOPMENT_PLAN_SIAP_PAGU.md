# DOKUMEN RENCANA PENGEMBANGAN APLIKASI (PROJECT DEVELOPMENT PLAN)
# SIAP-PAGU: SISTEM INFORMASI AKUNTABILITAS PERENCANAAN & PAGU ANGGARAN

**Dokumen Versi:** 1.0.0  
**Klasifikasi:** Dokumen Arsitektur & Perencanaan Teknis Sistem Informasi Keuangan Daerah  
**Target Platform:** Web Application (Responsive Desktop, Tablet & Mobile)  
**Kepatuhan Regulasi:** Permendagri No. 77 Tahun 2020, Permendagri No. 90 Tahun 2019, dan Standar Akuntabilitas Keuangan Pemerintah Daerah  

---

## DAFTAR ISI
1. [Eksekutif Summary & Tujuan Sistem](#1-eksekutif-summary--tujuan-sistem)
2. [Arsitektur & Teknologi yang Disarankan](#2-arsitektur--teknologi-yang-disarankan)
   - 2.1 Arsitektur Sistem (Layered MVC Architecture)
   - 2.2 Komposisi Stack Teknologi
   - 2.3 Standar Keamanan & Proteksi Data Finansial
3. [Struktur Database & Skema Relasional (DDM/DDL)](#3-struktur-database--skema-relasional-ddmddl)
   - 3.1 Diagram Relasi Konseptual (Entity Relationship Context)
   - 3.2 Modul Pengguna & Hak Akses (RBAC)
   - 3.3 Modul Master Rekening & Kebutuhan Penganggaran (ASN, SBU, ASB & APBD)
   - 3.4 Modul Flow Pergeseran & Revisi Anggaran
   - 3.5 Modul Realisasi Anggaran (SP2D) & Sisa Pagu
   - 3.6 Modul Audit Trail & Riwayat Aktivitas
   - 3.7 Skrip DDL MySQL (Production-Ready)
4. [Alur Kerja (Workflow) & Logika Bisnis](#4-alur-kerja-workflow--logika-bisnis)
   - 4.1 Alur Input Data Kebutuhan Penganggaran (Belanja ASN, SBU, dan ASB)
   - 4.2 Alur Multi-Level Approval Pergeseran Anggaran
   - 4.3 Engine Perhitungan Realisasi & Sisa Pagu Real-Time
5. [Rancangan Fitur Utama & Desain Antarmuka (UI/UX)](#5-rancangan-fitur-utama--desain-antarmuka-uiux)
   - 5.1 Struktur Navigasi & Menu Aplikasi
   - 5.2 Rancangan Halaman Kunci
   - 5.3 Contoh Implementasi Kode Inti (Code Snippets)
     - CodeIgniter 4 Controller & Database Transaction
     - Filter RBAC Middleware
     - Komponen Antarmuka Reaktif (Alpine.js + Axios)
     - Visualisasi ApexCharts Dashboard
6. [Roadmap Tahapan Pembangunan (Phased Development)](#6-roadmap-tahapan-pembangunan-phased-development)
   - Matriks Fase & Deliverables (Sprint 1 s/d Sprint 6)
   - Standar Pengujian & Quality Assurance

---

## 1. EKSEKUTIF SUMMARY & TUJUAN SISTEM

Aplikasi **SIAP-PAGU** (*Sistem Informasi Akuntabilitas Perencanaan & Pagu Anggaran*) dikembangkan sebagai instrumen digital kendali anggaran pemerintah daerah / instansi untuk menjembatani disparitas antara fase **Perencanaan Kebutuhan Anggaran**, **Penetapan Pagu (Perda & Perbup APBD)**, **Dinamika Pergeseran Anggaran (Revisi Pagu)**, hingga **Realisasi Penyerapan (SP2D)** secara presisi, akuntabel, dan transparan.

### Sasaran Utama Sistem:
1. **Integritas Anggaran:** Mencegah terjadinya *over-budgeting* atau pengeluaran tanpa dasar pagu resmi (*unauthorized spending*) melalui validasi berlapis dan kunci pagu (*budget locking*).
2. **Fleksibilitas Terkontrol (Pergeseran Anggaran):** Memfasilitasi pergeseran anggaran antar-rincian objek atau antar-sub-kegiatan dengan alur persetujuan bertingkat (*multi-level approval state machine*) sesuai aturan perundang-undangan (Permendagri No. 77/2020).
3. **Akuntabilitas Kebutuhan Belanja Pegawai:** Menyediakan repositori analitik kebutuhan gaji, tunjangan, dan TPP ASN Daerah yang tersinkronisasi dengan pagu belanja pegawai di Lampiran Perbup.
4. **Visibilitas Real-Time:** Memberikan visibilitas langsung kepada pimpinan (Sekda/Bupati/Walikota/Kepala BPKAD) mengenai sisa pagu efektif, realisasi SP2D, dan proyeksi defisit/surplus anggaran per SKPD.

---

## 2. ARSITEKTUR & TEKNOLOGI YANG DISARANKAN

### 2.1 Arsitektur Sistem (Layered Architecture)

SIAP-PAGU mengadopsi pola arsitektur **Clean Layered Architecture** dengan fondasi MVC (*Model-View-Controller*) yang diperkuat dengan *Service-Repository Pattern* pada CodeIgniter 4 untuk memisahkan logika bisnis anggaran dari presentasi antarmuka.

```
+-------------------------------------------------------------------------------+
|                                 CLIENT LAYER                                  |
|         Desktop Browser / Tablet / Mobile (Responsive Presentation)           |
|  [Tabler / AdminLTE 4] + [Bootstrap 5.3 & Tailwind Utilities] + [Alpine.js]   |
+---------------------------------------+---------------------------------------+
                                        | HTTPS / TLS 1.3 (JSON / AJAX / Form)
                                        v
+-------------------------------------------------------------------------------+
|                            SECURITY & GATEWAY LAYER                           |
|       Nginx Web Server -> ModSecurity (WAF) -> Rate Limiting & SSL Offload    |
+---------------------------------------+---------------------------------------+
                                        |
                                        v
+-------------------------------------------------------------------------------+
|                    APPLICATION LAYER (CodeIgniter 4.5+)                       |
|  +-------------------------------------------------------------------------+  |
|  | Middleware Filters: CSRF Protection, AuthCheck, RBAC & Role Permission |  |
|  +-------------------------------------------------------------------------+  |
|  | Controllers: PaguController, PergeseranController, RealisasiController  |  |
|  +-------------------------------------------------------------------------+  |
|  | Business Service Layer: BudgetEngine, ApprovalStateMachine, RealTimePagu|  |
|  +-------------------------------------------------------------------------+  |
|  | Repositories & Models (Data Access & Query Builder)                     |  |
|  +-------------------------------------------------------------------------+  |
+---------------------------------------+---------------------------------------+
                                        | Connection Pool (PDO MySQL / SSL)
                                        v
+-------------------------------------------------------------------------------+
|                             DATA STORAGE LAYER                                |
|   MySQL 8.0 Enterprise / Community (InnoDB Engine, ACID, Decimal Precision)   |
|   - Master Rekening & Pagu APBD                                               |
|   - Pergeseran & Riwayat Approval                                             |
|   - Realisasi SP2D & Potongan Pajak                                           |
|   - Immutable Audit Logs (Partitioned by Fiscal Year)                         |
+-------------------------------------------------------------------------------+
```

### 2.2 Komposisi Stack Teknologi

| Layer / Komponen | Teknologi Terpilih | Justifikasi & Karakteristik Finansial |
| :--- | :--- | :--- |
| **Backend Core** | **PHP 8.2+ & CodeIgniter 4** | Ringan, jejak memori (*memory footprint*) sangat kecil, eksekusi cepat, *zero-configuration deployment* yang kompatibel dengan server PDN/Diskominfo, serta kepatuhan tinggi terhadap PSR. |
| **Database Engine** | **MySQL 8.0+ / MariaDB 10.11 LTS** | Mesin penyimpanan `InnoDB` yang mendukung penuh transaksi ACID, *window functions* untuk kalkulasi kumulatif SP2D, dan tipe `DECIMAL(18,2)` bebas *floating-point rounding error*. |
| **Admin UI Framework** | **Tabler UI / AdminLTE 4** | Mengusung standar UI modern, ramah perangkat retina, komponen tabel data yang rapi untuk tabel rekening akuntansi yang panjang. |
| **Styling Hybrid** | **Bootstrap 5.3 + Tailwind CSS Utilities** | Bootstrap 5.3 menangani grid sistemik dan komponen modal/tabel dasar; utility Tailwind digunakan untuk *micro-styling*, padding fleksibel, badge status dinamis, dan responsivitas cepat. |
| **Reactivity Frontend** | **Alpine.js 3.x** | Menggantikan jQuery yang berbobot berat untuk interaksi reaktif lokal seperti manipulasi baris rincian anggaran dinamis, kalkulasi selisih pagu (*delta*) di browser sebelum submit. |
| **Async Communication** | **Axios & AJAX Engine** | Menangani pengiriman data mutasi anggaran asynchronous, proteksi otomatis header CSRF, dan progress bar upload berkas pendukung (PDF Lampiran SK/DPA). |
| **Data Visualization** | **ApexCharts 3.x** | Rendering SVG interaktif untuk visualisasi serapan anggaran (gauge charts, bar chart pagu vs realisasi, dan drill-down belanja operasi/modal). |
| **Document Export** | **PhpSpreadsheet & Dompdf / wkhtmltopdf** | Kemampuan menghasilkan dokumen tabular matriks F4/Folio Landscape yang presisi sesuai format baku Permendagri. |

### 2.3 Standar Keamanan & Proteksi Data Finansial

Sebagai aplikasi yang mengelola data keuangan pemerintah daerah, SIAP-PAGU wajib menerapkan kontrol keamanan ketat:

1. **CSRF (Cross-Site Request Forgery) Protection:**
   - Mengaktifkan fitur bawaan CI4 CSRF protection berbasis cookie/header (`Config\Security::$csrfProtection = 'session'`).
   - Regenerasi token otomatis pada setiap *state-changing request* via AJAX (mengembalikan header token baru dalam respons JSON).

2. **SQL Injection Prevention:**
   - 100% interaksi database wajib menggunakan **Query Builder** atau **Prepared Statements** dengan *parameter binding*. Dilarang keras melakukan konkatenasi string SQL mentah pada nilai input pengguna.

3. **Data Integrity & Immutability:**
   - Menggunakan mekanisme *Soft Deletes* untuk data anggaran. Riwayat pagu yang telah disahkan **tidak boleh dihapus secara fisik** (*hard delete*).
   - Tipe data numerik finansial menggunakan `DECIMAL(18,2)` untuk mencegah anomali pembulatan mata uang.

4. **Enkripsi Data Sensitif:**
   - NIK ASN, nomor rekening kas daerah, dan kredensial diamankan menggunakan algoritma **AES-256-CTR / GCM** via `CodeIgniter\Encryption\Encryption`.
   - Hashing password menggunakan algoritma **Argon2id** atau **Bcrypt** dengan work factor minimum 12.

5. **Role-Based Access Control (RBAC) & Principle of Least Privilege:**
   - Setiap aksi (Create, Read, Update, Delete, Verify, Approve, Reject) diikat oleh Matrix Permission yang dievaluasi di level Route Filter (Middleware) dan Model Query Scope.

---

## 3. STRUKTUR DATABASE & SKEMA RELASIONAL (DDM/DDL)

### 3.1 Diagram Relasi Konseptual (Entity Relationship Context)

```
[skpd] 1 ------ * [users]
  |
  +-- 1 ------ * [kebutuhan_belanja_asn]
  |
  +-- 1 ------ * [pagu_rekening_belanja]
                   |
                   +-- 1 ------ * [pergeseran_detail] <---- * [pergeseran_header]
                   |                                                |
                   |                                                +-- 1 -- * [pergeseran_approval_log]
                   |
                   +-- 1 ------ * [realisasi_sp2d_detail] <---- * [realisasi_sp2d_header]
```

### 3.2 Modul Pengguna & Hak Akses (RBAC)
Mencakup 5 role utama pemerintahan:
1. **Super Admin / SysAdmin:** Manajemen user, referensi sistem, dan konfigurasi tahun anggaran.
2. **Perencana OPD (Subag Program/Keuangan SKPD):** Input usulan kebutuhan pegawai (ASN), pemantauan batas Standar Biaya Umum (SBU) & Analisis Standar Biaya (ASB), serta pengajuan draft pergeseran anggaran.
3. **Verifikator TAPD (Bappeda & Bidang Anggaran BPKAD):** Pemeriksaan kepatuhan standar harga, konsistensi nomenklatur, dan koreksi rincian pagu.
4. **Pejabat Pengelola Keuangan Daerah (PPKD / PA / Kepala BPKAD):** Otorisator final persetujuan pergeseran pagu anggaran dan pengesahan DPA/DPPA.
5. **Pimpinan Eksekutif (Bupati/Walikota/Sekda):** Akses pemantauan *Read-Only* eksekutif dashboard, ringkasan realisasi, dan peringatan dini deviasi serapan.

### 3.3 Modul Master Rekening & Kebutuhan Penganggaran (ASN, SBU, ASB & APBD)
Mengadopsi hierarki kodifikasi **Permendagri 90/2019**:
- **Urusan -> Bidang Urusan -> Program -> Kegiatan -> Sub Kegiatan**
- **Akun -> Kelompok -> Jenis -> Objek -> Rincian Objek -> Sub Rincian Objek**
- **Kebutuhan Belanja ASN:** Proyeksi analitik Gaji Pokok, Tunjangan Keluarga, TPP (Tambahan Penghasilan Pegawai), BPJS Kesehatan, dan BPJS Ketenagakerjaan.
- **Standar Biaya Umum (SBU):** Batasan tertinggi biaya satuan operasional (honorarium, perjalanan dinas, konsumsi rapat, belanja sewa, dsb.).
- **Analisis Standar Biaya (ASB):** Standarisasi alokasi belanja berbasis beban kerja dan output sub-kegiatan.

### 3.4 Modul Flow Pergeseran & Revisi Anggaran
Mencatat pergeseran pagu antar-rekening (*budget reallocation*) dengan prinsip *Zero-Sum* pada level tertentu (total penambahan pada rekening tujuan harus seimbang dengan pengurangan pada rekening sumber bila pergeseran bersifat internal):
- **Header:** Nomor Pengajuan, Jenis Pergeseran (Perbup/Perda), Alasan, Dokumen Dasar Hukum, Status.
- **Detail:** ID Rekening Asal, ID Rekening Tujuan, Nilai Semula, Nilai Pergeseran (+/-), Nilai Menjadi.
- **Approval Log:** Catatan verifikasi, timestamp, disposisi, dan tanda tangan digital/token persetujuan.

### 3.5 Modul Realisasi Anggaran (SP2D)
Mencatat realisasi belanja berdasarkan Surat Perintah Pencairan Dana (SP2D):
- Nomor SP2D, Tanggal Penerbitan, Jenis Belanja (UP, GU, TU, LS Barang Jasa, LS Pegawai).
- Rincian belanja per Sub Rincian Objek dan pemotongan kewajiban pajak (PPN, PPh 21, PPh 22, PPh 23).
- Kalkulasi otomatis penyerapan pagu dan perhitungan sisa pagu anggaran dinamis.

---

### 3.6 Skrip DDL MySQL (Production-Ready)

Berikut adalah skema tabel inti berstandar enterprise MySQL 8.0 dengan foreign keys, indexing, dan constraint keamanan:

```sql
-- =============================================================================
-- SKEMA BASIS DATA: SIAP_PAGU (Sistem Informasi Akuntabilitas Perencanaan & Pagu)
-- Standar Engine: InnoDB | Charset: utf8mb4 | Collation: utf8mb4_unicode_ci
-- =============================================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS realisasi_sp2d_detail;
DROP TABLE IF EXISTS realisasi_sp2d_header;
DROP TABLE IF EXISTS pergeseran_approval_log;
DROP TABLE IF EXISTS pergeseran_detail;
DROP TABLE IF EXISTS pergeseran_header;
DROP TABLE IF EXISTS pagu_rekening_belanja;
DROP TABLE IF EXISTS sub_kegiatan_skpd;
DROP TABLE IF EXISTS master_rekening_belanja;
DROP TABLE IF EXISTS master_sub_kegiatan;
DROP TABLE IF EXISTS kebutuhan_belanja_asn;
DROP TABLE IF EXISTS master_asn;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS master_roles;
DROP TABLE IF EXISTS master_skpd;
DROP TABLE IF EXISTS tahun_anggaran;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. TABEL TAHUN ANGGARAN & PENGATURAN STATUS
CREATE TABLE tahun_anggaran (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun YEAR NOT NULL UNIQUE,
    status_tahapan ENUM('penyusunan', 'murni', 'pergeseran', 'perubahan', 'pertanggungjawaban', 'tutup_buku') DEFAULT 'penyusunan',
    is_active BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. MASTER SATUAN KERJA PERANGKAT DAERAH (SKPD / OPD)
CREATE TABLE master_skpd (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_skpd VARCHAR(50) NOT NULL UNIQUE,
    nama_skpd VARCHAR(255) NOT NULL,
    nama_kepala VARCHAR(150) NULL,
    nip_kepala VARCHAR(30) NULL,
    pagu_total_murni DECIMAL(18,2) DEFAULT 0.00,
    pagu_total_pergeseran DECIMAL(18,2) DEFAULT 0.00,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_skpd_kode (kode_skpd)
) ENGINE=InnoDB;

-- 3. ROLE MANAGEMENT (RBAC)
CREATE TABLE master_roles (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_code VARCHAR(30) NOT NULL UNIQUE,
    role_name VARCHAR(100) NOT NULL,
    description VARCHAR(255) NULL
) ENGINE=InnoDB;

INSERT INTO master_roles (role_code, role_name, description) VALUES
('superadmin', 'Super Administrator', 'Pengelola penuh infrastruktur & pengguna sistem'),
('perencana', 'Perencana SKPD', 'Penyusun RKA dan pengusul pergeseran pagu SKPD'),
('verifikator', 'Verifikator TAPD / BPKAD', 'Pemeriksa administratif dan regulasi pergeseran pagu'),
('pejabat_keuangan', 'PPKD / Kepala BPKAD', 'Otorisator pengesahan dokumen pergeseran dan pengeluaran'),
('pimpinan', 'Pimpinan Daerah / Eksekutif', 'Akses pemantauan eksekutif ringkasan serapan pagu');

-- 4. TABEL PENGGUNA (USERS)
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id SMALLINT UNSIGNED NOT NULL,
    skpd_id INT UNSIGNED NULL,
    username VARCHAR(60) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(150) NOT NULL,
    nip VARCHAR(30) NULL,
    jabatan VARCHAR(100) NULL,
    phone_number VARCHAR(25) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    last_login_at DATETIME NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES master_roles(id) ON UPDATE CASCADE,
    CONSTRAINT fk_users_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_users_auth (username, is_active)
) ENGINE=InnoDB;

-- 5. MASTER DATA ASN & PROYEKSI KEBUTUHAN BELANJA PEGAWAI
CREATE TABLE master_asn (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    skpd_id INT UNSIGNED NOT NULL,
    nip VARCHAR(30) NOT NULL UNIQUE,
    nama_lengkap VARCHAR(150) NOT NULL,
    status_kepegawaian ENUM('PNS', 'PPPK', 'PPPK_PARUH_WAKTU') NOT NULL,
    golongan_ruang VARCHAR(20) NOT NULL,
    eselon VARCHAR(10) NULL,
    jumlah_tanggungan TINYINT UNSIGNED DEFAULT 0,
    gaji_pokok_bulanan DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    tunjangan_keluarga_bulanan DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    tunjangan_jabatan_bulanan DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    tpp_bulanan DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_asn_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON UPDATE CASCADE,
    INDEX idx_asn_skpd (skpd_id, status_kepegawaian)
) ENGINE=InnoDB;

CREATE TABLE kebutuhan_belanja_asn (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_anggaran_id INT UNSIGNED NOT NULL,
    skpd_id INT UNSIGNED NOT NULL,
    bulan TINYINT UNSIGNED NOT NULL,
    total_gaji_pokok DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    total_tunjangan DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    total_tpp DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    total_iuran_bpjs DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    total_kebutuhan DECIMAL(18,2) GENERATED ALWAYS AS (total_gaji_pokok + total_tunjangan + total_tpp + total_iuran_bpjs) STORED,
    catatan_verifikasi TEXT NULL,
    status_verifikasi ENUM('draft', 'terverifikasi', 'disahkan') DEFAULT 'draft',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_kebutuhan_tahun FOREIGN KEY (tahun_anggaran_id) REFERENCES tahun_anggaran(id) ON UPDATE CASCADE,
    CONSTRAINT fk_kebutuhan_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON UPDATE CASCADE,
    UNIQUE KEY uk_kebutuhan_periode (tahun_anggaran_id, skpd_id, bulan)
) ENGINE=InnoDB;

-- 6. NOMENKLATUR PERMENDAGRI 90 & MASTER PAGU APBD
CREATE TABLE master_sub_kegiatan (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_urusan VARCHAR(10) NOT NULL,
    kode_bidang_urusan VARCHAR(15) NOT NULL,
    kode_program VARCHAR(20) NOT NULL,
    kode_kegiatan VARCHAR(30) NOT NULL,
    kode_sub_kegiatan VARCHAR(50) NOT NULL UNIQUE,
    nomenklatur_sub_kegiatan VARCHAR(255) NOT NULL,
    INDEX idx_kode_subkeg (kode_sub_kegiatan)
) ENGINE=InnoDB;

CREATE TABLE master_rekening_belanja (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_akun VARCHAR(5) NOT NULL,
    kode_kelompok VARCHAR(10) NOT NULL,
    kode_jenis VARCHAR(15) NOT NULL,
    kode_objek VARCHAR(20) NOT NULL,
    kode_rincian_objek VARCHAR(30) NOT NULL,
    kode_sub_rincian_objek VARCHAR(50) NOT NULL UNIQUE,
    nama_sub_rincian_objek VARCHAR(255) NOT NULL,
    INDEX idx_kode_rekening (kode_sub_rincian_objek)
) ENGINE=InnoDB;

-- Pagu Rekening Terperinci (Turunan Lampiran 1 Perda & Perbup)
CREATE TABLE pagu_rekening_belanja (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tahun_anggaran_id INT UNSIGNED NOT NULL,
    skpd_id INT UNSIGNED NOT NULL,
    sub_kegiatan_id INT UNSIGNED NOT NULL,
    rekening_belanja_id INT UNSIGNED NOT NULL,
    pagu_murni DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    pagu_pergeseran DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    pagu_realisasi DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    sisa_pagu DECIMAL(18,2) GENERATED ALWAYS AS (pagu_pergeseran - pagu_realisasi) STORED,
    is_locked BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pagu_tahun FOREIGN KEY (tahun_anggaran_id) REFERENCES tahun_anggaran(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pagu_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pagu_subkeg FOREIGN KEY (sub_kegiatan_id) REFERENCES master_sub_kegiatan(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pagu_rek FOREIGN KEY (rekening_belanja_id) REFERENCES master_rekening_belanja(id) ON UPDATE CASCADE,
    UNIQUE KEY uk_pagu_rekening (tahun_anggaran_id, skpd_id, sub_kegiatan_id, rekening_belanja_id),
    INDEX idx_pagu_filter (tahun_anggaran_id, skpd_id)
) ENGINE=InnoDB;

-- 7. MODUL WORKFLOW PERGESERAN ANGGARAN
CREATE TABLE pergeseran_header (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nomor_tiket VARCHAR(60) NOT NULL UNIQUE,
    tahun_anggaran_id INT UNSIGNED NOT NULL,
    skpd_id INT UNSIGNED NOT NULL,
    tahap_ke TINYINT UNSIGNED NOT NULL DEFAULT 1,
    jenis_pergeseran ENUM('antar_rincian_objek_subkegiatan', 'antar_subkegiatan', 'antar_kegiatan', 'darurat_mendesak') NOT NULL,
    dasar_hukum VARCHAR(255) NOT NULL,
    latar_belakang_alasan TEXT NOT NULL,
    total_nilai_pergeseran DECIMAL(18,2) NOT NULL DEFAULT 0.00,
    status_approval ENUM('draft', 'diajukan', 'verifikasi_tapd', 'revisi', 'disetujui_ppkd', 'ditolak') DEFAULT 'draft',
    current_assigned_role VARCHAR(30) DEFAULT 'perencana',
    dokumen_pendukung_url VARCHAR(255) NULL,
    created_by INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pergeseran_tahun FOREIGN KEY (tahun_anggaran_id) REFERENCES tahun_anggaran(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pergeseran_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON UPDATE CASCADE,
    CONSTRAINT fk_pergeseran_creator FOREIGN KEY (created_by) REFERENCES users(id) ON UPDATE CASCADE,
    INDEX idx_pergeseran_status (status_approval, skpd_id)
) ENGINE=InnoDB;

CREATE TABLE pergeseran_detail (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pergeseran_header_id BIGINT UNSIGNED NOT NULL,
    pagu_rekening_id BIGINT UNSIGNED NOT NULL,
    jenis_mutasi ENUM('berkurang', 'bertambah') NOT NULL,
    nilai_semula DECIMAL(18,2) NOT NULL,
    nilai_pergeseran DECIMAL(18,2) NOT NULL,
    nilai_menjadi DECIMAL(18,2) NOT NULL,
    keterangan_rincian VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_detail_header FOREIGN KEY (pergeseran_header_id) REFERENCES pergeseran_header(id) ON DELETE CASCADE,
    CONSTRAINT fk_detail_pagu FOREIGN KEY (pagu_rekening_id) REFERENCES pagu_rekening_belanja(id) ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pergeseran_approval_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pergeseran_header_id BIGINT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    action_type ENUM('ajukan', 'verifikasi', 'minta_revisi', 'setujui', 'tolak') NOT NULL,
    status_sebelumnya VARCHAR(40) NOT NULL,
    status_sesudahnya VARCHAR(40) NOT NULL,
    catatan_koreksi TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_log_pergeseran FOREIGN KEY (pergeseran_header_id) REFERENCES pergeseran_header(id) ON DELETE CASCADE,
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 8. MODUL REALISASI ANGGARAN (SP2D)
CREATE TABLE realisasi_sp2d_header (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nomor_sp2d VARCHAR(100) NOT NULL UNIQUE,
    nomor_spm VARCHAR(100) NOT NULL,
    tahun_anggaran_id INT UNSIGNED NOT NULL,
    skpd_id INT UNSIGNED NOT NULL,
    tanggal_sp2d DATE NOT NULL,
    jenis_sp2d ENUM('UP', 'GU', 'TU', 'LS_BARANG_JASA', 'LS_GAJI_TUNJANGAN') NOT NULL,
    uraian_keperluan TEXT NOT NULL,
    nama_penerima VARCHAR(150) NOT NULL,
    total_bruto DECIMAL(18,2) NOT NULL,
    total_potongan DECIMAL(18,2) DEFAULT 0.00,
    total_netto DECIMAL(18,2) GENERATED ALWAYS AS (total_bruto - total_potongan) STORED,
    status_cair ENUM('terbit', 'batal') DEFAULT 'terbit',
    created_by INT UNSIGNED NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_sp2d_tahun FOREIGN KEY (tahun_anggaran_id) REFERENCES tahun_anggaran(id) ON UPDATE CASCADE,
    CONSTRAINT fk_sp2d_skpd FOREIGN KEY (skpd_id) REFERENCES master_skpd(id) ON UPDATE CASCADE,
    CONSTRAINT fk_sp2d_creator FOREIGN KEY (created_by) REFERENCES users(id) ON UPDATE CASCADE,
    INDEX idx_sp2d_tanggal (tanggal_sp2d, skpd_id)
) ENGINE=InnoDB;

CREATE TABLE realisasi_sp2d_detail (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sp2d_header_id BIGINT UNSIGNED NOT NULL,
    pagu_rekening_id BIGINT UNSIGNED NOT NULL,
    nilai_realisasi DECIMAL(18,2) NOT NULL,
    nilai_potongan_pajak DECIMAL(18,2) DEFAULT 0.00,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sp2ddet_header FOREIGN KEY (sp2d_header_id) REFERENCES realisasi_sp2d_header(id) ON DELETE CASCADE,
    CONSTRAINT fk_sp2ddet_pagu FOREIGN KEY (pagu_rekening_id) REFERENCES pagu_rekening_belanja(id) ON UPDATE CASCADE
) ENGINE=InnoDB;

-- 9. AUDIT TRAIL / LOG AKTIVITAS SISTEM (IMMUTABLE)
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NULL,
    skpd_id INT UNSIGNED NULL,
    action_event VARCHAR(100) NOT NULL, -- e.g., 'UPDATE_PAGU', 'APPROVE_PERGESERAN'
    table_affected VARCHAR(80) NOT NULL,
    record_id VARCHAR(80) NOT NULL,
    old_values JSON NULL,
    new_values JSON NULL,
    ip_address VARCHAR(45) NOT NULL,
    user_agent TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_audit_user (user_id, action_event),
    INDEX idx_audit_time (created_at)
) ENGINE=InnoDB;
```

---

## 4. ALUR KERJA (WORKFLOW) & LOGIKA BISNIS

### 4.1 Alur Input Data Kebutuhan Penganggaran (Belanja Pegawai ASN, SBU, dan ASB)

Pada SIAP-PAGU, pengelolaan data kebutuhan penganggaran difokuskan pada tiga pilar utama:
1. **Penyusunan Kebutuhan Pegawai (Data ASN & Proyeksi Gaji/TPP):**
   Subag Kepegawaian/Perencana SKPD mengelola profil aparatur daerah (PNS, PPPK, dan PPPK Paruh Waktu) beserta data jumlah tanggungan, golongan, dan jabatan. Sistem secara otomatis menghitung proyeksi kebutuhan belanja pegawai bulanan (Gaji Pokok, Tunjangan Keluarga, Tunjangan Jabatan, TPP, dan Iuran BPJS Kesehatan & Ketenagakerjaan). Proyeksi ini menjadi dasar penguncian pagu Belanja Operasi - Belanja Pegawai pada Lampiran Perbup APBD.
2. **Standar Biaya Umum (SBU):**
   Input dan pengelolaan kamus Standar Biaya Umum (SBU) daerah (antara lain pagu honorarium narasumber/panitia, satuan biaya uang harian & transportasi perjalanan dinas, sewa sarana/gedung, konsumsi rapat, dan belanja operasional kantor lainnya). Modul SBU di SIAP-PAGU bertindak sebagai *budget ceiling* (plafon batas tertinggi biaya satuan belanja) untuk mencegah usulan pembiayaan yang melampaui batas kewajaran regulasi kepala daerah.
3. **Analisis Standar Biaya (ASB):**
   Input dan pengelolaan parameter Analisis Standar Biaya (ASB) untuk aktivitas atau sub-kegiatan fisik maupun non-fisik (misalnya: biaya penyelenggaraan pelatihan per peserta/hari, biaya pemeliharaan berkala per m2 bangunan gedung, atau unit operasional). ASB memastikan bahwa alokasi pagu total untuk setiap sub-kegiatan dinilai kewajarannya secara rasional berdasarkan tolok ukur kinerja (*performance benchmark*) dan rasio beban kerja.

> **Catatan Penyelarasan SIPD Kemendagri:**  
> Tahapan *Kompilasi RKA SKPD* dan *Verifikasi TAPD* ditiadakan pada SIAP-PAGU karena seluruh proses pengusulan RKA dan penelaahan berjenjang oleh TAPD telah terlaksana secara terpusat melalui aplikasi **SIPD (Sistem Informasi Pembangunan Daerah - Kemendagri)**. SIAP-PAGU berfokus menerima dan mengunci pagu hasil penetapan (Lampiran 1 Perda & Perbup APBD), lalu memadukannya dengan analitik data riil kebutuhan ASN, parameter batas SBU, dan indeks ASB guna mengawal integritas pergeseran serta realisasi penyerapan anggaran.

```
[Perencana SKPD]                   [Engine SIAP-PAGU]                   [Database / SIPD APBD]
       |                                   |                                     |
       |--- 1. Kelola Data ASN Daerah ---->|                                     |
       |    & Mutasi Pegawai               |--- Hitung Proyeksi Gaji/TPP ------->|
       |                                   |    (Belanja Pegawai Otomatis)       |
       |--- 2. Sinkronisasi Kamus SBU ---->|                                     |
       |    (Batas Plafon Biaya Tertinggi) |--- Validasi Standar Belanja Operasi |
       |                                   |                                     |
       |--- 3. Analisis Biaya (ASB) ------>|                                     |
       |    (Standar Beban Kerja & Output) |--- Uji Rasionalitas Alokasi Pagu    |
       |                                   |                                     |
       |<-- Monitoring Kepatuhan Plafon <--|                                     |<-- Pagu Murni DPA
       |                                   |--- Sinkronisasi Pagu Definitif ---->|    (Lampiran Perbup)
```

### 4.2 Alur Multi-Level Approval Pergeseran Anggaran (State Machine)

Pergeseran anggaran tunduk pada regulasi ketat Permendagri No. 77/2020:
1. **Drafting (Perencana SKPD):** Menentukan rekening donor (berkurang) dan rekening resipien (bertambah). Total delta harus = 0 (keseimbangan rincian objek).
2. **Kunci Rekening Sementara:** Sistem mengunci sementara (*freeze*) rekening donor sebesar nilai yang dipindahkan agar tidak terpakai oleh pengajuan SP2D lain.
3. **Verifikasi TAPD (Bappeda/BPKAD):** Pemeriksaan alasan urgensi, regulasi (apakah cukup Perubahan Perbup atau harus Perda Perubahan APBD). Memberikan rekomendasi atau catatan perbaikan.
4. **Persetujuan Akhir PPKD (Kepala BPKAD / Sekda):**
   - Jika **Disetujui**: Sistem menjalankan transaksi ACID untuk memperbarui `pagu_pergeseran` pada tabel `pagu_rekening_belanja` dan melepas status kunci.
   - Jika **Ditolak**: Sistem membatalkan mutasi dan memulihkan alokasi pagu donor.

```
       +--------------+
       |    DRAFT     | <----+ (Minta Revisi)
       +-------+------+      |
               | [Ajukan]    |
               v             |
       +--------------+      |
       | DIAJUKAN     |      |
       +-------+------+      |
               |             |
               v             |
       +-------------------+ |
       |  VERIFIKASI TAPD  |-+
       +---------+---------+
                 | [Rekomendasi Setuju]
                 v
       +-------------------+
       | PERSETUJUAN PPKD  |
       +----+---------+----+
            |         |
[Disetujui] |         | [Ditolak]
            v         v
     +-----------+  +-----------+
     | DISETUJUI |  |  DITOLAK  |
     | (Update   |  | (Rollback |
     |  Pagu)    |  |  Lock)    |
     +-----------+  +-----------+
```

### 4.3 Engine Perhitungan Realisasi & Sisa Pagu Real-Time

Formula baku perhitungan integritas pagu pada SIAP-PAGU:

$$\text{Pagu Efektif} = \begin{cases} \text{Pagu Murni}, & \text{jika belum ada pergeseran disetujui} \\ \text{Pagu Pergeseran}, & \text{jika pergeseran telah disahkan} \end{cases}$$

$$\text{Total Realisasi SP2D} = \sum (\text{Nilai Realisasi SP2D Terbit})$$

$$\text{Pagu Terkunci (Pending Shift)} = \sum (\text{Nilai Usulan Pengurangan dalam Proses Review})$$

$$\text{Sisa Pagu Riil} = \text{Pagu Efektif} - \text{Total Realisasi SP2D}$$

$$\text{Sisa Pagu Bebas (Available to Spend)} = \text{Sisa Pagu Riil} - \text{Pagu Terkunci}$$

> **Aturan Bisnis (Business Rule):** Penerbitan SP2D atau pengajuan pergeseran baru akan otomatis **DITOLAK SISTEM (Validation Exception)** jika nilai yang diajukan melampaui $\text{Sisa Pagu Bebas}$.

---

## 5. RANCANGAN FITUR UTAMA & DESAIN ANTARMUKA (UI/UX)

### 5.1 Struktur Navigasi & Menu Aplikasi (Sitemap)

```
SIAP-PAGU
├── 1. Dashboard
│   ├── 1.1 Dashboard Eksekutif (Pimpinan)
│   ├── 1.2 Dashboard Operasional SKPD
│   └── 1.3 Matriks Serapan Anggaran Wilayah
├── 2. Perencanaan & Kebutuhan
│   ├── 2.1 Data Kepegawaian & Kebutuhan Belanja ASN
│   ├── 2.2 Proyeksi Gaji, Tunjangan & TPP Bulanan
│   ├── 2.3 Standar Biaya Umum (SBU) & Batas Belanja Operasional
│   └── 2.4 Analisis Standar Biaya (ASB) & Validasi Kewajaran Alokasi
├── 3. Pengelolaan Pagu APBD
│   ├── 3.1 Pagu Induk (Lampiran 1 Perda & Perbup APBD)
│   ├── 3.2 Breakdown Rekening Belanja per Sub-Kegiatan
│   └── 3.3 Status Kunci Pagu (Locking System)
├── 4. Pergeseran Anggaran
│   ├── 4.1 Pengajuan Pergeseran Baru (Matrix Donor & Resipien)
│   ├── 4.2 Tracking Disposisi & Riwayat Pengajuan
│   ├── 4.3 Meja Verifikasi TAPD (Review & Koreksi)
│   └── 4.4 Otorisasi PPKD (Digital Approval)
├── 5. Realisasi & Penyerapan
│   ├── 5.1 Pencatatan SP2D (UP/GU/TU/LS)
│   ├── 5.2 Buku Kas Pembantu Pagu Sub-Kegiatan
│   └── 5.3 Analisis Deviasi Target vs Realisasi
├── 6. Pelaporan & Ekspor (Executive Reporting)
│   ├── 6.1 Matriks Pergeseran Anggaran (Format F4 Folio Landscape PDF)
│   ├── 6.2 Laporan Realisasi Fisik & Keuangan Bulanan (Excel/PDF)
│   └── 6.3 Rekapitulasi Sisa Pagu per Rekening
├── 7. Administrasi Sistem & Keamanan
│   ├── 7.1 Manajemen User & Hak Akses (RBAC)
│   ├── 7.2 Konfigurasi Tahun Anggaran & Tahapan
│   └── 7.3 Log Audit Aktivitas (Audit Trail)
```

---

### 5.2 Rancangan Halaman Kunci

1. **Executive Summary Dashboard:**
   - Ringkasan KPI: Total Pagu APBD, Total Realisasi SP2D (Rp dan %), Sisa Pagu Bebas, dan Jumlah Tiket Pergeseran Menunggu Review.
   - Grafik Interaktif: Gauge serapan anggaran, bar chart top 5 SKPD serapan tertinggi dan 5 SKPD serapan terendah (ApexCharts).
2. **Interactive Budget Matrix View (Tabel Pagu Permendagri 90):**
   - Menampilkan tabel hierarkis bertingkat yang dapat di-*expand/collapse* dari Program $\rightarrow$ Kegiatan $\rightarrow$ Sub-Kegiatan $\rightarrow$ Kode Rekening.
   - Menampilkan kolom: Pagu Murni, Nilai (+/-) Pergeseran, Pagu Setelah Pergeseran, Realisasi SP2D, dan Sisa Pagu.
3. **Modal Form Pergeseran Reaktif (Alpine.js):**
   - Pilihan dinamis rekening donor dan rekening penerima.
   - Live validator: Menampilkan badge error merah jika total pengurangan $\neq$ total penambahan. Tombol submit dinonaktifkan hingga kondisi seimbang terpenuhi.

---

### 5.3 Contoh Implementasi Kode Inti (Code Snippets)

#### A. CodeIgniter 4 Controller & Transaksi ACID Pergeseran Anggaran
File: `app/Controllers/PergeseranController.php`

```php
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class PergeseranController extends BaseController
{
    /**
     * Memproses persetujuan pergeseran anggaran dengan Transaksi Database ACID
     */
    public function approve($tiketId): ResponseInterface
    {
        $db = Database::connect();
        $userId = session()->get('user_id');
        $userRole = session()->get('role_code');

        if ($userRole !== 'pejabat_keuangan') {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Otorisasi ditolak: Hanya PPKD yang berhak menyetujui pergeseran.'
            ]);
        }

        $header = $db->table('pergeseran_header')->where('id', $tiketId)->get()->getRow();

        if (!$header || $header->status_approval !== 'verifikasi_tapd') {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Status tiket tidak valid untuk disetujui.'
            ]);
        }

        // Mulai Transaksi ACID
        $db->transBegin();

        try {
            // Ambil rincian item pergeseran
            $details = $db->table('pergeseran_detail')
                          ->where('pergeseran_header_id', $tiketId)
                          ->get()->getResult();

            foreach ($details as $item) {
                $pagu = $db->table('pagu_rekening_belanja')
                           ->where('id', $item->pagu_rekening_id)
                           ->get()->getRow();

                if (!$pagu) {
                    throw new \Exception("Data rekening pagu #{$item->pagu_rekening_id} tidak ditemukan.");
                }

                if ($item->jenis_mutasi === 'berkurang') {
                    $paguBaru = (float)$pagu->pagu_pergeseran - (float)$item->nilai_pergeseran;
                    // Proteksi agar pagu tidak lebih kecil dari realisasi SP2D yang sudah terbit
                    if ($paguBaru < (float)$pagu->pagu_realisasi) {
                        throw new \Exception("Pagu rekening tidak dapat dikurangi di bawah nilai realisasi SP2D (Rp " . number_format($pagu->pagu_realisasi, 2) . ").");
                    }
                } else {
                    $paguBaru = (float)$pagu->pagu_pergeseran + (float)$item->nilai_pergeseran;
                }

                // Update nilai pagu pergeseran
                $db->table('pagu_rekening_belanja')
                   ->where('id', $item->pagu_rekening_id)
                   ->update([
                       'pagu_pergeseran' => $paguBaru,
                       'is_locked'       => false,
                       'updated_at'      => date('Y-m-d H:i:s')
                   ]);
            }

            // Update status tiket header
            $db->table('pergeseran_header')->where('id', $tiketId)->update([
                'status_approval'       => 'disetujui_ppkd',
                'current_assigned_role' => 'selesai',
                'updated_at'            => date('Y-m-d H:i:s')
            ]);

            // Catat Log Persetujuan
            $db->table('pergeseran_approval_log')->insert([
                'pergeseran_header_id' => $tiketId,
                'user_id'              => $userId,
                'action_type'          => 'setujui',
                'status_sebelumnya'    => 'verifikasi_tapd',
                'status_sesudahnya'    => 'disetujui_ppkd',
                'catatan_koreksi'      => 'Disetujui dan disahkan secara digital oleh PPKD.',
                'ip_address'           => $this->request->getIPAddress(),
                'user_agent'           => $this->request->getUserAgent()->getAgentString()
            ]);

            if ($db->transStatus() === false) {
                $db->transRollback();
                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 'error',
                    'message' => 'Gagal memproses transaksi pergeseran anggaran.'
                ]);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => "Tiket pergeseran {$header->nomor_tiket} berhasil disahkan. Pagu telah diperbarui."
            ]);

        } catch (\Throwable $e) {
            $db->transRollback();
            return $this->response->setStatusCode(422)->setJSON([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
```

---

#### B. Filter Middleware Hak Akses (RBAC)
File: `app/Filters/RoleAuthFilter.php`

```php
<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // 1. Periksa apakah pengguna telah login
        if (!$session->get('is_logged_in')) {
            return redirect()->to('/auth/login')->with('error', 'Sesi Anda telah berakhir, silakan login kembali.');
        }

        $userRole = $session->get('role_code');

        // 2. Periksa apakah peran pengguna cocok dengan argumen route
        if (!empty($arguments)) {
            if (!in_array($userRole, $arguments, true)) {
                if ($request->isAJAX()) {
                    return service('response')->setStatusCode(403)->setJSON([
                        'status'  => 'forbidden',
                        'message' => 'Anda tidak memiliki hak akses untuk fungsi keuangan ini.'
                    ]);
                }
                return redirect()->to('/dashboard')->with('error', 'Akses Ditolak: Hak akses tidak mencukupi.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}
```

---

#### C. Komponen Form Reaktif Pergeseran Anggaran (Alpine.js + Bootstrap/Tailwind)
File: `app/Views/pergeseran/form_modal.php`

```html
<div x-data="pergeseranForm()" class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Form Usulan Pergeseran Pagu Anggaran (Permendagri 77)</h5>
        <span class="badge bg-white text-primary px-3 py-2 rounded-pill font-monospace" x-text="nomorTiket"></span>
    </div>
    
    <div class="card-body p-4">
        <!-- Notifikasi Keseimbangan Nilai (Zero-Sum Rule) -->
        <div class="p-3 mb-4 rounded-3 border transition-all"
             :class="isBalanced ? 'bg-emerald-50 border-emerald-300 text-emerald-800' : 'bg-rose-50 border-rose-300 text-rose-800'">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold" x-text="isBalanced ? '✓ Keseimbangan Pagu Tercapai (Zero-Sum Valid)' : '✕ Nilai Pergeseran Belum Seimbang!'"></span>
                    <p class="small mb-0 mt-1" x-text="isBalanced ? 'Total penambahan telah seimbang dengan total pengurangan.' : 'Total pengurangan rekening donor harus sama dengan total penambahan rekening penerima.'"></p>
                </div>
                <div class="text-end">
                    <div class="text-xs uppercase tracking-wider text-muted">Selisih (Delta)</div>
                    <div class="fs-5 fw-bold" :class="isBalanced ? 'text-emerald-600' : 'text-rose-600'" x-text="formatRupiah(delta)"></div>
                </div>
            </div>
        </div>

        <!-- Tabel Baris Pergeseran Dinamis -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-center small text-uppercase">
                        <th style="width: 15%">Jenis Mutasi</th>
                        <th style="width: 40%">Rekening Belanja</th>
                        <th style="width: 20%">Pagu Saat Ini</th>
                        <th style="width: 20%">Nilai Pergeseran (Rp)</th>
                        <th style="width: 5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in items" :key="index">
                        <tr>
                            <td>
                                <select class="form-select form-select-sm" x-model="item.jenis_mutasi" @change="recalculate()">
                                    <option value="berkurang">Donor (Berkurang)</option>
                                    <option value="bertambah">Penerima (Bertambah)</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select form-select-sm" x-model="item.pagu_id" @change="onRekeningChange(index)">
                                    <option value="">-- Pilih Rekening Belanja --</option>
                                    <template x-for="rek in listRekening" :key="rek.id">
                                        <option :value="rek.id" x-text="rek.kode + ' - ' + rek.nama"></option>
                                    </template>
                                </select>
                            </td>
                            <td class="text-end font-monospace" x-text="formatRupiah(item.pagu_existing)"></td>
                            <td>
                                <input type="number" step="1000" min="0" class="form-control form-control-sm text-end font-monospace"
                                       x-model.number="item.nilai" @input="recalculate()" placeholder="0">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger" @click="removeItem(index)" :disabled="items.length <= 2">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-outline-secondary btn-sm" @click="addItem()">
                <i class="bi bi-plus-circle me-1"></i> Tambah Baris Rekening
            </button>
            <button type="button" class="btn btn-primary px-4" :disabled="!isBalanced || isSubmitting" @click="submitPergeseran()">
                <span x-show="!isSubmitting"><i class="bi bi-send me-1"></i> Ajukan ke Verifikator TAPD</span>
                <span x-show="isSubmitting"><i class="spinner-border spinner-border-sm me-1"></i> Memproses...</span>
            </button>
        </div>
    </div>
</div>

<script>
function pergeseranForm() {
    return {
        nomorTiket: 'TIKET-' + Math.floor(100000 + Math.random() * 900000),
        items: [
            { jenis_mutasi: 'berkurang', pagu_id: '', pagu_existing: 0, nilai: 0 },
            { jenis_mutasi: 'bertambah', pagu_id: '', pagu_existing: 0, nilai: 0 }
        ],
        listRekening: [], // Dimuat dari endpoint AJAX
        delta: 0,
        isBalanced: false,
        isSubmitting: false,

        init() {
            // Memuat daftar rekening via Axios
            axios.get('/api/pagu/active-accounts')
                 .then(res => this.listRekening = res.data)
                 .catch(err => console.error(err));
            this.recalculate();
        },

        addItem() {
            this.items.push({ jenis_mutasi: 'bertambah', pagu_id: '', pagu_existing: 0, nilai: 0 });
            this.recalculate();
        },

        removeItem(index) {
            this.items.splice(index, 1);
            this.recalculate();
        },

        recalculate() {
            let totalKurang = 0;
            let totalTambah = 0;

            this.items.forEach(i => {
                if (i.jenis_mutasi === 'berkurang') totalKurang += Number(i.nilai || 0);
                if (i.jenis_mutasi === 'bertambah') totalTambah += Number(i.nilai || 0);
            });

            this.delta = totalTambah - totalKurang;
            this.isBalanced = (totalKurang > 0) && (this.delta === 0);
        },

        formatRupiah(num) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(num || 0);
        },

        submitPergeseran() {
            if (!this.isBalanced) return;
            this.isSubmitting = true;

            axios.post('/pergeseran/simpan-usulan', {
                nomor_tiket: this.nomorTiket,
                items: this.items
            })
            .then(res => {
                Swal.fire('Berhasil!', res.data.message, 'success')
                    .then(() => window.location.href = '/pergeseran');
            })
            .catch(err => {
                Swal.fire('Gagal!', err.response?.data?.message || 'Terjadi kesalahan sistem.', 'error');
            })
            .finally(() => this.isSubmitting = false);
        }
    }
}
</script>
```

---

#### D. Visualisasi Realisasi Anggaran (ApexCharts)
File: `app/Views/dashboard/chart_partial.php`

```html
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-3 px-4">
        <div>
            <h6 class="fw-bold mb-0 text-dark">Perbandingan Pagu Efektif vs Realisasi SP2D per Jenis Belanja</h6>
            <small class="text-muted">Tahun Anggaran Berjalan (Akumulasi Real-Time)</small>
        </div>
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1">APBD Murni + Pergeseran</span>
    </div>
    <div class="card-body p-3">
        <div id="budgetApexChart" style="min-height: 350px;"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const options = {
        series: [
            { name: 'Pagu Alokasi (Rp)', data: [45000000000, 28000000000, 15000000000, 3500000000] },
            { name: 'Realisasi SP2D (Rp)', data: [38500000000, 19200000000, 8400000000, 1200000000] }
        ],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
                borderRadius: 4
            }
        },
        dataLabels: { enabled: false },
        stroke: { show: true, width: 2, colors: ['transparent'] },
        colors: ['#0d6efd', '#198754'],
        xaxis: {
            categories: ['Belanja Pegawai', 'Belanja Barang/Jasa', 'Belanja Modal', 'Belanja Tak Terduga']
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return 'Rp ' + (val / 1000000000).toFixed(1) + ' M';
                }
            }
        },
        fill: { opacity: 1 },
        tooltip: {
            y: {
                formatter: function (val) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                }
            }
        },
        legend: { position: 'top', horizontalAlign: 'right' }
    };

    const chart = new ApexCharts(document.querySelector("#budgetApexChart"), options);
    chart.render();
});
</script>
```

---

## 6. ROADMAP TAHAPAN PEMBANGUNAN (PHASED DEVELOPMENT)

Pembangunan SIAP-PAGU dibagi ke dalam **6 Tahapan / Sprints** terstruktur (siklus 2 mingguan per sprint) guna memastikan pengujian berulang dan akurasi logika keuangan:

```
[Sprint 1: Fondasi] --> [Sprint 2: Master & ASN] --> [Sprint 3: Pagu & Pergeseran]
                                                                |
[Sprint 6: Deployment] <-- [Sprint 5: Dashboard & Export] <-- [Sprint 4: SP2D & Sisa Pagu]
```

### Matriks Rincian Tahapan & Deliverables:

| Fase / Sprint | Durasi | Fokus Pengembangan & Deliverables | Kriteria Penerimaan (Acceptance Criteria) |
| :--- | :--- | :--- | :--- |
| **Tahap 1: Fondasi & Autentikasi RBAC** | Minggu 1–2 | • Setup CodeIgniter 4, Template Tabler/AdminLTE 4, Tailwind/Bootstrap.<br>• Skema DDL User, SKPD, Role & Hak Akses.<br>• Implementasi filter keamanan CSRF, Session Cookie Hardening, dan Login Throttling. | Pengguna dari 5 role berbeda berhasil login dan hanya melihat navigasi menu sesuai matriks perizinan (*least privilege*). |
| **Tahap 2: Master Nomenklatur, ASN, SBU & ASB** | Minggu 3–4 | • Import master kodifikasi Permendagri 90/2019 (Urusan s/d Sub-Rincian Objek).<br>• Modul Master Pegawai ASN SKPD (Gaji Pokok, Tunjangan, TPP).<br>• Engine kalkulasi proyeksi kebutuhan belanja pegawai bulanan per SKPD.<br>• Modul Kamus Standar Biaya Umum (SBU) dan Parameter Analisis Standar Biaya (ASB). | Proyeksi belanja pegawai cocok 100% dengan daftar gaji BPKAD, serta parameter SBU & ASB tervalidasi sebagai batas pagu. |
| **Tahap 3: Pagu APBD & Engine Pergeseran** | Minggu 5–6 | • Input & Import Pagu Induk (Lampiran 1 Perda & Perbup).<br>• Modul Pengajuan Pergeseran Anggaran (Matriks Donor & Resipien).<br>• State machine multi-level approval (Draft $\rightarrow$ Verifikasi TAPD $\rightarrow$ Disetujui PPKD).<br>• Mekanisme penguncian pagu (*lock*) dan rollback otomatis. | Transaksi pergeseran berhasil mengubah nilai pagu dengan ACID transaction dan menolak pengajuan jika selisih tidak zero-sum. |
| **Tahap 4: Realisasi SP2D & Engine Sisa Pagu** | Minggu 7–8 | • Modul input & import data SP2D (UP, GU, TU, LS Barang Jasa, LS Gaji).<br>• Pengurangan pagu real-time per rincian rekening objek.<br>• Validasi anti-overbudget (Sistem memblokir SP2D jika melebihi sisa pagu bebas). | Sisa pagu terhitung akurat secara instan tanpa inkonsistensi konkurensi saat multi-user menginput bersamaan. |
| **Tahap 5: Dashboard & Engine Pelaporan** | Minggu 9–10 | • Dashboard Eksekutif ApexCharts (Gauge & Bar Pagu vs Realisasi).<br>• Generator Matriks Pergeseran Anggaran format F4 Folio Landscape (PDF).<br>• Ekspor Buku Kas Pembantu Pagu & Penyerapan (Excel via PhpSpreadsheet).<br>• Modul Audit Trail (Pencatatan riwayat perubahan data). | Dokumen cetak PDF matriks pergeseran identik dengan format resmi Permendagri 77/2020 dan siap ditandatangani. |
| **Tahap 6: UAT, Hardening & Deployment** | Minggu 11–12 | • User Acceptance Testing (UAT) bersama tim TAPD & perwakilan SKPD.<br>• Security Penetration Testing (Injeksi SQL, Bypass Filter, Broken Access Control).<br>• Performance Optimization (Index tuning, Query profiling, Redis Cache).<br>• Deployment ke Server Produksi PDN/Pemda (Nginx, PHP-FPM, MySQL 8). | Zero vulnerabilities (*High/Critical*), load testing stabil pada simulasi 200 concurrent users dari OPD se-daerah. |

---

## 7. STANDAR PENGUJIAN & QUALITY ASSURANCE (QA)

1. **Unit Testing (PHPUnit):** Menguji formula matematika kalkulasi sisa pagu, delta pergeseran, dan penghitungan potongan pajak SP2D.
2. **Concurrency Stress Testing:** Menjalankan skrip simulasi penginputan pergeseran bersamaan untuk memastikan mekanisme `SELECT ... FOR UPDATE` dan transaksi InnoDB mengunci baris rekening tanpa *race condition*.
3. **Audit Log Verification:** Memastikan setiap operasi DML (`INSERT`, `UPDATE`, `DELETE`) pada pagu dan approval terekam dalam tabel `audit_logs` lengkap dengan snapshot data lama (*old values*) dan data baru (*new values*).

---
*Dokumen ini merupakan acuan resmi pengembangan sistem SIAP-PAGU. Setiap perubahan ruang lingkup (scope creep) wajib melalui mekanisme Change Request Approval.*
