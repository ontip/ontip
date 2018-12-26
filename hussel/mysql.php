<?php 
// deze variabelen vervangen met je Mysql server / database gegevens 

    $hostname = "localhost"; 
     $username = "ontipnlv"; 
     $password = "p9FV9VeY"; 
     $database = "ontipnlv_db";
     $ftp_server = 'ftp.ontip.nl'; 
     
     
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

$qry            = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysql_fetch_array( $qry );
$vereniging_nr  = $row['Vereniging_nr'];
$vereniging_id  = $row['Id'];
$output_naam_vereniging = $row['Vereniging_output_naam'];;

// Definieer variabelen en vul ze met waarde uit tabel hussel_config

$qry  = mysql_query("SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	// echo $var."<br>";
	 $$var = $row['Waarde'];
	}
	
if ($datum_lock == 'On'){	
	$qry  = mysql_query("SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." and Variabele ='datum_lock' ")     or die(' Fout in select');  
	$result  = mysql_fetch_array( $qry );
	$datum   = $result['Parameters'];
}
else {
	// datum vandaag
$datum = date ('Y')."-".date('m')."-".date('d');
}

	
setlocale(LC_ALL, 'nl_NL');
ini_set('default_charset','UTF-8');



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////