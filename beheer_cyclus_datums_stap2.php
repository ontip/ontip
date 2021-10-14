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

header("Location: ".$_SERVER['HTTP_REFERER'].""); 

$vereniging_id   = $_POST['vereniging_id'];
$vereniging_naam = $_POST['vereniging_naam'];
$toernooi        = $_POST['toernooi'];
$delete          = $_POST['delete'];
$url             = $_POST['return_page'].'?toernooi='.$toernooi;

include('mysqli.php');
include('action.php');
 
$error = 0;
$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'  order by Datum" )     ; 
$count    = mysqli_num_rows($sql);


if ($_POST['datum_new'] != '' and $count  > 10 and $delete  =='' ){
	
$error =1;
	?>
	<script type="text/javascript">
	   	alert("Max 10 datums per toernooi!")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}

// check date format new

// 01234567890
// 2020-02-26


$datum       =   $_POST['datum_new'];
$datum_maand = substr($datum ,5,2);
$datum_jaar  = substr($datum ,0,4);
$datum_dag   = substr($datum ,8,2);


// checkdate ( int $month , int $day , int $year ) :
$check = checkdate($datum_maand, $datum_dag, $datum_jaar);

if ($check === false and $delete  =='' and $datum !='' ) { 
     /// reset naar vandaag
	 $error =1;
	 ?>
	 <script type="text/javascript">
	   	alert("Datum is niet geldig <?php echo $datum;?> ")
		  window.location.replace('<?php echo $url;?>')
</script>
<?php
}
 

if ($error == 0 and $delete  ==''){
	
$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."'  order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		
		   $datum     = $_POST['datum_'.$row['Id']];
		   $locatie   = $_POST['locatie_'.$row['Id']];
	 
	 if ($datum !='' and strlen($datum) != 10){
	        $error =1;
	           ?>
	      <script type="text/javascript">
	       	alert("Datum lengte is geen 10!")
	    	  window.location.replace('<?php echo $url;?>')
          </script>
          <?php
      } // end if
    else {
      mysqli_query($con,"Update  toernooi_datums_cyclus  
	               set Datum   = '".$datum. "', 
	                   Locatie = '".$locatie."', Laatst = now()   where Id = ".$row['Id']." ") ;
    }  

}// end while


// toevoegen
if (isset($_POST['datum_new'])   and $_POST['datum_new'] !=''   ){
 
 mysqli_query($con,'insert into toernooi_datums_cyclus (Id, Vereniging_id, Vereniging, Toernooi,Datum, Laatst) 
                   values (0, '.$vereniging_id.',"'.$vereniging_naam.'","'.$toernooi.'","'.$_POST['datum_new'].'", now() )') or die ('Fout in insert :'.$_POST['datum_new'] ) ;

}
 

}  // end if  error

if ($error == 0 and $delete !='')  {
  foreach ($delete as $deleteid)
   {
	
    //echo "DELETE from npc_vereniging_teams  where Id =  ".$deleteid." <br>";
	mysqli_query($con,"DELETE from toernooi_datums_cyclus  where Id =  ".$deleteid." ");
	
		   
   }// end foreach
} // end if


		?>			                   