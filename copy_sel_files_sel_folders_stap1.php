<html>
<title>PHP Copy files</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TD {color:white ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
<head>
<body>


<?php
ob_start();
include 'mysql.php'; 

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
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

$source = '../boulamis' ;
$exten1  = 'php';
$exten2  = 'txt';
$exten3  = 'css';

$check_file   = 'N';
$check_doel   = 'N';

$check_file   =  $_GET['check1'];
$check_doel   =  $_GET['check2'];

// files not to copy
// Verwerk bestand               
$myFile = 'nocopyfiles.txt' ;    
//echo "Not copy : ". $myFile. "<br><br><hr/>";                                    
                                  

$not_copy = array();

                                  
$fh       = fopen($myFile, 'r');  
$naam     = fgets($fh);                  
$not_copy[]    = $naam;        



while ( $naam <> ''){      
//echo $naam;


$not_copy[]    = $naam;
$naam         = fgets($fh);
} /// while

fclose($fh);
	
$count =0;



if ($handle = @opendir($source)) 
{
    while (false !== ($file = @readdir($handle))) { 
        $bestand = $source ."/". $file ;
        $ext = pathinfo($bestand);
        if(IsSet($ext['extension']) && ($ext['extension'] == $exten1 or $ext['extension'] == $exten2 or $ext['extension'] == $exten3))
        {
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
<div style='border: white inset solid 1px; width:1250px; text-align: center;'>
<form method = 'post' action='copy_sel_files_sel_folders_stap2.php'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging ?>" /> 

<h3  style='padding:10pt;font-size:20pt;color:green;text-align:center;'>Copy selected files</h3>
<div Style='font-family:comic sans ms,sans-serif; color:red;font-size:12pt;'>Selecteer files en doel folder(s)</div><br/><br/>

<div style='border: green inset solid 1px; width:1250px; text-align: left;'>


<table >
<tr><td width='250' STYLE ='background-color:white;color:red;'><label>Files  </label></th>
	
	<?php if ($check_doel == 'J'){  ?>
	<th STYLE ='background-color:blue;color:white;'>	<a style= 'text-decoration:none;color:white;' href= 'copy_sel_files_sel_folders_stap1.php?check1=J&check2=J' >Select all</a></th>
  <?php } else {?>
	<th STYLE ='background-color:blue;color:white;'>	<a style= 'text-decoration:none;color:white;' href= 'copy_sel_files_sel_folders_stap1.php?check1=J&check2=N' >Select all</a></th>
  <?php } ?>
	<?php if ($check_doel == 'J'){  ?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a style= 'text-decoration:none;color:yellow;' href= 'copy_sel_files_sel_folders_stap1.php?check1=N&check2=J' >De-Select all</a></th>
  <?php } else {?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a style= 'text-decoration:none;color:yellow;' href= 'copy_sel_files_sel_folders_stap1.php?check1=N&check2=N' >De-Select all</a></th>
  <?php } ?>
	
	</tr><tr><td></td>

<input type='hidden' name ='source'   value ='../boulamis'/>
<input type='hidden' name ='extentie' value ='php'/>

<?php
$source = '../boulamis' ;
$exten  = 'php';
echo "Bron: ". $source."<br>";


$i=-1;
foreach ($file_list as $file){
	

 if (array_search($file, $not_copy) == 0 ){
	
    if ($i==2){
    	?>
       </tr><tr><td></td>
         <?php
           $i=0;
         }
    	else {
    	  	$i++;
    }
    
    if($check_file == 'J'){  ?>
     <td width='350'STYLE ='background-color:white;color:blue;font-size:9pt;'><input type ='checkbox'  name ='file[]' value ='<?php echo $file; ?>' checked><?php echo $file; ?></td>
      <?php } else {?>
       <td width='350'STYLE ='background-color:white;color:blue;font-size:9pt;'><input type ='checkbox'  name ='file[]' value ='<?php echo $file; ?>'><?php echo $file; ?></td>
      <?php } 
     } // not_copy file		
	
} // for each

?>


</tr>
</table>
</div>
<br><br>

<div style='border: green inset solid 1px; width:1450px; text-align: left;'>
<table >
<tr><td width='250'STYLE ='background-color:white;color:red;'><label>Doel</label></th>
	
	<?php if ($check_file == 'J'){  ?>
	<th STYLE =background-color:blue;color:white;'>	<a style= 'text-decoration:none;color:white;' href= 'copy_sel_files_sel_folders_stap1.php?check1=J&check2=J' >Select all</a></th>
  <?php } else {?>
	<th STYLE =background-color:blue;color:white;'>	<a style= 'text-decoration:none;color:white;' href= 'copy_sel_files_sel_folders_stap1.php?check1=N&check2=J' >Select all</a></th>
  <?php } ?>
	<?php if ($check_file == 'J'){  ?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a style= 'text-decoration:none;color:yellow;' href= 'copy_sel_files_sel_folders_stap1.php?check1=J&check2=N' >De-Select all</a></th>
  <?php } else {?>
	<th STYLE ='background-color:red;color:yellow;' colspan=2>	<a style= 'text-decoration:none;color:yellow;' href= 'copy_sel_files_sel_folders_stap1.php?check1=N&check2=N' >De-Select all</a></th>
  <?php } ?>
	
	</tr><tr><td></td>

	
	<?php
	
	$j=0;
	
	echo "<tr>";
	
	
	while($row = mysql_fetch_array( $namen )) {
		
		echo "<td></td><td STYLE ='background-color:white;color:black;font-size:9pt;'>";
		
		
		if ($check_doel == 'J'){ 
		
		echo "<input type ='checkbox'  name ='destination[]' value ='".$row['Prog_url']."' checked>".$row['Vereniging']."</td>";
	 } else {
		
		echo "<input type ='checkbox'  name ='destination[]' value ='".$row['Prog_url']."'>".$row['Vereniging']."</td>";
	 } // end if
		
		/// Kolommen
	if ($j==2){
		 $j=0;
		 echo"</tr><tr>";	
		 }  else { $j++;
	}	
		
	}// end while	
	?>	
		
		
<tr><td></td><td STYLE ='background-color:white;color:red;font-size:9pt;'><input type ='checkbox'  name ='destination[]' value ='../temp'>temp</td></tr>
<tr><td></td><td STYLE ='background-color:white;color:red;font-size:9pt;'><input type ='checkbox'  name ='destination[]' value ='../ontip/backup'>Backups</td></tr>

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
