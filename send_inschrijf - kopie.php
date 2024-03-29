<?php
ob_start();

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/* send_inschrijf.php

  Programma voor kontroleren invoer van Inschrijf_form.php
  Nadat alle controles succesvol zijn , wordt een mail verstuurd.
  Indien een email adres is ingevuld, wordt ook een bevestiging naar de deelnemer gestuurd.
  Als de vereniging is opgenomen in de tabel mail_tracer met Trace = J, wordt een BCC gestuurd naar het daarin vermelde email adres
  Als Naam = '' en Vereniging = ''  en  Licentie <> ''  wordt bij het opgegeven licentienr de Naam + Vereniging gezocht (aanroep search_licentie.php). In dat geval wordt (nog) geen mail verstuurd.
  In de mail wordt een kenmerk vermeld. Dit kenmerk is het resultaat van de versleuteling (versleutel_kenmerk.php) van min.sec.dag.uur (veld inschrijving). Met behulp van het kenmerk kan indien de organisatie daarvoor
  het configuratie item zelf_aanpassen_jn op J heeft gezet, de inschrijving zelf muteren (zelf_inschrijving_muteren.php?toernooi=xxxxxx).

  Met behulp van tooltje calculate_kenmerk.php?Inschrijf=<inschrijving) kan het kenmerk berekend worden.
  Na afronding van de inschrijving kan indien de instelling voor aan staat, een betaling via IDEAL worden gestart via prepare_ideal_betaling.php         */
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>

<?php
// formulier POST variabelen ophalen en kontroleren

  foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
        } 
    } 

//
$date          = date('Y-m-d:H:i:s');
$inschrijving  = $date;

// 012345678901234567890
// 2011-12-21 13:46:35

// Database gegevens. 
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
$url_hostName = $_SERVER['HTTP_HOST'];


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

/// Ophalen tekst kleur

$qry  = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  

$row        = mysqli_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

if (isset($extra_vraag)){
	  if ($Vraag !=''){
			$Extra_compl  = $Vraag . ";Antw.: " . $Extra;
	  }
  }
	    else {
		  $Extra ='';
}

if (!isset($bestemd_voor)) {
	$bestemd_voor = '';
}

if (!isset($zelf_aanpassen_jn)){
	$zelf_aanpassen_jn = 'N';
}
	
if (!isset($extra_invulveld)) {
	$extra_invulveld = '';
}	

if (!isset($sms_bevestigen_zichtbaar_jn)) {
	$sms_bevestigen_zichtbaar_jn = 'N';
}

// Haal sms parameters op ook ivm bevestigen laatste inschrijvingen + mail tracer

   $qry        = mysqli_query($con,"SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ;  
   $result     = mysqli_fetch_array( $qry);
   $sms_max    = $result['Max_aantal_sms'];
   $verzendadres_sms = $result['Verzendadres_SMS'];
   $trace          = $result['Mail_trace'];
   
   if ($trace =='J') {
       $email_tracer = $result['Mail_trace_email'];
   }

if ($sms_bevestigen_zichtbaar_jn == 'J')  {
    $sms_confirmation  = $_POST['sms_confirmation'];
    
   // check op al verstuurde sms berichten
  include('sms_tegoed.php');

  if ($sms_tegoed < 1){
     $sms_max = 0 ; 	
     $sms_bevestigen_zichtbaar_jn = 'N';
  }

 // Check op max aantal sms berichten
 
    if ($sms_max =='') {
   	   $sms_max = 0;
    }
    
    
} // end sms
	
// lees vereniging output naam
	
$qry        = mysqli_query($con,"SELECT * From vereniging  where Vereniging = '".$vereniging ."'   ") ;  
$result     = mysqli_fetch_array( $qry);
$vereniging_output_naam   = $result['Vereniging_output_naam'];


// Inschrijven als individu of vast team 

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

// Minimum aantal spelers

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'min_splrs'  ") ; 
$count      = mysqli_num_rows($qry);
if ($count > 0) {
 $result     = mysqli_fetch_array( $qry);
 $min_splrs  = $result['Waarde'];
}
else {
	$min_splrs   = 0;
}

// $uitgestelde_bevestiging_vanaf

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'uitgestelde_bevestiging_vanaf'  ") ; 
$count      = mysqli_num_rows($qry);
if ($count > 0) {
 $result     = mysqli_fetch_array( $qry);
 $uitgestelde_bevestiging_vanaf  = $result['Waarde'];
}
else {
	$uitgestelde_bevestiging_vanaf  = 0;
}

// extra invulveld

 if(isset($extra_invulveld)){
   $variabele = 'extra_invulveld';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select extra invul');  
   $result    = mysqli_fetch_array( $qry1); 	

   $invulveld    = $result['Waarde']; 
   $verplicht_jn = $result['Parameters'];
}

  $variabele = 'bestemd_voor';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select extra invul');  
   $result    = mysqli_fetch_array( $qry1); 	
   $wel_niet  = $result['Parameters'];
   $naam_vereniging = $result['Waarde'];
   


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

if ($Naam1 == ''){
	$message .= "* Naam speler 1 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam2 == '' and $soort_inschrijving != 'single'  and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam3 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam4 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam5 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam6 == '' and $soort_inschrijving == 'sextet' and $inschrijf_methode == 'vast'){
	$message .= "* Naam speler 6 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie1 == ''  and $licentie_jn == 'J'){
	$message .= "* Licentie speler 1 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie2 == '' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'  and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie3 == '' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 3 is niet ingevuld<br>";
	$error = 1;
}
 
if ($Licentie4 == '' and ($soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie5 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie6 == '' and $soort_inschrijving == 'sextet' and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
	$message .= "* Licentie speler 6 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging1 == '') {
   $message .= "* Vereniging speler 1 is niet ingevuld<br>";
   $error = 1;
 }
 
if ($Vereniging2 == '' and $soort_inschrijving != 'single' and $inschrijf_methode == 'vast'){
	$message .= "* Vereniging speler 2 is niet ingevuld<br>";
	$error = 1;
}
 
if ($Vereniging3 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging4 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging5 == '' and $inschrijf_methode == 'vast' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging6 == '' and $inschrijf_methode == 'vast' and $soort_inschrijving == 'sextet'){
	$message .= "* Vereniging speler 6 is niet ingevuld<br>";
	$error = 1;
}
  
if ($Email == ''  and $Telefoon == '' ){
	$message .= "* Telefoonnr en/of Email adres is niet ingevuld.<br>-  Minimaal een van de twee invullen is verplicht.<br>";
	$error = 1;
}

/// Kontrole extra vraag

if (isset($extra_vraag)  and  $Vraag != '' and  $Extra == '' ){
	 $message .= " * Geen antwoord gegeven op vraag . ". $Vraag .".<br>";
	 $error = 1;
}

/// Kontrole extra invulveld

if (isset($extra_invulveld) and $extra_invulveld !='' and $verplicht_jn   = 'J' and $Extra_invulveld_antwoord ==''){
	 $message .= " * Geen waarde ingevuld voor vraag '". $extra_invulveld ."'.<br>";
	 $error = 1;
}

if ($bankrekening_invullen_jn  == 'J' and $uitgestelde_bevestiging_jn == 'J' and $Bankrekening == '' ){
	$message .= "* Bankrekening is niet ingevuld.<br>-   Bij voorlopige inschrijvingen is dit een verplicht veld.<br>";
	$error = 1;
}

/// kontrole of deze vereniging wel / niet mag inschrijven

if ($bestemd_voor !=''){
   
   if ($naam_vereniging == $Vereniging1 and $wel_niet == 'N'){
     	$message .= $Naam1 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br> ";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging1 and $wel_niet == 'J'){
     	$message .= $Naam1 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br> ";
	    $error = 1;
    }
    
    if ($naam_vereniging == $Vereniging2 and $wel_niet == 'N' and $soort_inschrijving =='doublet' and $inschrijf_methode == 'vast'){
     	$message .= $Naam2 . " * Inschrijving is uitgesloten voor leden van ".$naam_vereniging." ";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging2 and $wel_niet == 'J' and $soort_inschrijving ='doublet' and $inschrijf_methode == 'vast'){
     	$message .= $Naam2 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
  
  if ($naam_vereniging == $Vereniging3 and $wel_niet == 'N' and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' )){
     	$message .= $Naam3 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging." ";
	    $error = 1;
    }
    
   if ($naam_vereniging != $Vereniging3 and $wel_niet == 'J' and  $inschrijf_methode == 'vast' and 
       ( $soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' )){
     	$message .= $Naam3 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    } 
  
  if ($naam_vereniging == $Vereniging4 and $wel_niet == 'N' and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' )){
     	$message .= $Naam4 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging4 and $wel_niet == 'J'and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == '4x4' or  $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam4 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
 
  if ($naam_vereniging == $Vereniging5 and $wel_niet == 'N' and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam5 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging5 and $wel_niet == 'J' and $inschrijf_methode == 'vast' and
       ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam5 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
 
  if ($naam_vereniging == $Vereniging6 and $wel_niet == 'N' and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == 'sextet')){
     	$message .= $Naam6 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging6 and $wel_niet == 'J' and $inschrijf_methode == 'vast' and 
       ($soort_inschrijving == 'sextet')){
     	$message .= $Naam6 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
    
}// bestemd voor

//// Email kontroles

if ($Email != ''){
	
$Email = trim($Email);   // verwijderd begin en eind spaties
$spatie_check  = explode(" ",$Email);  // break op na spatie


/// check op spaties
if (isset($spatie_check[1] )){
    $message .= " * Email adres is niet juist. Bevat een of meer spaties.<br>";
	  $error = 1;
}

if (strpos($Email, '@') == 0){
	 $message .= " * Email adres is niet juist. @ ontbreekt .<br>";
	 $error = 1;
}
else {

$splits   = explode("@", $Email);
$provider = $splits[1];

if (strpos($Email, '.') == 0){
	  $message .= " * Email adres is niet juist. Punt ontbreekt .<br>";
	  $error = 1;
	} else {
	       if (strpos($provider, '.') == 0){
	            $message .= " * Email adres is niet juist. Punt ontbreekt.<br>";
	            $error = 1;
         }
}

$splits2 = explode(".", $provider);

if (strlen($splits2[1]) < 2 or strlen($splits2[1]) > 3)   {
	  $message .= " * Email adres is niet juist. Land ".$splits2[1]." onwaarschijnlijk .<br>";
	  $error = 1;
}

if (strpos($Email, ',') > 0 or strpos($Email, '/') > 0 or strpos($Email, ':') > 0 or   strpos($Email, ':') > 0   ){
	  $message .= " * Email adres is niet juist. Bevat een ongeldig karakter .<br>";
	  $error = 1;
	}

//	if (strpos( strtoupper($Email),'@HOTMAIL.NL') > 0 ){
//	  $message .= " * @hotmail.nl is een verdacht Email adres. Wordt niet ondersteund .<br>";
//	  $error = 1;
//	}
	
// einde email kontrole	
} // end else
} // end email controle

// telefoon nummer controle

if ($sms_bevestigen_zichtbaar_jn == 'J'){
 
 // check of vereniging sms ondersteunt
 
 if ($verzendadres_sms == '' ) {
   	$message .= " * SMS bevestiging is bij deze vereniging (nog) niet geactiveerd.<br>";
	  $error = 1;
}
 
 if ($Telefoon != '' and !is_numeric($Telefoon) ) {
 	  $message .= " * Telefoon nummer mag alleen cijfers bevatten.<br>";
	  $error = 1;
	}

if ($sms_bevestigen_zichtbaar_jn == 'J'  and $Telefoon != ''  and substr($Telefoon,0,2)  !='06' and $sms_confirmation =='J')  {
    $message .= " * SMS bevestigingn is alleen mogelijk naar mobiel nummer.<br>";
	  $error = 1;
}


}//end sms controles


/// Omzetten naam naar eerste letter hoofdletter van alle woorden

if (isset($Naam1)) { $Naam1  = ucwords($Naam1); };
if (isset($Naam2)) { $Naam2  = ucwords($Naam2); };
if (isset($Naam3)) { $Naam3  = ucwords($Naam3); };
if (isset($Naam4)) { $Naam4  = ucwords($Naam4); };
if (isset($Naam5)) { $Naam5  = ucwords($Naam5); };
if (isset($Naam6)) { $Naam6  = ucwords($Naam6); };

// terugzetten hoofdletter in tussenvoegsel

$Naam1 = str_replace('Van De','van de', $Naam1);
$Naam1 = str_replace('Van ','van ', $Naam1);
$Naam1 = str_replace('Op De','op de', $Naam1);
$Naam1 = str_replace('Ter ','ter ', $Naam1);
$Naam1 = str_replace('Vd ','vd ', $Naam1);
$Naam1 = str_replace('V.d. ','v.d. ', $Naam1);
$Naam1 = str_replace(' V ',' v. ', $Naam1);
$Naam1 = str_replace(' De ',' de ', $Naam1);

$Naam2 = str_replace('Van De','van de', $Naam2);
$Naam2 = str_replace('Van ','van ', $Naam2);
$Naam2 = str_replace('Op De','op de', $Naam2);
$Naam2 = str_replace('Ter ','ter ', $Naam2);
$Naam2 = str_replace('Vd ','vd ', $Naam2);
$Naam2 = str_replace('V.d. ','v.d. ', $Naam2);
$Naam2 = str_replace(' V ',' v. ', $Naam2);
$Naam2 = str_replace(' De ',' de ', $Naam2);

$Naam3 = str_replace('Van De','van de', $Naam3);
$Naam3 = str_replace('Van ','van ', $Naam3);
$Naam3 = str_replace('Op De','op de', $Naam3);
$Naam3 = str_replace('Ter ','ter ', $Naam3);
$Naam3 = str_replace('Vd ','vd ', $Naam3);
$Naam3 = str_replace('V.d. ','v.d. ', $Naam3);
$Naam3 = str_replace(' V ',' v. ', $Naam3);
$Naam3 = str_replace(' De ',' de ', $Naam3);

$Naam4 = str_replace('Van De','van de', $Naam4);
$Naam4 = str_replace('Van ','van ', $Naam4);
$Naam4 = str_replace('Op De','op de', $Naam4);
$Naam4 = str_replace('Ter ','ter ', $Naam4);
$Naam4 = str_replace('Vd ','vd ', $Naam4);
$Naam4 = str_replace('V.d. ','v.d. ', $Naam4);
$Naam4 = str_replace(' V ',' v. ', $Naam4);
$Naam4 = str_replace(' De ',' de ', $Naam4);

$Naam5 = str_replace('Van De','van de', $Naam5);
$Naam5 = str_replace('Van ','van ', $Naam5);
$Naam5 = str_replace('Op De','op de', $Naam5);
$Naam5 = str_replace('Ter ','ter ', $Naam5);
$Naam5 = str_replace('Vd ','vd ', $Naam5);
$Naam5 = str_replace('V.d. ','v.d. ', $Naam5);
$Naam5 = str_replace(' V ',' v. ', $Naam5);
$Naam5 = str_replace(' De ',' de ', $Naam5);

$Naam6 = str_replace('Van De','van de', $Naam6);
$Naam6 = str_replace('Van ','van ', $Naam6);
$Naam6 = str_replace('Op De','op de', $Naam6);
$Naam6 = str_replace('Ter ','ter ', $Naam6);
$Naam6 = str_replace('Vd ','vd ', $Naam6);
$Naam6 = str_replace('V.d. ','v.d. ', $Naam6);
$Naam6 = str_replace(' V ',' v. ', $Naam6);
$Naam6 = str_replace(' De ',' de ', $Naam6);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Indien gekoppeld toernooi  (uitgezet 24 sep)

//$sql_t               = mysqli_query($con,"SELECT Waarde from config where Variabele ='gekoppeld_toernooi' and Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'  ")     ;  
//$result              = mysqli_fetch_array( $sql_t);
//$koppel_toernooi_id  = $result['Waarde'];

// if ($koppel_toernooi_id  != '0') {
//	$sql_i               = mysqli_query($con,"SELECT Vereniging, Toernooi from config where Id= '".$koppel_toernooi_id."' ")     ;  
//  $result              = mysqli_fetch_array( $sql_i);
//  $_toernooi            = $result['Toernooi'];
//  $_vereniging          = $result['Vereniging'];
// }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Kontrole op dubbel inschrijven m.b.v table hulp_naam

$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam1."' and Vereniging_speler = '".$Vereniging1."' " ;
//echo $sql;

$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
 $message .= "* Er is al een inschrijving ingevuld voor ".$Naam1." van ".$Vereniging1."<br>";
	$error = 1;
}

if ($Naam2 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam2."' and Vereniging_speler = '".$Vereniging2."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$Naam2. " van ".$Vereniging2."<br>";
	$error = 1;
}
}
	
if ($Naam3 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam3."' and Vereniging_speler = '".$Vereniging3."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$Naam3." van ".$Vereniging3. "<br>";
	$error = 1;
}
}

if ($Naam4 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam4."' and Vereniging_speler = '".$Vereniging4."'" ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$Naam4. " van ".$Vereniging4."<br>";
	$error = 1;
}
}

if ($Naam5 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam5."' and Vereniging_speler = '".$Vereniging5."'" ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$Naam5. " van ".$Vereniging5."<br>";
	$error = 1;
}
}

if ($Naam6 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$Naam6."' and Vereniging_speler = '".$Vereniging6."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$Naam6. " van ".$Vereniging6."<br>";
	$error = 1;
}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// kontroleer of gezocht moet worden op Licenties of user    


if ($Naam1 == '' and $Vereniging1 =='' and $Licentie1 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
	 }
	 
	 
if ($Naam2 == '' and $Vereniging2 =='' and $Licentie2 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
	 }
if ($Naam3 == '' and $Vereniging3 =='' and $Licentie3 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
	 }
if ($Naam4 == '' and $Vereniging4 =='' and $Licentie4 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
	 }
if ($Naam5 == '' and $Vereniging5 =='' and $Licentie5 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
	 }
if ($Naam6 == '' and $Vereniging5 =='' and $Licentie6 <> ''){
	  include("search_licentie.php");
	  $error = 0;
	  $message = 'geen fout';
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 /// alle controles goed 
if ($error == 0 and $message == ''){

// standaard opmerking niet meenemen.

if ($Opmerkingen == "Typ hier evt opmerkingen."){
 $Opmerkingen = '';
 }

/// Soort licentie opzoeken en opslaan  uitgezet 17 mei 2013 ivm verouderde lijst

	$Soort_licentie1 = '';
	$Soort_licentie2 = '';
	$Soort_licentie3 = '';
	$Soort_licentie4 = '';
	$Soort_licentie5 = '';
	$Soort_licentie6 = '';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insert in database

$Vereniging1        = str_replace("'",  "&#39", $Vereniging1);
$Vereniging2        = str_replace("'",  "&#39", $Vereniging2);
$Vereniging3        = str_replace("'",  "&#39", $Vereniging3);
$Vereniging4        = str_replace("'",  "&#39", $Vereniging4);
$Vereniging5        = str_replace("'",  "&#39", $Vereniging5);
$Vereniging6        = str_replace("'",  "&#39", $Vereniging6);
 
// uit vereniging tabel	
    
$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 


if ($Email  != '' ){       
    $status             = 'IN0';   // ingeschreven en bevestigd
}

if ($Email  == '' ){       
    $status             = 'IN1';   // ingeschreven. geen email bekend
}

// Volgnummer = aantal +1

$qry_i           = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging ."'  ") ;  
$result_i        = mysqli_fetch_array( $qry_i);
$aantal          = $result_i['Aantal'];
$volg_nummer     = $aantal+1;


$query = "INSERT INTO inschrijf(Id, Volgnummer, Toernooi, Vereniging,Vereniging_id, Datum, 
                                Naam1, Licentie1, Vereniging1, 
                                Naam2, Licentie2, Vereniging2, 
                                Naam3, Licentie3, Vereniging3, 
                                Naam4, Licentie4, Vereniging4, 
                                Naam5, Licentie5, Vereniging5, 
                                Naam6, Licentie6, Vereniging6, 
                                Adres, Postcode,  Woonplaats,  Telefoon,Email,   Bank_rekening,
                                Opmerkingen, Extra, Extra_invulveld, Status, Inschrijving, Kenmerk)
               VALUES (0,".$volg_nummer.", '".$toernooi."', '".$vereniging ."'  , ".$vereniging_id.", '".$datum."',
                         '".$Naam1."'     ,'".$Licentie1."'   , '".$Vereniging1."' ,
                         '".$Naam2."'     ,'".$Licentie2."'   , '".$Vereniging2."' ,
                         '".$Naam3."'     ,'".$Licentie3."'   , '".$Vereniging3."' ,
                         '".$Naam4."'     ,'".$Licentie4."'   , '".$Vereniging4."' ,
                         '".$Naam5."'     ,'".$Licentie5."'   , '".$Vereniging5."' ,
                         '".$Naam6."'     ,'".$Licentie6."'   , '".$Vereniging6."' , 
                         '".$Adres."'     ,'".$Postcode."'    , '".$Woonplaats."',
                         '".$Telefoon."'  ,'".$Email."'       , '".$Bankrekening."',
                         '".$Opmerkingen."','".$Extra_compl."', '".$Extra_invulveld_antwoord."','".$status."','".$date."','".$kenmerk."'  )";
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// Toevoegen aan hulpnaam ivm kontrole dubbel inschrijven
switch($soort_inschrijving){
 	   case 'single'  : $soort = 1; break;
 	   case 'doublet' : $soort = 2; break;
 	   case 'triplet' : $soort = 3; break; 
 	   case 'kwintet' : $soort = 5; break;
 	   case 'sextet'  : $soort = 6; break;
 	  }// end switch

/// Haal browser en OS van de PC op
$_browser     = 'onbekend';
$_os_platform = 'onbekend';

include ('get_browser_OS.php');


$insert  = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Soort_licentie, Vereniging_speler,Browser, OS_platform,Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam1."','".$Soort_licentie1 ."','".$Vereniging1."','".$_browser."','".$_os_platform."',NOW() )";
//echo $insert;
mysqli_query($con,$insert) ; 

/// Oude waarden bewaren voor mail. Reset browser en OS van de PC . 1x melden is genoeg
$save_browser      = $_browser;
$save_os_platform  = $_os_platform;

$_browser     = '';
$_os_platform = '';

if ($Naam2 <> ''){
	  $insert = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Soort_licentie, Vereniging_speler,Browser, OS_platform, Laatst) 
	         VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam2."','".$Soort_licentie2 ."','".$Vereniging2."','".$_browser."','".$_os_platform."',NOW() )";
	  mysqli_query($con,$insert);  
	 }
if ($Naam3 <> ''){
	  $insert = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Soort_licentie, Vereniging_speler,Browser, OS_platform, Laatst) 
	  VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam3."','".$Soort_licentie3 ."','".$Vereniging3."','".$_browser."','".$_os_platform."',NOW() )";
	  mysqli_query($con,$insert) ; 
	  }
if ($Naam4 <> ''){
	  $insert = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi, Naam , Soort_licentie,Vereniging_speler, Laatst)
	   VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam4."','".$Soort_licentie4 ."','".$Vereniging4."' ,'".$_browser."','".$_os_platform."',NOW())";
	  mysqli_query($con,$insert) ; 
	  }
if ($Naam5 <> ''){
	  $insert = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Soort_licentie, Vereniging_speler,Browser, OS_platform, Laatst) 
	  VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam5."','".$Soort_licentie5 ."','".$Vereniging5."' '".$_browser."','".$_os_platform."',NOW())";
	  mysqli_query($con,$insert) ; 
	 }
if ($Naam6 <> ''){
	  $insert = "insert into hulp_naam (Id,Toernooi, Vereniging, Datum, Soort_toernooi,Naam , Soort_licentie, Vereniging_speler,Browser, OS_platform, Laatst) 
	  VALUES (0,'".$toernooi."', '".$vereniging ."' , '".$datum."',".$soort." ,'".$Naam6."','".$Soort_licentie6 ."','".$Vereniging6."' '".$_browser."','".$_os_platform."',NOW())";
	  mysqli_query($con,$insert) ; 
	 }

// aantal tellen
$qry   = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ") or die(mysql_error());  
$row   = mysqli_fetch_array( $qry );
$aant_splrs = $row['Aantal'];


/// kontroleren uitgestelde bevestiging vanaf waarde

if (!isset($uitgestelde_bevestiging_vanaf)) {
	$uitgestelde_bevestiging_vanaf = '0';
}

if ($uitgestelde_bevestiging_vanaf > 0 and $aant_splrs >= $uitgestelde_bevestiging_vanaf ){
  	$uitgestelde_bevestiging_jn = 'J';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// Aanpassen status in het geval van reservering
////  RE0   =  Reservering. Email bekend
////  RE1   =  Reservering. Geen email bekend
////  RE4   =  Reservering. SMS versturen



if ($aant_splrs  > $max_splrs){
  $reservering = 'J';
  
 if ($status == 'IN0') {           /// email bekend
  $status             = 'RE0';   // reservering aangemaakt
	$query="UPDATE inschrijf       SET Status = 'RE0' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
    //echo $query."<br>";                 
    mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status = RE0'); 
}

if ($status  == 'IN1') {                    // geen email bekend
   $status             = 'RE1';   // reservering aangemaakt
   $query="UPDATE inschrijf       SET Status = 'RE1' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
    //echo $query."<br>";                 
    mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status = RE1'); 
}

if ($sms_confirmation  == 'J'  ) {
  $status             = 'RE4';   // reservering aangemaakt
	$query="UPDATE inschrijf       SET Status = 'RE4' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
    //echo $query."<br>";                 
    mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status = RE4'); 
}


}// if count > max 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Aanpassen status in het geval van uitgestelde bevestiging 

////  IN0   =  Ingeschreven. Email bekend
////  IN1   =  Ingeschreven. Geen email bekend

////  BE0   =  uitgestelde bevestiging J  uitgestelde inschrijving
////  BE1   =  uitgestelde bevestiging J  uitgestelde inschrijving geen  email bekend
////  BE2   =  uitgestelde bevestiging J  betaald niet bevestigd
////  BE3   =  uitgestelde bevestiging J  betaald en bevestigd
////  BE4   =  uitgestelde bevestiging J  betaald geen email bekend
////  BE5   =  uitgestelde bevestiging J  geanulleerd email bekend
////  BE6   =  uitgestelde bevestiging J  geannuleerd nog niet bevestigd 
////  BE7   =  Geannuleerd. Geen email bekend.
////  BE8   =  Nog niet bevestigd. Email bekend.
////  BE9   =  Nog niet bevestigd. Geen email bekend.

////  BEA   =  Bevestigd. Email bekend.
////  BEB   =  Bevestigd. Geen email bekend

////  BE2   =  uitgestelde bevestiging J  betaald niet bevestigd


///  Bij Email    0 - 1 - 2 - 3
///  Geen Email   0 - 1 - 4   bevestigd
///  Bij Email    0 - 5 - 7    geannulleerd


if ($uitgestelde_bevestiging_jn == 'J'  and  $bankrekening_invullen_jn == 'N' and $status  == 'IN0'    ) {
   $status             = 'BE8';
	 $query="UPDATE inschrijf       SET Status = 'BE8' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = BE8' ); 
}

if ($uitgestelde_bevestiging_jn == 'J'  and  $bankrekening_invullen_jn == 'N' and  $status == 'IN1'   ) {
	$status             = 'BE9';
	 $query="UPDATE inschrijf       SET Status = 'BE9' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = BE9' ); 
}

if ($uitgestelde_bevestiging_jn == 'J'  and  $bankrekening_invullen_jn == 'J' and $status  == 'IN0'   ) {
	$status             = 'BE0';
	 $query="UPDATE inschrijf       SET Status = 'BE0' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = BE0' ); 
}

if ($uitgestelde_bevestiging_jn == 'J'  and  $bankrekening_invullen_jn == 'J' and $status  == 'IN1'   ) {
	$status             = 'BE1';
	 $query="UPDATE inschrijf       SET Status = 'BE1' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = BE1' ); 
}

if ($sms_confirmation  == 'J' and $uitgestelde_bevestiging_jn == 'J' and ($status  == 'IN0'  or $status  == 'IN1')  ) {
    $status             = 'BED';   // voorlopig ingeschreven. bevestigd via SMS 
    $query="UPDATE inschrijf       SET Status = 'BED' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = BED' ); 
}

if ($sms_confirmation  == 'J' and $uitgestelde_bevestiging_jn == 'N'  and ($status  == 'IN0'  or $status  == 'IN1') ) {
    $status             = 'IN2';   // ingeschreven. bevestigd via SMS 
    $query="UPDATE inschrijf       SET Status = 'IN2' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : set Status  = IN2' ); 
}

// Verdere afhandeling van bevestigingen en betaling via beheer bevestigingen

 

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

/*
$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);
$vereniging        = str_replace("&#148", "\'", $vereniging);
*/

$Vereniging1       = str_replace("&#39",  "'", $Vereniging1);
$Vereniging2       = str_replace("&#39",  "'", $Vereniging2);
$Vereniging3       = str_replace("&#39",  "'", $Vereniging3);
$Vereniging4       = str_replace("&#39",  "'", $Vereniging4);
$Vereniging5       = str_replace("&#39",  "'", $Vereniging5);
$Vereniging6       = str_replace("&#39",  "'", $Vereniging6);

// andersom voor toernooi voluit 23-sep

$toernooi_voluit   = str_replace( "â", "&#226" , $toernooi_voluit);   
$toernooi_voluit   = str_replace( "é", "&#233" , $toernooi_voluit);   
$toernooi_voluit   = str_replace( "ê", "&#234" , $toernooi_voluit);   
$toernooi_voluit   = str_replace( "ë", "&#235" , $toernooi_voluit);   
$toernooi_voluit   = str_replace( "ï", "&#239" , $toernooi_voluit);   
$toernooi_voluit   = str_replace( "'", "&#39"  ,  $toernooi_voluit);  
$toernooi_voluit   = str_replace( "â", "&acirc;", $toernooi_voluit);  


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  mail versturen

if (isset($uitgestelde_bevestiging_jn) and $uitgestelde_bevestiging_jn == 'J'){
$subject = 'Voorlopige inschrijving ';
}
else {
	$subject = 'Inschrijving ';
}
$_Naam1 =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $Naam1);


$subject .= $toernooi_voluit . '  ' ; 
$subject .= $_Naam1;

// subject pas aanpassen na subject ivm afkeuring mail op vreemde tekens in subject

$toernooi_voluit   = str_replace("&#226", "â", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "é", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "ê", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "ë", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "ï", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39",  "'",  $toernooi_voluit);
$toernooi_voluit   = str_replace("&acirc;", "â",  $toernooi_voluit);

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

$to          = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;



/// tbv migratie
$url_hostName = $_SERVER['HTTP_HOST'];
if ( $url_hostName =='www.boulamis.nl') {
	$from = $email_organisatie;
}
else {
	 $from = substr($prog_url,3,-1)."@ontip.nl";	
}

// uitgaande mail server
//ini_set ( "SMTP", "mail.boulamis.nl" ); 


////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
$headers .= 'From: '. $from  . "\r\n" . 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $from  . "\r\n" . 
//       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
$headers .= 'From: '. $from  . "\r\n" . 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
//       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

/// status reservering

$vereniging        = str_replace("'", "&#39", $vereniging);
$reservering = 'N'; 
  
if (isset($uitgestelde_bevestiging_jn) and $uitgestelde_bevestiging_jn == 'J'){
$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Voorlopige inschrijving</u></h3>".   "\r\n";
}
else {
$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Inschrijving</u></h3>".   "\r\n";
}

$bericht .= "<div style= 'font-family:verdana;font-size:10pt;color:black;font-weight:bold;'>Uw inschrijving is verzonden naar ". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") .".  (".$email_organisatie.")</div>" . "\r\n\r\n\r\n\r\n";


if ($uitgestelde_bevestiging_jn == 'J' and $bankrekening_invullen_jn == 'N'){
 $bericht .= "<span style= 'font-family:verdana;font-size:9pt;color:black;'><br>Dit betreft een voorlopige inschrijving. U ontvangt tzt van de organisatie een definitieve bevestiging of afwijzing.<br><br/></span>". "\r\n\r\n";
}	
	
if ($uitgestelde_bevestiging_jn == 'J' and $bankrekening_invullen_jn == 'J'){
$bericht .= "<span style= 'font-family:verdana;font-size:9pt;color:black;'>Dit betreft een voorlopige inschrijving. Na betaling van het inschrijfgeld zal een definitieve bevestiging verstuurd worden.<br>
Voor de betaalwijze wordt u doorverwezen naar de site.<br>Vermeld bij betalen als kenmerk <b>".$kenmerk."</b><br></span>" . "\r\n\r\n";
}

if ($ideal_betaling_jn == 'J'){	
$bericht .= "<span style= 'font-family:verdana;font-size:9pt;color:black;'>Voor dit toernooi kan de inschrijving via IDEAL betaald worden. Wellicht heeft u dat al direct met inschrijven gedaan. Dan krijgt u bevestiging van de betaling via mail.<br></span>" . "\r\n\r\n";
}


if ($min_splrs > 0 and ($aant_splrs+1)  < $min_splrs  and $min_splrs < $max_splrs ){
	$bericht .= "<span style= 'font-family:verdana;font-size:9pt;color:black;'>WAARSCHUWING: Het minimum aantal inschrijvingen van ". $min_splrs." voor dit toernooi is nog niet bereikt.<br>Het is dus nog niet zeker of het toernooi doorgaat. Hou de website of de inschrijflijst in de gaten !<br><br></span>";
}
	
if ($aant_splrs  > $max_splrs){
	$bericht .="<span style= 'font-family:verdana;font-size:9pt;color:black;'><b>Het toernooi is volgeboekt. U hebt zich ingeschreven als reserve team of speler voor het geval er iemand afzegt. (Max. ".$aantal_reserves." reserves.)" .   "\r\n";
  $bericht .="Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.</b><br></span>" .   "\r\n";
}

// 9 sep 2015 nr_splr gebruiken ivm gebruik van bepalen max_splrs bij sms bericht. Stond eerst max_splrs++
//$nr_splr = $aant_splrs+1;

// 28 mar 2016 nr _splr = volgnummer

$bericht .= "<br><table  Style='font-family:verdana;font-size:9pt;border-collapse: collapse;background-color:white;padding:5pt;border-color:darkgrey;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Nr.</td><td colspan = 2 width=400  align=left>"   .  $volg_nummer. "</td></tr>".  "\r\n";

/// opmaak Licentie en vereniging voor in mail
if ($Licentie1 !='' and $Vereniging1 !='')  { 	$text1 = "(". $Licentie1. " , ".  $Vereniging1 . ")";}
if ($Licentie1 =='' and $Vereniging1 !='')  { 	$text1 = "(". $Vereniging1 . ")";}
if ($Licentie1 !='' and $Vereniging1 =='')  { 	$text1 = "(". $Licentie1.  ")";}
if ($Licentie1 =='' and $Vereniging1 =='')  { 	$text1 = '';}
//
if ($Licentie2 !='' and $Vereniging2 !='')  { 	$text2 = "(". $Licentie2. " , ".  $Vereniging2 . ")";}
if ($Licentie2 =='' and $Vereniging2 !='')  { 	$text2 = "(". $Vereniging2 . ")";}
if ($Licentie2 !='' and $Vereniging2 =='')  { 	$text2 = "(". $Licentie2.  ")";}
if ($Licentie2 =='' and $Vereniging2 =='')  { 	$text2 = '';}
//
if ($Licentie3 !='' and $Vereniging3 !='')  { 	$text3 = "(". $Licentie3. " , ".  $Vereniging3 . ")";}
if ($Licentie3 =='' and $Vereniging3 !='')  { 	$text3 = "(". $Vereniging3 . ")";}
if ($Licentie3 !='' and $Vereniging3 =='')  { 	$text3 = "(". $Licentie3.  ")";}
if ($Licentie3 =='' and $Vereniging3 =='')  { 	$text3 = '';}

if ($Licentie4 !='' and $Vereniging4 !='')  { 	$text4 = "(". $Licentie4. " , ".  $Vereniging4 . ")";}
if ($Licentie4 =='' and $Vereniging4 !='')  { 	$text4 = "(". $Vereniging4 . ")";}
if ($Licentie4 !='' and $Vereniging4 =='')  { 	$text4 = "(". $Licentie4.  ")";}
if ($Licentie4 =='' and $Vereniging4 =='')  { 	$text4 = '';}

if ($Licentie5 !='' and $Vereniging5 !='')  { 	$text5 = "(". $Licentie5. " , ".  $Vereniging5 . ")";}
if ($Licentie5 =='' and $Vereniging5 !='')  { 	$text5 = "(". $Vereniging5 . ")";}
if ($Licentie5 !='' and $Vereniging5 =='')  { 	$text5 = "(". $Licentie5.  ")";}
if ($Licentie5 =='' and $Vereniging5 =='')  { 	$text5 = '';}

if ($Licentie6 !='' and $Vereniging6 !='')  { 	$text6 = "(". $Licentie6. " , ".  $Vereniging6 . ")";}
if ($Licentie6 =='' and $Vereniging6 !='')  { 	$text6 = "(". $Vereniging6 . ")";}
if ($Licentie6 !='' and $Vereniging6 =='')  { 	$text6 = "(". $Licentie6.  ")";}
if ($Licentie6 =='' and $Vereniging6 =='')  { 	$text6 = '';}
//

if ($soort_inschrijving =='single' or $inschrijf_methode == 'single'){
	$bericht .= "<tr><td  width=200>Naam</td><td>"   .  $Naam1       ."</td><td align=right>     "   .  $text1 . "</td></tr>".  "\r\n";
}

if ($soort_inschrijving !='single' and $inschrijf_methode == 'vast'){
 $bericht .= "<tr><td  width=200>Naam (1)</td><td>"   .  $Naam1     ."</td><td align=right>     "   .  $text1. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam (2)</td><td>"   .  $Naam2     ."</td><td align=right>     "   .  $text2. "</td></tr>".  "\r\n";
}
 
if ( $inschrijf_methode == 'vast'  and ($soort_inschrijving =='triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet')){
 $bericht .= "<tr><td  width=200>Naam (3)</td><td>"   .  $Naam3     ."</td><td align=right>     "   .  $text3. "</td></tr>".  "\r\n";
}	

if ($inschrijf_methode == 'vast'  and ($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet')){
 $bericht .= "<tr><td  width=200>Naam (4)</td><td>"   .  $Naam4     ."</td><td align=right>     "   .  $text4. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam (5)</td><td>"   .  $Naam5     ."</td><tdalign=right >     "   .  $text5. "</td></tr>".  "\r\n";
 }	
if ($inschrijf_methode == 'vast'  and $soort_inschrijving == 'sextet'){
 $bericht .= "<tr><td  width=200>Naam (6)</td><td>"   .  $Naam6     ."</td><td align=right>     "   .  $text6. "</td></tr>".  "\r\n";
 }	

$bericht .= "<tr><td  width=200>Telefoon   </td><td colspan = 2>"         .  $Telefoon       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email      </td><td colspan = 2>"         .  $Email          ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk    </td><td colspan = 2>"         .  $kenmerk        ."</td></tr>".  "\r\n";


if ($bankrekening_invullen_jn  == 'J' and $uitgestelde_bevestiging_jn == 'J'  ){
$bericht .= "<tr><td  width=200>Bankrekening   </td><td colspan = 2>"    .  $Bankrekening      ."</td></tr>".  "\r\n";
}

if (isset($extra_vraag)   and $extra_vraag !='' ){
$bericht .= "<tr><td  width=200>".$Vraag. " </td><td colspan = 2>"       .  $Extra      ."</td></tr>".  "\r\n";
}

if (isset($extra_invulveld) and $extra_invulveld !='') {
$bericht .= "<tr><td  width=200>".$invulveld. " </td><td colspan = 2>"       .  $Extra_invulveld_antwoord      ."</td></tr>".  "\r\n";
}



if ($sms_confirmation  == 'J' and $verzendadres_sms !='' ) {
    $bericht .= "<tr><td  width=200>SMS bevestiging naar  </td><td colspan = 2>"         .  $Telefoon      ."</td></tr>".  "\r\n";
}

$bericht .= "<tr><td  width=200>Browser en OS </td><td colspan = 2>"      .  $save_browser. " - ". $save_os_platform    ."</td></tr>".  "\r\n";

$bericht .= "</table>"   . "\r\n";

/// alleen opmerkingen als deze niet leeg is

if ($Opmerkingen != ""){
$bericht .= "<h4 Style='font-family:verdana;font-size:9pt;'><u>Opmerkingen</u></h4>".   "\r\n";
$bericht .= $Opmerkingen . "\r\n";
}


///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
   mail($email_organisatie, $subject, $bericht, $headers,"-f".$email_organisatie."\r\n" );
 //     mail($email_organisatie, $subject, $bericht, $headers);
}

//echo $Email ." -- ". $email_organisatie;

//// Indien Mail adres ingevuld ook naar inschrijver (zonder BCC)
//// 1-2-2013 BCC ook naar inschrijver  ivm mogelijke mailblok


if (!empty ($Email)){
	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$email_noreply = $email_organisatie;
$email_return  = 'bounce@boulamis.nl';


/// tbv migratie
$url_hostName = $_SERVER['HTTP_HOST'];
if ( $url_hostName =='www.boulamis.nl') {
	  $from = $email_organisatie;
	  $email_return  = 'bounce@boulamis.nl';
}
else {
	 $from = substr($prog_url,3,-1)."@ontip.nl";	
	 $email_return  = 'bounce@ontip.nl';
}

$headers .= 'From: '. $from  . "\r\n" . 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

	
if ($uitgestelde_bevestiging_jn == 'J'){	
$subject  = 'Bevestiging voorlopige inschrijving ';
}
else {
$subject  = 'Bevestiging inschrijving ';
}

$subject .= $toernooi_voluit;
$to       = $Email;

if ($ideal_betaling_jn == 'J'){	
	// inschrijving ophalen
$qry3               = mysqli_query($con,"SELECT * From inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Inschrijving = '".$inschrijving."' ")     or die(' Fout in select3');  
$result3            = mysqli_fetch_array( $qry3 );
$id                 = $result3['Id'];

$bericht .= "<br><br><div ><a style='font-family:verdana;font-size:9pt;text-align:left;color:red;'  href='".$url_hostName."/".substr($prog_url,3)."betaal_inschrijving.php?toernooi=". $toernooi."&kenmerk=".$kenmerk."'>Nog niet betaald ? Klik dan op deze link</a><img src = 'http://www.ontip.nl/ontip/images/ideal.bmp' width='40'></div><br><br>".  "\r\n";
}

$bericht .= "<br><div style= 'font-family:verdana;font-size:10pt;color:red;'>Wilt u uw inschrijving intrekken ? <a href='".$url_hostName."/".substr($prog_url,3)."send_cancel_inschrijving_link.php?toernooi=".$toernooi."&kenmerk=".$kenmerk."'>Klik dan op deze link</a></div>" . "\r\n";

if (isset($adres) and $adres !='') {
		
		$bericht .= "<hr/><span Style='font-family:verdana;font-size:9pt;'>Wij spelen dit toernooi op deze locatie : <br></span>".   "\r\n";
		$bericht .= "<div>".   "\r\n";
		$bericht .= "<table>"   . "\r\n";
		
    $naw      = explode(";",$adres,6);
        		
        		$i=0;
             while(isset($naw[$i]))  {
             $bericht .= "<tr><td style= 'font-family:verdana;font-size:9pt;;color:blue;'>"   .  $naw[$i]  ."</td></tr>".  "\r\n";	
             $i++;
            }
           
   $bericht .= "</table></div><br>"   . "\r\n\r\n";

}// end if adres


$bericht .= "<br><table  Style='font-family:verdana;font-size:9pt;border-collapse: collapse;background-color:white;border-color:darkgrey;'>"   . "\r\n";

$variabele = 'meld_tijd';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter = explode('#', $result['Parameters']);
 $suffix    = $parameter[1];
 $meld_tijd = $result['Waarde'];

$variabele = 'aanvang_tijd';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $aanvang_tijd   = $result['Waarde'];
 

  if ($suffix =='1') {
     $bericht .= "<tr><td  width=200>Melden :  </td><td colspan = 2>voor "         .  $meld_tijd       ."</td></tr>".  "\r\n";
    }
   else {
     $bericht .= "<tr><td  width=200>Melden :  </td><td colspan = 2>vanaf "         .  $meld_tijd       ."</td></tr>".  "\r\n";
   }

 $bericht .= "<tr><td  width=200>Aanvang toernooi :  </td><td colspan = 2>"         .  $aanvang_tijd       ."</td></tr>".  "\r\n";
 $bericht .= "</table><br>"   . "\r\n\r\n";


if ($uitgestelde_bevestiging_jn != 'J'){	
  $bericht .= "<div style= 'font-family:verdana;font-size:10pt;color:red;'>Bewaar deze mail goed !</div><br>" . "\r\n\r\n\r\n\r\n";
}


// QRC code Ical event mee sturen

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

$url       = substr($prog_url,3);
$qrc_link  = "http://www.boulamis.nl/".$url."images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";

$qrc_file  = "images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";

if (file_exists($qrc_file)) {         
    $bericht .= "<hr/><h3><u>QR code t.b.v Agenda Smartphone of tablet</u></h3>".   "\r\n";
    $bericht .= "<img src='".$qrc_link."' border = 0 width = 200  alt='Open QRC code'>"; 
} // end file exist

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
  mail($Email, $subject, $bericht, $headers,"-f".$email_organisatie."\r\n");
}

};              /// indien email ingevuld

$geen_mail_versturen  = 0;
if ($Email == $email_organisatie or $Email == $email_cc){
	$geen_mail_versturen  = 1;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// SMS versturen

if ($sms_confirmation  == 'J' and $verzendadres_sms !='' and $Telefoon !=''  ) {
	
$to          = $Telefoon."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject   = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    
       
if ($uitgestelde_bevestiging_jn == 'J'){       
$sms_bericht .= "Hierbij bevestigen we uw voorlopige inschrijving voor het '". $toernooi_voluit. "' op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";
}       
else {            
$sms_bericht .= "Hierbij bevestigen we uw inschrijving voor het ". $toernooi_voluit. " op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";

}       

if ($aant_splrs  > $max_splrs){
$sms_bericht .="Het toernooi is volgeboekt. U hebt zich ingeschreven als reserve team of speler voor het geval er iemand afzegt. (Max. ".$aantal_reserves." reserves.)" .   "\r\n";
  }

// Maximaal 320 karakters versturen. Anders worden 3 berichten afgerekend. 160 lang is 1 bericht. 320 is 2 berichten. Wordt mee gerekend in sms_tegoed
 $sms_bericht        = substr($sms_bericht,0,319)  . "\r\n";    
 $sms_bericht_lengte = strlen($sms_bericht); 
      
///  alleen sms versturen als mail adres niet gelijk is aan organisatie om te sms verkeer te beperken
if ($Email != $email_organisatie and $sms_confirmation  == 'J'){
    mail($to, $subject, $sms_bericht, $headers);
 
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'  , '".$Telefoon."', '".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
 }       // email organisatie 
   
 } // end sms naar inschrijver  


//// sms bevestiging naar organisatie bij bereiken x aantal inschrijvingen
       
if ($verzendadres_sms !='') {

   // check op al verstuurde sms berichten
    
    $qry  = mysqli_query($con,"SELECT count(*) as Aantal From sms_confirmations where Vereniging  = '".$vereniging."'   ")     or die(' Fout in select');  
    $row  = mysqli_fetch_array( $qry );
    $sms_aantal  = $row['Aantal'];


if (isset($sms_laatste_inschrijvingen) and $sms_laatste_inschrijvingen < ($aant_splrs--) and $sms_laatste_inschrijvingen > 0  and   $sms_aantal < $sms_max  ) {
	
	$variabele = 'sms_laatste_inschrijvingen';
  $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
  $result1   = mysqli_fetch_array( $qry1);
  $Telefoon  = $result1['Parameters'];
  
  $to       = $Telefoon."@sms.messagebird.com";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
  $headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
              'Reply-To: '. $email_organisatie . "\r\n" .
              'X-Mailer: PHP/' . phpversion();

 $headers  .= "\r\n";
 $subject   = "OnTipSMS";     /// Verzender SMS

 $sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Inschrijving nr. ".$aant_splrs." voor  '". $toernooi_voluit. "'  op ".strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</div>.  ". "\r\n";
 $sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Speler 1 is ".$Naam1." van ".$Vereniging1."</div>.  ". "\r\n";
 $sms_bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>Max aant inschr : ". $max_splrs.  ". Max aant resv : ".$aantal_reserves."</div>.  ". "\r\n";
   

 // Maximaal 320 karakters versturen. Anders worden 3 berichten afgerekend.
 $sms_bericht = substr($sms_bericht,0,319)  . "\r\n";    
 $sms_bericht_lengte = strlen($sms_bericht); 


  //echo $sms_bericht;     
  mail($to, $subject, $sms_bericht, $headers);

// leg vast in tabel
 $kenmerk = "LAATSTE: ".$aant_splrs;
                         
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'  , '".$Telefoon."', '".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";                        
                         
 //echo $query;
 mysqli_query($con,$query) or die (mysql_error()); 
 
 
} // end sms bevestigen
} // end sms
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Terug naar inschrijf formulier als naam is gezocht bij licentie. Uitgeschakeld 8 sep 2015 Wordt geregeld in search licentie


if ($message == 'geen fout'){
/*	
$string = "Location: Inschrijfform.php?gevonden&toernooi=".$toernooi;

	
if (isset($_POST['simpel'])  or isset($_GET['simpel']) ){
	$string = "Location: Inschrijfform.php?gevonden&simpel&toernooi=".$toernooi;
}

if (isset($_POST['mobiel'])){
	$string = "Location: Inschrijfform.php?gevonden&mobiel&toernooi=".$toernooi;
}

*/


	/// header($string);
}
else {


if ($Email == $email_organisatie or $Email == $email_cc){
  	$Email = '';
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////  Melding op scherm dat inschrijven gelukt is.

echo "<div style= 'font-family:verdana;font-size:10pt;color:".$tekstkleur.";text-decoration:none;'>";
Echo "<h1 style='color:".$koptekst.";'>".$vereniging."-".$toernooi_voluit." </h1><br> ";
Echo "<h2 style='color:".$tekstkleur.";'>Dank u wel voor het inschrijven.</h2><br> ";
echo "<ul><li><a style='color:".$link.";text-decoration:none;'  href='". $url_website ."' target='_top' >Klik hier om naar de website van ". $vereniging_output_naam  ." te gaan.</a><br>"; 

if (isset($_POST['user_select']) and $_POST['user_select'] =='Yes'){
echo "<li><a style='color:".$link.";text-decoration:none;'  href='Inschrijfform.php?toernooi=". $toernooi."&user_select=Yes' target='_top' >Klik hier om naar het inschrijfformulier te gaan.</a><br>"; 
} else {
	echo "<li><a style='color:".$link.";text-decoration:none;'  href='Inschrijfform.php?toernooi=". $toernooi."' target='_top' >Klik hier om naar het inschrijfformulier te gaan.</a><br>"; 
}

echo "<li><a style='color:".$link.";text-decoration:none;'  href='lijst_inschrijf_kort.php?toernooi=". $toernooi." ' target='_top' >Klik hier om de inschrijvingen te bekijken.</a><br>";
echo "<li><a style='color:".$link.";text-decoration:none;'  href='outlook_event.php?toernooi=". $toernooi." ' target='_top' >Klik hier om het toernooi automatisch te laten toevoegen aan uw Outlook agenda</a><br>";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//// geen mail versturen is 0, dus WEL versturen. Veld wordt gebruikt bij search_licentie functionaliteit.
if ($geen_mail_versturen == 0){
echo "</ul><br><h3 style='color:".$tekstkleur.";'>Als u uw email heeft ingevuld, ontvangt u per omgaande een bevestiging.</h3>";

   if ($Email == $email_organisatie){
     echo "<h3 style='color:".$tekstkleur.";'>Het ingevulde Email adres is gelijk aan die van de organisatie. Om deze reden is geen email verstuurd</h3>"; 
   }

}


} // end else 
echo "</div>";

}// error = 0 and message = ''
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*    Via IDEAL betalen */

if ($ideal_betaling_jn  =='J'){ 
// inschrijving ophalen

?>
<center><br><br><fieldset style='border:1px solid blue;padding:10pt;width:900px;'>
<div style= 'font-family:Verdana;font-size:12pt;color:green;'>Betalen via IDEAL  <img src = '../ontip/images/ideal.bmp' width='100'>.</div></br>
<div style= 'font-family:Verdana;font-size:10pt;color:black;'>
<a href = 'prepare_ideal_betaling.php?toernooi=<?php echo $toernooi;?>&id=<?php echo $id;?>' target = '_blank'> Klik hier als u de inschrijving nu wilt betalen via IDEAL</a>
<div style='text-align:right;padding:0pt;vertical-align:bottom;'><img src = '../ontip/images/badge-ideal-small.png' width='80'></div></div></fieldset></center>
<?php
exit;
}

ob_end_flush();
?> 