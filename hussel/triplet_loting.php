<?php
////  HUSSEL Loting triplet  index.php (c) Erik Hendrikx 2015 ev
////
//// 7 sep 2017 muteer_score kan maximaal 125 records updaten per scherm.  Parameter boven_100  toegevoegd.
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
?>
<html>
<title>OnTip Hussel (c) Erik Hendrikx 2015</title>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">                    
<style type='text/css'><!-- 
BODY {color:black ;font-size: 12pt ; font-family: Comic sans, sans-serif;background-color:white}
TH {color:black ;background-color:white; font-size: 14.0pt ; font-family:Arial, Helvetica, sans-serif;Font-Style:Bold;text-align: left; }
TD {color:blue ;background-color:white; font-size: 12.0pt ; font-family:Arial, Helvetica, sans-serif ;padding-left: 11px;}
h2 {color:blue ;background-color:white; font-size: 14.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}
h1 {color:red ;background-color:white; font-size: 16.0pt ; font-family:Arial, Helvetica, sans-serif ;text-align: left;}

// --></style>

</head>
<body>

<?php

$range = $_GET["range"];  // aantal spelers

$triplets      = $range/6;
$triplets      = floor($triplets);
$rest          = $range - ($triplets * 6 );


//   aantal splrs   aantl triplets  banen  rest         correctie    rest           doublets          rest in incompl triplets
//     120            20  (120)            20    --                   -                     -
//     121            18  (108)      21     1                   13                    8                   5
//     122            19  (114)      21     2                    8                    8             
//     123            19  (114)      21     3                    9                    4                   5            
//     124            20  (120)      21     4                    4                    4                              
//     125            20  (120)      21     5                    5                                        5
//     126            21             21    --                   -                     -


switch($rest){
	   case 1; $triplets = $triplets-2;$rest=13;break;
	   case 2; $triplets = $triplets-1;$rest=8;break;
	   case 3; $triplets = $triplets-1;$rest=9;break;
	   case 4; $triplets = $triplets-0;$rest=4;break;
	   case 5; $triplets = $triplets-0;$rest=5;break;
}	   
	
	

$gedaan = array();
$reeks  = array();
$i=1;

$status = 0;
$regels = $range / 6;


while($status == 0){
    $waarde = round(rand(1,$range));
    if(count($gedaan) == $range){
        $status = 1;
    } else if(!in_array($waarde, $gedaan)){
        array_push($gedaan, $waarde);
//        echo $waarde.'<br />';
        $reeks[$i] = $waarde;
        $i++;
    }
}


$i=1;
?>
<h1>Loting triplet hussel voor <?php echo $range;?> spelers.</h1>
<?php
echo "Er kunnen maximaal ". ($triplets)." volledige triplets gevormd worden.<br>";
echo "Er blijven  ". $rest." spelers over.<br><br>";
?>


<table border =1  width=50%>
	<tr>
		<th>Baan</th>
		<th colspan =3>Team rood</th>
	    <td>-</td>
		<th colspan =3>Team zwart</th>
	</tr>
	
	
	<?php
	
	for ($j=1;$j<=$triplets;$j++){
		
		?>
		<tr>
			<td style='color:red;'><?php echo $j;?></td>
			<td><?php echo $reeks[$i];?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+3];?></td>
		  <td><?php echo $reeks[$i+4];?></td>
		  <td><?php echo $reeks[$i+5];?></td>
    </tr>
    <?php 
    $i=$i+6;
  }
  
  ?>
  </table>

   		  
 <h2>Overige <?php echo $rest;?></h2>  		  
<?php

if ($rest > 0){
	// begin waarde
	$i=( $triplets*6);
	
?>
	
	
	<table border =1 width=50%>
	<tr>
		<th>Baan</th>
		<th colspan =3>Team rood</th>
	    <td>-</td>
		<th colspan =3>Team zwart</th>
	</tr>
	
	<?php
	if ($rest ==4){
		?>
		<tr>
	    <td style='color:red;'><?php echo $triplets+1;?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+3];?></td>
		  <td><?php echo $reeks[$i+4];?></td>
	    <td></td>
	  </tr>
	<?php   
 }  // rest =4
   ?>
	<?php
	if ($rest ==5 ){
		?>
		<tr>
	    <td style='color:red;'><?php echo $triplets+1;?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
		  <td><?php echo $reeks[$i+3];?></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+4];?></td>
		  <td><?php echo $reeks[$i+5];?></td>
	    <td></td>
	  </tr>
	<?php   
 }  // rest = 5 
   ?>
	<?php
	if ($rest == 8){
		?>
		<tr>
	    <td style='color:red;'><?php echo $triplets+1;?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+3];?></td>
		  <td><?php echo $reeks[$i+4];?></td>
	    <td></td>
	  </tr>
		<tr>
	    <td style='color:red;'><?php echo $triplets+2;?></td>
		  <td><?php echo $reeks[$i+5];?></td>
		  <td><?php echo $reeks[$i+6];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+7];?></td>
		  <td><?php echo $reeks[$i+8];?></td>
	    <td></td>
	  </tr>
	<?php   
 }  // rest = 8 
   ?>
	<?php
	if ($rest == 9){
		?>
		<tr>
	    <td style='color:red;'><?php echo $triplets+1;?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+3];?></td>
		  <td><?php echo $reeks[$i+4];?></td>
	    <td></td>
	  </tr>
		<tr>
	    <td style='color:red;'><?php echo $triplets+2;?></td>
		  <td><?php echo $reeks[$i+5];?></td>
		  <td><?php echo $reeks[$i+6];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+7];?></td>
		  <td><?php echo $reeks[$i+8];?></td>
		  <td><?php echo $reeks[$i+9];?></td>
	  </tr>
	<?php   
 }  // rest = 9 
   ?>
	<?php
	if ($rest == 13){
		?>
		<tr>
	    <td style='color:red;'><?php echo $triplets+1;?></td>
		  <td><?php echo $reeks[$i+1];?></td>
		  <td><?php echo $reeks[$i+2];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+3];?></td>
		  <td><?php echo $reeks[$i+4];?></td>
	    <td></td>
	  </tr>
		<tr>
	    <td style='color:red;'><?php echo $triplets+2;?></td>
		  <td><?php echo $reeks[$i+5];?></td>
		  <td><?php echo $reeks[$i+6];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+7];?></td>
		  <td><?php echo $reeks[$i+8];?></td>
	    <td></td>
	  </tr>
		<tr>
	    <td style='color:red;'><?php echo $triplets+3;?></td>
		  <td><?php echo $reeks[$i+9];?></td>
		  <td><?php echo $reeks[$i+10];?></td>
	    <td></td>
	    <td>-</td>
		  <td><?php echo $reeks[$i+11];?></td>
		  <td><?php echo $reeks[$i+12];?></td>
		  <td><?php echo $reeks[$i+13];?></td>
	  </tr>
	<?php   
 }  // rest = 13 


		
		
		
} // if rest > 0		
?>

		
		        


</body>
</html>