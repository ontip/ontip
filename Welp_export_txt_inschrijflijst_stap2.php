<?php
# 9okt2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    Aantal spelers niet goed opgehaald ivm verkeerd commando
# Fix:              None
# Feature:          None
# Reference: 

ob_start();
$toernooi = $_GET['toernooi'];
$timest = date('Ymdhis');
    $log = 'OnTip_'.$toernooi.'.txt';
 //  echo $log;
	
	
    if (file_exists($log)){
    	unlink($log);
    }
  
    $myfile = fopen($log, "w") or die("Unable to open file!");
    $now = date('Y-m-d h:i:s');
 
  



// Database gegevens. 
include('mysqli.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select 1');  
while($row = mysqli_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};

$aant_splrs_q = mysqli_query($con,"SELECT Count(*) as Aantal  from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die('Fout in select 2'); 
//$aant_splrs =  mysql_result($aant_splrs_q ,0); 
$result      = mysqli_fetch_array( $aant_splrs_q );
$aant_splrs  = $result['Aantal'];

// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}


// header bestand

//echo "<OnTip>\n";
//echo "Equipes = ". $aant_splrs. "\n";


  fwrite($myfile, "<OnTip>"); 
  fwrite($myfile, "\nEquipes = ".$aant_splrs);    
  

switch($soort_inschrijving){
 	   case 'single'  : $soort = 1; break;
 	   case 'doublet' : $soort = 2; break;
 	   case 'triplet' : $soort = 3; break; 
 	   case '4x4'     : $soort = 3; break;   /// Welp kent geen 4x4
 	   case 'kwintet' : $soort = 3; break;   /// Welp kent geen kwintet
 	   case 'sextet'  : $soort = 3; break;   /// Welp kent geen sextet
 	  }// end switch


if ($inschrijf_methode == 'single'){
	$soort = 1;
}

/// soort toernooi
//echo "Spelers = ". $soort . "\n";
fwrite($myfile, "\nSpelers = ".$soort);   

//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die('Fout in select 3');  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {

//echo "Eq".$i. " = ";
fwrite($myfile, "\nEq".$i. " = " );   


  /// aanmaak details regels

if ($soort_inschrijving =='single' or $inschrijf_methode == 'single'){
	if (is_numeric($row['Licentie1'])) {
		
		fwrite($myfile, $row['Licentie1']. "," ); 
//		  echo  $row['Licentie1']. ",";
	 } else {
	 		fwrite($myfile, ","); 
	// 	 echo   ",";
	}	  
	//  echo  $row['Naam1']. ";";
	  	fwrite($myfile, $row['Naam1']. ";"); 
}
  
 if ($soort_inschrijving !='single' and $inschrijf_methode != 'single'){
 	if (is_numeric($row['Licentie1'])) {
 			fwrite($myfile, $row['Licentie1']. "," ); 
	//	  echo  $row['Licentie1']. ",";
	 } else {
	// 	 echo   ",";
	   	fwrite($myfile,  ", "); 
	}	  
  //  echo  $row['Naam1']. ";";
     	fwrite($myfile, $row['Naam1']. ";"); 
 }
 
if ($inschrijf_methode != 'single' and ($soort_inschrijving == 'doublet'or  $soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
    if (is_numeric($row['Licentie2'])) {
		//  echo  $row['Licentie2']. ",";
		  	fwrite($myfile, $row['Licentie2']. "," ); 
	 } else {
	// 	 echo   ",";
	 	     	fwrite($myfile,  ","); 
	}	  
  //  echo  $row['Naam2']. ";";
       	fwrite($myfile, $row['Naam2']. ";"); 
}

 if ($inschrijf_methode != 'single' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
    if (is_numeric($row['Licentie3'])) {
		//  echo  $row['Licentie3']. ",";
		  	fwrite($myfile, $row['Licentie3']. "," ); 
	 } else {
	// 	 echo   ",";
	   	fwrite($myfile,  ","); 
	}	  
   // echo  $row['Naam3']. ";";
       	fwrite($myfile, $row['Naam3']. ";"); 
  }
 
  if ($inschrijf_methode != 'single' and ($soort_inschrijving  == '4x4' or  $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet')){
 
  	if (is_numeric($row['Licentie4'])) {
		 // echo  $row['Licentie4']. ",";
		  	fwrite($myfile, $row['Licentie4']. "," ); 
	 } else {
	// 	 echo   ",";
	 	  	fwrite($myfile,  ","); 
	}	  
  //   echo  $row['Naam4']. ";";
      	fwrite($myfile, $row['Naam4']. ";"); 
     
     if (is_numeric($row['Licentie5'])) {
	//	  echo  $row['Licentie5']. ",";
		  	fwrite($myfile, $row['Licentie5']. "," ); 
	 } else {
	 	// echo   ",";
	 	     	fwrite($myfile,  ","); 
	}	  
  //   echo  $row['Naam5']. ";";
        	fwrite($myfile, $row['Naam5']. ";"); 
  }

  if ($inschrijf_methode != 'single' and $soort_inschrijving  == 'sextet'){
     if (is_numeric($row['Licentie6'])) {
	  // 	  echo  $row['Licentie6']. ",";
	   	  	fwrite($myfile, $row['Licentie2']. "," ); 
	     } else {
	 	//    echo   ",";
	 	    	fwrite($myfile,  ","); 
	    }	  
 //    echo  $row['Naam6']. ";";
     	fwrite($myfile, $row['Naam6']. ";"); 
   }
   	  

 
//echo "\n"; 

$i++;
};

 fclose($myfile);
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"OnTip_".$toernooi.".txt\"");
  
   

$myfile = fopen("OnTip_".$toernooi.".txt", "r") or die("Unable to open file!");
// Output one line until end-of-file
		
while(!feof($myfile)) {
$line = fgets($myfile);
			echo $line."\r\n";
}
 fclose($myfile);



?>

 
