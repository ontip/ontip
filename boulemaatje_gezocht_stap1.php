<?php
# boulemaatje_gezocht_stap1.php
# Zoeken op opgeven als speelmaatje
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 18okt2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Ontbrekende vars
# Fix:              Opgelost
# Feature:          None.
# Reference: 
#
?>
<html>
<head>
<title>Boule Maatje gezocht</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 10t;background-color:white;}
tab.th {color:blue;font-size:11pt;background-color:white;}      
td {color:brown;font-size: 10pt;padding:3pt;}
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
</head>

<?php 
ob_start();

include('mysql.php');
?>
<body bgcolor=white>
<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL);

$toernooi = $_GET['toernooi'];
$string = '';

if ($toernooi ==''){
	echo "Geen toernooi bekend!";
	exit;
}

//// SQL Queries
if (isset($toernooi)) {
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	};

$tekstkleur = 'black'; 
$koptekst   = 'red';

switch($soort_inschrijving){
    case 'single' :   $soort = 'mêlée';     break;
    case 'doublet' :  $soort = 'doubletten'; break;
    case 'triplet' :  $soort = 'tripletten'; break;
    case 'kwintet' :  $soort = 'kwintetten'; break;
    case 'sextet' :   $soort = 'sextetten';  break;
 }
  
/// Ophalen tekst kleur

$qry        = mysql_query("SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$row        = mysql_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$link       = $row['Link'];


 
$qry_sel      = mysql_query("SELECT * from boule_maatje Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Naam " )    or die(mysql_error());  


/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


?>


<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">

<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/boule_maatje.png' width=200></td>
<td STYLE ='font-size: 36pt; color:green'> Boulemaatje gezocht</td></tr> 
<tr><td STYLE ='font-size: 20pt; color:blue'><?php echo $toernooi_voluit ?><br>
	<?php   	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?> 
	
	</TD></tr>
</TABLE>

<hr color='red'/>
<br>
<div style='color:black;font-size:11pt;font-family:arial;'>Wil je graag deelnemen aan dit toernooi, maar heb je geen boule maatje?<br> 
       Via deze pagina kan je je opgeven als boule maatje of reserve of kan je een selectie maken uit spelers die ook een maatje zoeken.<br>
       Na invullen van deze pagina wordt een mail gestuurd naar de organisatie.</div><br>


<FORM action='boulemaatje_gezocht_stap2.php' method='post' name ='Form1'>

<input type='hidden' name='toernooi'    value='<?php echo $toernooi;?>'/>
<input type='hidden' name='vereniging'  value='<?php echo $vereniging;?>'/>
<input type='hidden' name='status'      value='I'/>
 
<fieldset style='border:1px solid <?php echo $koptekst; ?>;width:95%;padding:15pt;background-color:white'>
    <legend style='left-padding:5pt;color:<?php echo $koptekst; ?>;font-size:16pt;font-family:<?php echo $font_koptekst; ?>;'>Ik wil deelnemen, maar ik heb geen maatje&nbsp&nbsp</legend>

<font face='comic sans ms,sans-serif' color='white'>Vul hier je gegevens in.</font>

<table border = '0'>
<tr><th width='150' class='tab'>Naam    *</th><td><input type='text'  name='Naam'       size=40/></td></tr>
<tr><th class='tab'>Vereniging *</label></th><td><label><input type='text'  name='Vereniging_speler'    size=40/></label></td></tr>
<tr><th class='tab'>Licentie </label></th><td><label><input type='text'    name='Licentie'             size=10/></label></td></tr>
<tr><th class='tab'>Boule maatje of reserve   </label></th><label>
    <td class='sel'><label><input  type ='radio' name='Soort' Value='B' />Boule maatje</label><br>
         <label><input  type ='radio' name='Soort' Value='R' />Reserve</label></td></tr>

<tr><th class='tab'>Email    *</th><td><label><input type='text'  name='Email'       size=40/></label></td></tr>
<tr><th class='tab'>Telefoon    *</th><td><label><input type='text'  name='Telefoon'       size=40/></label></td></tr>
<tr>
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	  $string = '';
	  $length = 4;
	  
	  if( !isset($string )) { $string = '' ; }
	  
    $characters = "123456789234567819";
    if( !isset($string )) { $string = '' ; }
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
       
?>
	 <th class='tab' >Anti Spam</th>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="18" class="pink" Value='Typ hier code woord' style='font-size:10pt;' onclick="make_blank_spam();" >
        	
   <?php
   echo "<span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'><b>". $string."</b></span>
   <em><span style='font-size:9pt;'><em> <-- code woord.</span></em>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>
<tr><th class='tab'>Opmerkingen    </th>
	<td><textarea name='Opmerkingen' onfocus="change(this,'black','lightblue')
      	   onblur="change(this,'black','#F2F5A9');" rows='4' cols='45' onclick="make_blank();">Typ hier evt opmerkingen.
          </textarea></td></tr>
</table>
<br><br>
<INPUT type='submit' value='Gegevens versturen' >
</FORM>
</fieldset>

<br>

<fieldset style='border:1px solid <?php echo $koptekst; ?>;width:95%;padding:15pt;background-color:white;'>
    <legend style='left-padding:5pt;color:<?php echo $koptekst; ?>;font-size:16pt;font-family:<?php echo $font_koptekst; ?>;'>Selecteren boulemaatje&nbsp&nbsp</legend>

<br>
<div style='color:black;font-size:11pt;font-family:arial;'>Het betreft hier een <b><?php echo $soort; ?></b> toernooi.</div><br>

<FORM action='boulemaatje_gezocht_stap3.php' method='post' name = 'Form2'>

<input type='hidden' name='toernooi'    value='<?php echo $toernooi;?>'/>
<input type='hidden' name='vereniging'  value='<?php echo $vereniging;?>'/>
<input type='hidden' name='status'      value='B'/>

<b><div style='color:red;font-size:12pt;font-family:arial;text-decoration:underline;'>Mijn gegevens :</div><br></b>


<table border = '0'>
<tr><th width='250' class='tab'>Naam    *</th><td><input type='text'  name='Naam'       size=40/></td></tr>
<tr><th class='tab'>Vereniging *</label></th><td><label><input type='text'  name='Vereniging_speler'    size=40/></label></td></tr>
<tr><th class='tab'>Licentie </label></th><td><label><input type='text'    name='Licentie'             size=10/></label></td></tr>
<tr><th  class='tab'>Bevestiging naar Email    *</th><td><label><input type='text'  name='Email'       size=40/></td></tr>
<tr><th class='tab'>Telefoon    *</th><td><label><input type='text'  name='Telefoon'       size=40/></label></td></tr>

<tr>
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	  $string = '';
	  $length = 4;
	  
	  if( !isset($string )) { $string = '' ; }
	  
    $characters = "123456789234567819";
    if( !isset($string )) { $string = '' ; }
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
       
?>
	 <th class='tab' >Anti Spam</th>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="18" class="pink" Value='Typ hier code woord' style='font-size:10pt;' onclick="make_blank_spam2();" >
        	
   <?php
   echo "<span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'><b>". $string."</b></span>
   <em><span style='font-size:9pt;'><em> <-- code woord.</span></em>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>
</table>
<br><br><b>
<div style='color:blue;font-size:12pt;font-family:arial;text-decoration:underline;'>Beschikbare spelers.</div><br></b>


<br>
<table border =2>
<tr>
<th colspan = 1 style= 'color:red;font-weight:bold;'>x</th>
<th >Naam</th>
<th >Vereniging</th>
<th >Licentie</th>
<th>Tel.nr</th>
<th >E-mail</th>
<th >Opmerking</th>
<th >Status</td>
</tr>

<?php

/// Detail regels

$i=1;                        // intieer teller 

while($row = mysql_fetch_array( $qry_sel )) {

switch($row['Status'] ){
    case 'B' :   $status = 'Op zoek naar boulemaatje';     break;
    case 'O' :   $status = 'Gekoppeld, team nog niet compleet'; break;
    case 'K' :   $status = 'Gekoppeld en ingeschreven'; break;
    default  :   $status = 'Op zoek naar boulemaatje';     break;

 }

if ($row['Soort_aanvraag'] =='R') { $status = 'Reserve'; }

echo "<tr>"; 
	 echo "<td style='text-align:right;padding:5pt;background-color:#ffdab9;'>";
   echo "<input type='checkbox' name='Select[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
   echo "<td>";
   echo $row['Naam'];
   echo "</td>";
	 echo "<td>";
   echo $row['Vereniging_speler'];
   echo "</td>";
   echo "<td>";
   echo $row['Licentie'];
   echo "</td>";
	 echo "<td>";
   echo $row['Telefoon'];
   echo "</td>";
   echo "<td>";
   echo $row['Email'];
   echo "</td>";
   echo "<td>";
   echo $row['Opmerkingen'];
   echo "</td>";
   echo "<td>";
   echo $status;
   echo "</td>";
	 ECHO "</tr>"; 
$i++;
};

?>
</table>
<br><span style='color:black;font-size:10pt;font-family:arial;'><i>Zet een kruisje in het vakje voor de speler(s) met wie u zou willen spelen. De organisatie zal de teams samenstellen en voor de inschrijving zorgen.
</span>


<br><br>
<INPUT type='submit' value='Selectie keuze bevestigen' >
</FORM>

<?php

ob_end_flush();
?> 
</body>
</html>

