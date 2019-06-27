<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// send  notificaties


// send email
     
  if ($email_encrypt !=''){
     
     
   if ($email =='[versleuteld]'){ 
    $email    = versleutel_string($email_encrypt);    
   }
  
   
    // aanmaak email bericht
    $from = $subdomein."@ontip.nl";	
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
    $email_noreply = $email_organisatie;
    $email_return  = $email_organisatie;
    
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
           'Return-Path: '. $email_return  . "\r\n" . 
           'Reply-To: '. $email_organisatie . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
    $headers  .= "\r\n";
    
    $subject  = 'Email notificatie '.$toernooi_voluit;
    
    $bericht = "<table>"   . "\r\n";
    $bericht .= "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";
    $bericht .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
    $bericht .= "</table>"   . "\r\n";
    $bericht .= "<br><hr/>".   "\r\n";
    $bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Email notificatie</u></h3>".   "\r\n";
    
    $bericht .= "<br><span style='font-family:verdana;font-size:10pt;color:black;'>U ontvangt deze Email notificatie omdat er een plek is vrijgekomen voor onderstaand toernooi.  </span><br>".   "\r\n";
    
    $bericht .= "<br><table  Style='font-family:verdana;font-size:9pt;border-collapse: collapse;background-color:white;padding:5pt;border-color:darkgrey;'>"   . "\r\n";
    $bericht .= "<tr><td  width=200>Toernooi  </td><td colspan = 2>"          .  $toernooi_voluit       ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Max deelnemers </td><td colspan = 2>"     .  $max_splrs       ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Huidig aantal  </td><td colspan = 2>"     .  $aantal_deelnemers      ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Naam  </td><td colspan = 2>"              .  $naam                  ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Kenmerk notificatie   </td><td colspan = 2>"    .  $kenmerk        ."</td></tr>".  "\r\n";
    $bericht .= "</table>"   . "\r\n";
    $bericht .= "<br><br><span style='font-family:verdana;font-size:10pt;color:black;font-weight:bold;'>Klik op onderstaande link om u in te schrijven.</span>".   "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:10pt;color:red;'><a href='https://www.ontip.nl/".substr($prog_url,3)."Inschrijf_form.php?toernooi=".$toernooi."&email_notificatie=".$kenmerk."'>Klik op deze link</a></div>" . "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'https://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
    

  ///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
    if ($email != $email_organisatie){
      	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
        mail($email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
     }

 } // email notificatie


// send SMS
     
  if ($telefoon_encrypt !=''){
     
     
   if ($telefoon =='[versleuteld]'){ 
      $telefoon    = versleutel_string($telefoon_encrypt);    
   }

$to          = $telefoon."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject   = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    

$sms_bericht .="Er is nu een plek vrij voor toernooi ". $toernooi_voluit. " op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";
 mail($to, $subject, $sms_bericht, $headers);

}

?>