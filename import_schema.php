<?php
include 'mysqli.php'; 

// indien aangeroepen door step 3 dan is cookie gezet
if (isset($_COOKIE['competitie'])){
 $competitie_id  = $_COOKIE['competitie'];
}


// ophalen competitie naam adhv doorgegeven id
$sql        = mysqli_query($con,"SELECT * from comp_soort where Id = '".$competitie_id."'  ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$competitie_naam       = $result['Competitie'];

 mysqli_query($con,"DELETE FROM comp_spel_schema where Vereniging = '".$vereniging."' and Competitie = '".$competitie_naam."' ");
           
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees bestand met schema
////// : kolom1 : team. Overige kolommen tegenstanders. Gescheiden door spatie. In Ultraedit asci 09 (tab) vervangen door 3B !

$myFile   =  'schema.txt';
$fh       = fopen($myFile, 'r');
$line     = fgets($fh);
$sep      = ";";



while ( $line <> ''){

$tegenstander = explode($sep, $line);
$team         = $tegenstander[0];

echo " Voor team : " . $team."<br>";

echo " Voor tegenstander3 : " . $tegenstander[3]."<br>";

$i=1;
while ($tegenstander[$i] <> ''){
	

$sql4  = "INSERT into comp_spel_schema (Id,Vereniging,Competitie,Speelronde,Team,Tegenstander)
           VALUES (0,'".$vereniging."','".$competitie_naam."',".$i.",'".$team."','".$tegenstander[$i]."' )";
           echo $sql4;
        mysqli_query($con,$sql4) or die ('Fout in insert');         

$i++;
} /// while

$line = fgets($fh);
} /// while

?>