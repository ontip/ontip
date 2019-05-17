<html>
<title>Insert Hussel  configuratie</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:white;background-color:blue; font-size: 9.0pt ; font-family:verdana; ;Font-Style:Bold;text-align: left; }
TD {color:black ;background-color:white; font-size: 9.0pt ; font-family:verdana ;padding-left: 11px;}
h1 {color:darkgreen ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:yellow ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>
<head>
<body>


<?php
ob_start();
include 'mysqli.php'; 

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
?>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>OnTip verenigingen</TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<a href='OnTip_verenigingen.php' style='font-size:9pt;color:blue;'>Terug naar overzicht</a>
<h1>Hussel configuratie</h1>

<br>
<?php
///// Kontrole op POST parameter

$vereniging_id ='';
if (isset($_POST['vereniging'])){
    $vereniging_id = $_POST['vereniging'];
}
	
	
if ($vereniging_id !=''){ 
	
$sql        = mysqli_query($con,"SELECT Vereniging from vereniging where Id = ".$vereniging_id."   ")     or die(' Fout in select 1');  
$result     = mysqli_fetch_array( $sql );
$vereniging = $result['Vereniging'];


$qry      = mysqli_query($con,"SELECT * from hussel_config where Vereniging_id =  ".$vereniging_id." and  Variabele = 'aantal_rondes'  " )    or die(' Fout in select 2');
$result     = mysqli_fetch_array( $qry );
$variabele = $result['Waarde'];


   if  ($variabele =='') {  
   	/*
   	            echo         "INSERT INTO `hussel_config` ( `Vereniging`, `Vereniging_id`, `Variabele`, `Waarde`, `Parameters`) VALUES
                                      ('".$vereniging."', ".$vereniging_id." , 'controle_13', 'Off', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'aantal_rondes', '3', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'datum_lock', 'Off', '6'),
                                      ('".$vereniging."', ".$vereniging_id." , 'voorgeloot', 'On', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'blokkeer_invoer', 'Off', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'baan_schemas', 'Off', '0'),
                                      ('".$vereniging."', ".$vereniging_id." , 'verwijderen_spelers', 'On', ''   ) <br>";               
         */                    
             $sql        = mysqli_query($con,"INSERT INTO `hussel_config` ( `Vereniging`, `Vereniging_id`, `Variabele`, `Waarde`, `Parameters`) VALUES
                                      ('".$vereniging."', ".$vereniging_id." , 'controle_13', 'Off', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'aantal_rondes', '3', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'datum_lock', 'Off', '6'),
                                      ('".$vereniging."', ".$vereniging_id." , 'voorgeloot', 'On', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'blokkeer_invoer', 'Off', ''),
                                      ('".$vereniging."', ".$vereniging_id." , 'baan_schemas', 'Off', '0'),
                                      ('".$vereniging."', ".$vereniging_id." , 'verwijderen_spelers', 'On', '')  ")   or die(' Fout in insert');  
                                                      
          
          //  Check
          $qry2      = mysqli_query($con,"SELECT * from hussel_config where Vereniging_id =  ".$vereniging_id." and  Variabele = 'aantal_rondes'  " )    or die(' Fout in select 3');
          $result2   = mysqli_fetch_array( $qry2);
          
           ?>
        	        	<div>Vereniging <?php echo $result2['Vereniging'];  ?> toegevoegd aan OnTip Hussel configuratie. </div>
        	<?php
          
          
        } else { ?>
        	
        	<div   style= 'color:red;font-size:12pt;'>Vereniging <?php echo $result['Vereniging'];  ?> maakt al gebruik van OnTip Hussel. </div>
        	<?php
   } // if  variabele
   exit;
}
else {
	
		
?>

<FORM action="insert_sql_hussel_conf.php" method="post" name = "myForm" >



<blockquote>
	<INPUT type='submit' value='Toevoegen hussel config' >
   <table  width=80% border =1>
   	<tr>
   	<th>Nr</th>
   	<th>Sel</th>
   	<th>Vereniging id</th>
   	<th>Vereniging</th>
   		<th>Hussel gebruiker</th>
  </tr>

<?php
	$i=1;
	$qry      = mysqli_query($con,"SELECT * from vereniging order by Id " )    or die(mysql_error());  
	
	while($row = mysqli_fetch_array( $qry )) {?>
	<tr>
   	<td><?php echo $i;?></td>	
   	<td><input type='radio' name='vereniging' value= '<?php echo $row['Id']; ?>'></td>
   	<td><?php echo $row['Id']; ?></td>		
  	<td><?php echo $row['Vereniging']; ?></td>		
  	<td><?php echo $row['Hussel_gebruiker']; ?></td>		
   	</tr>
  <?php
  $i++; 
  }  ?>
  	
   </table>

	<INPUT type='submit' value='Toevoegen hussel config' >
	</blockquote>
</form>
<?php

}
?>
</html>

