<html>
<head>
<title>Zelf OnTip inschrijving muteren</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="js/utility.js"></script>
<script src="js/popup.js"></script>

<style type=text/css>
body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 10pt;background-color:white;}
h3 {color:red;font-size: 14pt;background-color:white;}
tab.th {color:blue;font-size:11pt;background-color:white;}      
td {color:brown;font-size: 10pt;padding:3pt;}
a    {text-decoration:none;color:blue;font-size: 8pt;}
li  {font-size:9pt;}
input:focus, input.sffocus { background-color: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }

.popup { POSITION: absolute;right:900px;VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 390; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }

#del   {background-color:red;border: 1pt solid red;} 

.tab  {color:blue;font-size:11pt;background-color:white;text-align:left;padding:5pt;width:160pt;}  
.tabh1  {color:blue;font-size:10pt;background-color:white;text-align:left;padding:5pt;width:160pt;}}  
.tabh2  {color:blue;font-size:10pt;background-color:white;text-align:left;padding:5pt;width:80pt;}}  

.sel  {color:black;font-size:11pt;background-color:white;text-align:left;padding:5pt;}  


</style>
 <!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("INPUT");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onfocus=function() {
            this.className+=" sffocus";
        }
        sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfFocus);
     -->
function make_blank()
{
	document.Form1.Opmerkingen.value="";
}

function make_blank_spam2()
{
	document.Form2.respons.value="";
}

function make_blank_spam()
{
	document.Form1.respons.value="";
}


function change(that, fgcolor, bgcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}  
</Script>
</head>

<?php 
ob_start();

include('mysql.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email

?>
<body bgcolor=white>
<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL);

$tekstkleur = 'black'; 
$koptekst   = 'red';

/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

$string = '';

if (!isset($toernooi)) {
   $toernooi              = $_GET['toernooi'];
}
   $variabele             = 'toernooi_voluit';
   $qry_config            = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
   $result_c              = mysql_fetch_array( $qry_config);
   $toernooi_voluit       = $result_c['Waarde'];

?>


<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">

<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD>
</tr>
</TABLE>

<hr color='red'/>
<br>


<?php 
if (!isset($_GET['Id'])){
?>
<div style='color:black;font-size:10pt;font-family:arial;'>Met behulp van deze pagina kan je je eigen inschrijving aanpassen.<br>
       </div><br>
       
<FORM action='zelf_inschrijving_muteren_stap2.php' method='post' name ='Form1'>

 
<fieldset style='border:1px solid <?php echo $koptekst; ?>;width:95%;padding:15pt;background-color:white'>
    <legend style='left-padding:5pt;color:<?php echo $koptekst; ?>;font-size:12pt;font-family:Verdana;'>Ik wil mijn inschrijving aanpassen</legend>

<font face='comic sans ms,sans-serif' color='white'>Vul hier je gegevens in.</font>

<h3>Vul het kenmerk en de naam van speler1 van uw inschrijving in</h3>
<table border = '0'>
<tr><th width='150' class='tab'>Toernooi</th><td style='border 1pt solid;'><?php echo $toernooi_voluit;?></td></tr>
<tr><th width='200' class='tab'>Kenmerk inschrijving *</th><td><input type='text'    name='Kenmerk'       size=15/></td></tr>
<tr><th width='200' class='tab'>Naam speler 1**</th><td><input type='text'           name='Naam1'         size=15/></td></tr>
</table>
<br>* Kenmerk inschrijving staat op de bevestigingsmail. <br>** Naam moet exact gelijk zijn aan de naam uit de oorspronkelijke inschrijving. 
<br><br>
<INPUT type='submit' value='Gegevens opvragen' >
</FORM>
</fieldset>

<?php } 
else { 
?>	
	<div style='color:black;font-size:10pt;font-family:arial;'>Met behulp van deze pagina kan je je eigen inschrijving aanpassen.<br>
       Na invullen van deze pagina wordt een mail gestuurd naar de organisatie.</div><br>
<?php
$string = '';

///// Id is gevonden

$kenmerk  = $_GET['Kenmerk'];


$qry_inschrijving      = mysql_query("SELECT * from inschrijf Where Id = '".$_GET['Id']."'  " )    or die('Inschrijving niet gevonden ! ');  
$result_i              = mysql_fetch_array( $qry_inschrijving  );
$toernooi              = $result_i['Toernooi'];

$email= $result_i['Email'];
$telefoon= $result_i['Telefoon'];


   if ($email =='[versleuteld]'){
   	$email =  versleutel_string($result_i['Email_encrypt']);
   }
    $telefoon = $result_i['Telefoon'];
   if ($telefoon =='[versleuteld]'){
   	$telefoon =  versleutel_string($result_i['Telefoon_encrypt']);
   }
$variabele             = 'toernooi_voluit';
$qry_config            = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$toernooi_voluit       = $result_c['Waarde'];

$variabele             = 'licentie_jn';
$qry_config            = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$licentie_verplicht    = $result_c['Waarde'];

$variabele             = 'soort_inschrijving';
$qry_config            = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$soort_inschrijving    = $result_c['Waarde'];

$variabele             = 'datum';
$qry_config            = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$variabele."' ")     or die(' Fout in select');  
$result_c              = mysql_fetch_array( $qry_config);
$datum                 = $result_c['Waarde'];
$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$font_koptekst = 'Verdana';


switch ($soort_inschrijving){
	case 'single': $soort = 'Mêlée'; break;
	default : $soort = $soort_inschrijving; break;
}


?>
<FORM action='zelf_inschrijving_muteren_stap3.php' method='post' name ='Form1'>

 
<fieldset style='border:1px solid <?php echo $koptekst; ?>;width:95%;padding:15pt;background-color:white'>
    <legend style='left-padding:5pt;color:<?php echo $koptekst; ?>;font-size:12pt;font-family:Verdana;'>Ik wil mijn inschrijving aanpassen</legend>

<font face='comic sans ms,sans-serif' color='white'>Vul hier je gegevens in.</font>
 <input type='hidden' name ='Id' value ='<?php echo $_GET['Id']; ?>'/>
 <input type='hidden' name ='Kenmerk' value ='<?php echo $kenmerk; ?>'/>
 
<table border = '0'>
<tr><th width='150' class='tab'>Toernooi</th><td style='border 1pt solid;'><?php echo $toernooi_voluit;?></td></tr>
<tr><th width='150' class='tab'>Vereniging</th><td style='border 1pt solid;'><?php echo $vereniging;?></td></tr>
<tr><th width='150' class='tab'>Datum</th><td style='border 1pt solid;'><?php echo $datum;?></td></tr>
<tr><th class='tab'>Soort toernooi</th><td style='border 1pt solid;'><?php echo ucfirst($soort);?></td></tr>
<tr><th width='150' class='tab'>Kenmerk inschrijving</th><td style='border 1pt solid;'><?php echo $kenmerk;?></td></tr>
</table>

<!--//// Volgende spelers ------------------  Deze kunnen gemuteerd worden ------------------------------>
<table border = '0'>
	<tr><th class='tabh1'>Naam speler 1</th><td><input type='text'         name='Naam1'    value='<?php echo $result_i['Naam1'];?>'     size=30/></td>
<?php
if ($licentie_verplicht =='J'){ ?>
<th class='tabh2'>Licentie speler 1</th><td><input type='text'   name='Licentie1'  value='<?php echo $result_i['Licentie1'];?>'    size=10/></td>
<?php }		?>
<th class='tabh2'>Vereniging speler 1</th><td><input type='text'   name='Vereniging1' value='<?php echo $result_i['Vereniging1'];?>'  size=40/></td></tr>
<?php
if ($soort == 'doublet' or $soort == 'triplet' or $soort == 'kwintet' or $soort == 'sextet') { ?>
<tr><th class='tabh1'>Naam speler 2</th><td><input type='text'         name='Naam2'    value='<?php echo $result_i['Naam2'];?>'     size=30/></td>
 <?php
if ($licentie_verplicht =='J'){ ?>
	<th class='tabh2'>Licentie speler 2</th><td><input type='text'   name='Licentie2'  value='<?php echo $result_i['Licentie2'];?>'    size=10/></td>
<?php } ?>
<th class='tabh2'>Vereniging speler 2</th><td><input type='text'   name='Vereniging2' value='<?php echo $result_i['Vereniging2'];?>' size=40/></td></TR>
<?php }		?>

<?php
if ( $soort == 'triplet' or $soort == 'kwintet' or $soort == 'sextet') { ?>
<TR><th class='tabh1'>Naam speler 3</th><td><input type='text'         name='Naam3'     value='<?php echo $result_i['Naam3'];?>'     size=30/></td>
	<?php
if ($licentie_verplicht =='J'){ ?>
<th class='tabh2'>Licentie speler 3</th><td><input type='text'   name='Licentie3'   value='<?php echo $result_i['Licentie3'];?>'   size=10/></td>
<?php } ?>
<th class='tabh2'>Vereniging speler 3</th><td><input type='text'   name='Vereniging3' value='<?php echo $result_i['Vereniging3'];?>' size=40/></td></tr>
<?php }		?>

<?php
if ( $soort == 'kwintet' or $soort == 'sextet') { ?>
<tr><th class='tabh1'>Naam speler 4</th><td><input type='text'         name='Naam4'     value='<?php echo $result_i['Naam4'];?>'      size=30/></td>
<?php
if ($licentie_verplicht =='J'){ ?>
<th class='tabh2'>Licentie speler 4</th><td><input type='text'   name='Licentie4'   value='<?php echo $result_i['Licentie4'];?>'   size=10/></td>
<?php } 	?>
<th class='tabh2'>Vereniging speler 4</th><td><input type='text'   name='Vereniging4' value='<?php echo $result_i['Vereniging4'];?>'  size=40/></td></tr>
	
<tr><th class='tabh1'>Naam speler 5</th><td><input type='text'         name='Naam5'     value='<?php echo $result_i['Naam5'];?>'      size=30/></td>
	<?php
if ($licentie_verplicht =='J'){ ?>
<th class='tabh2'>Licentie speler 5</th><td><input type='text'   name='Licentie5'   value='<?php echo $result_i['Licentie5'];?>'   size=10/></td>
<?php } ?>
<th class='tabh2'>Vereniging speler 5</th><td><input type='text'   name='Vereniging5' value='<?php echo $result_i['Vereniging5'];?>'  size=40/></td></tr>
<?php  }	?>

<?php
if (  $soort == 'sextet') { ?>
<tr><th class='tabh1'>Naam speler 6</th><td><input type='text'         name='Naam6'     value='<?php echo $result_i['Naam6'];?>'      size=30/></td></tr>
	<?php
if ($licentie_verplicht =='J'){ ?>
<th class='tabh2'>Licentie speler 6</th><td><input type='text'   name='Licentie6'   value='<?php echo $result_i['Licentie6'];?>'   size=10/></td></tr>
<?php } 	?>		
<th class='tabh2'>Vereniging speler 6</th><td><input type='text'   name='Vereniging6' value='<?php echo $result_i['Vereniging6'];?>'  size=40/></td></tr>
<?php  }	?>
</table>

<table border = '0'
<tr><th class='tab'>Email      </th><td><label><input type='email'  name='Email'           value='<?php echo $email;?>'   size=40/></label></td></tr>
<tr><th class='tab'>Telefoon   </th><td><label><input type='text'  name='Telefoon'     value='<?php echo $telefoon;?>'   size=40/></label></td></tr>
<tr>
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	  $string = '';
	  $length = 4;
	  
	  if( !isset($string )) { $string = '' ; }
	  
    $characters = "2345678923456789";
    if( !isset($string )) { $string = '' ; }
    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
       
?>
	 <th class='tab' >Anti Spam</th>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="18" class="pink" Value='Typ hier code woord' style='font-size:10pt;' onclick="make_blank_spam();" >
        	
   <?php
   echo "<span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'><b>". $string."</b></span>
   <em><span style='font-size:9pt;'><em> <-- code woord.</span></em>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>

</table>
<br><br>
</span>


<br><br>
<INPUT type='submit' value='Wijzigingen versturen' >
</FORM>


<?php
} /// Id gevonden

ob_end_flush();
?> 
</body>
</html>

