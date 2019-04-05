<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysqli.php');

$hussel_serie  = $_POST['hussel_serie'];
//echo $hussel_serie."<br>";


 for ($j=1;$j<21;$j++){
 	
 if (isset($_POST['id_'.$j])  ){
 
 		  $id     = $_POST['id_'.$j];
 		  $datum  = $_POST['datum_'.$j];
 		  
 		  // update
 			$query   = "UPDATE hussel_serie SET Naam_serie = '".$hussel_serie."' , Datum = '".$datum."'  where Id = ".$id." ";   
 		 // echo $query;
 mysqli_query($con,$query) or die ('Fout in update hussel_serie');  
 
 } else {
 
 			 $id = 0;
 			 $datum  = $_POST['datum_'.$j]; 
 			 
 		  // insert
 			$query   = "INSERT hussel_serie (Id, Vereniging, Vereniging_id ,Naam_serie, Datum) VALUES ( 0, '".$vereniging."' ,".$vereniging_id." ,'".$hussel_serie."' ,'".$datum."'   )";   
 			//echo $query;
 			mysqli_query($con,$query) or die ('Fout in insert hussel_serie');   	 		
  }			  // endif
 
 
}// end for

	
	//////// verwijderen

$delete = $_POST['Check'];

foreach ($delete as $deleteid)  { 

 mysqli_query($con,"DELETE FROM hussel_serie  where Id= ".$deleteid." ");

} // end foreach


ob_end_flush();
?> 
