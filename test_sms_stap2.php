<?php
include('mysqli.php');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}


$tel_nummer = $_GET['to'];

if (isset($_POST['Tel_nummer'])){
$tel_nummer = $_POST['Tel_nummer'];
}

	

// Controles
$error   = 0;
$message = '';

if ($tel_nummer == '') {
	$message = "* Geen telefoonnummer opgegeven (to).<br>";
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Kontroles goed. Haal rest op

if ($error == 0){

// uit vereniging tabel	
    
$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$verzendadres_sms       = $result_v['Verzendadres_SMS'];
   

/// aanmaak emailbericht (from Verzendadres_sms)
   

//$subject = 'Test sms '.$vereniging;
$subject   = "OnTipSMS";


setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

$email_cc            = 'erik.hendrikx@gmail.com';

$to = $tel_nummer.'@sms.messagebird.com';



$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$headers .= 'From: '. $verzendadres_sms . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
              'Cc: '. $email_cc . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";

// uitgaande mail server
ini_set ( "SMTP", "mail.kpnmail.nl" ); 


$bericht ="<div Style='font-family:verdana;font-size:9pt;color:blue;'>Dit is test om te kijken of een SMS van ".$vereniging." aankomt.</div>"."\r\n\r\n";

mail($to, $subject, $bericht, $headers);

?>

<script language="javascript">
        alert("Er is een test SMS bericht verstuurd naar <?php echo $tel_nummer; ?>. Heeft u binnen 20 seconden geen bericht ontvangen, kontroleer het telefoon nummer." + '\r\n' + 
              " Als u zeker weet dat dit correct is, neem dan contact op met de OnTip beheerder.")
    </script>
  <script type="text/javascript">
       window.close(); 
		</script>

<table width =100%>
	<tr>
		<td style='text-align:left;'><a style='text-decoration:none;font-size:9pt;color:blue;' href='index.php'>Terug naar Hoofdmenu</a></td>
    <td style='text-align:right;'><a style='text-decoration:none;font-size:9pt;color:blue;' href='test_sms_stap1.php'>Nog een keer proberen</a></td>
    </tr>
</table>


<?php
} // end if error



	
