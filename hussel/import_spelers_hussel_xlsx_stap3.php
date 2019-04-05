<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../../../ontip/Classes/PHPExcel.php';

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

// check kop regels  (row 1-2) 

	$error   = 0;
  $message ='';
  


// Skip kopregels
$aantal_kopregels = 2;
$first_data_line = $aantal_kopregels+1;
$volgnummer      = 1;
$max_lines       = $aantal_kopregels+200;


	
if ($error !=0){	
	
	echo $message;
} else {	

$j=0;
	
	// vanaf regel 3. 
 for ($i=3;$i < $max_lines;$i++){

$message ='';
	
       	$volgnr      = $objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$i)->getCalculatedValue();
       	$naam       = $objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$i)->getCalculatedValue();


       if ($naam !=''){
        $query="INSERT INTO hussel_score (Id, Vereniging, Vereniging_id,Datum, Naam) VALUES (0,'".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' )";   
         mysqli_query($con,$query) or die(' Fout in insert speler');  
        $j++;
     } 	
   else {
   	$i =9999;        
     } // end if gevuld volgnr     
  
          
  } // end for
 
 
}// end if

 


/////////////////////////////////////////////////////////////////////////////////////////////////////
//  

if ($error ==0 ) { 

?>
	
  <script language="javascript">
        alert("Er zijn <?php echo $j;?> regels geimporteerd ")
    </script>
   <form action="import_spelers_hussel_xlsx_stap1.php" method="POST" enctype="multipart/form-data">
  <input type='submit'  value ='Klik om door te gaan' name= 'input'>  
</form>
  <!--script type="text/javascript">
		window.location.replace('import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>');
	</script-->
<?php
}// end if error 




if ($error !=0  ) { 	
	?>
	 <script language="javascript">
        alert("Er zijn geen spelers gevonden om te importeren")
    </script>
   <form action="import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>" method="POST" enctype="multipart/form-data"> 
  <input type='submit'  value ='Klik om door te gaan' name= 'input'>  
</form>
  <script type="text/javascript">
		window.location.replace('import_spelers_xlsx_stap1.php');
	</script>
<?php	
}

	



ob_end_flush();



