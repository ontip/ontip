<html>
	<title>Intrekken inschrijving</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }
// --></style>

<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("INPUT");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onfocus=function() {
            this.className+=" sffocus";
        }
        sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfFocus);
     -->
</Script>
</head>

<body>
 
<?php
include 'mysql.php'; 

	$toernooi = $_GET['Toernooi'];
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens
if (isset($toernooi)) {
	

	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Regel < 9000 and Regel > 0 order by Regel")     or die(' Fout in select');  
 }
else {
		echo " Geen toernooi bekend :";
	};

//echo  "toernooi : ". $toernooi;

/// Als eerste kontrole op laats


// hulp tabel toernooi schonen

mysql_query("Delete from toernooi   ") ;  
$query = "INSERT INTO toernooi (Vereniging, Toernooi) select Distinct Vereniging, Toernooi from config where Vereniging = '".$vereniging ."'";
mysql_query($query) or die (mysql_error()); 
// ---------------------------------------------------------------------------------------------------------------------------------------------------
?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='240'></td>
<td STYLE ='font size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>



<h3 style='padding:10pt;font size=20pt;color:green;'>Intrekken inschrijving - <?php echo htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></h3>

<br><br>
<center>

<FORM action='select_verwijderen_inschrijving_stap2.php' method='post'>
	
	<div style='background-color:white;'>
		Voor het intrekken van uw inschrijving dient u het kenmerk van de inschrijving, zoals vermeld in de bevestigingsmail, op te geven
		</div>
			
	
	
<table width=70% border =0 >
	<tr>
        <td ><em>Geef hier het volledige kenmerk (xxxxxxxx.xxxxxx)</em></td>
        <td ><input TYPE="TEXT" NAME="Kenmerk" SIZE="25" class="pink"> </td>
    </tr>
    <tr>
        <td ><em>Naam van eerste speler (gelijk aan inschrijving)</em></td>
        <td ><input TYPE="TEXT" NAME="Naam1" SIZE="45" class="pink"> </td>
    </tr>
 </table>
 
  
 <input type='hidden' name='Toernooi'    value='<?php echo $toernooi;?>'/>
 <input type='hidden' name='vereniging'  value='<?php echo $vereniging;?>'/>      
      
<div STYLE ='font size: 10pt; background-color:white;color:orange ;'><INPUT type='submit' value='Bevestigen'></div>

</form>
</div>
</center>

</body>
</html>
