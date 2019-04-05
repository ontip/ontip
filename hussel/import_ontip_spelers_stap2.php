<html
<head>
<title>Upload ontip spelers</title>
<link rel="shortcut icon" type="image/x-icon" href="images/njbb_logo.ico">
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<style type="text/css">
	body {color:black;font-size:9pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}
a    {text-decoration:none ;color:blue;}

td {color:blue;font-size: 9pt;background-color:white;}

.tab {text-align:left;color:black;font-size:10pt;font-family:arial;}


</style>
</head>
<?php

?>
<body>
<?php
ob_start();
//include('mysql.php');


//// Database gegevens. 

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";


?>

<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ></a>
</td></tr>
</table>
<br>
<br>
<br>
<h2>Importeer spelers uit ontip toernooi </h2>

<div style='padding:10pt;font-size:20pt;color:green;'>Kontrole bestand </div>

<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees ontip inschrijf in hussel score
//// SQL Queries


$toernooi= $_POST['toernooi'];


// Inschrijven als individu of vast team

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result              = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging_id = '".$vereniging_id."' order by Inschrijving" )    or die(mysql_error());  
echo "Inschrijvingen ". $toernooi_voluit . "\r\n"; 

$i=1;

while($row = mysqli_fetch_array( $spelers )) {


if ($soort_inschrijving =='single' or $inschrijf_methode =='vast'){

$naam = $row['Naam1'];

}

 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	 
$naam = $row['Naam1']. " - " .$row['Naam2'];
  	
  
    	
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   $naam = $row['Naam1']. ", " .$row['Naam2']." e.a ";

  }
  
 
/// Voeg toe aan hussel_score
$query = "INSERT INTO hussel_score (Vereniging, Vereniging_id,Datum,  Naam, Winst, Saldo)
               VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' , 0,0)";
               echo $query."<br>";
               
               
//mysqli_query($con,$query) or die (mysql_error()); 



};
?>