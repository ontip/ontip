<?php
ob_start();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///// delete_one_inschrijving_stap2.php
/////
/////  Programma om op verzoek een inschrijving te verwijderen uit het systeem
/////  Aangeroepen door delete_one_inschrijving_stap1.php in een mail link met als parameters Id en kenmerk
/////  Naast het record uit inschrijf worden ook de records uit hulp_naam verwijderd. Deze tabel bevat de namen e.d van de individuele spelers 
////   zodat bij het invoeren van een nieuwe inschrijving snel gekeken kan worden of die persoon al ingeschreven is.
/////  De oorspronkele inschrijver krijgt een bevestiging van de verwijdering.
// 26 aug 2018  EHE
//  Email notificaties
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Database gegevens. 
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
include ('../ontip/versleutel_string.php'); // tbv telnr en email
setlocale(LC_ALL, 'nl_NL');

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

$toernooi    = $_POST['toernooi'];
$kenmerk     = $_POST['kenmerk'];
$id          = $_POST['id'];
$bevestiging = $_POST['bevestiging'];

// test
/*
$toernooi    = 'erik_test_toernooi';
$kenmerk     = 'GEDM.EKEE';
$id          =  115347;
$bevestiging = 'Ja';
*/

$qry           = mysqli_query($con,"SELECT * from inschrijf where Toernooi = '".$toernooi."' and Id= ".$id."   ")    or die(' Fout in select met id' ); 

$count         = mysqli_num_rows($qry);

if ($bevestiging != 'Ja'){
	  $count = 99;
}
	
if($count == 1){

$result        = mysqli_fetch_array( $qry );
//Datum toernooi
$datum     = $result['Datum'];
$dag       = substr ($datum , 8,2);         
$maand     = substr ($datum , 5,2);         
$jaar      = substr ($datum , 0,4);     

$email_sender  = $result['Email'];
$email_encrypt = $result['Email_encrypt'];

//  16 feb aanpassing encrypt email in database
if ($email_sender    =='[versleuteld]'){ 
    $email_sender    = versleutel_string($email_encrypt);    
}
 
if ($email_sender  == ''){
  $email_sender = $email_organisatie;
}

$vereniging_id   = $result['Vereniging_id'];

// Ophalen  gegevens
$qry3             = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysqli_fetch_array( $qry3 );
$verzendadres_sms   = $row3['Verzendadres_SMS'];
$trace             = $row3['Mail_trace'];
$url_logo          = $row3['Url_logo']; 

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
   
   
  if ($trace =='J') {
       $email_tracer = $row3['Mail_trace_email'];
   } 

// Haal gegegevens van toernooi uit config

switch($soort_inschrijving){
 	   case 'single'  : $soort = 'mêlée'; break;
 	   case 'doublet' : $soort = 'doublet'; break;
 	   case 'triplet' : $soort = 'triplet'; break; 
 	   case '4x4'     : $soort = '4x4'; break; 
 	   case 'kwintet' : $soort = 'kwintet'; break;
 	   case 'sextet'  : $soort = 'sextet'; break;
 	  }// end switch
	  
// verwijderen uit inschrijf en hulp_naam
mysqli_query($con,"Delete from inschrijf where Id='".$id."' and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam1']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  

if ($soort_inschrijving !='single'){
mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam2']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}

if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam3']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam4']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	

if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam4']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam5']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam6']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam5']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam6']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	         
         
 if ($soort_inschrijving == 'sextet'){
 mysqli_query($con,"Delete from hulp_naam where Naam = '"   .  $result['Naam6']       ."'  and Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
}	       

    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Mail versturen

$toernooi    = $_POST['toernooi'];

setlocale(LC_ALL, 'nl_NL');

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_return . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_return . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}

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


$_subject = "=?utf-8?b?".base64_encode($subject)."?=";

mail($email_sender, $_subject, $bericht, $headers, "-finfo@ontip.nl"); 

/// bevestiging naar organisatie + CC
if ($email_sender != $email_organisatie){	
	
$email_return  = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '   . $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$subject    = 'Melding verwijderen inschrijving ';
$subject   .= $toernooi_voluit;

$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
mail($email_organisatie, $_subject, $bericht, $headers, "-finfo@ontip.nl"); 
	
 	
  	
}// end email organisatie


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// send email notificatie

if 	($email_notificaties_jn =='J'){

	echo "<br>Max aantal spelers : ".$max_splrs;
	echo "<br>Aantal reserves    : ".$aantal_reserves;
	
$qry                = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Toernooi = '".$toernooi."' and Vereniging_id = ".$vereniging_id."  ")    or die(' Fout in select inschrijf count' ); 
$result             = mysqli_fetch_array( $qry );
$aantal_deelnemers  = $result['Aantal'];

	echo "<br>Aantal deelnemers    : ".$aantal_deelnemers;
	
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
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:10pt;color:red;'><a href='https://www.ontip.nl/".substr($prog_url,3)."Inschrijf_form.php?toernooi=".$toernooi."&email_notificatie=".$kenmerk."'>Klik op deze link</a></div>" . "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'https://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
    

  ///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
    if ($email != $email_organisatie){
      	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
        mail($email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
     }

}// end while

}  // end if aantal deelnemers < max spelers


} // end email_notificaties

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        alert("De gegevens van de inschrijving voor het  toernooi zijn al eerder verwijderd of konden niet gevonden worden." + '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		    window.close(); 
	</script>
<?php
}/// end  count == 1   (enkele inschrijving gevonden)


ob_end_flush();
?> 