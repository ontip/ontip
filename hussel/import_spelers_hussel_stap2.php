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


include('mysqli.php');
ini_set('display_errors', 0); 
$qry            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysqli_fetch_array( $qry );

// 0123456
// ../naam/

$prog_url = substr($row['Prog_url'],3,-1);
set_time_limit(300);//for setting 

$paths            = "/public_html/".$prog_url."/hussel/csv/";
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
   			window.location.replace('import_spelers_hussel_stap1.php');
</script>
<?php
}

if ($_POST['datum'] == ''){
	?>
	<script type="text/javascript">
		alert("Geen datum ingevoerd !") 
   			window.location.replace('import_spelers_hussel_stap1.php');
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
			window.location.replace('import_spelers_hussel_stap1.php');
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
			window.location.replace('import_spelers_hussel_stap1.php');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	


?>
Bestand is gedownload
<body>
<?php
ob_start();
//include('mysql.php');


//// Database gegevens. 

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'http://www.ontip.nl/boulamis/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";


?>

<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ></a>
</td></tr>
</table>
<br>
<br>
<br>
<h2>Importeer spelers uit csv bestand </h2>

<div style='padding:10pt;font-size:20pt;color:green;'>Kontrole bestand </div>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees bestand en voer kontroles uit

$myFile = 'csv/'. $name;

echo "Check ".$myFile;
echo "<br>Datum : ". $_POST['datum']."<br>";

$fh       = fopen($myFile, 'r');
$line     = fgets($fh);  // skip header 1
$line     = fgets($fh);  
$error   = 0;
$i      = 0;

$datum = $_POST['datum'];


while ( $line <> ''){

$message = '';
$count = 0;
	
//  Nr;Naam
$parts = explode (";", $line);


$nr             =   $parts[0];
$naam           =   $parts[1];

if ($naam !=''){
$sql            = mysqli_query($con,"SELECT count(*) as Aantal  From  hussel_scorewhere Vereniging_id = ".$vereniging_id." and Naam ='".$naam."' and Datum = '".$datum."'   " );
$row            = mysqli_fetch_array( $sql);
$count          = $row['Aantal'];	


if ($count > 0){
	echo "** ". $naam." is al bekend in de spelerslijst en wordt niet toegevoegd.<br>";
	
} 

else {
echo "** ". $naam." wordt toegevoegd.<br>";
/// Voeg toe aan hussel spelers

$query="INSERT INTO hussel_score (Id, Vereniging, Vereniging_id,Datum, Naam) VALUES (0,'".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' )";   

mysqli_query($con,$query) or die(' Fout in insert speler');  
$i++;
}
}


$line     = fgets($fh);


}// end while
fclose($fh);
?>
<br>
<div>
Er zijn  <?php echo $i;?> spelers toegevoegd.
</div>

</body>