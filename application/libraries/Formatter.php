<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * Code From GFEACORP.
     * Web Developer
     * @author      Galeh Fatma Eko Ardiansa
     * @package     Library Formatter
     * @copyright   Copyright (c) 2018 GFEACORP
     * @version     1.0, 1 September 2018
     * Email        galeh.fatma@gmail.com
     * Phone        (+62) 85852924304
     */

class Formatter {
	
	protected $CI;
	public function __construct()
	{
		$this->CI =& get_instance();
	}
//count work time
	public function getWorkTime($s)
	{
		if(empty($s)) 
			return null;
		$e=gmdate("Y-m-d", time() + 3600*(7));
		$diff = abs(strtotime($s) - strtotime($e));
		$tahun = floor($diff / (365*60*60*24));
		$bulan = floor(($diff - $tahun * 365*60*60*24) / (30*60*60*24));
		$hari = floor(($diff - $tahun * 365*60*60*24 - $bulan*30*60*60*24)/ (60*60*24));
		if ($tahun == 0) {
			$tahun=NULL;
		}else{
			if ($bulan != 0 || $hari != 0) {
				$tahun=$tahun.' Tahun, ';
			}else{
				$tahun=$tahun.' Tahun.';
			}
		}
		if ($bulan == 0) {
			$bulan=NULL;
		}else{
			if ($tahun != 0 || $hari != 0) {
				$bulan=$bulan.' Bulan, ';
			}else{
				$bulan=$bulan.' Bulan.';
			}
		}
		if ($hari == 0) {
			$hari=NULL;
		}else{
			$hari=$hari.' Hari.';
		}
		$work_t=$tahun.$bulan.$hari;
		return $work_t;
	}

//date format
	public function getMonth($version='long')
	{
		$month=[
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
		];
		if ($version == 'sort') {
			$month=[
				'01'=>'Jan',
				'02'=>'Feb',
				'03'=>'Mar',
				'04'=>'Apr',
				'05'=>'Mei',
				'06'=>'Jun',
				'07'=>'Jul',
				'08'=>'Agu',
				'09'=>'Sep',
				'10'=>'Okt',
				'11'=>'Nov',
				'12'=>'Des',
			];
		}
		return $month;
	}
	public function getNameOfMonthByPeriode($start,$end,$year)
	{
		if (empty($start) || empty($end)) 
			return null;
		$pack=[];
		$pack1=[];
		$bulan=$this->getMonth();
		$x=1;
		for ($i=1; $i <=12 ; $i++) { 
			if ($start > $end || $start == $end) {
				if ($i >= $start) {
					array_push($pack,$bulan[$this->CI->otherfunctions->addFrontZero($i)].' - '.($year-1));
				}
				if ($i<=$end) {
					array_push($pack1,$bulan[$this->CI->otherfunctions->addFrontZero($i)].' - '.$year);
				}               
			}else{
				if ($i >= $start && $i <= $end) {
					array_push($pack,$bulan[$this->CI->otherfunctions->addFrontZero($i)]);
				}
			}
		}
		$pack=array_merge($pack,$pack1);
		return $pack;
	}
	public function getQuartalList()
	{
		$var=['1'=>'Quartal 1','2'=>'Quartal 2','3'=>'Quartal 3'];
		return $var;
	}
	public function getQuartal($key)
	{
		return $this->CI->otherfunctions->getVarFromArrayKey($key,$this->getQuartalList());
	}
	public function getYear($date_first = null)
	{
		$first=2017;
		if(isset($date_first)){
			$first=$date_first;
		}
		$end=date('Y', strtotime(date('Y',strtotime($this->CI->otherfunctions->getDateNow())) . ' +2 year'));
		$date=range($first,$end);
		$year=[];
		foreach ($date as $d) {
			$year[$d]=$d;
		}
		return $year;
	}
    public function getDateFromRange($val,$param,$time='yes')
    {
        if(empty($val) || empty($param)) 
            return null;
        $ex=explode(' - ',$val);
        $new_val=null;
        if (!isset($ex))
            return null;
        if($time=='yes'){
            if ($param == 'start') {
                $new_val=$this->getDateTimeFormatDb($ex[0]);
            }elseif ($param == 'end') {
                $new_val=$this->getDateTimeFormatDb($ex[1]);
            }else{
                return null;
            }
        }else{
            if ($param == 'start') {
                $new_val=$this->getDateFormatDb($ex[0]);
            }elseif ($param == 'end') {
                $new_val=$this->getDateFormatDb($ex[1]);
            }else{
                return null;
            }
        }
        return $new_val;
    }
	public function getDateFormatDb($date)
	{
		if(empty($date)) 
			return null;
		if (!empty(strpos($date, '/'))) {
			$date=explode('/', $date);
			$date=$date[2].'-'.$date[1].'-'.$date[0];
		}elseif (!empty(strpos($date, '-'))) {
			$date=date('Y-m-d',strtotime($date));
		}		
		return $date;
	}
	public function getDateFormatDbTimeToNoTime($datetime)
	{
		if(empty($datetime)) 
			return null;
		$datetime=explode(' ', $datetime);
		$new_datetime=$datetime[0];
		return $new_datetime;
	}
	public function getDateFormatUser($date)
	{
		if(empty($date)) 
			return null;
		$date=explode('-', date('Y-m-d',strtotime($date)));
		$new_date=$date[2].'/'.$date[1].'/'.$date[0];
		return $new_date;
	}
	public function getDateMonthFormatUser($date)
	{
		if(empty($date)) 
			return null;
		$date1=explode('-', date('Y-m-d',strtotime($date)));
		$new_date=$date1[2].' '.$this->getNameOfMonth($date1[1]).' '.$date1[0];
		return $new_date;
	}
	public function getDayDateFormatUserId($date)
	{
		if(empty($date)) 
			return null;
		$date1=explode('-', date('Y-m-d',strtotime($date)));
		$new_date=$this->getNameOfDay($date).', '.$date1[2].' '.$this->getNameOfMonth($date1[1]).' '.$date1[0];
		return $new_date;
	}
	public function getDateTimeFormatDb($datetime)
	{
		if(empty($datetime)) 
			return null;
		$datetime=explode(' ', $datetime);
		$date=explode('/', $datetime[0]);
		if (isset($datetime[1])) {
			$time=$datetime[1];
		}else{
			$time='00:00:00';
		}
		$new_datetime=$date[2].'-'.$date[1].'-'.$date[0].' '.$time;
		return $new_datetime;
	}
	public function getDateTimeFormatUser($datetime)
	{
		if(empty($datetime)) 
			return null;
		$datetime=explode(' ', date('Y-m-d H:i:s',strtotime($datetime)));
		$date=explode('-', $datetime[0]);
		if (isset($datetime[1])) {
			$time=$datetime[1];
		}else{
			$time='00:00:00';
		}
		$new_datetime=$date[2].'/'.$date[1].'/'.$date[0].' '.$time;
		return $new_datetime;
	}
	public function getDateTimeMonthFormatUser($datetime)
	{
		if(empty($datetime)) 
			return null;
		$datetime=explode(' ', date('Y-m-d H:i:s',strtotime($datetime)));
		$date=explode('-', $datetime[0]);
		if (isset($datetime[1])) {
			$time=$datetime[1];
		}else{
			$time='00:00:00';
		}
		$new_datetime=$date[2].' '.$this->getNameOfMonth($date[1]).' '.$date[0].' '.$time;
		return $new_datetime;
	}
	public function getNameOfDay($date){
		if(empty($date)) 
			return null;
		$name_day = date('l',strtotime($date));
		$day = '';
		$day = ($name_day=='Sunday')?'Minggu':$day;
		$day = ($name_day=='Monday')?'Senin':$day;
		$day = ($name_day=='Tuesday')?'Selasa':$day;
		$day = ($name_day=='Wednesday')?'Rabu':$day;
		$day = ($name_day=='Thursday')?'Kamis':$day;
		$day = ($name_day=='Friday')?'Jumat':$day;
		$day = ($name_day=='Saturday')?'Sabtu':$day;
		return $day;
	}
	public function getNameOfDayByNumber($number){
		if(empty($number)) 
			return null;
		$name_day =$number;
		$day = '';
		$day = ($name_day==7)?'Minggu':$day;
		$day = ($name_day==1)?'Senin':$day;
		$day = ($name_day==2)?'Selasa':$day;
		$day = ($name_day==3)?'Rabu':$day;
		$day = ($name_day==4)?'Kamis':$day;
		$day = ($name_day==5)?'Jumat':$day;
		$day = ($name_day==6)?'Sabtu':$day;
		return $day;
	}
    public function getNameOfDayNumber($date){
        if(empty($date)) 
            return null;
        $name_day = date('l',strtotime($date));
        $day = '';
        $day = ($name_day=='Sunday')?7:$day;
        $day = ($name_day=='Monday')?1:$day;
        $day = ($name_day=='Tuesday')?2:$day;
        $day = ($name_day=='Wednesday')?3:$day;
        $day = ($name_day=='Thursday')?4:$day;
        $day = ($name_day=='Friday')?5:$day;
        $day = ($name_day=='Saturday')?6:$day;
        return $day;
    }
	public function getNameOfMonth($inputmonth)
	{
		if(empty($inputmonth)) 
			return null;
		$return = null;
		$month = strtolower(trim($inputmonth));
		switch($month){
			case '1' : $return = 'Januari'; break;
			case '01' : $return = 'Januari'; break;
			case 'januari' : $return = 'Januari'; break;
			case 'january' : $return = 'Januari'; break;
			case '2' : $return = 'Februari'; break;
			case '02' : $return = 'Februari'; break;
			case 'februari' : $return = 'Februari'; break;
			case 'february' : $return = 'Februari'; break;
			case '3' : $return = 'Maret'; break;
			case '03' : $return = 'Maret'; break;
			case 'maret' : $return = 'Maret'; break;
			case 'march' : $return = 'Maret'; break;
			case '4' : $return = 'April'; break;
			case '04' : $return = 'April'; break;
			case 'april' : $return = 'April'; break;
			case '5' : $return = 'Mei'; break;
			case '05' : $return = 'Mei'; break;
			case 'may' : $return = 'Mei'; break;
			case '6' : $return = 'Juni'; break;
			case '06' : $return = 'Juni'; break;
			case 'juni' : $return = 'Juni'; break;
			case 'june' : $return = 'Juni'; break;
			case '7' : $return = 'Juli'; break;
			case '07' : $return = 'Juli'; break;
			case 'juli' : $return = 'Juli'; break;
			case 'july' : $return = 'Juli'; break;
			case '8' : $return = 'Agustus'; break;
			case '08' : $return = 'Agustus'; break;
			case 'agt' : $return = 'Agustus'; break;
			case 'agu' : $return = 'Agustus'; break;
			case 'aug' : $return = 'Agustus'; break;
			case 'agustus' : $return = 'Agustus'; break;
			case 'august' : $return = 'Agustus'; break;
			case '9' : $return = 'September'; break;
			case '09' : $return = 'September'; break;
			case 'september' : $return = 'September'; break;
			case '10' : $return = 'Oktober'; break;
			case 'oct' : $return = 'Oktober'; break;
			case 'oktober' : $return = 'Oktober'; break;
			case 'october' : $return = 'Oktober'; break;
			case '11' : $return = 'November'; break;
			case 'nov' : $return = 'November'; break;
			case 'nopember' : $return = 'November'; break;
			case 'november' : $return = 'November'; break;
			case '12' : $return = 'Desember'; break;
			case 'dec' : $return = 'Desember'; break;
			case 'desember' : $return = 'Desember'; break;
			case 'december' : $return = 'Desember'; break;
			default : $return = $inputmonth; break;
		}
		return $return;
	}
    public function getFormatMoneyUser($var,$par=2,$sign='Rp'){
		if (empty($var) || !is_numeric($var)) {
			$var=0;
		}
		$var=(float)($var);
        $return = number_format(str_replace(",","",$var), (int)$par, ',', '.');
        return $sign."".$return;
    }
    public function getFormatMoneyDb($var){
        if(empty($var))
            return null;
        $var=strtoupper($var);
        $var= str_replace('RP', '', $var);
        $var= str_replace('.', '', $var);
		$var= str_replace(',', '.', $var);
        return (float)$var;
    }
	public function timeFormatUser($val,$usage='view')
	{
		$ret=($usage == 'excel')?null:$this->CI->otherfunctions->getMark();
		if(empty($val))
			return $ret;
		$ret=substr($val,0, -3);
		return $ret;
	}
	public function timeFormatDb($var)
	{
		if(empty($var))
			return null;
		$var=$var.':00';
		return $var;
	}
	public function getCountDateRange($start,$end)
	{
		if (empty($start) || empty($end))
            return null;
        $pack=[];
        if (!empty(strpos($start, '/'))) {
            $start=date_create($this->getDateFormatDb($start));
        }
        if (!empty(strpos($end, '/'))) {
            $end=date_create($this->getDateFormatDb($end));
        }
        $bulan=abs((date('Y', strtotime($end)) - date('Y', strtotime($start)))*12 + (date('m', strtotime($end)) - date('m', strtotime($start))));
        $start=date_create($start);
        $end=date_create($end);
        $diff=date_diff($start,$end);
         
        $diffx=$diff->format('%a');
        $tahun = ($diffx / 365) ; 
        $tahun = floor($tahun);
        $minggu= floor(($diffx+1) / 7); 
        $bulan_pay = floor($diff->format('%y') * 12 + $diff->format('%m'));
        $hari = ($diffx % 365) % 30.5;
        $pack=['tahun'=>$tahun,'bulan'=>$bulan,'bulan_pay'=>$bulan_pay,'hari'=>$hari,'minggu'=>$minggu];
        return $pack;
	}
	public function getNameOfMonthByPeriodeNum($start,$end,$year)
	{
		if (empty($start) || empty($end)) 
			return null;
		$pack=[];
		$pack1=[];
		$bulan=$this->getMonth();
		$x=1;
		for ($i=1; $i <=12 ; $i++) { 
			if ($start > $end || $start == $end) {
				if ($i >= $start) {
					array_push($pack,$this->CI->otherfunctions->addFrontZero($i));
				}
				if ($i<=$end) {
					array_push($pack1,$this->CI->otherfunctions->addFrontZero($i));
				}               
			}else{
				if ($i >= $start && $i <= $end) {
					array_push($pack,$this->CI->otherfunctions->addFrontZero($i));
				}
			}
		}
		$pack=array_merge($pack,$pack1);
		return $pack;
	}
	public function limit_words($string, $word_limit=10)
	{
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
	public function changeNilaiCustom($val,$custom = 0)
	{
		if(empty($val))
			return $custom;
		if($val>0){
			$new_val = $this->CI->formatter->getNumberFloat($val);
		}else{
			$new_val = $custom;
		}
		return $new_val;
	}
    public function zeroPadding($val)
    {
        $new_val = sprintf("%02d", $val);
        return $new_val;
    }
    public function getYearAll()
    {
        $first=1990;
        $end=date('Y', strtotime(date('Y',strtotime($this->CI->otherfunctions->getDateNow())) . ' +2 year'));
        $date=range($first,$end);
        $year=[];
        foreach ($date as $d) {
            $year[$d]=$d;
        }
        return $year;
    }
    public function getValHastagPrint($val){
        if(empty($val))
            return null;
        if (!empty($val)) {
            $ex1=explode('#',$val);
            if (isset($ex1)) {
                $new_val1=[];
                $no1=1;
                foreach ($ex1 as $exp1) {
                    $new_val1[$no1]=$no1.'. '.$exp1;
                    $no1++;
                }
                $new_val=implode('<w:br/>',$new_val1);
            }else{
                $new_val='1.'.$new_val;
            }
        }
        return $new_val;
    }
    public function getValHastagView($val){
        if(empty($val))
            return null;
        if (!empty($val)) {
            $ex1=explode('#',$val);
            if (isset($ex1)) {
                $new_val1=[];
                $no1=1;
                foreach ($ex1 as $exp1) {
                    $new_val1[$no1]=$no1.'. '.$exp1;
                    $no1++;
                }
                $new_val=implode('<br>',$new_val1);
            }else{
                $new_val='1.'.$new_val;
            }
        }
        return $new_val;
    }
    public function kataTerbilang($input_number){
        $input_number = abs($input_number);
        $number = ["", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $temp = "";

        if ($input_number < 12) {
            $temp = " " . $number[$input_number];
        } else if ($input_number < 20) {
            $temp = $this->kataTerbilang($input_number - 10) . " ".'belas';
        } else if ($input_number < 100) {
            $temp = $this->kataTerbilang($input_number / 10) . " ".'puluh' . $this->kataTerbilang($input_number % 10);
        } else if ($input_number < 200) {
            $temp = " ".'seratus' . $this->kataTerbilang($input_number - 100);
        } else if ($input_number < 1000) {
            $temp = $this->kataTerbilang($input_number / 100) . " ".'ratus' . $this->kataTerbilang($input_number % 100);
        } else if ($input_number < 2000) {
            $temp = " ".'seribu' . $this->kataTerbilang($input_number - 1000);
        } else if ($input_number < 1000000) {
            $temp = $this->kataTerbilang($input_number / 1000) . " ".'ribu' . $this->kataTerbilang($input_number % 1000);
        } else if ($input_number < 1000000000) {
            $temp = $this->kataTerbilang($input_number / 1000000) . " ".'juta' . $this->kataTerbilang($input_number % 1000000);
        } else if ($input_number < 1000000000000) {
            $temp = $this->kataTerbilang($input_number / 1000000000) . " ".'milyar' . $this->kataTerbilang(fmod($input_number, 1000000000));
        } else if ($input_number < 1000000000000000) {
            $temp = $this->kataTerbilang($input_number / 1000000000000) . " ".'trilyun' . $this->kataTerbilang(fmod($input_number, 1000000000000));
        }
        return ucwords($temp);
    }
    public function getTimeFormatUser($time, $timezone = null)
    {
        if(empty($time))
            return null;
		$zone = (!empty($timezone)) ? ' '.$timezone : '';
		if (strpos($time,'.')) {
			$timex=explode('.',$time);
			$time=$timex[0];
		}
        $new_val = substr($time,0,-3);
        return $new_val.$zone;
    }
    public function dateLoop($s,$e)
    {
        $date = $s;
        while ($date <= $e)
        {
            $m=date('m',strtotime($date));
            $d=date('d',strtotime($date));
            $y=date('Y',strtotime($date));
            $period[$y][$m][$d]=$d;
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        return $period;
	}
	public function dateLoopFull($s,$e)
    {
		$date = $s;
		$period=[];
        while ($date <= $e)
        {
            $period[$date]=$date;
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        return $period;
	}
	function dateRangeLoops($start, $end, $step = '+1 day', $format = 'Y-m-d' ) {
		// Declare an empty array 
		$array = array(); 
		
		// Variable that store the date interval 
		// of period 1 day 
		$interval = new DateInterval('P1D'); 
	
		$realEnd = new DateTime($end); 
		$realEnd->add($interval); 
	
		$period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
	
		// Use loop to store date into array 
		foreach($period as $date) {                  
			$array[] = $date->format($format);  
		} 
	
		// Return the array elements 
		return $array; 
	}
	// public function dateLoopJkb($s,$e,$shift=null)
    // {
	// 	$date = $s;
	// 	if (isset($shift)) {
	// 		$re=[];
	// 		$i=1;
	// 		foreach ($shift as $key => $value) {
	// 			foreach ($value as $v) {
	// 				$re[$i][$key]=$value;
	// 				$i++;
	// 			}
	// 		}
	// 	}
		
	// 	$start=1;
    //     while ($date <= $e)
    //     {
    //         $m=date('m',strtotime($date));
    //         $d=date('d',strtotime($date));
	// 		$y=date('Y',strtotime($date));
	// 		if (isset($shift)) {
	// 			foreach ($shift as $kode_shift=>$day_shift) {
    //                 if (in_array($this->getNameOfDayNumber($date),$day_shift)) {
	// 					$period[$y][$m][$d]=$kode_shift;
	// 				}
	// 			}
	// 		}
    //         if (isset($re[$start])) {
    //             foreach ($re[$start] as $kk=>$day) {
    //                 if (in_array($this->getNameOfDayNumber($date),$day)) {
	// 					$period[$y][$m][$d]=$kk;
	// 				}					
	// 			}
	// 			if ($start == count($re)) {
	// 				$start=1;
	// 			}else{
	// 				$start++;
	// 			}
	// 		}
	// 		if(!isset($shift) && !isset($re)){
    //             $period[$y][$m][$d]=$d;
    //         }
	// 		$date = date('Y-m-d', strtotime($date . ' +1 day'));
			
    //     }
    //     return $period;
	// }
    public function dateLoopJkb($s,$e,$shift=null)
    {
		$s=$this->getDateFormatDb($s);
		$e=$this->getDateFormatDb($e);
		$date = $s;
		if (isset($shift)) {
			$re=[];
			$i=1;
			foreach ($shift as $key => $value) {
				foreach ($value as $v) {
					$re[$i][$key]=$value;
					$i++;
				}
			}
		}
		$period=[];
		$start=1;
        while ($date <= $e)
        {
            $m=date('m',strtotime($date));
            $d=date('d',strtotime($date));
			$y=date('Y',strtotime($date));
			if (isset($shift)) {
				foreach ($shift as $kode_shift=>$day_shift) {
                    if (in_array($this->getNameOfDayNumber($date),$day_shift)) {
						$period[$date]=$kode_shift;
					}
				}
			}
            if (isset($re[$start])) {
                foreach ($re[$start] as $kk=>$day) {
                    if (in_array($this->getNameOfDayNumber($date),$day)) {
						$period[$date]=$kk;
					}					
				}
				if ($start == count($re)) {
					$start=1;
				}else{
					$start++;
				}
			}
			if(!isset($shift) && !isset($re)){
                $period[$date]=$d;
            }
			$date = date('Y-m-d', strtotime($date . ' +1 day'));
			
        }
        return $period;
	}
	public function count_days_schedule($s,$e,$shift,$date_val)
	{
		$date = $s;
		$r=[];
		foreach ($shift as $key => $value) {
			$r[$key]=count($value);
		}
		$max=array_sum($r);
		$ss=1;
		$ret=null;
		while ($date <= $e)
        {
			$d=date('d',strtotime($date));
            foreach ($r as $k_r => $v_r) {
				if ($ss < $max) {
					if ($d == $date_val) {
						$ret=$k_r;
						$ss++;
					}
				}
				if($ss == $v_r){
					$ss=1;
				}
			}
            
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
		}
		return $ret;
	}
    public function getPeriodeJadwal($range,$shift)
    {
        if (empty($range))
            return null;
        $ex=explode(' - ',$range);
        if (!isset($ex))
            return null;
        $start_date=$this->getDateTimeFormatDb($ex[0]);
		$end_date=$this->getDateTimeFormatDb($ex[1]);
        $periode=$this->dateLoopJkb($start_date,$end_date,$shift);
        return $periode;
    }
    public function getCols2($x)
    {
        $cols=[];
        $j=1;
        for ($i=1; $i <=31 ; $i++) { 
            if ($i < 10) {
                $i='0'.$i; 
            }
            $cols[$i]='tgl_'.$j;
            $j++;
        }
        return $cols[$x];
    }
    public function getDateCols($x)
    {
        $cols=[];
        $j=1;
        for ($i=1; $i <=31 ; $i++) { 
            if ($i < 10) {
                $i='0'.$i;
            }
            $cols['tgl_'.$j]=$i;
            $j++;
        }
        return $cols[$x];
    }
    public function getFormatManyDays($val_db)
    {
        //val_db bisa bertipe array dan struktur data data;data;data;
        if(empty($val_db))
            return null;
        if (is_array($val_db)) {
            $d=$val_db;
        }else {
            $d=explode(';', $val_db);
        }
        $sub='';
        $hari=[
            1=>"SENIN",
            2=>"SELASA",
            3=>"RABU",
            4=>"KAMIS",
            5=>"JUM'AT",
            6=>"SABTU",
            7=>"MINGGU",
        ];
        $c=1;
        if (isset($d)) {
            $dif=[];$full=[];
            foreach ($d as $v_d) {
                if (isset($hari[$v_d])) {
                    $sub.=$hari[$v_d];
                    $dif[$v_d]=$hari[$v_d];
                    if ($c < count($d)) {
                        $sub.=', ';
                    }
                } 
                if (isset($hari[$c])) {
                    $full[$c]=$hari[$c];
                }
                $c++;
            }
            $missing = array_diff($full,$dif);
            if (count($missing) == 0) {
                if (isset($hari[min($d)]) && isset($hari[max($d)])) {
                    $sub=$hari[min($d)].' - '.$hari[max($d)];
                }
            }
        }
        return $sub;
    }
	public function getMonthFromNameMonth($inputmonth)
	{
		if(empty($inputmonth)) 
			return null;
		$return = null;
		switch($inputmonth){
			case 'Jan' : $return = '01'; break;
			case 'Feb' : $return = '02'; break;
			case 'Mar' : $return = '03'; break;
			case 'Apr' : $return = '04'; break;
			case 'May' : $return = '05'; break;
			case 'Jun' : $return = '06'; break;
			case 'Jul' : $return = '07'; break;
			case 'Aug' : $return = '08'; break;
			case 'Sep' : $return = '09'; break;
			case 'Oct' : $return = '10'; break;
			case 'Nov' : $return = '11'; break;
			case 'Dec' : $return = '12'; break;
		}
		return $return;
	}
	public function getYearFromNameYear($inputyear)
	{
		if(empty($inputyear)) 
			return null;
		$return = null;
		switch($inputyear){
			case '18' : $return = '2018'; break;
			case '19' : $return = '2019'; break;
			case '20' : $return = '2020'; break;
			case '21' : $return = '2021'; break;
			case '22' : $return = '2022'; break;
			case '23' : $return = '2023'; break;
			case '24' : $return = '2024'; break;
			case '25' : $return = '2025'; break;
			// for ($i=0; $i <= $inputyear ; $i++) {
			// 	case $inputyear : $return = '20'$inputyear; break;
			// }
		}
		return $return;
	}
	public function getDateFormatDBMonthName($date_time)
	{
		if(empty($date_time)) 
			return null;
		$datetime=explode(' ',$date_time);
		$date=explode('-',$datetime[0]);
		$new_date=$this->getYearFromNameYear($date[2]).'-'.$this->getMonthFromNameMonth($date[1]).'-'.$date[0];
		return $new_date;
	}
	public function jam($time,$int,$op)
    {
        if ($op == '-') {
           $jam=strtotime($time) - (60*60*$int); 
        }else{
            $jam=strtotime($time) + (60*60*$int);
        }
        return date('H:i:s',$jam);
	}
	public function difHalfTime($s,$e)
    {
        $s=strtotime($s);
        $e=strtotime($e);
        $dif=($e-$s);
        if ($e<$s) {
            $half=((($dif/60)/60)+24)/2;
        }else{
            $half=((($dif/60)/60))/2;
        }
        return $half;
	}
	public function getDivTime($start,$end)
    {
        if ($start == NULL || $end == NULL) {
            $time='-';        
        }else{
            $s = strtotime($start);
            $e=  strtotime($end);
            if ($s < $e) {
                $diff= $e-$s;
            }else{
                $s=self::jam($start,24,'+');
                $s=strtotime($s);
                $diff= $e-$s;
            }
            $time= gmdate("H:i",$diff);
        }
        return $time;
    }
    public function getTimeDb($time)
    {
        $time=str_replace('.', ':', $time);
        $time=date('H:i:s',strtotime($time));
        return $time;
    }
    public function getColumn($val,$param)
    {
        $cols=[];
        $j=1;
        for ($i=1; $i <=31 ; $i++) { 
            if ($i < 10) {
                $i='0'.$i; 
            }
            $cols[$i]=$param.$j;
            $j++;
        }
        return $cols[$val];
	}
	public function getMaxDaysInMonth($bulan,$tahun)
	{
		if (empty($bulan) || empty($tahun))
			return 0;
		return cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
	}
	public function getClockUserAngka($data,$limit=2)
    {   
        if ($data != NULL) {
            $jam=explode(':', $data);
            $jamx=(float)$jam[0]+($jam[1]/60);
            $jamx=number_format($jamx,$limit);
        }else{
            $jamx=0;
        }
        return $jamx;
	}	
	public function getDateFormatAgo($timestamp)
	{
		$selisih = strtotime($this->CI->otherfunctions->getDateNow()) - strtotime($timestamp);
		$detik = $selisih ;
		$menit = round($selisih / 60 );
		$jam = round($selisih / 3600 );
		$hari = round($selisih / 86400 );
		$minggu = round($selisih / 604800 );
		$bulan = round($selisih / 2419200 );
		$tahun = round($selisih / 29030400 );
		if ($detik <= 60) {
			$waktu = $detik.' detik yang lalu';
		} else if ($menit <= 60) {
			$waktu = $menit.' menit yang lalu';
		} else if ($jam <= 24) {
			$waktu = $jam.' jam yang lalu';
		} else if ($hari <= 7) {
			$waktu = $hari.' hari yang lalu';
		} else if ($minggu <= 4) {
			$waktu = $minggu.' minggu yang lalu';
		} else if ($bulan <= 12) {
			$waktu = $bulan.' bulan yang lalu';
		} else {
			$waktu = $this->getDateTimeMonthFormatUser($timestamp);
		}
		return $waktu;
	}
}
?>
