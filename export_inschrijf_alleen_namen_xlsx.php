<?php
//// lijst_export_inschrijf_alleen_namen.xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de inschrijvingen voor een toernooi.
# 5mei2019          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               PHP7.
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

setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
// Ophalen toernooi gegevens

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              

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
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
		exit;
		
};


if (isset($toernooi)) {
	// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$timest    = date('Y-m-d h:i:s');
$xlsx_file ="csv/inschr_alleen_namen_".$toernooi.".xlsx";

// verwijder bestand indien aanwezig
unlink($xlsx_file);

 // aanmaak xlsx
 /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  date_default_timezone_set('Europe/London');

  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include path **/
  require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

/** Init PHP Excel **/
  $objPHPExcel = new PHPExcel();

  // Set document properties
  $objPHPExcel->getProperties()->setCreator("OnTip")
							 ->setLastModifiedBy("OnTip")
							 ->setTitle("OnTip Excel export")
							 ->setSubject("OnTip inschrijvingen")
							 ->setDescription("Excel bestand met de namen van de deelnemers.")
							 ->setKeywords("Office Excel OnTip")
							 ->setCategory("Inschrijvingen");

 
  // Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:E1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F1:G1');
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen alleen namen')
            ->setCellValue('D1', $toernooi_voluit)
            ->setCellValue('F1', $vereniging);
  

  // Add header line 2
   $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
   
   
   
 if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
	  $objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler');
   }

 
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
 	  $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2');
   }

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
 		$objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D2', 'Naam speler 3');
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
 		$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('E2', 'Naam speler 4');
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
 	  $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('F2', 'Naam speler 5');
  }
  
  if ($soort_inschrijving  == 'sextet'){
	  $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($border_bottom);
	  $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('G2', 'Naam speler 6');
   }
            
    // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(32);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(32);   

  // eerste 2 regels bold
   $objPHPExcel->getActiveSheet()->getStyle('A1:H2')->getFont()->setBold(true);

   // A1: set  font red
   $style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Verdana'
       )) ;
   $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray($style);            

  // footer  (secties L en R) met Pagina nr en tot paginas
  $objPHPExcel->getActiveSheet()->getHeaderFooter()->setDifferentOddEven(false);
  $objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L Aanmaak:'.$timest.'&C &F &R Pag. &P / &N');
  
  // set print Layout
  // Set Orientation, size and scaling
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// SQL Queries

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {
$j=$i+2;
if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i.".")
           ->setCellValue('B'.$j, $row['Naam1']);

   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i.".")
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2']);
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('D'.$j, $row['Naam3']);
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('E'.$j, $row['Naam4']);
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0) 
                  ->setCellValue('F'.$j, $row['Naam5']);
  }
   
  if ($soort_inschrijving  == 'sextet'){
		  $objPHPExcel->setActiveSheetIndex(0)
                 ->setCellValue('G'.$j, $row['Naam6']);
   }
   
$i++;
};

  // Rename worksheet
  $objPHPExcel->getActiveSheet()->setTitle('Inschrijvingen');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

 
} // end if 
 


?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = '../ontip/images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
</blockquote>
</body>
</html