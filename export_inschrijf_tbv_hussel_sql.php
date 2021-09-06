<?php
//// lijst_export_inschrijf_xlsx.php  (c) Erik Hendrikx 2017
//// Maakt een  sql impoty bestand met de inschrijvingen voor een toernooi.
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
	<head>
		<title>OnTip export inschrijvingen</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<?php
$toernooi = $_GET['toernooi'];

// Database gegevens. 
include('mysqli.php');

setlocale(LC_ALL, 'nl_NL');

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
// Ophalen toernooi gegevens
if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
		exit;
		
};
?>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanmaak excel export voor "<?php echo $toernooi_voluit;?>"</h3>
<br>

<div > Er wordt een bestand aangemaakt met sql insert commandos </div>
<?php


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}     



if (isset($toernooi)) {
	// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];
$prog_url = $result['Prog_url'];


$timest  = date('Ymd_Hi');


  // write log file
   $log = "hussel/xlsx/insert_hussel_".$toernooi."_". $timest.".txt";
  echo $log;

  
   if (!file_exists($log)){
   $fp      = fopen($log, "w");
   $myfile  = fopen($log, "a") or die("Unable to open file!");
    fclose($fp);
   }
   
   $myfile = fopen($log, "a") or die("Unable to open file!");
  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Detail regels Excel
//// SQL Queries

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer " )    or die(mysql_error());  

$i=1;

while($row = mysqli_fetch_array( $spelers )) {
$j=$i+2;
if ($soort_inschrijving =='single' or $inschrijf_methode =='single' ){
    $line ="INSERT into hussel_score  (Vereniging,Vereniging_id,Datum,Ronde,Naam )  
                         VALUES ('".$vereniging."',".$vereniging_id.", '".$datum."',0,'".$row['Naam1']."' );";
   }
  
 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	 $line ="INSERT into hussel_score  (Vereniging,Vereniging_id,Datum,Ronde,Naam )  
                         VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."',0,'".$row['Naam1']. " - ".$row['Naam2']."' );";
	 
}


// Max 2 namen per cell   


  fwrite($myfile, $line."\r\n");
  	
 
   
$i++;
};

 fclose($myfile);	
 
} // end if 

?>
<a href = '<?php echo $myfile;?>' target = '_blank'><br>Aangemaakt op <?php echo $timest;?>.<br>Klik hier voor bestand '<?php echo $log;?>'</a> 
</blockquote>
</body>
</html>