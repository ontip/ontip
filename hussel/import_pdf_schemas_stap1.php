<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 10pt;}
td {color:black;font-size: 12pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}


#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }


</style>

<!---/// Mouse over voor aan/uit zetten images--->

<script type="text/javascript">
function img_uitzetten(i){
	      i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/homeoff.jpg";break;
        case 2:
           document.getElementById('print').src="images/printer.jpg";break;
        }
}

</script>

<script type="text/javascript">
function img_aanzetten(i){
        i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/home.jpg";break;    
        case 2:
           document.getElementById('print').src="images/printerleeg.jpg";break;  
         }
}
<!----// Javascript voor input focus ------------>

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
 }
     
</script>
</head>
<body>


<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);


//// Database gegevens. 

include ('mysqli.php');


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

if ($jaar <> date('Y') ){
	$datum_string = strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
} else {
	$datum_string = strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );
}	

echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". $datum_string."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>
<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' >Naar scores</a>
</td></tr>
</table>
<br>
<br>
<br>

<h2>Upload PDF schema's tbv baan toewijzing </h2>

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Met behulp van deze functie kan je een pdf bestand met baan toewijzing importeren in OnTip hussel.
		<br>Geef het aantal deelnemers op en de naam van het bestand.</div>
<br>



<?php

// set max file size for upload (500 kb)
$max_file_size = 500000000;

	
?>
<form action="import_pdf_schemas_stap2.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.boulamis.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<table width=65% border = 0>
	<tr>
		<td width=45%>Wat is het aantal deelnemers  ?</td><td><input type=text size=4 name= 'aantal' ></td>
	</tr>
	<tr>
<td style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>Selecteer het bestand (PDF) voor upload (klik op Browse/Bladeren..):  </td>
<td style='text-align:right;vertical-align:text-top;width:100pt;'><input   name="userfile" type="file" size="40">
	<input type="submit" name="submit" value="Upload en importeer bestand" />
	
	</td>
</tr>
</table>
</form>


<fieldset style='border:1px solid red>;width:95%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:black;font-size:14px;font-family:Arial;'>PDF bestanden op het systeem</legend>


<table width= 90% border =0  style='font-weight:bold;font-size:12pt;'>



<?php
$i=1;

$dir = "pdf";
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}

$j=1; 

?>
<tr>
	<?php
foreach ($files as $file) {
   	
        $bestand = $dir ."/". $file ;
          
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
   
         
         if (strlen($file) > 3    and (strtoupper($ext) == 'PDF' )) {
            ?>
            
            <td width = 25% style='font-size:12pt;color:blue;' ><img src="images/pdf_ontip_logo.gif" width=32>&nbsp<a href ="<?php echo $bestand ?>" target ='_blank'><?php echo $file; ?></a>
            </td>
            
            
            <!--td style='font-size:10pt;color:black;text-align:right;vertical-align:bottom;padding:0pt;'><?php echo date ("d F Y H:i:s.", filemtime($bestand)); ?></td-->
            <!--td width = 25% style='font-size:10pt;color:black;text-align:left;vertical-align:bottom;padding:6pt;'>voor <?php echo $aantal; ?> deelnemers</td-->
            
           <?php
            if ($j==4) { ?>
            </tr>
            <tr>
            <?php 
            $j=1;
             } else {
          	$j++;
              }
        }// end if strln
  
  }// end fotr
  


  

?>	

</tr></table>
</fieldset>
<br>
<span style ='font-size:10pt;color:darkgreen;'> Met dank aan De Gemshoorn</span>
<br>
<br>
<div style='font-size:10pt;color:blue;' >Klik op de bestandsnaam om de inhoud te bekijken en/ of te bewaren.</div>


</center>

<br>


</body>
</html>

