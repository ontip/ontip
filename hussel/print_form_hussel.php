<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 12pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 10pt;vertical-align:bottom;}
td {color:brown;font-size: 12pt;}

#leeg          {color:white;padding-top:9pt;padding-bottom:9pt;}

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
</body>

	
<?php
/// Deze php haalt de gegevens van een vorige hussel op

ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);
setlocale(LC_ALL, 'nld_nld');


//// Database gegevens. 

include ('conf/mysql.php');
include ('conf/sub_date.php');

$jaar  = substr($date, 0,4);
$maand = substr($date, 5,2);
$dag   = substr($date, 8,2);


//// Sql queries

$score     = mysql_query("SELECT * From hussel WHERE Datum = '".$date."' ORDER BY Naam " )     or die(mysql_error());  
$size_q    = mysql_query("SELECT Waarde From hulp WHERE Naam='Size' " )                    or die(mysql_error()); 
$poule_q   = mysql_query("SELECT Waarde From hulp WHERE Naam='Poule' " )                    or die(mysql_error()); 

/// Bepalen aantal wedstrijden 
$size      = mysql_result($size_q,0); 

if (mysql_result($size_q,0) == 1){$Poule ='A';}; 
if (mysql_result($size_q,0) == 2){$Poule ='B';}; 


echo "<table>";
echo "<tr><td valign='center'  >";
echo  "<form>"; 
echo "<INPUT type='image' src='images/printerleeg.jpg'  id='print' onmouseover='img_uitzetten(2)' onmouseout='img_aanzetten(2)' value='image' width='75' alt='Print deze pagina' onClick='window.print()'>";
echo "</form>";
echo "</td>";
echo "<td valign='center' >";
echo "<a href ='hussel.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' width=65 border='0' alt='Terug naar begin'></a>";
echo "</td></tr>";
echo "</table>";

echo "<div Style='position:absolute; top:10pt;left:360pt;'>";
echo "Hussel van<br>";
echo strftime("%A %d %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));
echo "</div>";

echo "<br><center><div Style='font-size:14pt;color:black;font-weight:bold; '>";

if (mysql_result($size_q,0) > 0) {

echo "INVUL LIJST UITSLAGEN- Poule ";
echo $Poule;
echo "<br>";
}
else {
echo "INVUL LIJST UITSLAGEN<br>";
};

echo "</div>";

echo "<table border = 1 Style='empty-cells: show;background-color:white;'>";

echo "	<tr>";
echo "		<th colspan = '2' Style='width=100;background-color:white;border-color:white;' ></th>";

if ($size < 6 ){
echo "		<th colspan = '2'>Ronde 1</th>"; 
echo "		<th colspan = '2'>Ronde 2</th>";
echo "		<th colspan = '2'>Ronde 3</th>";
};       //// size < 6

if ($size >  4  and $size < 6){
echo "		<th colspan = '2'>Ronde 4</th>";
echo "		<th colspan = '2'>Ronde 5</th>";
};       //// size > 4 and size < 6

if ($size > 5){
echo "		<th colspan = '2'>Ronde 6</th>";
echo "		<th colspan = '2'>Ronde 7</th>";
echo "		<th colspan = '2'>Ronde 8</th>";
echo "		<th colspan = '2'>Ronde 9</th>";
echo "		<th colspan = '2'>Ronde 10</th>";
};       //// size > 5


echo "		</tr>";
echo "		<tr>"; 
echo " 	  <th Style='width=40;'>Nr</th>"; 
echo "		<th Style='width=400;'>Naam</th>"; 

if ($size < 6 ){
echo "		<th Style='width=50;'>V</th>";                          // ronde 1
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 2
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 3
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
};       //// size < 6

if ($size >  4  and $size < 6){
echo "		<th Style='width=50;'>V</th>";                          // ronde 4
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 5
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
};       //// size > 4 and size < 6

if ($size > 5){ 
echo "		<th Style='width=50;'>V</th>";                          // ronde 6
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 7
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 8
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
echo "		<th Style='width=50;'>V</th>";                          // ronde 9
echo "		<th Style='width=50;' Id= 'tegen'>T</th>"; 
echo "		<th Style='width=50;'>V</th>";                          // ronde 10
echo "		<th Style='width=50;' Id= 'tegen'>T</th>";
};       //// size > 5

echo "  </tr>";

//<!---- Standaard regel ---->
$i=1;
echo "  <tr>";
  while($row = mysql_fetch_array( $score )) {
	
	 
    echo "<td style ='text-align: right;padding:2pt;'>";  
    echo $i;
    echo "</td>";  
    echo "<td>";  
    echo $row['Naam'];
    echo "</td>";   
       
if ($size < 6 ){
	
	    ///// Ronde 1
     
  	echo "<td style ='text-align: right;padding:2pt; color:blue;'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td id='leeg' style ='text-align:right; padding:2pt; color:red;'>.";
  	
  	echo "</td>"; 
  	
  	  	
  	 ///// Ronde 2
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	
     ///// Ronde 3
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
};  	     //// size < 6

if ($size >  4  and $size < 6){ 
     ///// Ronde 4
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 

     ///// Ronde 5
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
};       //// size > 4 and size < 6

if ($size > 5){ 
     ///// Ronde 6
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 

     ///// Ronde 7
        
    echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 

     ///// Ronde 8
        
    echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 

     ///// Ronde 9
        
    echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 

     ///// Ronde 10
        
 echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>.";
  	
  	echo "</td>"; 
  	
};       //// size > 5

  
    
   echo "</tr>"; 
$i++;
} ;


   
echo "</table>"; 
echo "</center>"; 

?>
</body>

</html>
