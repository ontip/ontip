<HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>OnTip - Grafieken</title>

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

<?php

// Standard inclusions   

include ('mysqli.php');

setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

 $sql        = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  group by 2 order by 2");
     
$aantal  = array();

// Querie herhalen voor de aantallen
$i=1;
for ($month=1;$month<13;$month++){

/// bereken totalen over de maand
     //     $begin_maand = strftime("%Y-%m-%d" , mktime(0, 0, 0, date($month),date(1),date($select_year)) ) ;
     //     $einde_maand = strftime("%Y-%m-%d" , mktime(0, 0, 0, date($month),date(1),date($select_year)) ) ;
          
     //     echo $begin_maand ."<br>";
    //      echo $einde_maand ."<br>";
          
     
      $result             = mysqli_fetch_array( $sql );
      $aantal[$month]     = $result['Aantal'];
     
             
   // echo           $result['Aantal']. "<br>";
    
//              	  echo $month . "--". $aantal[$month]. "<br>";
             	  $i++;
             	  
 } /// end for            	  

?>
<body BGCOLOR='#ffffCC' >
	

<?php	


// Er wordt een XML file gevuld waarin de data wordt opgenomen
// Bij nieuwe file in Domeinhuis bestandsbeheer rechten op '777'  zetten

$xml_file ="aantal_per_maand.xml";

# Het bestand openen for write om te schonen
$fp = fopen($xml_file, "w");
fclose($fp);

# Het bestand openen for append om toe te voegen
$fp = fopen($xml_file, "a");

fwrite($fp, "<chart>\n");
//fwrite($fp, "<chart_type>bar</chart_type>\n");

// andere kleur + size aan de as geven
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");

// pas de left margin e

fwrite($fp, "<chart_rect x='100' />\n");

//=== waarden achter de  rij zetten
fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='100' />\n");


/////////////////////////////////////////////////////  aantal per maand /////////////////////////////////////////////////

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
}  /// end for month gewerkte uren

fwrite($fp, "      </row>\n");

//////////////////////////////////////////////////////////////////
// sluit af

fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
//fwrite($fp,"<update url='grafieken.php?uniqueID=0.26440600+1128349620'>\n") ;
fwrite($fp, "</chart>\n");

# En dan nog het bestandje sluiten.
fclose($fp);
//echo " maak grafiek <br>";

?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->


<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->



<center>
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
<!--			'salign', 'TL',-->
			'salign', 'ExactFit',
			'bgcolor', '#777788',
<!--			'wmode', 'opaque',-->
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
</center>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</body>
</html>