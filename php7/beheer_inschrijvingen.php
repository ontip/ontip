<html>
<head>
<title>Muteren inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 8pt;background-color:white;}
td {color:black;font-size: 8pt;}
a    {text-decoration:none;color:blue;font-size:9pt;}
li  {font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }

#del   {background-color:red;border: 1pt solid red;} 

.nav     {background-color:lightgrey;color:black;padding:5pt;border:1px solid black;}
.nav_cur {background-color:lightgreen;color:darkgreen;padding:5pt;border:1px solid black;font-weight:bold;border:3px double black;}
.nav_sort     {background-color:black;color:white;padding:5pt;border:1px solid red;}

.tooltipx {
    display: inline;
    position: relative;
}

.nav:hover:before{background-color:lightblue;color:darkblue;padding:5pt;}
.nav:hover       {background-color:yellow;color:darkblue;padding:5pt;}

.tooltip_weg:hover:before{
    border: solid;
    border-color: #333 transparent;
    border-width: 6px 6px 0 6px;
    bottom: 20px;
    content: "";
    left: 50%;
    position: absolute;
    z-index: 99;
}

.tooltip_weg:hover:after{
    background: #333;
    background: rgba(0,0,0,.8);
    border-radius: 5px;
    bottom: 26px;
    color: #fff;
    content: attr(title);
    text-align:center;
    left: 20%;
    padding: 5px 15px;
    position: absolute;
    z-index: 98;
    width: 50px;
}
>

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
</head>

<?php 
ob_start();

include('mysqli.php');
include('versleutel_kenmerk.php'); 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

?>
<body  >
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

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}

if ($toernooi==''){
	

  ?>
   <script language="javascript">
        alert("Er is geen toernooi geselecteerd. Klik op Tab Start, Selecteer toernooi en klik op  Ophalen.")
    </script>
  <script type="text/javascript">
		window.location.replace('index.php');
	</script>
<?php
 } // geen toernooi


//// Check op rechten


if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

if (!isset($geboortedatum_invullen_jn)) {
	$geboortedatum_invullen_jn = 'N';
}

// Database gegevens. 


if (!isset($_GET['sort'])){
	$sortkey = 'Volgnummer, Inschrijving';
	}
	else {$sortkey = $_GET['sort'];
}

// Ophalen toernooi gegevens
$var              = 'toernooi_voluit';
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

if (!isset($bankrekening_invullen_jn)){
	$bankrekening_invullen_jn = 'N';
}

// uit vereniging tabel	
	
$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];
$verzendadres_sms       = $row['Verzendadres_SMS'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

 // Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];


//// navigatie bij meer dan 25 regels
$sql1       = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Toernooi = '" . $toernooi. "' and Vereniging = '".$vereniging."'  ")                  or die(' Fout in select 2');  
$result1    = mysqli_fetch_array( $sql1 );
$aant_rows  = $result1['Aantal'];

 //Voorlopige bevestiging
 
if ($uitgestelde_bevestiging_jn =='J'){
$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'uitgestelde_bevestiging_jn'  ") ;  
$result     = mysqli_fetch_array( $qry);
$limiet_bevestiging   = $result['Parameters'];
} else {
$limiet_bevestiging   = 0;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Reset volgnummer bij sortering op Inschrijving

if ($sortkey =='Inschrijving'){
         //// SQL Queries
         $qry_sort = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die(mysqli_error());  
         
         $i =1 ;
         while($row = mysqli_fetch_array( $qry_sort )) {
         
          $id = $row['Id'];
          $query="UPDATE inschrijf 
                        SET Volgnummer   = ".$i."
                  WHERE  Id           = ".$id."  ";
         
         //echo $i.".    ". $query."<br>";
          mysqli_query($con,$query) or die ('Fout in update inschrijving'); 
          $i++;
          
}; // end for i update   

}/// end if


// navigatie
$start_row =  1;

// 22-aug-2015 initieele waarden aangepast indien geen start- en endwaarde is opgegeven

// bij init  eerste 25 records
if ($aant_rows > 25 and !isset($_GET['end'])  ){
   $end_row   = 25;
}
else {
$end_row   = $aant_rows;
}

if (isset($_GET['start'])){
	$start_row =  $_GET['start'];
	echo "<input type ='hidden'  name = 'start_row' value = ". $start_row.">";
}

if (isset($_GET['end'])){
	$end_row =  $_GET['end'];
	echo "<input type ='hidden'  name = 'end_row' value = ". $end_row.">";
}


//// SQL Queries
$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by ".$sortkey." " )    or die(mysqli_error());  

?>
<!-----  Divs tbv help teksten ---------------------------------------------->
<DIV onclick='event.cancelBubble = true;' class='popup' id='popup' >Het veld Status kan de volgende waarden hebben:<br>
	
	<h4>Reserveringen</h4>
	<ul>
    <li> RE0  =  Reservering aangemaakt en bevestigd.
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
    <li> BEG   =  Inschrijving vervallen als gevolg van limiet.
 	  <li> ID0   =  Inschrijving wacht op betaling via IDEAL.
 	  <li> ID1   =  Inschrijving betaald via IDEAL.
 	  <li> ID2   =  Betaling via IDEAL mislukt of afgebroken.
  </UL>
  
 <h4>Overig</h4>

    <ul>
     <li> DE0   =  Door deelnemer ingetrokken inschrijving (via mail).
     <li> DE1   =  Door deelnemer ingetrokken inschrijving (geen mail bekend).
     <li> DE2   =  Door deelnemer ingetrokken inschrijving (via SMS).
     <li> IN0   =  Ingeschreven en bevestigd via email.
     <li> IN1   =  Ingeschreven. Geen email bekend.
     <li> IN2   =  Ingeschreven en gemeld via SMS.
     <li> IM0   =  Inschrijving geimporteerd. Niet bevestigd.
     <li> IM1   =  Inschrijving geimporteerd. Bevestigd via Mail.
     <li> IM2   =  Inschrijving geimporteerd. Bevestigd via SMS.
   </ul>
   	
     	<a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<div>
<table >
<tr><td rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<?php
echo "<a style='font-size:8pt;color:blue;text-decoration:none;' href='index.php'>Terug naar Hoofdmenu</a>";

echo "<br><br><div style='font-size:20pt;color:green;font-family:arial;font-weight:bold;margin-left:15pt;'>Muteer inschrijvingen</div>";

if ($start_row == 1){

echo "<br><span style='margin-left:15pt;color:black;font-size:10pt;font-family:arial;'>Hier kan je eventuele typefouten in de naam corrigeren of records verwijderen uit de tabel. 
       Een compleet toernooi moet verwijderd worden via het <img src='../ontip/images/prullenbak.jpg' width=20 border =0 alt='prullenbak'> icon in de beheerpagina. De gegevens worden dan in het archief opgeslagen t.b.v. statistieken.<br>";
       
echo "<br><span style='margin-left:15pt;'><u>Betekenis van de eerste kolommen :</u> <br>
       <table width=50% style='margin-left:15pt;'>
       <tr><td><span style='font-size:9pt;color:blue;text-decoration:none;font-weight:bold;padding-right:3pt;' >Nr</span></td><td> Volgnummer , eventueel aan te passen.</td>
       <td><span style='width:65pt;'><img src='../ontip/images/delete.png' width=14     border =0></td><td> Voor verwijdering van een inschrijving het vakje in deze kolom aanvinken. </td></tr>
       <tr><td><img src='../ontip/images/reset.png'      width=14 border =0></td><td> Verwisseling van volgorde van achternaam en voornaam. Dit geldt dan voor alle namen in die regel !!!.</td>
       <td><img src='../ontip/images/email_icon.jpg' width=14 border =0></td><td> Opnieuw versturen van een bevestigingsmail.</td></tr>";
       
       if ($sms_bevestigen_zichtbaar_jn  =='J'){
       
       echo"<tr><td><span style='font-size:9pt;color:darkgreen;text-decoration:none;font-weight:bold;padding-right:3pt;' > SMS</span></td><td>  Opnieuw versturen van een bevestigings SMS.</td></tr>";
     }
echo "</table></span>";


}  // verbergen uitleg bij start > 1       
       
echo "<br><span style='margin-left:15pt;color:black;font-size:10pt;font-family:arial;'>De volgorde van de inschrijvingen kan aangepast worden door het volgnummer vooraan de regel aan te passen en op Bevestigen te klikken. Door op de kolomkop 'Nr' te klikken worden de volgnummers weer opeenvolgend (zonder dubbele of gaten) gemaakt.</span> 
      <br><span style='margin-left:15pt;color:black;font-size:10pt;font-family:arial;'>Na aanbrengen van wijzingen en of verwijderen op de knop bevestigen drukken onder of boven aan de pagina.Door op <b>Originele sortering</b> te klikken wordt de lijst gesorteerd op volgorde van inschrijving. Klik daarna op Bevestigen om de volgorde op te slaan.</span>";
      
if ($aant_rows > 25){    
      echo "<br><span style='margin-left:15pt;color:black;font-size:10pt;font-family:arial;'>Bij meer dan 25 regels wordt de pagina gesplitst en dient er gebladerd te worden via de navigatie knoppen.</span> ";
}
echo "</span><br><br>";


//// Tabel 

// tabel binnen div

if (isset($_GET['start'])){
  echo "<FORM action='muteer_inschrijvingen.php?start=".$_GET['start']."&end=".$_GET['end']."&toernooi=".$toernooi. "' method='post'>";
} else { 
  echo "<FORM action='muteer_inschrijvingen.php?toernooi=".$toernooi. "' method='post'>";
}


echo "<input type = 'hidden' name = 'toernooi' value = '".$toernooi."' />";

echo "<INPUT type='submit' value='Wijziging of selectie keuze bevestigen' ><input type='button' value='Ververs pagina' onClick='document.location.reload(true)'>";




/////////////////////////////////////////////////////////////////////////////  navigatie ///////////////////////////////////////////////////////////////////////////////

if ($aant_rows > 25){
echo " <b>Klik op de reeks hiernaast om te bladeren ---  </b>  ";
}

// 13 aug 2018  aant_rows kleiner dan bovenwaarde + 1

if ($aant_rows > 25 and $aant_rows < 51){


if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=26&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 26 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=26&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 26 - ".$aant_rows."  </a>";
}
} // aant 26 - 50


if ($aant_rows > 50 and $aant_rows < 76){
	
	if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=51&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 50 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=51&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 50 - ".$aant_rows."  </a>";
}
 
} /////// aant 50 -75

if ($aant_rows > 75 and $aant_rows < 101){ 

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=76&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 76 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=76&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 76 - ".$aant_rows."  </a>";
}


} ////// // aant 75 - 100

if ($aant_rows > 100 and $aant_rows < 126){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=101&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 101 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=101&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 101 - ".$aant_rows."  </a>";
}

} /// aant 100 -125

if ($aant_rows > 125 and $aant_rows < 151){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=126&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 126 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=126&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 126 - ".$aant_rows."  </a>";
}


}/// aant 125- 150

if ($aant_rows > 150 and $aant_rows < 176){
	
if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=151&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 151 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=151&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 151 - ".$aant_rows."  </a>";
}

}  // aant 150- 175

if ($aant_rows > 175 and $aant_rows < 201){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
  echo "<a class='nav_cur' href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}

if ($start_row == 176) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=176&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 176 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=176&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 176 - ".$aant_rows."  </a>";
}


}  // aant 175 - 200

if ($aant_rows > 200 and $aant_rows < 226){
	
if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}

if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
  echo "<a class='nav_cur' href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}

if ($start_row == 176) {
  echo "<a class='nav_cur' href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}

if ($start_row == 201) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=201&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 201 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=201&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 201 - ".$aant_rows."  </a>";
}

}  // aant 200- 225

if ($aant_rows > 225 and $aant_rows < 251){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}
if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
  echo "<a class='nav_cur' href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}

if ($start_row == 176) {
  echo "<a class='nav_cur' href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}

if ($start_row == 201) {
  echo "<a class='nav_cur' href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}

if ($start_row == 226) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=226&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 226 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=226&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 226 - ".$aant_rows."  </a>";
}

} //// aant 250 - 275

if ($aant_rows > 250 and $aant_rows < 276){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}
if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
  echo "<a class='nav_cur' href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}

if ($start_row == 176) {
  echo "<a class='nav_cur' href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}

if ($start_row == 201) {
  echo "<a class='nav_cur' href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}
if ($start_row == 226) {
  echo "<a class='nav_cur' href = '".$pageName."?start=226&end=250&toernooi=".$toernooi."' target='_top'> 226 - 250  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=226&end=250&toernooi=".$toernooi."' target='_top'> 226 - 250   </a>";
}

if ($start_row == 251) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=251&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 251 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=251&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 251 - ".$aant_rows."  </a>";
}

} //// aant 250  - 275

if ($aant_rows > 275 ){

if ($start_row == 1) {
  echo "<a class='nav_cur' href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=1&end=25&toernooi=".$toernooi."' target='_top'> 1 - 25  </a>";
}
if ($start_row == 26) {
  echo "<a class='nav_cur' href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}  else {
  echo "<a class='nav'     href = '".$pageName."?start=26&end=50&toernooi=".$toernooi."' target='_top'> 26 - 50  </a>";
}

if ($start_row == 51) {
  echo "<a class='nav_cur' href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=51&end=75&toernooi=".$toernooi."' target='_top'> 51 - 75  </a>";
}

if ($start_row == 76) {
  echo "<a class='nav_cur' href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=76&end=100&toernooi=".$toernooi."' target='_top'> 76 - 100  </a>";
}

if ($start_row == 101) {
  echo "<a class='nav_cur' href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=101&end=125&toernooi=".$toernooi."' target='_top'> 101 - 125  </a>";
}

if ($start_row == 126) {
  echo "<a class='nav_cur' href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=126&end=150&toernooi=".$toernooi."' target='_top'> 126 - 150  </a>";
}

if ($start_row == 151) {
  echo "<a class='nav_cur' href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=151&end=175&toernooi=".$toernooi."' target='_top'> 151 - 175   </a>";
}

if ($start_row == 176) {
  echo "<a class='nav_cur' href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=176&end=200&toernooi=".$toernooi."' target='_top'> 176 - 200   </a>";
}

if ($start_row == 201) {
  echo "<a class='nav_cur' href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=201&end=225&toernooi=".$toernooi."' target='_top'> 201 - 225   </a>";
}

if ($start_row == 226) {
  echo "<a class='nav_cur' href = '".$pageName."?start=226&end=250&toernooi=".$toernooi."' target='_top'> 226 - 250  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=226&end=250&toernooi=".$toernooi."' target='_top'> 226 - 250   </a>";
}

if ($start_row == 251) {
  echo "<a class='nav_cur' href = '".$pageName."?start=251&end=275&toernooi=".$toernooi."' target='_top'> 251 - 275  </a>";
}  else {
    echo "<a class='nav'   href = '".$pageName."?start=251&end=275&toernooi=".$toernooi."' target='_top'> 251 - 275  </a>";
}

if ($start_row == 276) {
   echo "<a class='nav_cur'  href = '".$pageName."?start=276&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 276 - ".$aant_rows."  </a>";
}  else {
   echo "<a class='nav'      href = '".$pageName."?start=276&end=".$aant_rows."&toernooi=".$toernooi."' target='_top'> 276 - ".$aant_rows."  </a>";
}

} //// aant 275  - einde

////////////////////////////////////////////////////////  navigatie einde /////////////////////////////////////////////////

////// originele sortering 18 feb 2016
$spaces = "&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp";
echo $spaces."<a class='nav_sort'  href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=Inschrijving'>Originele sortering<a/>"; 

echo "<br><br>";

////  Koptekst

if ($soort_inschrijving =='single' or  $inschrijf_methode  == 'single' ){
	
	//  Koptekst single

echo "<table border =2>";
echo "<tr>";
echo "<th width=30><a href = 'reset_volgnummer_inschrijf.php?toernooi=".$toernooi."' alt='Volgnummers resetten'>Nr</a></th>";
echo "<th  style= 'color:red;font-weight:bold;'><img src='../ontip/images/delete.png'       width=20 border =0 alt='Verwijderen'></th>";
echo "<th  style= 'color:green;font-weight:bold;'><img src='../ontip/images/reset.png'      width=20 border =0 alt='Achternaam naar voren'></th>";
echo "<th  style= 'color:green;font-weight:bold;'><img src='../ontip/images/email_icon.jpg' width=20 border =0 alt='Herzenden mail'></th>";

if ($sms_bevestigen_zichtbaar_jn =='J'){
echo "<th  style= 'color:green;font-weight:bold;'>SMS</th>";
}

echo "<th >Naam</th>";
echo "<th >Licentie</th>";
echo "<th >Vereniging</th>";

echo "<th >Tel.nr</th>";
echo "<th >E-mail</th>";

if (!isset($bankrekening_invullen_jn)){
	$bankrekening_invullen_jn == 'N';
}

if ($bankrekening_invullen_jn == 'J'){
echo "<th >Bankreknr</th>";
}

echo "<th >Opmerking</th>";

if(isset($extra_vraag) and $extra_vraag !=''){
	   $opties = explode(";",$extra_vraag,6);
     $vraag  = $opties[0];
echo "<th >".$vraag."</th>";
};

if(isset($extra_invulveld) and $extra_invulveld != ''){
echo "<th >".$extra_invulveld."</th>";
};

 if(isset($meerdaags_toernooi_jn) and $meerdaags_toernooi_jn != 'N'){
 	echo "<th >Cyclus of meerdaags</th>"; 
}

echo "<th >Status"; 

?>
<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a>
<?php
echo "</th>";
echo "<th style='color:blue;'>Kenmerk</th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=35'>Inschrijving<a/></th>";
echo "</tr>";

}// einde single

if ($soort_inschrijving !='single' and  $inschrijf_methode  != 'single'  ){

echo "<table border = 1 >";
echo "<tr>";

if ($sms_bevestigen_zichtbaar_jn =='J'){
echo "<th colspan = 5 style= 'color:white;'>.</th>";
} else {
echo "<th colspan = 4 style= 'color:white;'>.</th>";
}

  echo "<th colspan = 3>Speler 1</th>";
  echo "<th colspan = 3>Speler 2</th>";

if ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
  echo "<th colspan = 3>Speler 3</th>";
}

if ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
  echo "<th colspan = 4>Speler 4</th>";
}

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
  echo "<th colspan = 3>Speler 5</th>";
}

if ($soort_inschrijving == 'sextet'){
  echo "<th colspan = 3>Speler 6</th>";
}

/// voor de facultatieve velden colspan bepalen

$colspan = 11;

if(isset($extra_vraag) and $extra_vraag !=''){
	$colspan++;
}

echo "<th colspan = ".$colspan." style= 'color:white;'>.</th>";
echo "</tr>";


// tweede kopregel


echo "<tr>";
echo "<th width=30><a href = 'reset_volgnummer_inschrijf.php?toernooi=".$toernooi."' alt='Volgnummers resetten'>Nr</a></th>";

echo "<th colspan = 1 style= 'color:red;font-weight:bold;'><img src='../ontip/images/delete.png' width=20 border =0 alt='Verwijderen'></th>";
echo "<th colspan = 1 style= 'color:green;font-weight:bold;'><img src='../ontip/images/reset.png' width=20 border =0 alt='Achternaam naar voren'></th>";
echo "<th colspan = 1 style= 'color:green;font-weight:bold;'><img src='../ontip/images/email_icon.jpg' width=20 border =0 alt='Herzenden mail'></th>";

if ($sms_bevestigen_zichtbaar_jn =='J'){
echo "<th  style= 'color:green;font-weight:bold;'>SMS</th>";
}


//echo "<th colspan = 1 style= 'color:green;font-weight:bold;'><img src='../ontip/images/cwj.jpg' width=20 border =0 alt='Bepaal soort licentie'></th>";

echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=5'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=6'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=7'>Vereniging</a></th>";

echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=8'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=9'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=10'>Vereniging</a></th>";


if ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=11'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=12'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=13'>Vereniging</a></th>";
}

if ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=14'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=15'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=16'>Vereniging</a></th>";
}

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=17'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=18'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=19'>Vereniging</a></th>";
}

if ($soort_inschrijving == 'sextet'){
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=20'>Naam</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=21'>Licentie</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=22'>Vereniging</a></th>";
}

echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=24'>Tel.nr</a></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=27'>E-mail</a></th>";

if (!isset($bankrekening_invullen_jn)){
	$bankrekening_invullen_jn == 'N';
}

if ($bankrekening_invullen_jn == 'J'){
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=28'>Bankreknr</a></th>";
}
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=29'>Opmerking</a></th>";

if(isset($extra_vraag)and $extra_vraag !=''){
		 $opties = explode(";",$extra_vraag,6);
     $vraag  = $opties[0];
echo "<th ><a href='lijst_inschrijf.php?toernooi=".$toernooi."&sort=30&toernooi=".$toernooi."'>".$vraag."</a></th>";
};

if(isset($extra_invulveld) and $extra_invulveld != ''){
echo "<th >".$extra_invulveld."</th>";
};

 if(isset($meerdaags_toernooi_jn) and $meerdaags_toernooi_jn != 'N'){
 	echo "<th >Cyclus of meerdaags</th>"; 
}
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=33'>Status <a/>"; 

?>
<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('popup', event)">(info)</a>
<?php
echo "</th>";

echo "<th style='color:blue;'>Kenmerk<a/></th>";
echo "<th ><a href='beheer_inschrijvingen.php?toernooi=".$toernooi."&sort=34'>Inschrijving<a/></th>";
echo "</tr>";
}

/// Detail regels
/// Bij meer dan 99 rows heeft php een probleem, dus opsplitsen in pagina's van 25

$i=1;                        // intieer teller 

if ($start_row > 1){
	for ($i=1;$i< $start_row;$i++){
	   $row = mysqli_fetch_array( $qry );
	  }
}

/// van start row tot end row

for ($i=$start_row;$i<= $end_row;$i++){
  $row = mysqli_fetch_array( $qry );


//while($row = mysqli_fetch_array( $qry )) {
	
	if ($soort_inschrijving == 'single' or  $inschrijf_methode  == 'single' ){

 echo "<tr>";
 
 // Nieuwe inschrijvingen hebben als default volgnummer 999. Oude hebben 0. Hiermee staan de inschrijvingen in de juiste volgorde bij begin muteren
 
  if ($row['Volgnummer'] == 0 or $row['Volgnummer'] == 999 ){
  	  $row['Volgnummer'] = $i;
	}	;
 
  // echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
   echo "<input type = 'hidden' name= 'volgnr' value = '".$i."' />";

/// 13 aug 2015 Volgnummer
  
   echo "<td style='text-align:right;padding:5pt;font-size:7pt;' id='normaal'>"; 
   echo "<input style='font-size:8pt;' name= 'Volgnummer-";
   echo $i;
   echo "' type='text' size='1'  value =";
   echo $row['Volgnummer'];
   echo ">";
   
   
   echo "<td style='text-align:right;padding:5pt;background-color:#d3d3d3;' class='tooltip'  title='verwijderen'>";
   echo "<INPUT TYPE='hidden' NAME='Id-";
   echo $i;
   echo "' VALUE='";
   echo $row['Id'];
   echo "'>";
   
   echo "<input type='checkbox' name='Check[]' value ='";
   echo $row['Id'];
   echo "'   unchecked alt='Verwijderen'>"; 
   echo "</td>";
   
   echo "<td style='text-align:right;padding:5pt;background-color:#ffdab9;' class='tooltip'  title='draaien'>";
   echo "<input type='checkbox' name='Draai[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";

if ($row['Email'] != '') { 
   echo "<td style='text-align:right;padding:5pt;background-color:#b0e0e6;' class='tooltip'  title='herzenden mail'>";
   echo "<input type='checkbox' name='Mail[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
 } else { 
 	 echo "<td style='text-align:right;padding:5pt;background-color:#b0e0e6;' class='tooltip'  title='herzenden mail'>";
   echo "</td>";
  }
 
if ($sms_bevestigen_zichtbaar_jn =='J' ){
 if ($row['Telefoon'] != '') { 
   echo "<td style='text-align:right;padding:5pt;background-color:#CCFFCC;' class='tooltip'  title='herzenden SMS'>";
   echo "<input type='checkbox' name='SMS[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
 } else { 
 	 echo "<td style='text-align:right;padding:5pt;background-color:#CCFFCC;' class='tooltip'  title='herzenden SMS'>";
   echo "</td>";
  }
}
 
   echo "<td>";
   echo "<input name= 'Naam1-";
   echo $i;
   echo "' type='text' size='40' maxlength='40' value ='";
   echo $row['Naam1'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Licentie1-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie1'];
   echo "'> </td>";
   
   echo "<td>";
   echo "<input name= 'Vereniging1-";
   echo $i;
   echo "' type='text' size='20'' value ='";
   echo $row['Vereniging1'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Telefoon-";
   echo $i;
   echo "' type='text' size='10'  value ='";
   
     $telefoon = $row['Telefoon'];
   if ($telefoon =='[versleuteld]'){
   	$telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }
   
   echo $telefoon;
   echo "'> </td>"; 
  
   echo "<td>";
   echo "<input name= 'Email-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   
   $email = $row['Email'];
   if ($email =='[versleuteld]'){
   	$email =  versleutel_string($row['Email_encrypt']);
   }
   
   echo $email;
   echo "'></td>";

if ($bankrekening_invullen_jn == 'J'){
   echo "<td>";
   echo "<input name= 'Bankrekening-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   echo $row['Bank_rekening'];
   echo "'></td>";
}   
   echo "<td>";
   echo "<input name= 'Opmerkingen-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   echo $row['Opmerkingen'];
   echo "'></td>"; 

if(isset($extra_vraag) and $extra_vraag != ''){
   echo "<td>";
   echo "<input name= 'Extra-";
   echo $i;
   echo "' type='text' size='50' value ='";
   echo $row['Extra'];
   echo "'></td>";
}
   
if(isset($extra_invulveld) and $extra_invulveld != ''){
   echo "<td>";
   echo "<input name= 'Extra-invulveld-";
   echo $i;
   echo "' type='text' size='80' value ='";
   echo $row['Extra_invulveld'];
   echo "'></td>";
}   


 if (isset($meerdaags_toernooi_jn) and $meerdaags_toernooi_jn != 'N'){
   echo "<td><a href ='beheer_inschrijving_meerdaagse_datums.php?id=".$row['Id']."' target='_blank' > Muteer </a>";
   echo "</td>";
}   
   
   echo "<td   >";   
   echo "<input name= 'Status-";
   echo $i;
   echo "' type='text' size='2'  value ='";
   echo $row['Status'];
   echo "' ></td>"; 

  // bereken kenmerk   
   $date = $row['Inschrijving'];
   // 012345678901234567890
   // 2011-12-21 13:46:35
   $dag    = substr ($date , 8,2);         
   $maand  = substr ($date , 5,2);         
   $jaar   = substr ($date , 0,4);     
   $uur    = substr ($date , 11,2);     
   $minuut = substr ($date , 14,2);     
   $sec    = substr ($date , 17,2);     
   $_kenmerk = $minuut.$sec.$dag.$uur;
   /// roep versleutel routine aan
   /// versleutel_licentie($waarde, $richting, $delta)
   $encrypt = versleutel_kenmerk($_kenmerk,'encrypt', 20);
   
   echo "<td>";
   echo substr($encrypt,0,4).".".substr($encrypt,4,4);
   echo "</td>";    

   echo "<td>";
   echo $row['Inschrijving'];
   echo "</td>"; 
   echo "</tr>"; 
  
  }
  
  //////////////// not single
  else {

   echo "  <tr>";

/*
   echo "<td style='text-align:right;padding:5pt;'>";
   echo $i;
   echo "</td>";
 */  
   
   //  reset volgnummer  28 aug
   
   if ($row['Volgnummer'] == 0 or $row['Volgnummer'] == 999 ){
  	  $row['Volgnummer'] = $i;
 	}	;
    
 
  // echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
   echo "<input type = 'hidden' name= 'volgnr' value = '".$i."' />";

/// 13 aug 2015 Volgnunmer
  
   echo "<td style='text-align:right;padding:5pt;font-size:7pt;' id='normaal'>"; 
   echo "<input style='font-size:8pt;' name= 'Volgnummer-";
   echo $i;
   echo "' type='text' size='1'  value =";
   echo $row['Volgnummer'];
   echo ">";
  
   
   echo "<td style='text-align:right;padding:5pt;background-color:#d3d3d3;' class='tooltip'  title='verwijderen'>";
   echo "<INPUT TYPE='hidden' NAME='Id-";
   echo $i;
   echo "' VALUE='";
   echo $row['Id'];
   echo "'>";
   echo "<input type='checkbox' name='Check[]' value ='";
   echo $row['Id'];
   echo "'   unchecked alt= 'Verwijderen'>"; 
   echo "</td>";
   
   echo "<td style='text-align:right;padding:5pt;background-color:#ffdab9;' class='tooltip'  title='draaien'>";
   echo "<input type='checkbox' name='Draai[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
 
if ($row['Email'] != '') { 
   echo "<td style='text-align:right;padding:5pt;background-color:#b0e0e6;' class='tooltip'  title='herzenden mail'>";
   echo "<input type='checkbox' name='Mail[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
 } else { 
 	 echo "<td style='text-align:right;padding:5pt;background-color:#b0e0e6;' class='tooltip'  title='herzenden mail'>";
   echo "</td>";
 }


if ($sms_bevestigen_zichtbaar_jn =='J'){
 if ($row['Telefoon'] != '') { 
   echo "<td style='text-align:right;padding:5pt;background-color:#CCFFCC;' class='tooltip'  title='herzenden SMS'>";
   echo "<input type='checkbox' name='SMS[]' value ='";
   echo $row['Id'];
   echo "'   unchecked>"; 
   echo "</td>";
}  else { 
 	 echo "<td style='text-align:right;padding:5pt;background-color:#CCFFCC;' class='tooltip'  title='herzenden SMS'>";
   echo "</td>";
  }
}
    
   echo "<td>";
   echo "<input name= 'Naam1-";
   echo $i;
   echo "' type='text' size='40' maxlength='40' value ='";
   echo $row['Naam1'];
   echo "'> </td>"; 
  
   echo "<td>";
   echo "<input name= 'Licentie1-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie1'];
   echo "'> </td>"; 
      
   echo "<td>";
   echo "<input name= 'Vereniging1-";
   echo $i;
   echo "' type='text' size='20'' value ='";
   echo $row['Vereniging1'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Naam2-";
   echo $i;
   echo "' type='text' size='40'  value ='";
   echo $row['Naam2'];
   echo "'> </td>"; 
     
   echo "<td>";
   echo "<input name= 'Licentie2-";
   echo $i;
   echo "' type='text' size='6' ' value ='";
   echo $row['Licentie2'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Vereniging2-";
   echo $i;
   echo "' type='text' size='20' value ='";
   echo $row['Vereniging2'];
   echo "'> </td>"; 
   
 
if ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td>";
   echo "<input name= 'Naam3-";
   echo $i;
   echo "' type='text' size='40'  value ='";
   echo $row['Naam3'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Licentie3-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie3'];
   echo "'> </td>"; 
      
   echo "<td>";
   echo "<input name= 'Vereniging3-";
   echo $i;
   echo "' type='text' size='20'  value ='";
   echo $row['Vereniging3'];
   echo "'> </td>"; 
 
  }
  
if ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td>";
   echo "<input name= 'Naam4-";
   echo $i;
   echo "' type='text' size='40'  value ='";
   echo $row['Naam4'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Licentie4-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie4'];
   echo "'> </td>"; 
      
   echo "<td>";
   echo "<input name= 'Vereniging4-";
   echo $i;
   echo "' type='text' size='20'  value ='";
   echo $row['Vereniging4'];
   echo "'> </td>"; 
}

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
  
   echo "<td>";
   echo "<input name= 'Naam5-";
   echo $i;
   echo "' type='text' size='40'  value ='";
   echo $row['Naam5'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Licentie5-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie5'];
   echo "'> </td>"; 
      
   echo "<td>";
   echo "<input name= 'Vereniging5-";
   echo $i;
   echo "' type='text' size='20'  value ='";
   echo $row['Vereniging5'];
   echo "'> </td>"; 
      
  }
  
  if ($soort_inschrijving ==  'sextet'){
   echo "<td>";
   echo "<input name= 'Naam6-";
   echo $i;
   echo "' type='text' size='40'  value ='";
   echo $row['Naam6'];
   echo "'> </td>"; 
   
   echo "<td>";
   echo "<input name= 'Licentie6-";
   echo $i;
   echo "' type='text' size='6'  value ='";
   echo $row['Licentie6'];
   echo "'> </td>"; 
      
   echo "<td>";
   echo "<input name= 'Vereniging6-";
   echo $i;
   echo "' type='text' size='20'  value ='";
   echo $row['Vereniging6'];
   echo "'> </td>"; 
  }
 
   echo "<td>";
   echo "<input name= 'Telefoon-";
   echo $i;
   echo "' type='text' size='10'  value ='";
   
    $telefoon = $row['Telefoon'];
   if ($telefoon =='[versleuteld]'){
   	$telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }
   
   echo $telefoon;
   echo "'> </td>"; 
  
   echo "<td>";
   echo "<input name= 'Email-";
   echo $i;
   echo "' type='text' size='26'  value ='";
  
    $email = $row['Email'];
   if ($email =='[versleuteld]'){
   	$email =  versleutel_string($row['Email_encrypt']);
   }
   
   echo $email;
   
   echo "'></td>";
   
 if ($bankrekening_invullen_jn == 'J'){
   echo "<td>";
   echo "<input name= 'Bankrekening-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   echo $row['Bank_rekening'];
   echo "'></td>";
  }
   
   echo "<td>";
   echo "<input name= 'Opmerkingen-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   echo $row['Opmerkingen'];
   echo "'></td>"; 
      
 if(isset($extra_vraag) and $extra_vraag !=''){
   echo "<td>";
   echo "<input name= 'Extra-";
   echo $i;
   echo "' type='text' size='26'  value ='";
   echo $row['Extra'];
   echo "'></td>"; 
 };
 
 if(isset($extra_invulveld) and $extra_invulveld != ''){
   echo "<td>";
   echo "<input name= 'Extra-invulveld-";
   echo $i;
   echo "' type='text' size='40' value ='";
   echo $row['Extra_invulveld'];
   echo "'></td>";
}   

 if (isset($meerdaags_toernooi_jn) and $meerdaags_toernooi_jn != 'N'){
   echo "<td><a href ='beheer_inschrijving_meerdaagse_datums.php?id=".$row['Id']."' target='_blank' > Muteer </a>";
   echo "</td>";
}   


   echo "<td>";
   echo "<input name= 'Status-";
   echo $i;
   echo "' type='text' size='2'  value ='";
   echo $row['Status'];
   echo "'></td>"; 
      
   // bereken kenmerk   
   $date = $row['Inschrijving'];
   // 012345678901234567890
   // 2011-12-21 13:46:35
   $dag    = substr ($date , 8,2);         
   $maand  = substr ($date , 5,2);         
   $jaar   = substr ($date , 0,4);     
   $uur    = substr ($date , 11,2);     
   $minuut = substr ($date , 14,2);     
   $sec    = substr ($date , 17,2);     
   $_kenmerk = $minuut.$sec.$dag.$uur;
   /// roep versleutel routine aan
   /// versleutel_licentie($waarde, $richting, $delta)
   $encrypt = versleutel_kenmerk($_kenmerk,'encrypt', 20);
   
   echo "<td>";
   echo substr($encrypt,0,4).".".substr($encrypt,4,4);
   echo "</td>";    
      
   /////  Inschrijving mag niet aangepast worden ivm berekening kenmerk. Kenmerk blijft altijd hetzelfde.
      
   echo "<td>";
   echo $row['Inschrijving'];
   echo "</td>"; 
   echo "</tr>"; 
  }
//$i++;
};

echo "</table>";
echo "<br><span style='color:black;font-size:10pt;font-family:arial;'><i>Na aanpassingen/verwijdering eventueel even het scherm verversen.</i><br>";
echo "</span><br><br>";
echo "<INPUT type='submit' value='Wijziging of selectie keuze bevestigen' ><input type='button' value='Ververs pagina' onClick='document.location.reload(true)'>"; 
echo "</FORM>";

ob_end_flush();
?> 
</body>
</html>