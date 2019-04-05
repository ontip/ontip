<html>
<head>
<title>OnTip Hussel (c) 2016  Erik Hendrikx</title>
<style type="text/css" media="print">
body {color:blue;font-size: 12pt; font-family: Verdana;background-color:white;  }
th {color:black;font-size: 14t;vertical-align:bottom;padding:5pt;}
td {color:black;font-size: 11pt;padding:4pt;font-weight:bold;}
.noprint {display:none;}     
table {border-collapse: collapse;}

#leeg          {color:white;padding-top:9pt;padding-bottom:9pt;}
#onderschrift     {font-size:8pt;color:blue;text-align:center;padding:0pt;}

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
        case 3:
           document.getElementById('print').src="images/invul1.gif";break;
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
        case 3:
           document.getElementById('print').src="images/invul2.gif";break;  
         }
}

</script>
</head>
</body>

	
<?php
/// Deze php haalt de gegevens van een vorige hussel op
//// Database gegevens. 

//// Database gegevens. 

include ('mysqli.php');


//// 2015-05-19
//// 01234567890

$jaar =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag =  substr($datum, 8,2);

$sort = $_GET['sort'];



if ($sort =='Naam') {
	$score   = mysqli_query($con,"SELECT * From hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  and Naam <> '' ORDER BY Naam " )     or die(mysql_error());  

}

if ($sort =='Lot') {
	$score   = mysqli_query($con,"SELECT * From hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  and Naam <> '' ORDER BY Lot_nummer" )     or die(mysql_error());  

}



echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:9pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:10pt; text-shadow: 2px 2px darkgrey;text-align:center;'>INVUL LIJST UITSLAGEN<br>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
echo "</table>";


?>
<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 55 alt= 'Print pagina'></td> 		
<td valign='center' >
<a class='noprint'  href ='print_hussel.php'><img src='images/invul1.gif'   id='print'  class='noprint' width=35 border='0' alt='Terug naar print functies'></a>
</td>
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg' width = 55  id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Print<br>functies</td>
<td class='noprint' Style='font-size:8pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar scores</td>
</tr>
</table>


<?php


echo "<blockquote><table border = 1 Style='empty-cells: show;background-color:white;border:1px solid #000000;' cellpadding=0 cellspacing=0'  width=90%>";

echo "	<tr>";
echo "		<th colspan = '2' Style='width=100;background-color:white;border-color:black;' ></th>";
echo "		<th colspan = '2'>Ronde 1</th>"; 
echo "		<th colspan = '2'>Ronde 2</th>";

if ($aantal_rondes  > 2 ){
echo "		<th colspan = '2'>Ronde 3</th>";
}

if ($aantal_rondes  > 3 ){
echo "		<th colspan = '2'>Ronde 4</th>";
echo "		<th colspan = '2'>Ronde 5</th>";
};       //// size > 4 and size < 6



echo "		</tr>";
echo "		<tr>"; 


if ($voorgeloot == 'On') {
echo " 	  <th Style='width:25pt;'>Lot</th>"; 
}
else {
echo " 	  <th Style='width:25pt;''>Nr</th>"; 
}

echo "		<th width='200'>Naam</th>"; 


echo "		<th Style='width=60;'>V</th>";                          // ronde 1
echo "		<th Style='width=60;' Id= 'tegen'>T</th>";
echo "		<th Style='width=60;'>V</th>";                          // ronde 2
echo "		<th Style='width=60;' Id= 'tegen'>T</th>";

if ($aantal_rondes  > 2 ){

echo "		<th Style='width=60;'>V</th>";                          // ronde 3
echo "		<th Style='width=60;' Id= 'tegen'>T</th>";
}


if ($aantal_rondes ==5){
echo "		<th Style='width=60;'>V</th>";                          // ronde 4
echo "		<th Style='width=60;' Id= 'tegen'>T</th>";
echo "		<th Style='width=60;'>V</th>";                          // ronde 5
echo "		<th Style='width=60;' Id= 'tegen'>T</th>";
};       //// size > 4 and size < 6



echo "  </tr>";

//<!---- Standaard regel ---->
$i=1;
echo "  <tr>";
  while($row = mysqli_fetch_array( $score )) {
	
	 
      
    if ($voorgeloot == 'On') {
     echo "<td   style='text-align:right;padding:3pt;'>";  
      echo $row['Lot_nummer'];
      echo ".</td>";  
  }
  else {
  	 echo "<td style ='text-align: right;padding-right:2pt;'>";  
    echo $i;
    echo "</td>";  
  }
  
      	
    echo "<td>";  
    echo $row['Naam'];
    echo "</td>";   
       
	
	    ///// Ronde 1
     
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt; color:blue;'>";
  	
  	echo "</td>"; 
  	
  	echo "<td id='leeg' style ='text-align:right; padding:2pt; color:red;'>";
  	
  	echo "</td>"; 
  	
  	  	
  	 ///// Ronde 2
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;'>";
  	
  	echo "</td>"; 
  	
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:red;'>";
  	
  	echo "</td>"; 
  	
  if ($aantal_rondes  > 2 ){	
     ///// Ronde 3
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' >";
  	
  	echo "</td>"; 
  	
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:red;' >";
  	
  	echo "</td>"; 
  }
  
  	
if ($aantal_rondes ==5){
     ///// Ronde 4
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' >";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>";
  	
  	echo "</td>"; 

     ///// Ronde 5
        
  	echo "<td  id= 'leeg' style ='text-align: right;padding:2pt;color:blue;' >";
  	
  	echo "</td>"; 
  	
  	echo "<td style ='text-align: right;padding:2pt;color:red;' id= 'leeg'>";
  	
  	echo "</td>"; 
  	
};       //// size > 4 and size < 6


  	


  
    
   echo "</tr>"; 
$i++;
} ;
?>
</table>
</blockquote>
<br><br>
<div style='text-align:right;margin-right:35pt;'>
<em style='font-size:5pt;color:darkgrey;'>OnTip hussel is een programma gemaakt door Erik Hendrikx (c) <?php echo date('Y'); ?></em>
</div>

</body>

</html>
