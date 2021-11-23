<?php
 
// Database gegevens. 
include('mysqli.php');
//include('action.php');
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

 $qry      =  mysqli_query($con,"SELECT * from inschrijf where md5(Toernooi) = '".$toernooi_md5."'  and md5(Vereniging_id) = '".$vereniging_md5."' order by Id" )    or die('Fout in select inschrijf'); 
  
while($row = mysqli_fetch_array( $qry )) {
	
	$id          = $row['Id'];
	$volgnummer  = 'volgnummer-'.$id;
	$naam1       = 'naam1-'.$id;
	$naam2       = 'naam2-'.$id;
	$naam3       = 'naam3-'.$id;
	$vereniging1 = 'vereniging1-'.$id;
	$vereniging2 = 'vereniging2-'.$id;
	$vereniging3 = 'vereniging3-'.$id;

    $query = "UPDATE inschrijf 
             SET Volgnummer             = '".$$volgnummer."',
				 Naam1                  = '".$$naam1."',
                 Vereniging1            = '".$$vereniging1."'
             WHERE  Id  = ".$id."  ";

			 
   if (isset ($$naam2)){
	 
     	 $query = "UPDATE inschrijf 
                SET Volgnummer             = '".$$volgnummer."',
                     Naam1                 = '".$$naam1."',
                    Vereniging1            = '".$$vereniging1."',
                    Naam2                  = '".$$naam2."',
                    Vereniging2            = '".$$vereniging2."'
     		 WHERE  Id  = ".$id."  ";
					
   } // end if geen single en doublet
	
   if (isset ($$naam3)){	
	 $query = "UPDATE inschrijf 
                SET Volgnummer             = '".$$volgnummer."',
                    Naam1                  = '".$$naam1."',
                    Vereniging1            = '".$$vereniging1."',
                    Naam2                  = '".$$naam2."',
                    Vereniging2            = '".$$vereniging2."',
                    Naam3                  = '".$$naam3."',
				    Vereniging2            = '".$$vereniging2."'
         WHERE  Id  = ".$id."  ";
   } // end if triplet of meer
	
	// echo "<br>".$query;
    mysqli_query($con,$query) or die ('Fout in update inschrijf .Id '.$id);   
	
	
}// end while


if (isset ($_GET['sort'])){
	$toernooi_md5    = $_GET['id1'];
	$vereniging_md5  = $_GET['id2'];  // let op !!  vereniging
	
//	echo  "SELECT * from inschrijf where md5(Toernooi) = '".$toernooi_md5."'  and md5(Vereniging) = '".$vereniging_md5."' order by Inschrijving";
    $volgnummer  = 10;
    $qry      =  mysqli_query($con,"SELECT * from inschrijf where md5(Toernooi) = '".$toernooi_md5."'  and md5(Vereniging) = '".$vereniging_md5."' order by Inschrijving" )    or die('Fout in select inschrijf'); 
      
    while($row = mysqli_fetch_array( $qry )) {
		 $query = "UPDATE inschrijf 
                SET Volgnummer             = '".$volgnummer."'
          WHERE  Id  = ".$row['Id']."  ";
		  
	//	  echo "<br>".$query;
		   mysqli_query($con,$query) or die ('Fout in update sort inschrijf .Id '.$id);   
      $volgnummer = $volgnummer+ 10;
	  
		
    }// end while
	
    } // end if


if ($delete !='')  {
  foreach ($delete as $deleteid)
   {
	
	     
	 	mysqli_query($con,"DELETE from inschrijf  where Id =  ".$deleteid." ");
	
		   
   }// end foreach
} // end if

}// end fout

?>
