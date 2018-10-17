<html>
<head>
<title>OnTip - beheer bevestigingen, betalingen en voorlopige inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/utility.js"></script>
<script src="js/popup.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:black;font-size: 8pt;background-color:white;}
td {color:black;font-size: 10pt;background-color:white;}
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

include('mysql.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


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

$toernooi = $_GET['toernooi'];


if (isset($_GET['sort'])){
	
$key = $_GET['sort'];
}
else { 
	$key = 'Inschrijving';
}

//// SQL Queries
$qry      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'
               and Status in ('BE0','BE1','BE2','BE3','BE8','BE9','BED', 'IM0', 'ID0')  order by ".$key." ASC" )    or die(mysql_error());  
               
// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysql_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              

if (!isset($sms_bevestigen_zichtbaar_jn)){
	$sms_bevestigen_zichtbaar_jn = 'N';
}

 $qry2        = mysql_query("SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ;  
 $result2     = mysql_fetch_array( $qry2);
 $sender_sms = $result2['Verzendadres_SMS'];
   
   
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
    <li> BE7   =  Geannuleerd. Geen email bekend.
    <li> BE8   =  Nog niet bevestigd. Betaling nvt
    <li> BE9   =  Nog niet bevestigd. Betaling nvt. Geen email bekend.
    <li> BEA   =  Bevestigd. Betaling nvt. 
    <li> BEB   =  Bevestigd. Betaling nvt. Geen email bekend
    <li> BEC   =  Bevestigd. Nog niet betaald.
    <li> BED   =  Voorlopige inschrijving via SMS gemeld.
    <li> BEE   =  Bevestigd via SMS.
    <li> BEF   =  Geannuleerd en via email gemeld en gemeld via SMS.
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

<?php


 if ($sms_bevestigen_zichtbaar_jn == 'J'){
      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></blockquote><br>";
      
      if ($sender_sms  == ''){
       echo "<div style='background-color: white;color:red;font-size:10pt;padding:8pt;'>**  Voor ".$vereniging." is de SMS dienst nog niet geactiveerd. </div><br>";
       $sms_bevestigen_zichtbaar_jn = 'N';

     }
 }
?>

<span style='color:black;font-size:10pt;font-family:arial;'>In dit scherm kan je na betaling van een inschrijving een inschrijving definitief maken en een definitieve bevestiging laten versturen of een afwijzing laten versturen.
      <br>Van een inschrijving wordt hieronder alleen de eerste speler getoond. 	    
      <br>Een kopie van de inschrijving of afmelding wordt verstuurd naar <b><?php echo $email_organisatie; ?></b>.<br>
      <br>Na selectie op de knop bevestigen drukken onder aan de  pagina. Er kunnen meerdere regels tegelijk geselecteerd worden om te wijzigen. Via de keuze optie in de kolom Reset kan een bevestiging worden teruggezet naar de oorspronkelijke status.</span> <br><br>
      
<FORM action='muteer_bevestigingen.php' method='post' name= 'myForm'>

<input type='hidden' name ='toernooi'  value ='<?php echo $toernooi; ?>' >

<?php
////  Koptekst

echo "<table border =2 id='MyTable1'>";
echo "<tr>";
echo "<th width=30>Nr</th>";
echo "<th >Naam 1</th>";
echo "<th >Vereniging 1</th>";
echo "<th >E-mail</th>";
echo "<th >Telefoon</th>";
echo "<th >Inschrijving</th>";
echo "<th colspan =3>Omschrijving of Maak een keuze</th>";
echo "<th colspan =1 style='color:red;'>Reset</th>";
echo "<th colspan =2>Status"; 

?>
<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a>
<?php
echo "</th>";
echo "</tr>";

/// Detail regels

$i=1;                        // intieer teller 

while($row = mysql_fetch_array( $qry )) {
	
	 echo "<tr>";
   echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
     
   if ($row['Email'] == ''){
   	  $row['Email'] = 'onbekend.';
   	}
   	
   if ($row['Telefoon'] == ''){
   	   $row['Telefoon'] = 'onbekend.';
   }
   if (strlen($row['Telefoon']) < 10){
   	   $row['Telefoon'] = 'onbekend.';
   }
   	
   	
   	
   echo "<td>".$row['Naam1']."</td>"; 
   echo "<td>".$row['Vereniging1']."</td>"; 
   echo "<td>".$row['Email']."</td>";
   echo "<td>".$row['Telefoon']."</td>";
   echo "<td>".$row['Inschrijving']."</td>"; 
    
   /// uitgestelde bevestiging BE0 = nog niet betaald. Email bekend  BE1 = nog niet betaald. Email niet bekend             (BETAALID))
   
   if (  $row['Status']  == 'BE0' or $row['Status']   == 'BE1'   ){
   	  echo "<td style='color:blue;' ><input type='checkbox' name='Bevestigen[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Via mail bevestigen ?"; 
      echo "</td>";
    	echo "<td style='color:black;'><input type='checkbox' name='Betaald[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Betaald ?"; 
      echo "</td>";
      echo "<td style='color:red;'><input type='checkbox' name='Bevestigen[]' value ='";
      echo $row['Id'];
      echo "-NX'   unchecked> Annuleren ?"; 
      echo "</td>";
      echo "<td>N.v.t</td>";
      echo "<td style='color:blue;'>Wacht op bevestiging, betaling of annulering.</td>";
    }
 
   /// uitgestelde bevestiging BE2  = wel betaald nog niet bevestigd.                (BEVESTIGID)
  
  if ($row['Status']   == 'BE2'){
      echo "<td style='color:green;' colspan =2>Betaald : ".$row['Betaal_datum']."</td>";  
      echo "<td style='color:blue;' ><input type='checkbox' name='Bevestigen[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Via mail bevestigen ?"; 
      echo "</td>";
      echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
      echo "<td style='color:blue;'>Betaald. Moet nog bevestigd worden.</td>";
  }
    
   /// uitgestelde bevestiging BE3   =  Betaald. Geen email bekend.                 (BEVESTIGID)
   
    if ($row['Status']   == 'BE3'){
      echo "</td>"; echo "<td colspan =2 style='color:green;'>Betaald : ".$row['Betaal_datum']."</td>";  
      echo "<td  style='color:blue;'>Geen email bekend. Betaling op andere manier doorgeven.</td>";  	
   }
 
   /// uitgestelde bevestiging J  BE4  =  Betaald en bevestigd               (EIND STATUS)      
  
    if ($row['Status']   == 'BE4'){
       echo "<td style='color:green;' colspan = 2>Betaald: ".$row['Betaal_datum']."</td>"; 
       	echo "<td colspan= 1 style='color:green;'>Bevestigd : ".$row['Bevestiging_verzonden']."</td>";  
       echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
       echo "<td style='color:green;'>Betaald en bevestigd.</td>";  	          
    }     
 
   /// uitgestelde bevestiging J  BE5  = niet betaald en  afgewezen   (F)                (EIND STATUS)
    
   if ($row['Status']   == 'BE5'){
   	   echo "</td>"; 
       echo "<td style='color:red;' colspan = 3><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-NX'   unchecked> Afwijzing via mail bevestigen ?"; 
       echo "</td>";
       echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
       echo $row['Id'];
       echo "-JX'   unchecked> Ongedaan maken ?"; 
       echo "</td>";
       echo "<td style='color:blue;' >Annulering not niet bevestigd.</td>";  	
    }
    
    if ($row['Status']   == 'BE6'){
    	  echo "</td>"; 
        echo "<td colspan =3 style='color:red;'>Afwijzings mail verzonden: ".$row['Bevestiging_verzonden']."</td>";  	
        echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
        echo $row['Id'];
        echo "-JX'   unchecked> Ongedaan maken ?"; 
        echo "</td>"; 	
        echo "<td style='color:blue;' >Inschrijving geannuleerd.</td>";  	
    }
    
    if ($row['Status']   == 'BE7'){
      echo "</td>"; 
      echo "<td colspan =3 style='color:red;'>Afgewezen.Geen email bekend. Op andere manier doorgeven.</td>";  	
      echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>"; 	
      echo "<td style='color:blue;' >Inschrijving geannuleerd.</td>";  	
   }
     
   /// uitgestelde bevestiging BE8  = nog niet bevestigd.  betaling nvt               (BEVESTIGID)
  
 if ($row['Status']   == 'BE8'   ){
       echo "<td style='color:blue;' colspan = 1><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-JX'   unchecked> Inschrijving bevestigen ?"; 
       echo "</td>";
       echo "<td style='color:red;' colspan =2 ><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-NX'   unchecked> Inschrijving afwijzen ?"; 
       echo "</td>";
          echo "<td>N.v.t</td>";
       echo "<td style='color:blue;' >Inschrijving bevestigen of annuleren.</td>";  	
 }

if ($row['Status']   == 'BE9' ){
       echo "<td style='color:blue;' colspan = 1><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-JX'   unchecked> Inschrijving bevestigen (geen email bekend) ?"; 
       echo "</td>";
       echo "<td style='color:red;' colspan =2 ><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-NX'   unchecked> Inschrijving afwijzen ?"; 
       echo "</td>";
          echo "<td>N.v.t</td>";
       echo "<td style='color:blue;' >Inschrijving bevestigen of annuleren.</td>";  
 }
 
 if ($row['Status']   == 'BEA'){                                                      //     (EIND STATUS)
    	echo "<td colspan= 3 style='color:green;'>Bevestigd : ".$row['Bevestiging_verzonden']."</td>";  
      echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
      echo "<td style='color:blue;' >Bevestigd via email.</td>";  	
      
 }        
    
 if ($row['Status']   == 'BEB'){                                                      //     (EIND STATUS)
    	echo "<td colspan = 3 style='color:green;'>Bevestigd : ".$row['Bevestiging_verzonden']."</td>";  
    	echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
      echo "<td style='color:blue;' >Geen email bekend. Bevestiging op andere manier doorgeven.</td>";  	
 }        
 
 if ($row['Status']   == 'BEC'){                                                      //     
    	echo "<td colspan = 1 style='color:green;'>Bevestigd : ".$row['Bevestiging_verzonden']."</td>";  
           echo "<td style='color:black;' colspan =2><input type='checkbox' name='Betaald[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Betaald ?"; 
      echo "</td>";
      echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
      echo "<td style='color:blue;' >Bevestigd. Wacht op betaling.</td>";  	
 }    
 
   /// m.b.t IDEAL betalingen                                                   

if ($row['Status']   == 'ID0'   or  $row['Status']   == 'ID2'){                                                      //     
      echo "<td style='color:blue;' colspan = 1><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-JX'   unchecked> Inschrijving bevestigen  ?"; 
       echo "</td>";
       echo "<td style='color:red;' colspan =2 ><input type='checkbox' name='Bevestigen[]' value ='";
       echo $row['Id'];
       echo "-NX'   unchecked> Inschrijving afwijzen ?"; 
       echo "</td>";
 
       echo "<td>N.v.t</td>";
      echo "<td style='color:blue;' >Nog niet bevestigd. Wacht op IDEAL betaling.</td>";  	
 }    
 
 
 if ($row['Status']   == 'ID1'){                                                          //  (EIND STATUS)
    	echo "<td style='color:green;' colspan =3 >Betaald : ".$row['Betaal_datum']."</td>";  
    	echo "<td style='color:red;' ><input type='checkbox' name='Reset[]' value ='";
      echo $row['Id'];
      echo "-JX'   unchecked> Ongedaan maken ?"; 
      echo "</td>";
            echo "<td style='color:blue;' colspan= 1>Betaald via IDEAL en bevestigd...</td>";  	
      
 }     
 
 
    //// mbt Sms bevestiging
 
 
 if (($row['Status']   == 'BED' )  and $sms_bevestigen_zichtbaar_jn == 'J') {
       echo "<td style='color:blue;' colspan = 1>";
 
   
       if ($row['Telefoon'] != 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JS'   unchecked> Inschrijving bevestigen via SMS ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !=''){ 
           echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Inschrijving bevestigen via Mail ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JA'   unchecked> Inschrijving bevestigen via Mail ?"; 
       }
        
        if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Kan niet bevestigd worden via SMS of Email"; 
       }   
           
           
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
       
        if ($row['Telefoon'] != 'onbekend.'){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NS'   unchecked> Inschrijving afwijzen via SMS?"; 
        }
          
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !='onbekend.'){ 
          echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NA'   unchecked> Inschrijving afwijzen via Mail?"; 
        }
          
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NM'   unchecked> Inschrijving afwijzen via Mail?"; 
        }
          
        if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Kan niet geanulleerd worden via SMS of Email"; 
       }   
          
          
          
          echo "</td>";
          echo "<td>N.v.t</td>";
          echo "<td style='color:blue;' >Inschrijving bevestigen of annuleren.</td>";  	
    }

   //// mbt Import                                                      (IM0)
 
 
 if (($row['Status']   == 'IM0' )  and $sms_bevestigen_zichtbaar_jn == 'J') {
       echo "<td style='color:blue;' colspan = 1>";
 
   
       if ($row['Telefoon'] != 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JS'   unchecked> Geimporteerde inschrijving bevestigen via SMS ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !=''){ 
           echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Geimporteerde inschrijving bevestigen via Mail ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Geimporteerde inschrijving bevestigen via Mail ?"; 
       }
        
        if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Geimporteerde inschrijving kan niet bevestigd worden via Email of SMS."; 
       }   
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
          
       echo "</td>";
       echo "<td>N.v.t</td>";
       echo "<td style='color:blue;' >Inschrijving bevestigen.</td>";  	
    }
    
 if (($row['Status']   == 'IM0' )  and $sms_bevestigen_zichtbaar_jn == 'N') {
       echo "<td style='color:blue;' colspan = 1>";
      
       
       if ($row['Email'] !='onbekend.' ){ 
           echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Geimporteerde inschrijving bevestigen via Mail ?"; 
       }
       
        
        if ($row['Email'] =='onbekend.' ){ 
           echo "Geimporteerde inschrijving kan niet bevestigd worden via Email."; 
       }   
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
          
       echo "</td>";
       echo "<td>N.v.t</td>";
       echo "<td style='color:blue;' >Inschrijving bevestigen</td>";  	
    }
    
    
    
 // delete verzoek ongedaan maken
 
 if ($row['Status']   == 'DEL'){
     echo "<td style='color:blue;'><input type='checkbox' name='Bevestigen[]' value ='";
     echo $row['Id'];
     echo "-JX'   unchecked> verwijderen bevestigen ?"; 
     echo "</td>";
     echo "<td style='color:red;'><input type='checkbox' name='Bevestigen[]' value ='";
     echo $row['Id'];
     echo "-NX'   unchecked> inschrijving weer activeren ?"; 
     echo "</td>";
    }
 
  
      
  echo "<td style='color:blue;'>".$row['Status']."</td>";  	
  echo "</tr>";
$i++;
};

echo "</table>";


//////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $length = 4; 
	  $string = "";
	  if( !isset($string )) { $string = '' ; }
	  
      $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ;
       
?>
<br>
 <table>
     <tr>
	 <td width="190" style='font-size:10pt; color:bluetext-align:left;font-family:courier;padding:5pt;'><em>Anti Spam </em></td>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink" Value='Typ hier code' style='font-size:10pt;' onclick="make_blank();" >
        	
    <span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc7(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
   <?php
  
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>   
  </td>
  </tr>
  </table>

<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op Bevestigen om mails of SMS te versturen. Van ieder mailbericht ontvangt u een kopie.Afhankelijk van de instellingen ontvangt u eventueel een aflever rapport van het SMS bericht.</b></span><br><br>
<INPUT type='submit' value='Keuze(s) bevestigen' >
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_bevestigingen.php?toernooi=<?php echo $toernooi; ?>')">
</FORM>
</blockquote>

<?php
ob_end_flush();
?> 
</body>
</html>

