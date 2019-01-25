<?php 
# lijst_migratie_php7_xlsx.php
# Status bestanden gemigreerd naar php7
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 16jan2019            -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              changed
# Feature:          None
# Reference: 

?>
<html>
	<head>
		<title>OnTip migratie naar PHP </title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<div style='padding:18pt;font-size:20pt;color:orange;'>Status</div>
<hr color='red' width=100% align='left'> 

<h1>Excel lijst bestanden</h1>


<?php


// Database gegevens. 
include('mysql.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



$timest  = date('Ymd');
$xlsx_file ="php7/xlsx/migratie_".$timest.".xlsx";

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
  $objPHPExcel->getProperties()->setCreator("Boulamis")
							 ->setLastModifiedBy("Erik Hendrikx")
							 ->setTitle("PHPExcel Migratie Document")
							 ->setSubject("Van PHP 5.6 naar 7")
							 ->setDescription("Status lijst")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("PHP");

 
// Add header line
  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:B1');
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Status migratie naar PHP7')
            ->setCellValue('D1', 'Datum tijd: ')
            ->setCellValue('E1', date('d-m-Y H:i:s'));

  // Add header line 2

	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', 'Nr')
            ->setCellValue('B3', 'Naam bestand')
            ->setCellValue('C3', 'Timestamp')
            ->setCellValue('D3', 'PHP7 bestand')
            ->setCellValue('E3', 'Timestamp')
   ;
  
  $border_bottom = array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
              
    // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(45);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);   

   
   // headers bold
   $objPHPExcel->getActiveSheet()->getStyle('A1:E3')->getFont()->setBold(true);

  $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($border_bottom);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// bestanden

// Start vanaf row 4
$i=1;
$j=4;

         
    $dir ='../boulamis/';
    
    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('C1', $dir)           ;



// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}

  	
	
		
foreach ($files as $file) {
   $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
   // echo "<br>".$file;
    
             
         if (strlen($file) > 3    and (strtoupper($ext) == 'PHP'  )) {
    
    		  $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A'.$j, $i)
           ->setCellValue('B'.$j, $file)
           ->setCellValue('C'.$j, date ("d M Y H:i:s.", filemtime($file))  ) ;
    
          $doel_file = 'php7/'.$file;
          $bron_mtime= date ("d M Y H:i:s.", filemtime($file)) ;
          
          
          if (file_exists($doel_file)){
        		  $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('D'.$j, $doel_file)
               ->setCellValue('E'.$j, date ("d M Y H:i:s.", filemtime($doel_file))  ) ;
               $doel_mtime= date ("d M Y H:i:s.", filemtime($doel_file)) ;
            
            if ($doel_mtime  == $bron_mtime) {
             	$style= array('font'  => 
                   array('bold'  => true,
                         'color' => array('rgb' => '009933'),
                         'size'  => 10,
                         'name'  => 'Verdana'
                 )) ;
             $objPHPExcel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($style);     	   
            }     
          } 
          else {
          	$url= 'https://www.ontip.nl/boulamis/upgrade_php_to_7.php?bron='.$file;
          	$id=  'klik hier';
          	
          	$objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$j, $id, PHPExcel_Cell_DataType::TYPE_STRING2, TRUE)->getHyperlink()->setUrl(strip_tags($url));
         
             $style= array('font'  => 
             array('bold'  => false,
                   'color' => array('rgb' => '0033cc'),
                   'size'  => 10,
                   'name'  => 'Verdana'
                  )) ;
            $objPHPExcel->getActiveSheet()->getStyle('D'.$j)->applyFromArray($style);     	
        
             
             
         
   	
        }// if file exist
           
          $i++;  
          $j++;
  
         }// end if strln
  
  }// end each

   


  // Rename worksheet
  echo date('H:i:s') , " Migratie status" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Artikelen');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
  echo date('H:i:s') , " Write to Excel2007 format" , EOL;
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
 // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save($xlsx_file);

 

 
?>
<a href = '<?php echo $xlsx_file;?>' target = '_blank'>Klik hier voor bestand</a> 
</body>
</html>
