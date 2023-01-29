<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $id_kar = $this->session->userdata('ses_kar');
        $nm = (int) $id_kar;
    }

    public function index()
    {
        $guru = $this->model_master->getListGuruArray();
        $mapel = $this->model_master->getListMapelArray();
        $ruang = $this->model_master->getListRuangArray();
        $data = [
            'nama' => $this->session->userdata('ses_kar'),
            'title' => 'Dashboard',
            'jml_guru' => count($guru),
            'jml_mapel' => count($mapel),
            'jml_ruang' => count($ruang),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/index', $data);
        $this->load->view('_partial/main/footer');
    }
    public function master_kelas()
    {
        $data = [
            'title' => 'Master Kelas',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/master_kelas', $data);
        $this->load->view('_partial/main/footer');
    }
    public function master_mapel()
    {
        $data = [
            'title' => 'Master Mata Pelajaran',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/master_mapel', $data);
        $this->load->view('_partial/main/footer');
    }
    public function master_guru()
    {
        $data = [
            'title' => 'Master Guru',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/master_guru', $data);
        $this->load->view('_partial/main/footer');
    }
    public function master_ruang()
    {
        $data = [
            'title' => 'Master Ruang',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/master_ruang', $data);
        $this->load->view('_partial/main/footer');
    }
    public function master_jam()
    {
        $data = [
            'title' => 'Master Jam',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/master_jam', $data);
        $this->load->view('_partial/main/footer');
    }
    public function data_jadwal()
    {
        $data = [
            'title' => 'Generate Jadwal',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/data_jadwal', $data);
        $this->load->view('_partial/main/footer');
    }
    public function data_pengawas()
    {
        $data = [
            'title' => 'Generate Pengawas',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/data_pengawas', $data);
        $this->load->view('_partial/main/footer');
    }
    public function data_waktu()
    {
        $data = [
            'title' => 'Generate Jadwal',
            'nama' => $this->session->userdata('ses_kar'),
        ];
        $this->load->view('_partial/main/header', $data);
        $this->load->view('_partial/main/sidebar', $data);
        $this->load->view('layout/admin/data_waktu', $data);
        $this->load->view('_partial/main/footer');
    }
}