<html>
<title>PHP Copy files</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:#990000}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:#990000; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:yellow ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
<head>
<body>


<?php
ob_start();
include 'mysql.php'; 
/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=Y"';
echo '</script>';
}

 ?>

<div style='border: red solid 1px;background-color:#990000;'>
<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging ?></TD></tr>
<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
</TR>
</TABLE>
</div>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>

<?php
ob_start();
$sql        = "SELECT distinct Vereniging, Prog_url from namen where Prog_url <> '' order by Vereniging  ";
//echo $sql;
$namen      = mysql_query($sql);
?>
<br><br>

<br><br>
<center>
<div style='border: white inset solid 1px; width:1000px; text-align: center;'>
<form method = 'post' action='copy_files_stap2.php'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<h3  style='padding:10pt;font size=20pt;color:orange;text-align:center;'>Copy files</h3>
<div Style='font-family:comic sans ms,sans-serif; color:yellow;size:12pt;'>Selecteer folder naam en extentie</div><br/><br/>

<table >
<tr><td width='250'STYLE ='background-color:#990000;color:orange;'><label>Bron   </label></th><td STYLE ='background-color:#990000;color:orange;'><label><input type='text'  name='source' value='../boulamis_toernooi'  size=40/></label></td><tr>

<tr><td width='250'STYLE ='background-color:#990000;color:orange;'><label>Doel</label></th><td STYLE ='background-color:#990000;color:orange;'><label>
	<select name='destination' STYLE='width: 240px;'><option value='' selected>Selecteer doel</option>
		
		<?php
	
	
	while($row = mysql_fetch_array( $namen )) {
		
		echo "<option value ='".$row['Prog_url']."'>".$row['Vereniging']."</option>";
		
	}// end while	
	?>	
		
<option value='../boulamis_toernooi/backups'>Backups</option>
<option value='../temp'>temp</option>
</SELECT></label></td><td>
</td></td></tr>

<tr><td width='250'STYLE ='background-color:#990000;color:orange;'><label>File extentie </label></th><td STYLE ='background-color:#990000;color:orange;'><label>
	<select name='extentie' STYLE='width: 240px;'><option value='' selected>Selecteer extentie</option>
<option value='php'>PHP</option>
 <option value='css'>CSS</option>
</SELECT></label></td><td>
</td></td><tr>

</table><br><br>

<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
<br><br><a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>

</div>
</body>
</html>
