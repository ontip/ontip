<?php
ob_start();
/// Programma wordt aangeroepen vanuit link in email naar erik.hendrikx@gmail.com


//// Database gegevens. 

include ('mysqli.php');
$error =  0;
$count = 0;

$timestamp = $_GET['param_value'];
$_timestamp = str_replace('+',' ', $timestamp);

// 012345678901234567890
// yyyy-mm-dd hh:mm:ss
//echo "SELECT * From config where Regel = 9997 and Variabele ='sms_activation_key' and Laatst = '".$_timestamp ."'   <br>";
$qry                    = mysqli_query($con,"SELECT * From config where Regel = 9997 and Variabele ='sms_activation_key' and Laatst = '".$_timestamp ."'   ")     or die('SMS activation key niet gevonden.');  
$count                  = mysqli_num_rows($qry);

if($count == 0){
		$error =  1;
	echo "Fout gevonden in select aanvraag.<br>"; 
	echo "Timestamp :". $_timestamp. "<br>";
}
else { 
$row                    = mysqli_fetch_array( $qry );
$aantal_sms             = $row['Waarde'];
$Naam                   = $row['Toernooi'];
$_Parameters            = $row['Parameters'];

$Parameters             = explode(";", $_Parameters);
$Email                  = $Parameters[0];
$Telefoon               = $Parameters[1];
$vereniging_id          = $row['Vereniging_id'];
}

/*
echo "SMS:". $aantal_sms. "<br>";
echo "Telefoon:". $Telefoon. "<br>";
echo "Id:". $vereniging_id. "<br>";
*/


if ($error == 0){ 
$qry2                   = mysqli_query($con,"SELECT * from vereniging where Id =".$vereniging_id." " )    or die('SMS aanvraag is al geactiveerd.');  
$row2                   = mysqli_fetch_array( $qry2 );
$to                     = $row2['Email'];
$verzendadres_sms       = "OnTipSMS_".$vereniging_id."@ontip.nl";
$_vereniging            = $row2['Vereniging_output_naam'];
$curr_aantal_sms        = $row2['Max_aantal_sms'];
$_aantal_sms            = $aantal_sms + $curr_aantal_sms ;
$sms_bedrag_totaal      = ($aantal_sms * 16)/100;
$iban                   = $row2['Vereniging_IBAN'];
}
else {
	$error =  1;
	echo "Fout gevonden in select aanvraag.<br>"; 
	echo "Timestamp :". $_timestamp. "<br>";
	echo "SMS       :". $_aantal_sms. "<br>";
  echo "Telefoon  :". $Telefoon. "<br>";
  echo "Id        :". $vereniging_id. "<br>";
}


//echo $verzendadres_sms    ;

/// verwijder config record
//$qry                    = mysqli_query($con,"DELETE  From config where Regel = 9997 and Variabele = 'sms_activation_key' and Laatst = '".$timestamp ."'   ")     or die(' Fout in DELETE sms_activation_key');  

if ($error ==0 ){

$query="UPDATE vereniging  SET Verzendadres_SMS = '".$verzendadres_sms. "' , 
                                      Max_aantal_sms  = ".$_aantal_sms.",
                                      Datumtijd_sms_saldo_update = now()
               where Id   = ".$vereniging_id."" ; 
                    
//echo $query."<br>";                 
 mysqli_query($con,$query) or die ('Fout in update vereniging'); 
}// end errr


/// tbv boekhouding
if ($error ==0 ){
$date = date('Y-m-d');
$query="INSERT INTO ontip_financieel   ( Vereniging, Vereniging_id, Vereniging_IBAN, Bedrag_betaald_sms_saldo_update   , Datum_betaling_sms_saldo_update  , SMS_bundel_grootte , Laatst )
                                values ( '".$vereniging."',".$vereniging_id.",'".$iban. "','".$sms_bedrag_totaal   . "','".$date   . "',".$aantal_sms.",now()  ) ";
                              
                    
//echo $query."<br>";                 
 mysqli_query($con,$query) or die ('Fout in insert OnTip financieel'); 
}// end errr

if ($error ==0 ){

// mail ter bevestiging

$email_bcc     = 'erik.hendrikx@gmail.com';
$van           = 'sms.aanvraag@ontip.nl';
$email_noreply = 'noreply@ontip.nl';

// tijdelijk tot mail forwarder is aangemaakt
$subject = 'Activering SMS bundel - '. $vereniging;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '. $van  . "\r\n" . 
       'Bcc: '. $email_bcc . "\r\n" .
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td rowspan =2><img src= 'http://www.ontip.nl/ontip/images/ontip_logo.png'' width=150>"   . "\r\n";
$bericht .= "<td style= 'font-family:cursive;font-size:14pt;color:blue;'>Activering SMS bundel </b></td></tr>" . "\r\n";
$bericht .= "<tr><td style= 'font-family:Arial;font-size:12pt;color:darkgreen;'><b>".  $_vereniging."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3><u>Activering SMS bundel</u></h3>".   "\r\n";

$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br>Betreft de aanvraag voor een SMS bundel ".$timestamp.".</div>".  "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br>Beste ". $Naam   . "</div>"."\r\n";    
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Uw aangevraagde SMS bundel van <b>".$aantal_sms." </b>berichten is geactiveerd en vanaf nu beschikbaar binnen OnTip.</div>".  "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Uw SMS bundel bevat nu  <b>".$_aantal_sms." </b>berichten.</div>".  "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><br><br>Met vriendelijke groet,</div>".  "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>OnTip beheer</div>".  "\r\n";

$bericht .= "<hr/>".   "\r\n";

mail($to, $subject, $bericht, $headers);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// sms bevestiging

if ($Telefoon !=''){
	$to            = $Telefoon."@sms.messagebird.com";
  $email_noreply = 'sms_aanvraag@ontip.nl';
 
  
$headers      = 'MIME-Version: 1.0' . "\r\n";
$headers     .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
            'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject   = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "<div style= 'font-family:verdana;font-size:9pt;'>Beste ". $Naam   . "</div>"."\r\n";    
$sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br>Uw aangevraagde SMS bundel van <b>".$aantal_sms." </b>berichten is geactiveerd en vanaf nu beschikbaar binnen OnTip.</div>".  "\r\n";
$sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Uw SMS bundel bevat nu  <b>".$_aantal_sms." </b>berichten.</div>".  "\r\n";
$sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'><br><br><br>Met vriendelijke groet,</div>".  "\r\n";
$sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>OnTip beheer</div>".  "\r\n";
$sms_bericht_lengte = strlen($sms_bericht);   
 
//echo $sms_bericht;     
mail($to, $subject, $sms_bericht, $headers);

// Bij kennismakingactie gaat de 1e sms van het Boulamis tegoed af. Max 10 berichten

if ($aantal_sms < 11)  {
	  $vereniging1 = "Intro Bundel :".$aantal_sms;
	//$vereniging = 'Boulamis';
}
else { 
	$vereniging1 = "Bundel:".$aantal_sms;
}

$toernooi = '';
$kenmerk  = "ACTIVERING";
$datum    = date('Y-m-d');
 
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Vereniging,Vereniging_id, Datum, Verzender, Vereniging_speler,
                                Naam,  Kenmerk, Laatst)
               VALUES (0, '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,'".$vereniging1 ."'
                         '".$Naam."'    , '".$kenmerk."', NOW()   )";     

 //echo $query;
 mysqli_query($con,$query) or die ('Fout in insert sms_confirmations'); 
      
} // end telefoon ==''

}// error

if ($error ==0 ){
?>
   <script language="javascript">
        alert("Activeren SMS bundel voor <?php echo $vereniging ?> is uitgevoerd. ")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
}// error
