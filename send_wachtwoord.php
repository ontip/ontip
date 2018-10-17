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
include('mysql.php');
include 'versleutel.php'; 

$naam           = $_POST['naam'];
$vereniging     = $_POST['vereniging'];
$vereniging_nr  = $_POST['vereniging_nr'];
$challenge      = $_POST['challenge'];
$respons        = $_POST['respons'];

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

//// ophalen gegevens vereniging
$qry1            = mysql_query("SELECT * From vereniging where Vereniging_nr = '".$vereniging_nr ."' ")     or die(' Fout in select 1');  
$result1         = mysql_fetch_array( $qry1 );
$email_noreply   = $result1['Email_noreply'];

$ip        = $_SERVER['REMOTE_ADDR'];
$sql       = mysql_query("SELECT * FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result    = mysql_fetch_array( $sql );
$naam      = $result['Naam'];
$count     = mysql_num_rows($sql);
$password  = versleutel($result['Wachtwoord']);
$beheerder = $result['Naam'];
$email     = $result['Email'];

?>
<body >
<?php
 
//  mail versturen

$subject = 'Aanvraag user gegevens  ';
$subject .= $vereniging;
$to       = $email;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip Admin <'. $email_noreply  .">". "\r\n" . 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";




$bericht  = "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "Er is een aanvraag ontvangen voor toezending van user en wachtwoord" .  "\r\n\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Vereniging  : </td><td>". $vereniging ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>User        : </td><td>". $beheerder ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Wachtwoord  : </td><td>". $password  ."</td></tr>".  "\r\n";

$bericht .= "</table>"   . "\r\n";

if ($count > 0) {
   mail($to, $subject, $bericht, $headers);

   echo " <div style='color:blue;'>Bericht met wachtwoord is verstuurd naar ". $email." .";
   echo "<br><a href='index.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div>"; 
} // end if count 

ob_end_flush();
?> 
</body>
</html>