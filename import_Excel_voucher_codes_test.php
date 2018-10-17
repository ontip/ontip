<?php
		/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
//date_default_timezone_set('Amsterdam');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

/**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row == 1 || ($row >= 1 && $row <= 55)) {
            return true;
        }

        return false;
    }
}

////////////////////////////////////////////////////////////////////////////////////////

$inputFileName = $xlsx_file;

$cacheMethod   = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
$cacheSettings = array( 'memoryCacheSize' => '128MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
ini_set('max_execution_time', 123456);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Gegevens uit Excel
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$objReader   = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($inputFileName);


echo "<h1>TEST MODE</h1>";

echo "<h4>Tussen  [ ] staat het Cell coordinaat.</h4>";
echo "<table border =1 cellpadding =0 cellspacing =0  >";


for ($i=1;$i < 200;$i++){
   	$cell="A".$i;
   	$content = $objPHPExcel->setActiveSheetIndex(0)->getCell($cell)->getCalculatedValue();

     if ($content ==''){
        	$i =999;
      }

   echo  "<tr>";
    echo  "<td style='font-family:courier new;'><span style='font-size:9pt;color:blue;'>[".$cell."]</span>  ".$content."</td>";
   	$cell="B".$i;
   	$content = $objPHPExcel->setActiveSheetIndex(0)->getCell($cell)->getCalculatedValue();
    echo  "<td style='font-family:courier new;'><span style='font-size:9pt;color:blue;'>[".$cell."]</span>  ".$content."</td>";
  	$cell="C".$i;
   	$content = $objPHPExcel->setActiveSheetIndex(0)->getCell($cell)->getCalculatedValue();
    echo  "<td style='font-family:courier new;'><span style='font-size:9pt;color:blue;'>[".$cell."]</span>  ".$content."</td></tr>";

}
echo "</table>";






