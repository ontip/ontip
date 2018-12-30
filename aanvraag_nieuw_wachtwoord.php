<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:blue ;background-color:white; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
a    {text-decoration:none;color:blue;}

// --></style>
</head>
<body BACKGROUND="../ontip/images/ontip_grijs.jpg" width =40 bgproperties=fixed >
<br>
 
<?php
include 'mysql.php'; 
$qry          = mysql_query("SELECT * from vereniging where Vereniging ='".$vereniging."'  ")           or die(' Fout in select 1');  
$result       = mysql_fetch_array( $qry);
$vereniging   = $result['Vereniging'];
$_vereniging  = $vereniging;
$vereniging_output_naam = $result['Vereniging_output_naam'];

if ($vereniging_output_naam != '') {
   	$_vereniging = $vereniging_output_naam;
}


?>


<center>
	<br>
<div style='border: blue inset solid 1px; width:1200px; left:140px;text-align: center;'>
<FORM action='send_nieuw_wachtwoord.php' method='post'>

<input type='hidden' name ='vereniging' value = "<?php echo $vereniging; ?>"/> 

<h3 style='padding:10pt;font-size:20pt;color:green;text-align:center;'>Aanvraag nieuw wachtwoord</h3>
</center>
<center>
<blockquote>
<table border =1  style=';box-shadow: 5px 5px 3px #888888;'>
<tr><td rowspan =5 style='background-color:white;vertical-align:middle;padding:5pt;'><img src =  '../ontip/images/OnTip_banner_klein.png' width = 75</td>
<td colspan =2 Style='font-family:comic sans ms,sans-serif;color:white;font-size:10pt;background-color:#045FB4;padding-left:10pt;'>Vul hier je toegangscode  in</td></tr>
<tr><th width='150'STYLE ='color:green;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Toegangscode   </label></th><td STYLE ='background-color:white;color:green;'><label><input type='text'      name='Naam'        size=21/></label></td></tr> 
<tr><th width='150'STYLE ='color:green;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Anti spam   </label></th><td STYLE ='background-color:white;color:green;'><label>
        <input TYPE="TEXT" NAME="respons" SIZE="5" >  <- Neem onderstaande code uit grijze vlak over 
        	
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    
    
   echo "<div style= 'font-size:14pt; color:black;background-color:lightgrey;width:55pt;text-align:center;font-family:courier;'>". $string."</div>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";    
?>
</td></tr> 
<tr><td colspan =2 Style='font-family:comic sans ms,sans-serif;color:white;font-size:8pt;background-color:#045FB4;'>(c) OnTip <?php echo $_vereniging; ?></td></tr>
</table>




<br>
<INPUT type='submit' value='Vraag wachtwoord'>
<br>
<div STYLE ='font size: 11pt;color:black;'><br>Nadat de naam gevonden is, wordt een mail met het wachtwoord gestuurd naar het mail adres dat bij de gebruikersnaam hoort. Hierna kan het geactiveerd worden.
	</div>
</form>
</blockquote>
</div>
</center>
</body>
</html>