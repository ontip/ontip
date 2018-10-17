<?php
ob_start();

// Database gegevens. 
include('mysql.php');

$id       = $_GET['id'];
$key      = $_GET['key'];

//                    jjjjmmddhhmmssx
// uiteenrafelen key  012345678901234

$date    = substr($key,0,12);
$jaar    = substr($key,0,4);
$maand   = substr($key,4,2);
$dag     = substr($key,6,2);
$uur     = substr($key,8,2);
$minuut  = substr($key,10,2);
$seconde = substr($key,12,2);

// keuze geeft aan alles(1) of alleen config(2) records
$keuze   = substr($key,14,1);


// als key minder dan half uur geleden dan mag er verwijderd worden. Grenswaarde is dus aanmaak key + 30 minuten
$tijdstip     = mktime ($uur, $minuut+30, $seconde, $maand, $dag, $jaar);
$grens_waarde = date ("YmdHis",$tijdstip)   ; 

$nu = date("YmdHis");

$sql        = "SELECT * FROM config WHERE Id='".$id."'  and ".$nu."  between  ".$date." and  ".$grens_waarde." ";
$result     = mysql_query($sql);
$count      = mysql_num_rows($result);
$row        = mysql_fetch_array( $result );
$vereniging = $row['Vereniging'];  
$vereniging_id = $row['Vereniging_id'];  
$toernooi   = $row['Toernooi'];  

$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum' ")     or die(' Fout in select');  
$result = mysql_fetch_array( $qry );
$datum  = $result['Waarde'];

$cfg_xlm_file = "../ontip/xml/cfg_".$vereniging_id."_".$datum."_".$toernooi.".xml";
$ins_xlm_file = "../ontip/xml/ins_".$vereniging_id."_".$datum."_".$toernooi.".xml";
 
  
if($count > 0){

 // verwijderen uit config en of inschrijf (1 = beiden, 2 is alleen inschrijf)
  
  switch ($keuze) {
		case "1":  
	//	echo "Zowel configuratie als inschrijvingen worden verwijderd."; 
         mysql_query("Delete from config       where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ; 
         mysql_query("INSERT into stats_email (Vereniging, Toernooi, Datum, Naam, Email, Laatst)  (select Vereniging, Toernooi, Datum,Naam1, Email, Inschrijving from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and Email > '' group by Email   )  ");
         ////------------------------------------  archiveren in stats_naam vanuit hulp_naam omdat hierin al de individuele spelers staan  -----------------------------//////
         mysql_query("INSERT into stats_naam (select * from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  )  ") or die('Fout in insert stat_naam');

         mysql_query("Delete from inschrijf    where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
         mysql_query("Delete from hulp_naam    where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;
         mysql_query("Delete from boule_maatje where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;
         
         // xml files verwijderen
         unlink($cfg_xlm_file);
         unlink($ins_xlm_file);
        
        break; 
		case "2":  
	//			echo "Alleen  inschrijvingen worden verwijderd."; 
         mysql_query("INSERT into stats_email (Vereniging, Toernooi, Datum, Naam, Email, Laatst)  (select Vereniging, Toernooi, Datum,Naam1, Email, Inschrijving from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and Email > '' group by Email   )  ");
         ////------------------------------------  archiveren in stats_naam vanuit hulp_naam omdat hierin al de individuele spelers staan  -----------------------------//////
         mysql_query("INSERT into stats_naam (select * from hulp_naam where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  )  ") or die('Fout in insert stat_naam');
 
         mysql_query("Delete from inschrijf      where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
         mysql_query("Delete from hulp_toernooi  where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
         mysql_query("Delete from hulp_naam      where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  
         mysql_query("Delete from config         where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and Variabele = 'delete_key'   ") ; 
         mysql_query("Delete from boule_maatje   where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;

         // xml files verwijderen
         unlink($ins_xlm_file);
         break; 
  }// end switch
 ?>
<script language="javascript">
        alert("De gegevens van het <?php echo $toernooi; ?> toernooi zijn verwijderd." + '\r\n' + 
        "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		    window.close(); 
	</script>
<?php
}
 else {
   // verwijder wel delete_key recrd uit config
 	 mysql_query("Delete from config       where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."' and Variabele = 'delete_key'   ") ; 
 	?>
<script language="javascript">
        alert("Verwijdering van toernooi <?php echo $toernooi; ?> niet toegestaan ivm overschrijding half uur na verzending mail" + '\r\n' + 
              "of toernooi is al verwijderd. Het window kan veilig afgesloten worden.")
    </script>
  <script type="text/javascript">
       window.close(); 
		</script>
<?php

}
ob_end_flush();
?> 