<?php
// versleutel kenmerk. Omdat het allemaal getallen zijn delta eraf halen 

function versleutel_kenmerk($waarde, $richting, $delta)
{
	
	if ($richting =='encrypt'){
	
$encrypt_waarde = '';
for ($l=0;$l<strlen($waarde);$l++){
$char = substr($waarde,$l,1);
// conversie letter naar ascii waarde
$ascii = ord($char);
//echo "Char.".$char."<br>";
//echo "Ascii.".$ascii."<br>";
// verhoog ascii waarde met delta;
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
// verlaag ascii waarde met delta;
$decrypt_waarde = $decrypt_waarde . chr($ascii-$delta);
}// end len 
/// return string dencrypte waarde

return $decrypt_waarde;
} // end if
} // end function
?>
