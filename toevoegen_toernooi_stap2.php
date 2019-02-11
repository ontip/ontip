<?php
////  Toevoegen_toernooi_stap2.php (c) Erik Hendrikx 2012 ev
////
////  Programma voor het aanmaken van een nieuw toernooi. Dit programma is daarin de tweede stap.  Dit programma wordt aangeroepen door
////  toevoegen_toernooi_stap1.php (via form post).
////  Het programma leest het tekstbestand mytoernooi.txt voor de default instellingen voor een toernooi ($_POST['bron'] == 'default') . Deze worden samengevoegd met de waarden
////  vanuit toevoegen_toernooi_stap1.php en toegevoegd aan de tabel config.
////
///   Mytoernooi.txt bevat een aantal variabelen met de bijbehorende waarde:
////      $soort_inschrijving  = triplet 
////      $toernooi_voluit     = toernooi naam (pas deze naam aan via het configuratie bestand)
////      $max_splrs           = 32
////      $kosten_team         = 10.00 
////      $toegang             = voor iedereen met of zonder licentie
////      $licentie_jn         = N
////      $meld_tijd           = 12.00 uur
////      $aanvang_tijd        = 12.30 uur
////  Voor aantal van deze variabelen (bijv meld_tijd en kosten_team) wordt ook een parameter waarde toegevoegd. Deze parameters fungeren als stuur karakters
////  voor bijvoorbeeld de waarde Voor of Vanaf een opgegeven meldtijd. Indien er meerdere parameters zijn worden deze van elkaar gescheiden door het # teken.
////  Na het toevoegen van de records aan de config tabel wordt een mail verstuurd naar de gebruiker om aan te geven dat het toernooi is toegevoegd.
////  Een aantal waarden hieruit krijgen een andere waarde. Bijvoorbeeld $begin_inschrijving = datum vandaag.   
////  Vooor het toevoegen van een toernooi heeft de gebruiker rechten nodig voor A(les) of C(onfig).
////
//// Als alternatief voor mytoernooi.txt kan ook de inhoud van een bestaand toernooi als bron gebruikt worden ($bron = $_POST['bron'] . Bron = naam ander toernooi)
//// Alleen naam toernooi en datum verschillen.
////
////  Indien geselecteerd vanuit stap1 kan een QR code image worden aangemaakt vooe het openen van het Inschrijfform.php?toernooi= <naam>  
////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////  Programma aanpassingen
////  14-10-2013  Variabele boulemaatje_gezocht_zichtbaar_jn wordt toegevoegd vanuit dit programma en niet vanuit mytoernooi.txt.
////   6-07-2018  Variabele aangemaakt_door toegevoegd voor initiele aanmaak toernooi
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	</head>
<?php
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Database gegevens. 
include('mysql.php');
setlocale(LC_ALL, 'nl_NL');


// gebruik dummy variabelen om overschrijven vanuit myverenigig.txt te voorkomen

$_input_toernooi   = trim($_POST['_toernooi']);
$_datum            = $_POST['datum_jaar']."-".sprintf("%02d",$_POST['datum_maand'])."-".sprintf("%02d",$_POST['datum_dag']);
$error             = 0 ;
$message           = '';

$_email_organisatie   = trim($_POST['_email_organisatie']);
$aangemaakt_door      = $_POST['aangemaakt_door'];
// Controles

if ($_input_toernooi == '') {
	$message .= "* Naam toernooi is niet ingevuld<br>";
	$error = 1;
}

if ( strlen($_input_toernooi) > 50) {
	$message .= "* Naam toernooi mag maximaal 50 karakters lang zijn. Is nu ".strlen($_input_toernooi)." lang<br>";
	$error = 1;
}


$check                = $_input_toernooi;
$_input_toernooi_repl =  preg_replace('/[^a-zA-Z0-9 .@,]/', '*', $_input_toernooi);

if ($_input_toernooi_repl != $check){
	$message .= "* Naam toernooi mag geen vreemde tekens bevatten.<br>";
	$error = 1;
}


if ($_datum == '') {
	$message .= "* Datum toernooi is niet ingevuld<br>";
	$error = 1;
}

$today = date('Y')."-".date('m')."-".date('d');
if ($_datum < $today){
  $message .= "* Datum toernooi mag niet in het verleden liggen.<br>";
	$error = 1;
}

if ($_email_organisatie == '') {
	$message .= "* Email organisatie is niet ingevuld<br>";
	$error = 1;
}


if (!isset($_POST['akkoord'] )){
	$message .= "* U dient akkoord te gaan met de voorwaarden door een vinkje te zetten bij 'Ik ga akkoord ....'.<br>";
	$error = 1;
}
	
//// Converteer spaties naar underscores

$_input_toernooi  = trim($_input_toernooi);   // skip start and  end spaces

// kontroleer of toernooi al bestaat
if ($_input_toernooi !=''){
$_input_toernooi  = str_replace (" ","_",$_input_toernooi);
$sql     = mysql_query("SELECT count(*) as Aantal FROM config  WHERE Vereniging = '".$vereniging."' and Toernooi = '".$_input_toernooi."'" );
$result  = mysql_fetch_array( $sql );
$count   = $result['Aantal'];

if ($count > 0 ) {
	$message .= "* Er bestaat al een toernooi met de naam ". $_input_toernooi."";
	$error = 1;
}

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon foutmeldingen in popup

if ($error != 0){
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
              "     ")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
 }

 
 /// alle controles goed 
if ($error == 0){


if ( (substr($_POST['bron'],0,4)=='cfg_'  and substr($_POST['bron'],-4)=='.txt' ) or  ( $_POST['bron'] =='mytoernooi.txt')){ 
 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inhoud van de configuratie file wordt naar een  tabel geschreven
// hier kunnen de records gemuteerd worden. Het bestand bevat de default waarden. 

// Kopieer bestand mytoernooi.txt naar config
$myFile= $_POST['bron'] ;

if ($myFile !='mytoernooi.txt'){
  	$myFile = 'csv/'.$_POST['bron'];
}

//echo $myFile."<br>";


$fh       = fopen($myFile, 'r');
$line     = fgets($fh);
$i=1;
$query = '';

while ( $line <> ''){

$i++;
if (substr($line,0,1) == '$' ){

$pos = strpos($line, '=');

// Create variable (with $ sign), no spaces

$var = trim(substr($line,1,$pos-1));

// Set value to variable  trim for no spaces 
$$var = trim(substr($line,$pos+2,80));
$waarde = trim(substr($line,$pos+2,240));

//echo "Variabele : ". $var ." = " . $$var . "<br>";

 }
 // commentaar regels
 else {
 	$var    = 'Commentaar';
 	$waarde = $line;
}

$query = "INSERT INTO config (Id, Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde)
                         VALUES (0,".$i.", '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."','".$var . "','" .$waarde ."' )";
       
mysql_query($query) or die ('Fout in insert config tabel');           

$line = fgets($fh);

} /// while

// email organisatie apart toevoegen als deze er nog niet is

$var    = 'email_organisatie';
$qry_m  = mysql_query("SELECT * From config where Vereniging ='".$vereniging."' and Toernooi ='".$_input_toernooi. "' and Variabele  = '".$var."' ")     or die(' Fout in select');  
$count  = mysql_num_rows($qry_m);


if ($count == 0) {
 $waarde = $_POST['_email_organisatie'];
 $var    = 'email_organisatie';
 $query  = "INSERT INTO config (Id, Regel, Vereniging, Vereniging_id, Toernooi, Variabele, Waarde)
                         VALUES (0,3, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."','".$var . "','" .$waarde ."' )";
 mysql_query($query) or die ('Fout in insert config tabel');          

  } // if email toevoegen
} // if default


else {

//// voor toevoegen toernooi wordt gebruik gemaakt van een ander toernooi

$bron = $_POST['bron'];
// echo $bron. "<br>";

mysql_query("Delete from hulp_config where Vereniging_id = '".$vereniging_id."'   ") ;  

$query = "INSERT INTO hulp_config (Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde, Parameters)
                    SELECT Regel, Vereniging, Vereniging_id, Toernooi, Variabele, Waarde, Parameters FROM config where 
                       Vereniging_id = '".$vereniging_id."'  and Toernooi = '".$bron."' ";
// echo $query;

mysql_query($query) or die ('Fout in insert hulp_config tabel');           

// update hulp config met nieuwe naam

$query  =  "UPDATE hulp_config SET Toernooi = '".$_input_toernooi."' where Vereniging = '".$vereniging."'  and
            Toernooi = '".$bron."'";
            
 mysql_query($query) or die ('Fout in update hulp_config tabel');           
 
// insert in config
 
$query = "INSERT INTO config (Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde, Parameters)
                    SELECT Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde, Parameters FROM hulp_config where 
                       Vereniging_id = '".$vereniging_id."'  and Toernooi = '".$_input_toernooi."' ";

mysql_query($query) or die ('Fout in insert config tabel');           

}  // end else 

/////

if ($_input_toernooi != '' and $vereniging !='') {
	
// extra toevoegen record voor datum 
// Indien al toegevoegd via myconfiguratie.txt dan eerst verwijderen

mysql_query("Delete from config where Vereniging = '".$vereniging."' and Toernooi ='".$_input_toernooi."' and Variabele = 'datum'   ") ;  


$var    = 'datum';
$waarde = $_datum;

$query = "INSERT INTO config (Id, Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde)
                         VALUES (0,1, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."','".$var . "','" .$waarde ."' )";
       
 mysql_query($query) or die ('Fout in insert config tabel');           
}

// aanpassen begin en einde inschrijving

$today     = date("Y") ."-".  date("m") . "-".  date("d");
$dag   = 	substr ($_datum , 8,2); 
$maand = 	substr ($_datum , 5,2); 
$jaar  = 	substr ($_datum , 0,4); 

// einde inschrijving met uren en minuten erbij

$einde_inschrijving = date($jaar) ."-".  date($maand) . "-".  date($dag). " 00:00";

$var    = 'begin_inschrijving';
$waarde = $today;

mysql_query("Delete from config where Vereniging = '".$vereniging."' and Toernooi ='".$_input_toernooi."' and Variabele = '".$var."'   ") ;  
$query = "INSERT INTO config (Id, Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde)
                         VALUES (0,2, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."','".$var . "','" .$waarde ."' )";
       
 mysql_query($query) or die ('Fout in insert config tabel');           

$var    = 'einde_inschrijving';
$waarde = $einde_inschrijving;

mysql_query("Delete from config where Vereniging = '".$vereniging."' and Toernooi ='".$_input_toernooi."' and Variabele = '".$var."'   ") ;  
$query = "INSERT INTO config (Id, Regel, Vereniging, Vereniging_id,Toernooi, Variabele, Waarde)
                         VALUES (0,3, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."','".$var . "','" .$waarde ."' )";
       
 mysql_query($query) or die ('Fout in insert config tabel');           

// Ophalen  mail tracer en prog _url
$qry3             = mysql_query("SELECT *  From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select3');  
$row3             = mysql_fetch_array( $qry3 );
$trace            = $row3['Mail_trace'];
$prog_url         = $row3['Prog_url'];
   
   if ($trace =='J') {
       $email_tracer = $row3['Mail_trace_email'];
   }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// update bepaalde waarden met parameters

/// Aparte update ivm positie afbeelding

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'url_afbeelding' ") ;  
$result       = mysql_fetch_array( $qry);
$parameter    = '#r'; // plaatje rechts
$query        = "UPDATE config              SET  Parameters  = '".$parameter."' , Laatst      = NOW()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update url'); 

/// Aparte update ivm extra koptekst

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'extra_koptekst' ") ;  
$result       = mysql_fetch_array( $qry);
$parameter    = '#z'; // geen extra koptekst
$query        = "UPDATE config             SET  Parameters  = '".$parameter."' ,  Laatst      = NOW()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update extra_kop'); 

/// Aparte update ivm meldtijd

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysql_fetch_array( $qry);
$parameter    = '#2'; // Vanaf uur:min
$query        = "UPDATE config             SET  Parameters  = '".$parameter."' , Laatst      = NOW()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update meld_tijd'); 

/// Aparte update ivm kosten team

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'kosten_team' ") ;  
$result       = mysql_fetch_array( $qry);
$parameter    = '#m#2'; // Euro ind aan en voor team inschrijving
$query        = "UPDATE config             SET  Parameters  = '".$parameter."' ,  Laatst      = NOW()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update kosten_team'); 

// initialiseer uitgestelde betaling

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'uitgestelde_bevestiging_jn' ") ;  
$result       = mysql_fetch_array( $qry);
$query        = "UPDATE config             SET  Waarde = 'N', Laatst = now()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update uitgestelde bevestiging'); 

// initialiseer bankrekening invullen_jn

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'bankrekening_invullen_jn' ") ;  
$result       = mysql_fetch_array( $qry);
$query        = "UPDATE config             SET  Waarde = 'N', Laatst = now()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update bankrekening invullen'); 


$query        = "UPDATE config             SET  Waarde = 'N', Laatst = now()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update bankrekening invullen'); 

// ophalen email organisatie

$var          = 'email_organisatie';
$qry          = mysql_query("SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ;  
$result       = mysql_fetch_array( $qry);
$email_organisatie  =  $result['Email_organisatie'];


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// email organisatie apart toevoegen als deze er nog niet is

$var  = 'email_organisatie';
$qry_m  = mysql_query("SELECT * From config where Vereniging ='".$vereniging."' and Toernooi ='".$_input_toernooi. "' and Variabele  = '".$var."' ")     or die(' Fout in select');  
$count  =mysql_num_rows($qry_m);

if ($count == 0) {
 $waarde = $_POST['_email_organisatie'];
 $var    = 'email_organisatie';
 $query  = "INSERT INTO config (Id, Regel, Vereniging, Toernooi, Variabele, Waarde)
                         VALUES (0,3, '".$vereniging."','".$_input_toernooi."','".$var . "','" .$waarde ."' )";
 mysql_query($query) or die ('Fout in insert config tabel');          

  } // if email toevoegen als nog niet bestaat, anders waarde vervangen
  else {
 $waarde = $_POST['_email_organisatie'];
 $var    = 'email_organisatie';
 $query  = "UPDATE config set Waarde = '".$waarde."' where Vereniging ='".$vereniging."' and Toernooi ='".$_input_toernooi. "' and Variabele  = '".$var."' ";
 mysql_query($query) or die ('Fout in update config tabel');          

} // if email toevoegen als nog niet bestaat, anders waarde vervan 	
  
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Aanmaak QRC image voor inschrijf formulier 

if (isset ($_POST['qrc_code']) and $_POST['qrc_code'] == 'Ja'){
  include "../ontip/phpqrcode/qrlib.php"; 

$qry          = mysql_query("SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ; 
$result       = mysql_fetch_array( $qry);
$url_redirect =  $result['Url_redirect'];
  
 
 // de ontip link 
$form_link = $url_redirect."inschrijf_form_smal.html?simpel&mobiel&toernooi=".$_input_toernooi;

$qrc_link  = $prog_url."images/qrc/qrcf_".$_input_toernooi.".png";
$qrc_file  = $prog_url."images/qrc/qrcf_".$_input_toernooi.".png";

//echo "Gegevens voor toernooi ". $toernooi . "  : <br>";


QRcode::png("".$form_link."", "".$qrc_link."", "L", 4, 4); 

//QRcode::png("http://www.sitepoint.com", "test.png", "L", 4, 4); 


// Plaats OnTip logo rechtsonder in QRC

 
$logo_file = 'http://www.ontip.nl/ontip/images/OnTip_banner_qrc.png'; 
$image_file = $qrc_file;
$targetfile = $qrc_link;

$photo = imagecreatefrompng($image_file); 
$fotoW = imagesx($photo); 
$fotoH = imagesy($photo); 
$logoImage = imagecreatefrompng($logo_file); 
$logoW = imagesx($logoImage); 
$logoH = imagesy($logoImage); 


$photoFrame = imagecreatetruecolor($fotoW,$fotoH); 

$dest_x = $fotoW - $logoW; 
$dest_y = $fotoH - $logoH; 

// verplaats logo

$dest_x = $dest_x-5;
$dest_y = $dest_y-5;

// creer nieuw bestand

imagecopyresampled($photoFrame, $photo, 0, 0, 0, 0, $fotoW, $fotoH, $fotoW, $fotoH); 
imagecopy($photoFrame, $logoImage, $dest_x, $dest_y, 0, 0, $logoW, $logoH); 
imagejpeg($photoFrame, $targetfile);  


}// end if
   
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Toevoegen item voor boulemaatje zichtbaar J/N

$var    = 'boulemaatje_gezocht_zichtbaar_jn';
$qry_m  = mysql_query("SELECT * From config where Vereniging ='".$vereniging."' and Toernooi ='".$_input_toernooi. "' and Variabele  = '".$var."' ")     or die(' Fout in select');  
$count  =mysql_num_rows($qry_m);

if ($count == 0) {
 $waarde = "J";  
 $query  = "INSERT INTO config (Id, Regel, Vereniging, Toernooi, Variabele, Waarde)
                         VALUES (0,3, '".$vereniging."','".$_input_toernooi."','".$var . "','" .$waarde ."' )";
mysql_query($query) or die ('Fout in insert config tabel - boulemaatje');           

}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// url_website  tbv toernooi_ontip

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' 
                and Variabele = 'url_website' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
$id           = $result['Id'];
if (isset($_POST['Waarde-'.$id])){
   $waarde       = $_POST['Waarde-'.$id]; 
   $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
  }
 
  
} else {
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."', 'url_website','".$url_website."', now() ) ";
//echo $query."<br>";
           
mysql_query($query) or die ('Fout in update url website');   

}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi voluit

$qry          = mysql_query("SELECT * From config  where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'toernooi_voluit' ") ;  
$result       = mysql_fetch_array( $qry);
$parameter    = '#r'; // plaatje rechts
$query        = "UPDATE config              SET  Waarde  = '".$_input_toernooi."' , Laatst      = NOW()  WHERE  Id  = '".$result['Id']."'  ";
mysql_query($query) or die ('Fout in update toernooi_voluit'); 


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// vereniging_selectie_zichtbaar_jn

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'vereniging_selectie_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
$id           = $result['Id'];
if (isset($_POST['Waarde-'.$id])){
   $waarde       = $_POST['Waarde-'.$id]; 
   $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
  }
 

} else {
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."', 'vereniging_selectie_zichtbaar_jn','J', now() ) ";
//echo $query."<br>";
           
mysql_query($query) or die ('Fout in update vereniging selectie');   

}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi_gaat_door_ja

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'toernooi_gaat_door_jn' ") ;  
$count        = mysql_num_rows($qry);


if ($count > 0) {                
$id           = $result['Id'];
if (isset($_POST['Waarde-'.$id])){
   $waarde       = $_POST['Waarde-'.$id]; 
   $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
  }
 
} else {
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."', 'toernooi_gaat_door_jn','J', now() ) ";
//echo $query."<br>";
           
mysql_query($query) or die ('Fout in update toernooi gaat door');   

}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// bestemd_voor

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'bestemd_voor' ") ;  
$count        = mysql_num_rows($qry);

if ($count == 0) {                
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."', 'bestemd_voor','','', now() ) ";
//echo $query."<br>";
        
mysql_query($query) or die ('Fout in update bestemd_voor');   

}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// mimimum aantal 

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = 'min_splrs' ") ;  
$count        = mysql_num_rows($qry);

if ($count == 0) {                
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$_input_toernooi."', 'min_splrs','0','', now() ) ";
//echo $query."<br>";
        
mysql_query($query) or die ('Fout in update min_splrs');   

}//// end if
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Toevoegen parameter item voor $inschrijf_methode

$var  = 'soort_inschrijving';
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."' and Variabele = '".$var."' ") ;  
$result       = mysql_fetch_array( $qry);
$waarde       = $result['Waarde'];
$inschrijf_methode  = $result['Parameters'];

// soort_inschrijving   = doublet:vast

if (strpos($waarde , ":") > 0){
	$item                 = explode( ":", $waarde);
  $soort_inschrijving   = $item[0];
  $inschrijf_methode    = $item[1];
}
else {
   $soort_inschrijving   = $waarde;
}   

if ($inschrijf_methode == ''){ 
    $inschrijf_methode = 'vast';
}
 
$query  = "UPDATE config set Waarde     = '".$soort_inschrijving."' , 
                             Parameters = '".$inschrijf_methode."' 
                             where Vereniging ='".$vereniging."' and Toernooi ='".$_input_toernooi. "' and Variabele  = '".$var."' ";
 mysql_query($query) or die ('Fout in update config tabel - soort inschrijving');          

/////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra vraag

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$count        = mysql_num_rows($qry);
$vraag_antwoord = '';
$lijst_jn       = 'N';  
$parameters      = '#'.$lijst_jn;
 
if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $query        = "UPDATE config  SET Waarde      = '".$vraag_antwoord."',  Parameters  = '".$parameters."',    Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//  echo $query. "<br>";
  mysql_query($query) or die ('Fout in update extra_vraag ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'extra_vraag','".$vraag_antwoord."','".$parameters."' , now() ) ";
 //echo $query. "<br>";
   mysql_query($query) or die ('Fout in insert extra_vraag');   
  
}//// end if

/////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra invulveld

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'extra_invulveld' ") ;  
$count        = mysql_num_rows($qry);
$invulveld    = ''; 
$verplicht_jn = 'N';
$lijst_jn     = 'N'; 
$parameters   = '#'.$verplicht_jn.'#'.$lijst_jn;
 

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  
  $query        = "UPDATE config  SET Waarde      = '',   Parameters  = '".$parameters."',        Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update extra_invulveld ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'extra_invulveld','','#N#N' , now() ) ";
//  echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert extra_invulveld');   
  
}//// end if
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// lijst zichtbaar

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'link_lijst_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $result['Waarde']; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update link_lijst_zichtbaar ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'link_lijst_zichtbaar_jn','J', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert link_lijst_zichtbaar');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// sms bevestiging zichtbaar

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'sms_bevestigen_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $result['Waarde']; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update sms_bevestigen_zichtbaar_jn ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'sms_bevestigen_zichtbaar_jn','N', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert sms_bevestigen_zichtbaar_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Ideal_betaling  21 nov 2016

$qry          = mysql_query("SELECT * From vereniging  where Vereniging = '".$vereniging ."'  ") ; 
$result       = mysql_fetch_array( $qry);
 
 // default waarde in vereniging
$ideal_test_mode = $result['IDEAL_Test_Mode'];

// ideal betaling staat nog wel uit
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) VALUES
                                      (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'ideal_betaling_jn','N', '#".$ideal_test_mode."#0.00', now() ) ";

 mysql_query($query) or die ('Fout in insert ideal_betaling_jn');   

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi zichtbaar  1 aug 2017

$count        = 0;
$variabele = 'toernooi_zichtbaar_op_kalender_jn';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 
if ($count == 0) {                

  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'toernooi_zichtbaar_op_kalender_jn','0', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert toernooi_zichtbaar_op_kalender_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// wedstrijd schema  1 aug 2017

$count        = 0;
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'wedstrijd_schema' ") ;  
$count        = mysql_num_rows($qry);
 
if ($count == 0) {                

  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'wedstrijd_schema','', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert wedstrijd_schema');   
  
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// aangemaakt door   6 juli 2018

$count        = 0;
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$_input_toernooi ."'  and Variabele = 'aangemaakt_door' ") ;  
$count        = mysql_num_rows($qry);
 
if ($count == 0) {                
  $now = date('Y-m-d H:i:s');
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,Parameters, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$_input_toernooi."', 'aangemaakt_door','".$aangemaakt_door."','".$now."'  , now()) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert aangemaakt_door');   
  
}//// end if



/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi

$toernooi    = $_input_toernooi;
//include('conv_diakrieten.php');

/////////////////////////////////////////////////////////////////////////////////////////////////////
///  stuur email bericht
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$toernooi_voluit   = str_replace("&#226", "â", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "é", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "ê", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "ë", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "ï", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39", "'", $toernooi_voluit);

// uit vereniging tabel	
    
$qry_v           = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysql_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo']; 

$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);
$vereniging =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $vereniging);

/////////////////////////////////////////////////////////////////////////////////////////////////////
include('aanlog_check.php');	

$subject = 'Toevoegen '. $vereniging . ' - ';
$subject .= $_input_toernooi;

$email_bcc     = 'erik.hendrikx@gmail.com';
$email_bcc     = 'erik.hendrikx@gmail.com';
//$to            = $email_organisatie;

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';
 
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";

////   Alleen BCC indien Trace J
if ($trace == 'J' or $trace =='Y'){
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Bcc: '. $email_tracer . "\r\n" .
       'Cc: '. $email_organisatie . "\r\n" .
       'Return-Path: '. $from  . "\r\n" . 
       'Reply-To: '. $email_return . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
}	     
else { 
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
           'Cc: '. $email_organisatie . "\r\n" .
           'Return-Path: '. $from  . "\r\n" . 
           'Reply-To: '. $email_return . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
}

$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=80>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". $vereniging ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><hr/>".   "\r\n";
$bericht .= "<br><h3 Style='font-family:verdana;font-size:10pt;' ><u>Toevoegen toernooi</u></h3>".   "\r\n";

$bericht .= "<div style='font-family:verdana;color:black;'='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<span Style='font-family:verdana;font-size:9pt;' >Beste ".$naam . ",</span><br><br>" .  "\r\n";

$bericht .= "<div Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "Toernooi <b>".$_input_toernooi."</b> met datum ".$_datum. " is toegevoegd aan de OnTip configuratie voor ".$vereniging. "." .  "\r\n";
$bericht .= " Aangemaakt door <b>".$aangemaakt_door."</b>.<br><br>" .  "\r\n";
$bericht .= "N.B Via de beheerpagina kan in de configuratie de naam van het toernooi zoals deze op het scherm en lijsten verschijnt veranderd worden.<br><br>" .  "\r\n";
$bericht .= "</div>";

$bericht .= "</div>";

if (isset ($_POST['qrc_code']) and $_POST['qrc_code'] == 'Ja'){
	
$bericht .= "<div Style='font-family:verdana;font-size:9pt;color:black;'>"   . "\r\n";
$bericht .= "QRC code voor Inschrijffomulier Toernooi ".$_input_toernooi." <br>  <a href = 'http://www.ontip.nl/".substr($prog_url,3)."images/qrc/qrcf_".$_input_toernooi.".png'><img src= 'http://www.ontip.nl/".substr($prog_url,3)."images/qrc/qrcf_".$_input_toernooi.".png' border =0 target='_blank'></a><br>Klik op de code om het image in een apart window te openen zodat deze gekopieerd of gescand kan worden <br>" .  "\r\n";
$bericht .= "</div>";

}
//echo $bericht;

$bericht .= "<hr/><div style= 'style= 'font-family:verdana;font-size:9pt;color:black;padding-top:20pt;'><br><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze mail is aangemaakt vanuit On.Tip  (c) Erik Hendrikx ".date('Y ')."</div>" . "\r\n";

if ($_input_toernooi != '' and $vereniging !='') {
 mail($_email_organisatie, $subject, $bericht, $headers);
}
?>

<?php	
}/// einde controles
;
if ($error == 1){
	
?>
<script language="javascript">
        alert("Er is iets fout gegaan bij het aanmaken van het toernooi.")
    </script>
  <script type="text/javascript">
       window.close(); 
		</script>	
<?php
} else { 
?>
<script language="javascript">
		window.location.replace('index.php');
</script>

<?php
 }
 
?> 