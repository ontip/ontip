<html>
<head>
<title>Aanmaak QR Code toernooi all</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type=text/css>
body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
a    {text-decoration:none;color:blue;font-size: 8pt;}
</style>

<?php
// Database gegevens. 
include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');


/// QRC software lib
include "../ontip/phpqrcode/qrlib.php"; 

////////////////////////////////////////////////////////////////////////////////////////////
//  Create_qrcode_ontip.php

// Dit programma maakt een tekst QRCode tbv de overzichtspagina toernooi_all.php 
//
////////////////////////////////////////////////////////////////////////////////////////////


?>
<body >
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 28pt; background-color:white;color:darkgreen ;'>Toernooi inschrijving <?php echo $vereniging ?></TD>
</tr>

</TABLE>
</div>
<hr color='red'/>
             
<span style='text-align:right;font-size:8pt'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<?php

$lijst_link = $prog_url."toernooi_all.php";

// anders fout op volledig path

$qrc_link  = $prog_url."/images/qrc/qrcl_toernooi_all.png";


QRcode::png("".$lijst_link."", "".$qrc_link."", "L", 4, 4); 

//QRcode::png("http://www.sitepoint.com", "test.png", "L", 4, 4); 


echo "<h2 style='color:blue;font-family:cursive;font-size:22;'>QR Code voor overzichtspagina alle OnTip toernooien voor ".$vereniging.".</h2><br>";

echo "<center><img src = ".$qrc_link." border  = 0 width = 200></center>";




?> 
