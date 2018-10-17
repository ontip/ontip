<?php
//// zet diakrtische tekens om in code reeks tbv sql selectie
function chg_text ($text) {
  $text = str_replace("â", '&#226;', $text); //â
  $text = str_replace("ë", '&#235;', $text); //ë
  $text = str_replace("è", '&#232;', $text); //è
  $text = str_replace("é", '&#233;', $text); //è
 
 return $text;
 }
 ?>
 
 
