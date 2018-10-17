<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<body>
<?php 
// Database gegevens. 
ob_start();
/* Set locale to Dutch */

include('mysql.php');
setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

/// over 2012
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2012' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2012_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2012_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2012_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
/// over 2013
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2013' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2013_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2013_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2013_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 

/// over 2014
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2014' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2014_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
     //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2014_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2014_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 

/// over 2015
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2015' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2015_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
     //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2015_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2015_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 

/// over 2016
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2016' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2016_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
     //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2016_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2016_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 

/// over 2017
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2017' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2017_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
     //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2017_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2017_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="aantal_per_maand.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");

//  legend margin ruimte tussen kop en grafiek

fwrite($fp, "<legend   margin='8'   size= '8'/>\n");

//  axis_value is de y as
fwrite($fp, "<axis_value size='6'  />\n");

// size hieronder geeft de font grootte weer van de maandnamen onder de kolommen

fwrite($fp, "<axis_category size='7' color='FF0000' />\n");

// size hieronder geeft de font grootte weer van de waarden boven de kolommen

fwrite($fp, "<chart_rect x='120' y='50'   />\n");
fwrite($fp, "<chart_label position='outside' size='3' color='blue' alpha='120' />\n");
fwrite($fp, "<axis_category size='8' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='5' color='blue' alpha='120' />\n");

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

// 2012

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2012</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2012_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2013

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2013</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2013_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2014

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2014</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2014_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2015

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2015</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2015_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2016

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2016</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2016_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2017

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2017</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2017_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");


// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "	<draw>\n");
fwrite($fp, "   <text x='120' y='4' color ='FF4400' size= '10'>Inschrijvingen per maand (archief)</text>\n");
fwrite($fp, "	</draw>\n");


// 3d

/*
fwrite($fp, "  <series_color>"."\n");
fwrite($fp, "       <color>77CC00</color>". "\n");
fwrite($fp, "   		<color>FF4400</color>". "\n");
fwrite($fp, "   		<color>8844FF</color>". "\n");
fwrite($fp, "  </series_color>"."\n");
*/

fwrite($fp, "  <series bar_gap='10' set_gap='20' />"."\n");

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
			'width', '740',
			'height', '500',
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
