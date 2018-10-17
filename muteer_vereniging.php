<?php 
/*   Programma   : muteer_namen.php
     Auteur      : Erik Hendrikx
     
     Aangeroepen vanuit  : beheer_ontip.php
     
     Functie : Verwerken van mutaties op de tabellen namen en vereniging  */
     
ob_start();

// voor straks terug 
$tab     = 3; // algemeen
$toernooi = $_POST['toernooi'];


$replace = "toernooi=".$toernooi."&tab=".$tab."";

$error       = 0 ;
$message     = '';
 
// Controles

if ($_POST['url_website'] ==''){
	$message .= '* URL website mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if ($_POST['url_logo'] ==''){
	$message .= '* URL logo mag niet leeg zijn ! <br> ';
  $error   = 1;
}
	
if ($_POST['grootte_logo'] ==''){
	$message .= '* Grootte logo mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if ($_POST['plaats'] ==''){
	$message .= '* Plaats mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if ($_POST['email'] ==''){
	$message .= '* Email mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if ($_POST['volledige_naam'] ==''){
	$message .= '* Naam contact persoon mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if ($_POST['url_website'] ==''){
	$message .= '* Url website mag niet leeg zijn ! <br> ';
  $error   = 1;
}

if (substr($_POST['url_website'],0,4)  != 'http' ){
  $message .= '* Naam website begint niet met http ! <br> ';
  $error   = 1;
}


if ($error == 0 ){

// Database gegevens. 
include('mysql.php');

$update = "UPDATE vereniging  SET Url_website         = '".$_POST['url_website']."' ,
                                  Url_logo            = '".$_POST['url_logo']."' ,
                                  Grootte_logo        = '".$_POST['grootte_logo']."' ,
                                  Naam_contactpersoon = '".$_POST['volledige_naam']."' ,
                                  Email               = '".$_POST['email']."',
                                  Tel_contactpersoon  = '".$_POST['tel_contactpersoon']."',
                                  Plaats              = '".$_POST['plaats']."',
                                  Email_noreply       = '".$_POST['email_noreply']."',
                                  Indexpagina_kop_jn  = '".$_POST['indexpagina_kop_jn']."',
                                  Lijst_sortering     = '".$_POST['lijst_sortering']."',
                                  Max_aantal_sms      = '".$_POST['max_aantal_sms']."' , 
                                  Privacy_tekst       = '".$_POST['privacy_tekst']."' 
                            where Id     = '".trim($_POST['vereniging_id'])."' ;";
                     	
//echo $update."<br>";
mysql_query($update) or die ('fout in update');
} 
else { 

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Toon foutmeldingen

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
    <?php


 } // error = 1

?> 
<script language="javascript">
		window.location.replace('beheer_ontip.php?<?php echo $replace; ?>');
</script>
<?php
