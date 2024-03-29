<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 11pt;}
td {color:black;font-size: 12pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}


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
<!----// Javascript voor input focus ------------>

 sfFocus = function() {
    var sfEls = document.getElementsByTagName("INPUT");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onfocus=function() {
            this.className+=" sffocus";
        }
        sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfFocus);
     -->
 }
     
</script>
</head>
<body>


<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);


//// Database gegevens. 

include ('mysqli.php');


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_voorgeloot.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>";

$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'voorgeloot'  ") ;  
$result              = mysqli_fetch_array( $qry);
$toernooi            = $result['Parameters'];	

if ($voorgeloot == 'On') {
echo $toernooi . " ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
} else {
echo "Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
}

echo "</td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>
<table>
<tr>
<td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 height='45' ><br>Terug<br>naar score</a>
</td>
<td valign='center'  >
<a href = 'index.php'><img src='images/Icon_tools.png' border=0 height='45' ><br>Instellingen</a>
</td>
</tr>
</table>
<br>
<br>
<br>

<h2>Importeer spelers uit OnTip toernooi t.b.v voorgeloot </h2>

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:11pt;font-family: Comic sans, sans-serif, Verdana'>Met behulp van deze functie kan je de deelnemers lijst van een OnTip toernooi importeren in de scorelijst van de OnTip hussel t.b.v <b>Voorgelote partijen</b>.<br>
	De namen van de teamleden van doubletten, tripletten e.d worden samengevoegd in de kolom naam. Via database beheer kan  een kolom voor een lotnummer worden ingeschakeld t.b.v. de voorgelote partijen.
</div>
<br>



<?php
// maak hulptabel leeg

mysqli_query($con,"Delete from hulp_toernooi where Vereniging_id = '".$vereniging_id."'  ") or die('Fout in schonen tabel');   


// selectie toernooi
$query = "insert into hulp_toernooi (Toernooi, Vereniging, Vereniging_id, Datum) 
( select Toernooi,Vereniging, Vereniging_id, Waarde from config     where Vereniging_id = '".$vereniging_id."' and Variabele ='datum' group by Vereniging, Vereniging_id, Toernooi,Waarde   )" ;
//echo $query;

mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 


$update = mysqli_query($con,"UPDATE hulp_toernooi as h
 join config as c
  on c.Vereniging_id        = h.Vereniging_id 
  set h.Toernooi_voluit    = c.Waarde 
 where c.Toernooi         = h.Toernooi
   and c.Variabele        ='toernooi_voluit' 
   and c.Vereniging_id    = '".$vereniging_id."'  ");
   

$toernooien = mysqli_query($con,"SELECT h.Toernooi,  Waarde , Datum from config as c
 join hulp_toernooi as h
  on c.Vereniging_id        = h.Vereniging_id and
     c.Toernooi          = h.Toernooi 
   where c.Variabele     = 'toernooi_voluit' 
     and c.Vereniging_id    = '".$vereniging_id."' order by Datum ");
 
 
$toernooien        = mysqli_query($con,"SELECT * from hulp_toernooi  where Vereniging_id = ".$vereniging_id."              ORDER BY Datum DESC" )       or die('Fout in select');  
$aantal_toernooien = mysqli_num_rows($toernooien);
$color= 'black';

if ($voorgeloot == 'On') {     
?>
	<form action="import_spelers_ontip_stap2.php" method="POST" >
<TABLE width= 60%>
	<TR>
		<td style='text-align:left;color:blue;font-size:10pt;font-family:arial;' width=30% > Selecteer toernooi uit de lijst</td>
	   <td>
	   	
	   
	   	<SELECT name='toernooi' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:480px;vertical-align:top;'  id="selectBox"  >
  <?php
   //    echo "<option  
        while($row = mysqli_fetch_array( $toernooien )) {
  	           $var = substr($row['Datum'],0,10);
 	           
 	           
 	           
	      echo "<OPTION  value='".$row['Toernooi']."' >";
    	  echo $row['Datum'] . "  ". $row['Toernooi_voluit']." (".$row['Toernooi'].") ";
    	  echo "</OPTION>";	
    	  $i++;
       }  // end while toernooien
      
     ?>
    </SELECT>
    
   
             	     <INPUT style ='font-size:12pt;color;darkblue;font-weight:bold;' type='submit' value='Ophalen'>
    </FORM>     


</td>
</tr>
<tr>
<td></td><td Style='font-size:10pt;font-family:verdana;background-color:white;text-align:left;'><input  type ='checkbox'      name ='Check' value ='Ja'>Zet hier een vinkje indien de score lijst voor <b><?php echo $datum ; ?></b> eerst geschoond moet worden.</td></tr>
</TABLE>
<?php
}
else { ?>
	<span style='color:red;font-size:11pt;'> Alleen te gebruiken indien Voorgeloot is geselecteerd !!!</spaN>
<?php } ?>
	
</center>

<br>


</body>
</html>

