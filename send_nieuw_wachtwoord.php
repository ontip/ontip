<?php
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
?>
<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}

a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>
</head>
<body>
	
<?php
ob_start();


// Database gegevens. 
include('mysqli.php');
include 'versleutel.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$naam           = $_POST['Naam'];
$challenge      = $_POST['challenge'];
$respons        = $_POST['respons'];

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Controles
$error   = 0;
$message = '';

if ($naam == '') {
	$message .= "* Toegangscode is niet ingevuld.<br>";
	$error = 1;
}


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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$count =0;

// ophalen gegevens vereniging
$qry1            = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id ." ")     or die(' Fout in select 1');  
$result1         = mysqli_fetch_array( $qry1 );
$email_noreply   = $result1['Email_noreply'];
$ip              = $_SERVER['REMOTE_ADDR'];

$sql             = mysqli_query($con,"SELECT count(*) as Aantal FROM namen WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$_POST['Naam']."'   ") or die(' Fout in select aantal');  
$result1         = mysqli_fetch_array( $sql );
$count           = $result1['Aantal'];


if ($count == 0){  
   $message .= "- Gebruikersnaam is niet bekend.<br>";

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
}

if ($count ==1){
$sql       = mysqli_query($con,"SELECT * FROM namen WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$naam."'   ") or die(' Fout in select aantal');  
$result    = mysqli_fetch_array( $sql );
$id        = $result['Id'];

$Email            = $result['Email'];
$Email_encrypt    = $result['Email_encrypt'];
  
if ($Email =='[versleuteld]'){ 
$Email      = versleutel_string($Email_encrypt);    
}


 // aanmaak wachtwoord

$length = 6; 
$password ='';
if( !isset($password  )) { $password  = '' ; }
    $characters = "ABCDEK123456789123456789";
     while ( strlen($password ) < $length) { 
        $password .= $characters[mt_rand(1, strlen($characters))];
    }

	$encrypt = md5($password);
	
$email_bcc =  'info@ontip.nl';
 
//  mail versturen

$subject = 'Aanvraag nieuw wachtwoord ';
$subject .= $vereniging;
$to       = $Email;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip Admin <'. $email_noreply  .">". "\r\n" . 
      'Reply-To: '. $email_bcc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .

          'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";
 
$bericht  = "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<br><br><h3><u>Aanvraag nieuw wachtwoord</u></h3>".   "\r\n";
$bericht .= "Er is een aanvraag ontvangen voor toezending van een nieuw  wachtwoord" .  "\r\n\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Vereniging  : </td><td>". $vereniging ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Beheerder   : </td><td>". $naam ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Wachtwoord  : </td><td>". $password  ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht.= "\r\n\r\n<a href = 'https://www.ontip.nl/ontip/activeer_nieuw_wachtwoord.php?id=".$id."&md5=".$encrypt."' target= '_blank'><br>Klik hier voor activeren nieuw wachtwoord</a>";
$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";



if ($count > 0) {
   mail($to, $subject, $bericht, $headers);

   echo " <div style='color:blue;'>Bericht met wachtwoord is verstuurd naar email van de beheerder ".$to;
   echo "<br><br><a href='aanloggen.php'>Klik hier om terug te keren naar de aanlog pagina.</a><br></div>"; 
} // end if count 

} // end if count 
ob_end_flush();
?> 
</body>
</html>