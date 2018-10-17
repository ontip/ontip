<html
<head>
<title>Kleuren codes </title>
<style type="text/css">
	
	body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}
td {color:brown;font-size: 10pt;background-color:white;}
a    {text-decoration:none;color:blue;}
td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }
</style>

</head>

<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Database gegevens. 
include('mysql.php');

$replace = "key=KL&toernooi=".$_GET['toernooi']."";

if(!isset($_COOKIE['aangelogd'])){ 
 ?>
       <script language="javascript">
		         window.location.replace('aanlog.php?<?php echo $replace; ?>');
       </script>
      <?php
}
$toernooi = $_GET['toernooi'];

if (isset($toernooi)) {
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

//echo "SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ";


// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 //echo $var;
	 
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	};

$qry  = mysql_query("SELECT * From kleuren order by Kleurcode")     or die(' Fout in select');  

/// Ophalen tekst kleur

if (!isset ($achtergrond_kleur)){$achtergond_kleur= '#FFFFFF';};


$qry2  = mysql_query("SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  

$row2        = mysql_fetch_array( $qry2 );
$tekstkleur = $row2['Tekstkleur'];
$koptekst   = $row2['Koptekst'];
?>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;font-size:9pt;'><a href='beheer_ontip.php?toernooi=<?php echo $toernooi;?>'>Terug naar Configuratie</a></td></span><br>


	<table border =0 width=95%><tr>
		<td><h3 style='padding:10pt;font-size:20pt;color:green;'>Kleuren palet voor <?php echo $toernooi_voluit;?></h3></td>
		<td text-align = 'right' ><img src='../ontip/images/pallet.jpg' width=120 border =0>
			</tr>
</table>

<h4 style='color:brown;font-size:11pt;font-family:verdana;'>Kies een kleurcombinatie uit deze tabel</h4>

	<div style='color:black;font-size:9pt;font-family:arial;'>Deze kleur combinatie (tekstkleur en achtergrond) wordt gebruikt in het inschrijf formulier. Selecteer de kleur van je keuze. Klik daarna op 'Keuze bevestigen'. De kleurcode wordt hiermee direct overgenomen in het inschrijf formulier en de configuratie ervan. Zit uw kleur combinatie er niet tussen ? Stuur dan even een verzoek naar de beheerder van OnTip.<br>Na bevestigen keert u terug in het configuratiescherm.</div><br>

<div Style='font-size:10pt;color:black;text-align:left;font-weight:bold;' width=90%>Huidige kleurcombinatie : <span style='background-color:<?php echo $achtergrond_kleur;?>;padding:2pt;color:<?php echo $tekstkleur;?>;text-transform:uppercase;font-weight:bold;width:80pt;text-align:center;border:1px solid black;'><?php echo $achtergrond_kleur;?></span></div>
<br>
			
		<FORM action='update_config.php' method='post'>
			
			<input type='hidden' name ='Vereniging' value ="<?php echo $vereniging; ?>"/>
			<input type='hidden' name ='Toernooi'   value ="<?php echo $toernooi; ?>"/>
			<input type='hidden' name ='Variabele'  value ="achtergrond_kleur"/>

<center>
	<INPUT type='submit' value='Keuze bevestigen'  style='background-color:red;color:white;'>

<br>	<br>	
<table border =1 style='font-weight:bold;font-size:14pt;text-align:center;'>
<tr>

<?php
$i=1;

while($row = mysql_fetch_array( $qry )) {

$achtergrond_kleur = strtoupper($achtergrond_kleur);
$row['Kleurcode']  = strtoupper($row['Kleurcode']);


?>	
  <?php 
   if ($achtergrond_kleur == $row['Kleurcode'] ){
  ?>
  <td class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'" style='background-color:yellow;'><span style='background-color:<?php echo $row['Kleurcode'];?>;color:<?php echo $row['Tekstkleur'];?>;text-transform:uppercase;width:80pt;text-align:center;'><?php echo $row['Kleurcode'];?></br>
	<span style=' background-color:yellow;color:red;text-transform:capitalize;font-size:10pt;font-weight:bold;'>Selecteer <input type ='radio' checked name ='Waarde' value ='<?php echo strtoupper($row['Kleurcode']); ?>'></span><br></td>
<?php  } else { ?>
  <td class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'" ><span style='background-color:<?php echo $row['Kleurcode'];?>;color:<?php echo $row['Tekstkleur'];?>;text-transform:uppercase;width:80pt;text-align:center;'><?php echo $row['Kleurcode'];?></br>
  <span style=' background-color:white;color:blue;text-transform:capitalize;font-size:10pt;'>Selecteer <input type ='radio'  name ='Waarde' value ='<?php echo strtoupper($row['Kleurcode']); ?>'></span><br></td>
<?php } ?>


<?php if($i==10) {
	echo "</tr><tr>";
	$i=0;
}
$i++;
} // end while
?>	

</tr></table>
<br>

	<INPUT type='submit' value='Keuze bevestigen'  style='background-color:red;color:white;'>
</center> 
</form>


</html>