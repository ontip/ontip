<?php

include('action.php');

$toernooi_naam  = $_POST['toernooi_naam'];
$voor  = $_POST['voor'];
$tegen = $_POST['tegen'];
$naam  = $_POST['naam'];
$ronde = $_POST['ronde'];
$vereniging_id = $_POST['vereniging_id'];
$vereniging = $_POST['vereniging'];
$error =0;

 include('mysqli.php');
 
	
if ($naam ==''){
$error =1;
header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi_naam."&naam");

}

if ($ronde ==''){
	$error =1;
 header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi_naam."&ronde");
}

 
 if ($voor < 13 and $tegen < 13 and $voor !='' and $tegen !=''){
$error =1;
header("Location: doorgeven_uitslag_stap1.php?score&ronde=".$ronde);

}

 if ($voor == 13 and $tegen == 13 ){
 $error =1;
header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi_naam."&score");

}

if ($error ==0){
 setcookie('naam',$_POST['naam'], time()+7200 );
 
 
 echo "SELECT *  FROM `toernooi_uitslag` where Vereniging_id = ".$vereniging_id." and Toernooi_naam = '".$toernooi_naam."' and Naam = '".$naam."'     ";
 
  $uitslag    = mysqli_query($con,"SELECT *  FROM `toernooi_uitslag` where Vereniging_id = ".$vereniging_id." and Toernooi_naam = '".$toernooi_naam."' and Naam = '".$naam."'     ")            or die('fout in select');  
  $result     = mysqli_fetch_array( $uitslag );
  $id         = $result['Id'];
  
	
	
	if ($result['Naam'] != ''){
	 
     	
	$var1 = 'Voor'.$ronde;
	$var2 = 'Tegen'.$ronde;
	$var3 = 'Invoer_tijd'.$ronde;
	
    $update_query = "UPDATE `toernooi_uitslag` 
			     set ".$var1."  = ".$voor." ,
				     ".$var2."  = ".$tegen.",
					 ".$var3."  = now() 
					 where Toernooi_naam = '".$toernooi_naam."' and Vereniging_id = ".$vereniging_id." and Naam = '".$naam."' and Id = ".$id."  "  ;
	    
	//   	echo "<br>".$update_query;
	   mysqli_query($con,$update_query) or die ('Fout in update :    '.$update_query);
		header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi_naam);
		
	} else{
	 
	 	 
			   $insert_query = "insert into `toernooi_uitslag` (Id,Vereniging, Vereniging_id,Toernooi_naam,Naam,  Voor1,Tegen1, Invoer_tijd1)
                VALUES (0,'".$vereniging."',".$vereniging_id.",  '".$toernooi_naam."','".$naam."', ".$voor.",".$tegen.", now() )"  ;
		 
		
		
	 //	echo "<br>".$update_query;
	  mysqli_query($con,$insert_query) or die ('Fout in insert :    '.$insert_query);
	 
		header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi_naam);
	}
	
}
 
 
?>
