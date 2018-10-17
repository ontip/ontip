<?php

include('mysql.php');
// naar csv folder omdat xlsx nog niet bestaat bij meeste verenigingen
$paths            = "/public_html/".substr($prog_url,3, strlen($prog_url))."csv/";


$ftp_server       = $_POST['server'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$toernooi         = $_POST['toernooi'];
$timest           = date('ymdhis');
$destination_file = $paths.'import_'.$toernooi."_".$timest.'.xlsx';


if ($name  == '')
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen bestand geselecteerd !")
		  window.location.replace('import_inschrijvingen_xlsx_stap1.php');
</script>
<?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// set up a connection to ftp server
$conn_id          = ftp_connect($ftp_server);
ftp_pasv($conn_id,TRUE);
 
// login with username and password
$login_result     = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
 
// check connection and login result
if ((!$conn_id) || (!$login_result)) {
	$error = 1;
	?>
	<script type="text/javascript">
	   	alert("Probleem met verbinding maken met server!" + '\r\n' +
	          "Server : <?php echo  $ftp_server; ?> en user : <?php echo  $ftp_user_name; ?>")
		 	window.location.replace('import_inschrijvingen_xlsx_stap1.php');
</script>
<?php
}

// upload the file to the path specified

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
 
 //echo "Download locatie : ". $paths."<br>";
 // echo "Source file      : ". $name;
 
  
// check the upload status
if (!$upload) {
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Bij uploaden is er iets fout gegaan!" + '\r\n' + 
	          "Download locatie : <?php echo  $paths; ?>" + '\r\n' +
	          "Source file      : <?php echo  $name; ?>")
		  window.location.replace('import_inschrijvingen_xlsx_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	

//////////////////////////////////////////////////////////////////////////////////////////////

if ($error == 0){
$xlsx_file = $destination_file;
//echo $destination_file;

include('import_inschrijvingen_xlsx_stap3.php');
}
?>
