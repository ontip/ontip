 <?php
 # Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 1mei2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           None.
# Reference: 

ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

include('mysqli.php'); 

$today = date('Y-m-d');
$ip    = $_SERVER['REMOTE_ADDR'];

$pageName        = basename($_SERVER['SCRIPT_NAME']);
 // Ophalen toernooi gegevens

$toernooi = $_GET['toernooi'] ;

$qry              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry  )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
//	 echo "<br>".$var;
	}

$qry          = mysqli_query($con,"SELECT * from vereniging where Id = ".$vereniging_id." ")     or die(' Fout in select vereniging');  
$result       = mysqli_fetch_array( $qry  );
$vereniging   = $result['Vereniging'];
$plaats       = $result['Plaats'];

if ($result['Vereniging_output_naam']  !=''){
	$vereniging = $result['Vereniging_output_naam'];
}

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];

switch ($result['Parameters']){
	case "single" : $inschrijf_methode = 'mêlée';break;
	default       : $inschrijf_methode = $soort_inschrijving;break;
}

$variabele       = 'extra_koptekst';
 $qry1           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result         = mysqli_fetch_array( $qry1);
 $text_effect    = $result['Parameters'];
 //$extra_koptekst = $result['Waarde'];


switch ($text_effect){
	case '#n': $extra_koptekst = "<br>". $extra_koptekst;break;
	case '#m': $lichtkrant     = 'Ja';break;
	default : $extra_koptekst  = $extra_koptekst;break;
} // end switch


  if ($licentie_jn =='N'){
	  $licentie_option = 'none';
  } else{
	  $licentie_option = 'block';  
  }


if (isset($meerdaags_toernooi_jn)){
	
	
 if ($meerdaags_toernooi_jn ==''){
    $meerdaags_toernooi_jn = 'N';
    }

 if ($meerdaags_toernooi_jn =='J'){
 	 $variabele = 'eind_datum';
   $qry1      = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ."  and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select adres');  
   $result    = mysqli_fetch_array( $qry1);
   $eind_datum     = $result['Waarde'];
 
 if ($eind_datum ==''){
 	   $eind_datum = $datum;
 }

 $eind_dag   = 	substr ($eind_datum , 8,2); 
 $eind_maand = 	substr ($eind_datum , 5,2); 
 $eind_jaar  = 	substr ($eind_datum , 0,4); 

}   
  // toernooi cyclus
if ($meerdaags_toernooi_jn =='X'){

$datums ='';
$today =  date('Y-m-d');


$sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum >= '".$today."'  order by Datum" )     ; 
	
	while($row = mysqli_fetch_array( $sql )) { 		
		     $datum = $row['Datum'];
	         $dag   = 	substr ($datum , 8,2); 
             $maand = 	substr ($datum , 5,2); 
             $jaar  = 	substr ($datum , 0,4); 
      		$datums  = $datums.",".strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ); 
      }
      $datums = substr($datums,1,250);
  }
  
} else {
 $meerdaags_toernooi_jn = 'N';	
}// end isset

$variabele = 'kosten_team';
 $qry1      = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id." and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
 $result    = mysqli_fetch_array( $qry1);
 $id        = $result['Id'];
 $parameter  = explode('#', $result['Parameters']);
 
 $euro_ind        = $parameter[1];
 $kosten_eenheid  = $parameter[2];
 $kosten_team     = $result['Waarde'];

/// Laatste positie kosten_team geeft aan of Euro teken erbij moet
/// m = met  , z = zonder   (oude situatue, 11-10-2013 vervangen door parameter)
$len       = strlen($kosten_team);
$_euro_ind = substr($kosten_team,-1);

  if ($_euro_ind != 'm' and $_euro_ind != 'z'){
     	$kosten     = $result['Waarde'];
      } 
  else { 
      $len         = strlen($kosten_team);
  //    $_euro_ind    = substr($kosten_team,-1);
      $kosten      = substr($kosten_team,0,$len-1);
}

if ($kosten_eenheid == '1' or $soort_inschrijving  == 'single'){  
 	  $kosten_oms = 'persoon';
} else {
	  $kosten_oms = $soort_inschrijving;
}
  
   	
 if ($euro_ind == 'm') {
    $kosten_team  = ' &#128 '. $kosten . ' per '.$kosten_oms; 
     }  
    else {
    	/// zonder euro sign
    	$kosten_team = $kosten;
 }         
 
 // indicatie voor meld_tijd

$qry          = mysqli_query($con,"SELECT * From config  where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' and Variabele = 'meld_tijd' ") ;  
$result       = mysqli_fetch_array( $qry);
$parameter    = explode('#', $result['Parameters']);
$meld_tijd    = $result['Waarde'];
$prefix       = $parameter[1];
 
 
if ($prefix == '2'){
	 	    $meld_tijd_prefix = 'vanaf'; 
    }
    else {
	     	$meld_tijd_prefix = 'voor'; 
      }

/// Bepalen aantal spelers voor dit toernooi
$aant_splrs_q  = mysqli_query($con,"SELECT Count(*) as Aantal from inschrijf WHERE Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' ")        or die(mysqli_error()); 
$result        = mysqli_fetch_array( $aant_splrs_q);
$aant_splrs    = $result['Aantal'];

// check licentie

if ($datum_verloop_licentie !='0000-00-00'){
/// 01234567890
/// 2014-12-21
$dag    = substr($datum_verloop_licentie,8,2);
$maand  = substr($datum_verloop_licentie,5,2);
$jaar   = substr($datum_verloop_licentie,0,4);

$_datum_verloop = strftime("%d-%m-%Y",mktime(0,0,0,$maand,$dag,$jaar)) ;
$week_ervoor    = strtotime ("-1 week", mktime(0,0,0,$maand,$dag,$jaar));
$week6_erna     = strtotime ("+6 week", mktime(0,0,0,$maand,$dag,$jaar));
$today          = date('Y-m-d');
$_week6_erna    = date("Y-m-d", $week6_erna);
}


?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip inschrijf formulier</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
 <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
 <link rel="icon" href="images/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>

<style>
 <?php
 include("css/standaard.css")
 ?>
 
 input.form-control, select.form-control, check.form-control {
	   font-size:1.4vh;color:black;
	   background-color:<?php echo $achtergrond_kleur_invulvelden; ?>;
 }
 
 input.send[type=checkbox] {
    display:none;
  }
  
input[type="text"][disabled] {
   color: black;
   font-weight:bold;
   background-color:white;
   border:1pt solid darkgrey;
}
   
input.send[type=checkbox] + label
   {
	   background:url('../ontip/images/not_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
       display:inline-block;
	   vertical-align:middle;
	   position:relative;
	 
       padding: 0 0 0 0px;
   }
    
input.send[type=checkbox]:checked + label
    {
	background:url('../ontip/images/icon_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
    }
	
input.avg[type=checkbox] {
    display:none;
  }
  
   
input.avg[type=checkbox] + label
   {
	   background:url('../ontip/images/not_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
       display:inline-block;
	   vertical-align:middle;
	   position:relative;
	 
       padding: 0 0 0 0px;
   }
    
input.avg[type=checkbox]:checked + label
    {
	background:url('../ontip/images/icon_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
    }
	
	
.btn-space {
    margin-right: 8px;
}
 
.btn { box-shadow: 3px 5px #888888;border-radius: 15px;}
table { border:4px solid  black, box-shadow: 5px 10px #888888;
}  
h2 {font-size:2.0vh;}

h6,label {font-size:1.6vh;}
h4 {font-size:1.8vh;}
h5.card-header { color:<?php echo($tekst_kleur); ?>;}	
 
 input.form-control, select.form-control {
    font-size: 1.2vh;
  }
 th ,td {
    font-size: 1.4vh;
  }
  
tr  {height:1.0vh;}

/* If the screen size is 601px wide or more, set the font-size of <class> to 1.4 */
@media screen and (min-width: 601px) {
  p.koptekst,td.koptekst, a.koptekst, div.uitleg,span.uitleg, li {
    font-size: 1.4vh;
	color:black;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.koptekst,td.koptekst, div.uitleg,span.uitleg, li {
    font-size: 1.6vh;
	color:black;
  }
} 
table td {
  position: relative;
}

table xtd xinput {
  position: absolute;
  display: block;
  top:0;
  left:0;
  margin: 0;
  height: 100%;
  width: 100%;
  border: none;
  padding: 10px;
  box-sizing: border-box;
}
</style>
<script language="javascript">
 
function toggleInput(thisname) {
 var x = document.getElementById(thisname);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
 function deRequireCb(elClass) {
            el=document.getElementsByClassName(elClass);

            var atLeastOneChecked=false;//at least one cb is checked
            for (i=0; i<el.length; i++) {
                if (el[i].checked === true) {
                    atLeastOneChecked=true;
                }
            }

            if (atLeastOneChecked === true) {
                for (i=0; i<el.length; i++) {
                    el[i].required = false;
                }
            } else {
                for (i=0; i<el.length; i++) {
                    el[i].required = true;
                }
            }
        }
		

</script>

 </head>

<body >
 
 <?php
//include('include_navbar.php') ;
?>
<!---- novalidate  class="needs-validation" -->
<br>
<div class= 'container'   >
 <FORM  action='inschrijfform_stap2.php' class="needs-validation" novalidate autocomplete="off" name= 'myForm' id= 'myForm' method='post' target="_top">	 
       <input type="hidden" name="zendform"             value="1" /> 
       <input type="hidden" name="toernooi"             value="<?php echo $toernooi;?>" /> 
       <input type="hidden" name="vereniging"           value="<?php echo $vereniging;?>" /> 
       <input type="hidden" name="soort"                value="<?php echo $soort_inschrijving;?>" /> 
       <input type="hidden" name="inschrijf_methode"    value="<?php echo $inschrijf_methode;?>" /> 


 <div class= 'card w-100'>
  <div class= 'card card-header' style='background-color:<?php echo $achtergrond_kleur ; ?>;'>
 	<h4 style='font-family:<?php echo $font_koptekst; ?>;color: <?php echo $koptekst_kleur; ?>;'> Inschrijfformulier <?php echo $toernooi_voluit;?></h4>
	 
	<h5 style='color:<?php echo $tekst_kleur; ?>;'  >
	<?php if ($lichtkrant == 'Ja'  ){ ?>
      	 <marquee><?php echo $extra_koptekst;?></marquee>
      <?php } else {
		  echo $extra_koptekst; 
		  } 	?> 
	 </h5>
   </div>
  	
    <div class= 'card card-body'>

  <h4 style='color:red;'>Toernooi gegevens</h4>
  <br>
  
   <table class='table table-striped w-100   table-bordered' style='box-shadow: 3px 8px #888888;'>
     <tr>
	  <th class='w-25' width=50%  >Toernooi</th>
	  <td><?php echo $toernooi_voluit;?></td>
	  </tr>
	   <tr>
	  <th class='w-25' width=50%  >Vereniging</th>
	  <td><?php echo $vereniging;?> <?php echo $plaats;?></td>
	  </tr>
	  
	   <tr>
	  <th class='w-25' width=50%  >Adres locatie</th>
	  <td><?php echo $adres;?>  </td>
	  </tr>
	  
	  <?php
   	if ($meerdaags_toernooi_jn =='N'){  ?>     
      <tr>
	  <th>Datum toernooi</th>
   
	   <?php
	   $dag   = 	substr ($datum , 8,2); 
       $maand = 	substr ($datum , 5,2); 
       $jaar  = 	substr ($datum , 0,4); 
      ?>
      <td> <?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
	  </tr>
  	<?php } ?>
	
  <?php
   	if ($meerdaags_toernooi_jn =='J'){  ?>     
      <tr>
	  <th>Begindatum toernooi</th>
   
	   <?php
	   $dag   = 	substr ($datum , 8,2); 
       $maand = 	substr ($datum , 5,2); 
       $jaar  = 	substr ($datum , 0,4); 
      ?>
      <td> <?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
	  </tr>
       <tr>
	  <th>Einddatum toernooi</th>
   
	      <?php
	   
	    $eind_dag   = 	substr ($eind_datum , 8,2); 
        $eind_maand = 	substr ($eind_datum , 5,2); 
        $eind_jaar  = 	substr ($eind_datum , 0,4); 
        ?>
    
      <td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $eind_maand , $eind_dag, $eind_jaar) );  ?></td>
	  </tr>   
	<?php } ?>
	
	 <?php
   	if ($meerdaags_toernooi_jn =='X'){  ?>     
      <tr>
	  <th>Toernooi cyclus</th>
   
	   <?php
	   $dag   = 	substr ($datum , 8,2); 
       $maand = 	substr ($datum , 5,2); 
       $jaar  = 	substr ($datum , 0,4); 
      ?>
      <td><?php echo $datums;?>.</td>
	  </tr>
     
	<?php } ?>
	
	 <tr>
	  <th class='w-25' width=50%  >Soort toernooi</th>
	  <td><?php echo $soort_inschrijving;?></td>
	  </tr>
	  
	  <tr>
	  <th class='w-25' width=50%  >Soort inschrijving</th>
	  <td><?php echo $inschrijf_methode;?></td>
	  </tr>
	   
	  <tr>
	  <th class='w-25' width=50%  >Toegang voor</th>
	  <td><?php echo $toegang;?></td>
	  </tr>
	  
	  <tr>
	  <th class='w-25' width=50%  >Melden</th>
	  <td><?php echo $meld_tijd_prefix; ?> <?php echo $meld_tijd; ?></td>
	  </tr>
	
      <tr>
	  <th class='w-25' width=50%  >Start toernooi</th>
	  <td><?php echo $aanvang_tijd;?></td>
	  </tr>
	   
	  <tr>
	  <th class='w-25' width=50%  >Kosten</th>
	  <td><?php echo $kosten_team;?></td>
	  </tr>
	  
	  <tr>
	  <th class='w-25' width=50%  >Prijzen</th>
	  <td><?php echo $prijzen;?></td>
	  </tr>
	 </table>
	 <br>
	 
	 <h4 style='color:red;'>Aantallen</h4>
	 <br>
	  <table class='table table-striped w-100   table-bordered'>
	  <tr>
	  <th class='w-25' width=50%  >Minimum aantal deelnemers</th>
	  <td><?php echo $min_splrs;?></td>
	  </tr>
	  
	  <tr>
	  <th class='w-25' width=50%  >Maximum aantal deelnemers</th>
	  <td><?php echo $max_splrs;?></td>
	  </tr>
	  
	  <tr>
	  <th class='w-25' width=50%  >Maximum aantal reserves</th>
	  <td><?php echo $aantal_reserves;?></td>
	  </tr>
	  
	    <tr>
	  <th class='w-25' width=50%  >Aantal inschrijvingen</th>
	  <td><?php echo $aant_splrs;?></td>
	  </tr>
	  	
	 </table>
 
 <hr>
 <?php
 $vol_geboekt = 0;
 $einde       = 0;
 
 
if ($toernooi_gaat_door_jn == 'N'){ ?>
     <br><div class='uitleg'><center><br><h2>Dit toernooi gaat niet door. Reden : <?php echo $reden_niet_doorgaan;?> </h2></center></div>
	 <?php
     $einde = 1 ;
} // end if


 if ($einde == 0 and $now < $begin_datetime and $today < $datum){ ?>
        <div class='uitleg'><center><h2>Inschrijven voor dit toernooi is pas mogelijk vanaf <?php echo strftime("%A %e %B %Y %H:%M", mktime($begin_uur, $begin_min, 0, $begin_maand , $begin_dag, $begin_jaar) );?></h2></center></div>
      <?php
      $einde = 1 ;
 } // end if
 
 if ($einde == 0 and $today > $datum){?>
        <div class='uitleg'><center><h2>Het toernooi is al geweest.</h2></center></div>
    <?php   
   $einde = 1 ;
}

if ($_week6_erna  < $today){ ?>
  <div class='uitleg'><center><h2 >Er kan niet meer worden ingeschreven voor dit toernooi omdat de OnTip licentie van "<?php echo htmlentities($vereniging_output_naam, ENT_QUOTES | ENT_IGNORE, "UTF-8");?> is verlopen.</h2></center></div>
<?php
  $einde = 1 ;
}

 
 ////    toernooi volgeboekt ////////////////////////////
 
 
 	if ($einde == 0 and $aant_splrs  >= $max_splrs and  $aant_splrs <= ( $max_splrs + $aantal_reserves )  and $meerdaags_toernooi_jn !='X' ){
  // 	$vol_geboekt = 1;
	?>
   	  <div class='uitleg'><b>Het toernooi is volgeboekt . U kunt zich nog als reserve team of speler inschrijven voor het geval er iemand afzegt (Max. <?php echo $aantal_reserves;?> reserves).
	   <br>Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.</b>
	  <?php
	  
	   // 25 aug 2018 Email notificaties als toernooi vol is en aantal_reserves = 0 
	   
	   if ($email_notificaties_jn =='J' and $aantal_reserves ==0  and $meerdaags_toernooi_jn !='X') {
		   ?>
	   	  <div class='uitleg'><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.<br>";
	   	  <a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center><br>
           <?php	  
	  }	  ?>
	    </div>
	   </div>
	   <?php
   }
   
   if ($einde == 0 and $aant_splrs  >= $max_splrs and  $aant_splrs <( $max_splrs + $aantal_reserves ) and $meerdaags_toernooi_jn !='X'  ){
   	$vol_geboekt = 1;
	?>
   	 <div class ='uitleg'  >Het toernooi is volgeboekt. U kunt zich nog als reserve team of speler inschrijven voor het geval er iemand afzegt (Max. <?php echo $aantal_reserves;?> reserves)
	   <br>Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.
	  <?php
	   if ($email_notificaties_jn =='J' and $aantal_reserves == 0) {
		   ?>
	   	  <div class='uitleg'><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.<br>";
	   	  <a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center><br>
        <?php   	  
	  }	  ?>
	    </div>
	   </div>
	   <?php
   }
   
    if ($einde == 0 and $aant_splrs  >= $max_splrs and  $aant_splrs <( $max_splrs + $aantal_reserves ) and $meerdaags_toernooi_jn !='X'  ){
   	$vol_geboekt = 1;
	?>
   	 <div style='font-weight:bold;font-size:10pt;border:1pt solid black;padding:2pt;'>Het toernooi is volgeboekt. U kunt zich nog als reserve team of speler inschrijven voor het geval er iemand afzegt (Max. ".$aantal_reserves." reserves). ";
	   Wij nemen contact met u op. Indien u de dag voor het toernooi nog niets heeft vernomen, neem dan gerust contact op om te vragen of u toch kunt deelnemen.<br>
	 <?php
	   if ($email_notificaties_jn =='J' and $aantal_reserves == 0) {
		   ?>
	   	  <div class='uitleg'><br>Via onderstaande link kunt u zich aanmelden voor email notificaties. Indien er een plek vrijkomt, krijgt u direct een email bericht.<br>";
	   	  <a href ='toevoegen_email_notificatie_stap1.php?toernooi=".$toernooi."&email_notificatie' target='_self'>Klik hier voor aanmelden Email notificatie</a></center><br>
        <?php   	  
	  }	  ?>
	    </div>
	   </div>
	   <?php
   }
   
if ($vol_geboekt ==0 and $einde == 0){?> 
 <br>
  <p class ='koptekst'><b>
	   Vul het onderstaande formulier zo volledig mogelijk in om u in te schrijven voor dit toernooi en klik op 'Verzenden'. Indien u uw email adres invult, ontvangt u een bevestiging van uw inschrijving.
	
       <?php
       if ($uitgestelde_bevestiging_jn =='J'   ){?>
  	<br>Dit betreft een <u>voorlopige inschrijving</u>. U ontvangt tzt van de organisatie  een definitieve bevestiging of afwijzing. 
	   <?php } ?>
  </b>
  </p>	 
 <br>
 
	 	
	<!----------------------------------------------- invoer spelers ------------------------------------------//----->
	
	

 <h4 style='color:red;'>Spelers</h4>
 <h6>Vul de onderstaande gegevens in</h6>
 <br>
 <table class='table    table-responsive table-bordered w-auto'>
   <thead>
   <tr>
    <th    width=3%>#</th>
	<th    style = 'display:<?php echo $licentie_option;?>;'>Licentie</th>
	<th     >Naam</th>
	<th     >Vereniging</th>
	</tr>
  </thead>
  
  <tbody>
   <tr>
   <?php  $nr=1;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
	
<?php
        if (($soort_inschrijving =='doublet' or $soort_inschrijving =='triplet' 
		   or $soort_inschrijving =='4x4'    or $soort_inschrijving =='kwintet' 
		   or $soort_inschrijving =='sextet') and $inschrijf_methode !='mêlée' ){?>	
	
  <tr>
   <?php  $nr=2;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
   <?php
		   } //2
   ?>
	
<?php
        if (  ($soort_inschrijving =='triplet' 
		   or $soort_inschrijving =='4x4'   or $soort_inschrijving =='kwintet' 
		   or $soort_inschrijving =='sextet' ) and $inschrijf_methode !='mêlée' ){?>	
	
  <tr>
   <?php  $nr=3;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
   <?php
		   } //3 
   ?>	
	
	<?php
        if (  ($soort_inschrijving =='4x4'   or $soort_inschrijving =='kwintet' 
		   or $soort_inschrijving =='sextet' ) and $inschrijf_methode !='mêlée' ){?>	
	
  <tr>
   <?php  $nr=4;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
   <?php
		   } // 4
   ?>	

<?php
    if (  ( $soort_inschrijving =='kwintet' 		   or $soort_inschrijving =='sextet' ) and $inschrijf_methode !='mêlée' ){?>	
	
 <tr>
   <?php  $nr=5;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
    <?php
  } // 5
   ?>	

<?php
    if (  ( $soort_inschrijving =='sextet' ) and $inschrijf_methode !='mêlée' ){?>	
	
  <tr>
   <?php  $nr=6;?>
   <td width=3% ><b><?php echo $nr;?></b></td>
  	<td   style = 'display:<?php echo $licentie_option;?>;' >
	  <div class="form-group">
          <input   type="text"  name ='licentie<?php echo $nr;?>' size = 2 required class="form-control"   placeholder="Licentie ">
              <span class="invalid-feedback">Geen licentie ingevuld.<br>Indien onbekend vul nnb in</span>  
	   </div>
	</td>
	<td   > 
        <div class="form-group">	
          <input type="text"    name ='naam<?php echo $nr;?>' required               class="form-control"   placeholder="Naam">
              <span class="invalid-feedback">Geen naam ingevuld</span>  
	 </div>
	<td   > 
	 <div class="form-group">
          <input type="text"    name ='vereniging<?php echo $nr;?>' required          class="form-control"   placeholder="Vereniging">
               <span class="invalid-feedback">Geen vereniging ingevuld</span>  
      </div>
	   </td>
	</tr>
    <?php
  } // 6
   ?>	  
   
	</tbody>
 </table>
 <?php
 
  if ($meerdaags_toernooi_jn =='J'){
  	
  	  $variabele      = 'eind_datum';
       $qry1           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result         = mysqli_fetch_array( $qry1);
       $eind_datum     = $result['Waarde'];
       $toernooi_datum = $datum;
    	
  	?>
  <div class= 'row'>    
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Ik speel mee op<br><em style='font-size:1.2vh;'>(Aanvinken wat van toepassing is)</em> </b></label>
      </div>
	   <div class='col-6'>	
	   <?php
  	   while ($toernooi_datum <=  $eind_datum){
  	 		         $_datum = $toernooi_datum; 
         		     $dag   = 	substr ($_datum , 8,2);                                                                 
                     $maand = 	substr ($_datum , 5,2);                                                                 
                     $jaar  = 	substr ($_datum , 0,4);                                                                 
	
         		     ?>
    	         <input type='checkbox' name= 'meerdaags_datum[]'  value ='<?php echo $_datum;?>' checked  /> <?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?><br>
      		  
			   <?php
  	                  $_toernooi_datum    = strtotime ("+1 day", mktime(0,0,0,$maand,$dag,$jaar));
  	                  $toernooi_datum     = date("Y-m-d",  $_toernooi_datum);
  	   }///end while
     ?>
         </div>
	</div> <!-- row-->  
	
  <?php } //meerdaags = Ja  
	 
  if ($meerdaags_toernooi_jn =='X'){
  	
  	  $variabele      = 'eind_datum';
       $qry1           = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select eind datum');  
       $result         = mysqli_fetch_array( $qry1);
       $eind_datum     = $result['Waarde'];
       $toernooi_datum = $datum;
    	
  	?>
  <div class= 'row'>    
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Ik speel mee op<br><em style='font-size:1.2vh;'>(Aanvinken wat van toepassing is)</em> </b></label>
      </div>
	   <div class='col-6'>	
	           <?php
         $sql      = mysqli_query($con,"SELECT * from toernooi_datums_cyclus  where  Vereniging_id = ". $vereniging_id." and Toernooi ='".$toernooi."' and Datum >= '".$today."'  order by Datum" )     ; 
         	
         	while($row = mysqli_fetch_array( $sql )) { 		
         		     $_datum = $row['Datum']; 
         		     $aantal_cyclus = $row['Aantal_splrs'];
         		      
         		       $dag   = 	substr ($_datum , 8,2);                                                                 
                   $maand = 	substr ($_datum , 5,2);                                                                 
                   $jaar  = 	substr ($_datum , 0,4);   
                          
                 $locatie = $row['Locatie'];   
                 if ($locatie !=''){
                 	 $locatie = ".    [".$locatie."]";                                                       
	               }
	               
         		    
                 if ($aantal_cyclus ==''){
                 	$aantal_cyclus = 0;
                 }
	               // als max bereikt is geen input mogelijk

            		if ($aantal_cyclus  >= ( $max_splrs + $aantal_reserves )  ){  ?>
            		      X <em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?>   (vol) </em><br>
                      <?php } else {?>
          		     <input type='checkbox' name='meerdaags_datum[]' value ='<?php echo $_datum;?>'  checked> <em><?php echo strftime("%a %e %B ", mktime(0, 0, 0, $maand , $dag, $jaar) );?> [al <?php echo $aantal_cyclus;?> ingeschreven]</em><br>
         		     <?php
                       }
                
         		    }// while	  	
             ?>
         </div>
	</div> <!-- row-->  
	
  <?php } //meerdaags = X  
	?>
		
	
 <?php if (isset($extra_vraag) and $extra_vraag !=''){ 
          // Extra vraag
      	  $opties = explode(";",$extra_vraag,6);
      	  $vraag  = $opties[0];
      	  ?>
		  
 <div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b><?php echo $vraag;?></b></label>
		 </div>
		<div class='col-6'>	 
		 <div class="form-group">
		 <select name ='extra' required  class="form-control">
	              <option value =''  selected>Maak een keuze..</option>
		 <?php
		        $i=1;
	            while(isset($opties[$i]))  {?>
	  	 
				   <option value ='<?php echo $opties[$i];?>'   ><?php echo $opties[$i];?></option>	                
		        <?php	 
		        	 
		        		$i++;
	      		} // end while
			
			?>
			</select>
			    <span class="invalid-feedback">Geen keuze gemaakt</span>  
         </div>
	</div>
  </div> <!-- row-->
           <?php 
        }/// end if extra
         ?>   
      
   <?php if(isset($extra_invulveld) and $extra_invulveld !='' ){
	    
      //// Extra invulveld
      $variabele = 'extra_invulveld';
       $qry1      = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
       $result    = mysqli_fetch_array( $qry1);
       $id        = $result['Id'];
       
       if ($result['Parameters'] !='') {
       $keuze     = explode('#',$result['Parameters']);
       $verplicht_jn  = $keuze[1];
       $lijst_jn      = $keuze[2];
	  
       }
      else {
      	$verplicht_jn  = 'N';
        $lijst_jn      = 'N';
		$required       =' ';
      }
	  if ($verplicht_jn == "J"){
		   $required       ='required';
	  }
       
	   ?>
     <div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b><?php echo $extra_invulveld;?></b></label>
        </div>
        <div class='col-6'>	
	    <div class="form-group">
	      <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='Extra_invulveld_antwoord' <?php echo $required;?>  class="form-control"  placeholder="Antwoord">
     <?php 
	     if ($required !=''){?>
		   <span class="invalid-feedback">Geen antwoord gegeven.</span>  
		 <?php } ?>
         </div>
      </div>
	  </div> <!-- row-->
	
          <?php 
        }/// end if extra invulveld
         ?>   	
 <hr>
	 
<h4 style='color:red;'>Contact gegevens</h4>
  
   <div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Email <i class="fas fa-key" style='font-size:1.2vh;'></i></b></label>
        </div>
        <div class='col-6'>	
	      <input type="email" autocomplete="autocomplete_off_hack_xfr4!k" name ='email' required  class="form-control"  placeholder="Email adres">
             <span class="valid-feedback">OK</span>
              <span class="invalid-feedback">Geen email ingevuld</span>   
			  </div>
	  </div> <!-- row-->
	  
	 <div class= 'row'>
	  <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Telefoon <i class="fas fa-key" style='font-size:1.2vh;'></i></b></label>
            </div>
       <div class='col-6'>	
	      <input type="number" autocomplete="autocomplete_off_hack_xfr4!k" name ='telefoon' id= 'mobNummer' onchange="checkMobilenumber()" required class="form-control"   placeholder="Telefoon">
               <span class="valid-feedback">OK</span>
              <span class="invalid-feedback">Geen telefoon ingevuld</span>  
			  </div>
	   </div> <!-- row-->		 
	   
	   <?php if ($boulemaatje_gezocht_zichtbaar_jn == 'J' and $soort_inschrijving !='single'){ ?>
	   <br>
	   <div class= 'row'>
	    <div class='col-8'>	
	 <label for="exampleInputEmail1"><b>Wil je meedoen met dit toernooi, maar heb je geen boule maatje ?<br>Of wil je je opgeven als reserve speler ?</b></label>
              </div>
       <div class='col-2'>	
	   <a href='boulemaatje_gezocht_stap1.php?toernooi=<?php echo $toernooi;?>' role='button' class='btn btn-sm btn-danger shadow p-3 mb-5'>"Boulemaatje gezocht" </a>
        	

  
		</div> 
	  </div> <!-- row-->	
	  	<?php } ?> 
	 <hr>
 <br>
	  <div class= 'row'  > 
	  <div class='col-6'>	
     <h6><b>Vraag of opmerkingen</b></h6>
	 </div>
	  <div class='col-6'>	
      <div class="form-outline">
       <textarea style='font-size:1.4vh;' class="form-control" name='opmerkingen'  id="textAreaExample2" rows="4"   placeholder= "Type hier uw vraag of opmerking"></textarea>
        </div> 
	 </div>
	 </div> <!-- row--->	
	  <br>
	<div class= 'row'>
	  <div class='col-12'>
	      <div class="form-group" style='font-size:1.2vh;'>
	         <input type='checkbox' name= 'avg_check' class='avg form-control' id ='avg'  required  onclick='deRequire("avg")'  /><label for="avg"></label>	 
      		   <i class="fas fa-user-secret" style='font-size:1.6vh;'></i> Door dit vakje aan te vinken ga ik akkoord met de verwerking van evt persoonlijke gegevens
              <span class="invalid-feedback">Niet aangevinkt</span>   
    </div>
	 </div>
	 </div> <!-- row--->  
	 <br>
	 
	<?php
	include('include_spam_check.php');
	?>
 
<div style='font-size:1.0vh;'><i class="fas fa-key"></i> Gegevens versleuteld opgeslagen.</div>	  

<?php
}  // volgeboekt
?> 
  </div> <!-- card body--->
  	<div  class ='card-footer'>
	
<?php 
 if ($vol_geboekt == 0 and $einde ==0)	{?>
	<table  width=100%>
		 <tr>
	        <td style ='font-size:1.2vh;text-align:left;'>
			 <a href ='lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi;?>' target='_blank' role='button' class ='btn btn-sm btn-success'><i class="fas fa-list"></i> Lijst deelnemers</a>
  		 </td>
		 	        <td style ='font-size:1.2vh;text-align:center'>
			 <a href ='<?php echo $url_website ?>' target='_blank' role='button' class ='btn btn-sm btn-success'><i class="fas fa-globe"></i> Naar website</a>
  		 </td>
         <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden <i style='font-size:1.6vh;' class='fa fa-paper-plane'></i></button>	
			 </td>
 </tr>
     </table>
 <?php } ?>
 
   </div>
  </div> <!--- card ---->
	 </form>	
</div>  <!--  container ---->
<br>

 <!-- Footer -->
<?PHP
include('include_footer.php');
?>
<!-- Footer -->
  </body>
</html>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();


</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-switch/highlight.js"></script>
    <script src="js/bootstrap-switch/bootstrap-switch.js"></script>
    <script src="js/bootstrap-switch/main.js"></script>