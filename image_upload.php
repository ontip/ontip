
<?php 

/**************************************************************************************
 ***************************************************************************************       
 ***    <input type="file" name="imagefile">                              
***    with the above tag declared in the calling form                               
 ***    the variable name is $imagefile and the available properties are           
 ***    $imagefile :name of the file as stored on the temporary server directory   
 ***    $imagefile_name :filename.extension of the file as on the users machine     
 ***    $imagefile_size    :size in bytes of the file                                 
 ***    $imagefile_type    :the type of file image/gif image/jpg  text/html etc....   
 ***                                                                                 
 ***************************************************************************************
 **************************************************************************************/
 
//change these values to suit your site 
$ftp_user_name='boulamis'; 
$ftp_user_pass='but@3751'; 
$ftp_server='ftp.boulamis.nl'; 
$ftp_dir='http://www.boulamis.nl/boulamis_toernooi/images/'; 

/// tbv migratie
$url_hostName = $_SERVER['HTTP_HOST'];

// http://www.ontip.nl/

if ( $url_hostName =='www.boulamis.nl') {
     $hostname = "localhost"; 
     $username = "boulamis"; 
     $password = "But@3751"; 
     $database = "boulamis_db";
     $ftp_server='ftp.boulamis.nl'; 
     $ftp_dir='http://www.boulamis.nl/boulamis_toernooi/images/'; 

} else {
     $hostname = "localhost"; 
     $username = "ontipnlv"; 
     $password = "p9FV9VeY"; 
     $database = "ontipnlv_db";
     $ftp_server='ftp.ontip.nl'; 
     $ftp_dir='http://www.ontip.nl/ontip/images/'; 

}



//$web_location is needed for the file_exists function, the directories used by FTP
 //are not visible to it will always return not found. 

$web_dir='../images/'; 
$web_location=$web_dir.$imagefile_name; 

//build a fully qualified (FTP) path name where the file will reside 
$destination_file=$ftp_dir.$imagefile_name; 

// connect, login, and transfer the file 
$conn_id = ftp_connect($ftp_server); 
$login_result = ftp_login($conn_id, $username, $password); 
$upload = ftp_put($conn_id, $destination_file, $imagefile, FTP_BINARY); 

//use ftp_site to change mode of the file 
//this will allow it be visible by the world, 
$ch=ftp_site($conn_id,"chmod 777 ".$destination_file); 

// close the FTP stream 
ftp_close($conn_id); 

//verify file was written 
if (file_exists($web_location)) 
    { 
    echo "file was uploaded as $web_location"; 
    } 
else 
    { 
    echo "Could not create $web_location"; 
    } 
//end if 
?>