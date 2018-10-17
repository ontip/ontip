<?php
$toernooi = $_GET['toernooi'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"inschr_naam_ver_".$toernooi."_ver.csv\"");?>
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

// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];


$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 
/// Bepalen aantal spelers voor dit toernooi
$aant_splrs =  mysql_result($aant_splrs_q ,0); 
//// SQL Queries
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving" )    or die(mysql_error());  
echo "Inschrijvingen ". $toernooi_voluit . "\r\n"; 

$i=1;

while($row = mysql_fetch_array( $spelers )) {

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
	echo  $i  . ";";
   echo  $row['Naam1']. "; ";
   echo  $row['Vereniging1']; 
   
   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	 
	 echo  $i  . ";";
   echo  $row['Naam1'].";  ". $row['Vereniging1']." ; ";
   echo  $row['Naam2']."; ". $row['Vereniging2'];
    	
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   echo  " ; ". $row['Naam3']."; ". $row['Vereniging3'];
  }
  
  if (($soort_inschrijving  == '4x4' OR  $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   echo  " ; " . $row['Naam4']."; ". $row['Vereniging4'];
   echo  " ; ". $row['Naam5']."; ".  $row['Vereniging5'];

  }
  
  if ($soort_inschrijving  == 'sextet'){
   echo " ; " . $row['Naam6']."; ". $row['Vereniging6'];
   }
   
   
  if ($extra_vraag != ''){
  	 echo " ; " . $row['Extra'];
   }
   
   
   
   
echo "\r\n"; 



$i++;
};
?>