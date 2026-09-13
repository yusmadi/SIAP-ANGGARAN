<?php

namespace App\Controllers;

use App\Models\SubRincianObjekModel;
use App\Models\RincianObjekModel;
use App\Models\AuditLogModel;

class SubRincianObjek extends BaseController
{
    protected SubRincianObjekModel $subRincianObjekModel;
    protected RincianObjekModel $rincianObjekModel;

    public function __construct()
    {
        $this->subRincianObjekModel = new SubRincianObjekModel();
        $this->rincianObjekModel    = new RincianObjekModel();
    }

    public function index()
    {
        $keyword        = trim((string) $this->request->getGet('q'));
        $rincianObjekId = $this->request->getGet('rincian_objek_id') ? (int) $this->request->getGet('rincian_objek_id') : null;
        $perPage        = $this->request->getGet('per_page') ? (int) $this->request->getGet('per_page') : 15;
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        $subRincianObjeks = $this->subRincianObjekModel->getSubRincianObjekPaginated($rincianObjekId, $keyword, $perPage);
        $pager            = $this->subRincianObjekModel->pager;
        $allRincianObjeks = $this->rincianObjekModel->getRincianObjekWithParents();
        $stats            = $this->subRincianObjekModel->getStats($rincianObjekId, $keyword);

        $data = [
            'title'            => 'Master Data Sub Rincian Objek - SIAP-ANGGARAN',
            'subRincianObjeks' => $subRincianObjeks,
            'pager'            => $pager,
            'rincianObjeks'    => $allRincianObjeks,
            'stats'            => $stats,
            'keyword'          => $keyword,
            'rincian_objek_id' => $rincianObjekId,
            'perPage'          => $perPage,
            'currentPage'      => $pager ? $pager->getCurrentPage() : 1,
        ];

        return view('sub_rincian_objek/index', $data);
    }

    public function store()
    {
        $rules = [
            'rincian_objek_id'       => 'required|numeric|is_not_unique[master_rincian_objek.id]',
            'kode_sub_rincian_objek' => 'required|min_length[1]|max_length[60]|is_unique[master_sub_rincian_objek.kode_sub_rincian_objek]',
            'nama_sub_rincian_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Sub Rincian Objek Rekening. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'rincian_objek_id'       => (int) $this->request->getPost('rincian_objek_id'),
            'kode_sub_rincian_objek' => trim($this->request->getPost('kode_sub_rincian_objek')),
            'nama_sub_rincian_objek' => trim($this->request->getPost('nama_sub_rincian_objek')),
            'deskripsi'              => trim((string)$this->request->getPost('deskripsi')),
            'is_active'              => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->subRincianObjekModel->insert($data);
        $newId = $this->subRincianObjekModel->getInsertID();

        AuditLogModel::record(
            'SUB_RINCIAN_OBJEK_CREATE',
            'master_sub_rincian_objek',
            (string) $newId,
            null,
            ['kode_sub_rincian_objek' => $data['kode_sub_rincian_objek'], 'nama_sub_rincian_objek' => $data['nama_sub_rincian_objek']]
        );

        return redirect()->to('/sub-rincian-objek')->with('success', 'Data Sub Rincian Objek Rekening berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $sub = $this->subRincianObjekModel->find($id);
        if (!$sub) {
            return redirect()->to('/sub-rincian-objek')->with('error', 'Data Sub Rincian Objek Rekening tidak ditemukan.');
        }

        $rules = [
            'rincian_objek_id'       => 'required|numeric|is_not_unique[master_rincian_objek.id]',
            'kode_sub_rincian_objek' => "required|min_length[1]|max_length[60]|is_unique[master_sub_rincian_objek.kode_sub_rincian_objek,id,{$id}]",
            'nama_sub_rincian_objek' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Sub Rincian Objek Rekening.');
        }

        $updateData = [
            'rincian_objek_id'       => (int) $this->request->getPost('rincian_objek_id'),
            'kode_sub_rincian_objek' => trim($this->request->getPost('kode_sub_rincian_objek')),
            'nama_sub_rincian_objek' => trim($this->request->getPost('nama_sub_rincian_objek')),
            'deskripsi'              => trim((string)$this->request->getPost('deskripsi')),
            'is_active'              => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->subRincianObjekModel->update($id, $updateData);

        AuditLogModel::record(
            'SUB_RINCIAN_OBJEK_UPDATE',
            'master_sub_rincian_objek',
            (string) $id,
            $sub,
            $updateData
        );

        return redirect()->to('/sub-rincian-objek')->with('success', "Data Sub Rincian Objek '{$updateData['nama_sub_rincian_objek']}' berhasil diperbarui!");
    }

    public function delete($id = null)
    {
        $sub = $this->subRincianObjekModel->find($id);
        if (!$sub) {
            return redirect()->to('/sub-rincian-objek')->with('error', 'Data Sub Rincian Objek Rekening tidak ditemukan.');
        }

        $this->subRincianObjekModel->delete($id);

        AuditLogModel::record(
            'SUB_RINCIAN_OBJEK_DELETE',
            'master_sub_rincian_objek',
            (string) $id,
            $sub,
            null
        );

        return redirect()->to('/sub-rincian-objek')->with('success', "Data Sub Rincian Objek '{$sub['nama_sub_rincian_objek']}' berhasil dihapus.");
    }
}
