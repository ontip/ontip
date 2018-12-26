<?php
# demo_filmpje_hussel.php
# Demonstratie hoe OnTip hussel werkt
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 29nov2018          1.0.1           E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Image link naar oude website
# Fix:              None.
# Feature:          None.
# Reference: 
?>

<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:blue;font-size: 8pt;}
td {color:blue;font-size: 11pt;padding:3pt;}
h2 {color:blue;font-size: 12pt;padding:3pt;}
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
</tr>
</table>

<br>


</html>


 <h2>Demo filmpje</h2>
  
  <center>
  Klik rechtsonder in het bovenstaande schermpje voor beeldvullend. Wacht met afspelen tot het beeld scherp is.<br>   
           <iframe width="854" height="510" src="https://www.youtube.com/embed/EgeYgaXRYh4" frameborder="0" allowfullscreen></iframe>
         
      </center>    
</body>
</html>