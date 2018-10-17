<?php
ob_start();
include 'mysql.php'; 
include 'versleutel.php'; 
include ('../ontip/versleutel_string.php'); // tbv telnr en email

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
$check         = $_POST['zendform'];

if ($check != date('ymd')) {
	$error = 1;
  echo 'Er wordt geprobeerd via een onbeveiligde manier binnen te komen.<br>';
  exit;
}


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

 if (strlen($naam) < 1){
   $error = 1;
   $message = 'Naam is niet ingevuld<br>';
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

/// roep versleutel routine aan
/// 6 maart 2018 aanpassing voor md5 versleuteling


// aanpassing v
$encrypt = versleutel($wachtwoord);

$sql      = mysql_query("SELECT count(*) as Aantal,Laatste_wijziging_wachtwoord FROM namen WHERE  Naam='".$naam."' and ( Wachtwoord='".$encrypt."' or Wachtwoord = '".md5($wachtwoord)."'   )and Vereniging_id = ".$vereniging_id."  ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];

$laatste_wijziging_wachtwoord = $result['Laatste_wijziging_wachtwoord'];

// echo "aaaa".$count;
// echo  "SELECT count(*) as Aantal FROM namen WHERE  Naam='".$naam."' and Wachtwoord='".$encrypt."' and Vereniging_id = ".$vereniging_id."  ";
//


if ($count == 0){  
   $message .= "- Verkeerde usernaam of wachtwoord<br>";

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
function dateDifference($date_1 , $date_2 , $differenceFormat = '%d' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}
// check op laatste wijziging wachtwoord

 $sql2      = mysql_query("SELECT TIMEDIFF(NOW(), '".$laatste_wijziging_wachtwoord."'  ) as Verschil" );
 $result2   = mysql_fetch_array( $sql2 );
 
 $dStart = substr($laatste_wijziging_wachtwoord,0,10);
 $dEnd   = date('Y-m-d');
  
 $str = strtotime(date("Y-m-d")) - (strtotime($dStart));
 $interval = floor($str/3600/24);

 
 if ($interval > 360 and $dStart != '0000-00-00' ){

  	$count = 0;
 ?>
   <script language="javascript">
        alert("Wachtwoord moet gewjzigd worden (langer dan 1 jaar oud).\r\nZie aanlog scherm.")
    </script>
  <script type="text/javascript">
		history.back()
	</script>
<?php
}


if ($count == 1){

	
if ($dStart == '0000-00-00'){
	
	mysql_query("Update namen set Laatst = now(),
                                Laatste_wijziging_wachtwoord  = '".date('Y-m-d H:i:s')."' 
                          WHERE Naam='".$naam."' and Vereniging_id = ".$vereniging_id."  ");
  }
		 
// andere users resetten

mysql_query("Update namen set Laatst = now(),
                              IP_adres = '',
                              Aangelogd = 'N' where 
                              IP_adres = '". $_SERVER['REMOTE_ADDR']."' 
                              and Vereniging_id= ".$vereniging_id."  ");

// 6 maart 2018 aanpassing voor md5 versleuteling

$sql      = mysql_query("SELECT count(*) as Aantal FROM namen WHERE  Naam='".$naam."' and Wachtwoord='".$encrypt."' and Vereniging_id = ".$vereniging_id."  ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$count    = $result['Aantal'];

$sql      = mysql_query("SELECT Email FROM namen WHERE  Naam='".$naam."' and Wachtwoord='".$encrypt."' and Vereniging_id = ".$vereniging_id."  ") or die(' Fout in select');  
$result   = mysql_fetch_array( $sql );
$Email = $result['Email'];


if ($count ==1){   // oude versleuteling
	$encrypt = md5($wachtwoord);
}	

if ($result['Email']  !='[versleuteld]' ){
 
  $encrypt_email = versleutel_string('@##'.$Email);
  $email             = '[versleuteld]' ;
}
else {
  $encrypt_email = $result['Email_encrypt'];
  $email             = $result['Email'] ;
}
/*
echo 	"Update namen set Laatst = now(),
                              Aangelogd         = 'J',
                              Wachtwoord        = '".$encrypt."', 
                              IP_adres          = '". $_SERVER['REMOTE_ADDR']."' ,
                              Email             = '".$email."', 
                              Email_encrypt = '".$encrypt_email."'
                        WHERE Naam='".$naam."' and Vereniging_id = ".$vereniging_id."  ";
echo "xxxxxxxxxxxxxxxxxxxxxxxxxx".versleutel_string($encrypt_email);                        
 exit;
*/                        
mysql_query("Update namen set Laatst = now(),
                              Aangelogd         = 'J',
                              Wachtwoord        = '".$encrypt."', 
                              IP_adres          = '". $_SERVER['REMOTE_ADDR']."' ,
                              Email             = '".$email."', 
                              Email_encrypt = '".$encrypt_email."'
                        WHERE Naam='".$naam."' and Vereniging_id = ".$vereniging_id."  ");



// in script 'aanloggen.php' staat nu target = _top'  dit zorgt voor het openen in hetzelfde window !!!!!
//$url_redirect
$sql           = mysql_query("SELECT * from vereniging where Id = ".$vereniging_id."  ") or die(' Fout in select ver');  
$result        = mysql_fetch_array( $sql );
$url_redirect  = $result['Url_redirect'];


if (strpos($url_redirect,'index.php')== 0){
	$url_redirect = $url_redirect.'index.php';
	
}

//echo $url_redirect ;
//exit;

if ($url_redirect !='') { 
  $url = $url_redirect;
}
else {
	$url ='index.php';
}

redirect($url);

}  // count = 1

}  // error  0

?>
