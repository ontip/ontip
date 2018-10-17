<?php
$Aantal  = $_POST['Aantal'];
$Dir     = "/webspace/httpdocs/degemshoorn.nl/fotoboek/";
$delete  = $_POST['delete'];


//echo "Aantal : " . $Aantal;

// Database gegevens. 
include('mysql.php');


foreach ($delete as $deleteid)
{
		
		$sql      = mysql_query("SELECT * from gemshoorn_fotoboek where Id = '".$deleteid."'  order by Laatst desc ") or die(' Fout in select fotos'); 
		$row      = mysql_fetch_array( $sql )
		
		$file =   = $row['Image_file'];
		echo $file."<br>";
		
		
		   if ($file !=''){
		   	$del = $Dir. "/".$file;
		//   	unlink($del);
        echo $del. " verwijderd <br>";
     }
}
echo "</div>";
ob_end_flush();
?> 
<!--script type="text/javascript">
		window.location.replace('image_gallery.php');
	</script>