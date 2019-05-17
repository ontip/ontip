<?php
$qry                            = mysqli_query($con,"SELECT * from vereniging where Vereniging = '".$vereniging."' ")           or die(' Fout in select 1');  
$result                         = mysqli_fetch_array( $qry);
$url_website                    = $result['Url_website'];
$verzendadres_sms               = $row['Verzendadres_SMS'];
$vereniging_id                  = $result['Id'];
$url_redirect                   = $result['Url_redirect'];
$url_logo                       = $result['Url_logo'];
$prog_url                       = $result['Prog_url'];
$bond                           = $result['Bond'];
$indexpagina_achtergrond_kleur  = $result['Indexpagina_achtergrond_kleur']; 


$sql         = mysqli_query($con,"SELECT Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi    = $result['Toernooi'];


if ($toernooi ==''){
// maak hulptabel leeg
mysqli_query($con,"Delete from hulp_toernooi where Vereniging_id = '".$vereniging_id."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 

$query = "insert into hulp_toernooi (Toernooi, Vereniging, Vereniging_id, Datum) 
          (select Toernooi,Vereniging, Vereniging_id, Waarde from config  where Vereniging_id = '".$vereniging_id."' and Variabele ='datum' group by Vereniging, Vereniging_id, Toernooi,Waarde   )" ;
mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 

$update = mysqli_query($con,"UPDATE hulp_toernooi as h
                       join config as c
                        on c.Vereniging_id        = h.Vereniging_id 
                        set h.Toernooi_voluit    = c.Waarde 
                       where c.Toernooi         = h.Toernooi
                         and c.Variabele        ='toernooi_voluit' 
                         and c.Vereniging_id    = '".$vereniging_id."'  ") or die ('Fout in update hulp_toernooi'); 
  
$toernooien = mysqli_query($con,"SELECT h.Toernooi,  Waarde , Datum from config as c
                      join hulp_toernooi as h
                       on c.Vereniging_id        = h.Vereniging_id and
                          c.Toernooi          = h.Toernooi 
                        where c.Variabele     = 'toernooi_voluit' 
                          and c.Vereniging_id    = '".$vereniging_id."' order by Datum ")  or die ('Fout in select hulp_toernooi'); 
                      
$qry                    = mysqli_query($con,"SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'  order by Datum ")           or die(' Fout in select eerstv');  
$result                 = mysqli_fetch_array( $qry );
$toernooi               = $result['Toernooi'];
$aantal_toernooien      = mysqli_num_rows($qry);

// Indien geen toernooi in de toekomst gevonden of maar 1 toernooi laadt dan de laatste

if ($aantal_toernooien < 2 ) {
    $qry      = mysqli_query($con,"SELECT * from hulp_toernooi where Vereniging = '".$vereniging."'  order by Datum desc limit 1")           or die(' Fout in select toernooi 1');  
    $row      = mysqli_fetch_array( $qry );
    $var      = substr($row['Datum'],0,10);
    $toernooi = $row['Toernooi'];   	 
  
    mysqli_query($con,"Update namen set Toernooi = '".$toernooi."' WHERE Aangelogd = 'J'  and Vereniging_id = ".$vereniging_id."  and IP_adres = '". $_SERVER['REMOTE_ADDR']."' ");
 
   if ($toernooi =='') {
   	   $aantal_toernooien = 0;
   	}
   	else {
       $toernooi_voluit = $row['Waarde'];   	 
       $datum           = $row['Datum'];  
   	} 
}    


}
// haal geselecteerd toernooi op (bij select_toernooi wordt deze opgeslagen in de namen tabel

$sql         = mysqli_query($con,"SELECT Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi    = $result['Toernooi'];

//  Check op nog aanwezige al gespeelde toernooi inschrijvingen

$sql                   = mysqli_query($con,"SELECT count(*) as Aantal FROM inschrijf WHERE Vereniging = '".$vereniging."' and Datum < '".$today."'" );
$result                = mysqli_fetch_array( $sql );
$count_oud_toernooi    = $result['Aantal'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}


$_check =  preg_replace('/[^a-z0-9\\040\\"\\.\\-\\_\\\\]/i',  '*' , $_vereniging);

if ($_check !=  $_vereniging){
	  $_vereniging = $row['Vereniging'];
}

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
}

?>