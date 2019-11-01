<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst wizard inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css" media="print">
	

body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:blue;font-size: 11pt;background-color:white;font-family: Comic sans, sans-serif, Verdana; }
td {color:black;font-size: 11pt;font-family: Comic sans, sans-serif, Verdana; }
.noprint {display:none;}             

table {border-collapse: collapse;}
</style>

<script type="text/javascript">
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
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>


</head>

<?php 
//// Database gegevens. 

include ('mysqli.php');
//include ('../ontip/versleutel_string.php'); // tbv telnr en email


/// encrypten van string  (begin altijd met @##)

function versleutel_string($_text)
{
	// key_string moet even lang zijn als max email 
$key_string = "R00489659994743393930384774774747474747477777777777779383939337861326361271327132781327813278132713271727132771327127127127127171777777777777737373717181871129726432954265316abc5432189765";
$encrypt    = '';
$key_index  = substr($key_string,1,3);
$asc_string = '';

$len = strlen($_text);
$pos =  '';
$pos = strpos($_text,"##");

// init arrays

$asc_w= array();
$asc_k= array();
$k_bit= array();
$w_bit= array();
$e_bit= array();
$bin_w= array();
$bin_k= array();
$bin_e= array();
$dec_e= array();


// bepaal richting van decrypt
if ($pos  != 1){
	

	$k   = 0 ;
// echo $len;

for ($i=0;$i<$len;$i=$i+3){
	
	// conversie letter naar ascii waarde
	 $z        = $k+$key_index;
	 $asc_w[$k]= substr($_text,$i,3);
	 $asc_k[$k]= ord(substr($key_string,$z,1));
		 
	 // conversie ascii waarde letter naar binary waarde
	 // add leading zero to bin to len 8
	 
	 $bin_w[$k] = sprintf('%08d', decbin($asc_w[$k]));
	 $bin_k[$k] = sprintf('%08d', decbin($asc_k[$k]));
	 $bin_e[$k] = '';
	   
	 ///  compare and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$k],$j,1);
	  $k_bit[$j] = substr($bin_k[$k],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {             /// vergelijk met sleutelwaarde
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  =1;
	  }
	 $bin_e[$k] = $bin_e[$k].$e_bit[$j];
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$k] = sprintf('%03d',bindec($bin_e[$k]));

	
	 /// plak de chars tot een woord
	 $encrypt = $encrypt.chr($dec_e[$k]);
$k++;	
} /// end for i
	
/// return encrypte waarde
return $encrypt;
		
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////
else {
	 $bin_e = '';
	$_text = substr($_text,3,$len-2);
// encrypt  (vanaf pos 3 ivm @##)
for ($i=0;$i<$len-3;$i++){
	
   // conversie letter naar ascii waarde
	 $z        = $i+$key_index;
	 $asc_w[$i]= ord(substr($_text,$i,1));
	 $asc_k[$i]= ord(substr($key_string,$z,1));
	 
	 // conversie ascii waarde letter naar binary waarde
	 $bin_w[$i] = decbin($asc_w[$i]);
	 $bin_k[$i] = decbin($asc_k[$i]);
	 
	 // add leading zero to bin to len 8
	 $bin_w[$i] = sprintf('%08d', decbin($asc_w[$i]));
	 $bin_k[$i] = sprintf('%08d', decbin($asc_k[$i]));
	 
	 ///  compare bit by bit and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$i],$j,1);
	  $k_bit[$j] = substr($bin_k[$i],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  = 1;
	  }
	  
	  
	  if (!isset($bin_e[$i])) {
	  	$bin_e[$i] ='';
	 }   	
	
 	 $bin_e[$i] = $bin_e[$i].$e_bit[$j];
	
	
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$i] = sprintf('%03d',bindec($bin_e[$i]));

	/// plak de chars tot een woord
	$encrypt    = $encrypt.chr($dec_e[$i]);
	$asc_string = $asc_string.$dec_e[$i];
	 
	 
} /// end for i
 
/// return decimale asc string encrypte ivm mogelijke HTML waarden

return $asc_string;
} // end else
} // end function





/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


if (isset($_GET['toernooi'])) {
$toernooi = $_GET['toernooi'];
}

function leeftijd($datum) { 
list($dag,$maand,  $jaar) = explode('-', $datum); 
$leeftijdvanpersoon = date('Y') - $jaar; 

if ($maand > date('m')) { 
$leeftijdvanpersoon--; 
} 
if ($maand == date('m') && $dag > date('d')) { 
$leeftijdvanpersoon--; 
} 
$leeftijdvanpersoon .= ' jaar'; 
return $leeftijdvanpersoon; 
} 


// anders via POST
if (isset($_POST['toernooi'])) {
$toernooi = $_POST['toernooi'];
}

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

// ophalen parameters

// neem parameters op in array
if (isset($_GET['cols'])) {
$cols       = $_GET['cols'];
$array      = explode(',', $_GET['cols']) ;

// Maak van ieder argument een variabele aan

foreach ($array as $i => $value) {
         $var  = $array[$i];
         $$var = $value;
	
} // end foreach
} // end get

// anders via POST

if (!isset($_GET['cols'])) {

$cols   = '';

if (isset($_POST['Regel'])) {
	   $Regel = $_POST['Regel'];
	   $cols  = $cols.'Regel,';
}

if (isset($_POST['Naam1'])) {
	 $Naam1 =  $_POST['Naam1'];
   $cols  = $cols.'Naam1,';
}

if (isset($_POST['Naam2'])) {
	$Naam2 =  $_POST['Naam2'];
  $cols  = $cols.'Naam2,';
}

if (isset($_POST['Naam3'])) {
	$Naam3 =  $_POST['Naam3'];
  $cols  = $cols.'Naam3,';
}
if (isset($_POST['Naam4'])) {
	 $Naam4 =  $_POST['Naam4'];  
	 $cols  = $cols.'Naam4,';
}

if (isset($_POST['Naam5'])) {
	$Naam5 =  $_POST['Naam5'];
  $cols  = $cols.'Naam5,';
}
if (isset($_POST['Naam6'])) {
   $Naam6 =  $_POST['Naam6'];
   $cols  = $cols.'Naam6,';
}

if (isset($_POST['Licentie1'])) {
	$Licentie1 =  $_POST['Licentie1'];
  $cols      = $cols.'Licentie1,';
}
	
if (isset($_POST['Licentie2'])) {
	$Licentie2 =  $_POST['Licentie2'];
  $cols      = $cols.'Licentie2,';
	}
if (isset($_POST['Licentie3'])) {
	$Licentie3 =  $_POST['Licentie3'];
  $cols      = $cols.'Licentie3,';
}
if (isset($_POST['Licentie4'])) {
	$Licentie4 =  $_POST['Licentie4'];
  $cols      = $cols.'Licentie4,';
	}
if (isset($_POST['Licentie5'])) {
	$Licentie5 =  $_POST['Licentie5'];
  $cols      = $cols.'Licentie5,';
}
if (isset($_POST['Licentie6'])) {
	$Licentie6 =  $_POST['Licentie6'];
  $cols      = $cols.'Licentie6,';
}

if (isset($_POST['Vereniging1'])) {
	$Vereniging1 =  $_POST['Vereniging1'];
  $cols       = $cols.'Vereniging1,';
}
if (isset($_POST['Vereniging2'])) {
	$Vereniging2 =  $_POST['Vereniging2'];
  $cols        = $cols.'Vereniging2,';
}
if (isset($_POST['Vereniging3'])) {
	$Vereniging3 =  $_POST['Vereniging3'];
  $cols        = $cols.'Vereniging3,';
}
if (isset($_POST['Vereniging4'])) {
	$Vereniging4 =  $_POST['Vereniging4'];
  $cols        = $cols.'Vereniging4,';
}
if (isset($_POST['Vereniging5'])) {
	$Vereniging5 =  $_POST['Vereniging5'];
  $cols        = $cols.'Vereniging5,';
}
if (isset($_POST['Vereniging6'])) {
	$Vereniging6 =  $_POST['Vereniging6'];
  $cols        = $cols.'Vereniging6,';
}

if (isset($_POST['Telefoon']))              {
	$Telefoon               =  $_POST['Telefoon'];
  $cols                   = $cols.'Telefoon,';
}
if (isset($_POST['Email']))                 {
	$Email                  =  $_POST['Email'];
  $cols                   = $cols.'Email,';
}
if (isset($_POST['Extra_vraag']))           {
	$Extra_vraag            =  $_POST['Extra_vraag'];
  $cols                   = $cols.'Extra_vraag,';
  }   

if (isset($_POST['Extra_invulveld']))           {
	$Extra_invulveld          =  $_POST['Extra_invulveld'];
  $cols                   = $cols.'Extra_invulveld,';
}   
  
if (isset($_POST['Bank_rekening']))         {
	$Bank_rekening          =  $_POST['Bank_rekening'];
  $cols                   = $cols.'Bank_rekening,';
}    
if (isset($_POST['Betaal_datum']))          {
	$Betaal_datum           =  $_POST['Betaal_datum'];
  $cols                   = $cols.'Betaal_datum,';
}     
if (isset($_POST['Bevestiging_verzonden'])) {
	$Bevestiging_verzonden  =  $_POST['Bevestiging_verzonden'];
  $cols                   = $cols.'Bevestiging_verzonden,';
}
if (isset($_POST['Status']))                {
	$Status                 =  $_POST['Status'];
  $cols                   = $cols.'Status,';
}           
if (isset($_POST['Opmerkingen']))           {
	$Opmerkingen            =  $_POST['Opmerkingen'];
  $cols                   = $cols.'Opmerkingen,';
}      
if (isset($_POST['Inschrijving']))          {
	$Inschrijving           =  $_POST['Inschrijving'];
  $cols                   = $cols.'Inschrijvingen,';
}     

$cols = substr($cols,0,-1);// remove last char


}/// end if not GET

/// Ophalen tekst kleur

$qry  = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  

$row        = mysqli_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

/// als achtergrondkleur niet gevonden in tabel, zet dan default waarden
if ($tekstkleur ==''){ $tekstkleur = 'black';};
if ($koptekst   ==''){ $koptekst   = 'red';};
if ($invulkop   ==''){ $invulkop   = 'blue';};
if ($link       ==''){ $link       = 'blue';};

/// Afwijkende font voor koptekst

if (!isset($font_koptekst)){
 	$font_koptekst='';
}

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Lijst inschrijvingen - <?php echo  $toernooi_voluit; ?>";
</script> 
<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table border =0 width=90%>"; 
echo "<tr><td style='background-color:".$achtergrond_kleur.";'><img src='".$url_logo."' width='".$grootte_logo.">";
echo "</td><td style='background-color:".$achtergrond_kleur.";'>";
echo"<h1 style='color:".$koptekst. ";font-family:".$font_koptekst.";'>Lijst inschrijvingen voor ". $toernooi_voluit ."</h1><h3>";
echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ;
echo "</h3></td></tr>";
echo "</table><br>";

?>

<table border =1 id='myTable' style='background-color:white;'>
 <tr>
 	
 	<?php if (isset($Regel)) {?>
   <th>Nr</th>
 <?php } ?>
 	
 
 <?php if (isset($Naam1)) {?>
   <th>Naam speler 1</th>
 <?php } ?>
 
 <?php if (isset($Licentie1)) {?>
   <th>Licentie speler 1</th>
 <?php } ?>
 
 <?php if (isset($Vereniging1)) {?>
   <th>Vereniging speler 1</th>
 <?php } ?>
  
<?php if (isset($Naam2)) {?>
   <th>Naam speler 2</th>
 <?php } ?>

 <?php if (isset($Licentie2)) {?>
   <th>Licentie speler 2</th>
 <?php } ?>
 
 <?php if (isset($Vereniging2)) {?>
   <th>Vereniging speler 2</th>
 <?php } ?>
 
 <?php if (isset($Naam3)) {?>
   <th>Naam speler 3</th>
 <?php } ?>

 <?php if (isset($Licentie3)) {?>
   <th>Licentie speler 3</th>
 <?php } ?>
 
 <?php if (isset($Vereniging3)) {?>
   <th>Vereniging speler 3</th>
 <?php } ?>
   
 <?php if (isset($Naam4)) {?>
   <th>Naam speler 4</th>
 <?php } ?>

 <?php if (isset($Licentie4)) {?>
   <th>Licentie speler 4</th>
 <?php } ?>
 
 <?php if (isset($Vereniging4)) {?>
   <th>Vereniging speler 4</th>
 <?php } ?>
 
 <?php if (isset($Naam5)) {?>
   <th>Naam speler 5</th>
 <?php } ?>

 <?php if (isset($Licentie5)) {?>
   <th>Licentie speler 5</th>
 <?php } ?>
 
 <?php if (isset($Vereniging5)) {?>
   <th>Vereniging speler 5</th>
 <?php } ?>

 <?php if (isset($Naam6)) {?>
   <th>Naam speler 6</th>
 <?php } ?>

 <?php if (isset($Licentie6)) {?>
   <th>Licentie speler 6</th>
 <?php } ?>
 
 <?php if (isset($Vereniging6)) {?>
   <th>Vereniging speler 6</th>
 <?php } ?>

 <?php if (isset($Telefoon)) {?>
   <th>Telefoon contact</th>
 <?php } ?>

 <?php if (isset($Email)) {?>
   <th>Email contact</th>
 <?php } ?>

 <?php if (isset($Extra_vraag)) {
 	 $opties = explode(";",$extra_vraag,6);
   $vraag  = $opties[0];
 ?>
   <th><?php echo $vraag;?></th>
 <?php } ?>

 <?php if (isset($Extra_invulveld)) {?>
   <th><?php echo $extra_invulveld;?></th>
 <?php } ?>

 <?php if (isset($Bank_rekening)) {?>
   <th>Bankrekening</th>
 <?php } ?>
     
 <?php if (isset($Betaal_datum)) {?>
   <th>Betaal datum</th>
 <?php } ?>

 <?php if (isset($Bevestiging_verzonden)) {?>
   <th>Bevestiging verzonden</th>
 <?php } ?>

 <?php if (isset($Status)) {?>
   <th>Status</th>
 <?php } ?>
              
 <?php if (isset($Opmerkingen)) {?>
   <th>Opmerkingen</th>
 <?php } ?>
                       
 <?php if (isset($Inschrijving)) {?>
   <th>Tijdstip inschrijving</th>
 <?php } ?>

</tr>

<?php

//// SQL Queries
$inschrijvingen      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die(mysql_error());  

$i=1;
while($row = mysqli_fetch_array( $inschrijvingen )) {
?>
<tr>
	
	<?php if (isset($Regel)) {?>
	  <td><?php echo $i;?>.</td>
	 <?php } ?>
	 
	 
 <?php if (isset($Naam1)) {?>
   <td><?php echo $row['Naam1'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie1)) {?>
   <td><?php echo $row['Licentie1'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging1)) {?>
 <td><?php echo $row['Vereniging1'];?></td>
  <?php } ?>
  
    <?php if (isset($Naam2)) {?>
   <td><?php echo $row['Naam2'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie2)) {?>
   <td><?php echo $row['Licentie2'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging2)) {?>
 <td><?php echo $row['Vereniging2'];?></td> 
 <?php } ?>
  <?php if (isset($Naam3)) {?>
   <td><?php echo $row['Naam3'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie3)) {?>
   <td><?php echo $row['Licentie3'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging3)) {?>
 <td><?php echo $row['Vereniging3'];?></td>
  <?php } ?>

 <?php if (isset($Naam4)) {?>
   <td><?php echo $row['Naam4'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie4)) {?>
   <td><?php echo $row['Licentie4'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging4)) {?>
 <td><?php echo $row['Vereniging4'];?></td> 
 <?php } ?>

 <?php if (isset($Naam5)) {?>
   <td><?php echo $row['Naam5'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie5)) {?>
   <td><?php echo $row['Licentie5'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging5)) {?>
 <td><?php echo $row['Vereniging5'];?></td> 
 <?php } ?>


 <?php if (isset($Naam6)) {?>
   <td><?php echo $row['Naam6'];?></td>
 <?php } ?>
 
 <?php if (isset($Licentie6)) {?>
   <td><?php echo $row['Licentie6'];?></td>
 <?php } ?>
 
 <?php if (isset($Vereniging6)) {?>
 <td><?php echo $row['Vereniging6'];?></td>
  <?php } ?>


 <?php if (isset($Telefoon)) {
 	
   if ($row['Telefoon']=='[versleuteld]'){ 
        $Telefoon            = versleutel_string($row['Telefoon_encrypt']);    
    } else {
    	$Telefoon            = $row['Telefoon'];
   }  	?>
 <td><?php echo $Telefoon;?></td>
 <?php } ?>

 <?php if (isset($Email)) {
 	if ($row['Email']  =='[versleuteld]'){ 
   $Email      = versleutel_string($row['Email_encrypt']);    
 	} else {
 		$Email = $row['Email'];
 } 	?>

   <td><?php echo $Email;?></td>
 <?php } ?>



 
 <?php if (isset($Extra_vraag)) {?>
   <td><?php echo $row['Extra'];?></td>
 <?php } ?>

 <?php if (isset($Extra_invulveld)) {?>
   <td><?php echo $row['Extra_invulveld'];?></td>
 <?php } ?>



 <?php if (isset($Bank_rekening)) {?>
  <td><?php echo $row['Bank_rekening'];?></td>
 <?php } ?>
     
 <?php if (isset($Betaal_datum)) {?>
   <td><?php echo $row['Betaal_datum'];?></td>
 <?php } ?>

 <?php if (isset($Bevestiging_verzonden)) {?>
  <td><?php echo $row['Bevestiging_verzonden'];?></td>
 <?php } ?>

<?php if (isset($Status)) {
	
 switch ($row['Reservering']){ 
  case "1": $status = 'Nog niet betaald.'; break;
  case "2": $status = 'Betaald maar nog niet bevestigd.'; break;
  case "3": $status = 'Betaald en bevestigd.'; break;
  case "4": $status = 'Nog niet betaald.Geen email bekend.'; break;
  case "5": $status = 'Inschrijving afgewezen.'; break;
  case "6": $status = 'Nog niet bevestigd.'; break;
  case "7": $status = 'Bevestigd.'; break;
  case "8": $status = 'Nog niet bevesigd. Geen email bekend.'; break;
  case "9": $status = 'Inschrijving afgewezen.Geen email bekend.'; break;
  case "A": $status = 'Betaald. Geen email bekend.'; break;
  case "I": $status = 'Betaald via IDEAL en bevestigd.'; break;
  case "X": $status = 'Betaling via IDEAL mislukt of afgebroken.'; break;
  case "D": $status = 'Verzoek om intrekken ontvangen.'; break;
  case "J": $status = 'Reserve.'; break;
  case "N": $status = 'Ingeschreven.'; break;
  default:  $status = 'Status onbekend.'; break;
 } // end switch
 ?>
 <td><?php echo $status;?></td>
 <?php } ?>
 
              
 <?php if (isset($Opmerkingen)) {?>
  <td><?php echo $row['Opmerkingen'];?></td>
 <?php } ?>
                       
 <?php if (isset($Inschrijving)) {?>
   <td><?php echo $row['Inschrijving'];?></td>
 <?php } ?>
 
</tr> 
<?php
$i++;
 } 
 ?>
</table><br>
<br>

	<!--  Knoppen voor verwerking   ----->
<TABLE class='noprint'>
	<tr>
		<!--td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable'))" value="Select & Copy to clipboard" />
</form>
</td-->
<td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;'> 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
</tr>
<tr>
<td><a href = '<?php echo $prog_url;?>lijst_wizard_inschrijvingen_stap2.php?toernooi=<?php echo $toernooi;?>&cols=<?php echo $cols;?>'>Klik hier voor de link om deze lijst instelling vervolgens als favoriet te kunnen opslaan.</a></td>
</tr>
</table>
<div style='font-size:9pt;'>(c) Copyright by Erik Hendrikx &#169 2013 e.v</div>
</body>
</html>