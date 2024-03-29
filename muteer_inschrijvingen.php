<?php
# muteer_inschrijvingen.php
#
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 29dec2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              Ontbrekende var  Voucher_code en Bankrekening
# Feature:          None.
# Reference: 
#
# 4apr2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          PHP7
# Reference: 

# 18okt2019         -            E. Hendrikx 
# Symptom:         None.
# Problem:     	   None.
# Fix: 
# Feature:       Status IN3 toegevoegd            
# Reference: 

?>
<html>
<head>
<title>Muteren inschrijvingen</title>
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
	document.myForm1.respons.value="";
}


function changeFunc1(challenge) {
    document.myForm1.respons.value= challenge;
   }
   
function changeFunc2(challenge) {
    document.myForm2.respons.value= challenge;
   }   
   
</script>

<Script Language="Javascript">
function make_blank2()
{
	document.myForm2.respons.value="";
}

function fill_input_v_spam_field(text)
{
	
	   document.myForm.respons.value= text;
   
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
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>



<?php 

//// Database gegevens. 
include ('mysqli.php');
include ('../ontip/versleutel_string.php'); // tbv telnr en email



/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

$toernooi      = $_POST['toernooi'];
$check         = $_POST['Check'];
$mail_herzend  = $_POST['Mail'];
$sms_herzend   = $_POST['SMS'];
$zoek_licentie = $_POST['Licentie'];
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
	
	if 	(!isset($email_notificaties_jn )){
	$email_notificaties_jn = 'N';
}
	
	
	 
}
else {
		echo " Geen toernooi bekend :";
	 
};

$sql        = mysqli_query($con,"SELECT * from config where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Variabele ='soort_inschrijving' ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$soort_inschrijving  = $result['Waarde'];
$inschrijf_methode   = $result['Parameters'];

$sql       = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Toernooi = '" . $toernooi. "' and Vereniging = '".$vereniging."'  ")                  or die(' Fout in select 2');  
$result    = mysqli_fetch_array( $sql );
$aant_rows = $result['Aantal'];

if ($aant_rows > 25){
	
	// 13 aug 2015  Init voor de eerste keer
	$start_row = 1;
	$end_row   = 25;
		
	if (isset($_POST['start_row'])){
	   $start_row =  $_POST['start_row'];
	   $end_row   =  $_POST['end_row'];	
   }

	if (isset($_GET['start'])){
	   $start_row =  $_GET['start'];
	   $end_row   =  $_GET['end'];	
   }
	
	}	
else {
	$start_row = 1;
	$end_row   = $aant_rows;
}

$replace   = "start=".$start_row."&end=".$end_row."&toernooi=".$toernooi."";

/*
  echo $replace. "<br>";
  echo "Aantal : ". $aant_rows. "<br>";
	echo "Start : ". $start_row."<br>";
	echo "End : ". $end_row."<br>";
*/


/// In PHP 5.3  max 1000 POST vars gedefinieerd in php.ini. Dus probleem bij meer dan 100 rows en 10 kolommen
// 11 jun 2015 probleem is er nog steeds met aant > 99
/// van start row tot end row (max 25 records per keer)

for ($i=$start_row;$i<= $end_row;$i++){

$id               = $_POST['Id-'.$i];     
$volgnummer       = $_POST['Volgnummer-'.$i];     
$naam1            = $_POST['Naam1-'.$i];      
$naam2            = $_POST['Naam2-'.$i];    
$naam3            = $_POST['Naam3-'.$i];      
$naam4            = $_POST['Naam4-'.$i];      
$naam5            = $_POST['Naam5-'.$i];      
$naam6            = $_POST['Naam6-'.$i];      

$licentie1        = $_POST['Licentie1-'.$i];      
$licentie2        = $_POST['Licentie2-'.$i];      
$licentie3        = $_POST['Licentie3-'.$i];      
$licentie4        = $_POST['Licentie4-'.$i];      
$licentie5        = $_POST['Licentie5-'.$i];      
$licentie6        = $_POST['Licentie6-'.$i];      

$vereniging1      = $_POST['Vereniging1-'.$i];      
$vereniging2      = $_POST['Vereniging2-'.$i];      
$vereniging3      = $_POST['Vereniging3-'.$i];      
$vereniging4      = $_POST['Vereniging4-'.$i];      
$vereniging5      = $_POST['Vereniging5-'.$i];      
$vereniging6      = $_POST['Vereniging6-'.$i];      

$telefoon         = $_POST['Telefoon-'.$i];      
$opmerkingen      = $_POST['Opmerkingen-'.$i];     
$email            = $_POST['Email-'.$i];      
$extra            = $_POST['Extra-'.$i];      
$extra_invulveld  = $_POST['Extra-invulveld-'.$i];     
$bankrekening     = $_POST['Bankrekening-'.$i];      
$status           = $_POST['Status-'.$i];

//quote omzetten 

$vereniging1        = str_replace("'",  "&#39", $vereniging1);
$vereniging2        = str_replace("'",  "&#39", $vereniging2);
$vereniging3        = str_replace("'",  "&#39", $vereniging3);
$vereniging4        = str_replace("'",  "&#39", $vereniging4);
$vereniging5        = str_replace("'",  "&#39", $vereniging5);
$vereniging6        = str_replace("'",  "&#39", $vereniging6);

$naam1        = str_replace("'",  "&#39", $naam1);
$naam2        = str_replace("'",  "&#39", $naam2);
$naam3        = str_replace("'",  "&#39", $naam3);
$naam4        = str_replace("'",  "&#39", $naam4);
$naam5        = str_replace("'",  "&#39", $naam5);
$naam6        = str_replace("'",  "&#39", $naam6);

// Update

$query="UPDATE inschrijf 
               SET Volgnummer   = ".$volgnummer.",
                   Naam1        = '".$naam1."',
                   Licentie1    = '".$licentie1."',
                   Vereniging1  = '".$vereniging1."',
                   Naam2        = '".$naam2."',
                   Vereniging2  = '".$vereniging2."',
                   Licentie2    = '".$licentie2."',
                   Naam3        = '".$naam3."',
                   Licentie3    = '".$licentie3."',
                   Vereniging3  = '".$vereniging3	."',
                   Naam4        = '".$naam4."',
                   Licentie4    = '".$licentie4."',
                   Vereniging4  = '".$vereniging4	."',
                   Naam5        = '".$naam5."',
                   Licentie5    = '".$licentie5."',
                   Vereniging5  = '".$vereniging5	."',
                   Naam6        = '".$naam6."',
                   Licentie6    = '".$licentie6."',
                   Vereniging6  = '".$vereniging6	."',
                   Telefoon     = '".$telefoon."',
                   Opmerkingen  = '".$opmerkingen."',
                   Email        = '".$email."',
                   Bank_rekening = '".$bankrekening."',
                   Extra        = '".$extra."',
                   Extra_invulveld = '".$extra_invulveld."',
                   status       = '".$status."'
            WHERE  Id           = ".$id.";  ";

//echo $i.".    ". $query."<br>";
 mysqli_query($con,$query) or die ('Fout in update inschrijving'); 

// versleutel email
if ($email !='' and $email != '[versleuteld]' ){
  $encrypt_email = versleutel_string('@##'.$email);
  $query="UPDATE inschrijf SET Email_encrypt  = '".$encrypt_email."' , Email ='[versleuteld]' WHERE  Id = ".$id.";  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : Encrypt email:'.$query);
}

// versleutel telefoon
if ($telefoon !='' and $telefoon != '[versleuteld]' ){
  $encrypt_telefoon = versleutel_string('@##'.$telefoon);
  $query="UPDATE inschrijf SET Telefoon_encrypt  = '".$encrypt_telefoon."' , Telefoon ='[versleuteld]' WHERE  Id = ".$id.";  ";
  mysqli_query($con,$query) or die ('Fout in update inschrijf : Encrypt telefoon:'.$query);
}



}; // end for i update   


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in draaikolom(*) dan achternaam voor voornaam zetten
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$draai=$_POST['Draai'];
if ($draai !=''){

//echo "Draai gevonden !!! <br>";

foreach ($draai as $draaiid)
{

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$draaiid."' " )    or die(mysql_error());  
$row      = mysqli_fetch_array( $qry);
$naam1    = $row['Naam1'];
$naam2    = $row['Naam2'];
$naam3    = $row['Naam3'];
$naam4    = $row['Naam4'];
$naam5    = $row['Naam5'];
$naam6    = $row['Naam6'];
$id       = $row['Id'];

// omzetten

$name_item  = explode(" ", $naam1);
$last_item  = end($name_item);
$naam1      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam1 = $naam1 . " ". $name_item[$j];
$j++;
} // end while 1

$name_item  = explode(" ", $naam2);
$last_item  = end($name_item);
$naam2      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam2 = $naam2 . " ". $name_item[$j];
$j++;
} // end while 2

$name_item  = explode(" ", $naam3);
$last_item  = end($name_item);
$naam3      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam3 = $naam3 . " ". $name_item[$j];
$j++;
} // end while 2

$name_item  = explode(" ", $naam4);
$last_item  = end($name_item);
$naam4      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam4 = $naam4 . " ". $name_item[$j];
$j++;
} // end while 4

$name_item  = explode(" ", $naam5);
$last_item  = end($name_item);
$naam5      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam5 = $naam5 . " ". $name_item[$j];
$j++;
} // end while 5


$name_item  = explode(" ", $naam6);
$last_item  = end($name_item);
$naam6      = $last_item . " ";

$j=0;
while(isset ($name_item[$j]) and $name_item[$j] != $last_item){
$naam6 = $naam6 . " ". $name_item[$j];
$j++;
} // end while 6

// Update

$query="UPDATE inschrijf 
               SET Naam1        = '".$naam1."',
                   Naam2        = '".$naam2."',
                   Naam3        = '".$naam3."',
                   Naam4        = '".$naam4."',
                   Naam5        = '".$naam5."',
                   Naam6        = '".$naam6."'
            WHERE  Id           = '".$id."'  ";

//echo $query . "<br>";
 
mysqli_query($con,$query) or die (mysql_error()); 

}// end foreach
} // end if draai

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in mailkolom(*) dan herzenden mail
if ($mail_herzend !=''   and $check ==''){

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

<?php
echo "<span style='text-align:right;font-size:9pt;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>";
echo "<h3 style='padding:10pt;font-size:20pt;color:green;'>Herzenden email  ".$toernooi_voluit ." </h3>";

foreach ($mail_herzend as $mailid)
{
	
	$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$mailid."' and Email <> '' " )    or die('Fout in select inschrijf');  
  $row      = mysqli_fetch_array( $qry);
  $email    = $row['Email'];
	
	if ($email != ''){
	  $email_all = $email_all .  $mailid. ";";
 	} // end if not empty email	
}// end for each

 //

/////////////////////////////////////////    aanroep resend_email.php //////////////////////////////////////////////

echo "<FORM action='resend_mail.php?Id=". $email_all. "' method='post' name='myForm1' >";
echo "<span style='color:black;font-size:10pt;font-family:arial;'> U heeft ervoor gekozen voor de volgende inschrijvingen de mail te herzenden  :</span>      <br><br>";

 echo "<input type='hidden'  name ='toernooi' value ='".$toernooi."'>";	 

echo "<table border=1 style=background-color:white;color:blue;'>";

//// kopteksten

echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'></th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 1</th>"   ;

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 2</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 3</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 4</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 5</th>"   ;
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 6</th>"   ;
}
echo  "<th style= 'font-family:arial;font-size:10pt;color:white;' colspan =2>.</th>"   ;
echo  "</tr>"   ;

echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'>Nr.</th>"   ;

echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;

if ($soort_inschrijving !='single' and $inschrijf_methode  != 'single'){
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Email</th>"   ;
echo  "</tr>"   ;

$i=1;

/// detail regels

foreach ($mail_herzend as $mailid)
{
	
	$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$mailid."' and Email <> ''  " )    or die(mysql_error());  
  $row      = mysqli_fetch_array( $qry);
  $Email     = $row['Email'];
   if ($Email =='[versleuteld]'){
   	$Email =  versleutel_string($row['Email_encrypt']);
   }
    $Telefoon = $row['Telefoon'];
   if (Ttelefoon =='[versleuteld]'){
   	$Telefoon =  versleutel_string($row['Telefoon_encrypt']);
   }


echo  "<tr>"   ;
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;text-align:right;'>"   . $i. ".</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam1']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging1']. "</td>";

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam2']. "</td>";
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging2']. "</td>";
 }
 
if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam3']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging3']. "</td>";
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam4']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging4']. "</td>";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam5']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging5']. "</td>";
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam6']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging6']. "</td>";
}
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $Email. "</td>";
echo  "</tr>"   ;
$i++;

}/// end for each
echo "</table>";

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
 <table width=80% border =0 >
     <tr>
	 <td width="190" style='font-size:10pt; color:bluetext-align:left;font-family:courier;padding:5pt;'><em>Anti Spam </em></td>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink" Value='Typ hier code' style='font-size:10pt;' onclick="make_blank1();" >
        	
    <br><div style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc1(<?php echo $string; ?>);"><b><?php echo $string; ?></b></div>
    <?php
    echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
  </td>
  </tr>
  </table>

<?php
echo "<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op Ja om mails te versturen. Van ieder mailbericht ontvangt u een kopie</b></span><br><br><br>";
echo "<INPUT type='submit' value='Ja' >&nbsp&nbsp"; 

?>
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>')">
<?php
echo "</FORM>";

} // end if    mail

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in sms kolom(*) dan herzenden sms
if ($sms_herzend !=''  and $check ==''){

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

<span style='text-align:right;font-size:9pt;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<blockquote>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Herzenden SMS  <?php echo $toernooi_voluit; ?></h3>


<?php
foreach ($sms_herzend as $smsid)
{
	
	$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$smsid."' and Telefoon <> ''    " )    or die('Fout in select inschrijf');  
  $row      = mysqli_fetch_array( $qry);
  $telefoon   = $row['Telefoon'];
  
		
	if ($telefoon != ''){
	  $sms_all = $sms_all .  $smsid. ";";
 	} // end if not empty telefoon
}// end for each

 //

/////////////////////////////////////////    aanroep resend_sms.php //////////////////////////////////////////////
echo "<FORM action='resend_sms.php?Id=". $sms_all. "' method='post' name='myForm1' >";
echo "<span style='color:black;font-size:10pt;font-family:arial;'> U heeft ervoor gekozen voor de volgende inschrijvingen de sms te herzenden  :</span>      <br><br>";

 echo "<input type='hidden'  name ='toernooi' value ='".$toernooi."'>";	 

echo "<table border=1 style=background-color:white;color:blue;'>";

//// kopteksten

echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'></th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 1</th>"   ;

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 2</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 3</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 4</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 5</th>"   ;
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 6</th>"   ;
}
echo  "<th style= 'font-family:arial;font-size:10pt;color:white;' colspan =2>.</th>"   ;
echo  "</tr>"   ;

echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'>Nr.</th>"   ;

echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;

if ($soort_inschrijving !='single' and $inschrijf_methode  != 'single'){
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Telefoon</th>"   ;
echo  "</tr>"   ;

$i=1;

/// detail regels

foreach ($sms_herzend as $smsid)
{
	
	$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$smsid."' and Telefoon <> '' " )    or die(mysql_error());  
  $row      = mysqli_fetch_array( $qry);

echo  "<tr>"   ;
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;text-align:right;'>"   . $i. ".</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam1']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging1']. "</td>";

if ($soort_inschrijving !='single'  and $inschrijf_methode  != 'single' ){
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam2']. "</td>";
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging2']. "</td>";
 }
 
if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam3']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging3']. "</td>";
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam4']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging4']. "</td>";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam5']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging5']. "</td>";
}

if ($soort_inschrijving == 'sextet'  and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam6']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging6']. "</td>";
}
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Telefoon']. "</td>";
echo  "</tr>"   ;
$i++;

}/// end for each
echo "</table>";

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
 <table>
     <tr>
	 <td width="190" style='font-size:10pt; color:bluetext-align:left;font-family:courier;padding:5pt;'><em>Anti Spam </em></td>
        <td colspan = 2><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink" Value='Typ hier code' style='font-size:10pt;' onclick="make_blank1();" >
        	
    <span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc1(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
    <?php
    echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
  </td>
  </tr>
  </table>

<?php

echo "<br><span style='color:black;font-size:10pt;font-family:arial;'>Neem Anti Spam code over en klik op Ja om sms-jes te versturen. </b></span><br><br><br>";
echo "<INPUT type='submit' value='Ja' >&nbsp&nbsp"; 

?>
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>')">
<?php
echo "</FORM>";
echo "</blockquote>"; 
} // end if    sms

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////// Indien Vinkje in delete kolom dan verwijderen van aangevinkte records

if ($check !=''  and $mail_herzend == '') {

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
<span style='text-align:right;font-size:9pt'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<?php           

echo "<h3 style='padding:10pt;font-size:20pt;color:green;'>Verwijder inschrijvingen ".$toernooi_voluit ." </h3>";

///////////////////////////////////////////////////////////////////////////////////////////////////////////

echo "<FORM action='delete_inschrijvingen.php' method='post' name ='myForm2'>";

echo "<span style='color:black;font-size:10pt;font-family:arial;margin-left:45pt;'> U heeft ervoor gekozen voor de volgende inschrijvingen te verwijderen  :</span>      <br><br><br><br>";

echo "<input type='hidden'  name ='toernooi' value ='".$toernooi."'>";	 
echo "<blockquote><table border=1 style=background-color:white;color:blue;'  width=80%>";

//// kopteksten


echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'></th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 1</th>"   ;

if ( $soort_inschrijving !='single' and $inschrijf_methode  != 'single'  ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 2</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')  and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 3</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 4</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 5</th>"   ;
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single' ){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =2>Speler 6</th>"   ;
}
echo  "</tr>"   ;

echo  "<tr>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;'  width=45>Nr.</th>"   ;

echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;

if ($soort_inschrijving !='single' and $inschrijf_methode  != 'single'){
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ) and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single'){
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single'){
	echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Naam</th>"   ;
  echo  "<th style= 'font-family:arial;font-size:10pt;color:blue;' colspan =1>Vereniging</th>"   ;
}
echo  "</tr>"   ;


$i=1;

/// detail regels

foreach ($check as $checkid)
{

$qry      = mysqli_query($con,"SELECT * from inschrijf where Id= '".$checkid."' " )    or die('Fout in select inschrijf 2' );  
$row      = mysqli_fetch_array( $qry);

echo  "<tr>"   ;
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;text-align:right;'>"   . $checkid. ".</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam1']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging1']. "</td>";

if ($soort_inschrijving !='single' and $inschrijf_methode  != 'single' ){
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam2']. "</td>";
 echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging2']. "</td>";
 }
 
if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam3']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging3']. "</td>";
}

if (($soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam4']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging4']. "</td>";
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam5']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging5']. "</td>";
}

if ($soort_inschrijving == 'sextet' and $inschrijf_methode  != 'single' ){
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Naam6']. "</td>";
echo  "<td style= 'font-family:arial;font-size:10pt;color:black;'>"   . $row['Vereniging6']. "</td>";
}

echo  "</tr>"   ;
echo "<input type='hidden' name='Del-".$i."'   type='text' size='100'  value ='".$checkid."'>";
echo "<input type='hidden' name='Draai-".$i."' type='text' size='100'  value ='".$draaiid."'>";
$i++;

}/// end for
echo "</table>";
if ($email_notificaties_jn == 'J'){
echo"<br><span style='font-size:11pt;margin-left:15pt;'><input type='checkbox' name='notificaties' unchecked> Zet hier een vinkje als u Notificaties wilt verzenden.<br></span>";
}
echo "</blockquote>";

$i--;



//////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
      $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ;
       
?>
<blockquote>
  <div class="g-recaptcha" data-sitekey="6LcuBVcUAAAAAHAIiFktH8ZZ22fLeBGKujfN-4ss"></div>   
<br>
 
 
  </blockquote>
  
<?php
$sql      = mysqli_query($con,"SELECT * FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result   = mysqli_fetch_array( $sql );
$naam     = $result['Naam'];
$email    = $result['Email'];
$to       = $email;

if ($email == ''){
$to         = $email_organisatie;
}


echo "<input type='hidden' name='Aantal' type='text' value ='".$i."'>";

?>
<span style='margin-left:45pt;' >
<INPUT type='submit' value='Ja' >&nbsp&nbsp
<input type = 'button' value ='Annuleren' onclick= "location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>')">
</span>
</FORM>
<?php


}  /// end if   check

?>
<?php
ob_end_flush();
//echo $replace;



if ($check ==''  and $mail_herzend == '' and $sms_herzend == '') { ?>

<script language="javascript">
		window.location.replace('beheer_inschrijvingen.php?<?php echo $replace; ?>');
</script>
<?php } ?>
</html>
