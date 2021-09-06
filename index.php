<?php
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

# 7jun2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Wijzigen link tbv PTB export
#                   Toegevoegd link voor SMS berichten versturen vanuit Excel bestand
# Reference: 

# 22jun2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Lijst email notificaties
# Reference: 

# 16jan2020        -            E. Hendrikx 
# Symptom:   		    Geen link naar beheer reserveringen.
# Problem:     	    None
# Fix:              Query toegevoegd
# Feature:          None
# Reference: 
?>

<html>
	<Title>OnTip Homepage (c) Erik Hendrikx</title>
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			
<script type='text/javascript' src='js/utility.js'></script>	  
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: verdana;background-color:white;}
TH {color:black ;font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {font-size: 8.0pt ; font-family:Arial, Helvetica ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:darkblue; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
input {font-size:8.5pt;color:blue;}

 IMG.HoverBorder {border:3px solid #eee;}
 IMG.HoverBorder:hover {border:3px solid #555;}
 
  
       
.tooltip{
    display: inline;
    position: relative;
}


.tooltip:hover:before{
    border: solid;
    border-color: #333 transparent;
    border-width: 6px 6px 0 6px;
    bottom: 10px;
    content: "";
    left: 50%;
    position: absolute;
    z-index: 99;
   }

.tooltip:hover:after{
    background: #333;
    background: rgba(0,0,0,.8);
    border-radius: 5px;
    bottom: 26px;
    color: #fff;
    content: attr(title);
    text-align:center;
    font-size:8pt;
    left: 20%;
    padding: 5px 15px;
    position: absolute;top:-20px;
    z-index: 98;
    width: 100px;
    height:30px;
}



styled-select select {
   background: transparent;
   width: 268px;
   padding: 5px;
   font-size: 16px;
   line-height: 1;
   border: 0;
   border-radius: 0;
   height: 34px;
   -webkit-appearance: none;
   }
   
#tablist{
padding: 3px 0;
margin-left: 0;
margin-bottom: 0;
margin-top: 0.1em;
font: bold 12px Verdana;
}

#rotate {
  -moz-border-radius-topleft: 5px;
  -webkit-border-top-left-radius: 5px;
	-moz-border-radius-topright: 5px;
  -webkit-border-top-right-radius: 5px;
  -moz-border-radius-bottomleft: 5px;
  -webkit-border-bottom-left-radius:5px;
	-moz-border-radius-bottomright: 5px;
  -webkit-border-bottom-right-radius: 5px;
  -ms-transform: rotate(-5deg); /* IE 9 */
  -webkit-transform: rotate(-5deg); /* Chrome, Safari, Opera */
   transform: rotate(-5deg);
   position:relative;
	 top:-2pt; 
}	 
   
#tablist li{
list-style: none;
display: inline;
margin: 2;
}

#tablist li a{
padding: 3px 0.5em;
margin-left: 3px;
border: 1px solid white;
border-bottom: none;
background: white;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;
border: 1px solid;
font-size:11pt;
}

#tablist li a:link, #tablist li a:visited{
background-color:white;
color: navy;
}



#tablist li a.current{
background: lightyellow;
}

#tabcontentcontainer{
padding: 5px;
border: 1px solid black;
}

.tabcontent{
	height:400pt;
display:none;
}
// --></style>

<script type="text/javascript">
function toggle(obj,on) {
	   obj.className=(on)?'dotted':'normal'; 
	   } 

function show_popup(id) { 
	  if (document.getElementById){  
	   obj = document.getElementById(id);  
	  if (obj.style.display == "none") {  
	   obj.style.display = "";        
	    }
 }
 }
function hide_popup(id){ 
	  if (document.getElementById){        
	   obj = document.getElementById(id); 
   if (obj.style.display == ""){ 
     obj.style.display = "none";   
     }
   }
 }

function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=300,width=500,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}


function make_blank()
{
	document.Aanloggen.Naam.value="";
}

function changeFunc() {
    var selectBox = document.getElementById("selectBox");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Toernooi.value= selectedValue;
   }
function submitForm()
{
  document.myForm.submit();
}

function resizeText(multiplier) {
  if (document.body.style.fontSize == "") {
    document.body.style.fontSize = "1.0em";
  }
  document.body.style.fontSize = parseFloat(document.body.style.fontSize) + (multiplier * 0.2) + "em";
}

function blink() {
   var f = document.getElementById('Blink');
   setInterval(function() {
      f.style.fontSize = (f.style.fontSize == '9' ? '' : '12');
   }, 1000);
}

                                                 
</script>
</head>

<?php
include 'mysqli.php'; 
?>
 <base href="<?php echo $url_base; ?>"  target='_top'>



<body BACKGROUND="../ontip/images/ontip_grijs.jpg" width =40 bgproperties=fixed  onload="blink();" >
 
<?php

function curPageURL() {
$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
return $url;
}

/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
$today = date('Y-m-d');
$today      = date("Y") ."-".  date("m") . "-".  date("d");

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

// maak hulptabel leeg

mysqli_query($con,"Delete from hulp_toernooi where Vereniging_id = '".$vereniging_id."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 

 
$query = "insert into hulp_toernooi (Toernooi, Vereniging, Vereniging_id, Datum) 
  select Toernooi,Vereniging, Vereniging_id, Waarde from config     where Vereniging_id = '".$vereniging_id."' and Variabele ='datum' group by Vereniging, Vereniging_id, Toernooi,Waarde   " ;


mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 

$update = mysqli_query($con,"UPDATE hulp_toernooi as h
 join config as c
  on c.Vereniging_id        = h.Vereniging_id 
  set h.Toernooi_voluit    = c.Waarde 
 where c.Toernooi         = h.Toernooi
   and c.Variabele        ='toernooi_voluit' 
   and c.Vereniging_id    = '".$vereniging_id."'  ");
  
$toernooien = mysqli_query($con,"SELECT h.Toernooi,  Waarde , Datum from config as c
 join hulp_toernooi as h
  on c.Vereniging_id        = h.Vereniging_id and
     c.Toernooi          = h.Toernooi 
   where c.Variabele     = 'toernooi_voluit' 
     and c.Vereniging_id    = '".$vereniging_id."' order by Datum ");
 
 mysqli_query($con,"OPTIMIZE table  hulp_toernooi ") or die('Fout in optimize tabel');   

$aantal_toernooien = mysqli_num_rows($toernooien);
  
//$qry                    = mysqli_query($con,"SELECT * from hulp_toernooi where Vereniging = '".$vereniging."' and Datum >= '".$today."'   order by Datum ")           or die(' Fout in select eerstv');  
$qry                    = mysqli_query($con,"SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'  order by Datum ")           or die(' Fout in select eerstv');  

$result                 = mysqli_fetch_array( $qry );
$toernooi               = $result['Toernooi'];
$aantal_toernooien      = mysqli_num_rows($qry);


// Indien geen toernooi in de toekomst gevonden of maar 1 toernooi laadt dan de laatste

if ($aantal_toernooien < 2 ) {
    $qry      = mysqli_query($con,"SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'  order by Datum desc limit 1")           or die(' Fout in select toernooi 1');  
    $row      = mysqli_fetch_array( $qry );
    $var      = substr($row['Datum'],0,10);
    $toernooi = $row['Toernooi'];   	 
    $ip        = md5($_SERVER['REMOTE_ADDR']);
  
     mysqli_query($con,"Update namen set Toernooi = '".$toernooi."' 
                        WHERE Aangelogd = 'J'  and Vereniging_id = ".$vereniging_id."  and IP_adres_md5 = '". $ip."' ");
 
  
   if ($toernooi =='') {
   	   $aantal_toernooien = 0;
   	}
   	else {
       $toernooi_voluit = $row['Waarde'];   	 
       $datum    = $row['Datum'];  
   	} 
}    

// haal geselecteerd toernooi op (bij select_toernooi wordt deze opgeslagen in de namen tabel

$sql         = mysqli_query($con,"SELECT Toernooi FROM namen WHERE  IP_adres_md5 = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi    = $result['Toernooi'];

//  Check op nog aanwezige al gespeelde toernooi inschrijvingen

$sql     = mysqli_query($con,"SELECT count(*) as Aantal FROM inschrijf WHERE Vereniging = '".$vereniging."' and Datum < '".$today."'" );
$result  = mysqli_fetch_array( $sql );
$count_oud_toernooi    = $result['Aantal'];

// ophalen url website

$url_redirect   = '';
$qry    = mysqli_query($con,"SELECT * from vereniging where Vereniging = '".$vereniging."' ")           or die(' Fout in select 1');  
$result  = mysqli_fetch_array( $qry);
$url_website       = $result['Url_website'];
$verzendadres_sms  = $row['Verzendadres_SMS'];
$vereniging_id     = $result['Id'];
$url_redirect      = $result['Url_redirect'];
$prog_url          = $result['Prog_url'];
$bond              = $result['Bond'];
$indexpagina_achtergrond_kleur  = $result['Indexpagina_achtergrond_kleur']; 


$qry    = mysqli_query($con,"SELECT * from namen where Vereniging = '".$vereniging."' and Naam ='Erik'")           or die(' Fout in select 1');  
$result  = mysqli_fetch_array( $qry);
$id     = $result['Id'];

//Check op aanwezige berichten voor de vereniging of allen
$msg_qry    = mysqli_query($con,"SELECT * from messages where (Vereniging = '".$vereniging."' or Vereniging = '*ALL*')  and Begin_datum <= '".$today."' and Eind_datum > '".$today."'  order by Laatst desc")           or die(' Fout in select msg');  
$msg_count  = mysqli_num_rows($msg_qry);

// statistieken

$qry1    = mysqli_query($con,"SELECT count(*) as Aantal From hulp_naam where DATE_FORMAT(Datum,'%Y-%m-%d') >  '".$today."' ")     or die(' Fout in select stats' ); 
$result  = mysqli_fetch_array( $qry1 );
$totaal_inschrijvingen  = $result['Aantal'];


$qry2    = mysqli_query($con,"SELECT count(*) as Aantal From stats_naam")         or die(' Fout in select 7'); 
$result  = mysqli_fetch_array( $qry2);
$archief_inschrijvingen  = $result['Aantal'];

$qry3    = mysqli_query($con,"SELECT * FROM `inschrijf`  order by Inschrijving desc limit 8")  or die(' Fout in select inschrijf_stats'); 

$_totaal_inschrijvingen = '';
$len1   = strlen($totaal_inschrijvingen);

for ($k=0;$k < $len1;$k++){
	$j                      = substr($totaal_inschrijvingen,$k,1);
  $_totaal_inschrijvingen = $_totaal_inschrijvingen."<img src='../ontip/images/dg".$j.".gif'>";
  
  if ($len = 4 and $k==0) {
  	$_totaal_inschrijvingen = $_totaal_inschrijvingen."<img src='../ontip/images/dg_pnt.gif'>";
  }
  
}
 
 
$_totaal_archief = '';
$len2   = strlen($archief_inschrijvingen);

for ($k=0;$k < $len2;$k++){
	$j                      = substr($archief_inschrijvingen,$k,1);
  $_totaal_archief = $_totaal_archief."<img src='../ontip/images/dg".$j.".gif'>";
  
   if ($len2 = 5 and $k==1) {
  	$_totaal_archief = $_totaal_archief."<img src='../ontip/images/dg_pnt.gif'>";
  }
}
 
// check of er records zijn voor boulemaatje

if(isset($toernooi) and $toernooi !=''){ 
   $qry4    = mysqli_query($con,"SELECT count(*) as Aantal From boule_maatje  where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")         or die(' Fout in select 7'); 
   $result  = mysqli_fetch_array( $qry4);
   $aantal_boulemaatje = $result['Aantal'];
}

// check of er ideal transacties zijn voor dit toernooi

if(isset($toernooi) and $toernooi !=''){ 
   $qry5    = mysqli_query($con,"SELECT count(*) as Aantal From ideal_transacties where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")         or die(' Fout in select 8'); 
   $result  = mysqli_fetch_array( $qry5);
   $aantal_ideal_transacties  = $result['Aantal'];
}

// Definieer variabelen en vul ze met waarde uit tabel config

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
		
// uit vereniging tabel	
	
$qry                    = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row                    = mysqli_fetch_array( $qry );
$url_logo               = $row['Url_logo'];
$url_website            = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];
$hussel_gebruiker       = $row['Hussel_gebruiker'];
$onderhoud_ontip        = $row['Onderhoud_ontip'];
$datum_verloop_licentie = $row['Datum_verloop_licentie'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

$_check =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $_vereniging);

if ($_check !=  $_vereniging){
	  $_vereniging = $row['Vereniging'];
}

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
}

// 16 jan 2020
   $qry6    = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Status in ('RE0', 'RE1','RE4')  ")         or die(' Fout in select res'); 
   $result  = mysqli_fetch_array( $qry6);
   $aantal_reserves = $result['Aantal'];


//  26 oktober 2016  Aanpassijng ivm migratie ///
if ($onderhoud_ontip =='J'){ ?>
<script language="javascript">
		window.location.replace('onderhoud_ontip.php');
</script>
<?php } 
?>


<!---//---------------------- Plaatjes balk ---------------------------------------------------------------------------------------------//---> 
<table STYLE ='text-align:left;position:relative;top:-7px;border-collapse: collapse;margin-left:15pt;' width=90% border = 0 >
	<tr> 
		
		<td style='text-align:left;' width=20%><img src = '../ontip/images/ontip_logo.png' width='220'></td>
		<!--// AANLOGGEN  -->

<?php

if ($aangelogd == 'J'){
	$ip_adres = md5($_SERVER['REMOTE_ADDR']);
	    $sql      = mysqli_query($con,"SELECT * FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres_md5 = '".$ip_adres."' and Aangelogd = 'J'  ") or die(' Fout in select');  
	    $result   = mysqli_fetch_array( $sql );
      $rechten  = $result['Beheerder'];         	
      $laatste_wijziging_wachtwoord     = $result['Laatste_wijziging_wachtwoord'];
      
            
		            switch ($rechten) {
		              case "A":  $omschrijving = " Alle rechten.";
		                         break;
		              case "I":  $omschrijving = " Beheer inschrijvingen.";
		                         break;
		              case "C":  $omschrijving = " Beheer configuratie.";
		                         break;
		              case "W":  $omschrijving = " Beheer toernooi (beperkt).";
		                         break;
		           };// end switch               		
		     	           	
	      	?>
    		 
	            	<td STYLE ='font-size: 8pt;color:black;text-align:right;padding:5pt;width:140;vertical-align:middle;'>
                   Aangelogd als <?php echo $result['Naam']."<br>".$omschrijving;?>
	              </td>
	              <td STYLE ='font-size: 8pt;color:black;text-align:center;padding:5pt;width:140;vertical-align:middle;'>
	             	
	             	<form method = 'post' action='afloggen.php'>
	               	<input type='hidden'   name='vereniging'  value='<?php echo $vereniging;?>'  />
	                <input class="HoverBorder" style='padding:5pt;font size=9pt;color:blue;'type ='submit' value= 'Afloggen'> 
	              </form>
<?php	      }  // end if aangelogd

$dag    = substr($datum_verloop_licentie,8,2);
$maand  = substr($datum_verloop_licentie,5,2);
$jaar   = substr($datum_verloop_licentie,0,4);

$_datum_verloop = strftime("%d-%m-%Y",mktime(0,0,0,$maand,$dag,$jaar)) ;


$dag    = substr($laatste_wijziging_wachtwoord,8,2);
$maand  = substr($laatste_wijziging_wachtwoord,5,2);
$jaar   = substr($laatste_wijziging_wachtwoord,0,4);

$verloop_wachtwoord     = strtotime ("+1 year", mktime(0,0,0,$maand,$dag,$jaar));
$_verloop_wachtwoord    = date("d-m-Y", $verloop_wachtwoord);

if (substr($laatste_wijziging_wachtwoord,0,4) == '0000'){
	$_verloop_wachtwoord  = 'onbekend';
}


?>
</td>
<td style= 'font-size:8pt;vertical-align:middle;font-weight:bold;font-family:verdana;'>Uw licentie verloopt:<br>
         <?php echo $_datum_verloop; ?>
   <span style= 'font-size:8pt;vertical-align:middle;font-weight:bold;font-family:verdana;'><br>Uw wachtwoord verloopt:<br>
         <?php echo $_verloop_wachtwoord  ; // PHP:  2009-03-31; ?><a style='padding-left:4pt; font-size:9pt;' href='change_password.php' target='_self'>wijzig wachtwoord</a>
   </span>
</td>



	<!--td style= 'font-size:8pt;'><a href='http://www.enquetemaken.be/toonenquete.php?id=258717 ' target = '_blank'><img src  ='../ontip/images/enquete.jpg' width=80 border  =0></a>
	<?php 
	if ($vereniging =='Boulamis'){?>
		
	<a href='	http://www.enquetemaken.be/results.php?id=258717target = '_blank'> - Resultaten</a>
<?php } ?>
	</td-->
	<td style='text-align:right;vertical-align:top;'>
		
		<?php
 $size = getimagesize ($url_logo); 
 $logo_width  = $size[0];
 $logo_height = $size[1];  	
 
 // ongeveer uitkomen op 30 px voor height
$calc        = ($logo_width / 30) ;
$logo_width  = 30;
$logo_height = ( $logo_height / $calc) ;
 
 
 if ($logo_height < 15){
 	   $logo_height = $logo_height * 1.5;
 	   $logo_width =  $logo_width * 1.5;
 	 }
 ?> 	   
 
	 <!--a  href= "<?php echo $url_website; ?>" class="old_tooltip"   title='Naar site'><img src="<?php echo $url_logo; ?>" width='<?php echo $logo_width ; ?>' height='<?php echo $logo_height ; ?>' border =0 target='_blank'></a--->
   
  <?php if ($aangelogd !='J'){ ?>
  	<a href= "aanloggen.php" class="old_tooltip"   title='Aanloggen'><img class="HoverBorder" class="HoverBorder" src='../ontip/images/logon_ico.png' border = 0 width =30 alt='Aanloggen' ></a>
 
   <?php } ?>
	   		
	
	 <?php if ($hussel_gebruiker  =='J'){ ?>
  	<a href='<?php echo $url_redirect."index_hussel.html"; ?>' class="old_tooltip"   title='Hussel'><img class="HoverBorder" src='../ontip/images/OnTip_hussel.png' border = 0 width =60 alt='Hussel' ></a>
   <?php } ?>
   
     <?php if ($rechten == 'A' or  $rechten == 'C' or $i==0){ ?>
	 <a  href= "toevoegen_toernooi_stap1.php?key=T" class="old_tooltip"  target='_self' title='Toevoegen toernooi'><img class="HoverBorder" src='../ontip/images/plus.png' border = 0 width =27 alt='Toevoegen toernooi' ></a>
  
  
   	<?php if(isset($toernooi) and $toernooi !=''){ 
   		
   		/*
     $qrc_link   = "images/qrc/qrcf_".$toernooi.".png";
    if (file_exists($qrc_link)) {         ?>
        <a href="<?php echo $qrc_link;?>" target='_blank' border= 0 class="old_tooltip"   title='QR code voor inschrijf formulier'><img class="HoverBorder" src='../ontip/images/qrc.png' border = 0 width = 32 alt ='' ></a>
      <?php } 
     
    $output_pdf = 'images/'.$toernooi.'.pdf';
              
    if (file_exists($output_pdf)){ ?>
        <a href="<?php echo $output_pdf;?>" target='_blank' border= 0 class="old_tooltip"   title='OnTip PDF Flyer voor toernooi'><img class="HoverBorder" src='../ontip/images/pdf_ontip_logo.gif' border = 0 width = 32 alt ='' ></a>
    <?php }
    */ ?>
        
    <a href= "Inschrijfform.php?toernooi=<?php echo $toernooi;?>"          class="old_tooltip"   title='Inschrijf formulier'><img class="HoverBorder" src='../ontip/images/icon_inschrijf.png' border = 0 width =35 alt ='' ></a>
	 
    <?php if ($rechten == 'A' or $rechten =='I'){ ?>
  	  <a href="Inschrijfform.php?toernooi=<?php echo $toernooi; ?>&user_select=Yes"  class="old_tooltip"   title='Inschrijf formulier (eigen leden)'><img class="HoverBorder" src='../ontip/images/mensen.png' border = 0 width =35 alt ='' ></a>
	  <?php  } ?>  
	  
    <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "beheer_ontip.php?toernooi=<?php echo $toernooi;?>"          class="old_tooltip"   title='.Formulier aanpassen'><img class="HoverBorder" src='../ontip/images/Icon_tools.png' border = 0 width =35 alt ='' ></a>
	 <?php } ?>
	 
    <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>" class="old_tooltip"   title='Muteren inschrijvingen'><img class="HoverBorder" src='../ontip/images/icon_muteer.png' border = 0 width =35 alt ='' ></a>
  <?php } ?>
	  
	  <a href= "lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>&lijst_zichtbaar"  class="old_tooltip"   title='Simpele lijst'><img class="HoverBorder" src='../ontip/images/list_all_participants.png' border = 0 width = 33 alt ='' ></a>
	 
   	  
   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "image_gallery.php?toernooi=<?php echo $toernooi;?>" class="old_tooltip"   title='Selectie & upload afbeeldingen'><img class="HoverBorder" src='../ontip/images/gallery.jpg'  width =30 border =0 alt =''></a> 
   <?php } ?> 

  
	  <?php }  // er is nog geen toernooi bekend ?>
   
   
  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
 
   <?php if ($aantal_toernooien > 0 or $count_oud_toernooi > 0){ ?>
       <a href= "select_verwijderen.php?key=V" class="old_tooltip"   title='Archiveren en verwijderen inschrijvingen'><img class="HoverBorder" src='../ontip/images/prullenbak.jpg' border = 0 width =31 ></a>
       <a href= "../ontip/stats_one.php?Id=<?php echo $vereniging_id;?>" class="old_tooltip"   title='Statistieken'><img class="HoverBorder" src='../ontip/images/grafiek_bar.jpg' border = 0 width =45  ></a>
	 <?php }?>    
  <?php  }?>    
   
   
<?php } ?>	
    <a href= "release_notes.php"          class="old_tooltip"   title='Release notes'><img class="HoverBorder" src='../ontip/images/new_release.jpg' border = 0 width =35 alt =''  ></a>
	  <!--a href="contact.php" class="old_tooltip"   title='Email naar beheer OnTip'><img src='../ontip/images/mail.jpg' width =27 border =0  alt='' ></a-->
	   <a href='../ontip/select_pdf_bestand.php' class="old_tooltip"   title='OnTip Nieuwsbrieven'><img class="HoverBorder" src='../ontip/images/pdf.gif' width =40 border =0 ></a>
    <a href='../ontip/pdf/Handleiding.pdf' class="old_tooltip"   title='Handleiding'><img class="HoverBorder" src='../ontip/images/boek.jpg' width =40 border =0 ></a>
    <!--a href= "http://www.webhelpje.be/forum/forum.php?name=Ontip" class="old_tooltip"   title='Naar OnTip forum'><img src="../ontip/images/forum.png" width=55 border =0 target='_blank'></a-->

<!--/div-->
</tr>
</table>

<!---//---------------------- einde Plaatjes balk ---------------------------------------------------------------------------------------------//---> 


 <?php
 $size = getimagesize ($url_logo); 
 $logo_width  = $size[0];
 $logo_height = $size[1];  	
 
 // ongeveer uitkomen op 70 px voor height
$calc        = ($logo_width / 50) ;
$logo_width  = 50;
$logo_height = ( $logo_height / $calc) ;
 
 if ($logo_height < 35){
 	   $logo_height = $logo_height *2;
 	   $logo_width =  $logo_width *2;
 	 }
 ?> 	   
    		  			  	
  		  			  	
<!--div style= 'background-color:darkgreen;height:85pt;vertical-align:middle;border:0px solid #000000;box-shadow: 8px 8px 8px #888888;position:relative;top:-20px;margin-left:25pt;margin-right:25pt; ----->  		  			  	
<div style= 'background-image:url("../ontip/images/OnTip_banner_green_fade.jpg");height:85pt;vertical-align:middle;border:0px solid #000000;box-shadow: 8px 8px 8px #888888;position:relative;top:-20px;margin-left:25pt;margin-right:25pt;
	 -moz-border-radius-topleft: 10px;
   -webkit-border-top-left-radius: 10px;
   -moz-border-radius-topright: 10px;
   -webkit-border-top-right-radius: 10px;
   -moz-border-radius-bottomleft: 10px;
   -webkit-border-bottom-left-radius: 10px;
	 -moz-border-radius-bottomright: 10px;
   -webkit-border-bottom-right-radius: 10px;' cellpadding=0 cellspacing=0'> 
 
 <blockquote>
 	<br>
 	
	<table width=95% border =0 >
   <tr>
   	
    	<td width= <?php echo $logo_width ; ?> pt  STYLE ='text-align:center;vertical-align:top;' ><img src="<?php echo $url_logo; ?>" width='<?php echo $logo_width ; ?>' height='<?php echo $logo_height ; ?>' border =0 ></td>
   		<td width= 30% STYLE ='font-size:14pt; ;color:black;text-align:left;color:yellow;font-weight:bold;vertical-align:top;' ><?php echo $_vereniging;?></td>
   		
       <?php
        if (isset($toernooi) and $toernooi !=''){
       	
         $dag   = 	substr ($datum , 8,2); 
         $maand = 	substr ($datum , 5,2); 
         $jaar  = 	substr ($datum , 0,4); 
         
         $now       = date ('Y-m-d H:i');
         $variabele = 'einde_inschrijving';
         $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
         $result    = mysqli_fetch_array( $qry1);
         $einde_inschrijving =  $result['Waarde'];
         
      ?>
          	
       		<?php  		if ($toernooi_voluit !=''){  ?>	
       		
       		  <?php if (isset($toernooi_zichtbaar_op_kalender_jn)  and $toernooi_zichtbaar_op_kalender_jn  !='0') { ?>
          	<td width= 30% STYLE ='border-style:ridge;border-style:groove;border:inset 3pt orange;font-size:15pt;vertical-align:middle; background-color:#cccccc;color:black;text-align:left;font-weight:bold;' >
          <?php } else { ?>
          	<td width= 30% STYLE ='border-style:ridge;border-style:groove;border:inset 3pt orange;font-size:15pt;vertical-align:middle; background-color:#F3F781;color:black;text-align:left;font-weight:bold;' >
          <?php } ?>
          	
          		<?php echo $toernooi_voluit;?><br>  
          				<span style='font-size:12pt;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ; ?></span>
     	   		</td>
     		<?php } ?>		
       <?php } ?>
  <td  style='color:white;font-size 9pt;font-style:italic;font-weight:bold'>Selectie ander toernooi via het Tab blad 'Start'<br>Standaard wordt de laatst gebruikte geselecteerd.
  	  <?php if (isset($toernooi_zichtbaar_op_kalender_jn)  and $toernooi_zichtbaar_op_kalender_jn  !='0') { ?>
  	             <span style = 'color:yellow;'><br>Dit toernooi is niet zichtbaar op de OnTip kalender.</span>
  	  <?php } ?>
  	  
  	  
  	</td>
  <td  WIDTH=240pt style='text-align:center;vertical-align :middle;color:white;font-family:Cooper black;font-size:10pt;;'>	
    <div id = 'rotate'  style='border:2pt solid #A9BCF5;padding:2pt;box-shadow: 3px 3px 3px #d8f6ce;position:relative;background-color:blue;'>
    <?php
   
 if ($datum > $today and $begin_inschrijving <= $today and $now < $einde_inschrijving  ){?>
  	Dit toernooi is open voor inschrijving.
  
  	<?php } else { ?>
     <?php if ($now > $einde_inschrijving  ){ ?>
    	      Er kan vanaf <br><font color = yellow> <?php echo $einde_inschrijving; ?></font> <br>niet meer worden ingeschreven voor dit toernooi.
         <?php } else { ?>
  	        Dit toernooi is vanaf<br><font color = yellow> <?php echo $begin_inschrijving; ?></font> <br>geopend voor inschrijving.
  <?php }}  ?>
  </div></td></tr>
  	
</table>

<!---- klok ---------------------------->

<div id="klokbalk" width=100% style="background-color:transparent; color:#59b300;text-align:left;font-size:9pt;font-family:verdana;"></div>

<br>
<script language="javascript1.2" type="text/javascript">
<!--

var Teller=null
function toontijd () {
var nu = new Date()
var maand = nu.getMonth()
if (maand == 0)
maand = "Januari";
else if (maand == 1)
maand = "Februari";
else if (maand == 2)
maand = "Maart";
else if (maand == 3)
maand = "April";
else if (maand == 4)
maand = "Mei";
else if (maand == 5)
maand = "Juni";
else if (maand == 6)
maand = "Juli";
else if (maand == 7)
maand = "Augustus";
else if (maand == 8)
maand = "September";
else if (maand == 9)
maand = "Oktober";
else if (maand == 10)
maand = "November";
else if (maand == 11)
maand = "December";

var datum = nu.getDate()

var dag = nu.getDay()
if (dag == 0)
dag = "Zondag";
else if (dag == 1)
dag = "Maandag";
else if (dag == 2)
dag = "Dinsdag";
else if (dag == 3)
dag = "Woensdag";
else if (dag == 4)
dag = "Donderdag";
else if (dag == 5)
dag = "Vrijdag";
else if (dag == 6)
dag = "Zaterdag";
var uren = nu.getHours()
if (uren <=9)
uren = "0"+uren
var minuten = nu.getMinutes()
if (minuten <=9)
minuten = "0"+minuten
var seconden = nu.getSeconds()
if (seconden <=9)
seconden = "0"+seconden
var tijdWaarde = "" + dag
tijdWaarde += " " + datum
tijdWaarde += " " + maand
tijdWaarde += " " + uren
tijdWaarde += ":"+minuten
tijdWaarde += ":"+seconden
document.getElementById('klokbalk').innerHTML=tijdWaarde;
teller =
setTimeout("toontijd()",1000)
}

toontijd()
//-->
</script>
  <br>
</blockquote>


<?php

if($count_oud_toernooi > 0 and isset($toernooi) and ($rechten == 'A' or  $rechten == 'I')){
echo "<center><div style='color:red;font-size:10pt;font-weight:bold;font-family:calibri, san serif;margin-left:100pt;margin-right:100pt;'><marquee>Er zit(ten) nog ".$count." inschrijving(en) van al gespeelde toernooien in het systeem. A.u.b. verwijderen.
      Dat kan via de prullenbak (rechtsboven op dit scherm. Gegevens worden opgeslagen in archief.)</marquee></div></center>";
}


?>

<!---////-------------------------------------------------  JAVASCRIPTS TBV NAVIGATIE TABS ------------------------------////--> 	  

<script type="text/javascript">
 
//[which tab (1=first tab), ID of tab content to display]:
<?php
if (isset($_GET['tab'])  and $_GET['tab'] == 1){ ?> 
       var initialtab=[1, "Start"] 
<?php
} 
else {  ?>
var initialtab=[12, "Uitleg"] 
<?php } ?> 

<?php
if ($aantal_toernooien == 0){  ?> 
       var initialtab=[1, "Start"] 
<?php  
} 
?>
 
function cascadedstyle(el, cssproperty, csspropertyNS){
if (el.currentStyle)
return el.currentStyle[cssproperty]
else if (window.getComputedStyle){
var elstyle=window.getComputedStyle(el, "")
return elstyle.getPropertyValue(csspropertyNS)
}
}

var previoustab=""

function expandcontent(cid, aobject){
if (document.getElementById){
highlighttab(aobject)
detectSourceindex(aobject)
if (previoustab!="")
document.getElementById(previoustab).style.display="none"
document.getElementById(cid).style.display="block"
previoustab=cid
if (aobject.blur)
aobject.blur()

return false
}
else
return true
}

function highlighttab(aobject){
if (typeof tabobjlinks=="undefined")
collecttablinks()
for (i=0; i<tabobjlinks.length; i++){
tabobjlinks[i].style.backgroundColor=initTabcolor
}
var themecolor=aobject.getAttribute("theme")? aobject.getAttribute("theme") : initTabpostcolor
aobject.style.backgroundColor=document.getElementById("tabcontentcontainer").style.backgroundColor=themecolor

}

function collecttablinks(){
var tabobj=document.getElementById("tablist")
tabobjlinks=tabobj.getElementsByTagName("A")
}

function detectSourceindex(aobject){
for (i=0; i<tabobjlinks.length; i++){
if (aobject==tabobjlinks[i]){
tabsourceindex=i //s
break
}
}
}

function do_onload(){
var cookiecheck=window.get_cookie && get_cookie(window.location.pathname).indexOf("|")!=-1
collecttablinks()
initTabcolor=cascadedstyle(tabobjlinks[1], "backgroundColor", "background-color")
initTabpostcolor=cascadedstyle(tabobjlinks[0], "backgroundColor", "background-color")
if (typeof enablepersistence!="undefined" && enablepersistence && cookiecheck){
var cookieparse=get_cookie(window.location.pathname).split("|")
var whichtab=cookieparse[0]
var tabcontentid=cookieparse[1]
expandcontent(tabcontentid, tabobjlinks[whichtab])
}
else
expandcontent(initialtab[1], tabobjlinks[initialtab[0]-1])
}

if (window.addEventListener)
window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
window.attachEvent("onload", do_onload)
else if (document.getElementById)
window.onload=do_onload
</script>

<!--------//////-------------------------------------  Tabs ---------------------------/////------------------>
<br><br>
<div style='margin-left:80pt;' width = 80%>
<ul id="tablist"  width=80%   >
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Start', this)"               theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana" id= "Blink">Start</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Inschrijvingen', this)"      theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Inschrijvingen</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Inschrijfformulier', this)"  theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Formulieren</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Bevres', this)"              theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Bevestigingen e.d</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Export', this)"              theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Export en Import</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Lijsten', this)"             theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Lijsten</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('SMS', this)"                 theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2"  face="Verdana">OnTip SMS</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('QRPDF', this)"               theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">QRC en PDF</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('IDEAL', this)"               theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2"  face="Verdana">IDEAL</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Overig', this)"              theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Overig</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Algemeen', this)"            theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Algemeen</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'red'" onmouseout="this.style.border = '1px solid #000000'; this.style.color = 'black'"  onClick="return expandcontent('Uitleg', this)"              theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" face="Verdana">Uitleg</font></a></li>


<?php
	if ($msg_count > 0) { ?>
<li><a  style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '1px solid #000000'"   onClick="return expandcontent('Inbox', this)"               theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="2" color = 'red'  face="Verdana">Meldingen</font></a></li>
<?php } ?>

</ul>
</div>
	 
<!------------------------------------------------------------------   Tab start --------------------------------------------------------------------//---->	

<DIV id="tabcontentcontainer"  style='margin-left:80pt;margin-right:80pt;border:2px solid #000000;box-shadow: 10px 10px 5px #888888;poistion:relative:top:-10px;' cellpadding=0 cellspacing=0'   width = 70%>

<?php
// Hoogte van tabblad afhankelijk van aantal aanwezige toernooien
   $height = 500+($aantal_toernooien*16); 
 ?>
 
<div id="Start"  style="display:none;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:500 class="tabcontent"   >

<div style='text-align:right;' width=100%>
 	<!----- kleur palet    21 nov 2016 ------//---> 
 	
 	  <table border = 0 width= 99%><tr>
 	  	  <td width= 90% ></td>
 	  	  <td><table border =1 style='border-collapse: collapse;'     title='Kleur palet achtergrond kleur' >
 	  	  	 <tr>
 	  	  	 	<!---  hash  teken in url  wordt niet herkend. Daarom is deze vervangen door _    ---->
 	  	  	 	 <td style='background-color:#d8f6ce;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#d8f6ce;'  href = 'update_kleur_index.php?kleur=_d8f6ce'  target='_self'>** </a></td>
 	  	 	  	 <td style='background-color:#cccccc;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#cccccc;'  href = 'update_kleur_index.php?kleur=_cccccc'  target='_self'>**</a></td>
 	  	 	  	 <td style='background-color:#F7D358;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#F7D358;'  href = 'update_kleur_index.php?kleur=_F7D358'  target='_self'>**</a></td>
 	  	 	  	 <td style='background-color:#A9BCF5;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#A9BCF5;'  href = 'update_kleur_index.php?kleur=_A9BCF5'  target='_self'>**</a></td>
 	  	 	  	 <td style='background-color:#FFFFFF;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#FFFFFF;'  href = 'update_kleur_index.php?kleur=_FFFFFF'  target='_self'>**</a></td>
 	  	 	  	 <td style='background-color:#F5A9A9;font-size:9pt; width:15pt;'><a style='text-decoration:none;color:#F5A9A9;'  href = 'update_kleur_index.php?kleur=_F5A9A9'  target='_self'>**</a></td>
 	  	  	</tr>
 	    </table></td></tr>    
 	  </table></div>
<blockquote> 
	<fieldset  style = 'margin:10pt;border:1pt inset; '> 
		
<?php if ( $aantal_toernooien > 0 ) {?>
	
	
	<?php
   $pageName = basename($_SERVER['SCRIPT_NAME']);
   ?>

<FORM action='select_toernooi.php' method='post' name="myForm">
 
  <input type= 'hidden' name ='Toernooi'> 
  <input type= 'hidden' name ='Url' value = '<?php echo $pageName; ?>'> 
  
 <div class="styled-select" >
 	
     <?php
       $i=0;
       // Inddien er maar 1 toernooi is, wordt geen selectielijst getoond
      if ($aantal_toernooien == 1 ) {
      ?>
      <input type= 'hidden' name ='Toernooi' value = '<?php echo $toernooi;?>'>
      <table>
      	<tr>
      <td style='font-weight:bold;padding-right:15pt;font-size:12pt;'> Geselecteerd toernooi : </td>
      <td style= 'display:block;background-color:white;border: 1pt solid black;width:850px;color:blue;padding:2pt;font-size:10pt;' width=800px><?php echo substr($datum,0,10)." > ".$toernooi_voluit." (".$toernooi.")";?></td>
    </tr>
  </table>
    
    <?php
      	}    	
   else { 
  ?>
  <span style='font-weight:bold;padding-right:15pt;font-size:12pt;'>Selecteer een toernooi 	</span>&nbsp&nbsp
 	<SELECT name='Toernooi' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:850px;vertical-align:top;'  id="selectBox" onchange="changeFunc();" size= 7 >
  <?php
      echo "<OPTION style= 'color:blue;font-weight:bold;' value='".$toernooi."' > ".substr($datum,0,10)." > ".$toernooi_voluit. " (".$toernooi.") </option>";           
      
        while($row = mysqli_fetch_array( $toernooien )) {
  	           $var = substr($row['Datum'],0,10);
 	           
 	           if ($today > $var){
 	           	 $color = 'red';
 	           	 $char  = '-'; 
 	           } else {
  	           	$color = 'black';
	           	 $char  = '*'; 
           	}

 	          if (isset($toernooi) and $toernooi == $row['Toernooi']){
 	           	$color = 'blue';
           	 $char  = '>'; 
           	}
 	           
 	       if ($toernooi !=  $row['Toernooi'] ){     
         echo "<OPTION style= 'color:".$color.";' value='".$row['Toernooi']."' >";
     	  echo $var . " ".$char." ". $row['Waarde']. "  (".$row['Toernooi'].") ";
    	  echo "</OPTION>";	
    	 } 
    	  
    	  
    	  $i++;
       }  // end while toernooien
       }  // end if 1 toernooi
     ?>
    </SELECT>
   
    <?php 
     if ($aantal_toernooien > 1) {?>
     	     <INPUT style ='font-size:14pt;color;darkblue;font-weight:bold;font-famlily:verdana;border:1px solid #000000;box-shadow: 5px 5px 5px #888888;
            -moz-border-radius-topleft: 5px;
            -webkit-border-top-left-radius: 5px;
            -moz-border-radius-topright: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-bottomleft: 5px;
            -webkit-border-bottom-left-radius: 5px;
	          -moz-border-radius-bottomright: 5px;
            -webkit-border-bottom-right-radius: 5px;padding:5pt;' type='submit' value='Ophalen'>
             <?php } ?> 	     
    </div>
     
     <em>
     <?php 
     if ($aantal_toernooien > 1) {?>
     <p style= 'margin-left:50pt;font-weight:bold;font-family:verdana;font-size:9pt;' >Selecteer een toernooi uit de lijst en klik op 'Ophalen'. Rood gekleurde toernooien zijn al gespeeld. Het blauw gekleurde toernooi is nu geselecteerd.<br>Tussen haakjes staat de 'interne Ontip' naam van het toernooi.</p>
     	<?php } ?> 	     
     	
     	</em>
          
     <input type='hidden' name='Vereniging'  value='<?php echo $vereniging;?>'  /> 
  </FORM>
 </fieldset> 
 
  
  <h3 style='font-family:verdana;font-size:11pt;'> Basis functies</h3>
  
  <table width=95%>
  	  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
  	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'       >
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "toevoegen_toernooi_stap1.php">Aanmaak nieuw formulier <img src = "../ontip/images/plus.png" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Aanmaken van een formulier voor een nieuw toernooi.</span></a>
		</td></tr>	
	<?php } ?>
	 	
	
	  <?php if ($rechten == 'A' or $rechten == 'I'){ ?>	
	<tr>
		 	<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		 	<a  STYLE ='font-size: 11pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "Inschrijfform.php?toernooi=<?php echo $toernooi; ?>">Inschrijven voor toernooi '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_inschrijf.png' border = 0 width =23  alt='Configuratie'><br><span style=' font-size:9pt;color:black;'>Direct openen van het inschrijfformulier.</span></a>
		 	 <?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;color:black;'>Link voor formulier : <a  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" style= 'font-size:9pt;color:blue;' href='<?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?>' target = _blank'> <?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?></a></span>
   		 <?php }  ?>
		 </td>
		</tr>	
	<?php } ?>	
	
	  <?php if ($rechten == 'A' or $rechten =='C'){ ?>	
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "beheer_ontip.php?toernooi=<?php echo $toernooi; ?>">Aanpassen formulier '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<img src = "../ontip/images/Icon_tools.png" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Aanpassen van de gegevens van het toernooi en de vereniging.</span></a>
		</td></tr>
	<?php }  ?> 
	
  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>">Muteren inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_muteer.png' border = 0 width =22  alt='Muteer inschrijvingen'><br><span style=' font-size:9pt;color:black;'>Aanpassen van inschrijvingen en herzenden van email.</span></a>
			</td>
		</tr>	
  <?php  } ?> 
  
   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "select_verwijderen.php?key=V"">Verwijderen inschrijvingen en/of formulier(en) <img src = "../ontip/images/prullenbak.jpg" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Verwijderen van een formulier en kopieren van de inschrijvingen naar het archief tbv statistieken.</span></a>
		</td></tr>	
  <?php  } ?> 

		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>&lijst_zichtbaar'>Deelnemers lijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<img src='../ontip/images/icon_lijst_kort.png' border = 0 width =22  ><br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alleen Naam en Vereniging.</span></a>
						<?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;color:black;'>Link voor lijst :<a style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href ='<?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?>' target ='_blank'><?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?></a></span>
   		 <?php }  ?>
		 </td></tr>
		 
		 	
 
  
	</table> 
 <br><em>Klik op een van deze opties om naar de desbetreffende pagina te gaan. </em>
 
 <!---//// Nog geen toernooien bekend ------------------------------------------------------------------------------//////---->  
	<?php } else { ?>
			
				
 <h2 style ='font-size:11pt;color;red;font-weight:bold;'>Er zijn nog geen toernooien bekend voor <?php echo $_vereniging;?></h2><br>
				
		<em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>
		<br>
		<table  border= 0>
   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
			 <tr>
			<td><a style= 'padding:10pt;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href=  "toevoegen_toernooi_stap1.php?key=T"><img src='../ontip/images/plus.png' border = 0 width = 27 alt='Toevoegen toernooi' ></a></td>
			<td style ='font-size:11pt;color:blue;font-weight:bold;'>Voeg een toernooi toe door op het '+' plaatje te klikken.</td></tr>
			 <tr>
	  <?php } ?> 		 	
			 	
			<td> <a style= 'padding:10pt;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href="contact.php"><img src='../ontip/images/mail.jpg' width =27 border =0  alt='Mail naar Erik Hendrikx'></a></td>
			<td style ='font-size:11pt;color:blue;font-weight:bold;'>Neem contact op met OnTip beheerder.</td></tr>
			<tr>
				<td><a style= 'padding:9pt;'  onmouseover=="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href='../ontip/pdf/Handleiding.pdf'><img src='../ontip/images/boek.jpg' alt='Handleiding' width =40 border =0></a></td>
				<td style ='font-size:11pt;color:blue;font-weight:bold;'>Handleiding</a></td></tr>
 	  	</table>
		
   <?php } ?>
</blockquote>
</div>

<!------------------------------------------------------------------   Tab inschrijfformulier --------------------------------------------------------------------//---->	
	
<div id="Inschrijfformulier"  style="display:none;padding:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
	
	<fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Inschrijf formulier</legend>
		 	<br>
		 	<table border =0 width=98%>
   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_ontip.php?toernooi=<?php echo $toernooi; ?>">Aanpassen formulier '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src = "../ontip/images/Icon_tools.png" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Aanpassen van de gegevens van het toernooi en de vereniging.</span></a>
		</td></tr>
	<?php } ?> 	
	
	
<?php if ($url_redirect  != ''){  ?>
	 
	 <tr>
	 	<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
 		
   		  Link voor formulier '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>':<br>
          <a style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href='<?php echo "Inschrijfform.php?toernooi=".$toernooi; ?>' target = _blank'> <?php echo "Inschrijfform.php?toernooi=".$toernooi; ?></a>
   	</td>
   	</tr>

	 <tr>
	 	<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
   		  Link voor formulier te gebruiken in frame '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>':<br> <a style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href='<?php echo $url_redirect."inschrijf_form_smal.html?toernooi=".$toernooi; ?>' target = _blank'> <?php echo $url_redirect."inschrijf_form_smal.html?toernooi=".$toernooi; ?></a>
   	</td>
   	</tr>
   		 <?php }  ?>

		
		
  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "toevoegen_toernooi_stap1.php">Aanmaak nieuw formulier <img src = "../ontip/images/plus.png" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Aanmaken van een formulier voor een nieuw toernooi.</span></a>
		</td></tr>	
	 <?php }?>	
  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
  	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "recycle_toernooi_stap1.php">Recycle formulier <img src = "../ontip/images/recycle.jpg" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Recycle van een formulier voor een nieuw toernooi.</span></a>
		</td></tr>	
	<?php } ?>
		 
	  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_mytoernooi_txt.php?toernooi=<?php echo $toernooi; ?>">Aanmaak bronbestand tbv aanmaak nieuw formulier <img src = "../ontip/images/copy_paste.png" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>M.b.v een bronbestand kan een nieuw toernooi worden aangemaakt met dezelfde instellingen als <b><font color= darkgreen> <?php echo $toernooi; ?></font></b>.</span></a>
		</td></tr>	
	 <?php }?>	
	 
	 
	   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "select_verwijderen.php?key=V"">Verwijderen formulier <img src = "../ontip/images/prullenbak.jpg" width=22 border = 0><br><span style=' font-size:9pt;color:black;'>Verwijderen van een formulier en kopieren van de inschrijvingen naar het archief tbv statistieken.</span></a>
		</td></tr>	
	 <?php } ?> 	
	
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "wedcom_functies_stap1.php"  target='_blank'>Beperkte functies aanpassen toernooi Wedstrijdcommissie <b><?php echo $vereniging;?></b></a>
		</td>
  </tr>
  
  
  	</table>                    
  	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
  </fieldset>  
  
</div>

<!------------------------------------------------------------------   Tab inschrijvingen --------------------------------------------------------------------//---->	
	
<div id="Inschrijvingen"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
	<br>
	<fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Inschrijvingen</legend>
		 	<br>
		 	<table border =0 width=98%>


		<tr>
		 	<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		 	<a  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "Inschrijfform.php?toernooi=<?php echo $toernooi; ?>">Inschrijven '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'  <img src='../ontip/images/icon_inschrijf.png' border = 0 width =23  alt='Configuratie'><br><span style=' font-size:9pt;color:black;'>Direct openen van het inschrijfformulier.</span></a>
		 	 <?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;'>Link voor formulier : <a style= 'font-size:9pt;color:blue;' href='<?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?>' target = _blank'> <?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?></a></span>
   		 <?php }  ?>
		 </td>
		</tr>
	
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
		<tr>
		 	<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		 	<a  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "Inschrijfform.php?toernooi=<?php echo $toernooi; ?>&user_select=Yes">Inschrijven (incl selectie) '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src = "../ontip/images/mensen.png" width=20 border = 0><br><span style=' font-size:9pt;color:black;'>Inschrijfformulier met selectiebox leden eigen vereniging.</span></a>
		 	 	 <?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;color:black;'>Link voor formulier : <a style= 'font-size:9pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href='<?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?>&user_select=Yes' target = _blank'> <?php echo $url_redirect."Inschrijfform.php?toernooi=".$toernooi; ?>&user_select=Yes</a></span>
   		 <?php }  ?>                                                                                                     
		 <?php } ?> 
		 </td>
		</tr>
	
		
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
	 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>">Aanpassen inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_muteer.png' border = 0 width =22  alt='Muteer inschrijvingen'><br><span style=' font-size:9pt;color:black;'>Aanpassen van inschrijvingen en herzenden van email.</span></a>
			</td>
		</tr> 
	<?php } ?> 	
		
				<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;' href= 'lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>&lijst_zichtbaar'>Deelnemers lijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_lijst_kort.png' border = 0 width =22  ><br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alleen Naam en Vereniging.</span></a>
						<?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;'>Link voor lijst :<a style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href ='<?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?>' target ='_blank'><?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?></a></span>
   		 <?php }  ?>
		 </td></tr>
		 
    <?php if ($rechten == 'A' or $rechten =='I'){ ?>
     <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>">Importeren inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Importeren van inschrijvingen mbv Excel bestand.</span></a>
			</td>
		</tr>
  <?php } ?> 			
  
    <?php if ($rechten == 'A' or $rechten =='I'){ ?>
     <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "generate_voucher_codes.php?toernooi=<?php echo $toernooi; ?>">Aanmaak voucher codes voor '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Er wordt een lijst gemaakt van 100 unieke voucher codes en deze wordt opgenomen in het systeem en als excel verstuurd naar de organisatie.Voordat de codes worden aangemaakt wordtom een bevetsiging gevraagd om overschrijven te voorkomen.</b></span></a>
			</td>
		</tr>
  <?php } ?> 			
  
  
  <tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "stats_toernooi_days.php?toernooi=<?php echo $toernooi; ?>"  target='_blank'>Grafiek inschrijvingen per dag voor '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <br><span style=' font-size:9pt;color:black;'>Toont een grafiek met per dag het aantal inschrijvingen</span></a>
		</td>
  </tr>
  
  
		</table>    
		<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
   </fieldset>
</div>
<!------------------------------------------------------------------   Tab lijsten --------------------------------------------------------------------//---->	


<div id="Lijsten"  style="display:none;padding:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >

<fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
	<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Lijsten</legend>
			<br>
		<table width=98%>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;' href= 'lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>&lijst_zichtbaar'>Deelnemers lijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_lijst_kort.png' border = 0 width =22  ><br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alleen Naam, Vereniging, Status en indien aangegeven Extra vraag en/of invulveld.</span></a>
						<?php if ($url_redirect  != ''){  ?>
   		  		<br><span style='font-size:10pt;color:black;'>Link voor lijst :<a style= 'font-size:9pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href ='<?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?>' target ='_blank'><?php echo $url_redirect."lijst_inschrijf_kort.php?toernooi=".$toernooi; ?></a></span>
   		 <?php }  ?>
		 </td></tr>
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'lijst_inschrijf_prikbord.php?toernooi=<?php echo $toernooi; ?>'>Inschrijflijst prikbord '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen aangevuld met lege regels.</span></a>
		 </td></tr>
		 
		<?php if ($rechten == 'A' or $rechten =='I'){ ?>
	  <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_inschrijf.php?key=L&toernooi=<?php echo $toernooi; ?>">Uitgebreide lijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alle gegevens.</span></a>
			</td></tr>
   <?php } ?> 
   				
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_wizard_inschrijvingen_stap1.php?toernooi=<?php echo $toernooi; ?>">Lijst wizard <img src= '../ontip/images/wizard.jpg' border =0 width = 22 ><br>
					<span style=' font-size:9pt;color:black;'>Wizard om zelf een lijst samen te stellen.</span></a>
			</td></tr>
   	
  	</table>
  	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
   </fieldset>
</div>

<!------------------------------------------------------------------   Tab bevres --------------------------------------------------------------------//---->	

<div id="Bevres"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
<br>
<fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Bevestigingen, reserve inschrijvingen en boulemaatjes (indien van toepassing) </legend>
			<br>
 
		<table width=98%>
			
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
     <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_bevestigingen_stap1.php?toernooi=<?php echo $toernooi; ?>">Beheer bevestigingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br><span style=' font-size:9pt;color:black;'>Wijzigen gegevens m.b.t betaling en versturen definitieve bevestiging.</span></a>
		</td></tr>
   <?php } ?>

   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
    <?php		if ($aantal_reserves > 0  ){ ?>
  <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_reserveringen.php?toernooi=<?php echo $toernooi; ?>">Beheer reserve inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br><span style=' font-size:9pt;color:black;'>Bevestigen of afwijzen van deelname van reserve teams via mail.</span></a>
		</td></tr>
			<?php  } ?>
	 <?php  } ?>		
	
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
 
    <?php		if ($aantal_boulemaatje > 0  ){ ?>			
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_boulemaatje_stap1.php?toernooi=<?php echo $toernooi; ?>">Beheer Boulemaatje '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/boule_maatje.png' border = 0 width =28  alt='Muteer boulemaatje'><br><span style=' font-size:9pt;color:black;'>Aanpassen van status en verwijderen boule maatjes.</span></a>
			</td>
		</tr>	
  <?php  } ?>		
 <?php } ?>
 	
 	</table>
 	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
</fieldset>
</div>

<!------------------------------------------------------------------   Tab IDEAL --------------------------------------------------------------------//---->	

<div id="IDEAL"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
<br>
<fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Beheer en lijsten IDEAL betalingen(indien van toepassing) </legend>
			<br>
 
		<table width=98%>
			
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
    <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "beheer_ideal_transacties.php?toernooi=<?php echo $toernooi; ?>">Beheer IDEAL betalingen  '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font>'</b>
				<br><span style=' font-size:9pt;color:black;'>Beheer IDEAL betalingen.</span></a>
		</td></tr>
			
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_ideal_transacties.php?toernooi=<?php echo $toernooi; ?>">Lijst IDEAL betalingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'
				<br><span style=' font-size:9pt;color:black;'>Lijst met alle afgehandelde of foutieve IDEAL betalingen.</span></a>
		</td></tr>
	
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_excel_export_ideal_transacties.php?toernooi=<?php echo $toernooi; ?>">Lijst IDEAL betalingen in Excel '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ></b>
				<br><span style=' font-size:9pt;color:black;'>Export  alle afgehandelde of foutieve IDEAL betalingen.</span></a>
		</td></tr>
		
		 <?php } ?>
   
 	
 	</table>
 	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
</fieldset>
</div>



<!------------------------------------------------------------------   Tab overig --------------------------------------------------------------------//---->	

<div id="Overig"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:600px;" class="tabcontent"   >
<br>
<fieldset style='border-style:ridge;border:inset 1pt green;padding:10pt;width:95%;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Overige  </legend>
			<br>
		<table width=95%>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
   	 	 <a class="menuoff"  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "disclaimer.php">Disclaimer</a>&nbsp<img src = '../ontip/images/disclaimer.jpg' width='28'><br><span style=' font-size:9pt;color:black;'>Algemene voorwaarden gebruik OnTip</span>
   		
   	 	</td>
   	 	</tr>
		<tr>
			<td STYLE ='font-size:11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">          
   	 	 <a class="menuoff"  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "toernooi_all.php">Index pagina OnTip alle actieve toernooien van <b><?php echo $vereniging; ?></b></a><img src='../ontip/images/icon_ical.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Pagina met alle toernooien waarvoor kan worden ingeschreven.</span>
   	 	 			<br><span style='font-size:10pt;color:black;'>Link voor pagina :<a style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href ='<?php echo $url_redirect."toernooi_all.php"; ?>'  target ='_blank'><?php echo $url_redirect."toernooi_all.php"; ?></a></span>
   		 
   	 	</td></tr> 
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
   	 	 <a class="menuoff"  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "http://www.ontip.nl/ontip/toernooi_ontip.php">OnTip toernooi kalender</a><img src='../ontip/images/icon_ical.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Pagina met alle OnTip toernooien (alle verenigingen)</span>
   	 	 			<br><span style='font-size:10pt;color:black;'>Link voor pagina :<a style= 'font-size:9pt;color:blue;' href ='http://www.ontip.nl/ontip/toernooi_ontip.php'  target ='_blank'><?php echo "http://www.ontip.nl/ontip/toernooi_ontip.php"; ?></a></span>
   		
   	 	</td>
   	 	</tr>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
					<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "email_lijst_inschrijf.php?toernooi=<?php echo $toernooi; ?>">Email adressen t.b.v mailing toernooi<br><span style=' font-size:9pt;color:black;'>Kopieer lijst email adressen tbv mailing van het toernooi.</span>
   	 	</td>
    </tr>

		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
					<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "email_lijst_archief.php">Email adressen uit archief t.b.v mailing toernooi<br><span style=' font-size:9pt;color:black;'>Kopieer lijst email adressen tbv mailing van het toernooi (uit archief).</span>
   	 	</td>
    </tr>


	  <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
				<a class="menuoff"   STYLE ='font-size: 11pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'toernooi_schema.php?toernooi=<?php echo $toernooi; ?>'>Toernooi schema voorgeloot</a><br><span style=' font-size:9pt;color:black;'>Maak een schema voor de voorgelote partijen.</span>
    </td>
		</tr>
	
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		   <a STYLE ='font-size: 11pt;color:blue'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "aanvraag_extra_beheerder.php">Aanvragen extra OnTip beheerder (via mail)</a><br><span style=' font-size:9pt;color:black;'>Beheer account voor aanmaken en muteren toernooien en inschrijvingen e.d. </span>
	</td>
  </tr>
	
	
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "change_password.php">Wijzigen wachtwoord beheerder (via mail)</a><br><span style=' font-size:9pt;color:black;'>Wachtwoord wordt verstuurd aan de gebruiker gekoppeld emailadres </span>  
		</td>
  </tr>
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "../ontip/stats_one.php?Id=<?php echo $id;?>"  target='_blank'>Statistieken inschrijvingen uit archief <b><?php echo $vereniging;?></b><br><span style=' font-size:9pt;color:black;'>Statistieken mbt aantal inschrijvingen per toernooi e.d. </span>  
		</td>
  </tr>
  
  <tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "wedcom_functies_stap1.php"  target='_blank'>Beperkte functies aanpassen toernooi Wedstrijdcommissie <b><?php echo $vereniging;?></b></a><br><span style=' font-size:9pt;color:black;'>Deze gebruiker heeft alleen toegang tot specifieke functies m.b.t. toernooi.</span>  
		</td>
  </tr>
  
  
 <?php
	 	  $vereniging_url = substr($prog_url,3,-1);
	 	 	?>
	 	
	 	
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'create_toernooi_all_export_json.php?parm=<?php echo $vereniging_url; ?>' >Aanmaak json bestand tbv alle toernooien '<b><font color= darkgreen><?php echo $vereniging ;?></font></b></a>' 
        <br><span style=' font-size:9pt;color:black;'>Aanmaak van een bestand in json bestand met alle toernooien voor de vereniging.</span>
        <br>Aangemaakt betand : 
        <a  STYLE ='font-size: 11pt;color:darkgreen;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'csv/ontip_toernooi_<?php echo $vereniging_url;?>.json' >'ontip_toernooi_<?php echo $vereniging_url;?>.json</a>' 
       <br><span style='font-size:10pt;'>Include in website voor aanmaak : </span> <span style = 'color:blue;'font-size:10pt;'>http://www.ontip.nl/<?php echo $vereniging_url;?>/create_toernooi_all_export_json.html?parm=<?php echo $vereniging_url; ?></span>
		 </tr> 
 
 <?php if ($naam =='admin'){?>
   <tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "../ontip/insert_ontip_toernooi_add_stap1.php?toernooi=<?php echo $toernooi;?>&vereniging_id=<?php echo $vereniging_id;?>"  target='_blank'>Toevoegen sponsor info aan OnTip kalender <b><?php echo $vereniging;?></b></a><br><span style=' font-size:9pt;color:black;'>Marquee wordt toegevoegd aan OnTip kalender tv sponsor.</span>  
		</td>
  </tr>
<?php } ?> 
    
 	</table>
 	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
</fieldset>
</div>

<!------------------------------------------------------------------   Tab export --------------------------------------------------------------------//---->	
<div id="Export"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:700px;" class="tabcontent"   >
	<br>
 <fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Export en Import </legend >
			<br>
	
   <?php if ($rechten == 'A' or $rechten =='I'){ ?>
	<table width=95%>
   	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_alleen_namen_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Excel export - summier (alleen namen) '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alleen Namen t.b.v Excel (xlsx).</span></a>
		 </td></tr>
		 		 
			<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_naam_ver_1kolom_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Excel export - summier (namen + verenigingen)'<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met Namen en Verenigingen t.b.v Excel (xlsx).</span></a>
		 </td></tr>
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_naam_ver_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Excel export - namen + verenigingen, gescheiden kolommen) '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met alleen Namen, Verenigingen en evt Extra vraag t.b.v Excel (xlsx).</span></a>
		 </td></tr>

 <?php if ($hussel_gebruiker  =='J'){ ?>
  
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_tbv_hussel_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Excel export - namen tbv Hussel  '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst(xlsx) van Namen t.b.v Hussel programma(import functie).</span></a>
		 </td></tr>
		 
		 	 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_tbv_hussel_sql.php?toernooi=<?php echo $toernooi; ?>'>SQL export - namen tbv Hussel  '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>txt bestand met sql inserts van Namen t.b.v Hussel programma(import functie).</span></a>
		 </td></tr>
	<?php } ?>	
	 
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_uitgebreid_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Excel export - uitgebreid '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.png' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen met Namen, Licenties en Verenigingen t.b.v Excel (xlsx).</span></a>
		 </td></tr>
		 
	<?php if ($email_notificaties_jn  =='J'){ ?>	 
	   <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_email_notificaties_xlsx.php?id=<?php echo $vereniging_id; ?>&toernooi=<?php echo $toernooi; ?>">Email notificaties '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Lijst met deelnemers die zich hebben aangemeld voor email notificaties.</span></a>
			</td>
		</tr>
		<?php } ?>	
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'Welp_export_txt_inschrijflijst_stap1.php?toernooi=<?php echo $toernooi; ?>' >Aanmaak inschrijflijst bestand tbv Welp toernooi inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  > <img src='../ontip/images/welp_logo.png' border =0 width =25><br><span style=' font-size:9pt;color:black;'>Maakt txt bestand aan om inschrijvingen te kunnen importeren in Welp.</span></a>
		 </td>
		 </tr>
		
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'Welp_export_txt_spelerslijst_stap1.php?toernooi=<?php echo $toernooi; ?>'>Aanmaak Spelerslijst bestand Welp toernooi spelerslijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  > <img src='../ontip/images/welp_logo.png' border =0 width =25><br><span style=' font-size:9pt;color:black;'>Maakt Spelerslijst bestand aan om deelnemers te kunnen selecteren in Welp.</span></a>
		 </td>
		 </tr>
	 
	 		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'Welp_export_txt_spelerslijst_stap1.php?toernooi=<?php echo $toernooi; ?>'>Aanmaak Spelerslijst bestand Welp toernooi spelerslijst '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  > <img src='../ontip/images/welp_logo.png' border =0 width =25><br><span style=' font-size:9pt;color:black;'>Maakt Spelerslijst bestand aan om deelnemers te kunnen selecteren in Welp.</span></a>
		 </td>
		 </tr>
		  		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_inschrijf_pws_xlsx.php?toernooi=<?php echo $toernooi; ?>'>Export inschrijvingen tbv PWS '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  > <br><span style=' font-size:9pt;color:black;'>Maakt Excel bestand aan om inschrijvingen te kunnen importeren in PWS van Sjaak Franken.</span></a>
		 </td>
		 </tr>

	  <!--tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'export_toernooi_xml.php?toernooi=<?php echo $toernooi; ?>'>Opslaan toernooi als xml file tbv Toekan Kalender '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  > <span style=' font-size:9pt;color:black;'><br>Maakt xml bestand aan om aan toernooi kalender te kunnen toevoegen (Toekan).</span></a>
		 </td>
		 </tr-->
	
	
	<?php if ($bond =='NJBB'){ ?>	 
		 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'import_leden_csv_stap1.php'>Import leden met licenties (csv) <?php echo $vereniging;?> <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Maakt csv bestand aan met Namen + Licenties.</span></a>
		 </td></tr>
	<?php }  ?> 	
			 <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= 'PTB_download.php?toernooi=<?php echo $toernooi;?>'>Aanmaak deelnemers bestand  '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' voor Werkman PT Toernooi beheer <img src='../ontip/images/logo_ptb.png' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Het aangemaakte bestand kan worden ingelezen in Petanque Toernooi beheer.</span></a>
		 </td></tr>
		  <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "import_inschrijvingen_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>">Importeren inschrijvingen '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Importeren van inschrijvingen mbv Excel bestand.</span></a>
			</td>
		</tr>
		  <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "import_Excel_voucher_codes_stap1.php?toernooi=<?php echo $toernooi; ?>">Importeren Excel Voucher codes '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/icon_excel.jpg' border = 0 width =22  ><br><span style=' font-size:9pt;color:black;'>Inlezen van Excel (xlsx) bestand met voucher codes tbv toernooi actie.</span></a>
			</td>
		</tr>


		</table>
	<?php } ?> 
		<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
   </fieldset>
</div>
<!------------------------------------------------------------------   Tab uitleg --------------------------------------------------------------------//---->	
<div id="Uitleg"  style="display:none;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;padding:12pt;height:590px;" class="tabcontent"   >
 <br>
		<span style='color:darkblue;font-family:verdana;font-size:14pt;text-align:justify;'><b>OnTIP - Online Toernooi Inschrijving Petanque</b></span>
					<br>
			 <div style = 'font-family:verdana;font-size:10pt;margin-left:35pt;margin-right:35pt;margin-top:15pt;justify:right; background-color:white;border:1px solid #000000;box-shadow: 8px 8px 8px #888888;;padding:5pt;'>   
			 	Met behulp van dit programma kan een inschrijfformulier voor een Pétanque toernooi worden opgezet. Met behulp van dit formulier kunnen spelers zich op ieder moment van de dag via internet opgeven voor een toernooi.
				Voor het aanmaken van een formulier is absoluut <u>geen programmeerkennis</u> nodig. Het aanmaken kost niet meer dan 5 minuten. De gegevens van de inschrijving worden online opgeslagen in een database. Deze gegevens zijn beveiligd opgeslagen en niet vrij toegankelijk. De wedstrijdcommissie ontvangt van een inschrijving direct een email bericht (evt meerdere adressen) en als de inschrijver een eigen email adres opgeeft, wordt van de inschrijving direct een bevestiging verstuurd.<br>
				Ook de deelnemer ontvangt een bevestiging via email (of evt SMS). OnTip kent ook een IDEAL koppeling waarmee een deelnemer direct zijn/haar inschrijving kan betalen.
				<br><br>Aan de hand van een aantal kenmerken kan het formulier op een groot aantal zaken naar eigen wens worden aangepast.
				Naast instellingen die direct betrekking hebben op het toernooi, zoals datum, kosten, speelvorm (single, doublet, triplet, 4x4,quintet, sextet), etc.  kan ook het formulier aangepast worden met betrekking 
				tot bijvoorbeeld achtergrondkleur en toepasselijke afbeelding. Door het plaatsen van het logo in het formulier en het evt gebruik van clubkleuren krijgt het formulier zo een eigen uitstraling.<br>
				Het is ook mogelijk het formulier te integreren in de eigen website waarbij het nauwelijks te zien is dat het een externe pagina is.
				
				Aan een gebruiker van het programmma kunnen rechten worden toegekend m.b.t. de inschrijvingen, alleen de configuratie of beiden.<br>
				</div>
				<b><br><br><br>
			<span style= 'font-size:10pt;font-weight:bold;font-family:verdana;'>De diverse functies zijn verdeeld over een aantal Tabbladen. Klik op het tabblad 'Start' om te beginnen.</b><br>
			 <br>
			  <table border =0  width= 90%>
       	 <tr>
       	 	<td style='vertical-align:top;'>
       	 		<blockquote>
				<table border =1 style='font-size:8pt;background-color:white;border:1px solid #000000;box-shadow: 5px 5px 3px #888888;' cellpadding=0 cellspacing=0' width =95%>
       		<tr>
       			<th style='background-color:darkgreen;color:yellow;font-size:9pt;'>Tab blad</th>
       			<th style='background-color:darkgreen;color:yellow;font-size:9pt;'>Omschrijving</th>
       		</tr>	
		   
		    	<tr>
       			<td style='color:black;font-size:10pt;'>Start</td>
       			<td style='color:black;font-size:10pt;'>Basis functies: Selectie toernooi, Aanmaak nieuw formulier, Aanpassen formulier, Aanpassen inschrijvingen en Deelnemerslijst.</td>
       	  </tr>
		    	<tr>
       			<td style='color:black;font-size:10pt;'>Inschrijvingen</td>
       			<td style='color:black;font-size:10pt;'>Inschrijvingen toevoegen en aanpassen deelnemerslijst.</td>
       	  </tr>
		    	<tr>
       			<td style='color:black;font-size:10pt;'>Formulieren</td>
       			<td style='color:black;font-size:10pt;'>Aanpassen van de opmaak of gegevens van een formulier (o.a ook soort toernooi, datum, kosten  etc).</td>
       	  </tr>
		    	<tr>
       			<td style='color:black;font-size:10pt;'>Bevestigingen en<br>reserve inschrijvingen</td>
       			<td style='color:black;font-size:10pt;'>Verwerken van bevestigingen, reserve inschrijvingen en boulemaatjes.</td>
       	  </tr>
		    	<tr>
       			<td style='color:black;font-size:10pt;'>Lijsten</td>
       			<td style='color:black;font-size:10pt;'>Keuze van diverse overzichten of via wizard maken van een eigen overzicht van inschrijvingen.</td>
       	  </tr>
          <tr>
       			<td style='color:black;font-size:10pt;'>Export en Import</td>
       			<td style='color:black;font-size:10pt;'>Inschrijvingen exporteren naar Excel, Welp of Petanque Toernooi Beheer. Aanmaak en upload van eigen ledenbestand.</td>
       	  </tr> 
          <tr>
       			<td style='color:black;font-size:10pt;'>Meldingen</td>
       			<td style='color:black;font-size:10pt;'>Meldingen m.b.t verstoringen.Tab alleen aanwezig indien er iets te melden valt.</td>
       	  </tr> 
		      <tr>
       			<td style='color:black;font-size:10pt;'>OnTip SMS</td>
       			<td style='color:black;font-size:10pt;'>Diverse programma's tbv SMS dienst.Tab alleen aanwezig indien SMS dienst actief.</td>
       	  </tr> 
		      <tr>
       			<td style='color:black;font-size:10pt;'>QRC en PDF</td>
       			<td style='color:black;font-size:10pt;'>Aanmaak van QR code images en toernooi flyers in PDF formaat.</td>
       	  </tr> 
       	  <tr>
       			<td style='color:black;font-size:10pt;'>IDEAL</td>
       			<td style='color:black;font-size:10pt;'>Inschrijvingen betalen via iDEAL.</td>
       	  </tr> 
       	  <tr>
       			<td style='color:black;font-size:10pt;'>Overig</td>
       			<td style='color:black;font-size:10pt;'>Aanmaken toernooi schema, Aanvraag extra beheerder, links naar OnTip kalender vereniging en alle verenigingen, aanpassen wachtwoord, aanmaken mailing </td>
       	  </tr> 
		      <tr>
       			<td style='color:black;font-size:10pt;'>Algemeen</td>
       			<td style='color:black;font-size:10pt;'>Informatieve pagina met OnTip gegevens.</td>
       	  </tr> 
		     
		      <tr>
       			<td style='color:black;font-size:10pt;'>Uitleg</td>
       			<td style='color:black;font-size:10pt;'>Deze pagina.</td>
       	  </tr> 
		     </table>
		    </blockquote>
		     <br>
		     De meest gebruikte functies kunnen ook gestart worden via een icon in de plaatjes balk rechtsboven. Door met de muis erover heen te glijden zie je wat er gestart kan worden met welk icoontje.
					 </td>
			 <td>
	
			</span><br>
			
     </td>
    </tr>
  </table>
	   
     <div style='text-align:right;font-size:8pt;color:black;margin-right:30pt;'><img src = '../ontip/images/ontip_logo_zonder_bg.png' width='220'></div>
     <div style='text-align:left;font-size:8pt;color:black;font-weight:bold;'>Erik Hendrikx (c) 2012-<?php echo date('Y') ; ?></div>
      
</div>
<!------------------------------------------------------------------   Tab QRC en PDF --------------------------------------------------------------------//---->	
<div id="QRPDF"  style="display:none;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;padding:15pt;height:550px;" class="tabcontent"   >

 <fieldset style='border-style:ridge;border:inset 1pt green;width:95%;padding:15pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>QRC en PDF</legend >

				<table width=95%>
					
			<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_PDF_flyer_stap1.php?toernooi=<?php echo $toernooi; ?>">Aanmaak PDF Flyer t.b.v toernooi '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Met behulp van de toernooi gegevens wordt een flyer in PDF formaat gemaakt.</span></a>
				<?php 
	        $output_pdf = 'images/'.$toernooi.'.pdf';
	    		if (file_exists($output_pdf)){ ?>
	     			<br><a  style= 'font-size:9pt;color:red;' href= '<?php echo $output_pdf;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakte PDF flyer voor dit toernooi</a>
		    	<?php } ?>	
			</td>
		</tr>
			<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "upload_pdf_flyer_stap1.php?toernooi=<?php echo $toernooi; ?>">Upload eigen PDF Flyer t.b.v toernooi '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Voor het uploaden van een eigen Flyer (in PDF formaat).</span></a>
				<?php 
          $output_pdf = 'images/'.$toernooi.'.pdf';
   				if (file_exists($output_pdf)){ ?>
	     			<br><a  style= 'font-size:9pt;color:red;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= '<?php echo $output_pdf;?>' border = 0 width =28 target='_blank' >Klik hier voor de PDF flyer voor dit toernooi</a>
		    	<?php } ?>	
			</td>
		</tr>
		
			<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "delete_pdf_flyer_stap1.php">Verwijderen oude PDF Flyer's <img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Om ruimte op de server te beperken dienen oude flyers verwijderd te worden.</span></a>
			</td>
		</tr>
		
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_form.php?toernooi=<?php echo $toernooi; ?>">Aanmaak QRC Code Inschrijfformulier '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/qrc.png' border = 0 width =28 ></a><br><span style=' font-size:9pt;color:black;'>Via QRC image direct openen van inschrijf formulier op smartphones en tablets tbv flyers.</span>
			<?php 
	         $qrc_link     = 'images/qrc/qrcf_'.$toernooi.'.png';
   				if (file_exists($qrc_link)){ ?>
	     			<br><a  style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= '<?php echo $qrc_link;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakt QRC image voor dit toernooi (inschrijfformulier)</a>
		    	<?php } ?>	
			</td>
		</tr>
	
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'   onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_form_small.php?toernooi=<?php echo $toernooi; ?>">Aanmaak QRC Code Inschrijfformulier (smalle weergave)'<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>' <img src='../ontip/images/qrc.png' border = 0 width =28 ></a><br><span style=' font-size:9pt;color:black;'>Via QRC image direct openen van inschrijf formulier op smartphones en tablets tbv flyers.</span>
			<?php 
	         $qrc_link     = 'images/qrc/qrcf_'.$toernooi.'.png';
   				if (file_exists($qrc_link)){ ?>
	     			<br><a  style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= '<?php echo $qrc_link;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakt QRC image voor dit toernooi (inschrijfformulier compacte weergave)</a>
		    	<?php } ?>	
			</td>
		</tr>	
   	 	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_lijst.php?toernooi=<?php echo $toernooi; ?>">Aanmaak QRC Code deelnemerslijst '<font color= darkgreen>'<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'</font>' <img src='../ontip/images/qrc.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Via QRC image direct openen van deelnemerslijst op smarthpones en tablets tbv flyers.</span></a>
				<?php 
	         $qrc_link     = 'images/qrc/qrcl_'.$toernooi.'.png';
   				if (file_exists($qrc_link)){ ?>
	     			<br><a  style= 'font-size:9pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= '<?php echo $qrc_link;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakt QRC image tbv deelnemerslijst</a>
		    	<?php } ?>	
			</td>
		</tr>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_ontip.php">Aanmaak QRC Code overzichtspagina toernooien <img src='../ontip/images/qrc.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Via QRC image direct openen van overzichtspagina alle toernooien eigen vereniging.</span></a>
			</td>
		</tr>
   	 	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_ical_event.php?toernooi=<?php echo $toernooi; ?>">Aanmaak QRC Code tbv Agenda Smartphone '<font color= darkgreen>'<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'</font>' <img src='../ontip/images/qrc.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Via QRC image direct het toernooi opnemen in de Agenda van je smartphone.</span></a>
				<?php 
	          $qrc_link     = 'images/qrc/qrc_ical_'.$toernooi.'-'.$jaar.$maand.$dag.'.png'; 
   				if (file_exists($qrc_link)){ ?>
	     			<br><a  style= 'font-size:9pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= '<?php echo $qrc_link;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakt QRC image tbv Agenda Smartphone</a>
		    	<?php } ?>	
			</td>
		</tr>
		<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_ontip.php">Aanmaak QRC Code overzichtspagina toernooien <img src='../ontip/images/qrc.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Via QRC image direct openen van overzichtspagina alle toernooien eigen vereniging.</span></a>
			</td>
		</tr>
   	 	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "create_qrcode_app_uitslag.php?toernooi=<?php echo $toernooi; ?>">Aanmaak QRC Code tbv App uitslag '<font color= darkgreen>'<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'</font>' <img src='../ontip/images/qrc.png' border = 0 width =28 ><br><span style=' font-size:9pt;color:black;'>Via QRC image app openen om de uitslag door te geven.</span></a>
				<?php 
	          $qrc_link     = 'images/qrc/qrc_ical_'.$toernooi.'-'.$jaar.$maand.$dag.'.png'; 
   				if (file_exists($qrc_link)){ ?>
	     			<br><a  style= 'font-size:9pt;color:blue;' onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= '<?php echo $qrc_link;?>' border = 0 width =28 target='_blank' >Klik hier voor aangemaakt QRC image tbv Agenda Smartphone</a>
		    	<?php } ?>	
			</td>
		</tr>
   	</table>
   	<br><em>Maak een keuze uit een van de volgende menu opties door er op te klikken</em>  
  </fieldset>
   
</div>
<!------------------------------------------------------------------   Tab algemeen --------------------------------------------------------------------//---->	
<div id="Algemeen"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:6280px;" class="tabcontent"   >
<br>
<fieldset style='border-style:ridge;border:inset 1pt green;padding:5pt;width:95%;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>Algemeen</legend>
			<br>
	
	   <table width = 100%>
	   	<tr>
	   		<td width =55%>
	   <fieldset>
	   	
	   	<table><tr>
	   	    <td style='color:black;font-size:9pt;text-align:left;'>Aantal inschrijvingen OnTip voor toernooien waarvoor de inschrijving open staat   :</td><td style='color:black;font-size:9pt;text-align:right;'><?php echo $_totaal_inschrijvingen;?></td></tr>
		    	<td style='color:black;font-size:9pt;text-align:left;'>Aantal ingeschreven personen OnTip in archief                                     :</td><td style='color:black;font-size:9pt;text-align:right;'><?php echo $_totaal_archief;?></td></tr>
		     </table>
		    </fieldset>
		     <BR>
		     
		    			      <H3>Laatste 8 inschrijvingen binnen OnTip (alle toernooien) </H3>
		   
       	<table border =1 style='font-size:8pt;background-color:white;border-collapse: collapse;box-shadow: 8px 8px 8px #888888;' >
       		<tr>
       			<th style='color:yellow;font-size:8pt;background-color:darkgreen;'> Vereniging </th>
       			<th style='color:yellow;font-size:8pt;background-color:darkgreen;'   width=45pt > Toernooi </th>
       			<th style='color:yellow;font-size:8pt;background-color:darkgreen;'> Datum </th>
       		  <th style='color:yellow;font-size:8pt;background-color:darkgreen;'> Inschrijving </th>
       		</tr>	
		   
		     <?php
		     while($row = mysqli_fetch_array( $qry3 )) {
		     	
		    	$qry_i  = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'toernooi_voluit' ")  ;
		    	$row_i  = mysqli_fetch_array( $qry_i );
		     	$toernooi_voluit  = $row_i['Waarde'];
		     		     	
		      ?> 
		    	<tr>
       			<td style='color:black;font-size:8pt;'><?php echo $row['Vereniging'];?> </th>
       			<td style='color:black;font-size:8pt;'><?php echo $toernooi_voluit;?> </th>
       			<td style='color:black;font-size:8pt;'><?php echo $row['Datum'];?> </th>
       			<td style='color:black;font-size:8pt;'><?php echo $row['Inschrijving'];?> </th>
       	  </tr>
         <?php } ?>
		     </table>
		     
		     <?php
		     
		     $qry_i  = mysqli_query($con,"SELECT DATE_FORMAT(Inschrijving, '%Y-%m-%d') as Datum ,count(*) as Aantal FROM `inschrijf`   group by 1 order by 1 DEsc limit 7");
		     ?>
		    <br> 
		   <H3>Aantal inschrijvingen laatste 7 dagen binnen OnTip (alle toernooien) </H3>
		   
		   <table border =1 style='font-size:8pt;background-color:white;border-collapse: collapse;box-shadow: 8px 8px 8px #888888;' width=60%>
       		<tr>
       			<th style='color:yellow;font-size:8pt;background-color:darkgreen;padding:2pt;' width=25pt> Datum </th>
       		  <th style='color:yellow;font-size:8pt;background-color:darkgreen;padding:2pt;' width=25pt> Aantal </th>
       		</tr>	
       		
       		<?php
		   while($row = mysqli_fetch_array( $qry_i )) {
 	     ?>
		     <tr>
		     	<td style='color:black;font-size:8pt;padding:2pt;'><?php echo $row['Datum'];?> </th>
		     	<td style='color:black;font-size:8pt;text-align:right;padding:2pt;'><?php echo $row['Aantal'];?> </th>
		     </tr>
		   <?php } ?>
		  </table>
		    </td>
		    <td style='vertical-align:middle;'>
		    	<fieldset style='background-color:white;'>
		    	<iframe src ='../ontip/stats_maand_archief.php' width=700 height=450 frameborder = 0 scrolling = 'no' ></iframe>
		    </fieldset>
		    </td>
		  </tr>
		</table>	 
		  <br><br><br>   
	 	</fieldset>
</div>

<!------------------------------------------------------------------   Tab ideal --------------------------------------------------------------------//---->	
<div id="IDEAL"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
	<br>
<fieldset style='border-style:ridge;border:inset 1pt green;padding:10pt;width:95%;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;'>IDEAL Financiele transacties (indien van toepassing)</legend >
			<br>
     <?php		if (isset($ideal_betaling_jn) and $ideal_betaling_jn == 'J'  ){ ?>

		<table>
			<?php		if ($aantal_ideal_transacties > 0  ){ ?>		
	   <tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_ideal_transacties.php?toernooi=<?php echo $toernooi; ?>">Overzicht IDEAL transacties <img src = '../ontip/images/ideal.bmp' border = 0 width='28'><br><span style=' font-size:9pt;color:black;'>Lijst van IDEAL betalingen voor dit toernooi.</span></a>
		</td></tr>
     <?php } ?>
  
	  </table>
	  	<?php  } ?>		
   </fieldset>
</div>

<!------------------------------------------------------------------   Tab inbox  --------------------------------------------------------------------//---->	
<div id="Inbox"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
	<br>
<fieldset style='border-style:ridge;border:inset 1pt green;padding:10pt;'>
		<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>POSTBUS</legend >
			<br>
   
  <?php
  //Check op aanwezige berichten voor de vereniging of allen
$msg_qry    = mysqli_query($con,"SELECT * from messages where (Vereniging = '".$vereniging."' or Vereniging = '*ALL*')  and Begin_datum <= '".$today."' and Eind_datum > '".$today."'  order by Laatst desc")           or die(' Fout in select msg');  
$msg_count  = mysqli_num_rows($msg_qry);
  
  ?>
  <table border =0 width=95%><tr>
		<td><h3 style='padding:10pt;font-size:20pt;color:green;'>POSTBUS      <img src = "../ontip/images/mailbox.jpg" width=45 border = 1></h3></td>
			</tr>
</table>
<br>
		<div style='color:black;font-size:9pt;font-family:arial;'>Deze postbus bevat berichten m.b.t. OnTip. Deze kunnen bestemd zijn voor de eigen vereniging of voor alle OnTip verenigingen en hebben meestal betrekking op technische problemen waardoor een of meer OnTip functies niet beschikbaar zijn.</div><br>



	<table width=98% style= 'background-color:white;' border =1>
		<tr>
			<th style='width:120pt;'>Datum</th>
			<th style='width:200pt;'>Vereniging</th>
			<th style='width:280pt;'>Bericht</th>
		</tr>	
	<?php
	while($row = mysqli_fetch_array( $msg_qry )) {
   
   echo "<tr>";
   echo "<td style= 'font-size:10pt;color:black;'>".$row['Begin_datum']."</td>";
   echo "<td style= 'font-size:10pt;color:blue;'>".$row['Vereniging']."</td>";
   echo "<td style= 'font-size:10pt;color:blue;'>".$row['Bericht_regel1']."";
 
   if ($row['Bericht_regel2'] !=''){
     echo "<br>".$row['Bericht_regel2']."";
   }  
     
   echo "</td>";
   echo "</tr>";

 }// end while
 ?>
</table>
<br>  
  
   
   </fieldset>

</div>

<!------------------------------------------------------------------   Tab SMS --------------------------------------------------------------------//---->	
<div id="SMS"  style="display:none;padding-left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;height:550px;" class="tabcontent"   >
	<br>
<fieldset style='border-style:ridge;border:inset 1pt green;padding:10pt;width:95%;'>
<legend style='left-padding:5pt;color:black;font-size:12 px;font-family:verdana;font-weight:bold;'>OnTip SMS</legend >			<br>
		
		<?php
		      // Check sms_tegoed    
      include('sms_tegoed.php');
      echo "<blockquote><table style='border-collapse: collapse;border : 2pt solid green;box-shadow: 5px 5px 2px #888888;' >
      <tr><td style='background-color: green;color:white;font-size:7pt;padding:5pt;text-align:center;'>SMS tegoed<br> in OnTip bundel</td>
      <td style='background-color: white;color:black;font-size:11pt;width:25pt;text-align:center;padding:4pt;font-weight:bold;'> ".$sms_tegoed."</td></tr>
    
      </table></blockquote><br>";
      
      if ($verzendadres_sms  == ''){
       echo "<div style='background-color: <?php echo $indexpagina_achtergrond_kleur; ?>;color:red;font-size:10pt;padding:8pt;'>**  Voor ".$vereniging." is de SMS dienst nog niet geactiveerd. </div><br>";
       $sms_bevestigen_zichtbaar_jn = 'N';
     }
     // Definieer variabelen en vul ze met waarde uit tabel config

       $qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
        while($row = mysqli_fetch_array( $qry )) {
	
    	 $var = $row['Variabele'];
	     $$var = $row['Waarde'];
	     }
		?>
		
	<table width=95%>
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "aanvraag_sms.php"  target='_blank'>Aanvraag SMS bundel  <br><span style=' font-size:9pt;color:black;'>Kopen van een SMS bundel t.b.v SMS bevestigen.</span></a></a>
		</td>
  </tr>
<?php    if ($verzendadres_sms  != ''){?>
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'"  href= "../ontip/test_sms_stap1.php?toernooi=<?php echo $toernooi; ?>">Test met SMS bericht</b><br>
					<span style=' font-size:9pt;color:black;'>Test of de SMS dienst werkt.</span></a>
			</td></tr>
 
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_inschrijf_sms.php?toernooi=<?php echo $toernooi; ?>">Lijst met SMS berichten voor '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br>
					<span style=' font-size:9pt;color:black;'>Lijst van inschrijvingen die via SMS bevestigd zijn.</span></a>
			</td></tr>
			
	<tr>
			<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'">
				<a  STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "lijst_service_sms.php">Lijst met SMS service berichten voor '<b><font color= darkgreen><?php echo $vereniging ;?></font></b>'<br>
					<span style=' font-size:9pt;color:black;'>Lijst met SMS berichten t.b.v aanvraag SMS bundel etc.</span></a>
			</td></tr>
		
	<tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "send_sms_message_stap1.php?toernooi=<?php echo $toernooi; ?>"  target='_blank'>Sturen SMS bericht t.b.v. '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br><span style=' font-size:9pt;color:black;'>Sturen van een SMS bericht naar meerdere deelnemers.</span></a></a>
		</td>
  </tr>
  
  <tr>
		<td STYLE ='font-size: 11pt;color:blue;background-color:white;'  class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'"> 
		<a STYLE ='font-size: 11pt;color:blue;'  onmouseover="this.style.color = 'red'" onmouseout="this.style.color = 'blue'" href= "send_sms_message_xlsx_stap1.php?toernooi=<?php echo $toernooi; ?>"  target='_blank'>Sturen SMS bericht t.b.v. '<b><font color= darkgreen><?php echo $toernooi_voluit ;?></font></b>'<br><span style=' font-size:9pt;color:black;'>Sturen van een SMS bericht naar meerdere deelnemers adhv Excel bestand.</span></a></a>
		</td>
  </tr>
 <?php } ?>			
 
    
 	</table>
 	</div>

</fieldset>

<div style='position:relative;top:-29;right:-68;text-align:right;'><a href = 'https://www.twitter.com/ErikOnTip' target ='_blank'><img class="HoverBorder" src ='https://www.ontip.nl/ontip/images/Twitter_logo.png' width = 28 border =0></a></div>
<div style='position:relative;top:-23;right:-68;text-align:right;'><a href = 'contact.php' target ='_top'>                       <img class="HoverBorder" src ='https://www.ontip.nl/ontip/images/mail_icon_blauw.png' width = 28 border =0>	</a>	</div>
<div style='position:relative;top:-17;right:-68;text-align:right;'><a href = '<?php echo $url_website; ?>' target ='_top'>       <img class="HoverBorder" src ='https://www.ontip.nl/ontip/images/home_icon_blue.png' width = 28 border =0></a>		</div>

<?php if ($bond =='NJBB'){?>	 
<div style='position:relative;top:-15;right:-68;text-align:right;'><a href = 'https://www.njbb.nl' target ='_top'>       <img class="HoverBorder" src ='https://www.ontip.nl/ontip/images/NJBB_logo.jpg' width = 30 border =0></a>		</div>
<?php } ?>

<?php if ($bond =='De Regio'){ ?>	 
<div style='position:relative;top:-15;right:-68;text-align:right;'><a href = 'https://deregiojdb.nl/DOBIEL/indey.html' target ='_top'>       <img class="HoverBorder" src ='https://www.ontip.nl/ontip/images/deregio.jpg' width = 35 border =0></a>		</div>
<?php } ?>
</div>
<script type="text/javascript" id="cookieinfo"
	src="../ontip/js/cookinfo.js">
</script>
</body>
</html>