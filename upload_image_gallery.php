<?php
////  upload_img_bestand.php  (c) Erik Hendrikx 2012 ev
////
////  Programma voor het uploaden van een img bestand 
////
////

# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 8mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

# 10nov2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Harde waarde voor ftp server na migratie ontip naar andere server na problemen
# Reference: 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysqli.php');
ini_set('display_errors', 0); 


set_time_limit(300);//for setting 

$prog_url     = $_POST['url'];
//echo $prog_url;


if ($prog_url =='../boulamis_toernooi/'){
	$prog_url   = '../boulamis/';
}

$paths        = "/public_html/".substr($prog_url,3, strlen($prog_url))."images/";

//$paths              = $prog_url;
$toernooi         = $_POST['toernooi'];
//$ftp_server       = $_POST['server'];
$ftp_server       = '81.26.219.37'; 

$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];

$source_file      = $_FILES['userfile']['tmp_name'];
$destination_file = $paths.$_FILES['userfile']['name'];

// verwijder vreemde tekens uit de bestandsnaam, vervang door '_' ivm bug 17 april 2015
$destination_file = $paths.preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $name);

// echo "xxxxxxxxxxxxxxxx".$destination_file;



if ($source_file == ''){
	?>
	<script type="text/javascript">
		alert("Geen bestand geselecteerd via Bladeren/browse !") 
   	window.location.replace('image_gallery.php?toernooi=<?php echo $toernooi;?>');
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
			window.location.replace('image_gallery.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}

// upload the file to the path specified
//echo $destination_file;


$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
 
// check the upload status
if (!$upload) {
	?>
	<script type="text/javascript">
	   	alert("Bij uploaden is er iets fout gegaan!" + '\r\n' + 
	          "Download locatie : <?php echo  $paths; ?>" + '\r\n' +
	          "Source file      : <?php echo  $source_file; ?>")
		window.location.replace('image_gallery.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	
?>
<script type="text/javascript">
		window.location.replace('image_gallery.php?toernooi=<?php echo $toernooi;?>');
</script>