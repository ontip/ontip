<html>
<head>
<meta http-equiv="refresh">
<title>Export toernooi xml</title>
<link rel="shortcut icon" type="image/x-icon" href="images/Calendar.ico">
<link rel="stylesheet" type="text/css" href="toekan.css">
</head>

<body >


<?php 
// Database gegevens. 
include('mysqli.php');	
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


$pageName = basename($_SERVER['SCRIPT_NAME']);
//include('page_stats.php');



ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}


if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}
if (isset($_GET['toernooi'])){
 	  $toernooi= $_GET['toernooi'];
} // end get_html_translation_table(HTML_ENTITIES, ENT_NOQUOTES)
// Querie

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($result = mysqli_fetch_array( $qry )) {
	
	 $var = $result['Variabele'];
	 $$var = $result['Waarde'];
	}

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);


// met parameters
$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and variabele = 'meld_tijd' ")     or die(' Fout in select');  
$row  = mysqli_fetch_array( $qry);
$meld_tijd  = $row['Waarde'];
$parameter = explode('#', $row['Parameters']);
$suffix    = $parameter[1];

switch ($suffix){
	case "1": $melden = 'voor '. $meld_tijd;break;
	case "2": $melden = 'vanaf '. $meld_tijd;break;
}
	
$variabele = 'kosten_team';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $row       = mysqli_fetch_array( $qry1);
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

$qry2      = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select ver');  
 $row2       = mysqli_fetch_array( $qry2);
 $contact_persoon   = $row2['Naam_contactpersoon'];
 $plaats            = $row2['Plaats'];
 $_vereniging_nr   = $row2['Vereniging_nr'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
	
	
<body >
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
<tr><td STYLE ='font-size: 24pt; color:red'><?php echo $toernooi_voluit ?><br>
	<?php   	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?> 
	
	</TD></tr>
</TABLE>
</div>
<hr color='red'/>

 <h1 >Exporteren toernooi informatie (XML)</h1>
 
 <?php



//echo "Create xml voor ". $toernooi."<br>";


	

//echo $toernooi;


 if (strpos($vereniging_nr, '-') > 0 ){
  	  $_vereniging_nr = substr($vereniging_nr,0,2).substr($vereniging_nr,-3);  
 }   
 
//// spaties vervangen door _	
$toernooi_xml_repl =   str_replace (" ","_",$toernooi);

$today = date("Y-m-d h:i:s");
 
// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="xml/".$_vereniging_nr."_".$datum."_".$toernooi_xml_repl.".xml";
$fp       = fopen($xml_file, "w");
fclose($fp);

$today = date( 'Y-m-d');


$fp = fopen($xml_file, "a");

fwrite($fp, "<?xml version='1.0' encoding='UTF-8'?>\n");
fwrite($fp, "<!-- Toekan xml toernooi configuratie tbv insert toekan kalender . Created by export_toernooi_xml.php -->\n");
fwrite($fp, "<ontip>\n");
fwrite($fp, "<create_xml>".$today."</create_xml>\n");
fwrite($fp, "<author_toekan>Erik Hendrikx</author_toekan>\n");
fwrite($fp, "<vereniging>\n");
fwrite($fp, "<naam>".$vereniging."</naam>\n");
fwrite($fp, "<id>".$vereniging_nr."</id>\n");
fwrite($fp, "<url_vereniging>".$url_website."</url_vereniging>\n");
fwrite($fp, "</vereniging>\n");
fwrite($fp, "<toernooi>\n");
fwrite($fp, "<naam>".$toernooi."</naam>\n");
fwrite($fp, "<datum>".$datum."</datum>\n");
fwrite($fp, "<soort_toernooi>".$soort_inschrijving."</soort_toernooi>\n");
fwrite($fp, "<cat_toernooi></cat_toernooi>\n");
fwrite($fp, "<systeem_toernooi>".$result['Systeem_toernooi']."</systeem_toernooi>\n");
fwrite($fp, "<contact_persoon>".$contact_persoon."</contact_persoon>\n");
fwrite($fp, "<adres_locatie>".$adres."</adres_locatie>\n");
fwrite($fp, "<plaats>".$plaats."</plaats>\n");
fwrite($fp, "<tel_locatie></tel_locatie>\n");
fwrite($fp, "<email_info>".$email_organisatie."</email_info>\n");
fwrite($fp, "<inschrijven_vanaf>".$begin_inschrijving."</inschrijven_vanaf>\n");
fwrite($fp, "<inschrijven_tot>".$einde_inschrijving."</inschrijven_tot>\n");
fwrite($fp, "<licentie>".$licentie_jn."</licentie>\n");
fwrite($fp, "<kosten>".$kosten_team."</kosten>\n");
fwrite($fp, "<kosten_eenheid>".$kosten_eenheid."</kosten_eenheid>\n");
fwrite($fp, "<prijzen>".$prijzen."</prijzen>\n");
fwrite($fp, "<min_aantal>".$min_splrs."</min_aantal>\n");
fwrite($fp, "<max_aantal>".$max_splrs."</max_aantal>\n");
fwrite($fp, "<melden_toernooi>".$melden."</melden_toernooi>\n");
fwrite($fp, "<aanvang_toernooi>".$aanvang_tijd."</aanvang_toernooi>\n");
fwrite($fp, "<ontip_gebruik>J</ontip_gebruik>\n");
fwrite($fp, "</toernooi>\n");
fwrite($fp, "</ontip>\n");

fclose($fp);

?>
<blockquote>
 <div style='color:black;font-size:11pt;text-align:left;font-family:verdana;'>De toernooi informatie van <?php echo $toernooi;?> is opgeslagen onder naam <b><?php echo $toernooi_xml_repl; ?></b>.<br>

<a href = "<?php echo $xml_file;?>" target ="_blank">Klik hier voor file</a> 
Via 'Restore toernooi backup'  kan deze weer teruggehaald worden.</div>
<br>
</blockquote>
<pre>
	
	
	
	
	
</pre>

<div style='text-align:right;font-size:9pt;color:darkgrey;'><?php echo  basename($_SERVER['SCRIPT_NAME']);?></div>
</body>

</html>
