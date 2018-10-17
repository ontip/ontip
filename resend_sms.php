<?php
include('mysql.php');
include ('versleutel_kenmerk.php'); 

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

setlocale(LC_ALL, 'nl_NL');

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

// uit vereniging tabel	
    
$qry_v             = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v          = mysql_fetch_array( $qry_v);
$vereniging_id     = $result_v['Id'];
$url_logo          = $result_v['Url_logo']; 
$trace             = $result_v['Mail_trace'];
$verzendadres_sms  = $result_v['Verzendadres_SMS'];
  

// Alle sms ids  zijn in 1 keer doorgegeven

$sms_all = $_GET['Id'];
$smsid = explode(";", $sms_all);

$toernooi = $_POST['toernooi'];
$replace  = "toernooi=".$toernooi."";

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

/// aanmaken sms berichten 
   
for ($k=0;(!empty($smsid[$k]));$k++){

	$qry      = mysql_query("SELECT * from inschrijf where Id= '".$smsid[$k]."' " )    or die('Fout in select Id');  
  $row      = mysql_fetch_array( $qry);

  $Telefoon     = $row['Telefoon'];
  $Laatst       = $row['Inschrijving'];
  $datum        = $row['Datum'];
  $Naam1        = $row['Naam1'];
  $Vereniging1  = $row['Vereniging1'];

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
$kenmerk  = 'HERZEND:'.substr($encrypt,0,4).".".substr($encrypt,4,4);

if ($verzendadres_sms !='' and $Telefoon !=''  ) {
	
$to          = $Telefoon."@sms.messagebird.com";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$email_noreply = $email_organisatie;

$headers .= 'From: '. $verzendadres_sms  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();

$headers  .= "\r\n";
$subject   = "OnTipSMS";     /// Verzender SMS
      
$sms_bericht = "";    
 $dag    = substr ($datum , 8,2);         
$maand  = substr ($datum , 5,2);         
$jaar   = substr ($datum , 0,4);     

     
if ($uitgestelde_bevestiging_jn == 'J'){       
$sms_bericht .= "Hierbij bevestigen we uw voorlopige inschrijving voor het '". $toernooi_voluit. "'  op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";
}       
else {            
$sms_bericht .= "Hierbij bevestigen we uw inschrijving voor het ". $toernooi_voluit. "  op ".strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ). ".  ". "\r\n";

}       

// Maximaal 320 karakters versturen. Anders worden 3 berichten afgerekend. 160 lang is 1 bericht. 320 is 2 berichten. Wordt mee gerekend in sms_tegoed
 $sms_bericht        = substr($sms_bericht,0,319)  . "\r\n";    
 $sms_bericht_lengte = strlen($sms_bericht); 
  
/// verstuur sms     
 mail($to, $subject, $sms_bericht, $headers);
 
 // leg vast in tabel
 $query = "INSERT INTO sms_confirmations(Id, Toernooi, Vereniging,Vereniging_id, Datum, Verzender,
                                Naam, Vereniging_speler, Telefoon, Kenmerk,Lengte_bericht, Laatst)
               VALUES (0,'".$toernooi."', '".$vereniging ."'   , ".$vereniging_id.", '".$datum."','".$verzendadres_sms."' ,
                         '".$Naam1."'   ,  '".$Vereniging1."'  , '".$Telefoon."', '".$kenmerk."',".$sms_bericht_lengte."  , NOW()   )";
//echo $query;
mysql_query($query) or die (mysql_error()); 



} // verzendadres_sms

} // volgend Mailid  in loop k



} // end if error
?>
<script language="javascript">
		window.location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>');
</script>
	
