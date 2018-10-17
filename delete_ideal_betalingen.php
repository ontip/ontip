<?php 
//header("Location: ".$_SERVER['HTTP_REFERER']);

ob_start();
ini_set('display_errors', 'OFF');
error_reporting(E_ALL);

//// Database gegevens. 

include ('mysql.php');


// Controles
$challenge  =  $_POST['challenge'];
$respons    =  $_POST['respons'];
$toernooi   =  $_POST['toernooi'];

$replace = "toernooi=".$toernooi."";

$error   = 0;
$message = '';

if ($respons == '') {
	$message = "* Antispam code is niet ingevuld.<br>";
	$error = 1;
}
else {

if ($challenge != $respons){
	$message = "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon foutmeldingen

if ($error == 1){
  $error_line      = explode("<br>", $message);   /// opsplitsen in aparte regels tbv alert
  ?>
   <script language="javascript">
        alert("Er zijn een of meer fouten gevonden bij het invullen :" + '\r\n' + 
            <?php
              $i=0;
              while ( $error_line[$i] <> ''){    
               ?>
              "<?php echo $error_line[$i];?>" + '\r\n' + 
              <?php
              $i++;
             } 
             ?>
              "")
    </script>
    <script type="text/javascript">
		history.back()
	</script>
<?php
 } // error = 1

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

setlocale(LC_ALL, 'nl_NL');

$Bevestigen  = $_POST['Bevestigen'];
$toernooi    = $_POST['toernooi'];


foreach ($Bevestigen as $bevestigid)
{

//echo "DELETE FROM ideal_transacties where Toernooi = '".$toernooi."' and  Id= ".$bevestigid."<br> ";
$qry      = mysql_query("DELETE FROM ideal_transacties where Toernooi = '".$toernooi."' and Id= ".$bevestigid." " )    or die('Fout in select bevestig id');  

  
}/// end for each bevestigen of annuleren

ob_end_flush();
?> 
<script language="javascript">
		window.location.replace('beheer_ideal_transacties.php?<?php echo $replace; ?>');
</script>
