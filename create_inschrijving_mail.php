<?php
/// Mail

$soort_mail = $_GET['soort_mail'];


setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

$email_bcc   = 'erik.hendrikx@gmail.com';
$to          = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

$headers .= 'From: '. $email_noreply  . "\r\n" . 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_bcc . "\r\n" .
              'Return-Path: '. $email_organisatie  . "\r\n" . 
//       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". $toernooi_voluit ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". $vereniging ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>".$soort_mail." inschrijving</u></h3>".   "\r\n";

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Nr.</td><td>"   .  $count. "</td></tr>".  "\r\n";

/// opmaak Licentie en vereniging
if ($Licentie1 !='' and $Vereniging1 !='')  { 
	$text1 = "(". $Licentie1. " , ".  $Vereniging1 . ")";
}
if ($Licentie1 =='' and $Vereniging1 !='')  { 
	$text1 = "(".  $Vereniging1 . ")";
}
if ($Licentie1 !='' and $Vereniging1 =='')  { 
	$text1 = "(". $Licentie1.  ")";
}
if ($Licentie1 =='' and $Vereniging1 =='')  { 
	$text1 = '';
}
//
if ($Licentie2 !='' and $Vereniging2 !='')  { 
	$text2 = "(". $Licentie2. " , ".  $Vereniging2 . ")";
}
if ($Licentie2 =='' and $Vereniging2 !='')  { 
	$text2 = "(".  $Vereniging2 . ")";
}
if ($Licentie2 !='' and $Vereniging2 =='')  { 
	$text2 = "(". $Licentie2.  ")";
}
if ($Licentie2 =='' and $Vereniging2 =='')  { 
	$text2 = '';
}
//
if ($Licentie3 !='' and $Vereniging3 !='')  { 
	$text3 = "(". $Licentie3. " , ".  $Vereniging3 . ")";
}
if ($Licentie3 =='' and $Vereniging3 !='')  { 
	$text3 = "(".  $Vereniging3 . ")";
}
if ($Licentie3 !='' and $Vereniging3 =='')  { 
	$text3 = "(". $Licentie3.  ")";
}
if ($Licentie3 =='' and $Vereniging3 =='')  { 
	$text3 = '';
}
if ($Licentie4 !='' and $Vereniging4 !='')  { 
	$text4 = "(". $Licentie4. " , ".  $Vereniging4 . ")";
}
if ($Licentie4 =='' and $Vereniging4 !='')  { 
	$text4 = "(".  $Vereniging4 . ")";
}
if ($Licentie4 !='' and $Vereniging4 =='')  { 
	$text4 = "(". $Licentie4.  ")";
}
if ($Licentie4 =='' and $Vereniging4 =='')  { 
	$text4 = '';
}

if ($Licentie5 !='' and $Vereniging5 !='')  { 
	$text5 = "(". $Licentie5. " , ".  $Vereniging5 . ")";
}
if ($Licentie5 =='' and $Vereniging5 !='')  { 
	$text5 = "(".  $Vereniging5 . ")";
}
if ($Licentie5 !='' and $Vereniging5 =='')  { 
	$text5 = "(". $Licentie5.  ")";
}
if ($Licentie5 =='' and $Vereniging5 =='')  { 
	$text5 = '';
}

if ($Licentie6 !='' and $Vereniging6 !='')  { 
	$text6 = "(". $Licentie6. " , ".  $Vereniging6 . ")";
}
if ($Licentie6 =='' and $Vereniging6 !='')  { 
	$text6 = "(".  $Vereniging6 . ")";
}
if ($Licentie6 !='' and $Vereniging6 =='')  { 
	$text6 = "(". $Licentie6.  ")";
}
if ($Licentie6 =='' and $Vereniging6 =='')  { 
	$text6 = '';
}

//

if ($soort_inschrijving =='single'){
	$bericht .= "<tr><td  width=200>Naam</td><td>"   .  $Naam1       ."</td><td>     "   .  $text1 . "</td></tr>".  "\r\n";
}

if ($soort_inschrijving !='single'){
 $bericht .= "<tr><td  width=200>Naam(1)</td><td>"   .  $Naam1     ."</td><td>     "   .  $text1. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(2)</td><td>"   .  $Naam2     ."</td><td>     "   .  $text2. "</td></tr>".  "\r\n";
}
 
if ($soort_inschrijving =='triplet' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(3)</td><td>"   .  $Naam3     ."</td><td>     "   .  $text3. "</td></tr>".  "\r\n";
}	

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(4)</td><td>"   .  $Naam4     ."</td><td>     "   .  $text4. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(5)</td><td>"   .  $Naam5     ."</td><td>     "   .  $text5. "</td></tr>".  "\r\n";
 }	
if ($soort_inschrijving == 'sextet'){
 $bericht .= "<tr><td  width=200>Naam(6)</td><td>"   .  $Naam6     ."</td><td>     "   .  $text6. "</td></tr>".  "\r\n";
 }	

$bericht .= "<tr><td  width=200>Adres </td><td>"             .  $Adres      ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Postcode  Plaats</td><td>"   .  $Postcode  . " ". $Woonplaats      ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"         .  $Email       ."</td></tr>".  "\r\n";

if (isset($extra_vraag)){
$bericht .= "<tr><td  width=200>".$Vraag. " </td><td>"       .  $Extra      ."</td></tr>".  "\r\n";
}

$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";

if ($Opmerkingen != "Typ hier evt opmerkingen."){
$bericht .= $Opmerkingen . "\r\n";
}

 mail($to, $subject, $bericht, $headers);
 
 

?>