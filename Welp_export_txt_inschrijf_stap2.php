<?php
//// Welp_export_txt_inschrijf_stap2.php
//// Maakt een txt bestand met de inschrijvingen voor een toernooi tbv Welp
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 8mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

# 9okt2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    Aantal spelers niet goed opgehaald ivm verkeerd commando
# Fix:              None
# Feature:          None
# Reference: 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//ob_start();
$toernooi = $_GET['toernooi'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"OnTip_".$toernooi.".txt\"");
 
// Database gegevens. 
include('mysqli.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};
$aant_splrs_q = mysqli_query($con,"SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 
/// Bepalen aantal spelers voor dit toernooi
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

// 

echo "<OnTip>\r\n";
echo "Equipes = ". $aant_splrs. "\r\n";

switch($soort_inschrijving){
 	   case 'single'  : $soort = 1; break;
 	   case 'doublet' : $soort = 2; break;
 	   case 'triplet' : $soort = 3; break; 
 	   case 'kwintet' : $soort = 3; break;   /// Welp kent geen kwintet
 	   case 'sextet'  : $soort = 3; break;   /// Welp kent geen sextet
 	  }// end switch


if ($inschrijf_methode == 'single'){
	$soort = 1;
}
  echo "Spelers = ". $soort . "\r\n";


//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die(mysql_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {

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
  
  if ($inschrijf_methode != 'single' and ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet')){
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
od_end_clean();
?>