<html>
	<Title>OnTip score app</title>
	<head>
<style type='text/css'><!-- 
BODY {color:black ;font-size: 49pt ; font-family: Comic sans, sans-serif;background-color:;background-color:#f5deb3;}
TH {color:white ;background-color:blue; font-size: 20.0pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: center; }
TD {color:blue ;font-family:Arial, Helvetica, sans-serif ;}
a  {text-decoration:none;color:white;} 
 
.top  {   font-family: verdana, arial, helvetica, sans-serif;
        border-top-color: #28597a;
        font-weight: bold;
        background:red;
        border: 1px solid #000000;
        border-radius: 5px 10px 5px 10px / 10px 5px 10px 5px;
        border-spacing:5pt;
        width: 100%;}

.top1   {   font-family: verdana, arial, helvetica, sans-serif;
         border-top-color: #1b435e;
        font-weight: bold;
        background:green;
        border: 2px inset black;
        border-style:groove;border:inset 2pt orange;
        border-radius: 5px 10px 5px 10px / 10px 5px 10px 5px;
        border-spacing:5pt;
        width: 100%;}
        
        
.top2   {   font-family: verdana, arial, helvetica, sans-serif;
         border-top-color: #1b435e;
        font-weight: bold;
        background:blue;
        border: 2px inset black;
        border-style:groove;border:inset 2pt orange;
        border-radius: 5px 10px 5px 10px / 10px 5px 10px 5px;
        border-spacing:5pt;
        width: 100%;}
        
// --></style>

<script type="text/javascript">
function doSomething() {
    $.get("validate.php");
    return false;
}
</script>

<script type="text/javascript">
	

function validate_toernooi ( item )
{
   document.validateform_toernooi.Toernooi.value = item ;
   document.validateform_toernooi.submit() ;
}


function validate_team1 ( item )
{
   document.validateform_team1.Team1.value = item ;
   document.validateform_team1.submit() ;
}

function validate_team2 ( item )
{
   document.validateform_team2.Team2.value = item ;
   document.validateform_team2.submit() ;
}

function validate_datum ( item )
{
   document.validateform_datum.Datum.value = item ;
   document.validateform_datum.submit() ;
}

function validate_uitslag ( item )
{
   document.validateform_uitslag.Uitslag.value = item ;
   document.validateform_uitslag.submit() ;
}
</script>
</head>
<!--------------------- ////// -------------------------------------------------------------------------------------------------------------------> 
<body>
	
<?php 
// Database gegevens. 
include('mysqli.php');
/* Set locale to Dutch */
setlocale(LC_ALL, 'nl_NL');
?>	
	
	
<div style='border: #808080 solid inset 13px;background-color:#c0c0c0;width:1900px;padding:10px;'>
<table border =0 width=98%>
<tr><td rowspan=2 width=20%><img src = 'images/icon_score.png' width='350'></td>
<td STYLE ='font-size: 105pt;color:green;'>Score</TD></tr>
<tr><td STYLE ='font-size: 55Pt;color:blue;font-weight:bold;'><i>Mobiel bijhouden score OnTip toernooi.</i></TD>
</TR>
</TABLE>
</div>
<br><br>

<center>
<table border = '0' width=90% >
<tr>
		<td  style ='font-size:20pt;color:white;'  ><center><div  style='height:250px;padding:20px;font-size:60pt;'  class="top1" "><img src='<?php echo $url_logo; ?>'  width=<?php echo $grootte_logo; ?> border =0><br><center><?php echo $vereniging; ?>.</div></center></td>
</tr>
</table>
</center>
<br><br>
<br>

<?php

// formulier POST variabelen ophalen 

// formulier POST variabelen ophalen 
$item              = $_POST['validateitem'];



if ($item =='Toernooi'){
	?>
<form  name="validateform_toernooi"  method="post" action="OnTip_score_init.php"> 

<center><div style ='font-size:65pt;background-color:yellow;color:red;font-family:comic sans;text-align:center;width=1000px;'>Selecteer een toernooi.</div></center><br/>

<center>
<table border = '0' width=78% >
<input type="hidden" name="Toernooi" />

<?php
$qry  = mysqli_query($con,"SELECT  distinct Toernooi From config  where Vereniging = '".$vereniging."' ")     or die(' Fout in select');  

while($row = mysqli_fetch_array( $qry )) { 
$toernooi= $row['Toernooi'];

?>

<tr>
  <td  width=60%  cellspacing=15 style ='color:white;padding:25px;' ><div style='height:200px;padding:25px;font-size:65pt;' class="top" onclick="javascript:validate_toernooi('<?php echo $toernooi; ?>')" onmouseover="this.className='top2'" onmouseout="this.className='top'"><img src='images/user_group.png' width=165 border =0><?php echo $toernooi; ?></div></td></tr>
<tr></tr>
	
	<?php } /// end while
	
	
}// end if
	 ?>

</form>






</body>
</html>
