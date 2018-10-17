<?php
if (isset($_POST['user_select'])){
	 header("Location: Inschrijfform.php?toernooi=".$toernooi."&user_select=Yes");
  }
  else {
   header("Location: Inschrijfform.php?toernooi=".$toernooi);
}
  	
header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'); /// ivm cookies in Iframe

ob_start();

$_vereniging = $_POST['select_vereniging'];

echo "xxxxxxxxxxxxxxxxxxxxxx". $_vereniging;

if (isset($_POST['speler1']) and    $_POST['speler1'] == 'yes'){
	setcookie ("vereniging1", $_vereniging, time() +5);
}
if (isset($_POST['speler2']) and    $_POST['speler2'] == 'yes'){
	setcookie ("vereniging2", $_vereniging, time() +5);
}
if (isset($_POST['speler3']) and    $_POST['speler3'] == 'yes'){
	setcookie ("vereniging3", $_vereniging, time() +5);
}
if (isset($_POST['speler4']) and    $_POST['speler4'] == 'yes'){
	setcookie ("vereniging4", $_vereniging, time() +5);
}
if (isset($_POST['speler5']) and    $_POST['speler5'] == 'yes'){
	setcookie ("vereniging5", $_vereniging, time() +5);
}
if (isset($_POST['speler6']) and    $_POST['speler6'] == 'yes'){
	setcookie ("vereniging6", $_vereniging, time() +5);
}

if (isset($_POST['allen']) and    $_POST['allen'] == 'yes'){
	setcookie ("vereniging1", $_vereniging, time() +5);
	setcookie ("vereniging2", $_vereniging, time() +5);
	setcookie ("vereniging3", $_vereniging, time() +5);
	setcookie ("vereniging4", $_vereniging, time() +5);
	setcookie ("vereniging5", $_vereniging, time() +5);
	setcookie ("vereniging6", $_vereniging, time() +5);
	
}
ob_end_flush();
?>