<?php
$subject = 'Importeren inschrijvingen ';
$subject .= $toernooi_voluit; 

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);      

if(isset($_COOKIE['user'])){ 
	$user = $_COOKIE['user'];
}

$to   = $email_organisatie .  ', '; // note the comma
$to  .= $email_cc;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: '. $email_noreply  . "\r\n" . 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>Import inschrijvingen</u></h3>".   "\r\n";

switch($soort_inschrijving){
  	         	case "single":  $soort = "m?e";     break;
  	          case "doublet": $soort = "doublet"; break;
  	          case "triplet": $soort = "triplet"; break;
  	          case "kwintet": $soort = "kwintet"; break;
  	          case "sextet":  $soort = "sextet";  break;
  	}// end switch

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>";
$bericht .= "Beste ".$user . ",<br><br>" .  "\r\n";
$bericht .= "De volgende ".$soort." inschrijvingen zijn door u geimporteerd : <br></div><br>";
$i=1;
$bericht .= "<table border =1>"   . "\r\n";

//// kopteksten

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

$i=1;

foreach($uploads as $line){

	
$parts = explode (";", $line);

$nr           =   $parts[0];
$naam1        =   $parts[1];
$licentie1    =   $parts[2];
$vereniging1  =   $parts[3];

$naam2        =   $parts[4];
$licentie2    =   $parts[5];
$vereniging2  =   $parts[6];

$naam3        =   $parts[7];
$licentie3    =   $parts[8];
$vereniging3  =   $parts[9];

$naam4        =   $parts[10];
$licentie4    =   $parts[11];
$vereniging4  =   $parts[12];

$naam5        =   $parts[13];
$licentie5    =   $parts[14];
$vereniging5  =   $parts[15];

$naam6        =   $parts[16];
$licentie6    =   $parts[17];
$vereniging6  =   $parts[18];
	
$email        =   $parts[19];
$telefoon     =   $parts[20];

$bericht .= "<tr>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;text-align:right;'>"   . $i. ".</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam1. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $vereniging1. "</td>". "\r\n";

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
  $bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>" . $naam2. "</td>". "\r\n";
  $bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>" . $vereniging2. "</td>". "\r\n";
 }
 
if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam3. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $vereniging3. "</td>". "\r\n";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam4. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $vereniging4. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam5. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $vereniging5. "</td>". "\r\n";
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $naam6. "</td>". "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:9pt;color:black;'>"   . $vereniging6. "</td>". "\r\n";
}

$bericht .= "</tr>"   . "\r\n";
$i++;
} // foreach


$bericht .= "</table>"   . "\r\n";
$bericht .= "<div style= 'font-family:verdana;font-size:8pt;color:brown;padding-top:20pt;'><hr/>(Deze mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx ".date('Y').") </div>" . "\r\n";

//echo $bericht;

mail($to, $subject, $bericht, $headers);
?>