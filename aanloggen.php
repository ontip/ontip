<html>
<head>
	<meta http-equiv="refresh">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="../ontip/images/OnTip_banner_klein.ico">    
	<base target="_blank">
	<title>OnTip aanlogscherm</title>

<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }
// -->
</style>
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
</head>

<body BACKGROUND="../ontip/images/ontip_grijs.jpg" width =40 bgproperties=fixed >
<br>
<form method = 'post' action='verwerk_aanlog.php' target="_top">
<?php
include('mysql.php');	
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');

if (isset($_GET['return'])){
 $return_page = $_GET['return'];
}

if ($return_page ==''){
	$return_page = 'index.php';
}


$qry    = mysql_query("SELECT * from vereniging where Id = ".$vereniging_id." ")           or die(' Fout in select 1');  
$result  = mysql_fetch_array( $qry);
$vereniging_id     = $result['Id'];
$url_redirect      = $result['Url_redirect'];
$prog_url          = $result['Prog_url'];
$bond              = $result['Bond'];
$datum_verloop_licentie   = $result['Datum_verloop_licentie'];

$today = date('ymd');

echo "<input type= 'hidden'  name= 'zendform' value ='".$today."' />";

if ($datum_verloop_licentie !='0000-00-00'){
/// 01234567890
/// 2014-12-21
$dag    = substr($datum_verloop_licentie,8,2);
$maand  = substr($datum_verloop_licentie,5,2);
$jaar   = substr($datum_verloop_licentie,0,4);
$today  = date('Y-m-d');

$_datum_verloop = strftime("%d-%m-%Y",mktime(0,0,0,$maand,$dag,$jaar)) ;
$week_ervoor    = strtotime ("-1 week", mktime(0,0,0,$maand,$dag,$jaar));
$week4_ervoor   = strtotime ("-4 week", mktime(0,0,0,$maand,$dag,$jaar));
$week6_erna     = strtotime ("+6 week", mktime(0,0,0,$maand,$dag,$jaar));
$today          = date('Y-m-d');
$_week6_erna    = date("d-m-Y", $week6_erna);
$_week_ervoor   = date("Y-m-d", $week_ervoor);
$_week4_ervoor  = date("Y-m-d", $week4_ervoor);
}
else {
	$_datum_verloop = 'onbekend';
	$today          = $week_ervoor;
}

$_datum_verloop_licentie = strftime("%e %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );

$_vereniging  = $vereniging;


if ($vereniging_output_naam != '') {
   	$_vereniging = $vereniging_output_naam;
}





?>
<br>
<br>
<center>
<input type='hidden'name = 'return_page' value = '<?php echo $return_page;?> '>	
	<?php
	if ($datum_verloop_licentie < $today ){ ?>
		
		<table border =1  style=';box-shadow: 5px 5px 3px #888888;'  width=25%>
<tr><td rowspan = 4 style='background-color:white;vertical-align:middle;padding:5pt;text-align:center;'><img src =  '../ontip/images/OnTip_banner_klein.png' width = 75</td>
<td width= 75% colspan = 2 Style='font-family:comic sans ms,sans-serif;color:red;font-size:10pt;background-color:white;padding-left:12pt;font-weight:bold;'><marquee >Uw OnTip licentie is verlopen sinds <?php echo $_datum_verloop; ?></marquee></td></tr>
<tr><td colspan =2 STYLE ='color:green;font-size:9pt;text-align:left;padding:5pt;background-color:white;text-align:justify;'><label>Uw vereniging wordt op of kort na <?php echo $_week6_erna ; ?> verwijderd uit de OnTip database. 
	Tot die datum is inschrijven op de openstaande toernooien nog wel mogelijk.<br>Neem z.s.m. contact op met erik.hendrikx @ontip.nl voor de betaling van de licentiekosten. </td></tr> 
<tr><td colspan =2 Style='font-family:comic sans ms,sans-serif;color:white;font-size:8pt;background-color:#045FB4;'>(c) OnTip <?php echo $_vereniging; ?></td></tr>
</table><br>
	
<?php } else { ?>	
	
<table border =1  style=';box-shadow: 5px 5px 3px #888888;'>
<tr><td rowspan =5 style='background-color:white;vertical-align:middle;padding:5pt;'><img src =  '../ontip/images/OnTip_banner_klein.png' width = 75</td>
<td colspan =2 Style='font-family:comic sans ms,sans-serif;color:white;font-size:10pt;background-color:#045FB4;padding-left:10pt;'>Vul hier je toegangscode en wachtwoord in</td></tr>
<tr><th width='150'STYLE ='color:green;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Toegangscode   </label></th><td STYLE ='background-color:white;color:green;'><label><input type='text'      name='Naam'        size=21/></label></td></tr> 
<tr><th width='150'STYLE ='color:green;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Wachtwoord  </label></th><td STYLE ='background-color:white;color:green;'><label><input type='password'     name='secureontip'  size=21/></label></td></tr>
<tr>
	
<?php  if ($today >= $_week4_ervoor and $today < $_week_ervoor) {   ?>
        <th width='150' STYLE ='color:red;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Datum verloop licentie </label></th>
	 			<td STYLE ='color:black;background-color:yellow;font-size:10pt;text-align:center;'><?php echo $_datum_verloop_licentie  ;?></td>
       <?php } ?>

       <?php  if ($today >= $_week_ervoor and $today < $datum_verloop_licentie) {   ?>
       <th width='150' STYLE ='color:red;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Datum verloop licentie </label></th>
	 			<td STYLE ='color:black;background-color:orange;font-size:10pt;text-align:center;'><?php echo $_datum_verloop_licentie  ;?></td>
       <?php } ?>
       
       <?php if ($datum_verloop_licentie <= $today){ ?>
       <th width='150' STYLE ='color:red;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Datum verloop licentie </label></th>
          <td STYLE ='color:white;background-color:red;font-size:10pt;text-align:center;'><?php echo $_datum_verloop_licentie  ;?></td>
       <?php } ?>
	 		
		  <?php  if ($today < $_week4_ervoor  ) {   ?>
		  <th width='150' STYLE ='color:green;font-size:10pt;text-align:left;padding-left:10pt;background-color:white;'><label>Datum verloop licentie </label></th>
	 			<td STYLE ='color:black;font-size:10pt;text-align:center;background-color:white;'><?php echo $_datum_verloop_licentie  ;?></td>
       <?php }  ?>
</tr>


<tr><td colspan =2 Style='font-family:comic sans ms,sans-serif;color:white;font-size:8pt;background-color:#045FB4;'>(c) OnTip <?php echo $_vereniging; ?></td></tr>
</table>
<?php }
?>

<br>
<div style='font-family:comic sans ms,sans-serif;color:darkgrey;font-size:10pt;'>Alleen toegangelijk voor wedstrijdcommissie en (website)beheerders met een toegangscode.<br>
	Wachtwoord vergeten? <a href ='aanvraag_nieuw_wachtwoord.php' target='_self'> Klik hier om nieuwe aan te vragen.</a><br>
	
	
	Na verloop licentie is aanloggen niet meer mogelijk.<br>Voor betaling licentie klik <a style='color:blue;' href = 'disclaimer.php' >hier</a> voor de algemene voorwaarde en de wijze van betalen.</div><br>
<center>
	
	<input type ='submit' value= 'Klik hier na invullen'> </center>
</form>
<br/>


</body>
</html>
