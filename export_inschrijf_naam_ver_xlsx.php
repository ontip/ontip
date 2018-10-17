<?php
//// export_inschrijf_naam_ver_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand met de inschrijvingen voor een toernooi.
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
// Database gegevens. 
include('mysql.php');

ini_set('display_errors', 'On');
error_reporting(E_ALL);

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

$toernooi = $_GET['toernooi'];
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


<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysql_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}     

	// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$timest    = date('Y-m-d h:i:s');
$xlsx_file ="csv/inschr_naam_ver_".$toernooi.".xlsx";
?>
<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanmaak excel export voor "<?php echo $toernooi_voluit;?>"</h3>
<br>
<?php

// verwijder bestand indien aanwezig
unlink($xlsx_file);

 // aanmaak xlsx
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  
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
							 ->setDescription("Excel bestand met de namen + verenigingen van de deelnemers.")
							 ->setKeywords("Office Excel OnTip")
							 ->setCategory("Inschrijvingen");
 
  // Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:E1');

  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Inschrijvingen naam en vereniging')
            ->setCellValue('D1', $toernooi_voluit)
            ->setCellValue('F1', $vereniging);
 //           ->setCellValue('G1', $timest);

// center header line2
	  $style = array(
        'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                            )
       );
    $objPHPExcel->getActiveSheet()->getStyle("A2:M2")->applyFromArray($style);
         
	   $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
   
    
  // Add header line 2 +3

 if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
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
 
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
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

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
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
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging')                    
            ->setCellValue('D3', 'Naam')          
            ->setCellValue('E3', 'Vereniging')                    
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging');            
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:I3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging')                    
            ->setCellValue('D3', 'Naam')          
            ->setCellValue('E3', 'Vereniging')                    
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging')            
            ->setCellValue('H3', 'Naam')          
            ->setCellValue('I3', 'Vereniging');            
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:K2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:K3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4')
            ->setCellValue('J2', 'Speler 5');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging')                    
            ->setCellValue('D3', 'Naam')          
            ->setCellValue('E3', 'Vereniging')                    
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging')            
            ->setCellValue('H3', 'Naam')          
            ->setCellValue('I3', 'Vereniging')            
            ->setCellValue('J3', 'Naam')          
            ->setCellValue('K3', 'Vereniging');            
  }
  
  if ($soort_inschrijving  == 'sextet'){
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:C2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:E2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:G2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:I2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:K2');
	  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:M2');
	  $objPHPExcel->getActiveSheet()->getStyle('A3:M3')->applyFromArray($border_bottom);

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '')
            ->setCellValue('B2', 'Speler 1')
            ->setCellValue('D2', 'Speler 2')
            ->setCellValue('F2', 'Speler 3')
            ->setCellValue('H2', 'Speler 4')
            ->setCellValue('J2', 'Speler 5')
            ->setCellValue('L2', 'Speler 6');
  	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam')          
            ->setCellValue('C3', 'Vereniging')                    
            ->setCellValue('D3', 'Naam')          
            ->setCellValue('E3', 'Vereniging')                    
            ->setCellValue('F3', 'Naam')          
            ->setCellValue('G3', 'Vereniging')            
            ->setCellValue('H3', 'Naam')          
            ->setCellValue('I3', 'Vereniging')            
            ->setCellValue('J3', 'Naam')          
            ->setCellValue('K3', 'Vereniging')            
            ->setCellValue('L3', 'Naam')          
            ->setCellValue('M3', 'Vereniging');            
   }
            
    // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(22);   

  // eerste 3 regels bold
   $objPHPExcel->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);

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

$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysql_fetch_array( $spelers )) {
$j=$i+3;

 if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Vereniging1']);
   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $row['Naam1'])
           ->setCellValue('C'.$j, $row['Vereniging1'])
           ->setCellValue('D'.$j, $row['Naam2'])
           ->setCellValue('E'.$j, $row['Vereniging2']);
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('F'.$j, $row['Naam3'])
           ->setCellValue('G'.$j, $row['Vereniging3']);
  }
  
 if (($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('H'.$j, $row['Naam4'])
           ->setCellValue('I'.$j, $row['Vereniging4']);
  }

 if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('J'.$j, $row['Naam5'])
           ->setCellValue('K'.$j, $row['Vereniging5']);
  }
  
  if ($soort_inschrijving  == 'sextet'){
		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('L'.$j, $row['Naam6'])
           ->setCellValue('M'.$j, $row['Vereniging6']);
   }
  
$i++;
};

  // Rename worksheet
 // echo date('H:i:s') , " Rename worksheet" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Inschrijvingen');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

 // Save Excel 2007 file
 // echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save($xlsx_file);

 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = '../ontip/images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
</blockquote>
</body>
</html>