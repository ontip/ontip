<?php
$toernooi = $_GET['toernooi'];
header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=\"inschr_summier_".$toernooi.".doc\"");
header("Pragma: no-cache");
header("Expires: 0");
?>


<?php 
// Database gegevens. 
include('mysql.php');
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
};

// fs is font size (2x pixel grootte )
echo "\fs28"."Inschrijvingen ". $toernooi_voluit . "\rn"; 



$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 
/// Bepalen aantal spelers voor dit toernooi
$aant_splrs =  mysql_result($aant_splrs_q ,0); 
//// SQL Queries
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die(mysql_error());  


$i=1;

while($row = mysql_fetch_array( $spelers )) {

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
	echo  $i  . ";";
   echo  $row['Naam1']. " ";
   
   
   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	 
	 echo  $i  . ";";
   echo  $row['Naam1']. " - ";
   echo  $row['Naam2'];
    	
}

 if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' and $inschrijf_methode =='vast'){
   echo  " - ". $row['Naam3'];
  }
  
  if ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet' and $inschrijf_methode =='vast'){
   echo  " - " . $row['Naam4'];
   echo  " - ". $row['Naam5'];

  }
  
  if ($soort_inschrijving  == 'sextet'){
   echo " - " . $row['Naam6'];
   }
echo "\r\n"; 

$i++;
};
?>