<?php
ob_start();
// header("Location: ".$_SERVER['HTTP_REFERER']);

//// Database gegevens. 

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Lees ontip inschrijf in hussel score
//// SQL Queries
//// Database gegevens. 

include ('mysql.php');


$toernooi= $_POST['toernooi'];


if (isset($_POST['Check'])) {

$query = "DELETE from  hussel_score WHERE Vereniging_id = ". $vereniging_id." and Datum = '".$datum."'  ";
///              echo $query."<br>";
mysql_query($query) or die (mysql_error()); 
}
              
               


// Inschrijven als individu of vast team

$qry                 = mysql_query("SELECT * From config  where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result              = mysql_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

$spelers      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging_id = '".$vereniging_id."' order by Inschrijving" )    or die(mysql_error());  


$i=1;

while($row = mysql_fetch_array( $spelers )) {


if ($soort_inschrijving =='single' or $inschrijf_methode =='vast'){

$naam = $row['Naam1'];

}

 if ($soort_inschrijving !='single' and $inschrijf_methode =='vast'){
	 
$naam = $row['Naam1']. " - " .$row['Naam2'];
  	
  
    	
}

 if (($soort_inschrijving == 'triplet' or $soort_inschrijving == '4x4'  or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $inschrijf_methode =='vast'){
   $naam = $row['Naam1']. ", " .$row['Naam2']." e.a ";

  }

  
 
/// Voeg toe aan hussel_score
$query = "INSERT INTO hussel_score (Vereniging, Vereniging_id,Datum,  Naam, Winst, Saldo)
               VALUES ('".$vereniging."',".$vereniging_id.",'".$datum."','".$naam."' , 0,0)";
 //              echo $query."<br>";
mysql_query($query) or die (mysql_error());                
               

};
$qry                 = mysql_query("SELECT * From config  where Vereniging_id = '".$vereniging_id ."' and Toernooi = '".$toernooi ."' and Variabele = 'toernooi_voluit'  ") ;  
$result              = mysql_fetch_array( $qry);
$toernooi            = $result['Waarde'];

$query   = "UPDATE hussel_config SET Parameters = '".$toernooi."'   where  Vereniging_id = ".$vereniging_id." and Variabele = 'voorgeloot'";   
//  echo $query;
   
    mysql_query($query) or die(' Fout in update voorgeloot toernooi');  


?>
   <script language="javascript">
        alert("Spelers of teams zijn toegevoegd aan de scorelijst.")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php 
?>