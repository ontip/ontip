<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /-->

<title>Statistieken inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:black;font-family: Calibri, Verdana;font-size:14pt;}
h1   {color:red;}
h2   {color:red;font-size:11pt;}
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

 
<?php 
// Database gegevens. 

include('mysqli.php');
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

// Id ophalen ipv Vereniging ipv problemen met vreemde tekens
//$vereniging = $_GET['Vereniging'];
$id = $_GET['Id'];


$qry2    = mysqli_query($con,"SELECT * from vereniging where Id = ".$id." ")           or die(' Fout in select 2');  
$result2  = mysqli_fetch_array( $qry2);
$prog_url   = $result2['Prog_url'];
$vereniging = $result2['Vereniging'];


if (substr($prog_url,-1) != '/'){
	$prog_url = $prog_url."/";
}
// echo $prog_url;

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Statistieken - <?php echo  $vereniging; ?>";
</script> 

<?php



ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
	
	$qry1    = mysqli_query($con,"SELECT Distinct Vereniging, Toernooi From config  order by Vereniging, Toernooi ")           or die(' Fout in select 1');  
  $qry2    = mysqli_query($con,"SELECT Vereniging, Toernooi,Datum, count(*) as Aantal,max(Inschrijving) as Laatst From inschrijf  group by Vereniging, Toernooi,Datum order by Laatst desc ")     or die(' Fout in select 2'); 
  
	$qry3    = mysqli_query($con,"SELECT * FROM namen Order by Vereniging");   
	$qry4    = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf")     or die(' Fout in select'); 
		
	$result  = mysqli_fetch_array( $qry4 );
	
	  
  $totaal_inschrijvingen  = $totaal_inschrijvingen + $result['Aantal'];
  
  $qry5    = mysqli_query($con,"SELECT DAY(Inschrijving) as Dag, WEEKDAY(Inschrijving) as Dagnaam, count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."' and Vereniging = '".$vereniging."' group by 1 order by 1  ")     or die(' Fout in select namen 5');  
	
  $qry5_tot    = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf 
	                     where Month(Inschrijving) = '".$select_month."'
	                     and Year(Inschrijving) = '".$select_year."' and Vereniging = '".$vereniging."'  ")     or die(' Fout in select namen  5 tot');  
  $result  = mysqli_fetch_array( $qry5_tot );
  $totaal_maand  = $result['Aantal'];
  
  //echo "SELECT distinct Toernooi, Datum, count(*) as Aantal From stats_naam where Vereniging = '".$vereniging."' group by Toernooi order by Aantal desc";
  $qry6  = mysqli_query($con,"SELECT distinct Toernooi, Datum, count(*) as Aantal From stats_naam where Vereniging = '".$vereniging."' group by Toernooi, Datum order by Datum")     or die(' Fout in select 6'); 
  $qry6b = mysqli_query($con,"SELECT distinct Vereniging_speler, count(*) as Aantal From stats_naam where Vereniging = '".$vereniging."' group by Vereniging_speler order by Aantal desc limit 10")     or die(' Fout in select 6b'); 
  $qry6c = mysqli_query($con,"SELECT distinct Soort_toernooi, count(*) as Aantal From stats_naam where Vereniging = '".$vereniging."' group by 1 order by 2 desc")     or die(' Fout in select 6c'); 
  $qry6d = mysqli_query($con,"SELECT distinct Soort_Licentie, count(*) as Aantal From stats_naam group by 1 order by 2 desc")     or die(' Fout in select 6d'); 
  $qry6e = mysqli_query($con,"SELECT DATE_FORMAT(Datum, '%w') as Weekdag , count(*) as Aantal from stats_naam where Vereniging = '".$vereniging."' group by 1 order by 1")              or die(' Fout in select 6e');   
  
  $sql_aant_per_browser      = mysqli_query($con,"SELECT Browser,      count(*) as Aantal  FROM `stats_naam`  where Browser <> ''     and Vereniging = '".$vereniging."'   group by 1 order by 2 desc limit 20")     or die(' Fout in select 17');  
  $sql_aant_per_os_platform  = mysqli_query($con,"SELECT OS_platform,  count(*) as Aantal  FROM `stats_naam`  where OS_platform <> '' and Vereniging = '".$vereniging."'group by 1 order by 2 desc limit 20")     or die(' Fout in select 17');  

  
  
 $i=1;
 while($row = mysqli_fetch_array( $qry6b )) {
 	  $_vereniging = $row['Vereniging_speler'];
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit

$_vereniging        = str_replace("&#226", "â", $_vereniging);
$_vereniging        = str_replace("&#233", "é", $_vereniging);
$_vereniging        = str_replace("&#234", "ê", $_vereniging);
$_vereniging        = str_replace("&#235", "ë", $_vereniging);
$_vereniging        = str_replace("&#239", "ï", $_vereniging);
$_vereniging        = str_replace("&#39",  "'", $_vereniging);
$_vereniging        = str_replace("&#206", "Î", $_vereniging);
 	
 $_3d_vereniging[$i] = $_vereniging;	
 	 	
 //   $_3d_vereniging[$i] = $row['Vereniging'];
    $_3d_aantal[$i]       = $row['Aantal'];
    $i++;
  }
 $totaal_3d = $i;
  
  while($row = mysqli_fetch_array( $qry6c )) {
 	  $soort_toernooi                   = $row['Soort_toernooi'];
 	   	  //echo "soort : ". $soort_toernooi. "<br>";
 	   	  $_soort_aantal[$soort_toernooi]   = $row['Aantal'];
    
 } // end while
  
////// 6e 

 while($row = mysqli_fetch_array( $qry6e )) {
 	
 	   $dagnr                        = $row['Weekdag'];	
 	   $weekdag_3d_aantal[$dagnr]    = $row['Aantal'];
 } // end while

 for ($i=0;$i<7;$i++){ 	
  
    if (!isset($weekdag_3d_aantal[$i])){
     	$weekdag_3d_aantal[$i] =0;
   }
    
  }	/// end for
    
  
  $qry7  = mysqli_query($con,"SELECT count(*) as Aantal From stats_naam")     or die(' Fout in select 7'); 
	$result  = mysqli_fetch_array( $qry7 );
  $archief_inschrijvingen  = $result['Aantal'];

	$qry8    = mysqli_query($con,"SELECT  Vereniging, count(distinct Toernooi) as Aantal FROM `stats_naam`   group by Vereniging order by 2 desc")     or die(' Fout in select 8'); 
	
	$qry9    = mysqli_query($con,"SELECT Naam, Vereniging_speler as Vereniging, count(*) as Aantal FROM `stats_naam` where Vereniging = '".$vereniging."' group by 1 order by 3 desc,1 asc limit 10")     or die(' Fout in select 9'); 
	
	$qry10   = mysqli_query($con,"SELECT DATE_FORMAT(Laatst,'%d-%m-%Y') as Datum , count(*) as Aantal  from stats_naam 
	                       where Vereniging = '".$vereniging."' group by 1 order by 2 desc limit 10")     or die(' Fout in select 10'); 
	
	$qry11   = mysqli_query($con,"SELECT Naam, Vereniging, Laatst from namen where Naam <> 'Erik' order by 3 desc limit 10")     or die(' Fout in select 11'); 
	
	$qry12   = mysqli_query($con,"SELECT Naam, Vereniging, Aantal from namen where Naam <> 'Erik' and Vereniging = '".$vereniging."' order by 3 desc limit 10")     or die(' Fout in select 12'); 

/// over 2012
 $sql2012       = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2012' and Vereniging = '".$vereniging."' group by Maand order by Maand") or die(' Fout in select 2012');;

while($row = mysqli_fetch_array( $sql2012 )) {
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

/// over 2013
 $sql2013       = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2013' and Vereniging = '".$vereniging."' group by Maand order by Maand") or die(' Fout in select 2013'); 

while($row = mysqli_fetch_array( $sql2013 )) {
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

/// over 2014
 $sql2014        = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2014' and Vereniging = '".$vereniging."' group by Maand order by Maand") or die(' Fout in select 2014'); 

while($row = mysqli_fetch_array( $sql2014 )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2014_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal']; 
     //echo $row['Aantal'];  
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2014_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2014_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 

/// over 2015
 $sql2015        = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2015' and Vereniging = '".$vereniging."' group by Maand order by Maand") or die(' Fout in select 2014'); 

while($row = mysqli_fetch_array( $sql2015 )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2015_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal']; 
     //echo $row['Aantal'];  
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2015_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2015_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
  /// over 2016
 $sql2016      = mysqli_query($con,"SELECT count(*) as Aantal, DATE_FORMAT(Laatst,'%m') as Maand  from stats_naam  where DATE_FORMAT(Laatst, '%Y') = '2016' and Vereniging = '".$vereniging."' group by Maand order by Maand") or die(' Fout in select 2014'); 

while($row = mysqli_fetch_array( $sql2016 )) {
      $maand                    = number_format($row['Maand']);
     
     //Let's create a new variable: $aantal_maand_xx
     $var_name = "aantal_maand_2016_". $maand   ; //$var_name will store the NAME of the new variable  $aantal	_maand_xx
    //Let's assign a value to that new variable:
     $$var_name  = $row['Aantal']; 
     //echo $row['Aantal'];  
} //end while         
   
   // vul de nog ontbrekende maanden met een waarde 0
	for ($maand=1;$maand<13;$maand++){
	  $var_name  = "aantal_maand_2016_". $maand   ;
	   if(!isset($$var_name) ){ 
         $var_name = "aantal_maand_2016_". $maand   ; 
         $$var_name  = 0;//   
      }// end if
  }// end for 
  
  
  
	// uur statistieken
$qry13   = mysqli_query($con,"Select date_format(Laatst, '%H' ) as Uur, count(*) AS Aantal from stats_naam where Vereniging = '".$vereniging."' group by 1 order by 1 ")     or die(' Fout in select 13'); 
	 
while($row = mysqli_fetch_array( $qry13 )) {
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
<td colspan =4><span style='Font-size:32pt;color:green;'>STATISTIEKEN - <?php echo $vereniging;?></span></td></tr>
</table>

<hr color=darkgreen/>

<div style='Font-size:11pt;color:brown;'>Statistieken worden samengesteld uit de gegevens uit het archief. Door een toernooi na afloop te verwijderen, worden de gegevens (naam toernooi, vereniging, datum en spelersnamen) automatisch gekopieerd naar het archief.</div>


<!--- //  meerdere tabellen naast elkaar  ------------------>

<a name='stats_inschrijf'><h1>Archief inschrijvingen </h1></a>

<table width=90% border=0>
	
	</tr>
	<tr>
		<td STYLE="vertical-align: top;">
			 
			 
			 
<table id= 'MyTable3' border =1>
	<tr>
		<th style='txt-align:center;color:red;' colspan = 7 >Inschrijvingen per toernooi</th>
	<tr>
		<th>Nr</th>
		<th>Toernooi</th>
		<th>Datum</th>
		<th>Soort</th>
	  <th>Max.splrs</th>
		
		<th>Aantal<br>personen</th>
		<th>Percentage</th>

	</tr>
<?php
$i      = 1;
$totaal = 0;

while($row = mysqli_fetch_array( $qry6 )) {
	$datum =   $row['Datum'];
?>
 
	 <tr>
	 	<td style='text-align:right;'><?php echo $i;?>.</td>
	 	<td><?php echo $row['Toernooi'];?></td>
	 	<td> <?php echo $datum;?></td>
	 	
	 	<?php
	 	$qry    = mysqli_query($con,"SELECT Waarde, Parameters from config where Toernooi = '".$row['Toernooi']."'  and Vereniging = '".$vereniging."' and Variabele = 'soort_inschrijving'  ")     or die(' Fout in select soort'); 
    $result = mysqli_fetch_array( $qry);
    $soort   = $result['Waarde'];
    $methode = $result['Parameters'];
   	
   	$qry    = mysqli_query($con,"SELECT Waarde from config where Toernooi = '".$row['Toernooi']."'  and Vereniging = '".$vereniging."' and Variabele = 'max_splrs'  ")     or die(' Fout in select soort'); 
    $result = mysqli_fetch_array( $qry);
    $max    = $result['Waarde'];
    
    if ($soort =='doublet' and $methode !='single'){
    	 $max = $max *2;
    }
    if ($soort =='triplet' and $methode !='single'){
    	 $max = $max *3;
    }
    $perc = 0;
    if ($max > 0){
    $perc = ($row['Aantal']/( $max/100) );
  }
  
    
    
    ?>
    	<td style='text-align:right;'><?php echo $soort;?></td>	
   
	    <td style='text-align:right;'><?php echo $max;?></td>    
	    <td style='text-align:right;'><?php echo $row['Aantal'];?></td>    
	 	  <td style='text-align:right;'><?php echo number_format($perc, 1, '.', '');?></td>
	 	
	 	
	 	
	 
<?php   $totaal = $totaal + $row['Aantal']; ?>
  
	</tr>
 
<?php	 
	$i++; 
};
?>

<tr><td colspan =5>Totaal</td>
	
	<td style='text-align:right;'><?php echo $totaal;?></td></tr>
</table>

</td>
<!----------- volgende tabel----------------------->
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
while($row = mysqli_fetch_array( $qry9 )) {
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
<!----------- volgende tabel ---------->
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
while($row = mysqli_fetch_array( $qry10 )) {
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
</table>
<!---- // naast elkaar tot hier -------------------------->
<br>
<!-------------------------------------------- Grafieken naast elkaar ---------------------------->
<table border = 0 width = 80%>
	<tr>
		<td>

<!--///////////////////////////////////////////////////////////////// grafieken ///////////////////////////////////-->
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file = $prog_url ."aantal_per_maand".$id.".xml";
$fp = fopen($xml_file, "w");
fclose($fp);
//chmod($xml_file,0644);
//echo $xml_file."<br>";

$fp = fopen($xml_file, "a");

fwrite($fp, "<chart>\n");
fwrite($fp, "<axis_category size='10' color='FF0000' />\n");
fwrite($fp, "<chart_rect x='60' />\n");
fwrite($fp, "<chart_label position='outside' size='4' color='blue' alpha='120' />\n");

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


// 2014

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2014</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2014_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");


// 2015

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2015</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2015_". $month   ;
     
fwrite($fp, "        <number>");
fwrite($fp, $$var_name);                // watch for $$
fwrite($fp, "</number>\n");
}  /// end for month
fwrite($fp, "      </row>\n");


// 2016

fwrite($fp, "      <row>\n");
fwrite($fp, "        <string>2016</string>\n");

for ($month=1;$month<13;$month++){
     $var_name  = "aantal_maand_2016_". $month   ;
     
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

fwrite($fp, "  <series bar_gap='10' set_gap='20' />"."\n");

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
$xml_file =$prog_url ."aantal_per_uur".$id.".xml";
$fp = fopen($xml_file, "w");
fclose($fp);
//chmod($xml_file,0644);

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
fwrite($fp, "        <string>Aantal inschrijvingen per uur van de dag</string>\n");

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

// Kolom kleur

//  77CC00, 8844FF (groen en paars)

fwrite($fp, "<series_color>\n");
fwrite($fp, "<color>8844ff</color>\n");
fwrite($fp, "</series_color>\n");
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

<!-----------  3D pie charts--------------  naast elkaar--------------------------------------->
<br>
<table width =50%>
	<tr>
		<td>

<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file =$prog_url ."3Dpie_chart_top10_".$id.".xml";
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
		
	fwrite($fp, "     <string>".$_3d_vereniging[$i]."</string>\n");
	
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
fwrite($fp, "		<rect shadow='low' layer='background' x='-50' y='70' width='700' height='200' rotation='-5' fill_alpha='0' line_thickness='80' line_alpha='5' line_color='0' />\n");
fwrite($fp, "   <text x='100' y='4' color ='000000'>Inschrijving 10 hoogste verenigingen</text>\n");
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
<!-----------  3D pie charts-------------------------- volgende  --------------------------->
<td>
<?php

// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file =$prog_url ."3Dpie_chart_soort_".$id.".xml";
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
  	  
	fwrite($fp, "     <string>".$soort_inschrijving."</string>\n");	
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
fwrite($fp, "   <text x='100' y='4' color ='000000'>Inschrijving per soort toernooi</text>\n");
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
////////////////////////////////////////////////////////////////////////// volgende regel ////////////////////////////
// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file =$prog_url ."3Dpie_chart_weekdag_".$id.".xml";
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
			
		case "0"   : 	fwrite($fp, "     <string>Zondag</string>\n");break;
		case "1"   : 	fwrite($fp, "     <string>Maandag</string>\n");;break;
		case "2"   : 	fwrite($fp, "     <string>Dinsdag</string>\n");break;
		case "3"   : 	fwrite($fp, "     <string>Woensdag</string>\n");break;
		case "4"   : 	fwrite($fp, "     <string>Donderdag</string>\n");break;
		case "5"   : 	fwrite($fp, "     <string>Vrijdag</string>\n");break;
		case "6"   : 	fwrite($fp, "     <string>Zaterdag</string>\n");break;
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
fwrite($fp, "   <text x='100' y='4' color ='000000'>Per dag van de week</text>\n");
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

<!-- /////////////////////////////////////////////////  einde grafieken -------------------------------------------------->


<a name='per_browser'><h1>Browser en OS Platform</h1></a>


<table>
<tr>
 <td>



<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =1>Browser</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysqli_fetch_array( $sql_aant_per_browser    )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 	 	 		echo $row['Browser'];?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	
	
</table>

<td>
<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =1>OS Platform</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysqli_fetch_array( $sql_aant_per_os_platform   )) {
 ?>
	 <tr>
	 	 	<td style= 'text-align:left;' ><?php 	 	 		echo $row['OS_platform'];?></td>
	 		<td style= 'text-align:right;'><?php echo $row['Aantal'];?></td>
	 </tr>
	 
	<?php
	$i++;
	 } ?>
	
	
	
</table>

</td>
	</tr>
			
</table>


<a style='font-size:9pt;color:blue;text-decoration:none;' href="#home">Home</a>
<a name='per_dag'><h1>Inschrijvingen per dag deze maand(voor actieve toernooien)</h1></a>

<table id= 'MyTable1' border =1>
	<tr>
		<th colspan =2>Dag</th>
		<th>Aantal</th>
			
	</tr>
<?php
$i      = 1;
$totaal = 0;
while($row = mysqli_fetch_array( $qry5 )) {
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