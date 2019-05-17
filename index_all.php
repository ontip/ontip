<html>
	<Title>OnTip Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon" type="image/x-icon" href="../boulamis_toernooi/images/OnTip_banner_klein.ico">    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }

h1 {color:red ; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:blue ; font-size: 10.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 15px;
                  width: 15px;writing-mode: tb-rl;color:orange;}
// --></style>
</head>

<body>
<?php 
ob_start();

include('mysqli.php');
ini_set('default_charset','UTF-8');
?>
<div style='background-color:white;'>
<table >
<tr><td style='background-color:white;' rowspan=2 width='280'><img src = 'images/ontip_logo.png' width='280'></td>
<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>OnTip Verenigingen beheer</TD>
</tr>
</TABLE>
</div>
<hr color='red'/>


<div style='border:inset green solid 1px;margin:14pt;font size: 14pt;padding:10pt;background-color:white;text-align:center;'>
	
	<table width=95%><tr>
		    <td width=25%><a href= "http://www.boulamis.nl/boulamis_toernooi/stats.php"><b>Stats Alle toernooien</b> </a></td>
		    <td width=25%><a href= "http://www.boulamis.nl/boulamis_toernooi/stats_maand.php"><b>Stats dagen vd maand</b> </a></td>
		    <td width=9%><a href= "http://www.boulamis.nl/boulamis_toernooi/lijst_sms_confirmations.php" class='tooltip'  title='Naar OnTip SMS gebruik' target= '_blank'><img src ="../boulamis_toernooi/images/OnTip_sms.png" width ='55'> </a></td>	
		    <td width=25%><a href= "http://www.ontip.nl/toernooi_ontip.html"><b>OnTip Toernooi Kalender</b> </a></td>	
     	  <td width=9%><a href= "http://www.webhelpje.be/forum/forum.php?name=Ontip" class='tooltip'  title='Naar OnTip forum'><img src="../boulamis_toernooi/images/forum.png" width=55 border =0 target='_blank'></a></td>    
		    
  </tr>
</table>
</div>

<div style='margin:14pt;font size: 12pt;padding:10pt;background-color:white'>
	<table>
		<tr><td><h1>Beheer</h1></td></tr>
		<tr>
		    <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/OnTip_verenigingen.php">- OnTip verenigingen</a></td>
  </tr>
		<tr>
		    <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/OnTip_file_manager.php">- OnTip file manager</a></td>
  </tr>
	<tr>
		     <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/copy_sel_files_sel_folders_stap1.php">- Copy selected files to multiple folders</a></td>
  </tr>
	<tr>
		     <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/copy_sel_files_sel_hussel_stap1.php">- Copy selected files to multiple folders - HUSSEL</a></td>
  </tr>
  <tr>
		     <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/copy_sel_images_sel_folders_stap1.php">- Copy selected images to multiple folders</a></td>
  </tr>
<tr>
		  <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/mysqldump_tables_stap1.php">- Mysqldump config, inschrijf, namen en stats_naam</a></td></tr>
  <tr>
		   <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/insert_sql_stap1.php">- SQL insert variabele and value to multiple verenigingen</a></td>
  </tr>
  <tr>
		   <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/check_config_all_stap1.php">- Check en delete duplicate records in config</a></td>
  </tr>
  <tr>
		   <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/email_lijst.php">- Email lijst alle beheerders</a></td>
  </tr>
  <tr>
		   <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/users_info.php">- Beheerders</a></td>
		     <tr>
		     <td ><a href= "http://www.boulamis.nl/boulamis_toernooi/insert_leden_NJBB.php">- Insert NJBB spelers licenties</a></td>
  </tr>

  </tr>

</table>
</div>
<hr color='green'/>

<div style='margin:14pt;font size: 12pt;padding:10pt;background-color:white'>
	<table width=100%>
		<tr><td><h1>Verenigingen</h1></td></tr>
	</table>


<div style='border:inset white solid 1px;margin:12pt;font size: 14pt;padding:10pt;background-color:white;'>


<?php

//// SQL Queries
$qry      = mysqli_query($con,"SELECT * from vereniging  group by Vereniging order by Vereniging " )    or die(mysql_error());  


/// Detail regels

$i=1;                        // intieer teller 
$k=0;
echo "<table width = 100%><tr>";

while($row = mysqli_fetch_array( $qry )) {


?>


	
		<td align=right STYLE ='font size: 9pt; background-color:white;color:red;height:60;' width=10 ><?php echo $i;?>.</td>
		<td width=70><a href= "<?php echo $row['Url_website']; ?>"><img src="<?php echo $row['Url_logo']; ?>" width=60   border =0 ></a>   </td>
    <td STYLE ='font-size: 10pt; background-color:white;color:blue;' width=22%><a href= "<?php echo $row['Prog_url']; ?>"><?php echo $row['Vereniging']; ?><br><?php echo $row['Plaats']; ?> </a></td>
    
  <?php if($k==3){
  	    echo "</tr><tr>";
  	    $k=0;
  	  } else { $k++;
  	  }


$i++;} ?>
</tr>
</table>
</div>

</body>
</html>