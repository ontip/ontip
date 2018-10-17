<?php
//// export_inschrijf_uitgebreid_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de inschrijvingen voor een toernooi.Naam, vereniging, Licentie
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
include('mysql.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
};

if (isset($toernooi)) {
	// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$qry         = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'licentie_jn'  ") ;  
$result      = mysql_fetch_array( $qry);
$licentie_jn = $result['Waarde'];


$timest  = date('Y-m-d h:i:s');
$xlsx_file ="csv/inschr_uitgebreid_".$toernooi.".xlsx";

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
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Inschrijvingen");

 
  // Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H1:I1');    
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:F1');    
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen licentie, naam en vereniging')
            ->setCellValue('E1', $toernooi_voluit)
            ->setCellValue('H1', $vereniging)
            ->setCellValue('J1', $timest);


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
	  $objPHPExcel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($border_bottom);

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
    

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// SQL Queries

$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysql_fetch_array( $spelers )) {
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
 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'>Klik hier voor bestand</a> 
</body>
</html>
