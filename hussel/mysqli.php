<?php 
# mysqli.php
# Connect met website en database
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 24jan2019            -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie van PHP 5.6 naar PHP 7
# Reference: 


$url_hostName = $_SERVER['HTTP_HOST'];

     $hostname  = "localhost"; 
     $username  = "ontipnlv"; 
   $password = "w49WNfg0Rp"; 
     $database  = "ontipnlv_db";
     $ftp_server = 'ftp.ontip.nl'; 
     
     $ftp_user_name    = $username;
     $ftp_user_pass    = $password;

 
$con=mysqli_connect($hostname,$username,$password,$database);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_set_charset($con,'utf8');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// init variabelen

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie bestand tbv verenigingsnaam

$myFile   =  '../myvereniging.txt';
$fh       = fopen($myFile, 'r');
$line     = fgets($fh);

while ( $line <> ''){

if (substr($line,0,1) == '$' ){

$pos = strpos($line, '=');

// Create variable (with $ sign), no spaces

$var = trim(substr($line,1,$pos-1));

// Set value to variable  trim for no spaces 
$$var = trim(substr($line,$pos+2,80));
 }

$line = fgets($fh);
} /// while

fclose($fh);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Ophalen vereniging_nr e.d  uit vereniging

$qry            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysqli_fetch_array( $qry );
$vereniging_nr  = $row['Vereniging_nr'];
$vereniging_id  = $row['Id'];
$output_naam_vereniging = $row['Vereniging_output_naam'];;

// Definieer variabelen en vul ze met waarde uit tabel hussel_config

$qry  = mysqli_query($con,"SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	// echo $var."<br>";
	 $$var = $row['Waarde'];
	}
	
if ($datum_lock == 'On'){	
	$qry  = mysqli_query($con,"SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." and Variabele ='datum_lock' ")     or die(' Fout in select');  
	$result  = mysqli_fetch_array( $qry );
	$datum   = $result['Parameters'];
}
else {
	// datum vandaag
$datum = date ('Y')."-".date('m')."-".date('d');
}

	
setlocale(LC_ALL, 'nl_NL');
ini_set('default_charset','UTF-8');

?> 