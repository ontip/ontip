<?php
// versleutel licentie

function versleutel_licentie($waarde, $richting, $delta)
{
	
	if ($richting =='encrypt'){
	
$encrypt_waarde = '';
for ($l=0;$l<strlen($waarde);$l++){
$char = substr($waarde,$l,1);
// conversie letter naar ascii waarde
$ascii = ord($char);
// verhoog ascii waarde met 10;
$encrypt_waarde = $encrypt_waarde . chr($ascii+$delta);
}// end len 
/// return string encrypte waarde

return $encrypt_waarde;
}
else {
$decrypt_waarde = '';
for ($l=0;$l<strlen($waarde);$l++){
$char = substr($waarde,$l,1);
// conversie letter naar ascii waarde
$ascii = ord($char);
// verlaag ascii waarde met 10;
$decrypt_waarde = $decrypt_waarde . chr($ascii-$delta);
}// end len 
/// return string dencrypte waarde

return $decrypt_waarde;
} // end if
} // end function
?>
