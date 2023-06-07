<?php 
    if( (strcmp(ENVIRONMENT, 'production') == 0) ){ 
	    require_once($_SERVER['DOCUMENT_ROOT'].'/eda/apply/resource/PHPexcel/PHPExcel_xls_outputer_ver2.php');
    } else {
        require_once FCPATH . 'resource/PHPexcel/PHPExcel_xls_outputer_ver2.php';
    }


    $objPHPExcel = new PHPExcel();
    $sheet = $objPHPExcel->getActiveSheet();
    $helper = new helper();
    $WEEK_INDEX = array(
        'Sunday' =>'日',
        'Monday' =>'一',
        'Tuesday' =>'二',
        'Wednesday' =>'三',
        'Thursday' =>'四',
        'Friday' =>'五',
        'Saturday' =>'六',
    );
    
    $sheet->mergeCells('A1:E1');
    $downLoadTime = '下載時間：'.date('Y/m/d H:i:s');
    $sheet->setCellValue('A1',$downLoadTime);

    $sheet->mergeCells('A2:B2');
    $sheet->setCellValue('A2',"志工\n類別");
    // $sheet->setCellValue('B1',"場地");
    $colunm = 3;
    $row = 2;
    $month = date('m',strtotime(current($week_list)));
    foreach ($week_list as $date)
    {
        $now_feild = $helper->field_num_to_eng($colunm).$row;
        $sheet->setCellValue($now_feild,$date."\n(".$WEEK_INDEX[date('l',strtotime($date))].")");

        $sheet->getStyle($now_feild)->getAlignment()->setWrapText(true);
        $sheet->getStyle($now_feild)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($now_feild)->getFont()->setSize(18)->setBold(true);

        $sheet->getColumnDimension($helper->field_num_to_eng($colunm))->setWidth(23);
        $colunm++;
    }

    $row = 3;
    foreach ($vc_list as $vID => $pre_classroom_for_each_volunteer)
    {
        if(!isset($vID_arr[$vID]))
            continue;

        $rowspan = count($pre_classroom_for_each_volunteer);
        $rowspan_done = false;
        foreach ($pre_classroom_for_each_volunteer as $cID => $vc_data)
        {
            if($rowspan_done == false)
            {
            }



            if($vc_data->others)
            {
                 // print_r($row);
                 //    echo '<br>';
                $sheet->mergeCells('A'.$row.':'.'B'.$row);
                $sheet->setCellValue('A'.$row,$vc_data->volunteerName);
            }
            else
            {
                if(!$rowspan_done)
                {   
                    // print_r($row);
                    // echo '<br>';
                    // print_r($rowspan);
                    // echo '<br>';
                    $sheet->mergeCells('A'.$row.':'.'B'.($row+$rowspan-1));
                    // $sheet->mergeCells('B'.$row.':'.'B'.($row+$rowspan-1));
                    // $sheet->mergeCells('A'.$row.':'.'B'.$row);
                    $sheet->setCellValue('A'.$row,$vc_data->volunteerName);
                }
                // $sheet->setCellValue('B'.$row,$vc_data->classroomName);
            }

            $rowspan_done = true; 

            // 如果這天有資料
            $colunm = 3;
            foreach ($week_list as $date)
            {
                $now_feild = $helper->field_num_to_eng($colunm).$row;
                if(!empty($calendar_list[$vc_data->vcID][$date]))
                {
                    $str =  '';
                    $list_str = array();

                    // PHPEXCEL的文字處理器
                    $str = new PHPExcel_RichText();
                    foreach ($calendar_list[$vc_data->vcID][$date] as $type => $calendar_data)
                    {
                        // 如果不開放就PASS
                        if(!$calendar_data->status)
                            continue;

                        if($ONLY_ME && empty($apply_data[$calendar_data->id][$userID]))
                            continue;

                        
                        // 時段的標題文字，僅班務志工要顯示課程名稱
                        $time_str = date('Hi',strtotime($calendar_data->start_time)).'~'.date('Hi',strtotime($calendar_data->end_time));

                        // $title_str = $time_str.(!empty($calendar_data->courseName)?' '.$calendar_data->courseName:null);
                        $title_str = $time_str.(!empty($calendar_data->courseName)?' '.$calendar_data->courseName.'('.$calendar_data->term.')'.$calendar_data->worker.'('.$calendar_data->hours.')'."\n".$calendar_data->sname:null);


                        $title_str = $str->createTextRun($title_str);
                        $title_str->getFont()->setBold(true);//加粗

                        if($calendar_data->belongto == '68001'){
                            $star = $str->createTextRun('★');
                            $star->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_RED ) );
                        } else {
                            $outside_key = $calendar_data->date.'-'.$calendar_data->courseID;
                            if(in_array($outside_key, $outside)){
                                $star = $str->createTextRun('★');
                                $star->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_RED ) );
                            }
                        }

                        $str->createText("\n");

                                
                        if(!empty($apply_data[$calendar_data->id]))
                        {
                            foreach ($apply_data[$calendar_data->id] as $key_userID => $each_applied_user)
                            {
                                $users_str = $str->createTextRun($each_applied_user->userName."\n");
                                if($each_applied_user->got_it)
                                    $users_str->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_RED ) );
                            }
                        }
                        $str->createText("\n");
                    }
                    $sheet->setCellValue($now_feild,$str);
                }
                $colunm++;
            }
            // 整列都垂直置中、自動換行
            $sheet->getStyle('A'.$row.':'.$now_feild)->getAlignment()->setWrapText(true);
            $sheet->getStyle('A'.$row.':'.$now_feild)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $row++;
        }
    }

    $border_style['allborders'] = array('borders'=>array('allborders'=>array(
        'style'=>PHPExcel_Style_Border::BORDER_THIN,
        'color'=>array('argb'=>'000000')
    )));
    $sheet->getStyle('A1:'.$now_feild)->applyFromArray($border_style['allborders']);

    $max_row = $row-1;
    $sheet->getStyle('A1:B'.$max_row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $sheet->getStyle('A1:B'.$max_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1:B'.$max_row)->getFont()->setSize(18)->setBold(true);


    $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
    $sheet->getColumnDimension('B')->setWidth(23);



    // 預設閱讀的sheet
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="志工報名狀況表-'.$month.'月份.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT+8'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
?>