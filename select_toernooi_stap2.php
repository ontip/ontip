<?php
#
# Date              Version      Person
# ----              -------      ------


# 10mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

ob_start();
header("Location: ".$_SERVER['HTTP_REFERER']);


include 'mysqli.php'; 
//include('action.php');

if (isset($_POST['zendform'])){

$toernooi       = $_POST['toernooi']; 

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select config');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
$ip        = md5($_SERVER['REMOTE_ADDR']);


mysqli_query($con,"Update namen set Toernooi = '".$toernooi."' 
                        WHERE Aangelogd = 'J'  and Vereniging_id = ".$vereniging_id."  and IP_adres_md5 = '". $ip."' ");
                        

// Aanmaken cookie ivm selectie toernooi

setcookie ("toernooi", $toernooi , time() +144000);
setcookie ("toernooi_voluit", $toernooi_voluit , time() +144000);
setcookie ("datum", $datum , time() +144000);

}  // zendform	  
ob_end_flush();
//header ("location: index.php"); 
?>


