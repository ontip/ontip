<html>
<title>PHP Copy images</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TD {color:white ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
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

$check_file   = 'N';
$check_doel   = 'N';

$check_file   =  $_GET['check1'];
$check_doel   =  $_GET['check2'];


/// Als eerste kontrole op laatste aanlog. Indien langer dan half uur geleden opnieuw aanloggen

if(!isset($_COOKIE['aangelogd'])){ 
echo '<script type="text/javascript">';
echo 'window.location = "aanlog.php?key=CI"';
echo '</script>';
}

// Verwerk bestand met files die niet getoond moeten worden              
$myFile = 'nocopyimages.txt' ;    
                                
$fh       = fopen($myFile, 'r');  
$naam     = fgets($fh);                  
$not_copy    = $naam;        

while ( $naam <> ''){      

$not_copy    .= $naam;
$naam         = fgets($fh);
} /// while

fclose($fh);
 


?>


<div style='border: red solid 1px;background-color:white;'>
<table STYLE ='background-color:white;'>
<tr><td rowspan=3><img src = 'images/ontip_logo.png' width=280></td>
<td STYLE ='font-size: 40pt; background-color:white;color:red;'>OnTip beheer tool <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 15pt; background-color:white;color:blue;'>Programma om bestanden te distribueren.</TD>
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

$source = '../boulamis_toernooi/images' ;
$exten  = 'php';

if ($handle = @opendir($source)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $bestand = $source ."/". $file ;
        $ext = pathinfo($bestand);
        
       // echo $file. "<br>";
       
        if (strlen($file)> 2 and strpos($not_copy,$file) == false ){
         //	echo $file."<br>";
        	$file_list[] = $file;
      	}
 
            }
    @closedir($handle); 
} 
/// sorteer file list
asort($file_list);

$sql        = "SELECT distinct Vereniging, Prog_url from vereniging where Prog_url <> '' order by Vereniging  ";
//echo $sql;
$namen      = mysql_query($sql);

?>

<br><br>
<center>
<div style='border: green inset solid 1px; width:1000px; text-align: center;'>
<form method = 'post' action='copy_sel_images_sel_folders_stap2.php'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<h3  style='padding:10pt;font size=20pt;color:red;text-align:center;'>Copy selected images</h3>
<div Style='font-family:comic sans ms,sans-serif; color:green;size:12pt;'>Selecteer files en doel folder(s)</div><br/><br/>

<div style='border: white inset solid 1px; width:950px; text-align: left;'>


<table >
<tr><td width='250'STYLE ='background-color:white;color:red;'><label>Images  </label></th>

<?php if ($check_doel == 'J'){  ?>
	<th STYLE ='background-color:blue;color:white;'>	<a href= 'copy_sel_images_sel_folders.php?check1=J&check2=J' >Select all</a></th>
<?php } else {?>
	<th STYLE ='background-color:blue;color:white;'>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=J&check2=N' >Select all</a></th>
<?php } ?>
	
<?php if ($check_doel == 'J'){  ?>
	<th STYLE ='background-color:red;color:yellow;'>	<a href= 'copy_sel_images_sel_folders.php?check1=N&check2=J' >De-Select all</a></th>
<?php } else {?>
	<th STYLE ='background-color:red;color:yellow;;'>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=N&check2=N' >De-Select all</a></th>
<?php } ?>
	
	
</tr><tr><td></td>

<input type='hidden' name ='source'   value ='../boulamis_toernooi'/>
<input type='hidden' name ='extentie' value ='php'/>

<?php
$source = '../boulamis_toernooi/images' ;
$exten  = 'php';

$i=-1;
foreach ($file_list as $file){

    if ($i==2){
    	?>
       </tr><tr><td></td>
       
       <?php       
         $i=0;
         }
    	else {
         $i++;
      }
      
      
  	if($check_file == 'J'  ){  
  		?>
  		
       <td width='250'STYLE ='background-color:white;color:black;font-size:9pt;'><input type ='checkbox'  name ='file[]' value ='<?php echo $file; ?>' checked><?php echo $file; ?></td>
      <?php } else {?>
       <td width='250'STYLE ='background-color:white;color:black;font-size:9pt;'><input type ='checkbox'  name ='file[]' value ='<?php echo $file; ?>'><?php echo $file; ?></td>
      <?php 
 
      }  /// end ifcheck
      
      } // end for each

?>
</tr>
</table>
</div>
<br><br>

<div style='border: green inset solid 1px; width:950px; text-align: left;'>
<table >
<tr><td width='250'STYLE ='background-color:white;color:red;'><label>Doel</label></th>

	<?php if ($check_file == 'J'){  ?>
	<th STYLE ='background-color:blue;color:white;'>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=J&check2=J' >Select all</a></th>
<?php } else {?>
	<th STYLE ='background-color:blue;color:white;'>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=N&check2=J' >Select all</a></th>
<?php } ?>
	
	<?php if ($check_file == 'J'){  ?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=J&check2=N' >De-Select all</a></th>
<?php } else {?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a href= 'copy_sel_images_sel_folders_stap1.php?check1=N&check2=N' >De-Select all</a></th>
<?php } ?>
	</tr><tr><td></td>
	
	<?php
	
	$j=0;
	
	echo "<tr>";
		
	while($row = mysql_fetch_array( $namen )) {
		
		echo "<td></td><td STYLE ='background-color:white;color:black;font-size:9pt;'>";
		
		if ($check_doel == 'J'){ 
				echo "<input type ='checkbox'  name ='destination[]' value ='".$row['Prog_url']."images/' checked>".$row['Vereniging']."</td>";
	   } else {
				echo "<input type ='checkbox'  name ='destination[]' value ='".$row['Prog_url']."images/'>".$row['Vereniging']."</td>";
	  } // end if
		
			/// Kolommen
	if ($j==2){
		 $j=0;
		 echo"</tr><tr>";	
		 }  else { $j++;
	}	
	
	
	}// end while	
	?>	
		
		
<tr><td></td><td STYLE ='background-color:white;color:black;font-size:9pt;'><input type ='checkbox'  name ='destination[]' value ='../temp'>temp</td></tr>
<tr><td></td><td STYLE ='background-color:white;color:black;font-size:9pt;'><input type ='checkbox'  name ='destination[]' value ='../boulamis_toernooi/backups'>Backups</td></tr>

</table><br><br>
</div>
<br><br>

<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
<br><br><a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a><br></div><br><br><br><br>

</div>
</body>
</html>
