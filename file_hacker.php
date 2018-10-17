<html>
	<Title>File hacker</title>
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

$dir  = $_GET['dir'];


ini_set('default_charset','UTF-8');

$i=1;                        // intieer teller 
$k=0;

  echo "<h1>File hacker - ".$dir."</h1>";

  echo "<table width = 70% border =1 ><tr>";
  echo "<th width = 15>Nr</th>";
  echo "<th width = 15>Link</th>";
  echo "<th width = 100>Dir</th>";
  echo "<th>File</th>";
  echo "<th width = 25>Size</th>";
  echo "<th>Last mod</th>";
  echo "</tr>";

  	
	$j=1; 
  if ($handle = @opendir($dir)) 
    {
       while (false !== ($file = @readdir($handle))) { 
               
        if (strlen($file) > 3 ){    
        	$bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
 	
          echo "<tr><td>".$j.". </td><td><center><a href = '".$bestand."' target = '_blank'>open</a></center></td><td>".$dir."</td><td>".$file."</td><td style='text-align:right;'>".$filesize."</td><td style='text-align:right;'>".date("j/m/y h:i", $last_mod)."</td></tr>";       
          $j++;
         }
       }// end while filehandle
  @closedir($handle);     
  } // end if
	
	
	
	
	echo "</table>";
	
?>
</body>
</html>
	