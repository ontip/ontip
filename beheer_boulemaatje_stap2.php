<?php
# beheer_boulemaatje_stap1.php.
# aanmelden zonder boule partner of juist op zoek naar een
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 11apr2019         -            E. Hendrikx 
# Symptom:   		   None.
# Problem:     	   None.
# Fix:             PHP7 
# Reference: 
 
header("Location: ".$_SERVER['HTTP_REFERER']);
include 'mysqli.php';

// formulier POST variabelen ophalen 


// formulier POST variabelen ophalen en kontroleren

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


//

echo  "Aantal records : " . $aantal_records. "<br>";


for ($i=1;$i<=$aantal_records;$i++){
	
	$id = $_POST['Id-'.$i];
	$query="UPDATE boule_maatje 
               SET Status    = '".$_POST['Status-'.$i]."'    WHERE  Id           = '".$id."'  ";
  
  mysqli_query($con,$query) or die (mysql_error()); 
}
 


foreach ($_POST['Delete']  as $deleteid)
{

//echo "Delete from boule_maatje where Id='".$deleteid."'  <br>  ";

mysqli_query($con,"Delete from boule_maatje where Id='".$deleteid."'    ") ;  


}



?> 
