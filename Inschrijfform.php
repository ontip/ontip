<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Inschrijform.php
// Inschrijf programma voor OnTip
//
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 18okt2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Ontbrekende vars
# Fix:              Opgelost
# Feature:          None.
# Reference:
#
# 25jan2019         1.0.2            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None
# Fix:              None
# Feature:          Migratie naar PHP 7
# Reference:

# 24feb2019         1.0.3           E. Hendrikx 
# Symptom:   		None.
# Problem:     	    None.
# Fix:              None.
# Feature:          datum toernooi cyclus niet vermelden als max is bereikt. Max wordt bijgehouden toernooi_datums_cyclus per datum
# Reference: 

# 3mei2019         1.0.4            E. Hendrikx
# Symptom:   		None.
# Problem:       	Bij voorlopige bevesting = J en $uitgestelde_bevestiging_vanaf boven 0, dan staat er twee keer de melding dat het een voorlopige bevestiging is
# Fix:              $uitgestelde_bevestiging_vanaf alleen in combinatie met uitgestelde_bevesting = N  
# Feature:          None
# Reference:

# 31jan2020         1.0.4            E. Hendrikx
# Symptom:   		Selectie toernooien in de kop werkt niet
# Problem:       	Aantal toernooien klopte niet in functie msqli_num_rows. Vervangen door count(*)
# Fix:              None
# Feature:          None
# Reference:


 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Database gegevens. 
include('mysqli.php');
/// selectie privacy tekst 
$qry1      = mysqli_query($con,"SELECT Privacy_tekst From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select');  
$result1   = mysqli_fetch_array( $qry1);
$privacy_tekst = $result1['Privacy_tekst'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>OnTip Inschrijf formulier</title>
	<link rel="stylesheet" type="text/css" href="mycss.css" />
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
 <script type='text/javascript' src='js/utility.js'></script>	  
<style type=text/css>
 body {font-family: Calibri, Verdana;font-size:10pt;}
 input:focus, input.sffocus  { background: lightblue;cursor:underline; }
 textarea:focus { background: lightblue;cursor:underline; }
 em {font-family: Calibri, Verdana;font-size:10pt;}

.simple {border: solid 1pt #9e9e9e;
}

.normal {text-align:right;padding-right:5pt; } 
 
#dropdown { position:absolute; width:200px; display:none; }
#dropdown li:hover { background:#ccc; cursor:pointer; }
   
.normal {outline-style:none;
              cursor:auto
              } 
.dotted { border:2px dotted red;
              outline-color:red; 
              outline-style:dotted;
              cursor:help
              }     
#marquee{        position: absolute;} 

.tooltip{
    display: inline;
    position: relative;
}
.tooltip:hover:before{
    border: solid;
    border-color: #333 transparent;
    border-width: 6px 6px 0 6px;
    bottom: 20px;
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
    position: absolute;
    z-index: 98;
    width: 100px;
}
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
</Script>

<script type="text/javascript">
function change(that, fgcolor, bgcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}

function make_blank()
{
	document.myForm.Opmerkingen.value="";
}

function make_blank_spam()
{
	document.myForm.respons.value="";
}

function make_blank_telefoon()
{
	document.myForm.Telefoon.value="";
}

function make_blank_email()
{
	document.myForm.Email.value="";
}

function fill_input_n1_field(text)
{
	if (document.myForm.Naam1.value == "")
	{
	   document.myForm.Naam1.value= text;
    } else {
    	document.myForm.Naam1.value= "";
    }
  }

function fill_input_n2_field(text)
{
	if (document.myForm.Naam2.value == "")
	{
	   document.myForm.Naam2.value= text;
    } else {
    	document.myForm.Naam2.value= "";
    }
  }

function fill_input_n3_field(text)
{
	if (document.myForm.Naam3.value == "")
	{
	   document.myForm.Naam3.value= text;
    } else {
    	document.myForm.Naam3.value= "";
    }
  }

function fill_input_n4_field(text)
{
	if (document.myForm.Naam4.value == "")
	{
	   document.myForm.Naam4.value= text;
    } else {
    	document.myForm.Naam4.value= "";
    }
  }

function fill_input_n5_field(text)
{
	if (document.myForm.Naam5.value == "")
	{
	   document.myForm.Naam5.value= text;
    } else {
    	document.myForm.Naam5.value= "";
    }
  }

function fill_input_n6_field(text)
{
	if (document.myForm.Naam6.value == "")
	{
	   document.myForm.Naam6.value= text;
    } else {
    	document.myForm.Naam6.value= "";
    }
  }

function fill_input_l1_field(text)
{
	if (document.myForm.Licentie1.value == "")
	{
	   document.myForm.Licentie1.value= text;
    } else {
    	document.myForm.Licentie1.value= "";
    }
  }

function fill_input_l2_field(text)
{
	if (document.myForm.Licentie2.value == "")
	{
	   document.myForm.Licentie2.value= text;
    } else {
    	document.myForm.Licentie2.value= "";
    }
  }

function fill_input_l3_field(text)
{
	if (document.myForm.Licentie3.value == "")
	{
	   document.myForm.Licentie3.value= text;
    } else {
    	document.myForm.Licentie3.value= "";
    }
  }

function fill_input_l4_field(text)
{
	if (document.myForm.Licentie4.value == "")
	{
	   document.myForm.Licentie4.value= text;
    } else {
    	document.myForm.Licentie4.value= "";
    }
  }

function fill_input_l5_field(text)
{
	if (document.myForm.Licentie5.value == "")
	{
	   document.myForm.Licentie5.value= text;
    } else {
    	document.myForm.Licentie5.value= "";
    }
  }

function fill_input_l6_field(text)
{
	if (document.myForm.Licentie6.value == "")
	{
	   document.myForm.Licentie6.value= text;
    } else {
    	document.myForm.Licentie6.value= "";
    }
  }

function fill_input_v1_field(text)
{
	if (document.myForm.Vereniging1.value == "")
	{
	   document.myForm.Vereniging1.value= text;
    } else {
    	document.myForm.Vereniging1.value= "";
    }
  }

function fill_input_v2_field(text)
{
	if (document.myForm.Vereniging2.value == "")
	{
	   document.myForm.Vereniging2.value= text;
    } else {
    	document.myForm.Vereniging2.value= "";
    }
  }

function fill_input_v3_field(text)
{
	if (document.myForm.Vereniging3.value == "")
	{
	   document.myForm.Vereniging3.value= text;
    } else {
    	document.myForm.Vereniging3.value= "";
    }
  }

function fill_input_v4_field(text)
{
	if (document.myForm.Vereniging4.value == "")
	{
	   document.myForm.Vereniging4.value= text;
    } else {
    	document.myForm.Vereniging4.value= "";
    }
  }

function fill_input_v5_field(text)
{
	if (document.myForm.Vereniging5.value == "")
	{
	   document.myForm.Vereniging5.value= text;
    } else {
    	document.myForm.Vereniging5.value= "";
    }
  }

function fill_input_v6_field(text)
{
	if (document.myForm.Vereniging6.value == "")
	{
	   document.myForm.Vereniging6.value= text;
    } else {
    	document.myForm.Vereniging6.value= "";
    }
  }

function fill_input_v_spam_field(text)
{
	
	   document.myForm.respons.value= text;
   
  }
function show_alert()
{
alert("Uitleg Anti Spam" + '\n' + 
  "Met spam wordt bedoeld het ongevraagd toezenden van mail berichten. Veelal gebeurt dit m.b.v. spam robots." + '\n' +
  "Dit zijn programma's die op het internet zoeken naar invulformulieren.Een spam robot is in staat een formulier automatisch in te vullen en te versturen."  + '\n' +
  "Door het opnemen van een Anti Spam code in het formulier wordt dit tegengegaan." + '\n' +
  "Bij het invullen van het formulier wordt u gevraagd een willekeurige code over te nemen die op het scherm staat afgebeeld." + '\n' +
  "In ons geval staat deze code afgebeeld in het grijze vlakje naast het invulveld voor Anti spam."+ '\n' +
  "Deze dient u exact over te nemen in het invulveld. Dit kan ook door op de code te klikken."
  )
}
function show_alert2()
{
alert("Uitleg SMS" + '\n' + 
  "Indien dit vakje is aangevinkt ontvangt u op het aangegeven telefoon nummer een bevestiging van uw inschrijving." + '\n' +
  "De kosten voor het SMS bericht worden doorbelast aan de organiserende vereniging." + '\n' +
  "Tevens bestaat de mogelijkheid andere informatie m.b.t het toernooi via SMS te ontvangen." + '\n' +
  "Indien u een Email adres heeft ingevuld wordt er ook een bevestiging naar de email gestuurd, maar dat is " + '\n' +
  "niet verplicht. Een email bevestiging is wel nodig in het geval u uw inschrijving zou willen annuleren via de link in het emailbericht." 
  )
}
 
 function show_alert_voucher()
{
alert("Uitleg Voucher" + '\n' + 
  "Uw vereniging maakt voor dit toernooi gebruik van vouchers met sponsor informatie. Deze voucher bevat een unieke code. Indien deze waarde hier invult, krijgt u een reductie op het inschrijfgeld of kunt u deelnemen aan een actie vermeld op de voucher." 
  )
}
 
function show_privacy()
{
alert("Privacy verklaring" + '\n' + 
  "<?php echo $privacy_tekst;?>" 
  )
}


 
function show_hulp()
{
alert("Invul hulp" + '\n' + 
  "* Zoeken a.d.h.v licentie : vul Licentienr in en klik op de afbeelding van het loepje." + '\n' +
  "* Bij klikken op het woord 'Licentie' wordt 'N.v.t.' ingevuld. " + '\n' +
  "* Bij klikken op het woord 'Vereniging' voor het invulvak, wordt de naam van de organiserende vereniging ingevuld." + '\n' +
  "* Nog een keer klikken op het woord 'Vereniging' voor het invulvak, maakt het invulveld weer leeg. " + '\n' +
  "* Klikken op het woord 'Naam' voor het invulvak, maakt het invulveld leeg. "
  )
}

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
 function clearFieldFirstTime(element) {
  if (element.counter==undefined) {
	element.counter = 1;
  }

  else {
	element.counter++;
  }

  if (element.counter == 1) {
	element.value = '';
  }
}

function changeFunc1() {
    var selectBox = document.getElementById("selectBox1");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging1.value= selectedValue;
   }
   
function changeFunc1a() {
    var selectBox = document.getElementById("selectBox1a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById("Vereniging1a").value= selectedValue;
   }
  
function changeFunc2() {
    var selectBox = document.getElementById("selectBox2");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging2.value= selectedValue;
   }
   
function changeFunc2a() {
    var selectBox = document.getElementById("selectBox2a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 document.getElementById("Vereniging2a").value= selectedValue;
   }
   
function changeFunc3() {
    var selectBox = document.getElementById("selectBox3");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging3.value= selectedValue;
   }

function changeFunc3a() {
    var selectBox = document.getElementById("selectBox3a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 document.getElementById("Vereniging3a").value= selectedValue;
   }


function changeFunc4() {
    var selectBox = document.getElementById("selectBox4");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging4.value= selectedValue;
   }

function changeFunc4a() {
    var selectBox = document.getElementById("selectBox4a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 document.getElementById("Vereniging4a").value= selectedValue;
   }


function changeFunc5() {
    var selectBox = document.getElementById("selectBox5");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging5.value= selectedValue;
   }
   
function changeFunc5a() {
    var selectBox = document.getElementById("selectBox5a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 document.getElementById("Vereniging5a").value= selectedValue;
   }


function changeFunc6() {
    var selectBox = document.getElementById("selectBox6");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.myForm.Vereniging6.value= selectedValue;
   }

function changeFunc6a() {
    var selectBox = document.getElementById("selectBox6a");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
 document.getElementById("Vereniging6a").value= selectedValue;
   }


  
function changeFunc11() {
    var selectBox = document.getElementById("selectBox11");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie1.value= myarr[0];
    document.myForm.Naam1.value= myarr[1];
    document.myForm.Vereniging1.value= myarr[2];
    document.myForm.Email.value= myarr[3];
    document.myForm.Telefoon.value= myarr[4];
   }

function changeFunc21() {
    var selectBox = document.getElementById("selectBox21");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie2.value= myarr[0];
    document.myForm.Naam2.value= myarr[1];
    document.myForm.Vereniging2.value= myarr[2];
   }

function changeFunc31() {
    var selectBox = document.getElementById("selectBox31");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie3.value= myarr[0];
    document.myForm.Naam3.value= myarr[1];
    document.myForm.Vereniging3.value= myarr[2];
   }

function changeFunc41() {
    var selectBox = document.getElementById("selectBox41");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie4.value= myarr[0];
    document.myForm.Naam4.value= myarr[1];
    document.myForm.Vereniging4.value= myarr[2];
   }

function changeFunc51() {
    var selectBox = document.getElementById("selectBox51");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie5.value= myarr[0];
    document.myForm.Naam5.value= myarr[1];
    document.myForm.Vereniging5.value= myarr[2];
   }

function changeFunc61() {
    var selectBox = document.getElementById("selectBox61");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie6.value= myarr[0];
    document.myForm.Naam6.value= myarr[1];
    document.myForm.Vereniging6.value= myarr[2];
   }

function changeFunc7(challenge) {
    document.myForm.respons.value= challenge;
   }

IE=(navigator.appName.indexOf('Microsoft') >= 0);
NS=(navigator.appName.indexOf('Netscape') >= 0);
SF=(navigator.appName.indexOf('Safari') >= 0);
FF=(navigator.userAgent.indexOf('Firefox') >= 0);
OP=(navigator.userAgent.indexOf('Opera') >= 0);
GK=(navigator.userAgent.indexOf('Gecko') >= 0);
V4=(parseInt(navigator.appVersion) >= 4);
if((V5=navigator.appVersion.indexOf('MSIE '))<0) V5=-5;
V5=(parseInt(navigator.appVersion.charAt(V5+5))>=5);
MAC=(navigator.userAgent.indexOf('Mac')!=-1);

function weCheckForm( frm )
{
	for(var k=0; k<frm.elements.length; ++k)
	{	var obj=frm.elements[k];
		if(obj.type && ('text,textarea,password,file,email'.indexOf(obj.type.toLowerCase()) >= 0))
		{
			if( obj.value == '')
			{	alert('Voer de gevraagde informatie in het veld in.');
				obj.focus();
				return false;
			}
		}
	}
	return true;
}
</script>
</head>

<?php
error_reporting(E_ALL);
ini_set('display_errors','Off');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


ini_set('default_charset','UTF-8');



if ($datum_verloop_licentie !='0000-00-00'){
/// 01234567890
/// 2014-12-21
$dag    = substr($datum_verloop_licentie,8,2);
$maand  = substr($datum_verloop_licentie,5,2);
$jaar   = substr($datum_verloop_licentie,0,4);

$_datum_verloop = strftime("%d-%m-%Y",mktime(0,0,0,$maand,$dag,$jaar)) ;
$week_ervoor    = strtotime ("-1 week", mktime(0,0,0,$maand,$dag,$jaar));
$week6_erna     = strtotime ("+6 week", mktime(0,0,0,$maand,$dag,$jaar));
$today          = date('Y-m-d');
$_week6_erna    = date("Y-m-d", $week6_erna);
}

/// selectie bond  tbv vereniging lijst

$qry1      = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select');  
$result1   = mysqli_fetch_array( $qry1);
$bond      = $result1['Bond'];

if ($bond == 'NJBB'){  
$ver_namen = array();
$qry_v     = mysqli_query($con,"SELECT Vereniging_naam from njbb_verenigingen order by Vereniging_naam")     or die(' Fout in select ver');  
//$qry_v     = mysqli_query($con,"SELECT Distinct Vereniging, Vereniging_nr From speler_licenties  group by Vereniging")     or die(' Fout in select');  
    while($row = mysqli_fetch_array( $qry_v )) {
       	  $ver_namen[] = $row['Vereniging_naam'];
   	} // end while
} // end if
else { 

$ver_namen = array();
$qry_v     = mysqli_query($con,"SELECT Vereniging From bond_verenigingen  where Bond = '".$bond."'  order by Vereniging ")     or die(' Fout in select bond vereniging');  
    while($row = mysqli_fetch_array( $qry_v )) {
       	  $ver_namen[] = $row['Vereniging'];
   	} // end while
} // end if

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Inschrijfformulier <?php echo  $toernooi_voluit; ?>";
</script> 
<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// Indien er voor de vereniging meerdere toernooien open staan voor inschrijving zorg voor een selectbox met daarin die toernooien  ////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$today      = date("Y-m-d");
mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") ;  

// Insert alle toernooien voor deze vereniging in hulp toernooi

$insert = mysqli_query($con,"INSERT INTO hulp_toernooi
(`Toernooi`, `Vereniging`,`Vereniging_id`,Inschrijving_open,  `Datum`) 
 select distinct Toernooi, Vereniging,Vereniging_id,'N',  Waarde from config where Vereniging = '".$vereniging."' and Variabele = 'Datum' and   Waarde >= '".$today."' ");

// Update Inschrijving_open
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging_id        = c.Vereniging_id 
   set t.Inschrijving_open  = 'J'
   where t.Vereniging_id = ".$vereniging_id." and 
    c.Variabele    = 'begin_inschrijving'
  and c.Waarde <= '".$today."'  ");

// Update toernooi_voluit
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi           = c.Toernooi and
     t.Vereniging         = c.Vereniging 
   set t.Toernooi_voluit  = c.Waarde
   where t.Vereniging = '".$vereniging."' and 
    c.Variabele    = 'toernooi_voluit' ");

$update             = mysqli_query($con,"UPDATE hulp_toernooi set Inschrijving_open = 'N'  where Vereniging = 'Boulamis' and Toernooi = 'erik_test_toernooi' ");
$qry_toernooien     = mysqli_query($con,"SELECT count(*) as Aantal From hulp_toernooi where Vereniging_id = ".$vereniging_id ." and  Inschrijving_open <> 'N' order by Datum ")     or die(' Fout in select 2');  
$result             = mysqli_fetch_array($qry_toernooien);
$aantal_toernooien  = $result['Aantal'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$toernooi ='';
if (isset($_GET['toernooi'])){
   $toernooi = $_GET['toernooi'];
}

if ($toernooi !='') {
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select tornooi');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	//echo "Var ".$var." heeft waarde  ". $$var. "<br>";
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	};
	
if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
	};


//// eenvoudig formulier 27 feb 2015
if (isset($_GET['simpel'])){
 $simpel = $_GET['simpel'];
}

// 26 aug 2018
if (isset($_GET['email_notificatie'])){
   $email_notificatie = $_GET['email_notificatie'];
}

if (!isset($bestemd_voor)) {
	$bestemd_voor = '';
}
$font_koptekst ='';


if ($font_koptekst =='' ) {
	$font_koptekst = 'Verdana';
}

if (!isset($bankrekening_invullen_jn)) {
	$bankrekening_invullen_jn = 'N';
}

if (!isset($toernooi_gaat_door_jn)) {
	$toernooi_gaat_door_jn = 'J';
}

if (!isset($boulemaatje_gezocht_zichtbaar_jn)) {
	$boulemaatje_gezocht_zichtbaar_jn = 'J';
}

if (!isset($vereniging_selectie_zichtbaar_jn)) {
	$vereniging_selectie_zichtbaar_jn = 'J';
}

if (!isset($uitgestelde_bevestiging_vanaf)) {
	$uitgestelde_bevestiging_vanaf = '0';
}

if (!isset($sms_bevestigen_zichtbaar_jn)) {
	$sms_bevestigen_zichtbaar_jn = 'N';
}

if (!isset($website_link_zichtbaar_jn)) {
	$website_link_zichtbaar_jn = 'J';
}

// email_notificaties_jn
// 26 aug 2018
if (!isset($email_notificaties_jn)) {
	$email_notificaties_jn = 'N';
}


if (!isset($voucher_code_invoeren_jn)){
	$voucher_code_invoeren_jn ='N';
} else {
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'voucher_code_invoeren_jn'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $voucher_code_richting  = $result1['Parameters'];
	
	if ($voucher_code_richting ==''){
		$voucher_code_richting = 'In';
	}
}	

// Check sms_tegoed   
include('sms_tegoed.php');

if ($sms_tegoed < 1){
     $sms_bevestigen_zichtbaar_jn = 'N'; 	
}

/// standaard voor achtergrond kleur voor input velden
$variabele = 'achtergrond_kleur_invulvelden';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $achtergrond_kleur_invulvelden  = $result1['Waarde'];
 
 if ($achtergrond_kleur_invulvelden =='' ){
	$achtergrond_kleur_input   =  '#F2F5A9';
}
else {
	$achtergrond_kleur_input = $achtergrond_kleur_invulvelden;
}	

////// kleur buttons

if (!isset($achtergrond_kleur_buttons)){
 $achtergrond_kleur_verzenden  =  'Red';
 $tekstkleur_verzenden         =  'white';
 $achtergrond_kleur_herstellen =  'Blue';
 $tekstkleur_herstellen        =  'white';
}
else {
 $variabele = 'achtergrond_kleur_buttons';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $id                = $result1['Id'];
 $achtergrond_kleur_button = explode (';', $result1['Waarde']);
 
 $achtergrond_kleur_verzenden   =  $achtergrond_kleur_button[0];
 $tekstkleur_verzenden          =  $achtergrond_kleur_button[1];
 $achtergrond_kleur_herstellen  =  $achtergrond_kleur_button[2];
 $tekstkleur_herstellen         =  $achtergrond_kleur_button[3];
}

$variabele = 'font_koptekst';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);

 $id                 = $result['Id'];
 $font_koptekst     = $result['Waarde'];

// Inschrijven als individu of vast team

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result              = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

$qry            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysqli_fetch_array( $qry );
$url_website    = $row['Url_website'];
$url_logo       = $row['Url_logo'];
$grootte_logo   = $row['Grootte_logo'];
$vereniging_output_naam   = $row['Vereniging_output_naam'];
$onderhoud_ontip    = $row['Onderhoud_ontip'];

// Gebruik alternatief logo bestand (vanaf 12 feb 2015)

$variabele = 'url_logo';
 $qry1        = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result      = mysqli_fetch_array( $qry1);
 $_url_logo  = $result['Waarde'];

if ($_url_logo != basename($url_logo)  and $_url_logo != ''){	  
 	   $url_logo = 'images/'.$_url_logo;
 	   $grootte_logo   = $result['Parameters'];
}

//// strange chars in vereniging

$vereniging = str_replace('\"','&#148', $vereniging);


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       0123456789012345
//       2012-05-29 19:00

$begin_dag    = substr ($begin_inschrijving , 8,2); 
$begin_maand  =	substr ($begin_inschrijving , 5,2); 
$begin_jaar   =	substr ($begin_inschrijving , 0,4); 

// 4 apr 2016
$begin_uur   =	substr ($begin_inschrijving , 11,2); 
$begin_min   =	substr ($begin_inschrijving , 14,2); 

if ($begin_uur ==''){  
	$begin_uur = 00;
	$begin_min = 00;
}

$begin_inschrijving = $begin_jaar."-".$begin_maand."-".$begin_dag." ".$begin_uur.":".$begin_min;


// dubbele spatie vervangen  door 1 (fout in invoer in
$einde_inschrijving = str_replace('  ',' ', $einde_inschrijving);
$einde              = explode(" ", $einde_inschrijving);

$eind_datum_inschrijving = $einde[0];
$eind_tijd_inschrijving  = $einde[1];

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

if (strlen($einde_inschrijving) == 10){
	  $einde_inschrijving = $einde_inschrijving . " 00:00";
}	  

$eind_inschrijving_dag    = substr ($eind_datum_inschrijving , 8,2); 
$eind_inschrijving_maand  =	substr ($eind_datum_inschrijving , 5,2); 
$eind_inschrijving_jaar   =	substr ($eind_datum_inschrijving , 0,4); 

$eind_inschrijving_uur   = substr ($eind_tijd_inschrijving , 0,2); 
$eind_inschrijving_minuut = substr ($eind_tijd_inschrijving , 3,2); 

$eind_tijd_inschrijving   = $eind_inschrijving_jaar.$eind_inschrijving_maand.$eind_inschrijving_dag.$eind_inschrijving_uur.$eind_inschrijving_minuut;
$now          = date("Y").date("m").date("d").date("H").date("i");
$today        = date("Y") ."-".  date("m") . "-".  date("d");

if (!isset ($achtergrond_kleur)){$achtergond_kleur= '#FFFFFF';};
if (!isset ($logo_zichtbaar_jn)){$logo_zichtbaar_jn = 'J';};

/// Bepalen aantal spelers voor dit toernooi
$aant_splrs_q  = mysqli_query($con,"SELECT Count(*) as Aantal from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysqli_error()); 
$result        = mysqli_fetch_array( $aant_splrs_q);
$aant_splrs    = $result['Aantal'];

////
$variabele = 'kosten_team';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
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
    $kosten_team  = ' &#128 '. $kosten . ' per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
 }         
 
/// Ophalen tekst kleur

$qry        = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$row        = mysqli_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$link       = $row['Link'];

/// nieuw vanaf 5-feb-2015 aparte kleur instellingen

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'tekst_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$tekstkleur          = $result['Waarde'];

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'link_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$link                = $result['Waarde'];

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'koptekst_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$koptekst_kleur      = $result['Waarde'];

/// als achtergrondkleur of instellingen niet gevonden in tabel, zet dan default waarden
if ($tekstkleur ==''){ $tekstkleur = 'black';};
if ($koptekst   ==''){ $koptekst   = 'red';};
if ($invulkop   ==''){ $invulkop   = 'blue';};
if ($link       ==''){ $link       = 'blue';};
if ($koptekst_kleur   ==''){ $koptekst_kleur  = 'red';};

/// invul kader achtergrond en tekstkleur (nvt voor single inschrijvingwn)

$invulkop         = $koptekst_kleur ;


/// Afwijkende font voor koptekst

if (!isset($font_koptekst)){
 	$font_koptekst='';
}

if (!isset($min_splrs)){
 	$min_splrs = '0';
}

$variabele = 'toernooi_selectie_zichtbaar_jn';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result   = mysqli_fetch_array( $qry);
 $toernooi_selectie_zichtbaar_jn  =  $result['Waarde'];
 
 if ($toernooi_selectie_zichtbaar_jn ==''){
 	$toernooi_selectie_zichtbaar_jn  ='J';
 }


if ($toernooi_gaat_door_jn == 'N'){
$variabele       = 'toernooi_gaat_door_jn';
 $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result         = mysqli_fetch_array( $qry1);
 $reden_niet_doorgaan = $result['Parameters'];
 }

$variabele       = 'extra_koptekst';
 $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result         = mysqli_fetch_array( $qry1);
 $parameter      = explode('#', $result['Parameters']);
 $extra_koptekst = $result['Waarde'];
 
///  oude situatie extra koptekst op een volgende regel als deze begint met %
///  conversie van oud naar nieuw

$new_line     =  substr($extra_koptekst,0,1);
 if ($new_line == '%'){ 
                   $text_effect  =  '#n';
                   $extra_koptekst = substr($extra_koptekst,1,strlen($extra_koptekst));
 }
 else {
 	$_text_effect  =  substr($extra_koptekst,-2);
 }
 
if ($_text_effect =='#m' or $_text_effect =='#n' or $_text_effect == '#z'){
    $text_effect    = substr($_text_effect,-1);
    $extra_koptekst = substr($extra_koptekst,0,strlen($extra_koptekst)-2);
  } else {  
  	$extra_koptekst = $result['Waarde'];
  	$text_effect    = $parameter[1];
}
 

/// Nieuwe situatie 
/// Laatste positie geeft tekst effect aan 
/// #n = newline  , #m = marquee , #z = zonder
// 11-10-2013 vervangen door parameter


$lichtkant = 'Nee';

switch ($text_effect){
	case 'n': $extra_koptekst = "<br>". $extra_koptekst;break;
	case 'm': $lichtkrant     = 'Ja';break;
	default : $extra_koptekst  = $extra_koptekst;break;
} // end switch

/// check of smartphone tablet

$mobile = 'off';

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	$mobile = 'on';
	$url_afbeelding ='';
	$logo_zichtbaar_jn = 'N';
}

// indicatie voor meld_tijd

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysqli_fetch_array( $qry);
$parameter    = explode('#', $result['Parameters']);

$prefix    = substr($meld_tijd,-2);

//// oude situatie. 11-10-2013 vervangen door parameter
 if ($prefix =='#1') {
 	   $prefix =1;
 	   $meld_tijd = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
 	} else {
 		 $prefix = 2;
 		 $meld_tijd = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
}    

 if ($suffix != '#1' and  $suffix != '#2'){
 	   $prefix    = $parameter[1];
   	 $meld_tijd = $result['Waarde'];
 }	
 
if ($prefix == '2'){
	 	    $meld_tijd_prefix = 'vanaf'; 
    }
    else {
	     	$meld_tijd_prefix = 'voor'; 
      }

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'ideal_betaling_jn' ") ;  
$result       = mysqli_fetch_array( $qry);
$ideal_betaling_jn    =$result['Waarde'];

/// wedstrijd schema 31 jul 2017
$variabele = 'wedstrijd_schema';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select schema');  
 $result    = mysqli_fetch_array( $qry1);
 $wedstrijd_schema   =  '';

 if ($result['Waarde'] !=''){
 	$qry_schema_sel     = mysqli_query($con,"SELECT * From wedstrijd_systemen  where Code = '".$result['Waarde']."'  ")     or die(' Fout in select wedstrijd schema 1');  
  $result_sel         = mysqli_fetch_array( $qry_schema_sel);
	$wedstrijd_schema   = $result_sel['Omschrijving']; 
}

/// meerdaags_toernooi  31 jul 2017

$variabele = 'meerdaags_toernooi_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select schema');  
 $result    = mysqli_fetch_array( $qry1);
 $meerdaags_toernooi_jn   = $result['Waarde'];

if (isset($meerdaags_toernooi_jn)){
	
	
 if ($meerdaags_toernooi_jn ==''){
    $meerdaags_toernooi_jn = 'N';
    }

 if ($meerdaags_toernooi_jn =='J'){
 	 $variabele = 'eind_datum';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select adres');  
   $result    = mysqli_fetch_array( $qry1);
   $eind_datum     = $result['Waarde'];
 
 if ($eind_datum ==''){
 	   $eind_datum = $datum;
 }

 $eind_dag   = 	substr ($eind_datum , 8,2); 
 $eind_maand = 	substr ($eind_datum , 5,2); 
 $eind_jaar  = 	substr ($eind_datum , 0,4); 

} 
// toernooi cyclus
if ($meerdaags_toernooi_jn =='X'){

$datums ='';
$today =  date('Y-m-d');


$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum >= '".$today."'  order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		
		     $datum = $row['Datum'];
	        $dag   = 	substr ($datum , 8,2); 
          $maand = 	substr ($datum , 5,2); 
          $jaar  = 	substr ($datum , 0,4); 
      		$datums  = $datums.",".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ); 
      }
      $datums = substr($datums,1,250);
  }
  
} else {
 $meerdaags_toernooi_jn = 'N';	
}// end isset

    
    
 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<body  bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">


<?php
//  26 oktober 2016  Aanpassijng ivm migratie ///
if ($onderhoud_ontip =='J'){ ?>
<script language="javascript">
		window.location.replace('onderhoud_ontip.php');
</script>
<?php } ?>


<?php
if (isset($_GET['user_select'])){
     $replace = "key=IS&toernooi=".$toernooi."";
     
       
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
        
        if (isset($_GET['toernooi'])){
        	$toernooi = $_GET['toernooi'];
        }
        
       //// Check op rechten
       $rechten  = $result['Beheerder'];
       
       if ($rechten != "A"  and $rechten != "I"){
        echo '<script type="text/javascript">';
        echo 'window.location = "rechten.php"';
        echo '</script>'; 
       }
      
      $user_select = $_GET['user_select'];
      $vereniging_selectie_zichtbaar_jn = 'N';                           // anders kan na selectie van een speler nog de vereniging aangepast worden
 }
  else {
  	$user_select =  'No';
  }	
  

/// bepaal hoogte sel box spelers adv aan spelers

switch($soort_inschrijving){
	 case 'single'  : $sel_box_height=165;break;
	 case 'doublet' : $sel_box_height=240;break;
	 case 'triplet' : $sel_box_height=280;break;
   case 'kwintet' : $sel_box_height=350;break;
	 default        : $sel_box_height=390;break;
} // end switch

?>
<!-----//////---------------------------------------------------------------------------------------------------------------------------------------------------------------/////---->


<!--FORM action="action.php" method=post name = "myForm" -->
<FORM action="send_inschrijf.php" method=post name = "myForm">

<?php

if (isset($_GET['simpel'])){ ?> 
	<input type= 'hidden' name = 'simpel' value = 'Yes'> 
<?php } 

if (isset($_GET['email_notificatie'])){ ?> 
	<input type= 'hidden' name = 'email_notificatie' value = '<?php echo $_GET['email_notificatie'];?>'> 
<?php } 


if (!isset($_GET['simpel'])){ ?> 
	
	
<div 	Style="font-size: 14px;">    
<fieldset style='border:1px solid <?php echo $koptekst_kleur; ?>;width:95%;padding:15pt;background-color:<?php echo($achtergrond_kleur); ?>;'>
    <legend style='left-padding:5pt;color:<?php echo $koptekst_kleur; ?>;font-size:20 px;font-family:<?php echo $font_koptekst; ?>;'>

<?php } else { 

/// Kop tekst ander font grootte op mobiel  14-5-2015
if ($mobile == 'on'){ 
       $font_size=10;
      } else { 
     $font_size=14;
    }

?>
 <div Style="font-size: <?php echo $font_size; ?>pt;font-weight:bold;color:<?php echo $koptekst_kleur; ?>;font-family:<?php echo $font_koptekst; ?>;">  
	Inschrijven   <?php echo $toernooi_voluit; ?>
</div>

<?php
if(!isset($lichtkrant)){
	$lichtkrant ='';
}
?>


<?php if ($extra_koptekst !=''){ ?>

<div Style="font-size: 10px;font-weight:bold;color:<?php echo $tekstkleur; ?>;">
	<!-- ///// lichtkrant -----------------------------------------------///--->
  	<span style='font-size:12px;color:<?php echo($tekstkleur); ?>;font-family: Calibri, Verdana;'>
      <?php if ($lichtkrant == 'Ja'  ){ 
      	  include('marquee.php');?>  </span>&nbsp</legend> 		
      <?php } else { 	echo $extra_koptekst; } 	?> 
       </span>
</div>
<?php } ?>
<br>
<?php } ?>

<?php
if (!isset($_GET['simpel'])){ ?>

      <!--///   select box als er meer toernooien zijn ----------////-------->  	
    	<?php
       if ($aantal_toernooien > 1  and $toernooi_selectie_zichtbaar_jn  == 'J'){ ?>
       	 Inschrijven
           <select name="forma" onchange="location = this.options[this.selectedIndex].value;" style='left-padding:5pt;color:<?php echo $koptekst_kleur; ?>;font-size:20px;font-family:<?php echo $font_koptekst; ?>;background-color:<?php echo($achtergrond_kleur); ?>;'>
           	<option style='left-padding:5pt;font-weight:bold;color:<?php echo $koptekst_kleur; ?>;font-size:20px;font-family:<?php echo $font_koptekst; ?>;' value="<?php echo $prog_url;?>Inschrijfform.php?toernooi=<?php echo $toernooi;?>" selected><?php echo $toernooi_voluit;?></option>
    	   
      <?php
         while($row = mysqli_fetch_array( $qry_toernooien )) {?>
            <option style='font-weight:bold;left-padding:5pt;color:<?php echo $koptekst_kleur; ?>;font-size:20px;font-family:<?php echo $font_koptekst; ?>;' value="<?php echo $prog_url;?>Inschrijfform.php?toernooi=<?php echo $row['Toernooi'];?>"><?php echo $row['Toernooi_voluit'];?></option>
    	    <?php } ?>
          </select>
    <?php } else {?>
    	Inschrijven   <?php echo $toernooi_voluit; ?>&nbsp&nbsp
    <?php } ?>

<?php
if (!isset($lichtkrant)){
	$lichtkrant ='';
}
?>

    <!-- ///// lichtkrant -----------------------------------------------///--->
  	<span style='font-size:18px;color:<?php echo($tekstkleur); ?>;font-family: Calibri, Verdana;'>
      <?php if ($lichtkrant == 'Ja'  and $mobile =='off'){   include('marquee.php');?>  </span>&nbsp</legend> 		
      <?php } else { 	echo $extra_koptekst;  	?>  </span>&nbsp</legend>	  <?php }  

}

  if(!isset($soort_toernooi))     {$soort_toernooi = $soort_inschrijving; }       
?>

<!---- Voorkeurspelling NJBB ---->
<?php switch($soort_inschrijving){
    case 'single' :   $soort = 'tête-a-tête'; break;
    case 'doublet' :  $soort = 'doubletten'; break;
    case 'triplet' :  $soort = 'tripletten'; break;
    case 'kwintet' :  $soort = 'kwintetten'; break;
    case 'sextet' :   $soort = 'sextetten';  break;
  }
  ?>

<?php
$einde = 0 ;


// 201604011700

// 01234567890123456
// 2016-04-01 17:00

$now            = date('Y').sprintf("%02d",date('m')).sprintf("%02d",date('d')).sprintf("%02d",date('H')).sprintf("%02d",date('i'));
$begin_datetime = substr($begin_inschrijving,0,4).substr($begin_inschrijving,5,2).substr($begin_inschrijving,8,2).substr($begin_inschrijving,11,2).substr($begin_inschrijving,14,2);

//////  als toernooi niet open is   4 apr 2016 met tijd

 if ($now < $begin_datetime and $today < $datum){
        echo "<center><br><h2>Inschrijven voor dit toernooi is pas mogelijk vanaf ". strftime("%A %e %B %Y %H:%M", mktime($begin_uur, $begin_min, 0, $begin_maand , $begin_dag, $begin_jaar) )."</h2></center>";
        $einde = 1 ;
 } // end if
 
 if ($today > $datum){
         echo "<br><center><h2 style='font-weight:bold;font-size:12pt;'>Het toernooi is al geweest.</h2></center>";
       $einde = 1 ;
}

if ($_week6_erna  < $today){ 
  echo "<br><center><h2 style='font-weight:bold;font-size:12pt;'>Er kan niet meer worden ingeschreven voor dit toernooi omdat de OnTip licentie van ".htmlentities($vereniging_output_naam, ENT_QUOTES | ENT_IGNORE, "UTF-8")." is verlopen.</h2></center>";
  $einde = 1 ;
}


if ($einde == 0 ) {
?>


<?php
if (!isset($_GET['simpel'])){ ?> 


<table border = 0 >
  <tr>
  		<td width=80% style='font-size:11pt;'>
    Vul het onderstaande formulier in om je in te schrijven voor het <b><?php echo $toernooi_voluit ?></b> van <?php echo $vereniging_output_naam; ?></b>
    	
    	<?php
    	if ($meerdaags_toernooi_jn =='N'){
      	echo " op<br> <br><center><font size =+2><b>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ;
       }  
    	if ($meerdaags_toernooi_jn =='J'){          
             	echo "<br> <br><center><font size =+2><b>van ".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
             	echo " tot en met ".strftime("%A %e %B %Y", mktime(0, 0, 0, $eind_maand , $eind_dag, $eind_jaar) );
      }  
          	 
    	if ($meerdaags_toernooi_jn =='X'){      
             	echo "op <br> <br><center><font size =+2><b>".$datums;
      }  
          
   ?>
   </b></font></center><br> 
   en klik op de <b>Verzenden</b> knop. Dit is een <?php echo $soort_toernooi; ?> toernooi <b>toegankelijk <?php echo $toegang ?></b>. 
  <?php echo "Kosten ".$kosten_team; ?>. Melden <?php echo $meld_tijd_prefix; ?> <?php echo $meld_tijd ?>. Spelen vanaf <?php echo $aanvang_tijd ?>.
  <?php echo $prijzen; ?>
</td>
  <?php if ($logo_zichtbaar_jn == "J"){   ?>
        <td align='center'><img src ='<?php echo $url_logo;  ?>' width='<?php echo $grootte_logo; ?>' ></td>
<?php  } ?>
      </tr>
</table>
     
<!-----  gestructureerde tekst in het geval van een simpel formulier -----------------------///------->     
     
<?php } else { 

/// Kop tekst ander font grootte op mobiel  14-5-2015
if ($mobile == 'on'){ 
       $font_size=18;
      } else { 
     $font_size=9;
    }
?>
    
<?php
if(!isset($meerdaags_toernooi)){
	$meerdaags_toernooi ='';
}
?>
    
  <table border = 0 width=80%>
  <tr><td width=30% style='font-size:<?php echo $font_size; ?>pt;'>Naam toernooi   : </td><td width=40% style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $toernooi_voluit; ?></b> </td>
  
  <?php if ($logo_zichtbaar_jn == "J" and $mobiel !='on'){   ?>
     <td width=20% rowspan = 7 align='center'><img src ='<?php echo $url_logo;  ?>' width='<?php echo $grootte_logo; ?>' ></td> </tr>
  <?php  } ?>
</tr>
   <?php
 	if ($meerdaags_toernooi =='N' or $meerdaags_toernooi ==''){?>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Datum           : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></b> </td></tr>
 <?php } 
 ?>
   <?php
 	if ($meerdaags_toernooi =='J'){?>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Begin datum     : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></b> </td></tr>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Eind datum      : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $eind_maand , $eind_dag, $eind_jaar) )  ?></b> </td></tr>
<?php }  ?>

<?php
if ($meerdaags_toernooi_jn =='X'){      ?>
	 <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Cyclus   : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $datums;?></b> </td></tr>
 <?php     }  ?>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Soort toernooi  : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $soort; ?></b> </td></tr>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Toegang voor    : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $toegang; ?></b> </td></tr>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Melden          : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $meld_tijd_prefix; ?> <?php echo $meld_tijd; ?></b> </td></tr>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Spelen          : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $aanvang_tijd; ?> </b> </td></tr>
  <tr><td  style='font-size:<?php echo $font_size; ?>pt;'>Kosten          : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $kosten_team; ?> </b> </td></tr>
  <tr><td style='font-size:<?php echo $font_size; ?>pt;'>Prijzen        : </td><td style='font-size:<?php echo $font_size; ?>pt;'><b><?php echo $prijzen; ?> </b> </td></tr>
</table>   

<?php } ?>     

        
<?php

if ($toernooi_gaat_door_jn == 'N'){
     echo "<br><div style='font-weight:bold;font-size:12pt;border:1pt solid black;padding:2pt;color:".$koptekst.";'><center><br><h2>Dit toernooi gaat niet door. Reden : ".$reden_niet_doorgaan." </h2></center></div>";
     $einde = 1 ;
} // end if


/// ophalen parameter ivm beperkte inschrijving
		$naam_vereniging = '';
    $wel_niet        = '';
    
if ($bestemd_voor !='' and $einde == 0){
	
   $qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'bestemd_voor' ") ;  
   $result       = mysqli_fetch_array( $qry);
	
   if ($result['Parameters'] =='') { 
     $wel_niet        = substr($result['Waarde'],-2);
     $naam_vereniging = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
    }
   else {
     $naam_vereniging = $result['Waarde'];
     $wel_niet        = $result['Parameters'];
   } 

     $_vereniging = $vereniging;
     if ($vereniging_output_naam !=''){
      	  $_vereniging = $vereniging_output_naam;
    	}
}

$vol_geboekt =0;

if ($aant_splrs  >= $max_splrs and $einde == 0){

 if ($wel_niet == 'J'){

/// 11 aug 2015  aanpassing ivm inschrijving beperkt tot 1 vereniging en inschrijving is vol

 	
 	if ($einde == 0 and $aant_splrs  >= $max_splrs and  $aant_splrs <( $max_splrs + $aantal_reserves )  and $meerdaags_toernooi_jn !='X' ){
   	$vol_geboekt = 1;
   	echo "<div style='font-weight:bold;font-size:10pt;border:1pt solid black;padding:2pt;'>Het toernooi is volgeboekt voor leden van ".$naam_vereniging.". U kunt zich nog als reserve team of speler inschrijven voor het geval er iemand afzegt (Max. ".$aantal_reserves." reserves). ";
	  echo "Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.";
	  
	  
	   // 25 aug 2018 Email notificaties als toernooi vol is en aantal_reserves = 0 
	   
	   
	   if ($email_notificaties_jn =='J' and $aantal_reserves ==0  and $meerdaags_toernooi_jn !='X') {
	   	  echo"<center><h2><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.</h2><br>";
	   	  echo "<a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center>";
	   }	  
	  echo "</div>";
   }
 	
 	if ($aant_splrs  >= $max_splrs and $aantal_reserves == 0){
     $vol_geboekt = 1;
     echo "<center><br><h2>Er hebben zich nu ". $aant_splrs . " teams van ".$_vereniging." ingeschreven voor dit toernooi. <br>Hiermee is het toernooi volgeboekt voor leden van ".$naam_vereniging.".</h2></center>";
     $einde  =1; 
     
      // 25 aug 2018 Email notificaties als toernooi vol is en aantal_reserves = 0 
	   
	   if ($email_notificaties_jn =='J' and $aantal_reserves ==0) {
	   	  echo"<center><h2><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.</h2><br>";
	   	  echo "<a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center>";
	   }	  
	  echo "</div>";
  }    
 
  if ($aant_splrs  >= ( $max_splrs + $aantal_reserves ) and $aantal_reserves > 0 and $meerdaags_toernooi_jn !='X' ){
   	$vol_geboekt = 1;
    echo "<center><br><h2>Er hebben zich nu ". ($max_splrs + $aantal_reserves)  . " teams van ".$_vereniging." (incl ". $aantal_reserves." reserves)  ingeschreven voor dit toernooi. <br>Hiermee is het toernooi volgeboekt voor leden van ".$naam_vereniging.".</h2></center>";
    $einde  =1;
  }	
 	 	
  }
	  else { 

   if ($einde == 0 and $aant_splrs  >= $max_splrs and  $aant_splrs <( $max_splrs + $aantal_reserves ) and $meerdaags_toernooi_jn !='X'  ){
   	$vol_geboekt = 1;
   	echo "<div style='font-weight:bold;font-size:10pt;border:1pt solid black;padding:2pt;'>Het toernooi is volgeboekt. U kunt zich nog als reserve team of speler inschrijven voor het geval er iemand afzegt (Max. ".$aantal_reserves." reserves). ";
	  echo "Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.";
	  
	     // 25 aug 2018 Email notificaties als toernooi vol is en aantal_reserves = 0 
	   
	   if ($email_notificaties_jn =='J' and $aantal_reserves == 0) {
	   	  echo"<center><h2><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.</h2><br>";
	   	  echo "<a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center>";
	   }	  
	  echo "</div>";
   }
	  

   if ($aant_splrs  >= $max_splrs and $aantal_reserves == 0  and $meerdaags_toernooi_jn !='X'){
     echo "<center><br><h2>Er hebben zich nu ". $aant_splrs . " teams ingeschreven voor dit toernooi. <br>Hiermee is het toernooi volgeboekt.</h2></center>";
     $einde  =1; 
     
      // 25 aug 2018 Email notificaties als toernooi vol is en aantal_reserves = 0 
	   
	  if ($email_notificaties_jn =='J' and $aantal_reserves ==0) {
	   	  echo"<center><h2><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.</h2><br>";
	   	  echo "<a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center>";
	   }	  
	   
   }
   
   if ($aant_splrs  >= ( $max_splrs + $aantal_reserves ) and $aantal_reserves > 0 and $meerdaags_toernooi_jn !='X' ){
    echo "<center><br><h2>Er hebben zich nu ". ($max_splrs + $aantal_reserves)  . " teams (incl ". $aantal_reserves." reserves)  ingeschreven voor dit toernooi. <br>Hiermee is het toernooi volgeboekt.</h2></center>";
    $einde  =1;
    }
 } // wel niet
 
}// aantal > max

if ($now > $eind_tijd_inschrijving and $einde == 0){
   echo "<br><center><h2 style='font-weight:bold;font-size:12pt;'>De inschrijftermijn voor dit toernooi is verlopen.</h2></center>";
   $einde  = 1;
}
 
} // end einde 0 
 
   $qry              = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'uitgestelde_bevestiging_jn' ") ;  
   $result           = mysqli_fetch_array( $qry);
   $verval_termijn   = $result['Parameters'];
  
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($einde == 0) {

	if ($uitgestelde_bevestiging_jn =='J'  and $ideal_betaling_jn == 'J' and $vol_geboekt == 0){
  	echo "<br><span style='font-size:10pt;'>Dit betreft een <u>voorlopige inschrijving</u>. Indien u betaaalt via IDEAL ontvangt u via mail een definitieve bevestiging.</span>";
  	if ($verval_termijn >0){
  	 echo "<br><span style='font-size:10pt;'>De voorlopige inschrijving vervalt na ".$verval_termijn." dagen na inschrijving indien er niet bevestigd is.</span>";
    }	
  }
  
  if ($uitgestelde_bevestiging_jn =='J'  and $ideal_betaling_jn == 'J' and $vol_geboekt == 1){
  	echo "<br><span style='font-size:10pt;'>Dit betreft een <u>voorlopige inschrijving</u>. U ontvangt tzt van de organisatie  een definitieve bevestiging of afwijzing.</span>";
  	  	if ($verval_termijn >0){
  	 echo "<br><span style='font-size:10pt;'>De voorlopige inschrijving vervalt na ".$verval_termijn." dagen na inschrijving indien er niet bevestigd is.</span>";
    }	
  }
  
  
  if ($uitgestelde_bevestiging_jn =='J' and $bankrekening_invullen_jn == 'J' and $ideal_betaling_jn != 'J'){
  	echo "<br><span style='font-size:10pt;'>Dit betreft een <u>voorlopige inschrijving</u>. Pas na betaling  ontvangt u via mail een definitieve bevestiging anders een afwijzing.</span>";
   	if ($verval_termijn >0){
  	 echo "<br><span style='font-size:10pt;'>De voorlopige inschrijving vervalt na ".$verval_termijn." dagen na inschrijving indien er niet bevestigd is.</span>";
    }	
  }
  
   
  if ($uitgestelde_bevestiging_jn =='J' and $bankrekening_invullen_jn == 'N'   and $ideal_betaling_jn != 'J')  {
  	echo "<br><span style='font-size:10pt;'>Dit betreft een <u>voorlopige inschrijving</u>. U ontvangt tzt van de organisatie een definitieve bevestiging of afwijzing.</span>";
  }
 	
 	if ($uitgestelde_bevestiging_vanaf > 0 and $aant_splrs >= $uitgestelde_bevestiging_vanaf and $uitgestelde_bevestiging_jn != 'J'){
  	echo "<br><span style='font-size:10pt;'>Dit betreft een <u>voorlopige inschrijving</u>. U ontvangt tzt van de organisatie een definitieve bevestiging of afwijzing.</span>";
  }
 	 	
  if ($inschrijf_methode == 'single' and $soort_inschrijving !='single'){
  	echo "<br>Voor dit ".$soort." toernooi dient individueel (mêlée) te worden ingeschreven. De teams worden via loting samengesteld.<br>";
  }
 
 if  (!isset($_GET['simpel'])){  
  echo "<br>";
}
else {
  	echo "<br>";
}


 if ($mobile == 'on'){ 
 	$font_size = 6;
} else { 
	$font_size = 10;
} 

  if ($inschrijf_methode == 'vast'){  	
  	  	echo  "<span style='font-size:".$font_size."pt;font-weight:bold;maRGIN-LEFT:5PT;font-weight:NORMAL'><br>";
  	 	
	switch ($soort_inschrijving) {
		case "single":     echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " tête-a-tête spelers (max.  ". $max_splrs .")";     break;
    case "doublet":    echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " doublet teams (max.  ". $max_splrs .")";           break;
    case "triplet":    echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " triplet teams (max.  ". $max_splrs . ")";          break;
    case "4x4":        echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " 4x4 teams (max.  ". $max_splrs . ")";              break;
    case "kwintet":    echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " kwintet teams (max.  ". $max_splrs . ")";          break;
    case "sextet":     echo "Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " sextet teams (max.  ". $max_splrs . ")";           break;   
     }   // end switch
    echo "</span>"; 
 } 
  else { 
         echo "<div style='font-size:10pt;font-weight:bold;'><br>Aantal inschrijvingen tot nu toe :  "  .  $aant_splrs  . " (max.  ". $max_splrs .").  </div>"; 
  }// end if
 
 if ($wedstrijd_schema !=''){
       echo "<div style='font-size:10pt;font-weight:bold;'><br>Toegepast wedstrijd systeem :  "  .  $wedstrijd_schema.".</div>"; 
} 	
   
  
 if ($min_splrs > 0 and $aant_splrs < $min_splrs  and $min_splrs < $max_splrs ){
  	echo "<BR>WAARSCHUWING: Het minimum aantal inschrijvingen van ". $min_splrs." voor dit toernooi is nog niet bereikt. Het is dus nog niet zeker of het toernooi doorgaat. Hou de website of de inschrijflijst in de gaten !<br>";
  }
 
 
 if ($einde == 0 and $aantal_reserves != 0 and $aant_splrs > $max_splrs and $inschrijf_methode == 'vast') {
 	switch ($soort_inschrijving) {
		case "single":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve tête-a-tête spelers ingeschreven worden.  </span>"; 
          break;
    case "doublet":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve doubletten teams ingeschreven worden.  </span>";    
          break;
    case "triplet":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve tripletten teams ingeschreven worden.  </span>";    
          break;
    case "4x4":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve 4x4 teams ingeschreven worden.  </span>";    
          break;
    case "kwintet":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve kwintetten teams ingeschreven worden.  </span>";    
          break;
    case "sextet":  
          echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves." reserve sextetten teams ingeschreven worden.  </span>";    
          break;
    }   // send switch
 	} // end if
 	
 	if ($aantal_reserves != 0 and $aant_splrs > $max_splrs and $inschrijf_methode == 'single' ) {
 	    echo "<span style='font-size:".$font_size."pt;'>Er kunnen maximaal ".$aantal_reserves."  reserve spelers ingeschreven worden.  </span>"; 
 	 } 
 	
         
if ($bestemd_voor !=''){
	   
   if ($wel_niet == 'N'){
     	echo "<h5>Inschrijving is niet mogelijk voor leden van ".$naam_vereniging.".</h5>";
	  }
  
	    
   if ($wel_niet == 'J'){
     	echo "<h5>Inschrijving is alleen toegestaan voor leden van ".$naam_vereniging.".</h5> ";
	  }
	  	  
	 }// end bestemd 
   
?>

  <!---/////------ hidden POST parameters ---------------------------------///--->
  
    <input type='hidden' name='toernooi'    value='<?php echo $toernooi;?>'/>
    <input type='hidden' name='datum'       value='<?php echo $datum;?>'/>
    <input type='hidden' name='vereniging'  value='<?php echo $vereniging;?>'/>
    
    <?php
    if ($user_select =='Yes') {
 	   echo "<input type='hidden'  name ='user_select' value ='Yes'>";  
     } 
    if (isset($_GET['simpel'])){ ?> 
      <input type='hidden' name ='simpel' value = 'J' />
    <?php } ?>
 
<?php
 
 //// plaatje links of rechts afhankelijk van parameter #l of #r als laatste 2 karakters url_afbeelding
 
 $qry              = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'url_afbeelding' ") ;  
 $result           = mysqli_fetch_array( $qry);
 $url_afbeelding   = $result['Waarde'];
 $parameter        = explode('#', $result['Parameters']);
 
if ( $parameter[1] != '') { 
   $plaats_afb       = '#'. $parameter[1];
   $url_afbeelding   = $result['Waarde'];
}

// afbeelding zowel breedte als hoogte 12-dec-2014
$afb_width   = 0;
$afb_height  = 0;


if ( $parameter[2] != '') { 
   $afb_width  = $parameter[2];
}
if ( $parameter[3] != '') { 
   $afb_height  = $parameter[3];
}

if ($afb_width > 0){ 
$afb_string = ' width = '.$afb_width.' height = '.$afb_height.' ';
}
else {
$afb_string  = 'width = '.$afbeelding_grootte.' ' ;
}



?>   
 
<!---- //////------------------------ Begin tabel voor inschrijven ----------------------------------------------------------------------/////-->
  <table border = 0 >
  	 <tr>
  	 	<?php
 
      //// vervangen quote voor * voor automatisch invullen vereniging
     $_vereniging =  preg_replace('/&#39t/',  '*t' , $vereniging);
 
   	 	///////////////////////////////////////////////////   afbeelding links
  	 	
  	 	if ($plaats_afb =='#l' and $url_afbeelding !='#l'  and (!isset($_GET['simpel']))   ) {
  	 		?>
  	 		 <td align='right'>
  	 		 	  <?php if($url_afbeelding !=''){?>
    		         <img src ='<?php echo $url_afbeelding ?>' <?php echo $afb_string; ?>  /> 
      	    <?php } 

          ///// speel locatie        	
        	if (isset($adres) and $adres !='') {
            echo "<div style='text-align:left;font-weight:bold;color:".$tekstkleur.";'>";       	
        		$naw = explode(";",$adres,6);
        		
        		$i=0;
             while(isset($naw[$i]))  {
                 	echo $naw[$i]."<br>";
                 	$i++;
            }
             	
          }
        	?> 
       	</td>
        <?php }?>
  	 	
  	   	 	<td width=80% style='padding-left:10px;'>
  	 	
<!-----// Als spelvorm niet gelijk is aan single, dan de spelers voor de teams invoeren --->

 
<?php
//// ophalen van resultaten zoekstring

/* in search_licentie.php (aangeroepen vanuit send_inschrijf.php) zijn de gegevens van de speler(s) opgehaald uit de tabel apeler_licenties en
   weggeschreven in de hulp tabel hulp_select_speler (ivm cookie problemen) a.d.h.v toernooi, vereniging en Ip adres
*/   

if (isset($_GET['gevonden']) ){
  
/// Via hulp_select_speler  niet meer nodig ivm select box users eigen vereniging
//  Via search_licentie.php
//$vereniging_selectie_zichtbaar_jn = 'N';
$ip_adres    = $_SERVER['REMOTE_ADDR'];  
$qry  = mysqli_query($con,"SELECT * from hulp_select_speler 
                   where Toernooi     = '".$toernooi."' and
                         Vereniging   = '".$vereniging."' and
                         IP_adres     = '".$ip_adres."'  ");  	

while($row = mysqli_fetch_array( $qry )) {

If ( $row['Speler_nr']   == 1){
 	   $naam1           = $row['Naam'];
 	   $licentie1       = $row['Licentie'];
 	   $vereniging1     = $row['Vereniging_speler'];
 	   $email           = $row['Email'];
}
 	  
If ( $row['Speler_nr']   == 2){
 	   $naam2           = $row['Naam'];
 	   $licentie2       = $row['Licentie'];
 	   $vereniging2     = $row['Vereniging_speler'];
}
 	   
If ( $row['Speler_nr']   == 3){
 	   $naam3           = $row['Naam'];
 	   $licentie3       = $row['Licentie'];
 	   $vereniging3     = $row['Vereniging_speler'];
}

If ( $row['Speler_nr']   == 4){
 	   $naam4           = $row['Naam'];
 	   $licentie4       = $row['Licentie'];
 	   $vereniging4     = $row['Vereniging_speler'];
}

If ( $row['Speler_nr']   == 5){
 	   $naam5           = $row['Naam'];
 	   $licentie5       = $row['Licentie'];
 	   $vereniging5     = $row['Vereniging'];
}

If ( $row['Speler_nr']   == 6){
 	   $naam6           = $row['Naam'];
 	   $licentie6       = $row['Licentie'];
 	   $vereniging6     = $row['Vereniging_speler'];
}

} // end while

/* 4 jan 2017 bij enkele inschrijving wordt 'undefined' ingevuld bij telefoon en email */
$telefoon = '';


} // end user_select en search

///// Indien alleen bestemd voor vereniging dan vereniging vast invullen

if ($bestemd_voor !=''){
  if ($wel_niet == 'J'){
		
      $vereniging1 = $naam_vereniging;
      $vereniging2 = $naam_vereniging;
      $vereniging3 = $naam_vereniging;
      $vereniging4 = $naam_vereniging;
      $vereniging5 = $naam_vereniging;
      $vereniging6 = $naam_vereniging;
      
      // uitschakelen licentie plicht  weer ongedaan gemaakt  5 feb 2017
   //   $licentie_jn = 'N'; 
     	
	  }// end wel_niet
}  // end bestemd voor
 ?> 
 
 
<?php if ($soort_inschrijving != 'single' and $inschrijf_methode != 'single'){ ?>
 
   <?php  if  (isset($_GET['simpel'])){ ?>    
    <br>
  <?php } ?>
 
  <fieldset style='border:1px solid <?php echo $invulkop;?>;padding:5px;margin-left:5pt;'>
  <?php  if  (!isset($_GET['simpel'])){ ?>
  
   
    <legend width=60% id= 'spelers_kop' Style='color:<?php echo $invulkop;?>;'>Spelers <?php echo $soort_inschrijving ?> team &nbsp
    	<?php if ($licentie_jn != 'N') {  ?>
 
    <!--- 7 sep 2015 indien bestemd_voor is ingevuld kan er niet op licentie gezocht worden omdat er anders een verkeerde vereniging wordt gekoppeld aan de licentie --->
    	
    	  <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
       <?php } ?>	
    	
    	<?php } ?>
    	</legend>
  <?php } ?>
  
  
  <table width=100% border=0>

  <?php  if  (!isset($_GET['simpel'])){ ?>
      
      <!------------------------------------------------------ speler 1 ----------------------------------->
      <tr>
      	<td style='font-size :10pt;width:10pt;'>1.</td>
        <?php          if ($licentie_jn != 'N') { ?>
          <td width="80" onclick="fill_input_l1_field('N.v.t.');" ><em onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie nr</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie1" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie1;?>" ></td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie1' value  =''/>"; 
          }
        ?>
        <td width="100" onclick="fill_input_n1_field('');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Naam</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam1" SIZE="25" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam1;?>"><br>
        	
       	<?php  if ($user_select =='Yes'){ 
        	
         	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox11" onchange="changeFunc11();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]   ;
           $soort    = $parts[3]  ;
           $email    = $parts[4]  ;
           $sms_telefoon = $parts[5]  ;

           //  echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging.",".$email.",".$sms_telefoon."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>
                 	
     	 </td>
        <td width="85" onclick="fill_input_v1_field('<?php echo $_vereniging;?>');"><em class="normal" id= 'dot2'>Vereniging</em></td>
          	<?php  if ($wel_niet == 'J') { ?>
      	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' >
        		   <?php echo $vereniging1;?>
        		   <input   type = "hidden" NAME="Vereniging1" value = "<?php echo $vereniging1;?>">
        		   
        		</td>		
        	<?php } else { ?> 
        	<td width="185" >
        	<input TYPE="TEXT" NAME="Vereniging1" SIZE="21" class="pink" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  style='background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging1;?>">
        	
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding:0pt;' id="selectBox1" onchange="changeFunc1();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
           	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
         	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
        </td>
        	<?php } ?>
        </tr>
 
 <?php } else { ?>
 
 <!--------/////////--------------------  simpel input voor speler 1 ------------------------------------////////---------->
 
 <?php  
  if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 

     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="120" onclick="fill_input_l1_field('N.v.t.');" ><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 1</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie1" SIZE="25" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input; ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie1;?>" >
      
       <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
       <?php } ?>	
          	
          	</td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie1' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
 
 
 <tr>
  <td  onclick="fill_input_n1_field('');" ><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 1</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam1" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam1;?>"><br>
 </tr>
 <tr>
        <td  onclick="fill_input_v1_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;' class="normal" id= 'dot2'>Vereniging 1</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-weight:bold;' >
        		   <?php echo $vereniging1;?>
        		   <input   type = "hidden" NAME="Vereniging1" value = "<?php echo $vereniging1;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging1" id ="Vereniging1a" SIZE="25" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	            style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging1;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox1a" onchange="changeFunc1a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
           	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
        	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
   
   
    <?php  if  (!isset($_GET['simpel'])){ ?>      
       <!------------------------------------------------------ speler 2  ----------------------------------->       
       <tr>
       	<td style='font-size :10pt;' >2.</td>
       	 <?php          if ($licentie_jn != 'N') { ?>
        <td  onclick="fill_input_l2_field('N.v.t.');" padding-left="20"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie</em></td>
        <td><input TYPE="TEXT" NAME="Licentie2" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie2;?>"></td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie2' value  =''/>"; 
          }
        ?>
        <td onclick="fill_input_n2_field('');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Naam</em></td>
        <td><input TYPE="TEXT" NAME="Naam2" SIZE="25" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $naam2;?>" ><br>
        	
        <?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox21" onchange="changeFunc21();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>	
        	
       	</td>
        <td onclick="fill_input_v2_field('<?php echo $_vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Vereniging</em></td>
        
        <?php  if ($wel_niet == 'J') { ?>
        	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' >
        		   <?php echo $vereniging2;?>
        		   <input type = "hidden" NAME="Vereniging2" value = "<?php echo $vereniging2;?>">
        		</td>		
        	<?php } else { ?> 
        	<td width="165" >
        	<input TYPE="TEXT" NAME="Vereniging2" SIZE="21" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $vereniging2;?>">
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding-left:0pt;' id="selectBox2" onchange="changeFunc2();">
          	    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
           	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
         	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
         	      </select>
         	      <?php } ?>
        </td>
        	<?php } ?>
        </tr>
  
  <?php } else { ?>
 
 <!--------/////////--------------------  simpel input voor speler 2 ------------------------------------////////---------->

 <?php  
 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l2_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 2</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie2" SIZE="25" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie2;?>" >

          <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
           <?php } ?>	

          	</td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie2' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
     
 <tr>
  <td width="100" onclick="fill_input_n2_field('');"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 2</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam2" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>pt; background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam2;?>"><br>
 </tr>
 
 <tr>
        <td width="85" onclick="fill_input_v2_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;' class="normal" id= 'dot2'>Vereniging 2</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-weight:bold;' >
        		   <?php echo $vereniging2;?>
        		   <input   type = "hidden" NAME="Vereniging2" value = "<?php echo $vereniging2;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging2" ID="Vereniging2a" SIZE="25" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	            style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging2;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox2a" onchange="changeFunc2a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
           	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
         	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
  
   
   <?php     
       if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' or  $soort_inschrijving == '4x4' ) and $inschrijf_methode == 'vast') { ?>
  
  
  <?php  if  (!isset($_GET['simpel'])){ ?>           	
       	 <!------------------------------------------------------ speler 3  ----------------------------------->       
       	
        <tr>
        	<td style='font-size :10pt;'>3.</td>
         <?php          if ($licentie_jn != 'N') { ?>
        <td width="50" onclick="fill_input_l3_field('N.v.t.');" padding-left="20"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie</em></td>
        <td><input TYPE="TEXT" NAME="Licentie3" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $licentie3;?>"></td>
       <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie3' value  =''/>"; 
          }
        ?>
         
        <td onclick="fill_input_n3_field('');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Naam</em></td>
        <td ><input TYPE="TEXT" NAME="Naam3" SIZE="25" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $naam3;?>" ><br>
        	
        	<?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox31" onchange="changeFunc31();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>
       </td>
        <td onclick="fill_input_v3_field('<?php echo $_vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Vereniging</em></td>
        
        <?php  if ($wel_niet == 'J') { ?>
        	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' >
        		   <?php echo $vereniging3;?>
        		   <input type = "hidden" NAME="Vereniging3" ID="Vereniging2"  value = "<?php echo $vereniging3;?>">
        		</td>		
        	<?php } else { ?> 
        	<td width="165" >
        	<input TYPE="TEXT" NAME="Vereniging3" SIZE="21" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $vereniging3;?>">
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding-left:0pt;' id="selectBox3" onchange="changeFunc3();">
          	    <option>Typ hierboven  of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
          	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
        	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
         	      </select>
         	    <?php } ?>
        </td>
        	<?php } ?>
       </tr>   

  <?php } else { ?>
 <!--------/////////--------------------  simpel input voor speler 3 ------------------------------------////////---------->
 
 <?php  
 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l3_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 3</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie3" SIZE="25" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie3;?>" >
          
            <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
           <?php } ?>	
          
          	</td>

        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie3' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
    
 <tr>
  <td width="100" onclick="fill_input_n3_field('');"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 3</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam3" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam3;?>"><br>
 </tr>
 
 
    
    <tr>
        <td width="85" onclick="fill_input_v3_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;'  class="normal" id= 'dot2'>Vereniging 3</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-weight:bold;' >
        		   <?php echo $vereniging3;?>
        		   <input   type = "hidden" NAME="Vereniging3" value = "<?php echo $vereniging3;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging3" ID="Vereniging3a"  SIZE="25" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	          style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging3;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox3a" onchange="changeFunc3a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
          	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
         	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
  
 <!--  speler3 - Ja ----> 
  
 <?php }; ?>
    
  <?php          if (($soort_inschrijving == 'sextet' or $soort_inschrijving == 'kwintet' or  $soort_inschrijving == '4x4') and $inschrijf_methode == 'vast') { ?>


  <?php  if  (!isset($_GET['simpel'])){ ?>           	
   
   	 <!------------------------------------------------------ speler 4  ----------------------------------->       
   
        <tr>
        	<td style='font-size :10pt;'>4.</td>
        	   <?php          if ($licentie_jn != 'N') { ?>
        <td  onclick="fill_input_l4_field('N.v.t.');" padding-left="20"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie</em></td>
        <td ><input TYPE="TEXT" NAME="Licentie4" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $licentie4;?>"></td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie4' value  =''/>"; 
          }
        ?>
        <td onclick="fill_input_n4_field('');"><em>Naam</em></td>
        <td ><input TYPE="TEXT" NAME="Naam4" SIZE="25" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $naam4;?>" ><br>
        	
        	<?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox41" onchange="changeFunc41();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>
      
       	</td>
        <td onclick="fill_input_v4_field('<?php echo $_vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Vereniging</em></td>
        
        <?php  if ($wel_niet == 'J') { ?>
        	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' ><?php echo $vereniging4;?>
        		   <input type = "hidden" NAME="Vereniging4" value = "<?php echo $vereniging4;?>">
        		</td>		
        	<?php } else { ?> 
        	<td width="165" >
        	<input TYPE="TEXT" NAME="Vereniging4" SIZE="21" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $vereniging4;?>">
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding-left:0pt;' id="selectBox4" onchange="changeFunc4();">
          	    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
                	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
            	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
         	      </select>
         	<?php }?>      
        </td>
        	<?php } ?>
             
       </tr>   
  
  <?php } else { ?>
 <!--------/////////--------------------  simpel input voor speler 4 ------------------------------------////////---------->
 
 <?php  
 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l4_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 4</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie4" SIZE="25" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie4;?>" >
         	
         	  <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
            <?php } ?>	
         	
          
          	</td>

        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie4' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
    
 
 <tr>
  <td width="100" onclick="fill_input_n4_field('');"><em style='font-size:<?php echo $font_size; ?>pt;'onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 4</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam4" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam4;?>"><br>
 </tr>
 
 
    <tr>
        <td width="85" onclick="fill_input_v4_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;'  class="normal" id= 'dot2'>Vereniging 4</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>;font-weight:bold;' >
        		   <?php echo $vereniging4;?>
        		   <input   type = "hidden" NAME="Vereniging4" value = "<?php echo $vereniging4;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging4" ID="Vereniging4a"  SIZE="25" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	       style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging4;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox4a" onchange="changeFunc4a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
                	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
            	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
  
  <?php }; ?>
     
  <?php     if (($soort_inschrijving == 'sextet' or $soort_inschrijving == 'kwintet' ) and $inschrijf_methode == 'vast') { ?>
  
   
    <?php  if  (!isset($_GET['simpel'])){ ?>         
       <!------------------------------------------------------ speler 5  ----------------------------------->       
       
       <tr>
       	<td style='font-size :10pt;'>5.</td>
         <?php          if ($licentie_jn != 'N') { ?>
        <td onclick="fill_input_l5_field('N.v.t.');"  padding-left="20"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie</em></td>
        <td><input TYPE="TEXT" NAME="Licentie5" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $licentie5;?>"></td>
       <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie5' value  =''/>"; 
          }
        ?>
        <td onclick="fill_input_n5_field('');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Naam</em></td>
        <td ><input TYPE="TEXT" NAME="Naam5" SIZE="25" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" value = "<?php echo $naam5;?>" ><br>
        	
        	<?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox51" onchange="changeFunc51();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>
      
      	</td>
        <td onclick="fill_input_v5_field('<?php echo $_vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Vereniging</em></td>
        
        <?php  if ($wel_niet == 'J') { ?>
        	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' >
        		   <?php echo $vereniging5;?>
        		   <input type = "hidden" NAME="Vereniging5" value = "<?php echo $vereniging5;?>">
        		</td>		
        	<?php } else { ?> 
        	<td width="165" >
        	<input TYPE="TEXT" NAME="Vereniging5" SIZE="21" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $vereniging5;?>">
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding-left:0pt;' id="selectBox5" onchange="changeFunc5();">
          	    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
              	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
           	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
         	      </select>
         	    <?php } ?>
        </td>
        	<?php } ?>
      </tr>   
  
  <?php } else { ?>
 <!--------/////////--------------------  simpel input voor speler 5 ------------------------------------////////---------->
 
 <?php  
 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l5_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 5</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie5" SIZE="25" class="simple" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie5;?>" >
           
           
             <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
            <?php } ?>	
       	
          	
          	</td>

        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie5' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
    
 <tr>
  <td width="100" onclick="fill_input_n5_field('');"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 5</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam5" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>ptbackground-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam5;?>"><br>
 </tr>
 
 
    
    <tr>
        <td width="85" onclick="fill_input_v5_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;'  class="normal" id= 'dot2'>Vereniging 5</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-weight:bold;' >
        		   <?php echo $vereniging5;?>
        		   <input   type = "hidden" NAME="Vereniging5" value = "<?php echo $vereniging5;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging5" SIZE="25" ID="Vereniging5a"  class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	                style='font-size:<?php echo $font_size; ?>ptbackground-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging5;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox5a" onchange="changeFunc5a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
             	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
            	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
        <?php }; ?>
     
  <?php     if ($soort_inschrijving == 'sextet') { ?>   
  
    
  <?php  if  (!isset($_GET['simpel'])){ ?>          
         <!------------------------------------------------------ speler 6  ----------------------------------->       
         
       <tr>
       	<td style='font-size :10pt;'>6.</td>
         <?php          if ($licentie_jn != 'N') { ?>
        <td onclick="fill_input_l6_field('N.v.t.');"  padding-left="20"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot1'>Licentie</em></td>
        <td><input TYPE="TEXT" NAME="Licentie6" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie6;?>"></td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie6' value  =''/>"; 
          }
        ?>
        <td onclick="fill_input_n6_field('');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Naam</em></td>
        <td ><input TYPE="TEXT" NAME="Naam6" SIZE="25" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam6;?>" ><br>
        	
        	<?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox61" onchange="changeFunc61();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>
      
      </td>
        <td onclick="fill_input_v6_field('<?php echo $_vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" id= 'dot2'>Vereniging</em></td>
        
        <?php  if ($wel_niet == 'J') { ?>
        	<td width="165" Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' >
        		   <?php echo $vereniging6;?>
        		   <input type = "hidden" NAME="Vereniging6" value = "<?php echo $vereniging6;?>">
        		</td>		
        	<?php } else { ?> 
        	<td width="165" >
        	<input TYPE="TEXT" NAME="Vereniging6" SIZE="21" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"   value = "<?php echo $vereniging6;?>">
        	
        	<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<select style='font-size:9pt;padding-left:0pt;' id="selectBox6" onchange="changeFunc6();">
          	    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
              	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
           	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
         	      </select>
         	    <?php } ?>
        </td>
        	<?php } ?>
       </tr>   
  
<?php } else { ?>
 <!--------/////////--------------------  simpel input voor speler 6 ------------------------------------////////---------->
 
 <?php  
 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l5_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie nr 6</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie6" SIZE="25" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie6;?>" >
          
          
          <?php if ($bestemd_voor ==''){ ?>
          	<span class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		      <INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'>
    		   </span>
       <?php } ?>	  
          
          	</td>

        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie6' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
    
 <tr>
  <td width="100" onclick="fill_input_n6_field('');"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Speler 6</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam6" SIZE="25" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam6;?>"><br>
 </tr>
 
 
    <tr>
        <td width="85" onclick="fill_input_v6_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;'  class="normal" id= 'dot2'>Vereniging 6</em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-weight:bold;' >
        		   <?php echo $vereniging6;?>
        		   <input   type = "hidden" NAME="Vereniging6" value = "<?php echo $vereniging6;?>">
     			</td>		
        	
        	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging6" ID="Vereniging6a"  SIZE="25" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	        style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging6;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox6a" onchange="changeFunc6a();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
                	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
            	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?>
      
          
      <?php }; ?>
   <tr><td colspan = 7 style = 'font-size:10pt;font-style:italic' onclick="show_hulp()">* Speler 1 is de captain en contactpersoon. Klik hier voor invul hulp. </td>
   	  </tr>      
      </table>
      
     
   </fieldset>
  
  <!--- einde kontrole spelvorm single ------>
        
  <?php };?>
           
 	<?php if ($soort_inschrijving != 'single'){ ?>
        <table border = 0 width=80%> 
      
  <!-----  /// begin single inschrijving   -------------->
   <?php }
       
     if ($soort_inschrijving == 'single' or $inschrijf_methode == 'single'){ ?>
 	
 	      
  <?php  if  (!isset($_GET['simpel'])){ ?>    
   
       <div Style= 'font-weight:bold;color:<?php echo $invulkop;?>;font-size:20pt'>Invoer gegevens	</div>
       <table border=0> 
        <?php          if ($licentie_jn != 'N') { ?>
      	 <tr>
        <td width="190" padding-left="20" ><em>Licentie</em></td>
        <td  ><input TYPE="TEXT" NAME="Licentie1" SIZE="4" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"   style='vertical-align:top;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie1;?>">
         <span  class='tooltip'  title='Zoek op ingevuld licentienr. Naam en vereniging mogen dan niet zijn ingevuld'><a href ="javascript:document.myForm.submit();"> 
         	<img src='../ontip/images/icon_loep.png' alt='' width=20 border = 0></a>
         	</span></td>
        </tr>
       <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie1' value  =''/>"; 
          }
        ?>
       <tr>
        <td width="190" onclick="fill_input_n1_field('');"><em>Naam (1 persoon)</em></td>
               	
        <td colspan =2><input TYPE="TEXT" NAME="Naam1" SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam1;?>"><br>
        	
       	<?php  if ($user_select =='Yes'){ 
        	
        	/// Verwerk bestand met spelers            
          $myFile = 'csv/licensies_vereniging.csv' ;    
                                  
          $fh       = fopen($myFile, 'r');  
          $line     = fgets($fh);                  /// skip kopregel1
          $line     = fgets($fh);                  /// skip kopregel2
          $line     = fgets($fh);                  
          ?> 
 
          <select style='font-size:9pt;' id="selectBox11" onchange="changeFunc11();">
          <option>Typ hierboven of kies uit lijst..</option>

          <?php
          while ( $line <> ''){      

           $parts    = explode(";", $line);
           $nr       = $parts[0]  ;  
           $licentie = $parts[1]   ; 
           $naam     = $parts[2]    ;
           $soort    = $parts[3]  ;

           echo "<OPTION   value='".$licentie.",".$naam.",".$vereniging."'>".$naam. "  (".$licentie."-".$soort.")</OPTION>";	
           $line     = fgets($fh);

          } // end while
       echo "</SELECT>";
       
      } // end user select
      ?>	
        	
        	</td>
      </tr>
       <tr>
        <td width="190" onclick="fill_input_v1_field('<?php echo $vereniging;?>');"><em onmouseover="toggle(this,1)" onmouseout="toggle(this,0)">Vereniging</em></td>
          
          <?php
          $_vereniging = $vereniging;
          if ($vereniging_output_naam !=''){
         	  $_vereniging = $vereniging_output_naam;
          	}
       	?>
          
        	 <?php  if ($wel_niet == 'J') { ?>
        	<td colspan 2 Style= 'background-color:<?php echo $achtergrond_kleur; ?>; font-size:18px;font-weight:bold;' ><?php echo $_vereniging;?>
        		   <input type = "hidden" NAME="Vereniging1" value = "<?php echo $vereniging1;?>">
        	<?php } else { ?> 
        	<td colspan =2 >
        		
        		
        	<input TYPE="TEXT" NAME="Vereniging1" SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  style='padding-right:0pt;'  value = "<?php echo $vereniging1;?>">
        	
        		<?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
             <select style='font-size:9pt;padding-left:0pt;' id="selectBox1" onchange="changeFunc1();">
                  	<option>Typ de vereniging of kies uit lijst..</option>
                   	  <?php foreach($ver_namen as $ver_naam){
                   	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
            	          	echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
                     } 
             	?> 
         	 </select>
        	<?php
        	  }
        	 }
        	  ?>
        	
        	 <?php if ($bestemd_voor ==''){ ?>
   	   	    	<br><em><span onmouseover="toggle(document.getElementById('dot2'),1)" onmouseout="toggle(document.getElementById('dot2'),0)" >
   	    		Bij klikken op het woord 'Vereniging' wordt <?php echo $vereniging;?> ingevuld.
   	    	</span>
   	    	
   	<?php } ?>
        </td>
      
   
   
   <?php } else { ?>
 
 <!--------/////////--------------------  simpel input voor speler 1 (melee)------------------------------------////////---------->
 
 <?php  
  if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
     if ($licentie_jn != 'N') { ?>
      <tr> 
          <td width="80" onclick="fill_input_l1_field('N.v.t.');" padding-left="20"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  class="normal" id= 'dot1'>Licentie 1</em></td>
          <td width="85"><input TYPE="TEXT" NAME="Licentie1" SIZE="4" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $licentie1;?>" >
          <span onmouseover="toggle(this,1)" onmouseout="toggle(this,0)"  class='tooltip'  title='Zoek op ingevuld licentie nr. Naam en vereniging mogen dan niet zijn ingevuld'>
    		<INPUT TYPE="image" SRC="../ontip/images/icon_loep.png" alt="." width=22 border = 0   id= 'loep'></span>
          	</td>
        <?php }
         else { 
          // ivm user selectie als er geen licentie bekend is
          echo "<input type= 'hidden' name = 'Licentie1' value  =''/>"; 
         
        ?>
     </tr>  
    <?php } ?>
    
 <tr>
  <td width="100" onclick="fill_input_n1_field('');"><em style='font-size:<?php echo $font_size; ?>pt;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" class="normal" id= 'dot2'>Naam (1 persoon)</em></td>
        <td width="220"><input TYPE="TEXT" NAME="Naam1" SIZE="35" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  value = "<?php echo $naam1;?>"></td>
 </tr>
 
   <?php
          $_vereniging = $vereniging;
          if ($vereniging_output_naam !=''){
          	  $_vereniging = $vereniging_output_naam;
          	}
       	?>
       	
       	
     <tr>
        <td width="85" onclick="fill_input_v1_field('<?php echo $_vereniging;?>');"><em style='font-size:<?php echo $font_size; ?>pt;' class="normal" id= 'dot2'>Vereniging </em></td>
   
      	<?php  if ($wel_niet == 'J') { ?>
         	<td width="165" Style= 'font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur; ?>; font-size:12px;font-weight:bold;' >
        		   <?php echo $_vereniging;?>
        		   <input   type = "hidden" NAME="Vereniging1" value = "<?php echo $vereniging1;?>">
     			</td>		
        	
     	<?php } else { ?> 
        	<td width="185" >
    	   <input TYPE="TEXT" NAME="Vereniging1" SIZE="21" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
    	            style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value = "<?php echo $vereniging1;?>">
           
        <?php if ($vereniging_selectie_zichtbaar_jn =='J'){ ?>
        	<br><tr><td></td><td><select style='font-size:9pt;padding:0pt;' id="selectBox1" onchange="changeFunc1();">
        		    <option>Typ hierboven of kies uit lijst..</option>
         	      <?php foreach($ver_namen as $ver_naam){
            	  	$ver_naam = str_replace("'" ,'`', $ver_naam);
         	  	   echo "<option value ='".$ver_naam."'>".$ver_naam."</option>";  
         	      } ?> 
          </select>
          <?php } ?>
          
        </td>
     	<?php } ?>
   </tr>  
  <?php } ?> 
   
  <?php }; ?>  
       
   
  <?php  if  (isset($_GET['simpel'])){ ?>    
    </fieldset>
  </blockquote>
  <?php } ?>  
   




 <!--------------------------------- vanaf hier voor alle soorten inschrijvingen-------------->
   
     
  <?php if (isset($sms_telefoon) and $sms_telefoon !='' and $sms_telefoon !='undefined'){ 
  	      	$telefoon = $sms_telefoon;  
  	      	
  	      }     
  	      else {
  	      	$telefoon ='';
  	      }
  	    
  	    $telefoon ='';
  	    $email ='';    
              ?>
       
       
       
     <?php  if  (!isset($_GET['simpel'])){ ?>  
        
       <tr>
        <td ><em>Telefoon</em></td>
        <td colspan = 2 ><input TYPE="TEXT" NAME="Telefoon" SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' value ='' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  onclick="make_blank_telefoon();">
        	<?php 
        	if ($sms_bevestigen_zichtbaar_jn == 'J'){ ?>
        	<br><input type="checkbox" name="sms_confirmation" value="J"><em><span onclick="show_alert2()" style= 'font-size:9pt;color:<?php echo $link; ?>;text-align:right;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Klik het vakje hiernaast aan voor bevestiging via SMS</span></em> 
       <?php }; ?>  
        	 </td>
      </tr>
             
      <tr>
        <td width="190"><em>E-mail deelnemer</em></td>
        <td colspan = 2><input TYPE="Email" NAME="Email" SIZE="35" class="pink"  style='background-color:<?php echo $achtergrond_kleur_input ?>;'  value='' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  onclick="make_blank_email();"><br><em><span style='font-size:9pt;' > (voor bevestiging inschrijving)</em></span></td>
      </tr>
      
      <?php if ($bankrekening_invullen_jn == 'J'  and $uitgestelde_bevestiging_jn == 'J'){ ?>
        <tr>
         <td width="190"><em>Bankrekening</em></td>
         <td><input TYPE="TEXT" NAME="Bankrekening" SIZE="20" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" > (verplicht) </td>
       </tr>
        <?php      }?>
      	
      
      <?php if(isset($extra_vraag)){
      
      	/// Extra vraag
      	  $opties = explode(";",$extra_vraag,6);
      	  $vraag  = $opties[0];
      	  ?>
      	 <tr>	
      	  <input type='hidden' NAME='Vraag' VALUE='<?php echo $vraag;?>'>
      	  
      	  	   <td width="190"><em><?php echo $vraag;?></em></td>
             
             <?php
             $i=1;
             while(isset($opties[$i]))  {
             	?>
             	<td>
             	<?php 
             	if (substr($opties[$i],-1) == "*") { ?>
             	<input type='radio' name='Extra' value ='<?php echo $opties[$i];?>' checked>
             	<?php } else { ?>
             	<input type='radio' name='Extra' value ='<?php echo $opties[$i];?>'>
             	<?php } ?>
             	
             		<?php echo $opties[$i];?></td></tr><tr><td width="190"></td>
             	<?php $i++;}?>
             	<?php if ($i>1){?>
                <tr><td></td><td>(Maak een keuze, * = standaard keuze)</td></tr>
                         
        <?php 
            } // end if > 1  
        }/// end if extra
         ?> 
  
  <!----  selectie lijst bij meerdaags toernooi   19 dec 2017--------------->
  
  
 <?php
   // meerdaags van tot
      
   if ($meerdaags_toernooi_jn =='J'){
  	
  	 	 $variabele      = 'eind_datum';
       $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result         = mysqli_fetch_array( $qry1);
       $eind_datum     = $result['Waarde'];
       $toernooi_datum = $datum;
    	
  	?>
  	<tr>	    <td width="190"  style='vertical-align:top;'><em>Ik speel mee op<br>(Aanvinken wat van toepassing is)</em></td>
  		<td>
      <?php
  	   while ($toernooi_datum <=  $eind_datum){
  	 		         $_datum = $toernooi_datum; 
         		     
         		     $dag   = 	substr ($_datum , 8,2);                                                                 
                 $maand = 	substr ($_datum , 5,2);                                                                 
                 $jaar  = 	substr ($_datum , 0,4);                                                                 
	
         		     ?>
         		     <input type='checkbox' name='meerdaags_datum[]' value ='<?php echo $_datum;?>'  checked><em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?></em><br>
         		     <?php
  	             $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	             $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while
     ?>
       </td>
     </tr>
  <?php	
       } // end if j
  
      // toernooi cyclus
       if ($meerdaags_toernooi_jn =='X'){
         
         $datums ='';
         $today =  date('Y-m-d');
         ?>
          <tr>	
            <td width="190" style='vertical-align:top;'><em>Ik speel mee op<br>(Aanvinken wat van toepassing is)</em></td><td>
         <?php
         $sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum >= '".$today."'  order by Datum" )     ; 
         	
         	while($row = mysqli_fetch_array( $sql )) { 		
         		     $_datum = $row['Datum']; 
         		     $aantal_cyclus = $row['Aantal_splrs'];
         		      
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);   
                          
                 $locatie = $row['Locatie'];   
                 if ($locatie !=''){
                 	$locatie = ".    [".$locatie."]";                                                       
	               }
	               
         		               
	               // als max bereikt is geen input mogelijk

            		if ($aantal_cyclus  >= ( $max_splrs + $aantal_reserves )  ){  ?>
            		      X <em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?>   (vol) </em><br>
                <?php } else {?>
          		     <input type='checkbox' name='meerdaags_datum[]' value ='<?php echo $_datum;?>'  checked><em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?> [al <?php echo $aantal_cyclus;?> ingeschreven]</em><br>
         		     <?php
                }
                
         		    }// while	  	
         	?>	    
         		    </tr>
   		    <?php
      }// end toernooi cyclus (x)
?>

  <?php if(isset($extra_invulveld) and $extra_invulveld !='' ){
      	  ?>
      	 <tr>	
      	 	   <td width="190"><em><?php echo $extra_invulveld;?></em></td>
          <?php 
         	/// Extra invulveld. De waarde wordt omgezet naar een variabele, waarbij spaties worden vervangen door '_' Werkt niet ivm veld in tabel
                	  ?>
         	 <td>
               	<input type='text' name='Extra_invulveld_antwoord' SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');">
           </td></tr>
       <?php                         
        }/// end if extra veld
   ?> 
  
    <?php if(isset($voucher_code_invoeren_jn) and $voucher_code_invoeren_jn =='J' and $voucher_code_richting =='In' ){
      	  ?>
      	 <tr>	
      	 	   <td onclick="show_alert_voucher()" width="190"><em>Voucher code(<span style= 'font-size:9pt;color:<?php echo $link; ?>;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Uitleg</span>)</em></td>
                	 
         	 <td>
               	<input type='text' name='Voucher_code' SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');">
           </td></tr>
       <?php                         
        }/// end if voucher
   ?> 
 
  
  
  <tr>
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $length = 4; 
	  $string = '';
	  
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters[] ='';
    $characters = "123456789123456789";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
       
?>
	 <td width="190" onclick="show_alert()" ><br><em>Anti Spam (<span style= 'font-size:9pt;color:<?php echo $link; ?>;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Uitleg</span>)</em></td>
        <td colspan = 2><input TYPE="text" NAME="respons" id= 'respons' SIZE="32" class="pink" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  style='background-color:<?php echo $achtergrond_kleur_input ?>;font-size:9pt;' Value='Typ hier de aangegeven cijfercode' onclick="make_blank_spam();" >
        	
   <span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc7(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
   <?php
  
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>
      <tr><br>
       <td>
      <em><label>Opmerkingen</label></em></td>
            <td colspan = 2><label><textarea name='Opmerkingen' onfocus="change(this,'black','lightblue');" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" rows='4' cols='45' onclick="make_blank();">Typ hier evt opmerkingen.
                </textarea></label>
  </td>
</tr>


<!-------////            simpel input -------------------------------------/////--> 


<?php } else { 
	
	
	 if ($mobile == 'on'){ 
    	$font_size = 14;
    } else { 
	  $font_size = 10;
   } 
   
  ?> 
	<tr>
        <td ><em style='font-size:<?php echo $font_size; ?>pt;'>Telefoon</em></td>
        <td colspan = 2 ><input TYPE="TEXT" NAME="Telefoon" SIZE="35" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' value='' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  onclick="make_blank_telefoon();">
        	<?php 
        	if ($sms_bevestigen_zichtbaar_jn == 'J'){ ?>
        	<br><input type="checkbox" name="sms_confirmation" value="J"><em><span onclick="show_alert2()" style= 'font-size:9pt;color:<?php echo $link; ?>;text-align:right;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Klik het vakje hiernaast aan voor bevestiging via SMS</span></em> 
       <?php }; ?>  
        	 </td>
      </tr>
             
      <tr>
        <td width="190"><em style='font-size:<?php echo $font_size; ?>pt;'>E-mail deelnemer</em></td>
        <td colspan = 2><input TYPE="Email" NAME="Email" SIZE="35" class="simple"  style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;'  value='' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  onclick="make_blank_email();"><br><em><span style='font-size:9pt;' > (voor bevestiging inschrijving)</em></span></td>
      </tr>
      
      <?php if ($bankrekening_invullen_jn == 'J'  and $uitgestelde_bevestiging_jn == 'J'){ ?>
        <tr>
         <td width="190"><em style='font-size:<?php echo $font_size; ?>pt;'>Bankrekening</em></td>
         <td><input TYPE="TEXT" NAME="Bankrekening" SIZE="20" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" > (verplicht) </td>
       </tr>
        <?php      }?>
      	
      
      <?php if(isset($extra_vraag)){
      
      	/// Extra vraag
      	  $opties = explode(";",$extra_vraag,6);
      	  $vraag  = $opties[0];
      	  ?>
      	 <tr>	
      	  <input type='hidden' NAME='Vraag' VALUE='<?php echo $vraag;?>'>
      	  
      	  	   <td width="190"><em style='font-size:<?php echo $font_size; ?>pt;'><?php echo $vraag;?></em></td>
             
             <?php
             $i=1;
             while(isset($opties[$i]))  {
             	?>
             	<td style='font-size:<?php echo $font_size; ?>pt;'>
             	<?php 
             	if (substr($opties[$i],-1) == "*") { ?>
             	<input style='font-size:<?php echo $font_size; ?>pt;' type='radio' name='Extra' value ='<?php echo $opties[$i];?>' checked>
             	<?php } else { ?>
             	<input style='font-size:<?php echo $font_size; ?>pt;' type='radio' name='Extra' value ='<?php echo $opties[$i];?>'>
             	<?php } ?>
             	
             		<?php echo $opties[$i];?></td></tr><tr><td width="190"></td>
             	<?php $i++;}?>
             	<?php if ($i>1){?>
                <tr><td></td><td style='font-size:<?php echo $font_size; ?>pt;'>(Maak een keuze, * = standaard keuze)</td></tr>
                         
        <?php 
            } // end if > 1  
        }/// end if extra
         ?> 
  
  <?php if(isset($extra_invulveld) and $extra_invulveld !='' ){
      	  ?>
      	 <tr>	
      	 	   <td width="190"><em style='font-size:<?php echo $font_size; ?>pt;'><?php echo $extra_invulveld;?></em></td>
          <?php 
         	/// Extra invulveld. De waarde wordt omgezet naar een variabele, waarbij spaties worden vervangen door '_' Werkt niet ivm veld in tabel
                	  ?>
         	 <td>
               	<input type='text' name='Extra_invulveld_antwoord' SIZE="35" class="simple" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');">
           </td></tr>
       <?php                         
        }/// end if extra veld
 ?>       
       <!----  selectie lijst bij meerdaags toernooi   19 dec 2017--------------->
  
  
 <?php
  $meerdaagse_toernooi_selectie_jn ='J';
  
  if ($meerdaagse_toernooi_selectie_jn =='J'){
  	
      // meerdaags van tot
      
     if ($meerdaags_toernooi_jn =='J'){
  	
  	 	 $variabele = 'eind_datum';
       $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result    = mysqli_fetch_array( $qry1);
       $eind_datum  = $result['Waarde'];
       $toernooi_datum = $datum;
    	
  	?>
  	<tr>	    <td width="190"  style='vertical-align:top;'><em>Ik speel mee op<br>(Aanvinken wat van toepassing is)</em></td><td>
            	<?php
  	   while($toernooi_datum <=  $eind_datum){
  	 		     $_datum = $toernooi_datum; 
         		     
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);                                                                 
	
         		     ?>
         		     <input type='checkbox' name='meerdaags_datum[]' value ='<?php echo $_datum;?>'  checked><em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?></em><br>
         		     <?php
  	             $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	             $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while
  	
       } // end if j
  
      // toernooi cyclus
       if ($meerdaags_toernooi_jn =='X'){
         
         $datums ='';
         $today =  date('Y-m-d');
         ?>
          <tr>	
            <td width="190" style='vertical-align:top;'><em>Ik speel mee op<br>(Aanvinken wat van toepassing is)</em></td><td>
         <?php
         $sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum >= '".$today."'  order by Datum" )     ; 
         	
         	while($row = mysqli_fetch_array( $sql )) { 		
         		     $_datum = $row['Datum']; 
         		     
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);                                                                 
	
         		     ?>
         		     <input type='checkbox' name='meerdaags_datum[]' value ='<?php echo $_datum;?>'   checked><em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?></em><br>
         		     <?php
         		    }// while	  	
         	
           }// end toernooi cyclus (x)
            
           
           
         }// end if meerdaags
?>
      
      <?php if(isset($voucher_code_invoeren_jn) and $voucher_code_invoeren_jn =='J' ){
      	  ?>
      	 <tr>	
      	 	   <td onclick="show_alert_voucher()" width="190"><em>Voucher code(<span style= 'font-size:9pt;color:<?php echo $link; ?>;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Uitleg</span>)</em></td>
                	 
         	 <td>
               	<input type='text' name='Voucher_code' SIZE="35" class="pink" style='background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');">
           </td></tr>
       <?php                         
        }/// end if voucher
   ?> 
  <tr>
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	
	  $length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "123456789123456789";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
       
?>
	 <td width="190" onclick="show_alert()" ><br><em  style='font-size:<?php echo $font_size; ?>pt;'>Anti Spam (<span style= 'font-size:9pt;color:<?php echo $link; ?>;' onmouseover="toggle(this,1)" onmouseout="toggle(this,0)" class="normal" >Uitleg</span>)</em></td>
        <td colspan = 2><input TYPE="text" NAME="respons" id= 'respons' SIZE="28" class="simple" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');"  
        	 style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' Value='Typ hier de aangegeven cijfercode' onclick="make_blank_spam();" >
         <span style='font-size:<?php echo $font_size; ?>pt;color:black;background-color:lightgrey;width:100pt;height:font-size:<?php echo $font_size; ?>pt;text-align:right;font-family:courier;padding:3pt;'  id ='challenge' onclick="changeFunc7(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
   <?php
  
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>
      <tr><br>
       <td>
       	
      <em style='font-size:<?php echo $font_size; ?>pt;'><label>Opmerkingen</label></em></td>
      	
      	<?php
      	if ($mobile == 'on'){ 
         	$font_size = 11;
           } else { 
	       $font_size = 10;
          } 
      	?>
      	
            <td  colspan = 2><label><textarea name='Opmerkingen' onfocus="change(this,'black','lightblue');" style='font-size:<?php echo $font_size; ?>pt;background-color:<?php echo $achtergrond_kleur_input ?>;' onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','<?php echo $achtergrond_kleur_input ?>');" rows='3' cols='35' onclick="make_blank();">Typ hier evt opmerkingen.
                </textarea></label>
  </td>
</tr>

	<?php } ?>




</table>
    </td>
    <?php
    //////////////////////////////////////////////////  afbeelding rechts (default)
    	if ($plaats_afb =='#r' and $url_afbeelding !='#r'   and (!isset($_GET['simpel']))   ) {
    		?>
        <td align='right'><?php if($url_afbeelding !=''){?>
    		  <img src ='<?php echo $url_afbeelding ?>' <?php echo $afb_string; ?> /> 
        	<br>
        	<?php } 
          ////// speel locatie         	
        	if (isset($adres) and $adres !='') {
            echo "<div style='text-align:left;font-weight:bold;color:".$tekstkleur.";'>";       	
        		$naw = explode(";",$adres,6);
        		
        		$i=0;
             while(isset($naw[$i]))  {
                 	echo $naw[$i]."<br>";
                 	$i++;
            }
             	
          }
             	?> 
             	</td>
        <?php } ?>     	
  </tr>
 </table>
  
<?php
	
	 if ($mobile == 'on'){ 
    	$font_size = 6;
    } else { 
	  $font_size = 9;
   } 
?>   
</center>

 <div style = 'text-align:left;font-size:<?php echo $font_size; ?>pt;color: <?php echo($tekstkleur); ?>;'>
     <input type='checkbox' name = 'privacy'><b>Privacy verklaring</b>.<br>Door dit vakje aan te vinken ga ik akkoord met de verwerking van evt persoonlijke gegevens . <span style='font-weight:bold;text-decoration:underline;' onclick="show_privacy()" >Klik hier voor de beschrijving.</span>
 </div>
  
   <center>  
     <div style = 'font-size:<?php echo $font_size; ?>pt;color: <?php echo($tekstkleur); ?>;text-align:center;'>Einde inschrijving op 
        	  	<?php	echo strftime("%A %e %B %Y om %H:%M", mktime($eind_inschrijving_uur, $eind_inschrijving_minuut, 0, $eind_inschrijving_maand , $eind_inschrijving_dag, $eind_inschrijving_jaar) ); ?> of bij meer dan <?php echo $max_splrs; ?> inschrijvingen.<br>
    
           	  	
        	  	<?php if ($boulemaatje_gezocht_zichtbaar_jn == 'J' and $soort_inschrijving !='single'){ ?>
  	  	        	  	Wil je meedoen met dit toernooi, maar heb je geen boule maatje ? Of wil je je opgeven als reserve speler ? Klik <a href='boulemaatje_gezocht_stap1.php?toernooi=<?php echo $toernooi;?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_blank'>hier</a> voor "Boulemaatje gezocht".</br>
        	  	<?php } ?>
    </div>
    
   
    
    
</fieldset>    
  
 	 <center>
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
        </td>
      </tr>
      <tr>
        <td ALIGN="center"><input TYPE="submit" VALUE="Verzenden!" ACCESSKEY="v" style= 'color:<?php echo $tekstkleur_verzenden;?>;background-color:<?php echo $achtergrond_kleur_verzenden;?>;' >&nbsp;&nbsp;
        <input TYPE="reset" VALUE="Herstellen" ACCESSKEY="h" style= 'color:<?php echo $tekstkleur_herstellen;?>;background-color:<?php echo $achtergrond_kleur_herstellen;?>;' ></td>
              </tr>
    </table>
  </center>
   
 </div> 
</FORM>
<?php
/// end if verlopen inschrijf termijn
}
?>
<?php if ($einde == 0) { ?>
<?php if($soort_inschrijving !='single'){ $woord = 'teams';} else {$woord ='personen';}?>

<?php
if ($ideal_betaling_jn =='J'){ ?>
	<em style='font-size:<?php echo $font_size; ?>pt;color:<?php echo($tekstkleur); ?>;'>De inschrijving voor dit toernoooi kunt u betalen via IDEAL <img src = 'http://www.ontip.nl/ontip/images/ideal.bmp' width='35'></em><br>
<?php }  ?>	

<em style='font-size:<?php echo $font_size; ?>pt;color:<?php echo($tekstkleur); ?>;'> Indien ingevuld, krijgt u via uw e-mail een bevestiging van de inschrijving. Er is plek voor <?php echo $max_splrs. "  ". $woord ?>.<br>We kijken naar de volgorde van inschrijving. 
Wilt u weten met wie u uw krachten gaat meten ?<br>Klik dan <a STYLE ='font-size: <?php echo $font_size; ?>pt; color:<?php echo $link; ?>;'  href='lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi;?>'>hier</a> voor de lijst van deelnemers.
Klik <a STYLE ='font-size: <?php echo $font_size; ?>pt; color:<?php echo $link; ?>;' href= "outlook_event.php?toernooi=<?php echo $toernooi;?>">hier</a> om het toernooi toe te voegen aan uw Outlook Agenda.<br>
</font></em>
<br>
<?php }
else { 
	?>
</center></b>
	<span STYLE ='font-size: <?php echo $font_size; ?>pt; color:<?php echo $tekstkleur; ?>;text-align:left;'>
		Klik  <a href='lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi;?>'>hier</a> voor de lijst van deelnemers.	<br>
	</span>
	
	
	
	<?php
	echo "</fieldset>";
}?>

<?php
//// aanpassing 6 feb 2015
if ($website_link_zichtbaar_jn == 'J' and  $mobile != 'on' and !isset($_GET['simpel']) ) { ?>
    <center>
	          <span STYLE ='font-size: <?php echo $font_size; ?>pt; color:<?php echo $tekstkleur; ?>;'>
    <a href= '<?php echo $url_website ?>' target="_top">Klik hier om naar de site te gaan </a><br></span>
   </center>
<?php } ?>


<table width=98% border =0>
<tr><td style='font-size:9pt;color:<?php echo($tekstkleur); ?>'>
<?php 
echo "<b>Formulier gemaakt met OnTip</b><br>Versie :</b> ". date("d-m-y g:i:sa", filemtime('Inschrijfform.php'))."<br>(c) Erik Hendrikx, Bunschoten ".date('Y').".<br><a href='http://www.ontip.nl/ontip/pdf/Flyer_OnTip.pdf' target='_blank'>Wat is OnTip ?</a>";
?>
</td>

<!-------------------------------- klok in beeld ------------------------------>
<?php if (isset($klok_zichtbaar_jn) and $klok_zichtbaar_jn == 'J'){ ?>
<td align=right>

<table cellpadding="5">
	<td bgcolor="black">
<img src="../ontip/images/dg8.gif" name="hr1" width="12">
<img src="../ontip/images/dg8.gif" name="hr2" width=12>
<img src="../ontip/images/dgc.gif" width=7>
<img src="../ontip/images/dg8.gif" name="mn1" width=12>
<img src="../ontip/images/dg8.gif" name="mn2" width=12>
<img src="../ontip/images/dgc.gif" width=7>
<img src="../ontip/images/dg8.gif" name="se1" width=12>
<img src="../ontip/images/dg8.gif" name="se2"width=12>
<img src="../ontip/images/dgpm.gif" name="ampm"></td></table>
</td></table>

<script type="text/javascript">

dg0 =new Image();dg0.src="../ontip/images/dg0.gif";
dg1 =new Image();dg1.src="../ontip/images/dg1.gif";
dg2 =new Image();dg2.src="../ontip/images/dg2.gif";
dg3 =new Image();dg3.src="../ontip/images/dg3.gif";
dg4 =new Image();dg4.src="../ontip/images/dg4.gif";
dg5 =new Image();dg5.src="../ontip/images/dg5.gif";
dg6 =new Image();dg6.src="../ontip/images/dg6.gif";
dg7 =new Image();dg7.src="../ontip/images/dg7.gif";
dg8 =new Image();dg8.src="../ontip/images/dg8.gif";
dg9 =new Image();dg9.src="../ontip/images/dg9.gif";
dgam=new Image();dgam.src="../ontip/images/dgam.gif";
dgpm=new Image();dgpm.src="../ontip/images/dgpm.gif";

function dotime(){ 
theTime=setTimeout('dotime()',1000);
d = new Date();
hr= d.getHours()+100;
mn= d.getMinutes()+100;
se= d.getSeconds()+100;
if(hr==100){hr=112;am_pm='am';}
else if(hr<112){am_pm='am';}
else if(hr==112){am_pm='pm';}
else if(hr>112){am_pm='pm';hr=(hr-12);}
tot=''+hr+mn+se;
document.hr1.src = '../ontip/images/dg'+tot.substring(1,2)+'.gif';
document.hr2.src = '../ontip/images/dg'+tot.substring(2,3)+'.gif';
document.mn1.src = '../ontip/images/dg'+tot.substring(4,5)+'.gif';
document.mn2.src = '../ontip/images/dg'+tot.substring(5,6)+'.gif';
document.se1.src = '../ontip/images/dg'+tot.substring(7,8)+'.gif';
document.se2.src = '../ontip/images/dg'+tot.substring(8,9)+'.gif';
document.ampm.src= '../ontip/images/dg'+am_pm+'.gif';
}
dotime();

</script>
<?php }?>
</body>
</html>
