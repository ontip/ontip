<?php
/*************************************************************************
php convert string in html file
==========================================================================

*************************************************************************/
 
$dbfile = $_GET['html'];
// $dbfile  = 'testdiv.html';
 
 echo "<br> Convert ".$dbfile;
  
 if(!file_exists($dbfile)) {
die("Error: Data file " . $dbfile . " NOT FOUND!");
}
 
if(!is_writable($dbfile)) {
die("Error: Data file " . $dbfile . " is NOT writable! Please CHMOD it to 666!");
}

$file2= 'backup/'.$dbfile;
if (!copy($dbfile, $file2)) {
    echo "failed to copy $dbfile...\n";
}
file_put_contents($file2, str_replace("ontip.nl", "petanqueinschrijven.com", file_get_contents($dbfile)));



?>


   