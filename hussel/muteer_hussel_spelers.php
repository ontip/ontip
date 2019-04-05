<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');
include ('conf/sub_date.php');

$poule_q      = mysqli_query($con,"SELECT Waarde From hulp WHERE Naam='Poule' " )                   or die(mysql_error()); 

if ( mysqli_result($poule_q ,0) == 0) { $poule ='';} ;
if ( mysqli_result($poule_q ,0) == 1) { $poule ='A';} ;
if ( mysqli_result($poule_q ,0) == 2) { $poule ='B';} ;

// bepaal eerst aantal regels voor de huidige datum

$sql       =  mysqli_query($con,"SELECT Count(*) from hussel where Datum = '".$date."' and Poule = '".$poule."' ");
$aant      =  mysqli_result($sql,0); 


for ( $i= 1; $i <= $aant; $i++) {

$id        = $_POST['Id-'.$i];     
$naam      = $_POST['Naam-'.$i];      
$poule     = $_POST['Poule-'.$i];  

// Update

$query="UPDATE hussel 
               SET Naam       = '".$naam."',
               Poule          = '".$poule."'
               WHERE  Id      = '".$id."'  ";

mysqli_query($con,$query) or die (mysql_error()); 

/// Hierna pas het verwijderen van aangevinkte spelers doen

$check=$_POST['Check'];
foreach ($check as $checkid)
{
echo "$checkid is checked en zal verwijderd worden";
mysqli_query($con,"DELETE FROM hussel where Id= '".$checkid."'");
}

};  ////// end if bladeren

include ('return.php');
   
ob_end_flush();
?> 
