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
function redirect($url) {
        //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
}

include 'mysqli.php'; 

$toernooi       = $_POST['Toernooi']; 
$url            = $_POST['Url'];

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

setcookie ("toernooi", $toernooi );
setcookie ("toernooi_voluit", $toernooi_voluit , time() +144000);
setcookie ("datum", $datum , time() +144000);

$url = $url.'?toernooi='.$toernooi;

redirect($url);
 
 	  
ob_end_flush();
?>


