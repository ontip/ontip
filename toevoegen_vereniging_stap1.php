<html>
	<Title>PHP Inschrijvingen (c) Erik Hendrikx</title>
	<head>
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
		<style type='text/css'><!-- 
BODY {color:black ;font-size: 9pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif; color:darkgreen;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 9.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h1 {color:red ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
a {color:blue ; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-decoration:none;}
// --></style>
</head>

<body>
 
<?php
include 'mysql.php'; 

//echo  "vereniging : ". $vereniging;

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

$qry_n          = mysql_query("SELECT  * from vereniging  group by Vereniging order by Vereniging ") ;  
                

// ---------------------------------------------------------------------------------------------------------------------------------------------------
?>
<table STYLE ='background-color:white;'>
<table >
   <tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
   	<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>Aanmaak vereniging</TD>
</TR>
</TABLE>

<hr color= red/>

<br><br>
<center>
<div style='border: white inset solid 1px; width:1000px; text-align: center;'>
<FORM action='toevoegen_vereniging_stap2.php' method='post'>
	<h3  style='padding:10pt;font size=20pt;color:green;text-align:center;'>Toevoegen vereniging</h3>
	
<table width=90%>

	<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Naam vereniging</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:white;color:blue ;'><input type='text'   name='vereniging' size=40 /></label</td></tr>

	<tr><td STYLE ='font size: 12pt; background-color:white;color:red ;'>NJBB vereniging nr</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:white;color:blue ;'><input type='text'   name='vereniging_nr' size=10 /></label</td></tr>

 	<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Plaats vereniging</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:white;color:blue ;'><input type='text'   name='plaats' size=40 /></label</td></tr>
 			
 	<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Beheerder vereniging</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:white;color:blue ;'><input type='text'   name='beheerder' size=40 /></label</td></tr>

 	<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Email beheerder vereniging</td>
 		<td width=50% STYLE ='font size: 15pt; background-color:white;color:blue ;'><input type='text'   name='email_beheerder' size=40 /></label</td></tr>
 			
  <tr><td STYLE ='font size: 12pt; background-color:white;color:red ;'>Prog folder (../naam vereniging/)</td>
 	<td STYLE ='background-color:white;color:blue;font size: 12pt;'><label><input type='text'   name='url'  size=40  /></td></tr>

<tr><td STYLE ='font size: 12pt; background-color:white;color:red ;'>Selecteer bestaande vereniging</td>
<td>
<select name='sel_vereniging' STYLE='font-size:9.5pt;background-color:WHITE;font-family: Courier;width:400px;'>
  <input type='hidden' name= 'no_delete'  value ='J'/>
  <option value='' selected>Kies uit lijst</option>
           <?php           
             while($row = mysql_fetch_array( $qry_n )) {
             		echo "<OPTION  value='".$row['Vereniging_nr']."'>".$row['Vereniging']."     (".$row['Vereniging_nr'].")</OPTION>";	
    	       } // end while
         
           ?>
</select></td></tr>

 	
 <tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Verwijder records in namen tabel. </td><td><input type='checkbox'                   name='delete_namen' value= 'Ja' </label></td></tr>

<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Insert records in namen tabel. </td><td><input type='checkbox'                       name='insert_namen' value= 'Ja' checked</label></td></tr>

<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Update naam gegevens adhv myvereniging.txt tabel. </td><td><input type='checkbox'    name='update_namen' value= 'Ja' checked</label></td></tr>

<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Folder structuur aanmaken                         </td><td><input type='checkbox'    name='create_dirs' value= 'Ja' checked</label></td></tr>

	</td>
</table><br><br>

<center><input type ='submit' value= 'Klik hier na invullen'> </center>
</form> 
<hr color='blue'/>

<br/>
<h3  style='padding:10pt;font size=20pt;color:green;text-align:center;'>Upload bron bestanden (myvereniging.txt, mytoernooi.txt, nocopyimages.txt)</h3>
<?php
// set max file size for upload (500 kb)
$max_file_size = 500000;
?>
<form action="upload_txt_bestand.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.ontip.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">


<table width=90% border = 0 >
	<tr>
<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Prog folder (../naam vereniging/)</td>
 	<td STYLE ='background-color:white;color:blue;font size: 12pt;'><label><input type='text'   name='url'  size=40  /></td></tr>
 	
 	
<td width = 50% style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>Selecteer het txt bestand (klik op Browse/Bladeren..):  </td>
<td style='text-align:right;vertical-align:text-top;width:100pt;'><input   name="userfile" type="file" size="30"><br>
	<input type="submit" name="submit" value="Upload txt bestand" />
	
	</td>
</tr>
</table>
</form>
<br>

<form action="upload_img_bestand.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.ontip.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<table width=90% border = 0 >
<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>Prog folder (../naam vereniging/)</td>
 	<td STYLE ='background-color:white;color:blue;font size: 12pt;'><label><input type='text'   name='url'  size=40  /></td></tr>

<tr>
<td width = 50% style='text-align:left;color:blue;font-size:10pt;font-family:arial;'>Selecteer het image bestand (klik op Browse/Bladeren..):  </td>
<td style='text-align:right;vertical-align:text-top;width:100pt;'><input   name="userfile" type="file" size="30"><br>
	<input type="submit" name="submit" value="Upload img bestand" />
	
	</td>
</tr>
</table>
</form>

<form action="upload_pdf_bestand.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="server" value="ftp.ontip.nl">
<input type="hidden" name="max_file_size" value="<?php echo $max_file_size;?>">

<table width=90% border = 0 >
<tr><td STYLE ='font size: 12pt; background-color:white;color:blue ;'>PDF folder (../ontip/pdf/)</td>
 	<td STYLE ='background-color:white;color:blue;font size: 12pt;'><label><input type='text'   name='url'  size=40  value= '../ontip/pdf/' /></td></tr>

</table>
</form>
</div>
<br><br><a href='index_all.php'>Klik hier om terug te keren naar de menu pagina.</a>

</center>

</body>
</html>
