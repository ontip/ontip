<?php
/// encrypten van wachtwoord

$detail     = $_GET['detail'];
$wachtwoord = $_GET['ww'];

$detail = "J";
$key_string = "R0048965999954265316abc5432189765";
$encrypt    = '';
$key_index  = substr($key_string,1,3);


if (isset($_GET['ww'])){


if ($detail=='J'){
  echo "<h1>SYNCHRONE VERSLEUTELING   (c) Erik Hendrikx 2011</h1>";
  echo "<table border = 1><tr> ";
   echo "<td colspan= 5>Wachtwoord :<br><b>".$wachtwoord."</b></td><td colspan= 5>Sleutel :<br><span style='color:blue;font-weight:bold;'>". $key_string." Key index : ". $key_index."</span></td></tr>";
  echo "<tr><th>Pos</th><th>WW<br>Char</th><th>Key<br>Char</th><th>ASCII<br>WW</th><th>ASCII<br>Key</th><th>BIN WW</th><th>BIN Key</th><th>BIN<br>compare</th><th>Encrypt<br>ASCII</th><th>Encrypt<br>Char</th></tr>";
 } 
 
$len = strlen($wachtwoord);

for ($i=0;$i<$len;$i++){
	
	// conversie letter naar ascii waarde
   $z        = $i+$key_index;
	 $asc_w[$i]= ord(substr($wachtwoord,$i,1));
	 $asc_k[$i]= ord(substr($key_string,$z,1));
	 
	 
	 if ($detail=='J'){
	 	echo "<tr><td>". 	 $i ."</td>";
	 	echo "<td>". substr($wachtwoord,$i,1) ."</td>";
		echo "<td>". substr($key_string,$z,1) ."</td>";
	  echo "<td>".$asc_w[$i]."</td>";
    echo "<td>".$asc_k[$i]."</td>";
	 }
	 
	 // conversie ascii waarde letter naar binary waarde
	 $bin_w[$i] = decbin($asc_w[$i]);
	 $bin_k[$i] = decbin($asc_k[$i]);
	 
	 // add leading zero to bin to len 8
	 $bin_w[$i] = sprintf('%08d', decbin($asc_w[$i]));
	 $bin_k[$i] = sprintf('%08d', decbin($asc_k[$i]));
	 
	 if ($detail=='J'){
	   echo"<td>". $bin_w[$i]."</td>";
	   echo "<td>".$bin_k[$i]."</td>";
   }
   
	 ///  compare and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$i],$j,1);
	  $k_bit[$j] = substr($bin_k[$i],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  =1;
	  }
	 $bin_e[$i] = $bin_e[$i].$e_bit[$j];
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$i] = sprintf('%03d',bindec($bin_e[$i]));

	if ($detail=='J'){
    echo  "<td>".$bin_e[$i]."</td> ";
	  echo  "<td>".$dec_e[$i]." </td>";	
	  echo  "<td>".chr($dec_e[$i])."</td></tr>";	
	 }
	 /// plak de chars tot een woord
	 $encrypt = $encrypt.chr($dec_e[$i]);
	 $asc_string = $asc_string.$dec_e[$i];
} /// end for i
	 
	  
	if ($detail=='J'){
	 echo "<tr><td colspan =10 >Het wachtwoord na encryptie is <span style='font-weight:bold;'>". htmlspecialchars($encrypt)."</span><span style='color:green;font-weight:bold;'>   (".$asc_string.")</span></td></tr>";
	 echo "</table>";
	}
	
echo "<a href='calculate_back.php?ww=". $asc_string."'>Klik hier voor terugberekening.</a><br>"; 	

}// end if	
?>


