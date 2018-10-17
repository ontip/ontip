<html>
<title>Intrekken inschrijving</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:yellow ;background-color:#990000; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

// --></style>
</head>
<body>
	
	<?php
ob_start();

// Database gegevens. 
include('mysql.php');

/// Ophalen tekst kleur

$sql        = mysql_query("SELECT Tekstkleur,Link From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$result     = mysql_fetch_array( $sql );
$tekstkleur = $result['Tekstkleur'];
$link       = $result['Link'];

$date     = date('YmdHis');
$kenmerk  = $_POST['Kenmerk'];
$toernooi = $_POST['Toernooi'];
$naam     = $_POST['Naam1'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens
if (isset($toernooi)) {
	

	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Regel < 9000 and Regel > 0 order by Regel")     or die(' Fout in select');  
 }
else {
		echo " Geen toernooi bekend :";
	};
//echo "id : ".  $id;

// kenmerk :
//           1
// 01234567890123456789
// jjjjmmdd.hhmmss

$dag    = substr ($kenmerk , 6,2);         
$maand  = substr ($kenmerk , 4,2);         
$jaar   = substr ($kenmerk , 0,4);     
$uur    = substr ($kenmerk , 9,2);     
$minuut = substr ($kenmerk , 11,2);     
$sec    = substr ($kenmerk , 13,2);     

date('Y-m-d:H:i:s');

$inschrijving = $jaar."-".$maand."-".$dag." ".$uur.":".$minuut.":".$sec;

$sql     = "SELECT * from inschrijf where Toernooi = '".$toernooi."' and Inschrijving = '".$inschrijving."' and Naam1 = '".$naam."'  ";
$result  = mysql_query($sql);


 // Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];


// ---------------------------------------------------------------------------------------------------------------------------------------------------
?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>



<h3 style='padding:10pt;font size=20pt;color:green;'>Intrekken inschrijving - <?php echo htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></h3>

<br><br>
<center>
	<?php

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);


if ($count == 0){
	echo "Niet gevonden !";
}
else {
$row       = mysql_fetch_array( $result );
//echo $toernooi;

//echo "xxxxxxxxxxxxxx". $soort_inschrijving;
	

echo "<FORM action='select_verwijder_inschrijving_stap3.php' method='post'>";

echo "<span style='color:black;font-size:10pt;font-family:cursive;'> U heeft ervoor gekozen de volgende ".$soort_inschrijving." inschrijving in te trekken  :</span>      <br><br><br><br>";


echo "<table border=1 style='background-color:white;color:blue;border: 1px solid black;width:300pt;'>";

//// kopteksten


echo  "<tr>"   ;
echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 1</th>"   ;

if ($soort_inschrijving !='single' and $inschrijf_methode !='single'){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 2</th>"   ;
}

if ( ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode !='single'){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 3</th>"   ;
}

if ( ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode !='single'){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 4</th>"   ;
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 5</th>"   ;
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode !='single'){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =2>Speler 6</th>"   ;
}
echo  "</tr>"   ;

echo  "<tr>"   ;


echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;

if ($soort_inschrijving !='single' and $inschrijf_methode !='single'){
echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;

}

if ( ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode !='single' ){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;

}

if (( $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode !='single' ){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;
  echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (( $soort_inschrijving == 'sextet')   and $inschrijf_methode !='single'){
	echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:cursive;font-size:11pt;color:blue;' colspan =1>Vereniging</th>"   ;
}
echo  "</tr>"   ;


/// detail regel


echo  "<tr>"   ;

echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam1']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging1']. "</td>";

if ($soort_inschrijving !='single' and $inschrijf_methode !='single'){
 echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam2']. "</td>";
 echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging2']. "</td>";
 }
 
if ( ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode !='single' ){
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam3']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging3']. "</td>";
}

if (( $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode !='single'){
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam4']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging4']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam5']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging5']. "</td>";
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode !='single'){
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Naam6']. "</td>";
echo  "<td style= 'font-family:cursive;font-size:11pt;color:black;'>"   . $row['Vereniging6']. "</td>";
}

echo  "</tr>"   ;
echo "</table>";

echo "<input type='hidden' name='Kenmerk' type='text' size='100'  value ='".$kenmerk."'>";


echo "<input type='hidden' name='Aantal' type='text' value ='".$i."'>";

echo "<br>Klik op Ja om verwijderen te bevestigen. De verwijdering wordt gemeld via een email bericht aan ".$email_organisatie.".<br><br><br>";
echo "<INPUT type='submit' value='Ja' >&nbsp&nbsp"; 


?><input type = 'button' value ='Annuleren' onclick= "location.replace('<?php echo $url_website; ?>');">
<?php

echo "</FORM>";

}  /// end if

ob_end_flush();
?> 
</body>
</body>
</html>