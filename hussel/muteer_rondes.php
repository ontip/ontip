<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysqli.php');


if (isset($_GET['aantal_rondes'])){ 
	$aantal_rondes  = $_GET['aantal_rondes'];	 
}
 else {
  $aantal_rondes  = $_POST['aantal_rondes'];	 
}

 
  $query   = "UPDATE hussel_config SET Waarde = '".$aantal_rondes."'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'aantal_rondes'";   
  mysqli_query($con,$query) or die(' Fout in aanpassen aantal rondes');  

ob_end_flush();
?> 
