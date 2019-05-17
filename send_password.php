<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}

a {color:orange ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
</head>
<body>
	
<?php
ob_start();


// Database gegevens. 
include('mysqli.php');
include 'versleutel.php'; 

$naam           = $_POST['naam'];
$vereniging     = $_POST['vereniging'];
$vereniging_nr  = $_POST['vereniging_nr'];

//// ophalen gegevens vereniging
$qry1            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select 1');  
$result1         = mysqli_fetch_array( $qry1 );
$email_noreply   = $result1['Email_noreply'];


$qry        = mysqli_query($con,"SELECT * from namen where Naam = '".$naam."' and Vereniging = '".$vereniging."' and Vereniging_nr = '".$vereniging_nr."' ") or die('Fout in select 2');
$count      = mysqli_num_rows($qry);

echo "<div style=' color:red;'>";
if ($count == 0 ){
	die ('Combinatie gebruikersnaam en verenigingnr niet gevonden !!!');
}
echo "</div>";

$row        = mysqli_fetch_array( $qry );
$password   = versleutel($row['Wachtwoord']);
$beheerder  = $row['Naam'];
$email      = $row['Email'];
$rechten    = $row['Beheerder'];

           switch ($rechten) {
		              case "A":  $omschrijving = " Alle rechten.";
		                         break;
		              case "I":  $omschrijving = " Beheer inschrijvingen.";
		                         break;
		              case "C":  $omschrijving = " Beheer configuratie.";
		                         break;
		       };// end switch             

?>
<body >
<?php
 
//  mail versturen

$subject = 'Aanvraag user gegevens  ';
$subject .= $vereniging;
$to       = $email;

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht  = "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "Er is een aanvraag ontvangen voor toezending van user en wachtwoord" .  "\r\n\r\n";
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Vereniging  : </td><td>". $vereniging ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>User        : </td><td>". $beheerder ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Wachtwoord  : </td><td>". $password  ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Rechten     : </td><td>". $omschrijving ."</td></tr>".  "\r\n";

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