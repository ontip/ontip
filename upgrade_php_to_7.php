<?php
# upgrade_php_to_7.php
# Tool om php progarmma te migreren naar PHP 7.
# Gemigreerd bestand qwodt gekopieerd naar foilder php7
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 7jan2019            -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              changed
# Feature:          None
# Reference: 

$php_bron_file = $_GET['bron'];
$php_doel_file = 'php7/'.$php_bron_file;

$fp       = fopen($php_doel_file, "w");
fclose($fp);

$url = "";

$homepage = file_get_contents($php_bron_file);

if (filesize($php_bron_file) ==0 ){

	$error = 1;
	  $message  .= "\n"."* Fout in kopieren bestand : ". $php_bron_file ." ! <br>";
 
  }

/// Toon foutmeldingen

if ($error == 1){
  echo "<br><div style='border: 1pt solid black;padding:10pt;font-size:12pt;font-weight:bold;color:red;margin:25pt;'>"; 
  echo "Er zijn een of meer fouten gevonden bij het inlezen : <br><br>";
	echo $message . "<br>";
	echo "</div>"; 
  //exit;
 }
 
 
/// replace


$homepage = str_replace('mysql.php','mysqli.php', $homepage);
$homepage = str_replace('aanlog_check.php','aanlog_checki.php', $homepage);
$homepage = str_replace('mysql_','mysqli_', $homepage);
$homepage = str_replace('mysqli_query(','mysqli_query($con,', $homepage);


// Kopieer inhoud bestand  naar doel_file
file_put_contents($php_doel_file,$homepage);


if ($error == 0){
  echo "<br><div style='border: 1pt solid black;padding:10pt;font-size:12pt;font-weight:bold;color:red;margin:25pt;'>"; 
  echo "<h1>Migratie naar PHP 7</h1>";
  echo "Bestand is succesvol gemigreerd : <br><br>";
	echo $php_doel_file . "<br>";
	echo "</div>"; 
  //exit;
 }
 	
 	