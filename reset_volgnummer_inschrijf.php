<?php
ob_start();

//// Database gegevens. 

$toernooi = $_GET['toernooi'];


include ('mysql.php');

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

$i=1;

//// SQL Queries
$qry      = mysql_query("SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving " )    or die('Fout in select');  

while($row = mysql_fetch_array( $qry )) {


$id = $row['Id'];

$query="UPDATE inschrijf 
               SET Volgnummer   = ".$i."
            WHERE  Id           = ".$id."  ";

//echo $i.".    ". $query."<br>";
 mysql_query($query) or die ('Fout in update inschrijving'); 
 $i++;
 
}; // end for i update   


ob_end_flush();

?>

<script language="javascript">
		window.location.replace('beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>');
</script>

