<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 8pt;}
td {color:brown;font-size: 10pt;}
a {text-decoration:none;color:yellow;padding-left:2px;padding-right:2pt;}


#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}

</style>

<!---/// Mouse over voor aan/uit zetten images--->

<script type="text/javascript">
function img_uitzetten(i){
	      i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/homeoff.jpg";break;
        case 2:
           document.getElementById('print').src="images/printer.jpg";break;
        }
}

</script>

<script type="text/javascript">
function img_aanzetten(i){
        i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/home.jpg";break;    
        case 2:
           document.getElementById('print').src="images/printerleeg.jpg";break;  
         }
}

</script>
</head>
<body>


<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);


//// Database gegevens. 

include ('mysql.php');


//// SQL Queries
$spelers      = mysql_query("SELECT Id,Naam, Poule From hussel_spelers where Vereniging_id = ".$vereniging_id." order by Naam  " )    or die(mysql_error());  


echo "<div style='border: red solid 1px;padding-left:5px;'>";  
echo"<h1>Beheer spelers  ";
echo "</h1>"; 
echo "</div>";

 // dbase plaatje

echo "<div style='position: absolute; top: 30px; right: 20px; width: 40px;height:40;' >";
echo "<img src='images/dbase.jpg' width=55 border='0' alt='Database beheer'>";
echo "</div>";

echo "<table>";
echo "<tr><td valign='center'  >";
echo  "<form>"; 
echo "<INPUT type='image' src='images/printerleeg.jpg'  id='print' onmouseover='img_uitzetten(2)' onmouseout='img_aanzetten(2)' value='image' width='75' alt='Print deze pagina' onClick='window.print()'>";
echo "</form>";
echo "</td>";
echo "<td valign='center' >";
echo "<a href ='index.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' width=65 border='0' alt='Terug naar begin'></a>";
echo "</td></tr>";
echo "<tr>";
echo "<td Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>";
echo "<td Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar score</td>";
echo "</tr>";echo "</table>";

echo "<div style='position: absolute; top: 110px; left: 180px;font-size:11pt;color:blue;' >";
echo "<br>Hier kan je eventuele typefouten in de naam corrigeren of spelers verwijderen uit de hussel.<br>
      Voor verwijderen moet je het vakje in de kolom verwijderen aan vinken.<br>
      Na aanbrengen van wijzingen en of verwijderen op de knop bevestigen drukken onder aan de  pagina.";
echo "</div>";


//// Tabel met users

// tabel binnen div
echo "<div style='position: absolute; top: 210px; left: 180px; width: 940px;color:green;padding-left:10pt' >";

echo "<FORM action='muteer_hussel_spelers.php' method='post'>";

////  Koptekst


echo "<table border =1>";
echo "<tr>";
echo "<th width=30>Nr</th>";
echo "<th>Verwijder</th>";
echo "<th >Naam</th>";
echo "<th >Poule</th>";
echo "</tr>";

/// Detail regels

$i=1;                        // intieer teller 

echo "  <tr>";

while($row = mysql_fetch_array( $spelers )) {

   echo "<td style='text-align:right;padding:5pt;' >";
   echo $i;
   echo "</td>";
   echo "<td style='text-align:center;padding:5pt;width:50;'>";
   echo "<INPUT TYPE='hidden' NAME='Id-";
   echo $i;
   echo "' VALUE='";
   echo $row['Id'];
   echo "'>";
   echo "<input type='checkbox' name='Check[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "<td>";
   echo "<LABEL 'Naam'></LABEL><input name= 'Naam-";
   echo $i;
   echo "' type='text' size='40' maxlength='40' value ='";
   echo $row['Naam'];
   echo "'> </td>"; 
   
   echo "</tr>";

$i++;
};
echo "</table><br>";
echo "<INPUT type='submit' value='Verwijderen of wijzigen bevestigen' ></td>"; 
echo "</FORM>";

echo  "</div>";


?> 
</body>
</html>

