<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
include 'mysql.php';

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
  
  mysql_query($query) or die (mysql_error()); 
}
 


foreach ($_POST['Delete']  as $deleteid)
{

//echo "Delete from boule_maatje where Id='".$deleteid."'  <br>  ";

mysql_query("Delete from boule_maatje where Id='".$deleteid."'    ") ;  


}



?> 
