<?php

//include('action.php');

$id_md5 = $_GET['id'];
 
include('mysqli.php');
 	$qry       = mysqli_query($con,"SELECT * FROM `toernooi_uitslag` where   md5(Id) = '".$id_md5."'   ")            or die('fout in select');  
    $result    = mysqli_fetch_array( $qry );
   for ($i=1;$i<11;$i++)	{
	    $var = 'voor'.$i;
		$$var = $result['Voor'.$i];
	}
	
	$naam      = $result['Naam'];
	$toernooi  = $result['Toernooi_naam'];
  
   if ($naam ==''){
		header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi);
   }
   
    $var1 = 'Voor'.$ronde;
	$var2 = 'Tegen'.$ronde;
	$var3 = 'Invoer_tijd'.$ronde;
	$laatste = 0;

//haal 	vershcil van laatst ingevoerde

 
	for ($i=1;$i<11;$i++){
		
		$var        = 'Invoer_tijd'.$i;
		echo "<br>".$result[$var];
			
		if ($result[$var] !='')	{
		
		echo "<br>SELECT NOW() as Nu,".$var." as Invoer, TIMEDIFF(NOW()   , '".$result[$var]."'  ) as Verschil";
		
		$sql2      = mysqli_query($con,"SELECT NOW() as Nu,".$var." as Invoer, TIMEDIFF(NOW()   , '".$result[$var]."'   ) as Verschil" ); 
		$result2   = mysqli_fetch_array( $sql2 );
		 
			$verschil  = $result2['Verschil'];
			$nu        = $result2['Nu'];
			$ronde     = $i;
		}
	}// end for
	 
 	 
	
	$tijd      = explode (":", $verschil);
    $uren      = $tijd[0];
    $mins      = $tijd[1];
    $secs      = $tijd[2];
    $tot_secs  = $secs + (120*$mins) + (3600 * $uren);
  
    // half uur is 30 min x 60 sec = 1800 sec
  
/*  
   echo "laatst is ".$verschil;
   echo "<br>Nu is ". $nu;
   echo "<br>verschil is ".$tot_secs;
  */ 
  
    if ($tot_secs > 1800){
		header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi."&halfuur");
		
		
	} else {
	
    $var1 = 'Voor'.$ronde;
	$var2 = 'Tegen'.$ronde;
	$var3 = 'Invoer_tijd'.$ronde;
	
    $update_query = "UPDATE `toernooi_uitslag` SET ".$var1." = NULL, ".$var2." = NULL,  ".$var3." = NULL WHERE md5(Id) = '".$id_md5."' " ;
		
	
  //echo $update_query;
  
       mysqli_query($con,$update_query) or die ('Fout in update :    '.$update_query);
 
	header("Location: doorgeven_uitslag_stap1.php?toernooi=".$toernooi);
	}
	
 
 
 
?>
