<html>
	<Title>Toernooi kalender Regio detail</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/njbb_logo.ico">

<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;}
TH   {color:blue ;background-color:white; font-size: 10.0pt ; font-family:Comic sans, sans-serif; Font-Style:Bold;text-align: left; border: 1px solid darkgrey;padding:2pt;}
Td   {color:black ; font-size: 10.0pt ; font-family:Comic sans, sans-serif; Font-Style:Bold;text-align: left;padding:2pt; }
h1   {color:red ; font-size: 16.0pt ; font-family:Comic sans, sans-serif ;text-align: left;}
h2   {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Comic sans, sans-serif ;text-align: left;}
h3   {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Comic sans, sans-serif ;text-align: left;}
a    {color:blue ; font-size: 10.0pt ; font-family:Comic sans, sans-serif ;text-decoration:none;}

.kal {border-color:#BBBBBB; border-style:groove; border-width:2px; border-collapse:collapse;
 margin:0px; table-layout:auto;}
 
.kolom2 {font-weight:bold;color:white;background-color:DARKBLUE;}
.kolom3 {color:black;background-color:white;;border: 1px solid darkgrey;}

// --></style>
</head>

<body  style='background-color:#FFFFCD;' >
	
	
	<?php 
ob_start();

include('mysql.php');
ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');


?>
<center>
<div style='width:900;'>

<div>



<h1>Toernooi details</h1>
<br>
<table width=50%>
	<tr>
		<td><a style='font-size:10pt;color:blue;font-weight:bold;' href =  'toernooi_regio.php?bond=De Regio&beknopt' target ='_self'>terug naar lijst</a></td>
		</tr>
</TABLE>
			

<br>
<br>

<?php

$toernooi      = $_GET['toernooi'];
$vereniging_nr = $_GET['vereniging_nr'];

$qry_v  = mysql_query("SELECT * From vereniging where Vereniging_nr = '".$vereniging_nr ."'  ")     or die(' Fout in select ver');  
$row_v  = mysql_fetch_array( $qry_v );
$email_info  = $row_v['Email'];
$vereniging  = $row_v['Vereniging'];
$prog_url    = $row_v['Prog_url'];
$logo_url   = $row_v['Url_logo'];
$url_aanmeldingpagina  = 'http://www.ontip.nl/'.substr($prog_url,3).'inschrijf_form.html?toernooi='.$toernooi;
$url_deelnemers        = 'http://www.ontip.nl/'.substr($prog_url,3).'lijst_inschrijf_kort.html?toernooi='.$toernooi; 
   
if (isset($toernooi)) {
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select config');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	};


// dubbele spatie vervangen  door 1 (fout in invoer in
$einde_inschrijving = str_replace('  ',' ', $einde_inschrijving);
$einde              = explode(" ", $einde_inschrijving);

// verwijderen Speel locatie : 

if (substr($adres,0,15) =='Speel lokatie :') {
$adres = substr($adres,15,99);
}


$adres   = str_replace(';','<br>', $adres);

$einde_datum = $einde[0];
$einde_tijd  = $einde[1];

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

if (strlen($einde_inschrijving) == 10){
	  $einde_inschrijving = $einde_inschrijving . " 00:00";
}	  

$dag2    =  substr ($einde_datum , 8,2); 
$maand2  =	substr ($einde_datum , 5,2); 
$jaar2   =	substr ($einde_datum , 0,4); 

//// 01234567890
//// 2015-01-17



$variabele = 'kosten_team';
 $qry1      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select vereniging');  
 $result    = mysql_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $kosten_team     = $result['Waarde'];
 
 if ($kosten_eenheid == '1' or $soort_inschrijving  == 'single'){  
 	  $kosten_oms = 'persoon';
} else {
	  $kosten_oms = $soort_inschrijving;
}
  
   	
 if ($euro_ind == 'm') {
    $kosten_team  = '&#128 '. $kosten_team . ' per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten_team;
 }         
 

 // Inschrijven als individu of vast team

$qry                 = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result              = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];
$soort_inschrijving  = $result['Waarde'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

$soort           = $soort_inschrijving;


 if ($soort_inschrijving =='single'){
 	$soort = 'Tete-a-tete';


}if ($inschrijf_methode == 'single' and $soort_inschrijving !='single'){
   $soort = $soort_inschrijving."(melee inschrijving)";
 }




?>
<center>
	<div style='width:1000;'>		
		
	<table width=100%>
		<tr>
		<td  style='text-align:left; vertical-align:top;'><img style='padding-top:5pt;'src = "<?php echo $logo_url; ?>" border = 0 width =150>
   </td>
		<td>			
		
<table width = 80% class ='kal' >
	
	<tr><th  width = 35%>Datum</th><td class= 'kolom3'><?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar)) ; ?></td></tr>
	<tr><th  >Naam toernooi</th><td class= 'kolom3'><b><?php echo $toernooi_voluit;?></b></td></tr>
	<tr><th  >Naam vereniging</th><td class= 'kolom3'><?php echo $vereniging;?></td></tr>
	<tr><th  >Plaats</th><td             class= 'kolom3'><?php echo $row_v['Plaats'];?></td></tr>
	<tr><th  >Contact Email</th><td      class= 'kolom3'><a href='mailto:<?php echo $row_v['Email'];?>' > <?php echo $row_v['Email'];?></a></td></tr>
	<tr><th  >Adres locatie</th><td class= 'kolom3'><?php echo $adres;?></td></tr>
	<tr><th  >Min aantal deelnrs</th><td   class= 'kolom3'><?php echo $min_splrs;?></td></tr>
	<tr><th  >Max aantal deelnrs</th><td   class= 'kolom3'><?php echo $max_splrs;?></td></tr>
	<tr><th  >Soort</th><td   class= 'kolom3'><?php echo $soort;?></td></tr>
	<tr><th  >Kosten</th><td   class= 'kolom3'><?php echo $kosten_team;?>  </td></tr>
	<tr><th  >Prijzen</th><td   class= 'kolom3'><?php echo $prijzen;?></td></tr>
	<tr><th  >Aanvang toernooi</th><td   class= 'kolom3'><?php echo $aanvang_tijd;?></td></tr>
	<tr><th  >Inschrijven tot</th><td   class= 'kolom3'><?php echo strftime("%a %e %b %Y", mktime(0, 0, 0, $maand2 , $dag2, $jaar2)) ; ?></td></tr>
	<tr><th  >Website </th><td   class= 'kolom3'><a href = '<?php echo $row_v['Url_website'];?>' target ='_blank'><?php echo $row_v['Url_website'];?></a></td></tr>
	<tr><th  >Inschrijf pagina</th><td   class= 'kolom3'><a href= "<?php echo $url_aanmeldingpagina; ?>" style='color:blue;' target ="_self"><img src='images/aanmelden.jpg' height=23>
		 <img src='images/OnTip_banner_klein.jpg' height=15>
			</a>
		</td></tr>
		<tr><th  >Deelnemers lijst</th><td   class= 'kolom3'><a href= "<?php echo $url_deelnemers; ?>" style='color:blue;' target ="_self"><?php echo $url_deelnemers; ?></a></td></tr>
    </table>
   
    
    <br><br>


</center>
</div>










<p>









</p>
</body>
</html>
	