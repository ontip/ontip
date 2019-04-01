<?php
# beheer_cyclus_datums.php.
# definieren van de datums voor een cyclus
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 1apr2019         -            E. Hendrikx 
# Symptom:   		   None.
# Problem:     	   None.
# Fix:             PHP7 en aantal datums van 10 naar 20
# Reference: 
?>

<html>
<head>
<title>OnTip - beheer datums toernooi cyclus</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/utility.js"></script>
<script src="js/popup.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
TH {color:white ;background-color:blue; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left;padding: 4px; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding: 4px;}
a  {text-decoration:none;color:blue;font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }

</style>
 
<script type="text/javascript">
 <!--
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


function make_blank()
{
	document.myForm.respons.value="";
}
function make_datum_blank()
{
	
	document.getElementById("datum").value="";
}

function changeFunc7(challenge) {
    document.myForm.respons.value= challenge;
   }
   


</script>
</head>

<?php 
ob_start();

include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

?>
<body bgcolor=white>
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

//// Check op rechten
$sql      = mysqli_query($con,"SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres = '".$ip_adres."' and Aangelogd = 'J'  ") or die(' Fout in select'); 
$result   = mysqli_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

$toernooi = $_GET['toernooi'];

//// SQL Queries
//$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'
//              and Status in ('BE0','BE1','BE2','BE3','BE8','BE9','BED', 'BEG', 'IM0', 'ID0')  order by Inschrijving ASC" )    or die(mysql_error());  
               
// Ophalen toernooi gegevens

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              

// als er nog geen datum in zit,dan toernooi datum vast toevoegen

$count     = 0;
$qry      = mysqli_query($con,"SELECT * From toernooi_datums_cyclus where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' order by Datum" )     or die(' Fout in select1');  
$count    = mysqli_num_rows($qry);

if ($count == 0){
   mysqli_query($con,"insert into toernooi_datums_cyclus (Id, Vereniging_id, Vereniging, Toernooi,Datum, Laatst) 
                   values (0, ".$vereniging_id.",'".$vereniging."','".$toernooi."','".$datum."', now() )") ;	
}
  
//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Beheer datums toernooi cyclus - <?php echo  $toernooi_voluit; ?>";
</script> 
	



<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>
<span style='text-align:right;'><a href='beheer_ontip.php?toernooi=<?php echo $toernooi;?>&tab=1'>Terug naar Config</a></span><br>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Beheer datums voor Toernooi Cyclus "<?php echo $toernooi_voluit;?>"</h3>


<borderquote>
<span style='color:black;font-size:10pt;font-family:arial;'>Een toernooi cyclus bestaat uit een aantal toernooien (max 10) volgens een bepaald formaat. In dit scherm kan je datums (max 20) koppelen aan dit toernooi om een cyclus aan te maken. De eerste datum is gelijk aan de opgegeven datum voor het toernooi.<br>
	De datums worden automatisch op volgorde gesorteerd.<br>
	Indien gewenst kan je een afwijkende speellocatie opgeven die als extra informatie op het formulier wordt getoond.<br>	    
      Wijzigingen zijn niet direct zichtbaar in de OnTip kalender. Forceer de aanmaak van een actuele kalender via de link in de kalender.
  </span>  
     	 <br><br>

		<form method = 'post' action='update_toernooi_cyclus.php' target="_top" name='myForm'>
		<blockquote>  
			<table width=60%  border =1 style='border:1px solid #000000;' cellpadding=0 cellspacing=0 width=60%>
		   <tr><th   style='font-size:12pt;font-family:verdana;font-weight:bold;text-align:center;background-color:red;'> X </th>
		      <th>Datum nr</th><th>Invoer datum</th><th>Datum tekst</th>
		      <th>Afwijkende locatie </th></tr>
		   	
		   	 <input type='hidden'  name = 'vereniging_id'      value ="<?php echo $vereniging_id;?>" />
			   <input type='hidden'  name = 'vereniging_naam'    value ="<?php echo $vereniging;?>" />
	       <input type='hidden'  name = 'toernooi'           value ="<?php echo $toernooi;?>" />			
	        
			 <?php
			          $qry      = mysqli_query($con,"SELECT * From toernooi_datums_cyclus where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' order by Datum" )     or die(' Fout in select2');  
                    
                    $i=1;
                    while($row = mysqli_fetch_array( $qry )) {
	
	                  $id = $row['Id'];
	                  $_datum = $row['Datum'];
	                  $dag   = 	substr ($_datum , 8,2); 
                    $maand = 	substr ($_datum , 5,2); 
                    $jaar  = 	substr ($_datum , 0,4); 
	                  
	                  ?>
			         		 		<tr>
			         		 			<?php
			         		 			// niet verwijderen als datum = toernooi datum
			         		 			 if ($datum != $_datum){?>
			              		 			<td style='color:black;text-align:center;'><input type='checkbox' name='Delete[]' value ='<?php echo $id;?>' unchecked></td>
			         		 			<?php } else {?>
			         		 			<td></td>
			         		 		<?php } ?>		         		 			
            			 			<td  style='font-weight:bold;font-family:verdana;'>Datum <?php echo $i;?></td><td style='font-size:12pt;font-family:verdana;text-align:center;'>
			 			       	        <input  style='font-size:12pt;font-family:verdana;' type = 'text' name = 'datum_<?php echo $id;?>'  value ="<?php echo $_datum;?>" size =12></td>
			 			       	  <td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
			 			       	  <td style='padding-left: 2px;padding-right: 0px;border:1px solid #000000;' >
			 			       	  	   <input  style='font-size:11pt;font-family:verdana;' type = 'text' name = 'locatie_<?php echo $id;?>'  value ="<?php echo $row['Locatie'];?>" size =40></td>
			 			</tr>
			 			
			 		<?php 
			 		$i++;
			 		}?> 		
			 			 
			 	<tr>
			 		<td  style='text-align:center;'>+</td><td>Extra Datum </td>
			 		<td  style='font-size:12pt;font-family:verdana;text-align:center;'>
			 		<input onclick="make_datum_blank()" style='font-size:11pt;font-family:verdana;border:1pt solid red;font-weight:bold;' type = 'text' name = 'datum_new' id='datum' value ="jjjj-mm-dd" size =12></td>
		  <td colspan =2 style='padding-left: 2px;padding-right: 0px;border:1px solid #000000;font-weight:bold;color:blue;'>  <-- Vul hier de datum in  van de volgende dag.</td></tr>
  </table><br><div style='font-weight:bold;font-family:verdana;font-size=10pt;' >Zet Vinkje in vakje voor verwijderen van een datum. Voeg een Datum toe of pas een van de datums aan en klik op 'Klik hier na invullen'.  <br>
  	<span style='color:red;'>Vul alleen een locatie in als deze afwijkt van de standaard locatie!!</span><br><br></div>
  
  
  <input type ='submit' value= 'Klik hier na invullen'> 
</form>

<?php
ob_end_flush();
?> 
</body>
</html>

