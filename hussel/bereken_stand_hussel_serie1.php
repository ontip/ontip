<html>
	<head>
<style type='text/css'><!-- 
body {color:blue;font-size: 9pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:black;font-size: 10pt;vertical-align:bottom;}
td {color:black;font-size: 12pt;}

h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

#waarde    {text-align:right;color:blue;}
#hoogste   {text-align:right;color:blue;}
#laagste   {text-align:right;color:red;}
#laagste1  {text-align:right;color:black;}

#tot {text-align:right;color:black; font-weight:bold;}


#vertical {font-size: 12pt Arial;writing-mode: tb-rl;color:teal;height:80pt;width:20pt;vertical-align:middle;}

.verticaltext2{
font: 11px Arial;position: absolute;left: 43px;top: 15px;width: 15px;writing-mode: tb-rl;color:#CCFFFF;}

// --></style>

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


// Schonen
$query = "DELETE FROM hussel_serie_scores where Vereniging_id = ".$vereniging_id." ";
mysql_query($query) or die ('Fout in schonen 1'); 

$query = "DELETE FROM hussel_serie_stand where Vereniging_id = ".$vereniging_id." ";
mysql_query($query) or die ('Fout in schonen 2'); 


//// Via lezen van datums hussel_serie  de scores voor de hussel ophalen

$sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 


   while($row = mysql_fetch_array( $sql_datums )) {

    $naam_serie    = $row['Naam_serie'];
    $datum         = $row['Datum'];
       
    $sql_score  = mysql_query("SELECT * FROM hussel_score WHERE  Vereniging_id = ".$vereniging_id." and Datum = '".$row['Datum']."' order by Naam  ") or die(' Fout in select scores'); 
    

   while($row_score = mysql_fetch_array( $sql_score )) {

    $naam   = $row_score['Naam'];
    $datum  = $row_score['Datum'];
    
  
    $score  = $row_score['Voor1']+$row_score['Voor2']+$row_score['Voor3']+$row_score['Voor4']+$row_score['Voor5'];
    $saldo  = $row_score['Saldo'];
     
   	$query   = "INSERT INTO hussel_serie_scores (Id, Vereniging, Vereniging_id, Naam_serie ,Datum, Naam, Score, Saldo, Laatst)
 	              VALUES ( 0, '".$vereniging."' ,".$vereniging_id." ,'".$naam_serie."','".$datum."','".$naam."', ".$score.",".$saldo.", now()    )";   
 	//		echo $query;
 			mysql_query($query) or die ('Fout in insert hussel_serie_scores');   	 		


} // end while  row score


} //end while  datums

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// opmaak tabel met scores

$datums=array();
$d = 1;
?>

<table border = 1>

 <tr>
 	 <th>Nr</th>
 	 <th>Naam</th>

   <?php
   // datums tbv kopregel
      $sql_datums   = mysql_query("SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
         while($row = mysql_fetch_array( $sql_datums )) {
         	$naam_serie = $row['Naam_serie'];
         	
    ?> 
    <th><?php echo $row['Datum'];?></th>
  <?php 
     $datum[$d] = $row['Datum'];
    } // end while
    ?>
     <th>Gespeeld</th>
     <th>Score</th>
     <th>Saldo</th>
  </tr>

<?php
/// detail regels per speler
 $i=1;
 
    $sql_score  = mysql_query("SELECT * FROM hussel_serie_scores WHERE  Vereniging_id = ".$vereniging_id." Group by Naam order by Saldo desc ") or die(' Fout in select scores'); 
         while($row_score = mysql_fetch_array( $sql_score )) {
         	
         	$aantal_dagen = 0;
         	$tot_saldo    = 0;
          $tot_score    = 0;
    ?> 
    <tr>
     <td><?php echo $i; ?></td>
     <td><?php echo $row_score['Naam'];?></td>
     <?php
     
     $query        = "INSERT INTO hussel_serie_stand (Vereniging,Vereniging_id,Naam_serie,Naam) values ('".$vereniging."', ".$vereniging_id." ,'".$naam_serie."','".$row_score['Naam']."'  ) ";
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
    
    ?>
     <td><?php echo $score;?></td>
    <?php
    $datum_teller++;
    
    
    } // end while sql datums per speler
    
     // laatste waarden updaten per speler    
     $query        = "UPDATE hussel_serie_stand set Totaal = '".$tot_score."' , Gespeeld = ".$aantal_dagen." WHERE  Vereniging_id = ".$vereniging_id." and Naam = '".$row_score['Naam']."'    ";
     mysql_query($query) or die ('Fout in update hussel_serie_stand');   	 		

   ?>
    <td><?php echo $aantal_dagen;?></td>
    <td><?php echo $tot_score; ?></td>
    <td><?php echo $tot_saldo; ?></td>
    <?php
 
    $i++;
  }// end spelers
  ?>
</tr>
</table>


    
   















</body>
</html>
