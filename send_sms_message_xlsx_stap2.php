<?php 
# send_sms_message_xlsx_stap2.php
# Scherm om deelnemeres uit xslx bestand te selecteren die een SMS krijgen. 
# aangeroepen vanuit send_sms_message_xlsx_stap1.php
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 24mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Verkleinen input veld voor bestandsnaam
# Reference: 
?>
<html>
<head>
<title>Send SMS tbv inschrijvingen</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:blue;font-size: 8pt;background-color:white;}
td {color:brown;font-size: 8pt;}
a    {text-decoration:none;color:blue;font-size:9pt;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }
</style>

<Script Language="Javascript">
function make_blank1()
{
	document.myForm.respons.value="";
}
</script>

<Script Language="Javascript">
function make_blank2()
{
	document.myForm2.respons.value="";
}
</script>
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
</Script>
</head>



<?php 

//// Database gegevens. 
include ('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email

$toernooi      = $_POST['toernooi'];
$bevestigen    = $_POST['Bevestigen'];
$aantal_sms    = $_POST['aantal'];
$sms_tekst     = $_POST['smstekst'];
$replace       = "toernooi=".$toernooi."";
//echo $toernooi;

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana;font-weight:normal;';



if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
		exit;
	 
};
	
if (!isset($sms_bevestigen_zichtbaar_jn)) {
	$sms_bevestigen_zichtbaar_jn = 'N';
}
//include('action.php');
// naar csv folder omdat xlsx nog niet bestaat bij meeste verenigingen
$paths            = "/public_html/".substr($prog_url,3, strlen($prog_url))."csv/";

$ftp_server       = $_POST['server'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;
$name             = $_FILES['userfile']['name'];
$source_file      = $_FILES['userfile']['tmp_name'];
$toernooi         = $_POST['toernooi'];
$timest           = date('ymdhis');
$destination_file = $paths.'sms_'.$toernooi."_".$timest.'.xlsx';

if ($name  == '')
{
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Geen bestand geselecteerd !")
		  window.location.replace('send_sms_message_xlsx_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// set up a connection to ftp server
$conn_id          = ftp_connect($ftp_server);
ftp_pasv($conn_id,TRUE);
 
// login with username and password
$login_result     = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
 
// check connection and login result
if ((!$conn_id) || (!$login_result)) {
	$error = 1;
	?>
	<script type="text/javascript">
	   	alert("Probleem met verbinding maken met server!" + '\r\n' +
	          "Server : <?php echo  $ftp_server; ?> en user : <?php echo  $ftp_user_name; ?>")
		 	window.location.replace('send_sms_message_xlsx_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
}

// upload the file to the path specified

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
 
 //echo "Download locatie : ". $paths."<br>";
 // echo "Source file      : ". $name;
 
  
// check the upload status
if (!$upload) {
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Bij uploaden is er iets fout gegaan!" + '\r\n' + 
	          "Download locatie : <?php echo  $paths; ?>" + '\r\n' +
	          "Source file      : <?php echo  $name; ?>")
		  window.location.replace('send_sms_message_xlsx_stap1.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php
  } 
// close the FTP connection
ftp_close($conn_id);	

//////////////////////////////////////////////////////////////////////////////////////////////
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

$inputFileName = 'csv/sms_'.$toernooi."_".$timest.'.xlsx';

$objReader   = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($inputFileName);

?>
<body >
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>

</div>
<hr color='red'/>

<table width=99%><tr>
	<td style='text-align:left;'><a href='index.php'>Terug naar Hoofdmenu</a></td>
	<td style='text-align:right;'><a href='send_sms_message_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?> '>Terug naar selectie</a></td>
</tr>
</table>

<FORM action="send_sms_message_xlsx_stap3.php" method="post" name= "myForm">
<input type="hidden" name="toernooi" value="<?php echo $toernooi;?>" />


<blockquote>

<?php

echo "<h3 style='padding:10pt;font-size:20pt;color:green;'>Verzenden SMS tbv  ".$toernooi_voluit ." &nbsp<img src = '../ontip/images/sms_bundel.jpg' width=45 border =0 ></h3>";

  
 if ($sms_bevestigen_zichtbaar_jn == 'J'){
      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<table><tr><td><blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></td><td style='vertical-align:top;'><img src='../ontip/images/icon_excel.png' width=100></td></tr></table></blockquote><br>";
  }


echo "<blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' width=60%><tr>
  <td style='background-color: darkblue;color:white;font-size:9pt;padding:8pt;text-align:center;' width=10%>SMS tekst</td>
  <td <td style='background-color: white;color:black;font-size:10pt;width:25pt;text-align:left;padding:4pt;'> ".$sms_tekst."</td></tr></table><br>";
 ?>
<br>

<?php
   
 //  Koptekst 

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>";
echo "<tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";' width=30>Check</th>";
echo "<th style='". $th_style.";'         >Naam</th>";
echo "<th style='". $th_style.";'         >Vereniging</th>";
echo "<th style='". $th_style.";'>Tel.nr</th>";
echo "</tr>";
$max_lines = 150;
  $j=1;

/// Detail regels uit Excel
	// vanaf regel 3. 
 for ($i=3;$i < $max_lines;$i++){

  	
       	$volgnr      = $objPHPExcel->setActiveSheetIndex(0)->getCell('A'.$i)->getCalculatedValue();
       	$naam1       = $objPHPExcel->setActiveSheetIndex(0)->getCell('B'.$i)->getCalculatedValue();
       	$vereniging1 = $objPHPExcel->setActiveSheetIndex(0)->getCell('C'.$i)->getCalculatedValue();
      	$tel_nummer   = $objPHPExcel->setActiveSheetIndex(0)->getCell('D'.$i)->getCalculatedValue();
 
    if ($volgnr !=''){
       if ($tel_nummer !=''){
		   $status = 'checked';
	   } else {
		    $status = 'unchecked';
		   }
 
 
   echo "<tr><td style='". $td_style.";'>".$j."</td>";
   echo "<td style='". $td_style.";'><input type='checkbox' name='Check[]' value ='".$i."'  ".$status." alt='selecteren'>"; 
   echo "</td>";
   echo "<td style='". $td_style.";'>".$naam1."</td>";
   echo "<td style='". $td_style.";'>".$vereniging1."</td>";
   echo "<td style='". $td_style.";'>".$tel_nummer."</td>";
   echo "</tr>"; 
     
   echo"<input type ='hidden'  name = 'tel_nummer[".$i."]' value ='".$tel_nummer."' >"; 
   $j++;
 }
  else {
	$i = 1000;
}


}// end for while

echo "</table><br>";


//////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $string ='';
	  $length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
      $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ;
       
?>
<br>
<FORM action="send_sms_message_xlsx_stap3.php" method="post" name= "myForm">
 <table>
     <tr>
	 <td width="190" style='font-size:10pt; color:bluetext-align:left;font-family:courier;padding:5pt;'><em>Anti Spam </em></td>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink" Value='Typ hier code' style='font-size:10pt;' onclick="make_blank1();" >
        	
   <?php
   echo "<span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'><b>". $string."</b></span>
   <em><span style='font-size:9pt;'><em> <-- code.</span></em>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
  </td>
  </tr>
  </table>
  
  	
<input type='hidden' name ='toernooi'    value ='<?php echo $toernooi; ?>' >
<input type='hidden' name ='Bevestigen'  value ='<?php echo $sms_all; ?>' >
<input type='hidden' name ='smstekst'    value ='<?php echo $sms_tekst; ?>' >


<?php
echo "<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op de knop om de SMS berichten te verzenden.</b></span><br><br><br>";
echo "<INPUT type='submit' value='SMS Verzenden' >&nbsp&nbsp"; 

?>
<input type = 'button' value ='Annuleren' onclick= "location.replace('send_sms_message_xlsx_stap1.php?<?php echo $replace; ?>')">
<?php
echo "</FORM>";

?>
</blockquote>
<script language="javascript" type="text/javascript">
			document.myForm.Naam.respons();
		</script>
<?php

ob_end_flush();
?>
</html>
