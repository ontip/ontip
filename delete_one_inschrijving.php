<?php
ob_start();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///// delete_one_inschrijving.php
/////
/////  Programma om op verzoek een inschrijving te verwijderen uit het systeem
/////  Aangeroepen door send_cancel_inschrijving_link.php in een mail link met als parameters Id en kenmerk
/////  Naast het record uit inschrijf worden ook de records uit hulp_naam verwijderd. Deze tabel bevat de namen e.d van de individuele spelers 
////   zodat bij het invoeren van een nieuwe inschrijving snel gekeken kan worden of die persoon al ingeschreven is.
/////  De oorspronkele inschrijver krijgt een bevestiging van de verwijdering.

# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 5apr2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          PHP7
# Reference: 

# 26jun2019           1.0.1           E. Hendrikx
# Symptom:   		      None.
# Problem:       	    None
# Fix:                None.
# Feature:            email notificatie verzenden
# Reference: 


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Database gegevens. 
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

$id        = $_GET['id'];
$kenmerk   = $_GET['kenmerk'];


if (isset($_GET['SMS'])){
	$sms_send = 'J';
}
else {
	$sms_send = 'N';
}
	
//echo "SELECT * from inschrijf where Id='".$id."' and  Kenmerk  ='".$kenmerk."'  ";

$qry           = mysqli_query($con,"SELECT * from inschrijf where Id='".$id."' and  Kenmerk  ='".$kenmerk."'  ")    or die(' Fout in select met kenmerk' ); 
$result        = mysqli_fetch_array( $qry );
$toernooi      = $result['Toernooi'];  //Toernooi is in dit geval geen parameter

// mysqli_num_row is counting table row
$count=mysqli_num_rows($qry);
// If result matched $myusername and $mypassword, table row must be 1 row

if($count == 1){

$date     = $result['Inschrijving'];

// 012345678901234567890
// 2011-12-21 13:46:35

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


//Datum toernooi
$datum     = $result['Datum'];
$dag       = substr ($datum , 8,2);         
$maand     = substr ($datum , 5,2);         
$jaar      = substr ($datum , 0,4);     

$email_sender  = $result['Email'];

if ($email_sender  == ''){
$email_sender = $email_organisatie;
}

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

if (!isset($sms_bevestigen_zichtbaar_jn)) {
	$sms_bevestigen_zichtbaar_jn = 'N';
}


if (!isset($email_notificaties_jn)){
	$email_notificaties_jn ='N';
} 


if ($email_notificaties_jn =='J'){
	$variabele = 'email_notificaties_jn';
  $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select notifi');  
  $result    = mysqli_fetch_array( $qry1);
 
 $keuze     = substr($result['Waarde'],0,1);
 $kanaal    = substr($result['Parameters'],1,1);
	
}


// Ophalen sms gegevens
$qry3             = mysqli_query($con,"SELECT Verzendadres_SMS From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS'];

/// Ophalen mail tracer

//echo $vereniging;

//echo "SELECT * From mail_trace where Vereniging = '".$vereniging."' <br> ";
$qry  = mysqli_query($con,"SELECT * From mail_trace where Vereniging = '".$vereniging."' ");  

$count=mysqli_num_rows($qry);
$trace = 'N';

if ($count > 0) {
	$row          = mysqli_fetch_array( $qry );
  $trace        = $row['Trace'];
  $email_tracer = $row['Email'];
  
  //echo "Mail trace : ". $trace . " - ". $email_tracer. "<br>";
}

// Haal gegegevens van toernooi uit config

switch($soort_inschrijving){
 	   case 'single'  : $soort = 'mêlée'; break;
 	   case 'doublet' : $soort = 'doublet'; break;
 	   case 'triplet' : $soort = 'triplet'; break; 
 	   case 'kwintet' : $soort = 'kwintet'; break;
 	   case 'sextet'  : $soort = 'sextet'; break;
 	  }// end switch
	  
// verwijderen uit inschrijf en hulp_naam
mysqli_query($con,"Delete from inschrijf where Id='".$id."' and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam1']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  

if ($soort_inschrijving !='single'){
mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam2']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}

if ($soort_inschrijving =='triplet' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam3']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam4']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam5']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	         
         
 if ($soort_inschrijving == 'sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam6']       ."' and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	       

    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Mail versturen

setlocale(LC_ALL, 'nl_NL');

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

$headers  .= "\r\n";
 
$subject    = 'Bevestiging verwijderen inschrijving ';
$subject   .= $toernooi_voluit;

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";
$bericht .= "<br><br><h3><u>Intrekken inschrijving toernooi</u></h3>".   "\r\n";

$bericht .= "<br><br><div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "Beste ".$result['Naam1'].",<br><br>" .  "\r\n";
$bericht .= "Op uw verzoek hebben we de volgende inschrijving verwijderd uit het OnTip inschrijf systeem.<br><br>" .  "\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";

$bericht .= "<tr><td  width=200>Soort toernooi</td><td>"   .  $soort     ."</td></tr>".  "\r\n";
  
if ($soort_inschrijving !='single' and $inschrijf_methode == 'vast'){
 $bericht .= "<tr><td  width=200>Naam(1)</td><td>"   .  $Naam1     ."</td><td>     "   .  $text1. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(2)</td><td>"   .  $Naam2     ."</td><td>     "   .  $text2. "</td></tr>".  "\r\n";
}
 
if ( $inschrijf_methode == 'vast'  and ($soort_inschrijving =='triplet' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet')){
 $bericht .= "<tr><td  width=200>Naam(3)</td><td>"   .  $Naam3     ."</td><td>     "   .  $text3. "</td></tr>".  "\r\n";
}	

if ($inschrijf_methode == 'vast'  and ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet')){
 $bericht .= "<tr><td  width=200>Naam(4)</td><td>"   .  $Naam4     ."</td><td>     "   .  $text4. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(5)</td><td>"   .  $Naam5     ."</td><td>     "   .  $text5. "</td></tr>".  "\r\n";
 }	
if ($inschrijf_methode == 'vast'  and $soort_inschrijving == 'sextet'){
 $bericht .= "<tr><td  width=200>Naam(6)</td><td>"   .  $Naam6     ."</td><td>     "   .  $text6. "</td></tr>".  "\r\n";
 }	
 
$bericht .= "<tr><td  width=200>Kenmerk   </td><td>".$kenmerk       ."</td></tr>".  "\r\n";          
if ( $sms_send == 'J' and $sms_bevestigen_zichtbaar_jn == 'J' ){
$bericht .= "<tr><td  width=200>Er is een SMS verstuurd naar </td><td>"  .  $result['Telefoon']   ."</td></tr>".  "\r\n";                                       
}
                             
$bericht .= "</table><br>";

$bericht .= "Met vriendelijke groet,<br>"."\r\n";
$bericht .= "Wedstrijd commissie ".$vereniging."."."\r\n";

mail($email_sender, $subject, $bericht, $headers); 


/// email notificaties versturen

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// send email notificatie

if 	($email_notificaties_jn =='J'  and $kanaal =='E'  ){

//	echo "<br>Max aantal spelers : ".$max_splrs;
//	echo "<br>Aantal reserves    : ".$aantal_reserves;
	
	//echo "SELECT count(*) as Aantal from inschrijf where Toernooi = '".$toernooi."' and Vereniging_id = ".$vereniging_id;
	
$qry                = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Toernooi = '".$toernooi."' and Vereniging_id = ".$vereniging_id."  ")    or die(' Fout in select inschrijf count' ); 
$result             = mysqli_fetch_array( $qry );
$aantal_deelnemers  = $result['Aantal'];

//	echo "<br>Aantal deelnemers    : ".$aantal_deelnemers;
	
/// als aantal deelnemers < max spelers en reserves = 0 	
if ($aantal_deelnemers < $max_splrs  and $aantal_reserves  == 0){


  // Ophalen notificatie gegevens
   
   $qry             = mysqli_query($con,"SELECT * From email_notificaties where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Ingeschreven ='N'  ")     or die(' Fout in select notificaties');  
    while($row = mysqli_fetch_array( $qry )) {

   $id               = $row['Id'];
   $naam             = $row['Naam'];
   $email            = $row['Email'];
   $email_encrypt    = $row['Email_encrypt'];
   $licentie         = $row['Licentie'];
   $kenmerk          = $row['Notificatie_kenmerk'];
     
   if ($email =='[versleuteld]'){ 
       $email    = versleutel_string($email_encrypt);    
   }
   
 //     echo "Notificatie naar ".$naam."- ".$email;
   
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
    $bericht .= "<tr><td  width=200>Email      </td><td colspan = 2>"         .  $email                 ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Kenmerk notificatie   </td><td colspan = 2>"    .  $kenmerk        ."</td></tr>".  "\r\n";
    $bericht .= "</table>"   . "\r\n";
    $bericht .= "<br><br><span style='font-family:verdana;font-size:10pt;color:black;font-weight:bold;'>Klik op onderstaande link om u in te schrijven.</span>".   "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:10pt;color:red;'><a href='https://www.ontip.nl/".substr($prog_url,3)."Inschrijfform.php?toernooi=".$toernooi."&email_notificatie=".$kenmerk."'>Klik op deze link</a></div>" . "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'https://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
    
//echo $bericht;

 
      	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
        mail($email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
 

}// end while

}  // end if aantal deelnemers < max spelers


} // end email_notificaties




//// SMS

$Telefoon = $result['Telefoon'];

if ( $sms_send == 'J' and $sms_bevestigen_zichtbaar_jn == 'J' ){
	
// Check op max aantal sms berichten
include('sms_tegoed.php');

 if ($sms_tegoed < 1){       
    // Voorkom dat er meer dan 100 sms berichten verstuurd kunnen worden
       $sms_send = 'N';
} // end sms tegoed

}// end sms send

// telefoon nummer controle
$error = 0;
//echo  "zichtbaar : ". $sms_bevestigen_zichtbaar_jn. "<br>";
//echo  "zend      : ". $sms_send. "<br>";

if ($sms_bevestigen_zichtbaar_jn == 'J' and $sms_send =='J'){
   
 // check of vereniging sms ondersteunt
 
 if ($verzendadres_sms == '' ) {
   	$message .= " * SMS bevestiging is bij deze vereniging (nog) niet geactiveerd.<br>";
	  $error = 1;
}
 
 if ($Telefoon != '' and !is_numeric($Telefoon)) {
 	$message .= " * Telefoon nummer mag alleen cijfers bevatten.<br>";
	  $error = 1;
	}
	
	if ($Telefoon == '') {
 	  $message .= " * Telefoon nummer mag niet leeg zijn bij SMS bevestiging<br>";
	  $error = 1;
	}
	
}//end sms controles

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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// zend sms



// check op al verstuurde sms berichten
include("sms_tegoed.php");

if ($sms_bevestigen_zichtbaar_jn == 'J' and $sms_send =='J'){
	
$to          = $Telefoon."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Cc: '. $email_cc . "\r\n" .
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject   = "OnTipSMS";     /// Verzender SMS
     
$sms_bericht = "";    
$sms_bericht .= "Hierbij bevestigen we dat uw inschrijving voor het '". $toernooi_voluit. "' toernooi op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). " is verwijderd.". "\r\n";
$sms_bericht_lengte = strlen($sms_bericht);   
 
//echo $sms_bericht;

 mail($to, $subject, $sms_bericht, $headers);
 
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$result['Naam1']."'   ,  '".$result['Vereniging1']."'  , '".$Telefoon."','".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                      
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
 

}









 ?>
 <!----- /////////////////////////////////////////   close window in popup ---------------------------------------------------------->
<script language="javascript">
        alert("De gegevens van de inschrijving voor '<?php echo $result['Naam1']; ?>' voor het '<?php echo $toernooi_voluit; ?>' toernooi  zijn verwijderd." + '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
<script type="text/javascript">
		    window.close(); 
</script>
<?php
}/// end if  count  == 1 
else {
?>
<script language="javascript">
        alert("De gegevens van de inschrijving voor het '<?php echo $toernooi_voluit; ?>' toernooi zijn al eerder verwijderd of konden niet gevonden worden." + '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		    window.close(); 
	</script>
<?php
}/// end  count == 1   (enkele inschrijving gevonden)


ob_end_flush();
?> 