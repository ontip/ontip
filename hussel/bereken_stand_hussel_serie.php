<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<style type="text/css" media="print">
body {color:blue;font-size: 9pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }

td {color:black;font-size: 9pt;}

th {color:blue;font-size: 9pt;}
h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:9pt;}       
.noprint {display:none;}     

#waarde    {text-align:right;color:blue;}
#hoogste   {text-align:right;color:blue;}
#laagste   {text-align:right;color:red;}
#laagste1  {text-align:right;color:black;}

#tot {text-align:right;color:black; font-weight:bold;}

.vertical {font-size: 9pt; Arial;writing-mode: tb-rl;color:blue;height:80pt;width:20pt;vertical-align:middle;}

.rotate {
			-ms-transform: rotate(90deg);
			-moz-transform: rotate(90deg);
			-webkit-transform: rotate(90deg);

			float:left;
			color:blue;
			height:100pt;
			width:20pt;
			{font-size: 9pt; 

}


</style>

<!---/// Mouse over voor aan/uit zetten images--->

<script type="text/javascript">
function img_uitzetten(i){
	      i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/homeoff.jpg";break;
        case 2:
           document.getElementById('print').src="images/printer.jpg";break;
        }
}

</script>

<script type="text/javascript">
function img_aanzetten(i){
        i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/home.jpg";break;    
        case 2:
           document.getElementById('print').src="images/printerleeg.jpg";break;  
         }
}

</script>
</head>
<body>
<?php
//// Database gegevens. 

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysql.php');

// datum vandaag
$vandaag = date ('Y')."-".date('m')."-".date('d');

// Schonen
$query = "DELETE FROM hussel_serie_scores where Vereniging_id = ".$vereniging_id." ";
mysql_query($query) or die ('Fout in schonen 1'); 

$query = "DELETE FROM hussel_serie_stand where Vereniging_id = ".$vereniging_id." ";
mysql_query($query) or die ('Fout in schonen 2'); 

//// Via lezen van datums hussel_serie  de scores voor de hussel ophalen

$sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 

   while($row = mysql_fetch_array( $sql_datums )) {

    $naam_serie    = $row['Naam_serie'];
    $_datum         = $row['Datum'];
      
    $sql_score  = mysql_query("SELECT * FROM hussel_score WHERE  Vereniging_id = ".$vereniging_id." and Datum = '".$row['Datum']."' order by Naam  ") or die(' Fout in select scores'); 
 
   while($row_score = mysql_fetch_array( $sql_score )) {

    $naam    = $row_score['Naam'];
    $_datum  = $row_score['Datum'];
    $score   = $row_score['Voor1']+$row_score['Voor2']+$row_score['Voor3']+$row_score['Voor4']+$row_score['Voor5'];
    $saldo   = $row_score['Saldo'];
     
   	$query   = "INSERT INTO hussel_serie_scores (Id, Vereniging, Vereniging_id, Naam_serie ,Datum, Naam, Score, Saldo, Laatst)
 	              VALUES ( 0, '".$vereniging."' ,".$vereniging_id." ,'".$naam_serie."','".$_datum."','".$naam."', ".$score.",".$saldo.", now()    )";   
 	//		echo $query;
 			mysql_query($query) or die ('Fout in insert hussel_serie_scores');   	 		


} // end while  row score
} //end while  datums

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// opmaak tabel met scores

$datums=array();
$d = 1;

   // datums tbv kopregel
      $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
         while($row = mysql_fetch_array( $sql_datums )) {
         	$naam_serie = $row['Naam_serie'];
  
     $datum[$d] = $row['Datum'];
    } // end while

/// detail regels per speler
 $i=1;
 
    $sql_score  = mysql_query("SELECT * FROM hussel_serie_scores WHERE  Vereniging_id = ".$vereniging_id." Group by Naam order by Saldo desc ") or die(' Fout in select scores'); 
         while($row_score = mysql_fetch_array( $sql_score )) {
         	
         	$aantal_dagen = 0;
         	$tot_saldo    = 0;
          $tot_score    = 0;

     $query        = "INSERT INTO hussel_serie_stand (Vereniging,Vereniging_id,Naam_serie,Naam) values ('".$vereniging."', ".$vereniging_id." ,'".$naam_serie."','".$row_score['Naam']."'  ) ";
 //    echo $query. "<br>";
     mysql_query($query) or die ('Fout in insert hussel_serie_stand');   	 		
    
     //Datums een voor een af gaan
     $datum_teller = 1;
     $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
     
      // kontroleer of de speler op die datum heeft meegedaan
     while($result = mysql_fetch_array( $sql_datums )) {

     $count = 0;
     
     $sql_score_speler_datum   = mysql_query("SELECT * FROM hussel_serie_scores WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$row_score['Naam']."'  and Datum = '".$result['Datum']."'   ") ;   
     $count       = mysql_num_rows($sql_score_speler_datum);	
     
       if ($count > 0){
          $result_score_speler_datum  = mysql_fetch_array( $sql_score_speler_datum );
          $score = $result_score_speler_datum['Score'];
          $saldo = $result_score_speler_datum['Saldo'];
         
          $aantal_dagen++;
          $tot_score = $tot_score+$score;
          $tot_saldo= $tot_saldo+$saldo;
          
       } else { 
     	   $score   = 0;
     	   $saldo   = 0;
       }	 // end if  count
       
        $query        = "UPDATE hussel_serie_stand set Score".$datum_teller." = '".$score."'  WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$row_score['Naam']."'    ";
        mysql_query($query) or die ('Fout in update hussel_serie_stand');   	 		
    
        $datum_teller++;
    
    } // end while sql datums per speler
        $query        = "UPDATE hussel_serie_stand set Totaal = '".$tot_score."' , Gespeeld = ".$aantal_dagen." WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$row_score['Naam']."'    ";
        mysql_query($query) or die ('Fout in update hussel_serie_stand');   	 		

 
    $i++;
  }// end spelers
  ?>

<!-------------------//////////////////  eind stand gesorteerd////////////////////////////////----------------->
<?php

$jaar  =  substr($datum, 0,4);
$maand =  substr($datum, 5,2);
$dag   =  substr($datum, 8,2);

  // bepaal naam serie

$sql  = mysql_query("SELECT Naam_serie FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." Limit 1 ") or die(' Fout in select naam serie'); 
$row = mysql_fetch_array( $sql );
$naam_serie = $row['Naam_serie'];

echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'images/OnTip_hussel.png' width='80'><br><span style='margin-left:15pt;font-size:10pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:10pt; text-shadow: 2px 2px darkgrey;'>Stand ". $naam_serie. " tm ".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1>";
echo "</table>";
?>

<table class='noprint'>
<tr>
	<td class='noprint' onclick="window.print()"><img src='images/printer.jpg' border =0 width = 50 alt= 'Print pagina'></td> 		
	<td class='noprint' onclick="window.location.href='hussel_serie_csv.php?datum=<?php echo $datum;?>'"><img src='images/icon_excel.png' border =0 width = 50 alt= 'Export naar Excel'></td> 		
<td valign='center' >
<a class='noprint'  href ='index.php'><img src='images/home.jpg' id='home' onmouseover='img_uitzetten(1)' onmouseout='img_aanzetten(1)' class='noprint' width=35 border='0' alt='Terug naar begin'></a>
</td></tr><tr>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Print<br>deze pagina</td>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Lijst naar<br>Excel</td>
<td class='noprint' Style='font-size:9pt;color:blue;text-align:center;padding:1pt;'>Terug<br>naar scores</td>
</tr>
</table>


<br>
<br>


<?php
 $sql_stand  = mysql_query("SELECT * FROM hussel_serie_stand WHERE  Vereniging_id = ".$vereniging_id." order by Totaal desc ") or die(' Fout in select scores'); 
 ?>

<center>
<table border = 1 cellpadding=0 cellspacing =0 width=94%>
 <tr>
 <?php
 $aantal_datums=0;
 $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <= '".$vandaag."' and Datum <>'0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
         while($row = mysql_fetch_array( $sql_datums )) {
         	$naam_serie = $row['Naam_serie'];
          $aantal_datums++;
       ?>
       <td style= 'font-size:9pt;padding:3pt;color:darkgreen;'><?php echo $aantal_datums.".".$row['Datum'];?></td>
      <?php } ?>
    </tr>
    </table>  
</center> 
 <br>
 
<table border = 1 width=98% cellpadding=0 cellspacing =0 style='padding:2pt;'>

 <tr >
 	 <th colspan = 2>
 	 	<th colspan = <?php echo $aantal_datums; ?> style='text-align:center;font-size:9pt;'>Hussels</th>
 	 <th colspan = 3 style='text-align:center;font-size:9pt;'>Totalen</th>
 	</tr>
 	<tr>	
 	
 	 <th style= 'font-size:9pt;'>Nr</th>
 	 <th style= 'font-size:9pt;'>Naam</th>

    <?php
   // datums tbv kopregel
   $aantal_datums=0;
      $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <= '".$vandaag."' and Datum <>'0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
         while($row = mysql_fetch_array( $sql_datums )) {
         	$naam_serie = $row['Naam_serie'];
          $aantal_datums++;
    ?> 
    <th style= 'font-size:9pt;width:15pt;text-align:right;padding:2pt;' ><?php echo $aantal_datums;?></th>
  <?php 
         } // end while
    ?>
     <th style= 'font-size:9pt;text-align:right;' >Gespld</th>
     <th style= 'font-size:9pt;'>Score</th>
    <th style= 'font-size:9pt;'>Saldo</th>
  </tr>

<?php
  $i=1;
  while($row_stand= mysql_fetch_array( $sql_stand )) {
?>
  <tr>
  	 <td style= 'font-size:9pt;'><?php echo $i; ?></td>
     <td style= 'font-size:9pt;'><?php echo $row_stand['Naam'];?></td>
     
    <?php
    // kontroleer of er al op deze datum gespeeld is
    
     for($j=1;$j<=$aantal_datums;$j++){
     	?>
     <td style= 'font-size:9pt;text-align:right;padding:2pt;'><?php echo $row_stand['Score'.$j];?></td>
     <?php
    }
    ?>
     <td style= 'font-size:9pt;text-align:right;''><?php echo $row_stand['Gespeeld'];?></td>
     <td style= 'font-size:9pt;text-align:right;''><?php echo $row_stand['Totaal'];?></td>
     
     <?php
     // bepaald einde saldo
         $sql_saldo  = mysql_query("SELECT SUM(Saldo) as Saldo FROM hussel_serie_scores WHERE  Vereniging_id = ".$vereniging_id." and Naam ='".$row_stand['Naam']."'  Group by Naam ") or die(' Fout in select saldo'); 
         $row_saldo  = mysql_fetch_array( $sql_saldo );
         ?>
         <td style= 'font-size:9pt;text-align:right;''><?php echo $row_saldo['Saldo'];?></td>
     
 </tr>
 
<?php
$i++;
 } // end while
?>
</table>


</body>
</html>
