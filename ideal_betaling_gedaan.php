<?php 
# ideal_betaling_gedaan.php
# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 17mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 
?>
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<Title>OnTip IDEAL betaling (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:green;background-color:white; font-size:8.0pt ; font-family:Arial, Helvetica, sans-serif; ;Font-Style:Bold;text-align: left; }
TD {color:black;font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 { font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

h2 {color:red;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a  {text-decoration:none;color:blue;}
</style>

</head>
<?php
include ('mysqli.php');
include ('versleutel_kenmerk.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email
setlocale(LC_ALL, 'nl_NL');

$toernooi = $_GET['toernooi'];

if (isset($_GET['kenmerk'])) {
  /*
    Via ideal_report.php heeft Mollie de betaling al gemeld, en in dat script heeft bij Mollie gecontroleerd 
    wat de betaalstatus is. Deze betaalstatus is in ideal_report.php ergens opgeslagen in het systeem (bijv. 
    in de database).
   
    De klant komt bij dit script terug na de betaling. Hier kan dan met behulp van het 'transaction_id' 
    de status van de betaling uit de database gehaald worden en de klant de relevante informatie tonen.
  */

    $qry  = mysqli_query($con,"SELECT * From ideal_transacties where Kenmerk = '".$_GET['kenmerk']."'  " )  or die('Fout in ideal select');  	
    $row  = mysqli_fetch_array( $qry );

  /*
     Status             Omschrijving 
     Success            De betaling is gelukt 
     Cancelled          De consument heeft de betaling geannuleerd. 
     Failure            De betaling is niet gelukt (er is geen verdere informatie beschikbaar) 
     Expired            De betaling is verlopen doordat de consument niets met de betaling heeft gedaan. 
*/
$Vereniging          = $row['Vereniging'];
$Toernooi            = $row['Toernooi'];

/* IDEAL gegevens                       */
$Transaction_id      = $row['Transaction_id'];
$Totale_kosten       = $row['Totale_kosten'];
$ConsumerName        = $row['consumerName'];        
$ConsumerAccount     = $row['consumerAccount'];       
$ConsumerCity        = $row['consumerCity'];        
$Description         = $row['Description'];   
$Amount              = $row['paidAmount'];   
$Email               = $row['Email'];   

$Email_encrypt       = $row['Email_encrypt'];
 
 if ($Email =='[versleuteld]'){ 
$Email           = versleutel_string($Email_encrypt);    
}


$Status              = $row['Status'];      
$Laatst              = $row['Laatst'];     
$kenmerk_clear_tekst  = $row['Kenmerk'];   
// zonder punt
$_kenmerk            = substr($row['Kenmerk'],0,4).substr($row['Kenmerk'],5,4);

$now                 = date('Y-m-d H:i:s');

$var                 = "ideal_betaling_jn"; 

//echo "SELECT * from config where  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = '".$var."'  <br>";

$qry                 = mysqli_query($con,"SELECT * from config where  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = '".$var."'  ")           or die(' Fout in select 1');  
$result              = mysqli_fetch_array( $qry);

if ($result['Waarde'] != 'J') {
	echo "Via IDEAL betalen is niet mogelijk voor dit toernooi.<br>";
	exit;
}
$parameter           = explode('#', $result['Parameters']);
$test_mode            = $parameter[1];
$ideal_opslag_kosten = $parameter[2];

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}

//// ophalen gegevens vereniging
$qry1          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select vereniging'); 
$result1       = mysqli_fetch_array( $qry1 );
$partner_id    = $result1['Ideal_partner_id']; // Uw mollie partner ID
$url_website   = $result1['Url_website'];
$url_logo      = $result1['Url_logo']; 



/// roep versleutel routine aan
/// versleutel_licentie($waarde, $richting, $delta)
$decrypt  = versleutel_kenmerk($_kenmerk,'', 20);

// twist eerste en tweede helft
$kenmerk = substr($decrypt,4,4).substr($decrypt,0,4);

$qry_inschrijving      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$row['Toernooi']."' and Kenmerk = '".$kenmerk_clear_tekst."'  " ) or die ('Fout in select inschrijf')   ;
$result_i              = mysqli_fetch_array( $qry_inschrijving  );

if  ($Status =='PAID') {
$update1         = "UPDATE inschrijf           SET Status        = 'ID1'  , Betaal_datum       = '".$now."'         WHERE Id = ".$result_i['Id']."; ";
$update2         = "UPDATE ideal_transacties   SET Inschrijf_id  = ".$result_i['Id']." , 
                                                   Inschrijving = '".$result_i['Inschrijving']."' ,
                                                   Laatst = now()    WHERE Transaction_id = '".$_GET['transaction_id']."'; ";
//echo $update1   . "<br>";

$_Status               ='Betaald via IDEAL';

}
else { 
/*  Betaling niet succesvol !    */
$_Status               ='Betaling via IDEAL niet gedaan.';
$update1               = "UPDATE inschrijf           SET Status           = 'ID2'   ,     Betaal_datum       = '".$now."'      WHERE Id = ".$result_i['Id']."; ";
$update2               = "UPDATE ideal_transacties   SET Inschrijf_id     = ".$result_i['Id']." , Inschrijving = '".$result_i['Inschrijving']."'     WHERE Transaction_id = '".$_GET['transaction_id']."'; ";
}	

mysqli_query($con,$update1) or die ('Fout in update status Inschrijf: '.$update1.' :'. $kenmerk_clear_tekst); 
mysqli_query($con,$update2) or die ('Fout in update ideal_transcties: '.$update2); 


if  ($Status == 'PAID') {

$_Naam1 =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $result_i['Naam1']  );

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);     

$subject  = 'Bevesting IDEAL betaling ';
$subject .= $toernooi_voluit . ' - ' ; 
$subject .= $_Naam1;
$from     = substr($prog_url,3,-1)."@ontip.nl";	

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
         'Cc: '. $email_organisatie . "\r\n" .
         'Return-Path: '. $from  . "\r\n" . 
         'Reply-To: '. $from  . "\r\n" . 
         'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";


$email_noreply = $email_organisatie;
$to            = $Email;

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<div style='text-align:right;padding:0pt;vertical-align:bottom;width:600px;'><img src = 'http://www.ontip.nl/ontip/images/ideal.bmp' width='70'></div>".  "\r\n";

$bericht .= "<h3 style='color:black;font-family:verdana;font-size:10pt;'><u>De volgende inschrijving is betaald via IDEAL </u></h3>".   "\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
if ($test_mode =='TEST'){
$bericht .= "<tr><td  width=200>IDEAL Test mode</td><td>"                .     $test_mode    . "!!!</td></tr>".  "\r\n";
}	
$bericht .= "<tr><td  width=200>Kenmerk</td><td>"                .     $row['Kenmerk']    . "</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Naam speler 1</td><td>"          .     $result_i['Naam1'] . "</td><td>   ( "   .  $result_i['Vereniging1'] . " )</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Rekening nummer </td><td>"       .     $ConsumerAccount   . "</td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Rekeninghouder </td><td>"        .     $ConsumerName      . "</td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Rekeninghouder plaats</td><td>"  .     $ConsumerCity      . "</td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Rekening afschrift</td><td>"     .     $Description       . " </td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email</td><td>"                  .     $Email             . "</td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Kenmerk inschrijving</td><td>"   .     $kenmerk_clear_tekst          . "</td><td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Totaal bedrag</td><td>€. "       .     number_format($Amount/100, 2, ',', ' ') ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Tijdstip betalen</td><td>"       .     $now               . "</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Status</td><td>"                 .     $_Status           . "</td><td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><div style= 'font-family:arial;font-size:9pt;color:black;'>Dit is tevens de definitieve bevestiging van uw inschrijving.</div>"."\r\n";
$bericht .= "<div style= 'font-family:arial;font-size:9pt;color:black;'>OnTip kan niet aansprakelijk gesteld worden voor eventueel foutieve informatie m.b.t betalingen.</div>" . "\r\n";
$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:15pt;'><hr><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
$bericht .= "<div style='text-align:right;padding:0pt;vertical-align:bottom;width:600px;'><img src = 'http://www.ontip.nl/ontip/images/badge-ideal-small.png' width='80'></div>".  "\r\n";

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
   mail($email_organisatie, $_subject, $bericht, $headers, "-finfo@ontip.nl");
}

//echo $bericht;


}  // end id paid for mail
	
?>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<br>
<table>
 <tr>
		<td style='font-family:cursive; font-size: 14pt;color:green;' colspan='2'><h3 style>Betalen via iDEAL</h3></td>
 </tr>
</table>
<blockquote>
<center>
	<div style='width:650px; left:140px;padding:20pt;text-align: left;font-family:arial;font-size:10pt;border-collapse: collapse;background-color:white;padding:5pt;
		         box-shadow: 8px 8px 8px #888888;background-image: url(../ontip/images/payment_background.jpg); background-repeat: no-repeat;
		         -moz-border-radius-topleft: 10px;-webkit-border-top-left-radius: 10px;
					  -moz-border-radius-topright: 10px;-webkit-border-top-right-radius: 10px;
				  	-moz-border-radius-bottomleft: 10px;-webkit-border-bottom-left-radius: 10px;
				  	-moz-border-radius-bottomright: 10px;-webkit-border-bottom-right-radius: 10px;	'>


  <!--div style='width:600px; left:140px;padding:20pt;text-align: left;font-family:cursive;font-size:11pt;'-->
  <fieldset style='border:1px solid white;padding:10pt;'>
<TABLE width=100% border =0>
		<tr>
			<td style='text-align:left;padding:0pt;vertical-align:top;'><img src = '../ontip/images/badge-ideal-small.png' width='85'>
			<td width=90%  style='text-align:center;padding:0pt;color:white;font-size:22pt;font-weight:bold;'>MOLLIE ONLINE BETALINGEN</td>
			<td cellpadding="0" style='text-align:right;padding:2pt;;color:white;vertical-align:top;'><img src = '../ontip/images/ideal.bmp' width='60'></td>
		</tr>
			</TABLE>

<blockquote>
    <center>  
<table width=100%>
<tr>
	<?php if  ($Status == 'PAID'){ ?>
		<td style='font-family:cursive; font-size: 14pt;color:white;' colspan='2'><h3>Betaald via iDEAL</h3></td>
		<?PHP } ELSE {   ?>
		<td style='font-family:cursive; font-size: 14pt;color:yellow;' colspan='2'><h3>Niet Betaald via iDEAL</h3></td>
		<?php } ?>      			
</tr>
</table>

    
           	<?php if  ($Status =='PAID'){ ?>
           	           	 <div style='text-align:center;color:yellow;font-size:14pt;font-weight:bold;'>Bedankt voor uw betaling</div>
           	<?PHP } ELSE {   ?>
           	        	 <div style='text-align:center;color:white;font-size:12pt;font-weight:bold;'>UW BETALING KON NIET DOOR DE BANK VERWERKT WORDEN</div>  	 
           	<?php } ?>     
          <br>
           <table width=90% border =1 style='border-collapse: collapse;background-color:white;padding:5pt;box-shadow: 3px 3px 3px #888888;font-size:8pt;'>
           	 
           	 <?php if ($test_mode =='TEST'){  ?>
           	 <tr><th>iDEAL Test Mode       </th><td>TEST !!!!!</td></tr>
           	<?php } ?> 
           	  <tr><th>Vereniging        </th><td><?php echo $Vereniging; ?></td></tr>
	            <tr><th>Toernooi          </th><td><?php echo $toernooi_voluit ;?></td></tr>
	          	<tr><th>Rekening nummer   </th><td><?php echo $ConsumerAccount;?></td></tr>
              <tr><th>Rekening houder   </th><td><?php echo $ConsumerName;?></td></tr>
              <tr><th>Plaats            </th><td><?php echo $ConsumerCity;?></td></tr>
              <tr><th>Bedrag            </th><td>€. <?php echo number_format($Amount/100,2,",",".");?></td></tr>
              <tr><th>Omschrijving      </th><td><?php echo $Description;?></td></tr>
              <tr><th>Transactie Id     </th><td><?php echo $Transaction_id;?></td></tr>
              <tr><th>Status            </th><td><?php echo $_Status;?></td></tr>
           	<?php if  ($Status =='PAID'){ ?>
              <tr><th>Tijdstip betaling  </th><td><?php echo $now;?></td></tr>
              <tr><th>Bevestigd naar    </th><td><?php echo $Email;?></td></tr>
           	<?php } ?>     
              
            </table>
            </center>
  </blockquote> 
  
  <br>
</fieldset>

<?php

}
else {
  echo 'Er is geen transaction_id meegegeven.';   
}
?>
</body>
</html>
