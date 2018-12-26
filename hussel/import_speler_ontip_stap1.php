<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 11pt;}
td {color:black;font-size: 12pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;}


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

include ('mysql.php');


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>
<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ></a>
</td></tr>
</table>
<br>
<br>
<br>

<h2>Importeer spelers uit OnTip toernooi </h2>

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Met behulp van deze functie kan je de deelnemers lijst van een OnTip toernooi importeren in de scorelijst van de OnTip hussel.<br>
	De namen van  de teamleden worden samengevoegd in de kolom naam. Via database beheer kan  een kolom voor een lotnummer worden ingeschakeld t.b.v. de voorgelote partijen.
</div>
<br>



<?php
// maak hulptabel leeg

mysql_query("Delete from hulp_toernooi where Vereniging_id = '".$vereniging_id."'  ") or die('Fout in schonen tabel');   


// selectie toernooi
$query = "insert into hulp_toernooi (Toernooi, Vereniging, Vereniging_id, Datum) 
( select Toernooi,Vereniging, Vereniging_id, Waarde from config     where Vereniging_id = '".$vereniging_id."' and Variabele ='datum' group by Vereniging, Vereniging_id, Toernooi,Waarde   )" ;
//echo $query;

mysql_query($query) or die ('Fout in vullen hulp_toernooi'); 


$update = mysql_query("UPDATE hulp_toernooi as h
 join config as c
  on c.Vereniging_id        = h.Vereniging_id 
  set h.Toernooi_voluit    = c.Waarde 
 where c.Toernooi         = h.Toernooi
   and c.Variabele        ='toernooi_voluit' 
   and c.Vereniging_id    = '".$vereniging_id."'  ");
   

$toernooien = mysql_query("SELECT h.Toernooi,  Waarde , Datum from config as c
 join hulp_toernooi as h
  on c.Vereniging_id        = h.Vereniging_id and
     c.Toernooi          = h.Toernooi 
   where c.Variabele     = 'toernooi_voluit' 
     and c.Vereniging_id    = '".$vereniging_id."' order by Datum ");
 
 
$toernooien        = mysql_query("SELECT * from hulp_toernooi  where Vereniging_id = ".$vereniging_id."              ORDER BY Datum DESC" )       or die('Fout in select');  
$aantal_toernooien = mysql_num_rows($toernooien);
$color= 'black';

?>
<TABLE>
	<TR>
		<td style='text-align:left;color:blue;font-size:10pt;font-family:arial;'> Selecteer toernooi uit de lijst</td>
	   <td>
	   	
	   	
	   	<SELECT name='toernooi' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:450px;vertical-align:top;'  id="selectBox"  >
  <?php
   //    echo "<option  
        while($row = mysql_fetch_array( $toernooien )) {
  	           $var = substr($row['Datum'],0,10);
 	           
 	           

 	           
 	           
	      echo "<OPTION  value='".$row['Toernooi']."' >";
    	  echo $row['Datum'] . "  ". $row['Toernooi_voluit']." (".$row['Toernooi'].") ";
    	  echo "</OPTION>";	
    	  $i++;
       }  // end while toernooien
      
     ?>
    </SELECT>
   
    <?php 
     if ($aantal_toernooien > 1) {?>
     	     <INPUT style ='font-size:12pt;color;darkblue;font-weight:bold;' type='submit' value='Ophalen'>
    <?php } ?> 	     


</td>
</tr>
</TABLE>
</center>

<br>


</body>
</html>

