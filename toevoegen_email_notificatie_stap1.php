<?php 
# toevoegen_email_notificaties_stap1.php
# aanmelden voor notificaties
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 26jun2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Ook SMS mogelijk
# Reference: 
?>
<html>
<head>
<title>Toevoegen Email notificatie voor toernooi</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {color:darkgreen;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 10t;background-color:white;}
tab.th {color:blue;font-size:11pt;background-color:white;}      
td {color:darkgreen;font-size: 10pt;padding:3pt;}
a    {text-decoration:none;color:blue;font-size: 8pt;}
li  {font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }

#del   {background-color:red;border: 1pt solid red;} 

.tab  {color:blue;font-size:11pt;background-color:white;text-align:left;padding:5pt;}  
.sel  {color:black;font-size:11pt;background-color:white;text-align:left;padding:5pt;}  


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
function make_blank()
{
	document.Form1.Opmerkingen.value="";
}

function make_blank_spam2()
{
	document.Form2.respons.value="";
}

function make_blank_spam()
{
	document.Form1.respons.value="";
}


function change(that, fgcolor, bgcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}  
</Script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<?php 
ob_start();

include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
ini_set('display_errors', 'On');
error_reporting(E_ALL);

?>
<body bgcolor=white>
<?php


$toernooi = $_GET['toernooi'];
$string = '';
if (isset($_GET['smal'])){
$smal = $_GET['smal'];
}

//// SQL Queries
if (isset($toernooi)) {
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
		exit;
	};
$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

// Ophalen  gegevens
$qry3             = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS'];
$trace             = $row3['Mail_trace'];
$url_logo          = $row3['Url_logo']; 
$grootte_logo      = $row['Grootte_logo'];
?>

<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">


<?php
if (!isset($smal)){?>

<!--table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '<?php echo $url_logo;?>' width='<?php echo $grootte_logo;?>'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/-->
<?php } ?>
<br>
<blockquote>
<div style='color:black;font-size:10pt;font-family:verdana;'>Zoals je gemerkt hebt is het toernooi momenteel volgeboekt. Wil je toch graag deelnemen aan dit toernooi,dan kan je je aanmelden voor een email of SMSnotificatie.
	Indien een deelnemer zijn of haar inschrijving intrekt of de organisatie verwijdert een inschrijving, zal OnTip direct een Email of SMS sturen naar de personen die zich hiervoor hebben opgegeven. <br>
  In het Email bericht dat u dan krijgt staat een link naar het OnTip inschrijf formulier. Als u deze link gebruikt voorkomt u dat u na inschrijving nogmaals notificaties ontvangt. Mocht iemand u voor zijn, dan blijven de notificaties verstuurd worden als er nog een plek vrijkomt.
<br>
   Na invullen van deze pagina wordt u toegevoegd aan de Email of SMS notificaties voor dit toernooi. U krijgt hiervan een bevestiging op het opgegeven email adres.<br>
   SMS notificaties zijn alleen beschikbaar als de vereniging zich heeft aangemeld voor de SMS dienst.</div><br>


<FORM action='toevoegen_email_notificatie_stap2.php' method='post' name ='Form1'>

<input type='hidden' name='toernooi'       value='<?php echo $toernooi;?>'/>
<input type='hidden' name='vereniging_id'  value='<?php echo $vereniging_id;?>'/>
<br>
 
<fieldset style='border:1px solid <?php echo $koptekst; ?>;width:60%;padding:15pt;background-color:white' >
    <legend style='left-padding:5pt;color:<?php echo $koptekst; ?>;font-size:11pt;font-family:verdana;'>Ik wil toegevoegd worden aan de Email notificaties voor dit toernooi&nbsp&nbsp</legend>

<font face='comic sans ms,sans-serif' color='white'>Vul hier je gegevens in.</font>

<table border = '0'>
<tr><th width='150' class='tab'>Toernooi</th><td style='font-size:12pt;font-weight:bold;'><?php echo $toernooi_voluit;?></td></tr>
<tr><th width='150' class='tab'>Datum</th><td style='font-size:12pt;font-weight:bold;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));?></td></tr>
<tr><th width='150' class='tab'>Naam    *</th><td><input type='text'  name='Naam'       size=40/></td></tr>
<tr><th class='tab'>Vereniging </th><td><input type='text'  name='Vereniging_speler'    size=40/></td></tr>
<tr><th class='tab'>Email*    </th><td><input type='text'            name='Email'       size=40/></td></tr>

<?php
if ( $verzendadres_sms !=''){?>
<tr><th class='tab'>Telefoon (SMS)    </th><td><input type='text'            name='Telefoon'       size=40/></td></tr>
<?php } else { ?>
<tr><th class='tab'>Telefoon (SMS)    </th><td style='color:red;'>Vereniging heeft geen OnTip SMS dienst.</td></tr>
<?php }  ?>



</table>
<br>
<br>
   <div class="g-recaptcha" data-sitekey="6LcuBVcUAAAAAHAIiFktH8ZZ22fLeBGKujfN-4ss"></div>
   <br>
   
<br><br>
<INPUT type='submit' value='Gegevens versturen' >
</FORM>
</fieldset>
</blockquote>
<?php

ob_end_flush();
?> 
</body>
</html>

