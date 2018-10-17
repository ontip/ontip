<html>
	<Title>OnTip XML File browser</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH   {color:blue ;background-color:white; font-size: 9pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; }
Td   {color:black ;background-color:white; font-size: 9pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; }
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

?>
<h1> XML files tbv backup en restore</h1>
<?php

?>
<h2> XML files tbv configuratie</h2>
<?php

echo "<FORM action='delete_xml_file.php' method='post'>";
echo "<center><input style='color:black;font-size:10pt;text-align:center;'type='submit' name='submit' value='Verwijderen' /></center>"; 
echo "<table border = 1>";
echo "<tr><th>Nr</th><th>Vereniging</th><th>Open</th><th>Folder</th><th>Datum</th><th>File</th><th>Size</th><th>Creation time</th><th>Del</th></tr>";

$dir            = 'xml';
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}
	
	$j=1; 
$j=1; 
foreach ($files as $file) {
   	
                
        if (strlen($file) > 3 ){    
        	$bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
        	
        	$part = explode('_', $file);
        	
        	// cfg_4_2015-06-13_Rabobank_Randmeren.xml	
          $id    = $part[1];
          $datum = $part[2];
          if (strpos($datum, '-') < 1){
          	$datum = '';
          }
            
        //  echo $id;   
               	
        	$qry      = mysql_query("SELECT Vereniging from vereniging where Id = ".$id." ")     or die(' Fout in select 7'); 
         	$result        = mysql_fetch_array( $qry );
          $vereniging    = $result['Vereniging'];
        	
 	        if ($part[0] =='cfg'){
 	          echo "<tr><td>".$j.". </td><td>".$vereniging."</td><td><center><a href = '".$bestand."' target = '_blank'>open</a></center></td><td>".$dir."</td><td>".$datum."</td><td>".$file."</td>
 	          <td style='text-align:right;'>".$filesize."</td><td style='text-align:right;'>".date("d-m-Y H:i:s", $last_mod)."</td><td style='color:black;'>
 	           <input type='checkbox' name='Delete[]' value ='".$bestand."' unchecked></td></tr>";       
            $j++;      
          }
          
        }

  } // end foreach
	

	
	
echo "</table>";
echo "<center><input style='color:black;font-size:10pt;text-align:center;'type='submit' name='submit' value='Verwijderen' /></center>"; 
echo "</form>";

?>
<h2> XML files tbv inschrijvingen</h2>
<?php


echo "<FORM action='delete_xml_file.php' method='post'>";
echo "<center><input style='color:black;font-size:10pt;text-align:center;'type='submit' name='submit' value='Verwijderen' /></center>"; 
echo "<table border = 1>";
echo "<tr><th>Nr</th><th>Vereniging</th><th>Open</th><th>Folder</th><th>Datum</th><th>File</th><th>Size</th><th>Creation time</th><th>Del</th></tr>";

$dir            = 'xml';
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}	
$j=1; 
foreach ($files as $file) {
     	
          if (strlen($file) > 3 ){    
        	$bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
        	
        	$part = explode('_', $file);
      // ins_4_2015-06-13_Rabobank_Randmeren.xml	
          $id    = $part[1];
          $datum = $part[2];
          if (strpos($datum, '-') < 1){
          	$datum = '';
          }  	//echo $part[1];
               	
        	$qry      = mysql_query("SELECT Vereniging from vereniging where Id = ".$id." ")     or die(' Fout in select 7'); 
         	$result                    = mysql_fetch_array( $qry );
          $vereniging    = $result['Vereniging'];
        	
 	        if ($part[0] =='ins'){
 	     echo "<tr><td>".$j.". </td><td>".$vereniging."</td><td><center><a href = '".$bestand."' target = '_blank'>open</a></center></td><td>".$dir."</td><td>".$datum."</td><td>".$file."</td>
 	          <td style='text-align:right;'>".$filesize."</td><td style='text-align:right;'>".date("d-m-Y H:i:s", $last_mod)."</td><td style='color:black;'>
 	           <input type='checkbox' name='Delete[]' value ='".$bestand."' unchecked></td></tr>";       
            $j++;     }
          
          
          
         }
 
  } // end foreach
	

	
	
	echo "</table>";
echo "<center><input style='color:black;font-size:10pt;text-align:center;'type='submit' name='submit' value='Verwijderen' /></center>"; 
echo "</form>";


?>
</body>
</html>
	