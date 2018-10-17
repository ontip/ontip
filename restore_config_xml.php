<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Restore configuratie bestand</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }	
td,th { text-align:left;padding:2pt;font-size:9pt;}
h2 {color:darkgreen;font-size:11pt;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }
</style>

<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 	
 	function changeFunc(text) {
    document.getElementById("xml_file").value= text;
   }

function CopyToClipboard() 
{ 
var controlValue  = document.getElementById('cmds').value;
        alert(controlValue);
         window.clipboardData.setData('Text', controlValue);
        alert('Copied text to clipboard : '   controlValue); 
}

function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
//This line will copy the formatted text to the clipboard
            controlRange.execCommand('Copy');         

            alert('Your HTML has been copied\n\r\n\rGo to Word and press Ctrl+V');
}    
  
</Script>	
	
</head>
<body>

<?php	
	
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen
include 'mysql.php'; 
$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
?>

<table STYLE ='background-color:white;'>
<table >
   <tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
   	<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>OnTip Restore configuratie m.b.v XML</TD>
</TR>
</TABLE>
<hr color= red/>
<br>

<h2>Aanmaak SQL commando's tbv restore configuratie toernooi m.b.v XML file</h2>

<?php

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

if (!isset($_POST['xml_file']) or !isset($_GET['xml'])    ){
	?>
	 <FORM action='restore_config_xml.php?xml' method='post' name = 'myForm3'>
	
	 <table width =60%>
		<tr>
			<th  width = 50%>Naam xml file tbv restore (volledig path)</th>
			<td>	<input name= 'xml_file'  id= 'xml_file'  type='text' size='45' >
	  </td> 
	  <tr>
			<th  width = 50%>Update of Insert</th>
			<td>	<input style ='font-size:7pt;padding-right:25pt;' name= 'action'   type='radio' value='insert' >Insert  <br>
				  <input name= 'action'   type='radio' value='update'  >Update 
	  </td>   
    </tr>
   </table>
   
   <INPUT type='submit' value='Verzenden'  name = 'myForm2' style='background-color:red;color:white;'>
  </FORM>   
  
 
<?php

?>
<div style ='margin-left:45pt;padding:5pt;'	>
<h1> XML files tbv backup en restore</h1>
<?php


echo "<table border = 1>";
echo "<tr><th>Nr</th><th>Vereniging</th><th>Open</th><th>Select</th><th>Folder</th><th>File</th><th>Size</th><th>Creation time</th></tr>";

$dir            = 'xml';
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}
$j=1; 
foreach ($files as $file) {
     	
       if (strlen($file) > 3 ){      	
          $bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
               	
        	
        	$part = explode('_', $file);
        	//echo $part[1];
               	
        	$qry           = mysql_query("SELECT Vereniging from vereniging where Id = ".$part[1]." ")     or die(' Fout in select 7'); 
         	$result        = mysql_fetch_array( $qry );
          $vereniging    = $result['Vereniging'];
	
           if ($part[0] =='cfg'){ ?>
              <tr><td ><?php echo $j; ?></td><td><?php echo $vereniging; ?></td>
          	    <td><center> <a  href = '<?php echo $bestand; ?>'  target = '_blank'>open</a></center></td>
          	    <td style='color:darkgreen;font-weight:bold;' onclick="changeFunc('<?php echo $bestand; ?>');" >Select</td>
         	  	  <td><?php echo $dir; ?></td><td><?php echo $file; ?></td><td style='text-align:right;'><?php echo $filesize; ?></td>
          	    <td style='text-align:right;'><?php echo date("d-m-Y H:i:s", $last_mod); ?></td>
              </tr>       
          	<?php
          $j++;
             }  	
       }
} // end for each
	
 echo "</table>";
 echo "</div>";
 }  else {
 $xml_file = $_POST['xml_file'];
	
	
	
	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xml    = simplexml_load_file($xml_file) or die("Error: Cannot create object");


$sql_update  =   "";
$sql_insert  =   "";
$var_list = '';

?>

<?php

// Omzetten van Xml data in variables

$create_xml       = $xml->create_xml;
$vereniging       = $xml->vereniging->naam;
$vereniging_id    = $xml->vereniging->id;
$toernooi         = $xml->toernooi->naam;

//// string @#@# as eof because of explode

function sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm){

$sql  =  "update config set Waarde = '".$waarde."'  , Parameters = '".$parm."' , Vereniging_id = ".$vereniging_id." , Laatst = now() where Variabele = '".$var."' and Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."';@#@#";
return $sql ;
}


function sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm){
	
$sql =  "insert into config (id, Vereniging, Vereniging_id, Toernooi, Variabele, Waarde, Parameters, Laatst) 
                                          values (0,'".$vereniging."' ,".$vereniging_id.", '".$toernooi."','".$var."','".$waarde."','".$parm."', now() );@#@#";
return $sql ;
}

$var              = 'toernooi_voluit';
$waarde           = $xml->toernooi->toernooi_voluit->waarde;
$parm             = $xml->toernooi->toernooi_voluit->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'url_afbeelding';
$waarde           = $xml->toernooi->url_afbeelding->waarde;
$parm             = $url_afbeelding_parm   = $xml->toernooi->url_afbeelding->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'toegang';
$waarde           = $xml->toernooi->toegang->waarde;
$parm             = $xml->toernooi->toegang->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'soort_inschrijving';
$waarde           = $xml->toernooi->soort_inschrijving->waarde;
$parm             = $xml->toernooi->soort_inschrijving->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'prijzen';
$waarde           = $xml->toernooi->prijzen->waarde;
$parm             = $xml->toernooi->prijzen->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'meld_tijd';
$waarde           = $xml->toernooi->meld_tijd->waarde;
$parm             = $xml->toernooi->meld_tijd->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);


$var              = 'max_splrs';
$waarde           = $xml->toernooi->max_splrs->waarde;
$parm             = $xml->toernooi->max_splrs->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'logo_zichtbaar_jn';
$waarde           = $xml->toernooi->logo_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->logo_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'licentie_jn';
$waarde           = $xml->toernooi->licentie_jn->waarde;
$parm             = $xml->toernooi->licentie_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'kosten_team';
$waarde           = $xml->toernooi->kosten_team->waarde;
$parm             = $xml->toernooi->kosten_team->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'klok_zichtbaar_jn';
$waarde           = $xml->toernooi->klok_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->klok_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'font_koptekst';
$waarde           = $xml->toernooi->font_koptekst->waarde;
$parm             = $xml->toernooi->font_koptekst->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'extra_vraag';
$waarde           = $xml->toernooi->extra_vraag->waarde;
$parm             = $xml->toernooi->extra_vraag->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'extra_koptekst';
$waarde           = $xml->toernooi->extra_koptekst->waarde;
$parm             = $xml->toernooi->extra_koptekst->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'email_cc';
$waarde           = $xml->toernooi->email_cc->waarde;
$parm             = $xml->toernooi->email_cc->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'einde_inschrijving';
$waarde           = $xml->toernooi->einde_inschrijving->waarde;
$parm             = $xml->toernooi->einde_inschrijving->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'datum';
$waarde           = $xml->toernooi->datum->waarde;
$parm             = $xml->toernooi->datum->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'bankrekening_invullen_jn';
$waarde           = $xml->toernooi->bankrekening_invullen_jn->waarde;
$parm             = $xml->toernooi->bankrekening_invullen_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'begin_inschrijving';
$waarde           = $xml->toernooi->begin_inschrijving->waarde;
$parm             = $xml->toernooi->begin_inschrijving->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'bestemd_voor';
$waarde           = $xml->toernooi->bestemd_voor->waarde;
$parm             = $xml->toernooi->bestemd_voor->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'afbeelding_grootte';
$waarde           = $xml->toernooi->afbeelding_grootte->waarde;
$parm             = $xml->toernooi->afbeelding_grootte->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'aanvang_tijd';
$waarde           = $xml->toernooi->aanvang_tijd->waarde;
$parm             = $xml->toernooi->aanvang_tijd->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'aantal_reserves';
$waarde           = $xml->toernooi->aantal_reserves->waarde;
$parm             = $xml->toernooi->aantal_reserves->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'email_organisatie';
$waarde           = $xml->toernooi->email_organisatie->waarde;
$parm             = $xml->toernooi->email_organisatie->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'extra_invulveld';
$waarde           = $xml->toernooi->extra_invulveld->waarde;
$parm             = $xml->toernooi->extra_invulveld->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'ideal_betaling_jn';
$waarde           = $xml->toernooi->ideal_betaling_jn->waarde;
$parm             = $xml->toernooi->ideal_betaling_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'min_splrs';
$waarde           = $xml->toernooi->min_splrs->waarde;
$parm             = $xml->toernooi->min_splrs->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'vereniging_selectie_zichtbaar_jn';
$waarde           = $xml->toernooi->vereniging_selectie_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->vereniging_selectie_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'toernooi_gaat_door_jn';
$waarde           = $xml->toernooi->toernooi_gaat_door_jn->waarde;
$parm             = $xml->toernooi->toernooi_gaat_door_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'boulemaatje_gezocht_zichtbaar_jn';
$waarde           = $xml->toernooi->boulemaatje_gezocht_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->boulemaatje_gezocht_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'url_website';
$waarde           = $xml->toernooi->url_website->waarde;
$parm             = $xml->toernooi->url_website->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'uitgestelde_bevestiging_vanaf';
$waarde           = $xml->toernooi->uitgestelde_bevestiging_vanaf->waarde;
$parm             = $xml->toernooi->uitgestelde_bevestiging_vanaf->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'link_lijst_zichtbaar_jn';
$waarde           = $xml->toernooi->link_lijst_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->link_lijst_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'sms_bevestigen_zichtbaar_jn';
$waarde           = $xml->toernooi->sms_bevestigen_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->sms_bevestigen_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'sms_laatste_inschrijvingen';
$waarde           = $xml->toernooi->sms_laatste_inschrijvingen->waarde;
$parm             = $xml->toernooi->sms_laatste_inschrijvingen->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'achtergrond_kleur_invulvelden';
$waarde           = $xml->toernooi->achtergrond_kleur_invulvelden->waarde;
$parm             = $xml->toernooi->achtergrond_kleur_invulvelden->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'achtergrond_kleur_buttons';
$waarde           = $xml->toernooi->achtergrond_kleur_buttons->waarde;
$parm             = $xml->toernooi->achtergrond_kleur_buttons->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'tekst_kleur';
$waarde           = $xml->toernooi->tekst_kleur->waarde;
$parm             = $xml->toernooi->tekst_kleur->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'link_kleur';
$waarde           = $xml->toernooi->link_kleur->waarde;
$parm             = $xml->toernooi->link_kleur->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'koptekst_kleur';
$waarde           = $xml->toernooi->koptekst_kleur->waarde;
$parm             = $xml->toernooi->koptekst_kleur->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'toernooi_selectie_zichtbaar_jn';
$waarde           = $xml->toernooi->toernooi_selectie_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->toernooi_selectie_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'website_link_zichtbaar_jn';
$waarde           = $xml->toernooi->website_link_zichtbaar_jn->waarde;
$parm             = $xml->toernooi->website_link_zichtbaar_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

$var              = 'toernooi_zichtbaar_op_kalender_jn';
$waarde           = $xml->toernooi->toernooi_zichtbaar_op_kalender_jn->waarde;
$parm             = $xml->toernooi->toernooi_zichtbaar_op_kalender_jn->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);


$var              = 'url_logo';
$waarde           = $xml->toernooi->url_logo->waarde;
$parm             = $xml->toernooi->url_logo->parameter;
$sql_update      .= sqlUpdate( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);
$sql_insert      .= sqlInsert( $toernooi, $vereniging, $vereniging_id, $var, $waarde, $parm);

?>

<blockquote>
	<table width = 40%>
		<tr>
			<th width = 60% >Vereniging      :</th><td><?php echo $vereniging;?>  </td></tr>
			<th width = 60%>Toernooi         :</th><td><?php echo $toernooi;?>     </td></tr>
			<th width = 60%>Aanmaak xml      :</th><td><?php echo $create_xml;?>   </td></tr>
		</table>
	</blockquote>
	<br>
	<fieldset style='padding:5pt;font-family:courier new;font-size:8pt;'    ><legend> Uit te voeren commandos</legend>
		<div id= 'cmds'   onblur="CopyToClipboard(this)">
<?php

if ($_POST['action'] =='update'){
$sql_line      = explode("@#@#", $sql_update);   /// opsplitsen in aparte regels 
 $i=0;
    while ( $sql_line[$i] <> ''){    
  
    	  if (strlen($sql_line[$i]) > 2 ){
     	echo $sql_line[$i]."<br>";
   /////       mysql_query($sql_line[$i]) or die ('Fout in update line '.$i); 
        }
        $i++;
  } // while
} // end if
             
if ($_POST['action'] =='insert' ){
$sql_line      = explode("@#@#", $sql_insert);   /// opsplitsen in aparte regels 
 $i=0;
    while ( $sql_line[$i] <> ''){    
  
    	  if (strlen($sql_line[$i]) > 2 ){
    	  	echo $sql_line[$i]."<br>";
     ///     mysql_query($sql_line[$i]) or die ('Fout in insert line '.$i); 
        }
        $i++;
  } // while
}// end if

?>
</div>
</fieldset>
<br>
<form name="test2">
<input type="button" onClick="SelectRange('cmds')" value="Select " />
<input type="button" onClick="CopyToClipboard()" value="Copy to Clipboard " />
</form>




<a href ='restore_config_xml.php' target='_top'>Klik hier voor opnieuw selecteren</a>
<?php

}// end if input

?>

</body>
</html>