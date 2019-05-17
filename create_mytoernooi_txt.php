<html>
<head>
<title>Aanmaak mytoernooi.txt file</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

</head>
<body>

<?php

include('mysqli.php');
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
$spaties = '                                                                                ';

//$spaties = '-------------------------------------------------------------------------------';

$toernooi            = $_GET['toernooi'];
$txt_file            = "csv/cfg_". trim($toernooi).".txt";

$fp = fopen($txt_file, "w");
fclose($fp);
$fp = fopen($txt_file, "a");

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' order by Variabele")     or die(' Fout in select config');  
	$j=0;
while($row = mysqli_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	 $param = $var.$spaties;
	 $line = "$".substr($param,0,45)." = ".$$var;
	 
	 fwrite($fp, $line."\n");
	//echo "<span style='font-family: courier;'>".$line. "</span><br>";
	$j++;
}; // end while lezen
fclose($fp);
} // end if

echo "<br>File ".$txt_file. " is aangemaakt met de instellingen (".$j." regels) van ". $toernooi;
 ?>
 <br><br>
 <a href = "index.php" >Klik hier om terug te gaan naar hoofdmenu.
</body>
</html>
