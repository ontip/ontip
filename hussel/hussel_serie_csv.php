<?php
$datum = $_GET['datum'];
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"hussel_serie_".$datum.".csv\"");

// Database gegevens. 
include('mysql.php');

$jaar  =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag   =  substr($datum, 8,2);
// datum vandaag
$vandaag = date ('Y')."-".date('m')."-".date('d');

$sql_stand  = mysql_query("SELECT * FROM hussel_serie_stand WHERE  Vereniging_id = ".$vereniging_id." order by Totaal desc ") or die(' Fout in select scores'); 

  // bepaal naam serie

$sql  = mysql_query("SELECT Naam_serie FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." Limit 1 ") or die(' Fout in select naam serie'); 
$row = mysql_fetch_array( $sql );
$naam_serie = $row['Naam_serie'];


echo "Eindstand hussel serie  ".$naam_serie.". Stand per ".$datum."\r\n"; 

echo "Nr" .";"; 
echo "Naam" .";"; 

   // datums tbv kopregel
   $aantal_datums=0;
      $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <= '".$vandaag."' and Datum <>'0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
         while($row = mysql_fetch_array( $sql_datums )) {
          $aantal_datums++;
        echo $row['Datum'].";"; 
         } // end while

echo "Gespeeld" .";"; 
echo "Score" .";"; 
echo "Saldo" ."\r\n"; 

  $i=1;
  while($row_stand= mysql_fetch_array( $sql_stand )) {

echo $i .".;"; 
echo $row_stand['Naam'].";"; 

// kontroleer of er al op deze datum gespeeld is
    
   for($j=1;$j<=$aantal_datums;$j++){
     echo $row_stand['Score'.$j].";"; 
   }
 echo $row_stand['Gespeeld'].";"; 
 echo $row_stand['Totaal'].";"; 
 
 // bepaald einde saldo
         $sql_saldo  = mysql_query("SELECT SUM(Saldo) as Saldo FROM hussel_serie_scores WHERE  Vereniging_id = ".$vereniging_id." and Naam ='".$row_stand['Naam']."'  Group by Naam ") or die(' Fout in select saldo'); 
         $row_saldo  = mysql_fetch_array( $sql_saldo );
 
         echo $row_saldo['Saldo']."\r\n"; 
$i++;
 } // end while




echo "Einde lijst"."\r\n"; 
?>
