<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);

ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');

$naam            = $_POST['bestaande_speler'];
$datum           = $_POST['datum'];
$vereniging      = $_POST['vereniging'];
$vereniging_id   = $_POST['vereniging_id'];


/// Voeg toe aan hussel
if ($naam !=''){ 
$query = "INSERT INTO hussel_score (Vereniging, Vereniging_id,Datum,  Naam, Winst, Saldo)
               VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' , 0,0)";
mysqli_query($con,$query) or die (mysql_error()); 


}
ob_end_flush();
?> 
