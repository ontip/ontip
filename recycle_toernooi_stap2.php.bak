<?php
ob_start();

//// Database gegevens. 

include ('mysql.php');

// formulier POST variabelen ophalen en kontroleren

$respons           = $_POST['respons'];
$challenge         = $_POST['challenge'];
$bron              = $_POST['bron'];
$_toernooi         = $_POST['_toernooi'];

$datum_dag         = $_POST['datum_dag'];
$datum_maand       = $_POST['datum_maand'];
$datum_jaar        = $_POST['datum_jaar'];

$begin_datum_dag   = $_POST['begin_datum_dag'];
$begin_datum_maand = $_POST['begin_datum_maand'];
$begin_datum_jaar  = $_POST['begin_datum_jaar'];

$eind_datum_dag   = $_POST['eind_datum_dag'];
$eind_datum_maand = $_POST['eind_datum_maand'];
$eind_datum_jaar  = $_POST['eind_datum_jaar'];

$eind_datum_uur = $_POST['eind_datum_uur'];
$eind_datum_min  = $_POST['eind_datum_min'];


//

// Controles
$error   = 0;
$message = '';

if ($respons == '' or $respons == 'Typ hier de aangegeven cijfercode') {
	$message .= "* Antispam code is niet ingevuld.<br>";
	$error = 1;
}
else {

if ($challenge != $respons){
	$message .= "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}

if ($bron == '') {
	$message .= "* Er is geen toernooi geselecteerd.<br>";
	$error = 1;
}

if ($_toernooi == '') {
	$message .= "* Er is geen toernooinaam ingevuld.<br>";
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


 /// alle controles goed 
if ($error == 0 and $message == ''){
///  update

$datum       = $datum_jaar."-". sprintf("%02d",$datum_maand)."-". sprintf("%02d",$datum_dag);
$begin_datum = $begin_datum_jaar."-". sprintf("%02d",$begin_datum_maand)."-". sprintf("%02d",$begin_datum_dag);
$eind_datum  = $eind_datum_jaar."-". sprintf("%02d",$eind_datum_maand)."-". sprintf("%02d",$eind_datum_dag)." ". sprintf("%02d",$eind_datum_uur).":". sprintf("%02d",$eind_datum_min);


/// toernooi_voluit

$query = "UPDATE config set Waarde ='".$_toernooi."'  where Vereniging = '".$vereniging."' and Toernooi ='".$bron."' and Variabele = 'toernooi_voluit' ";
//echo $query;
mysql_query($query) or die (mysql_error()); 

// datum

$query = "UPDATE config set Waarde ='".$datum."'  where Vereniging = '".$vereniging."' and Toernooi ='".$bron."' and Variabele = 'datum' ";
//echo $query;
mysql_query($query) or die (mysql_error()); 

// begin_inschrijving

$query = "UPDATE config set Waarde ='".$begin_datum."'  where Vereniging = '".$vereniging."' and Toernooi ='".$bron."' and Variabele = 'begin_inschrijving' ";
//echo $query;
mysql_query($query) or die (mysql_error()); 


// einde_inschrijving

$query = "UPDATE config set Waarde ='".$eind_datum."'  where Vereniging = '".$vereniging."' and Toernooi ='".$bron."' and Variabele = 'einde_inschrijving' ";
//echo $query;
mysql_query($query) or die (mysql_error()); 

/////////////////////////////////////////////////////////////////////////////////////////////////////
// Aanmaak QRC image voor inschrijf formulier 

if (isset ($_POST['qrc_code']) and $_POST['qrc_code'] == 'Ja'){
  include "../ontip/phpqrcode/qrlib.php"; 

// hier volledig path 
$form_link = 'http://www.ontip.nl/'.substr($prog_url,3)."Inschrijfform.php?toernooi=".$_input_toernooi;

// bij aanmaak relatief path, anders fout op volledig path. In de mail wordt het volledige path gelinkt

$qrc_link  = "images/qrc/qrcf_".$_input_toernooi.".png";

QRcode::png("".$form_link."", "".$qrc_link."", "L", 4, 4); 

}// end if


}


?>
<script language="javascript">
		window.location.replace('recycle_toernooi_stap1.php');
</script>

