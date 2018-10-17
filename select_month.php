<?php
ob_start();

if (isset($_POST['Month'])) {
$month        = $_POST['Month']; 
}
if (isset($_POST['Year'])) {
$year         = $_POST['Year']; 
}


// oude wegknikkeren
setcookie ("_month",$month , time() -144000);
setcookie ("_year",$year , time() -144000);


// Aanmaken cookie ivm selectie maand

 setcookie ("_month", $month , time() +144000);
 setcookie ("_year",  $year , time() +144000);


if (isset($_POST['Month']) ) {
  header ( "Location: stats_maand.php"  ); 
echo "motn";
}


	
ob_end_flush();
?>


