<html>
<title>PHP Toernooi Inschrijvingen</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 5px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

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
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>


<?php
ob_start();
include 'mysqli.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email


$ip_adres = $_SERVER['REMOTE_ADDR'];

// haal geselecteerd toernooi op (bij select_toernooi wordt deze opgeslagen in de namen tabel

$sql         = mysqli_query($con,"SELECT * FROM namen WHERE  IP_adres = '".$ip_adres."' and  Vereniging = '".$vereniging."' and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi    = $result['Toernooi'];
$naam        = $result['Naam'];
$email                = $row['Email']; 
$email_encrypt        = $row['Email_encrypt'];

if ($email    =='[versleuteld]'){ 
    $email   = versleutel_string($email_encrypt);    
}


// uit config tabel	

$sql         = mysqli_query($con,"SELECT Waarde as toernooi_voluit from config WHERE  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele ='toernooi_voluit'   ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi_voluit   = $result['toernooi_voluit'];

// uit vereniging tabel	
	
$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

?>
<body>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 32pt; background-color:white;color:green ;'><?php echo $_vereniging; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:red;'>Contact pagina</h3>
    <p align="justify" Style='font-family:comic sans ms,sans-serif;color:blue;font-size:11pt;padding-left:15pt;'>Heeft u een vraag, klacht of wilt u gewoon meer informatie , vul dit contact formulier in en we nemen zo snel mogelijk contact met u op

<FORM action="send_vraag.php" method=post  name='myForm'>
     <input type="hidden" name="zendform" value="1" /> 
<input type="hidden" name="Vereniging"  value="<?php echo $_vereniging ?>" /> 

  <blockquote>
    <table>
    	<tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Vereniging</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><?php echo $_vereniging;?> </td>
      </tr>
      <tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Toernooi</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><input TYPE="TEXT" NAME="Toernooi" value = "<?php echo $toernooi_voluit;?>"   SIZE="44" >  </td>
      </tr>
      <tr>
        <td align="left" width="180" Style='font-family:Arial;font-size:9pt;color:black;'>Naam</td>
        <td><input TYPE="TEXT" NAME="Naam" SIZE="44" value="<?php echo $naam; ?>"> </td>
      </tr>
      <tr>
        <td align="left" Style='font-family:Arial;font-size:9pt;color:black;'>Telefoon</td>
        <td><input TYPE="TEXT" NAME="Telefoon" SIZE="25" MAXLENGTH="25"> </td>
      </tr>
      <tr>
        <td align="left" Style='font-family:Arial;font-size:9pt;color:black;'>E-mail verzender</td>
        <td><input TYPE="Email" NAME="Email"  value="<?php echo $email; ?>" SIZE="25"></td>
      </tr>
          
      <tr>
       <td Style='font-family:Arial;font-size:9pt;color:black;'>
      <label>Vraag of opmerkingen</label></td>
<td><label><textarea name='Opmerkingen' rows='6' cols='60' onfocus="change(this,'black','lightblue');" 
            	   onblur="change(this,'black','#F2F5A9');" rows='4' cols='45' >Typ hier evt vraag of opmerkingen.</textarea></label>
</td></tr>

 <tr>
       <td Style='font-family:Arial;font-size:9pt;color:black;'>
      <label>Kopie van email naar afzender</label></td>
      <td><input type='checkbox' name='Check' unchecked> Zet hier een vinkje als u een CC wilt ontvangen.</td>

</tr>
<!--tr>
	 <td Style='font-family:arial;font-size:9pt;color:black;'><br>Anti Spam</td>
        <td colspan = 2 Style='font-family:arial;font-size:10pt;color:black;'><input TYPE="TEXT" NAME="respons" SIZE="17" class="pink">  <- Neem onderstaande code uit grijze vlak over 
        	
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    
    
   echo "<div style= 'font-size:14pt; color:black;background-color:lightgrey;width:100pt;text-align:center;font-family:courier;'>". $string."</div>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";    
?>
</td></tr-->
   </table>
    <div class="g-recaptcha" data-sitekey="6LcuBVcUAAAAAHAIiFktH8ZZ22fLeBGKujfN-4ss"></div>   
  </blockquote>
 

<hr color='red' width=100% align='left'> 
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
 </form>

  <br>
    <p align="justify">
  

  <br class="clearfloat" />
  
<!-- end #container --></div>
</body>
<!-- InstanceEnd --></html>