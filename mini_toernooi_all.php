<?php
$today      = date("Y-m-d");
$now        = date("Y-m-d H:i");
$vereniging = 'Boulamis';

include('mysqli.php');

 

/// Schoon hulp tabel

mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") ;  

// Insert alle toernooien voor deze vereniging

$insert = mysqli_query($con,"INSERT INTO hulp_toernooi
(`Toernooi`, `Vereniging`, `Datum`) 
 select distinct Toernooi, Vereniging, Waarde from config where Vereniging = '".$vereniging."' and Variabele = 'Datum' and   Waarde >= '".$today."' ");
 
// Update soort Toernooi
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Soort_toernooi =  c.Waarde,
       t.Inschrijving_open  = 'J'
   where t.Vereniging = '".$vereniging."' and 
         c.Variabele    = 'soort_inschrijving'");

// Update Inschrijving_open
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Inschrijving_open  = 'N'
   where t.Vereniging = '".$vereniging."' and 
    c.Variabele    = 'begin_inschrijving'
  and c.Waarde > '".$today."'  ");

ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');


mysqli_query($con,"Delete from hulp_toernooi where Toernooi like '%test%' and Vereniging = '".$vereniging ."'  ") ;  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon alle toernooien

$qry          = mysqli_query($con,"SELECT distinct Vereniging,Toernooi, Datum From hulp_toernooi where Vereniging = '".$vereniging ."'  order by Datum ")     or die(' Fout in select 2');  

while($row = mysqli_fetch_array( $qry )) {


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row1= mysqli_fetch_array( $sql )) {
	
	 $var  = $row1['Variabele'];
	 $$var = $row1['Waarde'];
	}


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$dag1   = 	substr ($begin_inschrijving , 8,2); 
$maand1 = 	substr ($begin_inschrijving , 5,2); 
$jaar1  = 	substr ($begin_inschrijving , 0,4); 

$qry_ins      = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select inschrijf');  
$result    = mysqli_fetch_array( $qry_ins);
$aantal    = $result['Aantal'];	

?>
                
       <?php
        if ($begin_inschrijving <= $now and $datum >= $today ){?>       
            	
            <div style='background-color:white;width:200pt;font-size:8pt;border:1pt solid blue;padding:5pt;' class='rounded_small'  id= 'rechts1' 
			             onmouseover="style.backgroundColor='lightgrey';Style.color='blue'"
                   onmouseout="style.backgroundColor='white';Style.color='black'"                   > 	
            	
		         <a style= 'text-decoration:none;vertical-align:middle;font-size:9pt;font-family:Comic sans, sans-serif;font-weight:bold;color:black;' href ='http://www.boulamis.nl/site2015/page_inschrijf.php?toernooi=<?php echo $toernooi;?>' target='_top' >
		         	    <img style='padding-right:5pt;' src ='../ontip/images/ontip_logo_zonder_bg.jpg' width=40 border = 0>Inschrijven <?php echo $toernooi_voluit;?> <?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?></a>
		         	    <span style='font-size:9pt;color:darkgreen;font-size:9pt;font-family:Comic sans, sans-serif;font-weight:bold;'><br>Aantal inschrijvingen tot nu :<b> <?php echo $aantal;?></b> van <?php echo $max_splrs;?></span>
		         	    <span style='padding-left:10pt;'><a href='http://www.boulamis.nl/site2015/page_lijst_inschrijf.php?toernooi=<?php echo $toernooi;?>'" target='_top'>  <img  src ='../ontip/images/lists-icon.png' width=15 border =0 alt='Lijst deelnemers'> </a>  </span> 	    	 
		         	    
		         	    
			      <?php } else {?>
			      
			       <div style='background-color:white;width:200pt;font-size:9pt;border:1pt solid darkgrey;padding:5pt;' class='rounded_small'  id= 'rechts1'       >
			        <span style= 'color:darkgrey;font-size:9pt;font-family:Comic sans, sans-serif;color:darkgrey;' >
		         	    <img style='padding-right:5pt;' src ='../ontip/images/ontip_logo_zonder_bg.jpg' width=40 border = 0> <?php echo $toernooi_voluit;?> <?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?><br>
		         	    Inschrijven mogelijk vanaf : <?php echo strftime("%e %b %Y", mktime(0, 0, 0, $maand1 , $dag1, $jaar1)); ?>
			        </span>
			     
			 <?php    } ?>
			</div> 
  <br>
<?php } ?>

