<html>
<head>
<title>Toernooi schema</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
<script src="../ontip/js/utility.js"></script>
<script src="../ontip/js/popup.js"></script>

<style type="text/css" media="print">
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }
th {color:black;font-size: 12pt;background-color:white;font-weight:bold;}
td {color:black;font-size: 12pt;background-color:white;}
textarea {overflow:hidden;};
input {font-family:Courier New;background:#ffffcc;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }

#tot   {background-color:lightblue;font-weight:bold;} 
#tegen {color:red;font-weight:bold;}
#leeg  {color:white;}
#naam  {Font-weight:bold;font-size:12pt;padding-left:5pt;}
#alert {right;padding:2pt; background-color:red;}
#norm  {text-align: right;padding:2pt; color:blue;}
#score {text-align: right;padding:2pt; color:black;font-weight:bold;}

.popupLink { COLOR: red; outline: none }
.popup { POSITION: absolute; VISIBILITY: hidden; BACKGROUND-COLOR: yellow; LAYER-BACKGROUND-COLOR: yellow; 
         width: 460; BORDER-LEFT: 1px solid black; BORDER-TOP: 1px solid black;
         BORDER-BOTTOM: 3px solid black; BORDER-RIGHT: 3px solid black; PADDING: 3px; z-index: 10 }
.verticaltext1    {font: 11px Arial;position: absolute;right: 5px;bottom: 35px;
                  width: 15px;writing-mode: tb-rl;color:black;}
                  
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
include('mysql.php');
$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');

$aant_splrs      = $_POST['Aantal'];
$aant_rondes     = $_POST['Rondes'];
$toernooi        = $_POST['Toernooi'];
$letter_nummer   = $_POST['Tekens'];
$vrijloting      = $_POST['Vrijloting'];
$vereniging      = $_POST['Vereniging'];
$invul_namen     = $_POST['invul_namen'];
$toernooi_voluit = $_POST['Toernooi_naam'];
$naam_printen    = $_POST['Naam_printen'];
//  $soort_spel      = $_POST['Soort'];
$baan_toewijzing = $_POST['Baan'];

if ($toernooi_voluit =='') {
	$toernooi_voluit = $toernooi;
}



/*
if ($soort_spel == 2 and $baan_toewijzing == 'J') {
	 $aantal_banen = $aant_splrs / 4;  // doublet
} else {
	 $aantal_banen = $aant_splrs / 6; // triplet
} 	 
*/

$_aant_splrs          = $aant_splrs;	

if ($vrijloting == 'J'){
	$aant_splrs++;
}

//// Change Title //////
?>
<script language="javascript">
 document.title = "Toernooi schema <?php echo  $toernooi_voluit; ?> <?php echo  $vereniging; ?>";
</script> 
<?php

/// Maak gebruik van tabel toernooi_schema

// schonen tabel
mysql_query("Delete from toernooi_schema where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'    ") ;  


if (isset($toernooi)) {
	
//	echo $vereniging;
//  echo $toernooi;
	
	$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Regel < 9000 order by Regel")     or die(' Fout in select config');  
 }
else {
		echo " Geen toernooi bekend :";
	};

/// Ophalen spelers
$namen       = mysql_query("SELECT * from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  order by Inschrijving")     or die(' Fout in select inschrijf');  

// Ophalen toernooi gegevens
$qry2             = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysql_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}


/// Ophalen tekst kleur

$sql        = mysql_query("SELECT Tekstkleur,Link From kleuren where Kleurcode = '".$achtergrond_kleur."' ")     or die(' Fout in select kleur');  
$result     = mysql_fetch_array( $sql );
$tekstkleur = $result['Tekstkleur'];
$link       = $result['Link'];

?>
<body bgcolor="white">

<?php
 
 if ($naam_printen == 'J' ){
echo "<div style='border: red solid 1px;padding-left:5px;'>";  
echo"<h1>Toernooi schema ". $toernooi_voluit ." <h1>"; 
echo "</div>";
} 
else { 
echo "<div style='border: red solid 1px;padding-left:5px;'>"; 
echo"<h1>Toernooi schema ". $aant_rondes."  voorgeloot<h1>"; 
?>

<script language="javascript">
 document.title = "Toernooi schema <?php echo $aant_rondes;?> voorgeloot";
</script> 
<?php
echo "</div>";
}
?>
<div style='padding-left:10pt;font-size:10pt;color:black;' >
<br>Dit schema bevat een uitdraai van <?php echo $aant_rondes;?> voorgelote partijen voor <span style='font-size:14pt;font-weight:bold;'><?php echo $_aant_splrs;  ?> </span> deelnemende teams 
<?php
if ($vrijloting == 'J'){
	echo "(+ 1 vrijloting)";
}	
?>
</div>

<br>


<!--  Knoppen voor verwerking   ----->
<TABLE class='noprint' width=100%>
	<tr><td valign="top" > 
<INPUT type= 'button' alt='Print deze pagina' value = 'Print'  onClick='window.print()'>
</td>
<td valign="top" >
<form method = 'post' action='print_toernooi_score_form.php?toernooi=<?php echo $toernooi_voluit;?>&invul_namen=<?php echo $invul_namen;?>'>
<input type='hidden' name='Toernooi'    value="<?php echo $toernooi;    ?>" /> 
<input type='hidden' name='Vereniging'  value="<?php echo $vereniging;  ?>" /> 
<input type='hidden' name='Aantal'      value="<?php echo $aant_splrs;  ?>" /> 
<input type='hidden' name='Rondes'      value="<?php echo $aant_rondes; ?>" /> 
<input type='hidden' name='Tekens'      value="<?php echo $letter_nummer; ?>" /> 
<input type='hidden' name='Baan_toewijzing'      value="<?php echo $baan_toewijzing; ?>" /> 

<input type ='submit' value= 'Klik hier voor PDF score formulieren'> </center><br>
<br><span class='noprint'> De aanmaak van het PDF document met de score briefjes kan wat tijd kosten. Een moment geduld a.u.b</span>
</form>


</td>
</tr>
</table>

<?php
$spelers = '';

/// Maak een string met de nummers 1 t/m aantal (3 posities)
for ($i=1;$i<=$aant_splrs;$i++){
	  $spelers   .= sprintf("%03d",$i);          // leading zeroes to len 3
} /// end for i

$aant_wedstr = $aant_splrs / 2;	


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
$kolom1[]         = array(0);
$kolom2[]         = array(0); 

// eerste ronde
for ($k=0;$k<$aant_splrs;$k=$k+2){

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
for ($j=2;$j<=$aant_rondes;$j++){

$len = ($aant_splrs/2) *3;
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

if ($aant_splrs > 32) {
	$font_size = 11;
}
else {
	$font_size = 12;
}



echo "<table border = 2 id='myTable1'>";
echo "<tr>";
echo "<th colspan = 1 Style='width:10pt;font-size:".$font_size.";'>Team</th>";

if ($invul_namen =='J'){
   echo "<th colspan = 1 Style='width:180pt;font-size:".$font_size.";'>Team</th>";
}

for ($j=1;$j <= $aant_rondes;$j++){
	
echo "<th colspan = 1 Style='width:80pt;font-size:".$font_size.";'>Ronde ".$j."</th>";

}





echo "</tr>";


$i=1;
$b=1;    // baan teller
$namen_lijst[0]='';

/// init arrays
$baan[]         = array(0);


// detail regels

 for ($j=1;$j<=$aant_splrs;$j++){                     //// spelers = regels  , rondes = kolommen
 
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
 	 	
 	 	
//echo $j." - ". $_team."<br>";


if ($letter_nummer == 'Nummers'){
		 $_team = $j;
	}

if ($vrijloting == 'J' and $j == $aant_splrs) {
	 $_team = 'Vrij' ;
}


if ($invul_namen =='J'){
	
$row = mysql_fetch_array( $namen );

$namen_lijst[$j]      = $row['Naam1'];
$vereniging_lijst[$j] = $row['Vereniging1'];


switch ($soort_inschrijving) {
		case "single":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size.";'>".$_team."</td><td Style='font-family:Courier New;'>".$row['Naam1'] ."</td>";
          break;
          
    case "doublet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size.";'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']."</td>";
          break;
    case "triplet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size.";'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']." /<br>".$row['Naam3']."</td>";
          break;         
   case "kwintet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size.";'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']."/<br>".$row['Naam3']." /<br>";
               $row['Naam4']." / ".$row['Naam5']."<br>".$row['Naam3']."</td>";

          break;   
    case "sextet":  		
          echo "<tr><td Style='font-family:Courier New;font-size:".$font_size.";'>".$_team."</td><td Style='font-family:Courier New;'>".
               $row['Naam1']." / ".$row['Naam2']." / ".$row['Naam3']." /<br>";
               $row['Naam4']." / ".$row['Naam5']." / ".$row['Naam6']."</td>";
          break;   
     }// end switch     
 
} // end if namen
 else {
 	echo "<tr><td Style='font-family:Courier New;font-weight:bold;font-size:".$font_size.";'>".$_team."</td>";
} /// end if namen

// ronde 1

$ronde    = 1;
$b        = 1;  // baan teller

for ($ronde=1;$ronde<=$aant_rondes;$ronde++) {  

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
 	     	
 		    
 		 if ($letter_nummer == 'Nummers'){
		    $tegenstander = sprintf("%d",$_tegenstander);
		    if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aant_splrs) ) {
	         $tegenstander = 'Vrij' ;
         }
		        
		    if ($baan_toewijzing  == 'J' and $tegenstander !='Vrij'){
		 	   	echo "<td style='text-align:right;font-size:".$font_size.";'>".$tegenstander." -  (baan ".$_baan.") </td>"; 
	      } else {
	  	 	 echo "<td style='text-align:right;font-size:".$font_size.";'>".$tegenstander."</td>"; 
	      }
	 
	 
	   }
	       else {
 		    if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aant_splrs) ) {
	         $tegenstander = 'Vrij' ;
           }
           
         if ($baan_toewijzing  == 'J' and $tegenstander !='Vrij'){
		 	   	echo "<td style='text-align:right;font-size:".$font_size.";'>".$tegenstander." -  (baan ".$_baan.") </td>"; 
	      } else {
	  	 	 echo "<td style='text-align:right;font-size:".$font_size.";'>".$tegenstander."</td>"; 
	      }  
 		     	
 		     	
 		     	
     }


//echo " tegenstander :" . $_tegenstander . "<br>";
//echo " aantal       :" . sprintf("%03d",$aant_splrs). "<br>";
//echo " vrijloting   :" . $vrijloting . "<br>";

if ($vrijloting == 'J' and sprintf("%03d",$_tegenstander) == sprintf("%03d",$aant_splrs) ) {
	 $tegenstander = 'Vrij' ;
}

$team_naam1          = $namen_lijst[$x] ;
$team_vereniging1    = $vereniging_lijst[$x] ;

$tegenstander_naam1  = $namen_lijst[$y] ;

//echo "T: ". $x . "TG: ". $y."<br>";

 $query = "INSERT INTO toernooi_schema(Id, Toernooi, Vereniging,Ronde, Wedstrijd,Team, Team_naam1, Team_vereniging1, Tegenstander,Tegenstander_naam1, Baan)
                         VALUES (0,'".$toernooi."', '".$vereniging ."' ,".$ronde.", ".$j.",'".$_team."', '".$team_naam1."', '".$team_vereniging1."', '".$tegenstander."','".$tegenstander_naam1."',".$_baan."   )";
  // echo $query;
                        
 mysql_query($query) or die (mysql_error()); 
 $query = "INSERT INTO toernooi_schema(Id, Toernooi, Vereniging,Ronde, Wedstrijd,Team, Team_naam1, Tegenstander,Tegenstander_naam1, Baan)
                         VALUES (0,'".$toernooi."', '".$vereniging ."' ,".$ronde.", ".$j.",'".$tegenstander."','".$tegenstander_naam1."' ,'".$_team."', '".$team_naam1."' ,".$_baan."   )";
 
 //echo $query;
                        
mysql_query($query) or die (mysql_error());  

 }/// end for rondes
echo "</tr>";
 }/// end for j


 echo "</table>";
 echo "<div style='font-size:7pt;'>(c) Copyright OnTip - Erik Hendrikx 2014</div>"
 ?>
</div>



</body>
</html>