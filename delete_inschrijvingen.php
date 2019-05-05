<?php
# delete_inschrijvingen.php
#
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

# 5mei2019          1.0.2           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               PHP7.
# Feature:           None.
# Reference: 


?><html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>		
		<?php 
ob_start();

$toernooi   = $_POST['toernooi'];
$replace    = "toernooi=".$toernooi."";
$Aantal     =  $_POST['Aantal'];
$challenge  =  $_POST['challenge'];
$respons    =  $_POST['respons'];
$notificaties   =  $_POST['notificaties'];

// Controles
$error   = 0;
$message = '';

/*
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
*/

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
  
<?php
 } // error = 1
 
 

//echo "Aantal : " . $Aantal;

// Database gegevens. 
include('mysqli.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include ('../ontip/versleutel_string.php'); // tbv telnr en email

include('page_stats.php');


if ($error == 0){

for ($i=1;$i<= $Aantal;$i++){
		
		
	$id         = $_POST['Del-'.$i];     
	
  $sql        = mysqli_query($con,"SELECT * from inschrijf where Id = ".$id." ")     or die(' Fout in select: '.$id);  
  $result     = mysqli_fetch_array( $sql );
  
  
  $naam1[$i]        = $result['Naam1'];
  $naam2[$i]        = $result['Naam2'];
  $naam3[$i]        = $result['Naam3'];
  $naam4[$i]        = $result['Naam4'];
  $naam5[$i]        = $result['Naam5'];
  $naam6[$i]        = $result['Naam6'];
  $toernooi         = $result['Toernooi'];
  $ver_naam1[$i]    = $result['Vereniging1'];
  $ver_naam2[$i]    = $result['Vereniging2'];
  $ver_naam3[$i]    = $result['Vereniging3'];
  $ver_naam4[$i]    = $result['Vereniging4'];
  $ver_naam5[$i]    = $result['Vereniging5'];
  $ver_naam6[$i]    = $result['Vereniging6'];
     
	//echo " Te verwijderen : " . $id."<br>";

	
  mysqli_query($con,"DELETE FROM inschrijf where Id= ".$id." ");

// ook uit hulp_naam

mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam1[$i]."'  ") ;  
mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam2[$i]."'  ") ;  
mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam3[$i]."'  ") ;  
mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam4[$i]."'  ") ;  
mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam5[$i]."'  ") ;  
mysqli_query($con,"Delete from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and  Naam = '".$naam6[$i]."'  ") ;  


}

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}



// uit vereniging tabel	
    
$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 


if (!isset($email_notificaties_jn)){
	$email_notificaties_jn ='N';
} 
   
 



/////////////////////////////////////////////////////////////////////////////////////////////////////
//  mail versturen

$subject = 'Verwijdering inschrijvingen ';
$subject .= $toernooi_voluit; 

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);      

$ip       = $_SERVER['REMOTE_ADDR'];
$sql      = mysqli_query($con,"SELECT * FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select mail from namen') ;
$result   = mysqli_fetch_array( $sql );
$user     = $result['Naam'];
$email    = $result['Email'];
$to       = $email;

if ($email == ''){
$to         = $email_organisatie;
}


/// tbv migratie
$url_hostName = $_SERVER['HTTP_HOST'];
$from = substr($prog_url,3,-1)."@ontip.nl";	


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
         'Return-Path: '. $from  . "\r\n" . 
         'Reply-To: '. $from  . "\r\n" . 
         'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Verwijdering inschrijvingen</u></h3>".   "\r\n";

switch($soort_inschrijving){
  	         	case "single":  $soort = "mêlée";     break;
  	          case "doublet": $soort = "doublet"; break;
  	          case "triplet": $soort = "triplet"; break;
  	          case "kwintet": $soort = "kwintet"; break;
  	          case "sextet":  $soort = "sextet";  break;
  	}// end switch

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>";
$bericht .= "Beste ,<br><br>" .  "\r\n";
$bericht .= "De volgende ".$soort." inschrijvingen zijn door u verwijderd : <br></div><br>";
$i=1;
$bericht .= "<table border =1>"   . "\r\n";

//// kopteksten

 // Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$bericht .= "<tr>"   . "\r\n";
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;'></th>"   . "\r\n";
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 1</th>"   . "\r\n";

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single'  ){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 2</th>"   . "\r\n";
}


if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 3</th>"   . "\r\n";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 4</th>"   . "\r\n";
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 5</th>"   . "\r\n";
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =2>Speler 6</th>"   . "\r\n";
}
$bericht .= "</tr>"   . "\r\n";

$bericht .= "<tr>"   . "\r\n";
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;'>Nr.</th>"   . "\r\n";

$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";

if ($soort_inschrijving !='single' and $inschrijf_methode  != 'single'){
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";

}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
  $bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";

}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
  $bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";
  $bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
  $bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single'){
	$bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Naam</th>"   . "\r\n";
  $bericht .= "<th style= 'font-family:verdana;font-size:9pt;color:blue;' colspan =1>Vereniging</th>"   . "\r\n";
}
$bericht .= "</tr>"   . "\r\n";

/// detail regels

for ($i==1;$i<= $Aantal;$i++){

$bericht .= "<tr>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;text-align:right;'>"   . $i. ".</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam1[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam1[$i]. "</td>". "\r\n";

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
  $bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam2[$i]. "</td>". "\r\n";
  $bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam2[$i]. "</td>". "\r\n";
 }
 
if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam3[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam3[$i]. "</td>". "\r\n";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam4[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam4[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam5[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam5[$i]. "</td>". "\r\n";
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam6[$i]. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $ver_naam6[$i]. "</td>". "\r\n";
}

$bericht .= "</tr>"   . "\r\n";

}
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><div style= 'style= 'font-family:verdana;font-size:9pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx ".date('Y ')."</div>" . "\r\n";


//echo $bericht;

mail($to, $subject, $bericht, $headers);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// send email notificatie

if 	($email_notificaties_jn =='J'   and $notificaties !='' ){

	echo "<br>Max aantal spelers : ".$max_splrs;
	echo "<br>Aantal reserves    : ".$aantal_reserves;
	
$qry                = mysqli_query($con,"SELECT * from inschrijf where Toernooi = '".$toernooi."' and Vereniging_id = ".$vereniging_id."  ")    or die(' Fout in select inschrijf count' ); 
$aantal_deelnemers  = mysql_num_rows($qry);

	echo "<br>Aantal deelnemers    : ".$aantal_deelnemers;
	
/// als aantal deelnemers < max spelers en reserves = 0 	
if ($aantal_deelnemers < $max_splrs  and $aantal_reserves  == 0){


  // Ophalen notificatie gegevens
   
   $qry             = mysqli_query($con,"SELECT * From email_notificaties where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Ingeschreven ='N'  ")     or die(' Fout in select notificaties');  
    while($row = mysqli_fetch_array( $qry )) {

   $id               = $row['Id'];
   $naam             = $row['Naam'];
   $email            = $row['Email'];
   $email_encrypt    = $row['Email_encrypt'];
   $licentie         = $row['Licentie'];
   $kenmerk          = $row['Notificatie_kenmerk'];
     
   if ($email =='[versleuteld]'){ 
    $email    = versleutel_string($email_encrypt);    
   }
   
      echo "Notificatie naar ".$naam."- ".$email;
   
    // aanmaak email bericht
    $from = $subdomein."@ontip.nl";	
    
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset="UTF-8"' . "\r\n";
    $email_noreply = $email_organisatie;
    $email_return  = $email_organisatie;
    
    $headers .= 'From: OnTip '. $subdomein. ' <'.$from.'>' . "\r\n" .	 
           'Return-Path: '. $email_return  . "\r\n" . 
           'Reply-To: '. $email_organisatie . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
    $headers  .= "\r\n";
    
    $subject  = 'Email notificatie '.$toernooi_voluit;
    
    $bericht = "<table>"   . "\r\n";
    $bericht .= "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";
    $bericht .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
    $bericht .= "</table>"   . "\r\n";
    $bericht .= "<br><hr/>".   "\r\n";
    $bericht .= "<h3 style='font-family:verdana;font-size:10pt;color:black;'><u>Email notificatie</u></h3>".   "\r\n";
    
    $bericht .= "<br><span style='font-family:verdana;font-size:10pt;color:black;'>U ontvangt deze Email notificatie omdat er een plek is vrijgekomen voor onderstaand toernooi.  </span><br>".   "\r\n";
    
    $bericht .= "<br><table  Style='font-family:verdana;font-size:9pt;border-collapse: collapse;background-color:white;padding:5pt;border-color:darkgrey;'>"   . "\r\n";
    $bericht .= "<tr><td  width=200>Toernooi  </td><td colspan = 2>"          .  $toernooi_voluit       ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Max deelnemers </td><td colspan = 2>"     .  $max_splrs       ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Huidig aantal  </td><td colspan = 2>"     .  $aantal_deelnemers      ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Naam  </td><td colspan = 2>"              .  $naam                  ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Email      </td><td colspan = 2>"         .  $email                 ."</td></tr>".  "\r\n";
    $bericht .= "<tr><td  width=200>Kenmerk notificatie   </td><td colspan = 2>"    .  $kenmerk        ."</td></tr>".  "\r\n";
    $bericht .= "</table>"   . "\r\n";
    $bericht .= "<br><br><span style='font-family:verdana;font-size:10pt;color:black;font-weight:bold;'>Klik op onderstaande link om u in te schrijven.</span>".   "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:10pt;color:red;'><a href='https://www.ontip.nl/".substr($prog_url,3)."Inschrijf_form.php?toernooi=".$toernooi."&email_notificatie=".$kenmerk."'>Klik op deze link</a></div>" . "\r\n";
    
    $bericht .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'https://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";
    

  ///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
    if ($email != $email_organisatie){
      	$_subject = "=?utf-8?b?".base64_encode($subject)."?=";
        mail($email, $_subject, $bericht, $headers,"-finfo@ontip.nl");
     }

}// end while

}  // end if aantal deelnemers < max spelers


} // end email_notificaties

} // error =0

?>
	<script language="javascript">
		window.location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>');
</script>
<?php

ob_end_flush();
?>
</body> 