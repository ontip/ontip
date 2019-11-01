<?php 
# beheer_bevesigigingen_stap1.php
# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 9mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

# 20jun2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Status IM0 (import) verwijderd uit selectie
# Reference: 

# 31oct2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              Include versleutelstring in dt programma opgenomen omdat dit problemen gaf
# Feature:          PHP7
# Reference: 


?>
<html>
<head>
<title>OnTip - beheer bevestigingen, betalingen en voorlopige inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/utility.js"></script>
<script src="js/popup.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
TH {color:blue ;background-color:white; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left;padding: 4px; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding: 4px;}
a    {text-decoration:none;color:blue;font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black
         
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
function changeFunc7(challenge) {
    document.myForm.respons.value= challenge;
   }
   
function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>
</head>

<?php 
ob_start();

include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


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
$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'
               and Status in ('BE0','BE1','BE2','BE3','BE8','BE9','BED', 'BEG', 'ID0')  order by Inschrijving ASC" )    or die(mysql_error());  
               
// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              

if ($soort_inschrijving =='single'){
	$soort_inschrijving= 'tete-a-tete';
}

if (!isset($sms_bevestigen_zichtbaar_jn)){
	$sms_bevestigen_zichtbaar_jn = 'N';
}

  
//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Beheer bevestigingen - <?php echo  $toernooi_voluit; ?>";
</script> 
	

<!-----  Divs tbv help teksten ---------------------------------------------->
<DIV onclick='event.cancelBubble = true;' class='popup' id='popup' >Het veld Status kan de volgende waarden hebben:<br>
	
	<h4>Reserves</h4>
	<ul>
    <li> RE0  =  Reservering aangemaakt en gemeld via Email.
    <li> RE1  =  Reservering aangemaakt. Geen email bekend.
    <li> RE2  =  Reservering geannuleerd en gemeld via Email.
    <li> RE3  =  Reservering geannuleerd. Geen email bekend.
    <li> RE4  =  Reservering aangemaakt en bevestigd via SMS.
    <li> RE5  =  Reservering geannuleerd en gemeld via SMS.
  </ul>
  
 <h4>Bevestigingen en Betalingen</h4>
	
	<ul>
		<li> BE0   =  Voorlopige inschrijving via Email gemeld.
		<li> BE1   =  Voorlopige inschrijving. Geen Email bekend.
		<li> BE2   =  Betaald maar nog niet bevestigd
		<li> BE3   =  Betaald. Geen email bekend.
		<li> BE4   =  Betaald en bevestigd
    <li> BE5   =  Geannuleerd maar nog niet gemeld.
    <li> BE6   =  Geannuleerd en via email gemeld.
    <li> IN3   =  Geannuleerd en gemeld via SMS.
    <li> BE7   =  Geannuleerd. Geen email bekend.
    <li> BE8   =  Nog niet bevestigd. Betaling nvt
    <li> BE9   =  Nog niet bevestigd. Betaling nvt. Geen email bekend.
    <li> BEA   =  Bevestigd. Betaling nvt. 
    <li> BEB   =  Bevestigd. Betaling nvt. Geen email bekend
    <li> BEC   =  Bevestigd. Nog niet betaald.
    <li> BED   =  Voorlopige inschrijving via SMS gemeld.
    <li> BEE   =  Bevestigd via SMS.
    <li> BEF   =  Geannuleerd en via email gemeld en gemeld via SMS.
   	<li> BEG   =  Inschrijving vervallen als gevolg van limiet.
	  <li> ID0   =  Inschrijving wacht op betaling via IDEAL.
 	  <li> ID1   =  Inschrijving betaald via IDEAL.
 	  <li> ID2   =  Betaling via IDEAL mislukt of afgebroken.
  </UL>

 <h4>Overig</h4>

    <ul>
     <li> DEL   =  Door deelnemer ingetrokken inschrijving (via mail).
     <li> IN0   =  Ingeschreven en gemeld via mail
     <li> IN1   =  Ingeschreven. Geen mail bekend.
     <li> IN2   =  Ingeschreven en gemeld via SMS.
     <li> IM0   =  Inschrijving geimporteerd. Niet bevestigd.
     <li> IM1   =  Inschrijving geimporteerd. Bevestigd via Mail.
     <li> IM2   =  Inschrijving geimporteerd. Bevestigd via SMS.
     </ul>		
		<a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>
<!-----  Divs tbv help teksten ---------------------------------------------->



<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Beheer bevestigingen, betalingen en voorlopige inschrijvingen</h3>


<borderquote>
<span style='color:black;font-size:10pt;font-family:arial;'>Een voorlopige inschrijving kan definitief gemaakt worden of geannuleerd. Hieronder staan de inschrijvingen die nog niet definitief zijn.
      <br>Van een inschrijving wordt hieronder alleen de eerste speler getoond.  Als je op <font color=blue>(info)</font>  in de kopregel klikt, krijg je een lijst met alle mogelijke waarden voor 'status'.<br>	    
       Klik op de tekst 'Klik hier om te selecteren' om een inschrijving aan te passen. Na aanpassing verdwijnt de inschrijving uit deze lijst.</span> <br>
     <br>
     <span style='color:black;font-size:10pt;font-family:arial;'>Soort toernooi : <?php echo $soort_inschrijving; ?></span>
     	 <br><br>

 <table border = 1 id='MyTable1'  cellpadding=0 cellspacing =0   style='margin-left:25pt;'>
         <tr>
            <th >Nr.</th>
             <th >Naam 1</th>
            <th >Vereniging 1</th>
            <th >Telefoon</th>
            <th >E-mail</th>
            <th>Tijdstip inschrijving</th>
            <th>Status <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a></th>
            <th>Betekenis status</th>
            <th>Actie</th>
          </tr>  
          
  <?php
  /// Detail regels

$i=1;                        // intieer teller 

while($row = mysqli_fetch_array( $qry )) {?>
	
	       
    <tr>
	            <td style='text-align:right;padding:5pt;' id='normaal'><?php echo $i;?>.</td>
	           	<td><?php echo $row['Naam1'];?></td>
	           	<td><?php echo $row['Vereniging1'];?></td>
	           	
	           	
	           		<?php
	           	 if ($row['Telefoon'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo $row['Telefoon'];?></td>
	           	 	<?php }?>  	
	     	 	  		<?php
	           	 if ($row['Email'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo $row['Email'];?></td>
	           	 	<?php }  ?>  	
	      	 <td><?php echo $row['Inschrijving'];?></td>
	      	 <td><?php echo $row['Status'];?></td>
	      	 <td>
	      	 	 <?php switch ($row['Status']){ 
	      	 	 	  case "BE1": $stats_oms="Voorlopige inschrijving. Geen Email bekend.";break;
	      	 	 	  case "BE2": $stats_oms="Betaald maar nog niet bevestigd.";break;                
                case "BE3": $stats_oms="Betaald. Geen email bekend.";break;                     
                case "BE5": $stats_oms="Geannuleerd maar nog niet gemeld.";break;               
                case "BE8": $stats_oms="Nog niet bevestigd. Betaling nvt.";break;               
                case "BE9": $stats_oms="Nog niet bevestigd. Betaling nvt. Geen email bekend.";break;
                case "BEG" :$stats_oms="Inschrijving vervallen als gevolg van limiet.";break;
                case "BED": $stats_oms="Voorlopige inschrijving via SMS gemeld.";break;         
                case "ID0": $stats_oms="Inschrijving wacht op betaling via IDEAL.";break;       
                case "ID2": $stats_oms="Betaling via IDEAL mislukt of afgebroken.";break;       
                
	              default   : $stats_oms="Onbekende status.";break;
	           } ;?>
 	   
 	   <?php echo $stats_oms;?>
	      	 </td>
	   	     <td><a href = "beheer_bevestigingen_stap2.php?id=<?php echo $row['Id'];?>&toernooi=<?php echo $toernooi;?>"  target ='_self'>Klik hier om te selecteren</a></td>
	           </tr> 
	  	        
<?php
$i++;
};
?>
</table>



</blockquote>

<?php
ob_end_flush();
?> 
</body>
</html>

