<?php
//// lijst_email_notificaties_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de namen en ge decrypte waarden voor email adressen.

# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 22jun2019          1.0.1           E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None.
# Feature:          None.
# Reference: 
#

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
	<head>
		<title>OnTip lijst email notificaties</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<?php

// Database gegevens. 
include('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email

if (isset($_GET['id'])){	
$vereniging_id = $_GET['id'];
$toernooi      = $_GET['toernooi'];

	$qry  = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};

4
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Email notificaties</TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:green ;'><?php echo $toernooi_voluit;?></TD></tr>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanmaak excel bestand</h3>
<br>
Er wordt een Excel bestand aangemaakt met daarin de aangemelde email notificaties binnen OnTip.<br>
Hiervoor kan een deelnemer zich aanmelden als de functie is aangezet voor een toernooi en het toernooi volgeboekt is.<br>
Zodra er een  deelnemer wordt verwijderd en de email notificaties worden verstuurd krijgen de aangemelde email adressen een bericht dat er weer ingeschreven kan worden.<br>
<br>


<?php
if (isset($_GET['id'])){
$vereniging_id = $_GET['id'];
$toernooi      = $_GET['toernooi'];
if (isset($toernooi)) {
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};


$qry        = mysqli_query($con,"SELECT * From email_notificaties where Vereniging_id = ".$vereniging_id." and Toernooi = '".$toernooi."' order by Vereniging_id  , Toernooi ") ;  

} else {
$qry        = mysqli_query($con,"SELECT * From email_notificaties order by Vereniging_id  , Toernooi  ") ;  
	
	
}

$timest  = date('Ymd');
$xlsx_file ="csv/email_notificaties_".$timest.".xlsx";

// verwijder bestand indien aanwezig
unlink($xlsx_file);

 // aanmaak xlsx
 /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  date_default_timezone_set('Europe/Amsterdam');

  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include path **/
  require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

/** Init PHP Excel **/
 
  //echo date('H:i:s') , " Create new PHPExcel object" , EOL;
  $objPHPExcel = new PHPExcel();

  // Set document properties
 // echo date('H:i:s') , " Set document properties" , EOL;
  $objPHPExcel->getProperties()->setCreator("OnTip")
							 ->setLastModifiedBy("OnTip")
							 ->setTitle("Beheerders")
							 ->setSubject("Beheerders")
							 ->setDescription("Lijst met alle beheerders.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Beheerders");

 
  // Add header line 1
  
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Email notificaties')
            ->setCellValue('F1', 'Tijd: '.$timest);


  // Add header line 2

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Ver.Id')
            ->setCellValue('C2', 'Vereniging Naam')
            ->setCellValue('D2', 'Toernooi')
            ->setCellValue('E2', 'Datum')
            ->setCellValue('F2', 'Naam')
            ->setCellValue('G2', 'Kenmerk')
            ->setCellValue('H2', 'Email adres')
            ->setCellValue('I2', 'Laatst');

 // details
 
$r=3;
$i=1;

 while($row = mysqli_fetch_array( $qry )) {
 	
 if (	$row['Email_encrypt'] !=''){
 	$email = versleutel_string($row['Email_encrypt']);
} else {
 	$email = $row['Email'];

}
	 	
 
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$r, $i)
            ->setCellValue('B'.$r, $row['Vereniging_id'])
            ->setCellValue('C'.$r, $row['Vereniging'])
            ->setCellValue('D'.$r, $row['Toernooi'])
            ->setCellValue('E'.$r, $row['Datum'])
            ->setCellValue('F'.$r, $row['Naam'])
            ->setCellValue('G'.$r, $row['Notificatie_kenmerk'])
            ->setCellValue('H'.$r, $email)
            ->setCellValue('I'.$r, $row['Laatst']);


$r++;
$i++;
}
        // A1: set  font red
   $style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Verdana'
       )) ;
	   
	$border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    
   $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray($style);       
   $objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($border_bottom);   
   
    // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(26);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);   
   
   $objPHPExcel->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);


  // Rename worksheet
 // echo date('H:i:s') , " Rename worksheet" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Email notificaties');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
  //echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'>Klik hier voor bestand</a> 
</blockquote>
</body>
</html>
