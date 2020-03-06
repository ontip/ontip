<?php
//// toernooi_regio.php
//// Kalender voor toernooien de regio
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 8mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7 en tonen PDF link
# Reference: 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
	<Title>OnTip (c) Erik Hendrikx</title>	     
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">    
		<link rel="stylesheet" type="text/css" href="mycss.css" />
	
	           
<style type='text/css'><!-- 

TH {color:black ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;padding-right: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {text-decoration:none;font-size: 11.0pt ;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:grey;}
                  
.kolom2 {font-weight:bold;color:black;background-color:#E0DFAF;font-size: 9.0pt;}
.kolom3 {font-weight:bold;color:black;background-color:black;font-size: 9.0pt;}


                  
// --></style>
</head>

<body>
 
<?php
ini_set('default_charset','UTF-8');

include 'mysqli.php'; 
//// Omrekenen datum
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
$today      = date("Y-m-d");

//// Change Title //////
?>
<script language="javascript">
 document.title = "Inschrijven toernooien ";
</script> 
<?php

if (isset($_GET['bond'])){
$bond = $_GET['bond'];
}
else {
	$bond = 'De Regio';
}


if (isset($_GET['beknopt'])){
	$beknopt     = 'J';
}
else { 
  if (isset($_POST['beknopt']) and $_POST['beknopt'] =='Yes' ){
	$beknopt     = 'J';
  }
}

if (!isset($linkr)){
	$linkr = 'blue';
}

/// Schoon hulp tabel

mysqli_query($con,"Delete from regio_toernooi ") ;  

// Insert alle toernooien voor de verenigingen van de opgegeven bond

   
   
 $insert = mysqli_query($con,"INSERT INTO regio_toernooi
    (`Toernooi`, `Vereniging`, Vereniging_nr, `Datum`) 
      select distinct Toernooi, c.Vereniging,c.Vereniging_id, Waarde from config c
        join vereniging as v 
         on c.Vereniging_id = v.Id
   where v.Bond = '".$bond."'  and c.Variabele = 'Datum' and   c.Waarde >= '".$today."' ");

  // Update soort Toernooi
 
$update = mysqli_query($con,"UPDATE regio_toernooi as t
 join config as c
  on t.Toernooi             = c.Toernooi and
     t.Vereniging_nr        = c.Vereniging_id 
   set t.Soort_toernooi =  c.Waarde,
       t.Inschrijving_open  = 'J'
   where          c.Variabele    = 'soort_inschrijving'");

// Update Inschrijving_open
 
$update = mysqli_query($con,"UPDATE regio_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging_nr        = c.Vereniging_id
   set t.Inschrijving_open  = 'N'
   where  c.Variabele    = 'begin_inschrijving'
  and c.Waarde > '".$today."'  ");

$update = mysqli_query($con,"UPDATE regio_toernooi set Soort_toernooi = '1.Tete-a-tete'   where  Soort_toernooi = 'single' ");
$update = mysqli_query($con,"UPDATE regio_toernooi set Soort_toernooi = '2.Doublet'       where  Soort_toernooi = 'doublet' ");
$update = mysqli_query($con,"UPDATE regio_toernooi set Soort_toernooi = '3.Triplet'       where  Soort_toernooi = 'triplet' ");
$update = mysqli_query($con,"UPDATE regio_toernooi set Soort_toernooi = '5.Kwintet'       where  Soort_toernooi = 'kwintet' ");
$update = mysqli_query($con,"UPDATE regio_toernooi set Soort_toernooi = '6.Sextet'        where  Soort_toernooi = 'sextet' ");

$achtergrond_kleur  = 'white';
$tekstkleur         = 'black';
$link               = 'blue';
$invulkop           = 'blue';

if (!isset($boulemaatje_gezocht_zichtbaar_jn)) {
	$boulemaatje_gezocht_zichtbaar_jn = 'J';
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$qry          = mysqli_query($con,"SELECT distinct Vereniging,Toernooi, Datum From regio_toernooi where   Inschrijving_open = 'J' order by Datum ")     or die(' Fout in select 2');  


/// Toon alle toernooien
if (isset($_POST['check']) and $_POST['check'] =='Yes'){
$qry          = mysqli_query($con,"SELECT distinct Vereniging,Toernooi, Datum From regio_toernooi   order by Datum ")     or die(' Fout in select 2');  
}

$aantal       = mysqli_num_rows($qry);
/*
$qry1               = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     or die(' Fout in select');  
 $result             = mysqli_fetch_array( $qry1);
 $indexpagina_kop_jn = $result['Indexpagina_kop_jn'];
 $url_logo           = $result['Url_logo'];
 $prog_url           = $result['Prog_url'];
*/


$indexpagina_kop_jn = 'N';

 /// Koptekst  toernooi_all.php aan (J) of uit (N)
 if ($indexpagina_kop_jn == ''){ $indexpagina_kop_jn = 'J';  }   
 
if (isset($_GET['bgcolor'])) {
	$bgcolor = $_GET['bgcolor'];
	
	?>
	<body bgcolor="<?php echo($bgcolor);?>"  >
	<?php } else {?>
<body  style='background-color:#FFFFCD;' >
<?php }?>



<?php if (isset($indexpagina_kop_jn) and  $indexpagina_kop_jn == 'J'){ ?>

<?php
if (isset($beknopt)){?>

<table  width=99% border = 0>
<tr><td rowspan=3><img src = '../ontip/images/ontip_logo.png' width='240'>
<tr>
<td STYLE ='font-size: 12pt; color:brown ;'>Overzicht van de komende toernooien waarvoor men kan inschrijven. </TD>
</TR>
</TABLE>
<?php } else { ?>
<div style='border:2px solid red;box-shadow: 10px 10px 5px #888888;background-color:#E0DFAF;'>

<table  width=99%>
<tr><td rowspan=3><a href = 'http://www.deregiojdb.nl/' target ='_self' border =0><img src = '../ontip/images/logo_deregio.jpg' width='200'></a></td>
<td STYLE ='font-size: 40pt;color:green ;'>Toernooi inschrijving De Regio</TD>
<td rowspan=3 style= 'text-align:right;padding:10pt;'><img src = '../ontip/images/icon_ical.png' width='100'></td>
</tr>
	

<td STYLE ='font-size: 12pt; color:brown ;'>Overzicht van de komende toernooien waarvoor men kan inschrijven voor toernooien van <?php echo $bond; ?>.</TD>
</TR>
</TABLE>
</div>

<?php } } ?>

<?php if (!isset($indexpagina_kop_jn)){ 
if (!isset($beknopt)){?>

<a name='Home'></a>   
<div style='border: red solid 1px;background-color:white;'>

<table STYLE ='background-color:white;'>
<tr><td rowspan=3><img src = '../ontip/images/logo_deregio.jpg' width='200'></td>
<td STYLE ='font-size: 40pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
	

<td STYLE ='font size: 15pt; background-color:white;color:brown ;'>Overzicht van de komende toernooien waarvoor men kan inschrijven.</TD>
</TR>
</TABLE>
</div>

<?php } } ?>

<center>
	<br>
<h2>Klik op de naam van een van de onderstaande <?php echo $aantal ?> toernooien om je direct in te schrijven.</h2>

 <FORM action='toernooi_regio.php?bond=De Regio' method='post'>
<table>
	<tr >
	<td style='text-align:center;font-size:9pt;'>
		<?php
   	 if (isset($_POST['check']) ){
    ?>
   	<input type='checkbox' name='check' value ='Yes' checked>Vink deze aan om ook nog niet geopende toernooien te tonen.
  <?php } else {?>  
   	<input type='checkbox' name='check' value ='Yes'>Vink deze aan om ook nog niet geopende toernooien te tonen.  
  <?php } ?> 
</td>
<td style='text-align:center;font-size:9pt;'>
		<?php
	
   	 if (isset($_POST['beknopt']) or isset($_GET['beknopt']) ) {
    ?>
   	<input type='checkbox' name='beknopt' value ='Yes' checked>Vink deze aan om een beknopt overzicht te krijgen.
  <?php } else {?>  
   	<input type='checkbox' name='beknopt' value ='Yes'>Vink deze aan om een beknopt overzicht te krijgen.
  <?php } 
    ?> 
</td>
</tr>	
</table>
 <INPUT type='submit' value='Keuze opties bevestigen'>
</form>
</center>
<br>

<?php
if (!isset($beknopt)){?>
<div style='text-align:right;font-size:9pt;padding-right:12px;'>
			<img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =26 > Link naar (OnTip) PDF flyer. &nbsp

	Indicatie van aantal inschrijvingen : 
	<img src ='../ontip/images/blok_rood.jpg'  width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
	<img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
</div>	
<?php }


if (isset($beknopt)){?>
<center>
	<table class="kal" border="1" >
 <tr>
  <th class="kolom2">Datum</th>
  <th class="kolom2">Soort</th>
  <th class="kolom2">Naam toernooi</td>
  <th class="kolom2">Vereniging</th>
  <th class="kolom2">Plaats</th>
 </tr>
 
<?php } 

while($row = mysqli_fetch_array( $qry )) {

//echo "xxxx  ".$row['Vereniging'];
//echo "xxxx  ".$row['Toernooi'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
	$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

$sql2      = mysqli_query($con,"SELECT Prog_url, Url_logo,Plaats, Vereniging_nr  From vereniging where Vereniging = '".$row['Vereniging'] ."' ")     or die(' Fout in select');  
  $result    = mysqli_fetch_array( $sql2 );
  $prog_url  = $result['Prog_url'];
  $logo_url  = $result['Url_logo'];
  $plaats    = $result['Plaats'];
  $vereniging_nr      = $result['Vereniging_nr'];
  $url_deelnemers     = 'https://www.ontip.nl/'.substr($prog_url,3).'lijst_inschrijf_kort.html?toernooi='.$toernooi; 
  $url_boulemaatje    = 'https://www.ontip.nl/'.substr($prog_url,3).'boulemaatje_gezocht_stap1.php?toernooi='.$toernooi;
 
  
// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

if (!isset($min_splrs)){
 	$min_splrs = '0';
}


if (!isset($toernooi_gaat_door_jn)) {
	$toernooi_gaat_door_jn = 'J';
}


if ($toernooi_gaat_door_jn == 'N'){
$variabele = 'toernooi_gaat_door_jn';
 $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result         = mysqli_fetch_array( $qry1);
 $reden_niet_doorgaan = $result['Parameters'];
 }
 
 	
$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 
$datum_toernooi = $jaar.$maand.$dag;


//echo "today : ". $today. "<br>";
//echo "begin : ". $begin_inschrijving. "<br>";

if ($datum >= $today  ){
	
	
$sql2       = mysqli_query($con,"SELECT count(*) as Aantal FROM inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select 4');  
$result     = mysqli_fetch_array( $sql2 );
$aantal     = $result['Aantal'];

// kosten team

$qry2        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'kosten_team' ") ;  
$result2     = mysqli_fetch_array( $qry2);

if ($result2['Parameters']  != ''){
 $parameter       = explode('#', $result2['Parameters']);
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $kosten          = $result2['Waarde'];

 $qry21        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving' ") ;  
 $result21     = mysqli_fetch_array( $qry21);
 $soort_inschrijving = $result21['Waarde'];
 
 if ($kosten_eenheid == '1'){  
 	  $kosten_oms = ' persoon';
} else {
	  $kosten_oms = $soort_inschrijving;
}
 
if ($euro_ind == 'm') {
    $kosten_team  = 'Kosten &#128 '. $kosten . ' per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
 }      
 
} // einde parameter 

// Oude situatie
if ($result2['Parameters']  == ''){

/// Laatste positie kosten_team geeft aan of Euro teken erbij moet
/// m = met  , z = zonder

$len      = strlen($kosten_team);
$euro_ind = substr($kosten_team,-1);

  if ($euro_ind != 'm' and $euro_ind != 'z'){
     	$kosten_team = substr($kosten_team,0,strlen($kosten_team));
      } 
  else { 
      $len         = strlen($kosten_team);
      $euro_ind    = substr($kosten_team,-1);
      $kosten      = substr($kosten_team,0,$len-1);
            
    if ($euro_ind == 'm') {
    		if ($kosten_team != 'm'){
    	     	$kosten_team  = 'Kosten &#128 '. $kosten . ' per inschrijving'; 
    	    }
    }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
    }
  }

}  // einde parameter ''

/// extra koptekst
$qry3         = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'   and Variabele = 'extra_koptekst' ") ;  
$result3      = mysqli_fetch_array( $qry3);

if ($result3['Parameters'] != '') {
	 $extra_koptekst    = $result3['Waarde'];
	 $parameter         = explode('#', $result3['Parameters']);
	 $text_effect       = $parameter[1];
	    if ($text_effect == 'm'){
	 		 $marquee           = '#'.$parameter[1];
	     $_extra_koptekst = "<marquee width=500 behavior=scroll>". $extra_koptekst. "</marquee>";	 
	    }	 
       else {
            $_extra_koptekst = $extra_koptekst;
   }
}  
   // oude manier
 if ($result3['Parameters'] == '') { 

  if (substr($extra_koptekst,0,1) == '%') {
 	 $extra_koptekst = substr($extra_koptekst,1,strlen($extra_koptekst));
 	}

$_extra_koptekst = '';
$len             = strlen($extra_koptekst);
$marquee         = substr($extra_koptekst,-2);
    
 if ($marquee == '#m' or $marquee == '#z'){
      $extra_koptekst = substr($extra_koptekst,0,$len-2);
}
  if ($marquee == '#m' and substr($extra_koptekst,0,4) != '<br>'  ) { 
 	         $_extra_koptekst = "<marquee width=500 behavior=scroll>". $extra_koptekst. "</marquee>";
  }
 if ($marquee == '#m' and substr($extra_koptekst,0,4) == '<br>'  ) { 
 	         $_extra_koptekst = "<br><marquee width=500 behavior=scroll>". substr($extra_koptekst,4,strlen($extra_koptekst)). "</marquee>";
 }
 
 if ($marquee == '#z'  ) { 
      $_extra_koptekst = substr($extra_koptekst,0,strlen($extra_koptekst));
 }
 
} 
 $extra_koptekst = $_extra_koptekst;
 ?>

<?php switch($soort_inschrijving){
    case 'single' :   $soort = 'mêlée';     break;
    case 'doublet' :  $soort = 'doublet'; break;
    case 'triplet' :  $soort = 'triplet'; break;
    case 'kwintet' :  $soort = 'kwintet'; break;
    case 'sextet' :   $soort = 'sextet';  break;
    
  }
  
 if ($toernooi_gaat_door_jn == 'N'){
 $variabele = 'toernooi_gaat_door_jn';
  $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
  $result         = mysqli_fetch_array( $qry1);
  $reden_niet_doorgaan = $result['Parameters'];
 }
  
 $einde  = 0; 
 
 // Bereken hoe vol 

$perc = ($aantal / ($max_splrs / 100));

$achtergrond_kleur  = 'white';
$tekstkleur         = 'black';
$link               = 'blue';
$invulkop           = 'blue';
$koptekst           = 'red';
?>

<?php
if (isset($beknopt)){

$jaar  = substr($datum,0,4);
$maand = substr($datum,5,2);
$dag   = substr($datum,8,2);
$datum_toernooi = $jaar.$maand.$dag;
	
//$toernooi   = str_replace("â","&#226", $row['Toernooi']);	 
//$toernooi   = str_replace("&#226","â", $row['Toernooi']);	 

?>
 
<tr>
<td style= 'text-align:right;'><?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)) ; ?></td>
<td><?php
switch ($soort_inschrijving) {
		case "sextet"  :  echo "Sextette";break;
		case "doublet" :  echo "Doublette";break;
	  case "triplet" :  echo "Triplette";break;
	  case "kwintet" :  echo "Kwintette";break;
	  default : echo "Tête-à-tête"; break ;
		}
?>
</td>
<td>
	
	
	<a href= "toernooi_regio_detail.php?toernooi=<?php echo $toernooi; ?>&vereniging_nr=<?php echo $vereniging_nr; ?>" style='color:blue;' target ="_self">
<span style='text-decoration:none;font-size:10pt;color:blue;'><?php echo $toernooi_voluit; ?></span></a></td>
<td><?php echo $vereniging; ?></td>
<td><?php echo $plaats; ?></td>
</tr>


<?php
///// beknopt einde

} else {
?>


<div  ><center>
	<table border= 1 width = 98%  style='border:2px solid red;box-shadow: 5px 5px 2px #888888;' cellpadding=0 cellspacing=0>
		<tr><td width = 10% rowspan =2  style='background-color:white;'>
			<center>
			
		<?php if($url_website !=''){ ?>
			<a style= 'font-size:11pt;' href = '<?php echo $url_website;?>' target ='_blank'>
	  <?php } ?>
		<img style='padding-top:5pt;'src = "<?php echo $logo_url; ?>" border = 0 width =100></center><br><br><center><span style='font-weight:bold;text-align:center;font-size:10pt;color:blue;vertical-align:bottom;'><?php echo $plaats; ?></span>
		<?php if($url_website !='') { ?>
			 </a>
	  <?php } ?>
		</center>
		</td>		
			
			
			
<td style='text-align:left;background-color:<?php echo $achtergrond_kleur; ?>;' colspan =2>
<span style = 'color:<?php echo $koptekst; ?>;font-size:12pt;font-weight:bold;'> <?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?></span> -&nbsp
<?php
/// Geen link  als de inschrijving nog niet open staat
  if ( $begin_inschrijving <= $today ){
  ?>
  <a href= "<?php echo $prog_url; ?>Inschrijfform.php?toernooi=<?php echo $toernooi; ?>" style='color:<?php echo $link; ?>;'>
<span style='text-decoration:underline;font-size:12pt;'><?php echo $vereniging; ?> - <?php echo $toernooi_voluit; ?></span></a>
<?php } else { ?>	
 <span style='text-decoration:none;font-size:12pt;color:blue;'><?php echo $vereniging; ?> - <?php echo $toernooi_voluit; ?></span>
<?php } ?>		
	
<?php
   $output_pdf = $prog_url.'images/'.$toernooi.'_'.$datum_toernooi.'.pdf';    
  
   		if (file_exists($output_pdf)){ ?>
	     			<a  style= 'font-size:9pt;color:red;' href= '<?php echo $output_pdf;?>' border = 0 width =28 target='_blank' ><img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =26 ></a>
	<?php }	 ?>	
	
	<span style='font-size:12px;color:darkgreen; ?>;'> <?php echo($extra_koptekst); ?></span>  

</td>
</tr>
<tr><td style='text-align:left;background-color:<?php echo $achtergrond_kleur; ?>;' >		
		
<div style='color:<?php echo $tekstkleur; ?>;margin:10pt;font-size: 10pt;padding:5pt;'>
	Dit is een <?php echo $soort; ?> toernooi <?php echo $toegang; ?>. <?php echo $kosten_team ?> . Aantal inschrijvingen tot nu toe : <?php echo $aantal; ?> (Max :<?php echo $max_splrs; ?>) 
	<?php if ($min_splrs >  0 ){
	echo "Minimum aantal inschrijvingen is ".$min_splrs.".<br>";
  }  

if ($toernooi_gaat_door_jn == 'N'){
  echo "<div style='font-weight:bold;font-size:12pt;padding:6pt;color:". $tekstkleur.";'>Het toernooi gaat niet door. De reden hiervan is ".$reden_niet_doorgaan.". </div>";
	$einde = 1;
}

if ( $begin_inschrijving > $today ){
	$dag   = 	substr ($begin_inschrijving , 8,2); 
  $maand = 	substr ($begin_inschrijving , 5,2); 
  $jaar  = 	substr ($begin_inschrijving , 0,4); 
  echo "<div style='font-weight:bold;font-size:12pt;padding:6pt;color:red;'>Inschrijving voor dit toernooi is pas mogelijk vanaf ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar)).".</div>";
}


if ($aantal >= $max_splrs  and $aantal_reserves == 0 and $einde  == 0) {
		echo "<br><B>Dit toernooi is al VOLGEBOEKT !!!</B>";
}
   
	
	
	
?>
	<br>
	<?php 
	if ($aantal_reserves > 0 and $aantal  >= $max_splrs and  $aantal <( $max_splrs + $aantal_reserves ) and $einde  == 0  ){
	echo "<b>Het toernooi is volgeboekt. U kunt zich nog als reserve team of speler inschrijven in het geval er iemand afzegt (Max. ".$aantal_reserves." reserves).</b><br> ";
 	}
		
/// Geen link  als de inschrijving nog niet open staat
  if ( $begin_inschrijving <= $today ){
  ?>
				
Klik <a href='<?php echo $url_deelnemers; ?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_self'>hier</a> voor de lijst van deelnemers.</b>
     <?php if ($boulemaatje_gezocht_zichtbaar_jn == 'J' and $soort_inschrijving !='single'  and $einde  == 0){ ?>
  	  	        	  	<br>Wil je meedoen met dit toernooi, maar heb je geen boule maatje ? Of wil je je opgeven als reserve speler ? Klik <a href='<?php echo $url_boulemaatje; ?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_self'>hier</a> voor "Boulemaatje gezocht".</br>
     <?php } ?>

     <?php } ?>
      
</td>
<td width = 10% style='text-align:left;background-color:<?php echo $achtergrond_kleur; ?>;'><center><span style= 'font-size:24px;color:<?php echo $linkr; ?>;background-color:<?php echo $achtergrond_kleur; ?>;'>
	<?php
	switch ($soort_inschrijving) {
		case "sextet"  :  echo "Sextet";break;
		case "doublet" :  echo "Doublet";break;
	  case "triplet" :  echo "Triplet";break;
	  case "kwintet" :  echo "Kwintet";break;
	  default : echo "Mêlée"; break ;
		}
		?>
<br><br><center><span style='font-weight:bold;text-align:center;font-size:10pt;color:blue;vertical-align:bottom;'  alt = 'Vulgraad toernooi'>
<?php
//echo "Percentage :".$perc. "  " ;


 if ($perc <= 17){
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
	    echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}


if ($perc > 17 and $perc <= 32){
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
   	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}  

if ($perc > 32 and $perc <= 48){
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}

if ($perc > 48 and $perc <= 64){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}

if ($perc > 64 and $perc <= 80){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}

if ($perc > 80 and $perc <= 90){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=20 alt = 'Vulgraad toernooi' />";
}

if ($perc > 90 and $perc <= 99){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_oranje.jpg'  width=20 alt = 'Vulgraad toernooi' />";
}

if ($perc >  99 ){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=20 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=20 alt = 'Vulgraad toernooi' />";
}

?>  	
	</span></center></td></tr>
</table>
<br>
<a style='text-align:left;' href='#Home'><img src = '../ontip/images/home_regio.png' border =0  width = 55></a>
</center>
<br>
</div>
<?php } } }
 
 
 if (!isset($beknopt)){?>
 	
<hr color = grey>
<div style='font-size:8pt;color:grey;'><b>Formulieren zijn gemaakt met OnTip</b><br>(c) Erik Hendrikx, Bunschoten <?php echo date('Y');?>.<br><a style='font-size:8pt;color:green;text-decoration:underline;' href='../ontip/pdf/Flyer_OnTip.pdf' target='_blank'>Wat is OnTip ?</a> | <a style='font-size:8pt;color:green;text-decoration:underline;' href='http://www.ontip.nl/toernooi_ontip.html' target='_blank'>Link naar OnTip Toernooi kalender</a> |
<span style='color:green;'>OnTip nu ook inschrijven met SMS bevestiging. Vraag de wedstrijd commissie naar de mogelijkheden &nbsp<img src = '../ontip/images/sms_bundel.jpg' width='26'></span></div>
 <pre>
<?php }?>	
 	
 	
 	
 	
 	
</pre>
</body>
</html>

