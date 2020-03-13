<?php
# 21feb2020         1.0.0       E. Hendrikx 
# Symptom:   		 Ongeldige datum geeft probleem met insert in toernooi_ontip
# Problem:     	     None
# Fix:               checkdate functie
# Feature:           
# Reference: 

# 13mar2020          1.0.0       E. Hendrikx 
# Symptom:   		 Delete werkt niet als gevolg van ongeldige datum check
# Problem:     	     None
# Fix:               ongeldige datum check alleen als er geen delete is aangevinkt
# Feature:           
# Reference: 



//header("Location: ".$_SERVER['HTTP_REFERER'].""); 
function redirect($url) {
    if(!headers_sent()) {
        //If headers not sent yet... then do php redirect
        header('Location: '.$url);
        exit;
    } else {
        //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}
$vereniging_id   = $_POST['vereniging_id'];
$vereniging_naam = $_POST['vereniging_naam'];
$toernooi        = $_POST['toernooi'];
$delete          = $_POST['Delete'];
$url             = 'beheer_cyclus_datums.php?toernooi='.$toernooi;

include('mysqli.php');
//include('action.php');


$error = 0;
$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'  order by Datum" )     ; 
$count    = mysqli_num_rows($sql);


if ($_POST['datum_new'] != '' and $count > 20 and $delete  =='' ){
	
$error =1;
	?>
	<script type="text/javascript">
	   	alert("Max 20 datums per toernooi!")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}

// check date format new

// 01234567890
// 2020-02-26


$datum =   $_POST['datum_new'];
$datum_maand = substr($datum ,5,2);
$datum_jaar  = substr($datum ,0,4);
$datum_dag   = substr($datum ,8,2);


// checkdate ( int $month , int $day , int $year ) :
$check = checkdate($datum_maand, $datum_dag, $datum_jaar);

if ($check === false and $delete  =='') { 
     /// reset naar vandaag
	 $error =1;
	 ?>
	 <script type="text/javascript">
	   	alert("Datum is niet geldig <?php echo $datum;?> ")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}

//// 2017-01-10
//// 01234567890

if (strlen($datum) != 10){
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Nieuwe datum lengte is geen 10!")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}

if ($error == 0 and $delete  ==''){
	
$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'  order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		
			  $datum     = $_POST['datum_'.$row['Id']];
		      $locatie   = $_POST['locatie_'.$row['Id']];
//// 2017-01-10
//// 01234567890

if ($datum !='' and strlen($datum) != 10){
	$error =1;
	?>
	<script type="text/javascript">
	   	alert("Datum lengte is geen 10!")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}
else {


   mysqli_query($con,"Update  toernooi_datums_cyclus  set Datum = '".$datum. "', Locatie = '".$locatie."', Laatst = now()   where Id = ".$row['Id']." ") ;
}  

}
// toevoegen
if (isset ($_POST['datum_new'])   and $_POST['datum_new'] !='' and $_POST['datum_new'] !='jjjj-mm-dd'  ){
                   
                   
 mysqli_query($con,'insert into toernooi_datums_cyclus (Id, Vereniging_id, Vereniging, Toernooi,Datum, Laatst) 
                   values (0, '.$vereniging_id.',"'.$vereniging_naam.'","'.$toernooi.'","'.$_POST['datum_new'].'", now() )') ;

}

}  // end if
if ($error == 0 and $delete !='')  {
  foreach ($delete as $deleteid)
   {
	
    //echo "DELETE from npc_vereniging_teams  where Id =  ".$deleteid." <br>";
	mysqli_query($con,"DELETE from toernooi_datums_cyclus  where Id =  ".$deleteid." ");
	
		   
   }// end foreach
} // end if


redirect($url);	


	

		?>			                   