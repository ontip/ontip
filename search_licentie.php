<?php
/*  search_licentie.php   (c) Erik Hendrikx
    Programma zoekt aan de hand van het licentienr naar de gegevens van de speler uit de tabel speler_licenties.
    Dit programma wordt via een include aangeroepen in send_inschrijf.php
    De gevonden gegevens worden weggeschreven naar de tabel hulp_select_speler en in Inschrijfform.php uitgelezen indien de GET
    parameter 'gevonden' aanwezig is.
    
    8 sep 2015  Parameter simpel wordt niet goed verwerkt. Simpel is verticale opmaak. Volgorde headers aangepast. Eerst default waarde
*/
//echo "Simpel : ".$simpel;

// default. Bij opvragen via Loep in gewone opmaak
header("Location: Inschrijfform.php?gevonden&toernooi=".$toernooi."");

// bij selectie user eigen vereniging vanujit sele4ctie lijst
if (isset($_POST['user_select']) ){
   header("Location: Inschrijfform.php?gevonden&user_select=Yes&toernooi=".$toernooi."");
}
// bij opvragen via loep verticale opmaak
if (isset($_POST['simpel'])  or $simpel == 'J'  ){
  header("Location: Inschrijfform.php?simpel&gevonden&toernooi=".$toernooi."");
}

if (isset($_POST['mobiel']) ){
  header("Location: Inschrijfform1.php?mobiel&gevonden&toernooi=".$toernooi."");
}



//header("Location: ".$_SERVER['HTTP_REFERER']);
//header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"'); /// ivm cookies in Iframe

ob_start();

// eerst schonen
$ip_adres    = $_SERVER['REMOTE_ADDR'];  

$query     =  "DELETE from hulp_select_speler
               where Toernooi     = '".$toernooi."' and
                     Vereniging   = '".$vereniging."' and
                     IP_adres     = '".$ip_adres."'  ";
mysql_query($query); 

/// Ophalen namen adhv licentie

if ($Licentie1 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie1."' ");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   
   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,1, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}

if ($Licentie2 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie2."' ");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   
   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,2, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}

if ($Licentie3 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie3."' ");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   
   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,3, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}

if ($Licentie4 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie4."'");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   
   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,4, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}
if ($Licentie5 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie5."'");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   
   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,5, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}

if ($Licentie6 != ''){

$qry   = mysql_query("SELECT * From speler_licenties where Licentie = '".$Licentie6."'");  
$row   = mysql_fetch_array( $qry );

$licentie = $row['Licentie']; 
$naam     = $row['Naam'];
$email    = $row['Email'];
$vereniging_speler  = $row['Vereniging'];   

   
 	/// Insert in hulp tabel 
$insert  = "insert into hulp_select_speler (Id,Toernooi, Vereniging, Speler_nr, Naam , Vereniging_speler, Licentie, Email, IP_adres, Laatst) 
            VALUES (0,'".$toernooi."', '".$vereniging ."' ,6, '".$naam."','".$vereniging_speler ."','".$licentie ."','".$email."','".$ip_adres."', now() )";
mysql_query($insert) ; 
}

ob_end_flush();
?>