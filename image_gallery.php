<?php 
# image_gallery.php
# beheer van images vor de webpagina
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 8mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 
?>
<html
<head>
<title>Image Gallery</title>
<style type="text/css">
	body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
table {border-collapse:collapse;color:grey;}

th {color:brown;font-size: 8pt;background-color:white;}
td {color:brown;font-size: 10pt;background-color:white;}
a  {text-decoration:none ;color:blue;font-size: 9pt;}
h4 {color:brown;font-size: 12pt;background-color:white;}

td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuon2 { border-color: blue;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: black;border-width:2px;font-size:14pt;  }

a.LinkButton {
  border-style: solid;
  border-width : 1px 1px 1px 1px;
  background: darkgreen;
  text-decoration : none;
  font-size:8pt;
  color:white;
  padding : 2px;
  border-radius: 2px;
  border-color : #000000
}

.stylish-button {
    -webkit-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
    -moz-box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
    box-shadow:rgba(0,0,0,0.2) 0 1px 0 0;
    background-color:darkgreen;
    border-radius:5px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:none;
    font-size:9px;
    color:white;
    font-weight:700;
    padding:4px 16px;
    text-shadow:#FE6 0 1px 0
}


.file_input_textbox
{
	float: left
}

.file_input_div
{
	position: relative; 
	width: 270px; 
	height: 23px; 
	overflow: hidden;
}

.file_input_button
{
	width: 270px; 
	position: absolute; 
	top: 0px;
	background-color: #33BB00;
	color: #FFFFFF;
	border-style: solid ;
	border-width:1px;
	border-color:black;
}

.file_input_hidden
{
	font-size: 45px; 
	position: absolute; 
	right: 0px; 
	top: 0px; 
	opacity: 0; 
	
	filter: alpha(opacity=0); 
	-ms-filter: "alpha(opacity=0)"; 
	-khtml-opacity: 0; 
	-moz-opacity: 0;
}
.img-shadow { 
float:right; 
background: url(trans-shadow.png) no-repeat bottom right; /* Most major browsers other than IE supports transparent shadow. Newer release of IE should be able to support that. */ 
}

.img-shadow img { 
display: block; /* IE won't do well without this */ 
position: relative; /* Make the shadow's position relative to its image */ 
padding: 5px; /* This creates a border around the image */ 
background-color: #fff; /* Background color of the border created by the padding */ 
border: 1px solid #cecece; /* A 1 pixel greyish border is applied to the white border created by the padding */ 
margin: -6px 6px 6px -6px; /* Offset the image by certain pixels to reveal the shadow, as the shadows are 6 pixels wide, offset it by that amount to get a perfect shadow */ 
}

</style>

<script type="text/javascript"> 
function sendToClipboard(s) 

{ 
if( window.clipboardData && clipboardData.setData ) 
{ 
clipboardData.setData("Text", s); 
alert('Image  ' + s + ' is geselecteerd. \nSelecteer, na sluiten van dit scherm, in het config scherm bij url_afbeelding de Paste functie of \nzet de cursor in het inputveld en druk CTRL-V ');
document.getElementById("div2").innerText = window.clipboardData.getData("Text");
document.getElementById("div2").style.backgroundColor = window.clipboardData.getData("Text"); 

} 
else 
{ 
alert("Internet Explorer required"); 
} 
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
 

var newwindow = ''
function popitup(url) {
if (newwindow.location && !newwindow.closed) {
    newwindow.location.href = url; 
    newwindow.focus(); } 
else { 
    newwindow=window.open(url,'htmlname','width=404,height=316,resizable=1');} 
}

function tidy() {
if (newwindow.location && !newwindow.closed) { 
   newwindow.close(); } 
}

</script> 

</head>
<body >
	

<?php

// Database gegevens. 
include('mysqli.php');
ob_start();

$id       = 'url_afbeelding';
$toernooi = $_GET['toernooi'];

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

// uit vereniging tabel	
	
$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];


if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}


?>
<script language="javascript">
 document.title = "OnTip Image Gallery - <?php echo  $toernooi_voluit; ?>";
</script> 

<div style='background-color:white;'>
<table >
<tr><td rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; color:green ;'>Toernooi inschrijving <?php echo $_vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>

<hr color='red'/>

<table width=100% border = 0>
	<tr>
		<td style='vertical-align:text-top;' colspan =2 width = 370>
<span style='text-align:right;vertical-align:text-top;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>

<?php if (isset($toernooi)){ ?>
<span style='text-align:right;'><a href='beheer_ontip.php?toernooi=<?php echo $toernooi;?>&tab=4'>Terug naar Configuratie</a></span><br>
<?php } ?>
<br><span style='color:green;font-size:32;'>OnTip Image Gallery <img src='../ontip/images/image_gallery.png' width=80 border =0 ></span></td>
<td width=300 align=center vertical-align=bottom><span class="img-shadow">
	
	<?php if ($url_afbeelding == ''){   ?>
       Er wordt nu geen plaatje gebruikt.
  <?php } else { ?>     	
	<img  src ='<?php echo $url_afbeelding; ?>' width=120 border =0></span><br><br>
	Huidige afbeelding<br><span style='color:blue;font-size:10;'><?php echo $url_afbeelding; ?></span>
	
<?php } ?>
	
	</td>
<td width=70 align=center></td>
<?php

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


if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

// set max file size for upload (1000 kb)
$max_file_size = 1000000;
//$max_file_size = 500;
	
?>
<form action="upload_image_gallery.php" method="POST" enctype="multipart/form-data">
	<?php
	
  $url_hostName   = $_SERVER['HTTP_HOST'];
  $ftp_server     ='ftp.ontip.nl'; 
  //$ftp_dir        = substr($prog_url,3,-1).'images/'; 


?>
<input type="hidden" name="server"   value="<?php echo $ftp_server;?>">
<input type="hidden" name="toernooi" value="<?php echo $toernooi; ?>">
<input type="hidden" name="url"      value="<?php echo $prog_url; ?>">

<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<td style='vertical-align:top;'>

<fieldset style='border:1px solid green;'><legend style='padding:4px;color:red;'>Import eigen afbeeldingen (upload)</legend>
<input type="text" id="fileName" class="file_input_textbox" readonly="readonly">
 
<div class="file_input_div" >
  <input type="button" value="Zoek naar plaatjes bestand (max 1 Mb)" class="file_input_button" />
  <input type="file" name ="userfile" class="file_input_hidden" onchange="javascript: this.form.fileName.value = this.value" />
</div>
    
   <input type="submit" name="submit" value="Upload bestand" />
</fieldset>

	</td>
</tr>
</table>
</form>

<br>
<h4>Kies een bestand uit deze tabel</h4>


<?php
/// Verwerk bestand met files die niet getoond moeten worden              
$myFile = 'nocopyimages.txt' ;    
                                  
$fh       = fopen($myFile, 'r');  
$naam     = fgets($fh);                  
$not_copy    = $naam;        

while ( $naam <> ''){      

$not_copy    .= $naam;
$naam         = fgets($fh);
} /// while

fclose($fh);
?>

<FORM action='update_config.php' method='post'>
<span style='color:black;font-size:10pt;font-family:arial;'>Selecteer het plaatje van je keuze. Klik daarna op 'Keuze bevestigen'. De naam van de afbeelding wordt hiermee direct overgenomen in de configuratie (en hiermee in het inschrijf formulier).<br>Door hier op het plaatje te klikken verschijnt het plaatje groter in een popup window. <span style='color:red;font-weight:bold;'> <B>UPLOAD GEEN PLAATJES WAAR AUTEURS- of BEELDRECHT OP RUST. EVENTUELE CLAIMS ZULLEN WORDEN DOOR VERWEZEN NAAR DE VERENIGING !</span>
</span><br>
<center>
  	<!--a class = 'stylish-button'  href="" onclick="window.location.reload(true);return false;">Ververs pagina</a-->
		<INPUT style='background-color:blue;color:white;font-size:9pt;' type='submit' value='Keuze bevestigen'  style='background-color:red;color:white;'>
  </center><br>
	
			<input type='hidden' name ='Vereniging' value ="<?php echo $vereniging; ?>"/>
			<input type='hidden' name ='Toernooi'   value ="<?php echo $toernooi; ?>"/>
			<input type='hidden' name ='Variabele'  value ="url_afbeelding"/>
      <input type='hidden' name ='Bron'       value ="gallery"/>   
      
  <div style='background-color:grey;padding:10px;text-align:center;margin-left:15pt;margin-right:15pt;border:1pt inset black;'>
  	<center>
   <table border =1 style='font-weight:bold;font-size:14pt;'>
     <tr>
<?php
$i=1;
$dir = "images";


$j=1; 
if ($handle = @opendir($dir)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $bestand = $dir ."/". $file ;
          
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
         
         if (strlen($file) > 3  and strpos($not_copy,$file) == false  and (strtoupper($ext) == 'JPG' or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG' or strtoupper($ext) == 'BMP' )) {
           
           
           if ( ($bestand == $url_afbeelding)  and $url_afbeelding !=''){
            
            ?>
            <td class="menuoff" onmouseover="className='menuon2';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:#FFFFCC;' >
   
               <A HREF="javascript:popitup('<?php echo $bestand; ?>')" >
   	               <IMG SRC="<?php echo $bestand; ?>" WIDTH="100" HSPACE="5" vSPACE="5" BORDER="0" ALT="Maak groter door muisklik" ALIGN=center>
   	           </A> 
           	<br>
           	<center>In gebruik</center></span></td>
              
            <?php  } else { ?>
            	
            	<td class="menuoff" onmouseover="className='menuon2';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:white;' >
   
               <A HREF="javascript:popitup('<?php echo $bestand; ?>')" >
   	               <IMG SRC="<?php echo $bestand; ?>" WIDTH="100" HSPACE="5" vSPACE="5" BORDER="0" ALT="Maak groter door muisklik" ALIGN=center>
   	           </A> 
           	<br>
           	Selecteer <input type ='radio'  name ='Waarde' value ='<?php echo "images/".$file; ?>'  ></span></td>
            	
            <?php } ?>
   
           <?php 
           if ($i==10) { 	
           	   echo "</tr><tr>"; 
  	        	$i=1; 
  	        }
  	           else { 	$i++;   }
         }// end if strln
  $j++;
  }// end while
  
  if ($url_afbeelding == ''){   ?>
  <td class="menuoff" onmouseover="className='menuon2';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:#FFFFCC;vertical-align:middle';' >
  	<div style='padding:5 pt; color:red:font-size:14pt;text-align:center;border:1pt;'>Ik wil geen plaatje<br>gebruiken <?php echo $url_afbeelding; ?></div>
     </td>
  <?php } else { ?>
  <td class="menuoff" onmouseover="className='menuon2';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:white;' >
  	   <div style='padding:5 pt; color:red:font-size:14pt;text-align:center;background-color:white;border:1 pt;vertical-align:middle;'>Ik wil geen plaatje<br>gebruiken</div>
       <br><span style= 'vertical-align:bottom;'></span>Selecteer <input type ='radio'  name ='Waarde' value ='leeg'  ></span></td>
  <?php }
  
  
@closedir($handle);     
} // end if
?>	

</tr></table>
</center>
</div>
<br>
<center>
		<INPUT style='background-color:blue;color:white;font-size:9pt;' type='submit' value='Keuze bevestigen'  style='background-color:red;color:white;'>
  </center>
</form>

<hr color='red'/>

<table width=90%><tr>
	<td><h4>Verwijderen plaatjes</h4></td>
	<td text-align-right><img src='../ontip/images/prullenbak.jpg' width =75 border =0></td>
</tr>
</table>

<span style='color:black;font-size:10pt;font-family:arial;'>Vink de plaatjes aan die je wilt verwijderen en klik op de knop 'Verwijderen uitvoeren'. Er wordt niet om een bevestiging gevraagd !!!</span><br>
<br>

<form method = 'post' action='delete_images_gallery.php'>
	
	 <div style='background-color:grey;padding:10px;text-align:center;margin-left:15pt;margin-right:15pt;border:1pt inset black;'>
	 	<center>
<table border =1 style='font-weight:bold;font-size:14pt;'>
<tr>


<?php
$i=1;

$dir = "images";

 // echo $dir. "<br>";
 echo "<input type='hidden' name ='Imagedir'   value='".$dir."'/>";
 
$j=1; 
if ($handle = @opendir($dir)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $bestand = $dir ."/". $file ;
          
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
        //echo $file. "-".  $ext. "<br>";
        
        
         //echo strpos($not_copy,$file). "<br>";
     
         
         if (strlen($file) > 3  and strpos($not_copy,$file) == false  and (strtoupper($ext) == 'JPG' or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG' or strtoupper($ext) == 'BMP')) {
         
        if ( ($bestand == $url_afbeelding)  and $url_afbeelding !=''){
            ?>
             <td class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:#FFFFCC; '>
             	<img src = '<?php echo $bestand; ?>' alt='<?php echo $file;?>'  WIDTH="102" HSPACE="5" vSPACE="5" border =0 ALIGN=center><br><br>
             	<center>In gebruik</center></td>
           
         <?php } else { ?>
           
            <td class="menuoff" onmouseover="className='menuon';" onmouseout="className='menuoff'" style='font-size:8pt;color:blue;vertical-align:bottom;background-color:white;'>
             	<img src = '<?php echo $bestand; ?>' alt='<?php echo $file;?>'  WIDTH="102" HSPACE="5" vSPACE="5" border =0 ALIGN=center><br>
             	Verwijder <input type ='checkbox'  name ='file-<?php echo $j; ?>' value ='<?php echo $file; ?>' </td>
           
         <?php }
         
           if ($i==10) { 	
           	   echo "</tr><tr>"; 
  	        	$i=1; 
  	        }
  	           else { 	$i++;   }
         }// end if strln
  $j++;
  }// end while
  
@closedir($handle);     
} // end if
?>	
<input type='hidden' name ='Aantal'   value='<?php echo $j;?>'/>

</tr></table>
</center>
</div>
<br>
<center>
	
  <input style='background-color:red;color:white;font-size:9pt;' type = 'submit' value ='Verwijderen uitvoeren' />
</form>
</center>

<br>


</html>
