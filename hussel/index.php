<?php
////  HUSSEL index.php (c) Erik Hendrikx 2015 ev
////
//// 7 sep 2017 muteer_score kan maximaal 125 records updaten per scherm.  Parameter boven_100  toegevoegd.
# 5apr2019           -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          PHP7
# Reference: 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
?>
<html>
<title>OnTip Hussel (c) Erik Hendrikx 2015</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 14.0pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left; }
li {color:black ;background-color:white; font-size: 9pt ; font-family:Arial, Helvetica, sans-serif;text-align: left; }
TD {color:blue ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }
.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute;right:20pt; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;color:black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
         
.alert {background-color:red;}

a.tooltip {outline:none; }
a.tooltip strong {line-height:30px;}
a.tooltip:hover {text-decoration:none;} 
a.tooltip span {
    z-index:10;display:none; padding:14px 20px;
    margin-top:-30px; margin-left:28px;
    width:300px; line-height:16px;
}
a.tooltip:hover span{
    display:inline; position:absolute; color:#111;
    border:1px solid #DCA; background:#fffAF0;}
.callout {z-index:20;position:absolute;top:30px;border:0;left:-12px;}
    
/*CSS3 extras*/
a.tooltip span
{

em {color:red ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;}

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

<script language="JavaScript">
function setVisibility(id, visibility) {
document.getElementById(id).style.display = visibility;
}

function changeFunc21() {
    var selectBox = document.getElementById("selectBox21");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    var myarr = selectedValue.split(",");
    
    document.myForm.Licentie2.value= myarr[0];
    document.myForm.Naam2.value= myarr[1];
    document.myForm.Vereniging2.value= myarr[2];
   }

 function fill_input_lot_nummer_field(id)
{
	if (document.getElementById('Lot_nummer_'+id).value == "0")
	{
	   document.getElementById('Lot_nummer_'+id).value= "";
  
    }
  } 
  
 
 function fill_input_voor1_field(id)
{
	if (document.getElementById('Voor1_'+id).value == "0")
	{
	   document.getElementById('Voor1_'+id).value= "";
  
    }
  } 
  
    
 function fill_input_voor2_field(id)
{
	if (document.getElementById('Voor2_'+id).value == "0")
	{
	   document.getElementById('Voor2_'+id).value= "";
  
    }
  } 
  
    
 function fill_input_voor3_field(id)
{
	if (document.getElementById('Voor3_'+id).value == "0")
	{
	   document.getElementById('Voor3_'+id).value= "";
  
    }
  } 
  
    
 function fill_input_voor4_field(id)
{
	if (document.getElementById('Voor4_'+id).value == "0")
	{
	   document.getElementById('Voor4_'+id).value= "";
  
    }
  } 
  
    
 function fill_input_voor5_field(id)
{
	if (document.getElementById('Voor5_'+id).value == "0")
	{
	   document.getElementById('Voor5_'+id).value= "";
  
    }
  } 
  
    
 function fill_input_tegen1_field(id)
{
	if (document.getElementById('Tegen1_'+id).value == "0")
	{
	   document.getElementById('Tegen1_'+id).value= "";
  
    }
  } 
  
  function fill_input_tegen1_field(id)
{
	if (document.getElementById('Tegen1_'+id).value == "0")
	{
	   document.getElementById('Tegen1_'+id).value= "";
  
    }
  } 
  
  function fill_input_tegen2_field(id)
{
	if (document.getElementById('Tegen2_'+id).value == "0")
	{
	   document.getElementById('Tegen2_'+id).value= "";
  
    }
  } 
  
  function fill_input_tegen3_field(id)
{
	if (document.getElementById('Tegen3_'+id).value == "0")
	{
	   document.getElementById('Tegen3_'+id).value= "";
  
    }
  } 
  
  function fill_input_tegen4_field(id)
{
	if (document.getElementById('Tegen4_'+id).value == "0")
	{
	   document.getElementById('Tegen4_'+id).value= "";
  
    }
  } 
  
  function fill_input_tegen5_field(id)
{
	if (document.getElementById('Tegen5_'+id).value == "0")
	{
	   document.getElementById('Tegen5_'+id).value= "";
  
    }
  } 
  
function fill_input_naam_field()
{
	if (document.getElementById('naam').value == "Typ hier de naam"){
		
	   document.getElementById('naam').value= "";
  
    }
  } 
  
  
  
</script>
</head>


<body>
<?php
ob_start();
include 'mysqli.php'; 

// variabelen worden geladen in mysql.php
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen
/*
$aangelogd = 'N';

include('aanlog_check_hussel.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen_hussel.php");
</script>
<?php
exit;
}
*/

setlocale(LC_ALL, 'nl_NL');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

$boven_100 = 'N';

if (isset($_GET['boven_100'])){
 $boven_100 = $_GET['boven_100'];
}


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

if ($jaar <> date('Y') ){
	$datum_string = strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
} else {
	$datum_string = strftime("%A %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );
}	

$sql_score      = mysqli_query($con,"SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id."  and  Datum = '".$datum."'  ")     or die(' Fout in select spelers');  
$result         = mysqli_fetch_array( $sql_score );
$aantal         = $result['Aantal'];

$sql_score       = mysqli_query($con,"SELECT count(*) as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ")     or die(' Fout in select aantal');  
$result          = mysqli_fetch_array( $sql_score );
$aantal_ingevuld = $result['Aantal'];

$sql_score      = mysqli_query($con,"SELECT count(*) as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Beperkt ='J' and  Datum = '".$datum."'  ")     or die(' Fout in select aantal');  
$result         = mysqli_fetch_array( $sql_score );
$aantal_beperkt = $result['Aantal'];


echo "<table width=99% border =0>";
echo "<tr>";
echo "<td>";
echo "<img src = 'images/OnTip_hussel.png' width='200'>";
echo "<br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'>".$output_naam_vereniging."</span></td>";
echo "<td width=60%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>";

if ($voorgeloot == 'On') {
	
$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'voorgeloot'  ") ;  
$result              = mysqli_fetch_array( $qry);
$toernooi            = $result['Parameters'];	

echo $toernooi . "<br>". $datum_string."</h1>";
} else {
echo "Hussel ". $datum_string."</h1>";
}

if ($baan_schemas == 'On') {
$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'baan_schemas'  ") ;  
$result              = mysqli_fetch_array( $qry);
$min_aantal         = $result['Parameters'];	
}

/// 7 sep 2017  indien > 100 splitsen


echo "</td>";
echo "<td width = 50><a style='font-size:8pt;text-align:center;' href = 'beheer_settings.php' target ='_top' id= 'instellingen'><img src='images/Icon_tools.png' height=40><br>Instellingen</a></td>";
if ($voorgeloot == 'On') { 
echo "<td width = 50><a style='font-size:8pt;text-align:center;' href = 'random_lotnr.php' target ='_top'><img src='images/dice.jpg' height=40><br>Start loting</a></td>";

  if ($aantal >= $min_aantal  and $baan_schemas =='On' ) {
     echo "<td width = 20><a style='font-size:8pt;text-align:center;' href = 'pdf/".$aantal."_deelnemers.pdf' target ='_blank'><img src='images/icon-place.png' height=40><br>Schema<br>voor ".$aantal."</a></td>";
  }
}

echo "<td width = 50><a style='font-size:8pt;text-align:center;' href = 'print_hussel.php?datum=".$datum."' target ='_top'><img src='images/printer.jpg' height=40><br>Print functies</a></td>";
echo "<td width = 50><a style='font-size:8pt;' href = 'scorelijst.php?datum=".$datum."' target ='_top'><img src='images/score.jpg' height=45><br><center>Eind uitslag</center></a></td>";   

echo "<td width = 50><a style='font-size:8pt;' href = 'bereken_stand_hussel_serie.php' target ='_top'><img src='images/hussel_serie.png' height=40><br><center>Hussel serie</center></a></td>";

echo "<td  style='font-size:8pt;text-align:center;' width = 50>";
echo "<FORM action='muteer_check13.php?controle_13' method='post'>"; 

if ($controle_13=='Auto'){
echo "<span style='font-size:8pt;text-align:center;' ><input style= 'height:35pt;' type='image' src='images/check13auto.png' alt='Klik hier' /><br>Controle 13</span>";
}

if ($controle_13=='On'){
echo "<span style='font-size:8pt;text-align:center;' ><input style= 'height:35pt;' type='image' src='images/check13aan.png' alt='Klik hier' /><br>Controle 13</span>";
}

if ($controle_13=='Off'){
echo "<span style='font-size:8pt;text-align:center;' ><input style= 'height:35pt;' type='image' src='images/check13uit.png' alt='Klik hier' /><br>Controle 13</span>";
}


echo "</form></td>";


echo "<td  style='font-size:8pt;text-align:center;' width = 50>";


if ($aantal_rondes == 2){
	echo "<FORM action='muteer_rondes.php?aantal_rondes=3' method='post'>"; 
  echo "<span style='font-size:8pt;text-align:center;'  ><input style= 'height:35pt;' type='image' src='images/2rondes.png' alt='Klik hier' /><br>rondes</span>";
} 


if ($aantal_rondes == 3){
	echo "<FORM action='muteer_rondes.php?aantal_rondes=5' method='post'>"; 
echo "<span style='font-size:8pt;text-align:center;'  ><input style= 'height:35pt;' type='image' src='images/3rondes.png' alt='Klik hier' /><br>rondes</span>";
} 

if ($aantal_rondes == 5){
	echo "<FORM action='muteer_rondes.php?aantal_rondes=2' method='post'>"; 
  echo "<span style='font-size:8pt;text-align:center;'  ><input style= 'height:35pt;' type='image' src='images/5rondes.png' alt='Klik hier' /><br>rondes</span>";
} 

echo "</form></td>";


if ($aantal_ingevuld > 0) {

echo "<td  style='font-size:8pt;text-align:center;' width = 60>";
echo "<FORM action='muteer_invoer.php?blokkeer_invoer' method='post'>"; 

if ($blokkeer_invoer == 'On'){
echo "<span style='font-size:8pt;text-align:center;'  ><input style= 'height:35pt;' type='image' src='images/icon_input_off.png' alt='Klik hier' /><br>Invoer namen</span>";
} else {
echo "<span style='font-size:8pt;text-align:center;' ><input style= 'height:35pt;' type='image' src='images/icon_input.png' alt='Klik hier' /><br>Invoer namem</span>";
}
echo "</form></td>";

}

 if ($verwijderen_spelers == 'On' and $aantal_beperkt > 0 ){
 	echo "<td width = 50><a style='font-size:8pt;' href = 'verwijder_spelers_beperkt_stap1.php' target ='_top'><img src='images/tag.jpg' height=40><br><center>Verwijder<br>beperkt</center></a></td>";
}

echo "</tr>";
echo "</table>";

if ($datum_lock=='On'){
 echo "<center><div style ='color:red;text-align:center;font-size:11pt;' width=50%><marquee width=50%>Datum is vastgezet.Uitschakelen via instellingen.</marquee></div></center>";
}
?>
 
<!-----------------------------------------------------------------------------------------///////------------------------------------------------------------------------------>
<blockquote>

<?php 
// indien een stand in ronde1 is ingevuld verdwijnt de marquee met invul tip

//echo "SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ";
$sql_score      = mysqli_query($con,"SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ")     or die(' Fout in select spelers');  
$result         = mysqli_fetch_array( $sql_score );
$aantal         = $result['Aantal'];


if ($aantal == 0 ){
	// blokkeren uitschakelen bij aantal 0
	$query   = "UPDATE hussel_config SET Waarde = 'Off'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'blokkeer_invoer'";   
  mysqli_query($con,$query) or die(' Fout in deactiveren invoer');
}

if ($aantal < 5 and $blokkeer_invoer == 'Off' ){
	// uitschakelen  marquee
?>
<center>
<marquee  width = 80% style='text-align:center;color:blue;font-size:10pt;font-weight:bold;'>Selecteer een naam uit de lijst voor spelers die al eens eerder de hussel gespeeld hebben of voeg een nieuwe speler toe.<span style=  'color:red;'>Nadat eerste score is ingevuld kan de invoer van nieuwe spelers worden uitgezet.</span></marquee>
</center>
<?php
}

//// Query voor spelers ophalen die nog niet eerder zijn geselecteerd

$sql_splrs      = mysqli_query($con,"SELECT * From hussel_spelers  where Vereniging_id = ".$vereniging_id." and Naam not in ( select Naam from hussel_score where Vereniging_id = ".$vereniging_id." and  Datum = '".$datum."' ) order by Naam ")     or die(' Fout in select spelers');  

?>
<?php
// indien de eerste score is ingevuld en blokkeren invoer is ingeschakeld, verdwijnen de invulvelden voor spelers

if ($blokkeer_invoer == 'Off' or $aantal ==0 ){
?>
<table width=90%>
	<tr>
		<td STYLE='font-size:14pt;background-color:WHITE;'>
		<fieldset style='border:1px solid red;width:95%;padding:5pt;height:120;'>
    	<legend style='left-padding:5pt;color:red;font-size:14px;font-family:Arial;'>Selecteer bekende spelers</legend>

			<FORM action='select_speler.php' method='post'>
				<input type ='hidden'  name= 'datum'          value = '<?php echo $datum;?>' />
				<input type ='hidden'  name= 'vereniging'     value = '<?php echo $vereniging;?>' />
				<input type ='hidden'  name= 'vereniging_id'  value = '<?php echo $vereniging_id;?>' />
				 
			<select name='bestaande_speler' STYLE='font-size:14pt;background-color:WHITE;font-family: Courier;width:460px;'>
         <option value='' selected>Selecteer uit lijst..</option>
       <?php
        $i=1;
         while($row = mysqli_fetch_array( $sql_splrs )) {
         	?>
         	
          <option STYLE='font-size:14pt;background-color:WHITE;font-family: Courier;width:450px;' value='<?php echo $row['Naam']; ?>' ><?php echo $row['Naam']; ?></option>
         <?php } ?>

      </SELECT>
      <br>
      <input style='font-size:12pt;'  TYPE="submit" VALUE="Selecteer uit de lijst en klik hier om toe te voegen aan de hussel">
      <br> <br><br><em style= 'color:black;text-align:center;padding:5pt;font-size:11pt;'>Al geselecteerde namen zijn niet meer zichtbaar in deze lijst</em>
     </form>

  </fieldset>

	</td>
	<td>
			<fieldset style='border:1px solid red;width:95%;padding:5pt;height:120;'>
         	<legend style='left-padding:5pt;color:red;font-size:14px;font-family:Arial;'>Voeg nieuwe speler toe</legend>

			<FORM action='insert_speler.php' method='post'>
				<input type ='hidden'  name= 'datum'  value = '<?php echo $datum;?>' />
				<input type ='hidden'  name= 'vereniging'     value = '<?php echo $vereniging;?>' />
				<input type ='hidden'  name= 'vereniging_id'  value = '<?php echo $vereniging_id;?>' />
				<input onclick="fill_input_naam_field();" STYLE='font-size:14pt;font-family: Courier;' type ='text'  id = 'naam' name = 'nieuwe_speler' value ='Typ hier de naam' size =55 />
     <br><input style='font-size:12pt;' TYPE="submit" id="submit_nieuwe_speler" VALUE="Typ naam nieuwe speler en klik hier om toe te voegen aan de hussel en spelerslijst">
     </form>
     <br><em style= 'color:black;text-align:center;padding:5pt;font-size:11pt;'>De toegevoegde naam is voor de volgende keer beschikbaar in de selectielijst</em>
     
      </fieldset>
  </td>  

	
</tr>
</table>
</blockquote>

<?php 
} //end score ingevuld
?>
<br>
		
<!--///   Tabel voor invoer score ----------//---->

 <FORM action='muteer_score.php' method='post' name = 'myForm'>
 	<center>
 	<input style= 'font-size:16pt;text-align:center;' TYPE="submit" VALUE="Opslaan">
</center>
 	<table width =80%>
  <td style= 'color:darkgreen;text-align:left;font-size:10pt;'> Om regel te verwijderen, zet vinkje in de kolom <font color=red>Del</font> en klik op Opslaan (of Druk op Enter toets)</td>
  <td style= 'color:blue;text-align:right;font-size:10pt;'><em>
  	
  	<?php
  	if ($controle_13=='Auto'){?>
  	  Alleen de waarde ongelijk aan 13 hoeft te worden ingevuld, behalve bij 0-13 of 13-0
  	<?php }  ?>
  	
  	<?php
  	if ($controle_13=='On'){?>
  	  Automatisch invullen waarde '13' is uitgeschakeld. Er wordt wel op max waarde 13 gecontroleerd
  	<?php }  ?>
  	<?php
  	if ($controle_13=='Off'){?>
  	  Automatisch invullen waarde '13' en controle op max waarde 13 is uitgeschakeld.
  	<?php }  ?>
  	
  	</em></td>
  </table>
<table width=95%    BORDER =1 >
	<tr>
		<?php
		$colspan =3;
		if ($voorgeloot == 'On' ){
			$colspan++;
		}
		if ($verwijderen_spelers == 'On' ){
			$colspan++;
		}
	?>
 
	<th colspan=<?php echo $colspan;?>  ></th>
 
  <th style='text-align:center;' colspan=2>Ronde 1</th>
	<th style='text-align:center;' colspan=2>Ronde 2</th>
<?php 
 if ($aantal_rondes > 2){?>
   	<th style='text-align:center;' colspan=2>Ronde 3</th>
<?php }  ?>   	
	
<?php 
   if ($aantal_rondes == 5){
   	?>
	<th style='text-align:center;' colspan=2>Ronde 4</th>
	<th style='text-align:center;' colspan=2>Ronde 5</th>
<?php }  ?>   	
	
	<th colspan=3></th>
  </tr>	
	<tr>
		<th>Nr</th>
		<th  style='background-color:red;color:white;font-size:9pt;width:10pt;text-align:left;' >
			<!--First tooltip-->
<a href="#" class="tooltip"  style='color:white;'>
    <span>
        <strong><u>Verwijderen</strong></u><br />
        Zet hier een vinkje voor de spelers die je direct wilt verwijderen en klik op Opslaan.<br>
        Er wordt om een bevestiging gevraagd. Na verwijderen moet er opnieuw geloot worden.
    </span>
<center>Del</center></a>
</th>
	
	 <?php
	 if ($voorgeloot == 'On' ){?>
	<th  style='background-color:darkblue;color:white;font-size:9pt;width:10pt;text-align:left;'>
		<!--First tooltip-->
<a href="#" class="tooltip"  style='color:white;'>
    <span>
        <strong><u>Lotnummer</u></strong><br />
        Hier kan het nummer van de voorloting worden ingevuld. Door te klikken op de dobbelsteen kan dit geautomatiseerd worden. <br>
        Voor een nieuwe loting kan via het beheerscherm de loting gereset worden.<br>
        Als er minimaal <?php echo $min_aantal; ?> spelers zijn ingevoerd, kan een baanschema worden geselecteerd.
    </span>

<center>Lotnr</center></a>

</th>
   <?php } ?> 
  
   
		<th>Naam</th>
		 	 <?php
	 if ($verwijderen_spelers == 'On' ){?>
	<th  style='background-color:darkgreen;color:white;font-size:9pt;width:10pt;text-align:left;'  >
		<!--First tooltip-->
<a href="#" class="tooltip"  style='color:white;'>
    <span>
        <strong><u>Beperkte deelname</u></strong><br />
        Voor spelers die niet alle rondes meedoen kunnen hier aangevinkt worden.<br>
        Vergeet niet op Opslaan te klikken. Het vinkje blijft staan totdat deze spelers verwijderd zijn of het vinkje handmatig verwijderd is.<br>
        Na verwijderen van een of meer spelers dient er opnieuw geloot te worden.
    </span>

Beperkt</a></th>
   <?php } ?> 
   
   
		<th style='text-align:center;'>Voor</th>
		<th style='color:red;text-align:center;'>Tegen</th>
		<th style='text-align:center;'>Voor</th>
		<th style='color:red;text-align:center;'>Tegen</th>
		
	<?php 
 if ($aantal_rondes > 2){?>	
		<th style='text-align:center;' >Voor</th>
		<th style='color:red;text-align:center;'>Tegen</th>
		
<?php }  ?>  		
	<?php 
   if ($aantal_rondes == 5){
   	?>
		<th style='text-align:center;'>Voor</th>
		<th style='color:red;text-align:center;'>Tegen</th>
		<th style='text-align:center;'>Voor</th>
		<th style='color:red;text-align:center;'>Tegen</th>
<?php }  ?>   	

		<th style='background-color:lightblue;font-weight:bold;text-align:center;'>Winst</th>
		<th style='background-color:lightblue;font-weight:bold;text-align:center;' >Saldo</th>
</tr>
			
<?php


// er kunnen max 125 records in 1 keer geupdate worden. Pas veilige marge tot max 100 door gebruik te maken van  limit van. aantal
 if ($boven_100 == 'J')  {
    $limit_tekst =  '100,100';
    $i=100;
 }  else {
  	$limit_tekst = '0,100';
  	$i=1;
  }
 
  
if ($voorgeloot == 'On') {
$sql_score      = mysqli_query($con,"SELECT * FROM hussel_score WHERE  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' order by Lot_nummer , Naam ") or die(' Fout in select score');  
} else {
$sql_score      = mysqli_query($con,"SELECT * FROM hussel_score WHERE  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' order by Naam Limit ".$limit_tekst."  " ) or die(' Fout in select score');  
}

$count          = mysqli_num_rows($sql_score);	

echo "<input type='hidden'  name ='count_score'   value ='".$count."'>";  
echo "<input type='hidden'  name ='boven_100'     value ='".$boven_100."'>";  
echo "<input type='hidden'  name ='begin_waarde'  value ='".$i."'>";  
echo "<input type='hidden'  name ='controle_13'   value =".$controle_13.">";  
echo "<input type='hidden'  name ='aantal_rondes' value =".$aantal_rondes.">";  

//// detail regels
    while($row_score = mysqli_fetch_array( $sql_score )) {

   //  store id waarde
    echo "<input type='hidden'  name ='Id_".$i."' value =".$row_score['Id'].">";  
    
    
?>
	<tr>
		<td><?php echo $i;?></td>
		<td Style='font-family:verdana;background-color:white;text-align:center;'><input  type ='checkbox'      name ='Check[]' value ='<?php echo $row_score['Id'];; ?>'></td>
		
		<?php
	 if ($voorgeloot == 'On' ){?>
	
	   <?php
	     if ($reset_loting == 2){?>
	   
	   <td onclick="fill_input_lot_nummer_field(<?php echo $i;?>);" style='width:10pt;text-align:right;' ><input style='font-size:12pt;font-weight:bold;text-align:right;color:darkgreen;' type'text'  value = '<?php echo $row_score['Lot_nummer'];?>' name = 'Lotnummer_<?php echo $i; ?>' id = 'Lot_nummer_<?php echo $i; ?>' size = 2/></td>
   <?php } else { ?>
	   <td onclick="fill_input_lot_nummer_field(<?php echo $i;?>);" style='width:10pt;text-align:right;' ><span style='font-size:12pt;font-weight:bold;text-align:right;color:darkgreen;' ><?php echo $row_score['Lot_nummer'];?></span></td>
	   <input type= 'hidden'  value = '<?php echo $row_score['Lot_nummer'];?>' name = 'Lotnummer_<?php echo $i; ?>'  />
    <?php } ?>
  
  
   <?php } ?>
		
		<td  ><input style='font-size:12pt;' type'text'  value = '<?php echo $row_score['Naam'];?>' name = 'Naam_<?php echo $i; ?>' size = 45/></td>
   
   
   		<?php
	 if ($verwijderen_spelers == 'On' ){
	 	
	 	 if ($row_score['Beperkt']  == 'J'){	 	?>
        <td Style='font-family:verdana;background-color:white;text-align:center;'><input  type ='checkbox'      name ='Beperkt[]'  checked  value ='<?php echo $row_score['Id']; ?>'></td>  
   <?php } else { ?>
     <td Style='font-family:verdana;background-color:white;text-align:center;'><input  type ='checkbox'      name ='Beperkt[]' value ='<?php echo $row_score['Id']; ?>'></td>  
    <?php } ?>
  
  
  <?php } ?>



   <?php if ($row_score['Voor1'] != 0 and $row_score['Tegen1'] !=0  or ( $row_score['Voor1'] == 13 or $row_score['Tegen1'] == 13)  ){
   	     $bg_color= 'lightgrey';
   	   } else {
   	   	 $bg_color= '#FFFFD4'; 
   }   ?>
   
    <td onclick="fill_input_voor1_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
    	     <input  style='font-size:14pt;color:black;text-align:right;' type'text'  value = '<?php echo $row_score['Voor1'];?>'     name = 'Voor1_<?php echo $i;?>'  id = 'Voor1_<?php echo $i;?>'  size = 2/></td>		
    <td onclick="fill_input_tegen1_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
    	     <input style='font-size:14pt;color:red;text-align:right;'  type'text'  value = '<?php echo $row_score['Tegen1'];?>'      name = 'Tegen1_<?php echo $i;?>' id = 'Tegen1_<?php echo $i;?>' size = 2/></td>		
	 
	 
	 <?php if ($row_score['Voor2'] != 0 and $row_score['Tegen2'] !=0  or ( $row_score['Voor2'] == 13 or $row_score['Tegen2'] == 13) ){
   	     $bg_color= 'lightgrey';
   	   } else {
   	   	 $bg_color= '#FFFFD4'; 
   }   ?>
   
	 
	 
	  <td onclick="fill_input_voor2_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
	  	     <input style='font-size:14pt;color:black;text-align:right;' type'text'  value = '<?php echo $row_score['Voor2'];?>'      name = 'Voor2_<?php echo $i;?>'  id = 'Voor2_<?php echo $i;?>'  size = 2/></td>		
	  <td onclick="fill_input_tegen2_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;' >
    	     <input style='font-size:14pt;color:red;text-align:right;'  type'text'  value = '<?php echo $row_score['Tegen2'];?>'      name = 'Tegen2_<?php echo $i;?>' id = 'Tegen2_<?php echo $i;?>' size = 2/></td>		
	 
	 <?php if ($row_score['Voor3'] != 0 and $row_score['Tegen3'] !=0  or ( $row_score['Voor3'] == 13 or $row_score['Tegen3'] == 13) ){
   	     $bg_color= 'lightgrey';
   	   } else {
   	   	 $bg_color= '#FFFFD4'; 
     }   ?>
	
		<?php 
 if ($aantal_rondes > 2){?>	 
	 <td onclick="fill_input_voor3_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
	  	     <input style='font-size:14pt;color:black;text-align:right;' type'text'  value = '<?php echo $row_score['Voor3'];?>'      name = 'Voor3_<?php echo $i;?>'  id = 'Voor3_<?php echo $i;?>'  size = 2/></td>		
	  <td onclick="fill_input_tegen3_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
    	     <input style='font-size:14pt;color:red;text-align:right;'  type'text'  value = '<?php echo $row_score['Tegen3'];?>'      name = 'Tegen3_<?php echo $i;?>' id = 'Tegen3_<?php echo $i;?>' size = 2/></td>		
 
<?php } ?>
   
 <?php 
   if ($aantal_rondes == 5){
   	?>
   	
   	<?php if ($row_score['Voor4'] != 0 and $row_score['Tegen4'] !=0  or ( $row_score['Voor4'] == 13 or $row_score['Tegen4'] == 13) ){
   	     $bg_color= 'lightgrey';
   	   } else {
   	   	 $bg_color= '#FFFFD4'; 
     }   ?>
     
     
   	
   	 <td onclick="fill_input_voor4_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
	  	     <input  style='font-size:14pt;color:black;text-align:right;' type'text'  value = '<?php echo $row_score['Voor4'];?>'      name = 'Voor4_<?php echo $i;?>'  id = 'Voor4_<?php echo $i;?>'  size = 2/></td>		
	  <td onclick="fill_input_tegen4_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
    	     <input style='font-size:14pt;color:red;text-align:right;'  type'text'   value = '<?php echo $row_score['Tegen4'];?>'      name = 'Tegen4_<?php echo $i;?>' id = 'Tegen4_<?php echo $i;?>' size = 2/></td>		
	
	
	<?php if ($row_score['Voor5'] != 0 and $row_score['Tegen5'] !=0  or ( $row_score['Voor5'] == 13 or $row_score['Tegen5'] == 13) ){
   	     $bg_color= 'lightgrey';
   	   } else {
   	   	 $bg_color= '#FFFFD4'; 
     }   ?>
     
	 <td onclick="fill_input_voor5_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
	  	     <input style='font-size:14pt;color:black;text-align:right;' type'text'   value = '<?php echo $row_score['Voor5'];?>'      name = 'Voor5_<?php echo $i;?>'  id = 'Voor5_<?php echo $i;?>'  size = 2/></td>		
	  <td onclick="fill_input_tegen5_field(<?php echo $i;?>);" style='background-color:<?php echo $bg_color; ?>;text-align:right;'>
    	     <input style='font-size:14pt;color:red;text-align:right;'  type'text'  value = '<?php echo $row_score['Tegen5'];?>'      name = 'Tegen5_<?php echo $i;?>' id = 'Tegen5_<?php echo $i;?>' size = 2/></td>		
	
	
	
<?php }  ?>   	
    
	 <td style='text-align:right;background-color:#D6EBFF;color:black;font-weight:bold;font-size:14pt;'><?php echo $row_score['Winst'];?></td>
	 
	 <?php 
	 if ($row_score['Saldo'] < 0){  ?>
	 <td style='text-align:right;background-color:#FFEBEB;color:red;font-weight:bold;font-size:14pt;'><?php echo $row_score['Saldo'];?></td>
	<?php } else { ?>
	 <td style='text-align:right;background-color:#EBFFEB;color:black;font-weight:bold;font-size:14pt;'><?php echo $row_score['Saldo'];?></td>
	 <?php }  ?> 
	</tr>
	
<?php 
$i++;
} // end while score
?>
</table>

<?php
$sql_score      = mysqli_query($con,"SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id."  and  Datum = '".$datum."'  ")     or die(' Fout in select spelers');  
$result         = mysqli_fetch_array( $sql_score );
$aantal         = $result['Aantal'];

if ($aantal > 100 and  isset($_GET['boven_100'])){
?>
<a href = 'index.php' target ='self'><img src= 'images/onder100.png' width =50></a>
<?php } ?>

<?php
if ($aantal > 100 and  !isset($_GET['boven_100'])){
?>
<a href = 'index.php?boven_100=J' target ='self'><img src= 'images/boven100.png' width =50></a>
<?php } ?>



	
	<div  style='font-size:8pt; color:darkgrey;text-align:right;width:1300pt;'>(c) Erik Hendrikx <?php echo date('Y');?></div>
	<center>
	<input style= 'font-size:16pt;text-align:center;' TYPE="submit" VALUE="Opslaan">
</form>
</center>

</body>
</html>