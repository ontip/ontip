<?php 
ob_start();
$url = 'verwijder_hussels_stap1.php';
//// Database gegevens. 

include ('mysqli.php');
$check         = $_POST['Check'];



if (isset($_POST['verwijder_scores'])){
		$verwijder_spelers = 'On';

    foreach ($check as $datum)
    {
  	 $query="DELETE FROM hussel_score    where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'   ";   
	   //echo $query;
    mysqli_query($con,$query) or die(' Fout in verwijder spelers beperkt');  
 
	}  // end foreach
}  // end if
	
	
header("Location: ".$url);


ob_end_flush();
?> 
