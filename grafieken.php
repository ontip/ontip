<HTML>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>La Boule Naarden</title>
<!-- InstanceEndEditable -->
<link href="../twoColLiqLtHdr.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColLiqLtHdr #sidebar1 { padding-top: 30px; }
.twoColLiqLtHdr #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->

<?php include ("../php/javalib.php"); ?> 
<?php include ("../php/css.php"); ?> 	
	
<script language="javascript">AC_FL_RunContent = 0;</script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
var requiredMajorVersion = 9;
var requiredMinorVersion = 0;
var requiredRevision = 45;
-->
</script>

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body class="twoColLiqLtHdr" Style= 'background-color:#BDCCEA;'>

<div id="container"> 
  <!---- Opmaak header en linkermenu in aparte bestanden ivm herbruikbaarheid--->
 
<?php include("../php/header.php"); ?> 
<?php include("../php/sidebar.php"); ?>  

  <div id="mainContent">    <!-- InstanceBeginEditable name="EditRegion3" -->    
   <basefont FACE="Times New Roman" SIZE="3">

<table width=100%>
<tr>
		<td style='font-type: Comic Sans; font-size: 14pt;color:yellow;' colspan='2'><h3>Grafieken</h3></td>
</td>
<td align='right'><img src = '../images/grafiek_bar2.jpg' width=100></td>
</tr>
</table>
<br>
	
<?php

// Standard inclusions   
   
include ('conf/mysqli.php');

/////////////////////////////////////////////////////   aantal per boule /////////////////////////////////////////////////
// Select

$qry = mysqli_query($con,"SELECT distinct(Boule)as Naam, count(*) FROM bestelling_boules 
         where Bestelling_afgerond = 'Ja'  group by 1 order by 2 DESC" )  or die(mysql_error());  
 

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("aantal_per_boule_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("aantal_per_boule_bar.xml", "a");

fwrite($fp, "<chart>\n");
fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='9' bold='true' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de boules verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	fwrite($fp, $row['Naam']);
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal verkocht per boule</string>\n");

// Querie herhalen voor de aantallen boules

$qry = mysqli_query($con,"SELECT distinct(Boule)as Naam, count(*) as Aantal FROM bestelling_boules 
   where Bestelling_afgerond = 'Ja' group by 1 order by 2 DESC" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Aantal']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);


/////////////////////////////////////////////////////   aantal per acces /////////////////////////////////////////////////
// Select

$qry = mysqli_query($con,"SELECT distinct(Artikel) as Naam, sum(bestel_aantal) FROM bestelling_accessoires
  where Bestelling_afgerond = 'Ja'  group by 1 order by 2 DESC" )  or die(mysql_error());  
 

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("aantal_per_accs_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("aantal_per_accs_bar.xml", "a");

fwrite($fp, "<chart>\n");
fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='9' bold='true' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='110' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de boules verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	fwrite($fp, $row['Naam']);
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal verkocht per accessoire</string>\n");

// Querie herhalen voor de aantallen boules

$qry = mysqli_query($con,"SELECT distinct(Artikel)as Naam, sum(bestel_aantal) as Aantal FROM bestelling_accessoires 
  where Bestelling_afgerond = 'Ja' group by 1 order by 2 DESC" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Aantal']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);

//////////////////////////////////////////////////////  aantal boules per maand

// Select

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, count(*) FROM bestelling_boules 
  where Bestelling_afgerond = 'Ja' group by 1 order by 1" )  or die(mysql_error());  

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("aantal_boules_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("aantal_boules_bar.xml", "a");

fwrite($fp, "<chart>\n");
//fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de maanden verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	
	if ($row['Maand'] == 1) {
			fwrite($fp, 'Jan');
			}
	if ($row['Maand'] == 2) {
			fwrite($fp, 'Feb');
			}		
	if ($row['Maand'] == 3) {
			fwrite($fp, 'Mrt');
			}
	if ($row['Maand'] == 4) {
			fwrite($fp, 'Apr');
			}		
	if ($row['Maand'] == 5) {
			fwrite($fp, 'Mei');
			}
	if ($row['Maand'] == 6) {
			fwrite($fp, 'Jun');
			}		
	if ($row['Maand'] == 7) {
			fwrite($fp, 'Jul');
			}
	if ($row['Maand'] == 8) {
			fwrite($fp, 'Aug');
			}		
  if ($row['Maand'] == 9) {
			fwrite($fp, 'Sep');
			}
	if ($row['Maand'] == 10) {
			fwrite($fp, 'Okt');
			}		
	if ($row['Maand'] == 11) {
			fwrite($fp, 'Nov');
			}
	if ($row['Maand'] == 12) {
			fwrite($fp, 'Dec');
			}					
			
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal boules verkocht per maand</string>\n");


// Querie herhalen voor de aantallen

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, count(*) as Aantal FROM bestelling_boules
  where Bestelling_afgerond = 'Ja'  group by 1 order by 1" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Aantal']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

//fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);

//////////////////////////////////////////////////////  aantal accessoires per maand

// Select

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(bestel_aantal) FROM bestelling_accessoires
   where Bestelling_afgerond = 'Ja' group by 1 order by 1" )  or die(mysql_error());  

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("aantal_accs_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("aantal_accs_bar.xml", "a");

fwrite($fp, "<chart>\n");
//fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de maanden verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	
	if ($row['Maand'] == 1) {
			fwrite($fp, 'Jan');
			}
	if ($row['Maand'] == 2) {
			fwrite($fp, 'Feb');
			}		
	if ($row['Maand'] == 3) {
			fwrite($fp, 'Mrt');
			}
	if ($row['Maand'] == 4) {
			fwrite($fp, 'Apr');
			}		
	if ($row['Maand'] == 5) {
			fwrite($fp, 'Mei');
			}
	if ($row['Maand'] == 6) {
			fwrite($fp, 'Jun');
			}		
	if ($row['Maand'] == 7) {
			fwrite($fp, 'Jul');
			}
	if ($row['Maand'] == 8) {
			fwrite($fp, 'Aug');
			}		
  if ($row['Maand'] == 9) {
			fwrite($fp, 'Sep');
			}
	if ($row['Maand'] == 10) {
			fwrite($fp, 'Okt');
			}		
	if ($row['Maand'] == 11) {
			fwrite($fp, 'Nov');
			}
	if ($row['Maand'] == 12) {
			fwrite($fp, 'Dec');
			}					
			
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal accessoires verkocht per maand</string>\n");


// Querie herhalen voor de aantallen

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(bestel_aantal) as Aantal FROM bestelling_accessoires
   where Bestelling_afgerond = 'Ja'  group by 1 order by 1" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Aantal']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

//fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);


//////////////////////////////////////////////////////  omzet boules per maand

// Select

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(Prijs) FROM bestelling_boules
   where Bestelling_afgerond = 'Ja'  group by 1 order by 1" )  or die(mysql_error());  

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("omzet_boules_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("omzet_boules_bar.xml", "a");

fwrite($fp, "<chart>\n");
//fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de maanden verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	
	if ($row['Maand'] == 1) {
			fwrite($fp, 'Jan');
			}
	if ($row['Maand'] == 2) {
			fwrite($fp, 'Feb');
			}		
	if ($row['Maand'] == 3) {
			fwrite($fp, 'Mrt');
			}
	if ($row['Maand'] == 4) {
			fwrite($fp, 'Apr');
			}		
	if ($row['Maand'] == 5) {
			fwrite($fp, 'Mei');
			}
	if ($row['Maand'] == 6) {
			fwrite($fp, 'Jun');
			}		
	if ($row['Maand'] == 7) {
			fwrite($fp, 'Jul');
			}
	if ($row['Maand'] == 8) {
			fwrite($fp, 'Aug');
			}		
  if ($row['Maand'] == 9) {
			fwrite($fp, 'Sep');
			}
	if ($row['Maand'] == 10) {
			fwrite($fp, 'Okt');
			}		
	if ($row['Maand'] == 11) {
			fwrite($fp, 'Nov');
			}
	if ($row['Maand'] == 12) {
			fwrite($fp, 'Dec');
			}					
			
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Boule omzet per maand</string>\n");


// Querie herhalen voor de aantallen

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(Prijs) as Omzet FROM bestelling_boules 
   where Bestelling_afgerond = 'Ja' group by 1 order by 1" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Omzet']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

//fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);

//////////////////////////////////////////////////////  omzet accs  per maand

// Select

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(Bestel_prijs) FROM bestelling_accessoires 
where Bestelling_afgerond = 'Ja' group by 1 order by 1" )  or die(mysql_error());  

// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

# Het bestand openen for write om te schonen
$fp = fopen("omzet_accs_bar.xml", "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen("omzet_accs_bar.xml", "a");

fwrite($fp, "<chart>\n");
//fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

// Eerst de namen van de maanden verwerken

while($row = mysqli_fetch_array( $qry )) {
	// Print out the contents of each row into a table
	
	fwrite($fp, "         <string>");
	
	if ($row['Maand'] == 1) {
			fwrite($fp, 'Jan');
			}
	if ($row['Maand'] == 2) {
			fwrite($fp, 'Feb');
			}		
	if ($row['Maand'] == 3) {
			fwrite($fp, 'Mrt');
			}
	if ($row['Maand'] == 4) {
			fwrite($fp, 'Apr');
			}		
	if ($row['Maand'] == 5) {
			fwrite($fp, 'Mei');
			}
	if ($row['Maand'] == 6) {
			fwrite($fp, 'Jun');
			}		
	if ($row['Maand'] == 7) {
			fwrite($fp, 'Jul');
			}
	if ($row['Maand'] == 8) {
			fwrite($fp, 'Aug');
			}		
  if ($row['Maand'] == 9) {
			fwrite($fp, 'Sep');
			}
	if ($row['Maand'] == 10) {
			fwrite($fp, 'Okt');
			}		
	if ($row['Maand'] == 11) {
			fwrite($fp, 'Nov');
			}
	if ($row['Maand'] == 12) {
			fwrite($fp, 'Dec');
			}					
			
	fwrite($fp, "</string>\n");
}
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Accessoires omzet per maand</string>\n");


// Querie herhalen voor de aantallen

$qry = mysqli_query($con,"SELECT distinct(Month(Datum))as Maand, sum(Bestel_prijs) as Omzet FROM bestelling_accessoires 
   where Bestelling_afgerond = 'Ja' group by 1 order by 1" )  or die(mysql_error());  
while($row = mysqli_fetch_array( $qry )) {
	
	
//========== Schrijf de X-as van de grafiek

fwrite($fp, "        <number>");
fwrite($fp, $row['Omzet']);
fwrite($fp, "</number>\n");
}
fwrite($fp, "      </row>\n");

//fwrite($fp, "\n");


// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");


# En dan nog het bestandje sluiten.
fclose($fp);
?>

<!--------------------------- Nu de XML bestanden verwerken-------------------->


<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=aantal_per_boule_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>

<!-------------------------------------- nr 2----------------------------------------------------------------------------->
<br>
<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=aantal_per_accs_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>

<!-------------------------------------- nr 3----------------------------------------------------------------------------->

<br>
<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=aantal_boules_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>

<!-------------------------------------- nr 3 ----------------------------------------------------------------------------->

<br>
<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=aantal_accs_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>

<!-------------------------------------- nr 4 ----------------------------------------------------------------------------->
<br>
<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=omzet_boules_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>


<!-------------------------------------- nr 5 ----------------------------------------------------------------------------->
<br>
<div Style="bottom: 1pt solid red;background-color:white;width:540pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '660',
			'height', '360',
			'scale', 'showAll',
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
	'wmode', 'transparent',   

		'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=omzet_accs_bar.xml', 
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
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>









<br><br>
<!-- end #container --></div>
</body>
<!-- InstanceEnd --></html>
