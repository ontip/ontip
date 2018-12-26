<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysql.php');
$naam            = $_POST['nieuwe_speler'];
$vereniging      = $_POST['vereniging'];
$vereniging_id   = $_POST['vereniging_id'];

$datum        =  $_POST['datum'];

/// Voeg toe aan hussel als de speler nog niet is toegevoegd

$sql      = mysql_query("SELECT count(*) as Aantal  from hussel_score where Vereniging_id = ".$vereniging_id." and  Naam = '".$naam."'   and Datum = '".$datum."' ") or die(' Fout in select hussel score');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count == 0 and $naam <> '') {

/// Voeg toe aan hussel score
$query = "INSERT INTO hussel_score (Vereniging, Vereniging_id,Datum,  Naam, Winst, Saldo)
               VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' , 0,0)";
mysql_query($query) or die(' Fout in insert score');  

};


/// Toevoegen aan spelers als deze er nog niet in staat
$sql      = mysql_query("SELECT count(*) as Aantal  from hussel_spelers where Vereniging_id = ".$vereniging_id." and Naam = '".$naam."'   ") or die(' Fout in select spelers');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count == 0 and $naam <> '') {

/// Voeg toe aan hussel spelers
$query="INSERT INTO hussel_spelers (Id, Vereniging, Vereniging_id,Naam) VALUES (0,'".$vereniging."',".$vereniging_id.",'".$naam."' )";   
mysql_query($query) or die(' Fout in insert speler');  
}
;
ob_end_flush();
?> 
