<?php
# beheer_boulemaatje_stap1.php.
# aanmelden zonder boule partner of juist op zoek naar een
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 11apr2019         -            E. Hendrikx 
# Symptom:   		   None.
# Problem:     	   None.
# Fix:             PHP7 
# Reference: 
?>
<html>
<head>
<title>Beheer Boule Maatje </title>
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

include('mysqli.php');
?>
<body bgcolor=white>
<?php

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

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}


ini_set('display_errors', 'On');
error_reporting(E_ALL);

$string = '';

//// SQL Queries
if (isset($toernooi)) {
	
	$qry_sel      = mysqli_query($con,"SELECT * from boule_maatje Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Naam " )    or die(mysql_error());  


	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
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
 
$qry_sel      = mysqli_query($con,"SELECT * from boule_maatje Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Naam " )    or die(mysql_error());  

/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

?>

<body bgcolor="white">


<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<table >
<tr><td STYLE ='font-size:20pt; color:green'> Beheer Boulemaatje gezocht</td>
<td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/boule_maatje.png' width=150></td>
</tr> 
</table>

<br>
<div style='color:black;font-size:11pt;font-family:arial;'>In dit scherm kun je status van een boulemaatje aanpassen of verwijderen uit de lijst.<br>
       Na invullen van deze pagina wordt een mail gestuurd naar de organisatie.</div><br>


<FORM action='beheer_boulemaatje_stap2.php' method='post' name = 'Form2'>

<input type='hidden' name='toernooi'    value='<?php echo $toernooi;?>'/>
<input type='hidden' name='vereniging'  value='<?php echo $vereniging;?>'/>

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
<th >Soort</td>
<th >Status</td>
</tr>

<?php

/// Detail regels

$i=1;                        // intieer teller 

while($row = mysqli_fetch_array( $qry_sel )) {

if ($row['Soort_aanvraag'] =='R') { $status = 'Reserve'; }

echo "<tr>"; 
	 echo "<td style='text-align:right;padding:5pt;background-color:#ffdab9;'>";
   echo "<input type='checkbox' name='Delete[]' value ='";
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
   
   switch ($row['Soort_aanvraag']){  
     case 'B': echo "Boule maatje" ; break; 
     case 'R': echo "Reserve"      ; break;  
   } // end switch
   
   echo "</td>";
   echo "<td class='sel'>";
   
   $id = $row['Id'];
   echo "<input type='hidden' Name = 'Id-".$i."' value = '".$id."' />" ;
    
   
   if ($row['Soort_aanvraag'] == 'B'){
   switch ($row['Status']){
     case 'B': ?>
                    <input  type ='radio' name='Status-<?php echo $i;?>' Value='B' checked />Boule maatje gezocht<br>
                    <input  type ='radio' name='Status-<?php echo $i;?>' Value='O' />Gekoppeld, team nog niet compleet<br>
                    <input  type ='radio' name='Status-<?php echo $i;?>' Value='K' />Gekoppeld en ingeschreven
               <?php ; break;
     case 'O': ?>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='B' />Boule maatje gezocht<br>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='O' checked />Gekoppeld, team nog niet compleet<br>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='K' />Gekoppeld en ingeschreven
              <?php ; break;           
     case 'K': ?>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='B' />Boule maatje gezocht<br>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='O' />Gekoppeld, team nog niet compleet<br>
                   <input  type ='radio' name='Status-<?php echo $i;?>' Value='K' checked />Gekoppeld en ingeschreven
              <?php ; break;
      
    } // end case
  } else {
  	echo "Beschikbaar als reserve";
  }
    
   echo "</td>";
	 ECHO "</tr>"; 
$i++;
};
$i--;

?>
</table>
<input type='hidden' name='aantal_records'    value='<?php echo $i;?>'/>

<br><span style='color:black;font-size:10pt;font-family:arial;'><i>Zet een kruisje in het vakje voor de speler(s) die u wilt verwijderen.
</span>


<br><br>
<INPUT type='submit' value='Selectie keuze bevestigen' >
</FORM>

<?php

ob_end_flush();
?> 
</body>
</html>

