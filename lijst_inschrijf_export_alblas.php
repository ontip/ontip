<html>
<head>
<title>Aanmaak import_alblas.csv file</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 8pt;}
</style>

</head>

<?php

$toernooi = $_GET['toernooi'];


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lijst_inschrijf_export_albias.php
// 
// Exporteer deelnemers naar csv formaat tbv software Arie Alblas Nederlek

// Output  (import_alblas.csv)
//
// Nr. ; Licentie1; Speler1 ; Licentie2; Speler2  ;Licentie3;  Speler3 ; Vereniging
// Indien Vereniging van spelers ongelijk dan is Vereniging Mix
//


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Database gegevens. 
include('mysql.php');
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


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
	$error =0;
	

//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysql_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
}
else {
		echo " Geen toernooi bekend :";
		$error =1;
		exit;
};



// Inschrijven als individu of vast team

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);

$aant_splrs_q = mysql_query("SELECT Count(*) from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die('Toernooi niet gevonden'); 
/// Bepalen aantal spelers voor dit toernooi
$aant_splrs =  mysql_result($aant_splrs_q ,0); 
//// SQL Queries
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving" )    or die('Deelnemers niet gevonden');  

?>


<body>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../boulamis_toernooi/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
<tr><td STYLE ='font-size: 24pt; color:red'><?php echo $toernooi_voluit ?><br>
	<?php   	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?> 
	
	</TD></tr>
</TABLE>
</div>
<hr color='red'/>
 <table width=100% border =0>
 <tr>
 	 <td style='text-align:left;border-style:none;' width=74%><a href='index.php' style='font-size:9pt;'>Terug naar Hoofdmenu</a></td> 
</tr>
</table>


<h3 style='padding:1pt;font-size:20pt;color:green;'>Aanmaak import bestand tbv Alblas software  '<?php echo $toernooi_voluit; ?>' </h3>
<?php

$i=1;

if (( $soort_inschrijving != 'single' and $soort_inschrijving != 'doublet' and  $soort_inschrijving != 'triplet') and $inschrijf_methode !='vast' ){
	echo "Niet mogelijk voor een ". $soort_inschrijving." toernooi. ";
}
else {
	
$txt_file            = "csv/import_alblas_".$toernooi.".csv";

$fp = fopen($txt_file, "w");
fclose($fp);
$fp = fopen($txt_file, "a");

// Kop regels

$soort = $soort_inschrijving;
if ($soort_inschrijving == 'single' and $inschrijf_methode !='vast'){
  $soort ='Melee';
}  


$line = "OnTip export: ;;".$toernooi_voluit.";;;;".$soort.";".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
fwrite($fp, $line."\n");
$line = "Nr;Licentie 1;Naam 1;Licentie 2; Naam2 ; Licentie 3; Naam 3 ; Vereniging.";
fwrite($fp, $line."\n");




while($row = mysql_fetch_array( $spelers )) {

$vereniging = $row['Vereniging1'];
 if ( strtoupper($row['Vereniging1'])  != strtoupper($row['Vereniging2'])  and $row['Vereniging2'] !='' ) {
 	$vereniging = "Mix team";
 	}
 	
 if ( strtoupper($row['Vereniging1']) != $row['Vereniging3'] and $row['Vereniging3'] !='') {
 	$vereniging = "Mix team";
 	}
 if ( strtoupper($row['Vereniging2']) != strtoupper($row['Vereniging3']) and $row['Vereniging3'] !='' ) {
 	$vereniging = "Mix team";
 	}

$line = $i.";".$row['Licentie1'].";".$row['Naam1'].";".$row['Licentie2'].";".$row['Naam2'].";".$row['Licentie3'].";".$row['Naam3'].";".$vereniging;
fwrite($fp, $line."\n");

//echo $row['Naam1'];
	
	

$i++;
};

fclose($fp);
} // end if

?>

<br>
	
	
	<fieldset style='border:1px solid red>;width:65%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:black;font-size:14px;font-family:Arial;'>Aangemaakt CSV bestand</legend>


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

<table border =0  style='font-weight:bold;font-size:14pt;'>



<?php
$i=1;

$dir   = "csv";


//echo $dir. "<br>";
 
$j=1; 
if ($handle = @opendir($dir)) 
{
    while (false !== ($file = @readdir($handle))) { 
       
        $ext ='';
          if (strpos($file,".")){      
            $name = explode(".",$file);
            $ext  = $name[1];
           }
           
         
         
         if (strlen($file) > 3    and strtoupper($ext) == 'CSV' and substr($file,0,13) == 'import_alblas'  ) {
              
                 
            ?>
            <tr>
            <td width = 50% style='font-size:12pt;color:blue;' ><img src="http://www.boulamis.nl/boulamis_toernooi/images/icon_excel.png" width=32>&nbsp<a style='font-size:11pt;'  href ="csv/<?php echo $file ?>" target ='_blank'><?php echo $file; ?></a>
            	
            	            	
            	</td>
            <td style='font-size:10pt;color:black;text-align:right;vertical-align:bottom;padding:0pt;'><?php echo date ("d F Y H:i:s.", filemtime('csv/'.$file)); ?></td>
         
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
	<div style='font-size:11pt;font-family: calibri;'>
	
	
	Klik op de bovenstaande link om het csv bestand te downloaden naar de PC. Let op de aanmaak datum en tijd van het bestand. Sla het bestand op in de folder waar ook de Alblas software staat. Noteer deze locatie. De macro in de Excel zal een verkenner starten waarmee het bestand ksn worden geopend.
	</div>
	
 <br><br>
<fieldset style='border:1px solid red>;width:65%;padding:15pt;'>
	
	<legend style='left-padding:5pt;color:black;font-size:14px;font-family:Arial;'>Inhoud bestand</legend>
 <table border =1>
 	
 	<?php
 	$myFile   = 'csv/import_alblas.csv';
  $fh       = fopen($myFile, 'r');  
  $line     = fgets($fh);  
      
 	// kopregels
 	$parts    = explode(";",$line);
 	?>
 	<tr>
 		<td colspan = 2  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[0];?></td>
 		<td colspan = 4  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[2];?></td>
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[6];?></td>	
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[7];?></td>	 
 	
 		</tr>
 		<?php
 		$line     = fgets($fh);
 	  $parts    = explode(";",$line);	
 	  ?>
 	<tr>
 		<td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[0];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[1];?></td>  
		<td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[2];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[3];?></td>  
 		<td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[4];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[5];?></td>  
		<td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[6];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:black;'><?php echo $parts[7];?></td>   		
 	  		
 	</tr>	
 	<?php
 		$line     = fgets($fh);
  	while ( $line <> ''){      
   $parts    = explode(";",$line);	
 	  ?>
 	<tr>
 		<td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[0];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[1];?></td>  
		<td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[2];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[3];?></td>  
 		<td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[4];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[5];?></td>  
		<td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[6];?></td>  
 	  <td colspan = 1  style='font-size:11;font-family:9pt;color:blue;'><?php echo $parts[7];?></td>   		
  	</tr>	
  <?php
     $line         = fgets($fh);
  } /// while
  ?> 	
 		
 		</table>
</fieldset>
<?php
fclose($fh);
?>











 
</body>
</html>
