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

# 10mei2019          -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

// Database gegevens. 
//include('mysqli.php');

/*
$toernooi      = 'Bon_Soir_mes_amis_cyclus';
$vereniging_id = 60;
$datum         = '2019-04-16';
$meerdaags_toernooi_jn  ='X';
*/
 echo "test";
 
 
// toernooi cyclus
if ($meerdaags_toernooi_jn =='X'){

 echo "test";



$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		

		     $datum_cyclus = $row['Datum'];
                      
         $qry      = mysqli_query($con,"SELECT count(*) as Aantal  from inschrijf where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' 
                      and Meerdaags_datums  like   '%".$datum_cyclus."%' " ); 
         $result = mysqli_fetch_array( $qry );

         // update
echo "UPDATE 	toernooi_datums_cyclus SET Aantal_splrs = ".$result['Aantal']." , Laatst = now()  
                      WHERE  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum = '".$datum_cyclus."'   ";
                      
                      
         $qry2      = mysqli_query($con,"UPDATE 	toernooi_datums_cyclus SET Aantal_splrs = ".$result['Aantal']." , Laatst = now()  
                      WHERE  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum = '".$datum_cyclus."'   ")  or die('Fout in update');

   } // end while
} // end cyclus

//exit;
