<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:blue;font-size: 8pt;}
td {color:blue;font-size: 10pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}


#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}
#onderschrift     {font-size:8pt;color:blue;text-align:center;padding:0pt;}

</style>
</head>
<body>

<?php
ob_start();
include 'mysql.php'; 


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


if ($jaar <> date('Y') ){
	$datum_string = strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
} else {
	$datum_string = strftime("%A %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );
}	

echo "<table width=80%>";
echo "<tr>";
echo "<td>";

echo "<a href = 'index.php'><img src = 'images/OnTip_hussel.png' width='200'></a>";
echo"<br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>";


if ($voorgeloot == 'On') {
	
$qry                 = mysql_query("SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'voorgeloot'  ") ;  
$result              = mysql_fetch_array( $qry);
$toernooi            = $result['Parameters'];	

echo $toernooi . " ". $datum_string."</h1></td>";
} else {
echo "Hussel ". $datum_string."</h1></td>";
}
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table width=60%>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ><br>Terug naar score</a>
</td>
<td style='text-align:center;'>
	<h2>Aanpassen instellingen</h2>
	</td></tr>
</table>

<?php 
echo "<tr>";

	$qry  = mysql_query("SELECT * From hussel_config where Vereniging_id = ".$vereniging_id ." and Variabele ='datum_lock' ")     or die(' Fout in select');  
	$result     = mysql_fetch_array( $qry );
	$datum_lock =  $result['Waarde']; 

if ($datum_lock == 'On'){	
	$datum   = $result['Parameters'];
} else {
   $datum = date ('Y')."-".date('m')."-".date('d');
}
$vandaag = date ('Y')."-".date('m')."-".date('d');

?>
<table width=80%    border = 1 cellspacing = 0 cellpadding=0>
	<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";
if ($aantal_rondes == 2){
echo "<img src='images/2rondes.png' height=40><br>rondes";
}

if ($aantal_rondes == 3){
echo "<img src='images/3rondes.png' height=40><br>rondes";
}

if ($aantal_rondes == 5){
echo "<img src='images/5rondes.png' height=40><br>rondes";
}



echo "</td>";
echo "<td  style='text-align:bottom;'><form action='muteer_rondes.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan het aantal spelrondes aangepast worden. Zet een vinkje bij de gewenste keuze klik op de knop.</span><br><br>";

?>
<table  width=90%>
	<tr>
		<td>
<?php

if ($aantal_rondes  == 2) {
	 echo "<input type='radio'              name='aantal_rondes' value='2'  checked /> Aantal rondes : 2";
	 echo "<br><input type='radio'          name='aantal_rondes' value='5'           /> Aantal rondes : 3";
	 echo "<br><input type='radio'          name='aantal_rondes' value='5'           /> Aantal rondes : 5";
}

if ($aantal_rondes  == 3) {
	  echo "<input type='radio'  name='aantal_rondes' value='2'         /> Aantal rondes : 2";
	  echo "<br><input type='radio'  name='aantal_rondes' value='3'  checked /> Aantal rondes : 3";
	 echo "<br><input type='radio'          name='aantal_rondes' value='5'   /> Aantal rondes : 5";
}
if ($aantal_rondes  == 5) {
	  echo "<input type='radio'  name='aantal_rondes' value='2'         /> Aantal rondes : 2";
	  echo "<br><input type='radio'  name='aantal_rondes' value='3'  /> Aantal rondes : 3";
	 echo "<br><input type='radio'          name='aantal_rondes' value='5'  checked  /> Aantal rondes : 5";
}

	echo "<br><br><INPUT type='submit' value='Aanpassen'>";

echo "</form>";
?>
</td>
<td style='vertical-align:top;'>
	<?php
	echo "<form action='muteer_verwijder_spelers.php' method='post'>"; 
	 if ($verwijderen_spelers =='On'){?>
     	   <input type='checkbox'  name='verwijder_spelers' value='On' checked  />Mogelijkheid om spelers te verwijderen die niet alle rondes spelen. Deze kunnen dan tussentijds verwijderd worden via kolom Beperkt.
     	<?php    } else { ?>
     	   <input type='checkbox'  name='verwijder_spelers' value='Off'   />Mogelijkheid om spelers te verwijderen die niet alle rondes spelen.Deze kunnen dan tussentijds verwijderd worden via kolom Beperkt.
     	<?php    } 
     	echo "<br><br><br><INPUT type='submit' value='Aanpassen'>";

echo "</form>";
?>
</td>
</tr>
</table>
<?php

echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'>";
echo "<td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;'><img src='images/datum.png' height=40><br>Datum vastzetten</td>";
echo "<td  style='text-align:bottom;'><form action='muteer_datum.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan de datum van de hussel aangepast worden (standaard gelijk aan vandaag)<br> Zet een vinkje bij de gewenste keuze, vul evt een afwijkende datum in en klik op de knop.</span><br><br>";


if ($datum_lock == 'On') {
	echo "<input type='radio'  name='lock' value='0'   /> Gelijk aan ".$vandaag." (vandaag, vervolgens automatisch aangepast) .";
  echo "<br><br><input type='radio'  name='lock' value='1'  checked /> Gelijk aan .";
	echo "<input name='datum' type='text' size=10 value='".$datum."' > ";
  echo "<br><br><INPUT type='submit' value='De-activeren'>";
}
else {
  	echo "<input type='radio'  name='lock' value='0' checked  /> Gelijk aan ".$vandaag." (vandaag, vervolgens automatisch aangepast) .";
    echo "<br><br><input type='radio'  name='lock' value='1' /> ";
  	echo "Vaste waarde :  <input name='datum' type='text' size=10 value='".$datum."' > (formaat :  jjjj-mm-dd bijv 2015-09-17)";
    echo "<br><br><INPUT type='submit' value='Aanpassen en activeren'> ";
}
echo "</form>";
echo "</td>";
echo "</tr>";
?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";


if ($controle_13 == 'On') {
	//  On = Alleen kontrole op 13
 echo "<img src='images/check13aan.png' height=50><br><br>Controle 13";
}

if ($controle_13 == 'Off') {
	//  Off = mag ook afwijkend van 13 zijn
echo "<img src='images/check13uit.png' height=50><br><br>Controle 13";
}
if ($controle_13=='Auto'){
echo "<img src='images/check13auto.png' height=50><br><br>Controle 13";
}

echo "</td>";


echo "<td  style='text-align:bottom;'><form action='muteer_check13.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan het automatisch invullen en controle van de waarde 13 in de hussel aan of uit gezet worden.Zet een vinkje bij de gewenste keuze klik op de knop.</span><br><br>";


if ($controle_13 == 'Auto') {
	//  auto = Aan en automatische kontrole
  echo "<input type='radio'          name='controle_13' value='Auto'      checked /> Automatisch invullen actief";
  echo "<br><br><input type='radio'  name='controle_13' value='On'                /> Automatisch invullen niet actief maar wel kontrole op 13";
	echo "<br><br><input type='radio'  name='controle_13' value='Off'               /> Automatisch invullen niet actief en geen kontrole op 13";

	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}

if ($controle_13 == 'On') {
	//  On = Alleen kontrole op 13
  echo "<input type='radio'          name='controle_13' value='Auto'          /> Automatisch invullen actief";
  echo "<br><br><input type='radio'  name='controle_13' value='On'  checked   /> Automatisch invullen niet actief maar wel kontrole op 13";
 	echo "<br><br><input type='radio'  name='controle_13' value='Off'           /> Automatisch invullen niet actief en geen kontrole op 13";
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}

if ($controle_13 == 'Off') {
	//  Off = mag ook afwijkend van 13 zijn
	echo "<input type='radio'          name='controle_13' value='Auto'          /> Automatisch invullen actief";
  echo "<br><br><input type='radio'  name='controle_13' value='On'            /> Automatisch invullen niet actief maar wel kontrole op 13";
	echo "<br><br><input type='radio'  name='controle_13' value='Off'  checked  /> Automatisch invullen niet actief en geen kontrole op 13";
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}

echo "</form>";
echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'>";
echo "<td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;'><img src='images/lottery.jpg' height=60></td>";
echo "<td  style='text-align:bottom;'><form action='muteer_voorgeloot.php' method='post'><span style='color:black;font-weight:bold;'>Het programma biedt eventueel de mogelijkheid de nummers van de loting bij te houden. Hiervoor wordt in het hussel scherm een kolom toegevoegd voor de uitgegeven lotnummers.Het programma kan ook de loting verzorgen.<br> Zet een vinkje bij de gewenste keuze en klik op de knop.</span><br><br>";


if ($voorgeloot == 'On') {

	echo "<input type='radio'          name='voorgeloot' value='0'           /> Hussel";
  echo "<br><br><input type='radio'  name='voorgeloot' value='1'  checked />  Hussel met loting of voorgeloot tbv toernooi.";
}
else {
 	echo "<input type='radio'          name='voorgeloot' value='0'  checked /> Hussel";
  echo "<br><br><input type='radio'  name='voorgeloot' value='1'          /> Hussel met loting of voorgeloot tbv toernooi.";
}
echo "<br><br>Vul hier evt toernooi naam in (verschijnt op scherm) <input type=text name='toernooi' size=40 value = '".$toernooi."' >";
echo "<br><br><INPUT type='submit' value='Aanpassen'>";
echo "</form>";
echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";

echo "<img src='images/dice.jpg' height=50><br>Loting";

echo "</td>";

echo "<td  style='text-align:bottom;'><form action='reset_loting.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan de loting gereset worden. Doe dit niet tijdens de hussel of het toernooi. Alle uitgegeven lotnummers verdwijnen.</span><br><br>";



if ($reset_loting == '1') {
	//  auto = Aan en automatische kontrole
  echo "<input type='radio'          name='reset_loting' value='1'  checked   /> Alle lotnummers worden geschoond. ";
  echo "<br><br><input type='radio'  name='reset_loting' value='2'                /> Lot nummers kunnen handmatig worden ingevoerd of aangepast.";
	echo "<br><br><input type='radio'  name='reset_loting' value='3'                /> Lot nummers kunnen alleen door programma bepaald worden.";

	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}

if ($reset_loting == '2') {
	//  On = Alleen kontrole op 13
  echo "<input type='radio'          name='reset_loting' value='1'          /> Alle lotnummers worden geschoond";                                       
  echo "<br><br><input type='radio'  name='reset_loting' value='2'  checked   /> Lot nummers kunnen handmatig worden ingevoerd of aangepast.";            
 	echo "<br><br><input type='radio'  name='reset_loting' value='3'           /> Lot nummers kunnen alleen door programma bepaald worden.";               
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}

if ($reset_loting == '3') {
	//  Off = mag ook afwijkend van 13 zijn
	echo "<input type='radio'          name='reset_loting' value='1'          /> Alle lotnummers worden geschoond";                                       
  echo "<br><br><input type='radio'  name='reset_loting' value='2'            /> Lot nummers kunnen handmatig worden ingevoerd of aangepast.";            
	echo "<br><br><input type='radio'  name='reset_loting' value='3'  checked  /> Lot nummers kunnen alleen door programma bepaald worden.";               
 
	echo "<br><br><INPUT type='submit' value='Aanpassen'>";
}


echo "</form>";
echo "</td>";
echo "</tr>";

?>

<?php
echo "<tr Style='color:blue;padding-left:2px;padding-right:2pt;'><td Style='text-align:center;color:blue;padding-left:2px;padding-right:2pt;border-top:1pt;font-size:9pt;'>";

if ($blokkeer_invoer =='On'){
echo "<img src='images/icon_input_off.png' height=50><br>Invoer namen";
} else {
echo "<img src='images/icon_input.png' height=50><br>Invoer namen";
}
echo "</td>";

echo "<td  style='text-align:bottom;'><form action='muteer_invoer.php' method='post'><span style='color:black;font-weight:bold;'>Hiermee kan de invoer van namen worden in - en uitgeschakeld. Indien er nog geen spelers zijn geselecteerd of ingevoerd zal de invoer van namen altijd mogelijk zijn.</span><br><br>";


if ($blokkeer_invoer == 'On') {
	
	//   blokkeer_invoer = 1 betekent geen invoer
   echo "<span style='margin-left:15pt; '>Invoer namen is nu uitgeschakeld.</span><br><br>";
   echo "<input type='hidden'          name='blokkeer_invoer' value='Off'                />";
   echo "<INPUT type='submit' value='Inschakelen'>";
}
else {
   echo "<span style='margin-left:15pt; '>Invoer namen is nu ingeschakeld.</span><br><br>";
   echo "<input type='hidden'          name='blokkeer_invoer' value='On'                />";
   echo "<INPUT type='submit' value='Uitschakelen'>";
}
echo "</form>";
echo "</td>";
echo "</tr>";

?>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/hussel_serie.png' height=40><br>Hussel serie</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='beheer_datums_hussel_serie_stap1.php'>Klik hier voor Muteren of Verwijderen datums voor Hussel serie.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/people.png' height=40><br>Aanpassen spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='beheer_spelers.php'>Klik hier voor Muteren of verwijderen Spelers in Tabel Spelers.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/icon_import.png' height=40><br>Importeren spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_spelers_xlsx_stap1.php'>Klik hier voor Importeren namen in Tabel Spelers vanuit Excel(xlsx) file.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/icon_import.png' height=40><br>Importeren spelers</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_spelers_hussel_xlsx_stap1.php'>Klik hier voor Importeren namen direct in Score pagina vanuit Excel(xlsx) file.</a>
</td>
</tr>


<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/upload_ontip.png' height=40><br>Importeren OnTip</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_spelers_ontip_stap1.php'>Klik hier voor Importeren namen in Tabel Spelers vanuit OnTip toernooi.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/prullenbak.jpg' height=40><br>Verwijderen hussels</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='verwijder_hussels_stap1.php'>Klik hier voor verwijderen oude hussels.</a>
</td>
</tr>

<tr Style='color:blue;padding-left:2px;padding-right:2pt;height:50pt;'>
	  <td Style='text-align:center;color:blue;padding-left:8px;padding-right:2pt;border-top:1pt;font-size:9pt;'><img src='images/upload_pdf.png' height=40><br>Baan schema's</td>
    <td><a style='padding-left:8px;color:black;font-weight:bold;font-size:10pt;' href='import_pdf_schemas_stap1.php'>Klik hier voor Uploaden van PDF schema tbv baan toewijzing.</a>
    <br><form action='muteer_baanschema.php' method='post'>
    	<?php
    	$qry                = mysql_query("SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'baan_schemas'  ") ;  
      $result             = mysql_fetch_array( $qry);
      $min_aantal         = $result['Parameters'];
      $baan_schema        = $result['Waarde'];
      if ($min_aantal =='') {
      	$min_aantal =  12;
      }
      
      ?>
    <div style= 'margin-left:5pt;'>
    <br>
     <?php 
if ($baan_schema == 'On') {
  
   echo "Baanschemas aanmaken is nu ingeschakeld.<br><span style='font-size:8pt;color:black;'><i>Als het aangegeven minimum aantal spelers is bereikt, verschijnt het icoontje om de schema's te kunnen printen. Via de loting (klik op dobbelsteen) worden de nummers van de deelnemers bepaald.</i></span><br><br>";
   echo "<input type='hidden'          name='baan_schema' value='0'                />";
   echo "<INPUT type='submit' value='Uitschakelen'>";
}
else {
   echo "Baanschemas aanmaken is nu uitgeschakeld.<br>";
   echo "<input type='hidden'          name='baan_schema' value='1'                />";
   echo "<INPUT type='submit' value='Inschakelen'>";
}   
    
  ?>
     	
    <br> Minimaal aantal deelnemers voor een baan toewijzing (min 12, max 65) : <input type='text'  name ='min_aantal' size =3  value = '<?php echo $min_aantal; ?>'> 
    <INPUT type='submit' value='Aanpassen'>  <b>Let op ! Hussel met loting moet 'aan'  staan.</b>
  </form></div>
    	
</td>
</tr>
<!--tr>
<td colspan =2><img src='images/dbase.jpg' width='50'><a href='delete_hussel.php'>Verwijder hussels ouder dan 1 jaar.</a>
</td>
</tr-->

</table>

</body>
</html>

