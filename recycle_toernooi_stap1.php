<?php
////  Recycle_toernooi_stap1.php (c) Erik Hendrikx 2012 ev
////
////  Programma voor het aanpassen van een bestaand toernooi. Dit programma is daarin de eerste stap.  Dit programma roept aan recycle_toernooi_stap2.php (via form post)
////  In dit programma worden als input gegeven :
////
////         1. Naam toernooi (korte naam, alleen gebruikt als opslagnaam in tabel config als key)
////         2. Datum toernooi (m.b.v selectie boxen dag, maand en jaar)
////         3. email_organisatie  (default gevuld met waarde uit myvereniging.txt)
////         4. Naam toernooi indien gebrukt wordt gemaakt van ander toernooi als bron (via selectiebox)
////         5. Selectie J/N voor aanmaak QR code inschrijfformulier t.b.v tabel of smartphone
////
////  Vooor het toevoegen van een toernooi heeft de gebruiker rechten nodig voor A(les) of C(onfig).
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////  Programma aanpassingen
////  14-10-2013  Datum toernooi via selectie boxen.
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
?>
<html>
<title>Recycle OnTip Toernooi formulier (c) Erik Hendrikx</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;  font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; }
TD { font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 560; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
         
#aDiv {
color: darkgreen;
background-color: lightgreen;
height: 200px;
}

.alert {background-color:red;}



em {color:red ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>

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

<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<script language="JavaScript">
function setVisibility(id, visibility) {
document.getElementById(id).style.display = visibility;
}

function make_blank_spam()
{
	document.getElementById('respons').value = "";
}

function changeFunc7(challenge) {
    document.myForm.respons.value= challenge;
   }
   
   
function changeDatum(datum) {
   
    var myarr = datum.split(",");
   
    document.getElementById('selectBoxDag').value= myarr[0];
    document.getElementById('selectBoxMaand').value= myarr[1];
    document.getElementById('selectBoxJaar').value= myarr[2];
    document.getElementById('weekdag').value= myarr[3];
   }

function changeDag() {
    var selectBox = document.getElementById("selectBoxDag");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById("datumdag").value= selectedValue;
   }
   
function changeMaand() {
    var selectBox = document.getElementById("selectBoxMaand");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById("datummaand").value= selectedValue;
   }
function changeJaar() {
    var selectBox = document.getElementById("selectBoxJaar");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById("datumjaar").value= selectedValue;
   }

function changeNaam() {
    var selectBox = document.getElementById("selectBoxNaam");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById("Naam").value= selectedValue;
    
    var dag   = selectedValue.substring(1, 4);
    var maand = selectedValue.substring(6, 2);
    var dag   = selectedValue.substring(9, 2);
  
   }
   
  
</script>
   

</head>
<body>
<?php
ob_start();
include 'mysqli.php'; 
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
setlocale(LC_ALL, 'nl_NL');

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

//// Check op rechten
if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

// maak hulptabel leeg

mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 
$today      = date("Y") ."-".  date("m") . "-".  date("d");
$query1 = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Distinct Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum' order by Waarde  )" ;

$query = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum'   group by Vereniging, Toernooi,Waarde   )" ;

mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 

$sql        = "SELECT Distinct config.Id,config.Toernooi,config.Waarde, hulp_toernooi.Datum from config,hulp_toernooi where hulp_config.Vereniging = '".$vereniging."'
              and config.Variabele ='toernooi_voluit' and hulp_toernooi.Toernooi = config.Toernooi  order by hulp_toernooi.Datum  ";
// echo $sql;
$sql        = "SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'                 order by hulp_toernooi.Datum  ";
$namen      = mysqli_query($con,$sql);
?>

<DIV onclick='event.cancelBubble = true;' class=popup id='help'>Uitleg QRC code<br>
 Een QRC code is een soort barcode. In dit vierkantje zit een tekst of een link naar een webpagina verborgen. Met een QRC programma op de smartphone kan hiervan een foto gemaakt worden, waarna de tekst of de webpagina op de smartphine geopend wordt.
<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<DIV onclick='event.cancelBubble = true;' class=popup id='uitleg'><h4>Uitleg recycle toernooi formulier</h4><br>
Met behulp van deze pagina kan een van een al bestaand toernooi het formulier herbruikt worden door alleen het aanpassen van de datums. 
De gegevens van een toernooi worden in het systeem opgeslagen onder een unieke naam (systeemnaam). 
De systeemnaam wordt niet gewijzigd. Wel kunt een nieuwe naam opgeven die wordt afgebeeld op lijsten en het scherm.<br><br>
Voorbeeld; <br>
<Ul>
<li>Systeem naam :  Maandtoernooi_november</li>
<li>Lijst naam   :  Doublet toernooi 15 november <?php echo date("Y");?></li>
</ul>
<br>

Eventueel kan ervoor gekozen worden een<b>  QR barcode </b>te laten aanmaken voor het openen het inschrijfformulier vanaf tablet of smartphone. . Klik op 'í' of lees de handleiding voor meer informatie.<br>
<br><br>

		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</div>


<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;'><a style = 'color:blue;' href='index.php'>Terug naar Hoofdmenu</a></span>
<h3 style='padding:10pt;font-size:20pt;color:green;'>Recycle toernooi <img src='../ontip/images/recycle.jpg' border = 0 width=50/></h3>

<br>
<center>
<div style='border: white inset solid 1px;  text-align: center;'>
<form method = 'post' action='recycle_toernooi_stap2.php' name ='myForm'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<div Style='font-family:arial; color:black;font-size:12pt;font-weight:bold;'>Vul hier de nieuwe gegevens voor een toernooi in   <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('uitleg', event)">
     <span bgcolor ='#006600' style='background-color:#006600; color:yellow;font-size:11pt; padding:2pt;font-family:calibri;' onmouseover="style.backgroundColor='#00FFFF',style.color='black'" onmouseout="style.backgroundColor='#006600',style.color='yellow'" >Uitleg</span> 	</a>
     	<br>
     	 </div><br/><br/>

<blockquote>
<table border =0  width=85%>

<tr>
  <td   STYLE ='font size: 12pt; background-color:white;color:blue ;'>Selecteer bestaand toernooi </td>
  <td   STYLE ='font size: 12pt; background-color:white;color:blue ;'><select name='bron' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:450px;' id="selectBoxNaam" onclick="changeNaam();">
  
<?php

echo "<option value='' selected>Maak een selectie....</option>"; 


$i=0;

 while($row = mysqli_fetch_array( $namen )) {
 	$var = substr($row['Datum'],0,10);
	echo "<OPTION  value=".$row['Toernooi']."><keuze>";
    	  echo $var . " - ". $row['Toernooi'];
    	  echo "</keuze></OPTION>";	
    	  $i++;
} 

?>

</SELECT></label></td></tr>
	
	<tr><td width='250'STYLE ='background-color:white;color:blue;'><label>Naam toernooi op schermen en lijsten </label></th><td STYLE ='background-color:white;color:orange;'><label><input type='text'  name='_toernooi' id='Naam' value= '' size=50/></label></td></tr>

	<tr><td width='250'STYLE ='background-color:white;color:blue;'>Datum toernooi<br><span style='font-size:9pt;color:black;'><i>(gebruik selecties voor dag, maand, jaar)</i></span></span> </th><td STYLE ='background-color:white;color:black;'>
		
		<!--span style='text-align:right;font-size:9pt;border:1 pt solid blue;'>
         	<!input   id= 'datumjaar' size=2>-<input   id= 'datummaand' size=1>-<input   id= 'datumdag' size=1></span--->
		
		  Kies : 
		 <select name='datum_dag'  id= 'datum_dag'  STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:50px;'   id="selectBoxDag" onclick="changeDag();">
     <?php
       
         for ($d=1;$d<=31;$d++){
 	            echo "<option value=".sprintf("%02d",$d).">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
         }
 	   ?>
  </SELECT>
 	
 	<select name='datum_maand'  STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:100px;' id="selectBoxMaand" onclick="changeMaand();">
     <?php
         for ($m=1;$m<=12;$m++){
 	 		     	 echo "<option value=".sprintf("%02d",$m).">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	       }			

     	?>
  </SELECT>

   <select name='datum_jaar'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:60px;' id="selectBoxJaar" onclick="changeJaar();">
        <?php
        $curr_year = date('Y');
        $end_year  = $curr_year+5;
        
         for ($y=$curr_year;$y<=$end_year;$y++){
  			     echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 		    	}
       	?>
   </SELECT>
   <input  id ='weekdag' style ='border:0pt;background-color:white;' >
</td>
		
	 </tr>
	 	
	 <tr><td width='250'STYLE ='background-color:white;color:blue;'>Begin inschrijving<br><span style='font-size:9pt;color:black;'><i>(gebruik selecties voor dag, maand, jaar)</i></span></span> </th><td STYLE ='background-color:white;color:black;'>
		
		<!--span style='text-align:right;font-size:9pt;border:1 pt solid blue;'>
         	<!input   id= 'datumjaar' size=2>-<input   id= 'datummaand' size=1>-<input   id= 'datumdag' size=1></span--->
		
		  Kies : 
		 <select name='begin_datum_dag'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:50px;'   id="selectBoxDag" onclick="changeDag();">
     <?php
       echo "<option value=".date("d") .">".strftime("%d",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
         for ($d=1;$d<=31;$d++){
 	            echo "<option value=".sprintf("%02d",$d).">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
         }
 	   ?>
  </SELECT>
 	
 	<select name='begin_datum_maand'  STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:100px;' id="selectBoxMaand" onclick="changeMaand();">
     <?php
      echo "<option value=".date("m") .">".strftime("%B ",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
         for ($m=1;$m<=12;$m++){
 	 		     	 echo "<option value=".sprintf("%02d",$m).">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	       }			

     	?>
  </SELECT>

   <select name='begin_datum_jaar'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:60px;' id="selectBoxJaar" onclick="changeJaar();">
        <?php
        $curr_year = date('Y');
        
        echo "<option value=".$curr_year.">".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
         
         for ($y=$curr_year;$y<=$end_year;$y++){
  			     echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 		    	}
       	?>
   </SELECT>
   <input  id ='weekdag' style ='border:0pt;background-color:white;' >
</td>
		
	 </tr>
	 
	 
	 <tr><td width='250'STYLE ='background-color:white;color:blue;'>Einde inschrijving<br><span style='font-size:9pt;color:black;'><i>(gebruik selecties voor dag, maand, jaar, uur, minuut)</i></span></span> </th><td STYLE ='background-color:white;color:black;'>
		
		<!--span style='text-align:right;font-size:9pt;border:1 pt solid blue;'>
         	<!input   id= 'datumjaar' size=2>-<input   id= 'datummaand' size=1>-<input   id= 'datumdag' size=1></span--->
		
		  Kies : 
		 <select name='eind_datum_dag'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:50px;'   id="selectBoxDag" onclick="changeDag();">
     <?php
       echo "<option value=".date("d") .">".strftime("%d",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
       
         for ($d=1;$d<=31;$d++){
 	            echo "<option value=".sprintf("%02d",$d).">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
         }
 	   ?>
  </SELECT>
 	
 	<select name='eind_datum_maand'  STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:100px;' id="selectBoxMaand" onclick="changeMaand();">
     <?php
        echo "<option value=".date("m") .">".strftime("%B ",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
        
         for ($m=1;$m<=12;$m++){
 	 		     	 echo "<option value=".sprintf("%02d",$m).">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	       }			

     	?>
  </SELECT>

   <select name='eind_datum_jaar'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:60px;' id="selectBoxJaar" onclick="changeJaar();">
        <?php
        $curr_year = date('Y');
        $end_year  = $curr_year+5;
    echo "<option value=".$curr_year.">".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date("Y")))."</option>";
          
         for ($y=$curr_year;$y<=$end_year;$y++){
  			     echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 		    	}
       	?>
   </SELECT>
  
   Tijd : 
   <select name='eind_datum_uur'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:60px;' id="selectBoxJaar" onclick="changeJaar();">
        <?php
        
    echo "<option value='00'>00</option>";
          
         for ($y=00;$y<=23;$y++){
  			     echo "<option value=".$y.">".sprintf("%02d",$y)."</option>";
 		    	}
       	?>
   </SELECT>
    <select name='eind_datum_min'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:60px;' id="selectBoxJaar" onclick="changeJaar();">
        <?php
        
    echo "<option value='00'>00</option>";
          
         for ($y=00;$y<=59;$y++){
  			     echo "<option value=".$y.">".sprintf("%02d",$y)."</option>";
 		    	}
       	?>
   </SELECT>
   
</td>
	
	 
	 	
	 </tr>

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
	 <td width='250' STYLE ='background-color:white;color:blue;'>Anti Spam </td>
        <td colspan = 2><input TYPE="text" NAME="respons" id= 'respons' SIZE="32" class="pink" onfocus="change(this,'black','lightblue');" onblur="change(this,'black','<?php echo $achtergrond_kleur; ?>');"  style='background-color:<?php echo $achtergrond_kleur; ?>;font-size:9pt;' Value='Typ hier de aangegeven cijfercode' onclick="make_blank_spam();"  >
        	
   <span style='font-size:14pt; color:black;background-color:lightgrey;width:100pt;height:14pt;text-align:center;font-family:courier;padding:5pt;'  id ='challenge' onclick="changeFunc7(<?php echo $string; ?>);"><b><?php echo $string; ?></b></span>
   <?php
  
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";
   ?>     	
	 </td>
	 </tr>		


<tr> 
<td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Aanmaak QRC image voor inschrijfformulier <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('help', event)">
     	<img src='../ontip/images/info.jpg' border = 0 width=20></a></td>
<td><input type='checkbox'  name='qrc_code' value= 'Ja' checked></td></tr>
</table>

<br><br>
<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
</blockquote>
<br></div><br><br>

</div>
</body>
</html>
