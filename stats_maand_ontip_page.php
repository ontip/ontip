<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Maand statistieken OnTip Pagina</title>
	<link rel="shortcut icon" type="image/x-icon" href="../ontip/images/OnTip_banner_klein.ico">    
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
<body>
<?php 
// Database gegevens. 
ob_start();
/* Set locale to Dutch */

include('mysql.php');
setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

$yearmonth = $_GET['yearmonth'];
$page      = $_GET['page'];

$start_date = date('Y-m-d', strtotime('-30 days'));
//echo $start_date;

// $sql        = mysql_query("SELECT DATE_FORMAT(Laatst,'%Y-%m-%d') as Dag, count(*) as Aantal  FROM `page_stats` where Page ='".$page."' and DATE_FORMAT(Laatst,'%Y-%m-%d') > '".$start_date."' group by 1 order by 1");


// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="ontip_per_maand.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");

//  legend margin ruimte tussen kop en grafiek

fwrite($fp, "<legend   margin='10' />\n");

//  axis_value is de y as
fwrite($fp, "<axis_value size='6'  />\n");


// size hieronder geeft de font grootte weer van de waarden boven de kolommen

fwrite($fp, "<chart_rect x='130' y='50'   />\n");
fwrite($fp, "<chart_label position='outside' size='2' color='blue' alpha='120' />\n");
fwrite($fp, "<axis_category size='3' color='FF0000' />\n");
fwrite($fp, "<chart_type>line</chart_type>\n");


//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

$select_year = date('Y');

// Eerst de dagen verwerken

$sql        = mysql_query("SELECT DATE_FORMAT(Laatst,'%d-%b') as Dag, count(*) as Aantal  FROM `page_stats` where Page ='".$page."' and DATE_FORMAT(Laatst,'%Y-%m-%d') > '".$start_date."' group by 1 order by Laatst");


while($row = mysql_fetch_array( $sql )) {

    fwrite($fp, "         <string>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,substr($row['Dag'],-6) );
     fwrite($fp, "</string>\n");
}// end while
fwrite($fp, "      </row>\n");

//========== Schrijf de X-as van de grafiek

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Vanaf ".$start_date."</string>\n");

$sql        = mysql_query("SELECT DATE_FORMAT(Laatst,'%Y-%m-%d') as Dag, count(*) as Aantal  FROM `page_stats` where Page ='".$page."' and DATE_FORMAT(Laatst,'%Y-%m-%d') > '".$start_date."' group by 1 order by Laatst");
 
while($row = mysql_fetch_array( $sql )) {     
fwrite($fp, "        <number>");
fwrite($fp, $row['Aantal']);                
fwrite($fp, "</number>\n");
}  /// end for while
fwrite($fp, "      </row>\n");

// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "	<draw>\n");
fwrite($fp, "   <text x='170' y='3' color ='FF4400' size= '10'>Gebruik pagina ".$page."</text>\n");
fwrite($fp, "	</draw>\n");


//fwrite($fp, "  <series bar_gap='145' set_gap='25' />"."\n");

fwrite($fp, "\n");
fwrite($fp, "</chart>\n");
fclose($fp);

?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:400pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '1500',
			'height', '700',
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
</div>
</body>
</html>
