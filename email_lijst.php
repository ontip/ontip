<html>
<title>PHP Toernooi Inschrijvingen</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:#990000}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:#990000; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
// --></style>
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
<body>
<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx &#169 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>

<?php
ob_start();
include 'mysqli.php'; 


if(isset($_COOKIE['toernooi'])){ 
  	
$toernooi = $_COOKIE['toernooi'];   

}

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=e1"';
echo '</script>';
}
?> 
<div style='border: red solid 1px;'>
<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging ?></TD></tr>
	<?php if (isset($toernooi)){ ?>
<td STYLE ='font size: 20pt; background-color:#990000;color:white ;'> <?php echo $toernooi ?></TD></tr>
<?php } else { ?>
<td STYLE ='font size: 20pt; background-color:#990000;color:white ;'> onbekend</TD></tr>
<?php }?>

<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
</TR>
</TABLE>
</div>
<br><br>
<center>
<div style='border: white inset solid 1px; width:800px; left:140px;text-align: center;padding:15pt;'>
<h3>Hulpmiddel voor aanmaak Mailing</h3>
<font color ="yellow">Klik op de Select & Copy knop.
Alles wat zich binnen het rode vlak bevind wordt gekopieerd.
Plak daarna de gekopieerde tekst in Outlook.</i><br></center></font>


<div id="myTable1" style="border: red solid 1px;padding:10pt;">  

<?php
$leden = mysqli_query($con,"SELECT distinct Email FROM namen WHERE EMAIL <> '' ") or die(mysql_error());  
echo "<table>";
echo "<tr><td height='100ptx' Style='background-color:white;'>";
$i =1;


// keeps getting the next row until there are no more to get
while($row = mysqli_fetch_array( $leden )) {
	// Print out the contents of each row into a table
	echo $row['Email'];
	// Zet er steeds een punt-komma tussen
	echo "&#59  "; 
  $i++;
  if ( $i > 6)
   { echo "<br/>";
     $i =1;
    };
     

} 
echo "</td></tr>";
echo "</table></div>";



?>
</div>
<!--  Knoppen voor verwerking   ----->
<center>
<TABLE>
	<tr><td valign="top" style='background-color:background-color:#990000'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select & Copy to clipboard" />
</form>
</td>
</tr>
</table>
</center>
<br>
</body>
</html>

