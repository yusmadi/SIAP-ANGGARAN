<?php

namespace App\Controllers;

use App\Models\AkunModel;
use App\Models\KelompokModel;
use App\Models\AuditLogModel;

class Kelompok extends BaseController
{
    protected KelompokModel $kelompokModel;
    protected AkunModel $akunModel;

    public function __construct()
    {
        $this->kelompokModel = new KelompokModel();
        $this->akunModel     = new AkunModel();
    }

    /**
     * Halaman Kelola Master Data Kelompok
     */
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $akunId  = $this->request->getGet('akun_id') ? (int) $this->request->getGet('akun_id') : null;

        $kelompoks = $this->kelompokModel->getKelompokWithAkun($akunId, $keyword);
        $allAkuns  = $this->akunModel->where('is_active', 1)->orderBy('kode_akun', 'ASC')->findAll();

        $stats = [
            'total_count'  => count($kelompoks),
            'active_count' => count(array_filter($kelompoks, fn($item) => $item['is_active'] == 1)),
        ];

        $data = [
            'title'     => 'Master Data Kelompok - SIAP-ANGGARAN',
            'kelompoks' => $kelompoks,
            'akuns'     => $allAkuns,
            'stats'     => $stats,
            'keyword'   => $keyword,
            'akun_id'   => $akunId,
        ];

        return view('kelompok/index', $data);
    }

    /**
     * Simpan Data Kelompok Baru
     */
    public function store()
    {
        $rules = [
            'akun_id'       => 'required|numeric|is_not_unique[master_akun.id]',
            'kode_kelompok' => 'required|min_length[1]|max_length[20]|is_unique[master_kelompok.kode_kelompok]',
            'nama_kelompok' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Kelompok. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'akun_id'       => (int) $this->request->getPost('akun_id'),
            'kode_kelompok' => trim($this->request->getPost('kode_kelompok')),
            'nama_kelompok' => trim($this->request->getPost('nama_kelompok')),
            'deskripsi'     => trim((string)$this->request->getPost('deskripsi')),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->kelompokModel->insert($data);
        $newId = $this->kelompokModel->getInsertID();

        AuditLogModel::record(
            'KELOMPOK_CREATE',
            'master_kelompok',
            (string) $newId,
            null,
            ['kode_kelompok' => $data['kode_kelompok'], 'nama_kelompok' => $data['nama_kelompok']]
        );

        return redirect()->to('/kelompok')->with('success', 'Data Kelompok berhasil ditambahkan!');
    }

    /**
     * Update Data Kelompok Existing
     */
    public function update($id = null)
    {
        $kelompok = $this->kelompokModel->find($id);
        if (!$kelompok) {
            return redirect()->to('/kelompok')->with('error', 'Data Kelompok tidak ditemukan.');
        }

        $rules = [
            'akun_id'       => 'required|numeric|is_not_unique[master_akun.id]',
            'kode_kelompok' => "required|min_length[1]|max_length[20]|is_unique[master_kelompok.kode_kelompok,id,{$id}]",
            'nama_kelompok' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Kelompok. Mohon periksa kembali inputan Anda.');
        }

        $updateData = [
            'akun_id'       => (int) $this->request->getPost('akun_id'),
            'kode_kelompok' => trim($this->request->getPost('kode_kelompok')),
            'nama_kelompok' => trim($this->request->getPost('nama_kelompok')),
            'deskripsi'     => trim((string)$this->request->getPost('deskripsi')),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->kelompokModel->update($id, $updateData);

        AuditLogModel::record(
            'KELOMPOK_UPDATE',
            'master_kelompok',
            (string) $id,
            $kelompok,
            $updateData
        );

        return redirect()->to('/kelompok')->with('success', "Data Kelompok '{$updateData['nama_kelompok']}' berhasil diperbarui!");
    }

    /**
     * Hapus Data Kelompok
     */
    public function delete($id = null)
    {
        $kelompok = $this->kelompokModel->find($id);
        if (!$kelompok) {
            return redirect()->to('/kelompok')->with('error', 'Data Kelompok tidak ditemukan.');
        }

        $this->kelompokModel->delete($id);

        AuditLogModel::record(
            'KELOMPOK_DELETE',
            'master_kelompok',
            (string) $id,
            $kelompok,
            null
        );

        return redirect()->to('/kelompok')->with('success', "Data Kelompok '{$kelompok['nama_kelompok']}' berhasil dihapus.");
    }
}
