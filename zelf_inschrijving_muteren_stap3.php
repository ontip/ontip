<?php
ob_start();
//header("Location: ".$_SERVER['HTTP_REFERER']);
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

// Controles
$error   = 0;
$message = '';

$kenmerk = $_POST['Kenmerk'];
$id   = $_POST['Id'];
$toernooi = $_POST['toernooi'];


//// Database gegevens. 
include ('mysql.php');
include ('versleutel_kenmerk.php'); 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$variabele             = 'datum';
$qry_config            = mysql_query("SELECT * From inschrijf where Id = ".$id." ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$toernooi              = $result_c['Toernooi'];


$variabele             = 'soort_inschrijving';
$qry_config            = mysql_query("SELECT * From config where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$soort_inschrijving    = $result_c['Waarde'];

$variabele             = 'datum';
$qry_config            = mysql_query("SELECT * From config where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$datum                 = $result_c['Waarde'];

$variabele             = 'toernooi_voluit';
$qry_config            = mysql_query("SELECT * From config where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$toernooi_voluit       = $result_c['Waarde'];

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

if ($respons == '') {
	$message .= "* Antispam code is niet ingevuld.<br>";
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

if ($Naam2 == '' and $soort_inschrijving != 'single'){
	$message .= "* Naam speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam3 == '' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam4 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam5 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Naam speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Naam6 == '' and $soort_inschrijving == 'sextet'){
	$message .= "* Naam speler 6 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie1 == ''  and $licentie_jn == 'J'){
	$message .= "* Licentie speler 1 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie2 == '' and $soort_inschrijving != 'single' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 2 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie3 == '' and $soort_inschrijving == 'triplet' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie4 == '' and $soort_inschrijving == 'sextet' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie5 == '' and $soort_inschrijving == 'sextet' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie5 == '' and $soort_inschrijving == 'kwintet' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Licentie6 == '' and $soort_inschrijving == 'sextet' and $licentie_jn == 'J'){
	$message .= "* Licentie speler 6 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging1 == '') {
   $message .= "* Vereniging speler 1 is niet ingevuld<br>";
   $error = 1;
 }
 
if ($Vereniging2 == '' and $soort_inschrijving != 'single'){
	$message .= "* Vereniging speler 2 is niet ingevuld<br>";
	$error = 1;
}

 
if ($Vereniging3 == '' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 3 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging4 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 4 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging5 == '' and ($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
	$message .= "* Vereniging speler 5 is niet ingevuld<br>";
	$error = 1;
}

if ($Vereniging6 == '' and $soort_inschrijving == 'sextet'){
	$message .= "* Vereniging speler 6 is niet ingevuld<br>";
	$error = 1;
}
  
if ($Email == ''  and $Telefoon == '' ){
	$message .= "* Telefoonnr en/of Email adres is niet ingevuld.<br>-  Minimaal een van de twee invullen is verplicht.<br>";
	$error = 1;
}

if ($error  == 0 and $Email == ''  and $uitgestelde_bevestiging_jn == 'J' ){
	$message .= "* Email adres is niet ingevuld. Deze is noodzakelijk voor de ontvangst van de definitieve bevestiging.<br>";
	$error = 1;
}


/// Kontrole extra vraag

if (isset($extra_vraag)  and  $Vraag != '' and  $Extra == '' ){
	 $message .= " * Geen antwoord gegeven op vraag . ". $Vraag .".<br>";
	 $error = 1;
}


if ($bankrekening_invullen_jn  == 'J' and $uitgestelde_bevestiging_jn == 'J' and $Bankrekening == '' ){
	$message .= "* Bankrekening is niet ingevuld.<br>-   Bij voorlopige inschrijvingen is dit een verplicht veld.<br>";
	$error = 1;
}


/// kontrole of deze vereniging wel / niet mag inschrijven

if ($bestemd_voor !=''){
	
   $naam_vereniging = substr($bestemd_voor,0,strlen($bestemd_voor)-2);
   $wel_niet        = strtoupper(substr($bestemd_voor,-2));

  //echo "bestemd voor  : " . $bestemd_voor . "<br>";
	//echo "Vereniging1  : " . $Vereniging1 . "<br>";
  //echo "Vereniging  : " . $naam_vereniging . "<br>";
  //echo "wel_niet : " . $wel_niet . "<br>";


   if ($naam_vereniging == $Vereniging1 and $wel_niet == '#N'){
     	$message .= $Naam1 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br> ";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging1 and $wel_niet == '#J'){
     	$message .= $Naam1 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br> ";
	    $error = 1;
    }
    
    if ($naam_vereniging == $Vereniging2 and $wel_niet == '#N' and $soort_inschrijving !='single'){
     	$message .= $Naam2 . " * Inschrijving is uitgesloten voor leden van ".$naam_vereniging." ";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging2 and $wel_niet == '#J' and $soort_inschrijving !='single'){
     	$message .= $Naam2 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
  
  if ($naam_vereniging == $Vereniging3 and $wel_niet == '#N' and 
       ($soort_inschrijving == 'triplet' or $soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam3 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging." ";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging3 and $wel_niet == '#J' and 
       ( $soort_inschrijving == 'triplet' or $soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam3 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    } 
  
  if ($naam_vereniging == $Vereniging4 and $wel_niet == '#N' and 
       ($soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam4 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging4 and $wel_niet == '#J'and 
       ($soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam4 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
 
  if ($naam_vereniging == $Vereniging5 and $wel_niet == '#N' and 
       ($soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam5 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging5 and $wel_niet == '#J' and 
       ($soort_inschrijving == 'quintet' or $soort_inschrijving == 'sextet')){
     	$message .= $Naam5 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
 
  if ($naam_vereniging == $Vereniging6 and $wel_niet == '#N' and 
       ($soort_inschrijving == 'sextet')){
     	$message .= $Naam6 ." * Inschrijving is uitgesloten voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }
   if ($naam_vereniging != $Vereniging6 and $wel_niet == '#J' and 
       ($soort_inschrijving == 'sextet')){
     	$message .= $Naam6 ." * Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging."<br>";
	    $error = 1;
    }   
    
}// bestemd voor



/// Kontrole op dubbel inschrijven  niet nodig want we muteren


 /// alle controles goed 

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


if ($Email !=''){

// versleutel email
  $encrypt_email = versleutel_string('@##'.$Email);
}  
if ($Telefoon !=''){

 // versleutel telefoon
  $encrypt_telnr = versleutel_string('@##'.$Telefoon);
}


 
// Update

$query="UPDATE inschrijf 
               SET Naam1        = '".$Naam1."',
                   Licentie1    = '".$Licentie1."',
                   Vereniging1  = '".$Vereniging1."',
                   Naam2        = '".$Naam2."',
                   Vereniging2  = '".$Vereniging2."',
                   Licentie2    = '".$Licentie2."',
                   Naam3        = '".$Naam3."',
                   Licentie3    = '".$Licentie3."',
                   Vereniging3  = '".$Vereniging3	."',
                   Naam4        = '".$Naam4."',
                   Licentie4    = '".$Licentie4."',
                   Vereniging4  = '".$Vereniging4	."',
                   Naam5        = '".$Naam5."',
                   Licentie5    = '".$Licentie5."',
                   Vereniging5  = '".$Vereniging5	."',
                   Naam6        = '".$Naam6."',
                   Licentie6    = '".$Licentie6."',
                   Vereniging6  = '".$Vereniging6	."',
                   Telefoon     = '[versleuteld]',
                   Email        = '[versleuteld]',
                   Telefoon_encrypt     = '".$encrypt_telnr."',
                   Email_encrypt        = '".$encrypt_email."'
            WHERE  Id           = '".$Id."'  ";
// echo $query;
mysql_query($query) or die (mysql_error()); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  mail versturen

$subject = 'Mutatie inschrijving ';
$subject .= $toernooi_voluit . '  ' ; 
$subject .= $Naam1;

$from = substr($prog_url,3,-1)."@ontip.nl";	
// 7 feb 2017
$from = $subdomein."@ontip.nl";	

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
$email_return  = $email_organisatie;
$email_noreply = $email_organisatie;

$to = $email_organisatie;

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $from  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);        


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>De volgende inschrijving is gewijzigd</u></h3>".   "\r\n";
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


$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk</td><td>"   .  $Kenmerk. "</td></tr>".  "\r\n";

if ($soort_inschrijving =='single'){
	$bericht .= "<tr><td  width=200>Naam</td><td>"   .  $Naam1       ."</td><td>     "   .  $text1 . "</td></tr>".  "\r\n";
}

if ($soort_inschrijving !='single'){
 $bericht .= "<tr><td  width=200>Naam(1)</td><td>"   .  $Naam1     ."</td><td>     "   .  $text1. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(2)</td><td>"   .  $Naam2     ."</td><td>     "   .  $text2. "</td></tr>".  "\r\n";
}
 
if ($soort_inschrijving =='triplet' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(3)</td><td>"   .  $Naam3     ."</td><td>     "   .  $text3. "</td></tr>".  "\r\n";
}	

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(4)</td><td>"   .  $Naam4     ."</td><td>     "   .  $text4. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(5)</td><td>"   .  $Naam5     ."</td><td>     "   .  $text5. "</td></tr>".  "\r\n";
 }	
if ($soort_inschrijving == 'sextet'){
 $bericht .= "<tr><td  width=200>Naam(6)</td><td>"   .  $Naam6     ."</td><td>     "   .  $text6. "</td></tr>".  "\r\n";
 }	

$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";


echo $bericht;

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
  mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
}

// Naar aanpasser
if (!empty ($Email)){
	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$email_noreply = $email_organisatie;

$headers .= 'From: '. $email_noreply  . "\r\n" . 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";
	
if ($Email != $email_organisatie){
 	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
  mail($Email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
}

};              /// indien email ingevuld
?>
<script language="javascript">
        alert("Uw aanpassing m.b.t  '<?php echo $toernooi_voluit; ?>' toernooi is verwerkt en gemaild naar '<?php echo $email_organisatie; ?>'." + '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		    window.close(); 
	</script>