<? 
ob_start();
include('versleutel_string.php');
include("action.php");
// formulier POST variabelen ophalen en kontroleren

if (isset($_POST['zendform'])) 
{ 
    foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
        } 
    } 
} 
else {
	exit;
	
}
 
// Controles
$error   = 0;
$message = '';

if ($challenge != versleutel_string('@##'.$respons) ){
	$message .= "* Anti spam (robot  controle) is niet (juist) ingevuld<br>";
	$error = 1;
} 

if(!isset($vereniging)){
	$vereniging = 'onbekend';
	
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
 
 /// alle controles goed 
if ($error == 0){
	 
 
//header ("location: vraag_gesteld.php"); 
} // end error	




ob_end_flush();
?> 