<html>
<title>Email PHP Toernooi Inschrijvingen </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
a    {text-decoration:none;color:blue;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
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
<?php
ob_start();
include 'mysql.php'; 


/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}


$toernooi = '';
$datum    = '';
$id       = $_POST['toernooi'];

if ($id > 0) {
// Ophalen lijst toernooien 
$sql2     = mysql_query("select * from hulp_toernooi where Id = ".$id." ") or die(' Fout in select 1');
$result   = mysql_fetch_array( $sql2 );
$toernooi = $result['Toernooi'];	
$datum    = $result['Datum'];	
echo $id."<br>";
echo $toernooi."<br>";
}
else { 

mysql_query("Delete from hulp_toernooi  ") ;  

$insert = mysql_query("INSERT INTO hulp_toernooi
(`Toernooi`, `Vereniging`, `Datum`) 
 select  Toernooi, Vereniging, Datum from stats_email where Vereniging = '".$vereniging."' group by Vereniging, Toernooi, Datum ");

// Ophalen lijst toernooien 
$sql1 =  mysql_query("select * from hulp_toernooi   group by Datum order by Datum") or die(' Fout in select 1');


}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Basis queries

$sql       =   "SELECT distinct Email From stats_email where Vereniging = '".$vereniging."'  ";


if ($toernooi == 'Alle toernooien'){
    $toernooi =  ""; 
  }


if ($toernooi != ''){
    $sql       .= "  and Toernooi  = '".$toernooi."' and Datum = '".$datum."' " ;

}

//echo $sql;

/// uit hulp toernooi vereniging, toernooi en datum ophalen bij selectie toernooi

// Uitvoeren queries

$qry       = mysql_query($sql)     or die(' Fout in select sql');  


?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>

</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<br>

<h2>Verzamel email adressen uit archief tbv mailing </h2>
<br>
<FORM action='email_lijst_archief.php' method='post' name= 'myForm'>
<table width=45% border= 1 style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>
<tr>
	<td colspan =3 style='color:red;font-size:9.5pt;'><b>Maak een selectie voor toernooi of alle toernooien:</b> </td>
	<tr>
		
  <td width = 50% STYLE ='font-size: 9pt;color:darkgreen;background-color:white;'><span style='font-weight:bold;;text-align:left;'>Filter op toernooi </span></td>
  <td colspan =2 style='padding-right:5pt;'>  
  	
  	<?php if ($toernooi != '' ){?>
  	<SELECT name='toernooi' STYLE='font-size:9pt;background-color:yellow;font-weight:bold;font-family: Courier;width:350px;'>
    <?php }  else { ?>
   	<SELECT name='toernooi' STYLE='font-size:9pt;background-color:white;font-family: Courier;width:350px;'>
    <?php } ?>
 
  	<?php if ($toernooi != '' ){?>
  	  <option value='<?php echo $id;?>' selected'>Selectie: <b><?php echo $datum;?> - <?php echo $toernooi;?></b></option>
      <option value='Alle toernooien' >Alle toernooien</option>
    <?php } 
     else { ?>
  	   <option value='Alle toernooien' selected>Selecteer uit de lijst.....</option>
  	   <option value='Alle toernooien' >Alle toernooien</option>
    <?php }
    
 while($row = mysql_fetch_array( $sql1 )) {
 	    
	      echo "<OPTION  value=".$row['Id']."><keuze>";
    	  echo $row['Toernooi']." - ".$row['Datum'];
    	  echo "</keuze></OPTION>";	
    	  $i++;
       }  // end while toernooi
     ?>
         </SELECT>
 
  <!--// SELECT soort toernooi  -->
</td>
</tr>
<tr>
<td colspan =2 style='border:0pt;text-align:right;padding-right:5pt;'><INPUT type='submit' value='(Zoek) Filter bevestigen'></td>
  </tr>
 </table>
 <br>
</FORM>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Email adressen van toernooi "<?php echo $toernooi_voluit; ?>" </h3>

<br><br>
<center>
<font color ="red">Klik op de Select knop.
Alle email adressen worden geselecteerd. Druk op CTRL+C en plak daarna de gekopieerde tekst met CTRL-V in het <b>BCC</b> veld van Outlook.</i><br></center></font>
<center>
	<br>
<div id="myTable1" style="border: red solid 1px;padding:10pt;padding-left:20pt;width:800pt;" width=70%>  

<?php
$leden = mysql_query("SELECT distinct Email FROM stats_email WHERE Vereniging = '".$vereniging ."'  and Email <> '' ") or die(mysql_error());  
echo "<table>";
echo "<tr><td height='100ptx' Style='background-color:white;'>";
$i =1;

// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $qry )) {
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
</center>
<!--  Knoppen voor verwerking   ----->
<center>
<TABLE>
	<tr><td valign="top" style='background-color:background-color:white;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select to clipboard" />
</form>
</td>
</tr>
</table>
</center>

</body>
</html>












