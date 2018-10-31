<?php
ob_start();
include 'mysql.php'; 
//include 'versleutel.php'; 

function redirect($url) {
    if(!headers_sent()) {
        //If headers not sent yet... then do php redirect
        header('Location: '.$url);
        exit;
    } else {
        //If headers are sent... do javascript redirect... if javascript disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
        exit;
    }
}

$naam          = $_POST['Naam']; 
$wachtwoord    = $_POST['secureontip']; 
$key           = $_POST['key'];
$url           = $_POST['return_page'];

//include('action.php');


//echo $url;
//echo "xxxxxxxxxxxxxxxxxxxxxxttttttttttttttxxxxxxxxxxx".$_POST['Wachtwoord'];

// kontrole op lengte

$error = 0;
$msg   = '';

if (strlen($wachtwoord) > 12){
   $error = 1;
   $message = 'Wachtwoord is te lang (maximaal 12 karakters)<br>';
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
//  $msg .= 'Wachtwoord is te lang (maximaal 12 karakters)<br>';
}

//echo "<br>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx".strlen($wachtwoord);
//exit;

if (strlen($wachtwoord) < 4){
   $error = 1;
   $message = 'Wachtwoord is te kort (minimaal 4 karakters)<br>';
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
}



  
if ($error == 0){

$encrypt = md5($wachtwoord);


$sql      = mysql_query("SELECT count(*) as Aantal FROM namen WHERE  Naam='".$naam."' and (Wachtwoord='".$encrypt."' or Wachtwoord_encrypt ='".$encrypt."' ) and Vereniging_id = ".$vereniging_id."  ") or die('Aanloggen: Fout in select');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];

if ($count == 1){

mysql_query("Update namen set Laatst = now(),
                              Aangelogd = 'J',
                              Wachtwoord = '[versleuteld]',
                              Wachtwoord_encrypt = '".$encrypt."' ,
                              IP_adres = '". $_SERVER['REMOTE_ADDR']."' 
                        WHERE Naam='".$naam."' and Vereniging_id = ".$vereniging_id."  ");



}
else {
$message = "Het aanloggen is niet goed gegaan. Mogelijk redenen :<br>";
$message .= "- Verkeerde usernaam of wachtwoord<br>";
$message .= "- Gebruik van Internet Explorer.<br>Deze kan problemen geven als gevolg van cookies.<br>";
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
}  // count = 0
}  // error  0


// in script 'aanloggen.php' staat nu target = _top'  dit zorgt voor het openen in hetzelfde window !!!!!
if ($url ==''){
 $url = "OnTip_index.php";
}
redirect($url);
ob_end_flush();
?>

</html>