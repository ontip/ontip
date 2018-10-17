<?php 
ob_start();
// Database gegevens. 
include('mysql.php');

if (isset($_POST['Check'])){
 $delete    = $_POST['Check'];
}
else {
	$delete ='';
}

if (isset($_POST['Geplaatst'])){
 $geplaatst    = $_POST['Geplaatst'];
}
else {
	$geplaatst ='';
}
// kontroleer eerst welke al gepubliceerd waren


$al_geplaatst = array();

$sql  = mysql_query("SELECT * From gastenboek  where Geplaatst = 'J'   ")     or die(' Fout in select gastenboek');  	
while($row = mysql_fetch_array( $sql )) {
  $al_geplaatst[] = $row['Id'];
};
   

$error = 0;

for ($i=1;$i<100;$i++){

$naam       = '';
$onderwerp   = '';
$email      = '';
$tekst      = '';

if (isset($_POST['Id-'.$i]))              {   $id              = $_POST['Id-'.$i];     }
if (isset($_POST['Naam-'.$i]))            {   $naam            = $_POST['Naam-'.$i];     }
if (isset($_POST['Onderwerp-'.$i]))       {   $onderwerp       = $_POST['Onderwerp-'.$i];     }
if (isset($_POST['Email-'.$i]))           {   $email           = $_POST['Email-'.$i];     }
if (isset($_POST['Tekst-'.$i]))           {   $tekst           = $_POST['Tekst-'.$i];     }
 
if ($naam !='' ) {      	 
      	     
$sql  = "UPDATE gastenboek
	           SET Naam                 =  '".$naam."',            
	               Onderwerp            =  '".$onderwerp."',     
	               Email                =  '".$email."',     
	               Geplaatst            =  'N',
	               Tekst                =  '".$tekst."'
	            WHERE Id= ".$id;
//echo $sql."<br>";
mysql_query ($sql) or die ('Fout in update');      
} // end if
} // end for

if ($delete !=''  )  {
  foreach ($delete as $deleteid)
   {
      mysql_query("DELETE from  gastenboek where Id = ".$deleteid." ");   
   } // end for each

} // end if delete

if ($geplaatst !=''  )  {
  foreach ($geplaatst as $geplaatstid)
   {
      mysql_query("UPDATE  gastenboek set Geplaatst = 'J ' where Id = ".$geplaatstid." ");   
      
      
      /// activeren melden naar aanbieder
      
      $sql  = mysql_query("SELECT * From gastenboek  where Id = ".$geplaatstid." ")     or die(' Fout in select gastenboek');  	
      $row  = mysql_fetch_array( $sql );
      $email = $row['Email'];
      
      if (in_array($geplaatstid, $al_geplaatst))  {
      	//echo "gevonden dus geen email";
      	$email ='';
      }
      

      if ($email !=''    ) {
      	
      	$headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: info@degemshoorn.nl' . "\r\n" .
            'Reply-To: noreply@degemshoorn.nl' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $headers .= "\r\n";

        $bericht = "<table>"   . "\r\n";
        $bericht .= "<tr><td><img src= 'http://www.degemshoorn.nl/images/logo_gemshoorn_blauw_geel.png' width=110>"   . "\r\n";
        $bericht .= "<td style= 'font-family:cursive;font-size:14pt;color:blue;'><b>*  JBV de Gemshoorn Soest *</b></td></tr>" . "\r\n";
        $bericht .= "</table>"   . "\r\n";
        $bericht .= "<br><br><hr/>".   "\r\n";
      
        $bericht .= "<br><br>Uw bijdrage aan het gastenboek is bevestigd door de beheerder.".   "\r\n";
      
        $subject = 'Uw bijdrage aan het gastenboek van JBV De Gemshoorn is bevestigd.';
        mail($email, $subject, $bericht, $headers);
     
      
    } // end if
      
   } // end for each

} // end if geplaatst

ob_end_flush();
?>
<script type="text/javascript">
		window.location.replace('beheer_gastenboek.php');
	</script>	