<?php
header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();
include 'mysql.php'; 

$user = $_POST['user'];

mysql_query("Update namen set Laatst = now(),
                              IP_adres = '' ,
                              Aangelogd = 'N'
                       WHERE IP_adres = '". $_SERVER['REMOTE_ADDR']."' and Vereniging_id = ".$vereniging_id."  ");
// expire cookies to logoff

setcookie ("aangelogd", "", time() - 3600);
setcookie ("user", "", time() - 3600);

ob_end_flush();
?>
