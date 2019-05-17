<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<Title>OnTip (c) Erik Hendrikx - Wedstrijdcommissie</title>	     
		
</head>

		
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}
em {color:red ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }
// --></style>
<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("INPUT");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onfocus=function() {
            this.className+=" sffocus";
        }
        sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfFocus);
     -->
</Script>
<head>
<body>


<?php
ob_start();
include 'mysqli.php'; 
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}


if ($rechten != "A"  and $rechten != "W"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

$sql      = mysqli_query($con,"SELECT * from config WHERE Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' 
            and Variabele = 'toernooi_voluit' ") or die(' Fout in select');  
$result   = mysqli_fetch_array( $sql );

$toernooi_voluit   = $result['Waarde'];


 ?>

<script type="text/javascript">
 var myverticaltext="<div class='verticaltext1'>Copyright by Erik Hendrikx © 2011</div>"
 var bodycache=document.body
 if ("bodycache && bodycache.currentStyle && bodycache.currentStyle.writingMode")
 document.write(myverticaltext)
 </script>



<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>

<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<blockquote>

<h3 style='padding:10pt;font-size:20pt;color:green;'>Aanpassen toernooi gegevens - wedstrijdcommissie</h3>

<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Diacrieten omzetten in vereniging en toernooi_voluit


/// Queries


	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysqli_fetch_array( $qry )) {
	
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}






/*
$sql1      = mysqli_query($con,"SELECT * from config WHERE Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' 
            and Variabele = 'begin_inschrijving' ") or die(' Fout in select');  
$result1  = mysqli_fetch_array( $sql1 );
$id1       = $result1['Id'];
$regel1    = $result1['Regel'];
$begin_inschrijving   = $result1['Waarde'];

$sql2      = mysqli_query($con,"SELECT * from config WHERE Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' 
            and Variabele = 'einde_inschrijving' ") or die(' Fout in select');  
$result2   = mysqli_fetch_array( $sql2 );
$id2       = $result2['Id'];
$regel2    = $result2['Regel'];
$einde_inschrijving   = $result2['Waarde'];

$sql3      = mysqli_query($con,"SELECT * from config WHERE Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' 
            and Variabele = 'max_splrs' ") or die(' Fout in select');  
$result3   = mysqli_fetch_array( $sql3 );
$id3       = $result3['Id'];
$regel3    = $result3['Regel'];
$max_splrs  = $result3['Waarde'];

$sql4      = mysqli_query($con,"SELECT * from config WHERE Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' 
            and Variabele = 'aantal_reserves' ") or die(' Fout in select');  
$result4   = mysqli_fetch_array( $sql4 );
$id4       = $result4['Id'];
$regel4    = $result4['Regel'];
$aantal_reserves  = $result4['Waarde'];


*/


//echo $result['Waarde'];

//$vereniging        = str_replace('&#226', 'â', $vereniging);
//$vereniging        = str_replace('&#233', 'é', $vereniging);
//$vereniging        = str_replace('&#234', 'ê', $vereniging);
//$vereniging        = str_replace('&#235', 'ë', $vereniging);
//$vereniging        = str_replace('&#239', 'ï', $vereniging);

$toernooi_voluit   = str_replace('&#226', 'â', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#233', 'é', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#234', 'ê', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#235', 'ë', $toernooi_voluit);
$toernooi_voluit   = str_replace('&#239', 'ï', $toernooi_voluit);

?>

<br><br>
<center>
<div style='border: white inset solid 1px; width:1000px; text-align: center;'>
<form method = 'post' action='wedcom_functies_stap2.php'>

<input type="hidden" name="Vereniging"  value="<?php echo $vereniging?>" /> 

<div Style='font-family:arial; color:black;font-size:12pt;font-weight:bold;'>Pas hier de gegevens van het toernooi <span style='color:blue;'>'<?php echo htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?>'</span> aan</div><br/><br/>

<input type="hidden" name="Toernooi"    value="<?php echo $toernooi; ?>" /> 

<input type="hidden" name="Id-1"          value="<?php echo $id1; ?>" /> 
<input type="hidden" name="Regel-1"       value="<?php echo $regel1; ?>" /> 
<input type="hidden" name="Id-2"          value="<?php echo $id2; ?>" /> 
<input type="hidden" name="Regel-2"       value="<?php echo $regel2; ?>" /> 
<input type="hidden" name="Id-3"          value="<?php echo $id3; ?>" /> 
<input type="hidden" name="Regel-3"       value="<?php echo $regel3; ?>" /> 
<input type="hidden" name="Id-4"          value="<?php echo $id4; ?>" /> 
<input type="hidden" name="Regel-4"       value="<?php echo $regel4; ?>" /> 

<table >
<tr><td width='400'STYLE ='background-color:white;color:blue;'><label>Begin inschrijving  (jjjj-mm-dd)  </label></th><td STYLE ='background-color:white;color:orange;'>
	<select name='begin_datum_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
<?php
 /* Set locale to Dutch */
 setlocale(LC_ALL, 'nl_NL');
 
 
 // 0123456789012345
 // 2013-01-17
 
 
 $dag   = substr($begin_inschrijving ,8,2);
 $maand = substr($begin_inschrijving ,5,2);
 $jaar  = substr($begin_inschrijving ,0,4);
 
 
 
 for ($d=1;$d<=31;$d++){
 	
 	if ($d == $dag ){
 			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
    }		
   else {
 				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
   }	
 }
 	?>
</SELECT>
 
 	
 	<select name='begin_datum_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
<?php
 for ($m=1;$m<=12;$m++){
 	if ($m == $maand ){
 	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 } else { 
 	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 }			
}

 	?>
</SELECT>
 <select name='begin_datum_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
<?php
 for ($y=date('Y');$y<(date('Y')+5);$y++){
 	
 	if ($y == $jaar ){
 		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
 		}
 		else {
 			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 			}
 }			
 	?>
</SELECT>
	
	
	
	
	
	
	</td><tr>
<tr><td width='400'STYLE ='background-color:white;color:blue;'><label>Einde inschrijving  (jjjj-mm-dd  uu:mm)  </label></th><td STYLE ='background-color:white;color:blue'>
	
	  	<select name='eind_datum_dag' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:50px;'>
<?php

 // 0123456789012345
 // 2013-01-17 12:34


 $dag   = substr($einde_inschrijving ,8,2);
 $maand = substr($einde_inschrijving ,5,2);
 $jaar  = substr($einde_inschrijving ,0,4);
 $uur   = substr($einde_inschrijving ,11,3);
 $min   = substr($einde_inschrijving ,14,2);



 for ($d=1;$d<=31;$d++){
 	
 	if ($d == $dag ){
 			 echo "<option value=".$d." selected>".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
    }		
   else {
 				 echo "<option value=".$d.">".strftime("%d",mktime(0,0,0,date('12'),date($d),date("Y")))."</option>";
   }	
 }
 	?>
</SELECT>
 	
 	<select name='eind_datum_maand' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:100px;'>
<?php
 for ($m=1;$m<=12;$m++){
 	if ($m == $maand ){
 	 			 echo "<option value=".$m." selected>".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 } else { 
 	 			 echo "<option value=".$m.">".strftime("%B",mktime(0,0,0,date($m),date(3),date("Y")))."</option>";
 	 }			
}

 	?>
</SELECT>
 <select name='eind_datum_jaar' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:60px;'>
<?php
 for ($y=date('Y');$y<(date('Y')+5);$y++){
 	
 	if ($y == $jaar ){
 		  echo "<option value=".$y."  selected>".strftime("%Y",mktime(0,0,0,date("m"),date("d"),date($y)))."</option>";
 		}
 		else {
 			 echo "<option value=".$y.">".strftime("%Y",mktime(0,0,0,date("m"),date(1),date($y)))."</option>";
 			}
 }			
 	?>
</SELECT>
 om 
<select name='eind_datum_uur' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:40px;'>
<?php
 for ($u=0;$u<=24;$u++){
 	
 	if ($u == $uur ){
 		  echo "<option value=".$u."  selected>".strftime("%H",mktime(date($u),0,0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$u.">".strftime("%H",mktime(date($u),0,0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			
 	?>
</SELECT>

<select name='eind_datum_min' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:40px;'>
<?php
 for ($n=0;$n<=59;$n++){
 	
 	if ($n == $min ){
 		  echo "<option value=".$n."  selected>".strftime("%M",mktime(0,date($n),0,date("m"),date("d"),date("Y")))."</option>";
 		}
 		else {
 			 echo "<option value=".$n.">".strftime("%M",mktime(0,date($n),0,date("m"),date(1),date("Y")))."</option>";
 			}
 }			

 
 	?>
</SELECT>
</td>
<tr>
<tr><td width='400'STYLE ='background-color:white;color:blue;'><label>Min aantal inschrijvingen </label></th><td STYLE ='background-color:white;color:orange;'><label><input type='text'  name='min_splrs' value='<?php echo $min_splrs; ?>' size=10/></label><em> (team is gelijk aan 1 inschrijving)</em></td><tr>
<tr><td width='400'STYLE ='background-color:white;color:blue;'><label>Max aantal inschrijvingen </label></th><td STYLE ='background-color:white;color:orange;'><label><input type='text'  name='max_splrs' value='<?php echo $max_splrs; ?>' size=10/></label><em> (team is gelijk aan 1 inschrijving)</em></td><tr>
<tr><td width='400'STYLE ='background-color:white;color:blue;'><label>Max aantal reserves </label></th><td STYLE ='background-color:white;color:orange;'><label><input type='text'        name='aantal_reserves' value='<?php echo $aantal_reserves; ?>' size=10/></label><em></em></td><tr>


</table> 
<br>
<span ><em style='color:green;'>Deze pagina is alleen toegankelijk voor gebruikers met rechten 'A' of 'W' </em></span>
</table><br><br>
<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<br/>
</center>
<br></div><br><br>
<?php

ob_end_flush();
?>
</div>
</body>
</html>
