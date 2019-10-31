<html>
	<head>
		<title>OnTip Toernooi kalender tijdelijke oplossing</title>
	<style type='text/css'><!-- 

TH {color:white ;background-color:blue; font-size: 10pt ; font-family:verdana; text-align: left; font-weight: bold;padding:3pt}
TD {background-color:white; font-family:verdana ;padding-left: 9px;font-size: 10pt ;padding:2pt}
h1 {color:darkgreen ; font-size:32pt ; font-family:verdana ;text-align: left;}
h2 {color:blue ; font-size: 11.0pt ; font-family:verdana ;}
h3 {color:darkgreen ;background-color:white; font-size: 11.0pt ; font-family:verdana ;text-align: left;}
.nav {color:darkgreen ; font-size: 10.0pt ; font-family:verdana ;text-align: left;}
a {text-decoration:none;color:blue;}
input:focus, input.sffocus  { background: lightblue;cursor:underline; }
a:hover {color:red;}

#kop a:hover {
 background-color:red;
 color:yellow;
 }

// --></style>
	</head>
	
<body>
<?php
include('mysqli.php');
 $qry2           = mysqli_query($con,"SELECT * From vereniging where Id = ".$vereniging_id."       ")     or die(' Fout in select vereniging');    
             $result         = mysqli_fetch_array( $qry2 );
             $bond     = $result['Bond'] ;
			 
			 
?>
	<blockquote>
	<table width = 90%   >
		<tr> 
			<td  style ='text-align:justify;' width=15% >
				<img src ='../ontip/images/ontip_logo.png' width =200 border = 0 >
			</td>
			<td  style = 'font-size:11pt;'>
<h1> OnTip toernooi kalender - <?php echo $bond;?></h1>
<h2>tijdelijke oplossing </h2>
<br>
Na de herstelactie van de database van Ontip door de installatie op een nieuwe server blijken sommige functies niet meer te werken.<br>
Helaas valt de toernooi kalender hier ook onder. De precieze oorzaak is nog niet duidelijk.Er wordt aan gewerkt om dit zo snel mogelijkop te lossen.
<br>
Hieronder staat een lijst met alle toernooien in OnTip gesorteerd op datum. Klik op de toernooi naam om naar het inschrijf formulier te gaan.<br>
Het kleur gebruik bij de aantallen geeft aan of het aantal ingeschreven deelnemers lager (rood) of hoger (blauw) is dan het resp minimum of maximum aantal spelers voor dat toernooi.


</td>
</tr>
<table>
<hr color = 'red'/>
<?php

setlocale(LC_ALL, 'nl_NL');

?>
<table width = 99% border =1 cellpadding = 0 cellspacing = 0 style='border:3px solid black;' >
	
	<tr>
		<th colspan = 5></th>
			<th style='text-align:center;' colspan = 3> Aantal </th>
		<th>
		</th>
	</tr>
	<tr>
		<th>Nr</th>
		<th>Vereniging</th>
			<th>Plaats</th>
		<th>Toernooi</th>
		<th>Soort</th>
		<th  width=2%>Min</th>
		<th width=2%>Max</th>
		<th width=2%>Nu</th>		
		<th>Datum en tijd</th>
	</th>
	<tr>
	<?php
	
	
	// maak en vul array 
	
$_datums = array();
$today =date('Y-m-d');
$i=0;	
	$qry       = mysqli_query($con,"SELECT * From config as c join vereniging as v on c.Vereniging_id  = v.Id
          	where  Bond = '".$bond."'  group by Toernooi  order by Toernooi")     or die(' Fout in select config');  

         while($row = mysqli_fetch_array( $qry )) {
	
	        $variabele = 'datum'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $toernooi_datum = $result['Waarde'] ;
  
  	        $variabele = 'datum'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $toernooi_datum = $result['Waarde'] ;

  	        $variabele = 'soort_inschrijving'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $soort_inschrijving = $result['Waarde'] ;

	        $variabele = 'min_splrs'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $min_splrs      = $result['Waarde'] ;

	        $variabele = 'max_splrs'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $max_splrs      = $result['Waarde'] ;
    
          $variabele = 'begin_inschrijving'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $begin_inschrijving     = $result['Waarde'] ;

     $variabele = 'aanvang_tijd'; 
             $qry2           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $aanvang_tijd     = $result['Waarde'] ;


            $qry2           = mysqli_query($con,"SELECT count(*)as Aantal From inschrijf where Vereniging_id = ".$row['Vereniging_id'] ." and Toernooi = '".$row['Toernooi'] ."'      ")     or die(' Fout in select datums');    
             $result         = mysqli_fetch_array( $qry2 );
             $aant_splrs      = $result['Aantal'] ;

            $qry2           = mysqli_query($con,"SELECT Plaats From vereniging where Id = ".$row['Vereniging_id'] ."       ")     or die(' Fout in select plaats');    
             $result         = mysqli_fetch_array( $qry2 );
             $plaats     = $result['Plaats'] ;
             
             
      if ($toernooi_datum > $today  and $row['Toernooi'] !='' and $row['Toernooi'] !='erik_test_toernooi'  ){     
	           $_datums[] = $toernooi_datum.";".$row['Toernooi'].";".$row['Vereniging_id'].";".$soort_inschrijving.";".$min_splrs.";".$max_splrs.";".$aant_splrs.";".$plaats.";".$aanvang_tijd;
	
	        }
}// end while


sort($_datums);
	
	echo  "<br><h3>Aantal toernooien : ".count($_datums)."</h3>";
	
	
$i=1;


   foreach ($_datums as $line){
   	
   	//echo "<br>x ".$line;
   	
       	$part = explode(";", $line);
       	$toernooi_datum     = $part[0];
       	$toernooi           = $part[1];
       	$vereniging_id      = $part[2];
        $soort_inschrijving = $part[3];
        $min_splrs          = $part[4];
        $max_splrs          = $part[5];
        $aant_splrs         = $part[6];
        $plaats             = $part[7];
        $aanvang_tijd       = $part[8];
      
             $variabele = 'datum'; 
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select rest');    
             $result       = mysqli_fetch_array( $qry2 );
             $toernooi_datum = $result['Waarde'] ;
 //   echo "SELECT Prog_url, Url_logo,Plaats, Vereniging_nr,Url_website  From vereniging where Vereniging_id = ".$vereniging_id;
    
     
             $sql2      = mysqli_query($con,"SELECT Vereniging,Prog_url, Url_logo,Plaats, Vereniging_nr,Url_website  From vereniging where Id = ".$vereniging_id ." ")     or die(' Fout in select');  
             $result    = mysqli_fetch_array( $sql2 );
             $prog_url  = $result['Prog_url'];
             $logo_url  = $result['Url_logo'];
             $plaats    = $result['Plaats'];
             $vereniging    = $result['Vereniging'];
             $url_website   = $result['Url_website'];   
    
             $link = 'https://www.ontip.nl/'.substr($prog_url,3).'Inschrijfform.php?toernooi='.$toernooi;             
             $dag    = 	substr ($toernooi_datum , 8,2); 
             $maand  = 	substr ($toernooi_datum , 5,2); 
             $jaar   = 	substr ($toernooi_datum , 0,4);
        
             $color   = 'black';
             $bgcolor = 'white';
             
             $variabele = 'toernooi_voluit'; 
             $qry2       = mysqli_query($con,"SELECT Waarde From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi."'  and  Variabele = '".$variabele ."'    ")     or die(' Fout in select rest');    
             $result       = mysqli_fetch_array( $qry2 );
             $toernooi_voluit = $result['Waarde'] 
             
             
         ?>
        <tr>
         	<td style ='text-align:right;'><?php echo $i;?>.</td>
         	<td><a href = "<?php echo $url_website;?>" target='_blank'><?php echo $vereniging;?></a></td>
         	<td><?php echo $plaats;?></td>
         	<td><a href = "<?php echo $link;?>" target ='_blank'><?php echo $toernooi_voluit;?></a></td>
         	<td><?php echo $soort_inschrijving;?></td>
         	<td style='text-align:right;'><?php echo $min_splrs;?></td>
         	<td style='text-align:right;'><?php echo $max_splrs;?></td>     
         	
         	<?php 
         	if ($aant_splrs >= $max_splrs){    
         	   $color   = 'white';
             $bgcolor = 'blue';
         	 } 
         	 
         	 	if ($aant_splrs < $min_splrs ){    
         	   $color   = 'white';
             $bgcolor = 'red';
         	 } 
         	 ?>
        
         	   	<td style = 'background-color:<?php echo $bgcolor;?>;color:<?php echo $color;?>;font-weight:bold;text-align:right;'><?php echo $aant_splrs;?></td>  
        
          
        
        
         	<td><?php echo strftime("%a %d %b %Y", mktime(0, 0, 0, $maand , $dag, $jaar))." ".$aanvang_tijd;?></td>
        </tr>	      
               
 <?php
          
  $i++;
} // end foreach 
?>
</table>
</blockquote>
</body>
</html>