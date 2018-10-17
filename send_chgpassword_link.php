<html>
	<Title>PHP Inschrijvingen (c) Erik Hendrikx</title>
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

if ($wachtwoord_oud == '') {
	 $message .= "Bestaand wachtwoord is niet ingevuld ! <br>";
	 $error = 1;
}

if ($naam == '') {
	 $message .= "Naam is niet ingevuld ! <br>";
	 $error = 1;
}

if ($wachtwoord_oud != '' and $wachtwoord_new1 =='') {
	 $message .= "Nieuw wachtwoord(1) is niet ingevuld ! <br>";
	 $error = 1;
}

if ($wachtwoord_oud !='' and $wachtwoord_new2 =='') {
	 $message .= "Nieuw wachtwoord(2) is niet ingevuld ! <br>";
	 $error = 1;
}

if ($wachtwoord_oud != '' and $wachtwoord_new1 != $wachtwoord_new2) {
	 $message .= "Nieuw wachtwoord(1) is niet gelijk aan nieuw wachtwoord(2) <br>";
	 $error = 1;
}

if ($wachtwoord_oud != ''  and  $wachtwoord_new1 !=''  and strlen($wachtwoord_new1) < 4){
	 $message .= "Nieuw wachtwoord moet minimaal 4 karakters lang zijn.<br>";
	 $error = 1;
}



	/// kontrole wachtwoord
include 'mysql.php'; 
include 'versleutel.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$encrypt= versleutel($wachtwoord_oud);
$sql      = mysql_query("SELECT count(*) as Aantal FROM namen WHERE  Naam='".$naam."' and ( Wachtwoord='".$encrypt."' or Wachtwoord = '".md5($wachtwoord_oud)."'   )and Vereniging_id = ".$vereniging_id."  ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];



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
		window.location.replace('change_password.php?naam=<?php echo $naam; ?>');
	</script>
<?php
 } // error = 1
 
 
 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$date     = date('YmdHis');

$sql       = mysql_query("SELECT * FROM namen WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$naam."'   ") or die(' Fout in select aantal');  
$result    = mysql_fetch_array( $sql );
$id        = $result['Id'];

$Email            = $result['Email'];
$Email_encrypt    = $result['Email_encrypt'];
  
if ($Email =='[versleuteld]'){ 
$Email      = versleutel_string($Email_encrypt);    
}


?>


<body>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
 <span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span><br>
 	
 	
<?php

$qry3          = mysql_query("SELECT * from vereniging where Vereniging =  '".$vereniging."' ");
$row3          = mysql_fetch_array( $qry3 );
$email_noreply = $row3['Email_noreply'];
  
if ($email_noreply == '') {
$email_noreply = 'noreply@ontip.nl';
}

	$encrypt = md5($wachtwoord_new1);
	
	
//  mail versturen


$subject = 'Bevestiging wijziging wachtwoord  ';
$to      = $Email;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip Admin <$email_noreply>' . "\r\n" .	 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht = "U heeft een wachtwoord wijziging aangevraagd :</div><br> " .  "\r\n\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>Vereniging  : </td><td>". utf8_decode($vereniging) ."</td></tr>".  "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>User        : </td><td>". $naam ."</td></tr>".  "\r\n";
$bericht .= "<tr><td Style='font-family:verdana;font-size:9pt;' width=200>Nieuw wachtwoord  : </td><td>". $wachtwoord_new1   ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<br><br>Klik op de onderstaande link om het wachtwoord daadwerkelijk te wijzigen :<br><br><br> " . "\r\n\r\n";


$bericht.= "\r\n\r\n<a href = 'https://www.ontip.nl/ontip/activeer_nieuw_wachtwoord.php?id=".$id."&md5=".$encrypt."' target= '_blank'><br>Klik hier voor activeren nieuw wachtwoord</a>";
$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";


$bericht .= "</div>";

if ($Email !=''){
   mail($to, $subject, $bericht, $headers);

echo "<h1>Wijziging wachtwoord bevestigen</h1>";
echo "<div style='font-size:12pt;color:black;'>"; 
echo "<br>De mail voor aanpassing van het wachtwooord is verstuurd naar <b>".$Email.".</b><br> In deze mail staat een link om de wijziging daadwerkelijk te activeren. Pas na de activatie is het nieuwe wachtwoord geldig !!!<br></div> ";
}
else { 
echo "<div style='font-size:12pt;color:black;'>"; 
echo "<br>De mail voor aanpassing van het wachtwooord kon niet verstuurd worden. Er is geen email adres bekend !!!<br></div> ";
}
	
 
?>
</body>
</html>