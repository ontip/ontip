<?php
//include('mysql.php');
$ip        = $_SERVER['REMOTE_ADDR'];
$count     = 0;
$laatst    = '';
$tot_secs  = 0;

//echo "check";
//echo "xx" .$vereniging;
//echo $ip;

//echo "SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ";


// kontroleer of op deze PC iemand is aangelogd

$sql      = mysql_query("SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select ip check');  
$result   = mysql_fetch_array( $sql );
$count    = mysql_num_rows($sql);

if ($count > 0){
  $rechten  = $result['Beheerder'];
  $naam     = $result['Naam'];
  $toernooi = $result['Toernooi'];

	// check op 2 uur geleden'
	$sql1      = mysql_query("SELECT Laatst FROM namen WHERE  IP_adres = '".$ip."'  and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select ip');  
  $result1   = mysql_fetch_array( $sql1 );
  $laatst    = $result1['Laatst'];

  $sql2      = mysql_query("SELECT TIMEDIFF(NOW(), '".$laatst."'  ) as Verschil" );
  $result2   = mysql_fetch_array( $sql2 );
  $verschil  = $result2['Verschil'];
  
  $tijd      = explode (":", $verschil);
  $uren      = $tijd[0];
  $mins      = $tijd[1];
  $secs      = $tijd[2];
  $tot_secs  = $secs + (120*$mins) + (3600 * $uren);

  if ($tot_secs > 28800) {
//	  echo "Langer dan 8 uur (8x3600)  geleden.<br>";
	  $count = 0 ;
  }
}

if ($count > 0){
	$aangelogd  = 'J';
	//echo "Aangelogd"; 
}
?>