<?php
/// Mail

function send_bevestiging_mail()
{
setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

if (!empty ($Email)){
$to  = $Email;


$subject = 'Definitieve inschrijving ';
$subject .= $toernooi . ' - ' ; 
$subject .= $Naam1; 


//// Indien Mail adres ingevuld ook naar inschrijver (zonder BCC)

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". $toernooi_voluit ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". $vereniging ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>Definitieve inschrijving</u></h3>".   "\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Dit is een definitieve bevestiging van uw inschrijving van (datum)</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Naam</td><td>"   .  $Naam1       ."</td></tr>".  "\r\n";

$bericht .= "<tr><td  width=200>Adres </td><td>"             .  $Adres      ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Postcode  Plaats</td><td>"   .  $Postcode  . " ". $Woonplaats      ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";


 mail($Email, $subject, $bericht, $headers);
 
 echo "Mail is verstuurd ";
 
}} // end if
?>