<?php
# change_password_stap2.php
# Aanpassen wachtwoord beheerder ontip vereniging
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 2april2019          1.0.2            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None
# Fix:              None
# Feature:          PHP7.
# Reference: 
?>
<html>
	<Title>OnTip</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Calibri, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:yellow ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

// --></style>
</head>

<?php
ob_start();

$error       = 0 ;
$message     = '';

/// Controles

$naam                  = $_POST['naam'];
$wachtwoord_oud        = $_POST['wachtwoord_bron'];
$wachtwoord_new1       = $_POST['wachtwoord_new1'];
$wachtwoord_new2       = $_POST['wachtwoord_new2'];
$vereniging_id         = $_POST['Vereniging_id'];
$vereniging            = $_POST['Vereniging'];

// kontrole wachtwoord
include 'mysqli.php'; 
include 'versleutel.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$encrypt= md5($wachtwoord_oud);

$sql      = mysqli_query($con,"SELECT count(*) as Aantal FROM namen WHERE  Naam='".$naam."' and Wachtwoord_encrypt ='".$encrypt."' and Vereniging_id = ".$vereniging_id."  ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count < 1){
	$error = 1;
	$message .='* Bestaand wachtwoord is niet correct of toegangscode bestaat niet!<br>'; 
}

if ($wachtwoord_new1 != $wachtwoord_new2){
	$error = 1;
	$message .= '* Nieuw wachtwoord en herhaling zijn niet gelijk!<br>'; 
}



if ($error != 0 ){

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon foutmeldingen

  $error_line      = explode("<br>", $message);   /// opsplitsen in aparte regels tbv alert
  ?>
   <script language="javascript">
        alert("Er zijn een of meer fouten gevonden bij het invullen :" + '\r\n' + 
            <?php
              $i=0;
              while ( $error_line[$i] <> ''){    
               ?>
              "<?php echo $error_line[$i];?>" + '\r\n' + 
              <?php
              $i++;
             } 
             ?>
              "")
    </script>
  <script type="text/javascript">
		window.location.replace('change_password_stap1.php?naam=<?php echo $naam; ?>');
	</script>
<?php
 } // error = 1
 
 
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($error == 0 ){

$date     = date('YmdHis');

$sql       = mysqli_query($con,"SELECT * FROM namen WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$naam."'   ") or die(' Fout in select aantal');  
$result    = mysqli_fetch_array( $sql );
$id        = $result['Id'];

$Email            = $result['Email'];
$Email_encrypt    = $result['Email_encrypt'];
  
if ($Email =='[versleuteld]'){ 
  $Email      = versleutel_string($Email_encrypt);    
}
 
$encrypt = md5($wachtwoord_new1);
$timest  = versleutel_string('@##'.date('Y-m-d H:i:s'));

//$Email ='erik.hendrikx@kpnmail.nl';

$qry3          = mysqli_query($con,"SELECT * from vereniging where Vereniging =  '".$vereniging."' ");
$row3          = mysqli_fetch_array( $qry3 );
$email_noreply = $row3['Email_noreply'];
  
if ($email_noreply == '') {
$email_noreply = 'noreply@ontip.nl';
}
	
//  mail versturen

$subject = 'Bevestiging wijziging wachtwoord  ';
$to      = $Email;

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';
 
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";

$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
      'Return-Path: '.$email_organisatie    . "\r\n" . 
      'Reply-To: '   . $from . "\r\n" .
      'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "U heeft een wachtwoord wijziging aangevraagd :</div><br> " .  "\r\n\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>Vereniging        : </td><td>". utf8_decode($vereniging) ."</td></tr>".  "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>Id                : </td><td>". $id ."</td></tr>".  "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>User              : </td><td>". $naam ."</td></tr>".  "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>Nieuw wachtwoord  : </td><td>". $wachtwoord_new1."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<br><br>Klik op de onderstaande link om het wachtwoord daadwerkelijk te wijzigen :<br><br><br> " . "\r\n\r\n";

//$bericht.= "\r\n\r\n<a href = 'https://www.ontip.nl/ontip/change_password_stap3.php?id=".$id."&md5=".$encrypt."' target= '_blank'><br>Klik hier voor activeren nieuw wachtwoord</a>";
$bericht.= "\r\n\r\n<a href = 'https://www.ontip.nl/ontip/change_password_stap3.php?id=".$id."&md5=".$encrypt."&timest=".$timest."' target= '_blank'><br>Klik hier voor activeren nieuw wachtwoord</a>";
$bericht .= "<br><br>Je hebt hiervoor een half uur de tijd.<br><br><br> " . "\r\n\r\n";
$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
$bericht .= "</div>";

//echo $bericht;

if ($Email !=''){
   mail($Email, $subject, $bericht, $headers,"-finfo@ontip.nl");

echo "<h1>Wijziging wachtwoord bevestigen</h1>";
echo "<div style='font-size:12pt;color:black;'>"; 
echo "<br>De mail voor aanpassing van het wachtwooord is verstuurd naar <b>".$Email.".</b><br> In deze mail staat een link om de wijziging daadwerkelijk te activeren. Pas na de activatie is het nieuwe wachtwoord geldig !!!<br></div> ";
}
else { 
echo "<div style='font-size:12pt;color:black;'>"; 
echo "<br>De mail voor aanpassing van het wachtwooord kon niet verstuurd worden. Er is geen email adres bekend !!!<br></div> ";
}
	
}// end error = 0
 