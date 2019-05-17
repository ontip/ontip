<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<html>
<head>
<title>OnTip INBOX</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 9pt;}
</style>

<?php
// Database gegevens. 
include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


//Check op aanwezige berichten voor de vereniging of allen
$today      = date("Y") ."-".  date("m") . "-".  date("d");
$msg_qry    = mysqli_query($con,"SELECT * from messages where (Vereniging = '".$vereniging."' or Vereniging = '*ALL*')  and Begin_datum <= '".$today."' and Eind_datum > '".$today."'  order by Laatst desc")           or die(' Fout in select msg');  
$msg_count  = mysqli_num_rows($msg_qry);


?>
<body >
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size:36pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving<br><?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
             
<span style='text-align:right;font-size:9pt;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<table border =0 width=75%><tr>
		<td><h3 style='padding:10pt;font-size:20pt;color:green;'>POSTBUS      <img src = "../ontip/images/mailbox.jpg" width=45 border = 1></h3></td>
			</tr>
</table>
<br>
		<div style='color:black;font-size:9pt;font-family:arial;'>Deze postbus bevat berichten m.b.t. OnTip. Deze kunnen bestemd zijn voor de eigen vereniging of voor alle OnTip verenigingen en hebben meestal betrekking op technische problemen waardoor een of meer OnTip functies niet beschikbaar zijn.</div><br>


<div style= 'position:absolute;left:20pt;width:1200px;border:1pt solid red;padding:10px;'> 	
	<table width=98% style= 'background-color:white;' border =1>
		<tr>
			<th style='width:120pt;'>Datum</th>
			<th style='width:200pt;'>Vereniging</th>
			<th style='width:280pt;'>Bericht</th>
		</tr>	
	<?php
	while($row = mysqli_fetch_array( $msg_qry )) {
   
   echo "<tr>";
   echo "<td style= 'font-size:10pt;color:black;'>".$row['Begin_datum']."</td>";
   echo "<td style= 'font-size:10pt;color:blue;'>".$row['Vereniging']."</td>";
   echo "<td style= 'font-size:10pt;color:blue;'>".$row['Bericht_regel1']."";
 
   if ($row['Bericht_regel2'] !=''){
     echo "<br>".$row['Bericht_regel2']."";
   }  
     
   echo "</td>";
   echo "</tr>";

 }// end while
 ?>
</table>
</div><br><br>
