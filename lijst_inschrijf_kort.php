<?php
# lijst_inschrijf_kort.php
# Inschrijf lijst deelnemers
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 29dec2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Onbekende var link_lijst_zichtbaar_jn
# Fix:              Opgelost.
# Feature:          None.
# Reference: 
#
# 1apr2019         -            E. Hendrikx 
# Symptom:   		   None.
# Problem:     	   None.
# Fix:             PHP7
# Reference: 

# 14mei2019        1.0.2         E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None.
# Fix:              None.
# Feature:          Verwerk aantal spelers per datum in toernooi_datums_cyclus en toon ze in overzicht
# Reference: 

# 18okt2019         -            E. Hendrikx 
# Symptom:         None.
# Problem:     	   None.
# Fix: 
# Feature:       Status IN3 toegevoegd            
# Reference: 

# 11feb2020         -            E. Hendrikx 
# Symptom:         None.
# Problem:     	   probleem met insert into hulp_toernooi
# Fix:             database aanpassing (kolom breedte) en soort_licentie uit insert gehaald
# Feature:         Status IN3 toegevoegd            
# Reference: 

?>
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Basis.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Lijst inschrijvingen</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css"> 
body {color:'.$tekstkleur.';font-family: Calibri, Verdana;font-size:14pt;}

table {border-collapse: collapse;}

</style>
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
//This line will copy the formatted text to the clipboard
            controlRange.execCommand('Copy');         

            alert('Your HTML has been copied\n\r\n\rGo to Word and press Ctrl+V');
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>

<script type="text/javascript">
function CopyHTMLToClipboard(element_id) {    
        if (document.body.createControlRange) {
            var htmlContent = document.getElementById(element_id);
            var controlRange;

            var range = document.body.createTextRange();
            range.moveToElementText(htmlContent);

            //Uncomment the next line if you don't want the text in the div to be selected
            range.select();

            controlRange = document.body.createControlRange();
            controlRange.addElement(htmlContent);

            //This line will copy the formatted text to the clipboard
            controlRange.execCommand('Copy');         

            alert('Your HTML has been copied\n\r\n\rGo to Word and press Ctrl+V');
        }
    }    
    
    function xcopyToClipboard( text )
{
  var input = document.getElementById( 'myTable1' );
  input.value = text;
  input.focus();
  input.select();
  document.execCommand( 'Copy' );
}
 
</script>
</head>


<?php 
// Database gegevens. 
include('mysqli.php');

ob_start();
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

$toernooi = $_GET['toernooi'];
$link_lijst_zichtbaar_jn = '';

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 
}
else {
		echo " Geen toernooi bekend :";
	 
};

if (!isset($link_lijst_zichtbaar_jn)){
	$link_lijst_zichtbaar_jn == 'J';
}
	

if ($link_lijst_zichtbaar_jn == 'N' and !isset($_GET['lijst_zichtbaar']) ){
    ?>
   <script language="javascript">
        alert("De wedstrijd commissie heeft de toegang tot de deelnemerslijst voor dit toernooi dichtgezet.")
    </script>
  <script type="text/javascript">
		window.history.go(-1);
	</script>
<?php
exit;
 } // lijst niet zichtbaar


	if (!isset($begin_inschrijving)){
		echo " <div style='text-align:center;padding:5pt;background-color:white;color:red;font-size:11pt;' >"; 
		die( " Er is geen toernooi bekend in het systeem onder de naam '".$toernooi."'.");
		echo "</div>";
	};


$sql  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $sql )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
/// Ophalen tekst kleur

$qry  = mysqli_query($con,"SELECT * From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$row        = mysqli_fetch_array( $qry );

$tekstkleur = $row['Tekstkleur'];
$koptekst   = $row['Koptekst'];
$invulkop   = $row['Invulkop'];
$link       = $row['Link'];

/// nieuw vanaf 5-feb-2015 aparte kleur instellingen

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'tekst_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$tekstkleur          = $result['Waarde'];

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'link_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$link                = $result['Waarde'];

$qry                 = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'koptekst_kleur'  ") ;  
$result              = mysqli_fetch_array( $qry);
$koptekst_kleur      = $result['Waarde'];

/// als achtergrondkleur of instellingen niet gevonden in tabel, zet dan default waarden
if ($tekstkleur ==''){ $tekstkleur = 'black';};
if ($koptekst   ==''){ $koptekst   = 'red';};
if ($invulkop   ==''){ $invulkop   = 'blue';};
if ($link       ==''){ $link       = 'blue';};
if ($koptekst_kleur   ==''){ $koptekst_kleur  = 'red';};

/// Afwijkende font voor koptekst

if (!isset($font_koptekst)){
 	$font_koptekst='';
}

if (!isset($min_splrs)){
 	$min_splrs = '0';
}

 $qry1                   = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id ." ")     or die(' Fout in select vereniging');  
 $result1                = mysqli_fetch_array( $qry1);
 $sortering_korte_lijst  = $result1['Lijst_sortering'];
 $url_logo               = $result1['Url_logo'];
 $grootte_logo           = $result1['Grootte_logo'];
 
 // Gebruik alternatief logo bestand (vanaf 12 feb 2015)

$variabele = 'url_logo';
 $qry1        = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result      = mysqli_fetch_array( $qry1);
  $_url_logo  = $result['Waarde'];


if ($_url_logo != basename($url_logo)  and $_url_logo != ''){	  
 	   $url_logo = 'images/'.$_url_logo;
}

//  alle inschrijvingen

//  19 feb 2016 Kontroleer eerst of er aangepaste volgnummers zijn
$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Volgnummer <> 999   " )    or die(mysqli_error());  
$count    = mysqli_num_rows($qry);

if ($count > 0) {
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer  ".$sortering_korte_lijst. "   " )    or die(mysqli_error());
} else {   
$spelers      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving ".$sortering_korte_lijst. "   " )    or die(mysqli_error());  
}

$aant_splrs   = mysqli_num_rows($spelers);

 // Inschrijven als individu of vast team

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

if  ($inschrijf_methode == ''){
	   $inschrijf_methode = 'vast';
}

/// meerdaags_toernooi  31 jul 2017

$variabele = 'meerdaags_toernooi_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select schema');  
 $result    = mysqli_fetch_array( $qry1);
 $meerdaags_toernooi_jn   = $result['Waarde'];

if (isset($meerdaags_toernooi_jn)){
	
	
 if ($meerdaags_toernooi_jn ==''){
    $meerdaags_toernooi_jn = 'N';
    }

 if ($meerdaags_toernooi_jn =='J'){
 	 $variabele = 'eind_datum';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select adres');  
   $result    = mysqli_fetch_array( $qry1);
   $eind_datum     = $result['Waarde'];
 
 if ($eind_datum ==''){
 	   $eind_datum = $datum;
 }

 $eind_dag   = 	substr ($eind_datum , 8,2); 
 $eind_maand = 	substr ($eind_datum , 5,2); 
 $eind_jaar  = 	substr ($eind_datum , 0,4); 

} 
// toernooi cyclus
if ($meerdaags_toernooi_jn =='X'){

$datums ='';
$today =  date('Y-m-d');

$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		
		     $datum = $row['Datum'];
	        $dag   = 	substr ($datum , 8,2); 
          $maand = 	substr ($datum , 5,2); 
          $jaar  = 	substr ($datum , 0,4); 
      		$datums  = $datums.",".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ); 
      }
      $datums = substr($datums,1,250);
  }
  
} else {
 $meerdaags_toernooi_jn = 'N';	
}// end isset

/// Bepalen aantal spelers voor dit toernooi

$th_style   = 'border: 1px solid black;padding:3pt;background-color:white;color:black;font-size:10pt;font-family:verdana;font-weight:bold;';
$td_style   = 'border: 1px solid black;padding:2pt;color:black;font-size:10pt;font-family:verdana';
$td_style_w = 'border: 1px solid black;padding:2pt;background-color:white;color:black;font-size:10pt;font-family:verdana';

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip Lijst inschrijvingen - <?php echo  $toernooi_voluit; ?>";
</script> 
<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

echo "<table border =0 width=90%>"; 
echo "<tr><td style='background-color:".$achtergrond_kleur.";'><img src='".$url_logo."' width='".$grootte_logo.">";
echo "</td><td style='background-color:".$achtergrond_kleur.";'>";
echo"<h1 style='color:".$koptekst_kleur. ";font-family:".$font_koptekst.";'>Lijst inschrijvingen voor<br>". $toernooi_voluit ."</h1><h3>";

  	if ($meerdaags_toernooi_jn =='N'){
      	echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ;
       }  
    	if ($meerdaags_toernooi_jn =='J'){          
             	echo "van ".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );
             	echo " tot en met ".strftime("%A %e %B %Y", mktime(0, 0, 0, $eind_maand , $eind_dag, $eind_jaar) );
      }  
          	 
    	if ($meerdaags_toernooi_jn =='X'){      
             	echo $datums;
      }  

echo "</h3></td></tr>";
if ($min_splrs >  0  and $aant_splrs < $min_splrs){
	echo "<tr><td style='color:".$tekstkleur,";'>Het minimum aantal inschrijvingen voor dit toernooi is ".$min_splrs.".</td></tr>";
}

echo "</table><br>";

//// SQL Queries

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$result       = mysqli_fetch_array( $qry);

$extra_vraag  = $result['Waarde']; 
if ($extra_vraag != '') { 
		$opties = explode(";",$extra_vraag,6);
    $vraag  = $opties[0];
    $keuze     = explode('#',$result['Parameters']);
    $vraag_op_lijst_jn   = $keuze[1];
}

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_invulveld' ") ;  
$result       = mysqli_fetch_array( $qry);
$count        = mysqli_num_rows($qry);

if ($count > 0) {  
$invulveld    = $result['Waarde']; 
$keuze     = explode('#',$result['Parameters']);
 $verplicht_jn            = $keuze[1];
 $invulveld_op_lijst_jn   = $keuze[2];

}
else {
	$invulveld ='';
	$extra_invulveld ='';
}

if ($inschrijf_methode == 'single' and $soort_inschrijving !='single'){
	  	echo "<span style= 'font-size:10pt;color:".$tekstkleur.";'>Voor dit ".$soort_inschrijving." toernooi dient individueel (mêlée) te worden ingeschreven. De teams worden via loting samengesteld.</span><br><br>";
}

// Tabel met inschrijvingen (niet alle kolommen ivp privacy)
// Koptekst

if ($soort_inschrijving == 'single' or $inschrijf_methode =='single'){

echo "<table  id='myTable1' style='border:2px solid #000000;' cellpadding=0 cellspacing=0 ><tr>";
echo "<th style='". $th_style.";' width=30>Nr</th>";
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";

$aantal_spelers = 1;


if ($extra_vraag != '' and $vraag_op_lijst_jn =='J'){
 echo "<th style='". $th_style.";'>".$vraag."</th>";
}

if ($extra_invulveld != '' and $invulveld_op_lijst_jn =='J'){
 echo "<th style='". $th_style.";'>".$invulveld."</th>";
}

echo "<th style='". $th_style.";'>Status inschrijving</th>";
 
  if ($meerdaags_toernooi_jn =='J'){
  	
  	 	 $variabele = 'eind_datum';
       $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result    = mysqli_fetch_array( $qry1);
       $eind_datum  = $result['Waarde'];
       $toernooi_datum = $datum;

        while($toernooi_datum <=  $eind_datum){
  	 		     $_datum = $toernooi_datum; 
         		     
         		     // 2018-09-09
         		     // 01234567890
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);                                                                 

                   $datum_kop = strftime("%d %b",mktime(0,0,0,$maand,$dag,$jaar)) ;	
 
                   echo "<th style='". $th_style.";font-size:8pt;'>".$datum_kop."</th>";        		    
   		     
  	             $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	             $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while
  }

   //  toernooi cyclus
     if ($meerdaags_toernooi_jn =='X'){
         
         $datums ='';
           
         $sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row = mysqli_fetch_array( $sql )) { 		
         		     $_datum = $row['Datum']; 
         		     
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);                                                                 
	
	                 $datum_kop = strftime("%d %b",mktime(0,0,0,$maand,$dag,$jaar)) ;	
 
                   echo "<th style='". $th_style.";font-size:8pt;'>".$datum_kop."</th>";        		    
        		     
         		    }// while	  	
     }// end toernooi cyclus (x)


echo "</tr>";

}// einde single of melee

if ($licentie_jn =='J'){
$colspan = 2;
}
else {
$colspan = 2;
}


if ($soort_inschrijving  != 'single' and $inschrijf_methode =='vast'){	

echo "<table id='myTable1' style='border:2px solid #000000;' cellpadding=0 cellspacing=0>";
echo "<tr>";
echo "<th colspan = 1 style='". $th_style.";'></th>";
echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 1</th>";
echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 2</th>";
$aantal_spelers = 2;

if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){	
 echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 3</th>";
 $aantal_spelers = 3;
}

if ($inschrijf_methode =='vast' and ( $soort_inschrijving == '4x4' or  $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){	
 echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 4</th>";
 $aantal_spelers = 4;
}

if ($inschrijf_methode =='vast' and ( $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){	
 echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 5</th>";
 $aantal_spelers = 5;
}

if ($inschrijf_methode =='vast' and $soort_inschrijving == 'sextet' ){	
 echo "<th colspan = ".$colspan." style='". $th_style.";'>Speler 6</th>";
// echo "<th colspan = 1 style='color:white;'>.</th>";
$aantal_spelers = 6;
}

$colspan = 1;

if ($extra_vraag != '' and $vraag_op_lijst_jn=='J' and $inschrijf_methode =='vast'){
	$colspan++;
}

if ($extra_invulveld != '' and $invulveld_op_lijst_jn=='J' and $inschrijf_methode =='vast'){
	$colspan++;
}

echo "<th   colspan=".$colspan." style='". $th_style.";'></th>";

$aant_dagen =0;
 if ($meerdaags_toernooi_jn =='J' and $inschrijf_methode =='vast'){
  	
  	 	 $variabele      = 'eind_datum';
       $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result         = mysqli_fetch_array( $qry1);
       $eind_datum     = $result['Waarde'];
       $toernooi_datum = $datum;

        while($toernooi_datum <=  $eind_datum){
     		        $_datum = $toernooi_datum; 
     	          $dag   = 	substr ($_datum , 8,2);                                                                 
                $maand = 	substr ($_datum , 5,2);                                                                 
                $jaar  = 	substr ($_datum , 0,4);                                                                 
	   		     
              	$aant_dagen++;
         		     
  	             $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	             $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
    	   }///end while

   echo "<th   colspan=".$aant_dagen." style='". $th_style.";text-align:center;'>Toernooi datums (meerdaags toernooi)</th>";
  }// end if 

   $aant_dagen =0;
   if ($meerdaags_toernooi_jn =='X' and $inschrijf_methode =='vast'){
        
          $sql2      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row2 = mysqli_fetch_array( $sql2 )) { 		
     	          $aant_dagen++;
         		    }// while	  	
 
      echo "<th   colspan=".$aant_dagen." style='". $th_style.";text-align:center;'>Toernooi datums (toernooi cyclus)</th>";        	
       }// end toernooi cyclus (x)

echo "</tr>";

}// einde <> single

// Tweede kopregel

if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
echo "<tr>";
echo "<th width=40  style='". $th_style.";'>Nr</th>";
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
// if ($licentie_jn=='J'){
// echo "<th >Licentie</th>";
// }

echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
//if ($licentie_jn=='J'){
//echo "<th >Licentie</th>";
//}
}   // eind niet single

if ($inschrijf_methode =='vast' and ($soort_inschrijving =='triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving == 'sextet')){
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
//if ($licentie_jn =='J'){
//echo "<th >Licentie</th>";
//}
}

if ($inschrijf_methode =='vast' and ($soort_inschrijving == '4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving == 'sextet')){
	echo "<th style='". $th_style.";'>Naam</th>";
  echo "<th style='". $th_style.";'>Vereniging</th>";
}

if ($inschrijf_methode =='vast' and ($soort_inschrijving =='kwintet' or $soort_inschrijving == 'sextet')){
  echo "<th style='". $th_style.";;' >Naam</th>";
  echo "<th style='". $th_style."'>Vereniging</th>";
}


if ($inschrijf_methode =='vast' and $soort_inschrijving == 'sextet'){
echo "<th style='". $th_style.";'>Naam</th>";
echo "<th style='". $th_style.";'>Vereniging</th>";
}// einde sextet

 
 if ($extra_vraag != '' and $vraag_op_lijst_jn =='J' and $soort_inschrijving !='single' and $inschrijf_methode =='vast'){
 	 echo "<th style='". $th_style."';'>".$vraag."</th>"; 
}

if ($extra_invulveld != '' and $invulveld_op_lijst_jn=='J' and $inschrijf_methode =='vast'){
 	 echo "<th style='". $th_style."';'>".$invulveld."</th>"; 
}
  
if ($inschrijf_methode =='vast' and $soort_inschrijving !='single'){
echo "<th style='". $th_style.";'>Status inschrijving </th>";
}

   // toernooi cyclus
   if ($meerdaags_toernooi_jn =='X' and $inschrijf_methode =='vast'){
         
         $datums ='';
         $sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row = mysqli_fetch_array( $sql )) { 		
          		     $_datum = $row['Datum']; 
         		       $dag    = 	substr ($_datum , 8,2);                                                                 
                   $maand  = 	substr ($_datum , 5,2);                                                                 
                   $jaar   = 	substr ($_datum , 0,4);                                                                 
	
	                   $datum_kop = strftime("%d %b",mktime(0,0,0,$maand,$dag,$jaar)) ;	
 
                   echo "<th style='". $th_style.";font-size:8pt;'>".$datum_kop."</th>";        		    
   		    }// while	  	
     }// end toernooi cyclus (x)

    if ($meerdaags_toernooi_jn =='J' and $inschrijf_methode =='vast'){
  	
  	 	 $variabele      = 'eind_datum';
       $qry1           = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result         = mysqli_fetch_array( $qry1);
       $eind_datum     = $result['Waarde'];
       $toernooi_datum = $datum;

        while($toernooi_datum <=  $eind_datum){
  	 		     $_datum = $toernooi_datum; 
         		     
             $dag   = 	substr ($_datum , 8,2);                                                                 
             $maand = 	substr ($_datum , 5,2);                                                                 
             $jaar  = 	substr ($_datum , 0,4);                                                                 
	
             $datum_kop = strftime("%d %b",mktime(0,0,0,$maand,$dag,$jaar)) ;	
 
              echo "<th style='". $th_style.";font-size:8pt;'>".$datum_kop."</th>";        		    
         		     
  	         $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	         $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while
    }// end if 

echo "</tr>";

/// Detail regels

if ($sortering_korte_lijst =='ASC'){
	$i=1;
} else {
	$i= $aant_splrs;
}

while($row = mysqli_fetch_array( $spelers )) {

if ($soort_inschrijving =='single' or $inschrijf_methode =='single'  ){
		echo "<tr>";
	 
	 if (($i  > $max_splrs and $aantal_reserves > 0) or (substr($row['Status'],0,2) =='RE')   ){
       echo "<td style='". $td_style_w.";background-color:yellow;' >". $i  . " *</td>" ;
    }
  else {
       echo "<td style='". $td_style_w.";background-color:white;' >". $i  . "</td>" ;
    }  
  
   echo "<td style='". $td_style_w.";'>". $row['Naam1'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging1'] .  "</td>" ;
   }
  
 if ($soort_inschrijving !='single' and  $inschrijf_methode =='vast'){
	 
	 echo "<tr>";
	 if (($i  > $max_splrs and $aantal_reserves > 0) or (substr($row['Status'],0,2) =='RE') ){
       echo "<td style='". $td_style.";background-color:yellow;;text-align:right;' >". $i  . ". *</td>" ;
    }
  else {
       echo "<td style='". $td_style_w.";text-align:right;' >". $i  . ". </td>" ;
    }  
    	
   echo "<td style='". $td_style_w.";'>". $row['Naam1'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging1'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Naam2'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging2'].   "</td>" ;

} // ongelijk single eerste 2 spelers

 if ($inschrijf_methode =='vast' and ($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet')){
   echo "<td style='". $td_style_w.";' >". $row['Naam3'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging3']  . "</td>" ;

 } // triplet, 4x4, kwintet, sextet

  
  if ($inschrijf_methode =='vast' and ($soort_inschrijving == '4x4' or $soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet')){
   echo "<td style='". $td_style_w.";'>". $row['Naam4'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging4'] .  "</td>" ;
} // 4x4, triplet, kwintet, sextet

  
  if ($inschrijf_methode =='vast' and ($soort_inschrijving  == 'kwintet' or $soort_inschrijving == 'sextet')){
   echo "<td style='". $td_style_w.";'>". $row['Naam5'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging5']  . "</td>" ;
 } /// kwintet of sextet
  
  if ($inschrijf_methode =='vast' and $soort_inschrijving  == 'sextet'){
   echo "<td style='". $td_style_w.";'>". $row['Naam6'] .  "</td>" ;
   echo "<td style='". $td_style_w.";'>". $row['Vereniging6'] .  "</td>" ;
 } /// sextet

if ($extra_vraag != '' and $vraag_op_lijst_jn=='J' ){
	if (strpos($row['Extra'],";")  >  0 ){ 
	$opties   = explode(";",$row['Extra']);
  $vraag    = $opties[0];
	$antwoord = $opties[1];
} else { 
	$antwoord = $row['Extra'];
}

 echo "<td style='". $td_style_w.";'>".$antwoord."</td>";
}

if ($extra_invulveld != '' and $invulveld_op_lijst_jn=='J' ){
  echo "<td style='". $td_style_w.";'>".$row['Extra_invulveld']."</td>";
}
  
  switch($row['Status']){
  	
  	case "BE0": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving via Email gemeld.</td>";break;
  	case "BE1": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving, Geen Email bekend.</td>";break;
  	case "BE2": 	echo "<td style='". $td_style_w.";'>Betaald maar nog niet bevestigd.</td>";break;
  	case "BE3": 	echo "<td style='". $td_style_w.";'>Nog niet betaald.Geen Email bekend.</td>";break;
  	case "BE4": 	echo "<td style='". $td_style_w.";'>Betaald en bevestigd.</td>";break;
  	case "BE5": 	echo "<td style='". $td_style_w.";'>Geannuleerd maar nog niet gemeld.</td>";break;
  	case "BE6": 	echo "<td style='". $td_style_w.";'>Geannuleerd en gemeld.</td>";break;
  	case "BE7": 	echo "<td style='". $td_style_w.";'>Geannuleerd. Geen Email bekend.</td>";break;
  	case "BE8": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd. </td>";break;
  	case "BE9": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Geen Email bekend. </td>";break;
  	case "BEA": 	echo "<td style='". $td_style_w.";'>Bevestigd. Email bekend.</td>";break;
  	case "BEB": 	echo "<td style='". $td_style_w.";'>Bevestigd. Geen Email bekend.</td>";break;
  	case "BEC": 	echo "<td style='". $td_style_w.";'>Bevestigd maar nog niet betaald.</td>";break;
  	case "BED": 	echo "<td style='". $td_style_w.";'>Voorlopige inschrijving via SMS gemeld.</td>";break;
  	case "BEE": 	echo "<td style='". $td_style_w.";'>Bevestigd via SMS.</td>";break;
  	case "BEF": 	echo "<td style='". $td_style_w.";'>Geannuleerd en gemeld via SMS.</td>";break;
    case "DE0": 	echo "<td style='". $td_style_w.";'>Deelnemer heeft verzocht inschrijving te verwijderen via mail.</td>";break;
    case "DE1": 	echo "<td style='". $td_style_w.";'>Deelnemer heeft verzocht inschrijving te verwijderen (geen mail bekend).</td>";break;
    case "DE2": 	echo "<td style='". $td_style_w.";'>Deelnemer heeft verzocht inschrijving te verwijderen (geen mail bekend, wel SMS).</td>";break;
  	case "ID0": 	echo "<td style='". $td_style_w.";'>Nog niet bevestigd.Wacht op betaling .</td>";break;
  	case "ID1": 	echo "<td style='". $td_style_w.";'>Betaald via IDEAL.</td>";break;
  	case "ID2": 	echo "<td style='". $td_style_w.";'>Betaling via IDEAL afgebroken of mislukt.</td>";break;
  	case "ID1": 	echo "<td style='". $td_style_w.";'>Betaling via IDEAL mislukt of afgebroken.</td>";break;
  	case "IM0": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "IM1": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Bevestigd via Mail.</td>";break;
  	case "IM2": 	echo "<td style='". $td_style_w.";'>Inschrijving geimporteerd. Niet bevestigd.</td>";break;
  	case "IN0": 	echo "<td style='". $td_style_w.";'>Ingeschreven en bevestigd via Email.</td>";break;
  	case "IN1": 	echo "<td style='". $td_style_w.";'>Ingeschreven. Geen Email bekend.</td>";break;
  	case "IN2": 	echo "<td style='". $td_style_w.";'>Ingeschreven en bevestigd via SMS.</td>";break;
  	case "IN3": 	echo "<td style='". $td_style_w.";'>Reservering omgezet naar inschrijving.Niet bevestigd.</td>";break;
  	case "RE0": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt en bevestigd via Email.</td>";break;
   	case "RE1": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt. Geen Email bekend.</td>";break;
   	case "RE2": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd via Email.</td>";break;
   	case "RE3": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd. Geen Email bekend.</td>";break;
  	case "RE4": 	echo "<td style='". $td_style_w.";'>Reservering aangemaakt. Bevestigd via SMS.</td>";break;
  	case "RE5": 	echo "<td style='". $td_style_w.";'>Reservering geannuleerd en gemeld via SMS.</td>";break;
   	default :     echo "<td style='". $td_style_w.";'>Onbekend.</td>";break; 
  }
 //   meerdaags
 // toernooi cyclus
   
  if ($meerdaags_toernooi_jn =='X'){
      $sql2      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row2 = mysqli_fetch_array( $sql2 )) { 		
         		     $_datum   = $row2['Datum']; 
         		     $deelname = $row['Meerdaags_datums'];
         		     $pos      = strpos($deelname,$_datum);
         		    
                if ($deelname !='' and $pos == true ){                                     
   	               echo "<td style='". $td_style_w.";text-align:center;'>X</td>";
   	               // aantal per dag ophogen
   	               
   	               $var = 'aantal_'.substr($_datum,0,4).substr($_datum,5,2).substr($_datum,8,2);
   	               if (!isset($$var)){
   	               	$$var =1;
   	              } else {
  	                $$var++;
                 }
   	               
                 } else { 
   	               echo "<td style='". $td_style_w.";text-align:center;'>-</td>";
         		    }
         		    }// while	  	
 	 }// end toernooi cyclus (x)
 
   if ($meerdaags_toernooi_jn =='J'){
 
       $toernooi_datum = $datum;
        while($toernooi_datum <=  $eind_datum){
  	 		       $_datum   = $toernooi_datum; 
       		     $deelname = $row['Meerdaags_datums'];
         		   $pos      = strpos($deelname,$_datum);
               
               $dag   = 	substr ($_datum , 8,2);                                                                 
               $maand = 	substr ($_datum , 5,2);                                                                 
               $jaar  = 	substr ($_datum , 0,4);    
                   
         		    
                if ($deelname !='' and $pos == true ){                                     
   	               echo "<td style='". $td_style_w.";text-align:center;'>X</td>";
   	               
   	                 // aantal per dag ophogen
   	               $var = 'aantal_'.substr($_datum,0,4).substr($_datum,5,2).substr($_datum,8,2);
                 if (!isset($$var)){
   	               	$$var =1;
   	              } else {
  	                $$var++;
                 }
   	               
 
                 } else { 
   	               echo "<td style='". $td_style_w.";text-align:center;'>-</td>";
         		    }
                 $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	             $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while

      }// end if
	
echo "</tr>"; 

if ($sortering_korte_lijst =='ASC'){
$i++;
} else {
	$i--;
}


}; //// end while

// totaal per dag
 if ($meerdaags_toernooi_jn !='N'){
$colspan = ($aantal_spelers*2)+2;
echo "<tr>"; 
echo "<td colspan = ".$colspan." style= 'background-color:white;color:black;font-size:9pt;text-align:left;'>Totaal";


  if ($meerdaags_toernooi_jn =='X'){
      $sql2      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row2 = mysqli_fetch_array( $sql2 )) { 		
         		     $_datum   = $row2['Datum']; 
        		    
        		    
        		          ///  0123456789
        		          //   2019-05-15
        		    
                   $var = 'aantal_'.substr($_datum,0,4).substr($_datum,5,2).substr($_datum,8,2);
                   if (!isset($$var)){
                   	$$var =0;
                  }
  	               echo "<td style='". $td_style_w.";text-align:right;'>".$$var."</td>";
  	               
  	               $update = mysqli_query($con,"UPDATE toernooi_datums_cyclus set Aantal_splrs = ".$$var. " where Datum = '".$_datum."' and Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' ");
        		
         		    }// while	  	
 	 }// end toernooi cyclus (x)
 
   if ($meerdaags_toernooi_jn =='J'){
      $sql2      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'   order by Datum" )     ; 
         	
         	while($row2 = mysqli_fetch_array( $sql2 )) { 		
         		     $_datum   = $row2['Datum']; 
        		    
        		    
        		          ///  0123456789
        		          //   2019-05-15
        		    
                   $var = 'aantal_'.substr($_datum,0,4).substr($_datum,5,2).substr($_datum,8,2);
                   if (!isset($$var)){
                   	$$var =0;
                  }
  	               echo "<td style='". $td_style_w.";text-align:right;'>".$$var."</td>";
  	               
  	               $update = mysqli_query($con,"UPDATE toernooi_datums_cyclus set Aantal_splrs = ".$$var. " where Datum = '".$_datum."' and Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' ");
        		
         		    }// while	  	
 	 }// end toernooi cyclus (x)

}// end meerdaags of cyclus
echo "</tr>";
echo "</table><br><br>";

	echo "<div style='font-size:9pt;border:1 pt solid black;color:".$tekstkleur.";'>"; 
if ($sortering_korte_lijst =='ASC') {
 	 	     echo "Op deze lijst staan de oudste inschrijvingen bovenaan.";
   }
  else {
 	  	  echo "Op deze lijst staan de nieuwste inschrijvingen bovenaan.";
}
echo "</div>";

if ($aantal_reserves > 0 and  $aant_splrs > $max_splrs){
	
	echo "<div style='font-size:9pt;border:1 pt solid black;background-color:yellow;color:".$tekstkleur.";'>"; 
echo "* De geel gemarkeerde spelers staan reserve<br>";
echo "</div>";
}

echo "<div style='font-size:9pt;color:".$tekstkleur.";'>"; 
echo "<br>Lijst bijgewerkt t/m ";
echo  date("d-m-Y H:i:s"); 
echo "</div>";

///  Boulemaatjes


//// SQL Queries
$aant_splrs   = 0;
$boule_maatjes        = mysqli_query($con,"SELECT * From boule_maatje  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'   ") ;  
$aant_splrs   = mysqli_num_rows($boule_maatjes );

if ($aant_splrs > 0) {
	?>
	<h3   style= "color:<?php echo $koptekst_kleur;?>;">Boule maatjes</h3>
	

<table border =2 style ='background-color:white;'>
<tr>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Nr</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Naam</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Vereniging</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Licentie</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Tel.nr</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>E-mail</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Opmerking</th>
<th style= 'color:black;font-weight:bold;font-size:10pt;'>Status</td>
</tr>

<?php

/// Detail regels

$i=1;                        // intieer teller 

while($row = mysqli_fetch_array( $boule_maatjes )) {

switch($row['Status'] ){
    case 'B' :   $status = 'Op zoek naar boulemaatje';     break;
    case 'O' :   $status = 'Gekoppeld, team nog niet compleet'; break;
    case 'K' :   $status = 'Gekoppeld en ingeschreven'; break;
    default  :   $status = 'Op zoek naar boulemaatje';     break;

 }

if ($row['Opmerkingen'] == 'Typ hier evt opmerkingen.'){
	$row['Opmerkingen'] ='';
	}


if ($row['Soort_aanvraag'] =='R') { $status = 'Reserve'; }

echo "<tr>"; 
echo "<td style= 'color:black;font-size:9pt;text-align:right;'>";
   echo $i;
   echo ".</td>";
   echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Naam'];
   echo "</td>";
	 echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Vereniging_speler'];
   echo "</td>";
   echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Licentie'];
   echo "</td>";
	 echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Telefoon'];
   echo "</td>";
   echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Email'];
   echo "</td>";
   echo "<td style= 'color:black;font-size:10pt;'>";
   echo $row['Opmerkingen'];
   echo "</td>";
   echo "<td style= 'color:black;font-size:10pt;'>";
   echo $status;
   echo "</td>";
	 ECHO "</tr>"; 
$i++;
};


?>
</table>	
	
	
<?php
} // boule maatjes

// Maak telling per vereniging    
// maak hulptabel leeg
mysqli_query($con,"Delete from hulp_inschrijf  ") or die('Fout in schonen tabel');   

// Vul hulptabel (6x )

$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging1, Naam1 from inschrijf 
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query) or die ('Fout in insert hulp1: '.$query); 

if ($soort_inschrijving !='single'){
$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging2, Naam2 from inschrijf 
    where Toernooi = '".$toernooi."'and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query) or die ('Fout in insert hulp2'); 
}

if ($soort_inschrijving =='triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ){
$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging3, Naam3  from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."')" ;

mysqli_query($con,$query) or die ('Fout in insert hulp3'); 
}

if ( $soort_inschrijving == '4x4' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ){
$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging4, Naam4 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."')" ;

mysqli_query($con,$query) or die ('Fout in insert hulp4'); 
}

if ( $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet' ){
$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging5, Naam5 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."')" ;

mysqli_query($con,$query) or die ('Fout in insert hulp5'); 
}

if ( $soort_inschrijving == 'sextet' ){
$query = "insert into hulp_inschrijf (Toernooi, Vereniging, Naam) 
( select Toernooi, Vereniging6, Naam6 from inschrijf
    where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' )" ;

mysqli_query($con,$query) or die ('Fout in insert hulp6'); 
}
             
$aantal   = mysqli_query($con,"select Vereniging, count(*) as Aantal from hulp_inschrijf  where length(Vereniging) > 0 group by Vereniging order by 2 desc" )   
        or die(mysqli_error());   

echo "<br><table border =1>";
echo "<tr>";
echo "<th style='". $th_style.";'>Vereniging</th>";
echo "<th style='". $th_style.";'>Aantal</th>";
echo "</tr>";

// Detail regels

while($row = mysqli_fetch_array( $aantal )) {

   echo "<tr>";
   echo "<td style='". $td_style_w.";'>". $row['Vereniging']  . "</td>" ;
   echo "<td style='". $td_style_w.";' align='right'>". $row['Aantal']  . "</td>" ;
   echo "</tr>";
  
};

echo "</table><br>";
?>
<?php
/// Maak xml file met de laatst opgeslagen inschrijvingen tbv restore
include ('create_inschrijf_xml.php');
?>

	<!--  Knoppen voor verwerking   ----->
<TABLE>
	<tr><td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;color:<?php echo $tekstkleur;?>;'> 
<form name="test2">
<input type="button" onClick="CopyToClipboard(SelectRange('myTable1'))" value="Select gegevens" /-->
<br><em style='font-size:9pt;color:<?php echo $tekstkleur;?>;'>Druk na Select op CTRL-C en dan om te plakken CTRL-V</em>


</form>
</td><td valign="top" style='background-color:<?php echo $achtergrond_kleur; ?>;color:<?php echo $tekstkleur;?>;'> 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
</tr>
</table>
<div style='font-size:9pt;color:<?php echo $tekstkleur;?>;'>&#169 OnTip - Erik Hendrikx, Bunschoten 2011-<?php echo date('Y');?></div>
</body>
</html>
