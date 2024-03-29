<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# aanvraag_extra_beheerder.php
#  Formulier voor aanvragen OnTip beheerder voor de vereniging.  Start send_aanvraag_beheerder.php
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 29nov2018          1.0.1           E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None.
# Feature:          None.
# Reference: 

# 29nov2018          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               PHP7.
# Feature:           None.
# Reference: 

*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:blue ;background-color:white; font-size: 10pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left; }
TD {color:black ;background-color:white; font-size:10pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
a    {text-decoration:none;color:blue;}
 input:focus, input.sffocus  { background: lightblue;cursor:underline; }
 textarea:focus { background: lightblue;cursor:underline; }
 
// --></style>
<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("TEXTAREA");
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
<script type="text/javascript">
	
function make_blank_opmerkingen()
{
	document.myForm.Opmerkingen.value="";
}
</Script>

</head>
<body>
 
<?php
// Database gegevens. 
include('mysqli.php');	
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}


//include 'convert_text_string.php'; 
$ip        = $_SERVER['REMOTE_ADDR'];
$sql      = mysqli_query($con,"SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result   = mysqli_fetch_array( $sql );
$naam     = $result['Naam'];
$email     = $result['Email'];
$vereniging_id = $result['Vereniging_id'];


?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'https://www.ontip.nl/ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size:36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<?php
echo "<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>";
?>

<br><BR>
<center>
	<br>
<div style='border: blue inset solid 1px; width:1200px; left:140px;text-align: center;'>
<FORM action='send_aanvraag_extra_beheerder.php' method='post'>

<input type='hidden' name ='zendform'        value = "1"/> 
<input type='hidden' name ='vereniging'      value = "<?php echo $vereniging; ?>"/> 
<input type='hidden' name ='vereniging_id'   value = "<?php echo $vereniging_id; ?>"/> 
<input type='hidden' name ='aanvrager'       value = "<?php echo $naam; ?>"/> 
<input type='hidden' name ='email_aanvrager' value = "<?php echo $email; ?>"/> 


<h3 style='padding:10pt;font-size:20pt;color:green;text-align:center;'>Aanvragen extra beheerder</h3>

<table width=70%  border = 0 >
	 <tr>
  <th style='color:blue;' width=40% >Vereniging</th> 
  <td><b><?php echo $vereniging;; ?></b></td> </tr>
 <tr>
 	 <tr>
  <th style='color:blue;' width=40% >Naam aanvrager</th> 
  <td><b><?php echo $naam; ?></b></td> </tr>

 <tr>
  <th style='color:blue;' width=40% >Voornaam nieuwe beheerder</th> 
  <td><input type="text" name="naam"   size=40         /></td> </tr>
 <tr>
  <th style='color:blue;' width=40% >Email adres nieuwe beheerder</th> 
   <td><input type="email" name="email"   size=40        /></td> </tr></tr>
	
	<tr><th width='150' rowspan =4  valign=top><label>Soort beheerder   </label></th>
  <td><label><input  type ='radio' name='rechten' Value='A' checked />Alles</label></td></tr>
  <tr><td><label><input  type ='radio' name='rechten' Value='C' />Alleen aanmaak en aanpassen toernooien</label></td></tr>
  <tr><td><label><input  type ='radio' name='rechten' Value='I' />Alleen inschrijvingen</label></td></tr>
  <tr><td><label><input  type ='radio' name='rechten' Value='W' />Wedstrijd commissie (heel beperkt toernooi aanpassen)</label></td></tr>
     	
<tr>
       <th Style='color:blue;' valign=top>
      <label>Vraag of opmerkingen</label></th>
<td><label><textarea name='opmerkingen' rows='6' cols='60' onfocus="change(this,'black','lightblue');" onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','#F2F5A9');" rows='4' cols='45' onclick="make_blank_opmerkingen();">Typ hier evt vraag of opmerkingen.</textarea></label>
</td></tr>
<th Style='font-family:arial;font-size:9pt;color:blue;'><br>Anti Spam</th>
        <td colspan = 2 Style='font-family:arial;font-size:10pt;color:green;'><input TYPE="TEXT" NAME="respons" SIZE="5" >  <- Neem onderstaande code uit grijze vlak over 
        	
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
</td></tr></table>
<br>
<INPUT type='submit' value='Verzenden'>
<br>
<div STYLE ='font size: 11pt;background-color:white;color:black;'><br>Zodra de aanvraag door de Ontip beheerder is goedgekeurd, wordt een mail met het wachtwoord gestuurd naar het mail adres van de nieuwe beheerder. 
	</div>
</form>
</div>
</center>
</body>
</html>