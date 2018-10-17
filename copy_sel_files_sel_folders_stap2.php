<html>
<title>PHP Copy files</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 10pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:green ; font-size: 14.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
<head>
<body>
<div style='border: red solid 1px;background-color:white;'>
<table STYLE ='background-color:white;'>
<tr><td rowspan=3><img src = 'images/logo.png' width=300></td>
<td STYLE ='font-size: 40pt; background-color:white;color:red;'>OnTip beheer tool <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 15pt; background-color:white;color:blue;'>Programma om bestanden te distribueren.</TD>
</TR>
</TABLE>
</div>

<?php
ob_start();
include 'mysql.php'; 

//// Formulier tbv import of de namen of een filenaam tbv de import

$source      = $_POST['source'];
$file        = $_POST['file'];
$destination = $_POST['destination'];
$exten       = $_POST['extentie'];
$aantal_files = 0;
$aantal_dest = 0;


if ($exten == "") {
	  die ("extention can't be spaces");
}	  

foreach ($destination as $destination_item)
{
$aantal_dest++;

}
$aantal --;

echo "<br><h1><u>Bestanden :</u></h1>";

foreach ($file as $source_file)
{
$aantal_files++;
echo $aantal_files. ".".$source_file . "<br>";

}	

echo "<br>Aantal te kopieren bestanden: ". $aantal_files. "<br>";
echo "Aantal verenigingen         : ". $aantal_dest. "<br><hr><br>";
echo "<br>"; 

$vcount = 0;

foreach ($destination as $destination_item)
{
	
	//// SQL Queries
$qry      = mysql_query("SELECT Vereniging from vereniging   where Prog_url = '".$destination_item."'" )    or die(mysql_error());  
$row      = mysql_fetch_array( $qry);
$vereniging = $row['Vereniging'];

if ($vereniging !='Boulamis'){

$vcount++;

echo $vcount.". Vereniging     : ". $vereniging. "<br>";  
//echo "destination  : ". $destination_item. "/*.". $exten. "<br>";  


// copy command
$count =0;
$fcount =0;

foreach ($file as $source_file)

{
            $from = $source."/".$source_file;
        	  $to   = $destination_item. "/".$source_file;

  	 
  	  if (!copy( $from,$to )) {
        	   echo "Failed to copy ". $source_file. "<br>";
        	  	$fcount ++;

    	  }
  	  else {
 //        	  	echo "File ". $source_file. "  copied. <br>";
      	  	$count++;
  	  }


}// for each file

if ($count != $aantal_files){
echo  "<h3>";
echo "* ". $count ." files copied to : " . $destination_item . "";
echo "* ". $fcount ." files not copied to : " . $destination_item . "";
echo "</h3><hr color=white>";
}

} // geen Boulamis
}// for each destination
echo "<hr><br>*** Naar ".$vcount." verenigingen gekopieerd.<br>";
?>
<a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>
</body>
</html>