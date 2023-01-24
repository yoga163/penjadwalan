<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_master extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// master kelas
	public function getListKelas(){
		$this->db->select('*');
		$this->db->from('master_kelas');
		return $this->db->get()->result();
	}
	public function getListKelasArray(){
		$this->db->select('kode_kelas');
		$this->db->from('master_kelas');
		return $this->db->get()->result_array();
	}
	public function getListKelasId($id){
		return $this->db->get_where('master_kelas',['id_kelas'=>$id])->result();
	}
	public function getListKelasKode($kode){
		return $this->db->select('kondisi,kode_kelas')->get_where('master_kelas',['kode_kelas'=>$kode])->row_array();
	}
	// master Mapel
	public function getListMapel(){
		$this->db->select('*');
		$this->db->from('master_mapel');
		return $this->db->get()->result();
	}
	public function getListMapelArray(){
		$this->db->select('kode_mapel');
		$this->db->from('master_mapel');
		return $this->db->get()->result_array();
	}
	public function getListMapelId($id){
		return $this->db->get_where('master_mapel',['id_mapel'=>$id])->result();
	}
	// master Guru
	public function getListGuru(){
		$this->db->select('*');
		$this->db->from('master_guru');
		return $this->db->get()->result();
	}
	public function getListGuruArray(){
		$this->db->select('*');
		$this->db->from('master_guru');
		return $this->db->get()->result_array();
	}
	public function getListGuruId($id){
		return $this->db->get_where('master_guru',['id_guru'=>$id])->result();
	}
	// master Ruang
	public function getListRuang(){
		$this->db->select('*');
		$this->db->from('master_ruang');
		return $this->db->get()->result();
	}
	public function getListRuangArray(){
		$this->db->select('*');
		$this->db->from('master_ruang');
		return $this->db->get()->result_array();
	}
	public function getListRuangId($id){
		return $this->db->get_where('master_ruang',['id_ruang'=>$id])->result();
	}
	// master Jam
	public function getListJam(){
		$this->db->select('*');
		$this->db->from('master_jam');
		return $this->db->get()->result();
	}
	public function getListJamArray(){
		$this->db->select('kode_jam');
		$this->db->from('master_jam');
		return $this->db->get()->result_array();
	}
	public function getListJamId($id){
		return $this->db->get_where('master_jam',['id_jam'=>$id])->result();
	}
	// Data Jadwal
	public function getJadwal(){
		$this->db->select('dt_j.*,mpl.nama as nama_mapel,jm.jam_mulai,jm.jam_selesai');
		$this->db->from('data_jadwal as dt_j');
		$this->db->join('master_mapel as mpl','mpl.kode_mapel = dt_j.mapel','left');
		$this->db->join('master_jam as jm','jm.kode_jam = dt_j.jam','left');
		$this->db->order_by('dt_j.hari','asc');
		$this->db->order_by('dt_j.jam','asc');
		return $this->db->get()->result();
	}
	public function getJadwalArray(){
		$this->db->select('kode_jam');
		$this->db->from('data_jadwal');
		return $this->db->get()->result_array();
	}
	public function getJadwalId($id){
		return $this->db->get_where('data_jadwal',['id_jam'=>$id])->result();
	}
	// Data Pengawas
	public function getPengawas(){
		$this->db->select('dt_p.*,gr.nama as nama_guru,ruang.nama as nama_ruang');
		$this->db->from('data_pengawas as dt_p');
		$this->db->join('master_ruang as ruang','ruang.kode_ruang = dt_p.ruang','left');
		$this->db->join('master_guru as gr','gr.kode_guru = dt_p.guru','left');
		$this->db->order_by('dt_p.ruang','asc');
		return $this->db->get()->result();
	}
	public function getPengawasId($id){
		return $this->db->get_where('data_pengawas',['id_jam'=>$id])->result();
	}

	// master Jam
	public function getListDataWaktu(){
		$this->db->select('*');
		$this->db->from('data_waktu');
		return $this->db->get()->result();
	}
	public function getListDataWaktuArray(){
		$this->db->select('kode_waktu');
		$this->db->from('data_waktu');
		return $this->db->get()->result_array();
	}
	public function getListDataWaktuId($id){
		return $this->db->get_where('data_waktu',['id_waktu'=>$id])->result();
	}
}