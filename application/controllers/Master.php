<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $id_kar = $this->session->userdata('ses_kar');
        $nm = (int) $id_kar;
    }

    public function master_kelas(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getListKelas();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
					$hari = explode(";",$d->hari);
                    $hari = $this->formatter->getFormatManyDays($hari);
					$datax['data'][]=[
						$d->id_kelas,
						$d->kode_kelas,
						$d->nama,
						$d->kondisi,
						'<button class="btn btn-info" onclick="do_view(\''.$d->id_kelas.'\')"><i class="fa fa-info-circle"></i></button><button class="btn btn-danger" onclick="do_delete(\''.$d->id_kelas.'\')"><i class="fa fa-trash"></i></button>',
					];
					$no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getListKelasId($id);
                    foreach ($data as $d) {
						$hari = explode(";",$d->hari);
                    	$hari = $this->formatter->getFormatManyDays($hari);
                        $datax = [
                            'id' => $d->id_kelas,
                            'kode_kelas' => $d->kode_kelas,
                            'nama' => $d->nama,
                            'kondisi' => $d->kondisi,
                        ];
                    }
                }
                echo json_encode($datax);
            }
        }
    }
    function add_master_kelas(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {			
			$data=[
				'kode_kelas'=>$kode,
				'nama'=>$this->input->post('nama'),
				'kondisi' => $this->input->post('kondisi'),
				
			];
			$datax = $this->db->insert('master_kelas',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_master_kelas(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id_kelas');
		if ($id != "") {
			$data=[
				'kode_kelas'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
				'kondisi' => $this->input->post('kondisi'),
			];
			$this->db->where('id_kelas', $id);        
			$datax = $this->db->update('master_kelas',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_master_kelas(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_kelas'=>$id,
			];
			$datax = $this->db->delete('master_kelas',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}

	//Master Mapel
    public function master_mapel(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getListMapel();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
					$datax['data'][]=[
						$d->id_mapel,
						$d->kode_mapel,
						$d->nama,
						'<button class="btn btn-info" onclick="do_view(\''.$d->id_mapel.'\')"><i class="fa fa-info-circle"></i></button><button class="btn btn-danger" onclick="do_delete(\''.$d->id_mapel.'\')"><i class="fa fa-trash"></i></button>',
					];
					$no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getListMapelId($id);
                    foreach ($data as $d) {
                        $datax = [
                            'id' => $d->id_mapel,
                            'kode_mapel' => $d->kode_mapel,
                            'nama' => $d->nama,
                        ];
                    }
                }
                echo json_encode($datax);
            }
        }
    }
    function add_master_mapel(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {
			$data=[
				'kode_mapel'=>$kode,
				'nama'=>ucwords($this->input->post('nama')),
			];
			$datax = $this->db->insert('master_mapel',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_master_mapel(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id_mapel');
		if ($id != "") {
			$data=[
				'kode_mapel'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
			];
			$this->db->where('id_mapel', $id);        
			$datax = $this->db->update('master_mapel',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_master_mapel(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_mapel'=>$id,
			];
			$datax = $this->db->delete('master_mapel',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}

	//Master Guru
    public function master_guru(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getListGuru();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
					$datax['data'][]=[
						$d->id_guru,
						$d->kode_guru,
						$d->nama,
						'<button class="btn btn-info" onclick="do_view(\''.$d->id_guru.'\')"><i class="fa fa-info-circle"></i></button><button class="btn btn-danger" onclick="do_delete(\''.$d->id_guru.'\')"><i class="fa fa-trash"></i></button>',
					];
					$no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getListGuruId($id);
                    foreach ($data as $d) {
                        $datax = [
                            'id' => $d->id_guru,
                            'kode_guru' => $d->kode_guru,
                            'nama' => $d->nama,
                        ];
                    }
                }
                echo json_encode($datax);
            }
        }
    }
    function add_master_guru(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {
			$data=[
				'kode_guru'=>$kode,
				'nama'=>ucwords($this->input->post('nama')),
			];
			$datax = $this->db->insert('master_guru',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_master_guru(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id_guru');
		if ($id != "") {
			$data=[
				'kode_guru'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
			];
			$this->db->where('id_guru', $id);        
			$datax = $this->db->update('master_guru',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_master_guru(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_guru'=>$id,
			];
			$datax = $this->db->delete('master_guru',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
	
	//Master Ruang
    public function master_ruang(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getListRuang();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
					$datax['data'][]=[
						$d->id_ruang,
						$d->kode_ruang,
						$d->nama,
						'<button class="btn btn-info" onclick="do_view(\''.$d->id_ruang.'\')"><i class="fa fa-info-circle"></i></button><button class="btn btn-danger" onclick="do_delete(\''.$d->id_ruang.'\')"><i class="fa fa-trash"></i></button>',
					];
					$no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getListRuangId($id);
                    foreach ($data as $d) {
                        $datax = [
                            'id' => $d->id_ruang,
                            'kode_ruang' => $d->kode_ruang,
                            'nama' => $d->nama,
                        ];
                    }
                }
                echo json_encode($datax);
            }
        }
    }
    function add_master_ruang(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {
			$data=[
				'kode_ruang'=>$kode,
				'nama'=>ucwords($this->input->post('nama')),
			];
			$datax = $this->db->insert('master_ruang',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_master_ruang(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id_ruang');
		if ($id != "") {
			$data=[
				'kode_ruang'=>$this->input->post('kode'),
				'nama'=>$this->input->post('nama'),
			];
			$this->db->where('id_ruang', $id);        
			$datax = $this->db->update('master_ruang',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_master_ruang(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_ruang'=>$id,
			];
			$datax = $this->db->delete('master_ruang',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}

	
	//Master Jam
    public function master_jam(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getListJam();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
					$datax['data'][]=[
						$d->id_jam,
						$d->kode_jam,
						$d->jam_mulai.' - '.$d->jam_selesai,
						'<button class="btn btn-info" onclick="do_view(\''.$d->id_jam.'\')"><i class="fa fa-info-circle"></i></button><button class="btn btn-danger" onclick="do_delete(\''.$d->id_jam.'\')"><i class="fa fa-trash"></i></button>',
					];
					$no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getListJamId($id);
                    foreach ($data as $d) {
                        $datax = [
                            'id' => $d->id_jam,
                            'kode_jam' => $d->kode_jam,
                            'range_jam' => $d->jam_mulai.' - '.$d->jam_selesai,
                            'jam_mulai' => $d->jam_mulai,
                            'jam_selesai' => $d->jam_selesai,
                        ];
                    }
                }
                echo json_encode($datax);
            }
        }
    }
    function add_master_jam(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {
			$data=[
				'kode_jam'=>$kode,
				'range_jam_mulai'=>$this->input->post('range_jam_mulai'),
				'range_jam_selesai'=>$this->input->post('range_jam_selesai'),
			];
			$datax = $this->db->insert('master_jam',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_master_jam(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id_jam');
		if ($id != "") {
			$data=[
				'kode_jam'=>$this->input->post('kode'),
				'range_jam_mulai'=>$this->input->post('range_jam_mulai'),
				'range_jam_selesai'=>$this->input->post('range_jam_selesai'),
			];
			$this->db->where('id_jam', $id);        
			$datax = $this->db->update('master_jam',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_master_jam(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_jam'=>$id,
			];
			$datax = $this->db->delete('master_jam',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
}