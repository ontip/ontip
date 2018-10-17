<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);

ini_set('display_errors', 'OFF');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysql.php');

$toernooi      = $_POST['toernooi'];   
$qry           = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result        = mysql_fetch_array( $qry);
$vereniging_id = $result['Id'];

$toernooi = $_POST['toernooi'];

/// Generieke update

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' order by Variabele") ;  

//echo "SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' order by Variabele<br>";


$regel = 0;
while($row = mysql_fetch_array( $qry )) {

$id         = $row['Id'];
$var        = $row['Variabele'];

if (isset($_POST['Waarde-'.$id])){
$waarde     = $_POST['Waarde-'.$id];    

//$regel      = $_POST['Regel-'.$id];  
$regel++;

$query = "UPDATE config
             SET Waarde        = '".$waarde."' ,
                 Regel         = '".$regel."',
                 Vereniging_id = ".$vereniging_id.",
                 Laatst  = NOW()     WHERE  Id  = ".$id."  ";
//echo $id."<br>";
//echo $query. "<br>";
//echo $var. "<br>";
mysql_query($query) or die ('Fout in update id generiek'); 
}


}; 

//////////////////////////////////////////////////////////////////////////////
// Aparte update voor inschrijf methode (single of vast)


if (isset ($_POST['inschrijf_methode'])){
	$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
  $result     = mysql_fetch_array( $qry);
  $query = "UPDATE config
             SET Parameters        = '".$_POST['inschrijf_methode']."' , 
                 Laatst  = NOW()     WHERE  Id  = ".$result['Id']."  ";
  mysql_query($query) or die ('Fout in update id inschrijf methode'); 
}; 

 ////////////////////////////////////////////  einde loop wegschrijven records
/// Aparte update ivm euro teken

$qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'kosten_team' ") ;  
$result     = mysql_fetch_array( $qry);
$parameter  = explode('#', $result['Parameters']);
 
 //var_dump($result['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $_euro_ind       = substr($result['Waarde'],-1); 
 
 if ($_euro_ind == 'm' or $_euro_ind == 'z'){
     $kosten = substr($result['Waarde'],-1);
   } 
   else { 
   		$kosten = $result['Waarde'];
 } 

if ($_POST['euro_sign'] =='on') {
	$euro_sign = 'm';
}
else {
	$euro_sign = 'z';

}
$kosten_eenheid = $_POST['kosten_eenheid'];
$parameters     = "#".$euro_sign."#".$kosten_eenheid;

$query    = "UPDATE config
             SET Waarde     = '".$kosten."' ,
                 Parameters = '".$parameters."' ,
             Laatst = NOW()
             WHERE  Id  = ".$result['Id']."  ";
//echo $query;
           
mysql_query($query) or die ('Fout in update euro'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm extra_koptekst / lichtkrant
/// Nieuwe situatie  18 sep 2013
/// Laatste positie geeft tekst effect aan 
/// #n = newline  , #m = marquee , #z = zonder
               
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'extra_koptekst' ") ;  
$result       = mysql_fetch_array( $qry);
$extra_koptekst    = $result['Waarde'];
$parameter = explode('#', $result['Parameters']);
$new_line          =  substr($row['Waarde'],0,1);  // oude setting

// oude situatie
if ($new_line == '%' ){
               	$extra_koptekst = substr($row['Waarde'],1,strlen($extra_koptekst));
} 


$text_effect     = $_POST['text_effect'];
$parameters        = "#".$text_effect;

$query = "UPDATE config
             SET Waarde  = '".$extra_koptekst."' , 
                 Parameters = '".$parameters."', 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";
            
mysql_query($query) or die ('Fout in update koptekst'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm positie afbeelding

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'url_afbeelding' ") ;  
$result       = mysql_fetch_array( $qry);
$url_afbeelding   = $result['Waarde'];
$parameter  = explode('#', $result['Parameters']);

if ( $parameter[1] != '') { 
   $plaats_afb       = $parameter[1];
   $url_afbeelding   = $result['Waarde'];
}

$size = getimagesize ($url_afbeelding);   
		
		/* geeft array terug met vier elementen. 
       Op index 0 staat de breedte van de tekening in pixels, op index 1 staat de hoogte.
       Index 2 geeft een getal weer dat staat voor het type afbeelding;
       1 = GIF
       2 = JPG
       3 = PNG
       4 = SWF
       5 = PSD
       6 = BMP
       7 = TIFF(intel byte order)
       8 = TIFF(motorola byte order)
       9 = JPC
       10 = JP2
       11 = JPX
       12 = JB2
       13 = SWC
       14 = IFF
       Op index 3 staat een tekst string met de hoogte en breedte die direct in een HTML IMG tag gebruikt kan worden. (dus index 3 van de array = height="yyy" width="xxx")
       */

$afb_width   = $size[0];
$afb_height  = $size[1];

 // doen we verder nog niks mee   
//  $afbeelding_grootte = $size[3];

// adhv van het veld afbeelding_grootte bepalen we de vewrhouding tussen breedte en hoogte

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'afbeelding_grootte' ") ;  
$result       = mysql_fetch_array( $qry);
$afbeelding_grootte   = $result['Waarde'];

$calc       = ( $afb_width / $afbeelding_grootte ) ;
$afb_width  =   $afbeelding_grootte   ;    // width = gelijk aan afbeelding_grootte
$afb_height = ( $size[1] / $calc  );
$afb_height = round($afb_height); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// oude situatie
/*
if (substr($url_afbeelding,-2) == '#r' or substr($url_afbeelding,-2) == '#l'){ 
  	$url_afbeelding   = substr($url_afbeelding,0,-2);
}
*/
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'url_afbeelding' ") ;  
$result       = mysql_fetch_array( $qry);
$url_afbeelding   = $result['Waarde'];
$parameter  = explode('#', $result['Parameters']);

if ($_POST['positie'] == 'links') {
	$plaats_afb = '#l';
}
else {
	$plaats_afb = '#r';
}

//$positie = $plaats_afb;

//echo  "afb width via POST ". $_POST['afbeelding_width']."<br>";

if ( isset ($_POST['afbeelding_width']) ) { 
	$afb_width   = $_POST['afbeelding_width'];
  $afb_height  = $_POST['afbeelding_height'];
} 
$param = $plaats_afb."#". $afb_width."#".$afb_height;


/// Laatste 2 posities url_afbeelding geeft de positie van de afbeelding aan
/// #l = links  , #r = rechts
//  Nieuw 12-10-2013  Via parameter

 //$_url_afbeelding = $url_afbeelding.$plaats_afb;
  
$query = "UPDATE config
             SET Waarde      = '".$url_afbeelding."',
                 Parameters  = '".$param."' , 
                 Laatst      = NOW()  WHERE  Id  = ".$result['Id']."  ";
  
// echo $query;
            
mysql_query($query) or die ('Fout in update afbeelding'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm bestemd_voor

$qry             = mysql_query("SELECT * From config  where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi ."'  and Variabele = 'bestemd_voor' ") ;  
 
$result          = mysql_fetch_array( $qry);
$id              = $result['Id'];
$bestemd_voor    = $_POST['Waarde-'.$id]; 
$wel_niet        = $_POST['Wel_niet'];

if ($bestemd_voor != ''){
	
/// Laatste positie bestemd_voor geeft aan of de vereniging wordt uitgesloten of juist geselecteerd
/// #J = alleen voor deze vereniging , #N = uitsluiten
  
     $query = "UPDATE config
             SET Waarde     = '".$bestemd_voor."' , 
                 Parameters = '".$wel_niet."', 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']." ";
       //    echo $query;

    mysql_query($query) or die ('Fout in update bestemd voor'); 
    }
   else {
   	// Nieuwe situatie. #J / #N als parameter
     
          $query = "UPDATE config
             SET Waarde     = '".$bestemd_voor."' , 
                 Parameters = '".$wel_niet."', 
                 Laatst     = NOW()
                WHERE  Id  = ".$result['Id']." ";
         //       echo $query;

    mysql_query($query) or die ('Fout in update bestemd voor'); 
  
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm datum selectie vanuit de drie selectie boxen

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'datum' ") ;  
$result       = mysql_fetch_array( $qry);
$datum        = $_POST['datum_jaar']."-".sprintf("%02d",$_POST['datum_maand'])."-".sprintf("%02d",$_POST['datum_dag']);

//echo $datum;
  $query = "UPDATE config
             SET Waarde  = '".$datum."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']." ";

   mysql_query($query) or die ('Fout in update datum');                 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm begin datum selectie vanuit de drie selectie boxen

$qry            = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                               and Variabele = 'begin_inschrijving' ") ;  
$result        = mysql_fetch_array( $qry);
$begin_datum   = $_POST['begin_datum_jaar']."-".sprintf("%02d",$_POST['begin_datum_maand'])."-".sprintf("%02d",$_POST['begin_datum_dag']);

 $query = "UPDATE config
             SET Waarde  = '".$begin_datum."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";

   mysql_query($query) or die ('Fout in update begin datum');                 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/// Aparte update ivm einde datumtijd selectie vanuit de drie selectie boxen

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'einde_inschrijving' ") ;  
$result       = mysql_fetch_array( $qry);
$einde_datumtijd   = $_POST['eind_datum_jaar']."-".sprintf("%02d",$_POST['eind_datum_maand'])."-".sprintf("%02d",$_POST['eind_datum_dag'])." ".sprintf("%02d",$_POST['eind_datum_uur']).":".sprintf("%02d",$_POST['eind_datum_min']);

 $query = "UPDATE config
             SET Waarde  = '".$einde_datumtijd."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";

mysql_query($query) or die ('Fout in update eind datumtijd');                 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm meldtijd

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysql_fetch_array( $qry);
$meld_tijd    = sprintf("%02d",$_POST['meld_uur']).":".sprintf("%02d",$_POST['meld_min']). " uur";

$parameter = '#'.$_POST['suffix'];
	
 $query = "UPDATE config
             SET Waarde      = '".$meld_tijd."' , 
                 Parameters  = '".$parameter."' ,
                 Laatst      = NOW()
                 WHERE  Id   = ".$result['Id']."  ";
          
mysql_query($query) or die ('Fout in update meldtijd'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm aanvang tijd

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'aanvang_tijd' ") ;  
$result       = mysql_fetch_array( $qry);
$aanvang_tijd  = sprintf("%02d",$_POST['aanvang_uur']).":".sprintf("%02d",$_POST['aanvang_min'])." uur";


 $query = "UPDATE config
             SET Waarde  = '".$aanvang_tijd."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";

mysql_query($query) or die ('Fout in update aanvangtijd');               
   
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
/// Aparte update ivm gekoppeld toernooi (mag geen spatie zijn)
/*
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'gekoppeld_toernooi' ") ;  
$result       = mysql_fetch_array( $qry);

if ($result['Waarde'] ==''){ 
   
    $query = "UPDATE config
             SET Waarde  = '0' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";
 //echo $query;
mysql_query($query) or die ('Fout in update gekoppeld toernooi'); 
}
*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// als bankrekening_invullen is J dan is uitgestelde_bevestiging ook Ja, andersom niet  op 6 feb 2014  uitgezet

/*
$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'bankrekening_invullen_jn' ") ;  
$result       = mysql_fetch_array( $qry);
$waarde_jn    = $result['Waarde'];
$id_bank      = $result['Id'];

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'uitgestelde_bevestiging_jn' ") ;  
$result       = mysql_fetch_array( $qry);
$id_bevest    = $result['Id'];

if ($waarde_jn  ==  'J') {
  $query = "UPDATE config  SET Waarde  = 'J',  Laatst  = NOW()  WHERE  Id  = ".$id_bevest."  ";
  mysql_query($query) or die ('Fout in update bankrekening J');  
}
*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// boulemaatje zichtbaar J/N

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'boulemaatje_gezocht_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update boulemaatje ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'boulemaatje_gezocht_zichtbaar_jn','J', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert boulemaatje');   
  
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// minimum aantal spelers

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'min_splrs' ") ;  
$count        = mysql_num_rows($qry);
$id           = $result['Id'];

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update min splrs');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'min_splrs','0', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert min splrs');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// url_website  tbv toernooi_ontip

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'url_website' ") ;  
$count        = mysql_num_rows($qry);

$qry_v           = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysql_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_website     = $result_v['Url_website'];

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$url_website."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update url_website');   
 } else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'url_website','".$url_website."', now() ) ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert url_website');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Ideal_betaling

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'ideal_betaling_jn' ") ;  
$count        = mysql_num_rows($qry);

/// Parameters bevat de waarde TEST of PROD   Voor de veiligheid kan deze alleen handmatig aangepast worden. Opslag kosten kunnen wel handmatig aangepast worden. 

if ($count > 0) {                
$result       = mysql_fetch_array( $qry);
$id           = $result['Id'];
$waarde       = $_POST['Waarde-'.$id]; 
$ideal_betaling_jn = $result['Waarde'];
$id           = $result['Id'];
$parameter    = explode('#', $result['Parameters']);
 
$testmode            = $parameter[1];
$ideal_opslag_kosten = $parameter[2];

$parameters ='#'.$testmode.'#'.$ideal_opslag_kosten; 

$query        = "UPDATE config  SET Waarde  = '".$ideal_betaling_jn."', Parameters = '".$parameters."' ,  Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
mysql_query($query) or die ('Fout in update ideal_betaling');   

} else {
  $query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) VALUES
                                      (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'ideal_betaling_jn','N', '#TEST#0.00', now() ) ";
 // echo $query;
  mysql_query($query) or die ('Fout in insert Ideal_betaling');   
}         

// als IDEAL is actief, dan ook verplicht om bankrekening in te vullen. 2-1-2014 Niet meer verplicht. Alleen irritant

if ($ideal_betaling_jn  =='J'){

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'and Variabele = 'bankrekening_invullen_jn' ") ;  
$result       = mysql_fetch_array( $qry);
$id_bank      = $result['Id'];
/*
$query        = "UPDATE config  SET Waarde  = 'J',  Laatst  = NOW()  WHERE  Id  = ".$id_bank."  ";
mysql_query($query) or die ('Fout in update bankrekening ideal');   
*/ 

// als IDEAL is actief, dan ook afrekenen per equipe

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'kosten_team' ") ;  
$result       = mysql_fetch_array( $qry);
$id_kosten    = $result['Id'];
$parameter    = explode('#', $result['Parameters']);
 
$euro_ind        = $parameter[1];
$kosten_eenheid  = $parameter[2];

$new_parameters   = '#'.$euro_ind.'#2';   // 2 = kosten per equipe  ( = totaal prijs)

$query        = "UPDATE config  SET Parameters  = '".$new_parameters."' ,  Laatst  = NOW()  WHERE  Id  = ".$id_kosten."  ";
mysql_query($query) or die ('Fout in update ideal');   

}//// end if

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Home.nl wordt vaak gezien als spam     1-2-2013  (SPAMHAUS) toch proberen

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_organisatie' ") ;  
$result       = mysql_fetch_array( $qry);
$email_organisatie  = $result['Waarde'];

if (strpos( strtoupper($email_cc),'@HOTMAIL.NL') > 0 ){
$query = "UPDATE config
             SET Waarde  = '<< Fout: @hotmail.nl  niet toegestaan ivm vermeende spam  (SPAMHAUS)>>' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";
                 mysql_query($query) or die ('Fout in update email_cc');   
}
// email organisatie en mail_cc mogen niet geljk zijn om spam te voorkomen

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_organisatie' ") ;  
$result       = mysql_fetch_array( $qry);
$email_organisatie  = $result['Waarde'];

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_cc' ") ;  
$result       = mysql_fetch_array( $qry);
$email_cc     = $result['Waarde'];
$id_cc        = $result['Id'];

if (strtoupper($email_organisatie) == strtoupper($email_cc) and $email_organisatie  !='') {
$query = "UPDATE config
             SET Waarde  = '<< Fout: email_cc mag niet gelijk zijn aan email_organisatie >>' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$id_cc."  ";
                 mysql_query($query) or die ('Fout in update email_cc');   
                
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// vereniging_selectie zichtbaar J/N

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'vereniging_selectie_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
   mysql_query($query) or die ('Fout in insert vereniging selectie');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Niet doorgaan toernooi

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'toernooi_gaat_door_jn' ") ;  
$count        = mysql_num_rows($qry);

 if ($count > 0) {                
$result       = mysql_fetch_array( $qry);
$id           = $result['Id'];
$waarde       = $_POST['Waarde-'.$id]; 
$reden        = $_POST['Reden-'.$id]; 
$query        = "UPDATE config  SET Waarde  = '".$waarde."', Parameters  = '".$reden."', Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
//echo $query."<br>";
mysql_query($query) or die ('Fout in update doorgaan toernooi ');   

} else {
$reden        = $_POST['Reden-'.$id];
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$toernooi."', 'toernooi_gaat_door_jn','J','".$reden."', now() ) ";
//echo $query."<br>";
 mysql_query($query) or die ('Fout in insert doorgaan toernooi ');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra invulveld

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_invulveld' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $invulveld    = $_POST['Waarde-'.$id]; 
  $verplicht_jn = $_POST['Waarde-verplicht-'.$id];
  $lijst_jn     = $_POST['Op-lijst-1-'.$id];
  
  $parameters   = '#'.$verplicht_jn.'#'.$lijst_jn;
 
  $query        = "UPDATE config  SET Waarde      = '".$invulveld."', 
                                      Parameters  = '".$parameters."', 
                                      Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update extra_invulveld ');   
} else {
  $invulveld    = $_POST['Waarde-'.$id]; 
  $verplicht_jn = $_POST['Waarde-verplicht-'.$id];
  $lijst_jn     = $_POST['Op-lijst-1-'.$id];
  
  $parameters   = '#'.$verplicht_jn.'#'.$lijst_jn;
  
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'extra_invulveld','".$invulveld."','".$parameters."' , now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert extra_invulveld');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra vraag

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $vraag_antwoord = $_POST['Waarde-'.$id]; 
  $lijst_jn       = $_POST['Op-lijst-2-'.$id];
  
  $parameters   = '#'.$lijst_jn;
 
  
  $query        = "UPDATE config  SET Waarde      = '".$vraag_antwoord."', 
                                      Parameters  = '".$parameters."', 
                                      Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update extra_vraag ');   
} else {
  $vraag_antwoord = $_POST['Waarde-'.$id]; 
  $lijst_jn       = $_POST['Op-lijst-2-'.$id];
  $parameters   = '#'.$lijst_jn;
    
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'extra_vraag','".$vraag_antwoord."','".$parameters."' , now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert extra_vraag');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// lijst zichtbaar

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'link_lijst_zichtbaar_jn' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  
  if ($waarde == '') {
  	  $waarde = 'J';
	}
  
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//  echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update lijst_zichtbaar ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'link_lijst_zichtbaar_jn','J', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert lijst_zichtbaar');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// SMS bevestiging 

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'sms_bevestigen_zichtbaar_jn' ") ;  

$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  
  
  if ($waarde == '') {
  	  $waarde = 'N';
	}
  
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update sms bevestiging_zichtbaar ');  
   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'sms_bevestigen_zichtbaar_jn','N', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert sms bevestiging_zichtbaar');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// SMS laaste inschrijvingen

$qry          = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'sms_laatste_inschrijvingen' ") ;  
$count        = mysql_num_rows($qry);

if ($count > 0) {                
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id];          ////  grenswaarde
  $parameters   = $_POST['Parameters-'.$id];      ////  telefoon nummer     
    
  if ($waarde == '') {
  	  $waarde = '0';
	}

  if (!is_numeric($waarde) ) {
  	  $waarde = '0';
	}
  
  $query        = "UPDATE config  SET Waarde  = '".$waarde."', Parameters = '".$parameters."', Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update sms_laatste_inschrijvingen ');  
   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'sms_laatste_inschrijvingen','0', now() ) ";
  //echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert sms_laatste_inschrijvingen');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrondkleur input velden

$variabele = 'achtergrond_kleur_invulvelden';
 $qry          = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count        = mysql_num_rows($qry);
 $result       = mysql_fetch_array( $qry);

if ($count > 0) {                
  
  $id           = $result['Id'];
  $waarde       = $_POST['achtergrond_kleur_invulvelden'];         
 
   if ($waarde =='') {
  	$waarde  = $result['Waarde'];
  }	
   
  $query        = "UPDATE config  SET Waarde  = '".$waarde."', Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update achtergrond_kleur_invulvelden ');  
   
} else {
	$waarde = '#F2F5A9';
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur_invulvelden','#F2F5A9', now() ) ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert achtergrond_kleur_invulvelden');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrondkleur buttons

$variabele = 'achtergrond_kleur_buttons';
 $qry          = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count        = mysql_num_rows($qry);

if ($count > 0) {             
	
  $result       = mysql_fetch_array( $qry);
  $id           = $result['Id'];
    
  $kleur_verzenden      = explode( ";", $_POST['kleur_verzenden'] ) ;         
  $kleur_herstellen     = explode( ";", $_POST['kleur_herstellen'] ) ;         

  $achtergrondkleur_verzenden    = $kleur_verzenden[0];       
  $tekstkleur_verzenden          = $kleur_verzenden[1];  
  $achtergrondkleur_herstellen   = $kleur_herstellen[0];        
  $tekstkleur_herstellen         = $kleur_herstellen[1];       
 
  $waarde =  $achtergrondkleur_verzenden.";".$tekstkleur_verzenden.";".$achtergrondkleur_herstellen.";".$tekstkleur_herstellen;
  $query        = "UPDATE config  SET Waarde  = '".$waarde."', Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update achtergrond_kleur_buttons');
  
} else {
	$waarde = 'Red;White;Blue;White';
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur_buttons','".$waarde."', now() ) ";
//  echo $query. "<br>";
  mysql_query($query) or die ('Fout in insert achtergrond_kleur_buttons');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Tekst kleur (apart sinds 5-2-2015)

$variabele = 'tekst_kleur';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry); 
 
if ($count > 0) {             
	
  $id           = $result['Id'];
	$tekst_kleur  = $_POST['Tekst_kleur'];
	 
  if ($tekst_kleur  ==  ''){
     	$tekst_kleur    =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$tekst_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
// echo $query. "<br>";
  
 mysql_query($query) or die ('Fout in update tekst_kleur');
  
} else {
	$tekst_kleur = '#000000'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'tekst_kleur','".$tekst_kleur."' , now() ) ";
//  echo $query. "<br>";
  mysql_query($query) or die ('Fout in insert tekst_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Link kleur (apart sinds 5-2-2015)

$variabele = 'link_kleur';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);
if ($count > 0) {             
	
  $id           = $result['Id'];
	$link_kleur  = $_POST['Link_kleur'];
	  
  if ($link_kleur  ==  ''){
     	$link_kleur    =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$link_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//  echo $query. "<br>";
  
 mysql_query($query) or die ('Fout in update link_kleur');
  
} else {
	$link_kleur = 'blue'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'link_kleur','".$link_kleur."' , now() ) ";
  //echo $query. "<br>";
  mysql_query($query) or die ('Fout in insert link_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Koptekst kleur (apart sinds 5-2-2015)

$variabele = 'koptekst_kleur';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {             
	
  $id              = $result['Id'];
	$koptekst_kleur  = $_POST['Koptekst_kleur'];
	
  
  if ($koptekst_kleur  ==  ''){
     	$koptekst_kleur  =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$koptekst_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //echo $query. "<br>";
  
 mysql_query($query) or die ('Fout in update koptekst_kleur');
  
} else {
	$koptekst_kleur = 'red'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'koptekst_kleur','".$koptekst_kleur."' , now() ) ";
 //echo $query. "<br>";
  mysql_query($query) or die ('Fout in insert koptekst_kleur');   
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrond kleur (apart sinds 5-2-2015)

$variabele = 'achtergrond_kleur';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {             
	
  $id              = $result['Id'];
	$achtergrond_kleur  = $_POST['achtergrond_kleur'];

  if ($achtergrond_kleur  ==  ''){
     	$achtergrond_kleur =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$achtergrond_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //echo $query. "<br>";
  
 mysql_query($query) or die ('Fout in update achtergrond_kleur');
  
} else {
	$achtergrond_kleur = '#FFFFFF'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur','".$achtergrond_kleur."' , now() ) ";
 //echo $query. "<br>";
  mysql_query($query) or die ('Fout in insert achtergrond_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi_selectie_zichtbaar_jn  (sinds 5-2-2015)

$variabele = 'toernooi_selectie_zichtbaar_jn';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update toernooi_selectie_zichtbaar_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'toernooi_selectie_zichtbaar_jn','J', now() ) ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert toernooi_selectie_zichtbaar_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// website link _zichtbaar_jn  (sinds 6-2-2015)

$variabele = 'website_link_zichtbaar_jn';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update website_link_zichtbaar_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'website_link_zichtbaar_jn','J', now() ) ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert website_link_zichtbaar_jn');   
  
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// url_logo  (sinds 12-2-2015)   alternatief logo  (bijv ivm andere achtergrondkleur)

$variabele = 'url_logo';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['url_logo']; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//   echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update url_logo');   
} else {
	$waarde       = $_POST['url_logo']; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'url_logo','".$waarde."', now() ) ";
// echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert url_logo');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// zelf_aanpassen_jn  (sinds 5-10-018c opnieuw erin)

$variabele = 'zelf_aanpassen_jn';
 $qry      = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysql_num_rows($qry);
 $result   = mysql_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update zelf_aanpassen_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'zelf_aanpassen_jn','N', now() ) ";
 echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in insert zelf_aanpassen_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/// Naam van form wordt wel meegegeven maar heeft geen inhoud
 if (isset($_POST['myForm1'])){
    $tab = 1;
 }
 
 if (isset($_POST['myForm2'])){
    $tab = 2;
 }
$replace = "toernooi=".$toernooi."&tab=".$tab."";
//echo "klaar";
$wel_niet     = $_POST['Wel_niet'];

?> 
<!--script language="javascript">
		window.location.replace('beheer_ontip.php?<?php echo $replace; ?>');
</script>
