<?php 
// Database gegevens. 
//include('mysql.php');	
//$pageName = basename($_SERVER['SCRIPT_NAME']);
//include('page_stats.php');

ob_start();
ini_set('display_errors', 'On');
//error_reporting(E_ALL);


//$toernooi = $_GET['toernooi'];
$today = date("Y-m-d h:i:s");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens
	 	 
	 // ophalen toernooi gegevens
	 $qry_cfg  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select 1');  
   while($row = mysql_fetch_array( $qry_cfg )) {
	
	    $var  = $row['Variabele'];
	    $$var = $row['Waarde'];
	  }
	
		 // ophalen toernooi gegevens
	 $qry_ver        = mysql_query("SELECT * From vereniging where Id = ".$vereniging_id ."  ")     or die(' Fout in select 2');  
   $result         = mysql_fetch_array( $qry_ver);
   $vereniging_nr  = $result['Vereniging_nr'];
   $plaats         = $result['Plaats'];  
   $bond           = $result['Bond'];  
   
   
   if ($result['Vereniging_output_naam'] !='') {
     $_vereniging = $result['Vereniging_output_naam'];
     }
    else {
    	$_vereniging = $result['Vereniging'];
   }
	 
	 $qry        = mysql_query("SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
   $result     = mysql_fetch_array( $qry);
   $inschrijf_methode   = $result['Parameters'];

   if  ($inschrijf_methode == ''){
	      $inschrijf_methode = 'vast';
   }
	
	$qry    = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum' ")     or die(' Fout in select');  
  $result = mysql_fetch_array( $qry );
  $datum  = $result['Waarde'];

	//  Aanmaak xml per toernooi
	
	$xml_file ="../ontip/xml/ins_".$vereniging_id."_".$datum."_".$toernooi.".xml";
  $fp = fopen($xml_file, "w");
  fclose($fp);


  $fp = fopen($xml_file, "a");
  
  // XML headers
  
  fwrite($fp, "<?xml version='1.0' encoding='UTF-8'?>\n");
  fwrite($fp, "<!-- OnTip xml inschrijvingen tbv backup zowel insert als update . Created by create_inschrijf_xml.php -->\n");

  // OnTip headers

  fwrite($fp, "<ontip>\n");
  fwrite($fp, "<create_xml>".$today."</create_xml>\n");
  fwrite($fp, "<vereniging>\n");
   fwrite($fp, "<naam>".$_vereniging."</naam>\n");
   fwrite($fp, "<nr>".$vereniging_id."</nr>\n");
   fwrite($fp, "<id>".$vereniging_nr."</id>\n");
   fwrite($fp, "<bond>".$bond."</bond>\n");
   fwrite($fp, "<plaats>".$plaats."</plaats>\n");
  fwrite($fp, "</vereniging>\n");

  // Toernooi headers

  fwrite($fp, "<toernooi>\n");
  fwrite($fp, "<naam>".$toernooi."</naam>\n");
	fwrite($fp, "<datum>".$datum."</datum>\n");
	fwrite($fp, "<soort_inschrijving>".$soort_inschrijving."</soort_inschrijving>\n");
	fwrite($fp, "<inschrijf_methode>".$inschrijf_methode."</inschrijf_methode>\n");
	fwrite($fp, "</toernooi>\n");
	
	fwrite($fp, "<inschrijvingen>\n");
	
	//VulInschrijf($toernooi, $vereniging );
	//  alle inschrijvingen
$i=1;
	
$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving  " )    or die(mysql_error());  
while($row_spl = mysql_fetch_array( $spelers )) {


 fwrite($fp, "<inschrijving  nr = '".$i."'>\n");
 
 // verwijder vreemde tekens uit de bestandsnaam, vervang door '_' ivm bug 17 april 2015
 $row_spl['Vereniging1'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging1']);
 $row_spl['Vereniging2'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging2']);
 $row_spl['Vereniging3'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging3']);
 $row_spl['Vereniging4'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging4']);
 $row_spl['Vereniging5'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging5']);
 $row_spl['Vereniging6'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Vereniging6']);
 
 $row_spl['Naam1'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam1']);         
 $row_spl['Naam2'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam2']);         
 $row_spl['Naam3'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam3']);         
 $row_spl['Naam4'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam4']);         
 $row_spl['Naam5'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam5']);         
 $row_spl['Naam6'] = preg_replace('/[^a-z0-9\\040\\.\\_\\\\]/i',         '_' , $row_spl['Naam6']);         
                                                                                                                      
fwrite($fp, "<personen>\n");
 
 fwrite($fp, "<speler1>\n");
 fwrite($fp, "<naam>".$row_spl['Naam1']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie1']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging1']."</vereniging>\n");
 fwrite($fp, "</speler1>\n");
  
 fwrite($fp, "<speler2>\n");
 fwrite($fp, "<naam>".$row_spl['Naam2']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie2']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging2']."</vereniging>\n");
 fwrite($fp, "</speler2>\n");
 
 fwrite($fp, "<speler3>\n");
 fwrite($fp, "<naam>".$row_spl['Naam3']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie3']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging3']."</vereniging>\n");
 fwrite($fp, "</speler3>\n");
 
 fwrite($fp, "<speler4>\n");
 fwrite($fp, "<naam>".$row_spl['Naam4']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie4']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging4']."</vereniging>\n");
 fwrite($fp, "</speler4>\n");
 
 fwrite($fp, "<speler5>\n");
 fwrite($fp, "<naam>".$row_spl['Naam5']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie5']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging5']."</vereniging>\n");
 fwrite($fp, "</speler5>\n");
 
 fwrite($fp, "<speler6>\n");
 fwrite($fp, "<naam>".$row_spl['Naam6']."</naam>\n");
 fwrite($fp, "<licentie>".$row_spl['Licentie6']."</licentie>\n");
 fwrite($fp, "<vereniging>".$row_spl['Vereniging6']."</vereniging>\n");
 fwrite($fp, "</speler6>\n");
 
 fwrite($fp, "</personen>\n");

 
 	if (strpos($row_spl['Extra'],";")  >  0 ){ 
	     $opties   = explode(";",$row_spl['Extra']);
       $vraag    = $opties[0];
	     $antwoord = $opties[1];
      } else { 
      	$vraag    = $extra_vraag;      /// from config
	      $antwoord = $row_spl['Extra'];
      }

	 fwrite($fp, "<extra_vraag>\n");
	 	 fwrite($fp, "<vraag>".$vraag."</vraag>\n");
	   fwrite($fp, "<antwoord>".$antwoord."</antwoord>\n");
	 fwrite($fp, "</extra_vraag>\n");
	
	 fwrite($fp, "<extra_invulveld>\n");
	   fwrite($fp, "<vraag>".$extra_invulveld."</vraag>\n");
     fwrite($fp, "<antwoord>".$row_spl['Extra_invulveld']."</antwoord>\n");
   fwrite($fp, "</extra_invulveld>\n");
		  
	 fwrite($fp, "<opmerking>".$row_spl['Opmerkingen']."</opmerking>\n");
	  
	 fwrite($fp, "<contact_info>\n");
	  fwrite($fp, "<email>".$row_spl['Email']."</email>\n");
	  fwrite($fp, "<telefoon>".$row_spl['Telefoon']."</telefoon>\n");
	 fwrite($fp, "</contact_info>\n");
	
	 fwrite($fp, "<extra_gegevens>\n");
	  fwrite($fp, "<adres>".$row_spl['Adres']."</adres>\n");
	  fwrite($fp, "<betaal_datum>".$row_spl['Betaal_datum']."</betaal_datum>\n");
	  fwrite($fp, "<bank_rekening>".$row_spl['Bank_rekening']."</bank_rekening>\n");
	  fwrite($fp, "<bevestiging_verzonden>".$row_spl['Bevestiging_verzonden']."</bevestiging_verzonden>\n");
	  fwrite($fp, "<reservering>".$row_spl['Reservering']."</reservering>\n");
	  fwrite($fp, "<meerdaags>".$row_spl['Meerdaags_datums']."</meerdaags>\n");
 	  fwrite($fp, "<status>".$row_spl['Status']."</status>\n");
    fwrite($fp, "<laatst>".$row_spl['Inschrijving']."</laatst>\n");
   fwrite($fp, "</extra_gegevens>\n");	
fwrite($fp, "</inschrijving>\n"); 	
	
	
	$i++;
}// end while
	
	fwrite($fp, "</inschrijvingen>\n");
	
	
	fwrite($fp, "</ontip>\n");
	fclose($fp);
	
	 ?>
	 <!--a href ='<?php echo $xml_file;?>' target='_blank'> Klik hier voor aangemaakte xml file voor <?php echo $toernooi;?></a><br-->
	 <?php
	 
	
?>
