<?php
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();
include 'mysql.php'; 

// ophalen aantal score regels
$count_score   = $_POST['count_score'];
$controle_13   = $_POST['controle_13'];

$aantal_rondes = $_POST['aantal_rondes'];

$voor4           = 0;
$tegen4          = 0;
$voor5           = 0;
$tegen5          = 0;

for ($i=1;$i<=$count_score;$t++){
	 
	 $id      = $_POST['Id_'.$i];
	 $naam    = $_POST['Naam_speler_'.$i];
	 $voor1   = $_POST['Voor1_'.$i];
	 $tegen1  = $_POST['Tegen1_'.$i];
	 $voor2   = $_POST['Voor2_'.$i];
	 $tegen2  = $_POST['Tegen2_'.$i];
	 $voor3   = $_POST['Voor3_'.$i];
	 $tegen3  = $_POST['Tegen3_'.$i];
	 
if ($aantal_rondes == 5){	 
	 $voor4   = $_POST['Voor4_'.$i];
	 $tegen4  = $_POST['Tegen4_'.$i];
	 $voor5   = $_POST['Voor5_'.$i];
	 $tegen5  = $_POST['Tegen5_'.$i];
} 
 
 if ($controle_13 == 'Ja'){
	 	
	 	if ($voor1   != 13 and $voor1 > 0   and $tegen1 == 0 ) {
	 		  $tegen1   = 13;
	 	}
	 	
	 	if ($tegen1   != 13 and $tegen1 > 0 and $voor1 == 0 ) {
	 		  $voor1    = 13;
	 	}

	 	if ($voor2   != 13 and $voor2 > 0   and $tegen2 == 0 ) {
	 		  $tegen2   = 13;
	 	}
	 	
	 	if ($tegen2   != 13 and $tegen2 > 0 and $voor2 == 0 ) {
	 		  $voor2   = 13;
	 	}

	 	if ($voor3   != 13 and $voor3 > 0   and $tegen3 == 0 ) {
	 		  $tegen3   = 13;
	 	}
	 	
	 	if ($tegen3   != 13 and $tegen3 > 0 and $voor3 == 0 ) {
	 		  $voor3   = 13;
	 	}

 if ($aantal_rondes == 5){
	 	if ($voor4   != 13 and $voor4 > 0   and $tegen4 == 0 ) {
	 		  $tegen4   = 13;
	 	}
	 	
	 	if ($tegen4   != 13 and $tegen4 > 0 and $voor4 == 0 ) {
	 		  $voor4   = 13;
	 	}

	 	if ($voor5   != 13 and $voor5 > 0   and $tegen5 == 0 ) {
	 		  $tegen5   = 13;
	 	}
	 	
	 	if ($tegen5   != 13 and $tegen5 > 0 and $voor5 == 0 ) {
	 		  $voor5   = 13;
	 	}

} // 5 rondes

} // end if controle_13

// bereken winst en saldo
	  $winst = 0;
	  if ($voor1 == 13){
	  	$winst++;
	  }
	  if ($voor2 == 13){
	  	$winst++;
	  }
	 if ($voor3 == 13){
	  	$winst++;
	  }
	  
	 $saldo = ($voor1-$tegen1)+($voor2-$tegen2)+($voor3-$tegen3)+($voor4-$tegen4)+($voor5-$tegen5);
	 		  
/// update score
$query        = "UPDATE hussel_score
                SET Naam_speler   = '".$_POST['Naam_speler_".$i."']."', 
                    Voor1          = ".$voor1.", 
                    Tegen1         = ".$tegen1.", 
                    Voor2          = ".$voor1.", 
                    Tegen2         = ".$tegen2.", 
                    Voor3          = ".$voor1.", 
                    Tegen3         = ".$tegen3.", 
                    Voor4          = ".$voor4.", 
                    Tegen4         = ".$tegen4.", 
                    Voor5          = ".$voor5.", 
                    Tegen5         = ".$tegen5.", 
                    Winst          = ".$winst.",     
                    Saldo          = ".$winst.",     
                    Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 // echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update hussel_score ');   	 		
	                         		 
	}// next line
ob_end_flush();
?>
