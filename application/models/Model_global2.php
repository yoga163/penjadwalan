<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_global2 extends CI_Model
{
    private $induk = array();
    private $individu = array(array(array()));

	function __construct()
	{
		parent::__construct();
	}
    public function countOnlyDay($start,$end)
	{
		$end = strtotime($end);
		$start = strtotime($start);
		$datediff = $end - $start;
		return round(($datediff / (60 * 60 * 24))+1);
	}

	public function generate_jadwal($data)
    {
        $hari=$data['date'];
        $crosover=[];
        $data['mapel']= $this->model_master->getListMapelArray();
        $kelas= $this->model_master->getListKelasArray();
        $jams= $this->model_master->getListJamArray();
        $jml_mapel = count($data['mapel']);
        $jadwal = ['mapel','hari','kelas','jam'];
        foreach($kelas as $kls){
            $data['kelas'][]=$kls['kode_kelas'];
        }

        foreach($jams as $jam){
            $data['jam'][]=$jam['kode_jam'];
        }
        foreach($data['mapel'] as $mapel){
            $mpl[]=$mapel['kode_mapel'];
        }
        $a = 0;
        $jm = [];
        foreach($mpl as $key => $mapl){ // iterate over your original array
            for($i=0;$i<(count($data['jam']));$i++){ // loop 5 times
                $mpl2[] = $mpl[$key];
                $jm = array_merge($jm, array_fill(0, 3, $data['jam'][$i]));
            }
            for($i=0;$i<(count($data['kelas']));$i++){ // loop 5 times
                $kels[] = $data['kelas'][$i];
            }
        }
        foreach($data['date'] as $key => $date2){ // iterate over your original array
            for($i=0;$i<(count($data['jam'])*count($data['kelas']));$i++){ // loop 5 times
                $hr[] = $data['date'][$key];
            }
        }
        shuffle($mpl2); 
        $data['mapel'] = $mpl2;
        $populasi =  $this->inisialisasi($data['jml_populasi'],$hr,$mpl2,$kels,$jm);
        for($i =0;$i <= $data['jml_generasi'];$i++){
            $fitness = $this->HitungFitness($data['jml_populasi'],$populasi,$data);
            // $selected = $this->rouletteWheelSelection($populasi,$fitness);
            $this->Seleksi($fitness,$data['jml_populasi'],$populasi);
                // $crosover_result=$this->onePointCrossover($selected[$i],$selected[$i+1],$data['crossover']);
            $this->StartCrossOver($data['jml_populasi'],$data['crossover'],$populasi,$data);
            $new_generation = $this->individu;
            // // // Perform mutation on the offspring
            $new_fitness_values = $this->mutasi_coba($new_generation, $data['mutasi'], $hr,$mpl2,$kels,$jm,$data);
            $new_generation = $this->individu;
            $best_chromosome = $this->evaluate($new_generation, $new_fitness_values);
            if ($best_chromosome != null) {
            // Jika sudah, kembalikan individu terbaik sebagai solusi terbaik
                return $best_chromosome;
                break;
            }
            $populasi = $new_generation;
        }
        // return $best_chromosome;
    }
    
    public function inisialisasi($jml_populasi,$hari,$mapel,$kelas,$jam){
        // Inisialisasi populasi awal
        $population = array();
        for ($i = 0; $i < $jml_populasi; $i++) {
            $schedule = array();
                for ($j = 0; $j < (count($mapel)); $j++) {
                    $class = array(
                    0 => $mapel[$j],
                    1 => $hari[$j],
                    2 => $jam[$j],
                    3 => $kelas[$j],
                    );
                    $schedule[$j] = $class;
                }
        $population[] = $schedule;
        }
        return $population;
    }
    function CekFitness($count_ind,$individu,$data) {
        $hari=[1,2,3,4,5];
        $penalty = 0;
        $jml_mapel = count($data['mapel']);
        $jml_hari = count($data['date']);
        $jml_jam = count($data['jam']);
        $jml_kelas = count($data['kelas']);
        for ($i = 0; $i < ($jml_mapel); $i++){
            $mapel = $individu[$count_ind][$i][0];
            $hari_i = $individu[$count_ind][$i][1];
            $jam = $individu[$count_ind][$i][2];
            $kelas = $individu[$count_ind][$i][3];
            //mapel dalam satu hari berbeda         
            for ($j = 0; $j < ($jml_mapel); $j++){
                $mapelB = $individu[$count_ind][$j][0];
                $hari_iB = $individu[$count_ind][$j][1];
                $jamB = $individu[$count_ind][$j][2];
                $kelasB = $individu[$count_ind][$j][3];
                if ($i == $j)
                continue;
                #cek hari, jam sama
                if($kelas == $kelasB && $jam == $jamB && $mapel == $mapelB){
                    $penalty +=1;
                }
            }  
        }
      
        $fitness = 1/(1+($penalty/($jml_mapel)));
        return $fitness;
    }
    public function HitungFitness($jumlah_populasi,$individu,$data)
    {
		$populasi = $jumlah_populasi;
        for ($indv = 0; $indv < $populasi; $indv++)
        {            
            $fitness[$indv] = $this->CekFitness($indv,$individu,$data);
        }
        return $fitness;
    }
    
    function rouletteWheelSelection($population, $fitness_values) {
        // Hitung total nilai fitness dari seluruh individu
        $total_fitness = array_sum($fitness_values);
        
        // Tentukan ruang untuk setiap individu pada roda keberuntungan
        $probabilities = array();
        foreach ($fitness_values as $fitness) {
          $probabilities[] = $fitness / $total_fitness;
        }
      
        // Tentukan individu terpilih dengan menggunakan roda keberuntungan
        $selected = array();
        for ($i = 0; $i < count($population); $i++) {
          $r = rand(0, 1);
          $cumulative_probability = 0;
          for ($j = 0; $j < count($population); $j++) {
            $cumulative_probability += $probabilities[$j];
            if ($r <= $cumulative_probability) {
              $selected[] = $population[$j];
              break;
            }
          }
        }
      
        return $selected;
      }
    public function Seleksi($fitness,$jumlah_populasi,$individu)
    {
		$populasi = $jumlah_populasi;
        $jumlah = 0;
        $rank   = array();
        
        for ($i = 0; $i < $populasi; $i++)
        {
          //proses ranking berdasarkan nilai fitness
            $rank[$i] = 1;
            for ($j = 0; $j < $populasi; $j++)
            {
              //ketika nilai fitness jadwal sekarang lebih dari nilai fitness jadwal yang lain,
              //ranking + 1;
              //if (i == j) continue;
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);
                
                if ( $fitnessA > $fitnessB)
                {
                    $rank[$i] += 1;
                }
            }
            
            $jumlah += $rank[$i];
        }
        
        $jumlah_rank = count($rank);
        for ($i = 0; $i < $populasi; $i++)
        {
            //proses seleksi berdasarkan ranking yang telah dibuat
            //int nexRandom = random.Next(1, jumlah);
            //random = new Random(nexRandom);
            $target = mt_rand(0, $jumlah - 1);           
            $cek    = 0;
            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
        
    }     
    // function onePointCrossover($chromosome1, $chromosome2) {
    //     // Pilih titik crossover secara acak
    //     $point = mt_rand(0, count($chromosome1) - 1);
    //     // Buat individu baru dengan mengambil bagian depan dari individu pertama dan bagian belakang dari individu kedua
    //     $new_chromosome1 = array_merge(array_slice($chromosome1, 0, $point), array_slice($chromosome2, $point));
    //     // Buat individu baru dengan mengambil bagian depan dari individu kedua dan bagian belakang dari individu pertama
    //     $new_chromosome2 = array_merge(array_slice($chromosome2, 0, $point), array_slice($chromosome1, $point));
    //     return array($new_chromosome1, $new_chromosome2);
    // }
    function onePointCrossover($chromosome1, $chromosome2,$crossover) {
        // Inisialisasi array anak
        $child1 = array();
        $child2 = array();
        // Lakukan crossover pada dua individu
        for ($i = 0; $i < count($chromosome1); $i++) {
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            if (floatval($cr) < floatval($crossover)) {
                $cutoff_point = rand(0, count($chromosome1) - 1);
                $child1[$i] = $chromosome1[$i+1];
                $child2[$i+1] = $chromosome2[$i];
            }else{
                $child1[$i] = $chromosome1[$i];
                $child2[$i] = $chromosome2[$i];
            }
          }
          return array($child1, $child2);
    }
    public function StartCrossOver($jumlah_populasi,$crossover,$individu,$data)
    {
        $populasi       = $jumlah_populasi;
        $individu_baru = array(array(array()));
        $jml_mapel = count($data['mapel']);
        $jml_kelas = count($data['kelas']);
        for ($i = 0; $i < $populasi; $i+=2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            //Two point crossover
            if (floatval($cr) < floatval($crossover)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, ($jml_mapel) - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, ($jml_mapel) - 1);
                }
                
                // var_dump($this->induk);
                //penentuan jadwal baru dari awal sampai titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {                        
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
                
                //Penentuan jadwal baru dari titik pertama sampai titik kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i]][$j][$k];
                    }
                }
                
                //penentuan jadwal baru dari titik kedua sampai akhir
                for ($j = $b; $j < ($jml_mapel); $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { 
                //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < ($jml_mapel); $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $jml_mapel = count($data['mapel']);
        for ($i = 0; $i < $populasi; $i += 2) {
          for ($j = 0; $j < ($jml_mapel) ; $j++) {
            for ($k = 0; $k < 4; $k++) {
                $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
            }
          }
        }
    }
    // Function to perform mutation
    function mutasi_coba($individual, $mutation_rate, $hari,$mapel,$kelas,$jam,$data) {
        for ($i = 0; $i < count($individual); $i++) {
            for ($j = 0; $j < count($mapel); $j++) {
                // Check if the class should be mutated
                if (rand(0, 1) < $mutation_rate) {
                    // Mutate the class by randomly assigning a new mapel, hari, kelas,jam
                   $this->individu[$i][$j][0] = $mapel[$j];
                   $this->individu[$i][$j][1] = $hari[$j];
                   $this->individu[$i][$j][2] = $jam[$j];
                   $this->individu[$i][$j][3] = $kelas[$j];
                }else{
                    $this->individu[$i][$j][0] = $individual[$i][$j][0];
                    $this->individu[$i][$j][1] = $individual[$i][$j][1];
                    $this->individu[$i][$j][2] = $individual[$i][$j][2];
                    $this->individu[$i][$j][3] = $individual[$i][$j][3];
                }
            };
            $fitness[$i]=$this->CekFitness($i,$this->individu,$data);
        }
        return $fitness;
    }
    function evaluate($generation, $fitness_values) {      
        // Inisialisasi indeks individu terbaik dengan 0
        $best_chromosome_index = 0;
        // Cari indeks individu terbaik dari seluruh individu di generasi
        for ($i = 1; $i < count($generation); $i++) {
          if ( $fitness_values[$i] == 1) {
                $best_chromosome_index = $i;
          }
        }
        
        // Kembalikan individu terbaik dari generasi
        return $generation[$best_chromosome_index];
      }
    // function evaluate($generation, $fitness_values, $min_fitness) {
    //     $best_chromosome = $generation[0];
    //     $best_fitness = $fitness_values[0];
    //     for ($i = 1; $i < count($generation); $i++) {
    //       if ($fitness_values[$i] > $best_fitness) {
    //         $best_chromosome = $generation[$i];
    //         $best_fitness = $fitness_values[$i];
    //       }
    //     }
    //     return $best_chromosome;
    //   }
      function reproduce($selected,$mutasi,$crosover,$hari,$mapel,$kelas,$jam,$data) {
        $new_generation = array();
        for ($i = 0; $i < count($selected); $i += 2) {
          // Kawinkan individu terpilih dengan menggunakan teknik one point crossover
          $crossover_result = $this->onePointCrossover($selected[$i], $selected[$i+1],$crosover);
          // Flatten hasil crossover menjadi array individu
          $new_generation = array_merge($new_generation, $crossover_result);
        }
        // Terapkan proses mutasi pada individu-individu di dalam generasi baru
        $new_fitness_values = $this->mutasi_coba($new_generation, $mutasi, $hari,$mapel,$kelas,$jam,$data);
        return $new_generation;
      }
}