<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function data_jadwal(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getJadwal();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
                    $datax['data'][]=[
                        $d->id_jadwal,
                        $this->formatter->getDateMonthFormatUser($d->hari),
                        $d->jam_mulai.'-'.$d->jam_selesai,
                        $d->nama_mapel,
                    ];
                    $no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getJadwalId($id);
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
    public function proses_jadwal(){
        $start = $this->formatter->getDateFromRange($this->input->post('tanggal'),'start','no');
        $end = $this->formatter->getDateFromRange($this->input->post('tanggal'),'end','no');
        $jml_populasi = $this->input->post('jml_populasi');
        $probabilitas_crossover = $this->input->post('probabilitas_crossover');
        $probabilitas_mutasi = $this->input->post('probabilitas_mutasi');
        $jml_generasi = $this->input->post('jml_generasi');
        $date=[];
        $current_date = $start;
        while($current_date <= $end){
            $timestamp = strtotime($current_date);
            $day = date('D', $timestamp);
            $n_day =$this->formatter->getNameOfDayNumber($day);
            if($n_day != 6 && $n_day != 7){
                $date[] =$current_date;
            }
            $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
        }
        
        $data = [
            'date'=>$date,
            'jml_populasi'=>$jml_populasi,
            'crossover'=>$probabilitas_crossover,
            'mutasi'=>$probabilitas_mutasi,
            'jml_generasi'=>$jml_generasi,

        ];
        $data_input = $this->model_global->generate_jadwal($data);
        if($data_input){
            $this->db->empty_table('data_jadwal');
            foreach($data_input as $d_i){
                $data = [
                    'mapel' => $d_i[0],
                    'hari' => $d_i[1],
                    'jam' => $d_i[2],
                    // 'kelas' => $d_i[3],
                    'tgl_mulai' => $start,
                    'tgl_selesai' => $end,
                ];
               $datax = $this->db->insert('data_jadwal',$data);
            }
        }
        echo json_encode($datax);
    }
    

    //data waktu
    public function data_waktu(){
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
						$d->id_waktu,
						$d->kode_waktu,
						$d->hari,
						$d->jam_mulai.'-'.$d->jam_selesai,
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
    function add_data_waktu(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$kode=$this->input->post('kode');
		if ($kode != "") {			
			$data=[
				'kode_kelas'=>$kode,
				'nama'=>$this->input->post('nama'),
				'kondisi' => $this->input->post('kondisi'),
				
			];
			$datax = $this->db->insert('data_waktu',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function edit_data_waktu(){
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
			$datax = $this->db->update('data_waktu',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}
    function delete_data_waktu(){
		if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$id=$this->input->post('id');
		if ($id != "") {
			$data=[
				'id_kelas'=>$id,
			];
			$datax = $this->db->delete('data_waktu',$data);
		}else{
			$datax=$this->messages->notValidParam();
		}
		echo json_encode($datax);
	}

    public function data_pengawas(){
        if (!$this->input->is_ajax_request()) 
		    redirect('not_found');
		$usage=$this->uri->segment(3);
		if ($usage == null) {
			echo json_encode('<span class="ec ec-construction"></span> Invalid Parameter');
        } else {
            if ($usage == 'view_all') {
                $data=$this->model_master->getPengawas();
				$no=1;
				$datax['data']=[];
				foreach ($data as $d) {
                    $datax['data'][]=[
                        $d->id_pengawas,
                        $d->nama_ruang,
                        $d->nama_guru,
                        
                    ];
                    $no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view_one') {
                $id = $this->input->post('id');
                if($id){
                    $data=$this->model_master->getPengawasId($id);
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
    public function proses_pengawas(){
        $jml_populasi = $this->input->post('jml_populasi');
        $probabilitas_crossover = $this->input->post('probabilitas_crossover');
        $probabilitas_mutasi = $this->input->post('probabilitas_mutasi');
        $jml_generasi = $this->input->post('jml_generasi');
        $data = [
            'jml_populasi'=>$jml_populasi,
            'crossover'=>$probabilitas_crossover,
            'mutasi'=>$probabilitas_mutasi,
            'jml_generasi'=>$jml_generasi,

        ];
        $data_input = $this->model_pengawas->generate_pengawas($data);
        if($data_input){
            $this->db->empty_table('data_pengawas');
            foreach($data_input as $d_i){
                $data = [
                    'guru' => $d_i[1],
                    'ruang' => $d_i[0],
                ];
               $datax = $this->db->insert('data_pengawas',$data);
            }
        }
        echo json_encode($datax);
    }
}
