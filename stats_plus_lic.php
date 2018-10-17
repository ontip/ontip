<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Statistieken inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;}
th   {color:blue;font-size:9pt;font-family: sans-serif;font-weight:bold;;background-color:white;border-color:black;}
td   {color:black;font-size:9pt;font-family: sans-serif;background-color:white;border-color:black;padding:2pt;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
</style>
<?php include ("js/javalib.php"); ?> 
	
<script language="javascript">AC_FL_RunContent = 0;</script>
<script language="javascript"> DetectFlashVer = 0; </script>
<script src="../ontip/js/AC_RunActiveContent.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
<!--
var requiredMajorVersion = 9;
var requiredMinorVersion = 0;
var requiredRevision = 45;
-->
</script>
</head>

<script type="text/javascript">
	
function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>
</head>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx &#169 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>
 
<?php 
// Database gegevens. 

include('mysql.php');
setlocale(LC_ALL, 'nl_NL');


if (isset($_COOKIE['_month'])){
 $select_month  = $_COOKIE['_month'];
 $select_year   = $_COOKIE['_year'];
 } else {
   $select_month  = date('m');
   $select_year   = date('Y');
 }	

 $curr_month   = date('m');
 $curr_year    = date('Y');
 
setlocale(LC_ALL,'Dutch_Nederlands', ' Dutch', 'nl_NL','nl');

/// over 2012
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2012' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2012_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2012_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2012_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
//var_dump($aantal_maand); 

/// over 2012
 $sql        = mysql_query("SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2013' group by Maand order by Maand");

while($row = mysql_fetch_array( $sql )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2013_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal'];   
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2013_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2013_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
//var_dump($aantal_maand); 


ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
	
	$qry     = mysql_query("SELECT Distinct Vereniging,Plaats from namen where Plaats <> '' order by Vereniging   ")     or die(' Fout in select namen');  
	$qry1    = mysql_query("SELECT Distinct Vereniging, Toernooi From config  order by Vereniging, Toernooi ")           or die(' Fout in select');  
  $qry2    = mysql_query("SELECT Vereniging, Toernooi, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf  group by Vereniging, Toernooi order by Laatst desc ")     or die(' Fout in select'); 
  $qry2jk  = mysql_query("SELECT Vereniging, Toernooi, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf_jk  group by Vereniging, Toernooi order by Laatst desc ")     or die(' Fout in select 2jk'); 
  $qry2b    = mysql_query("SELECT Vereniging, Toernooi, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf  group by Vereniging, Toernooi order by Datum asc ")     or die(' Fout in select'); 
  
  
	$qry3    = mysql_query("SELECT * FROM namen Order by Vereniging");   
	$qry4    = mysql_query("SELECT count(*) as Aantal From inschrijf")     or die(' Fout in select'); 
	$qry4jk  = mysql_query("SELECT count(*) as Aantal From inschrijf_jk")     or die(' Fout in select 4 jk'); 
		
	$result  = mysql_fetch_array( $qry4 );
	
	$totaal_inschrijvingen  = $result['Aantal'];
  $result  = mysql_fetch_array( $qry4jk );
  $totaal_inschrijvingen  = $totaal_inschrijvingen + $result['Aantal'];
  
  $qry5    = mysql_query("SELECT DAY(Inschrijving) as Dag, WEEKDAY(Inschrijving) as Dagnaam, count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."' group by 1 order by 1  ")     or die(' Fout in select namen');  
	
  $qry5_tot    = mysql_query("SELECT count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."'   ")     or die(' Fout in select namen');  
  $result  = mysql_fetch_array( $qry5_tot );
  $totaal_maand  = $result['Aantal'];
  
  /// grafieken bron
  
  $qry6  = mysql_query("SELECT distinct Vereniging, count(*) as Aantal From stats_naam group by Vereniging order by Aantal desc")            or die(' Fout in select 6'); 
  $qry6b = mysql_query("SELECT distinct Vereniging, count(*) as Aantal From stats_naam group by Vereniging order by Aantal desc limit 10")   or die(' Fout in select 6b'); 
  $qry6c = mysql_query("SELECT distinct Soort_toernooi, count(*) as Aantal From stats_naam group by 1 order by 2 desc")                      or die(' Fout in select 6c'); 
  $qry6d = mysql_query("SELECT distinct Soort_Licentie, count(*) as Aantal From stats_naam group by 1 order by 2 desc")                      or die(' Fout in select 6d'); 
  $qry6e = mysql_query("SELECT DATE_FORMAT(Datum, '%w') as Weekdag , count(*) as Aantal from stats_naam group by 1 order by 1")              or die(' Fout in select 6e'); 
  $qry6f = mysql_query("SELECT distinct Vereniging_speler, count(*) as Aantal From stats_naam group by Vereniging_speler order by Aantal desc")            or die(' Fout in select 6f');    
  $qry6g1 = mysql_query("SELECT DATE_FORMAT(Laatst, '%w') as Weekdag , count(*) as Aantal from stats_naam where DATE_FORMAT(Laatst,'%Y') = '2012'  group by 1 order by 1")              or die(' Fout in select 6g1'); 
  $qry6g2 = mysql_query("SELECT DATE_FORMAT(Laatst, '%w') as Weekdag , count(*) as Aantal from stats_naam where DATE_FORMAT(Laatst,'%Y') = '2013'  group by 1 order by 1")              or die(' Fout in select 6g2'); 
  $qry6h = mysql_query("SELECT distinct Vereniging_speler, count(*) as Aantal From stats_naam group by Vereniging_speler order by Aantal desc limit 10")   or die(' Fout in select 6h'); 

////// 6b 


 $i=1;
 while($row = mysql_fetch_array( $qry6b )) {
 	  $vereniging = $row['Vereniging'];
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);
 	
 $_3d_vereniging[$i] = $vereniging;	
  	
 //   $_3d_vereniging[$i] = $row['Vereniging'];
    $_3d_aantal[$i]       = $row['Aantal'];
    $i++;
  }
 $totaal_3d = $i;
  
 while($row = mysql_fetch_array( $qry6c )) {
 	  $soort_toernooi                   = $row['Soort_toernooi'];
 	   	  //echo "soort : ". $soort_toernooi. "<br>";
 	   	  $_soort_aantal[$soort_toernooi]   = $row['Aantal'];
    
 } // end while

////// 6e 

 while($row = mysql_fetch_array( $qry6e )) {
 	
 	   $dagnr                        = $row['Weekdag'];	
 	   $weekdag_3d_aantal[$dagnr]    = $row['Aantal'];
 } // end while

for ($i=0;$i<7;$i++){ 	
  
    if (!isset($weekdag_3d_aantal[$i])){
     	$weekdag_3d_aantal[$i] =0;
    }
    
  }	/// end for
	
	////// 6g1  2012

 while($row = mysql_fetch_array( $qry6g1 )) {
 	
 	   $dagnr                             = $row['Weekdag'];	
 	   $weekdag_bar_2012_aantal[$dagnr]   = $row['Aantal'];
 	 } // end while

for ($i=0;$i<7;$i++){ 	
  
    if (!isset($weekdag_bar_2012_aantal[$i])){
     	$weekdag_bar_2012_aantal[$i] =0;
    }
    
  }	/// end for
	
	////// 6g2  2013

 while($row = mysql_fetch_array( $qry6g2 )) {
 	
 	   $dagnr                        = $row['Weekdag'];	
 	   $weekdag_bar_2013_aantal[$dagnr]   = $row['Aantal'];
 } // end while

for ($i=0;$i<7;$i++){ 	
  
    if (!isset($weekdag_bar_2013_aantal[$i])){
     	$weekdag_bar_2013_aantal[$i] =0;
    }
    
  }	/// end for

////// 6h 

 $i=1;
 while($row = mysql_fetch_array( $qry6h )) {
 	  $vereniging = $row['Vereniging_speler'];
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$vereniging        = str_replace("&#226", "â", $vereniging);
$vereniging        = str_replace("&#233", "é", $vereniging);
$vereniging        = str_replace("&#234", "ê", $vereniging);
$vereniging        = str_replace("&#235", "ë", $vereniging);
$vereniging        = str_replace("&#239", "ï", $vereniging);
$vereniging        = str_replace("&#39",  "'", $vereniging);
$vereniging        = str_replace("&#206", "Î", $vereniging);
 	
 $h_3d_vereniging[$i] = $vereniging;	
  	
 //   $_3d_vereniging[$i] = $row['Vereniging'];
    $h_3d_aantal[$i]       = $row['Aantal'];
    $i++;
  } // end while
 $totaal_3dh = $i;

////// 6e 

	
  $qry7  = mysql_query("SELECT count(*) as Aantal From stats_naam")     or die(' Fout in select 7'); 
	$result  = mysql_fetch_array( $qry7 );
  $archief_inschrijvingen  = $result['Aantal'];

	$qry8    = mysql_query("SELECT  Vereniging, count(distinct Datum) as Aantal FROM `stats_naam`   group by Vereniging order by 2 desc")     or die(' Fout in select 8'); 
	
	$qry9    = mysql_query("SELECT Naam, Vereniging_speler as Vereniging, count(*) as Aantal FROM `stats_naam` group by 1 order by 3 desc,1 asc limit 10")     or die(' Fout in select 9'); 
	
	$qry10   = mysql_query("SELECT DATE_FORMAT(Laatst,'%d-%m-%Y') as Datum , count(*) as Aantal  from stats_naam group by 1 order by 2 desc limit 10")     or die(' Fout in select 10'); 
	
	$qry11   = mysql_query("SELECT Naam, Vereniging, Laatst from namen where Naam <> 'Erik' order by 3 desc limit 10")     or die(' Fout in select 11'); 
	
	$qry12   = mysql_query("SELECT Naam, Vereniging, Aantal from namen where Naam <> 'Erik' and Aantal > 0 order by 3 desc limit 10")     or die(' Fout in select 12'); 
	
	$qry13   = mysql_query("Select date_format(Laatst, '%H' ) as Uur, count(*) AS Aantal from stats_naam group by 1 order by 1 ")     or die(' Fout in select 13'); 
	 
while($row = mysql_fetch_array( $qry13 )) {
        $uur                    = number_format($row['Uur']);
        
        //Let's create a new variable: $aantal_uur_xx
         $var_name = "aantal_uur_". $uur   ; //$var_name will store the NAME of the new variable  $aantal_uur_xx

        //Let's assign a value to that new variable:
         $$var_name  = $row['Aantal'];
   } //end while         
   
   // vul de nog ontbrekende uren met een waarde 0
	for ($uur=0;$uur<24;$uur++){
	  $var_name  = "aantal_uur_". $uur   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_uur_". $uur   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for
  
  
  $qry14   = mysql_query("SELECT Vereniging, Toernooi, Datum, Soort_toernooi, count(*) as Aantal  FROM `stats_naam` group by 1,2 order by 5 desc limit 20")     or die(' Fout in select 14');  
  $qry15   = mysql_query("SELECT * FROM `inschrijf` where DATE_FORMAT(Inschrijving,'%Y') = '2012'  order by Inschrijving asc limit 20")     or die(' Fout in select 15');  
  $qry16   = mysql_query("SELECT count(*) as Aantal FROM `inschrijf` where DATE_FORMAT(Inschrijving,'%Y') = '2012'   ")     or die(' Fout in select 16');  
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Definieeer variabelen en vul ze met waarde uit tabel

$achtergrond_kleur = 'white';
$today = date('Y-m-d');

?>
<body bgcolor=<?php echo($achtergrond_kleur);?>>
	
<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
$totaal = 0;
?>

<a name='home'></a>

<table border =0 width=80%>
<tr><td style='background-color:<?php echo $achtergrond_kleur; ?>;' rowspan = 2>
<img src='images/ontip_logo.png' width='300'></td>
<td colspan =4><span style='Font-size:32pt;color:green;'>STATISTIEKEN</span></td></tr>
	<tr>
   <td><a href="#all_inschrijf"    style='font-size:10pt;color:blue;text-decoration:none;'>Inschrijvingen [<?php echo $totaal_inschrijvingen;?>]</a></td>
   <td><a href="#stats_inschrijf"  style='font-size:10pt;color:blue;text-decoration:none;'>Archief  [<?php echo $archief_inschrijvingen;?>]</a></td>
   <td><a href="#all_verenigingen" style='font-size:10pt;color:blue;text-decoration:none;'>Verenigingen [<?php echo mysql_num_rows($qry);?>]</a></td>
   <td><a href="#all_toernooien"   style='font-size:10pt;color:blue;text-decoration:none;'>Toernooien [<?php echo mysql_num_rows($qry1);?>]</a></td>
   <td><a href="#best"             style='font-size:10pt;color:blue;text-decoration:none;'>Best<br>bezochte toernooien</a></td>
   <td><a href="#per_dag"          style='font-size:10pt;color:blue;text-decoration:none;'>Per dag [<?php echo $totaal_maand;?>]</a></td>
   
</tr></table>

<hr color=darkgreen/>

<a name='all_inschrijf'><h1>Alle actuele inschrijvingen (<?php echo $totaal_inschrijvingen;?>)</h1></a>

<!------------------------------ 2 naast elkaar --------------------->

<table %>
	<tr>
		<td>
			


<table id= 'MyTable2' border =0 width=80% colspan =2>
	<tr>
		<td style='background-color:orange;color:black;'>Toernooi binnen 1 week </td>
		<td style='background-color:green;color:white;'>Toernooi vandaag</td>
		<td style='background-color:red;color:white;'>Toernooi gespeeld</td>
		<td style='background-color:blue;color:yellow;'>Toernooi volgeboekt</td>
	</tr>
</table>
<br>
</td>
</tr>
<tr><td>

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =6 >Inschrijvingen op datum invoer (nieuwste eerst)</th>
	</tr>
	<tr>
		
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi (interne naam)</th>
		<th>Datum</th>
		<th>Aantal</th>
		<th>Laatste update</th>
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry2 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	$sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ");
	  $result     = mysql_fetch_array( $sql );
    $datum      = $result['Waarde'];
    
    $sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'max_splrs' ");
	  $result     = mysql_fetch_array( $sql );
    $max_splrs  = $result['Waarde'];
    //echo $max_splrs;
    
    if ($datum=='') { $datum='onbekend';};
    
   ?>
      <?php
      if ($today > $datum) {   ?>
	  		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	    	<?php } else {
	 	    if ($today == $datum) {  ?>
	     		<td Style=' background-color:green;color:yellow;'><?php echo $datum;?></td>
     	   <?php } else { ?>
     	   <td><?php echo $datum;?></td>
	 	<?php }}?>
	 	
	 	<?php
	 		$totaal = $totaal + $row['Aantal'];
	 	if ($row['Aantal'] <   $max_splrs){ ?>
	   	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 <?php }  else { ?>
	 	 	
	 	<td style='text-align:right;background-color:blue;color:yellow;'><?php echo $row['Aantal'];?></td>
	<?php } ?> 
	 
	 	<td><?php echo $row['Laatst'];?></td>	
	</tr>
 
<?php	 
	$i++; 
};
?>

<tr><td colspan =4>Totaal</td>
	<td style='text-align:right;'><?php echo $totaal_inschrijvingen;?></td><td style='color:white;'>.</td></tr>
</table>

</td><td>

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan = 5 >Toernooi Kalender op datum</th>
	</tr>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
		<th>Soort</th>
		<th>Datum</th>
		</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry2b )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	$sql                  = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'soort_inschrijving' ");
    $result               = mysql_fetch_array( $sql );
    $soort                = $result['Waarde'];
    
    switch($soort){
  	    case 'single' : $soort_inschrijving  = 'Mêlée'    ; break;
  	    default       : $soort_inschrijving   = $soort    ; break;
    }// end switch
   ?>
   <td><?php echo $soort_inschrijving;?></td>
	 	
	 	<?php
	 	$sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ");
	 	//
	  $result     = mysql_fetch_array( $sql );
    $datum      = $result['Waarde'];
    $dag        = 	substr ($datum , 8,2); 
    $maand      = 	substr ($datum , 5,2); 
    $jaar       = 	substr ($datum , 0,4); 
   
    $vandaag        = time();
    $toernooi_datum = mktime(0,0,0,$maand,$dag,$jaar);
    $week_ervoor    = strtotime ("-1 week", mktime(0,0,0,$maand,$dag,$jaar));
    
// rode achtergrond als toernooi geweest is
    if ($today > $datum) {   ?>
	  		<td Style=' background-color:red;color:white;text-align:right;'><?php echo strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));?></td>
	   	<?php } 

// oranje achtergrond als toernooi geweest is

	    	
 	  if ($vandaag > $week_ervoor and $vandaag < $toernooi_datum) {   ?>
	  		<td Style=' background-color:orange;color:black;text-align:right;'><?php echo strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));?></td>
	  	<?php } 

// groene achtergrond als toernooi vandaag is
	    
	 	if ($today == $datum) {  ?>
	     		<td Style=' background-color:green;color:yellow;text-align:right;'><?php echo strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));?></td>
    <?php }

// zwarte tekst op witte achtergrond in alle andere gevallen
   
    if ($vandaag < $week_ervoor) {   ?>
         	   <td Style=' background-color:white;color:black;text-align:right;'><?php echo strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar));?></td>
	 <?php } ?>
	 	
	 	</tr>
 
<?php	 
	$i++; 
};
?>


</table><br><br>

</td></tr>
<!------------------------------ volgende rij --------------------->
<tr><td style='vertical-align:top;'>
			

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =6 >Inschrijvingen op datum inschrijving (oudste eerst)</th>
	</tr>
	<tr>
		
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
		<th>Datum</th>
		<th>Laatste</th>
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry15 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	$sql        = mysql_query("SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ");
	 	//
	 //	echo "SELECT Waarde FROM config WHERE Vereniging = '".$row['Vereniging']."' and Toernooi = '".$row['Toernooi']."' and Variabele = 'datum' ";
	 	//echo $sql;
    $result     = mysql_fetch_array( $sql );
    $datum      = $result['Waarde'];
    if ($datum=='') { $datum='onbekend';};
    
   ?>
      <?php
      if ($today > $datum) {   ?>
	  		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	    	<?php } else {
	 	    if ($today == $datum) {  ?>
	     		<td Style=' background-color:green;color:yellow;'><?php echo $datum;?></td>
     	   <?php } else { ?>
     	   <td><?php echo $datum;?></td>
	 	<?php }}?>
	 		 	<td><?php echo $row['Inschrijving'];?></td>	
	</tr>
 
<?php	 
	$i++; 
};

$result = mysql_fetch_array( $qry16); 
echo "<tr><td colspan =4 style='font-weight:bold;'> Aantal inschrijvingen voor 2012 :</td><td style='text-align:right;'> ". $result['Aantal']."</td></tr>";


?>
</table>




</td>
</tr>
</table>


<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>

<!--- //  meerdere tabellen naast elkaar  ------------------>

<a name='stats_inschrijf'><h1>Archief inschrijvingen </h1></a>

<table width=90% border=0>
	
	</tr>
	<tr>
		<td STYLE="vertical-align: top;">
			 
			 
			 
<table id= 'MyTable3' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Inschrijvingen per organiserende vereniging</th>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Aantal<br>personen</th>

	</tr>
<?php
$i      = 1;
$totaal = 0;

while($row = mysql_fetch_array( $qry6 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
<?php   $totaal = $totaal + $row['Aantal']; ?>
  
	</tr>
 
<?php	 
	$i++; 
};
?>

<tr><td colspan =2>Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td></tr>
</table>

</td>
<!----------- volgende tabel----------------------->

<td STYLE="vertical-align: top;">
<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Toernooien per vereniging</th>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Aantal<br>toernooien</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry8 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 	<?php $totaal = $totaal + $row['Aantal']; ?>
	</tr>
 
<?php	 
	$i++; 
};
?>
<tr>
	<td colspan =2> Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td>
</tr>
</table>


</td>
<!----------- volgende tabel ----------------------->
<td STYLE="vertical-align: top;" >

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4 >Top 10 - Toernooien per persoon</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Aantal<br>toernooien</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry9 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 		<td><?php echo $row['Vereniging'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>


</td>
<!----------- volgende tabel ----------------------->
<td STYLE="vertical-align: top;">

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Top 10 - Inschrijvingen per datum</th>
	<tr>
		<th>Nr</th>
		<th>Datum</th>
		<th>Aantal<br>personen</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry10 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Datum'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	 
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>
</TD>
</tr>
<!----------- volgende tabellen op volgende regel ----------------------->
<!---tr>
		<td STYLE="vertical-align: top;">
			 
			 
			 
<table id= 'MyTable3' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =3 >Inschrijvingen per deelnemende vereniging</th>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Aantal<br>personen</th>
		<th>Update command</th>

	</tr>
<?php
$i      = 1;
$totaal = 0;

while($row = mysql_fetch_array( $qry6f )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging_speler'];?></td>
	 	<td style='text-align:right;'><?php echo $row['Aantal'];?></td>
	  <td >update stats_naam set Vereniging_speler = '<?php echo $row['Vereniging_speler'];?>' where Vereniging_speler = '<?php echo $row['Vereniging_speler'];?>'</td> 
<?php   $totaal = $totaal + $row['Aantal']; ?>
  
	</tr>
 
<?php	 
	$i++; 
};
?>

<tr><td colspan =2>Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td></tr>
</table>

</td>
</tr-->
</table>


<!---- // naast elkaar tot hier -------------------------->
<br>
<!-------------------------------------------- Grafieken naast elkaar ---------------------------->
<table border = 0 width = 100%>
	<tr>
		<td>

<!--///////////////////////////////////////////////////////////////// grafieken ///////////////////////////////////-->
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="aantal_per_maand.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");

// 3d
// fwrite($fp, "<axis_category shadow='low' size='10' color='FF0000' alpha='75' orientation='horizontal' />\n"); 
// fwrite($fp, "<axis_ticks value_ticks='false' category_ticks='false' />\n");  
// fwrite($fp, "<axis_value alpha='0'  />\n");  
//  fwrite($fp, "	<chart_border top_thickness='0' bottom_thickness='0' left_thickness='0' right_thickness='0' />\n"); 

fwrite($fp, "<axis_category size='10' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='5' color='blue' alpha='120' />\n");

//fwrite($fp, "<chart_rect x='60' />\n"); 
//fwrite($fp, "<chart_label position='outside' size='9' color='blue' alpha='120' />\n"); 

//========== Schrijf de y-as van de grafiek (Maanden)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

$select_year = date('Y');

// Eerst de namen van de maanden verwerken
for ($month=1;$month<13;$month++){
    fwrite($fp, "         <string>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,strftime("%h",mktime(0,0,0,$month,1,$select_year)));
     fwrite($fp, "</string>\n");
}// end for
fwrite($fp, "      </row>\n");

//========== Schrijf de X-as van de grafiek

// 2012

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2012</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2012_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");

// 2013

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2013</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2013_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month

fwrite($fp, "      </row>\n");
// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "	<draw>\n");
fwrite($fp, "   <text x='120' y='4' color ='FF4400' size= '10'>Inschrijvingen per maand (archief)</text>\n");
fwrite($fp, "	</draw>\n");


// 3d

//fwrite($fp, "<chart_grid_h thickness='0' />\n");
// fwrite($fp, "	<chart_label shadow='low' color='blue' alpha='100' size='10' position='over' />\n");

//fwrite($fp, "	<chart_pref rotation_x='0' rotation_y='10' min_x='20' max_x='70' min_y='30' max_y='80' />\n");
//fwrite($fp, "	<chart_rect x='-10' y='20' width='380' height='200' positive_alpha='0' negative_alpha='25' />\n");
//fwrite($fp, "	<chart_type>3d column</chart_type>\n");
	
//fwrite($fp, "	<filter>\n");
//fwrite($fp, "		<shadow id='low' distance='2' angle='45' alpha='50' blurX='2' blurY='2' />\n");
//fwrite($fp, "	</filter>\n");
	
//fwrite($fp, "	<legend shadow='low' x='20' y='25' width='80' height='40' margin='5' fill_color='000066' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='vertical' size='12' color='blue' alpha='50' />\n");

fwrite($fp, "  <series_color>"."\n");
fwrite($fp, "   <color>ff8844</color>". "\n");
fwrite($fp, "   <color>88ff00</color>"."\n");
fwrite($fp, "  </series_color>"."\n");
fwrite($fp, "  <series bar_gap='10' set_gap='20' />"."\n");

//fwrite($fp, "	<series_color>\n");
//fwrite($fp, "		<color>666666</color>\n");
//fwrite($fp, "		<color>768bb3</color>\n");
//fwrite($fp, "	</series_color>\n");

fwrite($fp, "\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:400pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '700',
			'height', '500',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
</div>

</td>
<td>


<!---- Tweede grafiek -------------------------------->

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="aantal_per_uur.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='5' color='blue' alpha='120' />\n");

//========== Schrijf de y-as van de grafiek (aantal)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

$select_year = date('Y');

// Eerst de namen van de  urenverwerken
for ($uur=0;$uur<24;$uur++){
    fwrite($fp, "         <string>");	
		// Print out the contents of each row into a table
		 fwrite ($fp,$uur);
     fwrite($fp, "</string>\n");
}// end for
fwrite($fp, "      </row>\n");
//========== Schrijf de X-as van de grafiek
fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>Aantal inschrijvingen per uur (in archief)</string>\n");

for ($uur=0;$uur<24;$uur++){
     $var_name  = "aantal_uur_". $uur   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for uur

fwrite($fp, "      </row>\n");
// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:400pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '600',
			'height', '460',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
</div>

</td>
</tr>
<tr>
<td>


<!----  Derde grafiek volgende rij-------------------------------->

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="aantal_per_dag.xml";
$fp = fopen($xml_file, "w");
fclose($fp);
$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='5' color='blue' alpha='120' />\n");

//========== Schrijf de y-as van de grafiek (aantal)
fwrite($fp, "\n");
fwrite($fp, "   <chart_data>\n");
fwrite($fp, "      <row>\n");
fwrite($fp, "         <null/>\n");

$select_year = date('Y');

// Eerst de namen van de dagen verwerken
/// weekdagen

for ($i=0;$i<7;$i++){
		
		switch ($i){
			
		case "0"   : 	fwrite($fp, "     <string>Zon</string>\n");break;
		case "1"   : 	fwrite($fp, "     <string>Maa</string>\n");;break;
		case "2"   : 	fwrite($fp, "     <string>Din</string>\n");break;
		case "3"   : 	fwrite($fp, "     <string>Woe</string>\n");break;
		case "4"   : 	fwrite($fp, "     <string>Don</string>\n");break;
		case "5"   : 	fwrite($fp, "     <string>Vrij</string>\n");break;
		case "6"   : 	fwrite($fp, "     <string>Zat</string>\n");break;
}// end switch
 }	/// end for
fwrite($fp, "      </row>\n");
//========== Schrijf de X-as van de grafiek

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2012</string>\n");

// aantal per weekdag  2012	

	for ($i=0;$i<7;$i++){ 	
     	fwrite($fp, "     <number>".$weekdag_bar_2012_aantal[$i]."</number>\n");
 }	/// end for

fwrite($fp, "      </row>\n");

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2013</string>\n");

// aantal per weekdag  2013	

	for ($i=0;$i<7;$i++){ 	
     	fwrite($fp, "     <number>".$weekdag_bar_2013_aantal[$i]."</number>\n");
	}	/// end for

fwrite($fp, "      </row>\n");


// sluit af
fwrite($fp, "  </chart_data>\n");
fwrite($fp, "	<draw>\n");
fwrite($fp, "   <text x='150' y='4' color ='FF4400' size= '15'>Dagen vd week (archief)</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "  <series_color>"."\n");
fwrite($fp, "   <color>ff8844</color>". "\n");
fwrite($fp, "   <color>88ff00</color>"."\n");
fwrite($fp, "  </series_color>"."\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:400pt;">
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '600',
			'height', '460',
			'scale', 'showAll',
			'salign', 'ExactFit',
			'bgcolor', '#777788',
     	'wmode', 'transparent',   
		 'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart',
			'name', 'my_chart',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
</div>

</td>

</tr>
</table>

<!-----------  3D pie charts---------organiserende vereniging -----  naast elkaar--------------------------------------->
<br>
<table width =50% border = 0>
	<tr>
		<td>

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_top10a.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// verenigingen

for ($i=1;$i<$totaal_3d;$i++){
		
	fwrite($fp, "     <string>".$_3d_vereniging[$i]." (". $_3d_aantal[$i].")</string>\n");
	
}	/// end for
	fwrite($fp, "   </row>\n");
   
/// aantal per vereniging	
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Verenigingen</string>\n");
	 	
	for ($i=1;$i<$totaal_3d;$i++){
		
	fwrite($fp, "     <number>".$_3d_aantal[$i]."</number>\n");
	
}	/// end for
  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Inschrijven per vereniging</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='500' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Inschrijving 10 hoogste organiserende verenigingen</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>

</td>
<!-----------  3D pie charts------- deelnemende vereniging ------------------- volgende  --------------------------->
<td>

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_top10b.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// verenigingen

for ($i=1;$i<$totaal_3d;$i++){
		
	fwrite($fp, "     <string>".$h_3d_vereniging[$i]." (". $h_3d_aantal[$i].")</string>\n");
	
}	/// end for
	fwrite($fp, "   </row>\n");
   
/// aantal per vereniging	
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Verenigingen</string>\n");
	 	
	for ($i=1;$i<$totaal_3dh;$i++){
		
	fwrite($fp, "     <number>".$h_3d_aantal[$i]."</number>\n");
	
}	/// end for
  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Inschrijven per vereniging</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='500' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Inschrijving 10 hoogste deelnemende verenigingen</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>

</td>
</tr>

<!-------------------------------        regel eronder ------------------------------------------------------------------>
<tr>
		<td>
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_lic_archief.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// licenties
$qry6d = mysql_query("SELECT distinct Soort_Licentie, count(*) as Aantal From stats_naam group by 1 order by 2 desc")     or die(' Fout in select 6d'); 
  
 $i=1;
 while($row = mysql_fetch_array( $qry6d )) {
 	$soort = $row['Soort_Licentie'];
 	if ($soort == ''){
 		$soort = 'Onbekend'; 
 }// end if
	fwrite($fp, "     <string>".$soort."  (". $row['Aantal'].")</string>\n");
	
}	/// end while
	fwrite($fp, "   </row>\n");
   
/// aantal per licentie
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Licenties archief</string>\n");
	 	
$qry6d = mysql_query("SELECT distinct Soort_Licentie, count(*) as Aantal From stats_naam group by 1 order by 2 desc")     or die(' Fout in select 6d'); 
  
 $i=1;
 while($row = mysql_fetch_array( $qry6d )) {
 		fwrite($fp, "     <number>".$row['Aantal']."</number>\n");
	
}	/// end while
  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Verdeling over licenties</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='500' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Licenties - archief</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>		
	</td>
	<td>
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_lic_current.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// licenties
$qry6d = mysql_query("SELECT distinct Soort_Licentie, count(*) as Aantal From hulp_naam group by 1 order by 2 desc")     or die(' Fout in select 6d'); 
  
 $i=1;
 while($row = mysql_fetch_array( $qry6d )) {
 	$soort = $row['Soort_Licentie'];
 	if ($soort == ''){
 		$soort = 'Onbekend'; 
 }// end if
	fwrite($fp, "     <string>".$soort."  (". $row['Aantal'].")</string>\n");
	
}	/// end while
	fwrite($fp, "   </row>\n");
   
/// aantal per licentie
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Licenties (actieve toernooien)</string>\n");
	 	
$qry6d = mysql_query("SELECT distinct Soort_Licentie, count(*) as Aantal From hulp_naam group by 1 order by 2 desc")     or die(' Fout in select 6d'); 
  
 $i=1;
 while($row = mysql_fetch_array( $qry6d )) {
 		fwrite($fp, "     <number>".$row['Aantal']."</number>\n");
	
}	/// end while
  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Verdeling over licenties</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='500' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Licenties - actieve toernooien</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>		
	</td>
	</tr>
	
	<tr>
		<td>

<?php
////////////////////////////////////////////////////////////////////////// volgende regel ////////////////////////////
// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_weekdag.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// weekdagen

for ($i=0;$i<7;$i++){
		
		switch ($i){
			
		case "0"   : 	fwrite($fp, "     <string>Zondag (".$weekdag_3d_aantal[$i].")</string>\n");break;
		case "1"   : 	fwrite($fp, "     <string>Maandag (".$weekdag_3d_aantal[$i].")</string>\n");;break;
		case "2"   : 	fwrite($fp, "     <string>Dinsdag (".$weekdag_3d_aantal[$i].")</string>\n");break;
		case "3"   : 	fwrite($fp, "     <string>Woensdag (".$weekdag_3d_aantal[$i].")</string>\n");break;
		case "4"   : 	fwrite($fp, "     <string>Donderdag (".$weekdag_3d_aantal[$i].")</string>\n");break;
		case "5"   : 	fwrite($fp, "     <string>Vrijdag (".$weekdag_3d_aantal[$i].")</string>\n");break;
		case "6"   : 	fwrite($fp, "     <string>Zaterdag (".$weekdag_3d_aantal[$i].")</string>\n");break;
}// end switch
 }	/// end for
	fwrite($fp, "   </row>\n");
   
/// aantal per weekdag	
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Dagen vd week</string>\n");
	
	for ($i=0;$i<7;$i++){ 	
     	fwrite($fp, "     <number>".$weekdag_3d_aantal[$i]."</number>\n");
	}	/// end for
	
  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Inschrijven per vereniging</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='500' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Per dag van de week archief</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>
</td>	
<td>
<!--------------------------- Soort toernooi ----------->
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="3Dpie_chart_soort.xml";
$fp = fopen($xml_file, "w");
fclose($fp);

$fp = fopen($xml_file, "a");
fwrite($fp, "<chart>\n");
//===== Pas de grootte van het vlak aan
fwrite($fp, "<chart_rect height = '1300'        x='1000'/>\n");
fwrite($fp, "\n");

fwrite($fp, "<chart_data>\n");
fwrite($fp, "    <row>\n");
fwrite($fp, "      <null/>\n");

/// soort toernooi

foreach ($_soort_aantal as $soort => $aantal) {
	
	   switch($soort){
 	    case 1 : $soort_inschrijving  = 'Mêlée'    ; break;
 	    case 2 : $soort_inschrijving  = 'Doublet'; break;
 	    case 3 : $soort_inschrijving  = 'Triplet'; break; 
 	    case 4 : $soort_inschrijving  = 'Kwintet'; break;
 	    case 6 : $soort_inschrijving  = 'Sextet' ; break;
 	  }// end switch
  	  
	fwrite($fp, "     <string>".$soort_inschrijving." (" . $aantal .")</string>\n");	
	}	/// end foreach
	fwrite($fp, "   </row>\n");
   
	fwrite($fp, "   <row>\n");
	 fwrite($fp,"     <string>Soort toernooien</string>\n");
	 	
		/// aantal per soort toernooi

foreach ($_soort_aantal as $soort => $aantal) {

 fwrite($fp, "     <number>".$aantal."</number>\n");
}	/// end foreach 

  fwrite($fp, "   </row>\n");	
  fwrite($fp, "</chart_data>\n");
  fwrite($fp, "\n");

fwrite($fp, "<chart_grid_h thickness='0' />\n");
fwrite($fp, "    <chart_label shadow='low' color='000000' alpha='85' size='10' position='inside' as_percentage='false' />\n");
fwrite($fp, "    <chart_pref select='false' drag='true' rotation_x='60' min_x='20' max_x='90' />\n");
fwrite($fp, "    <chart_rect x='120' y='40' width='500' height='200' positive_alpha='0' />\n");
fwrite($fp, "	   <chart_transition type='spin' delay='.5' duration='0.75' order='category' />\n");
fwrite($fp, "	<chart_type>3D pie</chart_type>\n");
fwrite($fp, "\n");

fwrite($fp, "	<draw>\n");
//fwrite($fp, "		<rect bevel='bg' layer='background' x='0' y='0' width='1400' height='1200' fill_color='4c5577' line_thickness='0' />\n");
//fwrite($fp, "		<text shadow='low' color='0' alpha='10' size='40' x='10' y='260' width='800' height='50' v_align='right'>Inschrijven per vereniging</text>\n");
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='700' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Inschrijving per soort toernooi archief</text>\n");
fwrite($fp, "	</draw>\n");
fwrite($fp, "	<filter>\n");
fwrite($fp, "		<shadow id='low'   distance='2' angle='45' color='0' alpha='50' blurX='4' blurY='4' />\n");
fwrite($fp, "		<bevel id='bg'     angle='180' blurX='100' blurY='100' distance='50' highlightAlpha='0' shadowAlpha='15' type='inner' />\n");
fwrite($fp, "		<bevel id='bevel1' angle='45' blurX='5' blurY='5' distance='1' highlightAlpha='25' highlightColor='ffffff' shadowAlpha='50' type='inner' />\n");
fwrite($fp, "	</filter>\n");
	
fwrite($fp, "<legend bevel='bevel1' transition='dissolve' delay='0' duration='1' x='0' y='45' width='100' height='210' margin='10' fill_color='0' fill_alpha='0' line_color='000000' line_alpha='0' line_thickness='0' layout='horizontal' bullet='circle' size='12' color='red' alpha='99' />\n");

//------ kleuren skippen 

fwrite($fp, "<series_explode>\n");
fwrite($fp, "<number>0</number>\n");
fwrite($fp, "<number>10</number>\n");
fwrite($fp, "</series_explode>\n");
fwrite($fp, "</chart>\n");
fclose($fp);
?>
<!--------------------------- Nu de XML bestanden verwerken---------  WEBPAGE ----------->
<!------ zet charts.swf in de eigen directory !!!!!!!!!!!!!!!!!!!!!!!!!! -->
<div Style="bottom: 1pt solid red;background-color:white;width:450pt;">
	
<script language="JavaScript" type="text/javascript">
<!--
if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
	alert("This page requires AC_RunActiveContent.js.");
} else {
	var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
	if(hasRightVersion) { 
		AC_FL_RunContent(
			'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
			'width', '500',
			'height', '350',
			'scale', 'noscale',
			'salign', 'TL',
			'bgcolor', 'white',
    	'wmode', 'transparent', 
			'movie', 'charts',
			'src', 'charts',
			'FlashVars', 'library_path=charts_library&xml_source=<?php echo $xml_file;?>', 
			'id', 'my_chart_3d',
			'name', 'my_chart_3d',
			'menu', 'true',
			'allowFullScreen', 'true',
			'allowScriptAccess','sameDomain',
			'quality', 'high',
			'align', 'middle',
			'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
			'play', 'true',
			'devicefont', 'false'
			); 
	} else { 
		var alternateContent = 'This content requires the Adobe Flash Player. '
		+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
		document.write(alternateContent); 
	}
}
// -->
</script>
<noscript>
	<P>This content requires JavaScript.</P>
</noscript>
</div>
</td>	
</tr>

	
</table>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<!-- /////////////////////////////////////////////////  einde grafieken -------------------------------------------------->

<a name='all_verenigingen'><h1>Alle verenigingen (<?php echo mysql_num_rows($qry);?>)</h1></a>

<table id= 'MyTable1' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Plaats</th>
			
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 		<td><?php echo $row['Plaats'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
</table>		
<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
	 	
<?php	 	
$totaal =0;
?>
 	

<a name='all_toernooien'><h1>Alle toernooien (<?php echo mysql_num_rows($qry1);?>)</h1></a>

<table id= 'MyTable1' border =1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
		<th>Datum</th>
		<th>Begin<br>inschrijving</th>
		<th>Eind<br>inschrijving</th>
		<th>Laatste<br>wijziging</th>
	</tr>
<?php
$i=1;
while($row = mysql_fetch_array( $qry1 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	
	 	<?php
	 	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysql_query("SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$toernooi."' order by Waarde")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	 $laatst = $row['Laatst'];
	}
    if ($datum=='') { $datum='onbekend';};
    if ($begin_inschrijving =='') { $begin_inschrijving='onbekend';};
    if ($einde_inschrijving =='') { $einde_inschrijving='onbekend';};
      if ($today > $datum) {
      ?>
	 		<td Style=' background-color:red;color:white;'><?php echo $datum;?></td>
	 	<?php } else {?>
	 		 		<td><?php echo $datum;?></td>
	 	<?php }?>
	 	<td ><?php echo $begin_inschrijving;?></td>
	 	<td ><?php echo $einde_inschrijving;?></td>
	 		<td ><?php echo $laatst;?></td>
	 	
	</tr>
 
<?php	 
	$i++; 
};
?>

</table>


<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<a name='best'><h1>Best bezochte toernooien  (20 van <?php echo mysql_num_rows($qry1);?>)</h1></a>

<table id= 'MyTable3' border = 1>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
		<th>Toernooi</th>
	  <th>Datum</th>
	  <th>Soort</th>
		<th>Aantal</th>
		<th>Omgerekend</th>
		<!--th>Laatste</th-->
	</tr>
	
	<?php

$i=1;
while($row = mysql_fetch_array( $qry14 )) {
	
	$soort = $row['Soort_toernooi'];
	
	switch($soort){
 	    case 1 : $soort_toernooi  = 'Mêlée'    ; break;
 	    case 2 : $soort_toernooi  = 'Doublet'; break;
 	    case 3 : $soort_toernooi  = 'Triplet'; break; 
 	    case 4 : $soort_toernooi  = 'Kwintet'; break;
 	    case 6 : $soort_toernooi  = 'Sextet' ; break;
 	  }// end switch
	
	$gewicht   = $row['Aantal'] / $soort;
	
	
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Vereniging'];?></td>
	 	<td><?php echo $row['Toernooi'];?></td>
 	 <td><?php echo $row['Datum'];?></td>
   <td><?php echo $soort_toernooi;?></td>
 	 <td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
 	 <td style= 'text-align:right;'><?php echo number_format($gewicht, 1, ',', '.');?></td>
 	 	 
 	 	 
	 	 <!---td><?php echo $row['Laatst'];?></td-->
	</tr>
 
<?php	 
	$i++; 
};
?>
</table>

<?php
$totaal =0;
?>

<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<!--a name='all_gebruikers'><h1>Gebruikers (<?php echo mysql_num_rows($qry3);?>)</h1></a-->


<table width=85% border=0>


<!----------------  meerdere tabellen naast elkaar ------------>	
	<tr>

<td STYLE="vertical-align: top;">

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4  >Top 10 - Laatste gebruikers</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Laatst</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry11 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 	<td><?php echo $row['Vereniging'];?></td>
    <td><?php echo $row['Laatst'];?></td>
</tr>
 
<?php	 
	$i++; 
};
?>
</table>
</td>
<td>
<!-------------------------------------- tabel eronder in zelfde cel-------------------------------->

<br>

<table id= 'MyTable2' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan =4  >Top 10 - Frequentie gebruikers</th>
	<tr>
		<th>Nr</th>
		<th>Naam</th>
		<th>Vereniging</th>
		<th>Aantal</th>
	</tr>
<?php
$i       = 1;
$totaal  = 0;
while($row = mysql_fetch_array( $qry12 )) {
 ?>
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Naam'];?></td>
	 	<td><?php echo $row['Vereniging'];?></td>
    <td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
</tr>
 
<?php	 
	$i++; 
};
?>
</table>


</Td>
</tr>
</table>


<!---- // naast elkaar tot hier -------------------------->			 
			 


<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<a name='per_dag'><h1>Per dag</h1></a>&nbsp<a href='stats_maand.php' target='_blank' style='font-size:9pt;color:red;text-decoration:none;'>[Vorige maanden]</a>

<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =2>Dag</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysql_fetch_array( $qry5 )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 
	 	 		echo 
	 	 	strftime("%A",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 	 	<td style= 'text-align:right;' ><?php 
	 	 		echo 
	 	 	strftime("%d %B %Y",mktime(0,0,0,$select_month,$row['Dag'],$select_year));?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 		<?php 	 		 $totaal = $totaal + $row['Aantal'];	 		 ?>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	<tr>
	<td colspan =2> Totaal</td>
	<td style='text-align:right;'><?php echo $totaal;?></td>
</tr>
	
	
</table>
<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>

</body>
</html>