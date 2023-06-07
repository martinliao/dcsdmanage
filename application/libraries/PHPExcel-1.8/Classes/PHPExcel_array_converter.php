<?php
class PHPExcel_array_converter{

	/*
		建構子要求輸入路徑名稱
	*/

		
	private $objReader,
			$objLoad,
			$source_type="";

	public	$array,
			$helper;

	//可預設讀取資料，並抓出
	function __construct($file_path = '')
	{
		$this->helper = new helper();


		$file_path = iconv('UTF-8','Big5//IGNORE',trim($file_path));
		//$switch選擇要讀EXCEL檔或CSV檔
		include("PHPexcel.php");
		require_once("PHPExcel/IOFactory.php");
		if(file_exists($file_path))
		{
			$inputFileType = PHPExcel_IOFactory::identify($file_path);
			// echo $inputFileType;
			// die();
			switch ($inputFileType)
			{
				case 'CSV':
					$objReader = PHPExcel_IOFactory::createReader('CSV')->setDelimiter(',')
														->setEnclosure('"')
														->setLineEnding("\r\n")
														->setSheetIndex(0);
					$this->source_type = 'csv';
					break;
				
				case 'excel':
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$this->source_type = 'excel';
					break;

				case 'Excel2007':
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$this->source_type = 'excel';
					break;

				default:
					die('file type doesn\'t exists');
					break;
			}

			$this->objReader=$objReader;//利用switch 設定reader
			//這個時候甚麼值都還沒有，要記得load_file()


			$this->load_file($file_path);
		}
    }



    // 讀取檔案，並轉換資料。
    private function load_file($file_path)
    {
		$load = $this->objReader->load($file_path);
		$this->objLoad=$load;

		//用construct預設public的值
		$this->array = $load->getSheet(0)->toArray(null, true, true, true);//不管怎樣就是把他轉成array就對了
    }



    public function check_format($start='',$end='',$ignor='')
    {
    	if($start=='' || $end =='')
    		return false;

    	$start_num = $this->helper->feild_eng_to_num($start);
    	$end_num = $this->helper->feild_eng_to_num($end);

    	$check=$this->array;

    	if(!empty($ignor) && is_array($ignor))
    	{
    		foreach ($ignor as $key => $ignor_row)
    		{
    			unset($check[$ignor_row]);
    		}
    	}

    	foreach ($check as $row => $row_data)
    	{
    		foreach ($row_data as $field => $data)
    		{
    			$fieldID=$this->helper->feild_eng_to_num($field);
    			if(($fieldID<$start_num) || $fieldID>$end_num)
    				return false;
    		}
    	}

    	return true;
    }
}

class helper
{
	function feild_num_to_eng($input_number='')
	{
		//不能從0開始計，而且只接受數字
		if($input_number==0 || !is_numeric($input_number))
			{return false;}

		$output='';

		$mod_array=array(
			'1'=>'A',
			'2'=>'B',
			'3'=>'C',
			'4'=>'D',
			'5'=>'E',
			'6'=>'F',
			'7'=>'G',
			'8'=>'H',
			'9'=>'I',
			'10'=>'J',
			'11'=>'K',
			'12'=>'L',
			'13'=>'M',
			'14'=>'N',
			'15'=>'O',
			'16'=>'P',
			'17'=>'Q',
			'18'=>'R',
			'19'=>'S',
			'20'=>'T',
			'21'=>'U',
			'22'=>'V',
			'23'=>'W',
			'24'=>'X',
			'25'=>'Y',
			'0'=>'Z'
			);


		$quotient=(int)($input_number/26);
		$remainder = $input_number%26;


		if($remainder == 0 )
			{$quotient--;}

		$output = $mod_array[$remainder].$output;

		if($quotient>=26)
			{$output=$this->feild_num_to_eng($quotient).$output;}
		elseif($quotient!=0)
			{$output=$mod_array[$quotient].$output;}

		return $output;
	}

	function feild_eng_to_num($input_eng='')
	{
		//只能給英文
		if($input_eng=='' || (!preg_match('/^[a-zA-Z]+$/', $input_eng)))
			return false;

		$A=$a=1;
		$B=$b=2;
		$C=$c=3;
		$D=$d=4;
		$E=$e=5;
		$F=$f=6;
		$G=$g=7;
		$H=$h=8;
		$I=$i=9;
		$J=$j=10;
		$K=$k=11;
		$L=$l=12;
		$M=$m=13;
		$N=$n=14;
		$O=$o=15;
		$P=$p=16;
		$Q=$q=17;
		$R=$r=18;
		$S=$s=19;
		$T=$t=20;
		$U=$u=21;
		$V=$v=22;
		$W=$w=23;
		$X=$x=24;
		$Y=$y=25;
		$Z=$z=26;

		$each_array=preg_split('//', $input_eng, -1, PREG_SPLIT_NO_EMPTY);
		$each_array=array_reverse($each_array);

		

		$output=0;
		foreach ($each_array as $poewr => $eng)
		{
			$output+=$$eng*pow(26,$poewr);
		}

		return $output;
	}
}