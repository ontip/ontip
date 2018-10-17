<?php
ob_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Statistieken inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;}
th   {color:blue;font-size:9pt;font-family: sans-serif;font-weight:bold;;background-color:white;border-color:black;}
td   {color:black;font-size:9pt;font-family: sans-serif;background-color:white;border-color:black;padding:2pt;}
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
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
include('mysql.php');


if (isset($_COOKIE['_month'])){
 $select_month  = $_COOKIE['_month'];
 $select_year   = $_COOKIE['_year'];
 } else {
   $select_month  = date('m');
   $select_year   = date('Y');
 }	

 $curr_month   = date('m');
 $curr_year    = date('Y');
 
//echo "SELECT DAY(Inschrijving) as Dag, count(*) as Aantal from inschrijf where Month(Inschrijving) = '".$select_month."'
//	                     and Year(Inschrijving) = '".$select_year."' group by 1 order by 1  ";
	 
		
	$qry   = mysql_query("SELECT DAY(Inschrijving) as Dag, WEEKDAY(Inschrijving) as Dagnaam, count(*) as Aantal from inschrijf where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."' group by 1 order by 1  ")     or die(' Fout in select namen');  
	 
	 
// Definieeer variabelen en vul ze met waarde uit tabel

$achtergrond_kleur = 'white';
$today = date('Y-m-d');

?>
<body >
<FORM action='select_month.php' method='post'>   
<table width=100% border=0>
		<td width=65% ><h3  style='padding:10pt;font size=20pt;color:green;text-align:center;font-family:cursive;'>OnTip - <?php echo strftime("%B",mktime(0,0,0,$select_month,1,$select_year))."  ". $select_year ; ?></h3></td>
    <td width='270' STYLE ='font size: 15pt;color:blue ;font-family:cursive;font-size:9pt;'>Selecteer maand en jaar..</td>
    <td width='410' >
    	  <select name='Month' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
<?php
 for ($m=1;$m<=12;$m++){
 	
 	if ($m == $curr_month ){
 		  echo "<option value=".$m."  selected>".strftime("%B",mktime(0,0,0,date("m"),date("d"),$curr_year))."</option>";
 		}
 		else {
 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),$curr_year))."</option>";
 			}
 }			
 	?>
</SELECT>
 <select name='Year' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
<?php
 for ($y=2011;$y<=2020;$y++){
 	
 	if ($y == $curr_year ){
 		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 			}
 }			
 	?>
</SELECT>
<INPUT type='submit' value='Ophalen' style='font-size:8pt;'></td>
</tr>

	</table>
</form>
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table border =0 width=90%>"; 
echo "<tr><td style='background-color:".$achtergrond_kleur.";'><img src='".$url_logo."' width='".$grootte_logo.">";
echo "</td><td style='background-color:".$achtergrond_kleur.";'>";
echo "</td></tr></table>";

echo"<h1>Inschrijvingen per dag</h1>";

$totaal =0;
?>
<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =2>Dag</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 
	 	 		echo 
	 	 	strftime("%A",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 	 	<td style= 'text-align:right;' ><?php 
	 	 		echo 
	 	 	strftime("%d %B %Y",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
</table>		
</body>
</html>