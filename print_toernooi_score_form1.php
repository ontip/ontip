<html>
<head>
<title>Toernooi schema</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css" media="print">
.noprint {display:none;}    
</style>

</head>
 	
 <?php 
ob_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Database gegevens. 
include('mysql.php');


$aant_splrs        = $_POST['Aantal'];
$aant_rondes       = $_POST['Rondes'];
$toernooi          = $_POST['Toernooi'];
$letter_nummer     = $_POST['Tekens'];
$toernooi_voluit   = $_GET['toernooi'];
$invul_namen       = $_GET['invul_namen'];
$baan_toewijzing   = $_POST['Baan_toewijzing'];

//// Change Title //////
?>
<script language="javascript">
 document.title = "Toernooi schema <?php echo  $toernooi_voluit; ?>";
</script> 
<?php

  
//echo $toernooi;
//echo $vereniging;

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Regel < 9000 order by Regel")     or die(' Fout in select config');  
 }
else {
		echo " Geen toernooi bekend :";
	};

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	

?>

<body>

<?php
 
echo "<div style='border: red solid 1px;padding-left:5px;'>";  
echo"<h1>Toernooi schema ". $toernooi ." <h1>"; 
echo "</div>";

echo "<div style='position: absolute; left: 180px;font-size:11pt;' >";
echo "<br>Dit schema bevat een uitdraai van ".$aant_rondes ." voorgelote partijen voor ".$aant_splrs. " deelnemende teams.";
echo "</div>";


echo "<table width=100% class='noprint'><tr>";
echo "<td>";
echo "<a href='index.php' style='font-size:9pt;'>Terug naar Hoofdmenu</a></td>";
echo "</tr></table><br>

";
?>
<!--  Knoppen voor verwerking   ----->
<TABLE>
	<tr><td valign="top" '> 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()' class='noprint'>
</td>
</tr>
</table>
<hr/>
<DIV style="page-break-after:always"></DIV>
<?php
 ////////////////////////////////////////////////////////////////////////////////////// score formulier 
////  Koptekst
 
/// c is de teller voor aantal formulieren per pagina. Na 3 pagina's wordt een page break gezet	
  $c =0;
 
if ($invul_namen =='J'){
	/// Ophalen spelers uit toernooi_schema
  $namen       = mysql_query("SELECT * from toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  order by Wedstrijd, Ronde")     or die(' Fout in select inschrijf');  
}


  ///// $j is teller voor aantal teams
for ($j=1;$j <= $aant_splrs;$j++){
	
	$_team = chr($j+64); 
	if ($j > 26 and $j < 53){
 			 $_team = chr(65).chr($j+64-26);                   // AA  - Az
 	 	}
 			
 			if ($j > 52 and $j < 79){
 			 $_team = chr(66).chr($j+64-52);                   // BA  - Bx
 	 	}
 			
 			if ($j > 78 and $j < 115){
 			 $_team = chr(67).chr($j+64-78);                   // CA  - Cx
 	 	}

if ($letter_nummer == 'Nummers'){
		 $_team = $j;
	}



//// kop van formulier
?>
<br>
<table border=0 width=95%>
	<tr>
		<td style='border: black solid 1px;padding-left:5px;width:120px;font-size:16pt'>Team : <?php echo $_team;?></td>
	  <td style='padding-left:5px;font-size:14pt;text-align:right;'><?php echo $toernooi_voluit;?></br><?php echo $vereniging;?></td>
  </tr>
</table>
         
	<table border = 0 >
		
<?php  if ($invul_namen =='J'){		
//	 $namen       = mysql_query("SELECT * from toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  and order by Wedstrijd, Ronde")     or die(' Fout in select inschrijf');  
  $row = mysql_fetch_array( $namen );
?>

	<tr><td Style='font-family:cursive;font-size:11pt;'>Naam captain     : </td><td><?php echo $row['Team_naam1'];?></td></tr>
	<tr><td Style='font-family:cursive;font-size:11pt;'>Vereniging       : </td><td><?php echo $row['Team_vereniging1'];?></td></tr>
<?php } else { ?>
	<tr><td Style='font-family:cursive;font-size:11pt;'>Namen      : </td><td>________________________________________________________________</td></tr>
	<tr><td Style='font-family:cursive;font-size:11pt;'>Vereniging : </td><td>________________________________________________________________</td></tr>
<?php } ?>	



 </table>
 <br style='font-size:8pt;'>
 
<table border =1 >
	<tr>
	<th width=100>Ronde</th>
	<th width=100>Team</th>
	<th width=100>Tegenstander</th>
  <?php
	if ($baan_toewijzing =='J'){ ?>
	 <th width=100>Baan</th>
  <?php  } ?>

	<th width=100>Voor</th>
	<th width=100>Tegen</th>
	<th width=100>Winst (J/N)</th>
</tr>

<?php
/// Detail regels
/// $k is teller voor rondes

  for ($k=1;$k <= $aant_rondes;$k++){
   	
   	
 	 	
 //echo "SELECT Tegenstander From toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Ronde = ".$k."  and Team =  '" .$_team."' order by Team,Ronde" ;
 $qry  = mysql_query("SELECT Tegenstander,Baan From toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Ronde = ".$k."  and Team =  '" .$_team."' order by Team,Ronde" );  
 $row  = mysql_fetch_array( $qry );
 
	?>
	<tr>
		<td style='font-color:black;text-align:right;font-size:11pt'><?php echo $k;?>.</td>
		<td style='font-color:black;text-align:center;font-size:11pt'><?php echo $_team;?></td>
		<td style='font-color:black;text-align:center;font-size:11pt'><?php echo $row['Tegenstander']; ?></td>

		<?php
		if ($baan_toewijzing =='J'){ ?>
		<td style='font-color:black;text-align:center;font-size:11pt'><?php echo $row['Baan']; ?></td>
	  <?php  } ?>

 	  <td>.</td>
		<td>.</td>
		<td>.</td>
	</tr>
	
	
	<?php
	} /// end k
	?>
	</table>
	 
	 <DIV style="font-size:9pt;text-align:center;">Dit toernooi wordt gespeeld volgens de regels van de NJBB.</DIV>
	 
     <hr/>
	<?php
	 $c++;
	 if ($c==3){
	 	?>
	 	   <DIV style="page-break-after:always;"></DIV>
	 	<?php
	 	$c=0;
	    }
   }/// end j
?>
</body>
</html>