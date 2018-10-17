<html>
<title>ONTIP Aanmaak nieuwe vereniging</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 10pt ; font-family: Comic sans, sans-serif;background-color:white}
a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

// --></style>
</head>
<body>
<div style='border: red solid 1px;background-color:white;'>
<table STYLE ='background-color:white;'>
<table >
   <tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
   	<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Aanmaak vereniging</TD>
</TR>
</TABLE>
</div>
<hr color= 'red'>
<?php 
ob_start();

// Database gegevens. 
include('mysql.php');

?>
<body>
<?php




if (isset ($_POST['sel_vereniging']) and $_POST['sel_vereniging'] != ''){
	$vereniging_nr  = $_POST['sel_vereniging'];
  $qry_n          = mysql_query("SELECT  * from namen  where Vereniging_nr = '".$vereniging_nr."' ") ;  
  $row            = mysql_fetch_array( $qry_n); 
	$verenigng      = $row['Vereniging'];
	$prog_url       = $row['Prog_url'];
	
}
else {
 $vereniging             = $_POST['vereniging'];
 $vereniging_nr          = $_POST['vereniging_nr'];
 $prog_url               = $_POST['url'];
 $plaats                 = $_POST['plaats'];
 $beheerder              = $_POST['beheerder'];
 $email                  = $_POST['email_beheerder'];
	
}

// insert in namen
//echo $vereniging_nr . "<br>";




if (isset ($_POST['delete_namen'])  and $_POST['delete_namen'] == 'Ja' and !isset($_POST['sel_vereniging']) ){
	
echo "delete started "; 	
$delete = "DELETE FROM namen where Vereniging_nr = '".$vereniging_nr."' ";
///mysql_query($delete) or die ('fout in delete namen');
} 

$insert = "insert into vereniging (Id, Vereniging,Vereniging_nr, Plaats,  Prog_url, Laatst, Aantal) VALUES (
                                        0,'".$beheerder."',  
                                        '".htmlentities($vereniging,ENT_QUOTES, 'UTF-8') ."',
                                        '".$vereniging_nr."',
                                        '".$plaats."',
                                        '".$email_beheerder."',
                                        '009011005001',
                                        'A',
                                        '".$prog_url."',
                                        NOW(),
                                        0) ";
//echo $insert. "<br>";
                                       
mysql_query($insert) or die ('fout in insert namen 1'); 




/// 2 beheerders

if (isset ($_POST['insert_namen']) and $_POST['insert_namen'] == 'Ja'){
	
$insert = "insert into namen (Id, Naam, Vereniging,Vereniging_nr, Plaats, Email, Wachtwoord,Beheerder, Prog_url, Laatst, Aantal) VALUES (
                                        0,'".$beheerder."',  
                                        '".htmlentities($vereniging,ENT_QUOTES, 'UTF-8') ."',
                                        '".$vereniging_nr."',
                                        '".$plaats."',
                                        '".$email_beheerder."',
                                        '009011005001',
                                        'A',
                                        '".$prog_url."',
                                        NOW(),
                                        0) ";
//echo $insert. "<br>";
                                       
mysql_query($insert) or die ('fout in insert namen 1'); 

$insert = "insert into namen (Id, Naam, Vereniging,Vereniging_nr,Plaats, Email, Wachtwoord,Beheerder, Prog_url,Laatst, Aantal) VALUES (
                                        0,'Erik',  
                                        '".htmlentities($vereniging,ENT_QUOTES, 'UTF-8') ."',
                                        '".$vereniging_nr."',
                                        '".$plaats."',
                                        'erik.hendrikx@gmail.com',
                                        '093075095094008000015008',
                                        'A',
                                        '".$prog_url."',
                                        NOW(),
                                        0) ";
mysql_query($insert) or die ('fout in insert namen 2');
//echo $insert. "<br>";
echo "Namen beheerders toegevoegd aan namen tabel. <br>";

}// end if


if (isset ($_POST['update_namen']) and $_POST['update_namen'] == 'Ja'){

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie bestand tbv verenigingsnaam

if ($vereniging_nr  == '') {
	$echo = "* Vereniging_nr is niet ingevuld<br>";
	$error = 1;
}


$myFile   = $prog_url.'myvereniging.txt';
$fh       = fopen($myFile, 'r');
$line     = fgets($fh);

while ( $line <> ''){


if (substr($line,0,1) == '$' ){

$pos = strpos($line, '=');

// Create variable (with $ sign), no spaces

$var = trim(substr($line,1,$pos-1));

// Set value to variable  trim for no spaces 
$$var = trim(substr($line,$pos+2,80));
 }

$line = fgets($fh);
} /// while

fclose($fh);

// update 


 $update = "UPDATE namen SET Url_website     = '".$url_website."' ,
                             Url_logo        = '".$url_logo."' ,
                             Grootte_logo    = '".$grootte_logo."' 
                       where Vereniging_nr   = '".$vereniging_nr."' ";
                             
 //  echo $update."<br>";
   
mysql_query($update) or die ('fout in update');
 
} 
  

$error       = 0 ;
$message     = '';

if (isset ($_POST['create_dirs']) and $_POST['create_dirs'] == 'Ja'){


////  slash eraf halen tbv verwerking
$prog_url =  substr($prog_url,0,strlen($prog_url)-1);
 
  
// Controles

if ($vereniging  == '') {
	$message .= "* Naam Vereniging is niet ingevuld<br>";
	$error = 1;
}

if ($prog_url  == '') {
	$message .= "* Naam url is niet ingevuld<br>";
	$error = 1;
}

if ($error ==0 ){



echo "<br><div style='border: 1pt solid red;width:400pt;color:black;padding:5pt;fomt-size:10pt;'>"; 
if (!mkdir($prog_url,0777)){
  echo "Directory ". $prog_url." not created!<br>";
}
else {
	echo "Directory ". $prog_url." created!<br>";
}

/// sub dir

$prog_url2 = $prog_url. "/js";
if (!mkdir($prog_url2,0777,true)){
  echo "Directory ". $prog_url2." not created!<br>";
  }
else {
	echo "Directory ". $prog_url2." created!<br>";
	
	$file = "popup.js";
	$from = "../ontip/js/".$file;
  $to   = $prog_url2. "/".$file;
  
 	if (!copy( $from,$to )) {
      echo "Failed to copy ". $file. "<br>";
   }
  	  else {
    	echo "File ". $file. "  copied. <br>";
   }

	
	$file = "utility.js";
	$from = "../ontip/js/".$file;
  $to   = $prog_url2. "/".$file;
 	if (!copy( $from,$to )) {
      echo "Failed to copy ". $file. "<br>";
   }
  	  else {
    	echo "File ". $file. "  copied. <br>";
   }
	
}

$prog_url3 = $prog_url. "/images";
if (!mkdir($prog_url3,0777,true)){
  echo "Directory ". $prog_url3." not created!<br>";
}
else {
	echo "Directory ". $prog_url3." created!<br>";
}

$prog_url4 = $prog_url. "/images/qrc";
if (!mkdir($prog_url4,0777,true)){
  echo "Directory ". $prog_url4." not created!<br>";
}
else {
	echo "Directory ". $prog_url4." created!<br>";
}

$prog_url6 = $prog_url. "/csv";
if (!mkdir($prog_url6,0777,true)){
  echo "Directory ". $prog_url6." not created!<br>";
}
else {
	echo "Directory ". $prog_url6." created!<br>";
}


} // error = 0 
} // is create dirs
echo "</div>"; 
?> 
<div style= font-size:12pt;color:red;font-weight:bold;'>Voor het kopieren van de bestanden dienen eerst de rechten van de folders aangepast te worden. Dan kan niet via een programma.<br><br>
<a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>


