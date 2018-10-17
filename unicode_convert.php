<?php
/// Conversie voor toernooi_voluit
$toernooi_voluit = preg_replace("/&euml/","ë",  $toernooi_voluit);
$toernooi_voluit = preg_replace("/&#226/","â",  $toernooi_voluit);
$toernooi_voluit = preg_replace("/&#233/","é",  $toernooi_voluit);



// Conversie voor vereniging
$vereniging = preg_replace("/&#226/","â",  $vereniging);
$vereniging = preg_replace("/&#233/","é",  $vereniging);



// Conversie voor adres
$adres = preg_replace("/&ocirc/","ô",  $adres);
$adres = preg_replace("/&rsquo/","'",  $adres);

?> 