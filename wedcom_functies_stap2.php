<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);

ini_set('display_errors', 'OFF');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');


//echo "vereniging :". $vereniging . "<br>";
echo "toernooi   :". $toernooi . "<br>";

$toernooi     = $_POST['Toernooi']; 

$max_splrs     = $_POST['max_splrs'];      
$min_splrs     = $_POST['min_splrs'];      
$aantal_reserves   = $_POST['aantal_reserves'];      


// Update queries

//$datum             = $_POST['datum_jaar']."-".sprintf("%02d",$_POST['datum_maand'])."-".sprintf("%02d",$_POST['datum_dag']);

$begin_datum       = $_POST['begin_datum_jaar']."-".sprintf("%02d",$_POST['begin_datum_maand'])."-".sprintf("%02d",$_POST['begin_datum_dag']);
$einde_datumtijd   = $_POST['eind_datum_jaar']."-".sprintf("%02d",$_POST['eind_datum_maand'])."-".sprintf("%02d",$_POST['eind_datum_dag'])." ".sprintf("%02d",$_POST['eind_datum_uur']).":".sprintf("%02d",$_POST['eind_datum_min']);


$query = "UPDATE config SET Waarde  = '".$begin_datum."' ,  Laatst     = NOW()    WHERE  Vereniging = '".$vereniging."'  and    Toernooi   = '".$toernooi."'   and Variabele = 'begin_inschrijving' "; 
//echo $query;
mysqli_query($con,$query) or die ('Fout in update 1'); 

$query = "UPDATE config SET Waarde  = '".$einde_datumtijd."' ,  Laatst     = NOW()    WHERE  Vereniging = '".$vereniging."'  and    Toernooi   = '".$toernooi."'   and Variabele = 'einde_inschrijving' "; 
//echo $query;
mysqli_query($con,$query) or die ('Fout in update 2'); 




$query = "UPDATE config SET Waarde  = '".$aantal_reserves  ."' ,  Laatst     = NOW()     WHERE  Vereniging = '".$vereniging."'  and    Toernooi   = '".$toernooi."'   and Variabele = 'aantal_reserves' "; 
mysqli_query($con,$query) or die ('Fout in update 3'); 

$query = "UPDATE config SET Waarde  = '".$max_splrs."'         ,  Laatst     = NOW()     WHERE  Vereniging = '".$vereniging."'  and    Toernooi   = '".$toernooi."'   and Variabele = 'max_splrs' "; 
mysqli_query($con,$query) or die ('Fout in update 4'); 

$query = "UPDATE config SET Waarde  = '".$min_splrs."'         ,  Laatst     = NOW()     WHERE  Vereniging = '".$vereniging."'  and    Toernooi   = '".$toernooi."'   and Variabele = 'min_splrs' "; 
mysqli_query($con,$query) or die ('Fout in update 5'); 

?> 