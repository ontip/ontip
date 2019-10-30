<?php
/// encrypten van string  (begin altijd met @##)

function versleutel_string($_text)
{
	// key_string moet even lang zijn als max email 
$key_string = "R00489659994743393930384774774747474747477777777777779383939337861326361271327132781327813278132713271727132771327127127127127171777777777777737373717181871129726432954265316abc5432189765";
$encrypt    = '';
$key_index  = substr($key_string,1,3);
$asc_string = '';

$len = strlen($_text);
$pos =  '';
$pos = strpos($_text,"##");

// init arrays

$asc_w= [];
$asc_k= [];
$k_bit= [];
$w_bit= [];
$e_bit= [];
$bin_w= [];
$bin_k= [];
$bin_e= [];
$dec_e= [];


// bepaal richting van decrypt
if ($pos  != 1){
	

	$k   = 0 ;
// echo $len;

for ($i=0;$i<$len;$i=$i+3){
	
	// conversie letter naar ascii waarde
	 $z        = $k+$key_index;
	 $asc_w[$k]= substr($_text,$i,3);
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
	 $bin_e = '';
	$_text = substr($_text,3,$len-2);
// encrypt  (vanaf pos 3 ivm @##)
for ($i=0;$i<$len-3;$i++){
	
   // conversie letter naar ascii waarde
	 $z        = $i+$key_index;
	 $asc_w[$i]= ord(substr($_text,$i,1));
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
	  
	  
	  if (!isset($bin_e[$i])) {
	  	$bin_e[$i] ='';
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
} // end else
} // end function

/// test
/*
$text='@##erik.hendrikx@gmail.com';
echo "<br>".versleutel_string($text);

$encrypt = versleutel_string($text);
echo "<br>Terug: ".versleutel_string($encrypt);
*/

?>


