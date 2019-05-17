<?php
ob_start();

//// Database gegevens. 

include ('mysqli.php');
ini_set('default_charset','UTF-8');
$kleur = $_GET['kleur'];
$kleur = str_replace('_','#', $kleur);



if ($kleur !=''){
$query = "UPDATE vereniging set Indexpagina_achtergrond_kleur  = '".$kleur."' where Vereniging = '".$vereniging."'  ";
echo $query;

mysqli_query($con,$query) or die ('Fout in update kleur'); 
}

ob_end_flush();

?>
<script language="javascript">
		window.location.replace('index.php?tab=1');
</script>
