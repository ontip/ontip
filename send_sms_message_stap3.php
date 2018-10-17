<?php 

//// Database gegevens. 
include ('mysql.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email


$toernooi      = $_POST['toernooi'];
$sms_all       = $_POST['Bevestigen'];
$aantal_sms    = $_POST['aantal'];
$sms_tekst     = $_POST['smstekst'];
$challenge     = $_POST['challenge'];
$respons       = $_POST['respons'];
$check         = $_POST['Check'];

//// Alle id's zijn in 1 keer doorgegeven
$sms_id        = explode(";", $sms_all);

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


if (isset($toernooi)) {
	

	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	 
};
setlocale(LC_ALL, 'nl_NL');
$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

// Check op max aantal sms berichten
include ('sms_tegoed.php');

// Ophalen sms gegevens
$qry3             = mysql_query("SELECT Verzendadres_SMS From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysql_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS']; 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in bevestigen  dan zenden sms

if (count($sms_id) > 0 ){


for ($k=0;(!empty($sms_id[$k]));$k++){

	
	$bevestig_id =  $sms_id[$k];
	
	$qry             = mysql_query("SELECT * from inschrijf where Id= '".$bevestig_id."' " )    or die('Fout in select inschrijf');  
  $row             = mysql_fetch_array( $qry);
  
  $tel_nummer      = $row['Telefoon'];
  $telnr_encrypt   = $row['Telefoon_encrypt'];


//  9 aug aanpassing encrypt telnummer+  email in database

if ($tel_nummer    =='[versleuteld]'){ 
    $tel_nummer    = versleutel_string($telnr_encrypt);    
}

 
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

$to          = $tel_nummer."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";


$headers .= 'From: '. $verzendadres_sms   . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject = "OnTipSMS";     /// Verzender SMS
    
   
// Maximaal 160 karakters versturen. Anders worden 2 berichten afgerekend.

$sms_bericht = substr($sms_tekst,0,159)  . "\r\n";    
$sms_bericht_lengte = strlen($sms_bericht); 
 
 // send SMS message naar  (telefoon)@sms.messagebird.com
  
 if ($Email != $email_organisatie and $sms_bevestigen_zichtbaar_jn  == 'J'){     
 mail($to, $subject, $sms_bericht, $headers);
 
     
// leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms ."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'  , '".$tel_nummer."', '".$reden."'  ,".$sms_bericht_lengte."  , NOW()   )";       
 //echo $query;
 mysql_query($query) or die (mysql_error()); 
} // endif email_orgaNISATIE



}// end for k

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
$bericht .= "<tr><td  width=400  >Aantal berichten verzonden                : </td><td style= 'text-align:right;'>". $k."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=400  >Aantal berichten over in OnTip SMS bundel :  </td><td style= 'text-align:right;'>". $sms_tegoed."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>SMS bericht</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $sms_bericht . "</div>".  "\r\n";
$bericht .= "<br><br>".   "\r\n";

$bericht .= "<div style= 'font-family:verdana;font-size:8.5pt;color:brown;padding-top:20pt;'><hr/>(Deze automatische mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx 2011 - ".date('Y').")</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
mail($to, $_subject, $bericht, $headers, "-finfo@ontip.nl"); 



};              /// indien kopie email ingevuld







}
else {
	echo "Geen inschrijvingen geselecteerd. "; 
}// end if bevestigen
?>
<script language="javascript">
        alert("Er zijn <?php echo $k;?> SMS berichten verzonden ")
    </script>
  <script type="text/javascript">
		window.location.replace('send_sms_message_stap1.php?<?php echo $replace; ?>');
	</script>
<?php
ob_end_flush();
?>
</html>
