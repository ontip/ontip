<?php
/// vul tabel


echo "<tr>";
echo "<td class ='tab1'>".$volgnr."</td>";          
echo "<td>".$naam1.     "</td>";       
echo "<td>".$licentie1. "</td>";   
echo "<td>".$vereniging1. "</td>";   


if  ($soort_inschrijving != 'single' and $inschrijf_methode == 'vast'   ){
echo "<td>".$naam2.     "</td>";  
echo "<td>".$licentie2. "</td>";  
echo "<td>".$vereniging2. "</td>";   
}
	

if (($soort_inschrijving == 'triplet' or $soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam3.     "</td>";  
echo "<td>".$licentie3. "</td>";  
echo "<td>".$vereniging3. "</td>";   
}

if (($soort_inschrijving == 'kwintet' or $soort_inschrijving == 'sextet') and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam4.     "</td>";  
echo "<td>".$licentie4. "</td>";  
echo "<td>".$vereniging4. "</td>";   

echo "<td>".$naam5.     "</td>";  
echo "<td>".$licentie5. "</td>";   
echo "<td>".$vereniging5. "</td>";   

}

if ($soort_inschrijving == 'sextet' and $licentie_jn == 'J' and $inschrijf_methode == 'vast'){
echo "<td>".$naam6.     "</td>"; 
echo "<td>".$licentie6. "</td>";   
echo "<td>".$vereniging6. "</td>";   
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Kontrole op dubbel inschrijven m.b.v table hulp_naam

$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam1."' and Vereniging_speler = '".$vereniging1."' " ;
//echo $sql;

$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

if($count > 0){
  $message .= "* Er is al een inschrijving ingevuld voor ".$naam1." van ".$vereniging1."<br>";
	$error = 1;
}  

if ($naam2 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam2."' and Vereniging_speler = '".$vereniging2."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

   if($count > 0){
     $message .= "* Er is al een inschrijving ingevuld voor ".$naam2. " van ".$vereniging2."<br>";
    	$error = 1;
   }
}
	
if ($naam3 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam3."' and Vereniging_speler = '".$vereniging3."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

   if($count > 0){
     $message .= "* Er is al een inschrijving ingevuld voor ".$naam3." van ".$vereniging3. "<br>";
   	 $error = 1;
   }
}

if ($naam4 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam4."' and Vereniging_speler = '".$vereniging4."'" ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

  if($count > 0){
    $message .= "* Er is al een inschrijving ingevuld voor ".$naam4. " van ".$vereniging4."<br>";
  	$error = 1;
  }
}

if ($naam5 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam5."' and Vereniging_speler = '".$vereniging5."'" ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

   if($count > 0){
     $message .= "* Er is al een inschrijving ingevuld voor ".$naam5. " van ".$vereniging5."<br>";
   	$error = 1;
   }
}

if ($naam6 <> '') {
$sql   = "SELECT * FROM hulp_naam WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Naam='".$naam6."' and Vereniging_speler = '".$vereniging6."' " ;
$result= mysqli_query($con,$sql);
$count=mysqli_num_rows($result);

   if($count > 0){
     $message .= "* Er is al een inschrijving ingevuld voor ".$naam6. " van ".$vereniging6."<br>";
    	$error = 1;
   }
}



		if ($error == 0 ){
	      $message = 	'Geimporteerd';
	      $color = 'green';
	      
	      // gegevens in 1 regel opnemen tbv stap3
	      $_line = $volgnr.";".$naam1.";".$licentie1.";".$vereniging1;
	      $_line = $_line.";".$naam2.";".$licentie2.";".$vereniging2;
	      $_line = $_line.";".$naam3.";".$licentie3.";".$vereniging3;
	      $_line = $_line.";".$naam4.";".$licentie4.";".$vereniging4;
	      $_line = $_line.";".$naam5.";".$licentie5.";".$vereniging5;
	      $_line = $_line.";".$naam6.";".$licentie6.";".$vereniging6.";".$email.";".$telefoon.";";
	      
	//      echo $_line;
	      
	      $uploads[] = $_line;
	   } else { 
	   	  $color = 'red';
   }
if ($volgnr == 'Nr' and $error  == 0){
echo "<td>Kontrole</td>";  // bericht
}else {
	
echo "<td style= 'color:".$color."';'>".$message."</td>";  // bericht
}

echo "</tr>";

?>