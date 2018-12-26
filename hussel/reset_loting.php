<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

//// Database gegevens. 

include ('mysql.php');

//echo "SELECT count(*)as Aantal From hussel_score  where Vereniging_id = ".$vereniging_id." and Voor1 > 0 and Tegen1 > 0 and  Datum = '".$datum."'  ";

   $reset_loting = $_POST['reset_loting'];
  
    $query   = "UPDATE hussel_config SET Waarde = '".$reset_loting."'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'reset_loting'";   
   //echo $query;
   
    mysql_query($query) or die(' Fout in reset loting');  


// als reset loting = 1 moeten alle lot nummers worden gewist


if ($reset_loting ==1 ) {
   $query   = "UPDATE hussel_score SET Lot_nummer = 0  where  Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  ";   
   mysql_query($query) or die ('Fout in reset hussel_score vooor lotnr ');   


// na schonen op 3 gezet zodat ze niet kunnen worden aangepast

  $query   = "UPDATE hussel_config SET Waarde = '3'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'reset_loting'";   
   //echo $query;
   
    mysql_query($query) or die(' Fout in reset loting');  

}









ob_end_flush();
?> 
