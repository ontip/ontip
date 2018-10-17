<html>
<head>
<title>Aanmaak PDF Flyer</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 9pt;}
th   {font-size: 10pt; font-family: Verdana;background-color:blue;color:white;font-weight:bold; }
input:focus, input.sffocus  { background: lightblue;cursor:underline; }


.pink {background-color:#FFFAF0;}


</style>
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
<Script Language="Javascript">

function change(that, fgcolor, bgcolor){
that.style.color = fgcolor;
that.style.backgroundColor = bgcolor;
}

function make_blank()
{
	document.myForm.opmerkingen.value="";
}

function changeFunc1() {
    var selectBox = document.getElementById("selectBox1");
    var selectedValue1 = selectBox.options[selectBox.selectedIndex].value;
 
    document.getElementById('Cel1').style.backgroundColor=selectedValue1;
    document.myForm.achtergrond_kleur.value= selectedValue1;
    
    var tdValue = document.getElementById("Cel1").style.backgroundColor;
    document.getElementById('Cel0').style.backgroundColor=tdValue;
    document.getElementById('Cel2').style.backgroundColor=tdValue;
    document.getElementById('Cel3').style.backgroundColor=tdValue;
    document.getElementById('Cel4').style.backgroundColor=tdValue;
    document.getElementById('Cel5').style.backgroundColor=tdValue;
    document.getElementById('Cel6').style.backgroundColor=tdValue;
    document.getElementById('Cel7').style.backgroundColor=tdValue;   
    document.getElementById('Cel8').style.backgroundColor=tdValue;   
    document.getElementById('Cel9').style.backgroundColor=tdValue;
       document.getElementById('Cel6').style.backgroundColor=tdValue;
   }
function changeFunc2() {
    var selectBox = document.getElementById("selectBox2");
    var selectedValue2 = selectBox.options[selectBox.selectedIndex].value;
 
    var tdValue = document.getElementById("Cel1").style.backgroundColor;
            
    document.getElementById('Cel2').style.color=selectedValue2;
    document.myForm.tekstkleur.value= selectedValue2;
    
  
   }
   
function changeFunc3() {
    var selectBox = document.getElementById("selectBox3");
    var selectedValue3 = selectBox.options[selectBox.selectedIndex].value;
 
    var tdValue = document.getElementById("Cel1").style.backgroundColor;
            
    document.getElementById('Cel3').style.color=selectedValue3;

    document.myForm.koptekst.value= selectedValue3;
 
   }
 
 function changeFunc4() {
    var selectBox = document.getElementById("selectBox4");
    var selectedValue4 = selectBox.options[selectBox.selectedIndex].value;
 
    var tdValue = document.getElementById("Cel1").style.backgroundColor;


    document.getElementById("myIMG").src=selectedValue4;
  
   }
 
 function changeFunc5 () {
    var selectBox = document.getElementById("selectBox4");
    var selectedValue4 = selectBox.options[selectBox.selectedIndex].value;
 
    var tdValue = document.getElementById("Cel1").style.backgroundColor;


    document.getElementById("myIMG").src=selectedValue4;
  
   }  
   
   function changeImage(a,b,c,d) {
   	
   	if (document.getElementById("check").checked == true){
   	  document.getElementById("img").src=a; 
   	  document.getElementById("img").height=d;
   	     }
    else
   	  document.getElementById("img").src=b;
   	  document.getElementById("img").height=c;
   	  
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
</Script>
</head>

<body >
<?php
// Database gegevens. 
include('mysql.php');
ini_set('default_charset','UTF-8');
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

if (isset($_GET['toernooi'])){
	$toernooi = $_GET['toernooi'];
}


$sql  = mysql_query("SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

switch($soort_inschrijving){
    case 'single' :   $soort = 'tete-a-tete'; break;
    case 'doublet' :  $soort = 'doubletten'; break;
    case 'triplet' :  $soort = 'tripletten'; break;
    case 'kwintet' :  $soort = 'kwintetten'; break;
    case 'sextet' :   $soort = 'sextetten';  break;
  }

$sql2      = mysql_query("SELECT *  From vereniging where Vereniging = '".$vereniging."' ")     or die(' Fout in select');  
$result    = mysql_fetch_array( $sql2 );
 // $prog_url  = $result['Prog_url'];
  
/// Ophalen tekst kleur

$qry  = mysql_query("SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$row        = mysql_fetch_array( $qry );
$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

if ($tekstkleur =='') {
	$tekstkleur = '#000000';
	$koptekst   = '#000000';
}

// uit vereniging tabel	
	
$qry          = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysql_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

$qry_kl1  = mysql_query("SELECT * From kleuren order by Kleurcode")     or die(' Fout in select');  
$qry_kl2  = mysql_query("SELECT * From kleuren order by Kleurcode")     or die(' Fout in select');  
$qry_kl3  = mysql_query("SELECT * From kleuren order by Kleurcode")     or die(' Fout in select');  

/// Verwerk bestand met files die niet getoond moeten worden              
$myFile = 'nocopyimages.txt' ;    
                                  
$fh       = fopen($myFile, 'r');  
$naam     = fgets($fh);                  
$not_copy    = $naam;        

while ( $naam <> ''){      
$not_copy    .= $naam;
$naam         = fgets($fh);
} /// while

$parts = explode("/", $prog_url);
$dir = "../".$parts[3]."/images";

$dir = 'images/'; 

// Als pagina terugkomt van pag 2 , parameters uitpakken. ** terugzetten naar # ivm problemen met string

$check_qrc  = 'Yes';
$copy_page  = '';
$opmerkingen = 'Typ hier evt opmerkingen.'; 
$afb_grootte  = $afbeelding_grootte;

if (isset($_GET['parameters'])){
	$_parameters         = $_GET['parameters'];
	$params             = explode("$", $_parameters);
	$achtergrond_kleur  = str_replace ('**', '#',$params[0]);
  $tekstkleur         = str_replace ('**', '#',$params[1]);
  $koptekst           = str_replace ('**', '#',$params[2]);
  $url_afbeelding     = $params[3];
  $afb_grootte        = $params[4];
	$check_qrc          = $params[5];
	$copy_page          = $params[6];
	$check_text         = $params[7];
	$opmerkingen        = $params[8];
	$logo_width         = $params[9];
	$logo_height        = $params[10];
	$check_soort        = $params[11];
	$afb_width          = $params[12];
	$afb_height         = $params[13];
	$toernooi_naam      = $params[14];
	$_vereniging        = $params[15];
	
	
	
	
	
/*	
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[0]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[1]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[2]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[3]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[4]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[5]."<br>" ;
	echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".$params[6]."<br>" ;
*/

} // end if get

if ($toernooi_naam =='') {
	$toernooi_naam = $toernooi_voluit;
}



?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $_vereniging ?></TD>
</tr>
<tr><td STYLE ='font-size: 24pt; color:red;'><?php echo $toernooi_voluit ?>	</TD></tr>
</TABLE>
</div>
<hr color='red'/>
             
<span style='text-align:right;font-size:8pt'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
<?php

echo "<blockquote>";

echo "<h2 style='color:blue;font-family:verdana;font-size:24;'>Aanmaak PDF flyer voor '".$toernooi_voluit."' <img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =50 ></h2><br>";

?>
<div STYLE ='font-size: 10pt; color:black;'>In de onderstaande tabel staan de instellingen voor de PDF flyer. Deze instellingen komen overeen met het bijbehorende inschrijfformulier. Klik op 'Aanmaak PDF Flyer' voor een PDF flyer met deze standaard opmaak. Of verander één of meer instellingen en klik dan op 'Aanmaak PDF Flyer'.
	<br>Als er een <b>QR code</b> is aangemaakt, zal deze worden opgenomen in de flyer.
</div>
	
<FORM action="create_PDF_flyer_stap2.php" method=post name = "myForm"`>

<input type='hidden' name='toernooi'   value  = '<?php echo $toernooi;?>'>
<!--input type='hidden' name='vereniging' value  = '<?php echo $vereniging;?>'-->

<blockquote>	
	<INPUT type='submit' value='Aanmaak PDF flyer'>
	
<table border =1 width=80% name ='myTable' cellpadding=2>
	<tr>
		<th width=30%>Instelling</th>
		<th width=30%>Invoer veld</th>
		<th width=40%>Voorbeeld</th>
	</tr>
	
<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Vereniging<br>
			<span width=95% style='color:black;font-size:8pt;'>Deze informatie wordt op de flyer gezet.
			</td>
		<td STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
		     	<input type='text' name='_vereniging' value ='<?php echo $_vereniging; ?>' size =40>
   	</td>	
		<td id = 'Cel0' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;font-weight:bold;color:<?php echo strtoupper($koptekst);?>;padding-left:10pt;'><?php echo $_vereniging; ?>.</td>
  
</tr>  
	
	
	
	
<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Toernooi naam<br>
			<span width=95% style='color:black;font-size:8pt;'>Deze informatie wordt op de flyer gezet.
			</td>
		<td STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
		     	<input type='text' name='toernooi_naam' value ='<?php echo $toernooi_naam; ?>' size =40>
   	</td>	
		<td id = 'Cel0' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;font-weight:bold;color:<?php echo strtoupper($koptekst);?>;padding-left:10pt;'><?php echo $toernooi_naam; ?>.</td>
  
</tr>  
	
		<tr>
		<td STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Achtergrondkleur flyer<br>
		   	<span width=95% style='color:black;font-size:8pt;text-align:justify;'>Typ een waarde of selecteer uit de lijst.
				<br>Kijk voor de kleurcodes bij Kleurpalet in configuratie beheer. 
				<br>De waarde van het inschrijf formulier is standaard ingevuld.</span></td>
		<td STYLE ='font-size: 10pt; color:black;padding-left:25pt;'><input TYPE="TEXT" NAME="achtergrond_kleur" SIZE="9" class="pink"  value = "<?php echo strtoupper($achtergrond_kleur);?>">
		<br>	
		<SELECT name='' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:90px;'  id="selectBox1" onchange="changeFunc1();">
  	
  	  <option style='color:#FFFFFF;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($achtergrond_kleur);?>' selected><?php echo strtoupper($achtergrond_kleur);?></option>
  	  <option style='color:#FFFFFF;background:blue'                             value='blue' >Blauw</option>
  	  <option style='color:#FFFFFF;background:yellow'                           value='yellow' >Geel</option>
  	  <option style='color:#FFFFFF;background:darkgreen'                        value='darkgreen' >Groen</option>  	  
  	  <option style='color:#FFFFFF;background:orange'                           value='orange' >Oranje</option>  	  
  	  <option style='color:#FFFFFF;background:red'                              value='red'   >Rood</option>
  	  <option style='color:#000000;background:white'                            value='white' >Wit</option>
  	  <option style='color:#FFFFFF;background:black'                            value='black' >Zwart</option>
 <?php   
      while($row = mysql_fetch_array( $qry_kl1 )) {
 	    
	      echo "<OPTION style='color:#FFFFFF;background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
	      
    	
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie achtergrond
     ?>
    </SELECT> 
</td>
<td id = 'Cel1'  style = 'background-color:<?php echo strtoupper($achtergrond_kleur);?>;'>.</td>
</tr>

<tr>
		<td  STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Selecteer standaard tekstkleur flyer <br>
	   	<span width=95% style='color:black;font-size:8pt;'>Typ een waarde of selecteer uit de lijst.
				<br>Kijk voor de kleurcodes bij Kleurpalet in configuratie beheer. 
				<br>De waarde van het inschrijf formulier is standaard ingevuld.</span></td>
	   <td  STYLE ='font-size: 10pt; color:black;padding-left:25pt;'">
	   
	   		<input TYPE="TEXT" NAME="tekstkleur" SIZE="9" class="pink"  value = "<?php echo strtoupper($tekstkleur);?>">
			<br>
			<SELECT name='tekstkleur' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:90px;'  id="selectBox2" onchange="changeFunc2();">
  	
  	  <option value='<?php echo strtoupper($tekstkleur);?>' selected><?php echo strtoupper($tekstkleur);?></option>
  	  <option style='color:blue;background:#FFFFFF;'          value='blue' >Blauw</option>
  	  <option style='color:yellow;background:#FFFFFF;'        value='yellow' >Geel</option>
  	  <option style='color:darkgreen;background:#FFFFFF;'     value='darkgreen' >Groen</option>  	  
  	  <option style='color:orange;background:#FFFFFF;'        value='orange' >Oranje</option>  	  
  	  <option style='color:red;background:#FFFFFF;'           value='red'   >Rood</option>
  	  <option style='color:white;background:#000000;'         value='white' >Wit</option>
  	  <option style='color:black;background:#FFFFFF;'         value='black' >Zwart</option>
  	  
   <?php   
      while($row = mysql_fetch_array( $qry_kl2 )) {
 	    
	      echo "<OPTION style='color:".$row['Kleurcode'].";background:#FFFFFF;'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
	      
    	
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie standaard tekst 
     ?>
    </SELECT>  
 
</td>
<td id = 'Cel2'  style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo strtoupper($tekstkleur);?>;padding-left:10pt;'>De standaard tekstkleur.</td>
</tr>

<tr>
		<td  STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Selecteer toernooinaam tekstkleur flyer <br>
	   	<span width=95% style='color:black;font-size:8pt;'>Typ een waarde of selecteer uit de lijst.
				<br>Kijk voor de kleurcodes bij Kleurpalet in configuratie beheer.</span></td>
			<td  STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
					<input TYLE='font-size:10pt;background-color:white;font-family: Courier;width:50px;' TYPE="TEXT" NAME="koptekst" SIZE="9" class="pink"  value = "<?php echo strtoupper($koptekst);?>">
			<br>
			<SELECT name='koptekst' STYLE='font-size:10pt;background-color:white;font-family: Courier;width:90px;'  id="selectBox3" onchange="changeFunc3();">
  	
  	  <option value='<?php echo strtoupper($tekstkleur);?>' selected><?php echo strtoupper($tekstkleur);?></option>
  	  <option style='color:blue;background:#FFFFFF;'          value='blue' >Blauw</option>
  	  <option style='color:yellow;background:#FFFFFF;'        value='yellow' >Geel</option>
  	  <option style='color:darkgreen;background:#FFFFFF;'     value='darkgreen' >Groen</option>  	  
  	  <option style='color:orange;background:#FFFFFF;'        value='orange' >Oranje</option>  	  
  	  <option style='color:red;background:#FFFFFF;'           value='red'   >Rood</option>
 	    <option style='color:white;background:#000000;'         value='white' >Wit</option>
  	  <option style='color:black;background:#FFFFFF;'         value='black' >Zwart</option>
   	  
   <?php   
      while($row = mysql_fetch_array( $qry_kl3 )) {
 	    
	      echo "<OPTION style='color:".$row['Kleurcode'].";background:#FFFFFF;'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
	      
    	
    	  echo "</keuze></OPTION>";	
    	 }  // end while kleur selectie standaard tekst 
     ?>
    </SELECT>  
    
</td>
<td id = 'Cel3' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;font-weight:bold;color:<?php echo strtoupper($koptekst);?>;padding-left:10pt;'><?php echo $toernooi_voluit; ?></td>
</tr>
<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Tekst soort toernooi<br>
			<span width=95% style='color:black;font-size:8pt;'>Deze informatie wordt op de flyer gezet.
			</td>
		<td STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
			
     	<?php
     	if ($check_soort =='Yes'){ ?>
     	<input type='checkbox' name='check_soort' value ='Yes' checked>Vink deze aan om de tekst op te nemen in PDF.
    <?php } else { ?>    	
     	<input type='checkbox' name='check_soort' value ='Yes' >Vink deze aan om tekst op te nemen in PDF.
     <?php } ?>	
			</td>	
		<td id = 'Cel4' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;font-weight:bold;color:<?php echo strtoupper($koptekst);?>;padding-left:10pt;'><?php echo $soort; ?> toernooi.</td>
  
</tr>  
<tr>
		<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Grootte van logo op flyer <br>
			<span width=95% style='color:black;font-size:8pt;'>De waarde van de grootte van het logo in het voorbeeld hiernaast komt niet overeen met de grootte op de flyer.
				<i><br>Varieer met de grootte van het logo om de flyer op 1 pagina te houden.</i>
</span></td>
		<td  STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
		
		<?php 
		$size = getimagesize ($url_logo);   
		
		/* geeft array terug met vier elementen. 
       Op index 0 staat de breedte van de tekening in pixels, op index 1 staat de hoogte.
       index 2 geeft een getal weer dat staat voor het type afbeelding;
       Index 2 geeft een getal weer dat staat voor het type afbeelding;
       1 = GIF
       2 = JPG
       3 = PNG
       4 = SWF
       5 = PSD
       6 = BMP
       7 = TIFF(intel byte order)
       8 = TIFF(motorola byte order)
       9 = JPC
       10 = JP2
       11 = JPX
       12 = JB2
       13 = SWC
       14 = IFF
       Op index 3 staat een tekst string met de hoogte en breedte die direct in een HTML IMG tag gebruikt kan worden. (dus index 3 van de array = height="yyy" width="xxx")
       */
       
       
  	   if ($logo_width ==''){
  	   	   $logo_width  = $size[0];
  	   	}
  	   if ($logo_height ==''){
  	   	   $logo_height  = $size[1];
  	   	}
  	  ?>	   
		
		
Breedte <input type='text' name ='logo_width'  value ='<?php echo $logo_width;?>'  size=3 />  
Hoogte  <input type='text' name ='logo_height' value ='<?php echo $logo_height;?>' size=3 />  
   
</td>
<td id = 'Cel5' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;padding-left:25pt;padding-top:5pt;padding-bottom:5pt;'><center><img src ='<?php echo $url_logo;?>' width=90  ></center></td>
</tr>
<tr>
		<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Selecteer afbeelding op flyer (uit Image Gallery)<br>
			<span width=95% style='color:black;font-size:8pt;'>De waarde van de grootte van de voorbeeld afbeelding hiernaast komt niet overeen met de werkelijke grootte op de flyer.
				<i><br>Varieer met de grootte van de afbeelding om de flyer op 1 pagina te houden.</i>
</span></td>
		<td  STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
			<SELECT name='url_afbeelding' STYLE='font-size:9pt;background-color:white;font-family: Courier;width:200px;' id="selectBox4" onchange="changeFunc4();">
  	
  	  <?php 
     if ($url_afbeelding !=''){ ?>
  	    <option value='<?php echo $url_afbeelding;?>' selected><?php echo $url_afbeelding;?></option>
  	    <option value='' >Geen afbeelding</option>
  	  <?php } else {?> 
  	    	  <option value='' selected>Geen afbeelding</option>
     <?php } 
 
 
// bestanden ophalen op image dir
      if ($handle = @opendir($dir)) {
      while (false !== ($file = @readdir($handle))) { 
        $bestand = $dir ."/". $file ;
         echo $bestand;
         
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
         
         if (strlen($file) > 3  and strpos($not_copy,$file) == false  and (strtoupper($ext) == 'JPG' or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG' or strtoupper($ext) == 'BMP')) {
           
            $file1 = explode("/",$bestand);
             ?>
                 <option value='<?php echo $bestand;?>' style="background-image:url(images/<?php echo $file;?>);background-repeat:no-repeat; padding-left:30px;"><?php echo $file;?></option>          
            <?php
         }// end if strln
 
  }// end while    	 
    	 
@closedir($handle);     
} // end if    	 

		$size = getimagesize ($url_afbeelding);   
		
		/* geeft array terug met vier elementen. 
       Op index 0 staat de breedte van de tekening in pixels, op index 1 staat de hoogte.
       index 2 geeft een getal weer dat staat voor het type afbeelding;
       Index 2 geeft een getal weer dat staat voor het type afbeelding;
       1 = GIF
       2 = JPG
       3 = PNG
       4 = SWF
       5 = PSD
       6 = BMP
       7 = TIFF(intel byte order)
       8 = TIFF(motorola byte order)
       9 = JPC
       10 = JP2
       11 = JPX
       12 = JB2
       13 = SWC
       14 = IFF
       Op index 3 staat een tekst string met de hoogte en breedte die direct in een HTML IMG tag gebruikt kan worden. (dus index 3 van de array = height="yyy" width="xxx")
       */
  	   if ($afb_width ==''){
  	   	   $afb_width  = $size[0];
  	   	}
  	   if ($afb_height ==''){
  	   	   $afb_height  = $size[1];
  	   	}
  	  ?>	   

   </SELECT>
   
<!--Grootte <input type='text' name ='afb_grootte' value ='<?php echo $afb_grootte;?>' size=5 />  --->
<br>
Breedte <input type='text' name ='afb_width'  value ='<?php echo $afb_width;?>'  size=3 />  
Hoogte  <input type='text' name ='afb_height' value ='<?php echo $afb_height;?>' size=3 />  

   
</td>
<td id = 'Cel6' style = 'background-color:<?php echo $achtergrond_kleur;?>;font-size:10pt;padding-left:25pt;padding-top:5pt;padding-bottom:5pt;'><center><img src ='<?php echo $url_afbeelding;?>' width=120 id='myIMG' ></center></td>
</tr>

<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>QR Code t.b.v inschrijf formulier <br>
			<span width=95% style='color:black;font-size:8pt;'>Deze barcode bevat een link naar het inschrijf formulier. Deze kan mbv een smartphone of tablet worden gescand.</span><br>
			<span width=95% style='color:black;font-size:8pt;'>Link naar programma om QR code aan te maken : <a href = 'create_qrcode_form.php?toernooi=<?php echo $toernooi;?>' target='_blank'>Link</a><br>
			</td>
		<td   STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
		<?php
		$url       = explode("/",$prog_url);
    $qrc_link  = "images/qrc/qrcf_".$toernooi.".png";
    
     if (file_exists($qrc_link)) {   ?>
     	
     	<?php
     	if ($check_qrc =='Yes'){ ?>
     	<input type='checkbox' name='check_qrc' value ='Yes' checked>Vink deze aan om QR Code op te nemen in PDF.
    <?php } else { ?>    	
     	<input type='checkbox' name='check_qrc' value ='Yes' >Vink deze aan om QR Code op te nemen in PDF.
     <?php } ?>	
     	
    <?php } else {?>
    	.
    	<?php }  ?> 
  </td>
  <td  id = 'Cel7' style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo strtoupper($tekstkleur);?>;'><center>
   	<?php
   	if (file_exists($qrc_link)) {   ?>
   	<img src ="<?php echo $qrc_link; ?>" width=80 border =0  style="text-align:center;" >
   <?php } 
     else { ?>
     	<div style= 'color:red;font-size:11pt;text-align:center;'>QR code is niet aanwezig</div>
   <?php }    ?> 
  </center></td>
</tr>  

<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Extra informatie<br>
			<span width=95% style='color:black;font-size:8pt;'>Deze informatie wordt op de flyer gezet.
			</td>
		<td STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
			
     	<?php
     	if ($check_text =='Yes'){ ?>
     	<input type='checkbox' name='check_text' value ='Yes' checked>Vink deze aan om de tekst op te nemen in PDF.
    <?php } else { ?>    	
     	<input type='checkbox' name='check_text' value ='Yes' >Vink deze aan om tekst op te nemen in PDF.
     <?php } ?>	
			</td>	
			
		<td id ='Cel8'  style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo strtoupper($tekstkleur);?>;font-size: 10pt; color:black;padding-left:25pt;' colspan =1>
		<textarea name='opmerkingen' onfocus="change(this,'black','lightblue');" onfocus="clearFieldFirstTime(this);"
            	   onblur="change(this,'black','#F2F5A9');" rows='4' cols='65' onclick="make_blank();"><?php echo $opmerkingen; ?> </textarea>
  </td>
  
</tr>  

<tr>
<td width=300 STYLE ='font-size: 10pt; color:blue;padding-left:25pt;'>Aanmaak A5 strooibiljet<br>
			<span width=95% style='color:black;font-size:8pt;'>Door een kopie van de flyer op de tweede pagina te zetten, is het mogelijk twee flyers naast elkaar op een A4 te printen (instelling printer bij afdrukken).<br>Een aanwezige QR code is groot genoeg om zelfs op A5 formaat te kunnen scannen.</span><br>
			</td>
		<td  STYLE ='font-size: 10pt; color:black;padding-left:25pt;'>
			<?php
     	if ($copy_page =='Yes'){ ?>
     	<input type='checkbox' id= 'check' name='copy_page' value ='Yes' onchange  ="changeImage('../ontip/images/PDF_flyer_2page.jpg','../ontip/images/PDF_flyer_1page.jpg',125,200 );" checked>Vink deze aan om twee pagina's aan te maken in de PDF.
     <?php } else { ?> 
     	<input type='checkbox' id= 'check' name='copy_page' value ='Yes' onchange = "changeImage('../ontip/images/PDF_flyer_2page.jpg','../ontip/images/PDF_flyer_1page.jpg',200,125);">Vink deze aan om twee pagina's aan te maken in de PDF.
     	<?php } ?> 
     	
  </td>
  <td id ='Cel9' style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo strtoupper($tekstkleur);?>;vertical-align:middle;'><center>
  	<?php
  	if ($copy_page =='Yes'){ ?>
  	  	 	<img id ='img' src = '../ontip/images/PDF_flyer_2page.jpg' >
  	 <?php } else { ?> 	 	
  	 	 	<img id ='img' src = '../ontip/images/PDF_flyer_1page.jpg' >
  	  <?php } ?>	 	  	 	
  	  </center>
  	 </td>
</tr>  
</table>		
</blockquote>
</form>
