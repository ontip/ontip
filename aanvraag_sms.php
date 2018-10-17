<html>
<title>OnTip aanvraag SMS bundel</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">                
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: verdana;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 5px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;font-size: 9.0pt }
 input:focus, input.sffocus  { background: lightblue;cursor:underline; }
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
<Script Language="Javascript">
function make_blank_opmerkingen()
{
	document.myForm.Opmerkingen.value="";
}

function make_blank_aantal()
{
	document.myForm.Aantal_sms.value="";
}

function make_blank_email()
{
	document.myForm.Email.value="";
}

function make_blank_telefoon()
{
	document.myForm.Telefoon.value="";
}


function validate() {
	
	if (document.myForm.introductie.checked == true) {
      document.myForm.Aantal_sms.value= "5";
   }
   
   if (document.myForm.introductie.checked == false) {
      document.myForm.Aantal_sms.value= "100";
   }
   
   }
</Script>
</head>

<body>

<?php
ob_start();
include 'mysql.php'; 
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

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

//// Check op rechten
$sql      = mysql_query("SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres = '".$ip_adres."' and Aangelogd = 'J'  ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// uit vereniging tabel	
	
$qry                    = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row                    = mysql_fetch_array( $qry );
$url_logo               = $row['Url_logo'];
$url_website            = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];
//$max_aantal_sms         = $row['Max_aantal_sms'];
$telefoon               = $row['Tel_contactpersoon'];

// Check op max aantal sms berichten
include('sms_tegoed.php');

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $_vereniging; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<h3 style='padding:10pt;font-size:14pt;color:green;'>Aanvraag SMS bundel <img src = '../ontip/images/sms_bundel.jpg' width='60'></h3>
  
<?php
if (isset($_GET['verzonden'])){
	echo "<br><span Style='font-family:comic sans ms,sans-serif;color:blue;font-size:15pt;padding-left:15pt;'>Aanvraag is verzonden</span><br>";
}
else {?>

  <blockquote>
     <p align="justify" Style='font-family:verdana;color:black;font-size:10pt;padding-left:15pt;'>Vul voor het aanvragen van een SMS bundel dit formulier in en we nemen zo snel mogelijk contact met u op. U ontvangt per omgaande een faktuur op het aangegeven email adres. <br>
    Voor de <b>eenmalige kennismakingsactie</b> dient u een vinkje te zetten onder aan deze pagina bij 'Ik wil nog niet overgaan tot ......'<br>
    De SMS bundel kan gebruikt worden voor alle toernooien van de vereniging. <br>Met het versturen van deze aanvraag verplicht u zich de aangevraagde bundel te betalen. De kosten zijn &euro;  0,16 per sms.
    <br>Pas na betaling zal de bundel geactiveerd worden. Indien gewenst kunt u van de activatie een SMS bericht ontvangen. Zie optie 3 onder aan de pagina.</p>
   </blockquote>
  
<table border =1 width=50%>
  <tr><td style='background-color:white;color:red;padding:5pt;font-size:11pt;text-align:center;' >  Er zijn nu <?php echo $sms_aantal; ?> berichten verstuurd van in totaal <?php echo $max_aantal_sms;?>. Laatste bundel update : <?php echo $datum_sms_saldo_update;?></td>
  </tr>
</table>
 
<FORM action="send_aanvraag_sms.php" method=post name = "myForm">
 
<input type="hidden" name="zendform"    value="1" /> 
<input type="hidden" name="Kosten"      value="16" /> 

  <blockquote>
    <table>
    	<tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:green;padding-left: 8px;'>Vereniging</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:14pt;'><?php echo $_vereniging;?> </td>
      </tr>
      <tr>
        <td align="left" width="180" Style='font-family:Arial;font-size:9pt;color:green;'>Naam</td>
        <td><input TYPE="TEXT" NAME="Naam" SIZE="44" > </td>
      </tr>
      <tr>
        <td align="left" width="180" Style='font-family:Arial;font-size:9pt;color:green;'>Telefoon</td>
        <td><input TYPE="TEXT" NAME="Telefoon" value="<?php echo $telefoon; ?>"  SIZE="44" onclick="make_blank_telefoon();"><em>(Mag alleen cijfers bevatten)</em> </td>
      </tr>
      <tr>
        <td align="left" Style='font-family:Arial;font-size:9pt;color:green;'>Aantal SMS berichten (min 100)</td>
        <td><input style= 'text-align:right;'  TYPE="TEXT" NAME="Aantal_sms" SIZE="5" MAXLENGTH="5" value = '100' onclick="make_blank_aantal();"> </td>
      </tr>
      <tr>
        <td align="left" Style='font-family:Arial;font-size:9pt;color:green;'>E-mail verzender</td>
        <td><input TYPE="TEXT" NAME="Email"  value="<?php echo $email_organisatie; ?>" SIZE="25"  onclick="make_blank_email();"></td>
      </tr>
      <tr>
	 <td Style='font-family:arial;font-size:9pt;color:green;'><br>Anti Spam</td>
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
</td></tr>
    </table>
      <table>
      <tr>
     <tr>
       <td Style='font-family:Arial;font-size:9pt;color:green;'>
      <label>Vraag of opmerkingen</label></td>
<td><label><textarea name='Opmerkingen' rows='5' cols='80' onfocus="change(this,'black','lightblue');" onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','#F2F5A9');" rows='4' cols='45' onclick="make_blank_opmerkingen();">Typ hier evt vraag of opmerkingen.</textarea></label>
</td></tr>

 <tr>
       <td Style='font-family:Arial;font-size:9pt;color:blue;' colspan =2><input type='checkbox' name='introductie' unchecked  onclick="validate()" >&nbsp
      1. Ik wil nog niet overgaan tot aanschaf van een bundel, maar wil eerst gebruik maken van de <u>eenmalige kennismakingsactie</u>. Hierbij krijg ik 10 gratis SMS jes. Dit verplicht me verder niet tot aanschaf van een grotere SMS bundel.</td>
      <td>
</tr>
 <tr>
       <td Style='font-family:Arial;font-size:9pt;color:blue;' colspan =2><input type='checkbox' name='extra_kosten' unchecked>&nbsp
      2. Ik ga akkoord met de bovenaan de pagina vermelde voorwaarden en de algemene voorwaarden (zie link rechtsboven).</td>
      <td>
</tr>
 <tr>
       <td Style='font-family:Arial;font-size:9pt;color:blue;' colspan =2><input type='checkbox' name='sms_bevestiging' unchecked>&nbsp
      3. Ik wil de bevestiging van aanmaak van de bundel als SMS op het bovenstaande telefoonnummer ontvangen.Deze gaat van mijn SMS tegoed af (met uitzondering van kennismakingsactie).</td>
      <td>
</tr>


   </table>
  </blockquote>
<br>


       <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
        </td>
      </tr>
      <tr>
        <td ALIGN="center" style= 'Font-family:arial;'>
        	<input TYPE="submit" VALUE="Verzenden" ACCESSKEY="v">&nbsp;&nbsp;
        	<input  TYPE="reset" VALUE="Herstellen" ACCESSKEY="h">&nbsp;&nbsp;
        	
        <td>
      </tr>
    </table>
  </div>
  </blockquote>
 </form><br>

<hr color='red' width=100% align='left'> 
 
<table border =0 width=50%>
  <tr><td style='background-color:white;color:black;padding:5pt;font-size:10pt;' > 
Betaling op het in de faktuur aangegeven rekening nummer onder vermelding van <b>Aanvraag SMS bundel <?php echo $vereniging;?></b>
</td>
</tr>
 </table>
<?php
/// aanvraag verzonden
 }
?>
</body>
</html>
