<html>
<title>PHP Copy files</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:#990000}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:white ;background-color:#990000; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:yellow ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
<head>
<body>


<?php
ob_start();
include 'mysql.php'; 

/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

 ?>

<div style='border: red solid 1px;background-color:#990000;'>
<table STYLE ='background-color:#990000;'>
<tr><td rowspan=3><img src = '<?php echo $url_logo?>' width='<?php echo $grootte_logo?>'></td>
<td STYLE ='font size: 40pt; background-color:#990000;color:orange ;'>Toernooi inschrijving <?php echo $vereniging ?></TD></tr>
<td STYLE ='font size: 15pt; background-color:#990000;color:white ;'>Programma voor diverse soorten selecties en lijsten.</TD>
</TR>
</TABLE>
</div>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>

<?php
ob_start();



$sql        = "SELECT Vereniging, Toernooi from config group by Vereniging, Toernooi order by Vereniging  ";
//echo $sql;
$namen      = mysql_query($sql);

?>

<br><br>
<center>
<div style='border: white inset solid 1px; width:1000px; text-align: center;'>
<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<h3  style='padding:10pt;font size=20pt;color:orange;text-align:center;'>Controleer config file op dubbele records</h3>
</div><br/><br/>

<div style='border: white inset solid 1px; width:950px; text-align: left;color:white;'>

<?php
	
	while($row = mysql_fetch_array( $namen )) {
		
		echo " <b>".$row['Toernooi']." - ".$row['Vereniging']."</b><br> ";
		
		$sql1    = "SELECT DISTINCT Variabele from config where Toernooi = '".$row['Toernooi']."' and Vereniging ='".$row['Vereniging']."' order by Variabele ";
		$result1 = mysql_query($sql1);
    $count1  = mysql_num_rows($result1);
    
    $sql2    = "SELECT * from config where Toernooi = '".$row['Toernooi']."' and Vereniging ='".$row['Vereniging']."' order by Variabele ";
		$result2 = mysql_query($sql2);
    $count2  = mysql_num_rows($result2);
    
    $sql3    = "SELECT Id,Regel, Variabele,Max(Id) as Max from config where Variabele in (SELECT Variabele from  config where Toernooi = '".$row['Toernooi']."' and Vereniging ='".$row['Vereniging']."' 
                GROUP BY Variabele HAVING COUNT(Vereniging) > 1) and Toernooi = '".$row['Toernooi']."' and Vereniging ='".$row['Vereniging']."' Order by Variabele ";
                
    //echo $sql3."<br>";            
    $result3 = mysql_query($sql3);     
    $count3  = mysql_num_rows($result3);         
    
       	       
    ///  Toon de duplicate variabele en verwijder alle records waarvan het Recid kleiner dan de hoogst gevonden  
     while($row3 = mysql_fetch_array( $result3 )) {
      
         If ($row3['Variabele'] != ''){
         echo "<span style='color:yellow;padding-left:10pt;'>  -> Variabele : ".$row3['Variabele']. "<br></span>";
         mysql_query("DELETE FROM config where Variabele = '".$row3['Variabele']."' and Toernooi = '".$row['Toernooi']."' and Vereniging ='".$row['Vereniging']."' and Id < ".$row3['Max'] ."") or die(' Fout in delete');  
          }//// end if
      }//// end while
    		
	}// end while	
	?>	
		
		
</center></div>
<br><br><a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>

</div>
</body>
</html>
