<?php
	require_once 'inc/excel/PHPExcel.php';
	require_once 'inc/phpmailer/class.phpmailer.php';
	require_once 'inc/phpmailer/class.smtp.php';
	$data=file_get_contents("php://input");
	$data=json_decode($data);
	$link="http://phonelabs.net/a/chart.php?id=".$data->id;
	$email=$data->email;
	$data=$data->data;
	$mdata=array();
	$ar=array("0","0","0","0");
	array_push($mdata,$ar);	
	foreach ($data as $key => $value) {
		$ar=array(($value->t)*1000,$value->x,$value->y,$value->z);
		array_push($mdata,$ar);		
	};
	$ca=count($mdata);
	$gdImage = imagecreatefrompng('img/xl_logo.png');
	$ea = new PHPExcel();
   	$ews = $ea->getSheet(0);
	$ews->setTitle('Raw_Data');
	$ews->setCellValue('a1', 'Time');
	$ews->setCellValue('b1', 'X acell'); 
	$ews->setCellValue('c1', 'Y acell');
	$ews->setCellValue('d1', 'Z acell');

	$ews->getStyle("A1")->getFont()->setBold(true);
	$ews->getStyle("B1")->getFont()->setBold(true);
	$ews->getStyle("C1")->getFont()->setBold(true);
	$ews->getStyle("D1")->getFont()->setBold(true);
	
	$ews->getStyle("A1")->getFont()->setSize(14);
	$ews->getStyle("B1")->getFont()->setSize(14);
	$ews->getStyle("C1")->getFont()->setSize(14);
	$ews->getStyle("D1")->getFont()->setSize(14);

	$ews->fromArray($mdata, ' ', 'A2');

	$ews->getRowDimension(1)->setRowHeight(59);
	$ews->getColumnDimension('L')->setWidth(42);
     $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setCoordinates('L1');
        $objDrawing->setWidth(300);
        $objDrawing->setHeight(38);
        $objDrawing->setOffsetX(20);
        $objDrawing->setOffsetY(25);
        $objDrawing->setWorksheet($ews);

	$dsl=array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Raw_Data!$B$1', NULL, 1),
                new PHPExcel_Chart_DataSeriesValues('String', 'Raw_Data!$C$1', NULL, 1),
                new PHPExcel_Chart_DataSeriesValues('String', 'Raw_Data!$D$1', NULL, 1)
            );
	$xal=array(
               new PHPExcel_Chart_DataSeriesValues('Number', 'Raw_Data!$A$2:$A$'.$ca, NULL, $ca)
           );
	$dsv=array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Raw_Data!$B$2:$B$'.$ca, NULL, $ca),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Raw_Data!$C$2:$C$'.$ca, NULL, $ca),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Raw_Data!$D$2:$D$'.$ca, NULL, $ca)
            );
	$dsv[0]->setPointMarker('none');
	$dsv[1]->setPointMarker('none');
	$dsv[2]->setPointMarker('none');
	$ds=new PHPExcel_Chart_DataSeries(
                   PHPExcel_Chart_DataSeries::TYPE_LINECHART,
                   PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                   range(0, count($dsv)-1),
                   $dsl,
                   $xal,
                   $dsv
                   ); 
	$pa=new PHPExcel_Chart_PlotArea(NULL, array($ds));
	$legend=new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	$chart= new PHPExcel_Chart('chart1',NULL,$legend,$pa,true,0,NULL,NULL);
	$chart->setTopLeftPosition('F2');
	$chart->setBottomRightPosition('Z22');
	$ews->addChart($chart);


	$sheetId = 1;
	$ea->createSheet(NULL, $sheetId);
	$ea->setActiveSheetIndex($sheetId);
	$ea->getActiveSheet()->setTitle("Filtered_Data");

	//  Attach the newly-cloned sheet to the $objPHPExcel workbook
	$ews2 = $ea->getSheet(1);
	$ews2->setTitle('Filtered_Data');
	$ews2->setCellValue('a1', 'Time');
	$ews2->setCellValue('b1', 'X acell'); 
	$ews2->setCellValue('c1', 'Y acell');
	$ews2->setCellValue('d1', 'Z acell');
	$ews2->setCellValue('f1', 'Filter =');
	$ews2->setCellValue('g1', '0.20');
	$ews2->setCellValue('h1', '(0 to 1)');
	$ews2->setCellValue('i1', '1 is no filtering(as is)');
	$ews2->setCellValue('i2', '0 is hi filtering (very smooth)');

	$ews2->getStyle("A1")->getFont()->setBold(true);
	$ews2->getStyle("B1")->getFont()->setBold(true);
	$ews2->getStyle("C1")->getFont()->setBold(true);
	$ews2->getStyle("D1")->getFont()->setBold(true);
	$ews2->getStyle("f1")->getFont()->setBold(true);
	$ews2->getStyle("g1")->getFont()->setBold(true);

	$ews2->getStyle("A1")->getFont()->setSize(14);
	$ews2->getStyle("B1")->getFont()->setSize(14);
	$ews2->getStyle("C1")->getFont()->setSize(14);
	$ews2->getStyle("D1")->getFont()->setSize(14);
	$ews2->getStyle("f1")->getFont()->setSize(14);
	$ews2->getStyle("g1")->getFont()->setSize(14);

	$ews2->getStyle("f1")->getFont()->getColor()->setRGB('FF0000');
	$ews2->getStyle("g1")->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'FFFF00')));
	//$ews2->fromArray($mdata, ' ', 'A2');
	$ews2->setCellValue('a2', "='Raw_Data'!A2");
	$ews2->setCellValue('b2', "='Raw_Data'!B2"); 
	$ews2->setCellValue('c2', "='Raw_Data'!C2");
	$ews2->setCellValue('d2', "='Raw_Data'!D2");
	//=B2+Alpha*('Raw Data'!B3-B2)
	for ($i=3; $i < ($ca+2) ; $i++)
	{ 
		$ews2->setCellValue('a'.$i, "='Raw_Data'!A".$i);
		$ews2->setCellValue('b'.$i, "=B".($i-1)."+G1*('Raw_Data'!B".$i."-B".($i-1).")"); 
		$ews2->setCellValue('c'.$i, "=C".($i-1)."+G1*('Raw_Data'!C".$i."-C".($i-1).")");
		$ews2->setCellValue('d'.$i, "=D".($i-1)."+G1*('Raw_Data'!D".$i."-D".($i-1).")");
	}

	$ews2->getRowDimension(1)->setRowHeight(59);
	$ews2->getColumnDimension('L')->setWidth(42);
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Sample image');
    $objDrawing->setDescription('Sample image');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setCoordinates('L1');
    $objDrawing->setWidth(300);
    $objDrawing->setHeight(38);
    $objDrawing->setOffsetX(20);
    $objDrawing->setOffsetY(25);
    $objDrawing->setWorksheet($ews2);

	$dsl2=array(
                new PHPExcel_Chart_DataSeriesValues('String', 'Filtered_Data!$B$1', NULL, 1),
                new PHPExcel_Chart_DataSeriesValues('String', 'Filtered_Data!$C$1', NULL, 1),
                new PHPExcel_Chart_DataSeriesValues('String', 'Filtered_Data!$D$1', NULL, 1)
            );
	$xal2=array(
               new PHPExcel_Chart_DataSeriesValues('Number', 'Filtered_Data!$A$2:$A$'.$ca, NULL, $ca)
           );
	$dsv2=array(
                new PHPExcel_Chart_DataSeriesValues('Number', 'Filtered_Data!$B$2:$B$'.$ca, NULL, $ca),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Filtered_Data!$C$2:$C$'.$ca, NULL, $ca),
                new PHPExcel_Chart_DataSeriesValues('Number', 'Filtered_Data!$D$2:$D$'.$ca, NULL, $ca)
            );
	$dsv2[0]->setPointMarker('none');
	$dsv2[1]->setPointMarker('none');
	$dsv2[2]->setPointMarker('none');
	$ds2=new PHPExcel_Chart_DataSeries(
                   PHPExcel_Chart_DataSeries::TYPE_LINECHART,
                   PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                   range(0, count($dsv2)-1),
                   $dsl2,
                   $xal2,
                   $dsv2
                   );
	$pa2=new PHPExcel_Chart_PlotArea(NULL, array($ds2));
	$legend2=new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	$chart2= new PHPExcel_Chart('chart2',NULL,$legend2,$pa2,true,0,NULL,NULL);
	$chart2->setTopLeftPosition('F3');
	$chart2->setBottomRightPosition('Z22');
	$ews2->addChart($chart2);






	$ea->setActiveSheetIndex(0);

	$fileName="temp_xls/PL_Data_".uniqid().".xlsx";
	$title=new PHPExcel_Chart_Title('PhoneLabs Data');
	$writer = PHPExcel_IOFactory::createWriter($ea, 'Excel2007');        
	$writer->setIncludeCharts(true);
	$writer->save($fileName);
	
	if ($writer) {
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
		$mail->IsSMTP(); // telling the class to use SMTP
		//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "phonelabsorg.ipower.com"; // sets the SMTP server
		$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "admin@phonelabs.net"; // SMTP account username
		$mail->Password   = "@15Waheed";        // SMTP account password
		$mail->SMTPSecure = 'tls';
		$mail->AddAddress($email);
		$mail->SetFrom('admin@phonelabs.net', 'Phone Labs');
		$mail->AddReplyTo('noreply@phonelabs.net', 'No Reply');
		$mail->Subject = 'PhoneLabs Data';
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
		$mail->MsgHTML("Data Logged by PhoneLabs. \n \n <br> <a href='".$link."'><u>View graph in browser</u></a> \n ");
		$mail->AddAttachment($fileName);      // attachment
		if($mail->Send())
		{
			print "Email Sent";
		}else{
			print "Error : could not send email";
		}
		unlink($fileName);
	}else{
		print "Error : could not send email";
		unlink($fileName);
	}
?>