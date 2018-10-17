<?php
/// encrypten van wachtwoord

$detail     = $_GET['detail'];
$wachtwoord = $_GET['ww'];

$detail = "J";
$key_string = "R0048965999954265316abc5432189765";
$encrypt    = '';
$key_index  = substr($key_string,1,3);

//echo $wachtwoord;
if (isset($_GET['ww'])){
	
if ($detail=='J'){
  echo "<h1>SYNCHRONE VERSLEUTELING   (c) Erik Hendrikx 2011</h1>";
  echo "<table border = 1><tr> ";
  echo "<td colspan= 5>Wachtwoord :<br><b>".$wachtwoord."</b></td><td colspan= 5>Sleutel :<br><span style='color:blue;font-weight:bold;'>". $key_string." Key index : ". $key_index."</span></td></tr>";
  echo "<tr><th>Pos</th><th>ASC<br>WW</th><th>Char<br>WW</th><th>Char<br>Key</th><th>ASCII<br>Key</th><th>BIN WW</th><th>BIN Key</th><th>BIN<br>compare</th><th>Encrypt<br>ASCII</th><th>Encrypt<br>Char</th></tr>";
 } 
 
$len = strlen($wachtwoord);
$k   = 0 ;
// echo $len;

for ($i=0;$i<$len;$i=$i+3){
	
	// conversie letter naar ascii waarde
	 $z        = $k+$key_index;
	 $asc_w[$k]= substr($wachtwoord,$i,3);
	 $asc_k[$k]= ord(substr($key_string,$z,1));
	 //echo $asc_w[$k];
	 
	 
	 if ($detail=='J'){
	 	echo "<tr><td>". 	 $k ."</td>";
	 	echo "<td>". substr($wachtwoord,$i,3) ."</td>";
	 	echo "<td>". chr(substr($wachtwoord,$i,3)) ."</td>";
		echo "<td>". substr($key_string,$z,1) ."</td>";
	  echo "<td>".$asc_k[$k]."</td>";
	 }
	 
	 // conversie ascii waarde letter naar binary waarde
	 // add leading zero to bin to len 8
	 
	 $bin_w[$k] = sprintf('%08d', decbin($asc_w[$k]));
	 $bin_k[$k] = sprintf('%08d', decbin($asc_k[$k]));
	 
	 if ($detail=='J'){
	   echo"<td>". $bin_w[$k]."</td>";
	   echo "<td>".$bin_k[$k]."</td>";
   }
   
	 ///  compare and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$k],$j,1);
	  $k_bit[$j] = substr($bin_k[$k],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  =1;
	  }
	 $bin_e[$k] = $bin_e[$k].$e_bit[$j];
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$k] = sprintf('%03d',bindec($bin_e[$k]));

	if ($detail=='J'){
    echo  "<td>".$bin_e[$k]."</td> ";
	  echo  "<td>".$dec_e[$k]." </td>";	
	  echo  "<td>".chr($dec_e[$k])."</td></tr>";	
	 }
	 /// plak de chars tot een woord
	 $encrypt = $encrypt.chr($dec_e[$k]);
$k++;	
} /// end for i
	 
	 
	if ($detail=='J'){
	 echo "<tr><td colspan = 10>Het wachtwoord na decryptie is <span style='color:green;font-weight:bold;'>  ". htmlspecialchars($encrypt)."</span></td></tr>";
	 echo "</table>";
	}


}// end if	
?>


