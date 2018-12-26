<?php 
ob_start();
$url = 'index.php';
//// Database gegevens. 

include ('mysql.php');

if (isset($_POST['verwijder_scores'])){
		$verwijder_spelers = 'On';

    foreach ($check as $datum)
    {
  	 $query="DELETE FROM hussel_score    where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'   ";   
	   echo $query;
  //  mysql_query($query) or die(' Fout in verwijder spelers beperkt');  
 
	}// end foreach
}  // end if
	
	
header("Location: ".$url);


ob_end_flush();
?> 
