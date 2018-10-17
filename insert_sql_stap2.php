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

$variabele     = $_POST['variabele'];
$waarde        = $_POST['waarde'];
$regelnr       = $_POST['regelnr'];
$destination   = $_POST['destination'];

//echo $destination;

if ($destination == "") {
	  die ("destination can't be spaces");
}	  



if ($variabele == "") {
	  die ("source  can't be spaces");
}	  


if ($regelnr == "") {
	  die ("regelnr  can't be spaces");
}	  

echo "<br><div style='border: 1pt solid red;width:400pt;color:yellow;padding:5pt;'>"; 

$sqlcmd = '';

foreach ($destination as $destination_item)
{
	
$sql        = mysql_query("SELECT Vereniging from config where Id ='".$destination_item."' ")     or die(' Fout in select');  
$result     = mysql_fetch_array( $sql );
$vereniging = $result['Vereniging'];

echo "<br><div style='border: 1pt solid red;width:400pt;color:yellow;padding:5pt;'>"; 
echo "destination  : ". $vereniging.  "<br>";  

$sql        = "SELECT  distinct Toernooi, Vereniging  from config  where Vereniging = (Select Vereniging from config where Id ='".$destination_item."'   )";
//echo $sql;
$namen      = mysql_query($sql);

while($row = mysql_fetch_array( $namen )) {

$sqlcmd  =  "INSERT into config (Id, Regel, Vereniging,Toernooi,Variabele, Waarde) 
              VALUES(0,".$regelnr.",'".htmlspecialchars_decode($row['Vereniging'],ENT_NOQUOTES)."','".$row['Toernooi']."','".$variabele."','".$waarde."');"; 
//echo $sqlcmd."<br>";
echo "INSERT Variable '".$variabele."' with value '".$waarde."' into toernooi '".$row['Toernooi']."'<br>" ;
 
mysql_query($sqlcmd) or die ('fout in insert'); 
}// end while toernooi namen	

echo  "</div>";
}// end for each	

//echo $sqlcmd;




echo  "</div>";

echo  "<h3>";
echo "* ". $count ." files copied to : " . $destination . "";
echo "</h3>";
?>
<a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a>
</body>
</html>