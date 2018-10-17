<?php 
header("Content-Type: text/Calendar"); 
header("Content-Disposition: inline; filename=uitnodiging.ics"); 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Database gegevens. 
include('mysql.php');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

$toernooi = $_GET['toernooi'];
//echo $toernooi;

// Querie

$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}



if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
	};
	
//   0123456789
//// 2013-08-07

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

// woordje uur ervan af
$meld_tijd = explode(" ", $meld_tijd);
$meld_tijd = str_replace('.',':', $meld_tijd[0]);


$tijd = explode(":", $meld_tijd);
$uur = $tijd[0];
$minuut = $tijd[1];

if (strlen($uur) == 1 )    { $uur = '0'.$uur; };
if (strlen($minuut) == 1 ) { $minuut = '0'.$minuut; };


/// let op geen Z aan het einde. dat is UTC
//echo "DTSTART:20120908T003000Z\n" . "<br>";
$dtstart = $jaar.$maand.$dag.'T'.$uur.$minuut.'00';
$dtend   = $jaar.$maand.$dag.'T235900';

if (empty($adres)){
$adres = $vereniging;
}

$locatie = explode(";",$adres);
$adres = $locatie[0]." ".$locatie[1]." ".$locatie[2]." ".$locatie[3]." ".$locatie[4].".";

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "�", $vereniging);
$vereniging        = str_replace("&#233", "�", $vereniging);
$vereniging        = str_replace("&#234", "�", $vereniging);
$vereniging        = str_replace("&#235", "�", $vereniging);
$vereniging        = str_replace("&#239", "�", $vereniging);
$vereniging        = str_replace("&#39", "'", $vereniging);


$toernooi_voluit   = str_replace("&#226", "�", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "�", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "�", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "�", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "�", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39", "'", $toernooi_voluit);



//echo $toernooi_voluit. "<br>";

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//This is the most important coding. 

echo "BEGIN:VCALENDAR\n"; 
echo "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n"; 
echo "VERSION:2.0\n"; 
echo "METHOD:PUBLISH\n"; 
echo "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n"; 
echo "BEGIN:VEVENT\n"; 
echo "CLASS:PUBLIC\n"; 
echo "CREATED:20091109T101015Z\n"; 
echo "DESCRIPTION:Sla deze afspraak op als geheugensteuntje via de knop Opslaan boven aan.\n"; 
echo "DTEND:".$dtend."\n"; 
//echo "DTSTAMP:20120908T003000Z\n"; 
//echo "DTSTART:20120918T123000\n"; 
echo "DTSTART:".$dtstart."\n"; 
echo "LAST-MODIFIED:20091109T101015Z\n"; 
echo "LOCATION:".$adres ."\n"; 
echo "PRIORITY:5\n"; 
echo "SEQUENCE:0\n"; 
//echo "SUMMARY;LANGUAGE=en-us:How2Guru Event\n"; 
echo "SUMMARY;LANGUAGE=en-us:".$vereniging. " - Toernooi ". $toernooi_voluit."\n"; 
echo "TRANSP:OPAQUE\n"; 
echo "UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n"; 
echo "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n"; 
echo "X-MICROSOFT-CDO-IMPORTANCE:1\n"; 
echo "X-MICROSOFT-DISALLOW-COUNTER:FALSE\n"; 
echo "X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n"; 
echo "X-MS-OLK-AUTOFILLLOCATION:FALSE\n"; 
echo "X-MS-OLK-CONFTYPE:0\n"; 
//Here is to set the reminder for the event. 
echo "BEGIN:VALARM\n"; 
echo "TRIGGER:-PT1440M\n"; 
echo "ACTION:DISPLAY\n"; 
echo "DESCRIPTION:Reminder\n"; 
echo "END:VALARM\n"; 
echo "END:VEVENT\n"; 
echo "END:VCALENDAR\n"; 
?> 
