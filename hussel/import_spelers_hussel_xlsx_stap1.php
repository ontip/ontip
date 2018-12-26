<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 11pt;}
td {color:black;font-size: 12pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:8pt;}


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

include ('mysql.php');


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
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

<h2>Importeer spelers uit Excel(xlsx) bestand </h2>

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:10pt;font-family:arial;'>Met behulp van deze functie kan je een excel (xlsx) bestand met spelersnamen direct importeren in de score pagina. Geef ook de datum van gebruik op.<br>
	<b>De namen zijn dan alleen op die datum bekend in het systeem !!!</b><br>
		<br>De eerste 2 regels van het bestand zijn kop regels die niet geimporteerd worden.Vanaf regel 3 de spelersgegevens : Nr, Naam of Namen. Gebruik geen lege regels tussendoor.<br>Direct worden de  gegevens uit het bestand geimporteeerd in een database.<br>
		In het geval van een voorgeloot toernooi kan je in een cell ook meerdere namen opnemen.</div>
<br>



<?php

// set max file size for upload (500 kb)
$max_file_size = 500000000;

	
?>
<form action="import_spelers_hussel_xlsx_stap2.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.ontip.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<?php 
$datum = date('Y-m-d');
?>

<blockquote>
	Datum van de hussel waarvoor de namen worden ingevoerd : <input type ='text' name = 'datum'  size = 6 value = '<?php echo $datum;?>'><br>
	
</blockquote>



<table width=75% border = 0>
	<tr>
<td width = 45% style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>Selecteer het bestand (xlsx) voor upload (klik op Browse/Bladeren..):  </td>
<td style='text-align:right;vertical-align:text-top;width:100pt;'><input   name="userfile" type="file" size="40">
	<input type="submit" name="submit" value="Upload en importeer bestand" />
	
	</td>
</tr>
</table>
</form>


<fieldset style='border:1px solid red>;width:65%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:black;font-size:14px;font-family:Arial;'>xlsx bestanden op het systeem</legend>


<table border =0  style='font-weight:bold;font-size:14pt;'>



<?php
$i=1;

$dir = "xlsx";


echo $dir. "<br>";
 
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
   
         
         if (strlen($file) > 3    and (strtoupper($ext) == 'XLSX' )) {
              
                 
            ?>
            <tr>
            <td width = 50% style='font-size:12pt;color:blue;' ><img src="images/icon_excel.png" width=32>&nbsp<a href ="<?php echo $bestand ?>" target ='_blank'><?php echo $file; ?></a>
            	            	
            	
            	
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


</center>

<br>


</body>
</html>

