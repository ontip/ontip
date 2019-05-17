<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///// delete_inschrijving_stap1.php
/////
/////  Programma om het verwijderen van een inschrijving door de inschrijver te initieren.
/////  Dit programma wordt gestart vanuit een mail link met als GET parameters: Toernooi en Kenmerk
/////  Deze mail link is toegevoegd aan de mail m.b.v send_inschrijf.php
/////  delete_inschrijving.php laat een keuze scherm aan de gebruiker zien met de keuzes om de inschrijving wel of niet in te trekken.
/////  Dit is gedaan om te voorkomen dat een verwijdering wordt geinitieerd terwijl de gebruiker dit per ongeluk startte.
/////  Daarna wordt de inschrijving direct verwijderd.
/////  Als laatste stuurt dit programma een mail naar de organisatie een bevestiging van het verwijderen.De vezender is in principe de Email van de inschrijver.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>
	
	<?php
ob_start();

// Database gegevens. 
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

setlocale(LC_ALL, 'nl_NL');

$toernooi  = $_GET['toernooi'];
$kenmerk   = $_GET['kenmerk'];


$qry           = mysqli_query($con,"SELECT * from inschrijf where Toernooi = '".$toernooi."' and Kenmerk  ='".$kenmerk."'")     or die(' Fout in select record met kenmerk' ); 
$result        = mysqli_fetch_array( $qry );
$id            = $result['Id'];
$email_sender  = $result['Email'];
$Email_encrypt = $result['Email_encrypt'];
$_status       = $result['Status'];
$count         = mysqli_num_rows($qry);

if ($count == 0){
 
  ?>
   <script language="javascript">
        alert("De inschrijving kon niet gevonden worden of is al verwijderd."+ '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		 <script type="text/javascript">
		  history.back();
	  </script>
	</script>
<?php
 } 
 else {

//echo "<FORM action='https://www.ontip.nl/".substr($prog_url,3)."action.php' method='post'>";
echo "<FORM action='https://www.ontip.nl/".substr($prog_url,3)."delete_one_inschrijving_stap2.php' method='post'>";

?>
<input type='hidden' name = 'toernooi' value ='<?php echo $toernooi; ?>'  />
<input type='hidden' name = 'kenmerk'  value ='<?php echo $kenmerk;?>'  />
<input type='hidden' name = 'id'       value ='<?php echo $id;?>'  />

<?php
// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 
	
$dag                =	substr ($datum , 8,2);         
$maand              =	substr ($datum , 5,2);         
$jaar               =	substr ($datum , 0,4);         

echo  "<table>"   . "\r\n";
echo "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";
echo  "<td style= 'font-family:verdana;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
echo  "</table>"   . "\r\n";
echo  "<br><hr/>".   "\r\n";


echo "<br><div style= 'font-family:Verdana;font-size:12pt;color:black;'><u>Intrekken inschrijving</u>.</div></br>";

echo "<div style= 'font-family:Verdana;font-size:10pt;color:black;'>Door te klikken op de link in de bevestiging heeft U aangegeven uw inschrijving voor bovengenoemd toernooi te willen intrekken.<br>Maak een keuze door een van beide onderstaande regels te selecteren en klik op de knop :</div><br>";

echo "<div style= 'font-family:Verdana;font-size:10pt;color:black;'>"; 
echo "<INPUT type='radio' NAME='bevestiging'   value = 'Ja'  />Ja, ik wil inderdaad mijn inschrijving intrekken.<br>";
if ($_status  == 'IN2' or $_status  == 'RE4'  or $_status  ==  'BED' or $_status  == 'BEE'){
echo "<table width=60%><tr>  
      <td Style='font-family:Arial;font-size:9pt;color:green;'>
      <label><input type='checkbox' name='Check' unchecked> Bevestiging van intrekken via SMS naar bericht naar <b>".$result['Telefoon']."</b></label></td>
      </tr></table>";
}

echo "<INPUT type='radio' NAME='bevestiging'   value = 'Nee' />Nee, ik wil mijn inschrijving niet intrekken.<br></div><br>";

echo "<div style= 'font-family:Verdana;font-size:10pt;color:black;'>Bij 'Ja' zal de inschrijving DIRECT verwijderd worden. Er wordt een mail naar de organisatie (".$email_organisatie.") gestuurd.</div><br>";


echo "<INPUT type='submit'  value = 'Verzenden keuze'/>";


echo "</form>";



} // al verwijderd


ob_end_flush();
?>
</body>
</html>