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
                        $d->nama_kelas,
                        $d->jam_mulai.'-'.$d->jam_selesai,
                        $d->nama_mapel,
                    ];
                    $no++;
				}
				echo json_encode($datax);
            } elseif ($usage == 'view') {
                    $table='';
                    $no=1;
                    $ruangs= [];
                    $pws= [];
                    $pengawas=$this->model_master->getPengawas();
                    $kelas=$this->model_master->getListKelas();
                    $data=$this->model_master->getJadwalArray();
                    foreach($pengawas as $p){
                        foreach($kelas as $k){
                            if($p->kelas == $k->kode_kelas){
                                $ruangs[$p->kelas][] = $p->nama_ruang;
                                $pws[$p->kelas][] = $p->nama_guru;
                            }
                        }
                    }
                    foreach ($data as $key => $d) {
                        
                        $table .= '<tr>
                                    <td>'.$no++.'</td>
                                    <td>'.$d['hari'].'</td>
                                    <td>'.$d['nama_kelas'].'</td>
                                    <td>'.$d['jam_mulai'].' - '.$d['jam_selesai'].'</td>
                                    <td>'.$d['nama_mapel'].'</td>
                                    <td><p>
                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#ruang'.$d['id_jadwal'].'" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Detail
                                    </a>
                                    </p>
                                    <div class="collapse" id="ruang'.$d['id_jadwal'].'" style="max-height: 120px; overflow:auto;">
                                        <table class="table table-bordered">
                                            <tbody>';
                                            foreach($ruangs as $key => $r){
                                                if($key == $d['kelas']){
                                                    for($i=0;$i<count($r);$i++){
                                                        $table .= '<tr><td>'.$r[$i].'</td><td>'.$pws[$key][$i].'</td></tr>';
                                                    }
                                                }
                                            }
                                            $table .= '</tbody>
                                        </table>
                                    </div>
                                    </td>
                                </tr>';
                        $datax = [
                            'table' => $table,
                        ];
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
        $data_input = $this->model_global2->generate_jadwal($data);
        if($data_input){
            $this->db->empty_table('data_jadwal');
            foreach($data_input as $d_i){
                $data = [
                    'mapel' => $d_i[0],
                    'hari' => $d_i[1],
                    'jam' => $d_i[2],
                    'kelas' => $d_i[3],
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
                        $d->nama_kelas,
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
                    'kelas' => $d_i[2],
                ];
               $datax = $this->db->insert('data_pengawas',$data);
            }
        }
        echo json_encode($datax);
    }
}
