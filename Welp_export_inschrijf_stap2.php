<?php
$toernooi = $_GET['toernooi'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"SPL_".$toernooi.".txt\"");


//$filename  = "Spl_".$toernooi.".txt";
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
// Schonen hulp bestand welp

mysqli_query($con,"Delete from hulp_welp") or die('Fout in schonen tabel');   

	// Vul hulptabel (6x )
	
if ($soort_inschrijving =='single'){
	
$query1 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam1, Licentie1 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query1) or die (mysql_error()); 
}

if ($soort_inschrijving !='single'){
	
$query2 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam1, Licentie1 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query2) or die ('Fout in insert') ; 

$query3 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam2, Licentie2 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query3) or die (mysql_error()); 
}
	
if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){	
	
	$query4 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam3, Licentie3 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query4) or die (mysql_error()); 
	
}	
	
if ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet'){
	
		$query5 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam4, Licentie4 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query5) or die (mysql_error()); 


$query6 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam5, Licentie5 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query6) or die (mysql_error()); 
	
}

if ($soort_inschrijving == 'sextet'){
	
$query7 = "insert into hulp_welp (Toernooi, Vereniging, Naam, Licentie) 
( select Toernooi, Vereniging, Naam6, Licentie6 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query7) or die (mysql_error()); 
	
}



$welp_spelers      = mysqli_query($con,"SELECT * from hulp_welp Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Naam" )    or die(mysql_error());  

echo "<OnTip>\r\n";
	
while($row = mysqli_fetch_array( $welp_spelers )) {	
	
 echo  $row['Naam']. ";";
 if (is_numeric($row['Licentie']) and  $row['Licentie'] <> '0' ) {
		  echo  $row['Licentie'];
}
 echo "\r\n";
	
	
}// end while

?>
