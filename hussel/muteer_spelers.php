<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');


// ophalen aantal score regels
$count_spelers   = $_POST['count_spelers'];

for ($i=1;$i<=$count_spelers;$i++){

$id        = $_POST['Id-'.$i];     
$naam      = $_POST['Naam-'.$i];      


// Update

$query="UPDATE hussel_spelers
               SET Naam       = '".$naam."'
           WHERE  Id      = '".$id."'  ";
//echo $query;

mysqli_query($con,$query) or die (mysql_error()); 
}// end for


/// Hierna pas het verwijderen van aangevinkte spelers doen

if (isset ($_POST['Check'])){
$check=$_POST['Check'];
foreach ($check as $checkid)
{
//echo "$checkid is checked en zal verwijderd worden";
mysqli_query($con,"DELETE FROM hussel_spelers where Id= '".$checkid."'");
}
}
   
ob_end_flush();
?> 
