<?php

namespace App\Controllers;

use App\Models\RincianObjekModel;
use App\Models\ObjekModel;
use App\Models\AuditLogModel;

class RincianObjek extends BaseController
{
    protected RincianObjekModel $rincianObjekModel;
    protected ObjekModel $objekModel;

    public function __construct()
    {
        $this->rincianObjekModel = new RincianObjekModel();
        $this->objekModel        = new ObjekModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $objekId = $this->request->getGet('objek_id') ? (int) $this->request->getGet('objek_id') : null;

        $rincianObjeks = $this->rincianObjekModel->getRincianObjekWithParents($objekId, $keyword);
        $allObjeks     = $this->objekModel->getObjekWithParents();

        $stats = [
            'total_count'  => count($rincianObjeks),
            'active_count' => count(array_filter($rincianObjeks, fn($item) => $item['is_active'] == 1)),
        ];

        $data = [
            'title'         => 'Master Data Rincian Objek - SIAP-ANGGARAN',
            'rincianObjeks' => $rincianObjeks,
            'objeks'        => $allObjeks,
            'stats'         => $stats,
            'keyword'       => $keyword,
            'objek_id'      => $objekId,
        ];

        return view('rincian_objek/index', $data);
    }

    public function store()
    {
        $rules = [
            'objek_id'           => 'required|numeric|is_not_unique[master_objek.id]',
            'kode_rincian_objek' => 'required|min_length[1]|max_length[50]|is_unique[master_rincian_objek.kode_rincian_objek]',
            'nama_rincian_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Rincian Objek Rekening. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'objek_id'           => (int) $this->request->getPost('objek_id'),
            'kode_rincian_objek' => trim($this->request->getPost('kode_rincian_objek')),
            'nama_rincian_objek' => trim($this->request->getPost('nama_rincian_objek')),
            'deskripsi'          => trim((string)$this->request->getPost('deskripsi')),
            'is_active'          => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->rincianObjekModel->insert($data);
        $newId = $this->rincianObjekModel->getInsertID();

        AuditLogModel::record(
            'RINCIAN_OBJEK_CREATE',
            'master_rincian_objek',
            (string) $newId,
            null,
            ['kode_rincian_objek' => $data['kode_rincian_objek'], 'nama_rincian_objek' => $data['nama_rincian_objek']]
        );

        return redirect()->to('/rincian-objek')->with('success', 'Data Rincian Objek Rekening berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $rincian = $this->rincianObjekModel->find($id);
        if (!$rincian) {
            return redirect()->to('/rincian-objek')->with('error', 'Data Rincian Objek Rekening tidak ditemukan.');
        }

        $rules = [
            'objek_id'           => 'required|numeric|is_not_unique[master_objek.id]',
            'kode_rincian_objek' => "required|min_length[1]|max_length[50]|is_unique[master_rincian_objek.kode_rincian_objek,id,{$id}]",
            'nama_rincian_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Rincian Objek Rekening.');
        }

        $updateData = [
            'objek_id'           => (int) $this->request->getPost('objek_id'),
            'kode_rincian_objek' => trim($this->request->getPost('kode_rincian_objek')),
            'nama_rincian_objek' => trim($this->request->getPost('nama_rincian_objek')),
            'deskripsi'          => trim((string)$this->request->getPost('deskripsi')),
            'is_active'          => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->rincianObjekModel->update($id, $updateData);

        AuditLogModel::record(
            'RINCIAN_OBJEK_UPDATE',
            'master_rincian_objek',
            (string) $id,
            $rincian,
            $updateData
        );

        return redirect()->to('/rincian-objek')->with('success', "Data Rincian Objek '{$updateData['nama_rincian_objek']}' berhasil diperbarui!");
    }

    public function delete($id = null)
    {
        $rincian = $this->rincianObjekModel->find($id);
        if (!$rincian) {
            return redirect()->to('/rincian-objek')->with('error', 'Data Rincian Objek Rekening tidak ditemukan.');
        }

        $this->rincianObjekModel->delete($id);

        AuditLogModel::record(
            'RINCIAN_OBJEK_DELETE',
            'master_rincian_objek',
            (string) $id,
            $rincian,
            null
        );

        return redirect()->to('/rincian-objek')->with('success', "Data Rincian Objek '{$rincian['nama_rincian_objek']}' berhasil dihapus.");
    }
}
