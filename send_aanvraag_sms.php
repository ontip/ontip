<? 
ob_start();
include 'mysqli.php'; 

// formulier POST variabelen ophalen en kontroleren

if (isset($_POST['zendform'])) 
{ 
    foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                echo $key2. "<br>";
                
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
        } 
    } 
} 
// Controles
$error   = 0;
$message = '';

if ($challenge != $respons){
	$message .= "* Anti spam is niet (juist) ingevuld<br>";
	$error = 1;
}

if ($Naam == ''){
	$message .= "* Naam  is niet ingevuld<br>";
	$error = 1;
}

if ($extra_kosten == '' and $introductie == ''){
	$message .= "* U dient een keuze te maken voor optie 1 of 2 onder aan het scherm.<br>";
	$error = 1;
}

$qry                    = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row                    = mysqli_fetch_array( $qry );
$verzendadres_sms       = $row['Verzendadres_SMS'];
$vereniging_id          = $row['Id'];

if ($introductie != ''   and $verzendadres_sms !=''){
	$message .= "* U hebt al eens gebruik gemaakt van de kennismakingsactie.<br>";
	$error = 1;
}

if ($introductie != '' and $extra_kosten  !=''){
	$message .= "* U dient een keuze te maken voor optie 1 of 2 onder aan het scherm.<br>";
	$error = 1;
}

if ($introductie == '' and $Aantal_sms < 100){
	$message .= "* Het minimum aantal SMS-jes in een bundel is 100.<br>";
	$error = 1;
}

if ($sms_bevestiging != '' and $Telefoon =='' ){
	$message .= "* Indien u een SMS bevestiging wenst dient het telefoonnummer ingevuld te zijn.<br>";
	$error = 1;
}

if ($sms_bevestiging != '' and $Telefoon !=''  and (!is_numeric($Telefoon)) ){
	$message .= "* Indien u een SMS bevestiging wenst dient het telefoonnummer alleen te bestaan uit cijfers.<br>";
	$error = 1;
}


if ($Opmerkingen =='Typ hier evt vraag of opmerkingen.'){
  	$Opmerkingen ='';
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
 /// alle controles goed 
if ($error == 0){

// Als mail versturen
$van           = 'sms.aanvraag@ontip.nl';

if ($introductie != ''){
$subject = 'Aanvraag SMS bundel (kennismaking) - '. $vereniging;
} else {
$subject = 'Aanvraag SMS bundel - '. $vereniging;
}

$email_bcc = 'erik.hendrikx@gmail.com';
$to        = $Email;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '. $van  . "\r\n" . 
       'Bcc: '. $email_bcc . "\r\n" .
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td rowspan =2><img src= 'http://www.ontip.nl/ontip/images/ontip_logo.png'' width=150>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:14pt;color:blue;'>Aanvraag SMS bundel </b></td></tr>" . "\r\n";
$bericht .= "<tr><td style= 'font-family:Arial;font-size:12pt;color:darkgreen;'><b>".  htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3><u>Faktuur</u></h3>".   "\r\n";

$totaal = ($Kosten * $Aantal_sms);   // kosten in eurocent
if ($verzendadres_sms ==''){
	$totaal = ($totaal );
}

if ($introductie != ''){
  $Aantal_sms = 5;
  $Kosten     = 0;
  $totaal     = 0;
}

$bericht .= "<table style= 'font-family:verdana;font-size:9pt;' >"   . "\r\n";
$bericht .= "<tr><td  width=200  >Vereniging</td><td style= 'text-align:left;color:blue;'>"               .  $vereniging     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Naam</td>      <td style= 'text-align:left;color:blue;'>"               .  $Naam     ."</td></tr>".  "\r\n";

if ($Telefoon !=''){
$bericht .= "<tr><td  width=200  >Telefoon</td>     <td style= 'text-align:left;color:blue;'>"           .  $Telefoon       ."</td></tr>".  "\r\n";
}
$bericht .= "<tr><td  width=200  >Email</td>     <td style= 'text-align:left;color:blue;'>"               .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Aantal SMS berichten</td><td style= 'text-align:right;color:blue;'>"    .  $Aantal_sms   ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Bedrag per SMS </td>     <td style= 'text-align:right;color:blue;'>€."  .  number_format( ($Kosten/ 100),2,',', ' ') ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Totaal bedrag </td>      <td style= 'text-align:right;color:blue;'>€. " .  number_format(($totaal/100),2,',', ' ') ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

if ($introductie != ''){
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><b>Dit is uw aanvraag voor de kennismakingsactie. Er worden geen kosten in rekening gebracht.</b></div>".  "\r\n";
}


if ($verzendadres_sms == '' and $introductie == ''){
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><b>Dit is de eerste aanvraag. Hiervoor worden € 5,00 aan administratie kosten in rekening gebracht.</b></div>".  "\r\n";
}

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $Opmerkingen . "</div>".  "\r\n";
$bericht .= "<br><div style= 'font-family:verdana;font-size:9pt;color:darkgreen;'><br>Verwerkingstijd van de aanvraag is 1 dag na betaling. Pas <u>na betaling</u> wordt de bundel geactiveerd.U ontvangt hiervan een bevestiging.</div>".  "\r\n";

if ($sms_bevestiging != '' and $Telefoon !='' ){
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br>U ontvangt een bevestiging via SMS op ".$Telefoon." zodra de bundel geactiveerd is.</div>".  "\r\n";
}

$bericht .= "<hr/>".   "\r\n";

if ($totaal > 0 ){
   $bericht .= "<div style= 'font-family:verdana;font-size:9pt;color:blue;'>** € ". number_format(($totaal/100),2,',', ' ') . " overmaken op NL34INGB0005627348 t.a.v E. Hendrikx onder vermelding van Aanvraag SMS bundel ". $vereniging.".</div>".  "\r\n";
}
//echo $bericht;

mail($to, $subject, $bericht, $headers);


/// email naar sms_aanvraag

if ($introductie != ''){
$subject = 'Aanvraag activering SMS bundel (kennismaking) - '. $vereniging;
} else {
$subject = 'Aanvraag activering  SMS bundel - '. $vereniging;
}

$email_bcc = 'erik.hendrikx@gmail.com';
$to        = 'sms.aanvraag@ontip.nl';
$from       = 'sms.aanvraag@ontip.nl';

// tijdelijk tot mail forwarder is aangemaakt
$to   = 'erik.hendrikx@gmail.com';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
         'Return-Path: '. $from  . "\r\n" . 
         'Reply-To: '. $from  . "\r\n" . 
         'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td rowspan =2><img src= 'http://www.ontip.nl/ontip/images/ontip_logo.png'' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:14pt;color:blue;'>Aanvraag SMS bundel </b></td></tr>" . "\r\n";
$bericht .= "<tr><td style= 'font-family:Arial;font-size:12pt;color:darkgreen;'><b>".  htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3><u>Aanvraag tot activering</u></h3>".   "\r\n";

$bericht .= "<table style= 'font-family:verdana;font-size:9pt;' >"   . "\r\n";
$bericht .= "<tr><td  width=200  >Vereniging</td><td style= 'text-align:left;color:blue;'>"               .  $vereniging     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Vereniging id</td><td style= 'text-align:left;color:blue;'>"               .  $vereniging_id     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Naam</td>      <td style= 'text-align:left;color:blue;'>"               .  $Naam     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Email</td>     <td style= 'text-align:left;color:blue;'>"               .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Aantal SMS berichten</td><td style= 'text-align:right;color:blue;'>"    .  $Aantal_sms   ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Bedrag per SMS </td>     <td style= 'text-align:right;color:blue;'>€."  .  number_format( ($Kosten/ 100),2,',', ' ') ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Totaal bedrag </td>      <td style= 'text-align:right;color:blue;'>€. " .  number_format(($totaal/100),2,',', ' ') ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

if ($introductie != ''){
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><b>Dit is uw aanvraag voor de kennismakingsactie. Er worden geen kosten in rekening gebracht.</b></div>".  "\r\n";
}

if ($verzendadres_sms == '' and $introductie == ''){
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><b>Dit is de eerste aanvraag. Hiervoor worden € 5,00 aan administratie kosten in rekening gebracht.</b></div>".  "\r\n";
}

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $Opmerkingen . "</div>".  "\r\n";

// wordt als key gebruikt voor activering via email link
$timestamp   = date ('Y-m-d+H:i:s');
$_timestamp = str_replace(' ','+', $timestamp);

$parameters  = $Email;
if ($sms_bevestiging != '' and $Telefoon !='' ){
    $parameters  = $Email.";".$Telefoon;
}

$query = "INSERT INTO `config` (`Id`, `Regel`, `Vereniging`,`Vereniging_id`, `Toernooi`,  `Variabele`, `Waarde`,`Parameters`,`Laatst` ) 
        VALUES (0, 9997, '".$vereniging."',".$vereniging_id.",'".$Naam."' , 'sms_activation_key', '".$Aantal_sms."', '".$parameters."', '".$timestamp."') ";

mysqli_query($con,$query) or die (mysql_error()); 

$prog_url = 'Http://www.ontip.nl/ontip/';

$bericht   .= "<div style= 'font-family:verdana;font-size:9pt;color:red;'>SMS aanvraag activeren : <a href = 'Http://www.ontip.nl/".substr($prog_url,3,)."update_vereniging_sms.php?param_value=".$_timestamp. "' target = '_blank'>Klik hier voor activering</a></div>".  "\r\n";

$bericht .= "<hr/>".   "\r\n";

mail($to, $subject, $bericht, $headers);


header ("location: aanvraag_sms.php?verzonden"); 

}
ob_end_flush();
?> 