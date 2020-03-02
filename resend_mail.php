<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	</head>
<body>
<?php
include('mysqli.php');
include ('versleutel_kenmerk.php'); 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$Aantal     =  $_POST['Aantal'];
$challenge  =  $_POST['challenge'];
$respons    =  $_POST['respons'];


// Controles
$error   = 0;
$message = '';

if ($respons == '') {
	$message = "* Antispam code is niet ingevuld.<br>";
	$error = 1;
}
else {

if ($challenge != $respons){
	$message = "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Kontroles goed. Haal rest op

if ($error == 0){

   
 if ($trace =='J') {
       $email_tracer = $result_v['Mail_trace_email'];
   }


// Alle email adressen zijn in 1 keer doorgegeven

$email_all =$_GET['Id'];
$mailid = explode(";", $email_all);

$toernooi = $_POST['toernooi'];
$replace  = "toernooi=".$toernooi."";

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

 
/// aanmaken mailberichten 
   
for ($k=0;(!empty($mailid[$k]));$k++){

	$qry              = mysqli_query($con,"SELECT * from inschrijf where Id= '".$mailid[$k]."' " )    or die(mysql_error());  
  $row              = mysqli_fetch_array( $qry);
  $Email            = $row['Email'];
  $Email_encrypt    = $row['Email_encrypt'];

  $datum            = $row['Datum'];
  $Naam1            = $row['Naam1'];
  $Licentie1        = $row['Licentie1'];
  $Vereniging1      = $row['Vereniging1'];
  $Naam2            = $row['Naam2'];
  $Licentie2        = $row['Licentie2'];
  $Vereniging2      = $row['Vereniging2'];
  $Naam3            = $row['Naam3'];
  $Licentie3        = $row['Licentie3'];
  $Telefoon         = $row['Telefoon'];
  $Telefoon_encrypt         = $row['Telefoon_encrypt'];
  $Vereniging3      = $row['Vereniging3'];
  $Naam4            = $row['Naam4'];
  $Licentie4        = $row['Licentie4'];
  $Vereniging4      = $row['Vereniging4'];
  $Naam5            = $row['Naam5'];
  $Licentie5        = $row['Licentie5'];
  $Vereniging5      = $row['Vereniging5'];
  $Naam6            = $row['Naam6'];
  $Licentie6        = $row['Licentie6'];
  $Vereniging6      = $row['Vereniging6'];
  $reservering      = $row['Reservering'];
  $Laatst           = $row['Inschrijving'];

   // uit vereniging tabel	
       
$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$row['Vereniging']."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 
$trace           = $result_v['Mail_trace'];



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  versleutel kenmerk

$dag    = substr ($Laatst , 8,2);         
$maand  = substr ($Laatst , 5,2);         
$jaar   = substr ($Laatst , 0,4);     
$uur    = substr ($Laatst , 11,2);     
$minuut = substr ($Laatst , 14,2);     
$sec    = substr ($Laatst , 17,2);     

// $kenmerk = $jaar.sprintf("%02d",$maand).sprintf("%02d",$dag).".".sprintf("%02d",$uur).sprintf("%02d",$minuut).sprintf("%02d",$sec);

$_kenmerk = $minuut.$sec.$dag.$uur;

/// roep versleutel routine aan
/// versleutel_licentie($waarde, $richting, $delta)
$encrypt = versleutel_kenmerk($_kenmerk,'encrypt', 20);
$kenmerk  = substr($encrypt,0,4).".".substr($encrypt,4,4);
//echo "Kenmerk : ". $kenmerk. "<br>";
//

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "рам $vereniging);
$vereniging        = str_replace("&#233", "чам $vereniging);
$vereniging        = str_replace("&#234", "шам $vereniging);
$vereniging        = str_replace("&#235", "щам $vereniging);
$vereniging        = str_replace("&#239", "эам $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "╠в, $vereniging);

$_Naam1 =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $Naam1);

$subject = '[ Kopie ] Inschrijving ';
// subject pas aanpassen na subject ivm afkeuring mail op vreemde tekens in subject

$toernooi_voluit   = str_replace("&#226", "рам $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "чам $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "шам $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "щам $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "эам $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39",  "'",  $toernooi_voluit);
$toernooi_voluit   = str_replace("&acirc;", "рам  $toernooi_voluit);

$_toernooi_voluit = $toernooi_voluit;
$subject .= $toernooi_voluit . '  ' ; 
$subject .= $_Naam1;

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         


if ($Email =='[versleuteld]'){ 
$to            = versleutel_string($Email_encrypt);    
}
else {
$to =         $Email;
}
 
if ($Telefoon =='[versleuteld]'){ 
$Telefoon            = versleutel_string($Telefoon_encrypt);    
}

 
$email_cc      = $email_cc;
$email_noreply = $email_organisatie;

$email_noreply = $email_organisatie;
$email_return  = $email_organisatie;
$from = $subdomein."@ontip.nl";	

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";


////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $from  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";

// uitgaande mail server
//ini_set ( "SMTP", "mail.kpnmail.nl" ); 


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";


$bericht .="<div Style='font-family:verdana;font-size:9pt;color:blue;'>Dit is een kopie van een eerder ingevoerde inschrijving. Deze mail is door de organisatie (opnieuw) verstuurd.</div>"."\r\n\r\n";

if (isset($uitgestelde_bevestiging_jn) and $uitgestelde_bevestiging_jn == 'J'){
$bericht .= "<br><br><h3><u>Voorlopige inschrijving</u></h3>".   "\r\n";
}
else {
$bericht .= "<br><<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Inschrijving</u></h3>".   "\r\n";
}
	
if ($reservering =='J') {
	$bericht .="<b>Het toernooi is volgeboekt. U hebt zich ingeschreven als reserve team of speler voor het geval er iemand afzegt. (Max. ".$aantal_reserves." reserves.)" .   "\r\n";
  $bericht .="Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.</b><br>" .   "\r\n";
  
  $query="UPDATE inschrijf       SET Reservering = 'J' 
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     Inschrijving = '".$date."'  ";
 
mysqli_query($con,$query) or die (mysql_error()); 
}

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
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";

if ($soort_inschrijving =='single'){
	$bericht .= "<tr><td  width=200>Naam</td><td>"   .  $Naam1       ."</td><td>     "   .  $text1 . "</td></tr>".  "\r\n";
}

if ($soort_inschrijving !='single'){
 $bericht .= "<tr><td  width=200>Naam(1)</td><td>"   .  $Naam1     ."</td><td>     "   .  $text1. "</td></tr>".  "\r\n";
 $bericht .= "<tr><td  width=200>Naam(2)</td><td>"   .  $Naam2     ."</td><td>     "   .  $text2. "</td></tr>".  "\r\n";
}
 
if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(3)</td><td>"   .  $Naam3     ."</td><td>     "   .  $text3. "</td></tr>".  "\r\n";
}	

if ($soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(4)</td><td>"   .  $Naam4     ."</td><td>     "   .  $text4. "</td></tr>".  "\r\n";
}	

if ($soort_inschrijving == 'kwintet' or $soort_inschrijving =='sextet'){
 $bericht .= "<tr><td  width=200>Naam(5)</td><td>"   .  $Naam5     ."</td><td>     "   .  $text5. "</td></tr>".  "\r\n";
}	
 
if ($soort_inschrijving == 'sextet'){
 $bericht .= "<tr><td  width=200>Naam(6)</td><td>"   .  $Naam6     ."</td><td>     "   .  $text6. "</td></tr>".  "\r\n";
}	

$bericht .= "<tr><td  width=200>Telefoon   </td><td>"        .  $Telefoon   ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email      </td><td>"        .  $to          ."</td></tr>".  "\r\n";


if ($bankrekening_invullen_jn  == 'J' and $uitgestelde_bevestiging_jn == 'J'  ){
$bericht .= "<tr><td  width=200>Bankrekening   </td><td>"    .  $Bankrekening      ."</td></tr>".  "\r\n";
}

$bericht .= "<tr><td  width=200>Kenmerk   </td><td>"         .  $kenmerk       ."</td></tr>".  "\r\n";

if (isset($extra_vraag)){
$bericht .= "<tr><td  width=200>".$Vraag. " </td><td>"       .  $Extra      ."</td></tr>".  "\r\n";
}

$bericht .= "</table>"   . "\r\n";

$bericht .= "<h4><u>Opmerkingen</u></h4>".   "\r\n";

if ($Opmerkingen != "Typ hier evt opmerkingen."){
$bericht .= $Opmerkingen . "\r\n";
}
if ($ideal_betaling_jn == 'J'){	
	// inschrijving ophalen
$qry3               = mysqli_query($con,"SELECT * From inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Inschrijving = '".$inschrijving."' ")     or die(' Fout in select3');  
$result3            = mysqli_fetch_array( $qry3 );
$id                 = $result3['Id'];

$bericht .= "<br><br><div ><a style='font-family:verdana;font-size:9pt;text-align:left;color:red;'  href='".$url_hostName."/".substr($prog_url,3)."betaal_inschrijving.php?toernooi=". $toernooi."&kenmerk=".$kenmerk."'>Nog niet betaald ? Klik dan op deze link</a><img src = 'http://www.ontip.nl/ontip/images/ideal.bmp' width='40'></div><br><br>".  "\r\n";
}


if (isset($uitgestelde_bevestiging_jn) and $uitgestelde_bevestiging_jn == 'J' and $reservering =='1'){
$bericht .= "<span style= 'font-family:verdana;font-size:10pt;color:black;'>Dit betreft een voorlopige inschrijving. Na betaling van het inschrijfgeld zal een definitieve bevestiging verstuurd worden.<br>
Voor de betalingwijze wordt u verwezen naar de site.<br>Vermeld bij betalen als kenmerk <b>".$kenmerk."</b></span>" . "\r\n";
}

$bericht .= "<div style= 'font-family:verdana;font-size:12pt;color:black;'>Uw inschrijving is verzonden naar ". $vereniging ."</div>" . "\r\n\r\n\r\n\r\n";
$bericht .= "<hr/><div style= 'font-family:verdana;font-size:14pt;color:red;'>Bewaar deze mail goed !</div>" . "\r\n\r\n\r\n\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:11pt;color:blue;'>Wilt u uw inschrijving intrekken ? <a href ='http://www.ontip.nl/".substr($prog_url,3)."send_cancel_inschrijving_link.php?toernooi=".$toernooi."&kenmerk=".$kenmerk."'>Klik dan op deze link</a></div>" . "\r\n";

// QRC code Ical event mee sturen

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

$url       = explode("/",$prog_url);
$qrc_link  = "http://www.ontip.nl/".$url[3]."/images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";
$qrc_file  = "../".$url[3]."/images/qrc/qrc_ical_".$toernooi."-".$jaar.$maand.$dag.".png";

if (file_exists($qrc_file)) {         
    $bericht .= "<hr/><br><h3><u>QR code t.b.v Agenda Smartphone of tablet</u></h3>".   "\r\n";
    $bericht .= "<img src='".$qrc_link."' border = 0 width = 200  alt='Open QRC code'>"; 
    $bericht .= "<br><br><div style= 'font-family:arial;font-size:9pt;color:black;'>Scan deze code met uw smartphone of tablet om het toernooi op te nemen in uw agenda.</div>"."\r\n";
} // end file exist

$bericht .= "<hr/><span Style='font-family:verdana;font-size:9pt;'>Wij spelen dit toernooi op deze locatie : <br></span>".   "\r\n";
$bericht .= "<div>".   "\r\n";
$bericht .= "<table>"   . "\r\n";


if (isset($adres) and $adres !='') {
		
		$bericht .= "<div >".   "\r\n";
		$bericht .= "<table>"   . "\r\n";
		
    $naw      = explode(";",$adres,6);
        		
        		$i=0;
             while(isset($naw[$i]))  {
             $bericht .= "<tr><td style= 'font-family:verdana;font-size:9pt;;color:blue;'>"   .  $naw[$i]  ."</td></tr>".  "\r\n";	
             $i++;
            }
           
   $bericht .= "</table></div>"   . "\r\n";

}// end if adres

$bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

//echo $bericht;
 	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
  mail($to, $_subject, $bericht, $headers,"-finfo@ontip.nl");
   
  $function = basename($_SERVER['SCRIPT_NAME']);
  include('../ontip/mail_stats.php');
    
    
// }// not empty email
} // volgend Mailid  in loop k



} // end if error
?>
<script language="javascript">
		window.location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>');
</script>
</body>
</html>
