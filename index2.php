<html>
	<Title>PHP Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:#990000; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:orange ; font-size: 15.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
</head>

<body>
 
<?php
include 'mysql.php'; 

if(isset($_COOKIE['toernooi'])){ 
  	
$toernooi        = $_COOKIE['toernooi'];   
  
}
// maak hulptabel leeg

mysql_query("Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 
$today      = date("Y") ."-".  date("m") . "-".  date("d");
$query = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Distinct Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum' order by Waarde  )" ;
mysql_query($query) or die ('Fout in vullen hulp_toernooi'); 

$sql        = "SELECT Distinct config.Id,config.Toernooi,config.Waarde, hulp_toernooi.Datum from config,hulp_toernooi where config.Vereniging = '".$vereniging."'
                and config.Variabele ='toernooi_voluit' and hulp_toernooi.Toernooi = config.Toernooi  order by hulp_toernooi.Datum  ";
///echo $sql;
$namen      = mysql_query($sql);

// ---------------------------------------------------------------------------------------------------------------------------------------------------
//echo  "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx  vereniging : ". $vereniging;

?>

<div style='border: red solid 1px;background-color:#990000;'>

<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>

</tr>
	<?php if (isset($toernooi)){ ?>
<td STYLE ='font size: 20pt; background-color:#990000;color:white ;'> <?php echo $toernooi; ?>  (<?php echo $datum; ?>) <?php echo $extra_koptekst; ?>  </TD></tr>
<?php } else { ?>
<td STYLE ='font size: 20pt; background-color:#990000;color:white ;'> onbekend</TD></tr>
<?php }?>

<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
<td rowspan=3 style='text-align:right;'><img src = 'images/boules.jpg' width=100></td>
</TR>
</TABLE>
</div>
<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>

<table width=98% border =0>
<td width=30%><br><h1>Menu</h1></td>
<td STYLE ='font size: 20pt; background-color:#990000;color:orange;'><br><h2><center><a href="contact.php">Contact</a></center></h2></td>
<td align=right><a href='http://www.boulamis.nl/boulamis_toernooi/pdf/Handleiding.pdf'>HANDLEIDING</a>
</td>
</table>
		
	
<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<FORM action='select_toernooi.php' method='post'>
<table width=90% border=0>
 <tr>
<?php	if (!isset($toernooi)){ ?>
  <td width='1150' STYLE ='font size: 15pt; background-color:#990000;color:orange ;'>Selecteer een toernooi <font color = white> <?php echo $toernooi;?></font> </td>
<?php } else { ?>
<td width='1050' STYLE ='font size: 15pt; background-color:#990000;color:orange ;'>Selecteer een toernooi of gebruik<br><font color = white> <?php echo $toernooi;?></font> </td>
<?php   }?>

  <td width='550' STYLE ='font size: 15pt; background-color:#990000;color:orange ;'><select name='Id' STYLE='font-size:12pt;background-color:white;font-family: Courier;width:500px;'>

<?php


echo "<option value='' selected>Selecteer uit de lijst.....</option>"; 

 while($row = mysql_fetch_array( $namen )) {
 	$var = substr($row['Datum'],0,10);
	echo "<OPTION  value=".$row['Id']."><keuze>";
    	  echo $var . " - ". $row['Toernooi'];
    	  echo "</keuze></OPTION>";	
} 
?>
</SELECT></label>
</td>
<td STYLE ='font size: 10pt; background-color:#990000;color:orange ;'><INPUT type='submit' value='Ophalen'></td>
<td width=750 STYLE ='font size: 15pt; background-color:#990000;color:orange ;text-align:right;'>
	<a href= "toevoegen_toernooi_stap1.php?key=T">Toevoegen toernooi (beveiligd)</a><br/>
	<a href= "select_verwijderen.php?key=V">Verwijderen toernooi (beveiligd)</a></td>
	</tr>
</table>
</form>
</div>
<?php if (isset($toernooi)){ ?>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= "Inschrijfform.php?toernooi=<?php echo $toernooi; ?>">Inschrijfformulier</a>
</div>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= "toernooi_all.php">Index pagina alle actieve toernooien</a>
</div>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= "lijst_inschrijf.php?key=L&toernooi=<?php echo $toernooi; ?>">Uitgebreide lijst (beveiligd)</a>
</div>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= 'lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>'>Verkorte lijst</a>
</div>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= 'toernooi_schema.php?toernooi=<?php echo $toernooi; ?>'>Toernooi schema voorgeloot</a>
</div>

<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= "beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>">Muteren inschrijvingen (beveiligd)</a>
</div>
<div style='color:yellow;'>
	
<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<a href= "beheer_config.php?toernooi=<?php echo $toernooi; ?>">Beheer configuratie bestand (beveiligd)</a></div>
	
<div style='border:inset white solid 1px;margin:18pt;font size: 14pt;padding:12pt;'>
<table width=90%>
	<tr>
		<td width=30% style='font size: 12pt;background-color:#990000;'><a href= "select_user.php?toernooi=<?php echo $toernooi; ?>">Opvragen wachtwoord beheerder<br>(via mail)</a></td>
		<td width=40% style='font size: 12pt;background-color:#990000;text-align:center;'><a href= "toevoegen_user_stap1.php">Toevoegen beheerder</a></td>
		<td  style='font size: 12pt;background-color:#990000;text-align:right;'><a href= "change_password.php">Wijzigen wachtwoord beheerder<br>(via mail)</a></td>
	</tr>
</table>
</div>
	

<?php
}// end if isset 
if(isset($_COOKIE['aangelogd'])){ 
  	
$cookie_vars = explode(";", $_COOKIE['aangelogd']);   	
		
echo "Laatst aangelogd : <font color=white> " . $cookie_vars[1]. "</font>";
}

?>
</div>


</body>
</html>
