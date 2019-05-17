<html>
<title>PHP Toernooi Inschrijvingen</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">      
             
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a  (color:blue;}
.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: blue; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
// --></style>

<Script Language="Javascript">
<!---// Javascript voor paste clipboard in textares met id textArea ----------->
function PasteKleur() {
document.getElementById("textArea").innerText             = window.clipboardData.getData("Text").toUpperCase();
document.getElementById("textArea").style.backgroundColor = "lightblue"; 
}
</Script>

</head>
<body bgcolor="white" >

<?php
ob_start();

if(isset($_GET['toernooi'])){ 
  	$toernooi = $_GET['toernooi'];   
include 'mysqli.php';   	
  	
/// Ophalen aantal spelers
$sql        = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$aantal     = $result['Aantal'];

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
}
else {
	$vereniging = '';
}

?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi schema's <?php echo $vereniging; ?></TD></tr>
	<?php  	if(isset($_GET['toernooi'])){  ?>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
<?php }?>


</tr>
</TABLE>
</div>
<hr color='red'/>

<script language="javascript">
 document.title = "OnTip Toernooi schema - <?php echo  $toernooi_voluit; ?>";
</script> 
<?php

ob_start();
if (isset ($_GET['toernooi'])){
$toernooi = $_GET['toernooi'];
	
// Ophalen toernooi gegevens
$qry1             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select1');  

while($row = mysqli_fetch_array( $qry1 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	
$qry2    = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  
$row     = mysqli_fetch_array( $qry2 );
$aantal  = $row['Aantal'];
}
else {
	$aantal = 0;
	$toernooi_voluit ='';
}


	  	
echo"<form method = 'post' action='lijst_toernooi_schema.php'> "; 

?>
<input type='hidden' name='Toernooi'  value="<?php echo $toernooi ?>"  /> 

<?php

echo "<center>";
echo "<div style='border: white inset solid 1px; width:800px; left:140px;text-align: center;'>";

echo "<h3 style='padding:10pt;font size=20pt;color:green;'>Toernooi schema voorgeloot - ".$toernooi_voluit."</h3>";
echo "<div Style='font-family:comic sans ms,sans-serif;color:blue;font size=13pt;'>Vul hier aantal spelers en rondes in</div><br/><br/>";

echo "<table >";
echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Naam toernooi op briefjes </label></th><td STYLE ='background-color:white;color:green;' colspan =2><label><input type='text'  name='Toernooi_naam' value='".$toernooi_voluit."'  size=35 /></label></td><tr> "; 

echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Naam organiserende vereniging </label></th><td STYLE ='background-color:white;color:green;' colspan =2><label><input type='text'  name='Vereniging' value='".$vereniging."'  size=35 /></label></td><tr> "; 


echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Aantal spelers of teams      </label></th><td STYLE ='background-color:white;color:green;' colspan =2><label><input type='text'  name='Aantal' value=".$aantal."  size=5 /></label></td><tr> "; 
echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Aantal rondes  </label></th><td STYLE ='background-color:white;color:green;' colspan =2><label><input type='text' value = 2       name='Rondes'  size=5/></label></td><tr> "; 

echo "<tr><td width='280'STYLE ='color:green;font size=11pt;'><label>Gebruik letters of nummers in lijst</td></label></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Tekens' Value='Letters' /></label>Letters</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Tekens' Value='Nummers' checked  /></label>Nummers</td></tr> "; 

if(isset($_GET['toernooi'])){ 
echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Namen overnemen uit inschrijving?</label></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='invul_namen' Value='J' /></label>Ja</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='invul_namen' Value='N' checked  /></label>Nee</td></tr> "; 
}


echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Vrijloting toestaan  (alleen bij oneven aantal) ?</td></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Vrijloting' Value='J'  /></label>Ja</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Vrijloting' Value='N' checked /></label>Nee</td></tr> "; 

echo "<td width='380'STYLE ='color:green;font size=11pt;'><label>Naam toernooi afdrukken ?</td></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Naam_printen' Value='J'  /></label>Ja</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Naam_printen' Value='N' checked /></label>Nee</td></tr>";  
  
  /*   
if ($soort_inschrijving == 'doublet'){ 
echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Triplet of doublet spelen ?</td></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Soort' Value='2' checked /></label>Doublet</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Soort' Value='3'  /></label>Triplet</td></tr> "; 
}
else {
	 
echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Triplet of doublet spelen ?</td></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Soort' Value='2'  /></label>Doublet</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Soort' Value='3' checked /></label>Triplet</td></tr> "; 
}
*/

echo "<tr><td width='380'STYLE ='color:green;font size=11pt;'><label>Baan toewijzing gebruiken ?</td></th>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Baan' Value='J'  /></label>Ja</td>
     <td STYLE ='background-color:white;color:green;'><label><input type='radio'        name='Baan' Value='N' checked /></label>Nee</td></tr> "; 



echo "</table><br>"; 
echo"<center><input type ='submit' value= 'Klik hier na invullen'> </center>";
echo "</form> ";
echo "<br/>";
echo"<center><span style='color:black;'>In principe kan dit programma voor ook niet OnTip toernooien gebruikt worden.</span> </center><br>";

echo "</center></div><br><br><br><br>";


ob_end_flush();
?>
</div>
</body>
</html>
