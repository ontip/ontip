 <?php
 # Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 29apr2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           None.
# Reference: 

ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

include('mysqli.php'); 
$today = date('Y-m-d');
$ip    = $_SERVER['REMOTE_ADDR'];
$pageName        = basename($_SERVER['SCRIPT_NAME']);
$now             = date('d-m-Y H:i');  // 201701171234              
include('include_write_logfile.php');
 
 /// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';
include('aanlog_checki.php');	
 
if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php?url=<?php echo $pageName;?>");
</script>
<?php
exit;
}
             
// Ophalen toernooi gegevens
// toernooi naam opgehaald vanuit mysqli.php

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode    = $result['Parameters'];
$soort_inschrijving   = $result['Waarde'];
?>

<html>
 <head>
 <title>OnTip - import en export</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
 
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>
 
<style>
 

 <?php
 include("css/standard.css")
  ?>
  h5 {font-weight:bold;}
</style>
<script language="javascript">
function changeColor(color,id) {
document.getElementById('item1').style.color = "red";
};
</script>

 </head>

<body >
 
 <?php
$short_menu='Ja';
include('include_navbar.php') ;
?>


<br>
<div class= 'container'   >
 <div class= 'card w-100'>
    <div class= 'card card-header'>
    <h3><i class="fas fa-file-excel"></i> Excel export "<?php echo $toernooi_voluit;?>"</h3>
   
   </div>
 
   <div class= 'card card-body'>
  
 <?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}    
	
if (isset($toernooi)) {
	// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$qry         = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'licentie_jn'  ") ;  
$result      = mysqli_fetch_array( $qry);
$licentie_jn = $result['Waarde'];


$timest  = date('Y-m-d h:i:s');
$xlsx_file ="csv/inschr_uitgebreid_".$toernooi.".xlsx";


?>
 <br>
<p STYLE ='font-size:1.4vh;'>Dit programma maakt een Excel bestand met uitgebreide informatie van de inschrijvingen  .</p>
<br>
<?php
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

/** Init PHP Excel **/
 
 // echo date('H:i:s') , " Create new PHPExcel object" , EOL;
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
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:F1');    
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:J1');    
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen licentie, naam en vereniging')
            ->setCellValue('E1', $toernooi_voluit)
            ->setCellValue('H1', $vereniging);


// center header line2
	  $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            )
       );
    $objPHPExcel->getActiveSheet()->getStyle("A2:S2")->applyFromArray($style);
         
	   $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    
    
  // Add header line 2 +3

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' and $licentie_jn =='J' ){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($border_bottom);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler');
 	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Licentie')          
            ->setCellValue('C3', 'Naam')          
            ->setCellValue('D3', 'Vereniging');          
   }
 
 if ($soort_inschrijving =='single' or $inschrijf_methode =='single' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($border_bottom);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler');
 	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging');          
}
 
 
 
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast' and $licentie_jn =='J'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('E2', 'Speler 2');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Licentie')          
            ->setCellValue('C3', 'Naam')          
            ->setCellValue('D3', 'Vereniging')                    
            ->setCellValue('E3', 'Licentie')          
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging');                     
   }

 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2');
   	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging')                    
            ->setCellValue('D3', 'Naam')          
            ->setCellValue('E3', 'Vereniging');                     
   }


 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:J2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:J3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('E2', 'Speler 2')
            ->setCellValue('H2', 'Speler 3');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H3', 'Licentie')          
            ->setCellValue('I3', 'Naam')          
            ->setCellValue('J3', 'Vereniging');            
  }

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging');            
  }


  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:J2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K2:M2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('E2', 'Speler 2')
            ->setCellValue('H2', 'Speler 3')
            ->setCellValue('K2', 'Speler 4');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K3', 'Licentie')          
            ->setCellValue('L3', 'Naam')          
            ->setCellValue('M3', 'Vereniging');            
  }

 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H3', 'Naam')          
            ->setCellValue('I3', 'Vereniging');            
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:J2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K2:M2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N2:P2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:P3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('E2', 'Speler 2')
            ->setCellValue('H2', 'Speler 3')
            ->setCellValue('K2', 'Speler 4')
            ->setCellValue('N2', 'Speler 5');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('N3', 'Licentie')          
            ->setCellValue('O3', 'Naam')          
            ->setCellValue('P3', 'Vereniging');            
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:K2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4')
            ->setCellValue('J2', 'Speler 5');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J3', 'Naam')          
            ->setCellValue('K3', 'Vereniging');            
  }

  
  if ($soort_inschrijving  == 'sextet' and $licentie_jn =='J'){
  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:D2');
  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:J2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K2:M2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N2:P2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q2:S2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:S3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
	          ->setCellValue('B2', 'Speler 1')
            ->setCellValue('E2', 'Speler 2')
            ->setCellValue('H2', 'Speler 3')
            ->setCellValue('K2', 'Speler 4')
            ->setCellValue('N2', 'Speler 5')
            ->setCellValue('Q2', 'Speler 6');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('Q3', 'Licentie')          
            ->setCellValue('R3', 'Naam')          
            ->setCellValue('S3', 'Vereniging');            
   }

  if ($soort_inschrijving  == 'sextet' and $licentie_jn =='N'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:K2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:M2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4')
            ->setCellValue('J2', 'Speler 5')
            ->setCellValue('L2', 'Speler 6');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L3', 'Naam')          
            ->setCellValue('M3', 'Vereniging');            
   }

            
    // pas breedte kolommen aan    
    
  if( $licentie_jn =='J'){
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(28);   
} else {
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(28);   
}                                                      
	                                                     
// eerste 3 regels bold                                
                                                      
                                                       
   // A1: set  font red
   $style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Verdana'
       ));
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

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysqli_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {
$j=$i+3;


$row['Vereniging1'] = str_replace("&#39" ,'`', $row['Vereniging1']);
$row['Vereniging2'] = str_replace("&#39" ,'`', $row['Vereniging2']);
$row['Vereniging3'] = str_replace("&#39" ,'`', $row['Vereniging3']);
$row['Vereniging4'] = str_replace("&#39" ,'`', $row['Vereniging4']);
$row['Vereniging5'] = str_replace("&#39" ,'`', $row['Vereniging5']);
$row['Vereniging6'] = str_replace("&#39" ,'`', $row['Vereniging6']);


if ($soort_inschrijving =='single' or $inschrijf_methode =='single' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Licentie1'])
           ->setCellValue('C'.$j, $row['Naam1'])
           ->setCellValue('D'.$j, $row['Vereniging1']);

   }

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Vereniging1']);

   }


 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Licentie1'])
           ->setCellValue('C'.$j, $row['Naam1'])
           ->setCellValue('D'.$j, $row['Vereniging1'])
           ->setCellValue('E'.$j, $row['Licentie2'])
           ->setCellValue('F'.$j, $row['Naam2'])
           ->setCellValue('G'.$j, $row['Vereniging2']);
}

if ($soort_inschrijving !='single' and $inschrijf_methode =='vast' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Vereniging1'])
           ->setCellValue('D'.$j, $row['Naam2'])
           ->setCellValue('E'.$j, $row['Vereniging2']);
}


 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('H'.$j, $row['Licentie3'])
           ->setCellValue('I'.$j, $row['Naam3'])
           ->setCellValue('J'.$j, $row['Vereniging3']);
  }

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('F'.$j, $row['Naam3'])
           ->setCellValue('G'.$j, $row['Vereniging3']);
  }

  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('K'.$j, $row['Licentie4'])
           ->setCellValue('L'.$j, $row['Naam4'])
           ->setCellValue('M'.$j, $row['Vereniging4']);
  }

  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('H'.$j, $row['Naam4'])
           ->setCellValue('I'.$j, $row['Vereniging4']);
  }



 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('N'.$j, $row['Licentie5'])
           ->setCellValue('O'.$j, $row['Naam5'])
           ->setCellValue('P'.$j, $row['Vereniging5']);

  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('J'.$j, $row['Naam5'])
           ->setCellValue('K'.$j, $row['Vereniging5']);

  }

  
  if ($soort_inschrijving  == 'sextet' and $licentie_jn =='J'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('Q'.$j, $row['Licentie6'])
           ->setCellValue('R'.$j, $row['Naam6'])
           ->setCellValue('S'.$j, $row['Vereniging6']);
   }

  if ($soort_inschrijving  == 'sextet' and $licentie_jn =='N'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('L'.$j, $row['Naam6'])
           ->setCellValue('M'.$j, $row['Vereniging6']);

   }


   
$i++;
};


   $objPHPExcel->getActiveSheet()->getStyle('A1:S3')->getFont()->setBold(true);
   
   
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

 
} // end if 
 
  
 if ($xlsx_file !=''){?>
  <div><i class="fas fa-file-excel"></i> Aangemaakt op <?php echo date('d-m-Y h:i:s');?></div>
  <?php } ?>
  
  </div> <!--- card body ---->
  
  <div class = 'card card-footer'>
  <table class='w-100'>
     <tr>
	   <td  style='text-align:left;'>
	     <input type="button" value="Vorige pagina" class='btn btn-sm btn-info' onclick="history.back()" /> 
         </td>
	  <td  style='text-align:right;'>
	 <?php
		 if ($xlsx_file !=''){?>
		<a style='font-size:12pt;' role = 'button'  class ='btn btn-sm btn-success' href = '<?php echo $xlsx_file;?>' target = '_blank'><i class="fa fa-download" aria-hidden="true"></i> Download bestand</a> 
     <?php } ?>	  </td>    
	 </tr>
	 </table>
  </DIV>
 
	 
</div>  <!--  card  ---->
	</div>  <!--  container ---->
 <!-- Footer -->

<!-- Footer -->
 </body>
</html>
