<?php
// bepaal of mail adres (fragment) voorkomt in de mail blokkade tabel

function bepaal_mail_status($email_fragment){

$ip_adres   = $_SERVER['REMOTE_ADDR'];	

$email = explode($email_fragment ,'@');
$naam    = $email[0];
$domein  = "@".$email[1];

// Kontroleer op volledige naam

$sql      = mysqli_query($con,"SELECT * FROM mail_block  WHERE  Mail_adres_fragment  ='".$email_fragment."'  ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );
$count    = mysqli_num_rows($sql);

if ($count == 1){    //// precies 1 terug
	return $result['Block_reden'];
	exit;
}

// Kontroleer op domein

$sql      = mysqli_query($con,"SELECT * FROM mail_block  WHERE  Mail_adres_fragment  ='".$domein."'  ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );
$count    = mysqli_num_rows($sql);

if ($count == 1){   
	return $result['Block_reden'];
	exit;
}

$domein_ext = explode($email[1] ,'.');
$land       = $domein_ext[1];

// Kontroleer op land

$sql      = mysqli_query($con,"SELECT * FROM mail_block  WHERE  Mail_adres_fragment  ='".$land."'  ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );
$count    = mysqli_num_rows($sql);

if ($count == 1){    //// precies 1 terug
	return $result['Block_reden'];
	exit;
}

// alles goed
return;

} // end function

