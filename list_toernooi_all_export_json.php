<?php
$today      = date("Y-m-d");
$vereniging_url = $_GET['Vereniging_url'];
//header("Content-type: application/octet-stream");
//header("Content-Disposition: attachment; filename=\"ontip_toernooi_".$vereniging_url.".json\"");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie bestand tbv verenigingsnaam

$myFile   =  'http://www.boulamis.nl/'.$vereniging_url.'/myvereniging.txt';
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

//include('http://www.boulamis.nl/'.$vereniging_url.'/mysqli.php');

$hostname = "localhost"; 
$username = "boulamis"; 
$password = "But@3751"; 
$database = "boulamis_db";
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


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


/// Schoon hulp tabel

mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") ;  

// Insert alle toernooien voor deze vereniging

$insert = mysqli_query($con,"INSERT INTO hulp_toernooi
(`Toernooi`, `Vereniging`, `Datum`) 
 select distinct Toernooi, Vereniging, Waarde from config where Vereniging = '".$vereniging."' and Variabele = 'Datum' and   Waarde >= '".$today."' ");
 
// Update soort Toernooi
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Soort_toernooi =  c.Waarde,
       t.Inschrijving_open  = 'J'
   where t.Vereniging = '".$vereniging."' and 
         c.Variabele    = 'soort_inschrijving'");

// Update Inschrijving_open
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Inschrijving_open  = 'N'
   where t.Vereniging = '".$vereniging."' and 
    c.Variabele    = 'begin_inschrijving'
  and c.Waarde > '".$today."'  ");


mysqli_query($con,"Delete from hulp_toernooi where Toernooi like '%test%' and Vereniging = '".$vereniging ."'  ") ;  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon alle toernooien

$qry          = mysqli_query($con,"SELECT distinct Vereniging,Toernooi, Datum From hulp_toernooi where Vereniging = '".$vereniging ."'  order by Datum ")     or die(' Fout in select 2');  

while($row = mysqli_fetch_array( $qry )) {

// Start json  let op gebruik quotes
//    echo '[{'.'\r\n'; 



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel
 
 echo $toernooi."<br>";
 echo $vereniging . "<br>";
 
 

while($row1= mysqli_fetch_array( $sql )) {
	
	 $var  = $row1['Variabele'];
	 $$var = $row1['Waarde'];
	}


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$dag1   = 	substr ($begin_inschrijving , 8,2); 
$maand1 = 	substr ($begin_inschrijving , 5,2); 
$jaar1  = 	substr ($begin_inschrijving , 0,4); 

$qry_ins    = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select inschrijf');  
$result    = mysqli_fetch_array( $qry_ins);
$aantal    = $result['Aantal'];	

/*
  if ($begin_inschrijving <= $today  and $datum >= $today ){                      

       /// actief toernooi 
       
       echo '"toernooi":'. $toernooi.'",'.'\r\n'; 
       echo '"titel":  Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",'.'\r\n'; 
       echo '"beschrijving":  Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",'.'\r\n'; 
       echo '"actief": true'.'\r\n'; 
       echo '},'.'\r\n'; 
       
 }
 
       /// niet actief toernooi 
       
       echo '"toernooi":'. $toernooi.'",'.'\r\n'; 
       echo '"titel":  Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",'.'\r\n'; 
       echo '"beschrijving":  Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",'.'\r\n'; 
       echo '"actief": false'.'\r\n'; 
       echo '},'.'\r\n'; 
  
 } //end while toernooien      
  */
		 
			 // End json  let op gebruik quotes
    echo '}]'.'\r\n'; 



