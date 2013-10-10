<?php
include('lessonfunctions_2.php');
$orientation=$_GET['orientation'];
$file=$_GET['file'];
$htmlFile=FILE_ROOT.'/tmp/'.$file.'.html';
$pdfFile=FILE_ROOT.'/tmp/'.$file.'.pdf';
$success=passthru(escapeshellcmd("/usr/local/bin/wkhtmltopdf -l -O $orientation -s A4 -T 2mm -B 2mm -R 2mm -L 2mm $htmlFile $pdfFile"));
$browsePDF=fopen($pdfFile,'r');
$pdf_name=time().".pdf";
header("Content-type:application/pdf");
header("Content-Disposition:inline;filename=$pdf_name");
readfile($pdfFile);

?>
