<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);

// formulier POST variabelen ophalen 


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
// Controles
$error   = 0;
$message = '';

if ($respons == '') {
	$message .= "* Antispam code is niet ingevuld.<br>";
}
else {

if ($challenge != $respons){
	$message .= "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}

if ($Naam == '') {
	$message .= "* Naam is niet ingevuld.<br>";
	$error = 1;
}

if ($Vereniging_speler == '') {
	$message .= "* Vereniging is niet ingevuld.<br>";
	$error = 1;
}
if ($Soort == '') {
	$message .= "* Geen keuze gemaakt Boulemaatje of reserve.<br>";
	$error = 1;
}

if ($Telefoon == '') {
	$message .= "* Telefoon nr is niet ingevuld.<br>";
	$error = 1;
}

if ($Email == '') {
	$message .= "* Email adres is niet ingevuld.<br>";
	$error = 1;
}

if ($Opmerkingen ==' Typ hier evt opmerkingen.'){
   	$Opmerkingen = '';
}

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

include 'mysql.php';


 /// alle controles goed 
if ($error == 0 and $message == ''){


/// Insert in tabel boule_maatje

$query ="INSERT INTO boule_maatje(Id,
                    Toernooi,       
                    Datum,
                    Vereniging,     
                    Vereniging_id,
                    Naam,    
                    Vereniging_speler,
                    Email,          
                    Telefoon,      
                    Licentie,       
                    Status,    
                    Soort_aanvraag,      
                    Opmerkingen,       
                    Laatst)
         VALUES    (0,'".$toernooi."',         
                    '".$datum."',     
                    '".$vereniging."',     
                     ".$vereniging_id.",       
                    '".$Naam."',      
                    '".$Vereniging_speler."',      
                    '".$Email."',            
                    '".$Telefoon."',        
                    '".$Licentie."',             
                    '".$Status."',             
                    '".$Soort."',
                    '".$Opmerkingen."',             
                     NOW() )";
                                                                
//uitvoeren van de query : 

//echo $query;
mysql_query($query) or die (mysql_error()); 

/// Mail versturen
if ($Soort_aanvraag == 'B'){ 
$subject = 'Boule maatje gezocht ';
}
else {
$subject = 'Aanmelding reserve speler ';
}	
$subject .= $toernooi_voluit . '  ' ; 
$subject .= $Naam;

// subject pas aanpassen na subject ivm afkeuring mail op vreemde tekens in subject

$toernooi_voluit   = str_replace("&#226", "â", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "é", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "ê", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "ë", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "ï", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39", "'",  $toernooi_voluit);
$toernooi_voluit   = str_replace("&acirc;", "â",  $toernooi_voluit);

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

$to          = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

// uitgaande mail server
ini_set ( "SMTP", "mail.kpnmail.nl" ); 


////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
	  $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
              'Return-Path: '. $email_organisatie  . "\r\n" . 
//       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
	  $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
//       'Reply-To: '. $email_organisatie . "\r\n" .
              'Return-Path: '. $email_organisatie  . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

if ($Soort_aanvraag == 'B'){ 
$bericht .= "<br><br><h3><u>Boule maatje gezocht</u></h3>".   "\r\n";
}
else {
$bericht .= "<br><br><h3><u>Aanmelding als reserve speler.</u></h3>".   "\r\n";
}	
	
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Naam</td><td>"         .  $Naam    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Vereniging</td><td>"   .  $Vereniging_speler    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Licentie</td><td>"     .  $Licentie    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon</td><td>"     .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"   .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";

if ($Opmerkingen != "Typ hier evt opmerkingen."){
$bericht .= $Opmerkingen . "\r\n";
}

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
 mail($to, $subject, $bericht, $headers);
}

//echo $Email ." -- ". $email_organisatie;


//// Indien Mail adres ingevuld ook naar inschrijver (zonder BCC)
//// 1-2-2013 BCC ook naar inschrijver  ivm mogelijke mailblok

if (!empty ($Email)){
	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$email_noreply = $email_organisatie;
 $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
 //      'Reply-To: '. $email_noreply . "\r\n" .
                     'Return-Path: '. $email_organisatie  . "\r\n" . 
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

if ($Soort_aanvraag == 'R'){ 
$subject = 'Boule maatje gezocht ';
}
else {
$subject = 'Aanmelding reserve speler ';
}	


$subject .= $toernooi_voluit;
$to       = $Email;
$bericht .= "<div style= 'font-family:cursive;font-size:14pt;color:red;'><hr/> Uw aanmelding is verzonden naar ". $email_organisatie ."</div>" . "\r\n\r\n\r\n\r\n";
$bericht .= "<div style= 'font-family:cursive;font-size:7pt;color:brown;padding-top:20pt;'><hr/>(Deze automatische mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx 2011,2012.)</div>" . "\r\n";

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
   mail($to, $subject, $bericht, $headers);
}

};              /// indien email ingevuld





echo "<h1>Boulemaatje verzoek toegevoegd</h1>";




echo "<br><a href ='boulemaatje_gezocht_stap1.php?toernooi=".$toernooi."'  >Klik hier om terug te gaan</a>"; 
}// controles goed

?> 
