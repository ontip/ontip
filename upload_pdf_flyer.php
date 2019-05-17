<html
<head>
<title>Upload PDF flyer</title>
<style type="text/css">
	body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:brown;font-size: 8pt;background-color:white;}

a    {text-decoration:none ;color:blue;}

td.menuon { border-color: red;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }

td.menuon2 { border-color: blue;border-width:2px; border-style:solid outset;font-size:14pt;}
td.menuoff { border-color: #FFFFFF;border-width:2px;font-size:14pt;  }

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


</script> 

</head>
<body>
	
<script language="javascript">
 document.title = "OnTip Upload Ledenlijst";
</script> 


<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>


<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>
	
<?php

// Database gegevens. 
include('mysqli.php');
ob_start();
?>


<div style='padding:10pt;font-size:20pt;color:green;'><br>Upload PDF flyer <img src="../ontip/images/file_upload_icon.jpg" width=50 border =0 ></div>
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

//// Check op rechten

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

$qry            = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     ;
$row            = mysqli_fetch_array( $qry );
$prog_url       = $row['Prog_url'];

$toernooi = $_GET['toernooi'];


// set max file size for upload (500 kb)
$max_file_size = 500000;

	
?>
<form action="upload_pdf_bestand.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.boulamis.nl">
<input type="hidden" name="toernooi" value="<?php echo $toernooi;?>">

<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<div style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Een eigen PDF flyer kan met deze functie worden geupload.<br> Deze kan vervolgens in de algemene OnTip toernooi kalender geopend worden.
	In het <b>Inschrijfformulier met spelers selectie</b> kan deze vervolgens gebruikt worden.</div>
<br>



<table width=90% border = 0 >
	<tr>
<td width = 50% style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>Selecteer een PDF bestand voor upload (klik op Browse/Bladeren..):  </td>
<td style='text-align:right;vertical-align:text-top;width:100pt;'><input   name="userfile" type="file" size="30"><br>
	<input type="submit" name="submit" value="Upload bestand" />
	
	</td>
</tr>



</table>
</form>
<fieldset style='border:1px solid red>;width:65%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:black;font-size:14px;font-family:Arial;'>PDF Bestand(en)  op het systeem</legend>


<table border =0  style='font-weight:bold;font-size:14pt;'>



<?php
$i=1;

$parts = explode("/", $prog_url);
$dir   = "../".$parts[1]."csv";

$dir =  $prog_url.'/csv';

//echo $dir. "<br>";
 
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
     
         
         if (strlen($file) > 3    and (strtoupper($ext) == 'PDF' )) {
              
                 
            ?>
            <tr>
            <td width = 50% style='font-size:12pt;color:blue;' ><img src="../ontip/images/icon_pdf.jpg" width=32>&nbsp<a href ="<?php echo $bestand ?>" target ='_blank'><?php echo $file; ?></a>
            	
            	<?php if ($file =='licensies_vereniging.csv'){
            		echo "<span style='font-size:9pt;color:red;'>&nbsp(Actief bestand* )</span>";
            	}
            	?>
            	
            	</td>
            <td style='font-size:10pt;color:black;text-align:right;vertical-align:bottom;padding:0pt;'><?php echo date ("d F Y H:i:s.", filemtime($bestand)); ?></td>
					</tr>

           <?php 
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

</tr></table>
</fieldset>
<br>
<br>
<div style='font-size:10pt;color:blue;' >Klik op de bestandsnaam om de inhoud te bekijken en/ of te bewaren.</div>
<br>
<div style='font-size:10pt;color:black;' >* Het bestand ledenlijst <b>licensies_vereniging.csv</b> wordt gebruikt voor de selecties van leden in het inschrijfformulier (alleen voor beheerders).</div>


</center>

<br>


</html>
