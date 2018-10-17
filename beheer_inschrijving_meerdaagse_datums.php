<html>
<head>
<title>OnTip - beheer bevestigingen, betalingen en voorlopige inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/utility.js"></script>
<script src="js/popup.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
TH {color:white ;background-color:blue; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left;padding: 4px; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding: 4px;}
a    {text-decoration:none;color:blue;font-size:9pt;}
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

include('mysql.php');
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

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

//// Check op rechten
$sql      = mysql_query("SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres = '".$ip_adres."' and Aangelogd = 'J'  ") or die(' Fout in select'); 
$result   = mysql_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
// id van inschrijving
$id = $_GET['id'];

//// SQL Query
$qry      = mysql_query("SELECT * from inschrijf Where Id = ".$id." " )    or die('Fout in select inschrijving '.$id);  
$result   = mysql_fetch_array( $qry );
$deelname = $result['Meerdaags_datums'];
$naam1    = $result['Naam1'];
              
// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$result['Vereniging'] ."' and Toernooi = '".$result['Toernooi']."'  ")     or die(' Fout in select2');  

while($row2 = mysql_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              
  
//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Beheer inschrijving - <?php echo  $toernooi_voluit; ?> ";
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
<span style='text-align:right;'><a href='beheer_inschrijvingen.php?toernooi=<?php echo $toernooi;?>&tab=1'  target='_self'>Terug naar beheer</a></span><br>

<blockquote>
<h2 style='padding:10pt;font-size:20pt;color:green;'>Beheer datums voor Toernooi Cyclus "<?php echo $toernooi_voluit;?>"</h2>

<?php
if ($meerdaags_toernooi_jn =='J'){
	
	  $variabele = 'datum';
   $qry2       = mysql_query("SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags1');    
   $row2       = mysql_fetch_array( $qry2 );
   $toernooi_datum = $row2['Waarde'] ;
   
   $variabele = 'eind_datum';
   $qry2       = mysql_query("SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags2');    
   $row2       = mysql_fetch_array( $qry2 );
   $eind_datum = $row2['Waarde'] ;
             
 ?>
	<h3>Meerdaags toernooi van <?php echo $toernooi_datum;?> tot en met <?php echo $eind_datum;?></h3>
<?php } ?>

<?php
if ($meerdaags_toernooi_jn =='J'){?>
	<h2>Meerdaags toernooi</h2>
<?php } ?>

<h3>Naam 1: <?php echo $naam1;?></h3>

<borderquote>
<span style='color:black;font-size:10pt;font-family:arial;'>In dit scherm kan je datums koppelen van de inschrijving aanpassen voor een meerdaags toernooi of cyclus.<br>	    
    
  </span>  
     	 <br><br>

			<form method = 'post' action='muteer_inschrijving_meerdaagse_datums.php' target="_top" name='myForm'>
	
		<blockquote>  
			<table width=60%  border =1 style='border:1px solid #000000;' cellpadding=0 cellspacing=0 width=60%>
		   <tr>
		  <th>Datum nr</th><th>Invoer datum</th><th>Datum tekst</th></tr>
		   	
		   	 <input type='hidden'  name = 'vereniging_id'        value ="<?php echo $vereniging_id;?>" />
			   <input type='hidden'  name = 'vereniging_naam'      value ="<?php echo $vereniging;?>" />
	       <input type='hidden'  name = 'toernooi'             value ="<?php echo $toernooi;?>" />			
	       <input type='hidden'  name = 'id'                   value ="<?php echo $id;?>" />	
	       <input type='hidden'  name = 'meerdaags_toernooi_jn '      value ="<?php echo meerdaags_toernooi_jn ;?>" />
	  
	        
			 <?php
			  if ($meerdaags_toernooi_jn =='J'){   		 
			 
			$i=1;
				 
     while($toernooi_datum <=  $eind_datum){                                                               
 		       $_datum  = $toernooi_datum;                                                                       
      		 $pos     = strpos($deelname,$_datum);
          		   		                                                                                                  
           $dag   = 	substr ($_datum , 8,2);                                                               
           $maand = 	substr ($_datum , 5,2);                                                               
           $jaar  = 	substr ($_datum , 0,4);      
   
   ?>
		   		<tr>
        			<td  style='font-weight:bold;font-family:verdana;'>Datum <?php echo $i;?></td><td style='font-size:12pt;font-family:verdana;text-align:center;'>
          				
          			<?php
          			   if ($deelname !='' and $pos == true ){  ?>           	
         	 		   	  <input  style='font-size:12pt;font-family:verdana;' type = 'checkbox' name = 'datum_<?php echo $i;?>'  value ="<?php echo $toernooi_datum;?>" checked><?php echo $toernooi_datum;?>
                <?php } else {?>
         	 		   	  <input  style='font-size:12pt;font-family:verdana;' type = 'checkbox' name = 'datum_<?php echo $i;?>'  value ="<?php echo $toernooi_datum;?>" ><?php echo $toernooi_datum;?>
			 		   	  <?php }
			 		   	   ?>
			 		   	  
		 		   	  </td>
		       	  <td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
		 			</tr>		 
		 			<?php
		 			        
           $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	       $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);   
       $i++;
           
      }// end while
    }// end if    
    
     
	  if ($meerdaags_toernooi_jn =='X'){   		 
			 
			$i=1;
	
	  $datums ='';
         $sql      = mysql_query("SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row = mysql_fetch_array( $sql )) { 		
          		     $toernooi_datum = $row['Datum']; 
         		       $dag    = 	substr ($toernooi_datum  , 8,2);                                                                 
                   $maand  = 	substr ($toernooi_datum  , 5,2);                                                                 
                   $jaar   = 	substr ($toernooi_datum  , 0,4);                                                                 
	              	 $pos     = strpos($deelname,$toernooi_datum);      
   ?>
		   		<tr>
        			<td  style='font-weight:bold;font-family:verdana;'>Datum <?php echo $i;?></td><td style='font-size:12pt;font-family:verdana;text-align:center;'>
          				
          			<?php
          			   if ($deelname !='' and $pos == true ){  ?>           	
         	 		   	  <input  style='font-size:12pt;font-family:verdana;' type = 'checkbox' name = 'datum_<?php echo $i;?>'  value ="<?php echo $toernooi_datum;?>" checked><?php echo $toernooi_datum;?>
                <?php } else {?>
         	 		   	  <input  style='font-size:12pt;font-family:verdana;' type = 'checkbox' name = 'datum_<?php echo $i;?>'  value ="<?php echo $toernooi_datum;?>" ><?php echo $toernooi_datum;?>
			 		   	  <?php }
			 		   	   ?>
			 		   	  
		 		   	  </td>
		       	  <td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
		 			</tr>		 
		 			<?php
		 			        
     
       $i++;
           
      }// end while
    }// end if     
       ?>      
</table><br><div style='font-weight:bold;font-family:verdana;font-size=10pt;' >Zet Vinkje in vakje voor activeren van een datum en klik op 'Klik hier na invullen'.  <br><br></div>
  
  
  <input type ='submit' value= 'Klik hier na invullen'> 
</form>           
			
</body>
</html>

