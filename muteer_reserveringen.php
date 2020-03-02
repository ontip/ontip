<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);
# muteer_reserveringen.php
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 18okt2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              Opgelost
# Feature:          None.
# Reference: 
#
# 5mei2019          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               PHP7.
# Feature:           None.
# Reference: 


ob_start();

ini_set('display_errors', 'OFF');
error_reporting(E_ALL);
setlocale(LC_ALL, 'nl_NL');

//// Database gegevens. 

include ('mysqli.php');
// 6 jul 2018 EHE  versleutel_string voor Email
include ('../ontip/versleutel_string.php'); // tbv telnr en email


// Controles
$challenge  =  $_POST['challenge'];
$respons    =  $_POST['respons'];
$toernooi   =  $_POST['toernooi'];

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

$Bevestigen  = $_POST['Bevestigen'];





//////// Activeren verzending

$toernooi = $_POST['toernooi'];

$variabele = 'uitgestelde_bevestiging_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select 1');  
 $result    = mysqli_fetch_array( $qry1);
 $uitgestelde_bevestiging_jn     = $result['Waarde'];

$variabele = 'sms_bevestigen_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select 2');  
 $result    = mysqli_fetch_array( $qry1);
 $sms_bevestigen_zichtbaar_jn     = $result['Waarde'];

$variabele = 'toernooi_voluit';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select 3');  
 $result    = mysqli_fetch_array( $qry1);
 $toernooi_voluit     = $result['Waarde'];


// Ophalen sms gegevens en mail tracer
$qry3             = mysqli_query($con,"SELECT *  From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS'];
$trace              = $row3['Mail_trace'];
   
   if ($trace =='J') {
       $email_tracer = $row3['Mail_trace_email'];
   }



foreach ($Bevestigen as $bevestigid)
{
	
$id            = substr($bevestigid,0,-3);      /// -JX  
$reply         = substr($bevestigid,-2); 
$bevestig_jn   = substr($reply,0,1);         // Eerste karakter : J = bevestigen  N = Annuleren
$bevestig_ms   = substr($reply,-1);          // Laatste karakter : M = mail  S = SMS A = Alles  X = geen functie

// 	echo "id". $id. "-". $bevestig_jn. " - ".$bevestig_ms .": ". $sms_bevestigen_zichtbaar_jn . "<br>";

	// ophalen gegevens uit inschrijf voor doorgeven waarden aan send_inschrijf 

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$id."' " )    or die('Fout in select');  
$row      = mysqli_fetch_array( $qry);

$Naam1        = $row['Naam1'];
$Email        = $row['Email'];
$Telefoon     = $row['Telefoon'];   


   // 6 jul 2018
   if ($Email =='[versleuteld]'){
   	$Email =  versleutel_string($row['Email_encrypt']);
   }

   // 6 jul 2018

   if ($Telefoon =='[versleuteld]'){
   	$Telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }
    
$Inschrijving = $row['Inschrijving'];
$Betaal_datum = $row['Betaal_datum'];
$status       = $row['Status'];
$date         = $row['Inschrijving'];
$datum        = $row['Datum'];

$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);     

/// versleutel kenmerk

include 'versleutel_kenmerk.php'; 

$dag    = substr ($date , 8,2);         
$maand  = substr ($date , 5,2);         
$jaar   = substr ($date , 0,4);     
$uur    = substr ($date , 11,2);     
$minuut = substr ($date , 14,2);     
$sec    = substr ($date , 17,2);     

$_kenmerk = $minuut.$sec.$dag.$uur;

/// roep versleutel routine aan
/// versleutel_licentie($waarde, $richting, $delta)
$encrypt = versleutel_kenmerk($_kenmerk,'encrypt', 20);
$kenmerk  = substr($encrypt,0,4).".".substr($encrypt,4,4);
//echo "Kenmerk : ". $kenmerk. "<br>";

// 0123456789012345678
// 2011-12-21 13:46:35

$dag1   = substr ($datum , 8,2);         
$maand1 = substr ($datum , 5,2);         
$jaar1  = substr ($datum , 0,4);     

$dag2   = substr ($Inschrijving , 8,2);         
$maand2 = substr ($Inschrijving , 5,2);         
$jaar2  = substr ($Inschrijving , 0,4);     
$uur2    = substr ($Inschrijving , 11,2);     
$minuut2 = substr ($Inschrijving , 14,2);     

$dag3    = substr ($Betaal_datum , 8,2);         
$maand3  = substr ($Betaal_datum , 5,2);         
$jaar3   = substr ($Betaal_datum , 0,4);     
$uur3    = substr ($Betaal_datum , 11,2);     
$minuut3 = substr ($Betaal_datum , 14,2);     

if (!empty ($Email)){

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);

if ($bevestig_jn == 'J'){
$subject = 'Definitieve inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $Naam1; 
echo "OK"; 
}

if ($bevestig_jn == 'N'){
$subject = 'Afzegging inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $Naam1; 
}

//// Indien Mail adres ingevuld ook naar inschrijver (met BCC)
	
$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand1 , $dag1, $jaar1) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

if ($bevestig_jn == 'J'){
$bericht .= "<br><br><h3><u>Definitieve inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Dit is een definitieve bevestiging van uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))."</td></tr>".  "\r\n";
}

if ($bevestig_jn == 'N'){
$bericht .= "<br><br><h3><u>Afzeggen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Helaas konden we uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))." niet definitief maken als gevolg van een overschrijding van het max aantal inschrijvingen </td></tr>".  "\r\n";
}
//
$bericht .= "<br><tr><td  width=200>Naam</td><td>"               .  $Naam1       ."</td></tr>".  "\r\n";
// $bericht .= "<tr><td  width=200>Adres </td><td>"             .  $Adres      ."</td></tr>".  "\r\n";
// $bericht .= "<tr><td  width=200>Postcode  Plaats</td><td>"   .  $Postcode  . " ". $Woonplaats      ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $kenmerk       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

if ($bevestig_jn == 'N'){
	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Naast de inschrijving via Internet zijn er ook inschrijvingen gedaan via schriftelijke aanmelding (lijst op prikbord) of telefonisch. 
	             Dergelijke inschrijvingen worden dan niet direct ingevoerd in het Online systeem. We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";
}	

if ($Email !=''  and ($bevestig_ms = 'M' or $bevestig_ms = 'A')){
	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
  mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
  
      $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');

//  echo $bericht;
}



}// endif Email gevuld

// Check waarde
/*
echo "SMS : ". $sms_bevestigen_zichtbaar_jn  . "<br>";
*/

/// SMS versturen

if ($sms_bevestigen_zichtbaar_jn  == 'J' and ($status == 'RE4') and ($bevestig_ms = 'S' or $bevestig_ms = 'A')) {

$to          = $Telefoon."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    
  
  
if ($bevestig_jn == 'J'){
$sms_bericht .= "Dit is een def. bevestiging van uw inschrijving voor het '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand1 , $dag1, $jaar1) ). ".  ". "\r\n";
}       
else {            
$sms_bericht .= "Helaas konden we uw inschrijving voor het '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand1 , $dag1, $jaar1) ). " niet definitief maken als gevolg van een overschrijding van het max aantal inschrijvingen.  ". "\r\n";
}       
$sms_bericht_lengte = strlen($sms_bericht);   
      
      
// Check sms_tegoed   
include('sms_tegoed.php');

       
///  alleen sms versturen als mail adres niet gelijk is aan organisatie om te sms verkeer te beperken
if ($Email != $email_organisatie and $sms_bevestigen_zichtbaar_jn == 'J' and ($bevestig_ms = 'S' or $bevestig_ms = 'A') and $sms_tegoed > 1){
//	ECHO "SEND SMS TO ". $to;
	
mail($to, $subject, $sms_bericht, $headers);

    $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');

if ($bevestig_jn  == 'J'){
 	$kenmerk  = "RESV:J:".$kenmerk;
 	}
 	else {
 	$kenmerk  = "RESV:N:".$kenmerk;
}
  
  // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'   ,'".$Telefoon."', '".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                        
  //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
  
}       
       
} // end sms



//// Update status in geval van Bevestigen reserving

//echo  "uitge ". $uitgestelde_bevestiging_jn. "<br>";

if ($bevestig_jn == 'J' and $Email != ''  ){
$query="UPDATE inschrijf       SET Status  = 'IN0',
                                   Bevestiging_verzonden = NOW()  
            WHERE  Id           = '".$id."'  ";
             mysqli_query($con,$query) or die ('Fout in update IN0'); 
}


//// Update status in geval van Annuleren
 
if ($bevestig_jn == 'N' and $Email != ''  ){
$query="UPDATE inschrijf       SET Status  = 'RE2',
                                   Bevestiging_verzonden = NOW()  
            WHERE  Id           = '".$id."'  ";
             mysqli_query($con,$query) or die ('Fout in update RE2'); 
} 

            
if ($bevestig_jn == 'N' and $Email == ''  ){
$query="UPDATE inschrijf       SET Status  = 'RE3'
            WHERE  Id           = '".$id."'  ";
 mysqli_query($con,$query) or die ('Fout in update RE3'); 
} 
   
   // sms bevestiging

if ($bevestig_jn == 'J' and $status == 'RE4'){                                    ///// bevestiging (betaling nvt)  (RE4 - IN4)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'IN4' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
  
  if ($bevestig_jn == 'N' and $status == 'RE4'){                                    ///// annulering (betaling nvt)  (RE4 - IN5)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'IN5' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }         
            
  
}/// end for each
$i--;
?>
<?php
$replace = "toernooi=".$toernooi;

?> 
<script language="javascript">
		window.location.replace('beheer_reserveringen.php?<?php echo $replace; ?>');
</script>
<?php
ob_end_flush();
?> 
