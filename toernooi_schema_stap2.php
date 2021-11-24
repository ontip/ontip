<?php
# toernooi_schema.pdf
# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 17mei2019         -            E. Hendrikx 
# Symptom:   		    None.
# Problem:     	    None
# Fix:              None
# Feature:          Migratie PHP 5.6 naar PHP 7
# Reference: 

# 30jan2020         -            E. Hendrikx 
# Symptom:   		None.
# Problem:     	    None
# Fix:              None
# Feature:          Andere aanroep mpdf
# Reference: 

?>
<html>
<head>
<title>Toernooi schema</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
 
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>


<style type="text/css" media="print">
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:black;font-size: 1.8vh;background-color:white;font-weight:bold;}
td {color:black;font-size: 1.8vh;background-color:white;}
 
.noprint {display:none;}    


</style>
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

<!---// Javascript voor aanpassen achtergrondkleur en tekst kleur ----------->
<script type="text/javascript">
function change(that, fgcolor, bgcolor){
that.style.color           = fgcolor;
that.style.backgroundColor = bgcolor;
}

<!---// Javascript voor paste clipboard in textares met id textArea ----------->
function PasteKleur() {
document.getElementById("textArea").innerText             = window.clipboardData.getData("Text").toUpperCase();
document.getElementById("textArea").style.backgroundColor = "lightblue"; 
}
</Script>


 <script type="text/javascript">
function SelectRange (element_id) {
var d=document;
if(d.getElementById ) {
var elem = d.getElementById(element_id);
if(elem) {
if(d.createRange) {
var rng = d.createRange();
if(rng.selectNodeContents) {
rng.selectNodeContents(elem);
if(window.getSelection) {
var sel=window.getSelection();
if(sel.removeAllRanges) sel.removeAllRanges();
if(sel.addRange) sel.addRange(rng);
}
}
} else if(d.body && d.body.createTextRange) {
var rng = d.body.createTextRange();
rng.moveToElementText(elem);
rng.select();
}
}
}
}
</script>
<script type="text/javascript">
function CopyToClipboard()
{
   CopiedTxt = document.selection.createRange();
   CopiedTxt.execCommand("Copy");
}
</script>
</head>
 
<?php 
ob_start();

// Database gegevens. 
include('mysqli.php');
// include('action.php');

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

  foreach($_POST as $key => $value) 
    { 
        # controleren of $value een array is 
        if (is_array($value)) 
        { 
            foreach($value as $key_sub => $value_sub) 
            { 
                $key2 = $key . $key_sub; 
                $$key2 = $value_sub; 
            } 
        } 
        else 
        { 
            $$key = trim($value);                  /// Maakt zelf de variabelen aan
        } 
    } 
	
	
/*	
$aantal      = $_POST['Aantal'];
$rondes     = $_POST['Rondes'];
$toernooi        = $_POST['Toernooi'];
$tekens   = $_POST['Tekens'];
$vrijloting      = $_POST['Vrijloting'];
$vereniging      = $_POST['Vereniging'];
$invul_namen     = $_POST['invul_namen'];
$toernooi_voluit = $_POST['Toernooi_naam'];
$naam_printen    = $_POST['Naam_printen'];
//  $soort_spel      = $_POST['Soort'];
$baan_toewijzing = $_POST['Baan'];

*/

$_aant_splrs          = $aantal;	

if ($vrijloting == 'J'){
	$aantal++;
}

//// Change Title //////
?>
<script language="javascript">
 document.title = "Toernooi schema <?php echo  $toernooi_voluit; ?> <?php echo  $vereniging; ?>";
</script> 
<?php

/// Maak gebruik van tabel toernooi_schema

// schonen tabel
mysqli_query($con,"Delete from toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  


if (isset($toernooi)) {
 	$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Regel < 9000 order by Regel")     or die(' Fout in select config');  
 }
else {
		echo " Geen toernooi bekend :";
	};

/// Ophalen spelers
$namen       = mysqli_query($con,"SELECT * from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  order by Inschrijving")     or die(' Fout in select inschrijf');  

// Ophalen toernooi gegevens
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


if ($toernooi =='') {
	$toernooi = $toernooi_voluit;
}
 

?>
<body bgcolor="white">

<?php
 
 if ($naam_printen == 'J' ){?>
  <div    style='border: red solid 1px;padding-left:5px;'> 
       <h1>Toernooi schema "<?php echo $toernooi;?>" <h1>
   </div>
   <?php 
   } 
   else {  ?>
  <div    style='border: red solid 1px;padding-left:5px;'> 
    <h1>Toernooi schema <?php echo $rondes;?>  voorgeloot<h1>
	 </div>
	<?php
  }
?>
 
<div class='row'>
 <div class ='col-12 ml-5'>
  <br>Dit schema bevat een uitdraai van <b><?php echo $rondes;?> </b>  voorgelote partijen voor <span style='font-size:14pt;font-weight:bold;'><?php echo $_aant_splrs;  ?> </span> deelnemende teams 
<?php
if ($vrijloting == 'J'){
	echo "(+ 1 vrijloting)";
}	
?>
</div>
</div>
<br>


<!--  Knoppen voor verwerking   ----->
<TABLE class='noprint ml-5' width=100%>
	<tr><td valign="top" > 
<span   role= 'button' class="btn btn-primary noprint" alt=''    onClick='window.print()'><i class="fas fa-print"></i> Print deze pagina</span>
</td>
<td valign="top" >
<form method = 'post' action='print_toernooi_score_form.php?toernooi=<?php echo $toernooi_voluit;?>&invul_namen=<?php echo $invul_namen;?>'>
<input type='hidden' name='Toernooi'    value="<?php echo $toernooi;    ?>" /> 
<input type='hidden' name='Vereniging'  value="<?php echo $vereniging;  ?>" /> 
<input type='hidden' name='Aantal'      value="<?php echo $aantal;  ?>" /> 
<input type='hidden' name='Rondes'      value="<?php echo $rondes; ?>" /> 
<input type='hidden' name='Tekens'      value="<?php echo $tekens; ?>" /> 
<input type='hidden' name='Baan_toewijzing'      value="<?php echo $baan_toewijzing; ?>" /> 

<input type= 'submit' role= 'button' class="btn btn-success noprint" value="Klik hier voor PDF score formulieren" > 

</center><br>

</form>


</td>
</tr>
</table>

<?php
$spelers = '';

/// Maak een string met de nummers 1 t/m aantal (3 posities)
for ($i=1;$i<=$aantal;$i++){
	  $spelers   .= sprintf("%03d",$i);          // leading zeroes to len 3
} /// end for i

$aant_wedstr = $aantal / 2;	


	//Bepaal schema
	
//// bouw schema
/// eerste ronde :
//  A-B
//  C-D
//  E-F

// volgende rondes afleiden van dit systeem . eerste rij, eerste kolom blijft staan
// rechter kolom daalt, linker kolom stijgt.
// tweede van linker kolom, wordt eerste van rechter kolom
// onderste van rechter kolom verplaats zich naar onderste van linker kolom

/// tweede ronde
//  A-C
//  E-B,
//  F-D

/// 3e ronde
//  A-E
//  F-C
//  D-B

$j = 1;          /// ronde teller
$b = 1;          /// baan teller
$k = 1;          /// team teller per ronde

/// init arrays
$kolom1        = array();
$kolom2        = array(); 
$baan          = array();
$namen_lijst = array();
$vereniging_lijst = array();


// eerste ronde
for ($k=0;$k<$aantal;$k=$k+2){

/// maak aparte strings voor teams en tegenstanders en baan
$team         = substr($spelers,$k*3,3);              //  A, C, E
$tegenstander = substr($spelers,($k+1)*3,3);          //  B, D, F

$kolom1[$j]           .= sprintf("%03d",$team);       
$kolom2[$j]           .= sprintf("%03d",$tegenstander); 
$baan[$j]             .= sprintf("%03d",$b);       

$b++;

} // end k


/*
echo "teams          ronde ".$j . "-       " . $kolom1[$j] . "<br>"; 
echo "tegenstanders  ronde ".$j . "-       " . $kolom2[$j] . "<br>"; 
echo "baan           ronde ".$j . "-       " . $baan[$j] . "<br>"; 
*/

// vanaf 2e ronde uitgaan van de eerte wedstrijd en dan doorschuiven van posities
for ($j=2;$j<=$rondes;$j++){

$len                = ($aantal/2) *3;
$kolom1[$j]         = substr($kolom1[$j-1],0,3).substr($kolom1[$j-1],6,$len-6).substr($kolom2[$j-1],$len-3,3);
$kolom2[$j]         = substr($kolom1[$j-1],3,3).substr($kolom2[$j-1],0,$len-3);

// per 2 (x3 pos) doorschuiven, anders krijgen sommige spelers steeds dezelfde baan toegewezen.
$baan[$j]           = substr($baan[$j-1],6,$len-6).substr($baan[$j-1],0,6);

/*
echo "teams          ronde ".$j . "-       " . $kolom1[$j] . "<br>"; 
echo "tegenstanders  ronde ".$j . "-       " . $kolom2[$j] . "<br>"; 
echo "baan           ronde ".$j . "-       " . $baan[$j] . "<br>"; 
*/


}// end j


 ////////////////////////////////////////////////////////////////////////////////////// schema 
////  Koptekst

if ($aantal > 32) {
	$font_size = 1.2;
}
else {
	$font_size = 1.4;
}
?>

<table  class='table table-responsive table-bordered table-striped ml-4 mr-4'> 
 <thead>
 <tr>
  <th style='font-size:<?php echo $font_size;?>vh;'>Team</th>
 <?php


if ($invul_namen =='J'){?>
   <th style='font-size:<?php echo $font_size;?>vh;'>Team</th>
   <?php
}

for ($j=1;$j <= $rondes;$j++){?>
  <th style='font-size:<?php echo $font_size;?>vh;'>Ronde <?php echo $j;?></th>
<?php
}
?>
</tr>
</thead>
<tbody>
<?php


$i=1;
$b=1;    // baan teller


// detail regels

 for ($j=1;$j<=$aantal;$j++){                     //// spelers = regels  , rondes = kolommen
 
 	 $_team = chr($j+64); 
 
/// letter code van team kolom 1

 	
    if ($j > 26 and $j < 53){
 			 $_team = chr(65).chr($j+64-26);                   // AA  - Az
 	 	}
 			
 			if ($j > 52 and $j < 79){
 			 $_team = chr(66).chr($j+64-52);                   // BA  - Bx
 	 	}
 			
 	if ($j > 78 and $j < 105){
 			 $_team = chr(67).chr($j+64-78);                   // CA  - Cx
 	 	}
if ($j > 104 and $j < 131){
 			 $_team = chr(67).chr($j+64-104);                   // DA  - Dx
 	 	}

if ($j > 130 and $j < 156){
 			 $_team = chr(67).chr($j+64-130);                   // EA  - Ex
 	 	}


if ($tekens == 'Nummers'){
		 $_team = $j;
	}

if ($vrijloting == 'J' and $j == $aantal) {
	 $_team = 'Vrij' ;
}




if ($invul_namen =='J'){
	
$row = mysqli_fetch_array( $namen );

$namen_lijst[$j]      = $row['Naam1'];
$vereniging_lijst[$j] = $row['Vereniging1'];


switch ($soort_inschrijving) {
		case "single":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size."vh;'>".$_team."</td><td Style='font-family:Courier New;'>".$row['Naam1'] ."</td>";
          break;
          
    case "doublet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size."vh;'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']."</td>";
          break;
    case "triplet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size."vh;'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']." /<br>".$row['Naam3']."</td>";
          break;         
   case "kwintet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size."vh;'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']."/<br>".$row['Naam3']." /<br>";
               $row['Naam4']." / ".$row['Naam5']."<br>".$row['Naam3']."</td>";

          break;   
    case "sextet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size."vh;'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']." / ".$row['Naam3']." /<br>";
               $row['Naam4']." / ".$row['Naam5']." / ".$row['Naam6']."</td>";
          break;   
     }// end switch     
 
} // end if namen
 else {
 	echo "<tr><td Style='font-family:Courier New;font-weight:bold;font-size:".$font_size."vh;'>".$_team."</td>";
} /// end if namen

// ronde 1

$ronde    = 1;
$b        = 1;  // baan teller

for ($ronde=1;$ronde<=$rondes;$ronde++) {  

$x        = $j;
$j        = sprintf("%03d",$j);      // omzetten naar 3 chars


//echo "zoek voor ".$j ." of te wel team ". $_team. ".<br>";

// zoek positie van team in string kolom1(ronde); tegenstander is overeenkomstige pos in kolom2{ronde), baan is overeenkomstige pos in baan{ronde)
 	 	 	  
   for ($k=0;$k<=($aant_wedstr*3);$k=$k+3){        // per stukjes van drie zoeken
   	    $team        = substr($kolom1[$ronde],$k,3);
   	    $_baan       = substr($baan[$ronde],$k,3);
  	    $_baan       = sprintf("%d", $_baan);     // verwijder voorloop nullen
 //     echo $team ."<br>";
             
       
       if ($team == $j){ 
       	  $tegenstander = substr($kolom2[$ronde],$k,3);
          $k=999;
       }   /// end if
        
   } // end for k

 if ($k < 999){                  /// niet gevonden in kolom1{ronde} dan moet het team in kolom2(ronde) zitten
    for ($k=0;$k<=($aant_wedstr*3);$k=$k+3){
     	
       $team        = substr($kolom2[$ronde],$k,3);
       $_baan       = substr($baan[$ronde],$k,3);
       $_baan       = sprintf("%d", $_baan);
       
       if ($team == $j){ 
       	  $tegenstander = substr($kolom1[$ronde],$k,3);
          $k=999;
       }   /// end if
        
      } // end k  	
    } // end if k < 999
    
     
     // omzetten naar letter waarde
     
         $_tegenstander = $tegenstander;
         $y = 0 + $tegenstander;
        
         $tegenstander = chr($tegenstander+64);
         
      if ($_tegenstander > 26 and $_tegenstander < 53){
      	 $tegenstander = chr(65).chr($_tegenstander+64-26);                   // AA  - Ax
 	        }
 	    	  
 			if ($_tegenstander > 52 and $tegenstander < 79){
 	  				 $tegenstander = chr(66).chr($_tegenstander+64-52);                   // BA  - Ax
 	     	}	
 	     	
 	     if ($_tegenstander > 78  and $tegenstander < 115){
 	  				 $tegenstander = chr(67).chr($_tegenstander+64-78);                   // CA  - Ax
 	     	}	
 	     	
 	     	if ($_tegenstander > 104  and $tegenstander < 131){
 	  				 $tegenstander = chr(67).chr($_tegenstander+64-104);                   // DA  - Dx
 	     	}	
 	     	
 	    	if ($_tegenstander > 130  and $tegenstander < 156){
 	  				 $tegenstander = chr(67).chr($_tegenstander+64-130);                   // EA  - Ex
 	     	}	
 	     	
 		    
 		 if ($tekens == 'Nummers'){
		    $tegenstander = sprintf("%d",$_tegenstander);
		    if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aantal) ) {
	         $tegenstander = 'Vrij' ;
         }
		        
		    if ($baan_toewijzing  == 'J' and $tegenstander !='Vrij'){
		 	   	echo "<td style='text-align:right;font-size:".$font_size."vh;'>".$tegenstander." -  (baan ".$_baan.") </td>"; 
	      } else {
	  	 	 echo "<td style='text-align:right;font-size:".$font_size."vh;'>".$tegenstander."</td>"; 
	      }
	 
	 
	   }
	       else {
 		    if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aantal) ) {
	         $tegenstander = 'Vrij' ;
           }
           
         if ($baan_toewijzing  == 'J' and $tegenstander !='Vrij'){
		 	   	echo "<td style='text-align:right;font-size:".$font_size."vh;'>".$tegenstander." -  (baan ".$_baan.") </td>"; 
	      } else {
	  	 	 echo "<td style='text-align:right;font-size:".$font_size."vh;'>".$tegenstander."</td>"; 
	      }  
 		     	
 		     	
 		     	
     }

/*
 echo " tegenstander :" . $_tegenstander . "<br>";
 echo " aantal       :" . sprintf("%03d",$aantal). "<br>";
 echo " vrijloting   :" . $vrijloting . "<br>";
*/

if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aantal) ) {
	 $tegenstander = 'Vrij' ;
}

$team_naam1          = $namen_lijst[$x] ;
$team_vereniging1    = $vereniging_lijst[$x] ;

$tegenstander_naam1  = $namen_lijst[$y] ;

//echo "T: ". $x . "TG: ". $y."<br>";

 $query = "INSERT INTO toernooi_schema(Id, Toernooi, Vereniging,Ronde, Wedstrijd,Team, Team_naam1, Team_vereniging1, Tegenstander,Tegenstander_naam1, Baan)
                         VALUES (0,'".$toernooi."', '".$vereniging ."' ,".$ronde.", ".$j.",'".$_team."', '".$team_naam1."', '".$team_vereniging1."', '".$tegenstander."','".$tegenstander_naam1."',".$_baan."   )";
  // echo $query;
                        
 mysqli_query($con,$query) or die (mysql_error()); 
 $query = "INSERT INTO toernooi_schema(Id, Toernooi, Vereniging,Ronde, Wedstrijd,Team, Team_naam1, Tegenstander,Tegenstander_naam1, Baan)
                         VALUES (0,'".$toernooi."', '".$vereniging ."' ,".$ronde.", ".$j.",'".$tegenstander."','".$tegenstander_naam1."' ,'".$_team."', '".$team_naam1."' ,".$_baan."   )";
 
 //echo $query;
                        
mysqli_query($con,$query) or die (mysqli_error());  

 }/// end for rondes
echo "</tr>";
 }/// end for j
?>
</tbody>
</table>
 <div style='font-size:7pt;'>(c) Copyright OnTip - Erik Hendrikx 2014</div>
 
</div>



</body>
</html>