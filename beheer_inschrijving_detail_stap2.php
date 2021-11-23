<?php
 
// Database gegevens. 
include('mysqli.php');
//include('action.php');
include('versleutel_string.php');
header("Location: ".$_SERVER['HTTP_REFERER']);


$error = 0;
$message = '';

// formulier POST variabelen ophalen en kontroleren

if (isset($_POST['zendform'])) 
{ 
    foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
        } 
    } 
} 

if ($challenge != $respons){
	$message .= "* Anti spam is niet (juist) ingevuld<br>";
	$error = 1;
}

/// Toon foutmeldingen

if ($error == 1){
  $error_line      = explode("<br>", $message);   /// opsplitsen in aparte regels tbv alert
  ?>
   <script language="javascript">
        alert("Er zijn een of meer fouten gevonden bij het invullen :" + '\r\n' + 
            <?php
              $i=0;
              while ( $error_line[$i] <> ''){    
               ?>
              "<?php echo $error_line[$i];?>" + '\r\n' + 
              <?php
              $i++;
             } 
             ?>
              "")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
 } // error = 1
 
 
 /// alle controles goed 
if ($error == 0){

//echo "SELECT * from inschrijf where md5(Toernooi) = '".$toernooi_md5."'  and md5(Vereniging_id) = '".$vereniging_md5."' order by Id" ;

      $query = "UPDATE inschrijf 
             SET Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."'
                 Licentie1              = '".$licentie1."'
             WHERE  Id  = ".$id.";  ";

			 
   if ($naam2 !=''){
	 
     $query = "UPDATE inschrijf 
            SET  Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."',
                 Licentie1              = '".$licentie1."',     		
                 Naam2                  = '".$naam2."',
                 Vereniging2            = '".$vereniging2."',
                 Licentie2              = '".$licentie2."'     		
   	 WHERE  Id  = ".$id.";  ";
					
   } // end if geen single en doublet
	
   if ($naam3 !=''){	
	 $query = "UPDATE inschrijf 
             SET Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."',
                 Licentie1              = '".$licentie1."',     
                 Naam2                  = '".$naam2."',
                 Vereniging2            = '".$vereniging2."',
                 Licentie2              = '".$licentie2."',
                 Naam3                  = '".$naam3."',
                 Vereniging3            = '".$vereniging3."',
                 Licentie3              = '".$licentie3."'     					 
 		 WHERE  Id  = ".$id.";  ";
   } // end if triplet of meer

   if ($naam4 !=''){	
	 $query = "UPDATE inschrijf 
            SET Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."',
                 Licentie1              = '".$licentie1."',        
                 Naam2                  = '".$naam2."',
                 Vereniging2            = '".$vereniging2."',
                 Licentie2              = '".$licentie2."',     		
                 Naam3                  = '".$naam3."',
                 Vereniging3            = '".$vereniging3."',
                 Licentie3              = '".$licentie3."',     					 
                 Naam4                  = '".$naam4."',
                 Vereniging4            = '".$vereniging4."'
                 Licentie4              = '".$licentie4."'     					 
 		 WHERE  Id  = ".$id.";  ";
   } // end if 4x4 of meer
 
  if ($naam5 !=''){	
	 $query = "UPDATE inschrijf 
            SET Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."',
                 Licentie1              = '".$licentie1."' ,       
                 Naam2                  = '".$naam2."',
                 Vereniging2            = '".$vereniging2."'
                 Licentie2              = '".$licentie2."',     		
                 Naam3                  = '".$naam3."',
                 Vereniging3            = '".$vereniging3."',
                 Licentie3              = '".$licentie3."',     					 
                 Naam4                  = '".$naam4."',
                 Vereniging4            = '".$vereniging4."'
                 Licentie4              = '".$licentie4."'     					 
                 Naam5                  = '".$naam5."',
                 Vereniging5            = '".$vereniging5."',
                 Licentie5              = '".$licentie5."'     					 
 		 WHERE  Id  = ".$id.";  ";
   } // end if triplet of meer 
   
   if ($naam6 !=''){	
	 $query = "UPDATE inschrijf 
            SET Naam1                  = '".$naam1."',
                 Vereniging1            = '".$vereniging1."',
                 Licentie1              = '".$licentie1."',        
                 Naam2                  = '".$naam2."',
                 Vereniging2            = '".$vereniging2."'
                 Licentie2              = '".$licentie2."',     		
                 Naam3                  = '".$naam3."',
                 Vereniging3            = '".$vereniging3."',
                 Licentie3              = '".$licentie3."',     					 
                 Naam4                  = '".$naam4."',
                 Vereniging4            = '".$vereniging4."'
                 Licentie4              = '".$licentie4."'     					 
                 Naam5                  = '".$naam5."',
                 Vereniging5            = '".$vereniging5."',
                 Licentie5              = '".$licentie5."' ,
                 Naam6                  = '".$naam6."',
                 Vereniging6            = '".$vereniging6."',
                 Licentie6              = '".$licentie6."'     					 
		 WHERE  Id  = ".$id.";  ";
   } // end if triplet of meer 
  
	echo "<br>".$query;
     mysqli_query($con,$query) or die ('Fout in update inschrijf 1.Id '.$id);   
  

//  algemene velden	
	   $query = "UPDATE inschrijf 
             SET Email                     = '[versleuteld]',
			     Email_encrypt             = '".versleutel_string("@##".$email)."',
                 Telefoon                  = '[versleuteld]',
			     Telefoon_encrypt          = '".versleutel_string("@##".$telefoon)."',
                 Extra                     = '".$extra_vraag."',
                 Extra_invulveld           = '".$extra_invulveld."'
		  WHERE  Id  = ".$id.";  ";

 	echo "<br>".$query;
     mysqli_query($con,$query) or die ('Fout in update inschrijf 2.Id '.$id);   





}// end fout

?>
