<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi

$_vereniging   = str_replace("&#226", "â", $vereniging);
$_vereniging   = str_replace("&#233", "é", $vereniging);
$_vereniging   = str_replace("&#234", "ê", $vereniging);
$_vereniging   = str_replace("&#235", "ë", $vereniging);
$_vereniging   = str_replace("&#239", "ï", $vereniging);
$_vereniging   = str_replace("&#39", "'",  $vereniging);
$_vereniging   = str_replace("&#206", "î'",$vereniging);

$_toernooi     = str_replace("&#226", "â", $toernooi);
$_toernooi     = str_replace("&#233", "é", $toernooi);
$_toernooi     = str_replace("&#234", "ê", $toernooi);
$_toernooi     = str_replace("&#235", "ë", $toernooi);
$_toernooi     = str_replace("&#239", "ï", $toernooi);
$_toernooi     = str_replace("&#39", "'",  $toernooi);
$_toernooi     = str_replace("&#206", "î", $toernooi_voluit);

//echo $vereniging . " - ". $_vereniging. "<br>";
//echo $toernooi .   " - ". $_toernooi. "<br>";

/////////////////////////////////////////////////////////////////////////////////////////////////////
?>
