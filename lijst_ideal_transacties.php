<?php
/*  Programma       : Prepare_ideal_betaling.php
    Auteur          : Erik Hendrik okt 2013
 # Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 17mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference:    
                                                                                   */
?>
<html>
	<Title>OnTip IDEAL betaling (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'>
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH   {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD   {color:blue ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding: 1px;}
h1   {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3   {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2   {color:red;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
</style>
</head>


<?php 
// Database gegevens. 
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

$toernooi = $_GET['toernooi'];

if (!isset($toernooi)) {
		echo " Geen toernooi bekend :";
		exit;
};

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

//// Check op rechten
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	
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

<br><br>
<table>
 <tr>
		<td style='font-family:cursive; font-size: 14pt;color:green;'><h3>Ideal transacties  <img src = '../ontip/images/ideal.bmp' width='60'></h3></td>
 </tr>
</table>
<br>

<?php 
//echo "SELECT * from ideal_transacties Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Laatst<br>"; 
 $sql     = mysqli_query($con,"SELECT * from ideal_transacties Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Laatst" )    or die('Fout in select1');  
/// Koptekst
?>
<table  id='myTable1' border =1 cellpadding=0 cellspacing=0 >
<tr>
		<th>Nr.</th>
		<th>Naam speler 1</th>
		<th>Email</th>
		<th>Rekening houder</th>
		<th>Rekening nr</th>
		<th>Plaats</th>
		<th>Rekening afschrift</th>
		<th>Bedrag afschrift</th>
		<th>Kenmerk inschrijving</th>
		<th>Datum tijd inschrijving</th>
		<th>Datum tijd betaald</th>
	  <th>Test Mode</th>
		<th>Status betaal opdracht</th>
	</tr>  
	
<?php
$i=1;
while($row = mysqli_fetch_array( $sql )) {

  	 $qry_inschrijving     = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and  Id = ".$row['Inschrijf_id']." " ) or  die ('Fout in select2')   ;
  	 $result               = mysqli_fetch_array( $qry_inschrijving );
	   $bank_rekening        = $result['Bank_rekening'];

?>
  <tr>
	 <td><?php echo $i;                         ?></td>
	 <td><?php echo $result['Naam1'];           ?></td>
	 <td><?php echo $result['Email'];           ?></td>
	 <td><?php echo $row['consumerName'];       ?></td>
	 <td><?php echo $row['consumerAccount'];    ?></td>
	 <td><?php echo $row['consumerCity'];       ?></td>
	 <td><?php echo $row['Description'];        ?></td>
	 <td style='text-align:right;padding:2pt;'><?php echo number_format($row['paidAmount']/100, 2, ',', ' '); ?></td>
	 <td><?php echo $row['Kenmerk'];            ?></td>
	 <td><?php echo $result['Inschrijving'];      ?></td>
	 <td><?php echo $result['Betaal_datum'];      ?></td>
	 <td><?php echo $row['TestMode'];      ?></td>
	 <?php  if ($row['Status']  =='PAID'){  ?>
	 <td style ='color:blue;'><?php echo $row['Status'];             ?></td>
	 <?php  } else {   ?>
	 <td style ='color:red;font-weight:blold;'><?php echo $row['Status'];             ?></td>
	 <?php } ?>
	
	</tr>

	<?php
	 $i++; 

}

?>
<TABLE>
	<tr><td valign="top" > 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
</tr>
</table>
<div style='font-size:9pt;'>&#169 OnTip - Erik Hendrikx, Bunschoten 2011-<?php echo date ('Y');?></div>
</body>
</html>