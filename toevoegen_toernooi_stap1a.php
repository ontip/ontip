<?php
////  Toevoegen_toernooi_stap1.php (c) Erik Hendrikx 2012 ev
////
////  Programma voor het aanmaken van een nieuw toernooi. Dit programma is daarin de eerste stap.  Dit programma roept aan toevoegen_toernooi_stap2.php (via form post)
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
<title>Toevoegen OnTip Toernooi formulier (c) Erik Hendrikx</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white;  font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white;  font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
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
     
     
function show_uitleg()
{
	
alert("Uitleg QRC code" + '\n' + 
  "Een QRC code is een soort barcode. In dit vierkantje zit een tekst of een link naar een webpagina verborgen. Met een QRC programma op de smartphone kan hiervan een foto gemaakt worden, waarna de tekst of de webpagina op de smartphine geopend wordt."
  )
}
</Script>


<script src="js/utility.js"></script>
<script src="js/popup.js"></script>

<script language="JavaScript">
function setVisibility(id, visibility) {
document.getElementById(id).style.display = visibility;
}

function changeDatum(datum) {
   
    var myarr = datum.split(",");
   
    document.getElementById('datumdag').value= myarr[0];
    document.getElementById('selectBoxDag').value= myarr[0];
    document.getElementById('datummaand').value= myarr[1];
    document.getElementById('selectBoxMaand').value= myarr[1];
    document.getElementById('datumjaar').value= myarr[2];
    document.getElementById('selectBoxJaar').value= myarr[2];
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
   
   
</script>
   

</head>
<body>
<?php
ob_start();
include 'mysql.php'; 
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');


setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

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


//// Check op rechten
if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

// maak hulptabel leeg

mysql_query("Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 
$today      = date("Y") ."-".  date("m") . "-".  date("d");
$query1 = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Distinct Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum' order by Waarde  )" ;

$query = "insert into hulp_toernooi (Toernooi, Vereniging, Datum) 
( select Toernooi, Vereniging, Waarde from config     where Vereniging = '".$vereniging."' and Variabele ='datum' group by Vereniging, Toernooi,Waarde   )" ;

//echo $query. "<br>";
mysql_query($query) or die ('Fout in vullen hulp_toernooi'); 

$sql        = "SELECT Distinct config.Id,config.Toernooi,config.Waarde, hulp_toernooi.Datum from config,hulp_toernooi where hulp_config.Vereniging = '".$vereniging."'
              and config.Variabele ='toernooi_voluit' and hulp_toernooi.Toernooi = config.Toernooi  order by hulp_toernooi.Datum  ";
// echo $sql;
$sql        = "SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'                 order by hulp_toernooi.Datum  ";
$namen      = mysql_query($sql);


 ?>

<DIV onclick='event.cancelBubble = true;' class=popup id='help'>Uitleg QRC code<br>
 Een QRC code is een soort barcode. In dit vierkantje zit een tekst of een link naar een webpagina verborgen. Met een QRC programma op de smartphone kan hiervan een foto gemaakt worden, waarna de tekst of de webpagina op de smartphine geopend wordt.
<br>
		 <a class=closeLink href='#' onclick='hideCurrentPopup(); return false;'><br>[Sluit deze tip]</a>
</DIV>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../boulamis_toernooi/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></span>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Toevoegen toernooi <img src='../boulamis_toernooi/images/plus.png' border = 0 width=50/></h3>

<blockquote>
<fieldset style='border-style:ridge;border:inset 1pt green;width:85%;padding:15pt;font-size:10pt;' id= 'info' >
		<legend style='left-padding:5pt;color:red;font-size:11pt;font-family:verdana;'>Instructie</legend>
		 	<br>

Met behulp van deze pagina kan een nieuw toernooi(formulier) worden aangemaakt. De gegevens van het toernooi worden in het systeem opgeslagen onder een unieke naam (systeemnaam). Geef als naam een duidelijke, korte naam op.<br> 
Deze (systeem)naam wordt gebruikt om de gegevens van een toernooi (formulier en inschrijvingen) aan elkaar te koppelen.<br><br>
<b><font color=blue>Tip : Zet geen jaartal of datum in de naam van toernooien die jaarlijks terugkeren. Dan kan je dit formulier volgend jaar weer gebruiken. </b></font>
<br><br>
<b>Gebruik voor de (systeem)naam van het toernooi geen vreemde tekens (/,\  e met puntjes e.d) en geen spaties.</b> Dit kan problemen geven bij de selectie en het later verwijderen van het toernooi.<br>
Spaties zullen automatisch worden vervangen door underscores ('_'). 
<br>
In de configuratie (via OnTip homepagina, Tab Formulier Keuze Aanpassen formulier) dient na aanmaak van het toernooi<b> de naam die in het scherm </b>verschijnt nog aangepast te worden.<br>
Voor de invoer van de<b> toernooi datum </b>dient de datum (dag, maand en jaar) te worden geselecteerd m.b.v de selecties. Naderhand kan deze evt. nog gewijzigd worden.<br>
<br>
Het <b>Email adres organisatie</b> is het email adres dat dient als verzender van de bevestigings emails naar de inschrijvers. Dit kan je naderhand nog wijzigen in beheer configuratie.<br>
<br>
Normaal wordt voor het aanmaken van een toernooi de standaard configuratie uit <a href ='<?php echo $bron_toernooi; ?>' target= '_blank'>mytoernooi.txt</a> gebruikt.<br>
Maar ook is het mogelijk de gegevens van een ander toernooi te kopieren als <b> bron</b> voor een nieuw toernooi. Het kan zijn dat dit bron toernooi een aantal nieuwe functies nog niet bevat. <br>
Open in dit geval, na aanmaken van het nieuwe toernooi, het nieuw aangemaakte toernooi en klik op 'Opslaan' waarmee eventueel nieuwe functies alsnog worden toegevoegd.<br>
<br>

Eventueel kan ervoor gekozen worden een<b>  QR barcode </b>te laten aanmaken voor het openen het inschrijfformulier vanaf tablet of smartphone. . Klik op 'í' of lees de handleiding voor meer informatie.<br>
<br><br>
</fieldset>
</blockquote>

<br>

<center>
<input type=button name=type value='Toon uitleg'    onclick="setVisibility('info', 'inline');";>
<input type=button name=type value='Verberg uitleg' onclick="setVisibility('info', 'none');";> 
<br>
<div style='border: white inset solid 1px;  text-align: center;'>
<form method = 'post' action='toevoegen_toernooi_stap2.php' name ='myForm'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<div Style='font-family:arial; color:black;font-size:12pt;font-weight:bold;'>Vul hier de gegevens voor een nieuw toernooi in</div><br/><br/>

<blockquote>
<table border =0  width=85%>
	
	<tr><td width='250'STYLE ='background-color:white;color:blue;'>Datum<br><span style='font-size:9pt;color:black;'>(gebruik selecties voor dag, maand, jaar of klik op de datum in de kalender)</span></span> </th><td STYLE ='background-color:white;color:black;'>
		
		<span style='text-align:right;font-size:9pt;border:1 pt solid blue;'>
         	<input name='datum_jaar'  id= 'datumjaar' size=2>-<input name='datum_maand'  id= 'datummaand' size=1>-<input name='datum_dag'  id= 'datumdag' size=1></span>
		
		  Kies : 
		 <select name='datum_dag'    STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:50px;'   id="selectBoxDag" onclick="changeDag();">
     <?php
       
         for ($d=1;$d<=31;$d++){
 	            echo "<option value=".sprintf("%02d",$d).">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
         }
 	   ?>
  </SELECT>
 	
 	<select name='datum_maand'   STYLE='font-size:10pt;background-color:WHITE;font-family: Courier;width:100px;' id="selectBoxMaand" onclick="changeMaand();">
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
</td>
		
	 <td rowspan = 6 style='padding-left:35pt;'>
	 	
	 	<!----    kalender tabel ------------------------------------>
	 	<?php
	 	
      if (isset($_GET['jaar'])){
      	$jaar = 	 	$_GET['jaar'];
      } else {
 		 	 	$jaar    = date('Y');
 		 	}

      if (isset($_GET['maand'])){
      	$maand = 	 	$_GET['maand'];
      } else {
     	 	$maand   = date('m');
 		 	}
 	 	
 		 	 if ($maand < 1){
 		 	 	$maand = 12 ;
 		 	 	$jaar--;
 		 	 }
 		 	 
 		 	 if ($maand >  12){
 		 	 	$maand = 1 ;
 		 	 	$jaar++;
 		 	 }
 		 	 	
 		 	 	$maand_terug   = $maand -1;
 		 	  $maand_verder  = $maand +1;
 		 	 		
 		 	 	
//	 	$maand  = 4;
	 	$dag     = date('d');
	?> 	
	 	
	 	
	 	 	<table border =1 width=100%>
	 		<tr>
	 			<th style='background-color:lightblue;Font-size:8pt;color:black;font-family:verdana;'><a href ='toevoegen_toernooi_stap1.php?jaar=<?php echo $jaar;?>&maand=<?php echo $maand_terug;?>'>Terug<a/></th>
	 			<th style = 'text-align:center;'><?php echo ucfirst(strftime("%B - %Y", mktime(0, 0 , 0, $maand , $dag, $jaar)) ) ; ?></th>
	   		<th style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;text-align:right;'><a href ='toevoegen_toernooi_stap1.php?jaar=<?php echo $jaar;?>&maand=<?php echo $maand_verder;?>'>Verder</a></th>
	 			</tr>
	  </table>
		
		<table border =1 width=100%>
	 		<tr>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Maa</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Din</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Woe</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Don</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Vrij</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Zat</td>
	 			<td style='background-color:lightblue;font-size:8pt;color:black;font-family:verdana;'>Zon</td>
	 		</tr>
	 		<tr></tr>
	 		
	 
	 <?php		
	 	
	  for ($dag=1;$dag< 32 ;$dag++){
	 		$day_number = date ('N' ,mktime(0,0,0,$maand,$dag,$jaar));
	
	  
		     echo "<tr>"; 
	 		   for ($weekdag=1;$weekdag < 8 ;$weekdag++){
	 		
/*
	 		echo "dag: ". $dag."<br>";
	 		echo "weekdag: ". $weekdag."<br>";
	 		echo "daynr  : ". $day_number."<br>";
*/	 		
	 		     	
	 	    	 if ($day_number == $weekdag and $dag < 99) { ?>
 	     	 	  <td style='background-color:white;font-size:8pt;color:black;font-family:verdana;text-align:center;'>
 	   	 	   
 	   	 	   
 	   	 	   <a href="#" onclick="changeDatum('<?php echo sprintf("%02d",$dag); ?>,<?php echo sprintf("%02d",$maand); ?>,<?php echo $jaar; ?>' );"     	 	  	> <?php echo $dag;?></a>
 	   	 	   
 	   	 	   </td>
 	     	 	  <?php 
  		     	 $dag++;
	 		     	 $day_number = date ('N' ,mktime(0,0,0,$maand,$dag,$jaar));
	 		     	 
	 		     	 // 
	 		     	 if ( date ('m' ,mktime(0,0,0,$maand,$dag,$jaar))   != $maand) {
	 		     	 	  $dag =99;
	 		     	 }
	 		     	 
	 		     	 	  
	 		     	 	;
	 		     	 
		     	 	  }  else {
	 		          echo "<td style='background-color:lightgrey;font-size:8pt;color:lightgrey;font-family:verdana;'>.</td>";
	 		     	 }
           	 		  
	 		  }
	 		 echo "</tr>"; 
       $dag--;
       	 		
	 		}  
	 		
	 		  ?>
	 		</table>
 	  <br>
 	  <span style='font-size:9pt;text-decoration:italic;color:blue;text-align:center;'>Klik op Terug of Verder om te bladeren.<br>Als je op een dag in de maand klikt,<br>zal deze worden ingevuld als toernooi-datum.</span>
	 	</td>
	
<tr></tr>		<td width='250' STYLE ='background-color:white;color:blue;'>Naam toernooi (max 30 tekens)   </th><td STYLE ='background-color:white;color:black;'><input type='text'  name='_toernooi' id='toernooi' size=40/><em>  Geen vreemde tekens en spaties gebruiken !</em></td>


<tr><td width='250'STYLE ='background-color:white;color:blue;'><label>Email adres organisatie </label></th><td STYLE ='background-color:white;color:orange;'><label><input type='text'  name='_email_organisatie' value= '<?php echo $email_organisatie;?>' size=40/></label></td></tr>


 <tr>
  <td   STYLE ='font size: 12pt; background-color:white;color:blue ;'>Selecteer als bron  </td>
  <td   STYLE ='font size: 12pt; background-color:white;color:blue ;'><select name='bron' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:350px;'>
  
<?php

echo "<option value='default' selected>mytoernooi.txt (standaard)</option>"; 


$i=0;

 while($row = mysql_fetch_array( $namen )) {
 	$var = substr($row['Datum'],0,10);
	echo "<OPTION  value=".$row['Toernooi']."><keuze>";
    	  echo $var . " - ". $row['Toernooi'];
    	  echo "</keuze></OPTION>";	
    	  $i++;
} 

?>

</SELECT></label></td></tr>

<tr> 
<td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Aanmaak QRC image voor inschrijfformulier <a href="non_js_help.html" style= 'font-size:7pt;color:blue;' class='popupLink' onclick="return !showPopup('help', event)">
     	<img src='../boulamis_toernooi/images/info.jpg' border = 0 width=20></a></td>
<td><input type='checkbox'  name='qrc_code' value= 'Ja' checked></td></tr>

<tr>
<td Style='font-family:Arial;font-size:9pt;color:black;' colspan =2><input type='checkbox' name='akkoord' unchecked>&nbsp
      Ik ga akkoord met de <b>algemene voorwaarden</b> voor het gebruik van OnTip. <a style='color:blue;' href = 'disclaimer.php' >Klik hier voor de algemene voorwaarden.</a>.
      <td></td>
</tr>

</table>

<br><br>
<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
</blockquote>
<br></div><br><br>
<?php
if (isset($bron_toernooi)) {
	echo "<div style='color:brown;font-size:9pt;'>";
  echo "Bron voor toernooi gegevens : <a href='". $bron_toernooi."'>". $bron_toernooi."</a>";
  echo "</div>";
} 
ob_end_flush();
?>
</div>
</body>
</html>
