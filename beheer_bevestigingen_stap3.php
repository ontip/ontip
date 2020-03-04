<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);
# beheer_bevestigingen_stap3.php
# verwerken van bevestigingen in tabel inschrijf
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 18okt2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Ontbrekende vars
# Fix:              Opgelost
# Feature:          None.
# Reference: 
#
# 5apr2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          PHP7
# Reference: 

# 31oct2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              Include versleutelstring in dt programma opgenomen omdat dit problemen gaf
# Feature:          PHP7
# Reference: 

# 14jan2020           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              Include versleutelstring vanaf boulamis folder
# Feature:          PHP7
# Reference: 

# 4mar2020           -            E. Hendrikx 
# Symptom:   		None.
# Problem:     	    None
# Fix:              
# Feature:          mail_stats en test op geldig email adres
# Reference: 

ob_start();
ini_set('display_errors', 'OFF');
error_reporting(E_ALL);
setlocale(LC_ALL, 'nl_NL');

//// Database gegevens. 

include ('mysqli.php');
include ('versleutel_kenmerk.php'); 
include ('../boulamis/versleutel_string.php'); // tbv telnr en email

// Controles
$challenge     =  $_POST['challenge'];
$respons       =  $_POST['respons'];
$toernooi      =  $_POST['toernooi'];
$id            =  $_POST['id'];
$input_status  =  $_POST['status'];

$replace = "toernooi=".$toernooi."";

$error   = 0;
$message = '';

if ($respons == '') {
	$message = "* Antispam code is niet ingevuld.<br>";
	$error = 1;
}
else {

if ($challenge != $respons){
	$message = "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}


if ($input_status == '') {
	$message = "* Er is geen selectie gemaakt.<br>";
	$error = 1;
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);     

// Ophalen sms gegevens en mail tracer
$qry3             = mysqli_query($con,"SELECT *  From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS'];
$trace              = $row3['Mail_trace'];
$url_logo           = $row3['Url_logo']; 
$vereniging_id      = $row3['Id'];

   
 if ($trace =='J') {
     $email_tracer = $row3['Mail_trace_email'];
 }
$qry                = mysqli_query($con,"SELECT * from inschrijf where Id= ".$id." " )    or die('Fout in select id');  
$row                = mysqli_fetch_array( $qry);
$Naam1              = $row['Naam1'];
$current_status     = $row['Status'];

$Email            = $row['Email'];
$Email_encrypt    = $row['Email_encrypt'];

if ($Email =='[versleuteld]'){ 
$Email            = versleutel_string($Email_encrypt);    
}

$Telefoon         = $row['Telefoon'];
$Telefoon_encrypt         = $row['Telefoon_encrypt'];

if ($Telefoon =='[versleuteld]'){ 
$Telefoon            = versleutel_string($Telefoon_encrypt);    
}



$Kenmerk            = $row['Kenmerk'];
$Inschrijving       = $row['Inschrijving'];


$dag2   = substr ($Inschrijving , 8,2);         
$maand2 = substr ($Inschrijving , 5,2);         
$jaar2  = substr ($Inschrijving , 0,4);     
$uur2    = substr ($Inschrijving , 11,2);     
$minuut2 = substr ($Inschrijving , 14,2);     


/*   nogelijk waarden voor input_status

   'BEA'> Bevestigen via Email.<br>
   'BEB'> Bevestigen. Geen Email bekend.<br>
   'BE3'> Bevestigen. Geen Email bekend. Inschrijving is betaald (indien IDEAL NIET geactiveerd).<br>
   'BE4'> Bevestigen via Email.Inschrijving is betaald (indien IDEAL NIET geactiveerd).<br>
   'IN2'> Bevestigen melden via SMS (indien SMS dienst geactiveerd).<br>
   'RE0'> Omgezet naar reservering en melden via Email.<br>
   'RE0'> Omgezet naar reservering. Geen Email bekend.<br>
   'ID2'> Bevestigen via Email. Inschrijving is betaald via IDEAL (indien IDEAL geactiveerd).<br>
               
   'BE7'> Annuleren.  Geen email bekend.<br>
   'BE6'> Annuleren via Email melden.<br>
   'IN3'> Annulering melden via SMS (indien SMS dienst geactiveerd).<br>
   'RE0'> Omgezet naar reservering en melden via Email.<br>
   'RE1'> Omgezet naar reservering. Geen Email bekend.<br>
  
    DEL   =  Door deelnemer ingetrokken inschrijving (via mail).          	
 */
 
   $query="UPDATE inschrijf 
               SET Status = '".$input_status."'
            WHERE  Id           = '".$id."'  ";
    mysqli_query($con,$query) or die ('error in update generic : '. $input_status); 
    
    
 // voor betaalde trx betaal datum aanpassen muv Ideal   
    
 if ($input_status == 'BE3' or $input_status == 'BE4' ){
     $query="UPDATE inschrijf 
               SET Betaal_datum = NOW() ,
                   Status = '".$input_status."'
            WHERE  Id           = '".$id."'  ";
    mysqli_query($con,$query) or die ('error in update BE3 or 4'); 
}
  //echo $query;
  
//  $input_status = 'BEB';
//  $current_status ='DEL' ;

/// ================================================================   RESERVEREN  ================================================================

if ($input_status == 'RE0'  ){


$subject = 'Reserveren inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 

$subject .= $Naam1; 

/// Alleen tbv Email in  inschrijving
$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'Bcc: '.$email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Reserveren inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>In verband met het overschrijden van het aantal inschrijvingen is uw voorlopige inschrijving omgezet naar een reservering.</td></tr>".  "\r\n";

$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $Kenmerk       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Naast de inschrijving via Internet zijn er ook inschrijvingen gedaan via schriftelijke aanmelding (lijst op prikbord) of telefonisch. 
	             Dergelijke inschrijvingen worden dan niet direct ingevoerd in het Online systeem. We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

if (!empty ($Email)){
       mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
	   $function = basename($_SERVER['SCRIPT_NAME']);
       include('../ontip/mail_stats.php');
} // end if Email gevuld

// echo $bericht; 
  
}// end  for  reserve

/// ================================================================   ANNULEREN  ================================================================

if ($input_status == 'BE6'  ){

$subject = 'Annuleren inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 

$subject .= $Naam1; 

/// Alleen tbv Email in  inschrijving
$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'Bcc: '.$email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Annuleren inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>In verband met het overschrijden van het aantal inschrijvingen is uw voorlopige inschrijving geannuleerd.</td></tr>".  "\r\n";

$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $Kenmerk       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Naast de inschrijving via Internet zijn er ook inschrijvingen gedaan via schriftelijke aanmelding (lijst op prikbord) of telefonisch. 
	             Dergelijke inschrijvingen worden dan niet direct ingevoerd in het Online systeem. We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

if (!empty ($Email)){
       mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
	   $function = basename($_SERVER['SCRIPT_NAME']);
       include('../ontip/mail_stats.php');
} // end if Email gevuld
  
}// end  for  annuleren

/// ================================================================   ALSNOG BEVESTIGEN  ================================================================

if ($input_status == 'BEA' and $current_status =='DEL' ){

$subject = 'Ongedaan maken annulering ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $Naam1; 

/// Alleen tbv Email in  inschrijving

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'Bcc: '.$email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Ongedaan maken afzeggen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Het intrekken van uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))." is hierbij ongedaan gemaakt. U staat dus nog ingeschreven.</td></tr>".  "\r\n";


$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $Kenmerk       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<br><br><div style= 'font-family:Arial;font-size:10pt;color:black;'>De wedstrijdcommissie van ".$vereniging."</div>";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

if (!empty ($Email) and strpos($Email,'@') > 0){
       mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
       $function = basename($_SERVER['SCRIPT_NAME']);
       include('../ontip/mail_stats.php');
} // end if Email gevuld
 
  if (empty ($Email) or strpos($Email,'@') == 0){
  ?>
  <script language="javascript">
        alert("Bevestiging is niet verzonden ivm ongeldig email adres voor  <?php echo $Naam1; ?> zijnde '<?php echo $Email; ?>' en " + '\r\n' + 
              "Email is dus NIET verzonden. Dit window kan veilig afgesloten worden.")
    </script>
 <?php
  }
  
}// end  for alnsog bevestigen


/// ================================================================    BEVESTIGEN  ================================================================

if (($input_status == 'BEA' or $input_status == 'BE4' or $input_status == 'ID2' or $input_status == 'BE4' or $input_status == 'BEG' ) and $current_status !='DEL' ){

$subject = 'Bevestigen inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $Naam1; 

/// Alleen tbv Email in  inschrijving

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'Bcc: '.$email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Bevestigen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Dit is de definitieve bevestiging van uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))." .</td></tr>".  "\r\n";


$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $Kenmerk       ."</td></tr>".  "\r\n";

if ($input_status  == 'BE4') {
$bericht .= "<tr><td  width=200>Betaald op   </td><td>"         .  $Betaal_datum       ."</td></tr>".  "\r\n";
}
if ($input_status  == 'ID2'  and $ideal_betaling_jn == 'J') {
$bericht .= "<tr><td  width=200>Betaald via IDEAL op   </td><td>"         .  $Betaal_datum       ."</td></tr>".  "\r\n";
}
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><div style= 'font-family:Arial;font-size:10pt;color:black;'>De wedstrijdcommissie van ".$vereniging."</div>";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";


$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

if (!empty ($Email) and strpos($Email,'@') > 0){
       mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
       $function = basename($_SERVER['SCRIPT_NAME']);
       include('../ontip/mail_stats.php');
} // end if Email gevuld
  
  
  if (empty ($Email) or strpos($Email,'@') == 0){
  ?>
  <script language="javascript">
        alert("Bevestiging is niet verzonden ivm ongeldig email adres voor  <?php echo $Naam1; ?> zijnde '<?php echo $Email; ?>'. " + '\r\n' + 
              "Dit window kan veilig afgesloten worden.")
    </script>
 <?php
  }
  
}// end  for  bevestigen


/// ================================================================    BEVESTIGEN via sms ================================================================


if ($input_status == 'IN2'  and  $sms_bevestigen_zichtbaar_jn  == 'J'){


$to          = $Telefoon."@sms.messagebird.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    
  

$sms_bericht .= "Dit is een def. bevest.van uw inschrijving voor  '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";       
    

// Check sms_tegoed   
include('sms_tegoed.php');
       
     
       
if ($sms_bevestigen_zichtbaar_jn == 'J' and $sms_tegoed > 1){
 mail($to, $subject, $sms_bericht, $headers);
 
$Kenmerk  = "BVST:J:".$Kenmerk;

 
 $sms_bericht_lengte = strlen($sms_bericht);   
  
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'   ,'".$Telefoon."', '".$Kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                        
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
 
 //echo $sms_bericht;
 
}       
 
       
} // end sms

/// ================================================================   ANNULEREN  ================================================================

if ($input_status == 'BEG'  ){

$subject = 'Vervallen inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 

$subject .= $Naam1; 

/// Alleen tbv Email in  inschrijving
$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'Bcc: '.$email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Vervallen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>In verband met het overschrijden van de vervaldatum is uw voorlopige inschrijving vervallen.</td></tr>".  "\r\n";

$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $Kenmerk     ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Dit betekent dat u niet langer aanspraak kan maken op de inschrijving. U zult u opnieuw moeten inschrijven. 
	            We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

if (!empty ($Email) and strpos($Email,'@') > 0){
       mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
       $function = basename($_SERVER['SCRIPT_NAME']);
       include('../ontip/mail_stats.php');
} // end if Email gevuld
 
  if (empty ($Email) or strpos($Email,'@') == 0){
  ?>
  <script language="javascript">
        alert("Annulering is niet verzonden ivm ongeldig email adres voor  <?php echo $Naam1; ?> zijnde '<?php echo $Email; ?>' . " + '\r\n' + 
              "Dit window kan veilig afgesloten worden.")
    </script>
 <?php
  } 

  
}// end  for  annuleren

/// ================================================================    ANNULEREN via sms ================================================================

if ($input_status == 'IN3'  and  $sms_bevestigen_zichtbaar_jn  == 'J'){

$to          = $Telefoon."@sms.messagebird.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    

$sms_bericht .= "Helaas konden we uw inschrijving voor het '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). " niet definitief maken als gevolg van een overschrijding van het max aantal inschrijvingen.  ". "\r\n";
      

// Check sms_tegoed   
include('sms_tegoed.php');
     
      
       
if ($sms_bevestigen_zichtbaar_jn == 'J' and $sms_tegoed > 1){
 mail($to, $subject, $sms_bericht, $headers);
 $function = basename($_SERVER['SCRIPT_NAME']);
 include('../ontip/mail_stats.php');

 	$Kenmerk  = "BVST:N:".$Kenmerk;

 
 $sms_bericht_lengte = strlen($sms_bericht);   
  
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'   ,'".$Telefoon."', '".$Kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                        
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
}      // sms zichtbaar 
 //echo $sms_bericht;
       
} // end sms


ob_end_flush();
?> 
<script language="javascript">
        alert("Status van inschrijving voor <?php echo $Naam1; ?> is veranderd in <?php echo $input_status; ?>." + '\r\n' + 
              "Dit window kan veilig afgesloten worden.")
    </script>

		
		
<script language="javascript">
		window.location.replace('beheer_bevestigingen_stap1.php?<?php echo $replace; ?>');
</script>
