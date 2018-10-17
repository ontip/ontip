<?php
//header("Location: ".$_SERVER['HTTP_REFERER'].""); 
function redirect($url) {
    if(!headers_sent()) {
        //If headers not sent yet... then do php redirect
        header('Location: '.$url);
        exit;
    } else {
        //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}
$vereniging_id   = $_POST['vereniging_id'];
$vereniging_naam = $_POST['vereniging_naam'];
$toernooi        = $_POST['toernooi'];
$id              = $_POST['id'];
$meerdaags_toernooi_jn  = $_POST['meerdaags_toernooi_jn '];
$url             = 'beheer_inschrijving_meerdaagse_datums.php?id='.$id;


include('mysql.php');
$datums =';';

for($i=1;$i<101;$i++){
	
	
	if (isset($_POST['datum_'.$i])){
		
		$datums =$datums.$_POST['datum_'.$i].";";
	}
	
	
}// end for


mysql_query("Update inschrijf set Meerdaags_datums = '".$datums. "'   where Id = ".$id." ") or die('Fout in update:'.$datums);
redirect($url);	
	

		?>			                   