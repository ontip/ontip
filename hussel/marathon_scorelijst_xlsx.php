<?php
# scorelijst_xlsx.php
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
$datum   = $_GET['datum'];
$jaar    =  substr($datum, 0,4);
$maand   =  substr($datum, 5,2);
$dag     =  substr($datum, 8,2);

// Database gegevens. 
include('mysqli.php');
setlocale(LC_ALL, 'nl_NL');

$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'marathon_ronde'  ") ;  
$result              = mysqli_fetch_array( $qry);
$marathon_ronde      = $result['Waarde'];

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
// styles

 $borders_outline_red = [
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => 'FFFF0000'],
        ],
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

 $border_right = [
    'borders' => [
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
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

			 
  $black9_style= [
        'font' => [
          'bold' => false,
		   'color' => [ 'rgb' => '000000' ],
            'size'  => 9,
            'name'  => 'calibri',
	          ],
			 ];			
			 	
///end styles

$timest  = date('Y-m-d H:i:s');
$xlsx_file ="xlsx/scorelijst_".$datum.".xlsx";

if (file_exists($xlsx_file)){
	unlink($xlsx_file);
}
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet(0);

$sheet     ->setCellValue('B1', 'Eindstand Marathon Hussel')
            ->setCellValue('D1', strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ))
            ->setCellValue('B4', 'Nr')
            ->setCellValue('C4', 'Naam');

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath('images/OnTip_hussel.png');
$drawing->setHeight(32);
$drawing->setCoordinates('A1');
$drawing->setWorksheet($spreadsheet->getActiveSheet());

$spreadsheet->getActiveSheet()->getStyle('B1')->applyFromArray($red16_style);
// merge cells in headers
  $spreadsheet->getActiveSheet()->mergeCells('B1:C1');
  
//   detail regels
$r=5;
$i=1;

$score     = mysqli_query($con,"SELECT * From hussel_score WHERE Datum = '".$datum."'  and Vereniging_id = ".$vereniging_id." and Ronde = ".$marathon_ronde." ORDER BY Winst DESC , Saldo DESC" )       or die('Fout in select');  
while($row = mysqli_fetch_array( $score )) {
	
		
	$sheet  ->setCellValue('B'.$r, $i)
            ->setCellValue('C'.$r, $row['Naam'])
            ->setCellValue('D'.$r, $row['Winst'])
            ->setCellValue('E'.$r, $row['Saldo']);	
  $i++;
  $r++;
}// end while
 
  $sheet  ->setCellValue('D'.$r, '(c) Erik Hendrikx '.date('Y'));
  $spreadsheet->getActiveSheet()->getStyle('D'.$r)->applyFromArray($black9_style);

 $r--;
 
  // breedte kolommen
 
   $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);   
   $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8); 
   $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(38);   
   $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(12);   
   $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);  
   
 // borders 
  $spreadsheet->getActiveSheet()->getStyle('B4:E'.$r)->applyFromArray($borders);
  $spreadsheet->getActiveSheet()->getStyle('B4:E'.$r)->applyFromArray($black12_style);

  // laatste regel botom
  //  $objPHPExcel->getActiveSheet()->getStyle('B'.$j.':L'.$j)->applyFromArray($border_bottom2);
 
   /// renamen werkblad
    $spreadsheet->getActiveSheet()->setTitle('Score Hussel');
	 // set print Layout
  // Set Orientation, size and scaling
  $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
  $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4); 
  $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
  $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
  $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);


	// opslaan bestand
    $writer = new Xlsx($spreadsheet);
	//$writer->save('php://output');	

   $writer->save($xlsx_file);
?>

<a style='font-size:11pt;text-decoration:none;color:blue;' href = '<?php echo $xlsx_file;?>' target = '_blank'><img src = 'images/icon_excel.png'  width=50><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $xlsx_file;?>'</a> 
<br>
</blockquote>
</div>