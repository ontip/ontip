<html
<head>
<title>Upload excel csv</title>
<link rel="shortcut icon" type="image/x-icon" href="images/njbb_logo.ico">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<style type="text/css">
	body {color:black;font-size:9pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}
a    {text-decoration:none ;color:blue;}

td {color:blue;font-size: 9pt;background-color:white;}

.tab {text-align:left;color:black;font-size:10pt;font-family:arial;}


</style>
</head>
<?php

// Database gegevens voor username en password
include('mysql.php');
ini_set('display_errors', 0); 
$qry            = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysql_fetch_array( $qry );

// 0123456
// ../naam/
$aantal = $_POST['aantal'];

if ($aantal =='') {
	?>
	<script type="text/javascript">
	   	alert("Er is geen aantal deelnemers opgegeven")
			window.location.replace('import_pdf_schemas_stap1.php');
</script>
<?php
}


$prog_url = substr($row['Prog_url'],3,-1);
set_time_limit(300);//for setting 

$paths            = "/public_html/".$prog_url."/hussel/pdf/";
$ftp_server       = $_POST['server'];
$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$destination_file = $paths.$aantal."_deelnemers.pdf";

if ($source_file == ''){
	?>
	<script type="text/javascript">
		alert("Geen bestand geselecteerd via Bladeren/browse !") 
   			window.location.replace('import_pdf_schemas_stap1.php');
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
			window.location.replace('import_pdf_schemas_stap1.php');
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
			window.location.replace('import_pdf_schemas_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	


?>
Bestand is gedownload
<script language="javascript">
		window.location.replace('import_pdf_schemas_stap1.php');
</script>
