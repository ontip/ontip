<html
<head>
<title>Import Excel voucher codes</title>
<style type="text/css">
	body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;  }
th {color:white;font-size: 8pt;background-color:blue;}

td {color:black;font-size: 10pt;background-color:white;}
h3 {color:green ;font-size: 14pt;background-color:white;font-weight:bold;}
a    {text-decoration:none ;color:blue;font-size: 8pt;}

</style>

<script type="text/javascript">
 function make_blank_wedstrijdnr()
{
	document.myForm.wedstrijdnr.value="";
}
</Script>


</head>
<body>


   	<br>
<?php

// Database gegevens. 
include('mysql.php');
ob_start();

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
   window.location.replace('aanloggen.php');
</script>
<?php
exit;
}


setlocale(LC_ALL, 'nl_NL');
$today = date('Y-m-d');
$dag   = date('d');
$maand = date('m');
$jaar  = date('Y');

$toernooi = $_GET['toernooi'];

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysql_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              
	
//// Change Title //////
?>
<script language="javascript">
 document.title = "OnTip import Excel voucher codes  - <?php echo  $toernooi_voluit; ?>";
</script> 
	

<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Toernooi inschrijving <?php echo $vereniging; ?></TD></tr>
<td STYLE ='font-size: 32pt; background-color:white;color:blue ;'> <?php echo $toernooi_voluit; ?></TD>
</tr>
</TABLE>
</div>
<hr color='red'/>
		
<blockquote>	
<form action="import_Excel_voucher_codes_stap2.php" method="POST" enctype="multipart/form-data"  name='myForm'>

<input type="hidden" name="server"    value="ftp.ontip.nl">
<input type="hidden" name="toernooi"  value="<?php echo $toernooi;?>">
<br>
<h3>Gegevens voor import Excel voucher codes vanaf PC.</h3>

<br>
<table width=85%  border=0>
<tr>
<td style='color:black;font-size:10pt;font-family:verdana;text-align:justify;'>Een Excel xlsx bestand bevat voucher codes voor het toernooi. Je kan hieronder aangegeven welk bestand ingelezen moet worden, hoeveel kopregels het bevat en welke kolom (A,B of C) de codes bevat.
	<br>Als je niet weet hoeveel kopregels het bestand bevat of welke kolom de codes, kan je Test aanvinken, Dan wordt de inhoud van het betand getoond zonder deze in te lezen.<br>Er wordt niet gecontroleerd of de codes uniek zijn.<br> 
	De import stopt bij de eerste gevonden lege regel.De voucher codes worden ingelezen in het systeem, waarna ze direct beschikbaar zijn t.b.v. de inschrijvingen voor het aangegeven toernooi.<br>
	Maximum aantal codes =100. Bestand mag geen lege regels bevatten.</td>
</tr>
</table>
<br>
<br>
<blockquote>	
<table width=85%  border=0>

<tr>
<td width=50% style='color:black;font-size:10pt;font-family:verdana;'><br><br>Kies Excel bestand (xlsx) met wedstrijdformulier voor upload :  </td>
<td style='width:100pt;color:blue;'><input   name="userfile" type="file" size="190"></td>
</tr>
<br><br>
<tr>
	<td style='color:black;font-size:10pt;font-family:verdana;'>Aantal kopregels</td>
	<td><select name='aantal_kopregels' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:150px;'>
              <option value=''  selected>Maak een keuze...</option>
		          <option value='1'  >1</option>
		          <option value='2'  >2</option>
		          <option value='3'  >3</option>
		        </select>
	</td>
		          
 </tr>
	<tr>
	 <td style='color:black;font-size:10pt;font-family:verdana;'>Kolom met codes</td>
	 <td><select name='kolom_code' STYLE='font-size:9pt;background-color:WHITE;font-family: Courier;width:150px;'>
		 
		          <option value=''  selected>Maak een keuze...</option>
		          <option value='A'  >A</option>
		          <option value='B'  >B</option>
		          <option value='C'  >C</option>
		        </select>
	 </td>
  </tr>		
<tr>
		<td style='color:black;font-size:10pt;font-family:verdana;'>Datum toernooi</td>     
		<td><input type= 'text'  name = 'datum' value = '<?php echo $datum;?>'   size = 15>
		</td>
	</tr>

	<tr>
	<td style='color:black;font-size:10pt;font-family:verdana;' >Bestaande codes verwijderen of nieuwe codes toevoegen</td>
	<td>
  	<input type='radio' name='Check' value ='J' > Verwijderen.
		<input type='radio' name='Check' value ='N' > Toevoegen.
	</td>
</tr>
	<tr>                                                                                                                          
	<td style='color:black;font-size:10pt;font-family:verdana;' >Test run</td>
	<td><input type='checkbox' name='Test' value ='J' unchecked></td>	
	</tr>
</table>
		<input type='hidden'  name = 'toernooi' value='<?php echo $toernooi;?>'/>
<br><br>		
	<input type="submit" name="submit" value="Import en verwerk bestand" />
</blockquote>	
</blockquote>
</form>


<body>
</html>
