<?php
# afloggen.php
# Reset aanlog op deze PC
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
#
# 18okt2018          1.0.1            E. Hendrikx
# Symptom:   		    None.
# Problem:       	  None.
# Fix:              Opgelost
# Feature:          None.
# Reference: 
#

header("Location: ".$_SERVER['HTTP_REFERER']);
ob_start();

include 'mysqli.php'; 
mysqli_query($con,"Update namen set Laatst = now(),
                              IP_adres = '' ,
                              Aangelogd = 'N'
                       WHERE IP_adres = '". $_SERVER['REMOTE_ADDR']."'   ");

// expire cookies to logoff
setcookie ("aangelogd", "", time() - 3600);
setcookie ("user", "", time() - 3600);

ob_end_flush();
?>
