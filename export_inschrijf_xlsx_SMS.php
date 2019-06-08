<?php
//// export_inschrijf_xlsx_SMS.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de inschrijvingen voor een toernooi.Naam1, vereniging1, Telefoon# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 7jun2019          1.0.1            E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None
# Feature:           None.
# Reference: 


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
	<head>
		<title>OnTip export inschrijvingen</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<?php
$toernooi = $_GET['toernooi'];

// Database gegevens. 
include('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email
setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
// Ophalen toernooi gegevens
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
		exit;
		
};
?>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanmaak excel export voor "<?php echo $toernooi_voluit;?>"</h3>
<br>
<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}    
	
/// naam bestand
$timest  = date('Y-m-d h:i:s');
$xlsx_file = 'csv/sms_'.$toernooi.'_'.$timest.'.xlsx';

// verwijder bestand indien aanwezig
unlink($xlsx_file);

// aanmaak xlsx
 /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
//  date_default_timezone_set('Amsterdam');

  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include path **/
  require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

  $objPHPExcel = new PHPExcel();
  
   // Set document properties
  //echo date('H:i:s') , " Set document properties" , EOL;
  $objPHPExcel->getProperties()->setCreator("OnTip")
								 ->setLastModifiedBy("OnTip")
							 ->setTitle("OnTip Excel export")
							 ->setSubject("OnTip inschrijvingen")
							 ->setDescription("Excel bestand met de namen + verenigingen van de deelnemers.")
							 ->setKeywords("Office Excel OnTip")
							 ->setCategory("Inschrijvingen");

  // Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:G1');    
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:J1');    
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen naam , vereniging en telefoon nummer')
            ->setCellValue('D1', $toernooi_voluit)
            ->setCellValue('H1', $vereniging);
  	  
 // Add header line 2 	  
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Naam')
            ->setCellValue('C2', 'Vereniging')
            ->setCellValue('D2', 'Telefoon');          

            
    // pas breedte kolommen aan    
 
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);   
   
  // eerste 2 regels bold                                
   $objPHPExcel->getActiveSheet()->getStyle('A1:S2')->getFont()->setBold(true);                                               
                                                       
   // A1: set  font red
   $style_red = array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Verdana'
       ));
   $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray($style_red);       
   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// SQL Queries

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {
$j=$i+2;

    $telefoon = $row['Telefoon'];
   if ($telefoon =='[versleuteld]'){
   	$telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }





$row['Vereniging1'] = str_replace("&#39" ,'`', $row['Vereniging1']);

	$objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Vereniging1'])
           ->setCellValue('D'.$j, $telefoon);

$i++;
};

  // Rename worksheet
  //echo date('H:i:s') , " Rename worksheet" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Inschrijvingen');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
 // echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

 
 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = '../ontip/images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
</blockquote>
</body>
</html>
