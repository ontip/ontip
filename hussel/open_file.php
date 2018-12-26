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



</form>

