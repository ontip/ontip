<?php
//// zet diakrtische tekens om in code reeks tbv sql selectie
function chg_text ($text) {
  $text = str_replace("�", '&#226;', $text); //�
  $text = str_replace("�", '&#235;', $text); //�
  $text = str_replace("�", '&#232;', $text); //�
  $text = str_replace("�", '&#233;', $text); //�
 
 return $text;
 }
 ?>
 
 
