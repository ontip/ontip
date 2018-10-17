<?php 
header("Location: ".$_SERVER['HTTP_REFERER']);
include 'mysql.php';

// formulier POST variabelen ophalen 


// formulier POST variabelen ophalen en kontroleren

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


//
// Controles
$error   = 0;
$message = '';

if ($respons == '') {
	$message .= "* Antispam code is niet ingevuld.<br>";
}
else {

if ($challenge != $respons){
	$message .= "* Ingevulde Antispam code is niet gelijk aan opgegeven code.<br>";
	$error = 1;
}
}

if ($Naam == '') {
	$message .= "* Naam is niet ingevuld.<br>";
	$error = 1;
}

if ($Vereniging_speler == '') {
	$message .= "* Vereniging is niet ingevuld.<br>";
	$error = 1;
}

if ($Telefoon == '') {
	$message .= "* Telefoon nr is niet ingevuld.<br>";
	$error = 1;
}

if ($Email == '') {
	$message .= "* Email adres is niet ingevuld.<br>";
	$error = 1;
}


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
if ($error == 0 and $message == ''){



/// Mail versturen
$subject = 'Boule maatje gevonden ';
$subject .= $toernooi_voluit . '  ' ; 
$subject .= $Naam;

// subject pas aanpassen na subject ivm afkeuring mail op vreemde tekens in subject

$toernooi_voluit   = str_replace("&#226", "â", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#233", "é", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#234", "ê", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#235", "ë", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#239", "ï", $toernooi_voluit);
$toernooi_voluit   = str_replace("&#39", "'",  $toernooi_voluit);
$toernooi_voluit   = str_replace("&acirc;", "â",  $toernooi_voluit);

setlocale(LC_ALL, 'nl_NL');
$dag   = 	substr ($datum , 8,2);         
$maand = 	substr ($datum , 5,2);         
$jaar  = 	substr ($datum , 0,4);         

$to          = $email_organisatie;

$from          = substr($prog_url,3,-1)."@ontip.nl";	
$email_return  = 'bounce@ontip.nl';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Return-Path: '.$email_return    . "\r\n" . 
       'Reply-To: '   . $from . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$bericht = "<table>"   . "\r\n";
$bericht .= "<tr><td><img src= '". $url_logo ."' width=110>"   . "\r\n";
$bericht .= "<td style= 'font-family:Arial;font-size:14pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$bericht .= "</table>"   . "\r\n";
$bericht .= "<br><br><hr/>".   "\r\n";

$bericht .= "<br><br><h3><u>Mijn gegevens</u></h3>".   "\r\n";
	
$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>Naam</td><td>"         .  $Naam    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Vereniging</td><td>"   .  $Vereniging_speler    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Licentie</td><td>"     .  $Licentie    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Telefoon</td><td>"     .  $Telefoon        ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Email     </td><td>"   .  $Email       ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n";

$bericht .= "<br><br><h3>Zou graag spelen met (een van deze spelers) :</h3>".   "\r\n";

$i=1;

foreach ($Select as $selectid)
{

$qry      = mysql_query("SELECT * from boule_maatje where Id= '".$selectid."' " )    or die(mysql_error());  
$row      = mysql_fetch_array( $qry);

$bericht .= "<table Style='font-family:verdana;font-size:9pt;'>"   . "\r\n";
$bericht .= "<tr><td  width=200>(". $i."). Naam</td><td>"         .  $row['Naam']    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Vereniging</td><td>"   .  $row['Vereniging_speler']    ."</td></tr>".  "\r\n";
$bericht .= "<tr><td  width=200>Licentie</td><td>"      .  $row['Licentie']   ."</td></tr>".  "\r\n";
$bericht .= "</table>"   . "\r\n<br>";
$i++;
}


///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
 mail($to, $subject, $bericht, $headers);
}

//echo $Email ." -- ". $email_organisatie;


//// Indien Mail adres ingevuld ook naar inschrijver (zonder BCC)
//// 1-2-2013 BCC ook naar inschrijver  ivm mogelijke mailblok

if (!empty ($Email)){
	

$email_noreply = $email_organisatie;
$email_return  = $email_organisatie;

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset="utf-8"' . "\r\n";
$headers .= 'From: OnTip '. substr($prog_url,3,-1). ' <'.$from.'>' . "\r\n" .	 
       'Cc: '. $email_cc . "\r\n" .
       'Return-Path: '. $email_return  . "\r\n" . 
       'Reply-To: '. $email_organisatie . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
$headers  .= "\r\n";

$subject = 'Boule maatje gevonden ';


$subject .= $toernooi_voluit;
$to       = $Email;
$bericht .= "<div style= 'font-family:cursive;font-size:14pt;color:red;'><hr/> Uw aanvraag is verzonden naar ". $email_organisatie ."</div>" . "\r\n\r\n\r\n\r\n";
$bericht .= "<div style= 'font-family:cursive;font-size:7pt;color:brown;padding-top:20pt;'><hr/>(Deze automatische mail is aangemaakt vanuit OnTIP het digitaal inschrijf formulier (c) Erik Hendrikx 2011,2012.)</div>" . "\r\n";

///  alleen mail versturen als mail adres niet gelijk is aan organisatie om te mail verkeer te beperken
if ($Email != $email_organisatie){
   mail($to, $subject, $bericht, $headers);
}

};              /// indien email ingevuld




















foreach ($Select as $selectid)
{

$qry      = mysql_query("SELECT * from boule_maatje where Id= '".$selectid."' " )    or die(mysql_error());  
$row      = mysql_fetch_array( $qry);

echo $row['Naam'];


}


}// controles goed

?> 
