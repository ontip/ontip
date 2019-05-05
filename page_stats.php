<?php
//$pageName = basename($_SERVER['SCRIPT_NAME']);
//$pageName = $_COOKIE['page'];
//echo $pageName;
///include ('mysql.php');
/// Haal browser en OS van de PC op
$_browser     = 'onbekend';
$_os_platform = 'onbekend';
$ip_adres     = $_SERVER['REMOTE_ADDR'];
include ('get_browser_OS.php');

if ($_browser != 'Unknown Browser' and $_os_platform !='Unknown OS Platform') {  // internet bots
$query    = "INSERT INTO page_stats (Id, Vereniging, Vereniging_id,Page, Aantal, Browser, OS_platform, IP_adres, Laatst ) 
	                         VALUES (0, '".$vereniging."', ".$vereniging_id.",'".$pageName."',  1, '".$_browser."','".$_os_platform."','".$ip_adres."', now()  )";
//                         echo $query;

if (isset($con)){
mysqli_query($con,$query);  
} else {
	mysql_query($query);  
	
}
//
//php7


}

?>