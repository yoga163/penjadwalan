<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('ses_nama')) {
            redirect('admin');
        }
        $data = [
            'title' => 'Sistem Penjadwalan Otomatis',
        ];
        $this->load->view('_partial/login/header',$data);
        $this->load->view('layout/login/login',$data);
        $this->load->view('_partial/login/footer');
    }
    public function do_login()
    {
        $user = $this->input->post('username');
        $pasw = hash('sha512', $this->input->post('password'));
        $login = $this->login_m->Cek_login($user, $pasw);
        if ($login->num_rows() > 0) {
            $data = $login->row_array();
            $this->session->set_userdata('masuk', TRUE);
            $this->session->set_userdata('ses_nama', $data['username']);
            $this->session->set_userdata('ses_kar', $data['nama']);
            $this->session->set_userdata('ses_id', $data['id']);
            redirect('pages');
        } else {
            $url = base_url('login');
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username Atau Password Salah</div>');
            redirect($url);
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        $url = base_url('login');
        redirect($url);
    }
}
