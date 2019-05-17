<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
?>
<html>
<head>
<title>OnTip Release Notes</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 9pt;}
th   {color:blue;font-size: 9pt;}

</style>

<?php
// Database gegevens. 
include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


//Check op aanwezige berichten voor de vereniging of allen
$today      = date("Y") ."-".  date("m") . "-".  date("d");
$msg_qry    = mysqli_query($con,"SELECT * from release_notes order by Begin_datum desc")           or die(' Fout in select msg');  
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
		<td><h3 style='padding:10pt;font-size:20pt;color:green;'>PROGRAMMA AANPASSINGEN <img src = "../ontip/images/new_release.jpg" width=60 border = 0></h3></td>
			</tr>
</table>
<br>
		<div style='color:black;font-size:9pt;font-family:arial;'>Hieronder staat een opsomming van OnTip programma aanpassingen en nieuwe functies.</div><br>


<div style= 'position:absolute;left:20pt;width:1200px;border:1pt solid white;padding:10px;'> 	
	<table width=98% style= 'background-color:white;' border =1>
		<tr>
			<th style='width:10pt;'>Nr</th>
  		<th style='width:60pt;'>Datum</th>
			<th style='width:240pt;'>Omschrijving</th>
			<th style='width:70pt;'>Soort</th>
			<th style='width:280pt;'>Uitleg</th>
		</tr>	
	<?php
	$i=1;
	while($row = mysqli_fetch_array( $msg_qry )) {
   
   $datum = $row['Begin_datum'];
   
   $dag   = 	substr ($datum , 8,2); 
   $maand = 	substr ($datum , 5,2); 
   $jaar  = 	substr ($datum , 0,4); 

   echo "<tr>";
   echo "<td style= 'font-size:10pt;color:black;text-align:right;padding-right:5pt;'>".$i."</td>";
   echo "<td style= 'font-size:10pt;color:black;'>".strftime("%e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ."</td>";
   echo "<td style= 'font-size:10pt;color:black;'>".$row['Omschrijving']."</td>";
   echo "<td style= 'font-size:10pt;color:red;'>".$row['Soort']."</td>";
   echo "<td style= 'font-size:10pt;color:black;'>".$row['Detail']."";
   echo "</tr>";
 $i++;
 }// end while
 ?>
</table>
</div><br><br>


