<html>
<head>
<title>Beheer reserve inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>
<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:brown;font-size: 8pt;background-color:white;}
td {color:brown;font-size: 10pt;background-color:white;}
a    {text-decoration:none;color:blue;font-size 9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black
         

</style>
 <!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
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
</Script>
<script type="text/javascript">
	function make_blank()
{
	document.myForm.respons.value="";
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

// Database gegevens. 
include('mysql.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
// 6 jul 2018 EHE  versleutel_string voor Email
include ('../ontip/versleutel_string.php'); // tbv telnr en email

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


if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}


if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
?>


<body bgcolor=white>
<?php

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Beheer reserveringen - <?php echo  $toernooi_voluit; ?>";
</script>

<?php


 //// SQL Queries
$qry      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Status in ('RE0', 'RE1','RE4') order by Inschrijving  ASC" )    or die(mysql_error());  

if (!isset($sms_bevestigen_zichtbaar_jn)){
	$sms_bevestigen_zichtbaar_jn = 'N';
}

 $qry2        = mysql_query("SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ;  
 $result2     = mysql_fetch_array( $qry2);
 $sender_sms = $result2['Verzendadres_SMS'];

/// bereken sms tegoed

if ($sms_bevestigen_zichtbaar_jn == 'J'){
 $qry1      = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select sms aantal');  
 $result1   = mysql_fetch_array( $qry1);
 $max_aantal_sms  =  $result1['Max_aantal_sms'];
 
 $qry2        = mysql_query("SELECT count(*) as Aantal From sms_confirmations where Vereniging  = '".$vereniging."' ")     or die(' Fout in select sms gebruikt');  
 $result2     = mysql_fetch_array( $qry2 );
 $sms_aantal  = $result2['Aantal'];
 
 $sms_tegoed = ($max_aantal_sms - $sms_aantal);
 
 if ($sms_tegoed < 1){
  $sms_bevestigen_zichtbaar_jn = 'N'; 	
 }

}	


?>
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
    <li> BEF   =  Geannuleerd en gemeld via SMS.
 	  <li> ID0   =  Inschrijving betaald via IDEAL.
 	  <li> ID1   =  Betaling via IDEAL mislukt of afgebroken.
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
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;font-size:9pt;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Beheer reserve inschrijvingen</h3>

<blockquote>
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

echo "<span style='color:black;font-size:10pt;font-family:arial;'>In dit scherm kan een reserve team of speler alsnog een bevestiging van inschrijving krijgen (bijv na opzegging van een ander team) of een afwijziging.
      <br>Een kopie van de inschrijving wordt verstuurd naar <b>".$email_organisatie."</b>.
      <br>Na selectie op de knop bevestigen drukken onder aan de  pagina.</span> <br><br> <br>";
?>

<FORM action='muteer_reserveringen.php' method='post' name='myForm'>

<input type= 'hidden' name = 'toernooi'       value = '<?php echo $toernooi; ?>'/>

<table border =2 id='MyTable1'>
<tr>
<th width=30>Nr</th>
<th >Naam 1</th>
<th >Vereniging</th>
<th >E-mail</th>
<th >Telefoon</th>
<th >Inschrijving</th>
<th >Definitief bevestigen (via mail of SMS)</th>
<th >Afzeggen (via mail of SMS)</th>
<th colspan =2>Status

<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a>

<?php
echo "</th>";
echo "</tr>";


/// Detail regels

$i=1;                        // intieer teller 

while($row = mysql_fetch_array( $qry )) {
	
	
	 if ($row['Email'] == ''){
   	  $row['Email'] = 'onbekend.';
   	}
   	
   if ($row['Telefoon'] == ''){
   	  $row['Telefoon'] = 'onbekend.';
   	}
   	
	 echo "<tr>";
   echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
  
   
   echo "<td>".$row['Naam1']."</td>"; 
   echo "<td>".$row['Vereniging1'].".</td>"; 
   
   // 6 jul 2018
   $email = $row['Email'];
   if ($email =='[versleuteld]'){
   	$email =  versleutel_string($row['Email_encrypt']);
   }

   echo "<td>".$email.".</td>";
   
   // 6 jul 2018
    $telefoon = $row['Telefoon'];
   if ($telefoon =='[versleuteld]'){
   	$telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }
    
   
   echo "<td>".$telefoon.".</td>";
   echo "<td>".$row['Inschrijving']."</td>"; 
   
      
 
     if ( $row['Status'] == 'RE0'  or  $row['Status'] == 'RE1'  ){
     echo "<td style='color:green;'>";
       
       if ($row['Email'] !='onbekend.' ){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Reservering bevestigen via Mail ?"; 
       }
        
        if ($row['Email'] =='onbekend.' ){ 
           echo "Kan niet bevestigd worden via Email"; 
       }   
   
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
       
        
          
       if ($row['Email'] !='onbekend.' ){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NA'   unchecked> Reservering afwijzen via Mail?"; 
        }
          
      
          
        if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Kan niet geanulleerd worden via SMS of Email"; 
       }   
          
      echo "</td>";
   }   
  
    if ($row['Status']  =='RE4' and $sms_bevestigen_zichtbaar_jn == 'J'){
        echo "<td style='color:green;'>";
     
     
      if ($row['Telefoon'] != 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JS'   unchecked> Reservering bevestigen via SMS ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !=''){ 
           echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Reservering bevestigen via Mail ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JA'   unchecked> Reservering bevestigen via Mail ?"; 
       }
        
       if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Kan niet bevestigd worden via SMS of Email"; 
       }   
   
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
       
        if ($row['Telefoon'] != 'onbekend.'){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NS'   unchecked> Reservering afwijzen via SMS?"; 
        }
          
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !='onbekend.'){ 
          echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NA'   unchecked> Reservering afwijzen via Mail?"; 
        }
          
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NM'   unchecked> Reservering afwijzen via Mail?"; 
        }
          
        if ($row['Email'] =='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "Kan niet geanulleerd worden via SMS of Email"; 
       }   
      echo "</td>";
      
     }
  
 
  if ( ($row['Status'] == 'RE4' ) and $sms_bevestigen_zichtbaar_jn == 'N'){
       echo "<td style='color:green;'>";
     
             
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !=''){ 
           echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JM'   unchecked> Reservering bevestigen via Mail ?"; 
       }
       
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
           echo "<input type='checkbox' name='Bevestigen[]' value ='";
           echo $row['Id'];
           echo "-JA'   unchecked> Reservering bevestigen via Mail ?"; 
       }
        
        if ($row['Email'] =='onbekend.' ){ 
           echo "Kan niet bevestigd worden via Email"; 
       }   
   
       echo "</td>";
       echo "<td style='color:red;' colspan =2 >";
       
                  
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] !='onbekend.'){ 
          echo "<br><input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NA'   unchecked> Reservering afwijzen via Mail?"; 
        }
          
       if ($row['Email'] !='onbekend.' and $row['Telefoon'] == 'onbekend.'){ 
          echo "<input type='checkbox' name='Bevestigen[]' value ='";
          echo $row['Id'];
          echo "-NM'   unchecked> Reservering afwijzen via Mail?"; 
        }
          
        if ($row['Email'] =='onbekend.' ){ 
           echo "Kan niet geanulleerd worden via Email"; 
       }   
          
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
        	
   <?php
   echo "<span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'><b>". $string."</b></span>
   <em><span style='font-size:9pt;'><em> <-- code.</span></em>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
  </td>
  </tr>
  </table>

<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op Bevestigen om mails of SMS te versturen. Van ieder mailbericht ontvangt u een kopie.Afhankelijk van de instellingen ontvangt u eventueel een aflever rapport van het SMS bericht.</b></span><br><br>
<INPUT type='submit' value='Bevestigen' >
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_reserveringen.php?toernooi=<?php echo $toernooi; ?>')">
</FORM>
</blockquote>

<?php
ob_end_flush();
?> 
</body>
</html>

