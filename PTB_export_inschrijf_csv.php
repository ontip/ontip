<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  PTB_export_inschrijf_csv.php
// Maakt csv bestand aan tbv Werkman Petanque Toernooi Beheer
// De naam van de vereniging wordt adhv de licentie opgehaald uit speler licenties

// 4 apr 2018 Erik
// Probleem : Geen vereniging getoond bij Regio
// OpPlossing : 
///////////////////////////////////////////////////////////////////////////////////////////////
$toernooi = $_GET['toernooi'];

header("Content-type: application/octet-stream;charset=UTF-8");
header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header("Content-Disposition: attachment; filename=\"PTB_import_".$toernooi.".csv\"");
// onderstaande alleen om in Excel diakrieten goed weer te geven nu dus uitschaken
//echo "\xEF\xBB\xBF"; // UTF-8 BOM

# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 4apr2018          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 Geen vereniging getoond bij Regio.
# Fix:               Bond ophalen uit vereniging tabel.
# Feature:           None.
# Reference: 

# 7jun2019          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 Maar 1 speler opgehaald
# Fix:               Ivm PHP7 moet ook include mysqli in functie worden opgenomen
# Feature:           None.
# Reference: 


/// Database gegevens. 
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

// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

// Regio

$qry        = mysqli_query($con,"SELECT * From vereniging  where Vereniging = '".$vereniging ."'   ") ;  
$result     = mysqli_fetch_array( $qry);
$bond       = $result['Bond'];

// Bepalen aantal spelers voor dit toernooi
$aant_splrs_q = mysqli_query($con,"SELECT Count(*) as Aantal from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 
$result       = mysqli_fetch_array( $aant_splrs_q);
$aant_splrs   =  $result['Aantal'];


//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving" )    or die(mysql_error());  
//echo "Inschrijvingen ". $toernooi_voluit . "\r\n"; 


function get_vereniging($licentie, $_vereniging)
{
	include('mysqli.php');
	// tweede parameter in het geval er geen licentie is opgegeven
								
	if ($licentie !=''){								
            $sql    = mysqli_query($con,"SELECT * from speler_licenties as s join njbb_verenigingen as n
                                    on s.Vereniging_nr = n.Vereniging_nr  Where Licentie  = '".$licentie."'  limit 1" )    or die('Fout in ophalen licentie');  
            $result          = mysqli_fetch_array( $sql );
            $vereniging_naam = $result['Vereniging_naam'];
     }
     else {
	$vereniging_naam = $_vereniging;
    }

  return $vereniging_naam ;
}// end fun


$i=1;

while($row = mysqli_fetch_array( $spelers )) {

if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
   echo  $row['Naam1']. "; ";
   echo  $row['Licentie1']. "; ";

  if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie1'],$row['Vereniging1']); 
   } else {
   	echo $row['Vereniging1'];
  }
 }// end soort
 
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
   echo  $row['Naam1']. "; ";
   echo  $row['Licentie1']. "; ";
 
  if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie1'],$row['Vereniging1']). "; "; 
   } else {
   	echo $row['Vereniging1']. "; ";
  }

   echo  $row['Naam2']. "; ";
   echo  $row['Licentie2']. "; ";
 
  if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie2'],$row['Vereniging2']); 
   } else {
   	echo $row['Vereniging2'];
  }
	 
}


 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or  $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   echo  "; ".$row['Naam3']. "; ";
   echo  $row['Licentie3']. "; ";
   
    if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie3'],$row['Vereniging3']); 
   } else {
   	echo $row['Vereniging3'];
  }
   
  
  }

 if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   echo  "; ".$row['Naam4']. "; ";
   echo  $row['Licentie4']. "; ";
   
    if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie4'],$row['Vereniging4']); 
   } else {
   	echo $row['Vereniging4'];
  }
  

  }

  
  if (($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   echo  ";".$row['Naam5']. "; ";
   echo  $row['Licentie5']. "; ";
   
   if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie5'],$row['Vereniging5']); 
   } else {
   	echo $row['Vereniging5'];
  }
 

  }
  
  if ($soort_inschrijving  == 'sextet'){
   echo  ";".$row['Naam6']. "; ";
   echo  $row['Licentie6']. "; ";
   
   if ($bond =='NJBB'){
      echo  get_vereniging($row['Licentie6'],$row['Vereniging6']); 
   } else {
   	echo $row['Vereniging6'];
  }
  
 
   }
echo "\r\n"; 

$i++;
};
?>

