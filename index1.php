<html>
	<Title>OnTip</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
  	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

    <base target="_blank">
     <? include ("js/javalib.php"); ?> 
<style>

BODY {color:black ;font-size: 9pt ; font-family: verdana;background-color:white;}
TH {color:black ;font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {font-size: 8.0pt ; font-family:Arial, Helvetica ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:darkblue; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
input {font-size:8.5pt;color:blue;}

 IMG.HoverBorder {border:0px solid #eee;}
 IMG.HoverBorder:hover {border:3px solid #555;}
 
 .tegel {background-color:blue;color:white;width:180pt;height:80pt; -moz-border-radius-topleft: 5px;
   -webkit-border-top-left-radius: 5px;
   -moz-border-radius-topright: 5px;
   -webkit-border-top-right-radius: 5px;
   -moz-border-radius-bottomleft: 5px;
   -webkit-border-bottom-left-radius: 5px;
	 -moz-border-radius-bottomright: 5px;
   -webkit-border-bottom-right-radius: 5px;font-size:14pt;font-family:verdana;padding:5pt;vertical-align:middle;
   border:2pt solid  #000000;box-shadow: 4px 4px 4px #888888;}


 .tegel2 {background-color:darkgreen;color:white;width:180pt;height:80pt; -moz-border-radius-topleft: 5px;
   -webkit-border-top-left-radius: 5px;
   -moz-border-radius-topright: 5px;
   -webkit-border-top-right-radius: 5px;
   -moz-border-radius-bottomleft: 5px;
   -webkit-border-bottom-left-radius: 5px;
	 -moz-border-radius-bottomright: 5px;
   -webkit-border-bottom-right-radius: 5px;font-size:14pt;font-family:verdana;padding:5pt;vertical-align:middle;
   border:2pt solid  #000000;box-shadow: 4px 4px 4px #888888;}



img.tegel {
	img {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  width: auto; /* to keep proportions */
  height: auto; /* to keep proportions */
  max-width: 100%; /* not to stand out from div */
  max-height: 100%; /* not to stand out from div */
  margin: auto auto 0; /* position to bottom and center */
}


   
  .tegel:hover  {background-color:white;color:blue;}
 
 
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

function showMore(text){
    document.getElementById("menutekst").innerHTML = text";
}
</script>

</head>
<?php 
ob_start();
// Database gegevens. 
include('mysql.php');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

include('div_collect_data.php');	

if (isset($_GET['toernooi']) ){
	$toernooi = $_GET['toernooi'];
}


?>
<body BACKGROUND="../ontip/images/ontip_grijs.jpg" width =40 bgproperties=fixed  onload="blink();" >

<!---  div gecentreerd met afgeronde hoeken------------>
<center>

<div style='background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;color:black;width:1200pt;border:2pt solid black;height:1200pt; -moz-border-radius-topleft: 10px;
   -webkit-border-top-left-radius: 10px;
   -moz-border-radius-topright: 10px;
   -webkit-border-top-right-radius: 10px;
   -moz-border-radius-bottomleft: 10px;
   -webkit-border-bottom-left-radius: 10px;
	 -moz-border-radius-bottomright: 10px;
   -webkit-border-bottom-right-radius: 10px;'>
  
<?php 
 /// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'J';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}  
?>  
 <div>
	<?php include ("paginakop.php"); ?> 		
</div>

 <!--- plaatjes balk ------------------------------------//--------------->
<div  >
<?php include ("plaatjes_balk.php"); ?> 
</div>

<center>
	<div style='width:90%;background-color:white;'>
		<?php include ('div_selectie_toernooi.php');?>
	</div>
</center>
<br>
<blockquote>
	<div style='width:90%;background-color:white;text-align:left;border:4pt inset;'>
		
		  <table  border =0  width=100%>
		  	
         <tr>
         	<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Toernooi toevoegen<br><br>
		  				<div style='text-align:right;padding:5pt;'><img align='bottom' src='../ontip/images/plus.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  		
		  		<?php if ($aantal_toernooien > 0){?>
		  		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Inschrijven<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/mensen.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Inschrijven<br>eigen leden<br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/mensen.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  			<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Inschrijvingen aanpassen<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/muteren.png' border = 0 width =65 alt ='' ></div>
		  			</div>
		  		</td>
	 			</tr>
		  	<tr>	
		  		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Formulier aanpassen<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/Icon_tools.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  	
		  		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Lijsten<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/list_all_participants.png' border = 0 width =45 alt ='' ></div>
		 			</div>
		  		</td>
		
		  		<td style='padding:25pt;'>
		  			<div class='tegel' onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Bevestigingen<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/icon_bevestigen.png' border = 0 width =45 alt ='' ></div>
		  			</div>
  	  		</td>
	  	  	
		  		<td style='padding:25pt;'>
		  			<div class='tegel' onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Reserveringen<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/reservation-icon.png' border = 0 width =45 alt ='' ></div>
	  			</div>
  	  		</td>
  	</tr>
		<tr>  
  	 	 	 	<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Toernooi verwijderen<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/prullenbak.png' border = 0 width =45 alt ='' ></div>
		 			</div>
		  		</td>
  	 	 	 	<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				QRC en PDF<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/pdf_logo.png' border = 0 width =45 alt ='' ></div>
		 			</div>
		  		</td>
  	  		<td style='padding:25pt;'>
		  			<div class='tegel' onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Export en Import<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/data-import-export.gif' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  	
		  		<td style='padding:25pt;'>
		  			<div class='tegel' onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				OnTip SMS<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/SMS_logo.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  	</tr>
		  	<tr>
		   		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				IDEAL<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/ideal_logo.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		 	
			  		<td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Overig
		  			</div>
		  		</td>
  	     <td style='padding:25pt;'>
		  			<div class='tegel'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Kalenders<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/kalender.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		</td>
		  		</tr>
		  	<tr>
		  				<td style='padding:25pt;'>
		  			<div class='tegel2'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Uitleg<br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/uil.png' border = 0 width =45 alt ='' ></div>
		  			</div>
		  		<?php }  ?>	
		  				<td style='padding:25pt;'>
		  			<div class='tegel2'  onmouseover="this.style.border = '1px solid #ffff00'; this.style.color = 'yellow'" onmouseout="this.style.border = '2px solid #000000'; this.style.color = 'white'">
		  				Handleiding<br><br>
		  				<div style='text-align:right;'><img align='bottom' src='../ontip/images/handleiding.png' border = 0 width =45 alt ='' ></div>
			  			</div>
		  			
		  		</td>

		  	</tr>
		  </table>
		
	</div>
</blockquote>
<br>
<br>
 <div style='text-align:right;font-size:8pt;color:black;margin-right:30pt;'><img src = '../ontip/images/ontip_logo_zonder_bg.png' width='220'></div>
	
<!-----   einde centrale div----------------------------//----------------> 
</div>
</center>


<div style='padding-bottom:5pt;text-align:center;font-size:8pt;'  id= 'footer'>Website design : (c) Erik Hendrikx, Bunschoten 2017</div>

</body>
</html>
	
	