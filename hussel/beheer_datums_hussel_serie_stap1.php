<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:black;font-size: 8pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:white;font-size: 10pt;background-color:darkblue; }
td {color:black;font-size: 10pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:8pt;}

em {color:blue;font-size: 9pt;text-align:right;}


#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }


</style>

<!---/// Mouse over voor aan/uit zetten images--->

<script type="text/javascript">
function img_uitzetten(i){
	      i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/homeoff.jpg";break;
        case 2:
           document.getElementById('print').src="images/printer.jpg";break;
        }
}

</script>

<script type="text/javascript">
function img_aanzetten(i){
        i = parseInt(i);
        switch (i)
        {
        case 1:
           document.getElementById('home').src="images/home.jpg";break;    
        case 2:
           document.getElementById('print').src="images/printerleeg.jpg";break;  
         }
}
<!----// Javascript voor input focus ------------>

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
 }
     
</script>
</head>
<body>


<?php 
ob_start();

ini_set('display_errors', 'On');
error_reporting(E_ALL);


//// Database gegevens. 

include ('mysqli.php');

$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 

echo "<table width=90%>";
echo "<tr>";
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>
<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ><br>Terug naar score</a>
</td></tr>
</table>
<br>
<br>
<br>

<h2>Beheer datums hussel serie</h2>

<br>
	<br>
	

<div style='text-align:left;color:black;font-size:11pt;Comic sans, sans-serif, Verdana;'>Een hussel serie bestaat uit 1 tot maximaal 20 hussels. In de onderstaande lijst geef je aan welke datums in aanmerking komen voor deze serie. Alle <b>gescoorde punten</b> worden bij elkaar opgeteld zodat je na alle hussels een eindstand kan opmaken.
	<br>Je kan maar 1 serie definieren. Het is <b>noodzakelijk</b> dat de gegevens van al deze hussels tot aan het einde in het systeem blijven staan !!!
</div>
<br>


<?php
$sql_datums   = mysqli_query($con,"SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id."  order by Datum limit 1 ") or die(' Fout in select datum1'); 
$result       = mysqli_fetch_array( $sql_datums );
$hussel_serie = $result['Naam_serie'];

$sql_datums   = mysqli_query($con,"SELECT * FROM hussel_serie WHERE  Vereniging_id = ".$vereniging_id." and Datum <> '' and Datum <> '0000-00-00' order by Datum  ") or die(' Fout in select datums'); 
$count       = mysql_num_rows($sql_datums);	
$i=1;
?>

<h2 style='text-align:left;color:blue;font-size:10pt;font-family:arial;'> Gegevens hussel serie</h2>


	<form action="beheer_datums_hussel_serie_stap2.php" method="POST" >
		<blockquote>
<TABLE  border = 1 width = 40%>
	<TR>
		 <th colspan=1 >Naam hussel serie </th><td colspan=2><input type = 'text' name = 'hussel_serie' value ='<?php echo $hussel_serie;?>' size =45></td>
	</tr>
</table>
<br>
Om regel te verwijderen, zet vinkje in de kolom Del en klik op Opslaan.

	<TABLE  border = 1 width = 40%>
	<tr><th style='background-color:red;color:white;'>Del</th><th>Omschrijving</th><th>Datum</th></tr>
	<?php
         while($row = mysqli_fetch_array( $sql_datums )) {
	             $id  = $row['Id'];
	             
	             $dag   = 	substr ($row['Datum'] , 8,2); 
               $maand = 	substr ($row['Datum'] , 5,2); 
               $jaar  = 	substr ($row['Datum'] , 0,4); 
	             
	             
	?>  		 
	 <input type ='hidden' name = 'id_<?php echo $i;?>' value = '<?php echo $id;?>'> 
	   
		 		 <tr>		 		 	   <td><input  type ='checkbox'      name ='Check[]' value ='<?php echo $id; ?>'></td>
  		       <td>Datum <?php echo $i;?></td><td><input type = 'text' name = 'datum_<?php echo $i;?>'  value ='<?php echo $row['Datum'] ;?>' size =8>  <em><?php echo strftime("%a %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );?></em></td>
	       </tr>
	      <?php
      	$i++;
       }// end while
  
    //  aanvullen tot 20

	 $j =$i;
	 
	 for ($j;$j<21;$j++){
	 	?>
	 	
	
		 <tr>
		 		 	   <td></td>
  		       <td>Datum <?php echo $j;?></td><td><input type = 'text' name = 'datum_<?php echo $j;?>' size = 8> <em> jjjj-mm-dd</em></td>
	       </tr>
	      
	      <?php
      
       }// end for
	?>
	
	<TABLE>
		</blockquote>
	
    
   
             	     <INPUT style ='font-size:12pt;color;darkblue;font-weight:bold;' type='submit' value='Opslaan'>
    </FORM>     
<br>


</body>
</html>

