<?php
$toernooi = $_GET['toernooi'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"inschr_uitgebreid_".$toernooi.".csv\"");
?>
<?php 
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
//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving" )    or die(mysql_error());  
echo "Inschrijvingen ". $toernooi_voluit . "\r\n"; 

/// Kop teksten

echo ".;";
echo "Speler 1;;;";

if ($soort_inschrijving !='single'){
echo "Speler 2;;;";
}
if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "Speler 3;;;";
}

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "Speler 4;;;";
echo "Speler 5;;;";
}

if ($soort_inschrijving == 'sextet'){
echo "Speler 6;;;";
}
echo "\r\n"; 

// Tweede kopregel


echo "Nr.;";
echo "Naam;";
echo "Licentie;";
echo "Vereniging;";

if ($soort_inschrijving !='single'){
echo "Naam;";
echo "Licentie;";
echo "Vereniging;";
}

if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "Naam;";
echo "Licentie;";
echo "Vereniging;";
}

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "Naam;";
echo "Licentie;";
echo "Vereniging;";
}

if ($soort_inschrijving == 'sextet'){
echo "Naam;";
echo "Licentie;";
echo "Vereniging;";
}

echo "\r\n"; 
// Detail regels

$i=1;

while($row = mysqli_fetch_array( $spelers )) {

echo  $i  . ";";
echo  $row['Naam1']. ";";
echo  $row['Licentie1']. ";";
echo  $row['Vereniging1']. ";";
  
 if ($soort_inschrijving !='single'){
	 
   echo  $row['Naam2']. ";";
   echo  $row['Licentie2']. ";";
   echo  $row['Vereniging2']. ";";
}

 if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo  $row['Naam3']. ";";
   echo  $row['Licentie3']. ";";
   echo  $row['Vereniging3']. ";";
  }
  
  if ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo  $row['Naam4']. ";";
   echo  $row['Licentie4']. ";";
   echo  $row['Vereniging4']. ";";
   echo  $row['Naam5']. ";";
   echo  $row['Licentie5']. ";";
   echo  $row['Vereniging5']. ";";
  }
  
 if ($soort_inschrijving  == 'sextet'){
   echo  $row['Naam6']. ";";
   echo  $row['Licentie6']. ";";
   echo  $row['Vereniging6']. ";";   
   
   }
echo "\r\n"; 

$i++;
};
?>