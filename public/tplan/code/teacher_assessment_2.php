<?php
include('lessonfunctions_2.php');
require_once 'PHPExcel.php';
$unit_id=$_GET['unit_id'];
$sql3="select objective,theme,lesson_num,name,level_id from peplanning.objectives left join peplanning.lesson_objectives on peplanning.lesson_objectives.objective_id = peplanning.objectives.id left join peplanning.lesson on peplanning.lesson.id = peplanning.lesson_objectives.lesson_id left join peplanning.theme on peplanning.theme.id = peplanning.lesson.theme_id left join peplanning.unit_of_work on peplanning.lesson.uow_id = peplanning.unit_of_work.id left join peplanning.topic on peplanning.unit_of_work.topic_id = peplanning.topic.id where peplanning.lesson.uow_id=$unit_id order by lesson_num";
$result3 = mysql_query($sql3);
    if (!$result3)
    {
        die('Invalid query: '. mysql_error());
    }
$next_cell=mysql_num_rows($result3) + 6;
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator("PE Planning")
							 ->setLastModifiedBy("PE Planning")
							 ->setTitle("Teacher Assessment")
							 ->setSubject("Teacher Assessment")
							 ->setDescription("Teacher Assessment")
							 ->setKeywords("Teacher Assessment")
							 ->setCategory("Teacher Assessment");
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->getStyle('A1:D4')
                                              ->getAlignment()->setWrapText(true);
                $cell_array=array('D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF');
                foreach($cell_array as $cell_letter)
                {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($cell_letter)->setWidth(3);
                }
                $objective_cell_num=5;
                $objective_cell_letter="C";
                $level_cell_letter="B";
                $level_cell_num=5;
                $theme_cell_letter="A";
                $theme_cell_num=5;
                $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
                $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
                $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(60);
                $objPHPExcel->getActiveSheet()->getColumnDimension($theme_cell_letter)->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension($level_cell_letter)->setWidth(3);
                $objPHPExcel->getActiveSheet()->getColumnDimension($objective_cell_letter)->setAutoSize(true);
                $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(100);
                $objPHPExcel->getActiveSheet()->mergeCells('A3:C3');
                $objPHPExcel->getActiveSheet()->mergeCells('D2:Z2');
                $lesson_num=0;
                $theme_cell_start_num=5;
                while($row = mysql_fetch_array( $result3 ))
                    {
                        $level=(int)$row['level_id'];
                        $file_name=$row['name']."_level".$level.".xls";
                        $sheet_name=$row['name']." - Level ".$level." Assessment";
                        if ($row['lesson_num']!=$lesson_num)
                        {
                            $merge_obj_cell_start=$theme_cell_letter.$theme_cell_start_num;
                            $merge_obj_cell_end_num=$objective_cell_num-1;
                            $merge_obj_cell_end=$theme_cell_letter.$merge_obj_cell_end_num;
                            if ($lesson_num!=0) $objPHPExcel->getActiveSheet()->mergeCells("$merge_obj_cell_start:$merge_obj_cell_end");
                            $theme_cell_start_num=$objective_cell_num;
                            $theme_cell_num=$objective_cell_num;
                            $cell=$theme_cell_letter.$theme_cell_num;
                            $objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $cell_content="Lesson ".$row['lesson_num']." Theme: ".$row['theme'];
                            $objPHPExcel->getActiveSheet()->setCellValue($cell, $cell_content);
                            $lesson_num=$row['lesson_num'];
                        }
                        $objPHPExcel->getActiveSheet()->getRowDimension($objective_cell_num)->setRowHeight(20);
                        $cell=$level_cell_letter.$objective_cell_num;
                        $cell_content="L".$level;
                        //$cell_content=$merge_obj_cell_start;
                        $objPHPExcel->getActiveSheet()->setCellValue($cell, $cell_content);
                        $cell=$objective_cell_letter.$objective_cell_num;
                        $cell_content=$row['objective'];
                        //$cell_content=$merge_obj_cell_end;
                        $objPHPExcel->getActiveSheet()->setCellValue($cell, $cell_content);
                        $objective_cell_num++;
                    }
                $merge_obj_cell_start=$theme_cell_letter.($merge_obj_cell_end_num+1);
                $merge_obj_cell_end=$theme_cell_letter.($objective_cell_num-1);
                $objPHPExcel->getActiveSheet()->mergeCells("$merge_obj_cell_start:$merge_obj_cell_end");
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('Arial');
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize('24');
                $objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB('ff829f5e');
                $objPHPExcel->getActiveSheet()->setCellValue('A3',$sheet_name);
                $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('D2','Child\'s Name');
                $styleThinBlackBorderOutline = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => 'FF000000'),
                                ),
                            ),
                            'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_SOLID,
                                    'startcolor' => array(
	 				'argb' => '66b7cc99'
                                        ),

                                    )
                        );
                 $styleThinBlackBorderOutlineNoFill = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                'color' => array('argb' => 'FF000000'),
                                ),
                            )
                        );
                $table_next_cell=$next_cell-2;
                $table_cell_range="D5:AF".$table_next_cell;
                $objPHPExcel->getActiveSheet()->getStyle($table_cell_range)->applyFromArray($styleThinBlackBorderOutlineNoFill);
                $objPHPExcel->getActiveSheet()->getStyle('D3:AF3')->applyFromArray($styleThinBlackBorderOutline);
                $current_cell="C".$next_cell;
                $current_cell_range="D".$next_cell.":AF".$next_cell;
                $objPHPExcel->getActiveSheet()->getRowDimension($next_cell)->setRowHeight(20);
                $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getFont()->setName('Arial');
                $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getFont()->setSize('14');
                $objPHPExcel->getActiveSheet()->getStyle($current_cell)->getFont()->getColor()->setARGB('ff829f5e');
                $objPHPExcel->getActiveSheet()->setCellValue($current_cell,'NC Attainment Level ');
                $objPHPExcel->getActiveSheet()->getStyle($current_cell_range)->applyFromArray($styleThinBlackBorderOutline);
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment;filename=$file_name");
                header("Cache-Control: max-age=0");
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
?>
