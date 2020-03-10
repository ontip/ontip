<?php
//// export_inschrijf_PWS_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een Excel xlsx bestand  tbv Petanque Wedstrijd systeem van Sjaak Franken
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 7mar2020          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
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
body { font-family:calibri; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<?php


// Database gegevens. 
include('mysqli.php');
//include ('include_PHP_Excel_style_sheets.php');

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
$toernooi = $_GET['toernooi'];
// Ophalen toernooi gegevens
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
		exit;
		
};
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}    
?>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='180'><img src = '../ontip/images/ontip_logo.png' width='180'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanmaak excel export PWS voor "<?php echo $toernooi_voluit;?>"</h3>
<br>
<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)



$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];	

$timest  = date('Y-m-d H:i:s');
$xlsx_file ="csv/namen_pws.xlsx";

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

 /// styles
  $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
  $border_bottom2 = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THICK
            )
        )
    );
	
   $black7_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 7,
                   'name'  => 'calibri'
       ));
	   
   $grey6_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '757575'),
                   'size'  => 6,
                   'name'  => 'calibri'
       ));
	
   $grey11_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '757575'),
                   'size'  => 11,
                   'name'  => 'calibri'
       ));

	   
   $black9_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 9,
                   'name'  => 'calibri'
       ));
	   
    $blue7_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '0000ff'),
                   'size'  => 7,
                   'name'  => 'calibri'
       ));
	   
	$darkblue8_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '00005A'),
                   'size'  => 8,
                   'name'  => 'calibri'
       ));
	   
	$blue9_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '0000ff'),
                   'size'  => 9,
                   'name'  => 'calibri'
       ));
	   
	   
	   
    $black10_style= array('font'  => 
             array('bold'  => false,
                   'color' => array('rgb' => '000000'),
                   'size'  => 10,
                   'name'  => 'calibri'
       ));
	   
	 $black11_style= array('font'  => 
             array('bold'  => true,
                   'color' => array('rgb' => '000000'),
                   'size'  => 11,
                   'name'  => 'calibri'
       ));
	   
	$hor_center_style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
	
    $border_right = array(
        'borders' => array(
            'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

	
	$ver_center_style = array(
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
      );
	 
	$ver_bottom_style = array(
        'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM,
        )
      );
	
	   $align_right_style = array(
        'font' => array(
            'bold' => true,
            'color' => array('rgb' => '2F4F4F')
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
    );
	
	
 ///  end styles


  // Set document properties
  //echo date('H:i:s') , " Set document properties" , EOL;
  $objPHPExcel->getProperties()->setCreator("OnTip")
					     	 ->setLastModifiedBy("OnTip")
							 ->setTitle("OnTip Excel export")
							 ->setSubject("OnTip inschrijvingen  PWS")
							 ->setDescription("Excel bestand met de gegevens van de deelnemers.")
							 ->setKeywords("Office Excel OnTip")
							 ->setCategory("Inschrijvingen");

   //  Hide Column A
   //$objPHPExcel->getColumnDimension(1)->setVisible(false);
 
  // Merge cells in headers
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B5');
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E1:K2'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I4:K4'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L1:L5'); 
  
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D1:D3'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E3:F3'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G3:H3'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I3:K3'); 
 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:D4'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E4:F4'); 
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G4:H4'); 
  
  
  $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(28);
 
  // header teksten
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B1', '(C)')
            ->setCellValue('B2', 'SF')
            ->setCellValue('B3', 'Inschrijfnr')
            ->setCellValue('C1', 'Inlichtingen:')
            ->setCellValue('C2', 'Sjaak Franken')
            ->setCellValue('I4', 'Licenties');
            
   $objPHPExcel->setActiveSheetIndex(0)            ->setCellValue('L1', 'Lotnummer');
	
   $objPHPExcel->setActiveSheetIndex(0)             ->setCellValue('E3', $toernooi_voluit);
	
   $objPHPExcel->setActiveSheetIndex(0)             ->setCellValue('G3', $soort_inschrijving);
	
   $objPHPExcel->setActiveSheetIndex(0)             ->setCellValue('I3','OnTip export: '.$timest);
 	
   $objPHPExcel->setActiveSheetIndex(0)             ->setCellValue('D1',$vereniging);
		
	// email link
	
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', 'sjaabe@gmail.com');
    $objPHPExcel->setActiveSheetIndex(0)->getCell('C3')->getHyperlink()->setUrl('mailto:sjaabe@gmail.com');
    $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($blue7_style);
	
	
  //  tekst rotering
   $objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setTextRotation(90); 
   $objPHPExcel->getActiveSheet()->getStyle('L1')->getAlignment()->setTextRotation(90); 

   $objPHPExcel->getActiveSheet()->getStyle('C3:K3')->applyFromArray($border_bottom);
   $objPHPExcel->getActiveSheet()->getStyle('B5:L5')->applyFromArray($border_bottom2);
 
  // Add header line 2 +3
    
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C5', 'Speler 1')
            ->setCellValue('D5', 'Club 1')
	         ->setCellValue('E5', 'Speler 2')
            ->setCellValue('F5', 'Club 2')
	        ->setCellValue('G5', 'Speler 3')
            ->setCellValue('H5', 'Club 3')
		    ->setCellValue('I5', 'Speler 1')
            ->setCellValue('J5', 'Speler 2')
            ->setCellValue('K5', 'Speler 3');
   
     $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('I4')->applyFromArray($ver_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($ver_bottom_style);
     $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($align_right_style);
  	
    // vertikale borders
     $objPHPExcel->getActiveSheet()->getStyle('B1:B5')->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('D1:D5')->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('F4:F5')->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('H4:H5')->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('K1:K5')->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('L1:L5')->applyFromArray($border_right);
  
       // pas breedte kolommen aan    
    
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(4); 
   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(28);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(28); 
  // licenties   
   $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(4);   
	                                                     
  // eerste 5 regels bold                                
   $objPHPExcel->getActiveSheet()->getStyle('B1:L5')->applyFromArray($black11_style);       
   $objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($black9_style);
   $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($black9_style);
   $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($grey6_style);  
   $objPHPExcel->getActiveSheet()->getStyle('E3:H3')->applyFromArray($grey6_style);  
   $objPHPExcel->getActiveSheet()->getStyle('I3')->applyFromArray($darkblue8_style);  

  
   // afwijkend   
   $objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($blue7_style);
   $objPHPExcel->getActiveSheet()->getStyle('B1:B2')->applyFromArray($black9_style);
   
   //  afwiikend kleur bij triplet
	if ($soort_inschrijving !='triplet'  and $inschrijf_methode =='vast' ){
        $objPHPExcel->getActiveSheet()->getStyle('G5:H5')->applyFromArray($grey11_style);
        $objPHPExcel->getActiveSheet()->getStyle('K5')->applyFromArray($grey11_style);
	}
	
  
  // set print Layout
  // Set Orientation, size and scaling
  $objPHPExcel->setActiveSheetIndex(0);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    
  // freeze eerste 5 regels
  $objPHPExcel->getActiveSheet()->freezePane('A6');
  
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
  // details
  $spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

   $i=1;

   while($row = mysqli_fetch_array( $spelers )) {
   $j=$i+5; // regel nummer

 
   //  melee of tete-a-tete
    if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
		
		$objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('B'.$j, $i)
		   ->setCellValue('C'.$j, $row['Naam1'])
           ->setCellValue('D'.$j, $row['Vereniging1'])
           ->setCellValue('I'.$j, $row['Licentie1']);
     }
   //  doublet
   if ($soort_inschrijving !='single' and $inschrijf_methode =='vast' ){
		 $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('B'.$j, $i)
             ->setCellValue('C'.$j, $row['Naam1'])
             ->setCellValue('D'.$j, $row['Vereniging1'])
             ->setCellValue('I'.$j, $row['Licentie1']);
		   
		 $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('E'.$j, $row['Naam2'])
             ->setCellValue('F'.$j, $row['Vereniging2'])
             ->setCellValue('J'.$j, $row['Licentie2']);
	}

    // triplet
	if ($soort_inschrijving == 'triplet'  and $inschrijf_methode =='vast' ){
		  $objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue('G'.$j, $row['Naam3'])
             ->setCellValue('H'.$j, $row['Vereniging3'])
             ->setCellValue('K'.$j, $row['Licentie3']);
  }
  	$objPHPExcel->setActiveSheetIndex(0)
     		   ->setCellValue('L'.$j, $i);
		   
		   
   // borders
     $objPHPExcel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('D'.$j)->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('F'.$j)->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('H'.$j)->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('K'.$j)->applyFromArray($border_right);
     $objPHPExcel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($border_right);
 
     $objPHPExcel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($hor_center_style);
     $objPHPExcel->getActiveSheet()->getStyle('L'.$j)->applyFromArray($hor_center_style);
 
   $i++;
   }// end while
   
    // laatste regel botom
    $objPHPExcel->getActiveSheet()->getStyle('B'.$j.':L'.$j)->applyFromArray($border_bottom2);
 
    /// details
     $objPHPExcel->getActiveSheet()->getStyle('C6:K'.$j)->applyFromArray($black10_style);       
 
    /// beveilig alle cellen
   $objPHPExcel->getActiveSheet()->protectCells('B1:L'.$j, 'PHP');
   $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
     
	 /// copy
	 $objPHPExcel->getActiveSheet()->rangeToArray('B6:L'.$j);
	 
	 
	 
  // Rename worksheet
  
  $objPHPExcel->getActiveSheet()->setTitle('Inschrijvingen');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
 // echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

  
 
?>
<a style='font-size:11pt;' href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = '../ontip/images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
</blockquote>
</body>
</html>