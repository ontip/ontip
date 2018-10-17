<?php
$Aantal  = $_POST['Aantal'];
$Dir     = $_POST['Imagedir'];
//echo "Aantal : " . $Aantal;

// Database gegevens. 
include('mysql.php');
for ($i==1;$i<= $Aantal;$i++){
		
		   $file        = $_POST['pdf-'.$i];     
		   if ($file !=''){
		   	$del = $Dir. "/".$file;
		   	unlink($del);
//        echo $del. " verwijderd <br>";
  }
}
echo "</div>";
ob_end_flush();
?> 
<script type="text/javascript">
		window.location.replace('delete_pdf_flyer_stap1.php');
</script>