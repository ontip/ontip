<?php
header("Location: ".$_SERVER['HTTP_REFERER']);
$ip = $_SERVER['REMOTE_ADDR'];
 
include ('action.php');
include('conf/mysqli.php');
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

 
  
  $delete = $_POST['delete'];
  
	foreach ($delete as $deleteid)	{
	 
		 $delete_query = "DELETE from toernooi_uitslag  where Id = ".$deleteid;
	  	  mysqli_query($con,$delete_query) or die ('Fout in update :    '.$update_query);
		//echo $delete_query;
		}

?>
