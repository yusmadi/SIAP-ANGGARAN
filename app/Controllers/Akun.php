<?php

namespace App\Controllers;

use App\Models\AkunModel;
use App\Models\AuditLogModel;

class Akun extends BaseController
{
    protected AkunModel $akunModel;

    public function __construct()
    {
        $this->akunModel = new AkunModel();
    }

    /**
     * Halaman Kelola Master Data Akun
     */
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        $builder = $this->akunModel->orderBy('kode_akun', 'ASC');

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('kode_akun', $keyword)
                    ->orLike('nama_akun', $keyword)
                    ->orLike('deskripsi', $keyword)
                    ->groupEnd();
        }

        $akuns = $builder->findAll();

        $stats = [
            'total_count'  => count($akuns),
            'active_count' => count(array_filter($akuns, fn($item) => $item['is_active'] == 1)),
        ];

        $data = [
            'title'   => 'Master Data Akun - SIAP-ANGGARAN',
            'akuns'   => $akuns,
            'stats'   => $stats,
            'keyword' => $keyword,
        ];

        return view('akun/index', $data);
    }

    /**
     * Simpan Data Akun Baru
     */
    public function store()
    {
        $rules = [
            'kode_akun' => 'required|min_length[1]|max_length[10]|is_unique[master_akun.kode_akun]',
            'nama_akun' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Akun. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kode_akun' => trim($this->request->getPost('kode_akun')),
            'nama_akun' => trim($this->request->getPost('nama_akun')),
            'deskripsi' => trim((string)$this->request->getPost('deskripsi')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->akunModel->insert($data);
        $newId = $this->akunModel->getInsertID();

        AuditLogModel::record(
            'AKUN_CREATE',
            'master_akun',
            (string) $newId,
            null,
            ['kode_akun' => $data['kode_akun'], 'nama_akun' => $data['nama_akun']]
        );

        return redirect()->to('/akun')->with('success', 'Data Akun berhasil ditambahkan!');
    }

    /**
     * Update Data Akun Existing
     */
    public function update($id = null)
    {
        $akun = $this->akunModel->find($id);
        if (!$akun) {
            return redirect()->to('/akun')->with('error', 'Data Akun tidak ditemukan.');
        }

        $rules = [
            'kode_akun' => "required|min_length[1]|max_length[10]|is_unique[master_akun.kode_akun,id,{$id}]",
            'nama_akun' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Akun. Mohon periksa kembali inputan Anda.');
        }

        $updateData = [
            'kode_akun' => trim($this->request->getPost('kode_akun')),
            'nama_akun' => trim($this->request->getPost('nama_akun')),
            'deskripsi' => trim((string)$this->request->getPost('deskripsi')),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->akunModel->update($id, $updateData);

        AuditLogModel::record(
            'AKUN_UPDATE',
            'master_akun',
            (string) $id,
            $akun,
            $updateData
        );

        return redirect()->to('/akun')->with('success', "Data Akun '{$updateData['nama_akun']}' berhasil diperbarui!");
    }

    /**
     * Hapus Data Akun
     */
    public function delete($id = null)
    {
        $akun = $this->akunModel->find($id);
        if (!$akun) {
            return redirect()->to('/akun')->with('error', 'Data Akun tidak ditemukan.');
        }

        $this->akunModel->delete($id);

        AuditLogModel::record(
            'AKUN_DELETE',
            'master_akun',
            (string) $id,
            $akun,
            null
        );

        return redirect()->to('/akun')->with('success', "Data Akun '{$akun['nama_akun']}' berhasil dihapus.");
    }
}
