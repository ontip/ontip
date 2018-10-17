<?php 
// deze variabelen vervangen met je Mysql server / database gegevens 

$hostname = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "boulamis"; 

$username = "boulamis"; 
$password = "But@3751"; 
$database = "boulamis_db";

// Functie om eventuele MySQL errors te specificeren 

function showerror() 
{ 
die("Error" .mysql_errno() . " : " . mysql_error()); 
exit; 
} 

// MySQL connectie maken 

if (!($connection= @ mysql_connect($hostname, $username, $password))) showerror(); 


// specificeren welke database op de MySQL server we gebruiken 

if (!mysql_select_db($database, $connection)) 
showerror(); 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

$qry            = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysql_fetch_array( $qry );
$vereniging_nr  = $row['Vereniging_nr'];
//$prog_url       = $row['Prog_url'];
$grootte_logo   = $row['Grootte_logo'];
$url_website    = $row['Url_website'];
$vereniging_id  = $row['Id'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
 

}
else {
		//echo " Geen toernooi bekend :";
	 
};
?> 