<?php
/// Conversie voor toernooi_voluit
$toernooi_voluit = preg_replace("/&euml/","�",  $toernooi_voluit);
$toernooi_voluit = preg_replace("/&#226/","�",  $toernooi_voluit);
$toernooi_voluit = preg_replace("/&#233/","�",  $toernooi_voluit);



// Conversie voor vereniging
$vereniging = preg_replace("/&#226/","�",  $vereniging);
$vereniging = preg_replace("/&#233/","�",  $vereniging);



// Conversie voor adres
$adres = preg_replace("/&ocirc/","�",  $adres);
$adres = preg_replace("/&rsquo/","'",  $adres);

?> 