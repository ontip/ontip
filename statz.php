<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Statistieken inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;}
th   {color:blue;font-size:9pt;font-family: sans-serif;font-weight:bold;;background-color:white;border-color:black;}
td   {color:black;font-size:9pt;font-family: sans-serif;background-color:white;border-color:black;padding:2pt;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
</style>
<?php include ("js/javalib.php"); ?> 
	
<script language="javascript">AC_FL_RunContent = 0;</script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="../ontip/js/AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
var requiredMajorVersion = 9;
var requiredMinorVersion = 0;
var requiredRevision = 45;
-->
</script>
</head>

<script type="text/javascript">
	
function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>
</head>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx &#169 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>
 
<?php 
// Database gegevens. 

include('mysql.php');
if (isset($_COOKIE['_month'])){
 $select_month  = $_COOKIE['_month'];
 $select_year   = $_COOKIE['_year'];
 } else {
   $select_month  = date('m');
   $select_year   = date('Y');
 }	

 $curr_month   = date('m');
 $curr_year    = date('Y');
 
setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  group by 2 order by 2");
     
$aantal  = array();
$i=1;
for ($month=1;$month<13;$month++){
      $result             = mysql_fetch_array( $sql );
      $aantal[$month]     = $result['Aantal'];
} /// end for          

ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
	
	$qry     = mysql_query("SELECT Distinct Vereniging,Plaats from namen where Plaats <> '' order by Vereniging   ")     or die(' Fout in select namen');  
	$qry1    = mysql_query("SELECT Distinct Vereniging, Toernooi From config  order by Vereniging, Toernooi ")           or die(' Fout in select');  
  $qry2    = mysql_query("SELECT Vereniging, Toernooi, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf  group by Vereniging, Toernooi order by Laatst desc ")     or die(' Fout in select'); 
  $qry2jk  = mysql_query("SELECT Vereniging, Toernooi, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf_jk  group by Vereniging, Toernooi order by Laatst desc ")     or die(' Fout in select 2jk'); 
  
	$qry3    = mysql_query("SELECT * FROM namen Order by Vereniging");   
	$qry4    = mysql_query("SELECT count(*) as Aantal From inschrijf")     or die(' Fout in select'); 
	$qry4jk  = mysql_query("SELECT count(*) as Aantal From inschrijf_jk")     or die(' Fout in select 4 jk'); 
		
	$result  = mysql_fetch_array( $qry4 );
	
	$totaal_inschrijvingen  = $result['Aantal'];
  $result  = mysql_fetch_array( $qry4jk );
  $totaal_inschrijvingen  = $totaal_inschrijvingen + $result['Aantal'];
  
  $qry5    = mysql_query("SELECT DAY(Inschrijving) as Dag, WEEKDAY(Inschrijving) as Dagnaam, count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."' group by 1 order by 1  ")     or die(' Fout in select namen');  
	
  $qry5_tot    = mysql_query("SELECT count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."'   ")     or die(' Fout in select namen');  
  $result  = mysql_fetch_array( $qry5_tot );
  $totaal_maand  = $result['Aantal'];
    
  $qry6  = mysql_query("SELECT distinct Vereniging, count(*) as Aantal From stats_naam group by Vereniging order by Aantal desc")     or die(' Fout in select 6'); 
  $qry6b = mysql_query("SELECT distinct Vereniging, count(*) as Aantal From stats_naam group by Vereniging order by Aantal desc")     or die(' Fout in select 6'); 
 
 $i=1;
 while($row = mysql_fetch_array( $qry6b )) {
    $_3d_vereniging[$i] = $row['Vereniging'];
    $_3d_aantal[$i]     = $row['Aantal'];
    $i++;
  }
 $totaal_3d = $i;
 
  $qry7  = mysql_query("SELECT count(*) as Aantal From stats_naam")     or die(' Fout in select 7'); 
	$result  = mysql_fetch_array( $qry7 );
  $archief_inschrijvingen  = $result['Aantal'];

	$qry8    = mysql_query("SELECT  Vereniging, count(distinct Toernooi) as Aantal FROM `stats_naam`   group by Vereniging order by 2 desc")     or die(' Fout in select 8'); 
	
	$qry9    = mysql_query("SELECT Naam, Vereniging_speler as Vereniging, count(*) as Aantal FROM `stats_naam` group by 1 order by 3 desc,1 asc limit 10")     or die(' Fout in select 9'); 
	
	$qry10   = mysql_query("SELECT DATE_FORMAT(Laatst,'%d-%m-%Y') as Datum , count(*) as Aantal  from stats_naam group by 1 order by 2 desc limit 10")     or die(' Fout in select 10'); 
	
	$qry11   = mysql_query("SELECT Naam, Vereniging, Laatst from namen where Naam <> 'Erik' order by 3 desc limit 10")     or die(' Fout in select 11'); 
	
	$qry12   = mysql_query("SELECT Naam, Vereniging, Aantal from namen where Naam <> 'Erik' and Aantal > 0 order by 3 desc limit 10")     or die(' Fout in select 12'); 
	
	
// Definieeer variabelen en vul ze met waarde uit tabel

$achtergrond_kleur = 'white';
$today = date('Y-m-d');

?>
<body bgcolor=<?php echo($achtergrond_kleur);?>>
	
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$totaal = 0;
?>

<a name='home'></a>

<table border =0 width=80%>
<tr><td style='background-color:<?php echo $achtergrond_kleur; ?>;' rowspan = 2>
<img src='images/ontip_logo.png' width='300'></td>
<td colspan =4><span style='Font-size:32pt;color:green;'>STATISTIEKEN</span></td></tr>
	<tr>
   <td><a href="#all_inschrijf"    style='font-size:10pt;color:blue;text-decoration:none;'>Inschrijvingen [<?php echo $totaal_inschrijvingen;?>]</a></td>
   <td><a href="#stats_inschrijf"  style='font-size:10pt;color:blue;text-decoration:none;'>Archief  [<?php echo $archief_inschrijvingen;?>]</a></td>
   <td><a href="#all_verenigingen" style='font-size:10pt;color:blue;text-decoration:none;'>Verenigingen [<?php echo mysql_num_rows($qry);?>]</a></td>
   <td><a href="#all_toernooien"   style='font-size:10pt;color:blue;text-decoration:none;'>Toernooien [<?php echo mysql_num_rows($qry1);?>]</a></td>
   <td><a href="#all_gebruikers"   style='font-size:10pt;color:blue;text-decoration:none;'>Gebruikers [<?php echo mysql_num_rows($qry3);?>]</a></td>
   <td><a href="#per_dag"          style='font-size:10pt;color:blue;text-decoration:none;'>Per dag [<?php echo $totaal_maand;?>]</a></td>
   
</tr></table>

<hr color=darkgreen/>

<a name='all_inschrijf'><h1>Alle inschrijvingen (<?php echo $totaal_inschrijvingen;?>)</h1></a>


<table id= 'MyTable2' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
		<th>Datum</th>
		<th>Aantal</th>
		<th>Laatste</th>
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry2 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	$sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ");
	 	//
	 //	echo "SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ";
	 	//echo $sql;
    $result     = mysql_fetch_array( $sql );
    $datum      = $result['Waarde'];
    if ($datum=='') { $datum='onbekend';};
    
   ?>
      <?php
      if ($today > $datum) {
      ?>
	 		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	 	<?php } else {?>
	 		 		<td><?php echo $datum;?></td>
	 	<?php }?>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];
	 		$totaal = $totaal + $row['Aantal'];?>
	 	<td><?php echo $row['Laatst'];?></td>	
	</tr>
 
<?php	 
	$i++; 
};
?>

<!-- /// extra inschrijvingen =--

<?php
$row = mysql_fetch_array( $qry2jk);
?>

    <td style='text-align:right;color:blue;'><?php echo $i;?>.</td>
	 	<td style='color:blue;'><?php echo $row['Vereniging'];?></td>
	 	<td style='color:blue;'><?php echo $row['Toernooi'];?> </td>

<?php

    $sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ");
	 	//
	 //	echo "SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ";
	 	//echo $sql;
    $result     = mysql_fetch_array( $sql );
    $datum      = $result['Waarde'];
    if ($datum=='') { $datum='onbekend';};
    
   ?>
      <?php
      if ($today > $datum) {
      ?>
	 		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	 	<?php } else {?>
	 		 		<td style='color:blue;'><?php echo $datum;?></td>
	 	<?php }?>
	 	<td style='text-align:right;color:blue;'><?php echo $row['Aantal'];
	 		$totaal = $totaal + $row['Aantal'];?>
	 	<td style='color:blue;'><?php echo $row['Laatst'];?></td>	
	</tr>	 	 
-->
<!-- // tot hier extra ----------------------------------------------------->

<tr><td colspan =4>Totaal</td>
	<td style='text-align:right;'><?php echo $totaal_inschrijvingen;?></td><td style='color:white;'>.</td></tr>
</table>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>

<!--- //  meerdere tabellen naast elkaar  ------------------>

<a name='stats_inschrijf'><h1>Archief inschrijvingen </h1></a>

<table width=90% border=0>
	
	</tr>
	<tr>
		<td STYLE="vertical-align: top;">
			 
			 
			 
<table id= 'MyTable3' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Inschrijvingen per vereniging</th>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Aantal<br>personen</th>

	</tr>
<?php
$i      = 1;
$totaal = 0;

while($row = mysql_fetch_array( $qry6 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
<?php   $totaal = $totaal + $row['Aantal']; ?>
  
	</tr>
 
<?php	 
	$i++; 
};
?>

<tr><td colspan =2>Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td></tr>
</table>

</td>
<!----------- volgende tabel----------------------->

<td STYLE="vertical-align: top;">
<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Toernooien per vereniging</th>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Aantal<br>toernooien</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry8 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 	<?php $totaal = $totaal + $row['Aantal']; ?>
	</tr>
 
<?php	 
	$i++; 
};
?>
<tr>
	<td colspan =2> Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td>
</tr>
</table>


</td>
<!----------- volgende tabel ----------------------->
<td STYLE="vertical-align: top;" >

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4 >Top 10 - Toernooien per persoon</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Aantal<br>toernooien</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry9 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 		<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>


</td>
<!----------- volgende tabel ----------------------->
<td STYLE="vertical-align: top;">

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Top 10 - Inschrijvingen per datum</th>
	<tr>
		<th>Nr</th>
		<th>Datum</th>
		<th>Aantal<br>personen</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry10 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Datum'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>

</TD>
</tr>
</table>
<!---- // naast elkaar tot hier -------------------------->
<br>

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="aantal_per_maand.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='120' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

$select_year = date('Y');

// Eerst de namen van de maanden verwerken
for ($month=1;$month<13;$month++){
    fwrite($fp, "         <string>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,strftime("%h",mktime(0,0,0,$month,1,$select_year)));
     fwrite($fp, "</string>\n");
}// end for
fwrite($fp, "      </row>\n");
//========== Schrijf de X-as van de grafiek
fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal inschrijvingen per maand (in archief)</string>\n");

for ($month=1;$month<13;$month++){
if (!isset($aantal[$month])){
	   $aantal[$month] = 0;
	  }

fwrite($fp, "        <number>");
fwrite($fp, $aantal[$month]);
fwrite($fp, "</number>\n");
}  /// end for month       
fwrite($fp, "      </row>\n");
// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:840pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '690',
			'height', '460',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=aantal_per_maand.xml', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
</div>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>

<!-----------  3D pie chart----------------------------------------------------->

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_verenigingen.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
fwrite($fp, "<chart_data>\n");
fwrite($fp, "<row>\n");
fwrite($fp, "<null/>\n");

/// verenigingen

for ($i=1;$i<$totaal_3d;$i++){
		
	fwrite($fp, "<string>".$_3d_vereniging[$i]."</string>\n");
	
}	/// end for
	fwrite($fp, "</row>\n");
   
/// aantal per vereniging	
	fwrite($fp, "<row>\n");
	 fwrite($fp,"<string></string>\n");
	 	
	for ($i=1;$i<$totaal_3d;$i++){
		
	fwrite($fp, "<string>".$_3d_aantal[$i]."</string>\n");
	
}	/// end for
fwrite($fp, "</row>\n");	
fwrite($fp, "</chart_data>\n");
fwrite($fp, "<chart_grid_h thickness='0' />\n");

fwrite($fp, "<chart_label shadow='low' color='000000' alpha='65' size='9' position='inside' as_percentage='false' />\n");
fwrite($fp, "<chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "<chart_rect x='160' y='40' width='800' height='200' positive_alpha='0' />\n");
fwrite($fp, "<chart_transition type='spin' delay='0' duration='1' order='category' />\n");
fwrite($fp, "<chart_type>3d pie</chart_type>\n");

fwrite($fp, "<draw>\n");
fwrite($fp, "<rect bevel='bg' layer='background' x='0' y='0' width='400' height='300' fill_color='4c5577' line_thickness='0' />\n");
fwrite($fp, "<text shadow='low' color='0' alpha='10' size='40' x='0' y='260' width='500' height='50' v_align='middle'>Inschrijvingen per vereniging</text>\n");
fwrite($fp, "<rect shadow='low' layer='background' x='-50' y='70' width='540' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "</draw>\n");
fwrite($fp, "<filter>\n");
fwrite($fp, "<shadow id='low' distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "<bevel id='bg' angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='80' height='210' margin='10' fill_color='0' fill_alpha='20' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='7' color='ffffff' alpha='85' />\n");

fwrite($fp, "<series_color>\n");
fwrite($fp, "<color>00ff88</color>\n");
fwrite($fp, "<color>ffaa00</color>\n");
fwrite($fp, "<color>66ddff</color>\n");
fwrite($fp, "<color>bb00ff</color>\n");
fwrite($fp, "</series_color>\n");
fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>25</number>\n");
fwrite($fp, "<number>75</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "<chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:1240pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '690',
			'height', '460',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=3Dpie_chart_verenigingen.xml', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
</div>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>



<a name='all_verenigingen'><h1>Alle verenigingen (<?php echo mysql_num_rows($qry);?>)</h1></a>

<table id= 'MyTable1' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Plaats</th>
			
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 		<td><?php echo $row['Plaats'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
</table>		
<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
	 	
<?php	 	
$totaal =0;
?>
 	

<a name='all_toernooien'><h1>Alle toernooien (<?php echo mysql_num_rows($qry1);?>)</h1></a>

<table id= 'MyTable1' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
		<th>Datum</th>
		<th>Begin<br>inschrijving</th>
		<th>Eind<br>inschrijving</th>
		<th>Laatste<br>wijziging</th>
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry1 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysql_query("SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$toernooi."' order by Waarde")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	 $laatst = $row['Laatst'];
	}
    if ($datum=='') { $datum='onbekend';};
    if ($begin_inschrijving =='') { $begin_inschrijving='onbekend';};
    if ($einde_inschrijving =='') { $einde_inschrijving='onbekend';};
      if ($today > $datum) {
      ?>
	 		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	 	<?php } else {?>
	 		 		<td><?php echo $datum;?></td>
	 	<?php }?>
	 	<td ><?php echo $begin_inschrijving;?></td>
	 	<td ><?php echo $einde_inschrijving;?></td>
	 		<td ><?php echo $laatst;?></td>
	 	
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<a name='all_gebruikers'><h1>Gebruikers (<?php echo mysql_num_rows($qry3);?>)</h1></a>

<?php
$totaal =0;
?>


<table width=80% border=0>


<!----------------  meerdere tabellen naast elkaar ------------>	
	<tr>
		<td STYLE="vertical-align: top;" width=60% height=50% >
	 
			 

<table id= 'MyTable3' border = 1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>User</th>
			<th>Email</th>
		<th>Laatste</th>
	</tr>
	
	<?php
	 

$i=1;
while($row = mysql_fetch_array( $qry3 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Naam'];?></td>
	  <td><?php echo $row['Email'];?></td>
	 	 <td><?php echo $row['Laatst'];?></td>
	</tr>
 
<?php	 
	$i++; 
};
?>
</table>

</td>
<td STYLE="vertical-align: top;">

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4  >Top 10 - Laatste gebruikers</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Laatst</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry11 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 	<td><?php echo $row['Vereniging'];?></td>
    <td><?php echo $row['Laatst'];?></td>
</tr>
 
<?php	 
	$i++; 
};
?>
</table>

<!-------------------------------------- tabel eronder in zelfde cel-------------------------------->

<br>

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4  >Top 10 - Frequentie gebruikers</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Aantal</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry12 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 	<td><?php echo $row['Vereniging'];?></td>
    <td><?php echo $row['Aantal'];?></td>
</tr>
 
<?php	 
	$i++; 
};
?>
</table>









</Td>
</tr>
</table>








<!---- // naast elkaar tot hier -------------------------->			 
			 












<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<a name='per_dag'><h1>Per dag</h1></a>&nbsp<a href='stats_maand.php' target='_blank' style='font-size:9pt;color:red;text-decoration:none;'>[Vorige maanden]</a>

<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =2>Dag</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysql_fetch_array( $qry5 )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 
	 	 		echo 
	 	 	strftime("%A",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 	 	<td style= 'text-align:right;' ><?php 
	 	 		echo 
	 	 	strftime("%d %B %Y",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 		<?php 	 		 $totaal = $totaal + $row['Aantal'];	 		 ?>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	<tr>
	<td colspan =2> Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td>
</tr>
	
	
</table>
<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>

</body>
</html>