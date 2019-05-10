<?php

# lijst_inschrijf.php
# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 10mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 
?>

<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Lijst inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:11pt;}
a    {text-decoration:none;color:blue;}

#normaal  {background-color: white;color:black;}
#reserve  {background-color: yellow;color:black;}

</style>

<script type="text/javascript">
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
// Database gegevens. 

include('mysqli.php');


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



 
ini_set('display_errors', 'On');
error_reporting(E_ALL);


/// Kontrole op sort key
if (!isset($_GET['sort'])){
	$sortkey = 21;
	}
	else {$sortkey = $_GET['sort'];
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens


if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
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

/// Ophalen tekst kleur

$qry  = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  

$row        = mysqli_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

// Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

?>
<body bgcolor=white>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Lijst inschrijvingen voor <?php echo $toernooi_voluit; ?></h3>


<div style='position: absolute; left: 180px;font-size:11pt;color:black;' >
Klik op de Select & Copy knop om de gegevens uit de tabel te kopieren.
Plak daarna de gekopieerde tabel in Excel of Word.</div>
<br><br>
<?php

/// Uitlezen config
//// SQL Queries
// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
$qry1                   = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id ." ")     or die(' Fout in select');  
 $result1                = mysqli_fetch_array( $qry1);
 $sortering_korte_lijst  = $result1['Lijst_sortering'];
 
 /*
 echo "xxxxxxxxxxxxxxx". $soort_inschrijving."<br>";
 echo "xxxxxxxxxxxxxxx". $inschrijf_methode."<br>";
*/ 
 
//// SQL Queries
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving ".$sortering_korte_lijst."")    or die(mysql_error());  

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$result       = mysqli_fetch_array( $qry);

$extra_vraag  = $result['Waarde']; 
if ($extra_vraag != '') { 
		$opties = explode(";",$extra_vraag,6);
    $vraag  = $opties[0];
 }
?>


	<?php
	if ($inschrijf_methode == 'single' and $soort_inschrijving !='single'){
  	echo "<br><span style= 'font-size:10pt;'>Voor dit ".$soort_inschrijving." toernooi dient individueel te worden ingeschreven. De teams worden via loting samengesteld.</span><br><br>";
  }
  ?>
  <center>
	<!--  Knoppen voor verwerking   ----->
<TABLE>
	<tr><td valign="top" style='background-color:white;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select & Copy to clipboard" />
</form>
</td>
</tr>
</table>
</center>


<?php
ob_start();


/*
echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx". $soort_inschrijving. "<br>";
echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx". $inschrijf_methode. "<br>";
echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx". $licentie_jn. "<br>";
*/

if(!isset($soort_inschrijving)) { $soort_inschrijving = $soort_toernooi;}

////  Koptekst

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>";

if ($soort_inschrijving =='single' or $inschrijf_methode =='single'){
	
//  Koptekst single

echo "<tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'>Naam</th>";
if ($licentie_jn =='J'){
echo "<th style='". $th_style.";' >Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";
echo "<th style='". $th_style.";'>Tel.nr</th>";
echo "<th style='". $th_style.";'>E-mail</th>";

if ($bankrekening_invullen_jn =='J'){
echo "<th style='". $th_style.";'>Bankreknr</th>";
}
echo "<th style='". $th_style.";'>Opmerking</th>";

if(isset($extra_vraag) and $extra_vraag != ''){
echo "<th style='". $th_style.";'>".$vraag."</th>";
};
if(isset($extra_invulveld) and $extra_invulveld != ''){
echo "<th style='". $th_style.";'>".$extra_invulveld."</th>";
};

echo "<th style='". $th_style.";' >Status</th>";
echo "<th style='". $th_style.";' >Inschrijving</th>";
echo "</tr>";

}/// einde single

/// eerste kopregel


/// Bij licentie nummer wordt soort gezocht in extra kolom geprint
//  aangepast 18 feb 2016 alleen nog licentie nr, geen soort
if ($licentie_jn =='J'){
$colspan = 3;
} else {
$colspan = 2;
}



echo "<tr>";


if ($inschrijf_methode =='vast' and ( $soort_inschrijving == 'doublet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') ){	
echo "<th style='". $th_style.";' colspan = 1 >.</th>";
echo "<th style='". $th_style.";' colspan = ".$colspan.">Speler 1</th>";
echo "<th style='". $th_style.";' colspan = ".$colspan.">Speler 2</th>";
}

if ($inschrijf_methode =='vast' and ( $soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') ){
echo "<th style='". $th_style.";' colspan = ".$colspan.">Speler 3</th>";
}

if ($inschrijf_methode =='vast' and ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){	
echo "<th style='". $th_style.";' colspan = ".$colspan.">Speler 4</th>";
}

if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){	
echo "<th style='". $th_style.";' colspan = ".$colspan.">Speler 5</th>";
}


if ($inschrijf_methode =='vast' and $soort_inschrijving == 'sextet' ){	
echo "<th style='". $th_style.";' colspan = 3>Speler 6</th>";
}

if ($soort_inschrijving != 'single' and $inschrijf_methode =='vast'){	
  if(isset($extra_vraag) and $extra_vraag != ''){
     echo "<th style='". $th_style.";' colspan = 9 >.</th>";
     echo "</tr>";
   }
   else {
    echo "<th style='". $th_style.";' colspan = 8 >.</th>";
    echo "</tr>";
}}

//// tweede kopregel

if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
echo "<tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";' >Naam</th>";      //speler 1
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";' colspan = 1 >Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";

echo "<th style='". $th_style.";'>Naam</th>";       /// speler 2
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";'  colspan = 1  >Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";
}

if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
echo "<th style='". $th_style.";'>Naam</th>";               // speler 3
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";'  colspan = 1 >Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";

}

if ($inschrijf_methode =='vast' and ($soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
echo "<th style='". $th_style.";'>Naam</th>";             // speler 4
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";'  colspan = 1>Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";
}


if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
echo "<th style='". $th_style.";'>Naam</th>";           // speler 5
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";'  colspan = 1>Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";
}

if ($inschrijf_methode =='vast' and $soort_inschrijving == 'sextet'){
echo "<th style='". $th_style.";'>Naam </th>";            // speler 6
if ($licentie_jn =='J'){
	echo "<th style='". $th_style.";'  colspan = 1 >Licentie</th>";
}
echo "<th style='". $th_style.";'>Vereniging</th>";
}

if ($soort_inschrijving != 'single' and $inschrijf_methode =='vast' ){
echo "<th style='". $th_style.";' >Tel.nr</th>";
echo "<th style='". $th_style.";'>E-mail</th>";

if ($bankrekening_invullen_jn =='J'){
echo "<th style='". $th_style.";'>Bankreknr</th>";
}
echo "<th style='". $th_style.";'>Opmerking</th>";

if(isset($extra_vraag) and $extra_vraag != ''){
echo "<th style='". $th_style.";'>".$vraag."</th>";
} ;

if(isset($extra_invulveld) and $extra_invulveld != ''){
    echo "<th style='". $th_style.";'>".$extra_invulveld."</th>";
 };


echo "<th style='". $th_style.";'>Status</th>";
echo "<th style='". $th_style.";'>Inschrijving</th>";
echo "</tr>";
} // if geen single


/// Detail regels

$i=1;

while($row = mysqli_fetch_array( $spelers )) {

$Naam1           = $row['Naam1'];
$Vereniging1     = $row['Vereniging1'];
$Licentie1       = $row['Licentie1'];

$sql_l           = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie1."'  ")     ;  
$result          = mysqli_fetch_array( $sql_l);
$Soort1          = $result['Soort'];

$Naam2           = $row['Naam2'];
$Vereniging2     = $row['Vereniging2'];
$Licentie2       = $row['Licentie2'];

$sql_l               = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie2."'  ")     ;  
$result              = mysqli_fetch_array( $sql_l);
$Soort2              = $result['Soort'];

$Naam3           = $row['Naam3'];
$Vereniging3     = $row['Vereniging3'];
$Licentie3       = $row['Licentie3'];

$sql_l               = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie3."'  ")     ;  
$result              = mysqli_fetch_array( $sql_l);
$Soort3              = $result['Soort'];

$Naam4           = $row['Naam4'];
$Vereniging4     = $row['Vereniging4'];
$Licentie4       = $row['Licentie4'];

$sql_l               = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie4."'  ")     ;  
$result              = mysqli_fetch_array( $sql_l);
$Soort4              = $result['Soort'];

$Naam5           = $row['Naam5'];
$Vereniging5     = $row['Vereniging5'];
$Licentie5       = $row['Licentie5'];

$sql_l               = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie5."'  ")     ;  
$result              = mysqli_fetch_array( $sql_l);
$Soort5              = $result['Soort'];

$Naam6           = $row['Naam6'];
$Vereniging6     = $row['Vereniging6'];
$Licentie6       = $row['Licentie6'];

$sql_l               = mysqli_query($con,"SELECT * from speler_licenties where Licentie  = '".$Licentie6."'  ")     ;  
$result              = mysqli_fetch_array( $sql_l);
$Soort6              = $result['Soort'];

$Telefoon        = $row['Telefoon'];
$Email           = $row['Email'];
$Bankrekening    = $row['Bank_rekening'] ;
$Status          = $row['Reservering'];

//// indien leeg cel vullen met punt

 if (isset($Naam1) and $Naam1 == '') { $Naam1 = ".";} ;
 if (isset($Naam2) and $Naam2 == '') { $Naam2 = ".";} ;
 if (isset($Naam3) and $Naam3 == '') { $Naam3 = ".";} ;
 if (isset($Naam4) and $Naam4 == '') { $Naam4 = ".";} ;
 if (isset($Naam5) and $Naam5 == '') { $Naam5 = ".";} ;
 if (isset($Naam6) and $Naam6 == '') { $Naam6 = ".";} ;

 if (isset($Licentie1) and $Licentie1 == '') { $Licentie1 = ".";} ;
 if (isset($Licentie2) and $Licentie2 == '') { $Licentie2 = ".";} ;
 if (isset($Licentie3) and $Licentie3 == '') { $Licentie3 = ".";} ;
 if (isset($Licentie4) and $Licentie4 == '') { $Licentie4 = ".";} ;
 if (isset($Licentie5) and $Licentie5 == '') { $Licentie5 = ".";} ;
 if (isset($Licentie6) and $Licentie6 == '') { $Licentie6 = ".";} ;

 if (isset($Vereniging1) and $Vereniging1 == '') { $Vereniging1 = ".";} ;
 if (isset($Vereniging2) and $Vereniging2 == '') { $Vereniging2 = ".";} ;
 if (isset($Vereniging3) and $Vereniging3 == '') { $Vereniging3 = ".";} ;
 if (isset($Vereniging4) and $Vereniging4 == '') { $Vereniging4 = ".";} ;
 if (isset($Vereniging5) and $Vereniging5 == '') { $Vereniging5 = ".";} ;
 if (isset($Vereniging6) and $Vereniging6 == '') { $Vereniging6 = ".";} ;

if (isset($Email) and $Email == '') { $Email = ".";} ;


if ($soort_inschrijving == 'single' or $inschrijf_methode =='single' ){

 
 echo "<tr>";
   echo "<td style='". $td_style_w.";' id='normaal'>". $i  . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>". $Naam1  . "</td>" ;
   if ($licentie_jn =='J'){
      echo "<td id='normaal'>". $Licentie1  . "</td>" ;
      echo "<td id='normaal'>". $Soort1  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>". $Vereniging1  . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>". $Telefoon  . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>". $Email  . "</td>" ;
   
  if ($bankrekening_invullen_jn == 'J'){
     echo "<td id='normaal'>". $Bankrekening  . "</td>" ;
  }
   echo "<td id='normaal'>". $row['Opmerkingen']  . ".</td>" ;
   
   if(isset($extra_vraag) and $extra_vraag != ''){
   	 echo "<td id='normaal'>". $row['Extra']  . ".</td>" ;
    };
    
   if(isset($extra_invulveld) and $extra_invulveld != ''){
   	 echo "<td id='normaal'>". $row['Extra_invulveld']  . ".</td>" ;
   }
   
   //echo "<td id='normaal'>". $row['Reservering']  . "</td>" ;
   
  switch($row['Status']){
  	
  	case "BE0": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving via Email gemeld.</td>";break;
  	case "BE1": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving, Geen Email bekend.</td>";break;
  	case "BE2": 	echo "<td style='". $td_style_w.";'>Betaald maar nog niet bevestigd.</td>";break;
  	case "BE3": 	echo "<td style='". $td_style_w.";'>Nog niet betaald.Geen Email bekend.</td>";break;
  	case "BE4": 	echo "<td style='". $td_style_w.";'>Betaald en bevestigd.</td>";break;
  	case "BE5": 	echo "<td style='". $td_style_w.";'>Geannuleerd maar nog niet gemeld.</td>";break;
  	case "BE6": 	echo "<td style='". $td_style_w.";'>Geannuleerd en gemeld.</td>";break;
  	case "BE7": 	echo "<td style='". $td_style_w.";'>Geannuleerd. Geen Email bekend.</td>";break;
  	case "BE8": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd. </td>";break;
  	case "BE9": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Geen Email bekend. </td>";break;
  	case "BEA": 	echo "<td style='". $td_style_w.";'>Bevestigd. Email bekend.</td>";break;
  	case "BEB": 	echo "<td style='". $td_style_w.";'>Bevestigd. Geen Email bekend.</td>";break;
  	case "BEC": 	echo "<td style='". $td_style_w.";'>Bevestigd maar nog niet betaald.</td>";break;
  	case "BED": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving via SMS gemeld.</td>";break;
  	case "BEE": 	echo "<td style='". $td_style_w.";'>Bevestigd via SMS.</td>";break;
  	case "BEF": 	echo "<td style='". $td_style_w.";'>Geannuleerd en gemeld via SMS.</td>";break;
    case "DEL": 	echo "<td style='". $td_style_w.";'>Deelnemer heeft verzocht inschrijving te verwijderen.</td>";break;
  	case "ID0": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Wacht evt op betaling via IDEAL.</td>";break;
  	case "ID1": 	echo "<td style='". $td_style_w.";'>Betaald via IDEAL.</td>";break;
  	case "ID2": 	echo "<td style='". $td_style_w.";'>Betaling via IDEAL afgebroken of mislukt.</td>";break;
  	case "IM0": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "IM1": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Bevestigd via Mail.</td>";break;
  	case "IM2": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Bevestigd via SMS.</td>";break;
  	case "IN0": 	echo "<td style='". $td_style_w.";'>Ingeschreven en bevestigd via Email.</td>";break;
  	case "IN1": 	echo "<td style='". $td_style_w.";'>Ingeschreven. Geen Email bekend.</td>";break;
  	case "IN2": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "RE0": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt en bevestigd via Email.</td>";break;
   	case "RE1": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt. Geen Email bekend.</td>";break;
   	case "RE2": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd via Email.</td>";break;
   	case "RE3": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd. Geen Email bekend.</td>";break;
  	case "RE4": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt. Bevestigd via SMS.</td>";break;
  	case "RE5": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd en gemeld via SMS.</td>";break;
   	default : echo "<td style='". $td_style_w.";'>Onbekend.</td>";break; 
  }
   
   
   echo "<td id='normaal'>". $row['Inschrijving']  . "</td>" ;
   echo "</tr>";
  }
  else {

   echo "<tr>";
   echo "<td style='". $td_style_w.";' id='normaal'>". $i  . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>". $Naam1   . "</td>" ;
   if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie1  . "</td>" ;
  //    echo "<td style='". $td_style_w."; id='normaal'>". $Soort1  . "</td>" ;
   }
  
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Vereniging1 . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Naam2   . "</td>" ;
   if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie2  . "</td>" ;
 //      echo "<td style='". $td_style_w."; id='normaal'>". $Soort2  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>". $Vereniging2  . "</td>" ;
   
 if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Naam3    . "</td>" ;
 if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie3  . "</td>" ;
 //      echo "<td style='". $td_style_w."; id='normaal'>". $Soort3  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>". $Vereniging3  . "</td>" ;
  }
  
 if ($inschrijf_methode =='vast' and ($soort_inschrijving == '4x4'  or  $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Naam4    . "</td>" ;
 if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie4  . "</td>" ;
   //    echo "<td style='". $td_style_w."; id='normaal'>". $Soort4  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Vereniging4 . "</td>" ;
 }   
   
 if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
  
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Naam5    . "</td>" ;
 if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie5  . "</td>" ;
  //     echo "<td style='". $td_style_w."; id='normaal'>". $Soort5  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>". $Vereniging5  . "</td>" ;
  }
  
  if ($inschrijf_methode =='vast' and $soort_inschrijving ==  'sextet'){
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Naam6   . "</td>" ;
  if ($licentie_jn =='J'){
      echo "<td style='". $td_style_w.";' id='normaal'>". $Licentie6  . "</td>" ;
  //     echo "<td style='". $td_style_w."; id='normaal'>". $Soort6  . "</td>" ;
   }
   echo "<td style='". $td_style_w.";' id='normaal'>". $Vereniging6 . "</td>" ;
  }
    
   echo "<td style='". $td_style_w.";' id='normaal'>". $Telefoon  . "</td>" ;
   echo "<td style='". $td_style_w.";' id='normaal'>".  $Email     . "</td>" ;
   
  if ($bankrekening_invullen_jn =='J'){
   echo "<td style='". $td_style_w.";' id='normaal'>". $Bankrekening  . "</td>" ;
  }
   echo "<td style='". $td_style_w.";' id='normaal'>". $row['Opmerkingen'].  "</td>" ;
   
   if(isset($extra_vraag) and $extra_vraag != ''){
   	 echo "<td style='". $td_style_w.";' id='normaal'>". $row['Extra']  ."</td>" ;
    };
    
    if(isset($extra_invulveld) and $extra_invulveld != ''){
   	 echo "<td style='". $td_style_w.";' id='normaal'>". $row['Extra_invulveld']  . ".</td>" ;
   }
   
   //echo "<td id='normaal'>". $row['Reservering']  . ".</td>" ;
   
    
 switch($row['Status']){
  	
  	case "BE0": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving via Email gemeld.</td>";break;
  	case "BE1": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving, Geen Email bekend.</td>";break;
  	case "BE2": 	echo "<td style='". $td_style_w.";'>Betaald maar nog niet bevestigd.</td>";break;
  	case "BE3": 	echo "<td style='". $td_style_w.";'>Nog niet betaald.Geen email bekend.</td>";break;
  	case "BE4": 	echo "<td style='". $td_style_w.";'>Betaald en bevestigd.</td>";break;
  	case "BE5": 	echo "<td style='". $td_style_w.";'>Geannuleerd maar nog niet gemeld.</td>";break;
  	case "BE6": 	echo "<td style='". $td_style_w.";'>Geannuleerd en gemeld.</td>";break;
  	case "BE7": 	echo "<td style='". $td_style_w.";'>Geannuleerd. Geen email bekend.</td>";break;
  	case "BE8": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd. </td>";break;
  	case "BE9": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Geen Email bekend. </td>";break;
  	case "BEA": 	echo "<td style='". $td_style_w.";'>Bevestigd. Email bekend.</td>";break;
  	case "BEB": 	echo "<td style='". $td_style_w.";'>Bevestigd. Geen email bekend.</td>";break;
    case "DEL": 	echo "<td style='". $td_style_w.";'>Deelnemer heeft verzocht inschrijving te verwijderen.</td>";break;
  	case "ID0": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Wacht evt op betaling via IDEAL.</td>";break;
  	case "ID1": 	echo "<td style='". $td_style_w.";'>Betaald via IDEAL.</td>";break;
  	case "ID2": 	echo "<td style='". $td_style_w.";'>Betaling via IDEAL afgebroken of mislukt.</td>";break;
  	case "RE0": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt en bevestigd.</td>";break;
   	case "RE1": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt. Geen email bekend.</td>";break;
   	case "RE2": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd en bevestigd.</td>";break;
   	case "RE3": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd. Geen email bekend.</td>";break;
  	case "IN0": 	echo "<td style='". $td_style_w.";'>Ingeschreven en bevestigd via mail.</td>";break;
  	case "IN1": 	echo "<td style='". $td_style_w.";'>Ingeschreven. Geen email bekend.</td>";break;
   	default : echo "<td style='". $td_style_w.";'>Onbekend.</td>";break; 
  } 
   
   echo "<td style='". $td_style_w.";' id='normaal'>". $row['Inschrijving']  . ".</td>" ;
   echo "</tr>";
};///   Einde 


$i++;
};
echo "</table><br>";
echo "<div style='font-size:9pt;border:1 pt solid black;'>"; 
if ($sortering_korte_lijst =='ASC') {
 	 	     echo "Op deze lijst staan de oudste inschrijvingen bovenaan.";
   }
  else {
 	  	  echo "Op deze lijst staan de nieuwste inschrijvingen bovenaan.";
}
echo "</div>";
ob_end_flush();
?>


<!--  Knoppen voor verwerking   ----->

<center>
<TABLE>
	<tr><td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select & Copy to clipboard" />
</form>
</td>
</tr>
</table>

</center>
</body>
</html>
