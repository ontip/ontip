<?php
$source_file = 'somefile.txt';
$destination_file = 'readme.txt';

include('mysqli.php');


$ftp_server    = 'ftp.boulamis.nl';
$ftp_user_name= $username;
 
 //echo $username;
 
$ftp_user_pass =$password;


// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
// check connection and login result
if ((!$conn_id) || (!$login_result)) {
       echo "FTP connection has encountered an error!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name....";
       exit;
   } else {
       echo "Connected to $ftp_server, for user $ftp_user_name".".....";
   }
   
   
// upload a file

$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);

 
// check the upload status
if (!$upload) {
       echo "FTP upload has encountered an error!";
   } else {
       echo "Uploaded file with name $file to $ftp_server ";
   }
   

// close the connection
ftp_close($conn_id);
?> 