<?php
ob_start();

//// Database gegevens. 

include ('mysql.php');
include ('versleutel_kenmerk.php'); 

$kenmerk = $_POST['Kenmerk'];
$naam1   = $_POST['Naam1'];
$toernooi = $_POST['toernooi'];


//  GFDD.FFFD
//  012345678 

// zonder punt
$_kenmerk  = substr($kenmerk,0,4).substr($kenmerk,5,4);

/// roep versleutel routine aan
/// versleutel_licentie($waarde, $richting, $delta)
$decrypt  = versleutel_kenmerk($_kenmerk,'', 20);

//echo $decrypt;
// twist eerste en tweede helft
$kenmerk = substr($decrypt,4,4).substr($decrypt,0,4);

//echo "Kenmerk : ". $kenmerk. "<br>";

//echo $inschrijf."<br>";


$qry_inschrijving      = mysql_query("SELECT * from inschrijf Where Naam1 = '".$naam1."' and DATE_FORMAT(Inschrijving, '%d%H%i%s') = '".$kenmerk."'  " ) OR die ('Fout in select')   ;
//echo "SELECT * from inschrijf Where Naam1 = '".$naam1."' and DATE_FORMAT(Inschrijving, '%d%H%i%s') = '".$kenmerk."'  ";

$result_i              = mysql_fetch_array( $qry_inschrijving  );

if (!isset ($result_i['Id'])){
	?>
	<script language="javascript">
        alert("De inschrijving met als kenmerk '<?php echo $_POST['Kenmerk']; ?>' kon niet gevonden worden." +
         "Het window kan veilig afgesloten worden."  )
    </script>
  <script type="text/javascript">
		    window.close(); 
	</script>
<?php 
} else { 
    $parm = 'Id='.$result_i['Id']."&Kenmerk=".$_POST['Kenmerk']."&toernooi=".$toernooi; 
?>
<script language="javascript">
		window.location.replace('zelf_inschrijving_muteren_stap1.php?<?php echo $parm; ?>');
</script>
<?php
}    
?>

