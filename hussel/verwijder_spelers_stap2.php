<?php 
ob_start();

//// Database gegevens. 

include ('mysqli.php');

if (isset($_POST['verwijder_spelers'])){
		$verwijder_spelers = 'On';

$delete  = $_POST['delete'];


$deleteid = explode(';', $delete);
$aantal   = count($deleteid);
$aantal--;

for ($i=0;$i<$aantal;$i++){
		
	
		$qry  = mysqli_query($con,"delete  From hussel_score where Id = ".$deleteid[$i]."  ")     or die(' Fout in select');  
	  $row = mysqli_fetch_array( $qry );
}



  $query="UPDATE hussel_score  SET Lot_nummer = 0   where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'   ";   
   mysqli_query($con,$query) or die(' Fout in update lotnummer');  
   $url = 'index.php';
  
 }  else {
	 $url = $_SERVER['HTTP_REFERER'];
	}
	
	
header("Location: ".$url);


ob_end_flush();
?> 
