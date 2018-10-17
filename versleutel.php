<?php
/// encrypten van wachtwoord

$detail     = $_GET['detail'];
$wachtwoord = $_GET['ww'];

function versleutel($wachtwoord)
{
$key_string = "R0048965999954265316abc5432189765";
$encrypt    = '';
$key_index  = substr($key_string,1,3);
$asc_string = '';

$len = strlen($wachtwoord);


/// als lengte is groter dan 11 dan wordt gevraagd een wachtwoord te decrypten 
if ($len > 11) {
	
	$k   = 0 ;
// echo $len;

for ($i=0;$i<$len;$i=$i+3){
	
	// conversie letter naar ascii waarde
	 $z        = $k+$key_index;
	 $asc_w[$k]= substr($wachtwoord,$i,3);
	 $asc_k[$k]= ord(substr($key_string,$z,1));
		 
	 // conversie ascii waarde letter naar binary waarde
	 // add leading zero to bin to len 8
	 
	 $bin_w[$k] = sprintf('%08d', decbin($asc_w[$k]));
	 $bin_k[$k] = sprintf('%08d', decbin($asc_k[$k]));
	 $bin_e[$k] = '';
	   
	 ///  compare and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$k],$j,1);
	  $k_bit[$j] = substr($bin_k[$k],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {             /// vergelijk met sleutelwaarde
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  =1;
	  }
	 $bin_e[$k] = $bin_e[$k].$e_bit[$j];
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$k] = sprintf('%03d',bindec($bin_e[$k]));

	
	 /// plak de chars tot een woord
	 $encrypt = $encrypt.chr($dec_e[$k]);
$k++;	
} /// end for i
	
/// return encrypte waarde
return $encrypt;
		
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////
else {

for ($i=0;$i<$len;$i++){
	
	// conversie letter naar ascii waarde
	 $z        = $i+$key_index;
	 $asc_w[$i]= ord(substr($wachtwoord,$i,1));
	 $asc_k[$i]= ord(substr($key_string,$z,1));
	 
	 // conversie ascii waarde letter naar binary waarde
	 $bin_w[$i] = decbin($asc_w[$i]);
	 $bin_k[$i] = decbin($asc_k[$i]);
	 
	 // add leading zero to bin to len 8
	 $bin_w[$i] = sprintf('%08d', decbin($asc_w[$i]));
	 $bin_k[$i] = sprintf('%08d', decbin($asc_k[$i]));
	 
	 ///  compare bit by bit and create encrypted password
	 
	 for ($j=0;$j<8;$j++){
	   
	  $w_bit[$j] = substr($bin_w[$i],$j,1);
	  $k_bit[$j] = substr($bin_k[$i],$j,1);
	  
	  if ($w_bit[$j] == $k_bit[$j]) {
	    	$e_bit[$j]  = 0;}
	  	else {
	  	  $e_bit[$j]  = 1;
	  }
	 $bin_e[$i] = $bin_e[$i].$e_bit[$j];
	
	} // end for j
	
	// aanvullen met leading zero tot 3 lang
	$dec_e[$i] = sprintf('%03d',bindec($bin_e[$i]));

	
	 /// plak de chars tot een woord
	 $encrypt    = $encrypt.chr($dec_e[$i]);
	 $asc_string = $asc_string.$dec_e[$i];
	 
	 
} /// end for i
 
/// return decimale asc string encrypte ivm mogelijke HTML waarden

return $asc_string;

} // end function
}
?>


