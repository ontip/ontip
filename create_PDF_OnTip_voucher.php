<?php 
# create_PDF_Ontip_voucher.php
# Aanmaken van een PDF bestand met unieke voucher codes (vanuit bestand)
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 13mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 
?>
<html>
	<Title>OnTip PDF vouchers</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: verdana, sans-serif;background-color:white}

h1   {color:red ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2   {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3   {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {color:red ; font-size: 8.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
fieldset { border: 1px solid #000000; border-radius: 5px; padding: 10px;margin:5pt; }
 
 .kolom2 {font-weight:bold;color:black;background-color:#BDBDBD;}
 
// --></style>

</head>

<body>
<?php 
ob_start();

include('mysqli.php');
 
$path = $_SERVER['DOCUMENT_ROOT'];
$path = "../ontip/mpdf/mpdf.php";
include_once($path);   
   
ini_set('default_charset','UTF-8');

$toernooi= $_GET['toernooi'];


?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>OnTip vouchers</TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<a href='OnTip_financien.php' style='font-size:9pt;color:blue;'>Terug naar overzicht</a>
<br><br>
<?php

if (isset($toernooi)) {
	
	$voucherCode = []; 
	$qry  = mysqli_query($con,"SELECT * From voucher_codes where Vereniging_id = ".$vereniging_id." and Toernooi = '".$toernooi."' ")     or die(' Fout in select 1');  
	while($row = mysqli_fetch_array( $qry )) {
	
	$voucherCode[] = $row['Voucher_code'];
}
	
//	echo $vereniging;
//  echo $toernooi;

//	echo "SELECT * From config where Vereniging_id = ".$vereniging_id." and Toernooi = '".$toernooi."' ";
	$qry  = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id." and Toernooi = '".$toernooi."' ")     or die(' Fout in select 1');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


$qry_v           = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v        = mysqli_fetch_array( $qry_v);
$vereniging_id   = $result_v['Id'];
$url_logo        = $result_v['Url_logo'];
$vereniging_output_naam      = $result_v['Vereniging_output_naam']; 	  	 
}
else {
		echo " Geen toernooi bekend :";
	 
};


$output_pdf  = 'pdf/OnTip_vouchers_'.$toernooi.".pdf";

$html ='';
?>


<h1>OnTip  PDF Voucher </h1>

<?php
$html .='

  <table width=100% border =2 cellpadding =0 cellspacing =0>
    <tr>';
 
$n=1;    
for ($r=1;$r<8;$r++){ 
	
  for ($k=1;$k<3;$k++){ 
    	
    $html .='
   <td  style="margin:1pt;"  width=50%>
    <table width=100% border =0>
     <tr>
      <td width=10% style="vertical-align:top;" ><img src = "'.$url_logo.'" width="80"></td>
      <td style= "font-size:9pt;font-family:verdana;text-align:left;color:black;">'.$vereniging_output_naam.'</td>
      <td><h2  style= "font-size:7pt;font-family:verdana;text-align:left;color:blue ;">Voucher '.$n.'</h2><br></td></tr>
    </table>
      <div style="color:darkgreen;font-size:10pt;text-align:center;"> '.$toernooi_voluit.'</div>
     
      <div width=100% style="color:black;font-size:9pt;text-alin:justify;" >Aktie tekst Aktie tekst Aktie tekst Aktie tekst<br>Aktie tekst Aktie tekst Aktie tekst Aktie tekst</div>
      <table width=100%>
      
      <tr><td  style="font-size:12pt;">Code</td>
      <td  style="border:2pt solid blue;font-size:16pt;text-align:center;padding:5pt;">'.$voucherCode[$n-1] .'</td></tr>
    </table><br>
    <br><center>
 <em> Deze code is uniek en kan maar 1 keer gebruikt worden.</em></center>
    </td>';
    $n++;   
    } // end koloms
    
    $html .='</tr><tr>';

} // end rows

 
 $html .='</tr></table>';


//echo $html;

//==============================================================
//==============================================================
//============= AANMAAK  PDF FAKTUUR              ==============
//==============================================================

$mpdf = new mPDF('',   // mode - default ''
                                                '',    // format - A4, for example, default ''
                                                0,     // font size - default 0
                                                '',    // default font family
                                                1,    // margin_left
                                                1,    // margin right
                                                0,    // margin top
                                                0,    // margin bottom
                                                0,     // margin header
                                                0,     // margin footer
                                                'P');  // L - landscape, P - portrait
                                           
$mpdf=new mPDF();
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='utf-8';

$mpdf->WriteHTML($html);

$mpdf->Output($output_pdf,'F');

echo "<center><br><a href='javascript:history.go(-1);' style='font-size:9pt;color:blue;'>Klik hier voor factuur gegevens.</a><br>";
echo "<br><a style='font-size:10pt;' href = ".$output_pdf." target='_blank'>Klik hier om aangemaakte PDF factuur in een apart window te openen.</a>";
echo"<br><iframe src='".$output_pdf."' width='580' height='750' style='border: none;'></iframe></center>";

echo "<br><a style='font-size:10pt;' href = 'send_ontip_factuur.php?secret=haring&pdf=".$output_pdf."&vereniging_id=".$vereniging_id."'   target='_blank'>Klik hier om aangemaakte PDF factuur te verzenden naar contactpersoon.</a>";
$output_pdf



?>

</body>
</html>
	