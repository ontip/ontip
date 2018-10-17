<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=\"".$datum." ".$toernooi." deelnemers.txt\"");
header("Pragma: no-cache");
header("Expires: 0");

$toernooi            = $_GET['toernooi'];
$datum               = $_GET['datum'];
$vereniging_id       = $_GET['id'];
$filename = $datum." ". $toernooi." deelnemers.txt";


include('mysql.php');
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


if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens  (soort inschrijving e.d)
if (isset($toernooi)) {
	$qry  = mysql_query("SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' ")     or die(' Fout in select config');  
while($row = mysql_fetch_array( $qry )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

// 12 apr 2016  Melee inschrijving aanpassing
$qry  = mysql_query("SELECT Parameters From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving' ")     or die(' Fout in select config');  
$row = mysql_fetch_array( $qry) ;
$inschrijf_methode = $row['Parameters'];
}

/*
if ($soort_inschrijving  == 'single' ) {
	echo 'Mêlée toernooien worden niet ondersteund in PT Toernooi beheer';
	exit;
}
*/

//echo $soort_inschrijving;

/// wegschrijven


// PT Toernooi beheer werkt met wisselende teams.Dus teams worden pas in loting vast gesteld

//////////////////////////////////////////////  EXPORT t.b.v <TOERNOOI VOLUIT>.TXT   Petanque Toernooi systeem Werkman  /////////////////////////////////////////////////////
/// bestands voorbeeld
///     
///            1         2         3         4         5         6         7         8         9         1         1
////  123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890
////    1|     1| 45910|Erik Hendrikx                           |Boulamis                      |  1|            | | |1|
///     2|     2| 45909|Petra Hendrikx                          |Boulamis                      |  1|            | | |1|
////


////    Van   tot      veld
//      1     3        Volgnummer
//      4     4        Separator
//      5     10       Volgnummer?
//      11    11       Separator
//      12    17       Licentienr
//      18    18       Separator
//      19    58       Naam speler
//      59    59       Separator
//      60    89       Vereniging speler
//      90    90       Separator
//      91    93       Team nr
//      94    94       Separator
//      95    106      ???
//      107   107      Separator
//      108   108       ???
//      109   109      Separator
//      110   110       ???
//      111   111      Separator
//      112   112       ???
//      113   113      Separator EOL
//      
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$separator = "|";
$spaties = '                                                                                ';

// uitvullen van var lengte velden

$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving desc" )    or die('Fout in select');  

$i                 = 1;
$team              = 0;

//// Per speler een regel in het bestand. Het team nr geeft aan wie in hetzelfde team. 

//echo "\r\n";

while($row = mysql_fetch_array( $spelers )) {
	
$team++;

$volgnr = $i;
//$team   = $volgnr;


if ($i < 10) {
	  $volgnr = "  ".$i;
}

// because of extra start space
if ($i == 1){
	 $volgnr = " ".$i;
}	 

	 
if ($i > 9 and $i < 100) {
	  $volgnr = " ".$i;
}

// eerst Speler1 uit OnTip record
$naam       = $row['Naam1'].$spaties;
$licentie   = $spaties.$row['Licentie1'];
$vereniging = $row['Vereniging1'].$spaties;
$len        = strlen($licentie);

// vervang diacrieten
$vereniging       = str_replace("é",  "e", $vereniging);


//Replace all characters except (^) a till z, A till Z, 0 till 9, a space, the @ sign and ,.
$naam = preg_replace('/[^a-zA-Z0-9 .@,]/', '', $naam);

//      1     3        Volgnummer
echo  $volgnr ;
//      4     4        Separator
echo  $separator;
//      5     10       Volgnummer?
$volgnr = $spaties.$volgnr;
echo  substr($volgnr,-6, 6) ;
//      11    11       Separator
echo  $separator;
//      12    17       Licentienr
echo  substr($licentie,-6,6) ;
//      18    18       Separator
echo  $separator;
//      19    58       Naam speler
echo substr($naam,0,40);
//      59    59       Separator
echo  $separator;
//      60    89       Vereniging speler
echo substr($vereniging,0,30);
//      90    90       Separator
echo  $separator;
//      91    93       Team speler nr
$_team = $spaties.$team;
echo  substr($_team,-3,3) ;
//      94    94       Separator
echo  $separator;
//      95    106      ???
echo substr($spaties,0,12);
//      107   107      Separator
echo  $separator;
//      108   108       ???
echo substr($spaties,0,1);
//      109   109      Separator
echo  $separator;
//      110   110       ???
echo substr($spaties,0,1);
//      111   111      Separator
echo  $separator;
//      112   112       ???
echo "1";
//      113   113      Separator EOL
echo  $separator;

echo "\r\n";

$i++;


if ( ($soort_inschrijving  == 'doublet'  or $soort_inschrijving  == 'triplet') and $inschrijf_methode == 'vast' ) {
	
$volgnr = $i;


if ($i < 10) {
	  $volgnr = "  ".$i;
}
	 
if ($i > 9 and $i < 100) {
	  $volgnr = " ".$i;
}

	
// dan Speler2 uit OnTip record
$naam       = $row['Naam2'].$spaties;
$licentie   = $spaties.$row['Licentie2'];
$vereniging = $row['Vereniging2'].$spaties;
$len        = strlen($licentie);

//Replace all characters except (^) a till z, A till Z, 0 till 9, a space, the @ sign and ,.
$naam = preg_replace('/[^a-zA-Z0-9 .@,]/', '', $naam);

//      1     3        Volgnummer
echo  $volgnr ;
//      4     4        Separator
echo  $separator;
//      5     10       Volgnummer?
$volgnr = $spaties.$volgnr;
echo  substr($volgnr,-6, 6) ;
//      11    11       Separator
echo  $separator;
//      12    17       Licentienr
echo  substr($licentie,-6,6) ;
//      18    18       Separator
echo  $separator;
//      19    58       Naam speler
echo substr($naam,0,40);
//      59    59       Separator
echo  $separator;
//      60    89       Vereniging speler
echo substr($vereniging,0,30);
//      90    90       Separator
echo  $separator;
//      91    93       Team speler nr
$_team = $spaties.$team;
echo  substr($_team,-3,3) ;
//      94    94       Separator
echo  $separator;
//      95    106      ???
echo substr($spaties,0,12);
//      107   107      Separator
echo  $separator;
//      108   108       ???
echo substr($spaties,0,1);
//      109   109      Separator
echo  $separator;
//      110   110       ???
echo substr($spaties,0,1);
//      111   111      Separator
echo  $separator;
//      112   112       ???
echo "1";
//      113   113      Separator EOL

echo  $separator;
echo "\r\n";
$i++;

} // end doublet + triplet

if ($soort_inschrijving  ==  'triplet' and $inschrijf_methode == 'vast') {
// dan Speler3 uit OnTip record
$naam       = $row['Naam3'].$spaties;
$licentie   = $spaties.$row['Licentie3'];
$vereniging = $row['Vereniging3'].$spaties;
$len        = strlen($licentie);

$volgnr = $i;


if ($i < 10) {
	  $volgnr = "  ".$i;
}
	 
if ($i > 9 and $i < 100) {
	  $volgnr = " ".$i;
}
//Replace all characters except (^) a till z, A till Z, 0 till 9, a space, the @ sign and ,.
$naam = preg_replace('/[^a-zA-Z0-9 .@,]/', '', $naam);

//      1     3        Volgnummer
echo  $volgnr ;
//      4     4        Separator
echo  $separator;
//      5     10       Volgnummer?
$volgnr = $spaties.$volgnr;
echo  substr($volgnr,-6, 6) ;
//      11    11       Separator
echo  $separator;
//      12    17       Licentienr
echo  substr($licentie,-6,6) ;
//      18    18       Separator
echo  $separator;
//      19    58       Naam speler
echo substr($naam,0,40);
//      59    59       Separator
echo  $separator;
//      60    89       Vereniging speler
echo substr($vereniging,0,30);
//      90    90       Separator
echo  $separator;
//      91    93       Team speler nr
$_team = $spaties.$team;
echo  substr($_team,-3,3) ;
//      94    94       Separator
echo  $separator;
//      95    106      ???
echo substr($spaties,0,12);
//      107   107      Separator
echo  $separator;
//      108   108       ???
echo substr($spaties,0,1);
//      109   109      Separator
echo  $separator;
//      110   110       ???
echo substr($spaties,0,1);
//      111   111      Separator
echo  $separator;
//      112   112       ???
echo "1";
//      113   113      Separator EOL
echo  $separator;
echo "\r\n";
$i++;

} // end triplet


}; // end while lezen


 ?>
