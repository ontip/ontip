<?php

# import_Excel_voucher_codes_stap2.php
# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 10mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

include('mysqli.php');

$paths            = "/public_html/".substr($prog_url,3, strlen($prog_url))."csv/";
$paths            = "/public_html/ontip/xlsx/";

$test             = 'N';
$aantal_kopregels = $_POST['aantal_kopregels'];
$kolom_code       = $_POST['kolom_code'];
$toernooi         = $_POST['toernooi'];
$datum            = $_POST['datum'];
$check            = $_POST['Check'];

if (isset($_POST['Test'])){
  $test             = "J";
	$aantal_kopregels = '0';
	$kolom_code       = 'A';
	$check            = 'N';
}

$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];

$timest           = date('Ymdhis');
$destination_file = $paths.'import_voucher_codes_'.$toernooi.'_'.$timest.'.xlsx';

if ($name  == '')
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen bestand geselecteerd !")
		  window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}


if ($aantal_kopregels  == '' )
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen kopregels geselecteerd !")
		  window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}

if ($kolom_code  == '')
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen kolom voor de codes geselecteerd !")
		  window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}

if ($check  == '')
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen keuze voor toevoegen of verwijderen geselecteerd !")
		  window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
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
		 	window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}

// upload the file to the path specified

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_ASCII);
 
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
		  window.location.replace('import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	

//////////////////////////////////////////////////////////////////////////////////////////////

if ($error == 0){

$xlsx_file = "../ontip/xlsx/".'import_voucher_codes_'.$toernooi.'_'.$timest.'.xlsx';

if ($test =='J'){
  include('import_Excel_voucher_codes_test.php');
} else {
  include('import_Excel_voucher_codes_stap3.php');
}


}?>
