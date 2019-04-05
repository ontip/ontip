<?php

 ob_start();
include 'mysqli.php'; 


/// Alleen doen als er nog geen lotnummer ingevoerd is 
$query    = mysqli_query($con,"SELECT * from hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Lot_nummer = 0  " )     or die(mysql_error());  
$count    = mysqli_num_rows($query);


if ($count < 3  ){
	
?>
   <script language="javascript">
        alert("Er zijn al lotnummers ingevuld. Via het beheerscherm kan de loting gereset worden. De loting zal willekeurig lotnummers toekennen en de lijst hierop sorteren.")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
}
else {
	header("Location: ".$_SERVER['HTTP_REFERER']);

	
// reset

$query   = "UPDATE hussel_score SET Lot_nummer = 0  where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  ";   
mysqli_query($con,$query) or die ('Fout in reset hussel_score vooor lotnr ');   
    
    
// ophalen aantal score regels

$spelers    = mysqli_query($con,"SELECT * from hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Naam <> ''  " )     or die(mysql_error());  
$aantal    = mysqli_num_rows($spelers);


while($row = mysqli_fetch_array( $spelers )) {
$naam      = $row['Naam'];
$lot_nr    = mt_rand(1, $aantal);

$count= 0;

  $score     = mysqli_query($con,"SELECT Naam from hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Lot_nummer = ".$lot_nr."  " )     or die(mysql_error());  
	$count     = mysqli_num_rows($score);
 	
	while  ($count >  0) {
		$count     = 0;
	  $lot_nr    = mt_rand(1, $aantal);
	  $sql       = mysqli_query($con,"SELECT Lot_nummer from hussel_score WHERE Vereniging_id = ".$vereniging_id." and Datum = '".$datum."' and Lot_nummer = ".$lot_nr."  " )     or die(mysql_error());  
 	  $count     = mysqli_num_rows($sql);
   	}// end while count
		
		$query   = "UPDATE hussel_score SET Lot_nummer = ".$lot_nr."  where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  and Naam = '".$naam."' ";   
    mysqli_query($con,$query) or die ('Fout in update hussel_score vooor lotnr ');   	 		
	
} // end while score

}// end fout

ob_end_flush();
?>
