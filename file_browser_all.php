<html>
	<Title>OnTip File browser Ontip</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH   {color:blue ;background-color:white; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; padding:5pt;}
Td   {color:black ;background-color:white; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif; Font-Style:Bold;text-align: left; padding:5pt;}
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
                            
                             
$id    = $_GET['ontip_id'];      


function file_count($dir) {

	$count=0;
  if ($handle = @opendir($dir)) 
    {
       while (false !== ($file = @readdir($handle))) { 
               
        if (!is_dir($file) ){    
          $count++;
         }
       }// end while filehandle
  @closedir($handle);     
  } 
  return $count;
}


if ($id=='all'){ 
//// SQL Queries
$qry      = mysql_query("SELECT * from vereniging order by Id" )    or die(mysql_error());  
} else  {	
$qry      = mysql_query("SELECT * from vereniging where Id = ".$id."  " )    or die(mysql_error());  
}
 
   echo "<h1>File browser </h1>";

  echo "<table width = 70% border =1 style='border:2px solid #000000;box-shadow: 10px 10px 5px #888888;' cellpadding=0 cellspacing=0><tr>";
  echo "<th  >Nr</th>";
  echo "<th  >Id</th>";                                                                
  echo "<th  >Vereniging</th>";
  echo "<th  >Folder</th>";
  echo "<th  >Aantal</th>";
  echo "</tr>";

  /// prog url
  $i=1;
while($row = mysql_fetch_array( $qry )) {
	
	
	$prog_url       = $row['Prog_url'];
	$dir            = substr($prog_url, 0,strlen($prog_url)-1);
	if ($row['Id']==4){
	   $dir= '../boulamis';
	}
	

	?>
	<tr>
		<td rowspan =4 style='text-align:right;'><?php echo $i;?></td>
		<td rowspan =4 style='text-align:right;'><?php echo $row['Id'];?></td>
		<td rowspan =4 ><?php echo $row['Vereniging'];?></td>
		<td><?php echo $dir;?></td>
		
		
 <?php
		if ( file_count($dir)  < 100){?>
		   <td style='text-align:right;color:red;'><?php echo file_count($dir);?></td>
		<?php } else { ?>
	   <td style='text-align:right;color:darkgreen;'><?php echo file_count($dir);?></td>                                           	
		<?php } ?>        
</tr> 

 <?php
   $dir = $dir."/images";
	if ($row['Id']==4){
	$dir= '../boulamis/images';
	}
	?>
	
	<tr>
		<td><?php echo $dir;?></td>
		
    <?php
		if ( file_count($dir)  < 10){?>
		   <td style='text-align:right;color:red;'><?php echo file_count($dir);?></td>
		<?php } else { ?>
	   <td style='text-align:right;color:darkgreen;'><?php echo file_count($dir);?></td>                                           	
		<?php } ?>        
	</tr>


<?php
   $dir   = substr($prog_url, 0,strlen($prog_url)-1);
	 $dir   =  $dir."/hussel";
	if ($row['Id']==4){
	$dir= '../boulamis/hussel';
	}
	?>
	
	<tr>
		<td><?php echo $dir;?></td>
		
    <?php
		if ( file_count($dir)  < 10){?>
		   <td style='text-align:right;color:red;'><?php echo file_count($dir);?></td>
		<?php } else { ?>
	   <td style='text-align:right;color:darkgreen;'><?php echo file_count($dir);?></td>                                           	
		<?php } ?>        
	</tr>


<?php
   $dir = $dir."/images";
	
	?>
	
	<tr>
		<td><?php echo $dir;?></td>
		
    <?php
		if ( file_count($dir)  < 10){?>
		   <td style='text-align:right;color:red;'><?php echo file_count($dir);?></td>
		<?php } else { ?>
	   <td style='text-align:right;color:darkgreen;'><?php echo file_count($dir);?></td>                                           	
		<?php } ?>        
	</tr>












		
<?php 
$i++;
} ?>
</body>
</html>
	