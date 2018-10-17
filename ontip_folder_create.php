<html>
	<Title>OnTip Change owner</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH   {color:blue ;background-color:white; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; }
Td   {color:black ;background-color:white; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; }
h1   {color:red ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2   {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3   {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {color:red ; font-size: 8.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>
</head>

<body>
<?php 
ob_start();

include('mysql.php');
ini_set('default_charset','UTF-8');
$id= $_GET['id'];

//// SQL Queries
$qry      = mysql_query("SELECT Vereniging, Url_redirect from vereniging where Id = ".$id."  " )    or die(mysql_error());  

if ($id !=''){

/// Detail regels per vereniging

$i=1;                        // intieer teller 
$k=0;

while($row = mysql_fetch_array( $qry )) {

  echo "<h1>".$row['Vereniging']."</h1>";
  
  /// www.ontip .nl
  //$url_hostName = $_SERVER['HTTP_HOST'];

  // redirect http://www.ontip.nl/boulesdeboeuf/

  /// prog url

	$url       = $row['Url_redirect'];
		
	// create dirs
	echo $url.'images'. "<br>";
	echo $url.'images/qrc'. "<br>";
	echo $url.'js'. "<br>";
	echo $url.'csv'. "<br>";
	
	$output = shell_exec('mkdir '.$url.'images');
	$output = shell_exec('mkdir '.$url.'images/qrc');
	$output = shell_exec('mkdir '.$url.'js');
	$output = shell_exec('mkdir '.$url.'csv');
	
	
}// end while qry
}


?>
</body>
</html>
	