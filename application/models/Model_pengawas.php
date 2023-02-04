<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Model_pengawas extends CI_Model
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

	public function generate_pengawas($data)
    {
        $crosover=[];
        $guru= $this->model_master->getListGuruArray();
        $ruangs= $this->model_master->getListRuangArray();
        $kelas= $this->model_master->getListKelasArray();
        foreach($kelas as $kls){
            $data['kelas'][]=$kls['kode_kelas'];
        }
        foreach($ruangs as $ruang){
            $data['ruang'][]=$ruang['kode_ruang'];
        }
        foreach($guru as $gr){
            $data['guru'][]=$gr['kode_guru'];
        }
        foreach($data['ruang'] as $key => $ruang){
            for($i=0;$i<(2);$i++){
                $rg[] = $data['ruang'][$key];
            }
        }
        foreach($data['kelas'] as $key => $kls){
            for($i=0;$i<(12);$i++){
                $kl[] = $data['kelas'][$key];
            }
        }
        $populasi =  $this->inisialisasi($data['jml_populasi'],$data['guru'],$rg,$kl);
        for($i =0;$i < $data['jml_generasi'];$i++){
            $fitness = $this->HitungFitness($data['jml_populasi'],$populasi,$data);
            $selected = $this->rouletteWheelSelection($populasi,$fitness);
            for ($i = 0; $i < count($selected); $i += 2) {
                if(isset($selected[$i+1])){
                    $new_generation=$this->onePointCrossover($selected[$i],$selected[$i+1],$data['crossover']);
                }
            }
            // Perform mutation on the offspring
            $new_fitness_values = $this->mutasi_coba($new_generation, $data['mutasi'], $data['guru'],$rg,$kl,$data);
            $new_generation = $this->individu;
            $best_chromosome = $this->evaluate($new_generation, $new_fitness_values);
            if ($best_chromosome != null) {
            // Jika sudah, kembalikan individu terbaik sebagai solusi terbaik
                return $best_chromosome;
                break;
            }
            $populasi = $new_generation;
        }
    }
    
    public function inisialisasi($jml_populasi,$guru,$ruangs,$kelas){
        // Inisialisasi populasi awal
        $population = array();
        for ($i = 0; $i < $jml_populasi; $i++) {
            $schedule = array();
                for($j=0;$j<count($kelas);$j++){
                    $class = array(
                    0 => $ruangs[$j],
                    1 => isset($guru[$j])?$guru[$j]:$guru[array_rand($guru)],
                    2 => isset($kelas[$j])?$kelas[$j]:$kelas[array_rand($kelas)],
                    );
                    $schedule[$j] = $class;
                }
        $population[] = $schedule;
        }
        return $population;
    }
    function CekFitness($count_ind,$individu,$data) {
        $penalty = 0;
        $jml_ruang = count($data['ruang'])*2;
        $jml_guru = count($data['guru']);
        $jml_kelas = count($data['kelas']);
        for ($i = 0; $i < ($jml_kelas); $i++){
            $ruang = $individu[$count_ind][$i][0];
            $guru = $individu[$count_ind][$i][1];
            $kelas = $individu[$count_ind][$i][2];
            //mapel dalam satu hari berbeda         
            for ($j = 0; $j < ($jml_kelas); $j++){
                $ruangB = $individu[$count_ind][$j][0];
                $guruB = $individu[$count_ind][$j][1];
                $kelasB = $individu[$count_ind][$j][2];
                if ($i == $j)
                continue;
                if($guru == $guruB && $kelas == $kelasB){
                    $penalty +=1;
                }
            }  
        }
      
        $fitness = 1/(1+($penalty/$jml_ruang));
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
                $child1[$i] = $chromosome1[$i];
                $child2[$i] = $chromosome2[$i];
            } else {
                $child1[$i] = $chromosome2[$i];
                $child2[$i]= $chromosome1[$i];
            }
          }
          return array($child1, $child2);
    }
    public function StartCrossOver($jumlah_populasi,$crossover,$individu,$data)
    {
        $populasi       = $jumlah_populasi;
        $individu_baru = array(array(array()));
        $jml_mapel = count($data['mapel']);
        for ($i = 0; $i < $populasi; $i+=2) //perulangan untuk jadwal yang terpilih
        {
            $b = 0;
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            //Two point crossover
            if (floatval($cr) < floatval($crossover)) {
                //ketika nilai random kurang dari nilai probabilitas pertukaran
                //maka jadwal mengalami prtukaran
                
                $a = mt_rand(0, $jml_mapel - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jml_mapel - 1);
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
                for ($j = $b; $j < $jml_mapel; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else { 
                //Ketika nilai random lebih dari nilai probabilitas pertukaran, maka jadwal baru sama dengan jadwal terpilih
                for ($j = 0; $j < $jml_mapel; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k]     = $individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }
        
        $jml_mapel = count($data['mapel']);
        for ($i = 0; $i < $populasi; $i += 2) {
          for ($j = 0; $j < $jml_mapel ; $j++) {
            for ($k = 0; $k < 4; $k++) {
                $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
            }
          }
        }
    }
    // Function to perform mutation
    function mutasi_coba($individual, $mutation_rate, $guru,$ruang,$kelas,$data) {

        for ($i = 0; $i < count($individual); $i++) {
            for ($j = 0; $j < count($kelas); $j++) {
                // Check if the class should be mutated
                if (rand(0, 1) < $mutation_rate) {
                    // Mutate the class by randomly assigning a new mapel, hari, kelas,jam
                   $this->individu[$i][$j][0] = $ruang[$j];
                   $this->individu[$i][$j][1] = $guru[array_rand($guru)];
                   $this->individu[$i][$j][2] = $kelas[$j];
                }else{
                    $this->individu[$i][$j][0] = $individual[$i][$j][0];
                    $this->individu[$i][$j][1] = $individual[$i][$j][1];
                    $this->individu[$i][$j][2] = $individual[$i][$j][2];
                }
            }
            $fitness[$i]=$this->CekFitness($i,$this->individu,$data);
        }
        return $fitness;
    }
    function evaluate($generation, $fitness_values) {
        // Inisialisasi indeks individu terbaik dengan 0
        $best_chromosome_index = 0;
        // Cari indeks individu terbaik dari seluruh individu di generasi
        for ($i = 0; $i < count($generation); $i++) {
          if ($fitness_values[$i] > $fitness_values[$best_chromosome_index]) {
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
      function reproduce($selected,$mutasi,$crosover,$guru,$ruang,$data) {
        $new_generation = array();
        for ($i = 0; $i < count($selected); $i += 2) {
          // Kawinkan individu terpilih dengan menggunakan teknik one point crossover
          $crossover_result = $this->onePointCrossover($selected[$i], $selected[$i+1],$crosover);
          // Flatten hasil crossover menjadi array individu
          $new_generation = array_merge($new_generation, $crossover_result);
        }
        // Terapkan proses mutasi pada individu-individu di dalam generasi baru
        $new_fitness_values = $this->mutasi_coba($new_generation, $mutasi, $guru,$ruang,$data);
        return $new_generation;
      }
}