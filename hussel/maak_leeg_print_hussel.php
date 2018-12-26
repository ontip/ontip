<html>
<head>
<title>Jeu de Boules Hussel (C) 2009  Erik Hendrikx</title>
<style type=text/css>
body {color:blue;font-size: 12pt; font-family: Comic sans, sans-serif, Verdana;background-color:white;  }
th {color:brown;font-size: 10pt;vertical-align:bottom;}
td {color:brown;font-size: 10pt;}

#leeg          {color:white;font-size:7pt;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }

#vb            {color:blue;font-size:7pt;text-align:center;}

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
echo "<td><img src = 'http://www.boulamis.nl/boulamis_toernooi/hussel/images/OnTip_hussel.png' width='240'><br><span style='margin-left:15pt;font-size:12pt;font-weight:bold;color:darkgreen;'>".$vereniging."</span></td>";
echo "<td width=70%><h1 style='color:blue;font-weight:bold;font-size:32pt; text-shadow: 3px 3px darkgrey;'>Hussel ". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )."</h1></td>";
echo "</tr>";
echo "</table>";
echo "<hr style='border:1 pt  solid red;'/>";
?>

<table>
<tr><td valign='center'  >
<a href = 'index.php'><img src='images/home.jpg' border=0 width='45' ></a>
</td></tr>
</table>
<br>
<br>
<br>



<FORM action="print_leeg_hussel.php" method=post>

<blockquote>
    <table>
      <tr>
        <td ALIGN="right" width="430">Aantal spelers om in te vullen (= aantal regels formulier)</td>
        <td><input TYPE="TEXT" NAME="Aantal_rows" SIZE="5" > </td>
      </tr>
      <tr>
        <td ALIGN="right" width="430">Aantal spelrondes om in te vullen (= aantal kolommen formulier)</td>
        <td><input TYPE="TEXT" NAME="Aantal_cols" SIZE="5" > </td>
      </tr>
     </table>
     <br><br>
     <center>
         
     
     
      <table> 
         <tr>
        <td ALIGN="center"><input TYPE="submit" VALUE="Bevestigen" ACCESSKEY="b">&nbsp;&nbsp;
       	<input TYPE="reset" VALUE="Herstellen" ACCESSKEY="h"></td>
      </tr>
    </table>
    </center>
 </blockquote>
 </form>     
      
      

</body>

</html>
