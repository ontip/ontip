<?php

 ob_start();
include 'mysql.php'; 
?>
<?php
// ophalen aantal score regels
$count_score   = $_POST['count_score'];
$begin_waarde  = $_POST['begin_waarde'];
$max_updates   =  $begin_waarde + $count_score;


	//////// verwijderen

$delete = $_POST['Check'];
$param ='';

foreach ($delete as $deleteid)  { 

 $param = $param.$deleteid.';';
 
} // end foreach

$error = 0;
$message  ='';

$voor4           = 0;
$tegen4          = 0;
$voor5           = 0;
$tegen5          = 0;

echo "max aantal updates : ". $count_score."<br>";


for ($i=$begin_waarde;$i<=$max_updates;$i++){
	 
	 $id        = $_POST['Id_'.$i];
	 $naam      = $_POST['Naam_'.$i];
	 
   // lotnummer apart ophalen zie verder
	
	 $voor1     = $_POST['Voor1_'.$i];
	 $tegen1    = $_POST['Tegen1_'.$i];
	 $voor2     = $_POST['Voor2_'.$i];
	 $tegen2    = $_POST['Tegen2_'.$i];
	 $voor3     = $_POST['Voor3_'.$i];
	 $tegen3    = $_POST['Tegen3_'.$i];
	 
if ($aantal_rondes == 5){	 
	 $voor4   = $_POST['Voor4_'.$i];
	 $tegen4  = $_POST['Tegen4_'.$i];
	 $voor5   = $_POST['Voor5_'.$i];
	 $tegen5  = $_POST['Tegen5_'.$i];
} 
 
 
 if ($voor1 == '') { 
 	   $voor1 = 0;
 }
 	if ($voor2 == '') { 
 	   $voor2 = 0;
 }
 if ($voor3 == '') { 
 	   $voor3 = 0;
 }
 if ($voor4 == '') { 
 	   $voor4 = 0;
 }
 if ($voor5 == '') { 
 	   $voor5 = 0;
 }
 
 if ($tegen1 == '') { 
 	   $tegen1 = 0;
 }
 	if ($tegen2 == '') { 
 	   $tegen2 = 0;
 }
 if ($tegen3 == '') { 
 	   $tegen3 = 0;
 }
 if ($tegen4 == '') { 
 	   $tegen4 = 0;
 }
 if ($tegen5 == '') { 
 	   $tegen5 = 0;
 }
 
  
  
/// fout controles

if (!is_numeric($voor1))  {
	$error = 1 ;
	$message .=" Waarde Voor in regel ".$i." en Ronde 1 is geen getal. <br>";
}
if (!is_numeric($voor2))  {
	$error = 1 ;
	$message .=" Waarde Voor in regel ".$i." en Ronde 2 is geen getal. <br>";
}
if (!is_numeric($voor3))  {
	$error = 1 ;
	$message .=" Waarde Voor in regel ".$i." en Ronde 3 is geen getal. <br>";
}
if (!is_numeric($voor4) and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Voor in regel ".$i." en Ronde 4 is geen getal. <br>";
}
if (!is_numeric($voor5) and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Voor in regel ".$i." en Ronde 5 is geen getal. <br>";
}


if (!is_numeric($tegen1))  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 1 en regel ".$i." is geen getal. <br>";
}
if (!is_numeric($tegen2))  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 2 en regel ".$i." is geen getal. <br>";
}
if (!is_numeric($tegen3))  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 3 en regel ".$i." is geen getal. <br>";
}
if (!is_numeric($tegen4) and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 4 en regel ".$i." is geen getal. <br>";
}
if (!is_numeric($tegen5) and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 5 en regel ".$i." is geen getal. <br>";
}


/// als controle 13 aan is of auto
if ($controle_13 =='On' or $controle_13 =='Auto'){

if ($voor1 > 13)  {
	$error = 1 ;
	$message .=" Waarde Voor in Ronde 1 in regel ".$i." is groter dan 13. <br>";
}

if ($voor2 > 13)  {
	$error = 1 ;
	$message .=" Waarde Voor in Ronde 2 en regel ".$i."  is groter dan 13. <br>";
}

if ($voor3 > 13)  {
	$error = 1 ;
	$message .=" Waarde Voor in Ronde 3  en regel ".$i." is groter dan 13. <br>";
}


if ($voor4 > 13 and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Voor in Ronde 4 en regel ".$i." is groter dan 13. <br>";
}

if ($voor5 > 13  and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Voor in Ronde 5 en regel ".$i." is groter dan 13. <br>";
}
 
 if ($tegen1 > 13)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 1 en regel".$i." is groter dan 13. <br>";
}
 
  if ($tegen2 > 13)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 2 en regel".$i." is groter dan 13. <br>";
}
 if ($tegen3 > 13)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 3 en regel".$i." is groter dan 13. <br>";
}
 if ($tegen4 > 13  and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 4 en regel".$i." is groter dan 13. <br>";
}
 if ($tegen5 > 13  and $aantal_rondes == 5)  {
	$error = 1 ;
	$message .=" Waarde Tegen in Ronde 5 en regel".$i." is groter dan 13. <br>";
}

 if ($voor1 == 13 and $tegen1 == 13)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in regel ".$i."  in Ronde 1 beiden gelijk aan 13. <br>";
}
 
  if ($voor2 == 13 and $tegen2 == 13)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in regel ".$i." in Ronde 2 beiden gelijk aan 13. <br>";
}
 
 if ($voor3 == 13 and $tegen3 == 13)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in regel ".$i." in Ronde 3 beiden gelijk aan 13. <br>";
}
 
if ($voor4 == 13 and $tegen4 == 13  and $aantal_rondes > 3)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in regel ".$i." in Ronde 4 beiden gelijk aan 13. <br>";
} 
 

  if ($voor5 == 13 and $tegen5 == 13  and $aantal_rondes > 3)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in regel ".$i." Ronde 5 beiden gelijk aan 13. <br>";
}
 
if ($voor1 != 13 and $tegen1 != 13 and $voor1 !=0 and $tegen1 !=0 )  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in Ronde 1 in regel ".$i." beiden ongelijk aan 13. <br>";
}
 
 if ($voor2 != 13 and $tegen2 != 13 and $voor2 !=0 and $tegen2 !=0)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in Ronde 2 in regel ".$i." beiden ongelijk aan 13. <br>";
}
if ($voor3 != 13 and $tegen3 != 13 and $voor3 !=0 and $tegen3 !=0)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in Ronde 3 in regel ".$i." beiden ongelijk aan 13. <br>";
}
if ($voor4 != 13 and $tegen4 != 13  and $aantal_rondes > 3 and $voor4 !=0 and $tegen4 !=0)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in Ronde 4 in regel ".$i." beiden ongelijk aan 13. <br>";
}
if ($voor5 != 13 and $tegen5 != 13  and $aantal_rondes == 5 and $voor5 !=0 and $tegen5 !=0)  {
	$error = 1 ;
	$message .=" Waarde Voor en Tegen in Ronde 5 in regel ".$i." beiden ongelijk aan 13. <br>";
}
 
}

/// als controle 13  auto
if ( $controle_13 =='Auto'){
 ///auto invullen 13
 
 if ($controle_13 == 'Auto'   and $error ==  0){
	 	
	 	if ($voor1   != 13 and $voor1 > 0   and $tegen1 == 0 ) {
	 		  $tegen1   = 13;
	 	}
	 	
	 	if ($tegen1   != 13 and $tegen1 > 0 and $voor1 == 0 ) {
	 		  $voor1    = 13;
	 	}

	 	if ($voor2   != 13 and $voor2 > 0   and $tegen2 == 0 ) {
	 		  $tegen2   = 13;
	 	}
	 	
	 	if ($tegen2  != 13 and $tegen2 > 0 and $voor2 == 0 ) {
	 		  $voor2   = 13;
	 	}

	 	if ($voor3   != 13 and $voor3 > 0   and $tegen3 == 0 ) {
	 		  $tegen3   = 13;
	 	}
	 	
	 	if ($tegen3   != 13 and $tegen3 > 0 and $voor3 == 0 ) {
	 		  $voor3   = 13;
	 	}

 if ($aantal_rondes > 3){
	 	if ($voor4   != 13 and $voor4 > 0   and $tegen4 == 0 ) {
	 		  $tegen4   = 13;
	 	}
	 	
	 	if ($tegen4   != 13 and $tegen4 > 0 and $voor4 == 0 ) {
	 		  $voor4   = 13;
	 	}

	 	if ($voor5   != 13 and $voor5 > 0   and $tegen5 == 0 ) {
	 		  $tegen5   = 13;
	 	}
	 	
	 	if ($tegen5   != 13 and $tegen5 > 0 and $voor5 == 0 ) {
	 		  $voor5   = 13;
	 	}
}


} // 5 rondes

} // end if controle_13

// bereken winst en saldo
	  $winst = 0;
	  if ($voor1 > $tegen1){
	  	$winst++;
	  }
	  if ($voor2 > $tegen2){
	  	$winst++;
	  }
	 if ($voor3 > $tegen3){
	  	$winst++;
	  }
	  
	  // 29 mei 2017 winst werd niet overgenomen bij 5 rondes
 if ($aantal_rondes > 3){
   if ($voor4 > $tegen4){
	  	$winst++;
	 }
	  
   if ($voor5 > $tegen5){
	  	$winst++;
	 }
}	  
	  
	 $saldo = ($voor1-$tegen1)+($voor2-$tegen2)+($voor3-$tegen3)+($voor4-$tegen4)+($voor5-$tegen5);

if ($error == 0 and $id !='' ){	 		  
/// update score
$query        = "UPDATE hussel_score
                SET Naam           = '".$naam."', 
                    Voor1          = ".$voor1.", 
                    Tegen1         = ".$tegen1.", 
                    Voor2          = ".$voor2.", 
                    Tegen2         = ".$tegen2.", 
                    Voor3          = ".$voor3.", 
                    Tegen3         = ".$tegen3.", 
                    Voor4          = ".$voor4.", 
                    Tegen4         = ".$tegen4.", 
                    Voor5          = ".$voor5.", 
                    Tegen5         = ".$tegen5.", 
                    Winst          = ".$winst.",     
                    Saldo          = ".$saldo.",     
                    Beperkt        = 'N' ,
                    Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update hussel_score '.$query);   	 		
}

if ($error == 0   and $voorgeloot == 'On'  and $lotnummer !='' ){	 		  
/// update lotnummer apart ivm evt overschrijven bij per ongeluk uitschakelen
 $lotnummer = $_POST['Lotnummer_'.$i];
$query        = "UPDATE hussel_score
                SET Lot_nummer          = '".$lotnummer."', 
                    Laatst  = NOW()  WHERE  Id  = ".$id."  ";
 echo $query. "<br>";
  
  mysql_query($query) or die ('Fout in update hussel_score lotnummer');   	 		
}
                         		 
	}// next line


if ($error == 0   and $voorgeloot == 'On'){	 		  
// check op dubbel ingevoerde voorgeloot

$sql    =   mysql_query( "SELECT Lot_nummer, Count(*) from hussel_score where Vereniging_id = ".$vereniging_id."  
                   and Datum = '".$datum."' and Lot_nummer <> ''   group by Lot_nummer HAVING  COUNT(*) > 1") or die('Fout in select duplicates'); 
    
  //echo  "SELECT Naam, Lot_nummer, Count(*) from hussel_score where Vereniging_id = ".$vereniging_id."  
 //                  and Datum = '".$datum."'  group by  Lot_nummer HAVING  COUNT(*) > 1";
    
                   
while($row = mysql_fetch_array( $sql)) {
  $message .="*  Lotnummer ".$row['Lot_nummer']. "  is niet uniek : <br>";
    $qry            = mysql_query("SELECT * From hussel_score where Vereniging_id = ".$vereniging_id ." and Datum = '".$datum."' and Lot_nummer = '".$row['Lot_nummer']."'  ")     ;
      while($result = mysql_fetch_array( $qry)) {
           	$message .="- Lotnummer ".$row['Lot_nummer']." gebruikt bij ".$result['Naam']."<br>";
      }
 
  $error = 1;
}

}

	//////// label voor verwijderen (veld beperkt). Via verwijderen_beperkt worden de aangevinkte spelers verwijderd. Dit zijn spelers die hebben aangegeven maar 1 ronde te spelen

$beperkt = $_POST['Beperkt'];

foreach ($beperkt as $beperktid)  { 
echo $beperktid;

 mysql_query("UPDATE hussel_score set Beperkt = 'J' where Id= ".$beperktid." ");
 

} // end foreach



if ($error > 0){
$error_line      = explode("<br>", $message);   /// opsplitsen in aparte regels tbv alert

?>
   <script language="javascript">
        alert("Er zijn een of meer fouten gevonden bij het invullen :" + '\r\n' + 
            <?php
              $i=0;
              while ( $error_line[$i] <> ''){    
               ?>
              "<?php echo $error_line[$i];?>" + '\r\n' + 
              <?php
              $i++;
             } 
             ?>
              "")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
}
else {
	
	$delete = $_POST['Check'];
	if ($delete != ''){
		$url = 'verwijder_spelers_stap1.php?Check='.$param;
	}
 else { 
 	$url = $_SERVER['HTTP_REFERER'];
 	}
 		
	
	
	
	header("Location: ".$url);
}


ob_end_flush();
?>
</body>