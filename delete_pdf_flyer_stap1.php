<html
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Verwijderen PDF flyer</title>
<style type="text/css">
	body {color:brown;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
table {border-collapse:collapse;color:grey;}

td {color:brown;font-size: 10pt;background-color:white;padding:2pt;}
a  {text-decoration:none ;color:blue;font-size: 9pt;}
h4 {color:brown;font-size: 12pt;background-color:white;}

.img-shadow img { 
display: block; /* IE won't do well without this */ 
position: relative; /* Make the shadow's position relative to its image */ 
padding: 5px; /* This creates a border around the image */ 
background-color: #fff; /* Background color of the border created by the padding */ 
border: 1px solid #cecece; /* A 1 pixel greyish border is applied to the white border created by the padding */ 
margin: -6px 6px 6px -6px; /* Offset the image by certain pixels to reveal the shadow, as the shadows are 6 pixels wide, offset it by that amount to get a perfect shadow */ 
}

</style>

</head>
<body >


<?php

// Database gegevens. 
include('mysql.php');
setlocale(LC_ALL, 'nl_NL');

ob_start();
?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving<br><?php echo $vereniging ?></TD>
</tr>
<tr>
<td STYLE ='font-size:28pt; background-color:white;color:blue ;'><?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>

<hr color='red'/>

<span style='text-align:right;vertical-align:text-top;'><a href='index.php'>Terug naar Hoofdmenu</a></span><br>
<br>

<h2 style='color:blue;font-family:verdana;font-size:24;'>Verwijderen PDF flyers <img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =50 ></h2><br>

<?php

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


if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

?>

<br>
<span style='color:black;font-size:10pt;font-family:arial;'>Vink de PDF flyers aan die je wilt verwijderen en klik op de knop 'Verwijderen uitvoeren'. Er wordt niet om een bevestiging gevraagd !!!</span><br>
<br>


<form method = 'post' action='delete_pdf_flyer_stap2.php'>

<blockquote>	
<table border =1 style='font-weight:bold;font-size:12pt;'>
<tr>
 <th>Del</th>
 <th>Toernooi</th>
 <th>Toernooi voluit</th>
 <th>Datum toernooi</th>
 <th>PDF flyer</th>
 <th>Aangemaakt</th>
</tr> 
 

<?php


$i=1;

$sql  = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


$dir = "images";


//echo $dir. "<br>";

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
           
       // echo $file. "-".  $ext. "<br>";
             
         if (strlen($file) > 3  and (strtoupper($ext) == 'PDF' )  ) {
         
         $file1     = explode(".",$file);
         $toernooi  = $file1[0];
                  
         $sql    = mysql_query("SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = 'toernooi_voluit' ")     or die(' Fout in select');  
         $count  =  mysql_num_rows($sql);
         if($count == 1){
             $result            = mysql_fetch_array( $sql );
             $toernooi_voluit   = $result['Waarde'];
             $sql    = mysql_query("SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = 'datum' ")     or die(' Fout in select');  
             $result = mysql_fetch_array( $sql );
             $datum  = $result['Waarde'];
             $dag    = substr ($datum , 8,2); 
             $maand  = substr ($datum , 5,2); 
             $jaar   = substr ($datum , 0,4); 
             $datum = strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));
           }
        else {          
             $toernooi_voluit   ='<font color = "red">Niet (meer) in het systeem.</font>';
             $datum      = '';
        } 
         ?>    
                   
         <tr>
         	 <td> <input type ='checkbox'  name ='pdf-<?php echo $j; ?>' value ='<?php echo $file; ?>' > </td>
      	   <td style='font-size:10pt;color:blue;vertical-align:bottom;background-color:white;'><?php echo $toernooi; ?></td>         
       	   <td style='font-size:10pt;color:blue;vertical-align:bottom;background-color:white;'><?php echo $toernooi_voluit; ?></td>         
      	   <td style='font-size:10pt;color:blue;vertical-align:bottom;background-color:white;'><?php echo $datum; ?></td>         
       	   <td style='font-size:10pt;color:blue;vertical-align:bottom;background-color:white;'><?php echo $file; ?></td>         
           <td><?php echo date ("d F Y H:i:s", filemtime($bestand));?></td>	   
         </tr>	     
         <?php       
       }// end if strln
  $j++;
  }// end while
  
@closedir($handle);     
} // end if


?>	
<input type='hidden' name ='Aantal'   value='<?php echo $j;?>'/>

</tr></table>
<br>
<em>Als na het verwijderen van een flyer de flyer nog in de lijst staat, druk dan op F5 om het scherm te verversen.</em>
</blockquote>	



</div>
<br>
<center>
	
  <input style='background-color:red;color:white;font-size:9pt;' type = 'submit' value ='Verwijderen uitvoeren' />
</form>
</center>

<br>


</html>
