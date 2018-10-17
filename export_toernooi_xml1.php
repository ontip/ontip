<?php
$toernooi = $_GET['toernooi'];
$date = date('Y-m-d');
header("Content-type: application/xml");
header("Content-Disposition: attachment; filename=\"import_toekan_".$date."_".$toernooi.".xml\"");

// Database gegevens. 
include('mysql.php');	
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

ob_start();
//
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Querie

$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($result = mysql_fetch_array( $qry )) {
	
	 $var = $result['Variabele'];
	 $$var = $result['Waarde'];
	}

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);


// met parameters
$qry        = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and variabele = 'meld_tijd' ")     or die(' Fout in select');  
$row        = mysql_fetch_array( $qry);
$meld_tijd  = $row['Waarde'];
$parameter  = explode('#', $row['Parameters']);
$suffix     = $parameter[1];

switch ($suffix){
	case "1": $melden = 'voor '. $meld_tijd;break;
	case "2": $melden = 'vanaf '. $meld_tijd;break;
}
	
$variabele = 'kosten_team';
 $qry1      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $row       = mysql_fetch_array( $qry1);
 $parameter  = explode('#', $row['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];

 if ($kosten_eenheid == '1' ){
     $kosten_eenheid =  " per persoon";
    } else {
     $kosten_eenheid =   " per team";
}
 
 if ($euro_ind == 'm') {
    $kosten_team  = 'Eur '. $row['Waarde']  ;
}
else {
	  $kosten_team  = $row['Waarde']    ;
}

$qry2               = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select ver');  
 $row2              = mysql_fetch_array( $qry2);
 $contact_persoon   = $row2['Naam_contactpersoon'];
 $plaats            = $row2['Plaats'];
 $_vereniging_nr    = $row2['Vereniging_nr'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//echo $toernooi;

$today = date( 'Y-m-d');

echo "<?xml version='1.0' encoding='UTF-8'?>"."\r\n";
echo "<!-- Toekan xml toernooi configuratie tbv insert toekan kalender . Created by export_toernooi_xml.php -->"."\r\n";
echo "<ontip>"."\r\n";
echo "<create_xml>".$today."</create_xml>"."\r\n";
echo "<author_toekan>Erik Hendrikx</author_toekan>"."\r\n";
echo "<vereniging>"."\r\n";
echo "<naam>".$vereniging."</naam>"."\r\n";
echo "<id>".$vereniging_nr."</id>"."\r\n";
echo "<url_vereniging>".$url_website."</url_vereniging>"."\r\n";
echo "</vereniging>"."\r\n";
echo "<toernooi>"."\r\n";
echo "<naam>".$toernooi."</naam>"."\r\n";
echo "<datum>".$datum."</datum>"."\r\n";
echo "<soort_toernooi>".$soort_inschrijving."</soort_toernooi>"."\r\n";
echo "<cat_toernooi></cat_toernooi>"."\r\n";
echo "<systeem_toernooi>".$result['Systeem_toernooi']."</systeem_toernooi>"."\r\n";
echo "<contact_persoon>".$contact_persoon."</contact_persoon>"."\r\n";
echo "<adres_locatie>".$adres."</adres_locatie>"."\r\n";
echo "<plaats>".$plaats."</plaats>"."\r\n";
echo "<tel_locatie></tel_locatie>"."\r\n";
echo "<email_info>".$email_organisatie."</email_info>"."\r\n";
echo "<inschrijven_vanaf>".$begin_inschrijving."</inschrijven_vanaf>"."\r\n";
echo "<inschrijven_tot>".$einde_inschrijving."</inschrijven_tot>"."\r\n";
echo "<licentie>".$licentie_jn."</licentie>"."\r\n";
echo "<kosten>".$kosten_team."</kosten>"."\r\n";
echo "<kosten_eenheid>".$kosten_eenheid."</kosten_eenheid>"."\r\n";
echo "<prijzen>".$prijzen."</prijzen>"."\r\n";
echo "<min_aantal>".$min_splrs."</min_aantal>"."\r\n";
echo "<max_aantal>".$max_splrs."</max_aantal>"."\r\n";
echo "<melden_toernooi>".$melden."</melden_toernooi>"."\r\n";
echo "<aanvang_toernooi>".$aanvang_tijd."</aanvang_toernooi>"."\r\n";
echo "<ontip_gebruik>J</ontip_gebruik>"."\r\n";
echo "</toernooi>"."\r\n";
echo "</ontip>"."\r\n";
?>
</html>
