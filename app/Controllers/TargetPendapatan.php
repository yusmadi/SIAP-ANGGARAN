<?php

namespace App\Controllers;

use App\Models\TargetPendapatanModel;
use App\Models\SkpdModel;
use App\Models\TahunAnggaranModel;
use App\Models\AuditLogModel;

class TargetPendapatan extends BaseController
{
    protected TargetPendapatanModel $targetModel;
    protected SkpdModel $skpdModel;
    protected TahunAnggaranModel $tahunModel;

    public function __construct()
    {
        $this->targetModel = new TargetPendapatanModel();
        $this->skpdModel   = new SkpdModel();
        $this->tahunModel  = new TahunAnggaranModel();
    }

    public function index()
    {
        $session = session();
        $roleCode = $session->get('role_code');
        $userSkpdId = $session->get('skpd_id');

        $keyword = trim((string) $this->request->getGet('q'));
        $skpdId = $this->request->getGet('skpd_id') ? (int) $this->request->getGet('skpd_id') : null;

        // If user is OPD planner, lock SKPD filter to their own SKPD
        if ($roleCode === 'perencana_opd' && $userSkpdId) {
            $skpdId = $userSkpdId;
        }

        $perPage = $this->request->getGet('per_page') ? (int) $this->request->getGet('per_page') : 15;
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        $activeYear = $this->tahunModel->getActiveYear();
        $tahunId = $activeYear ? $activeYear['id'] : null;

        $targets = $this->targetModel->getTargetPendapatanPaginated($skpdId, $tahunId, $keyword, $perPage);
        $pager   = $this->targetModel->pager;
        $stats   = $this->targetModel->getStats($skpdId, $tahunId, $keyword);

        $skpdList         = $this->skpdModel->orderBy('kode_skpd', 'ASC')->findAll();
        $subRincianList   = $this->targetModel->getPendapatanSubRincianObjeks();

        $data = [
            'title'          => 'Target Pendapatan APBK - SIAP-ANGGARAN',
            'targets'        => $targets,
            'pager'          => $pager,
            'stats'          => $stats,
            'skpdList'       => $skpdList,
            'subRincianList' => $subRincianList,
            'activeYear'     => $activeYear,
            'keyword'        => $keyword,
            'skpd_id'        => $skpdId,
            'perPage'        => $perPage,
            'currentPage'    => $pager ? $pager->getCurrentPage() : 1,
            'roleCode'       => $roleCode,
            'userSkpdId'     => $userSkpdId,
        ];

        return view('target_pendapatan/index', $data);
    }

    public function store()
    {
        $rules = [
            'skpd_id'              => 'required|numeric|is_not_unique[master_skpd.id]',
            'sub_rincian_objek_id' => 'required|numeric|is_not_unique[master_sub_rincian_objek.id]',
            'target_murni'         => 'required|numeric|greater_than_equal_to[0]',
            'target_pergeseran'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            'target_perubahan'     => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan Target Pendapatan. Silakan periksa kembali inputan Anda.');
        }

        $activeYear = $this->tahunModel->getActiveYear();
        $tahunId = $activeYear ? $activeYear['id'] : null;

        $targetMurni = (float) $this->request->getPost('target_murni');
        $targetPergeseran = $this->request->getPost('target_pergeseran') !== null && $this->request->getPost('target_pergeseran') !== '' ? (float) $this->request->getPost('target_pergeseran') : $targetMurni;
        $targetPerubahan = $this->request->getPost('target_perubahan') !== null && $this->request->getPost('target_perubahan') !== '' ? (float) $this->request->getPost('target_perubahan') : $targetPergeseran;

        $data = [
            'tahun_anggaran_id'    => $tahunId,
            'skpd_id'              => (int) $this->request->getPost('skpd_id'),
            'sub_rincian_objek_id' => (int) $this->request->getPost('sub_rincian_objek_id'),
            'target_murni'         => $targetMurni,
            'target_pergeseran'    => $targetPergeseran,
            'target_perubahan'     => $targetPerubahan,
            'keterangan'           => trim((string) $this->request->getPost('keterangan')),
        ];

        $this->targetModel->insert($data);
        $newId = $this->targetModel->getInsertID();

        AuditLogModel::record(
            'TARGET_PENDAPATAN_CREATE',
            'target_pendapatan',
            (string) $newId,
            null,
            $data
        );

        return redirect()->to('/target-pendapatan')->with('success', 'Target Pendapatan APBK berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $target = $this->targetModel->find($id);
        if (!$target) {
            return redirect()->to('/target-pendapatan')->with('error', 'Data Target Pendapatan tidak ditemukan.');
        }

        $rules = [
            'skpd_id'              => 'required|numeric|is_not_unique[master_skpd.id]',
            'sub_rincian_objek_id' => 'required|numeric|is_not_unique[master_sub_rincian_objek.id]',
            'target_murni'         => 'required|numeric|greater_than_equal_to[0]',
            'target_pergeseran'    => 'permit_empty|numeric|greater_than_equal_to[0]',
            'target_perubahan'     => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Target Pendapatan.');
        }

        $targetMurni = (float) $this->request->getPost('target_murni');
        $targetPergeseran = $this->request->getPost('target_pergeseran') !== null && $this->request->getPost('target_pergeseran') !== '' ? (float) $this->request->getPost('target_pergeseran') : $targetMurni;
        $targetPerubahan = $this->request->getPost('target_perubahan') !== null && $this->request->getPost('target_perubahan') !== '' ? (float) $this->request->getPost('target_perubahan') : $targetPergeseran;

        $updateData = [
            'skpd_id'              => (int) $this->request->getPost('skpd_id'),
            'sub_rincian_objek_id' => (int) $this->request->getPost('sub_rincian_objek_id'),
            'target_murni'         => $targetMurni,
            'target_pergeseran'    => $targetPergeseran,
            'target_perubahan'     => $targetPerubahan,
            'keterangan'           => trim((string) $this->request->getPost('keterangan')),
        ];

        $this->targetModel->update($id, $updateData);

        AuditLogModel::record(
            'TARGET_PENDAPATAN_UPDATE',
            'target_pendapatan',
            (string) $id,
            $target,
            $updateData
        );

        return redirect()->to('/target-pendapatan')->with('success', 'Data Target Pendapatan APBK berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $target = $this->targetModel->find($id);
        if (!$target) {
            return redirect()->to('/target-pendapatan')->with('error', 'Data Target Pendapatan tidak ditemukan.');
        }

        $this->targetModel->delete($id);

        AuditLogModel::record(
            'TARGET_PENDAPATAN_DELETE',
            'target_pendapatan',
            (string) $id,
            $target,
            null
        );

        return redirect()->to('/target-pendapatan')->with('success', 'Data Target Pendapatan APBK berhasil dihapus.');
    }
}
