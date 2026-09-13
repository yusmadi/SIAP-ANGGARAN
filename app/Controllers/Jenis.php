<?php

namespace App\Controllers;

use App\Models\JenisModel;
use App\Models\KelompokModel;
use App\Models\AuditLogModel;

class Jenis extends BaseController
{
    protected JenisModel $jenisModel;
    protected KelompokModel $kelompokModel;

    public function __construct()
    {
        $this->jenisModel    = new JenisModel();
        $this->kelompokModel = new KelompokModel();
    }

    public function index()
    {
        $keyword    = trim((string) $this->request->getGet('q'));
        $kelompokId = $this->request->getGet('kelompok_id') ? (int) $this->request->getGet('kelompok_id') : null;

        $jeniss       = $this->jenisModel->getJenisWithKelompok($kelompokId, $keyword);
        $allKelompoks = $this->kelompokModel->getKelompokWithAkun();

        $stats = [
            'total_count'  => count($jeniss),
            'active_count' => count(array_filter($jeniss, fn($item) => $item['is_active'] == 1)),
        ];

        $data = [
            'title'       => 'Master Data Jenis Rekening - SIAP-ANGGARAN',
            'jeniss'      => $jeniss,
            'kelompoks'   => $allKelompoks,
            'stats'       => $stats,
            'keyword'     => $keyword,
            'kelompok_id' => $kelompokId,
        ];

        return view('jenis/index', $data);
    }

    public function store()
    {
        $rules = [
            'kelompok_id' => 'required|numeric|is_not_unique[master_kelompok.id]',
            'kode_jenis'  => 'required|min_length[1]|max_length[30]|is_unique[master_jenis.kode_jenis]',
            'nama_jenis'  => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Jenis. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kelompok_id' => (int) $this->request->getPost('kelompok_id'),
            'kode_jenis'  => trim($this->request->getPost('kode_jenis')),
            'nama_jenis'  => trim($this->request->getPost('nama_jenis')),
            'deskripsi'   => trim((string)$this->request->getPost('deskripsi')),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->jenisModel->insert($data);
        $newId = $this->jenisModel->getInsertID();

        AuditLogModel::record(
            'JENIS_CREATE',
            'master_jenis',
            (string) $newId,
            null,
            ['kode_jenis' => $data['kode_jenis'], 'nama_jenis' => $data['nama_jenis']]
        );

        return redirect()->to('/jenis')->with('success', 'Data Jenis Rekening berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $jenis = $this->jenisModel->find($id);
        if (!$jenis) {
            return redirect()->to('/jenis')->with('error', 'Data Jenis Rekening tidak ditemukan.');
        }

        $rules = [
            'kelompok_id' => 'required|numeric|is_not_unique[master_kelompok.id]',
            'kode_jenis'  => "required|min_length[1]|max_length[30]|is_unique[master_jenis.kode_jenis,id,{$id}]",
            'nama_jenis'  => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Jenis Rekening.');
        }

        $updateData = [
            'kelompok_id' => (int) $this->request->getPost('kelompok_id'),
            'kode_jenis'  => trim($this->request->getPost('kode_jenis')),
            'nama_jenis'  => trim($this->request->getPost('nama_jenis')),
            'deskripsi'   => trim((string)$this->request->getPost('deskripsi')),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->jenisModel->update($id, $updateData);

        AuditLogModel::record(
            'JENIS_UPDATE',
            'master_jenis',
            (string) $id,
            $jenis,
            $updateData
        );

        return redirect()->to('/jenis')->with('success', "Data Jenis '{$updateData['nama_jenis']}' berhasil diperbarui!");
    }

    public function delete($id = null)
    {
        $jenis = $this->jenisModel->find($id);
        if (!$jenis) {
            return redirect()->to('/jenis')->with('error', 'Data Jenis Rekening tidak ditemukan.');
        }

        $this->jenisModel->delete($id);

        AuditLogModel::record(
            'JENIS_DELETE',
            'master_jenis',
            (string) $id,
            $jenis,
            null
        );

        return redirect()->to('/jenis')->with('success', "Data Jenis '{$jenis['nama_jenis']}' berhasil dihapus.");
    }
}
