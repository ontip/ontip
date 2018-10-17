<?php
// Database gegevens. 


//////// verwijderen

$delete = $_POST['Delete'];

foreach ($delete as $bestand)  { 

unlink($bestand);
//echo $bestand. "<br>";


} // end foreach


?>
<script type="text/javascript">
		window.location.replace('xml_file_browser.php');
</script>
