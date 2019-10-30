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

    
      $hostname = "localhost"; 
     $username = "ontipnlv"; 
  //   $password = "p9FV9VeY"; 
	 $password = "w49WNfg0Rp"; 
     $database = "ontipnlv_db";
     
     $ftp_user_name    = 'ontipnlv';
     $ftp_user_pass    = "w49WNfg0Rp"; 

 
$con=mysqli_connect($hostname,$username,$password,$database);
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_set_charset($con,'utf8');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// init variabelen

$vereniging = '';


for ($i=1;$i<7;$i++){
	
	$var = 'naam'.$i;
	$$var ='';
	$var = 'vereniging'.$i;
	$$var ='';
  $var = 'licentie'.$i;
	$$var ='';

}
$suffix ='';
$lichtkranr = '';
$simpel ='';
$invulkop ='';
$mobiel ='';
$curl_url ='';
$achtergrond_kleur ='';
$Url_logo = '';
$toernooi_voluit = '';
$Grootte_logo = '';
$user = '';
$font_size = '';


//// Lees configuratie bestand tbv verenigingsnaam

$myFile   =  'myvereniging.txt';
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
$grootte_logo   = $row['Grootte_logo'];
$url_website    = $row['Url_website'];
$url_base       = $row['Url_redirect'];
$url_base       = str_replace('http://','https://', $url_base );
$prog_url       = $row['Prog_url'];
$datum_verloop_licentie = $row['Datum_verloop_licentie'];
$subdomein       = substr($prog_url,3,-1);



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select mysql');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


}
else {
		//echo " Geen toernooi bekend :";
	 
};
?> 