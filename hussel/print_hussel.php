<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 12pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 10pt;vertical-align:bottom;}
td {color:brown;font-size: 12pt;}
a {text-decoration:none;color:blue;padding-left:2px;padding-right:2pt;font-size:8pt;}
table {border-collapse: collapse;}
#leeg          {color:white;font-size:7pt;}
in
put:focus, input.sffocus { background: lightblue;cursor:underline; }
#vb             {color:blue;font-size:7pt;text-align:center;}
#vul            {color:blue;font-size:7pt;text-align:right;}
#kop            {color:black;font-size:7pt;text-align:center;font-weight:bold;}

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

</script>
</head>
<body>

<?php

ob_start();
include 'mysql.php'; 


$dag   = 	substr ($datum , 8,2); 
$maand = 	substr ($datum , 5,2); 
$jaar  = 	substr ($datum , 0,4); 


echo "<table width=80%>";
echo "<tr>";
echo "<td><img src = 'images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ><BR>Terug naar scores</a>
</td></tr>
</table>
<br>
<br>
<br>



<table>
<tr>
<td ><img src='images/invul1.gif' width='50'><a Style='font-size:12pt;color:blue;padding:4pt;' href='print_naam_hussel.php?datum=<?php echo $datum;?>&sort=Naam'>1a. Print lijst met namen en invulvelden voor scores, gesorteerd op Naam </a>
</td>
</tr>
<tr>
<td ><img src='images/invul1.gif' width='50'><a Style='font-size:12pt;color:blue;padding:4pt;' href='print_naam_hussel.php?datum=<?php echo $datum;?>&sort=Lot'>1b. Print lijst met namen en invulvelden voor scores, gesorteerd op Lotnummer </a>
</td>
</tr>

<tr>
<td><img src='images/invul1.gif' width='50'><a Style='font-size:12pt;color:blue;padding:4pt;'  href='print_namen_lijst.php?datum=<?php echo $datum;?>'>2. Print lijst met alleen namen </a>
</td>
</tr>

<tr>
<td><img src='images/invul1.gif' width='50'><a Style='font-size:12pt;color:blue;padding:4pt;'  href='maak_leeg_print_hussel.php'>3.  Print leeg formulier.</a>
</td>
</tr>

<tr>
<td><img src='images/invul1.gif' width='50'><a Style='font-size:12pt;color:blue;padding:4pt;'  href='print_oude_hussels.php'>4.  Print uitslagen van oude hussels.</a>
</td>
</tr>


</table>
<br>



 
 
 </center>
 
</body>

</html>
