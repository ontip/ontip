<html>
	<Title>Html Pagina hulp (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:red ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>

</head>

<body>
 
<?php
/// load ftp connectie parameters
include 'mysql.php'; 

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen
/*
if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=AV"';
echo '</script>';
}
*/

function getDirectory( $path = '.', $level = 0 ){

$ignore = array( 'cgi-bin', '.', '..', 'images','pdf', 'js' ,'css' ); 
// Directories to ignore when listing output. Many hosts 
// will deny PHP access to the cgi-bin. 

$dh = @opendir( $path ); 
// Open the directory to the handle $dh 

while( false !== ( $file = readdir( $dh ) ) ){ 
// Loop through the directory 

    if( !in_array( $file, $ignore ) ){ 
    // Check that this file is not to be ignored 

        $spaces = str_repeat( '&nbsp;', ( $level * 4 ) ); 
        // Just to add spacing to the list, to better 
        // show the directory tree. 

        if( is_dir( "$path/$file" ) ){ 
        // Its a directory, so we need to keep reading down... 

            echo "<strong>$spaces $file</strong><br />"; 
            getDirectory( "$path/$file", ($level+1) ); 
            // Re-call this same function but on a new directory. 
            // this is what makes function recursive. 

        } else { 

            echo "$spaces $file<br />"; 
            // Just print out the filename 

        } 

    } 

} 

closedir( $dh ); 
// Close the directory handle 
}


//getDirectory( "." ); 
// Get the current directory 

//getDirectory( "./files/includes" ); 
// Get contents of the "files/includes" folder 


 
                

// ---------------------------------------------------------------------------------------------------------------------------------------------------
?>
<table STYLE ='background-color:white;'>
<table >
   <tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'http://www.boulamis.nl/boulamis_toernooi/images/html_edit_logo.png' width='180'></td>
</TR>
</TABLE>

<hr color= red/>

Dit programma kan je helpen met het beheer van je website. Als je een pagina wilt aanpassen, haal deze over naar je PC (download) en pas deze aan mbv een edit programma.
Test de pagina m.b.v de browser op je PC. Als je tevredent bent over het resultaat,  kan je de aangepaste pagina naar de website kopieren (upload).

<h2>Bestanden op de website</h2>


<b> Selecteer een van de bestanden  : </b> &nbsp

<form action="download_htm_bestand.php" method="POST" >
<input type="hidden" name="server" value="ftp.boulamis.nl">
<input type="hidden" name="max_file_size" value=5000>



<?php

echo "<select name='html_file' STYLE='width: 240px;'>";
echo "<option value='' selected>Selecteer html pagina uit de  lijst</option>"; 


$ignore = array( 'cgi-bin', '.', '..', 'images','pdf', 'js' ,'css' ); 
// Directories to ignore when listing output. Many hosts 
// will deny PHP access to the cgi-bin. 
$path = '../amic2014/';


$dh = @opendir( $path ); 
// Open the directory to the handle $dh 

while( false !== ( $file = readdir( $dh ) ) ){ 
// Loop through the directory 

 $parts  =  explode (".", $file);
    $ext    =  $parts[1];
    $bak    =  $parts[2];
    
    if( !in_array( $file, $ignore ) and $ext == 'htm' and $bak == ''   ){ 
    	
    // Check that this file is not to be ignored 

        $spaces = str_repeat( '&nbsp;', ( $level * 4 ) ); 
        // Just to add spacing to the list, to better 
        // show the directory tree. 

        if( is_dir( "$path/$file" ) ){ 
        // Its a directory, so we need to keep reading down... 

/*            echo "<strong>$spaces $file</strong><br />"; 
            getDirectory( "$path/$file", ($level+1) ); 
            // Re-call this same function but on a new directory. 
            // this is what makes function recursive. 
*/
        } else { 

//            echo "$spaces $file<br />"; 
            echo "<OPTION value = '".$path.$file."' >".$file."</OPTION> ";
            
            
            // Just print out the filename 

        } 

    } 

} 

closedir( $dh ); 
// Close the directory handle 

?>
</select>
<INPUT type='submit' value='download'>


<h2>Prikbord bestanden op de website</h2>


Selecteer een van de bestanden 


<form action="download_htm_bestand.php" method="POST" >
<input type="hidden" name="server"        value="ftp.boulamis.nl">
<input type="hidden" name="max_file_size" value=5000>

<?php

echo "<select name='html_file' STYLE='width: 240px;'>";
echo "<option value='' selected>Selecteer html pagina uit de  lijst</option>"; 


$ignore = array( 'cgi-bin', '.', '..', 'images','pdf', 'js' ,'css' ); 
// Directories to ignore when listing output. Many hosts 
// will deny PHP access to the cgi-bin. 
$path = '../amic2014/prikbord/';


$dh = @opendir( $path ); 
// Open the directory to the handle $dh 

while( false !== ( $file = readdir( $dh ) ) ){ 
// Loop through the directory 

    $parts  =  explode (".", $file);
    $ext    =  $parts[1];
    $bak    =  $parts[2];
    
    if( !in_array( $file, $ignore ) and $ext == 'htm' and $bak == ''   ){ 
    // Check that this file is not to be ignored 

        $spaces = str_repeat( '&nbsp;', ( $level * 4 ) ); 
        // Just to add spacing to the list, to better 
        // show the directory tree. 

        if( is_dir( "$path/$file" ) ){ 
        // Its a directory, so we need to keep reading down... 

/*            echo "<strong>$spaces $file</strong><br />"; 
            getDirectory( "$path/$file", ($level+1) ); 
            // Re-call this same function but on a new directory. 
            // this is what makes function recursive. 
*/
        } else { 

//            echo "$spaces $file<br />"; 
             echo "<OPTION value = '".$path.$file."'>".$file."</OPTION> ";
            
            
            // Just print out the filename 

        } 

    } 

} 

closedir( $dh ); 
// Close the directory handle 

?>
</select>
<INPUT type='submit' value='download'>


</form>


<?php

if (isset($_GET['local_file'])){
$local_file   = $_GET['local_file'];
?>
<iframe src='<?php echo $_GET['local_file']; ?>' > </iframe>

<br>


<?php }
?>




<h2>Bestanden op de PC</h2>

<?php
$dir = $_POST['drive'];
$dir = 'D:'; 
$exten = 'doc';

echo "<FORM action='import_htm_betand.php' method='post'> <P>"; 
echo "<input type='hidden' name='drive' value='".$dir."' /> ";


echo "<table><tr>";
echo "<td  style='padding-right:12pt;'>";



echo "Selecteer bestand ";
echo "</td><td>"; 

echo "<select name='importfile' STYLE='width: 240px;'>";
echo "<option value='' selected>Selecteer bestand uit lijst</option>"; 
 	
if ($handle = @opendir($dir)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $bestand = $dir ."/". $file ;
        $ext = pathinfo($bestand);
        if(IsSet($ext['extension']) && $ext['extension'] == $exten)
        {
            echo "<OPTION>".$file."</OPTION <br> ";
 
        
        }
    }
    @closedir($handle); 
} 
?>

<INPUT type='submit' value='Upload'>

</form>


 	
 

</body>
</html>
