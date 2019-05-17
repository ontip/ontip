<?php
$Aantal  = $_POST['Aantal'];
$Dir     = $_POST['Imagedir'];
//echo "Aantal : " . $Aantal;

// Database gegevens. 
include('mysqli.php');
for ($i==1;$i<= $Aantal;$i++){
		
		   $file        = $_POST['file-'.$i];     
		   if ($file !=''){
		   	$del = $Dir. "/".$file;
		   	unlink($del);
        //echo $del. " verwijderd <br>";
  }
}
echo "</div>";
ob_end_flush();
?> 
<script type="text/javascript">
		window.location.replace('image_gallery.php');
	</script>