<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('conf/mysql.php');
include ('conf/sub_date.php');

$poule_q      = mysql_query("SELECT Waarde From hulp WHERE Naam='Poule' " )                   or die(mysql_error()); 

if ( mysql_result($poule_q ,0) == 0) { $poule ='';} ;
if ( mysql_result($poule_q ,0) == 1) { $poule ='A';} ;
if ( mysql_result($poule_q ,0) == 2) { $poule ='B';} ;

// bepaal eerst aantal regels voor de huidige datum

$sql       =  mysql_query("SELECT Count(*) from hussel where Datum = '".$date."' and Poule = '".$poule."' ");
$aant      =  mysql_result($sql,0); 


for ( $i= 1; $i <= $aant; $i++) {

$id        = $_POST['Id-'.$i];     
$naam      = $_POST['Naam-'.$i];      
$poule     = $_POST['Poule-'.$i];  

// Update

$query="UPDATE hussel 
               SET Naam       = '".$naam."',
               Poule          = '".$poule."'
               WHERE  Id      = '".$id."'  ";

mysql_query($query) or die (mysql_error()); 

/// Hierna pas het verwijderen van aangevinkte spelers doen

$check=$_POST['Check'];
foreach ($check as $checkid)
{
echo "$checkid is checked en zal verwijderd worden";
mysql_query("DELETE FROM hussel where Id= '".$checkid."'");
}

};  ////// end if bladeren

include ('return.php');
   
ob_end_flush();
?> 
