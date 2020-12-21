<?php

$totaal =60;  // deelnemers

// er zijn 6 reeksen. (Team rood : 1,2,3.  Team wit : 4,5,6)
// rood is de eerste helft
// wit is de tweede helft

$start_wit = ($totaal / 2 );
$aantal_wedstrijden = $totaal / 6;


$reeks1_rood = array();
$reeks2_rood = array();
$reeks3_rood = array();
$reeks1_wit  = array();
$reeks2_wit  = array();
$reeks3_wit  = array();
 
// opstellen basis schema
 
$j=1;
$y=1;
for($i=1;$i<=$aantal_wedstrijden;$i++){

$reeks1_rood[$j]  = $y;
$x .= $i;
$reeks2_rood[$j]  = $y+1;
$reeks3_rood[$j]  = $y+2;

$reeks1_wit[$j]   = $start_wit+$y;
$reeks2_wit[$j]   = $start_wit+$y+1;
$reeks3_wit[$j]   = $start_wit+$y+2;

$j++;
$y=$y+3;
}



var_dump($reeks1_rood );

echo "<br>";
var_dump($reeks1_wit );


echo "<h1>Ronde 1</h1>";


$j=1;
$y=1;
for($i=1;$i<=$aantal_wedstrijden;$i++){
	
echo "Wedstrijd ".$j." : ";
echo $reeks1_rood[$j].", ";
echo $reeks2_rood[$j].", ";
echo $reeks3_rood[$j]."   -    ";

echo $reeks1_wit[$j].", ";
echo $reeks2_wit[$j].", ";
echo $reeks3_wit[$j].".<br>";

$j++;
	
}




?>
