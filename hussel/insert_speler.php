<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');
$naam            = $_POST['nieuwe_speler'];
$vereniging      = $_POST['vereniging'];
$vereniging_id   = $_POST['vereniging_id'];

$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'marathon_ronde'  ") ;  
$result              = mysqli_fetch_array( $qry);
$marathon_ronde       = $result['Waarde'];

$datum        =  $_POST['datum'];

/// Voeg toe aan hussel als de speler nog niet is toegevoegd

$sql      = mysqli_query($con,"SELECT count(*) as Aantal  from hussel_score where Vereniging_id = ".$vereniging_id." and  Naam = '".$naam."'   and Datum = '".$datum."' ") or die(' Fout in select hussel score');  
$result   = mysqli_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count == 0 and $naam <> '') {

/// Voeg toe aan hussel score
$query = "INSERT INTO hussel_score (Vereniging, Vereniging_id,Datum,  Naam,Ronde,  Winst, Saldo)
               VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."', ".$marathon_ronde." , 0,0)";
mysqli_query($con,$query) or die(' Fout in insert score');  

};


/// Toevoegen aan spelers als deze er nog niet in staat
$sql      = mysqli_query($con,"SELECT count(*) as Aantal  from hussel_spelers where Vereniging_id = ".$vereniging_id." and Naam = '".$naam."'   ") or die(' Fout in select spelers');  
$result   = mysqli_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count == 0 and $naam <> '') {

/// Voeg toe aan hussel spelers
$query="INSERT INTO hussel_spelers (Id, Vereniging, Vereniging_id,Naam) VALUES (0,'".$vereniging."',".$vereniging_id.",'".$naam."' )";   
mysqli_query($con,$query) or die(' Fout in insert speler');  
}
;
ob_end_flush();
?> 
