<?php
$today         = date("Y-m-d");
$vereniging_url = $_GET['parm'];
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  create_toernooi_all_export_json
/// Maakt een json bestand aan met alle toernooien voor een vereniging en geeft aan of het toernooi actief is of niet.
//// Tbv  Pres le But
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie bestand tbv verenigingsnaam

//echo "ul" . $vereniging_url;

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

// Er wordt een JSON file gevuld waarin de data wordt opgenomen
$json_file = "csv/ontip_toernooi_".$vereniging_url.".json";
$fp        = fopen($json_file, "w");

fwrite($fp, '[  ');


$switch = 0;

while($row = mysqli_fetch_array( $qry )) {

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel
 

while($row1= mysqli_fetch_array( $sql )) {
	
	 $var  = $row1['Variabele'];
	 $$var = $row1['Waarde'];
	}


// komma tussen toernooien alleen niet bij eerste

if ($switch != 0){
	fwrite($fp, ' , ');
	} else {
	$switch =1;
}
  	

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$dag1   = 	substr ($begin_inschrijving , 8,2); 
$maand1 = 	substr ($begin_inschrijving , 5,2); 
$jaar1  = 	substr ($begin_inschrijving , 0,4); 

//  if ($begin_inschrijving <= $today  and $datum >= $today ){                      

       /// actief toernooi 
       
       fwrite($fp, '{ "toernooi    ": "'. $toernooi.'",');
       fwrite($fp, '  "titel       ": "Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",');
       fwrite($fp, '  "beschrijving": "Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",');
       fwrite($fp, '  "actief      ": "'.$begin_inschrijving. '"');
       fwrite($fp, '}');
  
       
/* }
 else {
       /// niet actief toernooi 
       
      fwrite($fp, '{ "toernooi    ": "'. $toernooi.'",');
       fwrite($fp, '  "titel       ": "Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",');
       fwrite($fp, '  "beschrijving": "Inschrijven '. $toernooi_voluit.' '.strftime('%a %e %b %Y', mktime(0, 0, 0, $maand , $dag, $jaar)). '",');
       fwrite($fp, '  "actief": false');
       fwrite($fp, '}');

}  // end if actief
 */
 
 
 } //end while toernooien      
	 
			 // End json  let op gebruik quotes
			 fwrite($fp, ' ] ');
fclose($fp);
/*
if ($vereniging_url !=''){
	?>
	<script language="javascript">
		window.location.replace('index.php');
</script>
<?php 
}
*/
?>


