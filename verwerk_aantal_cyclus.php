<?php
# verwerk_aantal_cyclus.php
# Deze  include  telt het aantal inschrijvingen per toernooi datum uit een cyclus en neemt deze op in de tabel toernooi_datums_cyclus.
# Include in send_inschrijf.php
#
# Date              Version      Person
# ----              -------      ------
# 24febt2019        Init          E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None.
# Fix:              None.
# Feature:          None.
# Reference: 


// Database gegevens. 
//include('mysql.php');

/*
$toernooi      = 'Bon_Soir_mes_amis_cyclus';
$vereniging_id = 60;
$datum         = '2019-04-16';
$meerdaags_toernooi_jn  ='X';
*/
 
// toernooi cyclus
if ($meerdaags_toernooi_jn =='X'){

$sql      = mysql_query("SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' order by Datum" )     ; 
	
	while($row = mysql_fetch_array( $sql )) { 		

		     $datum_cyclus = $row['Datum'];
                      
         $qry      = mysql_query("SELECT count(*) as Aantal  from inschrijf where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' 
                      and Meerdaags_datums  like   '%".$datum_cyclus."%' " ); 
         $result = mysql_fetch_array( $qry );

         // update

         $qry2      = mysql_query("UPDATE 	toernooi_datums_cyclus SET Aantal_splrs = ".$result['Aantal']." , Laatst = now()  
                      WHERE  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum = '".$datum_cyclus."'   ");

   } // end while
} // end cyclus