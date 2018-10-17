<?php
////  upload_csv_bestand.php  (c) Erik Hendrikx 2012 ev
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

$parts            = explode("/", $prog_url);
$paths            = "/public_html/".$parts[3]."/csv/";
$ftp_server       = $_POST['server'];
$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$destination_file = $_FILES['userfile']['name'];

if ($source_file == ''){
	?>
	<script type="text/javascript">
		alert("Geen bestand geselecteerd via Bladeren/browse !") 
   			window.location.replace('upload_leden_lijst.php');
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
	
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	
?>
