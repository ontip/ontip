<?php
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

# 31oct2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              Include versleutelstring in dt programma opgenomen omdat dit problemen gaf
# Feature:          PHP7
# Reference: 
?>

<html>
<head>
<title>Lijst wizard inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 11pt;background-color:white;font-family: Comic sans, sans-serif, Verdana; }
td {color:black;font-size: 11pt;font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 9pt;}
li  {font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }


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
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

// statistieken van de pagina bijhouden
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}

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

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$result       = mysqli_fetch_array( $qry);

$extra_vraag  = $result['Waarde']; 
if ($extra_vraag != '') { 
		$opties = explode(";",$extra_vraag,6);
    $vraag  = $opties[0];
 }
 
?>
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
<blockquote>
<table >
<tr><td STYLE ='font-size:20pt; color:green'>Lijst wizard inschrijvingen</td>
<td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/wizard.jpg' width=150></td>
</tr> 
</table>

<span style='color:black;font-size:10pt;font-family:arial;'>Via deze wizard kan je zelf een eigen lijst opmaken door de kolommen van je keuze te selecteren uit onderstaande lijst.</span><br><br>


<FORM action='lijst_wizard_inschrijvingen_stap2.php' method='post'>




<input type ='hidden' name= 'toernooi' value = '<?php echo $toernooi;?>' />
<?php
////  Koptekst

echo "<table border =2>";
echo "<tr>";
echo "<th>Nr.</th>";
echo "<th>Selectie</th>";
echo "<th>Kolom omschrijving xxxx</th>";
echo "</tr>";

$i=0;

if ($soort_inschrijving =='single'){

$i++;

echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Regel' value ='J'  unchecked /></td><td>Regel nummer</td>"; 
echo "</tr>";

echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam1' value ='J'  unchecked /></td><td>Naam speler</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie1' value ='J'  unchecked /></td><td>Licentie speler</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging1' value ='J'  unchecked /></td><td>Vereniging speler</td>"; 
echo "</tr>";

}// end speler1

if ($soort_inschrijving !='single'){

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Regel' value ='J'  unchecked /></td><td>Regel nummer</td>"; 
echo "</tr>";


echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam1' value ='J'  unchecked /></td><td>Naam speler 1</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie1' value ='J'  unchecked /></td><td>Licentie speler 1</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging1' value ='J'  unchecked /></td><td>Vereniging speler 1</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam2' value ='J'  unchecked /></td><td>Naam speler 2</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie2' value ='J'  unchecked /></td><td>Licentie speler 2</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging2' value ='J'  unchecked /></td><td>Vereniging speler 2</td>"; 
echo "</tr>";


}// end speler ongelijk  1

if ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam3' value ='J'  unchecked /></td><td>Naam speler 3</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie3' value ='J'  unchecked /></td><td>Licentie speler 3</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging3' value ='J'  unchecked /></td><td>Vereniging speler 3</td>"; 
echo "</tr>";

}// end speler 3,5,of 6

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet'){

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam4' value ='J'  unchecked /></td><td>Naam speler 4</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie4' value ='J'  unchecked /></td><td>Licentie speler 4</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging4' value ='J'  unchecked /></td><td>Vereniging speler 4</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam5' value ='J'  unchecked /></td><td>Naam speler 5</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie5' value ='J'  unchecked /></td><td>Licentie speler 5</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging5' value ='J'  unchecked /></td><td>Vereniging speler 5</td>"; 
echo "</tr>";

}// end speler 5,of 6


if ($soort_inschrijving == 'sextet'){

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Naam6' value ='J'  unchecked /></td><td>Naam speler 6</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Licentie6' value ='J'  unchecked /></td><td>Licentie speler 6</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Vereniging6' value ='J'  unchecked /></td><td>Vereniging speler 6</td>"; 
echo "</tr>";


}// end speler 6


///  Algemene velden

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Telefoon' value ='J'  unchecked /></td><td>Telefoon contactpersoon</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Email' value ='J'  unchecked /></td><td>Email contactpersoon</td>"; 
echo "</tr>";

if (isset($extra_vraag) and $extra_vraag !=''){
$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Extra_vraag' value ='J'  unchecked /></td><td>".$vraag."</td>"; 
echo "</tr>";
} // end extra vraag


if (isset($extra_invulveld) and $extra_invulveld !=''){
$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Extra_invulveld' value ='J'  unchecked /></td><td>".$extra_invulveld."</td>"; 
echo "</tr>";
} // end extra invulveld



if ($uitgestelde_bevestiging_jn =='J'){
	

if ($bankrekening_invullen_jn =='J'){
	
	
$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Bank_rekening' value ='J'  unchecked /></td><td>Bank rekening</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Betaal_datum' value ='J'  unchecked /></td><td>Datum tijd betaling verwerkt </td>"; 
echo "</tr>";
}


$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Bevestiging_verzonden' value ='J'  unchecked /></td><td>Datum tijd bevestiging verzonden </td>"; 
echo "</tr>";
}// end uitgestelde betaling

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Status' value ='J'  unchecked /></td><td>Status</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Opmerkingen' value ='J'  unchecked /></td><td>Opmerkingen</td>"; 
echo "</tr>";

$i++;
echo "<tr>";
echo "<td style='text-align:right;padding:5pt;' id='normaal'>". $i  . "</td>" ;
echo "<td style='text-align:right;padding:5pt;background-color:white;'><input type='checkbox' name='Inschrijving' value ='J'  unchecked /></td><td>Datum tijd inschrijving</td>"; 
echo "</tr>";

echo "</table>";

echo "</span><br><br>";
echo "<INPUT type='submit' value='Selectie keuze bevestigen' >"; 

echo "</FORM>";
echo "</blockquote>";
ob_end_flush();
?> 
</body>
</html>
