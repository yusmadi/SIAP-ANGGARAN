<?php

namespace App\Controllers;

use App\Models\ObjekModel;
use App\Models\JenisModel;
use App\Models\AuditLogModel;

class Objek extends BaseController
{
    protected ObjekModel $objekModel;
    protected JenisModel $jenisModel;

    public function __construct()
    {
        $this->objekModel = new ObjekModel();
        $this->jenisModel = new JenisModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $jenisId = $this->request->getGet('jenis_id') ? (int) $this->request->getGet('jenis_id') : null;

        $objeks    = $this->objekModel->getObjekWithParents($jenisId, $keyword);
        $allJeniss = $this->jenisModel->getJenisWithKelompok();

        $stats = [
            'total_count'  => count($objeks),
            'active_count' => count(array_filter($objeks, fn($item) => $item['is_active'] == 1)),
        ];

        $data = [
            'title'    => 'Master Data Objek Rekening - SIAP-ANGGARAN',
            'objeks'   => $objeks,
            'jeniss'   => $allJeniss,
            'stats'    => $stats,
            'keyword'  => $keyword,
            'jenis_id' => $jenisId,
        ];

        return view('objek/index', $data);
    }

    public function store()
    {
        $rules = [
            'jenis_id'   => 'required|numeric|is_not_unique[master_jenis.id]',
            'kode_objek' => 'required|min_length[1]|max_length[40]|is_unique[master_objek.kode_objek]',
            'nama_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Objek Rekening. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'jenis_id'   => (int) $this->request->getPost('jenis_id'),
            'kode_objek' => trim($this->request->getPost('kode_objek')),
            'nama_objek' => trim($this->request->getPost('nama_objek')),
            'deskripsi'  => trim((string)$this->request->getPost('deskripsi')),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->objekModel->insert($data);
        $newId = $this->objekModel->getInsertID();

        AuditLogModel::record(
            'OBJEK_CREATE',
            'master_objek',
            (string) $newId,
            null,
            ['kode_objek' => $data['kode_objek'], 'nama_objek' => $data['nama_objek']]
        );

        return redirect()->to('/objek')->with('success', 'Data Objek Rekening berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $objek = $this->objekModel->find($id);
        if (!$objek) {
            return redirect()->to('/objek')->with('error', 'Data Objek Rekening tidak ditemukan.');
        }

        $rules = [
            'jenis_id'   => 'required|numeric|is_not_unique[master_jenis.id]',
            'kode_objek' => "required|min_length[1]|max_length[40]|is_unique[master_objek.kode_objek,id,{$id}]",
            'nama_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Objek Rekening.');
        }

        $updateData = [
            'jenis_id'   => (int) $this->request->getPost('jenis_id'),
            'kode_objek' => trim($this->request->getPost('kode_objek')),
            'nama_objek' => trim($this->request->getPost('nama_objek')),
            'deskripsi'  => trim((string)$this->request->getPost('deskripsi')),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->objekModel->update($id, $updateData);

        AuditLogModel::record(
            'OBJEK_UPDATE',
            'master_objek',
            (string) $id,
            $objek,
            $updateData
        );

        return redirect()->to('/objek')->with('success', "Data Objek '{$updateData['nama_objek']}' berhasil diperbarui!");
    }

    public function delete($id = null)
    {
        $objek = $this->objekModel->find($id);
        if (!$objek) {
            return redirect()->to('/objek')->with('error', 'Data Objek Rekening tidak ditemukan.');
        }

        $this->objekModel->delete($id);

        AuditLogModel::record(
            'OBJEK_DELETE',
            'master_objek',
            (string) $id,
            $objek,
            null
        );

        return redirect()->to('/objek')->with('success', "Data Objek '{$objek['nama_objek']}' berhasil dihapus.");
    }
}
