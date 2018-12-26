<html>
<head>

<style type='text/css'><!-- 
body {color:blue;font-size: 9pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 10pt;vertical-align:bottom;}
td {color:brown;font-size: 12pt;}

h1 {color:blue ; font-size: 18.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h2 {color:blue ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h3 {color:orange ;background-color:white; font-size: 11.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
// --></style>
</head>
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
        case 3:
           document.getElementById('save').src="images/diskette1.jpg";break;
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
        case 3:
           document.getElementById('save').src="images/diskette2.jpg";break;

         }
}

</script>
<body>
	

<?php

//// Database gegevens. 

include ('conf/mysql.php');
include ('conf/sub_date.php');

$dag   = substr($date,8,2);
$maand = substr($date,5,2);
$jaar  = substr($date,0,4);

// Sorteer eerst op winst en dan op saldo
$score     = mysql_query("SELECT * From hussel WHERE Datum = '".$date."'  ORDER BY Winst DESC , Saldo DESC" )            or die(mysql_error());  


/// Schrijf naar printer

// Open printer
$handle = printer_open();

// Select font
$font = printer_create_font("Arial", 148, 76, PRINTER_FW_MEDIUM, false, false, false, -50);
printer_select_font($handle, $font);

printer_write($handle, "Eindstand ");
printer_write($handle, strftime("%A %d %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ));
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");

printer_write($handle, "Nr"\t);


printer_delete_font($font);

///printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);



echo "<br>";
echo "<br>";

echo "<table border='1' font='Arial' fontcolor='Red'>";
echo "<tr> <th width='10'>Nr</th>";

if ($lotnummers == 'On') {
echo " 	  <th Style='width=4;'>Lot</th>"; 
}

echo "<th width='200'>Naam</th>
      <th width='150'>Winst</th>
      <th width='150'>Saldo</th>
      </tr>";

$i = 1;


// keeps getting the next row until there are no more to get
while($row = mysql_fetch_array( $score )) {
	// Print out the contents of each row into a table
	echo "<tr><td>$i</td>";
	
	
	
	  if ($lotnummers == 'On') {
     echo "<td>";  
      echo $row['Lot_nummer'];
      echo "</td>";  
  }
  
  
	
	
	echo "<td>".$row['Naam'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Winst'];
	echo "</td><td Style= 'text-align: right;padding 5pt;'>"; 
	echo $row['Saldo'];
	echo "</td></tr>"; 
 $i++;
} 

echo "</table>";

?>

</body>
</html>
