<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysqli.php');

$marathon_ronde  = $_POST['marathon_ronde'];

$qry                 = mysqli_query($con,"SELECT * From hussel_config  where Vereniging_id = '".$vereniging_id ."' and Variabele = 'marathon_ronde'  ") ;  
$result              = mysqli_fetch_array( $qry);
$marathon_ronde       = $result['Waarde'];

$_marathon_ronde       = $_POST['marathon_ronde'];

if (isset($_GET['plus'])){
	$_marathon_ronde = $marathon_ronde+1;
}

if (isset($_GET['min'])){
	$_marathon_ronde = $marathon_ronde-1;
	if ($_marathon_ronde   == 0){
	$_marathon_ronde = 1;
  }
}



	 $query="UPDATE hussel_config SET Waarde = ".$_marathon_ronde."   where  Vereniging_id = ".$vereniging_id." and Variabele = 'marathon_ronde'  ";   
	//echo $query;
    mysqli_query($con,$query) or die(' Fout in aanpassen marathon ronde');  
 	
ob_end_flush();
?> 
