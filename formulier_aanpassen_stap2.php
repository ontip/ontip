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



//  Check if all variables are present

$sql      = mysqli_query($con,"SELECT * FROM config where Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' and Variabele = 'formulier_config_compleet'") or die(' Fout in select toernooi '.$toernooi_id);  
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
			if ($key !='toernooi_id' and $key !='vereniging_id' and  $key !='zendform' 
			       and $key !='afbeelding_width'            and $key !='afbeelding_height'
				   and $key !='positie'                     and $key !='text_effect'
				   and $key !='op_lijst_2_jn'               and $key !='begin_inschrijving_min'

		                ){
               $sql      = mysqli_query($con,"SELECT * FROM config WHERE Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' 
    		                    and Variabele = '".$key."'") or die(' Fout in select var '.$key);  
               $result   = mysqli_fetch_array( $sql );
     // insert if not present
               if ($result['Toernooi'] ==''){
    			   $query = "insert into config (Vereniging,Vereniging_id, Toernooi,Variabele,Waarde) 
                             VALUES ('".$vereniging."', ".$vereniging_id." ,'".$toernooi."','".$key."',' ' )";
    	//	       echo "<br>".$query;
    		    mysqli_query($con,$query) or die ('Fout in update '.$key);       
  
		   }
		}
     
		  }             
        } 
 // insert waarde voor synchronisatie
   $query = "delete from  config where WHERE  Variabele  = 'formulier_config_compleet'                    and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
	  mysqli_query($con,$query) ;   
	  
     
   $query = "insert into config (Vereniging,Vereniging_id, Toernooi,Variabele,Waarde) 
                             VALUES ('".$vereniging."', ".$vereniging_id." ,'".$toernooi."','formulier_config_compleet',now() )";
	
							 
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
			       and $key !='afbeelding_width'            and $key !='afbeelding_height'
				   and $key !='positie'                     and $key !='text_effect'
				   and $key !='op_lijst_2_jn'               and $key !='begin_inschrijving_min'
				   
	           ){
	        $query = "update config set Waarde     = '".$value."', Laatst = now() 
			            where Variabele            = '".$key."'  
                           and md5(Toernooi)       = '".$toernooi_id ."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
		//  echo "<br>".$query;
		 mysqli_query($con,$query) or die ('Fout in update '.$key);       
		}             
        } 
    } 

////////////////////  speciale instellingen ///////////////////////////////////////////////
 // $begin_inschrijving = $_POST['datum_begin_inschrijving']." ".sprintf("%02d",$_POST['begin_inschrijving_uur']).":".sprintf("%02d",$_POST['begin_inschrijving_min']);
 $size = getimagesize ($url_afbeelding);  
 if ($_POST['afbeelding_width'] == '') {
    $afb_width   = $size[0];
     $afb_height  = $size[1];
 } else {
	  $afb_width   = $_POST['afbeelding_width'];
      $afb_height  = $_POST['afbeelding_height'];
	 
 }

$parameters = $_POST['positie'].'#'.$afb_width.'#'.$afb_height;

if (strpos($url_afbeelding, '/') ==0){
	$url_afbeelding = 'images/'.$url_afbeelding;
}
$query      = "UPDATE config SET Waarde  = '".$url_afbeelding."' , Parameters ='".$parameters."' ,    Laatst     = NOW() WHERE  Variabele  = 'url_afbeelding' 
                           and md5(Toernooi)       = '".$toernooi_id."' 
 					       and Vereniging_id       =  '".$vereniging_id."' ";
	//	  echo "<br>".$query;
mysqli_query($con,$query) or die ('Fout in update url_afbeelding');       

ob_end_flush();
?> 