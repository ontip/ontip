<? 
ob_start();

// formulier POST variabelen ophalen en kontroleren

if (isset($_POST['zendform'])) 
{ 
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
} 
// Controles
$error   = 0;
$message = '';

if (!isset($_POST['zendform'])){
	$message .= "* Mail niet verzonden uit ontip programma<br>";
	$error = 1;
}


if ($challenge != $respons){
	$message .= "* Anti spam is niet (juist) ingevuld<br>";
	$error = 1;
}

if ($Naam == ''){
	$message .= "* Naam  is niet ingevuld<br>";
	$error = 1;
}

/// Toon foutmeldingen

if ($error == 1){
  echo "<div style='border: 1pt solid black;padding:10pt;font-size:14pt;font-weight:bold;'>"; 
  echo "Er is een fout gevonden bij het invullen : <br><br>";
	echo $message . "<br>";
	echo "</div>"; 
	echo "<a href='javascript:history.go(-1);'>Klik hier om terug naar het inschrijfformulier van ". $vereniging ." te keren.</a>";
 }
 
 /// alle controles goed 
if ($error == 0){
	ob_start();
include 'mysqli.php'; 



// Als mail versturen
$Klant_PC     = $_SERVER['REMOTE_ADDR'];

$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );


$van     = 'info@ontip.nl';
$subject = 'Vraag contact informatie - '. $vereniging;

$to          = 'erik.hendrikx@gmail.com';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip admin <noreply@ontip.nl>' . "\r\n" .
            'Reply-To: '.$Naam.'<'.$Email.'>'.  "\r\n" .
            'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= 'http://www.ontip.nl/ontip/images/ontip_logo.png'' width=150>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:14pt;color:blue;'>Vraag om informatie of klacht</b></td></tr>" . "\r\n";

$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<h3><u>Contact vraag</u></h3>".   "\r\n";

$bericht .= "<table style= 'font-family:verdana;font-size:9pt;' >"   . "\r\n";
$bericht .= "<tr><td  width=200  >Naam</td><td>"   .  $Naam     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Toernooi </td><td>"   .  $Toernooi."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"   .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"   .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>IP adres     </td><td>"   .  $Klant_PC       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $Opmerkingen . "</div>".  "\r\n";

if ($Naam <> ''){
  mail($to, $subject, $bericht, $headers);
}




$check=$_POST['Check'];
if ($check !=''){
	
$to          = $Email;
$subject     = 'Uw vraag contact informatie - '. $vereniging;


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '. $email_noreply  . "\r\n" . 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

 
mail($to, $subject, $bericht, $headers);


};              /// indien email ingevuld

};	
	
	
if ($Naam <> ''){	
	
header ("location: vraag_gesteld.php"); 

} else {
	
echo "Ongeldige vraag."	;
	
}

ob_end_flush();
?> 