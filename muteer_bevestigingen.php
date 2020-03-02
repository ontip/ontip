<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);

ob_start();
ini_set('display_errors', 'OFF');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');
include ('versleutel_kenmerk.php'); 

// Controles
$challenge  =  $_POST['challenge'];
$respons    =  $_POST['respons'];
$toernooi   =  $_POST['toernooi'];

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

setlocale(LC_ALL, 'nl_NL');

$Betaald     = $_POST['Betaald'];
$Bevestigen  = $_POST['Bevestigen'];
$Resetten    = $_POST['Reset'];
$Reserveren  = $_POST['Reserveren'];


$toernooi    = $_POST['toernooi'];

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

//echo "Verzender :  ".$verzendadres_sms."<br>";

//////// Verwerken van reset id

// Indien reset, dan verder geen verwerkingen van  betaling of bevestiging

if ($Resetten !=''){
	 $Betaald    = '';
	 $Bevestigen = '';
	 $Reserveren = '';
	 
}	 

foreach ($Resetten as $resetid)
{

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$resetid."' " )    or die('Fout in select resetid');  
$row      = mysqli_fetch_array( $qry);

$query="UPDATE inschrijf 
               SET Betaal_datum = '0000-00-00 00:00:00',
                   Bevestiging_verzonden = '0000-00-00 00:00:00',
                   Status = 'BE0'
            WHERE  Id           = '".$resetid."' and Email <> ''  ";
  mysqli_query($con,$query) or die ('error in update BE0 (reset) '); 
  
$query="UPDATE inschrijf 
               SET Betaal_datum = '0000-00-00 00:00:00',
                   Bevestiging_verzonden = '0000-00-00 00:00:00',
                   Status = 'BE1'
            WHERE  Id           = '".$resetid."' and Email = ''  ";
  mysqli_query($con,$query) or die ('error in update BE1 (reset) '); 
}

foreach ($Reserveren as $reserveid)
{

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$reserveid."' " )    or die('Fout in select reserveid');  
$row      = mysqli_fetch_array( $qry);

$id            = substr($bevestigid,0,-3);      /// -RX  
$reply         = substr($bevestigid,-2); 


$query="UPDATE inschrijf 
               SET Betaal_datum = '0000-00-00 00:00:00',
                    Status = 'RE0'
            WHERE  Id           = '".$reserveid."' and Email <> ''  ";
  mysqli_query($con,$query) or die ('error in update BE0 (reset) '); 
  
$query="UPDATE inschrijf 
               SET Betaal_datum = '0000-00-00 00:00:00',
                   Status = 'RE1'
            WHERE  Id           = '".$reserveid."' and Email = ''  ";
  mysqli_query($con,$query) or die ('error in update BE1 (reset) '); 
  
  
  // send mail
  
 //// Indien Mail adres ingevuld ook naar inschrijver (met BCC)
// Datum uit inschrijf   18 jan 2016  Fout opgelost (was eerst inschrijving)

$date         = $row['Inschrijving'];
$status       = $row['Status'];

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
$Naam1        = $row['Naam1'];
$Email        = $row['Email'];
$Betaal_datum = $row['Betaal_datum'];

$from = $subdomein."@ontip.nl";	


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$subject = 'Reserveren inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $_Naam1; 


/// Alleen tbv Email in  inschrijving
$headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>Reserveren inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>In verband met het overschrijden van het aantal inschrijvingen is uw voorlopige inschrijving omgezet naar een reservering.</td></tr>".  "\r\n";

$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $kenmerk       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Naast de inschrijving via Internet zijn er ook inschrijvingen gedaan via schriftelijke aanmelding (lijst op prikbord) of telefonisch. 
	             Dergelijke inschrijvingen worden dan niet direct ingevoerd in het Online systeem. We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";

if (!empty ($Email)){
       mail($Email, $subject, $bericht, $headers);
       
    $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');

} // end if Email gevuld

  
  
  
}// end  for each reserve


//////// Verwerken van betaal id

foreach ($Betaald as $_betaalid)
{
$betaalid        = substr($_betaalid,0,-2);
$betaald_jn      = substr($_betaalid,-1);         // Laatste karakter : J = bevestigen  N = Annuleren

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$_betaalid."' " )    or die('Fout in select betaalid');  
$row      = mysqli_fetch_array( $qry);

$Naam1        = $row['Naam1'];
$status       = $row['Status'];
$Email        = $row['Email'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// betaald_jn is laatste karakter van betaal id

// Betaling Ja bij status BE0 en BE1
// Bij BE0 en betaald_jn=J       BE2 Betaald maar nog niet bevestigd
// Bij BE1 en betaald_jn=J       BE3 Betaald. Geen email bekend.                             


//  Bij BE8 Te bevestigen

/// 5 feb 2014  Sterk vereenvoudigd. Bij uitgestelde bevesting is status BE8. Adhv bankrekening_invullen wordt gekeken naar betalen

 /* 
    <h4>Reserves</h4>
	<ul>
    <li> RE0  =  Reservering aangemaakt en gemeld via Email.
    <li> RE1  =  Reservering aangemaakt. Geen email bekend.
    <li> RE2  =  Reservering geannuleerd en gemeld via Email.
    <li> RE3  =  Reservering geannuleerd. Geen email bekend.
    <li> RE4  =  Reservering aangemaakt en bevestigd via SMS.
    <li> RE5  =  Reservering geannuleerd en gemeld via SMS.
  </ul>
  
 <h4>Bevestigingen en Betalingen</h4>
	
	<ul>
		<li> BE0   =  Voorlopige inschrijving via Email gemeld.
		<li> BE1   =  Voorlopige inschrijving. Geen Email bekend.
		<li> BE2   =  Betaald maar nog niet bevestigd
		<li> BE3   =  Betaald. Geen email bekend.
		<li> BE4   =  Betaald en bevestigd
    <li> BE5   =  Geannuleerd maar nog niet gemeld.
    <li> BE6   =  Geannuleerd en via email gemeld.
    <li> BE7   =  Geannuleerd. Geen email bekend.
    <li> BE8   =  Nog niet bevestigd. Betaling nvt
    <li> BE9   =  Nog niet bevestigd. Betaling nvt. Geen email bekend.
    <li> BEA   =  Bevestigd. Betaling nvt. 
    <li> BEB   =  Bevestigd. Betaling nvt. Geen email bekend
    <li> BEC   =  Bevestigd. Nog niet betaald.
    <li> BED   =  Voorlopige inschrijving via SMS gemeld.
    <li> BEE   =  Bevestigd via SMS.
    <li> BEF   =  Geannuleerd en via email gemeld en gemeld via SMS.
 	  <li> ID0   =  Inschrijving wacht op betaling via IDEAL.
 	  <li> ID1   =  Inschrijving betaald via IDEAL.
 	  <li> ID2   =  Betaling via IDEAL mislukt of afgebroken.
  </UL>

 <h4>Overig</h4>

    <ul>
     <li> DEL   =  Door deelnemer ingetrokken inschrijving (via mail).
     <li> IN0   =  Ingeschreven en gemeld via mail
     <li> IN1   =  Ingeschreven. Geen mail bekend.
     <li> IN2   =  Ingeschreven en gemeld via SMS
     <li> IM0   =  Inschrijving geimporteerd. Niet bevestigd.
     <li> IM1   =  Inschrijving geimporteerd. Bevestigd via Mail.
     <li> IM2   =  Inschrijving geimporteerd. Bevestigd via SMS.
     </ul>		
 	   
 	   */ 

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
echo "betaald_jn : ".$betaald_jn . "<br>";
echo "status     : ".$status. "<br>";
echo "betaal_id  : ".$betaalid. "<br>"; 
*/

if ($betaald_jn == 'J'  and $status == 'BE0'){                     //// betaald nog niet bevestigd
$query="UPDATE inschrijf 
               SET Betaal_datum = NOW() ,
                   Status = 'BE2'
            WHERE  Id           = '".$betaalid."'  ";
  mysqli_query($con,$query) or die ('error in update BE0'); 
 }

if ($betaald_jn == 'J'  and $status == 'BE1'){                     //// betaald . geen email bekend
$query="UPDATE inschrijf 
               SET Betaal_datum = NOW() ,
                   Status = 'BE3'
            WHERE  Id           = '".$betaalid."'  ";
mysqli_query($con,$query) or die ('error in update BE1-J'); 
 }
 
if ($betaald_jn == 'J' and $status == 'BEC'){                      //// betaald en bevestigd
$query="UPDATE inschrijf 
              SET Betaal_datum = NOW() ,
                  Status  = 'BE4' 
            WHERE  Id           = '".$betaalid."'  ";
mysqli_query($con,$query) or die ('error in update BE1-N'); 
}

 
/*

// Betaald is nooit N

if ($betaald_jn == 'N' and $status == 'BE0'){                      //// afwijzing zonder betaling, email bekend
 $query="UPDATE inschrijf 
               Set  Status  = 'BE6' 
            WHERE  Id           = '".$betaalid."'  ";
      mysqli_query($con,$query) or die ('error in update BE8-N'); 
}



if ($betaald_jn == 'N' and $status == 'BE1'){                      //// afwijzing zonder betaling, geen email bekend
$query="UPDATE inschrijf 
               Set  Status  = 'BE7' 
            WHERE  Id           = '".$betaalid."'  ";
      mysqli_query($con,$query) or die ('error in update BE1-N'); 
}

if ($betaald_jn == 'N' and $status == 'BE1'){                      //// afwijzing zonder betaling, niet email bekend
$query="UPDATE inschrijf 
              Set    Status  = 'BE7' 
            WHERE  Id           = '".$betaalid."'  ";
mysqli_query($con,$query) or die ('error in update BE1-N'); 
}
*/

}/// end for each betaling


//////// Activeren verzending voor bevestiging en annulering


foreach ($Bevestigen as $bevestigid)
{

$id            = substr($bevestigid,0,-3);      /// -JX  
$reply         = substr($bevestigid,-2); 
$bevestig_jn   = substr($reply,0,1);         // Eerste karakter : J = bevestigen  N = Annuleren
$bevestig_ms   = substr($reply,-1);          // Laatste karakter : M = mail  S = SMS A = Alles  X = geen functie


//echo " xxxx ". $id. "-" .$betaald_jn  . "<br>";

// ophalen gegevens uit inschrijf voor verzenden mail 

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$id."' " )    or die('Fout in select bevestig id');  
$row      = mysqli_fetch_array( $qry);

$Naam1        = $row['Naam1'];
$Email        = $row['Email'];
$Inschrijving = $row['Inschrijving'];
$Betaal_datum = $row['Betaal_datum'];
$Telefoon     = $row['Telefoon'];

// Datum uit inschrijf   18 jan 2016  Fout opgelost (was eerst inschrijving)

$date         = $row['Inschrijving'];
$status       = $row['Status'];

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


// 0123456789012345678
// 2011-12-21 13:46:35

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

$_Naam1 =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $Naam1);


if ($bevestig_jn  == 'J'){
$subject = 'Definitieve inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $_Naam1; 
}

if ($bevestig_jn  == 'N'){
$subject = 'Afzegging inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $_Naam1; 
}

if ($bevestig_jn  == 'A'){
$subject = 'Activeren inschrijving ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $_Naam1; 
}

$dag4   = 	substr ($datum , 8,2);         
$maand4 = 	substr ($datum , 5,2);         
$jaar4  = 	substr ($datum , 0,4);    

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace('&#226', 'â', $vereniging);
$vereniging        = str_replace('&#233', 'é', $vereniging);
$vereniging        = str_replace('&#234', 'ê', $vereniging);
$vereniging        = str_replace('&#235', 'ë', $vereniging);
$vereniging        = str_replace('&#239', 'ï', $vereniging);

$toernooi_voluit   = str_replace('&#226', 'â', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#233', 'é', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#234', 'ê', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#235', 'ë', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#239', 'ï', $toernooi_voluit);

//// Indien Mail adres ingevuld ook naar inschrijver (met BCC)

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";


/// Alleen tbv Email in  inschrijving

$headers .= 'From: '. $email_organisatie   . "\r\n" . 
 //      'Reply-To: '. $email_organisatie . "\r\n" .    
          'Return-Path: '. $email_organisatie  . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";


if ($bevestig_jn  == 'A'){
$bericht .= "<br><br><h3><u>Ongedaan maken afzeggen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Het intrekken van uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))." is hierbij ongedaan gemaakt. U staat dus nog ingeschreven.</td></tr>".  "\r\n";
}//

if ($bevestig_jn  == 'J'){
$bericht .= "<br><br><h3><u>Definitieve inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Dit is een definitieve bevestiging van uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))."</td></tr>".  "\r\n";
}

if ($bevestig_jn  == 'N'){
$bericht .= "<br><br><h3><u>Afzeggen inschrijving</u></h3>".   "\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  colspan =2>Helaas konden we uw inschrijving van ".strftime("%e %h %Y %H:%M", mktime($uur2, $minuut2, 0, $maand2 , $dag2, $jaar2))." niet definitief maken als gevolg van een overschrijding van het max aantal inschrijvingen </td></tr>".  "\r\n";
}//

$bericht .= "<br><tr><td  width=200>Naam</td><td>"           .  $Naam1       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $kenmerk       ."</td></tr>".  "\r\n";

if ($bevestig_jn  == 'J'){
if ($Bankrekening != ''){
$bericht .= "<tr><td  width=200>Bankrekening   </td><td>"    .  $Bankrekening      ."</td></tr>".  "\r\n";
}
if ($Betaal_datum != '' and $Betaal_datum != '0000-00-00 00:00:00' and $bankrekening_invullen_jn == 'J'){
$bericht .= "<tr><td  width=200>Betaling verwerkt     </td><td>"         .  strftime("%e %h %Y %H:%M", mktime($uur3, $minuut3, 0, $maand3 , $dag3, $jaar3))       ."</td></tr>".  "\r\n";
}

}// betaald_jn J 
$bericht .= "</table>"   . "\r\n";

if ($bevestig_jn  == 'J' and $bankrekening_invullen_jn == 'J' and ($Betaal_datum =='' or $Betaal_datum == '0000-00-00 00:00:00' ) ){
	
	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:red;font-weight:bold;'>Deze inschrijving is wel bevestigd maar nog niet betaald.<br>De wedstrijdcommissie van ".$vereniging."</div>";
 }	

if ($bevestig_jn  == 'J' and $bankrekening_invullen_jn == 'J' and ($Betaal_datum !='' and $Betaal_datum != '0000-00-00 00:00:00' ) ){

	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:blue;'>Deze inschrijving is bevestigd en een betaling is verwerkt.<br>De wedstrijdcommissie van ".$vereniging."</div>";
 }	

if ($bevestig_jn  == 'N' and ($Betaal_datum =='' or $Betaal_datum == '0000-00-00 00:00:00' ) ){
	
	$bericht .= "<br><div style= 'font-family:Arial;font-size:10pt;color:black;'>Naast de inschrijving via Internet zijn er ook inschrijvingen gedaan via schriftelijke aanmelding (lijst op prikbord) of telefonisch. 
	             Dergelijke inschrijvingen worden dan niet direct ingevoerd in het Online systeem. We hopen dat u hiervoor begrip heeft.<br><br>De wedstrijdcommissie van ".$vereniging."</div>";
}	


if (!empty ($Email)){
    if ($status != 'BE5' and $status != 'BE4' and $status != 'IN3' and ($bevestigd_ms = 'M' or $bevestigd_ms = 'A') ){
       mail($Email, $subject, $bericht, $headers);
           
    $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');

    }

} // end if Email gevuld

////  Kopie naar organisatie

 
 $subject = "[ Kopie ] ".$subject;
 
 
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
$headers .= 'From: '. $email_organisatie   . "\r\n" . 
       'Bcc: '. $email_tracer . "\r\n" .
              'Return-Path: '. $email_organisatie  . "\r\n" . 
 //      'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
$headers .= 'From: '. $email_organisatie   . "\r\n" . 
       'Cc: '. $email_cc . "\r\n" .
//       'Reply-To: '. $email_organisatie . "\r\n" .
              'Return-Path: '. $email_organisatie  . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

/// Extra mail bericht naar de organisatie incl extra bericht

if (empty ($Email)){
$bericht .= "<br><hr/><div style= 'font-family:Arial;font-size:10pt;color:blue;font-weight:bold;'>Aan de organisatie : Dit bericht is aangemaakt vanuit het scherm Beheer bevestigingen.<br>Omdat de deelnemer geen Email heeft zult u de deelnemer op een andere manier op de hoogte moeten brengen van de bevestiging of annulering.</div>";
}
else {
$bericht .= "<br><hr/><div style= 'font-family:Arial;font-size:10pt;color:blue;font-weight:bold;'>Aan de organisatie : Dit bericht is aangemaakt vanuit het scherm Beheer bevestigingen.<br>De deelnemer heeft zelf een email ontvangen via email adres ".$Email.".</div>";
}

if ($status != 'BE5' and $status != 'BE4' and ($bevestigd_ms = 'M' or $bevestigd_ms = 'A')){
mail($email_organisatie, $subject, $bericht, $headers);

    $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');

}


/// SMS versturen

//echo "Status : ".$status . "<br>";

if ($sms_bevestigen_zichtbaar_jn  == 'J' and ($status == 'BED' ) and ($bevestigd_ms = 'S' or $bevestigd_ms = 'A')) {

$to          = $Telefoon."@sms.messagebird.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    
  
if ($bevestig_jn  == 'J'){
$sms_bericht .= "Dit is een def. bevest.van uw inschrijving voor  '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";}       
else {            
$sms_bericht .= "Helaas konden we uw inschrijving voor het '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). " niet definitief maken als gevolg van een overschrijding van het max aantal inschrijvingen.  ". "\r\n";
}       

//echo $sms_bericht;

// Check sms_tegoed   
include('sms_tegoed.php');
       
//echo "sms_bevestigen_zichtbaar_jn : ". $sms_bevestigen_zichtbaar_jn . "<br>";
      
       
if ($sms_bevestigen_zichtbaar_jn == 'J' and $sms_tegoed > 1){
 mail($to, $subject, $sms_bericht, $headers);
 
    $function = basename($_SERVER['SCRIPT_NAME']);
    include('../ontip/mail_stats.php');
 
 if ($bevestig_jn  == 'J'){
 	$kenmerk  = "BVST:J:".$kenmerk;
 	}
 	else {
 	$kenmerk  = "BVST:N:".$kenmerk;
}
 
 $sms_bericht_lengte = strlen($sms_bericht);   
  
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'   ,'".$Telefoon."', '".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                        
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
}       
       
} // end sms

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Status updates afhankelijk van vorige status, antwoord en betaald_jn (bevestigen  of annnuleren
/// bevestig_jn = laatste karakter bevestig-id  : J = bevestigen  N = Annuleren  A = Activeren (na delete verzoek)


$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$id."' " )    or die('Fout in select 2');  
$row      = mysqli_fetch_array( $qry);
$status   = $row['Status'];

/*
echo "Id     : ". $id  . "<br>";
echo "Status : ". $status  . "<br>";
echo "bevestig_jn   : ". $bevestig_jn  . "<br>";
echo "betaald_jn    : ". $betaald_jn  . "<br>";
echo "bevestigd_ms  : ". $bevestig_ms  . "<br>";
*/

if ($bevestig_jn == 'J' and  ($status == 'BE0' or $status == 'BE1'  or $status == 'ID0') and ($Betaal_datum =='' or $Betaal_datum == '0000-00-00 00:00:00' )  ){	                               //// bevestiging zonder betaling, (BE0 - BE1    - ID0)
			$query="UPDATE inschrijf 
               SET  Bevestiging_verzonden = NOW(),
                Status  = 'BEC' 
            WHERE  Id           = '".$id."'  ";
          mysqli_query($con,$query) or die (mysql_error()); 
  }

if ($bevestig_jn == 'N' and  ($status == 'BE0' or $status == 'BE1') and $Email != '' ){	                               //// annulering  zonder betaling, (BE0 - BE1) 
	$query="UPDATE inschrijf 
               SET  Bevestiging_verzonden = NOW(),
                Status  = 'BE5' 
            WHERE  Id           = '".$id."'  ";
            
           echo $query;
          mysqli_query($con,$query) or die (mysql_error()); 
  }

if ($bevestig_jn == 'N' and  ($status == 'BE0' or $status == 'BE1' or $status == 'ID0') and $Email == '' ){	                               //// annulering zonder betaling, (BE0 - BE1  - ID0) Geen mail bekend
	$query="UPDATE inschrijf 
               SET  Bevestiging_verzonden = NOW(),
                Status  = 'BE7' 
            WHERE  Id           = '".$id."'  ";
          mysqli_query($con,$query) or die (mysql_error()); 
  }


	if ($bevestig_jn == 'J' and  $status == 'BE2'){	                               //// bevestiging na betaling, email bekend  (BE2 - BE4)
			$query="UPDATE inschrijf 
               SET  Bevestiging_verzonden = NOW(),
                Status  = 'BE4' 
            WHERE  Id           = '".$id."'  ";
          mysqli_query($con,$query) or die (mysql_error()); 
  }

  if ($bevestig_jn == 'N' and $status == 'BE5' and $Email != '' ){               ///// afwijzing   (BE5 - BE6)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE6' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
  if ($bevestig_jn == 'N' and $status == 'ID0' and $Email != '' ){               ///// afwijzing   (ID0 - BE6)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE6' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
  if ($bevestig_jn == 'N' and $status == 'BE5' and $Email == '' ){                ///// afwijzing (BE5 - BE7)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE7' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
 
  
  if ($bevestig_jn == 'J' and $status == 'BE8'){                                    ///// bevestiging (betaling nvt)   (BE8 - BEA)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BEA' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
 if ($bevestig_jn == 'J' and $status == 'BE9'){                                    ///// bevestiging (betaling nvt)  (BE9 - BEB)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BEB' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
 
 if ($bevestig_jn == 'N' and $status == 'BE8'){                                    ///// afwijzing (betaling nvt)   (BE8 - BE6)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE6'
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
 if ($bevestig_jn == 'N' and $status == 'BE9'){                                    ///// afwijzing (betaling nvt)  (BE9 - BE7)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE7' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  } 

if ($bevestig_jn == 'A' and $status == 'DE0' ){                                                             ///// intrekken afwijzing . Email bekend
    $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'IN0' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
}


if ($bevestig_jn == 'A' and $status == 'DE1'){                                                               ///// intrekken afwijing . Geen Email bekend
$query="UPDATE inschrijf 
               SET Status  = 'IN1' 
            WHERE  Id           = '".$id."'  ";
        mysqli_query($con,$query) or die (mysql_error()); 
}

if ($betaald_jn == 'A' and $status == 'DE0' and $uitgestelde_bevestiging_jn == 'J'){                      ///// intrekken afwijzing . Email bekend
$query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BE0' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
}


if ($betaald_jn == 'A' and $status == 'DE1' and $uitgestelde_bevestiging_jn == 'J'){                      ///// intrekken afwijzing . Geen Email bekend
      $query="UPDATE inschrijf 
               SET Status  = 'BE1' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
}

// sms bevestiging

if ($bevestig_jn == 'J' and $status == 'BED' ){                                    ///// bevestiging (betaling nvt)  (BED - BEE)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BEE' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
  
  if ($bevestig_jn == 'N' and $status == 'BED'){                                                                                   ///// bevestiging (betaling nvt)  (BED- BEF)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'BEF' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
// import  bevestiging

  if ($bevestig_jn == 'J' and $status == 'IM0' and ($bevestigd_ms = 'M' or $bevestigd_ms = 'A') ){                                    ///// bevestiging (betaling nvt)  (IM0 - IM1)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'IM1' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
  
  if ($bevestig_jn == 'N' and $status == 'IM0' and ($bevestigd_ms = 'S' or $bevestigd_ms = 'A')){                                   ///// bevestiging (betaling nvt)  (IM0 - IM2)
     $query="UPDATE inschrijf 
               SET Bevestiging_verzonden = NOW(),
                   Status  = 'IM2' 
            WHERE  Id           = '".$id."'  ";
      mysqli_query($con,$query) or die (mysql_error()); 
  }
 
  
}/// end for each bevestigen of annuleren

ob_end_flush();
?> 
<script language="javascript">
		window.location.replace('beheer_bevestigingen.php?<?php echo $replace; ?>');
</script>
