<?php
$id       = $_GET['id'];
$updown   = $_GET['updown'];
$toernooi = $_GET['toernooi'];
header("Location: beheer_config_1.php?toernooi=".$toernooi."");
// Database gegevens. 
include('mysqli.php');

$qry      = mysqli_query($con,"SELECT Regel From config where Id = ".$id ." ")     or die(' Fout in select');  
$row      = mysqli_fetch_array( $qry );
$regel    = $row['Regel'];

//echo $regel;

//// arrow up   = Regel --
//// arrow down = Regel ++

switch ($updown){
  case "up"     : $regel--;break;
  case "down"   : $regel++;break;
}// end switch

if ($regel < 2)  { $regel   = 2;}
if ($regel > 99) { $regel  = 99;}

$query="UPDATE config     SET Regel = ".$regel."                where Id = ".$id ." "; 
//echo $query;
               
mysqli_query($con,$query) or die ('Fout in update'); 
  
?>  