<?php
# marathon_scorelijst_xlsx.php
#
# Record of Changes:
#

# 15mar2020          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           
# Reference: 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css" media="print">
body {color:blue;font-size: 9pt; font-family:Verdana;background-color:white;  }
th {color:black;font-size: 14t;vertical-align:bottom;padding:5pt;}
td {color:black;font-size: 11pt;padding:4pt;}
h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
.noprint {display:none;}     

.onderschrift     {font-size:8pt;color:blue;text-align:center;padding:1pt;}

	a { text-decoration:none;color:blue;}
</style>
</head>
<body>
<?php

// Database gegevens. 
include('mysqli.php');
setlocale(LC_ALL, 'nl_NL');

$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'marathon_ronde'  ") ;  
$result              = mysqli_fetch_array( $qry);
$marathon_ronde      = $result['Waarde'];

$datum   = $_GET['datum'];
$jaar    =  substr($datum, 0,4);
$maand   =  substr($datum, 5,2);
$dag     =  substr($datum, 8,2);

?>
 <table width=80%>
 <tr>
  <td><img src = 'images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'><?php echo $vereniging;?></span></td>
  <td width=70%><h1 style='color:blue;font-weight:bold;font-size:26pt; text-shadow: 2px 2px darkgrey;text-align:center;'>Eindstand Marathon Hussel<br>
     <span style='color:darkgreen;font-weight:bold;font-size:18pt; text-shadow: 2px 2px darkgrey;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );?>
	 </span></h1>
</table>


<blockquote>

<div style= 'color:black;font-size:11pt;'>
Door te klikken op onderstaande link wordt het bestand gedownload naar de PC. Na een paar seconden krijgt u onderaan het scherm de melding dat het bestand gedownload is.<br>

<?php
require '../PHPspreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//include('../include_PHPspreadsheet_styles.php');
// functie om nummerieke waarde om te zetten naar letters voor de kolommen
 include('include_convert_colnum_to_alpha.php') ;

// styles

 $borders_outline_red = [
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => 'FFFF0000'],
        ],
    ],
];

$red10_style= [
        'font' => [
          'bold' => false,
		   'color' => [ 'rgb' => 'ff0000' ],
            'size'  => 10,
            'name'  => 'calibri',
	          ],
			 ];
$red16_style= [
        'font' => [
          'bold' => true,
		   'color' => [ 'rgb' => 'ff0000' ],
            'size'  => 16,
            'name'  => 'calibri',
	          ],
			 ];


$borders = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ],
];

 $border_bottom = [
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000'],
        ],
    ],
];

 $border_bottom_red = [
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => 'FFFF0000'],
        ],
    ],
];

 $border_right = [
    'borders' => [
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '00000000'],
        ],
    ],
];

 $border_bottom2 = [
    'borders' => [
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '00000000'],
        ],
    ],
];

  $black12_style= [
        'font' => [
          'bold' => false,
		   'color' => [ 'rgb' => '000000' ],
            'size'  => 12,
            'name'  => 'calibri',
	          ],
			 ];		

    $black10_style= [
        'font' => [
          'bold' => false,
		   'color' => [ 'rgb' => '000000' ],
            'size'  => 10,
            'name'  => 'calibri',
	          ],
			 ];		
    $black10_bold_style= [
        'font' => [
          'bold' => true,
		   'color' => [ 'rgb' => '000000' ],
            'size'  => 10,
            'name'  => 'calibri',
	          ],
			 ];		
			 
  $black9_style= [
        'font' => [
          'bold' => false,
		   'color' => [ 'rgb' => '000000' ],
            'size'  => 9,
            'name'  => 'calibri',
	          ],
			 ];			

  $hor_center_style = [
       'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
             ],      
    ];	
	
///end styles

$timest  = date('Y-m-d H:i:s');
$xlsx_file ="xlsx/marathon_scorelijst_".$datum.".xlsx";

if (file_exists($xlsx_file)){
	unlink($xlsx_file);
}
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet(0);

$sheet     ->setCellValue('B1', 'Eindstand Marathon Hussel')
            ->setCellValue('D1', strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ))
            ->setCellValue('A5', 'Nr')
            ->setCellValue('B5', 'Naam');

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath('images/OnTip_hussel.png');
$drawing->setHeight(32);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($spreadsheet->getActiveSheet());

$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($red16_style);

// dikke lijnen
$spreadsheet->getActiveSheet()->getStyle('A4:B4')->applyFromArray($border_bottom2); 
 

// merge cells in headers
$spreadsheet->getActiveSheet()->mergeCells('B1:C1');
 
// headers bepalen adhv gespeelde wedstrijden
$k=3;  // start vanaf kolom C

 $wed     = mysqli_query($con,"SELECT Ronde From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde > 0  group BY Ronde ORDER BY Ronde" ) or die('Fout in select rondes');  
    while($row = mysqli_fetch_array( $wed)) { 
 
 $kol1  =  convert_num_to_alpha($k);
 $k++;
 $kol2  =  convert_num_to_alpha($k);
 $spreadsheet->getActiveSheet()->mergeCells($kol1.'4:'.$kol2.'4');
 
 //echo "<br>".$kol1.'4:'.$kol2.'4';
 
 $sheet     ->setCellValue($kol1.'4', 'Ronde '.$row['Ronde']);
 $spreadsheet->getActiveSheet()->getStyle($kol1.'4')->applyFromArray($hor_center_style);
 $spreadsheet->getActiveSheet()->getStyle($kol1.'4:'.$kol2.'4')->applyFromArray($borders); 

 $sheet     ->setCellValue($kol1.'5', 'Winst');
 $sheet     ->setCellValue($kol2.'5', 'Saldo');
 
 $spreadsheet->getActiveSheet()->getColumnDimension($kol1)->setWidth(9);   
 $spreadsheet->getActiveSheet()->getColumnDimension($kol2)->setWidth(9);   

 $spreadsheet->getActiveSheet()->getStyle('A5:'.$kol2.'5')->applyFromArray($borders); 
 
 $k++;
  }
 
 
 
 $kol1  =  convert_num_to_alpha($k);
 $k++;
 $kol2  =  convert_num_to_alpha($k);
 $k++;
 $kol3  =  convert_num_to_alpha($k);
 
 // totaal tellingen header
 $spreadsheet->getActiveSheet()->mergeCells($kol1.'4:'.$kol3.'4');
 $sheet     ->setCellValue($kol1.'4', 'Totaal');
 $sheet     ->setCellValue($kol1.'5', 'Gespeeld');
 $sheet     ->setCellValue($kol2.'5', 'Winst');
 $sheet     ->setCellValue($kol3.'5', 'Saldo');
 
 $spreadsheet->getActiveSheet()->getStyle($kol1.'4')->applyFromArray($hor_center_style);
 $spreadsheet->getActiveSheet()->getColumnDimension($kol1)->setWidth(10);   
 $spreadsheet->getActiveSheet()->getColumnDimension($kol2)->setWidth(10);   
 $spreadsheet->getActiveSheet()->getColumnDimension($kol3)->setWidth(10);   

 $spreadsheet->getActiveSheet()->getStyle($kol1.'4:'.$kol3.'5')->applyFromArray($borders); 
 $spreadsheet->getActiveSheet()->getStyle('A4:'.$kol3.'5')->applyFromArray($black10_bold_style);
 
 $spreadsheet->getActiveSheet()->getStyle('A5:'.$kol3.'5')->applyFromArray($border_bottom_red); 
 
 
//   detail regels
$k=3;  // start vanaf kolom C

$r=6;
$i=1;
$namen = array();

// eerst kolom C vullen met de namen
 $spelers    = mysqli_query($con,"SELECT Naam From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde > 0  group BY Naam ORDER BY Naam" ) or die('Fout in select spelers');  

  while($row = mysqli_fetch_array( $spelers)) { 

   $sheet     ->setCellValue('A'.$r, $i.'.');
   $sheet     ->setCellValue('B'.$r, $row['Naam']);
   $namen[$i] = $row['Naam'];
   $spreadsheet->getActiveSheet()->getStyle('A'.$r.':C'.$r)->applyFromArray($borders); 
   
   // blauwe regel bij even 
	 if ($r % 2 != 0    ){ 
    $spreadsheet->getActiveSheet()->getStyle('A'.$r.':C'.$r)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6EBFF');
	 } //even
   
  $i++;
  $r++;
  }
    $last_row = $r-1;
	
	
 // de scores per ronde invullen 
  $k=3;  // start vanaf kolom C
  $j=1;
  
   $wed     = mysqli_query($con,"SELECT * From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde > 0  group BY Ronde ORDER BY Ronde" ) or die('Fout in select rondes');  
    while($row1 = mysqli_fetch_array( $wed)) { 
	
	 $kol1  =  convert_num_to_alpha($k);
     $k++;
     $kol2  =  convert_num_to_alpha($k);
     $r=6;
	 
	  foreach ($namen as $naam){
		$score     = mysqli_query($con,"SELECT * From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde = ".$row1['Ronde']." and Naam = '".$naam."'  ") or die('Fout in select ronde '.$row1['Ronde'] );  
    
		      $row2 = mysqli_fetch_array( $score);
			  if ($row2['Naam'] ==  $naam){
				   $sheet     ->setCellValue($kol1.$r, $row2['Winst']);
				   $sheet     ->setCellValue($kol2.$r, $row2['Saldo']);
	
                   $spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol2.$r)->applyFromArray($black10_style);
		
				   if ($row2['Saldo'] < 0){
                  $spreadsheet->getActiveSheet()->getStyle($kol2.$r.':'.$kol2.$r)->applyFromArray($red10_style);
				   }
		
				    }
				
		$spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol2.$r)->applyFromArray($borders); 
	    $spreadsheet->getActiveSheet()->getStyle($kol2.'4:'.$kol2.$last_row)->applyFromArray($border_right); 
 
		  // blauwe regel bij even 
	     if ($r % 2 != 0    ){ 
            $spreadsheet->getActiveSheet()->getStyle('D'.$r.':'.$kol2.$r)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6EBFF');
	      } //even
	 
	 
		$r++;  
	  }// end foreach
	$k++;
	}
  
	$last_kol = $kol2;
   
	
    // totaal score	
	$r=6;
	
 	 $kol1  =  convert_num_to_alpha($k);
     $k++;
     $kol2  =  convert_num_to_alpha($k);
     $k++;
     $kol3  =  convert_num_to_alpha($k);
     	
	  foreach ($namen as $naam){
	    $tot     = mysqli_query($con,"SELECT count(*) as Aantal, sum(Saldo) as TotSaldo , sum(Winst) as TotWinst From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Naam = '".$naam."' and Ronde > 0" ) or die('Fout in select rondes');  
        $row3    = mysqli_fetch_array( $tot);
	 
	 	$sheet     ->setCellValue($kol1.$r, $row3['Aantal']);
	 	$sheet     ->setCellValue($kol2.$r, $row3['TotWinst']);
		$sheet     ->setCellValue($kol3.$r, $row3['TotSaldo']);
		$spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol3.$r)->applyFromArray($borders); 
	    $spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol3.$r)->applyFromArray($black10_bold_style);
 
        $spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol3.$r)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fcfab3');
 
	     // blauwe regel bij even 
	     if ($r % 2 != 0    ){ 
            $spreadsheet->getActiveSheet()->getStyle($kol1.$r.':'.$kol3.$r)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6EBFF');
	      } //even


	    $r++;  
	  }// end foreach

  // dikke lijnen
  $spreadsheet->getActiveSheet()->getStyle($last_kol.'4:'.$last_kol.$last_row)->applyFromArray($border_right); 
  $spreadsheet->getActiveSheet()->getStyle('A4:'.$kol3.$last_row)->applyFromArray($border_bottom_red); 
  $spreadsheet->getActiveSheet()->getStyle('C3:'.$kol3.'3')->applyFromArray($border_bottom2); 
  $spreadsheet->getActiveSheet()->getStyle($kol3.'4:'.$kol3.$last_row)->applyFromArray($border_right); 
  $spreadsheet->getActiveSheet()->getStyle('B4:B'.$last_row)->applyFromArray($border_right); 


   // tellingen per ronde
    $k=3;  // start vanaf kolom C
	$r= $last_row+1;
	$sheet     ->setCellValue('B'.$r, 'Totaal aantal');
	$spreadsheet->getActiveSheet()->getStyle('B'.$r)->applyFromArray($black10_bold_style);

	  
      $wed     = mysqli_query($con,"SELECT Ronde, count(*) as Aantal From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde > 0  group BY Ronde ORDER BY Ronde" ) or die('Fout in select rondes');  
          while($row4 = mysqli_fetch_array( $wed)) { 

             $kol1  =  convert_num_to_alpha($k);
             $k++;
             $kol2  =  convert_num_to_alpha($k);
  			 
             $spreadsheet->getActiveSheet()->mergeCells($kol1.$r.':'.$kol2.$r);
 	         $sheet     ->setCellValue($kol1.$r, $row4['Aantal']);
	         $spreadsheet->getActiveSheet()->getStyle($kol1.$r)->applyFromArray($black10_bold_style);
             $spreadsheet->getActiveSheet()->getStyle($kol1.$r)->applyFromArray($hor_center_style);
 
           $k++;
		  }
             $k++;
             $kol3  =  convert_num_to_alpha($k);
			 
 
  $sheet  ->setCellValue($kol3.$r, '(c) Erik Hendrikx '.date('Y'));
  $spreadsheet->getActiveSheet()->getStyle($kol3.$r)->applyFromArray($black9_style);

 $r--;
 
  // breedte kolommen
 
   $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);   
   $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(28); 
  

   /// renamen werkblad
    $spreadsheet->getActiveSheet()->setTitle('Score Marathon Hussel');
	
	 // set print Layout
  // Set Orientation, size and scaling
  $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
  $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4); 
 // $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
  $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

	 // freeze eerste 5 regels en eerste 2 kolommen
     $spreadsheet->getActiveSheet()->freezePane('C6');


	// opslaan bestand
    $writer = new Xlsx($spreadsheet);
	//$writer->save('php://output');	

   $writer->save($xlsx_file);
?>

<a style='font-size:11pt;text-decoration:none;color:blue;' href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = 'images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
<br>
</blockquote>
</div>