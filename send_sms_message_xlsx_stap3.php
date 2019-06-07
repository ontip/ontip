<?php 
# send_sms_message_xlsx_stap3.php
# Stuur SMS bericht 
# aangeroepen vanuit send_sms_message_xlsx_stap2.php
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 24mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Verkleinen input veld voor bestandsnaam
# Reference: 

//// Database gegevens. 
include ('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email

//include('action.php');


$toernooi      = $_POST['toernooi'];
$sms_tekst     = $_POST['smstekst'];
$challenge     = $_POST['challenge'];
$respons       = $_POST['respons'];
$toernooi      = $_POST['toernooi'];
$check         = $_POST['Check'];
$tel_nummer    = $_POST['tel_nummer'];
$sms_count     = count ($check);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Controles
$error   = 0;
$message = '';

if ($respons == '') {
	$message .= "* Antispam code is niet ingevuld.<br>";
	$error = 1;
}
else {

if ($challenge != $respons){
	$message .= "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	 
}
else {
		echo " Geen toernooi bekend :";
	 exit;
};
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon foutmeldingen

if ($error == 1){
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
		history.back()
	</script>
<?php
 } // error = 1

$replace       = "toernooi=".$toernooi."";
//echo $toernooi;


setlocale(LC_ALL, 'nl_NL');
$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

// Check op max aantal sms berichten
include ('sms_tegoed.php');

// Ophalen sms gegevens
$qry3             = mysqli_query($con,"SELECT Verzendadres_SMS From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS']; 
echo $verzendadres_sms;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in bevestigen  dan zenden sms


foreach ($check as $checkid)
{
//	echo "<br>zend naar :".$checkid." -  ".$tel_nummer[$checkid];
	

  $telnummer      = $tel_nummer[$checkid];
  $Naam1           = $row['Naam1'];
  $Email            = $row['Email'];
  $Vereniging1     = $row['Vereniging1'];
  $reden           = 'SEND.SMS';
   
// check op al verstuurde sms berichten
include("sms_tegoed.php");

  
// Voorkom dat er meer dan max aantal  sms berichten verstuurd kunnen worden
    
 if ($sms_tegoed < 1){
     $sms_bevestigen_zichtbaar_jn = 'N';
  }	

$to          = $telnummer."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";
  
// Maximaal 160 karakters versturen. Anders worden 2 berichten afgerekend.

 if ($sms_bevestigen_zichtbaar_jn  == 'J'){    
 $sms_bericht = substr($sms_tekst,0,159)  . "\r\n";    
$sms_bericht_lengte = strlen($sms_bericht); 
 //  echo "<br> to : <br>".$to;
  //  echo "<br> bericht : <br>".$sms_bericht; 
	
$subject     = $sms_bericht;
mail($to, $subject, $sms_bericht, $headers);

 } // endif 



}// end for
//exit;


if ($check !=''){

// check op al verstuurde sms berichten
include("sms_tegoed.php");
  	
$to          = $email_organisatie;
$subject     = 'OnTip SMS bericht verzonden - '. $toernooi;

$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<h3><u>Melding OnTip</u></h3>".   "\r\n";

$bericht .= "<table style= 'font-family:verdana;font-size:9pt;' >"   . "\r\n";
$bericht .= "<tr><td  width=400  >U heeft een SMS bericht verzonden t.b.v toernooi</td><td style= 'text-align:left;'>". $toernooi_voluit."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=400  >Aantal berichten verzonden                : </td><td style= 'text-align:right;'>". $sms_count."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=400  >Aantal berichten over in OnTip SMS bundel :  </td><td style= 'text-align:right;'>". $sms_tegoed."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>SMS bericht</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $sms_bericht . "</div>".  "\r\n";
$bericht .= "<br><br>".   "\r\n";

$bericht .= "<div style= 'font-family:verdana;font-size:8.5pt;color:brown;padding-top:20pt;'><hr/>(Deze automatische mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx 2011 - ".date('Y').")</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
mail($to, $_subject, $bericht, $headers, "-finfo@ontip.nl"); 



};              /// indien kopie email ingevuld


?>
<script language="javascript">
        alert("Er zijn <?php echo $sms_count;?> SMS berichten verzonden ")
    </script>
  <script type="text/javascript">
		window.location.replace('send_sms_message_xlsx_stap1.php?<?php echo $replace; ?>');
	</script>
<?php
ob_end_flush();
?>
</html>
