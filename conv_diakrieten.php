<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi

$_vereniging   = str_replace("&#226", "�", $vereniging);
$_vereniging   = str_replace("&#233", "�", $vereniging);
$_vereniging   = str_replace("&#234", "�", $vereniging);
$_vereniging   = str_replace("&#235", "�", $vereniging);
$_vereniging   = str_replace("&#239", "�", $vereniging);
$_vereniging   = str_replace("&#39", "'",  $vereniging);
$_vereniging   = str_replace("&#206", "�'",$vereniging);

$_toernooi     = str_replace("&#226", "�", $toernooi);
$_toernooi     = str_replace("&#233", "�", $toernooi);
$_toernooi     = str_replace("&#234", "�", $toernooi);
$_toernooi     = str_replace("&#235", "�", $toernooi);
$_toernooi     = str_replace("&#239", "�", $toernooi);
$_toernooi     = str_replace("&#39", "'",  $toernooi);
$_toernooi     = str_replace("&#206", "�", $toernooi_voluit);

//echo $vereniging . " - ". $_vereniging. "<br>";
//echo $toernooi .   " - ". $_toernooi. "<br>";

/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
