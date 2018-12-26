<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 11pt;}
td {color:black;font-size: 12pt;}
a {text-decoration:none;padding-left:2px;padding-right:2pt;font-size:8pt; color:blue;}

#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }


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

function fill_input_naam_field()
{
	if (document.getElementById('naam').value == "Typ hier de naam"){
		
	   document.getElementById('naam').value= "";
  
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


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><a href='index.php' target = '_top'><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></a></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' >Terug naar scores</a>
</td></tr>
</table>
<br>
<blockquote>
<h2>Beheer spelers uit spelerslijst  (selectielijst hussel)</h2>



<div style='margin-left: 18px;font-size:10pt;color:black;' >
Hier kan je eventuele typefouten in de naam corrigeren of spelers verwijderen uit de spelers lijst.Type fouten in de namen van de hussel kan je daar aanpassen.<br>
Aanpassingen in de namen in het hussel schem worden niet doorgevoerd in deze lijst. Voor verwijderen moet je het vakje in de kolom verwijderen aan vinken.<br>
De spelers die hier worden toegevoegd worden niet toegevoegd aan de scorelijst.<br>
Na aanbrengen van wijzingen en of verwijderen op de knop bevestigen drukken onder aan de pagina.
</div><br><br>


	

<FORM action='insert_speler_spelerslijst.php' method='post'>
	
				<input type ='hidden'  name= 'datum'  value = '<?php echo $datum;?>' />
				<input type ='hidden'  name= 'vereniging'     value = '<?php echo $vereniging;?>' />
				<input type ='hidden'  name= 'vereniging_id'  value = '<?php echo $vereniging_id;?>' />
				
				<table width=60%>
					<tr>
						<th>Nieuwe speler toevoegen</th>
					    <td>
				<input onclick="fill_input_naam_field();" STYLE='font-size:11pt;' type ='text'  id = 'naam' name = 'nieuwe_speler' value ='Typ hier de naam' size =45 />
				<input style='font-size:10pt;' TYPE="submit" VALUE="Klik hier om toe te voegen aan de spelerslijst">
				</td>
			</tr>
			</table>
     
     </form>
  <br>



<?php
//// Tabel met users
//// SQL Queries
$spelers      = mysql_query("SELECT Id,Naam From  hussel_spelers where Vereniging_id = ".$vereniging_id." order by Naam  " )    or die(mysql_error());  
$count          = mysql_num_rows($spelers);	

// tabel binnen div

echo "<FORM action='muteer_spelers.php' method='post'>";
echo "<input type='hidden'  name ='count_spelers'   value ='".$count."'>";  
////  Koptekst

echo "<INPUT type='submit' value='Verwijderen of wijzigen bevestigen' >"; 
echo "<table border =1 width=50%>";
echo "<tr>";
echo "<th style='background-color:darkblue;color:white;' width=30>Nr</th>";
echo "<th style='background-color:red;color:white;'> Verwijder</th>";
echo "<th style='background-color:darkblue;color:white;'>Naam</th>";
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
   echo "<LABEL 'Naam'></LABEL><input style='font-size:11pt;'  name= 'Naam-";
   echo $i;
   echo "' type='text' size='60'  value ='";
   echo $row['Naam'];
   echo "'> </td>"; 
   
   echo "</tr>";

$i++;
};
echo "</table><br>";
echo "<INPUT type='submit' value='Verwijderen of wijzigen bevestigen' >"; 
echo "</FORM>";




?> 
</blockquote>

</body>
</html>

