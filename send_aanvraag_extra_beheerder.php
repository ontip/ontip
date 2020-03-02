<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
# send_aanvraag_extra_beheerder.php
# maakt iemand bericht aan voor aanvraag extra Ontip beheerder vereniging
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 29nov2018          1.0.1           E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None.
# Feature:          None.
# Reference: 

# 5mei2019          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               PHP7.
# Feature:           None.
# Reference: 

*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
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
  //         echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx". $$key. "<br>";
        } 
    } 
} 
// Controles
$error   = 0;
$message = '';

if ($challenge != $respons){
	$message .= "* Anti spam is niet (juist) ingevuld<br>";
	$error = 1;
}

if ($naam == ''){
	$message .= "* Naam  is niet ingevuld<br>";
	$error = 1;
}

if (strpos($naam,' ')){
	$message .= "* Naam mag geen spaties bevatten<br>";
	$error = 1;
}

if ($email == ''){
	$message .= "* Email is niet ingevuld<br>";
	$error = 1;
}

if ($rechten == ''){
	$message .= "* Geen selectie gemaakt bij soort beheerder<br>";
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
 
 /// alle controles goed 
if ($error == 0){
	ob_start();
include 'mysqli.php'; 



// Als mail versturen
$Klant_PC     = $_SERVER['REMOTE_ADDR'];

$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$vereniging_id = $row['Id'];


$van       = 'info@ontip.nl';
$subject   = 'Aanvraag extra beheerder - '. $vereniging;
$to        = 'erik.hendrikx@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip admin <noreply@ontip.nl>' . "\r\n" .
            'Reply-To: '.$aanvrager.' <'.$email_aanvrager.'>'.  "\r\n" .
            'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= 'http://www.ontip.nl/ontip/images/ontip_logo.png'' width=150>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:14pt;color:blue;'>Aanvraag extra beheerder</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";

$bericht .= "<div style= 'font-family:verdana;font-size:9pt;font-weight:bold;'>Er is een verzoek gedaan om een extra beheerder voor OnTip aan te maken.</div>".  "\r\n";

$bericht .= "<h3><u>Aanvraag</u></h3>".   "\r\n";

$bericht .= "<table style= 'font-family:verdana;font-size:9pt;' >"   . "\r\n";
$bericht .= "<tr><td  width=200  >Vereniging</td><td>"   .  $vereniging     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Aanvrager</td><td>"   .  $aanvrager     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200  >Naam</td><td>"   .  $naam     ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"   .  $email       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Soort     </td><td>"   .  $rechten      ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:9pt;'>". $opmerkingen . "</div>".  "\r\n";
$encrypt ='';


//echo $bericht;
// link voor OnTip beheerder om te activeren

// aanmaak wachtwoord
include 'versleutel.php'; 
$length = 6; 
if( !isset($string )) { $string = '' ; }
    $characters = "ABCDEK123456789123456789";
     while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }

// ivm melden wachtwoord in mail nog de eenvoudige versleuteling
$encrypt       = versleutel($string);


$replace = 'id='.$vereniging_id.'&naam='.$naam.'&encrypt='.$encrypt.'&rechten='.$rechten.'&email='.$email.'&naam_aanvrager='.$aanvrager;

$bericht .= "<h4><u>Activering</u></h4>".   "\r\n";

$url_hostName = $_SERVER['HTTP_HOST'];

$bericht.= "\r\n\r\n<a href = 'https://www.ontip.nl/ontip/OnTip_insert_beheerder_stap3.php?".$replace."' target= '_blank'>Klik hier voor activeren</a>";

$bericht .= "<hr/><div style= 'style= 'font-family:verdana;font-size:9pt;color:black;padding-top:20pt;'><br><img src = 'https://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx ".date('Y ')."</div>" . "\r\n";
$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
mail($to, $_subject, $bericht, $headers, "-finfo@ontip.nl");

$function = basename($_SERVER['SCRIPT_NAME']);
include('../ontip/mail_stats.php');


header ("location: aanvraag_verstuurd.php"); 



}

ob_end_flush();
?> 
