<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*  Programma       : Prepare_ideal_betaling.php
    Auteur          : Erik Hendrik okt 2013
    
    Programma voor het aanmaken van een ideal betaling om een inschrijving te betalen.
    Maakt gebruik van de php interface gebouwd door Mollie. 
    
    Parameters : toernooi  <korte naam toernooi>
                 id        Id van het record uit tabel inschrijf.
               
    Met behulp van de get parameters worden de gegevens van de vereniging, het toernooi en het Mollie partner id opgehaald en via POST doorgegeven.            
    Prepare_ideal_betaling roept zich zelf aan en leest dan de post parameters in.
    
    Via een selectie wordt de bank van de gebruiker geselecteerd.    
    
  18 apr 2018  aanpassing return url naar ideal_betaling_gedaan.php
           
    
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
                                                                         */
?>
<html>
	<Title>OnTip IDEAL betaling (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">      
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">              
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 8.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:green ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:red;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
</style>
</head>
<body>
	
<?php
$toernooi      = $_GET['toernooi'];
$id            = $_GET['id'];
$start         = $_GET['start'];

// als deze gestart is vanuit betaal_inschrjving_stap1.php  11 nov 2016
$challenge     = $_POST['challenge'];
$respons       = $_POST['respons'];


$bank_id       = $_POST['bank_id'];
$email         = $_POST['email'];


$respons       = $_POST['respons'];
if (!isset($toernooi)) {
		$message .= "*Parameter fout: Geen toernooi bekend.<br>";
		$error = 1;
};

if (!isset($id)) {
		$message .= "* Parameter fout:Geen inschrijf Id bekend.<br>";
		$error = 1;
};

if ($bank_id =='' and $start =='J') {
		$message .= "* Er is geen bank geselecteerd.<br>";
		$error = 1;
};

if ($email =='' and $start =='J') {
		$message .= "* Er is geen email adres ingevuld.<br>";
		$error = 1;
};


$check=$_POST['Check'];
if ($check ==''  and $start =='J' ){
	  $message .= "* U dient een vinkje te zetten bij de regel 'ik ga akkoord met onderstaande voorwaarden'.<br>";
		$error = 1;
};


if ($challenge != $respons){
	$message .= "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
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
 
 
setlocale(LC_ALL, 'nl_NL');

require_once "mysql.php";
include ('../ontip/versleutel_string.php'); // tbv telnr en email


//// ophalen gegevens vereniging
$qry1          = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select1');  
$result1       = mysql_fetch_array( $qry1 );
$prog_url      = $result1['Prog_url'];
$partner_id    = $result1['Ideal_partner_id']; // Uw mollie partner ID
$profile_key   = '5832B57A';
$url_website  = $result1['Url_website'];
$app_secret    = '10720A88419431792C629AD1EA7DC55E747BE378'; 

if ($partner_id =='') {
	echo "Mollie partner ID onbekend ! IDEAL betalen is niet mogelijk voor dit toernooi.<br>";
	exit;
}

$var     = "ideal_betaling_jn"; 
$qry     = mysql_query("SELECT * from config where  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = '".$var."'  ")           or die(' Fout in select 1');  
$result  = mysql_fetch_array( $qry);
$count   = mysql_num_rows($qry);

if ($count < 1){
	echo "Parameter fout: Opgegeven toernooi niet bekend.<br>";
	exit;
}

$parameter  = explode('#', $result['Parameters']);
$test_mode            = $parameter[1];
$ideal_opslag_kosten  = $parameter[2];

if ($result['Waarde'] != 'J') {
	echo "Via IDEAL betalen is uitgeschakeld voor dit toernooi.<br>";
	exit;
}

// Ophalen overige toernooi gegevens
$var              = 'toernooi_voluit';
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
$soort              = $soort_inschrijving;

if ($soort =='single'){
    $soort          = 'mêlee';
}


//require_once "../ontip/mollie_ideal/Payment.php"; 
require_once "ideal_payment.php"; 
include ('versleutel_kenmerk.php'); 
?>
	
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<!--span style='text-align:right;'><a href='<?php echo $url_website; ?>'>Naar de deelnemerslijst</a></span-->	
<?php



// inschrijving ophalen
// Kenmerk is het resultaat van de versleuteling (versleutel_kenmerk.php) van min.sec.dag.uur (veld inschrijving).

$qry3               = mysql_query("SELECT * From inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Id = '".$id."' ")     or die(' Fout in select3');  
$result3            = mysql_fetch_array( $qry3 );
$date               = $result3['Inschrijving'];
$naam1              = $result3['Naam1'];
$email              = $result3['Email'];
$Email_encrypt     = $result['Email_encrypt'];
 
 if ($email =='[versleuteld]'){ 
$email           = versleutel_string($Email_encrypt);    
}


$bankrekening       = $result3['Bank_rekening'];
$inschrijf_status   = $result3['Status'];
$betaal_datum       = $result3['Betaal_datum'];

$dag                = substr ($date , 8,2);         
$maand              = substr ($date , 5,2);         
$jaar               = substr ($date , 0,4);     
$uur                = substr ($date , 11,2);     
$minuut             = substr ($date , 14,2);     
$sec                = substr ($date , 17,2);     
$_kenmerk           = $minuut.$sec.$dag.$uur;

/// roep versleutel kennmerk routine aan
/// versleutel_licentie($waarde, $richting, $delta)

$encrypt  = versleutel_kenmerk($_kenmerk,'encrypt', 20);
$kenmerk  = substr($encrypt,0,4).".".substr($encrypt,4,4);

$ideal_kenmerk = 'ONTIP kenmerk:'.$kenmerk;

$var              = 'kosten_team';
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$var."' ")     or die(' Fout in select2');  
$result2          = mysql_fetch_array( $qry2 );
$kosten_team      = trim($result2['Waarde']);
$parameter        = explode('#', $result2['Parameters']);
 
$euro_ind        = $parameter[1];
$kosten_eenheid  = $parameter[2];  // 1 = pp , 2 = per team

//// vervang . voor kommma tbv rekenen. Niet bij ideal opslg
$kosten_team               = str_replace(".", ",", $kosten_team);
$ideal_opslag_kosten       = str_replace(".", ",", $ideal_opslag_kosten);
//$ideal_opslag_kosten         = intval($ideal_opslag_kosten );

// $ideal_opslag_kosten = 0.10;


/// omrekenen totale kosten adhv kosten_eenheid

if ($kosten_eenheid == 1) {
  switch ($soort_inschrijving){
  	 case 'single'  : $totale_kosten  =  $kosten_team; break;
  	 case 'doublet' : $totale_kosten  = ($kosten_team*2);break;
	   case 'triplet' : $totale_kosten  = ($kosten_team*3);break;
	   case 'kwintet' : $totale_kosten  = ($kosten_team*6);break;
  } // end switch	 

}
else { 
	$totale_kosten = $kosten_team;
} /// kosten eenheid = 1

//$ideal_opslag_kosten = 0.6;

// weer terug van punt naar komma 
$totale_kosten               = str_replace(",", ".", $totale_kosten);


if ($ideal_opslag_kosten > 0 ) { 
    $totale_kosten = $totale_kosten + $ideal_opslag_kosten;
}

// in eurocenten
$amount = $totale_kosten * 100;
 
echo  "<br>xxxxT xxxxxxxxxxxx".$totale_kosten;
//settype($amount, "integer");



$return_url    = "http://www.ontip.nl/".substr($prog_url,2,strlen($prog_url))."ideal_betaling_gedaan.php?toernooi=".$toernooi."&kenmerk=".$kenmerk.""; // URL waarnaar de consument teruggestuurd wordt na de betaling
$report_url    = "http://www.ontip.nl/".substr($prog_url,2,strlen($prog_url))."ideal_report.php";          // URL die Mollie aanvraagt (op de achtergrond) na de betaling om de status naar op te sturen

if (!in_array('ssl', stream_get_transports()))
{
	echo "<h1>Foutmelding</h1>";
	echo "<p>Uw PHP installatie heeft geen SSL ondersteuning. SSL is nodig voor de communicatie met de Mollie iDEAL API.</p>";
	exit;	
}

///*              Ophalen van de POST parameters                             */

$iDEAL = new Mollie_iDEAL_Payment ($partner_id);

/// aanpassen voor productie

if ($test_mode == 'PROD'){
	$iDEAL->setTestMode(False);
} 
ELSE {
  $iDEAL->setTestMode(True);
}

if (isset($_POST['amount']))       { 	    $amount       = $_POST['amount'];   	      }
if (isset($_POST['kenmerk']))      {      $kenmerk      = $_POST['kenmerk'];    	    }
if (isset($_POST['toernooi']))     {  	  $toernooi     = $_POST['toernooi'];   	    }
if (isset($_POST['email']))        {  	  $email        = $_POST['email'];      	    }
if (isset($_POST['bankrekening'])) {  	  $bankrekening = $_POST['bankrekening'];	    }  
   
$description   = $ideal_kenmerk;

//echo "==========================================================<br>";
//echo "Amount : ". $amount."<br>";
//echo "Descr  :  ". $description."<br>";
//echo "Return :  ". $return_url."<br>";
//echo "Report :  ". $report_url."<br>";
//echo "==========================================================<br>";

if (isset($_POST['bank_id']) and !empty($_POST['bank_id']) and !empty($_POST['email'])   ) 
{
	if ($iDEAL->createPayment($_POST['bank_id'],$amount, $description, $return_url, $report_url)) 
	{
		/* Hier kunt u de aangemaakte betaling opslaan in uw database, bijv. met het unieke transactie_id
		   Het transactie_id kunt u aanvragen door $iDEAL->getTransactionId() te gebruiken. Hierna wordt 
		   de consument automatisch doorgestuurd naar de gekozen bank. */
		
	  // Werk de transactie tabel bij met de klant gegevens
    $sTransactionId    =  $iDEAL->getTransactionId();
	  $sDescription      =  $iDEAL->getDescription();
	  
	  /*    Voeg gegevens toe aan de tabel ideal_transacties        */
	  
		$querie = "INSERT INTO ideal_transacties (Id,Mollie_partner_id,Transaction_id, Vereniging, Vereniging_nr,Toernooi, Email,Totale_kosten, Description, Kenmerk, Status, TestMode,Laatst) 
		                values (0, 
		                         '".$partner_id."',
		                         '".$sTransactionId."' ,  
		                         '".$vereniging."' ,  
		                         '".$vereniging_nr."' ,  
 		                         '".$toernooi."' ,  
           		               '".$email."' ,  
 		                          ".$amount.", 
		                         '".$sDescription."',  
		                         '".$kenmerk."', 
		                          'PREPARED', 
		                         '".$test_mode."', 
		 		                        now() );";
		mysql_query($querie) or die ('Fout in insert PREPARED status');
		
		?>
	<script type="text/javascript">
	  window.location = '<?php echo $iDEAL->getBankURL(); ?>'; 
  </script>
  <?php
		
		exit;	
	}
	else 
	{
		/* Er is iets mis gegaan bij het aanmaken bij de betaling. U kunt meer informatie 
		   vinden over waarom het mis is gegaan door $iDEAL->getErrorMessage() en/of 
		   $iDEAL->getErrorCode() te gebruiken. */
		
		echo '<p>De betaling kon niet aangemaakt worden.</p>';
		
		echo '<p><strong>Foutmelding:</strong> ', htmlspecialchars($iDEAL->getErrorMessage()), '</p>';
		exit;
	}
}


/*
  Hier worden de mogelijke banken opgehaald en getoont aan de consument.
*/

$bank_array = $iDEAL->getBanks();

if ($bank_array == false)
{
	echo '<p>Er is een fout opgetreden bij het ophalen van de banklijst: ', $iDEAL->getErrorMessage(), '</p>';
	exit;
}

/////////////////////////////////////////////////////////////// Opmaak van de pagina /////////////////////////////////////////////////////////////////////////////////

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 
?>

<br>
<table>
 <tr>
		<td style='font-family:cursive; font-size: 14pt;color:yellow;' colspan='2'><h3>Betalen via iDEAL</h3></td>
 </tr>
</table>
<blockquote>

<center>
<div style='width:650px; left:140px;padding:20pt;text-align: left;font-family:arial;font-size:10pt;border-collapse: collapse;background-color:white;padding:5pt;box-shadow: 8px 8px 8px #888888;
	background-image: url(../ontip/images/payment_background.jpg); background-repeat: no-repeat;
	        -moz-border-radius-topleft: 10px;-webkit-border-top-left-radius: 10px;
					-moz-border-radius-topright: 10px;-webkit-border-top-right-radius: 10px;
					-moz-border-radius-bottomleft: 10px;-webkit-border-bottom-left-radius: 10px;
					-moz-border-radius-bottomright: 10px;-webkit-border-bottom-right-radius: 10px;	'>
 	
<fieldset style='border:1px solid white;padding:10pt;'>
	<TABLE width=100% border =0>
		<tr>
			<td style='text-align:left;padding:0pt;vertical-align:top;'><img src = '../ontip/images/badge-ideal-small.png' width='85'>
			<td width=90%  style='text-align:center;padding:0pt;color:white;font-size:22pt;font-weight:bold;'>MOLLIE ONLINE BETALINGEN</td>
			<td cellpadding="0" style='text-align:right;padding:2pt;;color:white;vertical-align:top;'><img src = '../ontip/images/ideal.bmp' width='60'></td>
		</tr>
			</TABLE>
			

<br>	
<center>
<table border =1 style='border-collapse: collapse;background-color:white;padding:5pt;box-shadow: 3px 3px 3px #888888;font-size:8pt;' >

	<?php 	if ($test_mode != 'PROD'){ ?>
	<tr><th>Test mode         : </th><td><?php echo $test_mode;?></td></tr>
<?php } ?>


	<tr><th>Vereniging          : </th><td><?php echo $vereniging; ?> ( <?php echo $vereniging_nr;?>)</td></tr>
	<tr><th>Toernooi            : </th><td><?php echo $toernooi_voluit ;?></td></tr>
	<tr><th>Soort toernooi      : </th><td><?php echo $soort ;?></td></tr>
  <tr><th>Datum               : </th><td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );?></td></tr>
  <tr><th>Naam speler1        : </th><td><?php echo $naam1;?></td></tr>
  
  <?php
  if (isset($_POST['bankrekening'])) { ?>
	<tr><th>Bankrekening        : </th><td><?php echo $_POST['bankrekening'];	?></td></tr>	
<?php } ?>
	<tr><th>Kenmerk             : </th><td><?php echo $kenmerk;?></td></tr>	
	<tr><th>IDEAL opslag kosten : </th><td>€. <?php echo number_format($ideal_opslag_kosten, 2, ',', ' ');?></td></tr>	
	<tr><th>Totale kosten       : </th><td>€. <?php echo number_format($totale_kosten, 2, ',', ' ');?></td></tr>
</table> </center><br>


<?php if ($inschrijf_status == 'ID1') { ;?>
	<div style='text-align:CENTER;padding:0pt;font-size:14pt;color:yellow;font-weight:bold;'>De inschrijving is al betaald op <?php echo $betaal_datum; ?> ! </div>	 
<?php } else { ?>	

<?php if ($email == '') { 	$color   = 'red';} else {	$color = 'black';} ?>	 

<form method="post" action="prepare_ideal_betaling.php?toernooi=<?php echo $toernooi."&id=".$id."&start=J"; ?>" >

<br>
<div style='text-align:left;padding:0pt;font-size:10pt;color:white;font-weight:bold;'>Email voor bevestiging betaling (verplicht) : <input type= 'text' name='email'  value = '<?php echo $email; ?>'  size=40> </div>	 

<br><br>
<?php
if ($test_mode == 'PROD'){
	$iDEAL->setTestMode(False);
} 
ELSE {
  $iDEAL->setTestMode(True);
}
?>
<b>Selecteer hier uw bank, klik op 'Betaal via iDEAL' en volg de stappen.</b>
<br>
<br>
	
<input type= 'hidden' name='amount'         value =  <?php echo $amount; ?> >
<input type= 'hidden' name='toernooi'       value = '<?php echo $toernooi; ?>'>
<input type= 'hidden' name='id'             value = '<?php echo $id; ?>'>
<input type= 'hidden' name='kenmerk'        value = '<?php echo $kenmerk; ?>'>
<blockquote>
<table width=80%>
	<tr>
		<td  style='color:white;font-weight:bold;font-size:10pt'><b>Kies hier uw bank:</b></td>
	<td>
  <select name="bank_id">
		<option value=''>Kies uw bank</option>
		
         <?php foreach ($bank_array as $bank_id => $bank_name) { ?>
	              	<option value="<?php echo htmlspecialchars($bank_id) ?>"><?php echo htmlspecialchars($bank_name) ?></option>
         <?php } ?>

	</select>
	</td>
	</tr>
</table>
</blockquote>

  <div style='text-align:right;'>
	<input style='font-size:12pt;font-weight:bold;' type="submit" name="submit" value="Betaal via iDEAL" /></div>
		
<table  width= 100%>
	<tr>
		<td    style= 'vertical-align:bottom; color:white;font-size:8.5pt;font-weight:bold;'>
			<input style='color:white;'  type='checkbox' name='Check' unchecked> Ik ga akkoord met onderstaande voorwaarden.
		</td>
		
		</td>
	</tr>
</table>
</form>

<?php }  ?>

</fieldset>
</div>
<div style='width:650px;text-align:justify;padding:0pt;vertical-align:bottom;FONT-SIZE:9PT;COLOR:DARKGREY;padding-top:35pt;'><i><hr>Voorwaarden: OnTip faciliteert de IDEAL betalingen m.b.v. Mollie en heeft verder geen invloed op het resultaat van een betalingsaanvraag.De gebruiker is zelf verantwoordelijk voor de controle op correctheid van de gegevens. Derhalve kan de OnTip beheerder niet aansprakelijk worden gesteld voor eventuele fouten in de afwikkeling van de financiële transacties of configuratie fouten van de verenigingsbeheerder. Met het starten van de iDEAL betaling gaat u akkoord met deze voorwaarden.</i></div>	
</center>
</blockquote>
</body>
</html>