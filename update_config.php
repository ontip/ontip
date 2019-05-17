<?php
ob_start();

//// Database gegevens. 

include ('mysqli.php');

// Vereniging niet als POST waarde ivm diakrieten
$variabele  = $_POST['Variabele'];
$waarde     = $_POST['Waarde'];
$toernooi   = $_POST['Toernooi'];
$bron       = $_POST['Bron'];

if (!empty($variabele) and !empty($waarde)) {
$query = "UPDATE config set Waarde ='".$waarde."', Parameters = '#r' where Vereniging = '".$vereniging."' and Toernooi ='".$toernooi."' and Variabele = '".$variabele."' ";
 
//echo $query;
                        
mysqli_query($con,$query) or die (mysql_error()); 

}

if ($bron =='gallery' and $waarde == 'leeg'){
$query = "UPDATE config set Waarde ='' , Parameters = '#r' where Vereniging = '".$vereniging."' and Toernooi ='".$toernooi."' and Variabele = '".$variabele."' ";
mysqli_query($con,$query) or die (mysql_error()); 




}

ob_end_flush();


 if (!empty($bron) and $bron =='gallery') {
?>
<script language="javascript">
		window.location.replace('image_gallery.php?toernooi=<?php echo $toernooi;?>');
</script>
<?php  } else {?>
<script language="javascript">
		window.location.replace('beheer_ontip.php?toernooi=<?php echo $toernooi; ?>&tab=4');
</script>
<?php }?>
