<?php
$today      = date("Y-m-d");
$vereniging_url = $_GET['Vereniging_url'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie bestand tbv verenigingsnaam

$myFile   =  'myvereniging.txt';
$fh       = fopen($myFile, 'r');
$line     = fgets($fh);

while ( $line <> ''){

if (substr($line,0,1) == '$' ){

$pos = strpos($line, '=');

// Create variable (with $ sign), no spaces

$var = trim(substr($line,1,$pos-1));

// Set value to variable  trim for no spaces 
$$var = trim(substr($line,$pos+2,80));
 }

$line = fgets($fh);
} /// while


// databaase

include('mysql.php');
ini_set('default_charset','UTF-8');
  /* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


/// Schoon hulp tabel

mysql_query("Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") ;  

// Insert alle toernooien voor deze vereniging

$insert = mysql_query("INSERT INTO hulp_toernooi
(`Toernooi`, `Vereniging`, `Datum`) 
 select distinct Toernooi, Vereniging, Waarde from config where Vereniging = '".$vereniging."' and Variabele = 'Datum' and   Waarde >= '".$today."' ");
 
// Update soort Toernooi
 
$update = mysql_query("UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Soort_toernooi =  c.Waarde,
       t.Inschrijving_open  = 'J'
   where t.Vereniging = '".$vereniging."' and 
         c.Variabele    = 'soort_inschrijving'");

// Update Inschrijving_open
 
$update = mysql_query("UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging        = c.Vereniging 
   set t.Inschrijving_open  = 'N'
   where t.Vereniging = '".$vereniging."' and 
    c.Variabele    = 'begin_inschrijving'
  and c.Waarde > '".$today."'  ");


mysql_query("Delete from hulp_toernooi where Toernooi like '%test%' and Vereniging = '".$vereniging ."'  ") ;  

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon alle toernooien

$qry          = mysql_query("SELECT distinct Vereniging,Toernooi, Datum From hulp_toernooi where Vereniging = '".$vereniging ."'  order by Datum ")     or die(' Fout in select 2');  

while($row = mysql_fetch_array( $qry )) {


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
		
	$vereniging = $row['Vereniging'];
	$sql  = mysql_query("SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row1= mysql_fetch_array( $sql )) {
	
	 $var  = $row1['Variabele'];
	 $$var = $row1['Waarde'];
	} // end while


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$dag1   = 	substr ($begin_inschrijving , 8,2); 
$maand1 = 	substr ($begin_inschrijving , 5,2); 
$jaar1  = 	substr ($begin_inschrijving , 0,4); 

$qry_ins      = mysql_query("SELECT count(*) as Aantal From inschrijf where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select inschrijf');  
$result    = mysql_fetch_array( $qry_ins);
$aantal    = $result['Aantal'];	

?>
                
       <?php
        if ($begin_inschrijving <= $today  and $datum >= $today ){?>       
            	
            <div style='background-color:white;width:210pt;font-size:9pt;border:1pt solid blue;padding:5pt;' class='rounded_small'  id= 'rechts1' 
			             onmouseover="style.backgroundColor='lightgrey';Style.color='blue'"
                   onmouseout="style.backgroundColor='white';Style.color='black'"                   > 	
            	
		         <a href ='Inschrijfform.php?toernooi=<?php echo $toernooi;?>' target='_blank' >
		         	    <img style='padding-right:5pt;' src ='http://www.ontip.nl/images/ontip_logo_zonder_bg.jpg' width=40 border = 0>Inschrijven <?php echo $toernooi_voluit;?> <?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?></a>
		         	    <span style='font-size:9pt;color:darkgreen;'><br>Aantal inschrijvingen tot nu :<b> <?php echo $aantal;?></b> van <?php echo $max_splrs;?></span>
		         	    <span style='padding-left:10pt;'onclick="window.location.href='lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi;?>'" >  <img  src = 'http://www.ontip.nl/images/lists-icon.png' width=15 border =0 alt='Lijst deelnemers'>   </span> 	    	 
		         	    
		         	    
			      <?php } else {?>
			      
			       <div style='background-color:white;width:210pt;font-size:9pt;border:1pt solid darkgrey;padding:5pt;' class='rounded_small'  id= 'rechts1'       >
			        <span style= 'color:darkgrey;' >
		         	    <img style='padding-right:5pt;' src ='http://www.ontip.nl/images/ontip_logo_zonder_bg.jpg' width=40 border = 0> <?php echo $toernooi_voluit;?> <?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?><br>
		         	    Inschrijven mogelijk vanaf : <?php echo strftime("%e %b %Y", mktime(0, 0, 0, $maand1 , $dag1, $jaar1)); ?>
			        </span>
			     
			 <?php    } ?>
			</div> 
  <br>
<?php } ?>

