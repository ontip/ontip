<?php
ob_start();

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
//
/// Insert in tabel inschrijf

$date     = date('YmdHis');

// Database gegevens. 
include('mysql.php');

/// Ophalen tekst kleur

$sql        = mysql_query("SELECT Tekstkleur,Link From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select');  
$result     = mysql_fetch_array( $sql );
$tekstkleur = $result['Tekstkleur'];
$link       = $result['Link'];

?>
<body bgcolor="<?php echo($achtergrond_kleur); ?>" text="<?php echo($tekstkleur); ?>" link="<?php echo($link); ?>" alink="<?php echo($link); ?>" vlink="<?php echo($link); ?>">
<?php

/// Insert in config bestand met sleutel. Zonder dit record kan niet verwijderd worden

$query = "INSERT INTO `config` (`Id`, `Regel`, `Vereniging`, `Toernooi`, `Datum`, `Variabele`, `Waarde`) 
        VALUES (0, 9999, '".$vereniging."','".$toernooi."' ,'".$datum."', 'delete_key', '".$date."')";
        
 
//echo $query;
                        
mysql_query($query) or die (mysql_error()); 

//  mail versturen

$subject = 'Bevestiging verwijderen  ';
$subject .= $toernooi;

$to   = $email_organisatie .  ', '; // note the comma
$to  .= $email_cc;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '. $email_noreply  . "\r\n" . 
       'Reply-To: '. $email_noreply . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "U heeft aangegeven het toernooi ".$toernooi." te willen verwijderen uit het systeem.<br><br>" .  "\r\n";

$bericht .= "Klik op de onderstaande link om het toernooi te verwijderen :<br> " . "\r\n";


if ($vereniging == 'Le Ch&#226teau') {
   $bericht .= "<a href = 'http://www.boulamis.nl/lechateau/delete_toernooi.php?toernooi=". $toernooi ."&key=".$date."'>Verwijder ".$toernooi."</a>";
  }
  else {
      $bericht .= "<a href = '".$prog_url."delete_toernooi.php?toernooi=". $toernooi ."&key=".$date."'>Verwijder ".$toernooi."</a>";
}


mail($to, $subject, $bericht, $headers);


echo "<div style='font-size:14pt;font-weight:bold;'>"; 
echo "De mail ter bevestiging van het verwijderen van het ".$toernooi." toernooi is verstuurd <br><br></div> ";
echo "<a href='index.php'>Klik hier om naar het menu scherm terug te keren.</a><br>"; 


?>
</body>
 <?php

ob_end_flush();
?> 