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
////  import_NJBB_toernooi_kalender_csv_stap2.php  (c) Erik Hendrikx 2012 ev
////
////  Programma voor het uploaden van een csv bestand met de gegevens van de eigen leden. Wordt aangeroepen door Upload_speler_lijst.php met up te loaden filenaam 
////
////  Het inschrijfformulier kan gestart worden met de optie user_select=Yes. Dan komt er een optie op het formulier waarmee de leden van de eigen vereniging
////  kunnen worden geselecteerd uit een popup window om te worden ingevuld in het formulier.
//// 
////  Opmaak Excel (csv)
////
////  Datum;Naam toernooi;Vereniging;Lokatie/adres;Plaats;Tel locatie;Tel_Inschrijving;Inschr. tot;Lic/cat;Soort;Min;Max;Systeem;Kosten;Prijzen;Aanv;Email;URL
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysqli.php');
ini_set('display_errors', 0); 

set_time_limit(300);//for setting 

/*
$parts            = explode("/", $prog_url);
$paths            = "/public_html/".$parts[3]."/csv/";
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
   			window.location.replace('import_inschrijf_csv_stap1php');
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
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}
*/
?>


<body>
<div style='background-color:white;'>
<table >
<tr><td  rowspan=2 width='280'><img src = '../boulamis_toernooi/images/ontip_logo.png' width='240'></td>
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
<input type="hidden" name="datum"                   value="<?php echo $datum;?>" />

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees bestand en voer kontroles uit


$myFile   =  "csv/".$name;
$myFile = 'Toernooikalender_NJBB.csv';

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

//  Datum;Naam toernooi;Vereniging;Lokatie/adres;Plaats;Tel locatie;Tel_Inschrijving;Inschr. tot;Lic/cat;Soort;Min;Max;Systeem;Kosten;Prijzen;Aanv;Email;URL
$parts = explode (";", $line);

$temp              =   $parts[0];
$parts2            = explode (" ", $temp);

$datum_dag         =   $parts[0];
$datum_maand       =   $parts[1];
$datum_jaar        = date('Y');

switch($datum_maand){
	case 'jan' : $maand = '01';break;
	case 'feb' : $maand = '02';break;
	case 'mar' : $maand = '03';break;
	case 'apr' : $maand = '04';break;
	case 'mei' : $maand = '05';break;
	case 'jun' : $maand = '06';break;
	case 'jul' : $maand = '07';break;
	case 'aug' : $maand = '08';break;
	case 'sep' : $maand = '09';break;
	case 'okt' : $maand = '10';break;
	case 'nov' : $maand = '11';break;
	case 'dec' : $maand = '12';break;
}// end switch

$datum = $datum_jaar.'-'. $maand .'-'.sprintf("%02d",$datum_dag);      


$toernooi          =   $parts[1];
$vereniging        =   $parts[2];
$adres_locatie     =   $parts[3];
$plaats            =   $parts[4];
$tel_locatie       =   $parts[5];
$tel_inschrijving  =   $parts[6];
$temp              =   $parts[7];
$parts2            = explode ("-", $temp);
$datum_dag         =   $parts2[0];
$datum_maand       =   $parts2[1];
$datum_jaar        =   $parts2[1];
$inschrijven_tot   =   $datum_jaar.'-'. $maand .'-'.sprintf("%02d",$datum_dag);     
$temp              =   $parts[8];
$parts2            = explode ("/", $temp);
$licentie          =   $parts2[0];
$cat_toernooi      =   $parts2[1];
$soort_toernooi    =   $parts2[1];
$min_aantal        =   $parts[9];
$max_aantal        =   $parts[10];
$systeem_toernooi  =   $parts[11];
$kosten            =   $parts[12];
$aanvang_toernooi  =   $parts[13];
$email             =   $parts[14];
$url_website       =   $parts[15];


$insert = "insert into toernooi_kalender (Id,Datum ,Toernooi, Soort_toernooi,Cat_toernooi,Systeem_toernooi,Vereniging,Adres_locatie,Tel_locatie,Email_info,Inschrijven_vanaf, 
                                          Licentie, Kosten, Min_aantal, Max_aantal,Aanvang_toernooi,Url_vereniging, Laatst )
               values (0, '".$datum."', '".$toernooi."','".$soort_toernooi."', '".$cat_toernooi."', '".$systeem_toernooi."', '".$verenigiging."', '".$adres_locatie."', 
               '".$tel_locatie."', '".$email."', '".$inschrijven_vanaf."', '".$licentie."', '".$kosten."', ".$min_aantal.", ".$max_aantal.", '".$aanvang_toernooi."', 
               '".$url_vereniging."', now()  )" ;
               
echo $insert;
               
 


$line = fgets($fh);
} /// while

echo "</table>";

echo "<input type='hidden' name='uploads' value='".serialize($uploads)."' >";


fclose($fh);
?>
<br><br>
<input type="submit" name="submit" value="Importeer goedgekeurde inschrijvingen" />
</form>

