<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /-->

<title>Statistieken inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;font-size:11pt;}
th   {color:blue;font-size:9pt;font-family: sans-serif;font-weight:bold;;background-color:white;border-color:black;}
td   {color:black;font-size:9pt;font-family: sans-serif;background-color:white;border-color:black;padding:2pt;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
</style>
<?php include ("../boulamis_toernooi/js/javalib.php"); ?> 
	
<script language="javascript">AC_FL_RunContent = 0;</script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="../boulamis_toernooi/js/AC_RunActiveContent.js" language="javascript"></script>
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

 
<?php 
// Database gegevens. 

include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

// Id ophalen ipv Vereniging ipv problemen met vreemde tekens
//$vereniging = $_GET['Vereniging'];
$toernooi = $_GET['toernooi'];

$qry1    = mysqli_query($con,"SELECT date_format(Inschrijving, '%Y-%m-%d')   as Datum1,date_format(Inschrijving, '%d-%b')   as Datum2, count(*) as Aantal from `inschrijf` WHERE Toernooi ='".$toernooi."' group by Datum1 order by Datum1")           or die(' Fout in select 1');  
$qry2    = mysqli_query($con,"SELECT date_format(Inschrijving, '%Y-%m-%d') as Datum1, count(*) as Aantal from `inschrijf` WHERE Toernooi ='".$toernooi."' group by Datum1 order by Datum1")           or die(' Fout in select 1');  

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Statistieken - <?php echo  $toernooi; ?>";
</script> 

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file = $prog_url ."aantal_per_dag_".$toernooi.".xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");

fwrite($fp, "<chart>\n");

fwrite($fp, "<axis_category size='7' color='FF0000'  orientation ='diagonal_down' />\n");
fwrite($fp, "<chart_rect width='290' height='80'  x ='40' y='40'  />\n");
fwrite($fp, "<legend layout='hide' />\n");

fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

//========== Schrijf de X-as van de grafiek (dagen)

while($row = mysqli_fetch_array( $qry1 )  ) {

    fwrite($fp, "  <string>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,$row['Datum2']);
     fwrite($fp, "</string>\n");
}// end while
fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal per dag</string>\n");

while($row = mysqli_fetch_array( $qry2   )) {

    fwrite($fp, "  <number>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,$row['Aantal']);
     fwrite($fp, "</number>\n");
}// end while
fwrite($fp, "      </row>\n");


// sluit af
fwrite($fp, "  </chart_data>\n");

fwrite($fp, "	<draw>\n");
fwrite($fp, "   <text x='30' v_align='top' y='10'  color ='FF4400' size= '12'>Inschrijvingen per dag ".$toernooi."</text>\n");
fwrite($fp, "	</draw>\n");

fwrite($fp, "<chart_type>\n");
fwrite($fp, "<string>line</string>\n");
fwrite($fp, "</chart_type>\n");


fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<!--- width en height evenb hier de grootte van het window aan  ------>


<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '900',
			'height', '660',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
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

</body>
</html>