<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\SkpdModel;

class Skpk extends BaseController
{
    protected SkpdModel $skpdModel;

    public function __construct()
    {
        $this->skpdModel = new SkpdModel();
    }

    /**
     * Halaman Kelola Master Data SKPK
     */
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        $builder = $this->skpdModel->orderBy('kode_skpd', 'ASC');

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('kode_skpd', $keyword)
                    ->orLike('nama_skpd', $keyword)
                    ->orLike('nama_kepala', $keyword)
                    ->orLike('nip_kepala', $keyword)
                    ->groupEnd();
        }

        $skpds = $builder->findAll();

        $stats = [
            'total_count'     => count($skpds),
            'total_murni'      => array_sum(array_column($skpds, 'pagu_total_murni')),
            'total_pergeseran' => array_sum(array_column($skpds, 'pagu_total_pergeseran')),
        ];

        $data = [
            'title'      => 'Master Data SKPK - SIAP-ANGGARAN',
            'skpds'      => $skpds,
            'stats'      => $stats,
            'keyword'    => $keyword,
            'active_skpd_id' => session()->get('skpd_id'),
        ];

        return view('skpk/index', $data);
    }

    /**
     * Simpan Data SKPK Baru
     */
    public function store()
    {
        $rules = [
            'kode_skpd'             => 'required|min_length[3]|is_unique[master_skpd.kode_skpd]',
            'nama_skpd'             => 'required|min_length[3]',
            'nama_kepala'           => 'required|min_length[3]',
            'nip_kepala'            => 'required|min_length[10]',
            'pagu_total_murni'      => 'required|numeric',
            'pagu_total_pergeseran' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan SKPK. Mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kode_skpd'             => trim($this->request->getPost('kode_skpd')),
            'nama_skpd'             => trim($this->request->getPost('nama_skpd')),
            'nama_kepala'           => trim($this->request->getPost('nama_kepala')),
            'nip_kepala'            => trim($this->request->getPost('nip_kepala')),
            'pagu_total_murni'      => (float) $this->request->getPost('pagu_total_murni'),
            'pagu_total_pergeseran' => (float) $this->request->getPost('pagu_total_pergeseran'),
        ];

        $this->skpdModel->insert($data);
        $newId = $this->skpdModel->getInsertID();

        AuditLogModel::record(
            'SKPD_CREATE',
            'master_skpd',
            (string) $newId,
            null,
            ['nama_skpd' => $data['nama_skpd'], 'kode_skpd' => $data['kode_skpd']]
        );

        return redirect()->to('/skpk')->with('success', 'Data SKPK berhasil ditambahkan!');
    }

    /**
     * Update Data SKPK Existing
     */
    public function update($id = null)
    {
        $skpd = $this->skpdModel->find($id);
        if (!$skpd) {
            return redirect()->to('/skpk')->with('error', 'Data SKPK tidak ditemukan.');
        }

        $rules = [
            'kode_skpd'             => "required|min_length[3]|is_unique[master_skpd.kode_skpd,id,{$id}]",
            'nama_skpd'             => 'required|min_length[3]',
            'nama_kepala'           => 'required|min_length[3]',
            'nip_kepala'            => 'required|min_length[10]',
            'pagu_total_murni'      => 'required|numeric',
            'pagu_total_pergeseran' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui SKPK. Mohon periksa kembali inputan Anda.');
        }

        $updateData = [
            'kode_skpd'             => trim($this->request->getPost('kode_skpd')),
            'nama_skpd'             => trim($this->request->getPost('nama_skpd')),
            'nama_kepala'           => trim($this->request->getPost('nama_kepala')),
            'nip_kepala'            => trim($this->request->getPost('nip_kepala')),
            'pagu_total_murni'      => (float) $this->request->getPost('pagu_total_murni'),
            'pagu_total_pergeseran' => (float) $this->request->getPost('pagu_total_pergeseran'),
        ];

        $this->skpdModel->update($id, $updateData);

        AuditLogModel::record(
            'SKPD_UPDATE',
            'master_skpd',
            (string) $id,
            $skpd,
            $updateData
        );

        return redirect()->to('/skpk')->with('success', "Data SKPK '{$updateData['nama_skpd']}' berhasil diperbarui!");
    }

    /**
     * Hapus Data SKPK
     */
    public function delete($id = null)
    {
        $skpd = $this->skpdModel->find($id);
        if (!$skpd) {
            return redirect()->to('/skpk')->with('error', 'Data SKPK tidak ditemukan.');
        }

        $this->skpdModel->delete($id);

        AuditLogModel::record(
            'SKPD_DELETE',
            'master_skpd',
            (string) $id,
            $skpd,
            null
        );

        return redirect()->to('/skpk')->with('success', "Data SKPK '{$skpd['nama_skpd']}' berhasil dihapus.");
    }

    /**
     * Switch Konteks Pilihan SKPK Aktif pada Session & Dashboard
     */
    public function switch()
    {
        $session = session();
        $skpdId  = $this->request->getPost('skpd_id');

        if (empty($skpdId)) {
            $session->set([
                'skpd_id'   => null,
                'kode_skpd' => null,
                'nama_skpd' => 'Pemerintah Daerah (Seluruh SKPK)',
            ]);
            $msg = 'Konteks SKPK diubah ke Seluruh SKPK (Pemerintah Daerah).';
        } else {
            $skpd = $this->skpdModel->find($skpdId);
            if ($skpd) {
                $session->set([
                    'skpd_id'   => (int) $skpd['id'],
                    'kode_skpd' => $skpd['kode_skpd'],
                    'nama_skpd' => $skpd['nama_skpd'],
                ]);
                $msg = "Konteks SKPK berhasil diubah ke: {$skpd['nama_skpd']}";
            } else {
                return redirect()->back()->with('error', 'SKPK pilihan tidak valid.');
            }
        }

        AuditLogModel::record(
            'SKPD_SWITCH',
            'master_skpd',
            (string) ($skpdId ?? '0'),
            null,
            ['skpd_id' => $skpdId]
        );

        return redirect()->back()->with('success', $msg);
    }
}
