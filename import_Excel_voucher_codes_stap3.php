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

// Skip kopregels
$first_data_line = $aantal_kopregels+1;
$max_lines       = $aantal_kopregels+100;$j=1;

if ($check =='J'  ){
 // verwijder bestaande codes voor dit toernooi
 //mysql_query("DELETE FROM `voucher_codes` where Toernooi ='".$toernooi."' and Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'");
}


 for ($i=$first_data_line;$i < $max_lines;$i++){
       	$cell=$kolom_code.$i;
       	$voucher_code = $objPHPExcel->setActiveSheetIndex(0)->getCell($cell)->getCalculatedValue();
       
       
       if ($voucher_code ==''){
       	$i=999;
       } else {
       echo "<br>".$j.". [".$cell."] .".$voucher_code;
       
                // insert in table     
               $sqlcmd = "INSERT INTO `voucher_codes` (`Id`, `Vereniging_id`, `Vereniging`, `Toernooi`, `Datum`, `Voucher_code`, `Laatst`) 
                      VALUES (0, ".$vereniging_id.", '".$vereniging."', '".$toernooi."', '".$datum."', '".$voucher_code."', now() );"; 
              
         //      mysql_query($sqlcmd) or die ('fout in insert'); 
               
               
               
       }
       
  $j++;
  }

