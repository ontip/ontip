<html>
	<Title>PHP Inschrijvigen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
// --></style>
</head>

<body>
 
<?php
include 'mysqli.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email


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

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}

//// Check op rechten

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
$ip        = $_SERVER['REMOTE_ADDR'];  
$email = '';

// kontroleer of op deze PC iemand is aangelogd

$sql      = mysqli_query($con,"SELECT Naam, Email,Email_encrypt FROM namen WHERE  IP_adres_md5 = '".md5($ip)."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select ip check');  
$result   = mysqli_fetch_array( $sql );
$email     = $result['Email'];

if ($email =='[versleuteld]'){
   	$email =  versleutel_string($result['Email_encrypt']);
 }
else {
	$email ='';
}

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Verwijderen toernooi - selectie";
</script> 

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;font-size:9pt;color:blue;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Verwijderen toernooi  <img src='../ontip/images/prullenbak.jpg' width =75 border =0></h3>

<br><br>
<center>
<div STYLE ='font-size: 10pt; background-color:white;color:red;padding:10pt;'><br>Alleen toernooien die gespeeld zijn of waarvan het aantal inschrijvingen gelijk is aan 0 kunnen verwijderd worden.
	<br>
</div>

<FORM action='send_delete_link.php' method='post'>

<table width=60%>
 <tr>
  <td width=50% STYLE ='font-size: 12pt; background-color:white;color:blue ;'>Selecteer een toernooi om te verwijderen </td>
  <td width=30% STYLE ='font-size: 12pt; background-color:white;color:blue ;'>
  	     <select name='Id' STYLE='font-size:12pt;background-color:white;font-family: Courier;'>

<?php

// gebruik maken van hulp tabel omdat de naam van het toernooi niet goed overkomt (in het geval van meerdere woorden)
// maak hulptabel leeg

mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 
$today      = date("Y") ."-".  date("m") . "-".  date("d");

$query = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Distinct Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum' order by Waarde  )" ;
mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 

// Verwijderen van een toernooi mag alleen als een toernooi gespeeld is of het aantal inschrijvingen = 0
// 

$query = "delete from hulp_toernooi where Vereniging = '".$vereniging."'  and Datum > '".$today."'  and
  (select count(*) from inschrijf where inschrijf.Vereniging = '".$vereniging."'  and hulp_toernooi.Toernooi = inschrijf.Toernooi) > 0";
mysqli_query($con,$query) or die ('Fout in schonen deel hulp_toernooi'); 

// selecteer wat over is

$sql        = "SELECT Distinct config.Id,config.Toernooi,config.Waarde, hulp_toernooi.Datum from config,hulp_toernooi 
               where config.Vereniging        = '".$vereniging."'
                 and config.Variabele         = 'toernooi_voluit' 
                 and hulp_toernooi.Toernooi   = config.Toernooi 
                 and hulp_toernooi.Vereniging = config.Vereniging order by hulp_toernooi.Datum  ";
//echo $sql;
$namen      = mysqli_query($con,$sql);

echo "<option value='' selected>Selecteer uit de lijst...</option>"; 

 while($row = mysqli_fetch_array( $namen )) {
 	$var = substr($row['Datum'],0,10);
	echo "<OPTION  value=".$row['Id']."><keuze>";
    	  echo $var . " - ". $row['Toernooi'];
    	  echo "</keuze></OPTION>";	
} 
?>
</SELECT></label>
</td>
<td STYLE ='font-size: 10pt; background-color:white;color:orange ;'><INPUT type='submit' value='Selecteren'></td>
<td width=700 STYLE ='font-size: 15pt; background-color:white;color:orange ;text-align:right;'></td>
</tr>
<tr>
	<td STYLE ='font-size: 12pt; background-color:white;color:blue ;'>Wat moet er verwijderd worden :</td>
 	<td STYLE ='background-color:white;color:blue;font-size: 12pt;'><label><input type='radio'   name='keuze' Value='2' checked /></label>Alleen inschrijvingen</td></tr>
 <tr><td></td>
	<td STYLE ='background-color:white;color:blue;font-size: 12pt;'><label><input type='radio'   name='keuze' Value='1'  /></label>Configuratie en Inschrijvingen</td></tr>
</tr>
<tr>
	<td STYLE ='font-size: 12pt; background-color:white;color:blue ;'>Email voor bevestiging verwijderen</td>
	<td><input type= 'email' name = 'email'   value = '<?php echo $email;?>' size = 25>
<?php

// email adres is van persoon die is aangelogd   (aangepast 12-1-2016, voorheen uit cookie)

?>
	
<tr>
	<td colspan =3 STYLE ='font-size: 10pt; background-color:white;color:black;'><br>Nadat een toernooi geselecteerd is, 
		wordt er een mail ter bevestiging gestuurd naar de organisatie <b>(<?php echo $email; ?>).</b> <br>
		In de mail staat dan een link waarop u moet klikken om het geselecteerde toernooi daadwerkelijk te verwijderen. 
		Dit is gedaan ter bescherming van de gebruiker en om onbevoegden het verwijderen van gegevens moeilijker te maken. 
		<br>
		Het verwijderen moet gebeuren binnen een half uur na verzending van de mail.
		
	</td>
</table>
</form>
</div>
</center>

</body>
</html>