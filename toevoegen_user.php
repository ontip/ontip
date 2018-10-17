<html>
	<Title>PHP Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:#990000}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:#990000; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:yellow ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>
</head>

<body>
 
<?php
include 'mysql.php'; 

//echo  "vereniging : ". $vereniging;

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=U"';
echo '</script>';
}


// ---------------------------------------------------------------------------------------------------------------------------------------------------
?>
<div style='border: red solid 1px;background-color:#990000;'>

<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo; ?>' width='<?php echo $grootte_logo; ?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
</TR>
</TABLE>
</div>

<br><br>
<center>
<div style='border: white inset solid 1px; width:1000px; text-align: center;'>
<FORM action='add_user.php' method='post'>
	<h3  style='padding:10pt;font size=20pt;color:orange;text-align:center;'>Toevoegen user</h3>
	
<table width=90%>
 <tr>
 	<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Naam vereniging</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:#990000;color:orange ;'><input type='text'   name='vereniging' size=40 /></label</td></tr>
<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Naam user</td>
    <td STYLE ='background-color:#990000;color:orange;font size: 12pt;'><label><input type='text'   name='naam' size=40 /></label</td></tr>
<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Wachtwoord</td>
 	<td STYLE ='background-color:#990000;color:orange;font size: 12pt;'><label><input type='password'   name='wachtwoord1' size=10   /></td></tr>
</tr>
<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Nogmaals wachtwoord</td>
 	<td STYLE ='background-color:#990000;color:orange;font size: 12pt;'><label><input type='password'   name='wachtwoord2'  size=10  /></td></tr>
</tr>
<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Prog folder (../naam vereniging)</td>
 	<td STYLE ='background-color:#990000;color:orange;font size: 12pt;'><label><input type='text'   name='url'  size=40  /></td></tr>
</tr>
<tr><td STYLE ='font size: 12pt; background-color:#990000;color:orange ;'>Email </td>
 	<td STYLE ='background-color:#990000;color:orange;font size: 12pt;'><label><input type='text'   name='email' size=40   /></td></tr>
</tr>


	</td>
</table><br><br>

<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
<br><br><a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>
</form>
</div>
</center>

</body>
</html>
