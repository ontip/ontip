<?php
# beheer_bevestigingen_stap2.php
#
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 5apr2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          PHP7
# Reference: 

# 31oct2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              Include versleutelstring in dt programma opgenomen omdat dit problemen gaf
# Feature:          PHP7
# Reference: 

?>
<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:blue ;background-color:white; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left;padding: 4px; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding: 4px;}
a    {text-decoration:none;color:blue;}
 input:focus, input.sffocus  { background: lightblue;cursor:underline; }
 textarea:focus { background: lightblue;cursor:underline; }
 .popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black
         
         
 
// --></style>
<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("TEXTAREA");
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

<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<script type="text/javascript">
	
function make_blank_opmerkingen()
{
	document.myForm.Opmerkingen.value="";
}

function make_blank_spam()
{
	document.myForm.respons.value="";
}
</Script>

</head>
<body>
 
<?php
// Database gegevens. 
include('mysqli.php');	
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
//include ('../ontip/versleutel_string.php'); // tbv telnr en email
include ('../boulamis/versleutel_string.php'); // tbv telnr en email




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
$sql      = mysqli_query($con,"SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres_md5 = '".md5($ip_adres)."' and Aangelogd = 'J'  ") or die(' Fout in select'); 
$result   = mysqli_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

$id         = $_GET['id'];
$toernooi   = $_GET['toernooi'];


//// SQL Query. 

$qryIns     = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Id = ".$id." " )    or die('Fout in select inschrijving:'.$id);  
$result     = mysqli_fetch_array( $qryIns );           
 
  $Email            = $result['Email'];
  $Email_encrypt    = $result['Email_encrypt'];
 
 if ($Email =='[versleuteld]'){ 
$Email           = versleutel_string($Email_encrypt);    
}
 
   $Telefoon         = $result['Telefoon'];
  $Telefoon_encrypt         = $result['Telefoon_encrypt'];
 
 if ($Telefoon =='[versleuteld]'){ 
$Telefoon            = versleutel_string($Telefoon_encrypt);    
}
 
                          
// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in toernooi:'.$toernooi);  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              
	
if ($soort_inschrijving =='single'){
	$soort_inschrijving= 'tete-a-tete';
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
   	<li> BEG   =  Inschrijving vervallen als gevolg van limiet.</li>
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
<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>
<span style='text-align:right;'><a href='beheer_bevestigingen_stap1.php?toernooi=<?php echo $toernooi;?>'>Terug naar selectie</a></span>
<?php


 if ($sms_bevestigen_zichtbaar_jn == 'J'){
      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<div style='text-align:center;margin-left:250pt;'  width=100%><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></div>";
      
  }
?>
<blockquote>
<h3 style='margin-left:20pt;font-size:20pt;color:green;'>Muteer inschrijving status - bevestigingen of annuleringen</h3>


<span style='color:black;font-size:10pt;font-family:arial;'>In dit scherm kan je een voorlopige inschrijving definitief maken of een afwijzing laten versturen. Eventueel kan een voorlopige inschrijving ook worden omgezet in een reservering.
      <br>Van een inschrijving wordt hieronder alleen de eerste speler getoond. 	    
      Een kopie van de inschrijving of afmelding wordt verstuurd naar de organisatie (<b><?php echo $email_organisatie; ?></b>).<br>
      </span> <br>

      
       	<fieldset  width=60%   style ='border:1pt solid black;'>
       	<legend  style= 'color:red;'>Geselecteerde inschrijving</legend>
       	<br>
       	 <table border = 1 id='MyTable1'  cellpadding=0 cellspacing =0   style='margin-left:25pt;'>
         <tr>
            <th >Soort toernooi</th>
            <th >Naam 1</th>
            <th >Vereniging 1</th>
            <th >Telefoon</th>
            <th >E-mail</th>
            <th>Tijdstip inschrijving</th>
            <th>Status <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a></th>
            <th>Betekenis status</th>
          </tr>  
    <tr>
    	 	<td><?php echo $soort_inschrijving;?></td>
	           	<td><?php echo $result['Naam1'];?></td>
	           	<td><?php echo $result['Vereniging1'];?></td>
	           	
	           	
	           		<?php
	           	 if ($result['Telefoon'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo $Telefoon;?></td>
	           	 	<?php }?>  	
	     	 	  		<?php
	           	 if ($result['Email'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo $Email;?></td>
	           	 	  	
	           	 	  	
	           	 	  	
	           	 	  	
	           	 	  	
	           	 	<?php }  ?>  	
	      	 <td><?php echo $result['Inschrijving'];?></td>
	      	 <td><?php echo $result['Status'];?></td>
	      	 <td>
	      	 	 <?php switch ($result['Status']){ 
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
	   	 
	           </tr> 
	  	         </table>   
	  	         <br>
	       </fieldset>                  
	<br>
		<fieldset  width=60%   style ='border:1pt solid blue;'>                        
	<legend  style= 'color:red;'>Aanpassen status bevestiging voor geselecteerde inschrijving</legend>                
	<br>    
	<FORM action='beheer_bevestigingen_stap3.php' name ='myForm'  method='post'>

<input type='hidden' name ='zendform'        value = "1"/> 
<input type='hidden' name ='id'              value = "<?php echo $id;?>"/>         
<input type='hidden' name ='toernooi'        value = "<?php echo $toernooi;?>"/>         

<table border = 0 id='MyTable1'  cellpadding=0 cellspacing =0   style='margin-left:25pt;'>
         <tr>
            <th style= 'vertical-align:top;border:1pt solid white;padding-right:9pt;'  >Zet een vinkje bij de gewenste status, vul de antispam code in<br>en klik op 'Keuze bevestigen'.<br><em  style='font-size:7pt;color:darkgreen;'>Kan vervolgens alleen via Muteren inschrijvingen hersteld worden.<br>Tussen[] staat de nieuwe waarde voor 'status'.</em></th>
            <td style= 'vertical-align:top;border:1pt solid black;font-size:8pt;'><u> Opties bevestigen:</u><br><br>
            	<input type='radio' name='status' value ='BEA' > Bevestigen via Email.[BEA]<br>
            	<input type='radio' name='status' value ='BEB'> Bevestigen. Geen Email bekend.  [BEB]<br>
            	
           		<input type='radio' name='status' value ='BE3'> Bevestigen. Geen Email bekend. Inschrijving is betaald (indien IDEAL NIET geactiveerd).[BE3]<br>
            	<input type='radio' name='status' value ='BE4'> Bevestigen via Email. Inschrijving is betaald (indien IDEAL NIET geactiveerd).[BE4]<br>
              <input type='radio' name='status' value ='ID2'> Bevestigen via Email. Inschrijving is betaald via IDEAL (indien IDEAL geactiveerd).[ID2]<br>
             <?php
              if ($sms_bevestigen_zichtbaar_jn  == 'J'){?>
              <input type='radio' name='status' value ='IN2'> Bevestigen melden via SMS (indien SMS dienst geactiveerd).[IN2]<br>
             <?php } ?>
              <br>
            </td><td style= 'vertical-align:top;border:1pt solid black;font-size:8pt;'><u>Opties annuleren:</u><br><br>
             <?php if ($result['Status'] !='DEL'){?>
            	<input type='radio' name='status' value ='BE7'> Annuleren.  Geen Email bekend.[BE7]<br>
            	<input type='radio' name='status' value ='BE6'> Annuleren via Email melden.[BE6]<br>
           		<input type='radio' name='status' value ='DEL'> Inschrijving verwijderen.<br>
            <?php }
              if ($sms_bevestigen_zichtbaar_jn  == 'J'){?>
              <input type='radio' name='status' value ='IN3'> Annulering melden via SMS (indien SMS dienst geactiveerd).[IN3]<br>
             <?php } ?>
 	          </td>
 	           </td><td style= 'vertical-align:top;border:1pt solid black;font-size:8pt;'><u>Opties reserveren:</u><br><br>
 	           
             	<input type='radio' name='status' value ='RE0'> Omgezet naar reservering en melden via Email.[RE0]<br>
            	<input type='radio' name='status' value ='RE1'> Omgezet naar reservering. Geen Email bekend.[RE1]<br>
            	
            	<br>
            </td>
          </tr>
        </table>

<?php
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
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink" Value='Typ hier code' style='font-size:10pt;' onclick="make_blank_spam();" >
        	
    <span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc7(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
   <?php
  
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>   
  </td>
  </tr>
  </table>
    <br>
<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op 'Keuze bevestigen' om dce status aan te passen en evt mail of SMS te laten versturen. Van ieder mailbericht ontvangt u een kopie. Afhankelijk van de instellingen ontvangt u eventueel een aflever rapport van het SMS bericht.</b></span><br><br>
<INPUT type='submit' value='Keuze bevestigen' >
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_bevestigingen.php?toernooi=<?php echo $toernooi; ?>')">
</FORM>
</fieldset  >                                                                     

</blockquote>
</body>
</html>
                                