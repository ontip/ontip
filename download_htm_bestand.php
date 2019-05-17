<?php
ob_start();

////  download_htm_bestand.php  (c) Erik Hendrikx 2012 ev
////
////
////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Database gegevens voor username en password
include('mysqli.php');


echo $_POST['server']."<br>";
echo $_POST['html_file']."<br>";

$ftp_server       = $_POST['server'];
$max_file_size    = $_POST['max_file_size'];
$ftp_user_name    = $username;
$ftp_user_pass    = $password;

echo $username."<br>";


$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login    = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);

$local_file  = $_POST['html_file'];
$server_file = $_POST['html_file'];


// download server file
if (ftp_get($ftp_conn, $local_file, $server_file, FTP_ASCII))
  {
  echo "Successfully written to $local_file.";
  }
else
  {
  echo "Error downloading $server_file.";
  }

// close connection
ftp_close($ftp_conn);

ob_end_flush();
?>
