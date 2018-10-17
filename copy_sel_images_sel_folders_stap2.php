<html>
<title>PHP Copy files</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:yellow ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:#990000}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:#990000; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:yellow ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
<head>
<body>
<div style='border: red solid 1px;background-color:#990000;'>
<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo; ?>' width='<?php echo $grootte_logo; ?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
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


if ($exten == "") {
	  die ("extention can't be spaces");
}	  



foreach ($destination as $destination_item)
{
echo "<br><div style='border: 1pt solid red;width:400pt;color:yellow;padding:5pt;'>"; 
echo "Source       : ". $source. "/images/*.". $exten. "<br>";  
echo "destination  : ". $destination_item. "/*.". $exten. "<br>";  


// copy command
$count =0;
foreach ($file as $source_file)
{
            $from = $source."/images/".$source_file;
        	  $to   = $destination_item. "/".$source_file;

  	 
  	  if (!copy( $from,$to )) {
        	   echo "Failed to copy ". $source_file. "<br>";
     	  }
       	  else {
       	  	echo "File ". $source_file. "  copied. <br>";
      	  	$count++;
      	  }


}// for each file
echo  "<h3>";
echo "* ". $count ." files copied to : " . $destination_item . "";
echo "</h3>";
echo  "</div>";

}// for each destination
?>
<a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>
</body>
</html>