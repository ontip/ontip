<?php
////  upload_pdf_bestand.php  (c) Erik Hendrikx 2012 ev
////
////  Programma voor het uploaden van een pdf bestand (eigen flyer)O naar de csv dir
////
////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysql.php');
ini_set('display_errors', 0); 

set_time_limit(300);//for setting 
$qry            = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysql_fetch_array( $qry );
$prog_url       = $row['Prog_url'];
$paths          = $prog_url."csv/";

echo "copy  naar  ".$paths."<br>";

$ftp_server       = $_POST['server'];
$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$destination_file = $paths.$_FILES['userfile']['name'];

if ($source_file == ''){
	?>
	<script type="text/javascript">
		alert("Geen bestand geselecteerd via Bladeren/browse !") 
   			window.location.replace('upload_pdf_flyer.php');
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
			window.location.replace('toevoegen_vereniging_stap1.php');
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
			window.location.replace('toevoegen_vereniging_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	
?>
<script type="text/javascript">
   			window.location.replace('toevoegen_vereniging_stap1.php');
</script>