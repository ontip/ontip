<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Statistieken inschrijvingen Browser en OS</title>
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

<?php 
// Database gegevens. 
ob_start();
/* Set locale to Dutch */

include('mysql.php');
setlocale(LC_ALL, 'nl_NL');

$sql_aant_per_browser      = mysql_query("SELECT Browser,      count(*) as Aantal  FROM `hulp_naam`  where Browser <> ''      group by 1 order by 2 desc")     or die(' Fout in select 17');  
$sql_aant_per_os_platform  = mysql_query("SELECT OS_platform,  count(*) as Aantal  FROM `hulp_naam`  where OS_platform <> ''  group by 1 order by 2 desc")     or die(' Fout in select 17');  
 
 
 ?>
 <a name='per_browser'><h1>Browser en OS Platform</h1></a>
<table>
<tr>
 <td>



<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =1>Browser</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysql_fetch_array( $sql_aant_per_browser    )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 	 	 		echo $row['Browser'];?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	
	
</table>

<td>
<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =1>OS Platform</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysql_fetch_array( $sql_aant_per_os_platform   )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 	 	 		echo $row['OS_platform'];?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	
	
</table>

</td>


</tr>
</table>
