<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
//// Toevoegen aan hulpnaam ivm kontrole dubbel inschrijven
switch($soort_inschrijving){
 	   case 'single'  : $soort = 1; break;
 	   case 'doublet' : $soort = 2; break;
 	   case 'triplet' : $soort = 3; break; 
 	   case 'kwintet' : $soort = 5; break;
 	   case 'sextet'  : $soort = 6; break;
 	  }// end switch

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

////////////////////////////////////////////////////////////////////////////////////////

$inputFileName = 'csv/import_'.$toernooi."_".$timest.'.xlsx';

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

// check kop regels  (row 7) 

	$error   = 0;
  $message ='';
  
echo "<h3>Toernooi gegevens</h3><br>";

echo "<table border =0 >";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Naam toernooi         : </td><td>". $toernooi."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Naam toernooi voluit  : </td><td>". $toernooi_voluit."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Datum toernooi        : </td><td>". $datum."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Soort toernooi        : </td><td>". $soort_inschrijving."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Inschrijf_methode     : </td><td>". $inschrijf_methode."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Licentie verplicht    : </td><td>". $licentie_jn."</td></tr>";
echo "</tr></table><br>";



// Skip kopregels
$aantal_kopregels = 7;
$first_data_line = $aantal_kopregels+1;
$volgnummer      = 1;
$max_lines       = $aantal_kopregels+100;

/*
 if (!isset($_GET['insert'])){
    
     include('import_inschrijvingen_check.php');
}
*/    
	
if ($error !=0){	
	
	echo $message;
} else {	

$j=0;
	
	// vanaf regel 8. 
 for ($i=8;$i < $max_lines;$i++){

$message ='';
	
       	$volgnr      = $objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$i)->getCalculatedValue();
       	$naam1       = $objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$i)->getCalculatedValue();
       	$licentie1   = $objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$i)->getCalculatedValue();
       	$vereniging1 = $objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$i)->getCalculatedValue();
    	
       	$naam2       = $objPHPExcel->setActiveSheetIndex(0)->getCell('E'.$i)->getCalculatedValue();
       	$licentie2   = $objPHPExcel->setActiveSheetIndex(0)->getCell('F'.$i)->getCalculatedValue();
       	$vereniging2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('G'.$i)->getCalculatedValue();
       	
       	$naam3       = $objPHPExcel->setActiveSheetIndex(0)->getCell('H'.$i)->getCalculatedValue();
       	$licentie3   = $objPHPExcel->setActiveSheetIndex(0)->getCell('I'.$i)->getCalculatedValue();
       	$vereniging3 = $objPHPExcel->setActiveSheetIndex(0)->getCell('J'.$i)->getCalculatedValue();
       	
       	$naam4       = $objPHPExcel->setActiveSheetIndex(0)->getCell('K'.$i)->getCalculatedValue();
       	$licentie4   = $objPHPExcel->setActiveSheetIndex(0)->getCell('L'.$i)->getCalculatedValue();
       	$vereniging4 = $objPHPExcel->setActiveSheetIndex(0)->getCell('M'.$i)->getCalculatedValue();
       	
       	$naam5       = $objPHPExcel->setActiveSheetIndex(0)->getCell('N'.$i)->getCalculatedValue();
       	$licentie5   = $objPHPExcel->setActiveSheetIndex(0)->getCell('O'.$i)->getCalculatedValue();
       	$vereniging5 = $objPHPExcel->setActiveSheetIndex(0)->getCell('P'.$i)->getCalculatedValue();
       	
       	$naam6       = $objPHPExcel->setActiveSheetIndex(0)->getCell('Q'.$i)->getCalculatedValue();
       	$licentie6   = $objPHPExcel->setActiveSheetIndex(0)->getCell('R'.$i)->getCalculatedValue();
       	$vereniging6 = $objPHPExcel->setActiveSheetIndex(0)->getCell('S'.$i)->getCalculatedValue();
  
        $email       = $objPHPExcel->setActiveSheetIndex(0)->getCell('T'.$i)->getCalculatedValue();
        $telefoon    = $objPHPExcel->setActiveSheetIndex(0)->getCell('U'.$i)->getCalculatedValue();  	
 
        $status      =   'IM0';       // Via import
         
         if ($volgnr !='Nr' and $naam1 !='' ){
           	
         $j++;  	
         $query = "INSERT INTO inschrijf(Id, Toernooi, Vereniging,Vereniging_id, Datum, Volgnummer,
                                         Naam1, Licentie1, Vereniging1, 
                                         Naam2, Licentie2, Vereniging2, 
                                         Naam3, Licentie3, Vereniging3, 
                                         Naam4, Licentie4, Vereniging4, 
                                         Naam5, Licentie5, Vereniging5, 
                                         Naam6, Licentie6, Vereniging6, 
                                         Email, Telefoon,Status, Inschrijving)
                        VALUES (0,'".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."',".$volgnr.", 
                                  '".$naam1."'     ,'".$licentie1."'   , '".$vereniging1."' ,
                                  '".$naam2."'     ,'".$licentie2."'   , '".$vereniging2."' ,
                                  '".$naam3."'     ,'".$licentie3."'   , '".$vereniging3."' ,
                                  '".$naam4."'     ,'".$licentie4."'   , '".$vereniging4."' ,
                                  '".$naam5."'     ,'".$licentie5."'   , '".$vereniging5."' ,
                                  '".$naam6."'     ,'".$licentie6."'   , '".$vereniging6."' , 
                                  '".$email."'     ,'".$telefoon."'    , '".$status."'      , now()  )";
     // echo $query;
        mysqli_query($con,$query) or die ('Fout in insert inschrijving ');       	
       	
            // voor het voorkomen van dubbele inschrijvingen
          
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam1."','".$vereniging1."',NOW() )";
    //      echo $insert;
        mysqli_query($con,$insert) ; 
          
          if ($naam2 !=''){
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam2."','".$vereniging2."',NOW() )";
    //      echo $insert;
        mysqli_query($con,$insert) ; 
          }
          
          if ($naam3 !=''){
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam3."','".$vereniging3."',NOW() )";
          mysqli_query($con,$insert) ; 
          }
          
          if ($naam4 !=''){
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam4."','".$vereniging4."',NOW() )";
          mysqli_query($con,$insert) ; 
          }
          
          if ($naam5 !=''){
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam5."','".$vereniging5."',NOW() )";
          mysqli_query($con,$insert) ; 
          }
          
          if ($naam6 !=''){
          $insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Vereniging_speler,Laatst) 
                      VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$naam6."','".$vereniging6."',NOW() )";
          mysqli_query($con,$insert) ; 
          }    
     } 	
   else {
   	$i =9999;        
     } // end if gevuld volgnr     
  
          
  } // end for
 
 
}// end if
 echo "<br>";
 echo "<br>Sorteer de inschrijvingen in Muteer inschrijvingen.";
echo "<br>";
 


/////////////////////////////////////////////////////////////////////////////////////////////////////
//  

if ($error ==0 ) { 

?>
	
  <script language="javascript">
        alert("Er zijn <?php echo $j;?> inschrijvingen geimporteerd ")
    </script>
   <form action="import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>" method="POST" enctype="multipart/form-data">
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
        alert("Er zijn geen goedgekeurde inschrijvingen gevonden om te importeren")
    </script>
   <form action="import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>" method="POST" enctype="multipart/form-data"> 
  <input type='submit'  value ='Klik om door te gaan' name= 'input'>  
</form>
  <script type="text/javascript">
		window.location.replace('import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>');
	</script>
<?php	
}

	



ob_end_flush();



