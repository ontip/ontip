<?php
/// bereken sms tegoed vanaf laatste saldo update

 $qry1      = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select sms aantal');  
  $result1   = mysqli_fetch_array( $qry1);
 $max_aantal_sms         = $result1['Max_aantal_sms'];
 $datum_sms_saldo_update = $result1['Datumtijd_sms_saldo_update'];
 
 //echo $datum_sms_saldo_update. "<br>";
 
 //echo "SELECT count(*) as Aantal From sms_confirmations where Vereniging  = '".$vereniging."' and Laatst > '". $datum_sms_saldo_update."'  ";
 
  $qry2        = mysqli_query($con,"SELECT count(*) as Aantal From sms_confirmations where Vereniging  = '".$vereniging."' and Laatst > '". $datum_sms_saldo_update."'  ")     or die(' Fout in select sms gebruikt');  
 $result2     = mysqli_fetch_array( $qry2 );
 $sms_aantal  = $result2['Aantal'];

 // Bereken totale lengte berichten > 160
 
 $qry3        = mysqli_query($con,"SELECT count(*) as Aantal_lange_berichten From sms_confirmations where Vereniging  = '".$vereniging."' and Laatst > '". $datum_sms_saldo_update."' and Lengte_bericht > 160 ")     or die(' Fout in select sms gebruikt');  
 $result3     = mysqli_fetch_array( $qry3 );
 $sms_aantal_plus  = $result3['Aantal_lange_berichten'];
 
 $sms_aantal = $sms_aantal  + $sms_aantal_plus;
  
 // Bereken totale lengte berichten > 320
 
 $qry4        = mysqli_query($con,"SELECT count(*) as Aantal_lange_berichten From sms_confirmations where Vereniging  = '".$vereniging."' and Laatst > '". $datum_sms_saldo_update."' and Lengte_bericht > 320 ")     or die(' Fout in select sms gebruikt');  
 $result4     = mysqli_fetch_array( $qry4 );
 $sms_aantal_plus  = $result4['Aantal_lange_berichten'];
 
 $sms_aantal = $sms_aantal  + $sms_aantal_plus;
 
 // Bereken totale lengte berichten > 480
 
 $qry5        = mysqli_query($con,"SELECT count(*) as Aantal_lange_berichten From sms_confirmations where Vereniging  = '".$vereniging."' and Laatst > '". $datum_sms_saldo_update."' and Lengte_bericht > 480 ")     or die(' Fout in select sms gebruikt');  
 $result5     = mysqli_fetch_array( $qry5 );
 $sms_aantal_plus  = $result5['Aantal_lange_berichten'];
 
 $sms_aantal = $sms_aantal  + $sms_aantal_plus;
 
 /// totaal tegoed
 $sms_tegoed  = ($max_aantal_sms - $sms_aantal);
   
 
 if ($sms_tegoed == ''){
 	$sms_tegoed =   0;
}


 if ($sms_tegoed < 1){
     $sms_bevestigen_zichtbaar_jn = 'N'; 	
     $sms_send = 'N';
}
?>