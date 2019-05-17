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
	 
};
	
if (!isset($sms_bevestigen_zichtbaar_jn)) {
	$sms_bevestigen_zichtbaar_jn = 'N';
}

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana;font-weight:normal;';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in bevestigen  dan herzenden mail
if ($bevestigen !='' ){

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
	<td style='text-align:right;'><a href='send_sms_message_stap1.php?toernooi=<?php echo $toernooi; ?> '>Terug naar selectie</a></td>
</tr>
</table>
<FORM action="send_sms_message_stap3.php" method="post" name= "myForm">

<blockquote>

<?php

echo "<h3 style='padding:10pt;font-size:20pt;color:green;'>Verzenden SMS tbv  ".$toernooi_voluit ." &nbsp<img src = '../ontip/images/sms_bundel.jpg' width=45 border =0 ></h3>";

 if ($sms_bevestigen_zichtbaar_jn == 'J'){
      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:6pt;padding:8pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
      <tr><td style='text-align:center;font-size:9pt;color:red;border-top: 1pt solid green;' colspan =2><a style='font-size:9pt;color:red;' href='aanvraag_sms.php'  >Aanvullen SMS bundel</a></td></tr>     
      </table></blockquote><br>";
  }

echo "<table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' width=60%><tr>
  <td style='background-color: darkblue;color:white;font-size:9pt;padding:8pt;text-align:center;' width=10%>SMS tekst</td>
  <td <td style='background-color: white;color:black;font-size:10pt;width:25pt;text-align:left;padding:4pt;'> ".$sms_tekst."</td></tr></table><br>";
  
  
echo "<table width=60%><tr>  
      <td Style='font-family:Arial;font-size:9pt;color:green;'>
      <label><input type='checkbox' name='Check' unchecked> Kopie van het SMS bericht via email naar <b>".$email_organisatie."</b></label></td>
      </tr></table>";

?>
<br>


<?php
echo "<br>Er zullen ".count($bevestigen)." sms berichten verstuurd worden. <br>.";

   
 //  Koptekst 

echo "<table  id='myTable1' style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>";


echo "<tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'         >Naam</th>";
echo "<th style='". $th_style.";'         >Vereniging</th>";
echo "<th style='". $th_style.";'>Tel.nr</th>";
echo "</tr>";

/// Detail regels

$i=1;

foreach ($bevestigen as $bevestig_id)
{
	
	
	$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$bevestig_id."' " )    or die('Fout in select inschrijf');  
  $row      = mysqli_fetch_array( $qry);


echo "<td style='". $td_style.";'>".$i."</td>";
echo "<td style='". $td_style.";'>".$row['Naam1']."</td>";
echo "<td style='". $td_style.";'>".$row['Vereniging1']."</td>";

$tel_nummer      = $row['Telefoon'];
$telnr_encrypt   = $row['Telefoon_encrypt'];


//  9 aug aanpassing encrypt telnummer+  email in database
if ($email_sender    =='[versleuteld]'){ 
    $email_sender    = versleutel_string($email_encrypt);    
}

if ($tel_nummer    =='[versleuteld]'){ 
    $tel_nummer    = versleutel_string($telnr_encrypt);    
}



echo "<td style='". $td_style.";'>".$tel_nummer."</td>";
 echo "</tr>"; 
    
		
	if ( $tel_nummer  != ''){
	  $sms_all = $sms_all .  $bevestig_id. ";";
 	} // end if not empty telefoon
 	
 	$i++;
}// end for each

echo "</table><br>";


//////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
      $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ;
       
?>
<br>
<FORM action="send_sms_message_stap3.php" method="post" name= "myForm">
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
<input type = 'button' value ='Annuleren' onclick= "location.replace('send_sms_message_stap1.php?<?php echo $replace; ?>')">
<?php
echo "</FORM>";

?>
</blockquote>
<script language="javascript" type="text/javascript">
			document.myForm.Naam.respons();
		</script>
<?php

} //  if bevestigen


ob_end_flush();
?>
</html>
