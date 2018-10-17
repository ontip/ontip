<html>
	<Title>OnTip verwijderen toernooi (c) Hendrikx</title>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:brown;font-size: 8pt;background-color:blue;color:white;font-weight:bold;}
td {color:brown;font-size: 10pt;background-color:white;}
a    {text-decoration:none;color:blue;font-size: 9pt}
</style>
	</head>
<body>
	
	<?php
ob_start();

// Database gegevens. 
include('mysql.php');
setlocale(LC_ALL, 'nl_NL');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

$date     = date('YmdHis');
$id       = $_POST['Id'];
$keuze    = $_POST['keuze'];
$email    = $_POST['email'];


//echo "id : ".  $id;
$key      = $date . $keuze;

$qry              = mysql_query("SELECT * from config where Id = ".$id." ")     or die(' Fout in select'); 
$result           = mysql_fetch_array( $qry );
$toernooi         = $result['Toernooi'];
$toernooi_voluit  = $result['Waarde'];

/// echo $toernooi;
/// Insert in config bestand met sleutel. Zonder dit record kan niet verwijderd worden

$query_del = "delete from config where Vereniging = '".$vereniging."'  and Toernooi ='".$toernooi."'  and Variabele = 'delete_key' ";
mysql_query($query_del) or die ('Fout in verwijderen delete key'); 


$query = "INSERT INTO `config` (`Id`, `Regel`, `Vereniging`, `Toernooi`,  `Variabele`, `Waarde`,`Laatst` ) 
        VALUES (0, 9999, '".$vereniging."','".$toernooi."' , 'delete_key', '".$key."', NOW())";

mysql_query($query) or die (mysql_error()); 
  
// opvragen ivm uniek record id

$sql        = "SELECT Id from config where Toernooi =  '".$toernooi."' and Variabele = 'delete_key' and Waarde =  '".$key."' ";
//echo $sql;

$result     = mysql_query($sql);
$row        = mysql_fetch_array( $result );
$id         = $row['Id'];  

//  mail versturen

$subject    = 'Bevestiging verwijderen  ';
$subject   .= $toernooi;


/// Ophalen mail tracer
$qry  = mysql_query("SELECT * From mail_trace where Vereniging = '".$vereniging."' ");  
$count=mysql_num_rows($qry);
$trace = 'N';

if ($count > 0) {
	$row          = mysql_fetch_array( $qry );
  $trace        = $row['Trace'];
  $email_tracer = $row['Email'];
}

// email adres is van persoon die is aangelogd
/*
$email = '';

$sql      = mysql_query("SELECT Email FROM namen WHERE  IP_adres = '".$_SERVER['REMOTE_ADDR']."' and  Vereniging = '".$vereniging."' and Aangelogd ='J'  ") or die(' Fout in select email');  
$result   = mysql_fetch_array( $sql );
$email     = $result['Email'];
*/
$to         = $email;

$qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum'")     or die(' Fout in select');  
$result   = mysql_fetch_array( $qry );
$datum    = $result['Waarde'];

// uit vereniging tabel	
    
$qry_v           = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysql_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);

$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         


if ($email == ''){
$to         = $email_organisatie;
}

$url_hostName = $_SERVER['HTTP_HOST'];

// prog_url ../vereniging/

$email_noreply = substr($prog_url,3,-1)."@ontip.nl";
$from = substr($prog_url,3,-1)."@ontip.nl";	
$email_noreply = $email_organisatie;
$email_return  = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Bcc: '. $email_tracer . "\r\n" .
       'Return-Path: '. $from  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
    $headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}
$headers  .= "\r\n";


$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:verdana;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";
$bericht .= "<br><br><h3><u>Verwijdering toernooi</u></h3>".   "\r\n";

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "Beste <br><br>" .  "\r\n";
$bericht .= "U heeft aangegeven het toernooi <b>".$toernooi." </b> te willen verwijderen uit het OnTip systeem.<br><br>" .  "\r\n";

switch ($keuze) {
		case "1":  
         $bericht .= "<b>Zowel configuratie als inschrijvingen worden verwijderd.</b><br><br>" .  "\r\n";		
         break; 
		case "2":  
				 $bericht .= "<b>Alleen inschrijvingen worden verwijderd.</b><br><br>" .  "\r\n";	
          break; 
  }// end switch


$url_hostName = $_SERVER['HTTP_HOST'];
$url          = $url_hostName."/".substr($prog_url,3);


$bericht .= "Klik op de onderstaande link om het toernooi te verwijderen :<br> " . "\r\n";
$bericht .= "<a href = 'http://www.ontip.nl/".substr($prog_url,3)."delete_toernooi.php?id=". $id ."&key=".$key."'>Verwijder ".$toernooi."</a>";
$bericht .= "</div>";
$bericht .= "<hr/><div style= 'style= 'font-family:verdana;font-size:7pt;color:black;padding-top:20pt;'><br><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx ".date('Y ')."</div>" . "\r\n";


//echo $to;
//echo $headers;

//echo $bericht;


mail($to, $subject, $bericht, $headers);

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Verwijderen toernooi - <?php echo  $toernooi_voluit; ?>";
</script> 



<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<table width=99%><tr>
	<td style='text-align:left;'><a href='index.php'>Terug naar Hoofdmenu</a></td>
	<td style='text-align:right;'><a href='select_verwijderen.php'>Nog een toernooi verwijderen</a></td>
</tr>
</table>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Verwijderen toernooi  <img src='../ontip/images/prullenbak.jpg' width =75 border =0></h3>

<br>
<?php
echo "<div style='font-size:12pt;font-weight:bold;color:black;'>"; 
echo "De mail ter bevestiging van het verwijderen van het <span style='color:brown;font-size:16pt;'>".$toernooi." </span> toernooi is verstuurd naar <span style='color:blue;'>".$email.".</span><br><br></div> ";
echo "Open de mail en klik op de link om het verwijderen te bevestigen. Dit moet gebeuren binnen een half uur na verzending van de mail.</br>"; 
ob_end_flush();
?>
</body>
</html>