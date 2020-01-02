<?php
////  Beheer_onTip voorheen  Beheer_config.php (c) Erik Hendrikx 2012 ev
////
////  Programma om de configuratie items van een OnTip toernooi te kunnen aanpassen. Deze gegevens zijn per vereniging, per toernooi opgeslagen in de tabel config.
////  Een configuratie item heeft een naam en een waarde.  M.b.v deze waarden wordt het inschrijf formulier (Inschrijfform.php) gevuld.
////  Beheer_ontip.php verdeelt de gegevens over 2 tabbladen. Een voor de gegevens die direct betrekking hebben op het toernooi (datum, aantal_spelers, soort_toernooi, etc) en 
////  gegevens die betrekking hebben op het formulier (kleurgebruik, plaatjes, gebruik van niet verplichte velden, etc).
////  De diverse tabs hebben ieder een eigen DIV die door klikken op de tab geopend wordt. 
////   
////  Beheer_ontip.php roept het programma muteer_ontip.php aan om de gegevens in de tabel config te muteren.
////    Dit heeft betrekking op de tabs ((div)  Toernooi en Formulier

////  Beheer_ontip.php roept het programma muteer_namen.php aan om de gegevens in de tabel vereniging te muteren. En het aanpassen van het wachtwoord in de tabel namen.
////    Dit heeft betrekking op de tab ((div)  Algemeen

////  Op het tabblad Algemeen staan een aantal algemene zaken als url_website, url_logo etc
////  Verder is er ook een tabblad Uitleg. Met uitzondering van deze laatste hebben de andere tabs eigen formulieren Toernooi = myForm1 en Formulier = myForm2.
////  
////  Beheer_ontip wordt aangeroepen met als parameter de toernooi_naam en het tab nummer :  beheer_ontip.php?toernooi=xxxxxxxxx&tab=y
////    1. Tab Toernooi
////    2. Tab Formulier
////    3. Tab Algemeen
////    4. Tab Uitleg

////  Als een formulier gesubmit wordt, wordt via de naam van het formulier bepaald op welke tab er moet worden teruggekeerd. De tab wordt dan als parameter teruggegeven. 
////  De naam van de vereniging en wat andere zaken worden gelezen uit myvereniging.txt in mysqli.php dat in beheer_condig.php wordt aangeroepen. 
////  Voor het gebruik van beheer_ontip.php is een usernaam + wachtwoord nodig + de benodigde rechten (A of C) 
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

# 25jan2019        1.0.2            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None
# Feature:          PHP7
# Reference: 

# 15juni2019        1.0.3            E. Hendrikx
# Symptom:   		None.
# Problem:       	None.
# Fix:              None
# Feature:          Recensie zichtbaar
# Reference: 

 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Muteren configuratie bestand</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:brown;font-size: 8pt;background-color:blue;color:white;font-weight:bold;}
a    {text-decoration:none;color:blue;font-size 9pt;}
textarea {overflow:hidden;};
input  {font-family:Courier New;background:#ffffcc;border: 1px #000000 solid;}
select {font-family:Courier New;background:#ffffcc;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }

.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
 
 legend {font-size: 11pt; font-family: Comic sans, sans-serif, Verdana; }
 
.important:hover {color:red; }  
 
.normal {cursor:auto              } 
.dotted {cursor:help              }     
                             
  
 .config, td.config {
  background-color: #E6E6E6;
  color: #ffffff;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  }               
                  
 td.varname {
  background-color: #bdbdbd;
  color: #000000;
  font-weight:bold;
  font-size:10pt;
  height:42px;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
   padding-left:15pt;
  }               
           
 td.content {
  background-color: #bdbdbd;
  color: #000000;
  font-weight:bold;
  font-size:10pt;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  padding-left:15pt;
  }               
                  
td.info {
  background-color: #bdbdbd;
  color: #000000;
  font-weight:bold;
  font-size:10pt;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  padding-left:15pt;
  text-align:center;
  }               
 
 td.varname_k {
  background-color: #4B610B;
  color: yellow;
  font-weight:bold;
  font-size:12pt;
  height:45px;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  padding-left:15pt;
  }               
 td.config_k {
  background-color:  #4B610B;
  color: yellow;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  }            
            
 td.content_k {
  background-color: #4B610B;
  color: yellow;
  font-weight:bold;
  font-size:12pt;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :0 px ;
  padding-left:15pt;
  }               
                  
td.info_k {
  background-color: #4B610B;
  color: yellow;
  font-weight:bold;
  font-size:10pt;
  border: 1px #000000 solid;
  border-collapse : collapse;
  border-spacing :1 px ;
  padding-left:15pt;
  text-align:center;
  }               

#tablist{
padding: 3px 0;
margin-left: 0;
margin-bottom: 0;
margin-top: 0.1em;
font: bold 12px Verdana;
}

#tablist li{
list-style: none;
display: inline;
margin: 0;
}

#tablist li a{
padding: 3px 0.5em;
margin-left: 13px;
border: 1px solid #778;
border-bottom: none;
background: white;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;
border: 1px solid;
}

#tablist li a:link, #tablist li a:visited{
color: navy;
}

#tablist li a.current{
background: lightyellow;
}


	
#tabcontentcontainer{
padding: 15px;
margin-left: 45px;
margin-right: 45px;
border: 1px solid black;
}

.tabcontent{
display:none;
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
	 top:1pt; 
}	 

</style>

<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

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

<!---// Javascript voor aanpassen achtergrondkleur en tekst kleur ----------->
<script type="text/javascript">
function change(that, fgcolor, bgcolor){
that.style.color           = fgcolor;
that.style.backgroundColor = bgcolor;
}
</Script>

<Script  type="text/javascript">
<!----// Javascript voor invullen vereniging bij bestemd voor ------------>

function initForm(oForm, element_name, init_txt)  
{  

     frmElement = oForm.elements[element_name];  
     if ( frmElement.value == "")
     	{
      frmElement.value = init_txt;  
    }
    else {
    	frmElement.value = '';  
    }
} 

function toggle(obj,on) {
	   obj.className=(on)?'dotted':'normal'; 
	   }

function changeFunc1() {
    var selectBox      = document.getElementById("selectBox1");
    var selectedValue1 = selectBox.options[selectBox.selectedIndex].value;
   
    document.getElementById('Achtergrondkleur').value= selectedValue1;
    document.getElementById('Achtergrondkleur').style.backgroundColor=selectedValue1;
    document.getElementById('selectBox1').style.backgroundColor=selectedValue1;
    document.getElementById('selectBox11').style.backgroundColor=selectedValue1;
    document.getElementById('selectBox12').style.backgroundColor=selectedValue1;
    document.getElementById('selectBox13').style.backgroundColor=selectedValue1;
    document.getElementById('Tekstkleur').style.backgroundColor=selectedValue1;
    document.getElementById('Linkkleur').style.backgroundColor=selectedValue1;
    document.getElementById('Koptekstkleur').style.backgroundColor=selectedValue1;
    document.getElementById('Tekstkleur').style.color=myarr[1];
   }

function changeFunc11() {
    var selectBox      = document.getElementById("selectBox11");
    var selectedValue1 = selectBox.options[selectBox.selectedIndex].value;
   
    document.getElementById('Achtergrondkleur').value= selectedValue1;
    document.getElementById('Achtergrondkleur').style.color=selectedValue1;
    document.getElementById('selectBox11').style.color=selectedValue1;
   }

function changeFunc12() {
    var selectBox      = document.getElementById("selectBox12");
    var selectedValue1 = selectBox.options[selectBox.selectedIndex].value;
   
    document.getElementById('selectBox12').style.color=selectedValue1;
   }

function changeFunc13() {
    var selectBox      = document.getElementById("selectBox13");
    var selectedValue1 = selectBox.options[selectBox.selectedIndex].value;
   
    document.getElementById('selectBox13').style.color=selectedValue1;
   }

   
function changeFunc2() {
    var selectBox      = document.getElementById("selectBox2");
    var selectedValue2 = selectBox.options[selectBox.selectedIndex].value;
   
    document.getElementById('InvulAchtergrondkleur').value= selectedValue2;
    document.getElementById('InvulAchtergrondkleur').style.backgroundColor=selectedValue2;
   }
   
function changeFunc3() {
    var selectBox      = document.getElementById("selectBox3");
    var selectedValue3 = selectBox.options[selectBox.selectedIndex].value;
   
  
    document.getElementById('selectBox3').style.backgroundColor=selectedValue3;
   }
   
function changeFunc4() {
    var selectBox      = document.getElementById("selectBox4");
    var selectedValue4 = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue4.split(";");
     document.getElementById('Verzenden').style.backgroundColor=myarr[0];
     document.getElementById('Verzenden').style.color=myarr[1];
   }
   
function changeFunc5() {
    var selectBox      = document.getElementById("selectBox5");
    var selectedValue5 = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue5.split(";");
     document.getElementById('Herstellen').style.backgroundColor=myarr[0];
     document.getElementById('Herstellen').style.color=myarr[1];
   }
   	   
</Script>
</head>

<body BACKGROUND="../ontip/images/ontip_grijs.jpg" width =40 bgproperties=fixed >

<SCRIPT LANGUAGE="JavaScript">
<!--
self.moveTo(0,0);
self.resizeTo(screen.availWidth,screen.availHeight);
//-->
</SCRIPT>	 
<?php 
// Database gegevens. 
include('mysqli.php');	
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
$today = date('Y-m-d');
$today      = date("Y") ."-".  date("m") . "-".  date("d");


$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

ob_start();
ini_set('display_errors', 'On');
//error_reporting(E_ALL);

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

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

if (isset($_GET['toernooi'])){
 	  $toernooi = $_GET['toernooi'];
} // end get

if (!isset($toernooi)){	 

    echo "<div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >Geen toernooi bekend</div> ";
    ?>
    <script language="javascript">
	    	window.location.replace('index.php');
    </script>
 <?php
} // isset

// Definieer variabelen en vul ze met waarde uit tabel config

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
};

// uit vereniging tabel	
$vereniging_output_naam ='';
$_vereniging  = '';
	
$qry                            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row                            = mysqli_fetch_array( $qry );
$url_logo                       = $row['Url_logo'];
$url_website                    = $row['Url_website'];
$url_redirect                   = $row['Url_redirect'];
$vereniging_output_naam         = $row['Vereniging_output_naam'];
$indexpagina_achtergrond_kleur  = $row['Indexpagina_achtergrond_kleur']; 
 
if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

if (!isset($min_splrs)){
 	$min_splrs = '0';
}


/// Ophalen fonts nodig voor configuratie item font_koptekst
$sql        = "SELECT * from fonts        order by Font_family  ";
$fonts      = mysqli_query($con,$sql);

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Beheer configuratie - <?php echo  $toernooi_voluit; ?>";
</script> 

<!-----  Divs tbv help teksten ---------------------------------------------->

<DIV onclick='event.cancelBubble = true;' class=popup id='soort'>Hier kan het soort toernooi gekozen worden en de manier van inschrijven. Voor een doublet toernooi kan bijvoorbeeld individueel (mêlée) of als 
	team van 2 personen worden ingeschreven. In het eerste geval kan je op het formulier maar 1 naam invullen. In het tweede geval 2 namen.<br>
	Bij t&#234te-a-t&#234te speel je 1 tegen 1<br>
	Bij doublet speel je 2 tegen 2.<br>
	Bij triplet speel je 3 tegen 3.<br>
	Bij 4x4     speel je 2 tegen 2, maar schrijf je in als viertal.<br>
	Bij kwintet speel je afwisselend een doublet en een triplet.<br>
	Bij sextet  speel je afwisselend een doublet en een triplet.<br>
	<br>
	<a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='extra'>Indien ingevuld, wordt het inschrijfformulier voorzien van een extra vraag.<br>
	 In de configuratie moet dan als waarde worden ingevuld: vraag;antwoord1;antwoord2 <br>(tot maximlaal 5 keuze antwoorden;gescheiden door punt-komma. Niet afsluiten met een punt-komma)<br>De standaard keuze kan worden aangegeven met een '*' als laatste karakter van een antwoord.
	    Bijvoorbeeld  Ik kom;boulen*;boulen en eten;alleen eten<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='datum'>Hier kan de datum van het toernooi aangepast worden. Tevens kan worden aangegeven of het een meerdaags toernooi betreft (met begin - en eind datum) of een Cyclus.
	In het laatste geval kunnen de datums van de Cyclus worden opgegeven. Deelnemers schrijven zich eenmalig in voor de complete cyclus.<br> Klik, na selectie van Cyclus op het woord <font color=blue> Cyclus </font> om de cyclus te bewerken.Het getal tussen [] geeft het aantal toernooien in de cyclus aan.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='extra_invulveld'>Indien ingevuld, wordt het inschrijfformulier voorzien van een extra inputveld.<br>
	In de configuratie moet dan als waarde worden ingevuld de omschrijving van het invulveld. Bijvoorbeeld 'Geboortedatum jongste speler'. Deze tekst + ingevulde waarde in het inschrijfformuluer wordt vervolgens afgedrukt in de bevestigingsmail en uitgebreide lijst.<br>
	<a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='email'>Een emailbericht met daarin de inschrijving wordt ook verstuurd naar dit email adres. Het email adres van de organisatie staat in het bestand myvereniging.txt.$email_cc kan een 2e adres bevatten. Om het mail verkeer te beperken, mag hier maar 1 naam ingevuld worden.
	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='licentie'>Indien de waarde hiervan "N" is, wordt er <u>geen</u> invulveld voor 
	   licentie op het inschrijformulier afgedrukt.	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='einde_datum'>Bij overschrijding van de datum einde_inschrijving zullen geen nieuwe inschrijvingen meer ingevuld kunnen worden. In dit veld kan een waarde tot en met uren en minuten worden opgegeven.<br>
	Bijvoorbeeld : 2012-01-17 18:00 betekent geen inschrijvingen meer na 17 jan 2012 om 18:00 uur.
	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='max_splrs'>Bij overschrijding van het maximum aantal spelers. Er kunnen geen nieuwe inschrijvingen meer ingevuld kunnen worden (excl reserves).<br>
	Een team (doublet, triplet, kwintet of sextet) wordt als 1 inschrijving geteld!!!	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='min_splrs'>Het toernooi gaat door bij het bereiken van het minimum aantal spelers. Tot dit aantal bereikt is, zal op het formulier een waarschuwing staan.<br>
	Een team (doublet, triplet, kwintet of sextet) wordt als 1 inschrijving geteld!!!	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='verwijderen'>Als deze waarde op J gezet wordt, verschijnt in het hoofdmenu een optie 'Toernooi verwijderen'. 	<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='kleur'>Voor de selectie van een achtergrond kleur (met bijbehorende tekst kleur), kan gekozen worden uit de kleurenlijst of kan in het input veld een kleur ingevoerd worden.<br>
	 Na bevestigen van de wijziging, zal ook de voorbeeldtekst in deze regel de achtergrondkleur van uw keuze krijgen.
		<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='begin'>Deze variabele is van belang voor de lijst Indexpagina alle actieve toernooien. Als de datum begin inschrijving ligt voor vandaag en einde inschrijving na vandaag dan zal het toernooi op deze pagina getoond worden.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='aantal_reserves'>Hierin kan het aantal toegestane reserve inschrijvingen worden vermeld. Indien het reguliere aantal inschrijvingen is bereikt komt er een tekst 
	   te staan dat men zich nog kan opgegeven als reserve speler. In de bevestigings mail wordt dit ook aangegeven en in de lijst van deelnemers worden de reserve spelers gemarkeerd.
	  <br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='extra_koptekst'>Indien ingevuld verschijnt de tekst achter de toernooinaam in de kop van het inschrijfformulier.<br>
	     Indien nieuwe regel is aangevinkt, komt deze op de regel onder de toernooinaam te staan. <br>
	     Als deze tekst te lang is, of extra aandacht nodig heeft, kan het als een lichtkrant getoond worden. Vink dan lichtkrant aan.
			 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='adres'>Indien ingevuld worden de adres gegevens op het inschrijfformulier getoond en in de bevestigingsmail <br>
	 De inhoud van dit veld bestaat uit een aantal items (max 6), gescheiden door een ;<br>
	 Bijvoorbeeld: "Speel locatie:;Sportpark De sporten;Langs het spoor 23;1234 GG Plaats;tel 06 10987766 <br>
	
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='kosten'>Hierin dienen de kosten per inschrijving ingevuld worden.
	   Standaard zal er een euro teken voor gezet worden. Indien u dit niet wenst, moet het vinkje verder op de regel uitgezet worden.<br><br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>
		 
<DIV onclick='event.cancelBubble = true;' class=popup id='image'>In dit veld wordt de bestandsnaam van het gebruikte plaatje gezet. 
	   Dit plaatje kan worden geselecteerd uit de Image Gallery. Je kan zelf plaatjes toevoegen aan deze gallery via de upload functie op de Image Gallery pagina. Op deze regel kan je aangeven hoe groot het plaatje moet zijn. Nadat een plaatje is geselecteerd geeft het programma aan hoe groot het plaatje is. Eventueel kan met behulp van de invulwaarden (breedte en hoogte)  het plaatje worden verkleind of vergroot.<br>
	   Verder kan ook de positie van de afbeelding t.o.v. de invultekst bepaald worden via selectie links of rechts.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='patroon'>Indien gevuld met de naam van een bestaand plaatje, dan wordt dit plaatje gebruikt als achtergrond (buiten kader) van het formulier<br>
	Net als bij de afbeelding kan de naam handmatig worden ingegeven of geselecteerd uit de Image Gallery.
	Je kan zelf plaatjes toevoegen aan deze gallery via de upload functie op de Image Gallery pagina.<br>
	  	  <br>
			 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV> 		 
  		 
<DIV onclick='event.cancelBubble = true;' class=popup id='klok'>Indien de waarde hiervan J is,zal rechtsonder op het inschrijfformulier een digitale klok getoond worden.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='geb_datum'>Indien de waarde hiervan J is, wordt er een invulveld voor de geboortedatum getoond.
	   Bij junior toernooien zou dit van toepassing kunnen zijn.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='logo'>Standaard wordt het logo getoond dat vermeld staat onder de Tab Algemeen. Wil je voor dit formulier een afwijkend logo, kies dan een bestand uit de selectie lijst. Via de Image gallery kan je nieuwe bestanden uploaden. Via de keuze Ja - Nee kan je ook besluiten het logo al of niet te tonen. Kan nodig zijn ivm breedte van formulier. <br>
	Hier kan je ook de grootte van de afbeelding instellen. Deze geldt alleen als er een alternatief logo bestand gebruikt wordt. De grootte van het standaard logo kan je instellen onder Tab Algemeen.<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='uitgesteld'>Hierbij wordt bij inschrijving een voorlopige bevestiging verstuurd. Indien bankrekening_invullen_jn gelijk is aan Ja , kan er pas een definitieve bevestiging worden verstuurd als er betaald is via <b>Beheer bevestigingen</b>.Indien bankrekening_invullen_jn gelijk is aan = Nee dient er via Beheer bevestiging een bevestiging verstuurd te worden. Let dus op de instelling voor bankrekening_invullen_jn  !!! Er kan ook worden ingesteld dat een voorlopige bevestiing na een aantal dagen vervalt.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='uitgesteld_vanaf'>Bij het bereiken van het aangegeven aantal (indien groter dan 0) wordt er automatisch een voorlopige bevestiging bij inschrijving verstuurd.Via Beheer bevestigingen kan deze worden bevestigd of geannulleerd.</b>.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='boulemaatje_gezocht'>Deelnemers kunnen zich individueel opgeven als reserve of boulemaatje in het geval iemand afvalt of andere personen zich individueel willen inschrijven en er geen mêlée gespeeld wordt. Hier kan deze zichtbaar of verborgen worden.<br>Dit geldt dan zowel in het inschrijfformulier als op de index pagina voor alle actieve verenigingstoernooien. Voor meer informatie over boulemaatje gezocht,zie de handleiding.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='font_koptekst'>Indien ingevuld wordt dit Font gebruikt voor de kop van het inschrijf formulier en de kop van de verkorte lijst.<br>Selecteer het gewenste font uit de lijst<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='bestemd_voor'>Indien ingevuld kan de inschrijving beperkt worden tot leden van de genoemde vereniging of juist bestemd voor alleen leden van deze vereniging.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='meld_tijd'>Hier wordt de tijd ingevuld voor het aanmelden. Via een keuze kan aangegeven worden of men zich VOOR of VANAF de aangegeven tijd kan melden.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='bankrekening'>Indien de waarde 'Ja' is wordt een invulveld getoond voor de bankrekening. Dit is dan ook een verplicht veld om in te vullen. Hiervoor moet uitgestelde_bevestiging_jn ook de waarde 'Ja' hebben<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='koppel_toernooi'>Inschrijvingen worden opgenomen in de lijst van het geselecteerde toernooi. Muteren van de inschrijvingen moet dus ook bij het geselecteerde toernooi gedaan worden!<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='email_organisatie'>Dit email adres wordt gebruikt als verzendadres voor de bevestingsmails.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='toegang'>Hier kan worden omschreven welke personen toegang hebben tot dit toernooi. Bijvoorbeeld : voor boulers met W en J licentie<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='zelf'>Indien dit wordt toegestaan, kan de inschrijver via een link in de bevestigingsmail zijn eigen inschrijving aanpassen.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='email_noreply'>Email adres van de verzender van mails vanuit OnTip voor bijvoorbeeld toevoegen toernooien, verwijderen toernooien etc.<br>Zoals de naam als zegt is het niet de bedoeling dat de emails beantwoord worden. Meestal is dit ook een niet bestaand email adres.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='wachtwoord'>Als je je wachtwoord wilt wijzigen, zet dan het vinkje op Ja. Voer vervolgens het bestaande wachtwoord in en twee maal het nieuwe wachtwoord.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='koptekst'>De overzichtspagina van de eigen OnTip toernooien bevat een koptekst (blok met OnTip logo e.d). Deze kan uitgezet worden bijvoorbeeld om deze pagina mooier in de eigen website te integreren.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='vereniging_selectie'>Voor het invoeren van de vereniging van de speler kan gebruik gemaakt worden van een selectiebox. Met behulp van deze instelling kan dit aan of uit gezet worden.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='gaat_door'>Indien het toernooi niet doorgaat, kan dat hier worden aangegeven, met een reden. Deze wordt dan op het inschrijf formulier afgebeeld en inschrijven is niet langer mogelijk.<br>Bestaande inschrijvingen blijven wel in het systeem aanwezig.
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='ideal'>De kosten voor de inschrijving kunnen via IDEAL worden betaald. Er moet een contract met IDEAL provider MOLLIE worden afgesloten. De extra kosten per inschrijving zijn € 0,29 (zie website Mollie). De vereniging krijgt periodiek (per dag/ week/ maand) een betaling door de IDEAL provider Mollie. <br>
 Het is mogelijk de IDEAL koppeling te testen. De betalingen worden dan goedgekeurd of afgewezen door een IDEAL Bank simulator. Er worden geen bedragen afgeschreven in TEST mode.<br>Er kan worden aangegeven dat de inschrijver een opslag moet betalen voor een IDEAL transactie.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='toernooi_voluit'>De naam die hier wordt ingevuld, verschijnt op het inschrijfformulier en in de mail. Indien hier vreemde tekens worden gebruikt, dienen deze in een aparte schrijfwijze te worden weergegeven.<br>
	<b>Vervang de aangegeven letter door het aangegeven getal voorafgegaan door <span style='font-size:12pt;'>&#</span>
	        <table border = 1>
	        	<tr>
	        		<th style='font-size:12pt;'>Letter</th><th style='font-size:12pt;'>Schrijfwijze (hiervoor &#)</th></tr>
	    		    <td style='font-size:12pt;'>&#128</td><td style='font-size:12pt;text-align:right;'>128</td></tr>
	    		    <td style='font-size:12pt;'>&#146</td><td style='font-size:12pt;text-align:right;'>146</td></tr>
	    		    <td style='font-size:12pt;'>&#148</td><td style='font-size:12pt;text-align:right;'>148</td></tr>
	    		    <td style='font-size:12pt;'>&#223</td><td style='font-size:12pt;text-align:right;'>223</td></tr>
	            <td style='font-size:12pt;'>&#224</td><td style='font-size:12pt;text-align:right;'>224</td></tr>
	            <td style='font-size:12pt;'>&#225</td><td style='font-size:12pt;text-align:right;'>225</td></tr>
	            <td style='font-size:12pt;'>&#226</td><td style='font-size:12pt;text-align:right;'>226</td></tr>
              <td style='font-size:12pt;'>&#228</td><td style='font-size:12pt;text-align:right;'>228</td></tr>
	    	      <td style='font-size:12pt;'>&#232</td><td style='font-size:12pt;text-align:right;'>232</td></tr>
	            <td style='font-size:12pt;'>&#233</td><td style='font-size:12pt;text-align:right;'>233</td></tr>
	            <td style='font-size:12pt;'>&#234</td><td style='font-size:12pt;text-align:right;'>234</td></tr>
	            <td style='font-size:12pt;'>&#235</td><td style='font-size:12pt;text-align:right;'>235</td></tr>
	            <td style='font-size:12pt;'>&#239</td><td style='font-size:12pt;text-align:right;'>239</td></tr>
	            <td style='font-size:12pt;'>&#244</td><td style='font-size:12pt;text-align:right;'>244</td></tr>
	            <td style='font-size:12pt;'>&#38</td><td style='font-size:12pt;text-align:right;'>38</td>
	          </tr>
         </table><br>
 <br>Na opslaan zal de code worden omgezet naar het juiste karakter.<br>
    Voor meer vreemde tekens zoek in Wikipedia naar Windows-1252.<br>
			 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='sortering'>Op de eenvoudige lijst kan de sortering van inschrijvingen worden aangepast: oudste of nieuwste inschrijvingen bovenaan.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='lijst_zichtbaar'>Indien gewenst kan hier worden aangegeven of deelnemers aan het toernooi de lijst met andere inschrijvingen mogen zien. Dit is niet van toepassing op de organisatie.
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='sms'>Indien gewenst kan hier worden aangegeven of een deelnemer een bevestiging van de inschrijving via SMS kan krijgen. Hier zijn kosten aan verbonden voor de vereniging. Indien gewenst, neem contact op met de OnTip beheerder.
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='sms_laatste'>Bij het bereiken van een bepaald aantal inschrijvingen kan hier worden ingesteld dat de inschrijvingen worden verstuurd naar het aangegeven telefoon nr (van de organisatie). Hier zijn kosten aan verbonden. Niet actief als aantal = 0.
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='licentie_ontip'>Voor OnTip wordt een bepaald bedrag per jaar gevraagd voor het gebruik. Hier staat het bankrekeningnr dat gebruikt wordt voor de betaling van de licentie en de datum tot wanneer de licentie geldig is. Na verstrijken van deze datum kan er niet meer worden aangelogd.
	<br> <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='inputkleur'>Hier kan de achtergrondkleur van de invulvelden (naam, Vereniging etc) bepaald worden.	<br> <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='buttonkleur'>Hier kan u de achtergrondkleur van de knoppen 'Verzenden' en 'Herstellen'  aanpassen.	<br> <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='toernooi_selectie'>Als er meerdere toernooien open staan voor inschrijving kan er vanuit een inschrijf formulier makkelijk naar een ander formulier gegaan worden via een selectielijst in de kop van het formuluer. Met deze instelling kan dit uitgezet worden.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='toernooi_zichtbaar'>Indien gewenst kan worden aangegeven dat een toernooi niet zichtbaar is op de OnTip kalender om bijvoorbeeld de instellingen eerst te testen zonder dat er al spelers kunnen inschrijven.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='website_link'>Via deze instelling kan de link naar de eigen site, onderaan het inschrijf formulier zichtbaar of onzichtbaar gemaakt worden.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='ontip_map'>Via deze instelling kan in de OnTip kalender de juiste locatie voor het toernooi worden aangegeven voor de landkaart (OnTip Map).<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='wedstrijd_schema'>Via deze instelling kan worden aangegeven volgens welk systeem het toernooi gespeeld zal worden. Is ook te zien in de OnTip kalender.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='voucher'>Via deze instelling kan worden aangegeven dat bij inschrijving een voucher code moet worden ingevoerd, waarmee met korting ingeschreven kan worden.Ingaand betekent dat de voucher code dient te worden ingevuld. 
	Uitgaand betekent dat bij bevestiging van de inschrijving een vouchercode wordt vermeld. Bij Uitgaand kan vervolgens ook worden aangegeven of er een voucher per inschrijving of per persoon moet worden uitgegeven. <br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='email_notificaties'>Via deze instelling kan worden aangegeven of notificaties worden verzonden naar deelnemers die zich hiervoor hebben opgegeven als er weer plekken zijn vrijgekomen nadat het toernooi in 
eerste instantie vol was.<br>Voorwaarde is wel dat het aantal reserves gelijk moet zijn aan 0. Aanzetten van de notificatie zet deze waarde automatisch op 0.
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='recensie'>Via deze instelling kan worden aangegeven of er recensies bekeken of ingevoerd kunnen worden via de OnTip toernooi kalender.<br>
 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<!----------------------  einde help teksten ------------------------------>

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

<table STYLE ='text-align:left;position:relative;top:-7px;border-collapse: collapse;margin-left:15pt;' width=95% border = 0 >
 <tr> 
  <td width=60% style='text-align:left;' ><img src = '../ontip/images/ontip_logo.png' width='220'></td>
  <td style='text-align:right;border-style:none;vertical-align:top;' width=35%><a href='index.php' style='font-size:9pt;vertical-align:bottom;'><br><br>Terug naar Hoofdmenu</a></td>
 </tr>
</TABLE>

<div style= 'background-image:url("../ontip/images/OnTip_banner_green_fade.jpg");;height:85pt;vertical-align:middle;border:0px solid #000000;box-shadow: 8px 8px 8px #888888;position:relative;top:-20px;margin-left:25pt;margin-right:25pt;
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
 	
	<table width=99% border = 0>
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
    <td width=20%></td>
    <td  WIDTH=240pt style='text-align:center;vertical-align :middle;color:white;font-family:Cooper black;font-size:10pt'>	
    <div  id = 'rotate'  style='border:2pt solid #A9BCF5;padding:2pt;box-shadow: 3px 3px 3px #d8f6ce;background-color:blue;width:180pt;text-align:center;'>
    <?php
    
  	if ($datum > $today and $begin_inschrijving <= $today and $now < $einde_inschrijving  ){?>
   	Dit toernooi is open voor inschrijving.
  
  	<?php } else { ?>
     <?php if ($now > $einde_inschrijving  ){ ?>
    	      Er kan vanaf <br><font color = yellow> <?php echo $einde_inschrijving; ?></font> <br>niet meer worden ingeschreven voor dit toernooi.
         <?php } else { ?>
  	        Dit toernooi is vanaf<br><font color = yellow> <?php echo $begin_inschrijving; ?></font> <br>geopend voor inschrijving.
  <?php }}  ?>
  	
  </div></td>  	</tr>
</table>
<!---- klok ---------------------------->

<div id="klokbalk" width=100% style="background-color:transparent; color:#59b300;text-align:left;font-size:9pt;font-family:verdana;"></div>

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
</div>

<blockquote>
<h3 style='padding:1pt;font-size:20pt;color:green;position:relative;top:-30px;'>Aanpassen formulier voor  '<?php echo $toernooi; ?>' 
<img src ='../ontip/images/Icon_tools.png' width=48 border =0> </h3>
<div style='font-size:11pt;color:blue;position:relative;top:-30px;'>Klik op één van de drie tab bladen (Toernooi, Formulier of Algemeen) voor de diverse instellingen. In de Tab Inschrijf formulier zie je hoe het formulier eruit ziet.In de tab Uitleg staat een uitleg waar welke instelling te vinden is.</div><br>
</blockquote>

<script type="text/javascript">

<!---// Javascript voor navigatie tabs ------------->
   
//[which tab (1=first tab), ID of tab content to display]:

var initialtab=[5, "Uitleg"] 
<?php
if (isset($_GET['tab'])){
   
   if ($_GET['tab'] == 1){ ?> 
       var initialtab=[1, "Toernooi"] 
<?php  
} 

if ($_GET['tab'] == 2){ ?> 
       var initialtab=[2, "Formulier"] 
<?php  
} 

if ($_GET['tab'] == 3){ ?> 
       var initialtab=[3, "Algemeen"] 
<?php  
} 

if ($_GET['tab'] == 4){ ?> 
       var initialtab=[4, "Inschrijf_form"] 
<?php  
} 

 if ($_GET['tab'] > 4){ ?> 
       var initialtab=[5, "Uitleg"] 
<?php } 
} ?>
	  
 
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
for (i=0; i<tabobjlinks.length; i++)
tabobjlinks[i].style.backgroundColor=initTabcolor
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

<div style ='margin-left:45pt;position:relative;top:-30px;'>
<ul id="tablist">
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" class="current" onClick="return expandcontent('Toernooi', this)" theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="3" face="Verdana">Toernooi </font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" onClick="return expandcontent('Formulier', this)"                theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="3" face="Verdana">Formulier </font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" onClick="return expandcontent('Algemeen', this)"                 theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="3" face="Verdana">Algemeen</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" onClick="return expandcontent('Inschrijf_form', this)"           theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="3" face="Verdana">Inschrijf formulier</font></a></li>
<li><a style= 'border:1px solid #000000;box-shadow: 5px 0px 5px #888888;' href="#" onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" onClick="return expandcontent('Uitleg', this)"                   theme="<?php echo $indexpagina_achtergrond_kleur; ?>"><font size="3" face="Verdana">Uitleg</font></a></li>
</ul>
</div>

<DIV id="tabcontentcontainer"   style= 'border:1px solid #000000;box-shadow: 8px 8px 8px #888888;position:relative;top:-30px;'>
<div id="Toernooi"  style="display:none;padding-left:20px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;" class="tabcontent"   >

   <FORM action='muteer_ontip.php' method='post' name = 'myForm'>
  	 <br>
  	 <table width=100%>
   	<tr><td style='vertical-align:bottom;color:black;font-size:9pt;font-family:arial;'>Deze tab bevat de instellingen die direct betrekking hebben op het toernooi.</td>
  </tr>
</table>
     <center>
     <INPUT type='submit' value='Wijzigen bevestigen'  name = 'myForm1' style='background-color:red;color:white;position:relative;top:-30px;'>
      <input type= 'hidden' name = 'toernooi'       value = '<?php echo $toernooi; ?>'/>
    </center><br><br>

<!-- inspringen en breedte   21 nov 2016 ---->
<blockquote>
<table border = 2 id='myTable1' class = 'config' width=95% style= 'border:1px solid #000000;box-shadow: 8px 8px 8px #888888;padding:15pt;position:relative;top:-40px;'>
<?php
$screen = 'Formulier';
?>

 <tr> 
   <td class='varname_k'  width=20% >Toernooi</td><td class='info_k'></td>
   <td class='content_k'  colspan = 4 ><?php echo $toernooi; ?></td>
 </tr>

<?php 
 ////// Adres
$variabele = 'adres';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $adres     = $result['Waarde'];
 $id        = $result['Id'];

?>
 <tr>
 <td class='varname'>Adres speel locatie</td><td  style='text-align:center;background-color:#00288a;'> <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('adres', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>
<td class='content' colspan = 4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='100'  value ='";
 echo $adres;
 echo "'>  Het karakter ; in de adrestekst zorgt voor een nieuwe regel.</span></td>";
 
?>
</tr>
<?php 
 ////// OnTip map locatie
$variabele = 'Ontip_map_locatie';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select map locatie');  
 $result    = mysqli_fetch_array( $qry1);
 $locatie     = $result['Waarde'];
 $id        = $result['Id'];

?>
 <tr>
 <td class='varname'>OnTip Map locatie</td><td  style='text-align:center;background-color:#00288a;'> <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('ontip_map', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan = 4>

<?php 
 echo "<span><input name= 'Ontip_map_locatie' type='text' size='100'  value ='";
 echo $locatie;
 echo "'>  Gebruik locatie die gevonden kan worden in Google Maps.</span></td>";
 
?>
</tr>

<?php
  ////// Datum
 $variabele = 'datum';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select adres');  
 $result    = mysqli_fetch_array( $qry1);
 $datum     = $result['Waarde'];
 
  /* Set locale to Dutch */
 setlocale(LC_ALL, 'nl_NL');
 
 ////  0123456789
 ////  2013-09-18
  
 $dag     = 	substr ($datum , 8,2); 
 $maand   = 	substr ($datum , 5,2); 
 $jaar    = 	substr ($datum , 0,4); 
 ?>
 
 <tr>
 <td class='varname'  >Datum toernooi</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('datum', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a></td>
 <td class='content'   colspan = 2 >
 
	<select name='datum_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
<?php
 for ($d=1;$d<=31;$d++){
 	
 	if ($d == $dag ){
 			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
    }		
   else {
 				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
   }	
 }
 	?>
</SELECT>
 	<select name='datum_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
     <?php
      for ($m=1;$m<=12;$m++){
      	if ($m == $maand ){
      	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
      	 } else { 
      	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
      	 }			
     }
 	?>
</SELECT>
 <select name='datum_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
   <?php
    for ($y=date('Y')-1;$y<(date('Y')+5);$y++){
    	
    	if ($y == $jaar ){
    		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
    		}
    		else {
    			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
    			}
    }			
    	?>
  </SELECT>
<!--- aanvang toernooi hier 4 apr 2016  ---> 	
 	
 <?php
/// Aanvang

$variabele = 'aanvang_tijd';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $aanvang_tijd   = $result['Waarde'];
 
/// 0123456
/// 10:30
 
 $uur       = substr ($aanvang_tijd, 0,2);
 $min       = substr ($aanvang_tijd, 3,2);
?>
  Aanvang toernooi 

<select name='aanvang_uur' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($au=0;$au<=24;$au++){
 	
 	if ($au == $uur ){
 		  echo "<option value=".$au."  selected>".strftime("%H",mktime(date($au),0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$au.">".strftime("%H",mktime(date($au),0,0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>
 <select name='aanvang_min' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
    <?php
     for ($an=0;$an<=59;$an=$an+15){
     	
     	if ($an == $min ){
     		  echo "<option value=".$an."  selected>".strftime("%M",mktime(0,date($an),0,date("m"),date("d"),date("Y")))."</option>";
     		}
     		else {
     			 echo "<option value=".$an.">".strftime("%M",mktime(0,date($an),0,date("m"),date(1),date("Y")))."</option>";
     			}
     }			
     	?>
    </SELECT>  uur
    </td>
 	  <td class='content' colspan=1><b><?php echo strftime("%A %e %B %Y %H:%M", mktime($uur, $min, 0, $maand , $dag, $jaar) ); ?></b></td>
 	  <td class='varname'>Meerdaags toernooi:<br> 
 		 	<?php
 		 	
$variabele = 'meerdaags_toernooi_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $meerdaags_toernooi_jn   = $result['Waarde'];
 
 if ($meerdaags_toernooi_jn ==''){
   	$meerdaags_toernooi_jn = 'N';
   }
   
   if ($meerdaags_toernooi_jn =='X'){ 
   	$count = 0;
    $qry2    = mysqli_query($con,"SELECT count(*) as Aantal From toernooi_datums_cyclus where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' " )     or die(' Fout in select cyc');  
    $result    = mysqli_fetch_array( $qry2);
    $count       = $result['Aantal'];
   }
   		switch($meerdaags_toernooi_jn){
  	         	case "J":
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'J'  checked/> Ja ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'X'  /> Cyclus ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'N'        /> Nee ";break;
  	         	case "X":
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'J'  /> Ja ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'X'  checked /><a href='beheer_cyclus_datums.php?toernooi=".$toernooi."' target='Toernooi'>Cyclus [".$count."]</a> ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'N'        /> Nee ";break;
  	         	default:
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'J'  /> Ja ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'X'  /> Cyclus ";
  	          	echo "<input type='radio' name='meerdaags_toernooi_jn' value = 'N'    checked    /> Nee ";break;
 		}// end switch
    ?> 	
 	  </td>
  
 </tr>
 
 <?php
  if ($meerdaags_toernooi_jn =='J'){

 $variabele = 'eind_datum';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select adres');  
   $result    = mysqli_fetch_array( $qry1);
   $eind_datum     = $result['Waarde'];
   $verschil       = $result['Parameters'];
 
 if ($eind_datum ==''){
 	$eind_datum = date('Y-m-d');
 }
  
  /* Set locale to Dutch */
 setlocale(LC_ALL, 'nl_NL');
 
 ////  0123456789
 ////  2013-09-18
  
 $dag     = 	substr ($eind_datum	 , 8,2); 
 $maand   = 	substr ($eind_datum , 5,2); 
 $jaar    = 	substr ($eind_datum , 0,4); 
 ?>
 
 <tr>
 <td class='varname'  >Einddatum toernooi</td><td style='text-align:center;background-color:#00288a;'></td>
 <td class='content'   colspan = 2 >
 
	<select name='eind_datum_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
<?php
 for ($d=1;$d<=31;$d++){
 	
 	if ($d == $dag ){
 			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
    }		
   else {
 				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
   }	
 }
 	?>
</SELECT>
 	<select name='eind_datum_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
     <?php
      for ($m=1;$m<=12;$m++){
      	if ($m == $maand ){
      	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
      	 } else { 
      	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
      	 }			
     }
 	?>
</SELECT>
 <select name='eind_datum_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
   <?php
    for ($y=date('Y')-1;$y<(date('Y')+5);$y++){
    	
    	if ($y == $jaar ){
    		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
    		}
    		else {
    			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
    			}
    }			
    	?>
  </SELECT>
  <td class='content' colspan=1><b><?php echo strftime("%A %e %B %Y", mktime(0,0, 0, $maand , $dag, $jaar) ); ?></b></td>
  <td class='content' colspan=1><b><?php echo $verschil;?></b></td>
</tr>

 
 
<?php  
} // end meerdaags

 
 //////  Begin inschrijving

 $variabele = 'begin_inschrijving';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $datumtijd     = $result['Waarde'];
 $today     = date("Y") ."-".  date("m") . "-".  date("d");
 
 ////  012345678901234567890
 ////  2013-01-17 10:00
  
 $dag   = 	substr ($datumtijd , 8,2); 
 $maand = 	substr ($datumtijd , 5,2); 
 $jaar  = 	substr ($datumtijd , 0,4); 
 $uur   =   substr ($datumtijd , 11,2); 
 $min   =   substr ($datumtijd , 14,2); 
 
 if ($uur =='00') { $uur = '00'; }
 if ($min =='00') { $min = '00'; }
 ?> 
 <tr>
  <td class='varname'  >Tijdstip begin inschrijving</td><td style='text-align:center;background-color:#00288a;'>
     <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('begin', event)">
   	<img src='../ontip/images/info.jpg' border = 0 width=20></a></td>
   <td class='content'    colspan=2>
 	
	<select name='begin_datum_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
    <?php
     for ($d=1;$d<=31;$d++){
     	
     	if ($d == $dag ){
     			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
        }		
       else {
     				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
       }	
     }
     	?>
  </SELECT>
     	
 	<select name='begin_datum_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
   <?php
    for ($m=1;$m<=12;$m++){
    	if ($m == $maand ){
    	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
    	 } else { 
    	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
    	 }			
   }
   
    	?>
   </SELECT>
 <select name='begin_datum_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
     <?php
     for ($y=date('Y')-1;$y<(date('Y')+5);$y++){
     	
     	if ($y == $jaar ){
     		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
     		}
     		else {
     			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
     			}
     }			
     	?>
    </SELECT>
	    
<!--- 4 apr 2016 met begin uur en minuut----->
 
 om 
<select name='begin_datum_uur' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($u=0;$u<=24;$u++){
 	
 	if ($u == $uur ){
 		  echo "<option value=".$u."  selected>".strftime("%H",mktime(date($u),0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$u.">".strftime("%H",mktime(date($u),0,0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>

<select name='begin_datum_min' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
   <?php
    for ($n=0;$n<=59;$n++){
    	
    	if ($n == $min ){
    		  echo "<option value=".$n."  selected>".strftime("%M",mktime(0,date($n),0,date("m"),date("d"),date("Y")))."</option>";
    		}
    		else {
    			 echo "<option value=".$n.">".strftime("%M",mktime(0,date($n),0,date("m"),date(1),date("Y")))."</option>";
    			}
    }			
   	?>
   </SELECT>    
  </td>
 <td class='content' colspan=2><b><?php echo strftime("%A %e %B %Y %H:%M", mktime($uur, $min, 0, $maand , $dag, $jaar) ); ?></b></td>

<?php
//////  Einde inschrijving (datum + tijd)

 $variabele = 'einde_inschrijving';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 
 //// 0123456789 01234
 ///  2013-01-17 14:30
 
 $datum_tijd =  explode (" ", $result['Waarde']);
 $datum     = $datum_tijd[0];
 $_tijd     = $datum_tijd[1];
 $dag       = substr ($datum , 8,2); 
 $maand     = substr ($datum , 5,2); 
 
 if ($_tijd == '') {
 	$_tijd = '00:00';
}
 
 $jaar      = substr ($datum , 0,4); 
 $uur       = substr ($_tijd, 0,2);
 $min       = substr ($_tijd, 3,2);
  
 ?>
 <tr>
 <td class='varname'  >Tijdstip einde inschrijving</td><td style='text-align:center;background-color:#00288a;'>
   <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('einde', event)">
    	<img src='../ontip/images/info.jpg' border = 0 width=20>
   </a>
  </td>
 
 <td class='content' colspan = 2>
  	<select name='eind_inschrijving_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
<?php
 for ($d=1;$d<=31;$d++){
 	
 	if ($d == $dag ){
 			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
    }		
   else {
 				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
   }	
 }
 	?>
</SELECT>
 	
 	<select name='eind_inschrijving_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
<?php
 for ($m=1;$m<=12;$m++){
 	if ($m == $maand ){
 	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 } else { 
 	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 }			
}

 	?>
</SELECT>
 <select name='eind_inschrijving_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
<?php
 for ($y=date('Y')-1;$y<(date('Y')+5);$y++){
 	
 	if ($y == $jaar ){
 		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
 		}
 		else {
 			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 			}
 }			
 	?>
</SELECT>
 om 
<select name='eind_inschrijving_uur' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($u=0;$u<=24;$u++){
 	
 	if ($u == $uur ){
 		  echo "<option value=".$u."  selected>".strftime("%H",mktime(date($u),0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$u.">".strftime("%H",mktime(date($u),0,0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>

<select name='eind_inschrijving_min' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($n=0;$n<=59;$n++){
 	
 	if ($n == $min ){
 		  echo "<option value=".$n."  selected>".strftime("%M",mktime(0,date($n),0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$n.">".strftime("%M",mktime(0,date($n),0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			

 
 	?>
</SELECT>
</td>
 <td class='content' colspan=2><b><?php echo strftime("%A %e %B %Y %H:%M", mktime($uur, $min, 0, $maand , $dag, $jaar) ); ?></b></td>
</tr>
<tr>
 <td class='varname'>Soort toernooi</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('soort', event)">                     
 <img src='../ontip/images/info.jpg' border = 0 width=20></a></td>                                                                 
 
<?php 
 $variabele = 'soort_inschrijving';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 
 $soort_inschrijving = $result['Waarde'];
 $inschrijf_methode = $result['Parameters'];
 if ($inschrijf_methode == ''){
    $inschrijf_methode = 'vast';
 }   	
 
?>

 	<td class='content' colspan = 2 > Maak een keuze : 
 		<?php
 		switch($result['Waarde']){
  	         	case "single":
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'single'  checked/> T&#234te-a-t&#234te ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'        /> Doublet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'        /> Triplet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'         /> Sextet&nbsp  ";
  	          	break;
 							case "doublet":
	              echo "<input type='radio' name='Waarde-".$id."' value = 'single'          /> T&#234te-a-t&#234te ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet' checked /> Doublet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'        /> Triplet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'         /> Sextet&nbsp "; 							  
  	          	break;
 							case "triplet":
	              echo "<input type='radio' name='Waarde-".$id."' value = 'single'         /> T&#234te-a-t&#234te ";              
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'        /> Doublet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet' checked/> Triplet ";                          
   	          	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'         /> Sextet&nbsp  ";                     	  
  	          	break;
  						case "4x4":
	              echo "<input type='radio' name='Waarde-".$id."' value = 'single'         /> T&#234te-a-t&#234te ";              
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'        /> Doublet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'        /> Triplet ";                          
   	          	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'   checked  /> 4x4 ";
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'         /> Sextet&nbsp  ";                     	  
  	          	break;
 							case "kwintet":
 	              echo "<input type='radio' name='Waarde-".$id."' value = 'single'          /> T&#234te-a-t&#234te ";              
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'         /> Doublet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'         /> Triplet ";                          
  	           	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
              	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet' checked  > Kwintet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'          /> Sextet&nbsp  ";                     
  	          	break;
 						  case "sextet":
 	              echo "<input type='radio' name='Waarde-".$id."' value = 'single'         /> T&#234te-a-t&#234te ";              
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'        /> Doublet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'        /> Triplet ";                          
   	          	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
              	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet' checked /> Sextet&nbsp  ";                     
  	          	break;
  	          default:
  	            echo "<input type='radio' name='Waarde-".$id."' value = 'single' checked /> T&#234te-a-t&#234te ";              
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'doublet'        /> Doublet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'triplet'        /> Triplet ";                          
  	           	echo "<input type='radio' name='Waarde-".$id."' value = '4x4'            /> 4x4 ";
              	echo "<input type='radio' name='Waarde-".$id."' value = 'kwintet'        /> Kwintet ";                          
  	          	echo "<input type='radio' name='Waarde-".$id."' value = 'sextet'         /> Sextet&nbsp  ";                      
  	          break; 	
 		}// end switch
    ?> 	
 		 </td>
 		 <td class='varname'>Soort inschrijving</td>
 		 <td class='varname'>Maak een keuze : 
 		 	<?php
   		switch($inschrijf_methode){
  	         	case "single":
  	          	echo "<input type='radio' name='inschrijf_methode' value = 'single'  checked/> Mêlée ";
  	          	echo "<input type='radio' name='inschrijf_methode' value = 'vast'        /> Als team ";break;
  	         	case "vast":
  	          	echo "<input type='radio' name='inschrijf_methode' value = 'single'  /> Mêlée ";
  	          	echo "<input type='radio' name='inschrijf_methode' value = 'vast'    checked    /> Als team ";break;
 		}// end switch
    ?> 	
 	  </td>
 	</tr>

 <tr>
 	<?php
//// email_organisatie
$variabele = 'email_organisatie';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

 ?>
 <td class='varname'>Email adres organisatie</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('email_organisatie', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
<?php
echo "<span><input  name= 'Waarde-";
echo $id;
echo "' type='text' size='100'  value ='";
echo $result['Waarde'];
echo "'><span><br>Maximaal 1 email adres !!";           	
?>
</tr>   

<tr>
<?php
//// email_cc
$variabele = 'email_cc';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

 ?>
 
 <td class='varname'>Email adres CC</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('email', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
<?php
echo "<span><input  name= 'Waarde-";
echo $id;
echo "' type='text' size='100'  value ='";
echo $result['Waarde'];
echo "'><span><br>Maximaal 1 email adres !!";           	
?>
</tr>   
    	
<tr>
<?php
//// email_notificaties_jn
$variabele = 'email_notificaties_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];

$variabele = 'aantal_reserves';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $aantal_reserves   = $result['Waarde'];

if ($aantal_reserves > 0){
	  $keuze = 'N';
}

 
 if($keuze !='J'){
 	  $keuze = 'N';
 	}
?>
 
 <td class='varname'>Email notificaties</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('email_notificaties', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan = 2 >   
 <?php 

	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='email_notificaties_jn' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='email_notificaties_jn' value = 'N'/> Nee. ";  	
    }
   else {
     	echo "<input type='radio' name='email_notificaties_jn' value = 'J' /> Ja ";
      echo "<input type='radio' name='email_notificaties_jn' value = 'N' checked/> Nee. ";  	
 	}
 	?> 

</td>
<td class='content' colspan = 2>
<?php
if ($keuze =='J') {
echo "<span style='padding-left:25pt;'> Email notificaties zijn ingeschakeld.";
  }  else {
echo "<span style='padding-left:25pt;'> Email notificaties zijn uitgeschakeld.";
 	}
 	
 	if ($aantal_reserves > 0 ){
 		echo "&nbspAantal reserves moet 0 zijn";
 	}
 	echo "</span>";
 	
 	
?>
</td>
</tr>


<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Gaat niet door
$variabele  = 'toernooi_gaat_door_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count     = mysqli_num_rows($qry1);
 
if ($count == 0) {
	 $query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) 
	                 VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."',  'toernooi_gaat_door_jn','J', now() ) ";
    mysqli_query($con,$query) or die ('Fout in insert toernooi gaat door');  
    $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 }
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix    = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 } 
 $reden      = $result['Parameters']; 
 
  //echo "<input  name= 'Reden_doorgaan' type='text' size='120'  value ='".$reden."' >";
 
 
 ?>
 <tr>
 <td class='varname'  >Toernooi gaat door</td><td style='text-align:center;background-color:#00288a;'  > <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('gaat_door', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a></td>
     	
 <td class='content' colspan = 4 >   
 	 	
 <?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee. ";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee. ";  	
 	}

 echo "<span class='important'>Reden voor niet doorgaan : </span> <input name= 'Reden-";
 echo $id;
 echo "' type='text' size='100'  value ='";
 echo $reden;
 echo "'   >";
 		
echo "</span></td>";
?>
</tr>

  
  
<?php
////// Meld tijd en aanvang 

$variabele = 'meld_tijd';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter = explode('#', $result['Parameters']);
 
 $suffix    =  substr($result['Waarde'],-2);
 
  //// oude situatie. 11-10-2013 vervangen door parameter
 if ($suffix == '#1') {
 	   $suffix = 1;
 	   $meld_tijd = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
 	 }
 
 if ($suffix == '#2') {
 	   $suffix = 2;
 	   $meld_tijd = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
 	 }
 	 
 if ($suffix != '#1' and  $suffix != '#2'){
 	   $suffix    = $parameter[1];
   	 $meld_tijd = $result['Waarde'];
 }	
  
 $uur       = substr ($meld_tijd, 0,2);
 $min       = substr ($meld_tijd, 3,2);
 
 
 ?>
 <tr>
 <td class='varname'>Inschrijvers dienen zich te melden </td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('meld_tijd', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
</td>

<td class='content' colspan=2>

<?php
  
 echo " ";
 echo "<span > Maak een keuze : ";
   if ($suffix =='1') {
  	    echo "<input type='radio' name='suffix' value = '1' checked/>Voor ";
   	    echo "<input type='radio' name='suffix' value = '2'/> Vanaf";  	
   }
   else {
   	   	echo "<input type='radio' name='suffix' value = '1' /> Voor ";
   	    echo "<input type='radio' name='suffix' value = '2' checked/> Vanaf ";  	
   }
 

 ?>
 .  Tijd : <select name='meld_uur' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($mu=0;$mu<=24;$mu++){
 	
 	if ($mu == $uur ){
 		  echo "<option value=".$mu."  selected>".strftime("%H",mktime(date($mu),0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$mu.">".strftime("%H",mktime(date($mu),0,0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>

<select name='meld_min' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:45px;'>
<?php
 for ($mn=0;$mn<=59;$mn=$mn+15){
 	
 	if ($mn == $min ){
 		  echo "<option value=".$mn."  selected>".strftime("%M",mktime(0,date($mn),0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$mn.">".strftime("%M",mktime(0,date($mn),0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>  uur
</td>
 
 <td class='varname' colspan =2>
 	<?php
 	 if ($suffix =='1') {
  	    echo "Voor ";
   }
   else {
   	   	echo "Vanaf ";  	
   }
 ?>
	
 	<?php echo $uur;?>:<?php echo $min;?> uur</td>
 
</tr>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Bestemd voor
$variabele = 'bestemd_voor';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

$naam_vereniging = $result['Waarde'];
$wel_niet        = $result['Parameters'];

if (strlen($naam_vereniging) < 2){
	$naam_vereniging ='';
	}



if ($naam_vereniging != '' and $wel_niet == ''){
	 $wel_niet = 'J';
}
	

 ?>
 <tr>
 <td class='varname'  >Inschrijving beperken tot</td><td style='text-align:center;background-color:#00288a;'  > <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('bestemd_voor', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a></td>
     	
 <td class='content'  onclick="initForm(myForm,'Waarde-<?php echo $id;?>','<?php echo $vereniging;?>')"    
 	
 <?php 
 echo " colspan = 1 >";
 echo "<span class='important'>Naam vereniging</span> <input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='40'  value ='";
 echo $naam_vereniging;
 echo "'   >";
 
 echo "<br><em>Klik op 'Naam vereniging' om eigen vereniging in te vullen.</em></td><td class='content' colspan = 3 > Maak een keuze :<br>";
 if ($wel_niet == 'J') {
 	    echo "<input type='radio' name='Wel_niet' value = 'J' checked/> Alleen deze vereniging ";
 	    echo "<input type='radio' name='Wel_niet' value = 'N'/> Deze vereniging niet";  	
 	  }
 	  else {
 	   	echo "<input type='radio' name='Wel_niet' value = 'J' /> Alleen deze vereniging ";
 	    echo "<input type='radio' name='Wel_niet' value = 'N' checked/> Deze vereniging niet ";  	
 	}
 echo "</td>";       
?>
</tr>

<?php
////// Ideal betaling
$variabele   = 'ideal_betaling_jn';
 $qry1       = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result     = mysqli_fetch_array( $qry1);
 $id         = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);
 
 $testmode            = $parameter[1];
 $ideal_opslag_kosten = $parameter[2];
 
 if ($ideal_opslag_kosten == '') {
   	$ideal_opslag_kosten  = '0.00';
}

 $ideal_opslag_kosten = str_replace(',','.', $ideal_opslag_kosten);
  
 
 $suffix     = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }
?>
 <tr>
 <td class='varname'>IDEAL betaling</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('ideal', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan = 2>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
echo "</span>";

if ($keuze =='J') {
echo "<span style='padding-left:25pt;'>  Test : ";
  if ($testmode =='TEST') {
      echo "<input type='radio' name='ideal_test-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='ideal_test-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='ideal_test-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='ideal_test-".$id."' value = 'N' checked/> Nee ";  	
 	}
echo "</span>";

}
$_testmode = $testmode;
if ( $testmode !='TEST' ){
	$_testmode = 'LIVE'; 
} 	
		
echo "</span></td>";

if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Inschrijver kan betalen via IDEAL (<?php echo $_testmode; ?>).
    	 Opslag kosten IDEAL betaling €. <input name= 'ideal_opslag_kosten' type='text' size='5'  value ='<?php echo $ideal_opslag_kosten; ?>'.</span>
    	</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Betalen via IDEAL is uitgeschakeld .      	</td>
<?php } ?>

</tr>
<?php
////// Kosten
$variabele = 'kosten_team';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $kosten          = $result['Waarde'];
 
 
 //$variabele = 'soort_inschrijving';
 //$qry2      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 //$result2   = mysqli_fetch_array( $qry2);
 //$soort_inschrijving = $result2['Waarde'];
 
  //var_dump($result['Parameters']);
  
 /// Conversie oud naar nieuw
/// Laatste positie kosten geeft aan of Euro teken erbij moet
/// m = met  , z = zonder

$_euro_ind = substr($result['Waarde'],-1); 
 if ($_euro_ind == 'm' or $_euro_ind == 'z'){
     $len       = strlen($result['Waarde']);
     $kosten    = substr($result['Waarde'],0,$len-1);
     $euro_ind  = $_euro_ind;
     } 
   else { 
    $kosten = $result['Waarde'];
} 
 $kosten = str_replace(',','.', $kosten);
  
  
 ?>
 <tr>
 <td class='varname'>Kosten deelname</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('kosten', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan= 2>
<?php
echo "<input name= 'Waarde-";
echo $id;
echo "' type='text' size='25'  value ='";
echo $kosten;
echo "'      >"; 
 
 if ($soort_inschrijving == 'single' ){  
 	$team = ' persoon';
} else {
	  $team = $soort_inschrijving;
}
 if ($soort_inschrijving != 'single' and $inschrijf_methode =='vast'){ 
     if ($kosten_eenheid == '1' ){
               	echo "<input type='radio' name='kosten_eenheid' value = '1'  checked/> per persoon.";
  	          	echo "<input type='radio' name='kosten_eenheid' value = '2'        /> per ".$team.".  ";
  	      } 
  	      else {
  	      	   	echo "<input type='radio' name='kosten_eenheid' value = '1'         /> per persoon";
  	          	echo "<input type='radio' name='kosten_eenheid' value = '2' checked />per ".$team.".  ";
     }  	
}
 if ($soort_inschrijving == 'single' or $inschrijf_methode =='single'){ 
   echo "<input type='hidden' name='kosten_eenheid' value = '1'  checked/> per persoon.";
}


if ($soort_inschrijving == 'single' or $inschrijf_methode =='single'){
	  $kosten_oms = ' persoon'; 
  } else {
     if ($kosten_eenheid == '1'){  
 	       $kosten_oms = ' persoon';
     } else {
	  $kosten_oms = $soort_inschrijving;
    }
}
 if ($euro_ind == 'm') {
    $kosten_team  = 'Kosten &#128 '. $kosten . ' per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
 }           
              
?>  	 
 <br>Vink hier aan of het euro teken getoond moet worden.
<?php
  if ($euro_ind =='m') {
    	   echo "<input type='checkbox' name= 'euro_sign' checked/> </td>";
    	  }
 else {
      	 echo "<input type='checkbox' name= 'euro_sign' />";
 }
?>
  </td>
  <td class='content' colspan= 2><?php echo $kosten_team; 
  	
  	if( $ideal_betaling_jn == 'J' and $inschrijf_methode =='vast') {
  		echo  "<br>Indien er betaald kan worden mbv IDEAL moet dit de prijs per ".$team." zijn.In het invul vak mag dan alleen een bedrag staan!"; 
  	}	
		?> 
  	</td>
</tr>
<?php
////// Licentie verplicht
$variabele = 'licentie_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix     = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }
?>
 <tr>
 <td class='varname'>Licentie verplicht</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('licentie', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan = 4>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 		
echo "</span></td>";
?>
</tr>

<?php

////// Maximum aantal spelers

 $variabele = 'max_splrs';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
?>
 <tr>
 <td class='varname'>Max aantal inschrijvingen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('max_splrs', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan=  4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='5'  value ='";
 echo $result['Waarde'];
 
 if ($inschrijf_methode =='vast' ){
 echo "'> (Doublet,Triplet, Kwintet en Sextet tellen als 1)</span></td>";
} else {
	echo "'> personen.</span></td>";
}
?>
</tr>

<?php

////// Minimum aantal spelers

 $variabele = 'min_splrs';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $min_splrs = $result['Waarde'];
 
 if ($min_splrs == '') {
    	$min_splrs  = 0 ;
}
 
 
?>
 <tr>
 <td class='varname'>Min aantal inschrijvingen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('min_splrs', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>  </a>
</td>

<td class='content' colspan=  4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='5'  value ='";
 echo $min_splrs;
 
 if ($inschrijf_methode =='vast' ){
 echo "'> (Doublet,Triplet, Kwintet en Sextet tellen als 1)</span></td>";
} else {
	echo "'> personen.</span></td>";
}
?>
</tr>


<?php
////// Maximum aantal reserves

$variabele = 'aantal_reserves';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
?>
 <tr>
 <td class='varname'>Max aantal reserves</td><td style='text-align:center;background-color:#00288a;'>
  <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('aantal_reserves', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
</td>

<td class='content' colspan=  4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='2'  value ='";
 echo $result['Waarde'];
 echo "'> (Extra inschrijvingen als toernooi al vol is)</span></td>";
 
?>
</tr>

<?php
////// Prijzen
$variabele = 'prijzen';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
?>
 <tr>
 <td class='varname'>Prijzen toernooi</td><td style='text-align:center;background-color:#00288a;'>
  <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('prijzen', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
</td>

<td class='content' colspan = 4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='100'  value ='";
 echo $result['Waarde'];
 echo "'> (Bijv. In natura, geldprijzen e.d)</span></td>";
?>
</tr>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////// SMS bevestigigng
$variabele = 'sms_bevestigen_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix     = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }
?>
 <tr>
 <td class='varname'>Bevestigen inschrijving via SMS</td><td style='text-align:center;background-color:#00288a;'>
  <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('sms', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
</td>

<td class='content' colspan = 1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
?>	
</span></td>

<?php
if ($keuze =='J') { 	?> 
<td class='content' colspan=  3> Inschrijving kan bevestigd worden via SMS bericht.<br> Hier zijn kosten aan verbonden voor de vereniging ! </td>
<?php }
else { ?> 
<td class='content' colspan=  3> Inschrijving kan niet bevestigd worden via SMS bericht. </td>
<?php } ?>
</tr>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Uitgestelde bevestiging


$variabele = 'uitgestelde_bevestiging_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select limiet');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 $limiet    = $result['Parameters'];
  	 
 if ($limiet ==''){
  	   $limiet =  0;   // oneindig
  }
 ?>
 <tr>
 <td class='varname'>Voorlopige bevestiging</td><td style='text-align:center;background-color:#00288a;'>
 <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('uitgesteld', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a> 
</td>
<td class='content' colspan=  1>

<?php 
	echo "<span style='margin-right:15pt;'> Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee.   ";  	
 	}
 	 if ($keuze =='J') { ?>
    </span> Verval termijn 
    <input name= 'Limiet_bevestiging' type='text' size='2'  value ='<?php echo $limiet; ?>' > dagen (0 = niet).
     </td><td class='content' colspan=  3>Organisatie verstuurt definitieve bevestiging via beheer bevestigingen.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Inschrijving wordt automatisch direct definitief bevestigd.</td>
<?php } 
?> 		
</tr>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Uitgestelde bevestiging vanaf
$variabele = 'uitgestelde_bevestiging_vanaf';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count     = mysqli_num_rows($qry1);
 
if ($count == 0) {
	 $query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) 
	                         VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."',  'uitgestelde_bevestiging_vanaf','0', now() ) ";
    mysqli_query($con,$query) or die ('Fout in insert uitgestelde_bevestiging_vanaf');  
    $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 }
 
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $aantal    = $result['Waarde']
 ?>
  <td class='varname'>Automatisch voorlopige bevestiging versturen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('uitgesteld_vanaf', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a></td>
<td class='content' colspan=  4>

<?php 

 $color='black';
 if ($aantal !=''   and $aantal > 0){ 
 	  $color='red';
}


 echo "<span  style= 'color:".$color.";'>Bij meer dan <input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='2'  value ='";
 echo $aantal;
 
 if ($inschrijf_methode =='vast' ){
 echo "'> inschrijvingen (Doublet,Triplet, Kwintet en Sextet tellen als 1)   wordt automatisch een voorlopige bevestiging gestuurd (0 = niet)</span></td>";
} else {
	echo "'> personen wordt automatisch een voorlopige bevestiging gestuurd (0 = niet).</span></td>";
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?> 		
</tr>

<?php
////// _laatste_inschrijvingen
$variabele = 'sms_laatste_inschrijvingen';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
  

?>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Invoer recensie   15 jjni 2019

$variabele = 'recensie_mogelijk_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select recensie');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 
 if ($keuze !='J'){
	 $keuze = 'N'; 
 }
  	 
  ?>
 <tr>
 <td class='varname'>Recensie invoer mogelijk</td><td style='text-align:center;background-color:#00288a;'>
 <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('recensie', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a> 
</td>
<td class='content' colspan=  1>

<?php 
	echo "<span style='margin-right:15pt;'> Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='recensie_mogelijk_jn' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='recensie_mogelijk_jn' value = 'N'/> Nee";  	
    }
   else {
      echo "<input type='radio' name='recensie_mogelijk_jn' value = 'J' /> Ja ";
      echo "<input type='radio' name='recensie_mogelijk_jn' value = 'N' checked/> Nee.   ";  	
 	}
 	 if ($keuze =='J') { ?>
    </span> </td><td class='content' colspan=  3>Recensie invullen mogelijk voor dit toernooi.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Recensie invullen NIET mogelijk voor dit toernooi.</td>
<?php } 
?> 		
</tr>
 <tr>
 	
 <td class='varname'>Stuur SMS voor laatste inschrijvingen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('sms_laatste', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>

<td class='content' colspan = 4>

<?php 
 echo "<span>Vanaf <input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='2'  value ='";
 echo $result['Waarde'];
 echo "'> inschrijvingen (0 = niet) worden SMS berichten naar telnr ";
 echo "  <input name= 'Parameters-";
 echo $id;
 echo "' type='text' size='10'  value ='";
 echo $result['Parameters'];
 echo "'> (alleen cijfers!) gestuurd   </span>.</td>";
 
?>
</tr>
<?php
////// Toegang
$variabele = 'toegang';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

?>
 <tr>
 <td class='varname'>Toegang</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('toegang', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>

<td class='content' colspan = 4>

<?php 
 echo "<span><input name= 'Waarde-";
 echo $id;
 echo "' type='text' size='100'  value ='";
 echo $result['Waarde'];
 echo "'> </span></td>";
 
?>
</tr>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Toernooi  zichtbaar op kalender

// aangepast 9 maart 2017 

$variabele = 'toernooi_zichtbaar_op_kalender_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];

// overgangs situatie
 if ($keuze ==''   or $keuze =='J'){
 	   $keuze = '0';
 }

 if ($keuze =='N'){
 	   $keuze = '3';
 }

 ?>
 <tr>
   <td class='varname'>Toernooi zichtbaar op een kalender</td><td style='text-align:center;background-color:#00288a;'>
 <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('toernooi_zichtbaar', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a> 
   <td class='content' colspan=  1>



<?php 
// 9 maart 2017

  $qry1           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select');  
  $result1        = mysqli_fetch_array( $qry1);
  $bond           = $result1['Bond']; 



	echo "<span > Maak een keuze :<br> ";
  if ($keuze =='0') {
      echo "<input type='radio' name='toernooi_zichtbaar' value = '0' checked/> Alle kalenders ";
      echo "<input type='radio' name='toernooi_zichtbaar' value = '1'        />Kalender van ".$bond;
      echo "<br><input type='radio' name='toernooi_zichtbaar' value = '2'        />Kalender van de vereniging"; 
      echo "<input type='radio' name='toernooi_zichtbaar' value = '3'        />Geen kalender";
  }
   
  if ($keuze =='1') {
      echo "<input type='radio' name='toernooi_zichtbaar' value = '0'         /> Alle kalenders ";
      echo "<input type='radio' name='toernooi_zichtbaar' value = '1' checked />Kalender van ".$bond;
      echo "<br><input type='radio' name='toernooi_zichtbaar' value = '2'        />Kalender van de vereniging";
      echo "<input type='radio' name='toernooi_zichtbaar' value = '3'         />Geen kalender";
  }

  if ($keuze =='2') {
      echo "<input type='radio' name='toernooi_zichtbaar' value = '0'         /> Alle kalenders ";
      echo "<input type='radio' name='toernooi_zichtbaar' value = '1'         />Kalender van ".$bond;
      echo "<br><input type='radio' name='toernooi_zichtbaar' value = '2'  checked      />Kalender van de vereniging"; 
      echo "<input type='radio' name='toernooi_zichtbaar' value = '3'         />Geen kalender";
  }
  if ($keuze =='3') {
      echo "<input type='radio' name='toernooi_zichtbaar' value = '0'         /> Alle kalenders ";
      echo "<input type='radio' name='toernooi_zichtbaar' value = '1'         />Kalender van ".$bond;
      echo "<br><input type='radio' name='toernooi_zichtbaar' value = '2'        />Kalender van de vereniging";  
      echo "<input type='radio' name='toernooi_zichtbaar' value = '3'  checked       />Geen kalender";
  }
  ?>
</span></td>
  <?php
 
 switch ($keuze) { 
 	  case "0": ?>  	
 	       <td class='content' colspan=  3>Toernooi is zichtbaar op de OnTip kalender.</td><?php ; break;
 	  case "1": ?>  	
 	       <td class='content' colspan=  3>Toernooi is alleen zichtbaar op de OnTip kalender voor <?php echo $bond;?></td><?php ; break;
 	  case "2": ?>  	
 	       <td class='content' colspan=  3>Toernooi is alleen zichtbaar op de OnTip vereniging kalender.</td><?php ; break;
 	  case "3": ?>  	
 	       <td class='content' colspan=  3>Toernooi is op geen enkele kalender zichbaar.</td><?php ; break;
 }
 
  ?>
</tr>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Voucher code

// aangepast 7 dec 2017

$variabele = 'voucher_code_invoeren_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 $parameter            = explode('#', $result['Parameters']);
 $richting             = $parameter[0];
 $per_inschrijving_jn  = $parameter[1];   /// bij uitgaande voucher 1 voucher of 1 per persoon


 if ($keuze == ''){
 	  $keuze = 'N';
 }

 if ($richting == ''){
 	  $richting = 'In';
 }

 ?> 
 <tr>
   <td class='varname'>Voucher code gebruik</td><td style='text-align:center;background-color:#00288a;'>
 <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('voucher', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a> 
   <td class='content' colspan=  1>
<?php 
	echo "<span > Maak een keuze : ";
if ($keuze =='J') {
      echo "<input type='radio' name='voucher_code_invoeren_jn' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='voucher_code_invoeren_jn' value = 'N'/> Nee.";  	
    }
   else {
     	echo "<input type='radio' name='voucher_code_invoeren_jn' value = 'J' /> Ja ";
      echo "<input type='radio' name='voucher_code_invoeren_jn' value = 'N' checked/> Nee.   ";  	
 	}  ?>
</span></td>
<?php 
if ($keuze =='J'){?>
   <td class='content' colspan=  2>
<?php 
	echo "<span > Richting:<br>";
if ($richting =='In') {
      echo "<input type='radio' name='voucher_code_richting' value = 'In' checked/> Ingaand ";
      echo "<input type='radio' name='voucher_code_richting' value = 'Uit'/> Uitgaand.";  	
    }
   else {
     	echo "<input type='radio' name='voucher_code_richting' value = 'In' /> Ingaand ";
      echo "<input type='radio' name='voucher_code_richting' value = 'Uit' checked/> Uitgaand.   ";  	
 	}  ?>
 	</span>
   <td class='content' colspan=  1> 	
 	<?php 
 	if ($richting == 'Uit'){
	echo "<span > Aantal vouchers ingeval uitgaand):<br> ";
if ($per_inschrijving_jn  =='J') {
      echo "<input type='radio' name='per_inschrijving_jn' value = 'J' checked/> 1 per inschrijving. ";
      echo "<input type='radio' name='per_inschrijving_jn' value = 'N'/> 1 per persoon.";  	
    }
   else {
     	echo "<input type='radio' name='per_inschrijving_jn' value = 'J' /> 1 per inschrijving. ";
      echo "<input type='radio' name='per_inschrijving_jn' value = 'N' checked/> 1 per persoon.   ";  	
 	}
}  ?>
</span>
</td>
   
  <?php
} else {?>
 	       <td class='content' colspan=  3>Er kan geen Voucher code worden ingevoerd of toegekend.</td>
<?php }
 
  ?>
</tr>

 <tr>
 <!-----------------------------------   Keuze wedstrijd schema 	31 jul 2017 -----------------------------//---->
 <td class='varname'>Wedstrijd schema</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('wedstrijd_schema', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<?php

$variabele = 'wedstrijd_schema';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Parameters'];
 $count     = mysqli_num_rows($qry1);
 $schema_sel = "Geen wedstrijdschema geselecteerd."; 
 
 
if ($count == 0) {
	 $keuze = 'N'; 
	 
	 echo "<input type = 'hidden' name = 'wedstrijd_schema' value ='Geen wedstrijdschema geselecteerd.'>";
	}	 else {
		$qry_schema_sel     = mysqli_query($con,"SELECT * From wedstrijd_systemen  where Code = '".$result['Waarde']."'  ")     or die(' Fout in select wedstrijd schema 1');  
		$result_sel         = mysqli_fetch_array( $qry_schema_sel);
		$schema_sel         = $result_sel['Omschrijving']; 
    $qry_schema         = mysqli_query($con,"SELECT * From wedstrijd_systemen  order by Id ")     or die(' Fout in select wedstrijd schema');   
	}
	if ( $result['Waarde'] =='') { 
		$schema_sel = "Geen wedstrijdschema geselecteerd."; 
	}
	 
  
?>

<td class='content' colspan = 4>


 <span>Maak een selectie  <select name= 'wedstrijd_schema'  STYLE='font-size:10pt;font-family: Courier;width:490px;background-color:white;' >
 	

  <option style='color:black;background:white;' value ='<?php echo $result['Waarde'];?>'  SELECTED>(<?php echo $result['Waarde'];?>) <?php echo $schema_sel;?></option>
 <?php 
 while($row2 = mysqli_fetch_array( $qry_schema )) {
 ?>
   <option style='color:black;background:white;' value ='<?php echo $row2['Code'];?>'  >(<?php echo $row2['Code'];?>) <?php echo $row2['Omschrijving'];?></option>
 <?php
 }
 ?>
   <option style='color:black;background:white;' value =''  >Geen wedstrijdschema geselecteerd</option>
 echo "</select></td>";
 
?>
 
</tr>

 


<!--- einde instellingen ------------------------------////----> 
</table>

Op de Tab 'Uitleg' kunt u vinden waar welke instelling te vinden is.
</blockquote>
<br>

<span style='color:black;'>Door te klikken op het <img src='../ontip/images/info.jpg' border = 0 width=18>  plaatje krijgt u meer informatie.</span>

<center><INPUT type='submit' value='Wijzigen bevestigen' name = 'myForm1' style='background-color:red;color:white;position:relative;top:-50px;'></center>
    
    
<!--- einde div Toernooi ------////---->
</div>

<!--- start div Formulier ------////---->

<div id="Formulier"  style="display:none;padding-left:20pt;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;" class="tabcontent"  >

 
 <br>
  	 <table width=100%>
   	<tr><td style='vertical-align:bottom;color:black;font-size:9pt;font-family:arial;'>Deze tab bevat de instellingen die betrekking hebben op het formulier.</td>
  </tr>
</table>
   <center><INPUT type='submit' value='Wijzigen bevestigen' name = 'myForm2' style='background-color:red;color:white;position:relative;top:-30px;'></center><br><br>

<!-- inspringen en breedte   21 nov 2016 ---->
<blockquote>
<table border = 2 id='myTable2' class = 'config' width=95% style= 'border:1px solid #000000;box-shadow: 8px 8px 8px #888888;;padding:15pt;position:relative;top:-40px;'>
<?php
$screen = 'Formulier';
/// Detail regels

////// Toernooi (niet aan te passen)
 echo "<tr>"; 
 echo "<td class='varname_k'  width=20%>Toernooi</td><td class='info_k'></td>";
 echo "<td class='content_k'  colspan = 4 >".$toernooi."</td></tr>";
 ?>
 </tr>
 <?php
 ////// Datum (niet aan te passen)
 $variabele = 'datum';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 
 /* Set locale to Dutch */
 setlocale(LC_ALL, 'nl_NL');
 $datum =   $result['Waarde'];
 $dag   = 	substr ($datum , 8,2); 
 $maand = 	substr ($datum , 5,2); 
 $jaar  = 	substr ($datum , 0,4); 
 ?>
 <tr>
  <td class='varname_k'>Datum</td><td class='info_k'>
  	
  <td class='content_k' colspan= 4><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ); ?></td>
 </tr>

<?php
//// Toernooi voluit
 $variabele = 'toernooi_voluit';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 ?>
 
 <tr>
 <td class='varname'>Volledige naam toernooi op formulier en lijsten</td><td style='text-align:center;background-color:#00288a;'>
  <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('toernooi_voluit', event)">
           	<img src='../ontip/images/info.jpg' border = 0 width=20></a></td></td>
 <?php
 echo "<td class='content' colspan = 4 >";
 echo "<input name= 'Waarde-";
 echo $result['Id'];
 echo "' type='text' size='100'  value ='";
 echo $result['Waarde'];
 echo "'>  </td>"; 
?>
</tr>

<?php
//// Afbeelding en grootte
 $variabele  = 'url_afbeelding';
 $qry1       = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result     = mysqli_fetch_array( $qry1);
 $id         = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);


//  Nieuw 12-10-2013  Via parameter

if ( $parameter[1] != '') { 
   $plaats_afb  = $parameter[1];
}

// 12 dec 2014 zowel breedte als hoogte voor afbeelding. Default wordt via PHP de grootte bepaald (in muteer_ontip.php)

$afb_width   = 0;
$afb_height  = 0;

if (isset($parameter[2]) ){ 
   if ( $parameter[2] != '' )  { 
      $afb_width  = $parameter[2];
   }
}

if (isset($parameter[3]) ){ 
    if ( $parameter[3] != '' ) { 
       $afb_height  = $parameter[3];
   }
}


?>
 <tr>
 <td class='varname'>Afbeelding</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('image', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  1>
<?php
echo "<input name= 'Waarde-";
echo $id;
echo "' type='text' size='50'  value ='"; 
echo $url_afbeelding."' >";
  
echo "<br>Selecteer afbeelding in Image Gallery</td><td class='content' colspan=  1><span style='font-size:9pt;'> Positie :<br>";
     if ($plaats_afb =='l') {
     	    echo "<input type='radio' name= 'positie' value = 'links' checked/>Links ";
     	    echo "<input type='radio' name= 'positie' value = 'rechts'/>Rechts ";  	
     	  }
     	  else {
     	   	echo "<input type='radio' name= 'positie' value = 'links' />Links ";
     	    echo "<input type='radio' name= 'positie' value = 'rechts' checked/>Rechts ";  	
     	}
     	
     echo "</td><td class='content' colspan= 1 style='font-size:9pt;'>";
     
     // ophalen waarde voor afbeelding grootte

     $variabele = 'afbeelding_grootte'; 
     $qry1      =  mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele."'")     or die(' Fout in select');  
     $result    = mysqli_fetch_array( $qry1);
     $afbeelding_grootte = $result['Waarde'];
     
    if ($afb_width  > 0){
     echo "<table><tr><td style='color:black;font-size:9pt;font-weight:bold;'>Breedte :</td><td style='color:black;font-size:8pt;font-weight:bold;'><input  name= 'afbeelding_width'  size='3'  value ='".$afb_width."' > px.</td></tr>   ";
     echo "<tr><td style='color:black;font-size:9pt;font-weight:bold;'>Hoogte  :</td>       <td style='color:black;font-size:8pt;font-weight:bold;'><input  name= 'afbeelding_height' size='3'  value ='".$afb_height."' > px.</td></tr> </table> </td>";
     echo "<td class='content' colspan=  1>"; 
  } else {
     echo "Grootte in pixels <input name= 'Waarde-";
     echo $result['Id'];
     echo "' type='text' size='4'  value ='";
     echo $afbeelding_grootte;
     echo "'></td><td class='content' colspan=  1>"; 
  }
 
     // link naar image_gallery
     
     echo "<center><a href='image_gallery.php?toernooi=".$toernooi."' target='_top' style='color:blue;font-size:8pt;font-weight:bold;'>Klik hier voor image gallery </a>
           <img src='../ontip/images/image_gallery.png' width=30 border =0 ></center> "; 
     echo "</td></tr>";	
 ?>
</tr>

<?php
//// Achtergrond kleur
$variabele = 'achtergrond_kleur';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $achtergrond_kleur = $result1['Waarde'];

$variabele = 'link_kleur';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $link              = $result1['Waarde'];
 $link_onderstreept = $result1['Parameters'];

$variabele = 'tekst_kleur';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $tekstkleur        = $result1['Waarde'];

$variabele = 'koptekst_kleur';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $koptekst_kleur    = $result1['Waarde'];
 
if ($link ==''){
 /// Ophalen tekst kleur nodig voor configuratie item achtergrond_kleur

$qry2        = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$result2     = mysqli_fetch_array( $qry2 );
$tekstkleur = $result2['Tekstkleur'];
$link       = $result2['Link'];
$link_onderstreept = 'N';
}
 
if ($koptekst_kleur ==''){
$koptekst_kleur  ='Red';
}

 ?>
 <tr>
 <td class='varname'>Kleuren</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('kleur', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
		Selecteer kleur uit lijst.
		
		 Achtergrond :
		 <SELECT name='achtergrond_kleur' STYLE='color:<?php echo $tekstkleur;?>;font-size:10pt;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox1" onchange="changeFunc1();">
  	
  	 	
  	  <option style='color:<?php echo $tekstkleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($achtergrond_kleur);?>' selected><?php echo strtoupper($achtergrond_kleur);?></option>
 <?php   
      // ophalen kleurcodes tbv selectie
        $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  

      while($row = mysqli_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT> 

    Tekst :
 	
		<SELECT name='Tekst_kleur' STYLE='font-size:10pt;color:<?php echo $tekstkleur;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox11" onchange="changeFunc11();">
 		<option style='color:<?php echo $tekstkleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($tekst_kleur);?>' selected><?php echo strtoupper($tekst_kleur);?></option>
		<?php
		// ophalen kleurcodes tbv selectie
         $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  

      while($row = mysqli_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT> 
		
  	Link :
  	
   <SELECT name='Link_kleur' STYLE='font-size:10pt;color:<?php echo $link;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox12" onchange="changeFunc12();">
 		<option style='color:<?php echo $link;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($link);?>' selected><?php echo strtoupper($link);?></option>
		<?php
		// ophalen kleurcodes tbv selectie
      $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  

      while($row = mysqli_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT> 
	
  	Koptekst en border :
	<SELECT name='Koptekst_kleur' STYLE='font-size:10pt;color:<?php echo $koptekst_kleur;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox13" onchange="changeFunc13();">
 		<option style='color:<?php echo $koptekst_kleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($koptekst_kleur);?>' selected><?php echo strtoupper($koptekst_kleur);?></option>
		<?php
		// ophalen kleurcodes tbv selectie
      $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  

      while($row = mysqli_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT>&nbsp
 
 <?php
   if ($link_onderstreept == 'J'){?>
   	   <input type ='checkbox'  name = 'Link_onderstreept' value  = 'J' checked> Link onderstreept.
   	 <?php } else { ?>
   	   <input type ='checkbox'  name = 'Link_onderstreept' value  = 'J' > Link onderstreept.
   	 <?php }
   	 ?>  
 
   </td>
</tr>


<?php
//// Achtergrond kleur invulvelden
$variabele = 'achtergrond_kleur_invulvelden';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $id                = $result1['Id'];
 $achtergrond_kleur_input = $result1['Waarde'];

 
 if ($achtergrond_kleur_input =='') {
 	$achtergrond_kleur_input = '#F2F5A9';
 }	
 ?>
  <tr>
 <td class='varname'>Achtergrondkleur invulvelden</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('inputkleur', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
	  
  	Selecteer kleur uit de keuze lijst :

		<SELECT name='achtergrond_kleur_invulvelden' STYLE='font-size:10pt;font-family: Courier;width:90px;background-color:<?php echo $achtergrond_kleur_input;?>'  id="selectBox3" onchange="changeFunc3();">
  	
  	   <option style='color:<?php echo $tekstkleur;?>;background-color:<?php echo $achtergrond_kleur_input;?>' value='<?php echo strtoupper($achtergrond_kleur_input);?>' selected><?php echo strtoupper($achtergrond_kleur_input);?></option>
   <?php
       // ophalen kleurcodes tbv selectie
      $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  

      while($row = mysqli_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT> 
  </td>
</tr>
 
<?php
//// Achtergrond kleur buttons
$variabele = 'achtergrond_kleur_buttons';
 $qry1              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result1           = mysqli_fetch_array( $qry1);
 $id                = $result1['Id'];
 
 if ($id ==''){
 $achtergrond_kleur_verzenden  =  'Red';
 $tekstkleur_verzenden         =  'white';
 $achtergrond_kleur_herstellen =  'Blue';
 $tekstkleur_herstellen        =  'white';

}
else {
 $achtergrond_kleur_button = explode (';', $result1['Waarde']);
 
 $achtergrond_kleur_verzenden   =  $achtergrond_kleur_button[0];
 $tekstkleur_verzenden          =  $achtergrond_kleur_button[1];
 $achtergrond_kleur_herstellen  =  $achtergrond_kleur_button[2];
 $tekstkleur_herstellen         =  $achtergrond_kleur_button[3];
 }
 
 ?>
  <tr>
 <td class='varname'>Achtergrondkleur knoppen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('buttonkleur', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
	  
  	
		Selecteer kleur uit de keuze lijst :

	   <span style= 'border-style:outset 2px;fount-size:12pt;padding:2pt;text-align:center;color:<?php echo $tekstkleur_verzenden;?>;background-color:<?php echo $achtergrond_kleur_verzenden;?>;'   id ='Verzenden'> Verzenden </span>
		

		<SELECT name='kleur_verzenden' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:90px;'  id="selectBox4" onchange="changeFunc4();">
  	selected
  	   <option style='color:<?php echo $tekstkleur_verzenden;?>;background:<?php echo $achtergrond_kleur;?>'  value='<?php echo strtoupper($achtergrond_kleur_verzenden ).";".strtoupper($tekstkleur_verzenden );?>' selected><?php echo strtoupper($achtergrond_kleur_verzenden);?></option>
       <option style='color:black;background:#FFFFFF;' value='#FFFFFF;#000000' >#FFFFFF</option>
       <option style='color:black;background:#CCCCFF;' value='#CCCCFF;#000000' >#CCCCFF</option>
       <option style='color:black;background:#B1B3D9;' value='#B1B3D9;#000000' >#B1B3D9</option>
       <option style='color:white;background:#162A51;' value='#162A51;#FFFFFF' >#162A51</option>
       <option style='color:white;background:#CC0000;' value='#CC0000;#FFFFFF' >#CC0000</option>
       <option style='color:black;background:#BDBDBD;' value='#BDBDBD;#000000' >#BDBDBD</option>
       <option style='color:black;background:#E5E5E5;' value='#E5E5E5;#000000' >#E5E5E5</option>
       <option style='color:white;background:#0000FF;' value='#0000FF;#FFFFFF' >#0000FF</option> 
     </SELECT> 
      
    <span style= 'border-style:outset 2px;fount-size:12pt;padding:2pt;text-align:center;color:<?php echo $tekstkleur_herstellen;?>;background-color:<?php echo $achtergrond_kleur_herstellen;?>;'   id ='Herstellen'> Herstellen </span>
		

		<SELECT name='kleur_herstellen' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:90px;'  id="selectBox5" onchange="changeFunc5();">
  	
  	   <option style='color:<?php echo $tekstkleur_herstellen;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($achtergrond_kleur_herstellen).";".strtoupper($tekstkleur_herstellen);?>' selected><?php echo strtoupper($achtergrond_kleur_herstellen);?></option>
        <option style='color:black;background:#FFFFFF;' value='#FFFFFF;#000000' >#FFFFFF</option>
       <option style='color:black;background:#CCCCFF;' value='#CCCCFF;#000000' >#CCCCFF</option>
       <option style='color:black;background:#B1B3D9;' value='#B1B3D9;#000000' >#B1B3D9</option>
       <option style='color:white;background:#162A51;' value='#162A51;#FFFFFF' >#162A51</option>
       <option style='color:white;background:#CC0000;' value='#CC0000;#FFFFFF' >#CC0000</option>
       <option style='color:black;background:#BDBDBD;' value='#BDBDBD;#000000' >#BDBDBD</option>
       <option style='color:black;background:#E5E5E5;' value='#E5E5E5;#000000' >#E5E5E5</option>
       <option style='color:white;background:#0000FF;' value='#0000FF;#FFFFFF' >#0000FF</option>  
    </SELECT> 
       
  </td>
</tr> 
 

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Banknummer invullen J/N
$variabele = 'bankrekening_invullen_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix    = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }

 ?>
 <tr>
 <td class='varname'>Bankrekening verplicht in te vullen</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('bankrekening', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a> 
</td>
<td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 
 if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Bankrekening is verplicht om in te vullen.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Bankrekening invulveld is niet zichtbaar.</td>
<?php } 
	
echo "</span></td>";
?>
</tr>   

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Boulemaatje gezocht zichtbaar j/n  (niet bij melee (single))

$variabele = 'boulemaatje_gezocht_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")
     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix    = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }
 ?>
 <tr>
 <td class='varname'>Boulemaatje gezocht zichtbaar op formulier</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('boulemaatje_gezocht', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a> 
</td>
<td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 	
if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Opgeven als boulemaatje of reserve speler is mogelijk.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Opgeven als boulemaatje of reserve speler is NIET mogelijk.</td>
<?php } ?>

</tr>
<?php  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// email_organisatie

$variabele = 'email_organisatie';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

 ?>

<tr>
<?php
//// Extra koptekst + lichtkrant
$variabele = 'extra_koptekst';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];

 ?>
 
 <td class='varname'>Extra koptekst</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('extra_koptekst', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  4>
<?php
                /// Eerste positie geeft aan of de extra tekst op de volgende regel moet
               /// % = met. (oude situatie)
            
               $parameter    = explode('#', $result['Parameters']);
               $text_effect  = $parameter[1];
                  
               /// Laatste positie geeft aan of de lichtkrant aan moet
               /// #m = met  , #z = zonder
               /// Als marquee is aan, dan wordt new line ongedaan gemaakt. Oude situatie

               /// Nieuwe situatie 
               /// Laatste positie geeft tekst effect aan 
               /// #n = newline  , #m = marquee , #z = zonder
               /// vanaf 11-10-2013 via parameter
               
               $new_line      =  substr($result['Waarde'],0,1);
               $_text_effect  =  substr($result['Waarde'],-2);
            
               /// conversie van oud naar nieuw
               if ($new_line == '%'){ 
                   $text_effect  =  'n';
               }
                                            
               if ($new_line == '%' ){
               	$extra_koptekst = substr($result['Waarde'],1,strlen($result['Waarde']));
               } 
              else { 
                $extra_koptekst = $result['Waarde'];
              }
              
              if ($_text_effect != '#m' and $_text_effect != '#z' and $_text_effect != '#n'){
                $extra_koptekst = $result['Waarde'];
        //       	$text_effect    = 'z';
               } 
               else { 
               	$extra_koptekst = substr($extra_koptekst,0,strlen($extra_koptekst)-2);
                }
               
             echo "<input  name= 'Waarde-";
             echo $id;
             echo "' type='text' size='120'  value ='";
             echo $extra_koptekst;
             echo "'><br><span >Maak een keuze : ";
	  
	           if ($text_effect == 'n') {
               	    echo "<input type='radio' name='text_effect'  value = 'n' checked/>Op nieuwe regel ";
               	    echo "<input type='radio' name='text_effect'  value = 'm' />Als lichtkrant";  	
               	    echo "<input type='radio' name='text_effect'  value = 'z' />Geen van beiden";  	
              }
             if ($text_effect == 'm') {
               	    echo "<input type='radio' name='text_effect'  value = 'n' />Op nieuwe regel ";
               	    echo "<input type='radio' name='text_effect'  value = 'm' checked/>Als lichtkrant";  	
               	    echo "<input type='radio' name='text_effect'  value = 'z' />Geen van beiden";  	
              }
             if ($text_effect == 'z' or $text_effect == '') {
               	    echo "<input type='radio' name='text_effect'  value = 'n' />Op nieuwe regel ";
               	    echo "<input type='radio' name='text_effect'  value = 'm' />Als lichtkrant";  	
               	    echo "<input type='radio' name='text_effect'  value = 'z' checked/>Geen van beiden";  	
              }
                  	
             	echo "</span></td>";
             	
             	?>
    	</tr>
<tr>
<?php
//// Extra invulveld
$variabele = 'extra_invulveld';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 
 if ($result['Parameters'] !='') {
 $keuze     = explode('#',$result['Parameters']);
 $verplicht_jn  = $keuze[1];
 $lijst_jn      = $keuze[2];
 }
else {
	$verplicht_jn  = 'N';
  $lijst_jn      = 'N';
}
?> 
  
 <td rowspan =2  class='varname'>Extra invulveld</td><td style='text-align:center;background-color:#00288a;' rowspan =2 ><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('extra_invulveld', event)">
 	 <img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  2 rowspan =2>
	<?php
echo "<input  name= 'Waarde-";
echo $id;
echo "' type='text' size='50'  value ='";
echo $result['Waarde'];
echo "'><span><br>Geef hier de omschrijving van het invulveld en kruis evt aan of het een verplicht in te vullen veld is.";           	
?>
</td>
<td class='varname' rowspan = 1>Verplicht

<?php 
	echo "<span > : ";
		
  if ($verplicht_jn =='J') {
      echo "<input type='radio' name='Waarde-verplicht-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-verplicht-".$id."' value = 'N' /> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-verplicht-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-verplicht-".$id."' value = 'N' checked/> Nee ";  	
 	}
echo "</td><td class='varname'>"; 
if ($verplicht_jn =='J'){
	echo "Dit is een verplicht veld";
}
else{
echo "Dit is een optioneel veld";
}
 		
echo "</span></td>";   
?>
</tr>
<tr>
 <td class='varname' rowspan = 1>Tonen op deelnemerslijst :<br>
 <?php 
	echo "<span > ";
  if ($lijst_jn =='J') {
      echo "<input type='radio' name='Op-lijst-1-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Op-lijst-1-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Op-lijst-1-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Op-lijst-1-".$id."' value = 'N' checked/> Nee ";  	
 	}
echo "</td><td class='varname'>"; 
if ($lijst_jn =='J'){
	echo "Getoond op lijst";
}
else{
echo "Niet getoond op lijst";
}
		
echo "</span></td>";   
?>
</tr>


<tr>
<?php
//// Extra vraag
$variabele = 'extra_vraag';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = explode('#',$result['Parameters']);
 $lijst_jn = $keuze[1];
 
 if ($lijst_jn  == ''){ 
 	 $lijst_jn ='N';
 }	
 ?>
 
 <td class='varname'>Extra vraag</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('extra', event)">
 	 <img src='../ontip/images/info.jpg' border = 0 width=20></a>
</td>
<td class='content' colspan=  2>
	<?php
echo "<input  name= 'Waarde-";
echo $id;
echo "' type='text' size='100'  value ='";
echo $result['Waarde'];
echo "'><span><br>Dit is altijd een verplicht veld<br>(Vraag;antwoord 1;antwoord 2;antwoord 3 (max 5 antwoorden) * bij standaard keuze";           	
?>
</td>
<td class='varname' rowspan = 1>Tonen op deelnemerslijst :<br>
 <?php 
	echo "<span >";
  if ($lijst_jn =='J') {
      echo "<input type='radio' name='Op-lijst-2-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Op-lijst-2-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Op-lijst-2-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Op-lijst-2-".$id."' value = 'N' checked/> Nee ";  	
 	}
echo "</td><td class='varname'>"; 
if ($lijst_jn  =='J'){
	echo "Getoond op lijst";
}
else{
echo "Niet getoond op lijst";
}
		
echo "</span></td>";   
?>

</tr>
<tr>
<?php
//// Font text
$variabele = 'font_koptekst';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 
 $font_koptekst     = $result['Waarde'];
 $koptekst_kleur    = $result['Parameters'];
 
 /*
 if ($koptekst_kleur =='') {
 	$koptekst_kleur = 'Red';
 }	
 */
 
  
 ?>
 
 <td class='varname'>Font koptekst formulier</td><td style='text-align:center;background-color:#00288a;'>
  <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('font_koptekst', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
</td>
<td class='content' colspan=  2>&nbsp&nbspSelecteer een font of laat leeg.&nbsp
<?php
 echo "<select name='Waarde-";
 echo $id;
 echo "' STYLE='font-size:10pt;width:350px;'>";
 echo "<option value='".$font_koptekst."' selected>".$font_koptekst."</option>"; 
           
  $i=0; 
   while($row = mysqli_fetch_array( $fonts )) {
 	   	echo "<OPTION  value='".$row['Font_family']."'>";
      echo $row['Font_family'];
      echo "</OPTION>";	
     $i++;
    } 
    ?>
  </SELECT>
  
  
  <?php 
  echo"<span Style='padding: 5pt;font-size:8pt;'></span><span Style='font-family:".$font_koptekst.";color:black;'>";
  echo "<td class='content' Style='font-family:".$font_koptekst.";font-size:8.0pt;' colspan=  2><center> Dit is tekst met gekozen font ".$font_koptekst.".</span></center";        
  echo "</td>";

?>
</tr>

<?php
///// Klok zichtbaar  J/N
 
$variabele = 'klok_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix    = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 }
 ?>
 <tr>
 <td class='varname'>Klok zichtbaar op formulier</td><td style='text-align:center;background-color:#00288a;'></td>
 
<td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}

if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Klok is zichtbaar op het formulier.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Klok is NIET zichtbaar op het formulier</td>
<?php } 
 		
echo "</span></td>";
?>
</tr>

<?php
//// Link naar lijst zichtbaar J/N
$variabele = 'link_lijst_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $keuze     = $result['Waarde'];
 $id        = $result['Id'];
 
 if ($keuze ==''){
 	$keuze = 'J';
}
 
 ?>
 <tr>
   <td class='varname'>Lijst inschrijvingen toegankelijk voor deelnemers</td><td style='text-align:center;background-color:#00288a;'>
   	<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('lijst_zichtbaar', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a>
  </td>
   <td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze == 'J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 if ($keuze == 'J') { ?>
    </span></td><td class='content' colspan=  3>Deelnemerslijst is zichtbaar voor deelnemers.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Deelnemerslijst is NIET zichtbaar voor deelnemers.</td>
<?php } 
		
echo "</span></td>";
?>
</tr>

<?php
//// Website link zichtbaar J/N
$variabele = 'website_link_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 
 if ($keuze ==''){
 	$keuze = 'J';
 }

 ?>
 <tr>
   <td class='varname'>Link website zichtbaar op formulier</td><td style='text-align:center;background-color:#00288a;'>
   	<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('website_link', event)">
 	 <img src='../ontip/images/info.jpg' border = 0 width=20></a>
    	</td>
   <td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Link website is zichtbaar op het formulier.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Link website is NIET zichtbaar op het formulier</td>
<?php } 
		
echo "</span></td>";
?>
</tr>
<?php
//// Logo zichtbaar J/N

 
$variabele = 'url_logo';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $_url_logo  = $result['Waarde'];
 $param      = $result['Parameters'];
 
 if ($param ==''){
   $qry1           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select');  
   $result1        = mysqli_fetch_array( $qry1);
   $grootte_logo   = $result1['Grootte_logo'];
}	
else { 
	 $grootte_logo   = $result['Parameters'];
}	
 
 if ($_url_logo == '' ){
 	   $_url_logo = basename($url_logo);
 }
 	  
 if ($_url_logo == basename($url_logo) ){	  
 	   $_url_logo = '';
 	}   
 	   
 
 
 
 ?>
<tr>
   <td class='varname'>Logo op formulier</td><td style='text-align:center;background-color:#00288a;'>
   	 	<a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('logo', event)">
 	 <img src='../ontip/images/info.jpg' border = 0 width=20></a></td>
      <td class='content' colspan=  1>
      	
  <?php 
  $dir = "images";
  ?>
  
  Alternatief bestand : 
  
  
  <select name='url_logo' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:200px;'>
  	<option value='<?php echo $_url_logo; ?>' selected><?php echo $_url_logo; ?></option>
    <option value='' >Normaal logobestand</option>	
  	
  	<?php
 
$j=1; 
if ($handle = @opendir($dir)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
   
         
         if (strlen($file) > 3    and (strtoupper($ext) == 'JPG'  or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG')) {
            ?>  
                 <option value='<?php echo $file; ?>' ><?php echo $file; ?></option>
         <?php
           }
  	          
         }// end if strln
  $j++;
  }// end while
  ?>	
  	</SELECT>

      	
      	
      </td>
      <td class='content' colspan= 1>Grootte alt logo : <input name= 'grootte_logo' type='text' size='10'  value ='<?php echo $grootte_logo ;?>'/></td>
   <td class='content' colspan=  1>

<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$variabele = 'logo_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 
	echo "<span >Zichtbaar  : <br>";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  1>Logo is zichtbaar op het formulier.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  1>Logo is NIET zichtbaar op het formulier</td>
<?php } 
		
echo "</span></td>";
?>
</tr>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////Selectie toernooien zichtbaar

$variabele = 'toernooi_selectie_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];

 if ($keuze ==''){
 	$keuze = 'J';
 }

 ?>
 <tr>
   <td class='varname'>Toernooi selectie zichtbaar op formulier</td><td style='text-align:center;background-color:#00288a;'>
 <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('toernooi_selectie', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a> 
   <td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Toernooi selectie is zichtbaar op het formulier.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Toernooi selectie  is NIET zichtbaar op het formulier</td>
<?php } 
		
echo "</span></td>";
?>
</tr>


<?php
///// Vereniging selectie zichtbaar  J/N
$variabele = 'vereniging_selectie_zichtbaar_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count      = mysqli_num_rows($qry1);
 
if ($count == 0) {
	 $query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) 
	                 VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."',  'vereniging_selectie_zichtbaar_jn','J', now() ) ";
    mysqli_query($con,$query) or die ('Fout in insert vereniging selectie');  
    $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 }
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $suffix    = substr($variabele,-2,2);
 if ($suffix == 'jn'){
  	 $keuze   = $result['Waarde'];
 } 
 
 ?>
 <tr>
 <td class='varname'>Vereniging selectie zichtbaar op formulier</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('vereniging_selectie', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20>
  </a></td>
 
<td class='content' colspan=  1>

<?php 
	echo "<span > Maak een keuze : ";
  if ($keuze =='J') {
      echo "<input type='radio' name='Waarde-".$id."' value = 'J' checked/> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N'/> Nee";  	
    }
   else {
     	echo "<input type='radio' name='Waarde-".$id."' value = 'J' /> Ja ";
      echo "<input type='radio' name='Waarde-".$id."' value = 'N' checked/> Nee ";  	
 	}
 
  if ($keuze =='J') { ?>
    </span></td><td class='content' colspan=  3>Selectie vereniging is zichtbaar op het formulier.</td>
<?php } else { ?>
    </span></td><td class='content' colspan=  3>Selectie vereniging is NIET zichtbaar op het formulier</td>
<?php } 

		
echo "</span></td>";
?>
</tr>
</table>
<br>
Op de Tab 'Uitleg' kunt u vinden waar welke instelling te vinden is.
</blockquote>
<br>
<span style='color:black;'>Door te klikken op het <img src='../ontip/images/info.jpg' border = 0 width=18>  plaatje krijgt u meer informatie.</span>
<br><br>
 <center><INPUT type='submit' value='Wijzigen bevestigen'  name = 'myForm2' style='background-color:red;color:white;'></center>
</FORM>   
    
<!--- einde div Toernooi ------////---->
</div>

<div id="Algemeen"  style="display:none;padding-left:20px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;"   class="tabcontent"   >

<?php
 $screen = 'Algemeen';
 $qry1                   = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     or die(' Fout in select');  
 $result1                = mysqli_fetch_array( $qry1);
 $prog_url               = $result1['Prog_url'];
 $partner_id             = $result1['Ideal_partner_id'];
 $sortering_korte_lijst  = $result1['Lijst_sortering'];
 $indexpagina_kop_jn     = $result1['Indexpagina_kop_jn'];
 $indexpagina_achtergrond_kleur  = $result1['Indexpagina_achtergrond_kleur']; 
 
 $qry2  
                 = mysqli_query($con,"SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select ip check');  
 $result2               = mysqli_fetch_array( $qry2);
  
 
 /// Koptekst  toernooi_all.php aan (J) of uit (N)
 if ($indexpagina_kop_jn == ''){ $indexpagina_kop_jn = 'J';  }   

//sortering verkorte lijst 
 if ($sortering_korte_lijst == '') {
     $sortering_korte_lijst = 'ASC';
}  

 ?>
  <br>
   <table width=100%>
   	<tr><td style='vertical-align:bottom;color:black;font-size:9pt;font-family:arial;'>Deze tab bevat de algemene OnTip instellingen die voor alle toernooien gelden.Hier wijzigen betekent dat het voor alle toernooien wijzigt.<br>Wees hier voorzichtig mee. Benader de OnTip beheerder als je ergens over twijfelt.</td>
  </tr>
</table>

   <FORM action='muteer_vereniging.php' method='post' name = 'myForm3'>
 	
 	<br><br>
 <center><INPUT type='submit' value='Wijzigen bevestigen'  name = 'myForm2' style='background-color:red;color:white;position:relative;top:-30px;'></center>
    <br><br>

  <input type= 'hidden' name = 'vereniging_id'  value = '<?php echo $vereniging_id; ?>'/>
  <input type= 'hidden' name = 'naam'           value = '<?php echo $_COOKIE['user']; ?>'/>
  <input type= 'hidden' name = 'toernooi'       value = '<?php echo $toernooi; ?>'/>

<!--- blockquote 21 nov -----> 
<blockquote>
<table border = 2 id='myTable1' class = 'config' width=95% style= 'border:1px solid #000000;box-shadow: 8px 8px 8px #888888;;padding:15pt;position:relative;top:-40px;'>
<?php 
  ////// Vereniging (niet aan te passen)
 
 echo "<tr>"; 
 echo "<td class='varname_k'  width=20%>Vereniging</td><td class='info_k'></td>";
 echo "<td class='content_k'  colspan = 2 >".$vereniging."</td><td class='content_k'  colspan = 2 > NJBB verenigingsnr : ".$vereniging_nr.".</td></tr>";
 echo "<tr>"; 
 echo "<td class='varname_k'>Home folder OnTip</td><td class='info_k'></td>";
 
 if ($partner_id !='') {
     echo "<td class='content_k'  colspan = 2 >".$prog_url."</td>";
     echo "<td class='content_k'  colspan = 1 >IDEAL partner id : ".$partner_id."</td></tr>";
  } else { 
 	   echo "<td class='content_k'  colspan = 3 >".$prog_url."</td></tr>";
 }
 
 ?>
 <tr>
  <td class='varname_k'>Naam beheerder</td><td class='info_k'></td>
  <td class='content_k' colspan= 4><?php echo $result2['Naam'];?></td>
 </tr>
 
 
<tr>
  <td class='varname'>Plaats</td><td style='text-align:center;background-color:#00288a;'></td>
  <td class='content' colspan= 4><input name= 'plaats' type='text' size='100'  value ='<?php echo $result1['Plaats'];?>'/></td>
 </tr>
 
 <tr>
  <td class='varname'>Website vereniging </td><td style='text-align:center;background-color:#00288a;'></td>
  <td class='content' colspan= 2><input name= 'url_website' type='text' size='100'  value ='<?php echo $result1['Url_website'];?>'/></td>
  <td class='content'>Formaat moet zijn :  http:&#47&#47www.xxxxxx.nl&#47</td>
 </tr>

<tr>
  <td class='varname'>Email adres verzender noreply</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('email_noreply', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></td>
  <td class='content' colspan= 2><input name= 'email_noreply' type='text' size='100'  value ='<?php echo $result1['Email_noreply'];?>'/></td>
  <td class='content' colspan= 2>Email adres moet ingevuld zijn ivm wijzigen wachtwoord e.d </td>
 </tr>

<tr>
  <td class='varname'>Naam contactpersoon</td><td style='text-align:center;background-color:#00288a;'></td>
  <td class='content' colspan= 1><input name= 'volledige_naam' type='text' size='50'  value ='<?php echo $result1['Naam_contactpersoon'];?>'/></td>
  <td class='content'>Email adres<br>Tel.nummer</td>
  <td class='content' colspan= 1>
  	<input name= 'email'               type='text' size='50'  value ='<?php echo $result1['Email'];?>'/><br>
  	<input name= 'tel_contactpersoon'  type='text' size='50'  value ='<?php echo $result1['Tel_contactpersoon'];?>'/><br>
 	</td>
</tr>
<tr>
  <td class='varname'>Privacy verklaring tekst (max 500 tekens)</td><td style='text-align:center;background-color:#00288a;'></td>
  <td class='content' colspan= 4><textarea name='privacy_tekst' onfocus="change(this,'black','lightblue');" style='background-color:white;' onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','white');" rows='4' cols='75' onclick="make_blank();"><?php echo $result1['Privacy_tekst'];?>
                </textarea></td>
 </tr>
 
 
<tr>
  <td class='varname'>Volledige bestandsnaam logo</td><td style='text-align:center;background-color:#00288a;'></td>
  <td class='content' colspan= 1><input name= 'url_logo' type='text' size='100'  value ='<?php echo $result1['Url_logo'];?>'/></td>
  <td class='content'>Grootte logo (pixels)</td>
  <td class='content' colspan= 1><input name= 'grootte_logo' type='text' size='10'  value ='<?php echo $result1['Grootte_logo'];?>'/></td>
</tr>

<tr>
  <td class='varname'>Bank rekening nr mbt licentie</td>
  <td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('licentie_ontip', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></td>
  <td class='content' colspan= 1 style='font-family:courier new;'>
  	<?php
//  	NL15INGB00007460505
//    0123456789012345678
   
     $iban = $result1['Vereniging_IBAN'];
     $mask = substr($iban,0,2)."***************".substr($iban,16,2);
     
   	
  		echo $mask;?>
   </td>
  <td class='content' colspan= 1>Datum afloop licentie </td>
  <td class='content'>
  	<?php
  		echo $result1['Datum_verloop_licentie'];?>
   </td>
</tr>


<tr>
  <td class='varname'>Max aantal sms berichten</td>
  <td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('sms', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></td>
  <td class='content' colspan= 1>
  	<?php if ($naam  =='Erik'){ ?>
    	<input name= 'max_aantal_sms' type='text' size='10'  value ='<?php echo $result1['Max_aantal_sms'];?>'/><em>Alleen aan te passen door OnTip beheerder</em></td>
  	<?php } else {  
  		echo $result1['Max_aantal_sms'];?>
  	</td>
  <?php } ?>
   </td>
 <td class='content' colspan= 2>
 	<?php 
 	$qry  = mysqli_query($con,"SELECT count(*) as Aantal From sms_confirmations where Vereniging  = '".$vereniging."' ")     or die(' Fout in select');  
  $row  = mysqli_fetch_array( $qry );
  $sms_aantal  = $row['Aantal'];
  ?>
  Er zijn nu <?php echo $sms_aantal; ?> berichten gelogd.
   
 </td>
 </tr>

<tr><td class='varname'>Aan- of uitschakelen koptekst</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('koptekst', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></td>
 <td class='content' colspan= 1>
 	<?php 
 	if ($indexpagina_kop_jn =='J') { ?>
 	 <input type='radio' name='indexpagina_kop_jn' value = 'Ja' checked /> Aan
   <input type='radio' name='indexpagina_kop_jn' value = 'Nee'  /> Uit
  <?php } else { ?>
 	 <input type='radio' name='indexpagina_kop_jn' value = 'Ja' /> Aan
   <input type='radio' name='indexpagina_kop_jn' value = 'Nee' checked /> Uit
  <?php } ?>
   
 </td>
 <td class='varname' colspan=2>
 	 <?php
 	 
 	  if ($indexpagina_kop_jn =='J') {
 	 	     echo "De koptekst op de overzichtspagina van de eigen toernooien is ingeschakeld (zichtbaar).";
 	  }
 	  else {
 	  	  echo "De koptekst op de overzichtspagina van de eigen toernooien is uitgeschakeld (onzichtbaar).";
 	  }
 	  ?>	
 	</td>
</tr>


 <tr><td class='varname'>Sortering inschrijvingen lijst</td><td style='text-align:center;background-color:#00288a;'><a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class=popupLink onclick="return !showPopup('sortering', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></td>
 <td class='content' colspan= 1>
 	<?php 
 	
if ($sortering_korte_lijst  == 'ASC') { ?>
 	 <input type='radio' name='lijst_sortering' value = 'ASC' checked /> Oudste inschrijving bovenaan
   <input type='radio' name='lijst_sortering' value = 'DESC'  /> Nieuwste inschrijving bovenaan
  <?php } else { ?>
 	 <input type='radio' name='lijst_sortering' value = 'ASC' /> Oudste inschrijving bovenaan
   <input type='radio' name='lijst_sortering' value = 'DESC' checked /> Nieuwste inschrijving bovenaan
<?php } ?>
   
 </td>
 <td class='varname' colspan=2>
 	 <?php
 	 
 	  if ($sortering_korte_lijst =='ASC') {
 	 	     echo "Op de deelnemerslijst staan de oudste inschrijvingen bovenaan.";
 	  }
 	  else {
 	  	  echo "Op de deelnemerslijst staan de nieuwste inschrijvingen bovenaan.";
 	  }
 	  ?>	
 	</td>
</tr>
<!--tr><td class='varname' colspan=5 style='height:10px;background-color:#FFCC99'>Hieronder voor wachtwoord wijzigen.</td></tr-->
 
 <tr>
  <td class='varname'>Wachtwoord wijzigen</td><td style='text-align:center;background-color:#00288a;'></td>
   <td class='content' colspan= 1><a href = 'change_password.php?naam=<?php echo $result2['Naam'];?>' target = '_blank'>Klik hier om je wachtwoord te wijzigen.</a>
 </td>
  <td class='content' colspan= 2>Wachtwoord voor gebruiker <?php echo $result2['Naam'];?>.</td>
</tr>

</table>
<br>
Op de Tab 'Uitleg' kunt u vinden waar welke instelling te vinden is.
</blockquote>

<span style='color:black;'>Door te klikken op het <img src='../ontip/images/info.jpg' border = 0 width=18>  plaatje krijgt u meer informatie.</span>
<br><br>
 <center><INPUT type='submit' value='Wijzigen bevestigen'  name = 'myForm2' style='background-color:red;color:white;position:relative;top:-40px;'></center>
</FORM>   

<!--- einde div algemeen ------////---->
</div>
<?php
$pageName = basename($_SERVER['SCRIPT_NAME']);
?>

<div id="Inschrijf_form"  style="display:none;padding:left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;" class="tabcontent"   >

                	 	<br>
     	<center>
        	<table width=100%   border =0 >
        		<tr><td width=35%  style='color:black;font-size:10pt;font-family:arial;'>Dit is het actuele inschrijf formulier voor toernooi<br><b><?php echo $toernooi_voluit ?></b>.  </td>
        			<td width=14% style='color:black;font-size:9pt;font-family:arial;padding-right:10pt;text-align:right;'>Klik hiernaast op een van de<br>2 icoontjes voor het inschrijf formulier in de beschikbare formaten.</td>
        	
        			<?php if  (isset($_GET['format']) and $_GET['format']  =='smal'){ ?>
        			<td width=3%  style='border:2px solid red;' onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '2px solid red'"><a  style='color:black;font-size:11pt;font-family:arial;' href = "<?php echo $pageName; ?>?tab=4&format=smal"  target ='_self'><img src = '../ontip/images/icon_portrait.png'       width=40></a>   </td><td width=10pt></td>
        			<td width=3% onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'"><a style='color:black;font-size:11pt;font-family:arial;' href = "<?php echo $pageName; ?>?tab=4&format=normal"  target ='_self'><img src = '../ontip/images/icon_landscape.png'     width=50></a>   </td>
             <?php } else { ?>
        			<td width=3%  onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'"><a  style='color:black;font-size:11pt;font-family:arial;' href = "<?php echo $pageName; ?>?tab=4&format=smal"  target ='_self'><img src = '../ontip/images/icon_portrait.png'       width=40></a>   </td><td width=5pt></td>
        			<td width=3% style='border:2px solid red;' onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '2px solid red'"><a style='color:black;font-size:11pt;font-family:arial;' href = "<?php echo $pageName; ?>?tab=4&format=normal"  target ='_self'><img src = '../ontip/images/icon_landscape.png'     width=50></a>   </td>
             <?php } ?>

              <td width=40% style='color:black;font-size:9pt;font-family:arial;padding-left:10pt;text-align:right;'>Het plaatje rechts opent het formulier in<br>full screen in het gekozen formaat.</td>

        			<?php if  (isset($_GET['format']) and $_GET['format']  =='smal'){ ?>
         			<td onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" width=55pt   style= 'text-align:right;' ><a style='color:black;font-size:11pt;font-family:arial;width:55pt;' href = '<?php echo "inschrijf_form_smal.html?toernooi=".$toernooi; ?>'  target ='_blank'><img src = '../ontip/images/full-screen-icon.png'     width=50></a>   </td>
               <?php } else { ?>
        			<td onmouseover="this.style.border = '1px solid #ffff00'" onmouseout="this.style.border = '0px solid #000000'" width=55pt   style= 'text-align:right;' ><a style='color:black;font-size:11pt;font-family:arial;width:55pt;' href = '<?php echo "inschrijf_form.html?toernooi=".$toernooi; ?>'  target ='_blank'><img src = '../ontip/images/full-screen-icon.png'     width=50></a>   </td>
              <?php } ?>     		
       
        		</tr>
        	</table>  
        </center>	
 
  
  <div style = 'margin-left:45pt;margin-right:45pt;margin-top:15pt;background-color:#c0c0c0;border:1px solid #000000;box-shadow: 8px 8px 8px #888888;;padding:15pt;'>   
    <?php
    $url_hostName = $_SERVER['HTTP_HOST'];
    $part      =  explode ("/", $url_redirect);	
    ?>
   <?php if (isset($_GET['format']) and  $_GET['format']  =='smal') {?>
  	<div style='text-align:center;text-align:center;font-size:10pt; color:black;font-weight;bold;'><?php echo $url_hostName."/".$part[3]."/Inschrijfform.php?simpel&toernooi=".$toernooi; ?></div>
   <?php } else { ?>
  	<div style='text-align:center;text-align:center;font-size:10pt; color:black;font-weight;bold;'><?php echo $url_hostName."/".$part[3]."/Inschrijfform.php?toernooi=".$toernooi; ?></div>
   <?php } ?>     		
  	
  	<br>
  	<center>
  		 <?php
           if (isset($_GET['tab']) and $_GET['tab'] == 4 and $_GET['format']  =='smal') {?>
               <iframe src = '<?php echo "Inschrijfform.php?simpel&toernooi=".$toernooi; ?>' width=600 height=900 /></iframe>
      <?php } else { ?>         
               <iframe src = '<?php echo "Inschrijfform.php?toernooi=".$toernooi; ?>' width=95% height=900 /></iframe>
      <?php }  ?>       
      
    </center>
  </div>

<!--- einde div inschrijf formulier --------------------------------------------------------------------------------------------------////---->
</div>

<div id="Uitleg"  style="display:none;padding:left:10px;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;" class="tabcontent"   >

        <span style='color:black;font-size:9pt;font-family:arial;'>
        	<br>
        	Hier kan je de gegevens van een toernooi inschrijf formulier aanpassen. De gegevens zijn verdeeld over drie tabbladen. Eén voor de toernooi gegevens,één voor de formulier gegevens en één voor algemene gegevens.
        	Door op het tab te klikken wordt deze geopend. Nu is de tab 'Uitleg' geopend.<br>
Een wijziging is direct zichtbaar in het Inschrijf formulier (controleer via link rechtsboven; druk daar evt op F5 voor verversen).
     Na aanbrengen van wijzingen op de knop 'bevestigen' drukken boven of onder aan de Tab 'Toernooi' of 'Formulier'.  
  
  <div style = 'margin-left:45pt;margin-right:45pt;margin-top:15pt;background-color:white;border:1px solid #000000;box-shadow: 8px 8px 8px #888888;;padding:15pt;'>   
    <h3><u>Tab blad Toernooi</u></h3>
     
     <div>
     		<ul>
     			
    <table width=90%> 			
    		<tr>
    		<td width=45%  style='color:black;font-size:9pt;font-family:arial;'>
     			<li> Adres speel locatie
     			<li> Datum en aanvang toernooi
          <li> Email adres organisatie
          <li> Email adres CC
          <li> Email notificaties
     		  <li> Betalen via IDEAL mogelijk (J/N) (evt in TEST MODE) en opslag iDEAL kosten
   				<li> Toernooi gaat wel of niet door J/N en met reden
     			<li> Soort toernooi (tête-a-tête, doublet, triplet, kwintet of sextet)
     			<li> Inschrijven als team of mêlée
     		  <li> Begin inschrijving
     		  <li> Einde inschrijving
          <li> Bestemd voor ( vereniging ) Wel / Niet
     		  <li> Meldtijd  toernooi
     		  <li> Kosten per inschrijving (of per persoon)
       </td>
       <td  style='color:black;font-size:9pt;font-family:arial;'>
     		  <li> Licentie verplicht (J/N)
     		  <li> Minimum aantal inschrijvingen
     		  <li> Maximaal aantal inschrijvingen
     		  <li> Maximaal aantal reserve inschrijvingen (als toernooi vol is)
     		  <li> Prijzen toernooi (tekst)
          <li> Bevestigen inschrijving via SMS mogelijk J/N
    		  <lI> SMS laatste inschrijvingen
   	   	  <li> Toegang tot toernooi : tekst
          <li> Voorlopige bevestiging (J/N). (organisatie bevestigd pas na bijv ontvangst inschrijfgeld). Inclusief vervaltermijn
          <li> Voorlopige bevestiging vanaf xx. (Bij het bereiken van xx inschrijvingen worden de nieuwe inschrijvingen voorlopig bevestigd).
          <li> Toernooi zichtbaar op kalender J/N
          <li> Gebruik van voucher J/N
          <li> Gebruikt wedstrijd schema (selectie)
         </td>  
        </tr>	
      	</table>
      	</ul>
    </div>
 <br>    
      <h3><u>Tab blad Formulier</u></h3>
    	<ul>
   		 <table width=90%> 			
    		<tr>
    		<td width=45%  style='color:black;font-size:9pt;font-family:arial;'>
         <li> Volledige naam toernooi op formulier en lijsten
         <li> Afbeelding: filenaam afbeelding; grootte en positie 
         <li> Achtergrondkleur (selectie)
         <li> Kleur : tekst, link en koptekst (selectie)
         <li> Achtergrondkleur keuze (selectie)
         <li> Achtergrondkleur knoppen
         <li> Bankrekening (verplicht) invullen J/N
         <li> Boulemaatje gezocht zichtbaar J/N
     	   <li> Extra koptekst + lichtkrant
       </td>
       <td  style='color:black;font-size:9pt;font-family:arial;'>
         <li> Extra vraag met antwoorden (eigen invulling)
         <li> Extra invulveld (eigen invulling)
         <li> Font koptekst (selectie)
         <li> Inschrijving beperken tot 1 vereniging of juist niet
         <li> Lijst deelnemers toegankelijk J/N
         <li> Link website zichtbaar op formulier J/N
         <li> Logo zichtbaar op formulier J/N
         <li> Gebruik alternatief logo op formulier (bestandsnaam)
         <li> Toernooi selectie zichtbaar op formulier J/N
         <li> Selectie vereniging zichtbaar op formulier J/N
       </td>  
      </tr>	
      	</table>
       </ul> 	
    
     <h3><u>Tab blad Algemeen</u></h3>
      <div   style= 'font-weight:normal;'>
    	<ul>
         <li> Naam van de vereniging
         <li> url van de website
         <li> Naam van de beheerder , contactpersoon</li>  	
         <li> Email adres beheerder
         <li> Tel nummer contact persoon (t.b.v PDF formulier)
         <li> Url van het gebruikte logo bestand
         <li> Grootte van het logo 
         <li> Max aantal te verzenden sms berichten 
         <li> Aan of uitzetten koptekst overzicht toernooien
       	 <li> Mogelijkheid om wachtwoord te veranderen (link)
      	</ul>
     </div>	
 <br>
<!--- einde div uitleg -----------------------------------------------------------------------------------------////---->
</div>

<br>
</div>

<!--- einde tabcontainer <!--- einde div uitleg------////----------////---->
</DIV>

<!----/// tabcontainer -------------------------------////-->

</body>
</html>