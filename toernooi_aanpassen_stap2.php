<?php
ob_start();
// Database gegevens. 
include('mysqli.php');
//include('action.php');
//include('versleutel_string.php');

header("Location: ".$_SERVER['HTTP_REFERER']);

// formulier POST variabelen ophalen en kontroleren

if (!isset($_POST['zendform'])) 
{ 
	exit;
	
}

$error   = 0;
$message = '';
$toernooi_id       = $_POST['toernooi_id'];
$vereniging_id_md5 = $_POST['vereniging_id_md5'];
 
$sql      = mysqli_query($con,"SELECT * FROM config WHERE md5(Toernooi) = '".$toernooi_id."'  and md5(Vereniging_id)  =  '".$vereniging_id_md5."' and Variabele = 'toernooi_voluit'") or die(' Fout in select toernooi :'.$toernooi_id);  
$result   = mysqli_fetch_array( $sql );
   
if ($result['Toernooi'] ==''){
	echo "Toernooi niet gevonden!";
	exit;
	
} else {
 $vereniging    = $result['Vereniging'];
 $vereniging_id = $result['Vereniging_id'];
 $toernooi      = $result['Toernooi'];
}
echo "xxxxxxxxxxxxxxxxxxxxxxxxx".$vereniging_id;


//  Check if all variables are present

$sql      = mysqli_query($con,"SELECT * FROM config where Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' and Variabele = 'toernooi_config_compleet'") or die(' Fout in select toernooi '.$toernooi_id);  
$result   = mysqli_fetch_array( $sql );

if ($result['Toernooi'] ==''){

     foreach($_POST as $key => $value) 
        { 
            # controleren of $value een array is 
            if (is_array($value)) 
            { 
                foreach($value as $key_sub => $value_sub) 
                { 
                    $key2 = $key . $key_sub; 
                    $$key2 = $value_sub; 
                } 
            } 
            else 
            { 
                $$key = trim($value);                  /// Maakt zelf de variabelen aan
    	
		    // skip deze hulp variabelen
		    if ($key !='toernooi_id' and $key !='vereniging_id_md5' and  $key !='zendform' 
		                         and $key !='datum_begin_inschrijving'
		                         and $key !='begin_inschrijving_uur'
		                         and $key !='begin_inschrijving_min'
		                         and $key !='einde_inschrijving_uur'
		                         and $key !='einde_inschrijving_min'
								 and $key !='prefix_meldtijd'
		                         and $key !='meldtijd_uur'
		                         and $key !='meldtijd_min'
		                         and $key !='aanvang_uur'
		                         and $key !='aanvang_min'
		                         and $key !='inschrijf_methode'
		                         and $key !='euro_sign'
								   and $key !='euro_sign'

		                ){
               $sql      = mysqli_query($con,"SELECT * FROM config WHERE Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' 
    		                    and Variabele = '".$key."'") or die(' Fout in select var '.$key);  
               $result   = mysqli_fetch_array( $sql );
     // insert if not present
               if ($result['Toernooi'] ==''){
    			   $query = "insert into config (Vereniging,Vereniging_id, Toernooi,Variabele,Waarde) 
                             VALUES ('".$vereniging."', ".$vereniging_id." ,'".$toernooi."','".$key."',' ' )";
    //		       echo "<br>".$query;
    		    mysqli_query($con,$query) or die ('Fout in update '.$key);       
  
		   }
		}
     
		  }             
        } 
 // insert waarde voor synchronisatie
 $query = "delete from  config where WHERE  Variabele  = 'toernooi_config_compleet'                    and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
	  mysqli_query($con,$query);   
	  
	  
   $query = "insert into config (Vereniging,Vereniging_id, Toernooi,Variabele,Waarde) 
                             VALUES ('".$vereniging."', ".$vereniging_id." ,'".$toernooi."','toernooi_config_compleet',now() )";
      mysqli_query($con,$query) or die ('Fout in update sync waarde');   

} // end if 


 // update all  values for posted variables
 
   foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
			
			if ($key !='toernooi_id' and $key !='vereniging_id' and  $key !='zendform' 
			       and $key !='meldtijd_uur'            and $key !='meldtijd_min'
				   and $key !='aanvang_uur'             and $key !='aanvang_min'
				   and $key !='begin_inschrijving_uur'  and $key !='begin_inschrijving_min'
				   and $key !='einde_inschrijving_uur'  and $key !='einde_inschrijving_min'
	               and $key !='prefix_meldtijd'
	           ){
	        $query = "update config set Waarde     = '".$value."', Laatst = now() 
			            where Variabele            = '".$key."'  
                           and md5(Toernooi)       = '".$toernooi_id ."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
		  echo "<br>".$query;
		 mysqli_query($con,$query) or die ('Fout in update '.$key);       
		}             
        } 
    } 

////////////////////  speciale instellingen ///////////////////////////////////////////////
$begin_inschrijving = $_POST['datum_begin_inschrijving']." ".sprintf("%02d",$_POST['begin_inschrijving_uur']).":".sprintf("%02d",$_POST['begin_inschrijving_min']);
 
$query         = "UPDATE config SET Waarde  = '".$begin_inschrijving."' ,       Laatst     = NOW() WHERE  Variabele  = 'begin_inschrijving' 
                           and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
//
 //echo $query;

 mysqli_query($con,$query) or die ('Fout in update begin_inschrijving');  
////
$einde_inschrijving   = $_POST['datum_einde_inschrijving']." ".sprintf("%02d",$_POST['einde_inschrijving_uur']).":".sprintf("%02d",$_POST['einde_inschrijving_min']);
 
$query         = "UPDATE config SET Waarde  = '".$einde_inschrijving."' ,       Laatst     = NOW() WHERE  Variabele  = 'einde_inschrijving' 
                           and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
//
//echo "<br>zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz".$query;
mysqli_query($con,$query) or die ('Fout in update einde_inschrijving');  
/////

$aanvang_tijd  = sprintf("%02d",$_POST['aanvang_uur']).":".sprintf("%02d",$_POST['aanvang_min'])." uur";
$query         = "UPDATE config SET Waarde  = '".$aanvang_tijd."' ,       Laatst     = NOW() WHERE  Variabele  = 'aanvang_tijd' 
                           and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
//
//echo "<br>zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz".$query;
mysqli_query($con,$query) or die ('Fout in update aanvangtijd');       

/////

 
$meld_tijd    = sprintf("%02d",$_POST['meld_uur']).":".sprintf("%02d",$_POST['meld_min']). " uur";

$parameter = '#'.$_POST['prefix_meldtijd'];
$query         = "UPDATE config SET Waarde = '".$meld_tijd."' , Parameters  = '".$parameter."' ,       Laatst     = NOW() WHERE  Variabele  = 'meld_tijd' 
                          and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
						   
//echo "<br>zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz".$query;
mysqli_query($con,$query) or die ('Fout in update meldtijd');       


if ($_POST['euro_sign'] =='on') {
	$euro_sign = 'm';
}
else {
	$euro_sign = 'z';

}
$kosten_eenheid = $_POST['kosten_eenheid'];
$parameters     = "#".$euro_sign."#".$kosten_eenheid;


$query         = "UPDATE config SET Waarde = '".$kosten_team."' , Parameters  = '".$parameters ."' ,       Laatst     = NOW() WHERE  Variabele  = 'kosten_team' 
                          and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
//echo "<br>zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz".$query;
mysqli_query($con,$query) or die ('Fout in update kosten');       
			 
//////////////////////////////////
$parameters = $_POST['inschrijf_methode'];
$query         = "UPDATE config SET Waarde = '".$soort_inschrijving."' , Parameters  = '".$parameters ."' ,       Laatst     = NOW() WHERE  Variabele  = 'soort_inschrijving' 
                           and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
 mysqli_query($con,$query) or die ('Fout in update inschrijf methode'); 
  
  
  
ob_end_flush();
?> 