<html
<head>
<title>Upload inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type="text/css">
	body {color:black;font-size:9pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}
a    {text-decoration:none ;color:blue;}

td {color:blue;font-size: 9pt;background-color:white;}

.tab {text-align:left;color:black;font-size:10pt;font-family:arial;}


</style>
</head>
<?php
////  import_inschrijf_csv_stap2.php  (c) Erik Hendrikx 2012 ev
////
////  Programma voor het uploaden van een csv bestand met de gegevens van de eigen leden. Wordt aangeroepen door Upload_speler_lijst.php met up te loaden filenaam 
////
////  Het inschrijfformulier kan gestart worden met de optie user_select=Yes. Dan komt er een optie op het formulier waarmee de leden van de eigen vereniging
////  kunnen worden geselecteerd uit een popup window om te worden ingevuld in het formulier.
//// 
////  Dit bestand is aangemaakt door lijst_licensies_export.php.
////
////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysql.php');
ini_set('display_errors', 0); 

set_time_limit(300);//for setting 


	
$qry          = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysql_fetch_array( $qry );
$prog_url     = $row['Prog_url'];

$parts            = explode("/", $prog_url);
$paths            = "/public_html/".$parts[1]."/csv/";

$ftp_server       = $_POST['server'];
$toernooi         = $_POST['toernooi'];
$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$destination_file = $paths. $_FILES['userfile']['name'];

if ($source_file == ''){
	?>
	<script type="text/javascript">
		alert("Geen bestand geselecteerd via Bladeren/browse !") 
   			window.location.replace('import_inschrijf_csv_stap1.php');
</script>
<?php
}

// set up a connection to ftp server
$conn_id          = ftp_connect($ftp_server);
ftp_pasv($conn_id,TRUE);
 
// login with username and password
$login_result     = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
 
// check connection and login result
if ((!$conn_id) || (!$login_result)) {
	?>
	<script type="text/javascript">
	   	alert("Probleem met verbinding maken met server!" + '\r\n' +
	          "Server : <?php echo  $ftp_server; ?> en user : <?php echo  $ftp_user_name; ?>")
			window.location.replace('import_inschrijf_csv_stap1.php');
</script>
<?php
}

// upload the file to the path specified

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
 
// check the upload status
if (!$upload) {
	?>
	<script type="text/javascript">
	   	alert("Bij uploaden is er iets fout gegaan!" + '\r\n' + 
	          "Download locatie : <?php echo  $paths; ?>" + '\r\n' +
	          "Source file      : <?php echo  $source_file; ?>")
			window.location.replace('import_inschrijf_csv_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

?>

<body>
<div style='background-color:white;'>
<table >
<tr><td  rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>


<table width=95% border = 0 style='position:absolute;padding-top:-10pt;'>
	<tr>
		<td style='vertical-align:text-top;' >
<span style='text-align:left;vertical-align:text-top;font-size:9pt;'><a href='index.php'>Terug naar Hoofdmenu</a></span>
</td>
<td style='vertical-align:text-top;text-align:right;' >
<span style='text-align:right;vertical-align:text-top;font-size:9pt;'><a href='import_inschrijf_csv_stap1.php?toernooi=<?php echo $_POST['toernooi'];?>' >Terug naar keuze upload bestand</a></span>
</td>
</tr>
</table>
<br>

<div style='padding:10pt;font-size:20pt;color:green;'><br>Kontrole bestand </div>

<form action="import_inschrijf_csv_stap3.php" method="POST" >
<input type="hidden" name="file"                     value="<?php echo "..".$destination_file;?>"/> 
<input type="hidden" name="toernooi"                 value="<?php echo $toernooi;?>" />
<input type="hidden" name="vereniging"               value="<?php echo $vereniging;?>" />
<input type="hidden" name="datum"                    value="<?php echo $datum;?>" />

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees bestand en voer kontroles uit

echo "<h3>Toernooi gegevens</h3><br>";

echo "<table border =0 >";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Naam toernooi         : </td><td>". $toernooi."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Naam toernooi voluit  : </td><td>". $toernooi_voluit."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Datum toernooi        : </td><td>". $datum."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Soort toernooi        : </td><td>". $soort_inschrijving."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Inschrijf_methode     : </td><td>". $inschrijf_methode."</td></tr>";
echo "<tr><td style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Licentie verplicht    : </td><td>". $licentie_jn."</td></tr>";
echo "</tr></table><br>";

$myFile   =  "csv/".$name;

//echo "Check ".$myFile;

echo "<h3>Bestands kontroles</h3><br>";

echo "<table border =1 >";


$fh       = fopen($myFile, 'r');
$line     = fgets($fh);
$error   = 0;

while ( $line <> ''){

$message = '';

if (substr($line,0,2) != '//' and $error < 2){
	
//echo $line. "<br>";

if ($error < 2){
$error   = 0;
}

$parts = explode (";", $line);

$nr           =   $parts[0];
$naam1        =   $parts[1];
$licentie1    =   $parts[2];
$vereniging1  =   $parts[3];

$naam2        =   $parts[4];
$licentie2    =   $parts[5];
$vereniging2  =   $parts[6];

$naam3        =   $parts[7];
$licentie3    =   $parts[8];
$vereniging3  =   $parts[9];

$naam4        =   $parts[10];
$licentie4    =   $parts[11];
$vereniging4  =   $parts[12];

$naam5        =   $parts[13];
$licentie5    =   $parts[14];
$vereniging5  =   $parts[15];

$naam6        =   $parts[16];
$licentie6    =   $parts[17];
$vereniging6  =   $parts[18];

$email        =   $parts[19];
$telefoon     =   $parts[20];

if ($nr =='Nr'){

// Check kop teksten

if ($naam1 != 'Naam1'){
    $error = 2;
    $message .= '* Koptekst kolom B in bestand is niet correct. Verwacht : Naam1<br>';
 }    

if ($licentie1 != 'Licentie1'){
    $error = 2;
    $message .= '* Koptekst kolom C in bestand is niet correct. Verwacht : Licentie1<br>';
 }    

if ($vereniging1 != 'Vereniging1'){
    $error = 2;
    $message .= '* Koptekst kolom D in bestand is niet correct. Verwacht : Vereniging1<br>';
 }    

if ($naam2 != 'Naam2'){
    $error = 2;
    $message .= '* Koptekst kolom E in bestand is niet correct. Verwacht : Naam2<br>';
 }    

if ($licentie2 != 'Licentie2'){
    $error = 2;
    $message .= '* Koptekst kolom F in bestand is niet correct. Verwacht : Licentie2<br>';
 }    

if ($vereniging2 != 'Vereniging2'){
    $error = 2;
    $message .= '* Koptekst kolom G in bestand is niet correct. Verwacht : Vereniging2<br>';
 }    

if ($naam3 != 'Naam3'){
    $error = 2;
    $message .= '* Koptekst kolom H in bestand is niet correct. Verwacht : Naam3<br>';
 }    

if ($licentie3 != 'Licentie3'){
    $error = 2;
    $message .= '* Koptekst kolom I in bestand is niet correct. Verwacht : Licentie3<br>';
 }    

if ($vereniging3 != 'Vereniging3'){
    $error = 2;
    $message .= '* Koptekst kolom J in bestand is niet correct. Verwacht : Vereniging3<br>';
 }    

if ($naam4 != 'Naam4'){
    $error = 2;
    $message .= '* Koptekst kolom K in bestand is niet correct. Verwacht : Naam4<br>';
 }    

if ($licentie4 != 'Licentie4'){
    $error = 2;
    $message .= '* Koptekst kolom L in bestand is niet correct. Verwacht : Licentie4<br>';
 }    

if ($vereniging4 != 'Vereniging4'){
    $error = 2;
    $message .= '* Koptekst kolom M in bestand is niet correct. Verwacht : Vereniging4<br>';
 }    

if ($naam5 != 'Naam5'){
    $error = 2;
    $message .= '* Koptekst kolom N in bestand is niet correct. Verwacht : Naam5<br>';
 }    

if ($licentie5 != 'Licentie5'){
    $error = 2;
    $message .= '* Koptekst kolom O in bestand is niet correct. Verwacht : Licentie5<br>';
 }    

if ($vereniging5 != 'Vereniging5'){
    $error = 2;
    $message .= '* Koptekst kolom P in bestand is niet correct. Verwacht : Vereniging5<br>';
 }    

if ($naam6 != 'Naam6'){
    $error = 2;
    $message .= '* Koptekst kolom Q in bestand is niet correct. Verwacht : Naam6<br>';
 }    

if ($licentie6 != 'Licentie6'){
    $error = 2;
    $message .= '* Koptekst kolom R in bestand is niet correct. Verwacht : Licentie6<br>';
 }    

if ($vereniging6 != 'Vereniging6'){
    $error = 2;
    $message .= '* Koptekst kolom S in bestand is niet correct. Verwacht : Vereniging6<br>';
 }    

if (substr($email,0,5) != 'Email'){
    $error = 2;
    $message .= '* Koptekst kolom T in bestand is niet correct. Verwacht : Email<br>';
 }    

if (substr($telefoon,0,8) != 'Telefoon'){
    $error = 2;
    $message .= '* Koptekst kolom U in bestand is niet correct. Verwacht : Telefoon. Gevonden : '.$telefoon.'<br>';
 }    

}
else { 


// check op licentie indien licentie verplicht

if ($licentie_jn == 'N') {
	
if ($naam1 == '' ){
	  $message .= "* Naam speler 1 is niet ingevuld<br>";
	  $error = 1;
} 

if ($naam2 == '' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'  ){
	$message .= "* Naam speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($naam3 == '' and $soort_inschrijving == 'triplet'  and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($naam4 == '' and $soort_inschrijving == 'sextet'  and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($naam5 == '' and $soort_inschrijving == 'sextet'  and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 5 is niet ingevuld<br>";
	$error = 1;
}


if ($naam6 == '' and $soort_inschrijving == 'sextet'  and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 6 is niet ingevuld<br>";
	$error = 1;
}


} // licentie_verlicht_jn = N 


if ($licentie1 == ''  and $licentie_jn == 'J'){
	  $message .= "* Licentie speler 1 is niet ingevuld<br>";
	  $error = 1;
}

//echo "licentie2  : ". $licentie2."<br>";


if ($licentie2 == '' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'  and $licentie_jn == 'J' ){
	$message .= "* Licentie speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($licentie3 == '' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($licentie4 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($licentie5 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($licentie6 == '' and $soort_inschrijving == 'sextet' and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 6 is niet ingevuld<br>";
	$error = 1;
}


/// Indien licentie verplicht en naam niet is ingevuld wordt de naam opgehaald


$qry        = mysql_query("SELECT * From inschrijf  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ") ;  
$row        = mysql_fetch_array( $qry);

if ($naam1 == '' and $licentie_jn == 'J'){
    $naam1  = $row['Naam1'];
}
if ($naam2 == '' and $licentie_jn == 'J'){
    $naam2  = $row['Naam2'];
}
if ($naam3 == '' and $licentie_jn == 'J'){
    $naam3  = $row['Naam3'];
}
if ($naam4 == '' and $licentie_jn == 'J'){
    $naam4  = $row['Naam4'];
}
if ($naam5 == '' and $licentie_jn == 'J'){
    $naam5  = $row['Naam5'];
}

if ($naam6 == '' and $licentie_jn == 'J'){
    $naam6  = $row['Naam6'];
}


/// Indien licentie verplicht en naam niet is ingevuld wordt de naam opgehaald

if ($naam1 == '' and $licentie_jn == 'J' ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie1."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam1       = $row['Naam'];
  $vereniging1 =  $row['Vereniging'];
}

if ($naam1 != '' and $licentie1 != '' ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie1."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging1 =  $row['Vereniging'];
}

if ($naam2 == '' and $licentie_jn == 'J' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'  ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie2."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam2       = $row['Naam'];
  $vereniging2 =  $row['Vereniging'];
}

if ($naam2 != '' and $licentie2 != '' and $licentie_jn == 'J' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie2."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging2 =  $row['Vereniging'];
}

if ($naam3 == '' and $licentie_jn == 'J' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie3."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam3       = $row['Naam'];
  $vereniging3=  $row['Vereniging'];
}

if ($naam3 != '' and $licentie3 != '' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie3."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging3 =  $row['Vereniging'];
}

if ($naam4 == '' and $licentie_jn == 'J' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie4."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam4       = $row['Naam'];
  $vereniging4=  $row['Vereniging'];
}

if ($naam4 != '' and $licentie4 != '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie4."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging4 =  $row['Vereniging'];
}

if ($naam5 == '' and $licentie_jn == 'J' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie5."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam5       = $row['Naam'];
  $vereniging5 =  $row['Vereniging'];
}

if ($naam5 != '' and $licentie5 != '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie5."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging5 =  $row['Vereniging'];
}

if ($naam6 == '' and $licentie_jn == 'J' and $soort_inschrijving == 'sextet'){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie6."' ");  
  $row         = mysql_fetch_array( $qry );
  $naam6       = $row['Naam'];
  $vereniging6 = $row['Vereniging'];
}

if ($naam6 != '' and $licentie6 != '' and $soort_inschrijving == 'sextet' ){
	$qry         = mysql_query("SELECT * From speler_licenties where Licentie = '".$licentie6."' ");  
  $row         = mysql_fetch_array( $qry );
  $vereniging6 =  $row['Vereniging'];
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Kontrole op dubbel inschrijven m.b.v table hulp_naam

$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam1."' and Vereniging_speler = '".$vereniging1."' " ;
//echo $sql;

$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
 $message .= "* Er is al een inschrijving ingevuld voor ".$naam1." van ".$vereniging1."<br>";
	$error = 1;
}

if ($naam2 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam2."' and Vereniging_speler = '".$vereniging2."' " ;
$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam2. " van ".$vereniging2."<br>";
	$error = 1;
}
}
	
if ($naam3 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam3."' and Vereniging_speler = '".$vereniging3."' " ;
$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam3." van ".$vereniging3. "<br>";
	$error = 1;
}
}

if ($naam4 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam4."' and Vereniging_speler = '".$vereniging4."'" ;
$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam4. " van ".$vereniging4."<br>";
	$error = 1;
}
}

if ($naam5 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam5."' and Vereniging_speler = '".$vereniging5."'" ;
$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam5. " van ".$vereniging5."<br>";
	$error = 1;
}
}

if ($naam6 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam6."' and Vereniging_speler = '".$vereniging6."' " ;
$result= mysql_query($sql);
$count=mysql_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam6. " van ".$vereniging6."<br>";
	$error = 1;
}
}


} // end nr
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// vul tabel

echo "<tr>";
echo "<td class ='tab1'>".$nr."</td>";          
echo "<td>".$naam1.     "</td>";       
echo "<td>".$licentie1. "</td>";   
echo "<td>".$vereniging1. "</td>";   


if  ($soort_inschrijving != 'single' and $inschrijf_methode == 'vast'  and $licentie_jn == 'J' ){
echo "<td>".$naam2.     "</td>";  
echo "<td>".$licentie2. "</td>";  
echo "<td>".$vereniging2. "</td>";   
}
	

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam3.     "</td>";  
echo "<td>".$licentie3. "</td>";  
echo "<td>".$vereniging3. "</td>";   
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam4.     "</td>";  
echo "<td>".$licentie4. "</td>";  
echo "<td>".$vereniging4. "</td>";   

echo "<td>".$naam5.     "</td>";  
echo "<td>".$licentie5. "</td>";   
echo "<td>".$vereniging5. "</td>";   

}

if ($soort_inschrijving == 'sextet' and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam6.     "</td>"; 
echo "<td>".$licentie6. "</td>";   
echo "<td>".$vereniging6. "</td>";   
}

echo "<td>".$parts[19]. "</td>";   

if ($parts[0] == 'Nr' and $error  == 0){
echo "<td>Kontrole</td>";  // bericht
}
else {
		if ($error == 0 ){
	      $message = 	'Goed gekeurd';
	      $color = 'green';
	      
	      // gegevens in 1 regel opnemen tbv stap3
	      $_line = $nr.";".$naam1.";".$licentie1.";".$vereniging1;
	      $_line = $_line.";".$naam2.";".$licentie2.";".$vereniging2;
	      $_line = $_line.";".$naam3.";".$licentie3.";".$vereniging3;
	      $_line = $_line.";".$naam4.";".$licentie4.";".$vereniging4;
	      $_line = $_line.";".$naam5.";".$licentie5.";".$vereniging5;
	      $_line = $_line.";".$naam6.";".$licentie6.";".$vereniging6.";".$email.";".$telefoon.";";
	      
	//      echo $_line;
	      
	      $uploads[] = $_line;
	   } else { 
	   	  $color = 'red';
   }

echo "<td style= 'color:".$color.";'>".$message."</td>";  // bericht
}

echo "</tr>";
} // no comment 



$line = fgets($fh);
} /// while

echo "</table>";

echo "<input type='hidden' name='uploads' value='".serialize($uploads)."' >";


fclose($fh);
?>
<br><br>
<input type="submit" name="submit" value="Importeer goedgekeurde inschrijvingen" />
</form>

