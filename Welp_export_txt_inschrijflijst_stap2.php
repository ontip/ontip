<?php
ob_start();
$toernooi = $_GET['toernooi'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"OnTip_".$toernooi.".txt\"");


// Database gegevens. 
include('mysql.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select 1');  
while($row = mysql_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};


$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die('Fout in select 2'); 
/// Bepalen aantal spelers voor dit toernooi
$aant_splrs =  mysql_result($aant_splrs_q ,0); 

// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}


// header bestand

echo "<OnTip>\r\n";
echo "Equipes = ". $aant_splrs. "\r\n";




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
echo "Spelers = ". $soort . "\r\n";


//// SQL Queries
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die('Fout in select 3');  

$i=1;

while($row = mysql_fetch_array( $spelers )) {

echo "Eq".$i. " = ";

  /// aanmaak details regels

if ($soort_inschrijving =='single' or $inschrijf_methode == 'single'){
	if (is_numeric($row['Licentie1'])) {
		  echo  $row['Licentie1']. ",";
	 } else {
	 	 echo   ",";
	}	  
	  echo  $row['Naam1']. ";";
}
  
 if ($soort_inschrijving !='single' and $inschrijf_methode != 'single'){
 	if (is_numeric($row['Licentie1'])) {
		  echo  $row['Licentie1']. ",";
	 } else {
	 	 echo   ",";
	}	  
    echo  $row['Naam1']. ";";
 }
 
if ($inschrijf_methode != 'single' and ($soort_inschrijving == 'doublet'or  $soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
    if (is_numeric($row['Licentie2'])) {
		  echo  $row['Licentie2']. ",";
	 } else {
	 	 echo   ",";
	}	  
    echo  $row['Naam2']. ";";
}

 if ($inschrijf_methode != 'single' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
    if (is_numeric($row['Licentie3'])) {
		  echo  $row['Licentie3']. ",";
	 } else {
	 	 echo   ",";
	}	  
    echo  $row['Naam3']. ";";
  }
 
  if ($inschrijf_methode != 'single' and ($soort_inschrijving  == '4x4' or  $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet')){
 
  	if (is_numeric($row['Licentie4'])) {
		  echo  $row['Licentie4']. ",";
	 } else {
	 	 echo   ",";
	}	  
     echo  $row['Naam4']. ";";
     
     if (is_numeric($row['Licentie5'])) {
		  echo  $row['Licentie5']. ",";
	 } else {
	 	 echo   ",";
	}	  
     echo  $row['Naam5']. ";";
  }

  if ($inschrijf_methode != 'single' and $soort_inschrijving  == 'sextet'){
     if (is_numeric($row['Licentie6'])) {
	   	  echo  $row['Licentie6']. ",";
	     } else {
	 	    echo   ",";
	    }	  
     echo  $row['Naam6']. ";";
   }
   

   
echo "\r\n"; 

$i++;
};





?>