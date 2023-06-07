<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Taipei');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel-1.8/Classes/PHPExcel.php';

class Download_xlsx
{
	public function Volunteer_sign_report_output($category,$detail,$name,$month_start,$month_end,$year)
	{
// seedata($category,1);
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
// echo dirname(__FILE__) . '/./PHPExcel-1.8/Classes/PHPExcel.php'; die;
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		foreach ($category as $row => $value)
		{
			if ($value['id'] == "1")
			{
				$page = $row +1; //第幾分頁

				$objWorkSheet = $objPHPExcel->createSheet($page); 

				$objWorkSheet->getColumnDimension("A")->setWidth(12);
				$objWorkSheet->getColumnDimension("B")->setWidth(24);
				$objWorkSheet->getColumnDimension("C")->setWidth(12);
				$objWorkSheet->getColumnDimension("D")->setWidth(12);
				$objWorkSheet->getColumnDimension("E")->setWidth(10);
				$objWorkSheet->getColumnDimension("F")->setWidth(12);
				$objWorkSheet->getColumnDimension("G")->setWidth(12);
				$objWorkSheet->getColumnDimension("H")->setWidth(12);

				$objWorkSheet->mergeCells('A1:H1');

				$objWorkSheet->setCellValue('A1','臺北市政府公務人員訓練處-'.$year.'年度班務志工服務刷到/退紀錄表');

				//文字置中
				$objWorkSheet->getStyle('A1:H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				$objWorkSheet->mergeCells('A2:H2');
				// $objWorkSheet->mergeCells('A2:B2');
				// $objWorkSheet->setCellValue('A2','1-3月');
				// $objWorkSheet->mergeCells('C2:H2');
				// $objWorkSheet->setCellValue('C2','姓名 : 陳XX');
				// 	$objWorkSheet->mergeCells('A3:B3');
				// $objWorkSheet->setCellValue('A3','服務時數合計 :');
				// $objWorkSheet->mergeCells('C3:E3');
				// $objWorkSheet->setCellValue('C3','承辦人簽章 :');
				// $objWorkSheet->mergeCells('F3:H3');
				// $objWorkSheet->setCellValue('F3','主管核章 :');

				$objWorkSheet->mergeCells('A2:H2');
				$objWorkSheet->setCellValue('A2',intval($month_start).'-'.intval($month_end).'月'.'　　　　　　　　　　　　　'.'姓名 : '.$name);
				$objWorkSheet->mergeCells('A3:H3');
				$objWorkSheet->setCellValue('A3','服務時數合計 :'.'　　　　　　　　　'.'承辦人簽章 :'.'　　　　　　　　　'.'主管核章 :');
				
				$objWorkSheet->setCellValue('A4','日期');
				$objWorkSheet->setCellValue('B4','班期名稱');
				$objWorkSheet->setCellValue('C4','起時');
				$objWorkSheet->setCellValue('D4','迄時');
				$objWorkSheet->setCellValue('E4','服務時數');
				$objWorkSheet->setCellValue('F4','承辦人');
				$objWorkSheet->setCellValue('G4','服務人次');
				$objWorkSheet->setCellValue('H4','服務班次');
				$objWorkSheet->getStyle('A4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

				$k = 5;
				$person_total = 0;
				$class_total = 0;
				$hour_total = 0;
				foreach($detail as $row2 => $value2){
					if(empty($value2['max_time']) && empty($value2['min_time'])){
						continue;
					}
					
					if($value2['volunteerID'] == '1'){
						$url = "http://163.29.39.6/getServiceCount.php?y=".$value2['year']."&c=".$value2['class_no']."&t=".$value2['term'];
    	
				    	$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$html = curl_exec($ch);
						curl_close($ch);
						$data_array = unserialize($html);

						$value2['max_time'] = substr($value2['max_time'], 0, 2).':'.substr($value2['max_time'], 2, 2);

						$value2['min_time'] = substr($value2['min_time'], 0, 2).':'.substr($value2['min_time'], 2, 2);

						$hours_tmp = (intval(substr($value2['max_time'],0,2))*3600+substr($value2['max_time'],3,2)*60)-(substr($value2['min_time'],0,2)*3600+substr($value2['min_time'],3,2)*60);

						$hours_tmp = round(($hours_tmp/3600));

						if($hours_tmp > $value2['hours']){
							$hours = $value2['hours'];
						} else {
							$hours = $hours_tmp;
						}

						$objWorkSheet->setCellValueByColumnAndRow(0, $k, $value2['date']);
						$objWorkSheet->setCellValueByColumnAndRow(1, $k, $value2['name'].'第'.$value2['term'].'期');
						$objWorkSheet->setCellValueByColumnAndRow(2, $k, $value2['min_time']);
						$objWorkSheet->setCellValueByColumnAndRow(3, $k, $value2['max_time']);
						$objWorkSheet->setCellValueByColumnAndRow(4, $k, $hours);
						$objWorkSheet->setCellValueByColumnAndRow(5, $k, $value2['worker']);
						$objWorkSheet->setCellValueByColumnAndRow(6, $k, $data_array[0]['CNT']);
						$objWorkSheet->setCellValueByColumnAndRow(7, $k, "1");

						$person_total += $data_array[0]['CNT'];
						$class_total += 1;
						$hour_total += $value2['hours'];
						$k++;
					}
				}
	
				//最後一行，7表示資料最後列數，+2代表空一列
				$objWorkSheet->mergeCells("A".($k+1).":B".($k+1));
				$objWorkSheet->mergeCells("D".($k+1).":H".($k+1));
				$objWorkSheet->setCellValue("A".($k+1),'(小計欄)');
				$objWorkSheet->setCellValue("C".($k+1),intval($month_start).'-'.intval($month_end).'月');
				$objWorkSheet->setCellValue("D".($k+1),$person_total.'(人次)/'.'　　'.$class_total.'(班次)/'.'　　'.$hour_total.'(時數)');

				//黑色框線style
				$styleArray = array(
					 'borders' => array(
					  'allborders' => array(
					   'style' => PHPExcel_Style_Border::BORDER_THIN,
					   'color' => array('argb' => '000000'),
					  ),
					 ),
					);

				//框線設定起始欄位到最終欄位
				$objWorkSheet->getStyle('A1:H'.($k+1))->applyFromArray($styleArray);

				$objWorkSheet->setTitle("班務",false);
			}

			else
			{
				$page = $row +1; 

				// if ($id == "2")
				// 	$category_name = "警衛" ;
				// elseif ($id == "3")
				// 	$category_name = "圖書" ;
				// elseif ($id == "4")
				// 	$category_name = "客服" ;
				// elseif ($id == "5")
				// 	$category_name = "園藝" ;
				// else
				// 	$category_name = "" ;

				$objWorkSheet = $objPHPExcel->createSheet($page); 

				$objWorkSheet->getColumnDimension("A")->setWidth(16);
				$objWorkSheet->getColumnDimension("B")->setWidth(16);
				$objWorkSheet->getColumnDimension("C")->setWidth(16);
				$objWorkSheet->getColumnDimension("D")->setWidth(16);
				$objWorkSheet->getColumnDimension("E")->setWidth(16);
				$objWorkSheet->getColumnDimension("F")->setWidth(16);

				$objWorkSheet->mergeCells('A1:F1');

				$objWorkSheet->setCellValue('A1','臺北市政府公務人員訓練處-'.$year.'年度'.$value['name'].'志工服務刷到/退紀錄表');

				//文字置中
				$objWorkSheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

				$objWorkSheet->mergeCells('A2:F2');
				$objWorkSheet->setCellValue('A2',intval($month_start).'-'.intval($month_end).'月'.'　　　　　　　　　　　　　'.'姓名 : '.$name);
				$objWorkSheet->mergeCells('A3:F3');
				$objWorkSheet->setCellValue('A3','服務時數合計 :'.'　　　　　　　　　'.'承辦人簽章 :'.'　　　　　　　　　'.'主管核章 :');
				
				$objWorkSheet->setCellValue('A4','日期');
				$objWorkSheet->setCellValue('B4','起時');
				$objWorkSheet->setCellValue('C4','迄時');
				$objWorkSheet->setCellValue('D4','服務時數');
				$objWorkSheet->setCellValue('E4','服務人次');
				$objWorkSheet->setCellValue('F4','服務班次');
				$objWorkSheet->getStyle('A4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

				$k = 5;
				$person_total = 0;
				$class_total = 0;
				$hour_total = 0;
				foreach($detail as $row2 => $value2){
					if(empty($value2['max_time']) && empty($value2['min_time'])){
						continue;
					}

					if($value2['volunteerID'] == $value['id']){
						$hours_tmp = (intval(substr($value2['end_time'],0,2))*3600+substr($value2['end_time'],2,2)*60)-(substr($value2['start_time'],0,2)*3600+substr($value2['start_time'],2,2)*60);

						$hours_tmp = round(($hours_tmp/3600));

						$value2['max_time'] = substr($value2['max_time'], 0, 2).':'.substr($value2['max_time'], 2, 2);

						$value2['min_time'] = substr($value2['min_time'], 0, 2).':'.substr($value2['min_time'], 2, 2);

						$hours_tmp2 = (intval(substr($value2['max_time'],0,2))*3600+substr($value2['max_time'],3,2)*60)-(substr($value2['min_time'],0,2)*3600+substr($value2['min_time'],3,2)*60);

						$hours_tmp2 = round(($hours_tmp2/3600));

						if($hours_tmp2 > $hours_tmp){
							$hours = $hours_tmp;
						} else {
							$hours = $hours_tmp2;
						}						

						$objWorkSheet->setCellValueByColumnAndRow(0, $k, $value2['date']);
						$objWorkSheet->setCellValueByColumnAndRow(1, $k, $value2['min_time']);
						$objWorkSheet->setCellValueByColumnAndRow(2, $k, $value2['max_time']);
						$objWorkSheet->setCellValueByColumnAndRow(3, $k, $hours);

						if($value2['volunteerID'] == '2'){
							$url = "http://163.29.39.6/getServiceCountForGuard.php?d=".$value2['date'];
    	
					    	$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$html = curl_exec($ch);
							curl_close($ch);
							$data_array = unserialize($html);
							
							$objWorkSheet->setCellValueByColumnAndRow(4, $k, round($data_array['total']/$value2['person_division_by']));
							$person_total += round($data_array['total']/$value2['person_division_by']);
						} else {
							$objWorkSheet->setCellValueByColumnAndRow(4, $k, $value2['person_other']);
							$person_total += $value2['person_other'];
						}
						
						$objWorkSheet->setCellValueByColumnAndRow(5, $k, "1");

						$class_total += 1;
						$hour_total += $hours;

						$k++;
					}
				}

				$objWorkSheet->mergeCells("A".($k+1).":B".($k+1));
				$objWorkSheet->mergeCells("D".($k+1).":F".($k+1));
				$objWorkSheet->setCellValue("A".($k+1),'小計欄');
				$objWorkSheet->setCellValue("C".($k+1),intval($month_start).'-'.intval($month_end).'月');
				$objWorkSheet->setCellValue("D".($k+1),$person_total.'(人次)/'.'　　'.$class_total.'(班次)/'.'　　'.$hour_total.'(時數)');

				// 如果是圖書志工
				if($value['id']==3)
				{
					$objWorkSheet->mergeCells("A".($k+2).":F".($k+2));
					$objWorkSheet->setCellValue("A".($k+2),'備註：'.$value['special_note']);
				}

				// $objWorkSheet->mergeCells("A".(7+2).":F".(7+2));
				// $objWorkSheet->setCellValue("A".(7+2),'(小計欄)'.'　'.'1-3月'.'　'.'203(人次)/6(班次)/19(時數)');

				//黑色框線style
				$styleArray = array(
					 'borders' => array(
					  'allborders' => array(
					   'style' => PHPExcel_Style_Border::BORDER_THIN,
					   'color' => array('argb' => '000000'),
					  ),
					 ),
					);

				//框線設定起始欄位到最終欄位
				$objWorkSheet->getStyle('A1:F'.($k+1))->applyFromArray($styleArray);

				$objWorkSheet->setTitle($value['name'],false);

			}
		}
		
		$objPHPExcel->setActiveSheetIndexByName('Worksheet');
		$sheetIndex = $objPHPExcel->getActiveSheetIndex();
		$objPHPExcel->removeSheetByIndex($sheetIndex);
		// // Set active sheet index to the first sheet, so Excel opens this as the first sheet
		// $objPHPExcel->setActiveSheetIndex(0);
		$name = iconv("UTF-8","BIG5", "服務時數統計表");
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		header('Content-Disposition: attachment;filename='.$name.".xlsx");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;


	}


	public function volunteer_traffic_report_output($category,$detail,$year,$month)
	{
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
// echo dirname(__FILE__) . '/./PHPExcel-1.8/Classes/PHPExcel.php'; die;
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		// foreach ($category as $row => $value)
		// {
			// $page = $row +1 ;

			$objWorkSheet = $objPHPExcel->createSheet(); 

			// if ($id == "1")
			// 	$category_name = "班務" ;
			// elseif ($id == "2")
			// 	$category_name = "警衛" ;
			// elseif ($id == "3")
			// 	$category_name = "圖書" ;
			// elseif ($id == "4")
			// 	$category_name = "客服" ;
			// elseif ($id == "5")
			// 	$category_name = "園藝" ;
			// else
			// 	$category_name = "" ;

			/*  379~401 列 2019 05 06 鵬加上 */
			switch($month)
			{
				case '1-3':
					$start_month = '1月';
					$middle_month = '2月';
					$end_month = '3月';
					break;
				case '4-6':
					$start_month = '4月';
					$middle_month = '5月';
					$end_month = '6月';
					break;	
				case '7-9':
					$start_month = '7月';
					$middle_month = '8月';
					$end_month = '9月';
					break;
				case '10-12':
					$start_month = '10月';
					$middle_month = '11月';
					$end_month = '12月';
					break;
			}

			$objWorkSheet->getColumnDimension("A")->setWidth(12);
			$objWorkSheet->getColumnDimension("B")->setWidth(12);
			$objWorkSheet->getColumnDimension("C")->setWidth(12);
			$objWorkSheet->getColumnDimension("D")->setWidth(12);
			$objWorkSheet->getColumnDimension("E")->setWidth(12);
			$objWorkSheet->getColumnDimension("F")->setWidth(12);
			$objWorkSheet->getColumnDimension("G")->setWidth(16);
			$objWorkSheet->getColumnDimension("H")->setWidth(16);
			$objWorkSheet->getColumnDimension("I")->setWidth(26);

			$objWorkSheet->mergeCells('A1:I1');
			$objWorkSheet->setCellValue('A1','臺北市政府公務人員訓練處');

			$objWorkSheet->mergeCells('A2:H2');
			$objWorkSheet->setCellValue('A2',$year.'年'.$month.'月份志工餐點與交通補助清冊');
			$objWorkSheet->setCellValue('I2','中華民國'.(date('Y')-1911).'年'.date('m').'月'.date('d').'日');
			//文字置中
			$objWorkSheet->getStyle('A1:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
			$objWorkSheet->getStyle('A1:I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  

			$objWorkSheet->mergeCells('A3:A4');
			$objWorkSheet->setCellValue('A3','姓名');
			$objWorkSheet->mergeCells('B3:E3');
			$objWorkSheet->setCellValue('B3','班次');
			$objWorkSheet->setCellValue('B4',$start_month);	// 2019 05 06 原本是 1月 ，改為 $start_month 
			$objWorkSheet->setCellValue('C4',$middle_month);	// 2019 05 06 原本是 2月 ，改為 $middle_month 
			$objWorkSheet->setCellValue('D4',$end_month);	// 2019 05 06 原本是 3月 ，改為 $end_month 
			$objWorkSheet->setCellValue('E4','小計');
			$objWorkSheet->mergeCells('F3:F4');
			$objWorkSheet->setCellValue('F3','金額');
			$objWorkSheet->mergeCells('G3:G4');
			$objWorkSheet->setCellValue('G3','簽章');
			$objWorkSheet->mergeCells('H3:H4');
			$objWorkSheet->setCellValue('H3','身分證統一編號');
			$objWorkSheet->mergeCells('I3:I4');
			$objWorkSheet->setCellValue('I3','戶籍地址');
			
			$k = 5;
			$first_total = 0;
			$second_total = 0;
			$third_total = 0; 
			for ($i=0;$i<count($detail);$i++) {
				$first_count = 0;
				$second_count = 0;
				$third_count = 0; 
				for($j=0;$j<count($detail[$i]['first']);$j++){
					$hours_tmp = (intval(substr($detail[$i]['first'][$j]['end_time'],0,2))*3600+substr($detail[$i]['first'][$j]['end_time'],3,2)*60)-(substr($detail[$i]['first'][$j]['start_time'],0,2)*3600+substr($detail[$i]['first'][$j]['start_time'],3,2)*60);

					$hours_tmp = round(($hours_tmp/3600));

					$first_max_time = substr($detail[$i]['first'][$j]['max_time'], 0, 2).':'.substr($detail[$i]['first'][$j]['max_time'], 2, 2);

					$first_min_time = substr($detail[$i]['first'][$j]['min_time'], 0, 2).':'.substr($detail[$i]['first'][$j]['min_time'], 2, 2);

					$hours_tmp2 = (intval(substr($first_max_time,0,2))*3600+substr($first_max_time,3,2)*60)-(substr($first_min_time,0,2)*3600+substr($first_min_time,3,2)*60);

					$hours_tmp2 = round(($hours_tmp2/3600));

					
					if($hours_tmp2 >= $hours_tmp){
						$first_count++;
					}					
				}

				for($j=0;$j<count($detail[$i]['second']);$j++){
					$hours_tmp = (intval(substr($detail[$i]['second'][$j]['end_time'],0,2))*3600+substr($detail[$i]['second'][$j]['end_time'],3,2)*60)-(substr($detail[$i]['second'][$j]['start_time'],0,2)*3600+substr($detail[$i]['second'][$j]['start_time'],3,2)*60);

					$hours_tmp = round(($hours_tmp/3600));

					$second_max_time = substr($detail[$i]['second'][$j]['max_time'], 0, 2).':'.substr($detail[$i]['second'][$j]['max_time'], 2, 2);

					$second_min_time = substr($detail[$i]['second'][$j]['min_time'], 0, 2).':'.substr($detail[$i]['second'][$j]['min_time'], 2, 2);

					$hours_tmp2 = (intval(substr($second_max_time,0,2))*3600+substr($second_max_time,3,2)*60)-(substr($second_min_time,0,2)*3600+substr($second_min_time,3,2)*60);

					$hours_tmp2 = round(($hours_tmp2/3600));

					if($hours_tmp2 >= $hours_tmp){
						$second_count++;
					}					
				}

				for($j=0;$j<count($detail[$i]['third']);$j++){
					$hours_tmp = (intval(substr($detail[$i]['third'][$j]['end_time'],0,2))*3600+substr($detail[$i]['third'][$j]['end_time'],3,2)*60)-(substr($detail[$i]['third'][$j]['start_time'],0,2)*3600+substr($detail[$i]['third'][$j]['start_time'],3,2)*60);

					$hours_tmp = round(($hours_tmp/3600));

					$third_max_time = substr($detail[$i]['third'][$j]['max_time'], 0, 2).':'.substr($detail[$i]['third'][$j]['max_time'], 2, 2);

					$third_min_time = substr($detail[$i]['third'][$j]['min_time'], 0, 2).':'.substr($detail[$i]['third'][$j]['min_time'], 2, 2);

					$hours_tmp2 = (intval(substr($third_max_time,0,2))*3600+substr($third_max_time,3,2)*60)-(substr($third_min_time,0,2)*3600+substr($third_min_time,3,2)*60);

					$hours_tmp2 = round(($hours_tmp2/3600));

					if($hours_tmp2 >= $hours_tmp){
						$third_count++;
					}					
				}

				if($first_count > 0 || $second_count >0 || $third_count > 0){
					$objWorkSheet->setCellValueByColumnAndRow(0, $k, $detail[$i]['name']);
					$objWorkSheet->setCellValueByColumnAndRow(1, $k, $first_count);
					$objWorkSheet->setCellValueByColumnAndRow(2, $k, $second_count);
					$objWorkSheet->setCellValueByColumnAndRow(3, $k, $third_count);
					$objWorkSheet->setCellValueByColumnAndRow(4, $k, $first_count+$second_count+$third_count);
					$objWorkSheet->setCellValueByColumnAndRow(5, $k, ($first_count+$second_count+$third_count)*110);
					$objWorkSheet->setCellValueByColumnAndRow(6, $k, "");
					$objWorkSheet->setCellValueByColumnAndRow(7, $k, $detail[$i]['idno']);
					$objWorkSheet->setCellValueByColumnAndRow(8, $k, $detail[$i]['address']);

					$first_total += $first_count;
					$second_total += $second_count;
					$third_total += $third_count; 
					$k++;
				}
		
			}
			
			//最後一行
			$objWorkSheet->setCellValue("A".($k+1),'總計');
			$objWorkSheet->setCellValue("B".($k+1),$first_total);
			$objWorkSheet->setCellValue("C".($k+1),$second_total);
			$objWorkSheet->setCellValue("D".($k+1),$third_total);
			$objWorkSheet->setCellValue("E".($k+1),$first_total+$second_total+$third_total);
			$objWorkSheet->setCellValue("F".($k+1),($first_total+$second_total+$third_total)*110);
			$objWorkSheet->mergeCells("G".($k+1).":I".($k+1));


			//黑色框線style
			$styleArray = array(
				 'borders' => array(
				  'allborders' => array(
				   'style' => PHPExcel_Style_Border::BORDER_THIN,
				   'color' => array('argb' => '000000'),
				  ),
				 ),
				);

			// 框線設定起始欄位到最終欄位
			$objWorkSheet->getStyle('A3:I'.($k+1))->applyFromArray($styleArray);

			$objWorkSheet->setTitle('補助清冊',false);

		// }


		$objPHPExcel->setActiveSheetIndexByName('Worksheet');
		$sheetIndex = $objPHPExcel->getActiveSheetIndex();
		$objPHPExcel->removeSheetByIndex($sheetIndex);
		// // Set active sheet index to the first sheet, so Excel opens this as the first sheet
		// $objPHPExcel->setActiveSheetIndex(0);
		$name = iconv("UTF-8","BIG5", "志工餐點與交通補助清冊");
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		header('Content-Disposition: attachment;filename='.$name.".xlsx");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		
		
		exit;

	}

	public function sign_log_report($info,$categoryList){
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");

		$objWorkSheet = $objPHPExcel->setActiveSheetIndex(0);

		$objWorkSheet->setCellValue('A1','姓名');
		$objWorkSheet->setCellValue('B1','刷卡日期');
		$objWorkSheet->setCellValue('C1','簽到時間');
		$objWorkSheet->setCellValue('D1','簽退時間');
		$objWorkSheet->setCellValue('E1','當日報名類別時數');
		$objWorkSheet->setCellValue('F1','當日報名總時數');
		$objWorkSheet->setCellValue('G1','刷卡紀錄');
		$objWorkSheet->setCellValue('H1','實際服勤時數');
		$objWorkSheet->setCellValue('I1','當日班次');

		$k = 2;
		$total_hours = 0;
		for($i=0;$i<count($info);$i++){
          if(count($info[$i]['sign_time']) > 1){
            $sign_out_time = $info[$i]['sign_time'][count($info[$i]['sign_time'])-1];
          } else {
            $sign_out_time = '';
          }

          $category_hours = '';
          if(isset($info[$i]['category'][1])){
            $categoryList[$info[$i]['category'][1]['category_id']]['total_hours'] += $info[$i]['category'][1]['hours'];
            $category_hours .= $info[$i]['category'][1]['name'].$info[$i]['category'][1]['hours'];
            if(count($info[$i]['category']) == 2){
              $category_hours .= "\n";
            }
          }

          if(isset($info[$i]['category'][2])){
            $categoryList[$info[$i]['category'][2]['category_id']]['total_hours'] += $info[$i]['category'][2]['hours'];
            $category_hours .= $info[$i]['category'][2]['name'].$info[$i]['category'][2]['hours'];
          }

          $sign_log_list = '';
          for($j=0;$j<count($info[$i]['sign_time']);$j++){
          	$sign_log_list .= $info[$i]['sign_time'][$j];
          	if(count($info[$i]['sign_time']) != $j+1){
          		$sign_log_list .= '　'."\n";

          	}
          }

          // print_r($sign_log_list);
          // die();
          // $sign_log_list = implode("\n", $info[$i]['sign_time']);

          if(count($info[$i]['sign_time']) > 1){
          	$tmp_first_sign_time = str_replace('<font style="color:red">(補)</font>',"",$info[$i]['sign_time'][0]);
                            $tmp_last_sign_time = str_replace('<font style="color:red">(補)</font>',"",$info[$i]['sign_time'][count($info[$i]['sign_time'])-1]);

            $true_hours = (strtotime($tmp_last_sign_time) - strtotime($tmp_first_sign_time))/3600;
            // $true_hours = (strtotime($info[$i]['sign_time'][count($info[$i]['sign_time'])-1]) - strtotime($info[$i]['sign_time'][0]))/3600;
                      
            
            if(round($true_hours) > $true_hours){
              $true_hours = floor($true_hours)+0.5;
            } else if(round($true_hours) < $true_hours){
              $true_hours = floor($true_hours);
            }
           
          	if($true_hours > 8){
          		$true_hours = 8;
          	}
          } else {
            $true_hours = 0;
          }

          $class_times = floor($true_hours/3);
          if($class_times > count($info[$i]['category'])){
            $class_times = 1;
          }
          
          $total_hours += $info[$i]['total_hours'];
          $objWorkSheet->setCellValue("A".$k,$info[$i]['name']);
          $objWorkSheet->setCellValue("B".$k,$info[$i]['sign_date']);
          $objWorkSheet->setCellValue("C".$k,$info[$i]['sign_time'][0]);
          $objWorkSheet->setCellValue("D".$k,$sign_out_time);
          $objWorkSheet->setCellValue("E".$k,$category_hours);
          $objWorkSheet->setCellValue("F".$k,$info[$i]['total_hours']);
          $objWorkSheet->setCellValue("G".$k,$sign_log_list);
          $objWorkSheet->setCellValue("H".$k,$true_hours);
          $objWorkSheet->setCellValue("I".$k,$class_times);
          $k++;
        }

        $objWorkSheet->setCellValue('E'.$k,'總時數');
        $objWorkSheet->setCellValue('F'.$k,$total_hours);
      
        

        $total_true_hours = '';
        $total_class_times = '';
        $categoryList = array_values($categoryList);
        
        for($i=0;$i<count($categoryList);$i++){
          $total_true_hours .= $categoryList[$i]['name'].$categoryList[$i]['total_hours'].'小時';
          $total_class_times .= $categoryList[$i]['name'].floor($categoryList[$i]['total_hours']/3).'班次';;

          if(count($categoryList) == ($i+1)){
            $total_true_hours .= '。';
            $total_class_times .= '。';
          } else {
            $total_true_hours .= '/';
            $total_class_times .= '/';
          }
        }

        $k = $k+2;
        $objWorkSheet->setCellValue("A".$k,'以上各類別實際服勤總時數：'.$total_true_hours);
        $k++;
        $objWorkSheet->setCellValue("A".$k,'以上各類別實際服勤總班次：'.$total_class_times);

        $styleArray = array(
						 'borders' => array(
						  'allborders' => array(
						   'style' => PHPExcel_Style_Border::BORDER_THIN,
						   'color' => array('argb' => '000000'),
						  ),
						 ),
						);

		//框線設定起始欄位到最終欄位
		$objWorkSheet->getStyle('A1:I'.($k+1))->applyFromArray($styleArray);

		// Redirect output to a client’s web browser (OpenDocument)
		header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
		header('Content-Disposition: attachment;filename="signLog.ods"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
		$objWriter->save('php://output');
		exit;
	}


}