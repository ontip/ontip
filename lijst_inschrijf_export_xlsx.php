<?php
//// lijst_export_inschrijf_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de inschrijvingen voor een toernooi.

# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 10mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
};


if (isset($toernooi)) {
	// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$timest  = date('Ymdhis');
$xlsx_file ="csv/inschr_summier_".$toernooi.".xlsx";

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
 
  echo date('H:i:s') , " Create new PHPExcel object" , EOL;
  $objPHPExcel = new PHPExcel();

  // Set document properties
  echo date('H:i:s') , " Set document properties" , EOL;
  $objPHPExcel->getProperties()->setCreator("OnTip")
							 ->setLastModifiedBy("OnTip")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Inschrijvingen");

 
  // Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen alleen namen ')
            ->setCellValue('D1', $toernooi_voluit)
            ->setCellValue('E1', $vereniging)
            ->setCellValue('F1', 'Tijd: '.$timest);


  // Add header line 2

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler');
   }

 
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2');
   }

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2')
            ->setCellValue('D2', 'Naam speler 3');
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2')
            ->setCellValue('D2', 'Naam speler 3')
            ->setCellValue('E2', 'Naam speler 4');
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2')
            ->setCellValue('D2', 'Naam speler 3')
            ->setCellValue('E2', 'Naam speler 4')
            ->setCellValue('F2', 'Naam speler 5');
  }
  
  if ($soort_inschrijving  == 'sextet'){
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', 'Nr')
            ->setCellValue('B2', 'Naam speler 1')
            ->setCellValue('C2', 'Naam speler 2')
            ->setCellValue('D2', 'Naam speler 3')
            ->setCellValue('E2', 'Naam speler 4')
            ->setCellValue('F2', 'Naam speler 5')
            ->setCellValue('G2', 'Naam speler 6');
   }
            
    // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getStyle('A1:G2')->getFont()->setBold(true);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// SQL Queries

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {
$j=$i+2;
if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1']);

   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2']);
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2'])
           ->setCellValue('D'.$j, $row['Naam3']);
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2'])
           ->setCellValue('D'.$j, $row['Naam3'])
           ->setCellValue('E'.$j, $row['Naam4']);
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2'])
           ->setCellValue('D'.$j, $row['Naam3'])
           ->setCellValue('E'.$j, $row['Naam4'])
           ->setCellValue('F'.$j, $row['Naam5']);
  }
  
  if ($soort_inschrijving  == 'sextet'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Naam2'])
           ->setCellValue('D'.$j, $row['Naam3'])
           ->setCellValue('E'.$j, $row['Naam4'])
           ->setCellValue('F'.$j, $row['Naam5'])
           ->setCellValue('G'.$j, $row['Naam6']);
   }
   
$i++;
};

  // Rename worksheet
  echo date('H:i:s') , " Rename worksheet" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Voucher codes');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
  echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

 
} // end if 
 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'>Klik hier voor bestand</a> 
</body>
</html>
