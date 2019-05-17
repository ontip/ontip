<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:yellow ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
</head>
<body>
 
<?php
/// Zet vreemde tekens om in codering 

include 'mysqli.php'; 
//include 'convert_text_string.php'; 

?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size:36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<?php
echo "<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>";
?>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>

<br><BR>
<center>
<div style='border: white inset solid 1px; width:800px; left:140px;text-align: center;'>
<FORM action='send_password.php' method='post'>

<input type='hidden' name ='Vereniging' value = "<?php echo $vereniging; ?>"/> 


<h3 style='padding:10pt;font size=20pt;color:green;text-align:center;'>Opvragen wachtwoord</h3>

<?php
	/// Omdat SQL problemen geeft met diakritische tekens in de Verenining is ervoor gekozen het record id van de user te parsen
?>

<table width=70%>
 <tr>
   <th width=60%' >Gebruikersnaam </th>   <td><input type='text'                  name='naam' size=45></td>
   <th width=60%' >Verenigingsnr (zonder spaties en -)</th><td><input type='text' name='vereniging_nr' size=10</td>
</tr>

<table>
	<tr> 
<div STYLE ='font size: 10pt; background-color:white;color:black ;'><INPUT type='submit' value='Selecteren'></div>
<br>
<div STYLE ='font size: 11pt; background-color:white;color:black;'><br>Nadat een naam geselecteerd is, 
		wordt een mail met het wachtwoord gestuurd naar het mail adres dat bij de gebruiker hoort. 
	</div>
</form>
</div>
</center>
</body>
</html>