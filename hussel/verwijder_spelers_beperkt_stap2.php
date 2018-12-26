<?php 
ob_start();

//// Database gegevens. 

include ('mysql.php');

if (isset($_POST['verwijder_spelers'])){
		$verwijder_spelers = 'On';

	 $query="DELETE FROM hussel_score    where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Beperkt = 'J'  ";   
//	  echo $query;
    mysql_query($query) or die(' Fout in verwijder spelers beperkt');  
  $query="UPDATE hussel_score  SET Lot_nummer = 0   where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'   ";   
   mysql_query($query) or die(' Fout in update lotnummer');  
   $url = 'index.php';
  
 }  else {
	 $url = $_SERVER['HTTP_REFERER'];
	}
	
	
header("Location: ".$url);


ob_end_flush();
?> 
