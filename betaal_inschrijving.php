<html>
<title>PHP Toernooi Inschrijvingen</title>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">               
<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 5px;}
h1 {color:orange ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a    {text-decoration:none;color:blue;}

// --></style>


<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("TEXTAREA");
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
<script type="text/javascript">
	
function make_blank_opmerkingen()
{
	document.myForm.Opmerkingen.value="";
}
</Script>
</head>

<body>


<?php
ob_start();
include 'mysqli.php'; 
include ('versleutel_kenmerk.php'); 
$ip_adres = $_SERVER['REMOTE_ADDR'];
$toernooi = $_GET['toernooi'];

// uit config tabel	

$sql         = mysqli_query($con,"SELECT Waarde as toernooi_voluit from config WHERE  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele ='toernooi_voluit'   ") or die(' Fout in select aantal');  
$result      = mysqli_fetch_array( $sql );
$toernooi_voluit   = $result['toernooi_voluit'];

$var                 = "ideal_betaling_jn"; 
$qry                 = mysqli_query($con,"SELECT * from config where  Vereniging = '".$vereniging."' and Toernooi = '".$toernooi."' and Variabele = '".$var."'  ")           or die(' Fout in select 1');  
$result              = mysqli_fetch_array( $qry);

if ($result['Waarde'] != 'J') {
	echo "Via IDEAL betalen is niet mogelijk voor dit toernooi.<br>";
	exit;
}
$parameter           = explode('#', $result['Parameters']);
$testmode            = $parameter[1];
$ideal_opslag_kosten = $parameter[2];

$var              = 'kosten_team';
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = '".$var."' ")     or die(' Fout in select2');  
$result2          = mysqli_fetch_array( $qry2 );
$kosten_team      = trim($result2['Waarde']);
$parameter        = explode('#', $result2['Parameters']);
 
$euro_ind        = $parameter[1];
$kosten_eenheid  = $parameter[2];  // 1 = pp , 2 = per team

//// vervang . voor kommma tbv rekenen. 
$kosten_team               = str_replace(",", ".", $kosten_team);
$ideal_opslag_kosten       = str_replace(",", ".", $ideal_opslag_kosten);

$team_part   = explode('.', $kosten_team);
$kosten_team = $team_part[0].$team_part[1];

$ideal_part          = explode('.', $ideal_opslag_kosten);
$ideal_opslag_kosten = $ideal_part[0].$ideal_part[1];
/// omrekenen totale kosten adhv kosten_eenheid

if ($kosten_eenheid == 1) {
  switch ($soort_inschrijving){
  	 case 'single'  : $totale_kosten  =  $kosten_team; break;
  	 case 'doublet' : $totale_kosten  = ($kosten_team*2);break;
	   case 'triplet' : $totale_kosten  = ($kosten_team*3);break;
	   case 'kwintet' : $totale_kosten  = ($kosten_team*6);break;
  } // end switch	 

}
else { 
	$totale_kosten = $kosten_team;

} /// kosten eenheid = 1
//  echo $kosten_team."<br>";
//  echo $ideal_opslag_kosten."<br>";
//  echo $totale_kosten."<br>";
  

$totale_kosten = ($totale_kosten+$ideal_opslag_kosten)/100;

// uit vereniging tabel	
	
$qry          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."'   ")     or die(' Fout in select');  
$row          = mysqli_fetch_array( $qry );
$url_logo     = $row['Url_logo'];
$url_website  = $row['Url_website'];
$vereniging_output_naam = $row['Vereniging_output_naam'];

if ($vereniging_output_naam !=''){ 
    $_vereniging = $row['Vereniging_output_naam'];
} else { 
    $_vereniging = $row['Vereniging'];
}

if (isset($_GET['Kenmerk'])){
$kenmerk  = $_GET['Kenmerk'];
}
else { 
if (isset($_POST['Kenmerk'])){
$kenmerk  = $_POST['Kenmerk'];
}
}

//echo "SELECT * from inschrijf Where Toernooi = '".$toernooi."' and DATE_FORMAT(Inschrijving, '%d%H%i%s') = '".$kenmerk."' <br> " ;

$qry_inschrijving      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Kenmerk = '".$kenmerk."'  " )    ;
$result_i              = mysqli_fetch_array( $qry_inschrijving  );
$speler1               = $result_i['Naam1'];
$id                    = $result_i['Id'];

// Ophalen toernooi gegevens
$var              = 'toernooi_voluit';
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
$soort              = $soort_inschrijving;

if ($soort =='single'){
    $soort          = 'melee';
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Controles
$error   = 0;
$message = '';

if (isset($_POST['Kenmerk']) and $_POST['Kenmerk'] =='') {
	$message .= "* Kenmerk  is niet ingevuld.<br>";
	$error = 1;
}


if (isset($_POST['Kenmerk']) and $id =='') {
	$message .= "* Geen inschrijving gevonden met dit Kenmerk.<br>";
	$error = 1;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
 

?>
<body>

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'http://www.ontip.nl/ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 32pt; background-color:white;color:green ;'><?php echo $_vereniging; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
<span style='text-align:right;'><a href='index.php'>Terug naar Hoofdmenu</a></td></span>

<h3 style='padding:10pt;font-size:20pt;color:red;'>Betaal pagina  <img src = 'http://www.ontip.nl/ontip/images/ideal.bmp'  width=35 border =0></h3>
    <p align="justify" Style='font-family:comic sans ms,sans-serif;color:blue;font-size:11pt;padding-left:15pt;'>Via deze pagina kan u een inschrijving voor een OnTip toernooi betalen</p>

 <?php
 
 $qry1          = mysqli_query($con,"SELECT * From ideal_transacties where Vereniging = '".$vereniging ."' 
	                 and  Toernooi = '".$toernooi."' and Kenmerk = '".$_POST['Kenmerk']."'   ")     or die(' Fout in select ideal trx'); 
      $result1       = mysqli_fetch_array( $qry1 );
	  $betaal_status = $result1['Status'] ;
	  
	  if ($betaal_status  =='PAID'){?>

<blockquote>
    <table>
    	<tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Vereniging</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><?php echo $_vereniging;?> </td>
      </tr>
      <tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Toernooi</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><?php echo $toernooi_voluit;?> </td>
      </tr>
   	  <tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Soort toernooi      : </th><td><?php echo $soort ;?></td></tr>
     <tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Naam speler1  : </th><td> <?php echo $speler1;?></td></tr>	
     <tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Status : </th><td>Inschrijving is betaald</td></tr>	
     </table>
  </blockquote>

	  <?php } else { ?>




 <?php     if  ($_POST['Kenmerk'] ==''){ ?>
<FORM action="betaal_inschrijving.php?toernooi=<?php echo $toernooi;?>" method=post  name='myForm'>
<?php } else { ?>
<FORM action="prepare_ideal_betaling.php?toernooi=<?php echo $toernooi; ?>&id=<?php echo $id; ?>" method=post  name='myForm'>
<?php } ?>
     <input type="hidden" name="zendform" value="1" /> 
<input type="hidden" name="Vereniging"  value="<?php echo $_vereniging ?>" /> 


  <blockquote>
    <table>
    	<tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Vereniging</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><?php echo $_vereniging;?> </td>
      </tr>
      <tr>
        <td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Toernooi</td>
        <td Style='background-color:white;color:blue;font-family:arial;font-size:12pt;'><?php echo $toernooi_voluit;?> </td>
      </tr>
     
      
    <?php 
      if  ($_POST['Kenmerk'] !=''){ 
	  
	  
	  
	  ?>
       <tr>           
        <td align="left" Style='font-family:Arial;font-size:9pt;color:black;'>Kenmerk inschrijving (zie bevestigingsmail)</td>
        <td><?php echo $_POST['Kenmerk']; ?></td>
        <input type="hidden" name="Kenmerk"  value="<?php echo $kenmerk;?>" /> 
        <input type="hidden" name="Toernooi"  value="<?php echo $toernooi;?>" /> 
        
      </tr>
     	<tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Soort toernooi      : </th><td><?php echo $soort ;?></td></tr>
    	<tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Naam speler1  : </th><td> <?php echo $speler1;?></td></tr>	
    	<tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Inschrijfgeld  : </th><td>&euro;. <?php echo $kosten_team;?></td></tr>	
    	<tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>IDEAL opslag kosten : </th><td>&euro;. <?php echo number_format($ideal_opslag_kosten/100, 2, ',', ' ');?></td></tr>	
	    <tr><td align="left" width="190" Style='font-family:Arial;font-size:9pt;color:black;'>Totale kosten       : </th><td>&euro;. <?php echo number_format($totale_kosten, 2, ',', ' ');?></td></tr>  
       
	   
	   <input type="hidden" name="Totale_kosten"  value="<?php echo $totale_kosten;?>" /> 
       
      
    <?php } else { ?> 
      
       <tr>
        <td align="left" Style='font-family:Arial;font-size:9pt;color:black;'>Kenmerk inschrijving (zie bevestigingsmail)</td>
 
        <?php if ($kenmerk !=''){?>
        <td><input type = 'text' name ='Kenmerk' size =10 value ="<?php echo $kenmerk; ?>" ></td>
      <?php } else { ?>
        <td><input type = 'text' name ='Kenmerk' size =10 ></td>
       <?php } ?> 
      </tr>
     <?php } ?>
 
 <?php
  if  ($_POST['Kenmerk'] !=''){ ?>
<tr ><td style='color:white;font-size:12pt;'> xxx<br></tr>     <tr><br></tr> 
<tr>
	
	 <td Style='font-family:arial;font-size:9pt;color:black;vertical-align:top;'>Anti Spam</td>
        <td colspan = 2 Style='font-family:arial;font-size:10pt;color:black;'><input TYPE="TEXT" NAME="respons" SIZE="10" class="pink">  <- Neem onderstaande code uit grijze vlak over 
        	
	<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    
    
   echo "<div style= 'font-size:14pt; color:black;background-color:lightgrey;width:100pt;text-align:center;font-family:courier;'>". $string."</div>";
   echo "<input type='hidden' name='challenge'    value='". $string. "' /> "; 
   
   $string = "";    
?>
</td></tr>
<?php } ?>

   </table>
  </blockquote>
 

<hr color='red' width=100% align='left'> 
       <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
        </td>
      </tr>
      <tr>
        <td ALIGN="center" style= 'Font-family:arial;'>
        	<input TYPE="submit" VALUE="Doorgaan" ACCESSKEY="v">&nbsp;&nbsp;
        	<input  TYPE="reset" VALUE="Herstellen" ACCESSKEY="h">&nbsp;&nbsp;
        	
        <td>
      </tr>
    </table>
  </div>
  </blockquote>
 </form>


	  <?php } // al betaald ?>
  <br>
    <p align="justify">
  

  <br class="clearfloat" />
  
<!-- end #container --></div>
</body>
<!-- InstanceEnd --></html>
