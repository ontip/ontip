<?php
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 22jun2019          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           Email organisatie als BCC .
# Reference: 

ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Database gegevens. 
include('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email
setlocale(LC_ALL, 'nl_NL');

$telefoon ='';
$toernooi           = $_POST['toernooi'];
$vereniging_id      = $_POST['vereniging_id'];
$email              = $_POST['Email'];
$telefoon           = $_POST['Telefoon'];
$naam               = $_POST['Naam'];
$licentie           = $_POST['Licentie'];
$vereniging_speler  = $_POST['Vereniging_speler'];

$error   = 0;
$message = '';


if ($naam == '') {
	$message .= "* Naam is niet ingevuld.<br>";
	$error = 1;
}

if ($email == '') {
	$message .= "* Email adres is niet ingevuld.<br>";
	$error = 1;
}

if ($vereniging_speler == '') {
	$message .= "* Vereniging  is niet ingevuld.<br>";
	$error = 1;
}

  $email_encrypt = versleutel_string('@##'.$email);
  
   $sql              = mysqli_query($con,"SELECT * From email_notificaties where Toernooi = '".$toernooi."' and Email_encrypt = '".$email_encrypt."'   ")     or die(' Fout in select notificaties');  
   $result           = mysqli_fetch_array( $sql );


 if ($email_encrypt  == $result['Email_encrypt']){ 
  	$message .= "* Voor dit email adres is al een notificatie aanvraag ingevuld.<br>";
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
//exit;

if($error ==0){

// versleutel email let op @##
$email_encrypt = versleutel_string('@##'.$email);

// versleutel telefoon let op @##
$telefoon_encrypt = versleutel_string('@##'.$telefoon);


$qry  = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

$qry_v           = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id ."  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 


// random getal voor kenmerk
$kenmerk ='';
$string = '';
$length = 4;
	  
	  if( !isset($string )) { $string = '' ; }
	  
    $characters = "123456789234567819";
    if( !isset($string )) { $string = '' ; }
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }

$kenmerk = $string;

$query = "INSERT INTO `email_notificaties` (`Id`, `Toernooi`, `Vereniging_id`, `Vereniging`, `Datum`, `Naam`, `Licentie`, `Email`, `Email_encrypt`, `Notificatie_kenmerk`, 
                                            `Ingeschreven`, `Telefoon`, `Telefoon_encrypt`, `Laatst`) 
           VALUES  (0, '".$toernooi."', ".$vereniging_id.", '".$vereniging."', '".$datum."', '".$naam."', '".$licentie."', '[versleuteld]', '".$email_encrypt."',
                     '".$kenmerk."', 'N', '[versleuteld]', '".$telefoon_encrypt."', now()  )";

 
mysqli_query($con,$query) or die ('Fout in insert trigger tabel');           

$from = $subdomein."@ontip.nl";	

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
$email_noreply = $email_organisatie;
$email_return  = $email_organisatie;


$headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
	   'BCC: '. $email_organisatie . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$subject  = 'Aanmelding Email notificatie '.$toernooi_voluit;


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";

$bericht .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<br><hr/>".   "\r\n";
$bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Aangemeld voor Email notificaties</u></h3>".   "\r\n";

$bericht .= "<br><span style='font-family:verdana;font-size:10pt;color:black;'>U ontvangt deze Email omdat u zich heeft aangemeld voor Email notificaties omdat het toernooi is volgeboekt. Zodra er een inschrijving wordt ingetrokken of verwijderd ontvangt u op onderstaand email adres een notificatie.  </span><br>".   "\r\n";

$bericht .= "<br><table  Style='font-family:verdana;font-size:9pt;border-collapse: collapse;background-color:white;padding:5pt;border-color:darkgrey;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Toernooi  </td><td colspan = 2>"          .  $toernooi       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Naam  </td><td colspan = 2>"              .  $naam       ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Vereniging  </td><td colspan = 2>"        .  $vereniging_speler       ."</td></tr>".  "\r\n";
	if($licentie_jn =='J'){ 
$bericht .= "<tr><td  width=200>Licentie  </td><td colspan = 2>"          .  $licentie       ."</td></tr>".  "\r\n";
}		
$bericht .= "<tr><td  width=200>Email      </td><td colspan = 2>"         .  $_POST['Email']         ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk notificatie   </td><td colspan = 2>"         .  $kenmerk        ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><span style='font-family:verdana;font-size:10pt;color:black;font-weight:bold;'>In de notificatie staat de link waarmee u kunt inschrijven. Reageer snel op de notificatie, want ook andere belangstellenden kunnen een notificatie hebben ontvangen.</span>".   "\r\n";

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";


///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
  mail($_POST['Email'], $_subject, $bericht, $headers,"-finfo@ontip.nl");
}


}// end error
?>
<script language="javascript">
		window.location.replace('toevoegen_email_notificatie_stap3.php?toernooi=<?php echo $toernooi; ?>');
</script>

?>