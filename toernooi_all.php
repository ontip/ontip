<?php
# toernooi_all.php
# Kalender met toernooien van een vereniging
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 24feb2019        1.0.2         E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None.
# Fix:              None.
# Feature:          Verwerk aantal spelers per datum in toernooi_datums_cyclus 
# Reference: 

# 14mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7 en tonen PDF link
# Reference: 

# 19nov2019        1.0.2         E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    Init arrays.
# Fix:              None.
# Feature:          $array = array()  als oplossing
# Reference: 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
	<head>
	<Title>OnTip (c) Erik Hendrikx</title>	     
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">    
		<link rel="stylesheet" type="text/css" href="mycss.css" />
	
	           
<style type='text/css'><!-- 

TH {color:black ; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:black ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:black ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {text-decoration:none;font-size: 11.0pt ;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:grey;}
// --></style>
</head>

<body>
 
<?php
ini_set('default_charset','UTF-8');
$pageName = basename($_SERVER['SCRIPT_NAME']);


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

/// Schoon hulp tabel

mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging."'  ") ;  

// Insert alle toernooien voor deze vereniging

$insert = mysqli_query($con,"INSERT INTO hulp_toernooi 
   (`Toernooi`, `Vereniging`, Vereniging_id, `Datum`) 
    select distinct Toernooi, Vereniging, Vereniging_id, Waarde from config where Vereniging = '".$vereniging."' and Variabele = 'Datum' and   Waarde >= '".$today."' ");


// verwijder eerst de toernooien uit hulp_toernooi met een record in cyclus  om duplicates bij volgende insert te voorkomen

  $qry      = mysqli_query($con,"SELECT * From toernooi_datums_cyclus  order by Datum" )     or die(' Fout in select cyclus 1');  
 
               while($row = mysqli_fetch_array( $qry )) {
              	
                     $delete = mysqli_query($con,"DELETE from hulp_toernooi where Toernooi = '".$row['Toernooi']."' 
                                           and Vereniging_id = ".$vereniging_id."  and Datum = '".$row['Datum']."' " )     or die(' Fout in delete');  
               }

//  Toernooi Cyclus  15 dec 2017 pak hele cyclus ivm waarden uit basis gegevens

$insert = mysqli_query($con,"INSERT INTO hulp_toernooi
            (`Toernooi`, `Vereniging`, Vereniging_id, `Datum`, Dagnaam) 
             select distinct Toernooi, Vereniging,Vereniging_id, Datum, DAYNAME(Datum) from toernooi_datums_cyclus  ");

//  Meerdaags toernooi

$variabele = 'meerdaags_toernooi_jn';
$qry       = mysqli_query($con,"SELECT * From config where  Vereniging ='".$vereniging."'  and Variabele = '".$variabele ."' and Waarde  = 'J'   ")     or die(' Fout in select meerdaags');  

         while($row = mysqli_fetch_array( $qry )) {
             
               $toernooi          = $row['Toernooi'];
               $vereniging        = $row['Vereniging'];
               $vereniging_id     = $row['Vereniging_id'];
               	
             $variabele = 'datum';
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags1');    
             $row2       = mysqli_fetch_array( $qry2 );
             $toernooi_datum = $row2['Waarde'] ;
        
             $variabele = 'eind_datum';
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags2');    
             $row2       = mysqli_fetch_array( $qry2 );
             $eind_datum = $row2['Waarde'] ;
     
      //      echo $toernooi;
          while($toernooi_datum <=  $eind_datum){	
  	 		           $_datum = $toernooi_datum ; 
         		     
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);     
       
               //      echo "<br>insert ".$toernooi."-".$toernooi_datum;
                     
                  $insert = "INSERT INTO ontip_toernooi
                         (`Toernooi`, `Vereniging`, `Datum`, Dagnaam) 
                            values ('".$toernooi."','".$vereniging."','".$toernooi_datum."',DAYNAME('".$toernooi_datum."')   )";
                  
                    mysqli_query($con,$insert) or die ('Fout in insert meerdaags');   
             
                   $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	               $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	               }///end while                                                            
	       }// end while
 

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
$_now  = date('Y-m-d H:i');
 
 
$update = mysqli_query($con,"UPDATE hulp_toernooi as t
 join config as c
  on t.Toernooi          = c.Toernooi and
     t.Vereniging_id        = c.Vereniging_id 
   set t.Inschrijving_open  = 'N'
   where t.Vereniging = '".$vereniging."' and 
    c.Variabele    = 'begin_inschrijving'
  and c.Waarde > '".$_now."'  ");

$update = mysqli_query($con,"UPDATE hulp_toernooi set Soort_toernooi = '1.Tete-a-tete'   where  Soort_toernooi = 'single' ");
$update = mysqli_query($con,"UPDATE hulp_toernooi set Soort_toernooi = '2.Doublet'       where  Soort_toernooi = 'doublet' ");
$update = mysqli_query($con,"UPDATE hulp_toernooi set Soort_toernooi = '3.Triplet'       where  Soort_toernooi = 'triplet' ");
$update = mysqli_query($con,"UPDATE hulp_toernooi set Soort_toernooi = '5.Kwintet'       where  Soort_toernooi = 'kwintet' ");
$update = mysqli_query($con,"UPDATE hulp_toernooi set Soort_toernooi = '6.Sextet'        where  Soort_toernooi = 'sextet' ");

$achtergrond_kleur  = 'white';
$tekstkleur         = 'black';
$link               = 'blue';
$invulkop           = 'blue';

if (!isset($boulemaatje_gezocht_zichtbaar_jn)) {
	$boulemaatje_gezocht_zichtbaar_jn = 'J';
}

// aangepast 9 maart
// 0 = alle kalenders, 1 = alleen van eigen bond 2 = alleen vereniging kalender 3 = niet op kalenders
/// verwijder toernooi van lijst als toernooi_zichtbaar_op_kalender_jn = 3 

$variabele = 'toernooi_zichtbaar_op_kalender_jn';
 $qry      = mysqli_query($con,"SELECT Vereniging, Toernooi From config where Vereniging = '".$vereniging ."'   and Variabele = '".$variabele ."' and Waarde = '3'  ")     or die(' Fout in select');  

 while($row = mysqli_fetch_array( $qry )) {
   mysqli_query($con,"Delete from hulp_toernooi where Vereniging = '".$vereniging ."' and Toernooi ='".$row['Toernooi'] ."'  ") ;  
} // end while

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$qry          = mysqli_query($con,"SELECT Id, Vereniging,Toernooi, Datum From hulp_toernooi where Vereniging = '".$vereniging ."' and  Inschrijving_open = 'J' order by Datum ")     or die(' Fout in select 2');  


/// Toon alle toernooien
if (isset($_POST['check']) and $_POST['check'] =='Yes'){
$qry          = mysqli_query($con,"SELECT Id, Vereniging,Toernooi, Datum From hulp_toernooi where Vereniging = '".$vereniging ."'  order by Datum ")     or die(' Fout in select 2');  
}

$aantal       = mysqli_num_rows($qry);

$qry1                     = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ")     or die(' Fout in select');  
 $result                  = mysqli_fetch_array( $qry1);
 $indexpagina_kop_jn      = $result['Indexpagina_kop_jn'];
 $url_logo                = $result['Url_logo'];
 $url_website             = $result['Url_website'];
 $prog_url                = $result['Prog_url'];
 $vereniging_output_naam  = $result['Vereniging_output_naam'];

$_vereniging = $vereniging;
if ($vereniging_output_naam !='') {
	$_vereniging = $vereniging_output_naam;
}

 /// Koptekst  toernooi_all.php aan (J) of uit (N)
 if ($indexpagina_kop_jn == ''){ $indexpagina_kop_jn = 'J';  }   
 
if (isset($_GET['bgcolor'])) {
	$bgcolor = $_GET['bgcolor'];
	
	?>
	<body bgcolor="<?php echo($bgcolor);?>"  >
	<?php } else {?>
<body>
<?php }?>

<?php if (isset($indexpagina_kop_jn) and  $indexpagina_kop_jn == 'J'){ ?>

<div style='border:2px solid red;box-shadow: 10px 10px 5px #888888;'>

<table STYLE ='background-color:white;' width=99%>
<tr><td rowspan=3><a href='<?php echo $url_website;  ?>' target ='top' border =0><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></a></td>
<td STYLE ='font-size: 40pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $_vereniging ?></TD>
<td rowspan=3 style= 'text-align:right;padding:10pt;'><img src = '../ontip/images/icon_ical.png' width='100'></td>
</tr>
	

<td STYLE ='font-size: 12pt; background-color:white;color:brown ;'>Overzicht van de komende toernooien waarvoor men kan inschrijven.</TD>
</TR>
</TABLE>
</div>

<?php } ?>

<?php if (!isset($indexpagina_kop_jn)){ ?>

<div style='border: red solid 1px;background-color:white;'>

<table STYLE ='background-color:white;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></td>
<td STYLE ='font-size: 40pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>
	

<td STYLE ='font size: 15pt; background-color:white;color:brown ;'>Overzicht van de komende toernooien waarvoor men kan inschrijven.</TD>
</TR>
</TABLE>
</div>

<?php } ?>

<center>
	<br>
<h2>Klik op de naam van een van de onderstaande <?php echo $aantal ?> toernooien om je direct in te schrijven. 
	
	<?php if (isset($indexpagina_kop_jn) and  $indexpagina_kop_jn == 'J'){ ?>
	
	Klik op bovenstaand logo om terug te keren naar de website.
 <?php } ?>
 </h2>
 
 <FORM action='<?php echo $pageName;?>' method='post'>
<table>
	<tr >
	<td style='text-align:center;'>
		<?php
   	 if (isset($_POST['check']) ){
    ?>
   	<input type='checkbox' name='check' value ='Yes' checked>Vink deze aan om ook nog niet geopende toernooien te tonen. 
  <?php } else {?>  
   	<input type='checkbox' name='check' value ='Yes'>Vink deze aan om ook nog niet geopende toernooien te tonen.  
  <?php } ?> 
</td>
</tr>	
</table>
 <INPUT type='submit' value='Bevestigen'>
</form>
</center>


<div style='text-align:right;font-size:9pt;padding-right:12px;'>
			<img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =26 > Link naar (OnTip) PDF flyer. &nbsp

	Indicatie van aantal inschrijvingen : 
	<img src ='../ontip/images/blok_rood.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
  <img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
	<img src ='../ontip/images/blok_groen.jpg' width=12 alt = 'Vulgraad toernooi' />
</div>	
<?php
while($row = mysqli_fetch_array( $qry )) {

//echo "xxxx  ".$row['Vereniging'];
//echo "xxxx  ".$row['Toernooi'];

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

	$toernooi   = $row['Toernooi'];
	$vereniging = $row['Vereniging'];
  $ontip_id   = $row['Id'];
		
		
	$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$row['Vereniging'] ."' and Toernooi = '".$row['Toernooi'] ."' ")     or die(' Fout in select');  

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
// Betaling via IDEAL  11 nov 2016

 $qry1          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'ideal_betaling_jn' ") ;  
 $result        = mysqli_fetch_array( $qry1);
 $ideal_betaling = $result['Waarde'];
   
   
   
if ($toernooi_gaat_door_jn == 'N'){
$variabele = 'toernooi_gaat_door_jn';
 $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result         = mysqli_fetch_array( $qry1);
 $reden_niet_doorgaan = $result['Parameters'];
 }
 
/// ophalen parameter ivm beperkte inschrijving

		$naam_vereniging = '';
    $wel_niet        = '';
    
if ($bestemd_voor !='' ){
	
   $qry1          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'bestemd_voor' ") ;  
   $result       = mysqli_fetch_array( $qry1);

	
   if ($result['Parameters'] =='') { 
     $wel_niet        = substr($result['Waarde'],-2);
     $naam_vereniging = substr($result['Waarde'],0,strlen($result['Waarde'])-2);
    }
   else {
     $naam_vereniging = $result['Waarde'];
     $wel_niet        = $result['Parameters'];
   } 

     $_vereniging = $vereniging;
     if ($vereniging_output_naam !=''){
      	  $_vereniging = $vereniging_output_naam;
   	}
    	
    //	echo "xxxxxxxxxxxxxxxxxxxxx".$_vereniging;
    	
}

	// Datum uit hulp_toernooi ivm toernooi cyclus
	
		
	$sql2       = mysqli_query($con,"SELECT Datum FROM hulp_toernooi where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi."' and Id = ".$ontip_id."  ")     or die(' Fout in select 3d');  
  $result2    = mysqli_fetch_array( $sql2 );
	$datum      = $result2['Datum'];
	
 	
$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

$datum_toernooi = $jaar.$maand.$dag;


//echo "today : ". $today. "<br>";
//echo "begin : ". $begin_inschrijving. "<br>";

if ($datum >= $today  ){


// aantal deelnemers

	/// meerdaags_toernooi  31 jul 2017

$variabele = 'meerdaags_toernooi_jn';
 
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select schema');  
 $result    = mysqli_fetch_array( $qry1);
 $meerdaags_toernooi_jn   = $result['Waarde'];


/// 24feb 2019
if ( $meerdaags_toernooi_jn !='X'){

$sql2       = mysqli_query($con,"SELECT count(*) as Aantal FROM inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select 4');  
$result     = mysqli_fetch_array( $sql2 );
$aantal     = $result['Aantal'];

}
else {
	 $sql_cyclus      = mysqli_query($con,"SELECT Aantal_splrs as Aantal from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum = '".$datum."' " )     ; 
	 $result          = mysqli_fetch_array( $sql_cyclus );
	 $aantal          = $result['Aantal'];
}


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

// Betaling via IDEAL


   $qry1          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'ideal_betaling_jn' ") ;  
   $result        = mysqli_fetch_array( $qry1);
   $ideal_betaling = $result['Waarde'];
  
     
 $einde  = 0; 
 
 // Bereken hoe vol 

$perc = ($aantal / ($max_splrs / 100));

$achtergrond_kleur  = 'white';
$tekstkleur         = 'black';
$link               = 'blue';
$invulkop           = 'blue';
$koptekst           ='red';
?>

<div style='border: red solid 1px;margin:10pt;font size: 14pt;padding:8pt;font-family:Arial;background-color:#FFF8DC;' 
	onmouseover="style.backgroundColor='lightgrey';Style.color='blue'"
     onmouseout="style.backgroundColor='#FFF8DC';Style.color='black'" ><center>
	<table border= 0 width = 98%  style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0>
		<tr>
		<?php if ($ideal_betaling !='J'){ ?>
		<td style='text-align:left;background-color:white;' colspan =2>
		<?php } else { ?>
			<td style='text-align:left;background-color:white;' colspan =1>
	<?php } ?>			

<span style = 'color:<?php echo $koptekst; ?>;font-size:12pt;font-weight:bold;'> <?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar)); ?></span> -&nbsp
<?php


/// Geen link  als de inschrijving nog niet open staat

//                    012345678901234567

// begin_inschrijving 2016-04-21 10:00
$_begin_inschrijving = substr($begin_inschrijving,0,4).substr($begin_inschrijving,5,2).substr($begin_inschrijving,8,2).substr($begin_inschrijving,11,2).substr($begin_inschrijving,14,2);
$_now  = date('YmdHi');

if (!isset($aantal_reserves)){
	$aantal_reserves = 0;
}

  if ( $_begin_inschrijving <= $_now ){
  ?>
  
  <?php 
  if (isset($_GET['smal'])){?>
  
  <a href= "<?php echo $prog_url; ?>Inschrijfform.php?simpel&toernooi=<?php echo $toernooi; ?>" style='color:<?php echo $link; ?>;'>
  <?php }  else { ?>
  	 <a href= "<?php echo $prog_url; ?>Inschrijfform.php?toernooi=<?php echo $toernooi; ?>" style='color:<?php echo $link; ?>;'>
  <?php } ?>	
  	
  	
<span style='text-decoration:none;font-size:12pt;font-weight:bold;'><?php echo $_vereniging; ?> - <?php echo $toernooi_voluit; ?></span></a>
<?php } else { ?>	
 <span style='text-decoration:none;font-size:12pt;color:blue;'><?php echo $_vereniging; ?> - <?php echo $toernooi_voluit; ?></span>
<?php } ?>		
	
<?php
     $output_pdf = $prog_url.'images/'.$toernooi.'_'.$datum_toernooi.'.pdf';       
   		if (file_exists($output_pdf)){ ?>
	     			<a  style= 'font-size:9pt;color:red;' href= '<?php echo $output_pdf;?>' border = 0 width =28 target='_blank' ><img src='../ontip/images/pdf_ontip_logo.gif' border = 0 width =26 ></a>
	<?php }	 ?>	

	
	<span style='font-size:12px;color:darkgreen; ?>;'> <?php echo($extra_koptekst); ?></span>  
</td>
<!--/// Ideal--> 
			<?php if ($ideal_betaling =='J'){ ?>
		<td style= 'text-align:center;background-color:white;'><img src = '../ontip/images/ideal.bmp'  width=35 border =0></td>
	<?php } ?>	
	
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

if ( $_begin_inschrijving > $_now ){
	$dag   = 	substr ($begin_inschrijving , 8,2); 
  $maand = 	substr ($begin_inschrijving , 5,2); 
  $jaar  = 	substr ($begin_inschrijving , 0,4); 
  $uur = 	substr ($begin_inschrijving , 11,2); 
  $min= 	substr ($begin_inschrijving , 14,2); 
  
  
  echo "<div style='font-weight:bold;font-size:12pt;padding:6pt;color:red;'>Inschrijving voor dit toernooi is pas mogelijk vanaf ". strftime("%A %e %B %Y %H:%I", mktime($uur, $min, 0, $maand , $dag, $jaar)).".</div>";
  $einde = 1;
}



	
	
?>
	<br>
	<?php 
	
	
if ($aantal >= $max_splrs and $einde == 0){

 if ($wel_niet == 'J'){

	if ($aantal_reserves > 0 and $aantal  >= $max_splrs and $aantal <  ( $max_splrs + $aantal_reserves )   ){
	   echo "<b>Het toernooi is volgeboekt voor leden van ".$_vereniging.". U kunt zich nog als reserve team of speler inschrijven in het geval er iemand afzegt (Max. ".$aantal_reserves." reserves).</b><br> ";
 	}
	
	if ($aantal >= $max_splrs  and $aantal_reserves == 0 ) {
		echo "<br><B>Dit toernooi is VOLGEBOEKT voor leden van ".$_vereniging." !!!</B><br>";
  }

 if ($aantal_reserves > 0 and   $aantal >= ( $max_splrs + $aantal_reserves ) and $einde  == 0  ){
	echo "<b>Het toernooi is VOLGEBOEKT voor leden van ".$_vereniging.".</b><br> ";
 	}	
 
}  else {


	if ($aantal_reserves > 0 and $aantal  >= $max_splrs and  $aantal <( $max_splrs + $aantal_reserves ) and $einde  == 0  ){
	echo "<b>Het toernooi is volgeboekt. U kunt zich nog als reserve team of speler inschrijven in het geval er iemand afzegt (Max. ".$aantal_reserves." reserves).</b><br> ";
 	}	
 	
 	
 	if ($aantal >= $max_splrs  and $aantal_reserves == 0 and $einde  == 0) {
		echo "<br><B>Dit toernooi is VOLGEBOEKT !!!</B>";
  }

if ($aantal_reserves > 0 and   $aantal >= ( $max_splrs + $aantal_reserves ) and $einde  == 0  ){
	echo "<b>Het toernooi is VOLGEBOEKT !!!!.</b><br> ";
 	}	

} // wel
	
} // aantal > max


	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
		
/// Geen link  als de inschrijving nog niet open staat
  if ( $_begin_inschrijving <= $_now ){
  ?>
				
Klik <a href='lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi;?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_blank'>hier</a> voor de lijst van deelnemers.</b>
     <?php if ($boulemaatje_gezocht_zichtbaar_jn == 'J' and $soort_inschrijving !='single'  and $einde  == 0){ ?>
  	  	        	  	<br>Wil je meedoen met dit toernooi, maar heb je geen boule maatje ? Of wil je je opgeven als reserve speler ? Klik <a href='https://www.ontip.nl/<?php echo substr($prog_url,3);?>boulemaatje_gezocht_stap1.php?toernooi=<?php echo $toernooi;?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_blank'>hier</a> voor "Boulemaatje gezocht".</br>
     <?php } ?>
<?php if ($ideal_betaling =='J'){ ?>
Klik <a href='https://www.ontip.nl/<?php echo substr($prog_url,3);?>betaal_inschrijving.php?toernooi=<?php echo $toernooi;?>' style='color:<?php echo $link; ?>;font size: 10pt;font-family:Arial;' target ='_blank'>hier</a> als je de inschrijving nog moet betalen.</b>
<?php } ?>


     <?php } ?>
      
</td>
<td width = 15% style='text-align:left;background-color:<?php echo $achtergrond_kleur; ?>;'><center><span style= 'font-size:20px;color:<?php echo $link; ?>;background-color:<?php echo $achtergrond_kleur; ?>;'>
	
	<?php
	switch ($soort_inschrijving) {
		case "sextet"  :  $soort = "Sextet";break;
		case "doublet" :  $soort = "Doublet";break;
		case "4x4"     :  $soort = "4x4";break;
	  case "triplet" :  $soort = "Triplet";break;
	  case "kwintet" :  $soort = "Kwintet";break;
	  default : echo "Tête-a-Tête"; break ;
		}

	;
		$count = 0;

	
  if ($meerdaags_toernooi_jn =='X'){ 
    $qry2      = mysqli_query($con,"SELECT  count(*) as Aantal From toernooi_datums_cyclus where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' " )     or die(' Fout in select cyc1');  
    $result2   = mysqli_fetch_array( $qry2);
    $count     = $result2['Aantal'];
   }
   
   if ($count > 0){
   	
   	// rangnummer
  if ($meerdaags_toernooi_jn =='X'){ 
    $qry3      = mysqli_query($con,"SELECT count(*) as Nummer  From toernooi_datums_cyclus where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Datum <= '".$datum."' " )     or die(' Fout in select cyc2');  
    $result3   = mysqli_fetch_array( $qry3);
    $nummer     = $result3['Nummer'];
   }

 ?>
   	
   	
   	<span style= 'font-size:14px;color:<?php echo $link; ?>;background-color:<?php echo $achtergrond_kleur; ?>;'>
   	<?php echo $soort. "<br> Cyclus [". $nummer."/".$count. "]";?>
   <?php } else {?>
   	  	<span style= 'font-size:20px;color:<?php echo $link; ?>;background-color:<?php echo $achtergrond_kleur; ?>;'>
   	<?php echo $soort;
  }	 

if ($meerdaags_toernooi_jn =='J'){ 
	
             $variabele = 'datum';
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags1');    
             $row2       = mysqli_fetch_array( $qry2 );
             $toernooi_datum = $row2['Waarde'] ;
        
             $variabele = 'eind_datum';
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select meerdaags2');    
             $row2       = mysqli_fetch_array( $qry2 );
             $eind_datum = $row2['Waarde'] ;
    
         
                $aantal_dagen=0;
                $nummer =0;
                $j=1;
               
                $datum_array = array(); 
                while($toernooi_datum <=  $eind_datum){	
                	$_datum = $toernooi_datum ;
                  $aantal_dagen++;
                   $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);     
                   
                  
                  $datum_array[$j] = $toernooi_datum;
                  $j++;
                  $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	              $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	  
                 } // end while
                 
                 $nummer = array_search($datum, $datum_array);
             
          $text =  $soort."<br> Meerdaags [". $nummer."/".$aantal_dagen. "]";         
          ?>
	<span style= 'font-size:18px;color:<?php echo $link; ?>;background-color:<?php echo $achtergrond_kleur; ?>;'>
	<?php echo $text;?>
</span>
<?php
     
}// J
		?>
<br><br><center><span style='font-weight:bold;text-align:center;font-size:10pt;color:blue;vertical-align:bottom;'  alt = 'Vulgraad toernooi'>
<?php
//echo "Percentage :".$perc. "  " ;


 if ($perc <= 17){
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
	    echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}


if ($perc > 17 and $perc <= 32){
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
   	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}  

if ($perc > 32 and $perc <= 48){
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}

if ($perc > 48 and $perc <= 64){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}

if ($perc > 64 and $perc <= 80){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}

if ($perc > 80 and $perc <= 90){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_groen.jpg' width=15 alt = 'Vulgraad toernooi' />";
}

if ($perc > 90 and $perc <= 99){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_oranje.jpg'  width=15 alt = 'Vulgraad toernooi' />";
}

if ($perc >  99 ){
      echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg' width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=15 alt = 'Vulgraad toernooi' />";
  	  echo "<img src ='../ontip/images/blok_rood.jpg'  width=15 alt = 'Vulgraad toernooi' />";
}

?>  	

  
	
	</span></center><br></td></tr>
</table>
</center>

</div>
<?php } } ?>
<hr color = grey>
<div style='font-size:8pt;color:grey;'><b>Formulieren zijn gemaakt met OnTip</b><br>(c) Erik Hendrikx, Bunschoten <?php echo date('Y');?>.<br><a style='font-size:8pt;color:green;text-decoration:underline;' href='https://www.ontip.nl/ontip/pdf/Flyer_OnTip.pdf' target='_blank'>Wat is OnTip ?</a> | <a style='font-size:8pt;color:green;text-decoration:underline;' href='https://www.ontip.nl/toernooi_ontip.html' target='_blank'>Link naar OnTip Toernooi kalender</a> |
<span style='color:green;'>OnTip nu ook inschrijven met SMS bevestiging of <img src ='../ontip/images/ideal.bmp' width =24> betaling. Vraag de wedstrijd commissie naar de mogelijkheden &nbsp<img src = '../ontip/images/sms_bundel.jpg' width='26'></span></div>
  
</body>
</html>

