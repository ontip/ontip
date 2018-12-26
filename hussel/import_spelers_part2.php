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
////  import_NJBB_toernooi_kalender_csv_stap2.php  (c) Erik Hendrikx 2012 ev
////
////  Opmaak Excel (csv)
////
////  Datum;Naam toernooi;Vereniging;Lokatie/adres;Plaats;Tel locatie;Tel_Inschrijving;Inschr. tot;Lic/cat;Soort;Min;Max;Systeem;Kosten;Prijzen;Aanv;Email;URL
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysql.php');
ini_set('display_errors', 0); 

set_time_limit(300);//for setting 

$parts            = explode("/", $prog_url);
$paths            = "/public_html/njbb/csv/";
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
   			window.location.replace('import_NJBB_toernooi_kalender_stap1.php');
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
			window.location.replace('import_NJBB_toernooi_kalender_stap1.php');
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
			window.location.replace('import_NJBB_toernooi_kalender_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	


?>


<body>
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);


//// Database gegevens. 

include ('mysql.php');


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<h2>Importeer spelers uit csv bestand </h2>

<div style='padding:10pt;font-size:20pt;color:green;'><br>Kontrole bestand </div>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees bestand en voer kontroles uit

$myFile = 'csv/'. $name;

echo "Check ".$myFile;

$fh       = fopen($myFile, 'r');
$line     = fgets($fh);  // skip header 1


$error   = 0;
$i= 0;



while ( $line <> ''){

$message = '';

if (substr($line,0,2) != ';;' and $error < 2){
	
 //echo $line. "<br>";

$i++;

if ($error < 2){
$error   = 0;
}

//  Nr;Naam
$parts = explode (";", $line);


$nr             =   $parts[0];
$naam            =   $parts[1];


$spelers      = mysql_query("SELECT Id,Naam From  hussel_spelers where Vereniging_id = ".$vereniging_id." and Naam ='".$naam."'   " )    or die(mysql_error());  
$count         = mysql_num_rows($spelers);	

if ($count > 0){
	echo "** ". $naam." is al bekend in de spelerslijst en wordt niet toegevoegd.<br<>";
	
} else {

/// Voeg toe aan hussel spelers
$query="INSERT INTO hussel_spelers (Id, Vereniging, Vereniging_id,Naam) VALUES (0,'".$vereniging."',".$vereniging_id.",'".$naam."' )";   
mysql_query($query) or die(' Fout in insert speler');  
}

$line     = fgets($fh);


}// end while
