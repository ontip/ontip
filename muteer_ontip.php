<?php
# muteer_ontip
# muteer tabel config
#
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 29dec2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              Ontbrekende var  Voucher_code en Bankrekening
# Feature:          None.
# Reference: 

# 25jan2019         1.0.2            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None
# Fix:              None
# Feature:          Migratie naar PHP 7
# Reference:

# 3mei2019          1.0.3            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  Bij voorlopige bevesting = J en $uitgestelde_bevestiging_vanaf boven 0, dan staat er twee keer de melding dat het een voorlopige bevestiging is
# Fix:              $uitgestelde_bevestiging_vanaf alleen in combinatie met uitgestelde_bevesting = N  
# Feature:          None
# Reference:

# 15juni2019        1.0.4            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None
# Feature:          Recensie zichtbaar
# Reference: 

# 21juni2019        1.0.5            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None
# Feature:          Bij aanzetten email notificaties wordt aantal reserves op 0 gezet
# Reference: 

# 26juni2019        1.0.6            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              None
# Feature:          Notificatie als SMS
# Reference: 

# 27juni2019        1.0.7            E. Hendrikx
# Symptom:          None.
# Problem:       	None.
# Fix:              None
# Feature:          Bij aanzetten email notificaties wordt uitgestelde_bevestiging_vanaf op 0 gezet
# Reference: 

# 18okt2019          1.0.6            E. Hendrikx
# Symptom:   		None.
# Problem:       	None.
# Fix:              None
# Feature:          Bij uitbreiden inschrijvingen status voor reserves aanpassen naar ingeschreven niet bevestigd
# Reference: 

//header("Location: ".$_SERVER['HTTP_REFERER']);

ini_set('display_errors', 'OFF');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysqli.php');
//include('action.php');

$toernooi      = $_POST['toernooi'];   
$qry           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result        = mysqli_fetch_array( $qry);
$vereniging_id = $result['Id'];

$toernooi = $_POST['toernooi'];

// Als het aantal spelers wordt verhoogd eerst huidig aantal vastleggen
$variabele = 'max_splrs';
 $qry1      = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $max_splrs_vooraf   = $result['Waarde'];


/// Generieke update

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' order by Variabele") ;  

//echo "SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' order by Variabele<br>";


$regel = 0;
while($row = mysqli_fetch_array( $qry )) {

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
mysqli_query($con,$query) or die ('Fout in update id generiek'); 
}


}; 

//////////////////////////////////////////////////////////////////////////////
// Aparte update voor inschrijf methode (single of vast)


if (isset ($_POST['inschrijf_methode'])){
	$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
  $result     = mysqli_fetch_array( $qry);
  $query = "UPDATE config
             SET Parameters        = '".$_POST['inschrijf_methode']."' , 
                 Laatst  = NOW()     WHERE  Id  = ".$result['Id']."  ";
  mysqli_query($con,$query) or die ('Fout in update id inschrijf methode'); 
}; 

 ////////////////////////////////////////////  einde loop wegschrijven records
/// Aparte update ivm euro teken

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'kosten_team' ") ;  
$result     = mysqli_fetch_array( $qry);
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
           
mysqli_query($con,$query) or die ('Fout in update euro'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm extra_koptekst / lichtkrant
/// Nieuwe situatie  18 sep 2013
/// Laatste positie geeft tekst effect aan 
/// #n = newline  , #m = marquee , #z = zonder
               
$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                    and Variabele = 'extra_koptekst' ") ;  
$result             = mysqli_fetch_array( $qry);
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
            
mysqli_query($con,$query) or die ('Fout in update koptekst'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm positie afbeelding

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'url_afbeelding' ") ;  
$result       = mysqli_fetch_array( $qry);
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

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'afbeelding_grootte' ") ;  
$result       = mysqli_fetch_array( $qry);
$afbeelding_grootte   = $result['Waarde'];

$calc       = ( $afb_width / $afbeelding_grootte ) ;
$afb_width  =   $afbeelding_grootte   ;    // width = gelijk aan afbeelding_grootte

if ($calc > 0){
$afb_height = ( $size[1] / $calc  );
}
else {
	$afb_height = $size[1] ;
}
$afb_height = round($afb_height); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// oude situatie
/*
if (substr($url_afbeelding,-2) == '#r' or substr($url_afbeelding,-2) == '#l'){ 
  	$url_afbeelding   = substr($url_afbeelding,0,-2);
}
*/
$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'url_afbeelding' ") ;  
$result       = mysqli_fetch_array( $qry);
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
            
mysqli_query($con,$query) or die ('Fout in update afbeelding'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm bestemd_voor

$qry             = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging."' and Toernooi = '".$toernooi ."'  and Variabele = 'bestemd_voor' ") ;  
$result          = mysqli_fetch_array( $qry);
$id              = $result['Id'];
$bestemd_voor    = $_POST['Waarde-'.$id]; 
$wel_niet        = $_POST['Wel_niet'];
$count           = mysqli_num_rows($qry);

if ($count > 0) {                

      if ($bestemd_voor != ''){
      	
      /// Parameter
      /// J = alleen voor deze vereniging , N = uitsluiten
        
           $query = "UPDATE config
                   SET Waarde     = '".$bestemd_voor."' , 
                       Parameters = '".$wel_niet."', 
                       Laatst     = NOW()
                       WHERE  Id  = ".$result['Id']." ";
          //       echo $query;
      
          mysqli_query($con,$query) or die ('Fout in update bestemd voor'); 
          }
         else {
              
                $query = "UPDATE config
                   SET Waarde     = '' , 
                       Parameters = 'N', 
                       Laatst     = NOW()
                       WHERE  Id  = ".$result['Id']." ";
            //         echo $query;
      
          mysqli_query($con,$query) or die ('Fout in update bestemd voor'); 
        
      }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm datum selectie vanuit de drie selectie boxen

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum' ") ;  
$result       = mysqli_fetch_array( $qry);
$datum        = $_POST['datum_jaar']."-".sprintf("%02d",$_POST['datum_maand'])."-".sprintf("%02d",$_POST['datum_dag']);
$count        = mysqli_num_rows($qry);

if ($count > 0) {  
//echo $datum;
  $query = "UPDATE config
             SET Waarde  = '".$datum."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']." ";

   mysqli_query($con,$query) or die ('Fout in update datum');                 
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm begin datum selectie vanuit de 5 selectie boxen  ( 4 apr 2016 Ook met tijd)

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'begin_inschrijving' ") ;  
$result       = mysqli_fetch_array( $qry);
$count        = mysqli_num_rows($qry);

if ($count > 0) {  

$begin_datumtijd = $_POST['begin_datum_jaar']."-".sprintf("%02d",$_POST['begin_datum_maand'])."-".sprintf("%02d",$_POST['begin_datum_dag'])." ".sprintf("%02d",$_POST['begin_datum_uur']).":".sprintf("%02d",$_POST['begin_datum_min']);

 $query = "UPDATE config
             SET Waarde  = '".$begin_datumtijd."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";
  //echo $query;
    mysqli_query($con,$query) or die ('Fout in update begin datumtijd');                 
//exit;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   
/// Aparte update ivm einde datumtijd  einde _inschrijving selectie vanuit de 5 selectie boxen

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'    and Variabele = 'einde_inschrijving' ") ;  
$result       = mysqli_fetch_array( $qry);
$einde_datumtijd   = $_POST['eind_inschrijving_jaar']."-".sprintf("%02d",$_POST['eind_inschrijving_maand'])."-".sprintf("%02d",$_POST['eind_inschrijving_dag'])." ".sprintf("%02d",$_POST['eind_inschrijving_uur']).":".sprintf("%02d",$_POST['eind_inschrijving_min']);
$count        = mysqli_num_rows($qry);

if ($count > 0) {  
 $query = "UPDATE config
             SET Waarde  = '".$einde_datumtijd."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";

mysqli_query($con,$query) or die ('Fout in update eind datumtijd');                 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm meldtijd

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysqli_fetch_array( $qry);
$meld_tijd    = sprintf("%02d",$_POST['meld_uur']).":".sprintf("%02d",$_POST['meld_min']). " uur";

$parameter = '#'.$_POST['suffix'];
	
$query = "UPDATE config
             SET Waarde      = '".$meld_tijd."' , 
                 Parameters  = '".$parameter."' ,
                 Laatst      = NOW()
                 WHERE  Id   = ".$result['Id']."  ";
          
mysqli_query($con,$query) or die ('Fout in update meldtijd'); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Aparte update ivm aanvang tijd

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'aanvang_tijd' ") ;  
$result       = mysqli_fetch_array( $qry);
$aanvang_tijd  = sprintf("%02d",$_POST['aanvang_uur']).":".sprintf("%02d",$_POST['aanvang_min'])." uur";


 $query = "UPDATE config
             SET Waarde  = '".$aanvang_tijd."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";

mysqli_query($con,$query) or die ('Fout in update aanvangtijd');               
   
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// bankrekening_invullen J/N   - opnieuw toegevoegd 6 sep 2015

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'bankrekening_invullen_jn' ") ;  
$result       = mysqli_fetch_array( $qry);
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $id           = $result['Id'];
  //echo "Id : ". $id;
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update bankrekening_invullen ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'bankrekening_invullen_jn','N', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert bankrekening_invullen');   
  
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// boulemaatje zichtbaar J/N

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'boulemaatje_gezocht_zichtbaar_jn' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update boulemaatje ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'boulemaatje_gezocht_zichtbaar_jn','J', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert boulemaatje');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// minimum aantal spelers

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'min_splrs' ") ;  
$count        = mysqli_num_rows($qry);
$id           = $result['Id'];

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update min splrs');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'min_splrs','0', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert min splrs');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// url_website  tbv toernooi_ontip

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'url_website' ") ;  
$count        = mysqli_num_rows($qry);

$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_website     = $result_v['Url_website'];

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$url_website."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update url_website');   
 } else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'url_website','".$url_website."', now() ) ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert url_website');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Ideal_betaling

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'ideal_betaling_jn' ") ;  
$count        = mysqli_num_rows($qry);


/// Parameters bevat de waarde TEST of PROD . Opslag kosten kunnen wel handmatig aangepast worden. 
/// In vereniging tabel staat voor deze verenigng een default waarde, die gebruikt wordt bij een nieuw toernooi.

if ($count > 0) {                
$result       = mysqli_fetch_array( $qry);
$id           = $result['Id'];
$waarde       = $_POST['Waarde-'.$id]; 
$ideal_betaling_jn = $result['Waarde'];
$parameter    = explode('#', $result['Parameters']);
 
$testmode            = $parameter[1];
$ideal_opslag_kosten = $parameter[2];

//   Test mode aan of uit zetten voor dit toernooi   22 dec 2016

if (isset ($_POST['ideal_test-'.$id])){
 
   if ($_POST['ideal_test-'.$id]  =='J'){
      $testmode  = 'TEST';
     } else {
      $testmode  = 'PROD';
   }
}

if (isset ($_POST['ideal_opslag_kosten'])){
$ideal_opslag_kosten = $_POST['ideal_opslag_kosten'];
}
$parameters ='#'.$testmode.'#'.$ideal_opslag_kosten; 

$query        = "UPDATE config  SET Waarde  = '".$ideal_betaling_jn."', Parameters = '".$parameters."' ,  Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
//echo $query. "<br>";
mysqli_query($con,$query) or die ('Fout in update ideal_betaling');   

} else {
  $query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) VALUES
                                      (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'ideal_betaling_jn','N', '#TEST#0.00', now() ) ";
 // echo $query;
  mysqli_query($con,$query) or die ('Fout in insert Ideal_betaling');   
}         

if ($ideal_betaling_jn  =='J'){

// als IDEAL is actief, dan ook afrekenen per equipe

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                and Variabele = 'kosten_team' ") ;  
$result       = mysqli_fetch_array( $qry);
$id_kosten    = $result['Id'];
$parameter    = explode('#', $result['Parameters']);
 
$euro_ind        = $parameter[1];
$kosten_eenheid  = $parameter[2];

$new_parameters   = '#'.$euro_ind.'#2';   // 2 = kosten per equipe  ( = totaal prijs)

$query        = "UPDATE config  SET Parameters  = '".$new_parameters."' ,  Laatst  = NOW()  WHERE  Id  = ".$id_kosten."  ";
mysqli_query($con,$query) or die ('Fout in update ideal');   

}//// end if

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Home.nl wordt vaak gezien als spam     1-2-2013  (SPAMHAUS) toch proberen

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_organisatie' ") ;  
$result       = mysqli_fetch_array( $qry);
$email_organisatie  = $result['Waarde'];

if (strpos( strtoupper($email_organisatie),'@HOTMAIL.NL') > 0 ){
$query = "UPDATE config
             SET Waarde  = '<< Fout: @hotmail.nl  niet toegestaan ivm vermeende spam  (SPAMHAUS)>>' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$result['Id']."  ";
                 mysqli_query($con,$query) or die ('Fout in update email_cc');   
}
// email organisatie en mail_cc mogen niet geljk zijn om spam te voorkomen

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_organisatie' ") ;  
$result       = mysqli_fetch_array( $qry);
$email_organisatie  = $result['Waarde'];
$id_email           = $result['Id'];

//check op meerdere email adressen   6-4-2017
if (substr_count($email_organisatie, '@', 0) > 1) {

$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v              = mysqli_fetch_array( $qry_v);
$email_organisatie     = $result_v['Email_organisatie'];

$query = "UPDATE config
             SET Waarde  = '".$email_organisatie."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$id_email."  ";
                 mysqli_query($con,$query) or die ('Fout in update email_cc');   
}


$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'email_cc' ") ;  
$result       = mysqli_fetch_array( $qry);
$email_cc     = $result['Waarde'];
$id_cc        = $result['Id'];

if (strtoupper($email_organisatie) == strtoupper($email_cc) and $email_organisatie  !='') {
$query = "UPDATE config
             SET Waarde  = '' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$id_cc."  ";
                 mysqli_query($con,$query) or die ('Fout in update email_organisatie');   
                
}

// vervang punt comma door comma
$email_cc= str_replace(";", ",", $email_cc);


//check op meerdere email adressen   6-4-2017
if (substr_count($email_cc, '@', 0) > 1) {
 $part     = explode( ";",$email_cc);
 $email_cc = $part[0];
 
 $query = "UPDATE config
             SET Waarde  = '".$email_cc."' , 
                 Laatst     = NOW()
                 WHERE  Id  = ".$id_cc."  ";
                 mysqli_query($con,$query) or die ('Fout in update email_cc');   
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// vereniging_selectie zichtbaar J/N

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'vereniging_selectie_zichtbaar_jn' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
   mysqli_query($con,$query) or die ('Fout in insert vereniging selectie');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Niet doorgaan toernooi

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'toernooi_gaat_door_jn' ") ;  
$count        = mysqli_num_rows($qry);

 if ($count > 0) {                
$result       = mysqli_fetch_array( $qry);
$id           = $result['Id'];
$waarde       = $_POST['Waarde-'.$id]; 
$reden        = $_POST['Reden-'.$id]; 
$query        = "UPDATE config  SET Waarde  = '".$waarde."', Parameters  = '".$reden."', Laatst  = NOW()  WHERE  Id  = '".$id."'  ";
//echo $query."<br>";
mysqli_query($con,$query) or die ('Fout in update doorgaan toernooi ');   

} else {
$reden        = $_POST['Reden-'.$id];
$query        = "INSERT INTO  config (Id, Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) VALUES (0, '".$vereniging."',".$vereniging_id.",'".$toernooi."', 'toernooi_gaat_door_jn','J','".$reden."', now() ) ";
//echo $query."<br>";
 mysqli_query($con,$query) or die ('Fout in insert doorgaan toernooi ');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra invulveld

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_invulveld' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $invulveld    = $_POST['Waarde-'.$id]; 
  $verplicht_jn = $_POST['Waarde-verplicht-'.$id];
  $lijst_jn     = $_POST['Op-lijst-1-'.$id];
  
  $parameters   = '#'.$verplicht_jn.'#'.$lijst_jn;
 
  $query        = "UPDATE config  SET Waarde      = '".$invulveld."', 
                                      Parameters  = '".$parameters."', 
                                      Laatst  = NOW()  WHERE  Id  = ".$id."  ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update extra_invulveld ');   
} else {
  $invulveld    = $_POST['Waarde-'.$id]; 
  $verplicht_jn = $_POST['Waarde-verplicht-'.$id];
  $lijst_jn     = $_POST['Op-lijst-1-'.$id];
  
  $parameters   = '#'.$verplicht_jn.'#'.$lijst_jn;
  
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'extra_invulveld','".$invulveld."','".$parameters."' , now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert extra_invulveld');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// extra vraag

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'extra_vraag' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $vraag_antwoord = $_POST['Waarde-'.$id]; 
  $lijst_jn       = $_POST['Op-lijst-2-'.$id];
  
  $parameters   = '#'.$lijst_jn;
 
  
  $query        = "UPDATE config  SET Waarde      = '".$vraag_antwoord."', 
                                      Parameters  = '".$parameters."', 
                                      Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update extra_vraag ');   
} else {
  $vraag_antwoord = $_POST['Waarde-'.$id]; 
  $lijst_jn       = $_POST['Op-lijst-2-'.$id];
  $parameters   = '#'.$lijst_jn;
    
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters , Laatst) 
                                VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'extra_vraag','".$vraag_antwoord."','".$parameters."' , now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert extra_vraag');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// lijst zichtbaar

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'link_lijst_zichtbaar_jn' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  
  if ($waarde == '') {
  	  $waarde = 'J';
	}
  
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//  echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update lijst_zichtbaar ');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'link_lijst_zichtbaar_jn','J', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert lijst_zichtbaar');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// SMS bevestiging 

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'sms_bevestigen_zichtbaar_jn' ") ;  

$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  
  
  if ($waarde == '') {
  	  $waarde = 'N';
	}
  
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update sms bevestiging_zichtbaar ');  
   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'sms_bevestigen_zichtbaar_jn','N', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert sms bevestiging_zichtbaar');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// SMS laaste inschrijvingen

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'sms_laatste_inschrijvingen' ") ;  
$count        = mysqli_num_rows($qry);

if ($count > 0) {                
  $result       = mysqli_fetch_array( $qry);
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
  
  mysqli_query($con,$query) or die ('Fout in update sms_laatste_inschrijvingen ');  
   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'sms_laatste_inschrijvingen','0', now() ) ";
  //echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert sms_laatste_inschrijvingen');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrondkleur input velden

$variabele = 'achtergrond_kleur_invulvelden';
 $qry          = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count        = mysqli_num_rows($qry);
 $result       = mysqli_fetch_array( $qry);

if ($count > 0) {                
  
  $id           = $result['Id'];
  $waarde       = $_POST['achtergrond_kleur_invulvelden'];         
 
   if ($waarde =='') {
  	$waarde  = $result['Waarde'];
  }	
   
  $query        = "UPDATE config  SET Waarde  = '".$waarde."', Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update achtergrond_kleur_invulvelden ');  
   
} else {
	$waarde = '#F2F5A9';
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur_invulvelden','#F2F5A9', now() ) ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert achtergrond_kleur_invulvelden');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrondkleur buttons

$variabele = 'achtergrond_kleur_buttons';
 $qry          = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count        = mysqli_num_rows($qry);

if ($count > 0) {             
	
  $result       = mysqli_fetch_array( $qry);
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
  
  mysqli_query($con,$query) or die ('Fout in update achtergrond_kleur_buttons');
  
} else {
	$waarde = 'Red;White;Blue;White';
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur_buttons','".$waarde."', now() ) ";
//  echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert achtergrond_kleur_buttons');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Tekst kleur (apart sinds 5-2-2015)

$variabele = 'tekst_kleur';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry); 
 
if ($count > 0) {             
	
  $id           = $result['Id'];
	$tekst_kleur  = $_POST['Tekst_kleur'];
	 
  if ($tekst_kleur  ==  ''){
     	$tekst_kleur    =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$tekst_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//echo $query. "<br>";
  
 mysqli_query($con,$query) or die ('Fout in update tekst_kleur');
  
} else {
	$tekst_kleur = '#000000'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'tekst_kleur','".$tekst_kleur."' , now() ) ";
  //echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert tekst_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Link kleur (apart sinds 5-2-2015)
/// Link onderstreept toegevoegd als parameter sinds 22-6-2015

$variabele = 'link_kleur';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 
if ($count > 0) {             
	$result            = mysqli_fetch_array( $qry);
  $id                = $result['Id'];
	$link_kleur        = $_POST['Link_kleur'];
	
	if (isset($_POST['Link_onderstreept'])){
  	$link_onderstreept = $_POST['Link_onderstreept'];
  }
	else { 
		$link_onderstreept='';
	}
		  
  if ($link_kleur  ==  ''){
     	$link_kleur        =  $result['Waarde'];
     	$link_onderstreept =  $result['Parameters'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$link_kleur."', Parameters  = '".$link_onderstreept."', Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //echo $query. "<br>";
  
 mysqli_query($con,$query) or die ('Fout in update link_kleur');
  
} else {
	$link_kleur = 'blue'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'link_kleur','".$link_kleur."' , 'N', now() ) ";
 // echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert link_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Koptekst kleur (apart sinds 5-2-2015)

$variabele = 'koptekst_kleur';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {             
	
  $id              = $result['Id'];
	$koptekst_kleur  = $_POST['Koptekst_kleur'];
	
  
  if ($koptekst_kleur  ==  ''){
     	$koptekst_kleur  =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$koptekst_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //echo $query. "<br>";
  
 mysqli_query($con,$query) or die ('Fout in update koptekst_kleur');
  
} else {
	$koptekst_kleur = 'red'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'koptekst_kleur','".$koptekst_kleur."' , now() ) ";
 //echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert koptekst_kleur');   
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Achtergrond kleur (apart sinds 5-2-2015)

$variabele = 'achtergrond_kleur';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {             
	
  $id              = $result['Id'];
	$achtergrond_kleur  = $_POST['achtergrond_kleur'];

  if ($achtergrond_kleur  ==  ''){
     	$achtergrond_kleur =  $result['Waarde'];
  }
   
  $query        = "UPDATE config  SET Waarde  = '".$achtergrond_kleur."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //echo $query. "<br>";
  
 mysqli_query($con,$query) or die ('Fout in update achtergrond_kleur');
  
} else {
	$achtergrond_kleur = '#FFFFFF'; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde,  Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'achtergrond_kleur','".$achtergrond_kleur."' , now() ) ";
 //echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert achtergrond_kleur');   
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi_selectie_zichtbaar_jn  (sinds 5-2-2015)

$variabele = 'toernooi_selectie_zichtbaar_jn';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update toernooi_selectie_zichtbaar_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'toernooi_selectie_zichtbaar_jn','J', now() ) ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert toernooi_selectie_zichtbaar_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// website link _zichtbaar_jn  (sinds 6-2-2015)

$variabele = 'website_link_zichtbaar_jn';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['Waarde-'.$id]; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update website_link_zichtbaar_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'website_link_zichtbaar_jn','J', now() ) ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert website_link_zichtbaar_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// toernooi zichtbaar op kalender _jn  (sinds 6-2-2015)

$variabele = 'toernooi_zichtbaar_op_kalender_jn';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['toernooi_zichtbaar']; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update toernooi_zichtbaar_op_kalender_jn');   
} else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Laatst) VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'toernooi_zichtbaar_op_kalender_jn','".$_POST['toernooi_zichtbaar']."', now() ) ";
 // echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in insert toernooi_zichtbaar_op_kalender_jn');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// url_logo  (sinds 12-2-2015)   alternatief logo  (bijv ivm andere achtergrondkleur)    2-3-2015:grootte logo 

$variabele = 'url_logo';
 $qry      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $count    = mysqli_num_rows($qry);
 $result   = mysqli_fetch_array( $qry);

if ($count > 0) {                
  $id           = $result['Id'];
  $waarde       = $_POST['url_logo']; 
  $grootte_logo = $_POST['grootte_logo']; 
  $query        = "UPDATE config  SET Waarde  = '".$waarde."', Parameters = '".$grootte_logo."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //  echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update url_logo');   
} else {
	$waarde       = $_POST['url_logo']; 
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                           VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'url_logo','".$waarde."', '".$grootte_logo."',  now() ) ";
 // echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert url_logo');   
  
}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Uitgestelde bevestiging limiet  (sinds 14-4-2017)   

if (isset($_POST['Limiet_bevestiging'])){

$variabele = 'uitgestelde_bevestiging_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select limiet');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $keuze     = $result['Waarde'];
 $limiet    = $result['Parameters'];
  	 
 if ($limiet ==''){
  	   $limiet =  0;   // oneindig
  }
 
 $query     = "UPDATE config  SET Waarde  = '".$keuze."', Parameters = '".$_POST['Limiet_bevestiging']."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 
//  echo $query. "<br>";
 mysqli_query($con,$query) or die ('Fout in update Limiet');   

}//// end if

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// ontip map locatie  (sinds 15 mei 2017)

if (isset($_POST['Ontip_map_locatie'])){

$variabele = 'Ontip_map_locatie';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select limiet');  
 $count     = mysqli_num_rows($qry1);
  
 if ($count > 0) {   
  $result     = mysqli_fetch_array( $qry1);             
  $id         = $result['Id'];
  $locatie    = $_POST['Ontip_map_locatie']; 
  
  if ($locatie ==''){
      $qry      = mysqli_query($con,"SELECT Ontip_map_locatie,Plaats from vereniging where Vereniging = '".$vereniging."' ")     or die(' Fout in select vereniging locatie'); 
      $result   = mysqli_fetch_array( $qry );
      $locatie  = $result['Ontip_map_locatie'];
  }
  
   if ($locatie ==''){
      $locatie   = $result['Plaats'];
   }
  
  $query      = "UPDATE config  SET Waarde  = '".$locatie."', Parameters = '',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//  echo $query. "<br>";
  
  mysqli_query($con,$query) or die ('Fout in update ontip map locatie');   
//  exit;
} else {
  $locatie    = $_POST['Ontip_map_locatie'];
  if ($locatie ==''){
            $qry      = mysqli_query($con,"SELECT Plaats from vereniging where Vereniging = '".$vereniging."' ")     or die(' Fout in select vereniging locatie'); 
            $result   = mysqli_fetch_array( $qry );
            $locatie   = $result['Plaats'];
  }
   
  $query      = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                           VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'Ontip_map_locatie','".$locatie."', '',  now() ) ";
//  echo $query. "<br>";
  mysqli_query($con,$query) or die ('Fout in insert ontip map locatie');   
//  exit;
 } // count 0
 
}//// end if


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// wedstrijd schema   (sinds 30 juli 2017)

if (isset($_POST['wedstrijd_schema'])){
$variabele = 'wedstrijd_schema';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select wedstrijd schema');  
 $count     = mysqli_num_rows($qry1);

$result     = mysqli_fetch_array( $qry1);             
  $id         = $result['Id'];
  $wedstrijd_schema    = $_POST['wedstrijd_schema']; 
 
if ($count == 1)  {  
 
  
$query      = "UPDATE config  SET Waarde  = '".$wedstrijd_schema."', Parameters = 'J',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
//echo $query. "<br>";
mysqli_query($con,$query) or die ('Fout in update wedstrijd schema');   
} else { 
$query      = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                           VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'wedstrijd_schema','', 'N',  now() ) ";
//echo $query. "<br>";
mysqli_query($con,$query) or die ('Fout in insert wedstrijd schema');   

} // count 1

}// isset wedstrijd schema

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  voucher_code_invoeren_jn (sinds 5 dec 2017)  aangepast 7 en 12 dec 2017

if (isset($_POST['voucher_code_invoeren_jn'])){
$variabele = 'voucher_code_invoeren_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select voucher_code_invoeren_jn');  
 $count     = mysqli_num_rows($qry1);

$result     = mysqli_fetch_array( $qry1);             
  $id        = $result['Id'];
  $keuze     = $_POST['voucher_code_invoeren_jn']; 
  
  if ($keuze =='J'){
    $richting            = $_POST['voucher_code_richting'];
    $per_inschrijving_jn = $_POST['per_inschrijving_jn'];
  } else {
	  $richting            = 'In';
	  $per_inschrijving_jn = 'J';   
	}
	
	if ($per_inschrijving_jn == ''){   
	    $per_inschrijving_jn = 'J';   
	  }
	
if ($count == 1)  {  
    $parameters  = $richting.'#'.$per_inschrijving_jn;
 
    $query       = "UPDATE config  SET Waarde  = '".$keuze."', Parameters = '".$parameters ."',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //   echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in update voucher_code_invoeren_jn');   
  } else { 
    $query       = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'voucher_code_invoeren_jn','N', '".$parameters ."',  now() ) ";
  //  echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in insert voucher_code_invoeren_jn');   

} // count 1

}// isset voucher_code_invoeren_jn

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  meerdaags_toernooi_jn   (sinds 14 dec 2017)  

if (isset($_POST['meerdaags_toernooi_jn'])){
$variabele = 'meerdaags_toernooi_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select meerdaags_toernooi_jn');  
 $count     = mysqli_num_rows($qry1);

$result     = mysqli_fetch_array( $qry1);             
  $id        = $result['Id'];
  $keuze     = $_POST['meerdaags_toernooi_jn']; 
  
  if ($keuze ==''){
    $keuze = 'N';
	  }
	
if ($count == 1)  {  
     
    $query       = "UPDATE config  SET Waarde  = '".$keuze."', Parameters = '',  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 //   echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in update meerdaags_toernooi_jn');   
  } else { 
    $query       = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'meerdaags_toernooi_jn','N', '',  now() ) ";
//   echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in insert meerdaags_toernooi_jn');   

} // count 1


if ($keuze == 'J'  ){
	//// eind datum

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'eind_datum' ") ;  
$result       = mysqli_fetch_array( $qry);
$count        = mysqli_num_rows($qry);
$eind_datum   = $result['Waarde'];


if ($count > 0) {  
	
	if (isset($_POST['eind_datum_jaar'])){
    $eind_datum   = $_POST['eind_datum_jaar']."-".sprintf("%02d",$_POST['eind_datum_maand'])."-".sprintf("%02d",$_POST['eind_datum_dag']);
    // bereken aantal dagen
    $datediff = strtotime($eind_datum) - strtotime($datum);
    $verschil = floor($datediff / (60 * 60 * 24))+1;
}
else {
 	   $eind_datum = $datum;
 	   $verschil   = '<font color = red>Eind datum is toernooi datum !</font>'; 
}

 $query = "UPDATE config
             SET Waarde      = '".$eind_datum."' , 
                 Parameters  = '".$verschil."  dagen.',
                 Laatst      = NOW()  
                 WHERE  Id   = ".$result['Id']."  ";
//  echo $query;
   mysqli_query($con,$query) or die ('Fout in update einddatum');                 
//exit;
}
 else {
 	$eind_datum = $datum;
   $query       = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'eind_datum','".$eind_datum."', '',  now() ) ";
 //   echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in insert einddatum');   

} // end count

//exit;
} // end keuze

//exit;

}// isset meerdaags_toernooi_jn

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  email_notificatie_jn (sinds 25 aug 2018) 

if (isset($_POST['email_notificaties_jn'])){
$variabele = 'email_notificaties_jn';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select email_notificaties_jn');  
 $count     = mysqli_num_rows($qry1);

 $result     = mysqli_fetch_array( $qry1);             
 $id        = $result['Id'];
 
if ($count == 1)  {  
	$keuze       = $_POST['email_notificaties_jn'];
	$kanaal      = $_POST['email_notificaties_kanaal'];
	
	$query       = "UPDATE config  SET Waarde  = '".$keuze."', Parameters = '".$kanaal."' ,  Laatst  = NOW()  WHERE  Id  = ".$id."  ";
   //  echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in update  email_notificatie_jn'); 	
		
	if ($keuze == 'J')  {  
	     $query       = "UPDATE config  SET Waarde  = '0',   Laatst  = NOW()  
	                   WHERE  Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'aantal_reserves'";
        mysqli_query($con,$query) or die ('Fout in update aantal reserves ivm email_notificatie_jn'); 
        $query       = "UPDATE config  SET Waarde  = '0',   Laatst  = NOW()  
	                   WHERE  Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = 'uitgestelde_bevestiging_vanaf'";
        mysqli_query($con,$query) or die ('Fout in update aantal reserves ivm email_notificatie_jn'); 

     	}
	
  } else { 
    $query       = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'email_notificaties_jn','N', '',  now() ) ";
//    echo $query. "<br>";
    mysqli_query($con,$query) or die ('Fout in insert email_notificatie_jn');   

} // count 1

}// email_notificatie_jn 



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  $uitgestelde_bevestiging_vanaf boven (3 mei 2019) 

$variabele = 'uitgestelde_bevestiging_vanaf';
$qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select '. $variabele);  
$count     = mysqli_num_rows($qry1);

if ($count > 0){
	
	 $result     = mysqli_fetch_array( $qry1);    
	 $uitgestelde_bevestiging_vanaf  = $result['Waarde'];
	 
	if ($uitgestelde_bevestiging_vanaf > 0  ){
		
	$variabele = 'uitgestelde_bevestiging_jn';
	$qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."' and Waarde ='J'")     or die(' Fout in select '.$variabele);  
    $count     = mysqli_num_rows($qry1);

     if ($count > 0 ){
   	
     $result     = mysqli_fetch_array( $qry1);             
     $id        = $result['Id'];
 
     $query       = "UPDATE config  SET Waarde  = 'N',   Laatst  = NOW()  WHERE  Id  = ".$id."  ";
	   mysqli_query($con,$query) or die ('Fout in update uitgestelde_bevestiging_jn');   
	}// end if count
 } // end if uitgesteld vanaf 0
 
 	} // isset
else {
  $query       = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'uitgestelde_bevestiging_vanaf','0', '',  now() ) ";
   mysqli_query($con,$query) or die ('Fout in insert uitgestelde_bevestiging_vanaf');   
    
    
 } // end if isset	

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  $recensie_mogelijk j n (15 juni 2019) 

$variabele = 'recensie_mogelijk_jn';
$qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select '. $variabele);  
$count     = mysqli_num_rows($qry1);

if ($count > 0){
	
	 $result     = mysqli_fetch_array( $qry1);    
	 $id          = $result['Id'];
     $recensie_mogelijk_jn        = $_POST['recensie_mogelijk_jn'];
	 
     $query       = "UPDATE config  SET Waarde  = '".$recensie_mogelijk_jn."',   Laatst  = NOW()  WHERE  Id  = ".$id."  ";
	 
	// echo "<br>  rec"		.$query;	
	   mysqli_query($con,$query) or die ('Fout in update recensie_mogelijk_jn');   
 	} 
else {
  $query        = "INSERT INTO  config (Id,  Vereniging, Vereniging_id,Toernooi, Variabele , Waarde, Parameters, Laatst) 
                        VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$toernooi."', 'recensie_mogelijk_jn','N', '',  now() ) ";
						
	//echo "<br>"		.$query;			
  mysqli_query($con,$query) or die ('Fout in insert recensie_mogelijk_jn');   
   
 } // end if isset	
	 	 
	 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 18 okt 2019 aanpassen status inschrijvingen
// aantal_inschrijvingen_vooraf is bepaald vooordat deze gemuteerd werd

$variabele = 'max_splrs';
 $qry1      = mysqli_query($con,"SELECT Waarde From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $max_splrs_achteraf   = $result['Waarde'];

 $qry1      = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Status like 'RE%'   ")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $aantal_reserves   = $result['Aantal'];
 
 $qry1      = mysqli_query($con,"SELECT count(*) as Aantal From inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'    ")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $aantal_inschrijf   = $result['Aantal'];
//echo "<br>Aantal reserves in inschrijf ".$aantal_reserves;

  // als aantal spelers vooraf < dan aantal inschrijvingen en er zijn reserveringen
  
  //echo "<br>MAX SPLRS vooraf ".$max_splrs_vooraf ;
  //  echo "<br>MAX SPLRS achterraf  ".$max_splrs_achteraf ;

 $verschil = $max_splrs_achteraf  - $max_splrs_vooraf;
  //echo "<br>Verschil ".$verschil;
    
  if ($aantal_reserves > 0  and $verschil > 0 ){
    
	$qry2      = mysqli_query($con,"SELECT Id,Naam1 from inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' 
                         and Status like 'RE%'   order by Inschrijving limit ".$verschil." ")     or die(' Fout in select 18 ok');  

        while($row = mysqli_fetch_array( $qry2 )) {
    //      echo "<br>Id : ". $row['Naam1'];
		  
		  $update_qry ="UPDATE inschrijf set Status = 'IN3'  where Id = ".$row['Id']." and Toernooi = '".$toernooi ."' ";
		  
			   mysqli_query($con,$update_qry) or die ('Fout in update inschrijf ivm reserves');   
		} // end while
   } // end if verschil
  
// indien aantal verlaagd wordt en er staan nog reserves op de lijst  wordt oorspronkelijk aantal teruggezet
  
     if ($aantal_reserves > 0  and $verschil < 0 ){
            $update_qry ="UPDATE config  set Waarde  = '".$max_splrs_vooraf."'  where Variabele = 'max_splrs' and Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ";
      // echo 		$update_qry;
    	 mysqli_query($con,$update_qry) or die ('Fout in update config  ivm reserves');   
   }// end if	   
  
  //  aantal in conf mag niet kleiner zijn dan aantal inschrijvingen
      if ($max_splrs_achteraf  < $aantal_inschrijf ){
            $update_qry ="UPDATE config  set Waarde  = '".$aantal_inschrijf ."'  where Variabele = 'max_splrs' and Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ";
      // echo 		$update_qry;
    	 mysqli_query($con,$update_qry) or die ('Fout in update config  ivm reserves');   
   }// end if	   
  
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

<?php
/// Maak xml file met de laatst opgeslagen configuratie tbv restore
include ('create_config_xml.php');
?>

<script language="javascript">
		window.location.replace('beheer_ontip.php?<?php echo $replace; ?>');
</script>
