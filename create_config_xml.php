<?php 
// Database gegevens. 
//include('mysql.php');	
//$pageName = basename($_SERVER['SCRIPT_NAME']);
//include('page_stats.php');

ob_start();
ini_set('display_errors', 'On');
//error_reporting(E_ALL);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Lees configuratie tabel tbv toernooi gegevens

if (isset($_GET['toernooi'])){
 	  $toernooi = $_GET['toernooi'];
} // end get

//echo "Create xml voor ". $toernooi."<br>";

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum' ")     or die(' Fout in select');  
$result = mysqli_fetch_array( $qry );
$datum  = $result['Waarde'];
	
$today = date("Y-m-d h:i:s");

		 // ophalen toernooi gegevens
$qry_ver        = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id ."  ")     or die(' Fout in select 2');  
$result         = mysqli_fetch_array( $qry_ver);
$vereniging_nr  = $result['Vereniging_nr'];
$plaats         = $result['Plaats'];  
$bond           = $result['Bond'];  

   if ($result['Vereniging_output_naam'] !='') {
     $_vereniging = $result['Vereniging_output_naam'];
     }
    else {
    	$_vereniging = $result['Vereniging'];
   }
	 
	 
	    
// Er wordt een XML file gevuld waarin de data wordt opgenomen
$xml_file ="../ontip/xml/cfg_".$vereniging_id."_".$datum."_".$toernooi.".xml";
$fp = fopen($xml_file, "w");
fclose($fp);


$fp = fopen($xml_file, "a");
fwrite($fp, "<?xml version='1.0' encoding='UTF-8'?>\n");
fwrite($fp, "<!-- OnTip xml toernooi configuratie tbv backup zowel insert als update . Created by create_config_xml.php -->\n");

fwrite($fp, "<ontip>\n");
fwrite($fp, "<create_xml>".$today."</create_xml>\n");
fwrite($fp, "<vereniging>\n");
 fwrite($fp, "<naam>".$_vereniging."</naam>\n");
 fwrite($fp, "<id>".$vereniging_id."</id>\n");
 fwrite($fp, "<id>".$vereniging_nr."</id>\n");
 fwrite($fp, "<bond>".$bond."</bond>\n");
 fwrite($fp, "<plaats>".$plaats."</plaats>\n");
fwrite($fp, "</vereniging>\n");

fwrite($fp, "<toernooi>\n");
fwrite($fp, "<naam>".$toernooi."</naam>\n");


$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	$waarde = $row['Waarde'];
	if ($waarde == '<selecteer uit image gallery>'){
	  	$waarde  ='';
	}

	
fwrite($fp, "<".$row['Variabele'].">\n");
fwrite($fp, "<waarde>".$waarde."</waarde>\n");
fwrite($fp, "<parameters>".$row['Parameters']."</parameters>\n");
fwrite($fp, "</".$row['Variabele'].">\n");

} // end while

fwrite($fp, "</toernooi>\n");
fwrite($fp, "</ontip>\n");

fclose($fp);
?>
