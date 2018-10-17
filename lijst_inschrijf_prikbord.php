<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}

th   {color:blue;font-size:12pt;font-family: sans-serif;font-weight:bold;background-color:white;border-color:black;}
td   {color:black;font-size:12pt;font-family: sans-serif;border-color:black;padding:2pt;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
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
include('mysql.php');

ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

/// Ophalen tekst kleur

$qry  = mysql_query("SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  

$row        = mysql_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

/// als achtergrondkleur niet gevonden in tabel, zet dan default waarden
if ($tekstkleur ==''){ $tekstkleur = 'black';};
if ($koptekst   ==''){ $koptekst   = 'red';};
if ($invulkop   ==''){ $invulkop   = 'blue';};
if ($link       ==''){ $link       = 'blue';};

/// Afwijkende font voor koptekst

if (!isset($font_koptekst)){
 	$font_koptekst='';
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

$toernooi = $_GET['toernooi'];


if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
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

	if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
	};


$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysql_error()); 
/// Bepalen aantal spelers voor dit toernooi
$aant_splrs =  mysql_result($aant_splrs_q ,0); 


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Lijst inschrijvingen - <?php echo  $toernooi_voluit; ?>";
</script> 
<?php

?>
<?php if (isset($achtergrond_patroon) and $achtergrond_patroon !=''){ ?>
<body style='background:url("<?php echo($achtergrond_patroon); ?>");background-repeat:repeat-y;'  text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">
<?php }   else { ?>
<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">
<?php } 

ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table border =0 width=90%>"; 
echo "<tr><td style='background-color:".$achtergrond_kleur.";'><img src='".$url_logo."' width='".$grootte_logo.">";
echo "</td><td style='background-color:".$achtergrond_kleur.";'>";
echo"<h1 style='color:".$koptekst. ";font-family:".$font_koptekst.";'>Inschrijflijst voor ". $toernooi_voluit ."</h1><h3>";
echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ;
echo "</h3></td></tr></table>";

//// SQL Queries
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die(mysql_error());  

// Tabel met inschrijvingen (niet alle kolommen ivp privacy)
//  Koptekst

if ($soort_inschrijving =='single'){

echo "<table border = 2 id='myTable1'><tr>";
echo "<th width=30>Nr</th>";
echo "<th >Naam</th>";
echo "<th >Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th >Licentie</th>";
}
//echo "<th >Inschrijving</th>";

echo "</tr>";

}// einde single

	$colspan =2;
if ($licentie_jn =='J'){
	$colspan =3;
}

switch($soort_inschrijving){
 	   case 'single'  : $width = 500; break;
 	   case 'doublet' : $width = 1200; break;
 	   case 'triplet' : $width = 1800; break; 
 	   case 'kwintet' : $width = 3000; break;
 	   case 'sextet'  : $width = 3600; break;
 	  }// end switch 


if ($soort_inschrijving  != 'single'){	

echo "<table border = 2 id='myTable1' width=".$width.">";
echo "<tr>";
echo "<th colspan = 1 style='color:white;'>.</th>";
echo "<th colspan = ".$colspan.">Speler 1</th>";
echo "<th colspan = ".$colspan.">Speler 2</th>";

if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){	
 echo "<th colspan = ".$colspan.">Speler 3</th>";
}
if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){	
 
 echo "<th colspan = ".$colspan.">Speler 4</th>";
 echo "<th colspan = ".$colspan.">Speler 5</th>";
}

if ($soort_inschrijving == 'sextet' ){	
 echo "<th colspan = ".$colspan.">Speler 6</th>";
// echo "<th colspan = 1 style='color:white;'>.</th>";

}

 echo "</tr>";

}// einde <> single

// Tweede kopregel

if ($soort_inschrijving !='single'){

echo "<tr>";
echo "<th width=40>Nr.</th>";
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
}

if ($soort_inschrijving =='triplet'){
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
}

if ($soort_inschrijving =='kwintet' or $soort_inschrijving == 'sextet'){
	echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
}

if ($soort_inschrijving == 'sextet'){
echo "<th width=240>Naam</th>";
echo "<th width=240>Vereniging</th>";
if ($licentie_jn =='J'){
echo "<th width=40>Licentie</th>";
}
}
echo "</tr>";

/// Detail regels

$i=1;

while($row = mysql_fetch_array( $spelers )) {


if ($soort_inschrijving =='single'){
		echo "<tr>";
	 
	 if ($i  > $max_splrs and $aantal_reserves > 0){
       echo "<td style='text-align:right;padding:5pt;background-color:yellow;' >". $i  . " *</td>" ;
    }
  else {
       echo "<td style='text-align:right;padding:5pt;background-color:white;' >". $i  . "</td>" ;
    }  
  
   
   echo "<td style='background-color:white;'>". $row['Naam1']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging1']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie1']  . ".</td>" ; 
   }
	// echo "<td >". $row['Inschrijving']  . ".</td>" ;
   } /// einde single
  
 if ($soort_inschrijving !='single'){
	 
	 echo "<tr>";
	 if ($i  > $max_splrs and $aantal_reserves > 0){
       echo "<td style='text-align:right;padding:5pt;background-color:yellow;' >". $i  . " *</td>" ;
    }
  else {
       echo "<td style='text-align:right;padding:5pt;background-color:white;' >". $i  . "- </td>" ;
    }  
    	
   echo "<td style='background-color:white;'>". $row['Naam1']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging1']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie1']  . ".</td>" ; 
   }
   echo "<td style='background-color:white;'>". $row['Naam2']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging2']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie2']  . ".</td>" ; 
   }
}

 if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td style='background-color:white;' >". $row['Naam3']  . ".</td>" ;
   echo "<td style='background-color:white;'>".  $row['Vereniging3']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie3']  . ".</td>" ; 
   }
  }
  
  if ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td style='background-color:white;'>". $row['Naam4']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging4']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie4']  . ".</td>" ; 
   }
   echo "<td style='background-color:white;'>". $row['Naam5']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging5']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie5']  . ".</td>" ; 
   }
  }
  
  if ($soort_inschrijving  == 'sextet'){
   echo "<td style='background-color:white;'>". $row['Naam6']  . ".</td>" ;
   echo "<td style='background-color:white;'>". $row['Vereniging6']  . ".</td>" ;
   if ($licentie_jn =='J'){
    echo "<td style='background-color:white;'>". $row['Licentie6']  . ".</td>" ; 
   }
   }
   
echo "</tr>"; 


$i++;
};

/// Aantal lege regels

for ($j=$i;$j <= ($max_splrs+$aantal_reserves);$j++){
	
	if ($soort_inschrijving =='single'){
		echo "<tr>";
	 
	 if ($j  > $max_splrs and $aantal_reserves > 0){
       echo "<td style='text-align:right;padding:5pt;background-color:yellow;' >". $j  . " *</td>" ;
    }
  else {
       echo "<td style='text-align:right;padding:5pt;background-color:white;' >". $j  . "</td>" ;
    }  
   
   echo "<td style='background-color:white;'></td>" ;              // Naam1
   echo "<td style='background-color:white;'></td>" ;              // Vereniging1
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
  }
   }// end single

if ($soort_inschrijving !='single'){
	 
	 echo "<tr>";
	if ($j  > $max_splrs and $aantal_reserves > 0){
       echo "<td style='text-align:right;padding:5pt;background-color:yellow;' >". $j  . " *</td>" ;
    }
  else {
       echo "<td style='text-align:right;padding:5pt;background-color:white;' >". $j  . "</td>" ;
    }  
    
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam1
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging1	
   if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam2
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging2
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
   
 if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam3
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging3 
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
}
  
  if ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam4
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging4
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam5
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging5
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
  }
  
  if ($soort_inschrijving  == 'sextet'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Naam6
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Vereniging6
    if ($licentie_jn =='J'){
   echo "<td style='background-color:white;color:white;'>.</td>" ;              // Licentie
   }
   

 } // sextet
 
} /// end not single

echo "</tr>";

}/// end for
echo "</table>";
	
	echo "<div style='font-size:9pt;border:1 pt solid black;background-color:yellow;width:200pt;'>"; 
echo "* De geel gemarkeerde spelers staan reserve<br>";
echo "</div>";

echo "<div style='font-size:9pt;'>"; 
echo "<br>Lijst bijgewerkt t/m ";
echo  date("d-m-Y H:i:s"); 
echo "</div>";


?>

	<!--  Knoppen voor verwerking   ----->
<TABLE>
	<tr><td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select & Copy to clipboard" />
</form>
</td><td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;'> 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
</tr>
</table>
<div style='font-size:9pt;'>(c) Copyright by Erik Hendrikx &#169 2011</div>
</body>
</html>