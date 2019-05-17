<html>
<head>
<title>Toernooi schema</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type="text/css" >
	body {font-size: 10pt; font-family: Comic sans, sans-serif, Verdana; }
.noprint {display:none;}    
hr {
  border-top: 1px dotted #f00;
  color: #fff;
  background-color: #fff;
  height: 1px;
  width:50%;
  a    {text-decoration:none;color:blue;font-size: 9pt;}
}
</style>

</head>
 	
 <?php 
ob_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Database gegevens. 
include('mysqli.php');

$aant_splrs        = $_POST['Aantal'];
$aant_rondes       = $_POST['Rondes'];
$toernooi          = $_POST['Toernooi'];
$letter_nummer     = $_POST['Tekens'];
$toernooi_voluit   = $_GET['toernooi'];
$invul_namen       = $_GET['invul_namen'];
$baan_toewijzing   = $_POST['Baan_toewijzing'];

if (substr($prog_url,-1, 1) !=  "/" ){
	$prog_url = $prog_url . "/";
}


$output_pdf        = $prog_url.'images/Score_formulieren_'.$toernooi.'.pdf';
$output_pdf        = 'Score_formulieren_'.$toernooi.'.pdf';

//echo $output_pdf."<br>";

//// Change Title //////
?>
<script language="javascript">
 document.title = "Toernooi schema <?php echo  $toernooi_voluit; ?>";
</script> 
<?php

  
//echo $toernooi;
//echo $vereniging;

if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

   while($row = mysqli_fetch_array( $qry2 )) {
	       $var  = $row['Variabele'];
	       $$var = $row['Waarde'];
	     } // end while
	}
else {
		echo " Geen toernooi bekend :";
	};	

?>

<body>

<?php
include("../ontip/mpdf/mpdf.php");
$mpdf=new mPDF();
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='windows-1252';
$mpdf = new mPDF('',   // mode - default ''
                                                '',    // format - A4, for example, default ''
                                                0,     // font size - default 0
                                                '',    // default font family
                                                10,    // margin_left
                                                10,    // margin right
                                                4,     // margin top
                                                3,     // margin bottom
                                                3,     // margin header
                                                2,     // margin footer
                                                'P');  // L - landscape, P - portrait
                                                
                                           

echo "<div style='border: red solid 1px;padding-left:5px;'>";  
echo"<h1>Toernooi schema ". $toernooi ." <h1>"; 
echo "</div>";

echo "<div style='position: absolute; left: 180px;font-size:10pt;' >";
echo "Dit schema bevat een uitdraai van ".$aant_rondes ." voorgelote partijen voor ".$aant_splrs. " deelnemende teams.";
echo "</div>";


echo "<table width=100% ><tr>";
echo "<td>";
echo "<a href='index.php' style='text-decoration:none;color:blue;font-size: 9pt;'>Terug naar Hoofdmenu</a></td>";
echo "</tr></table>";


?>
<!--  Knoppen voor verwerking   ----->

<?php
 ////////////////////////////////////////////////////////////////////////////////////// score formulier 
////  Koptekst
 
/// c is de teller voor aantal formulieren per pagina. Na 3 pagina's wordt een page break gezet	
  $c =0;
 
if ($invul_namen =='J'){
	/// Ophalen spelers uit toernooi_schema
  $namen       = mysqli_query($con,"SELECT * from toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  order by Wedstrijd, Ronde")     or die(' Fout in select inschrijf');  
}

$html='';


  ///// $j is teller voor aantal teams
for ($j=1;$j <= $aant_splrs;$j++){
	
	$_team = chr($j+64); 
	if ($j > 26 and $j < 53){
 			 $_team = chr(65).chr($j+64-26);                   // AA  - Az
 	 	}
 			
 			if ($j > 52 and $j < 79){
 			 $_team = chr(66).chr($j+64-52);                   // BA  - Bx
 	 	}
 			
 			if ($j > 78 and $j < 115){
 			 $_team = chr(67).chr($j+64-78);                   // CA  - Cx
 	 	}

if ($letter_nummer == 'Nummers'){
		 $_team = $j;
	}

//// kop van formulier
?>

<?php
$html .= "<table border=0 width=100% >
	<tr>
		<td style='border: 3px solid orange; border-collapse: separate;padding-left:5px;width:120px;font-size:16pt'>Team : ". $_team."</td>
	  <td style='padding-left:5px;font-size:11pt;text-align:center;'>". $toernooi_voluit."</td>
	  <td style='padding-left:5px;font-size:11pt;text-align:right;'>". $vereniging."</td>
  </tr>
</table>"; 

$html .="<br><table border=0 width=100%>";

if ($invul_namen =='J'){
  $row = mysqli_fetch_array( $namen );

$html .= "<tr><td Style='font-family:cursive;font-size:11pt;'>Naam captain     : </td><td>".$row['Team_naam1']."</td></tr>";
$html .= "<tr><td Style='font-family:cursive;font-size:11pt;'>Vereniging       : </td><td>".$row['Team_vereniging1']."</td></tr>";
} else { 
$html .= "<br><tr><td Style='font-family:cursive;font-size:11pt;'>Namen      : </td><td>________________________________________________________________</td></tr>"; 
$html .= "<tr><td Style='font-family:cursive;font-size:11pt;'>Vereniging : </td><td>________________________________________________________________</td></tr>";
 } 
$html .="</table>";
 

$html .="<br><table style='border: 1px solid black; border-collapse: separate;' width=100%>
	      <tr>
	        <th width=100 style='border: 1px solid black; border-collapse: separate;'>Ronde</th>
	        <th width=100 style='border: 1px solid black; border-collapse: separate;'>Team</th>
        	<th width=100 style='border: 1px solid black; border-collapse: separate;'>Tegenstander</th>";

if ($baan_toewijzing =='J'){ 
$html .= "<th width=100 style='border: 1px solid black; border-collapse: separate;'>Baan</th>";
} 

$html .= "<th width=100 style='border: 1px solid black; border-collapse: separate;'>Voor</th>
        	<th width=100 style='border: 1px solid black; border-collapse: separate;color:red;'>Tegen</th>
	        <th width=100 style='border: 1px solid black; border-collapse: separate;'>Winst (J/N)</th>
          </tr>";
 
/// Detail regels
/// $k is teller voor rondes

  for ($k=1;$k <= $aant_rondes;$k++){
   	 	 	
 $qry  = mysqli_query($con,"SELECT Tegenstander,Baan From toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Ronde = ".$k."  and Team =  '" .$_team."' order by Team,Ronde" );  
 $row  = mysqli_fetch_array( $qry );
 
	
$html .= "<tr>
		<td style='font-color:black;text-align:right;font-size:12pt;border: 1px solid black; border-collapse: separate;'>".$k.".</td>
		<td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'>".$_team."</td>
		<td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'>".$row['Tegenstander']."</td>";

		if ($baan_toewijzing =='J'){ 
     $html .="<td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'>".$row['Baan']."</td>";
    }
$html .= "<td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'></td>
          <td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'></td>
          <td style='font-color:black;text-align:center;font-size:12pt;border: 1px solid black; border-collapse: separate;'></td></tr>";
	
	} /// end k

$html .= "</table><br>";
$html .="<table width=100%>
	      <tr>
        <td style='font-size:9pt;text-align:left;color:blue;'>Dit toernooi wordt gespeeld volgens de regels van de NJBB.</td>
        <td style='font-size:8pt;text-align:right;color:black;'>(c) OnTip Erik Hendrikx 2014.</td>
        </tr></table>";
  
  
  $c++;
  if ($c==3 and $c < $aant_splrs){
      $html .= "<pagebreak />";
	 	  $c=0;
  } // c =3	
  else {
  	$html .= "<hr style = 'border-top: 1px dotted #f00;color:darkgrey;' >"; 
   } // c =3
   

 }/// end j
 
// Afsluiten                                             

$mpdf->WriteHTML($html);
$mpdf->Output($output_pdf,'F');

echo "<br><br>Als bij een tweede keer aanmaken de output niet is wat je verwacht, druk op F5 om het scherm te verversen.";
echo "<center><br><br><iframe src='".$output_pdf."' width='580' height='680' style='border: none;'></iframe></center>";
echo "<br><a style='font-size:10pt;' href = ".$output_pdf." target='_blank'>Klik hier voor aangemaakte PDF Flyer in een apart window te openen.</a>";
?>




</body>
</html>