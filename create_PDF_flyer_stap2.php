<?php
# create_PDF_Flyer_stap2.php
# 
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 17mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

# 10jan2020         -            E. Hendrikx 
# Symptom:   		None.
# Problem:     	    None
# Fix:              None
# Feature:          Andere aanroep mpdf
# Reference: 


?>
<html>
<head>
<title>Aanmaak PDF Flyer</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 9pt;}

</style>
</head>

<?php
// Database gegevens. 
include('mysqli.php');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

$toernooi           = $_POST['toernooi'];

$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select1');  
while($row = mysqli_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4);
$datum_toernooi = $jaar.$maand.$dag;


// uit vereniging tabel	
	
$sql2      = mysqli_query($con,"SELECT *  From vereniging where Id = ".$vereniging_id." ")     or die(' Fout in select id');  
  $result    = mysqli_fetch_array( $sql2 );
  $prog_url  = $result['Prog_url'];
  $logo_url  = $result['Url_logo'];
  $plaats    = $result['Plaats'];
  $contact   = $result['Tel_contactpersoon'];
  $email     = $result['Email'];
  $vereniging_output_naam = $result['Vereniging_output_naam'];
  
  /*
  $vereniging_output_naam = $result['Vereniging_output_naam'];
  */
  $url_redirect  = $result['Url_redirect'];
  $url_website   = $result['Url_website'];

/*

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}
*/

if (substr($prog_url,-1, 1) !=  "/" ){
	$prog_url = $prog_url . "/";
}

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$datum = $begin_inschrijving;

$dag1   = 	substr ($datum , 8,2); 
$maand1 = 	substr ($datum , 5,2); 
$jaar1  = 	substr ($datum , 0,4); 

//// 0123456789012345 
///  2014-01-17 21:45
///

$datum = $einde_inschrijving;

$dag2   = 	substr ($datum , 8,2); 
$maand2 = 	substr ($datum , 5,2); 
$jaar2  = 	substr ($datum , 0,4); 
$tijd  =    substr ($datum , 11,5); 

// indicatie voor meld_tijd

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysqli_fetch_array( $qry);
$parameter    = explode('#', $result['Parameters']);

$prefix    = $parameter[1];
$meld_tijd = $result['Waarde'];
 
if ($prefix == '2'){
	 	    $meld_tijd_prefix = 'vanaf'; 
    }
    else {
	     	$meld_tijd_prefix = 'voor'; 
}

switch($soort_inschrijving){
    case 'single' :   $soort = 'tete-a-tete'; break;
    case 'doublet' :  $soort = 'doubletten'; break;
    case 'triplet' :  $soort = 'tripletten'; break;
    case 'kwintet' :  $soort = 'kwintetten'; break;
    case 'sextet' :   $soort = 'sextetten';  break;
  }

$variabele = 'kosten_team';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select kosten');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $kosten_team     = $result['Waarde'];
 

 /// Laatste positie kosten_team geeft aan of Euro teken erbij moet
/// m = met  , z = zonder   (oude situatue, 11-10-2013 vervangen door parameter)
$len       = strlen($kosten_team);
$_euro_ind = substr($kosten_team,-1);

  if ($_euro_ind != 'm' and $_euro_ind != 'z'){
     	$kosten     = $result['Waarde'];
      } 
  else { 
      $len         = strlen($kosten_team);
  //    $_euro_ind    = substr($kosten_team,-1);
      $kosten      = substr($kosten_team,0,$len-1);
}

if ($kosten_eenheid == '1' or $soort_inschrijving  == 'single'){  
 	  $kosten_oms = 'persoon';
} else {
	  $kosten_oms = $soort_inschrijving;
}
  
   	
 if ($euro_ind == 'm') {
    $kosten_team  = 'Kosten '. $kosten . ' Euro per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
 }         
$output_pdf = $prog_url.'images/'.$toernooi.'_'.$datum_toernooi.'.pdf';
$qrc_link   = $prog_url."images/qrc/qrcf_".$toernooi.".png";


//$output_pdf = $prog_url.'csv/test17.pdf';
/// Parameters uit OnTip_PDF_flyer_stap1


$toernooi_naam      = $_POST['toernooi_naam'];
$_vereniging        = $_POST['_vereniging'];


$achtergrond_kleur  = $_POST['achtergrond_kleur'];
$tekstkleur         = $_POST['tekstkleur'];
$koptekst           = $_POST['koptekst'];
$url_afbeelding     = $_POST['url_afbeelding'];
if ($url_afbeelding == 'geen afbeelding' ) {
    $url_afbeelding     = '';
} else {
	$afb_grootte      = $_POST['afb_grootte'];
}
$copy_page          = $_POST['copy_page'] ;
$check_qrc          = $_POST['check_qrc'] ;

if (isset($_POST['check_text'])){
	$check_text         = $_POST['check_text'] ;
}
else {
	$check_text ='';
}

if (isset($_POST['check_soort'])){
	$check_soort        = $_POST['check_soort'] ;
}
else {
	$check_soort ='';
}
	
$opmerkingen        = $_POST['opmerkingen'] ;
$check_soort        = $_POST['check_soort'] ;

$logo_width         = $_POST['logo_width'];
$logo_height        = $_POST['logo_height'];
  
$afb_width          = $_POST['afb_width'];
$afb_height         = $_POST['afb_height'];


// zet # uit kleurcode om in ** ivm problemen met splitsen
$param_string = $achtergrond_kleur."$".$tekstkleur."$".$koptekst."$".$url_afbeelding."$".$afb_grootte."$".$check_qrc."$".$copy_page."$".$check_text."$".$opmerkingen."$".$logo_width."$".$logo_height."$".$check_soort."$".$afb_width."$".$afb_height."$".$toernooi_naam."$".$_vereniging."$";;
$param_string = str_replace ('#', '**', $param_string);

if ($opmerkingen == 'Typ hier evt opmerkingen.'){
	  $opmerkingen = '';
}

?>
<body>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $_vereniging ?></TD>
</tr>
<tr><td STYLE ='font-size: 24pt; color:red'><?php echo $toernooi_voluit ?><br>
	<?php   	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?> 
	
	</TD></tr>
</TABLE>
</div>
<hr color='red'/>
             
<span style='font-size:8pt'><a href='index.php'>Terug naar Hoofdmenu</a></span>
<br>
<span style='font-size:8pt'><a href="create_PDF_flyer_stap1.php?toernooi=<?php echo $_POST['toernooi']; ?>&parameters=<?php echo $param_string;?>" >Terug naar instellen PDF</a></span>
<?php

echo "<h2 style='color:blue;font-family:verdana;font-size:24;'>Aanmaak PDF flyer voor ".$toernooi_voluit." <img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =35 ></h2><br>";


if ($vereniging_output_naam !='') {
$vereniging_naam        = $vereniging_output_naam;
} else {
$vereniging_naam        = $vereniging;
}
$html = '
<div Style="background-color:'.$achtergrond_kleur.';border:1pt solid black;padding:10pt;" width=100% height=92%>'; 



$html .='
<table width=95% border =0>
<tr>
<td><img src="'.$logo_url.'" width='.$logo_width.' height='.$logo_height.' border =0 /></td>
<td><h2 style= "font-size:22pt;font-family:Verdana;text-align:left;color:'.$tekstkleur.';">'.$_vereniging.'</h2></td></tr>
</table>';

$html .='
<br>
<table width=95% border =0>
<tr>
<td colspan = 2 style= "font-size:20pt;text-align:center;font-family:Verdana;color:'.$tekstkleur.';"><center>organiseert op '.strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) .'</center></td></tr>
<tr>
<td colspan =2 style ="text-align:center;font-size:28pt;color:'.$koptekst.';">'.$toernooi_naam.'</td>
</tr>';

if ($check_soort == 'Yes'){ 
$html .='
<tr>
<td colspan=2 style= "font-size:20pt;font-family:Verdana;color:'.$tekstkleur.';"><center><i>'.$soort.' toernooi.</i></center></td></tr>';
};

$html .='
<tr>
<td colspan=2 style= "font-size:14pt;font-family:Verdana;color:'.$tekstkleur.';"><center>'.$extra_koptekst.'</center></td></tr>
</table>
<br>';

if ($url_afbeelding !=''){
$html .='
<div style="text-align:center;padding:5pt;">
<img src = "'.$url_afbeelding.'" width = "'.$afb_width.'"  height = "'.$afb_height.'"  border =0>
</div><br>';
} else {
$html .='
	 <br>
	 <br>' ;
}


 
 
$html .='
<table width=95%>';




$html .='
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Inschrijven tot </td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.strftime("%e %B %Y", mktime(0, 0, 0, $maand2 , $dag2, $jaar2) ).' '. $tijd.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Max. aantal inschrijvingen</td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$max_splrs.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Toegang</td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$toegang.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Melden '.$meld_tijd_prefix. '</td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$meld_tijd.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Spelen vanaf </td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$aanvang_tijd.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Kosten </td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$kosten_team.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Prijzen </td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.$prijzen.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Locatie </td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">'.str_replace(";", " ", $adres).'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Inschrijven</td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Klik <a style = "text-decoration:underline;color:blue;" href = "'.$url_redirect.'inschrijf_form.html?toernooi='.$toernooi.'" target ="_blank">hier</a> voor het <b>OnTip</b> inschrijfformulier</a> of<br> ga naar de website '.$url_website.'</td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';vertical-align:top;">Informatie</td>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';">Tel. '.$contact.'<br>Email <a href="mailto:'.$email.'" target="_blank">'.$email.'</a></td></tr>
<tr>
<td style= "font-size:11pt;font-family:Verdana;color:'.$tekstkleur.';vertical-align:top;" >';

if ($_POST['check_text'] == 'Yes'){
$html .='
<br>'.$opmerkingen.'</td>';
} else {
	$html .='<br></td>';
}


$html .='
<td style="text-align:right;vertical-align:bottom;">
';
//QRC image

if (file_exists($qrc_link) and $_POST['check_qrc'] =='Yes') {  
$html .='
<img src ="'.$qrc_link.'" width=100 border =0  style="text-align:right;" ><br>
<span style ="text-align:center;font-size:9pt;color:'.$tekstkleur.';font-family:arial;">Scan QR Code<br>voor Inschrijfformulier';
}
else {
	$html .= '<br>';
}
$html .='</td></tr></table>';
	
$html .='
<center>
<div width=100% style ="text-align:center;font-size:11pt;color:'.$tekstkleur.';font-family:arial;vertical-align:bottom;font-weight:bold">Website: '.$url_website.'</div>
</center>';

if ($sms_bevestigen_zichtbaar_jn == 'J'){ 
$html .='<img src = "https://www.ontip.nl/ontip/images/sms_bundel.jpg" border = 0 width=28><span style="font-size:9pt;color:blue;">Voor dit toernooi kan via SMS bevestigd worden.</span>';
}


$html .='
</div>
<span style ="text-align:center;font-size:8pt;color:darkgrey;"><img src="https://www.ontip.nl/ontip/images/OnTip_banner.png" width=36 border =0 />  (c) Erik Hendrikx '.date("Y").'  * PDF aangemaakt vanuit programma * </span>
';

//  echo $html;


//==============================================================
//==============================================================
//==============================================================

require_once  '../ontip//mpdf/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$mpdf->WriteHTML($html);

// indien opgegeven wordt dezelfde pagina nog een keer geprint. Op de printer kan je vervolgens op een A4 twee flyers printen 

if ($_POST['copy_page'] and $_POST['copy_page'] == 'Yes' ){
$mpdf->AddPage(); // Adds a new page 
$mpdf->WriteHTML($html);
}

$mpdf->Output($output_pdf,'F');
//$mpdf->Output();


echo "<center><br><br><iframe src='".$output_pdf."' width='580' height='580' style='border: none;'></iframe></center>";
echo "<br><a style='font-size:10pt;' href = ".$output_pdf." target='_blank'>Klik hier voor aangemaakte PDF Flyer in een apart window te openen.</a>";
exit;

//==============================================================
//==============================================================
//==============================================================
?>
