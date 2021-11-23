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

# 18mei2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               Vertikaal uitlijnen tekst bij CC. En kleine textuele aanpassingen
# Feature:           None.
# Reference: 

ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

include('mysqli.php'); 
$today    = date('Y-m-d');
$ip       = $_SERVER['REMOTE_ADDR'];
$pageName = basename($_SERVER['SCRIPT_NAME']);
$toernooi_id = $_GET['toernooi'];
 

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';

include('aanlog_checki.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}

//$toernooi_id = 'c96e45d7cf77b40acfd9464c7077daaf';

$toernooi_id = $_GET['toernooi'];
 
  $qry             = mysqli_query($con,"SELECT Toernooi From config WHERE Vereniging_id = ".$vereniging_id."  and md5(Toernooi) = '".$toernooi_id."'  and Variabele ='toernooi_voluit' ")     or die(' Fout in select config');  
  $result          = mysqli_fetch_array( $qry );
  $toernooi_select = $result['Toernooi'];
 
  if ($toernooi_select ==''){
	  echo "<br>Toernooi niet gevonden!";
	  exit;
  }

// Definieer variabelen en vul ze met waarde uit tabel config

$qry  = mysqli_query($con,"SELECT * From config WHERE Vereniging_id = ".$vereniging_id."  and Toernooi = '".$toernooi_select ."' ")     or die(' Fout in select 2');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}   
	

?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - toernooi aanpassen <?php echo $toernooi;?></title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
 <link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">      
 <script src='https://www.google.com/recaptcha/api.js'></script>
 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>


<style>
 <?php
 include("css/standaard.css")
 ?>
 
 input.form-control {
	   font-size:1.4vh;
 }
 
  
.btn-space {
    margin-right: 8px;
	 
}
 
 @media screen and (max-width:576px){
.btn-group{display:flex;    flex-direction: column;}
}

::-webkit-input-placeholder {
   font-size: 25px;
}

:-moz-placeholder { /* Firefox 18- */
      font-size: 25px;
}

::-moz-placeholder {  /* Firefox 19+ */
      font-size: 25px;
}

/* Overriding styles */

::-webkit-input-placeholder {
   font-size: 13px!important;
}

:-moz-placeholder { /* Firefox 18- */
      font-size: 13px!important;
}
::-moz-placeholder {  /* Firefox 19+ */
      font-size: 13px!important;
}

h6  {font-size:1.6vh;}
h4 {font-size:1.8vh;}	


/* If the screen size is 601px wide or more, set the font-size of <class> to 1.4 */
@media screen and (min-width: 601px) {
  p.koptekst,td.koptekst, a.koptekst, label, div.uitleg,span.uitleg {
    font-size: 1.4vh;
	color:black;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.koptekst,td.koptekst, div.uitleg,span.uitleg, label {
    font-size: 1.6vh;
	color:black;
  }
}


</style>
<script language="javascript">
function changeColor(color,id) {
document.getElementById('item1').style.color = "red";
};


function changeBGcolor(id) {
document.getElementById('button1').style.backgroundColor = "red";
};
</script>

 </head>

<body >
 
 <?php
include('include_navbar.php') ;

function haal_parameters($vereniging_id,$toernooi,$arg){
		
	include('mysqli.php');
 			 
	$qry  = mysqli_query($con,"SELECT Parameters  From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'
                 and Variabele ='".$arg."'		  ")     or die(' Fout in select');  
     $result     = mysqli_fetch_array( $qry );
     $parameters = $result['Parameters'];
	 
  return($parameters);
  
	}

?>


<br>
<div class= 'container'   >

 <FORM class="needs-validation" novalidate  action='toernooi_aanpassen_stap2.php' autocomplete="off" name= 'myForm' method='post' target="_top">	 
       <input type="hidden" name="zendform"          value="1" /> 
	   <input type="hidden" name="toernooi_id"   value="<?php echo $toernooi_id;?>" /> 
	   <input type="hidden" name="vereniging_id_md5" value="<?php echo md5($vereniging_id);?>" /> 
	
 <div class= 'card w-100'>
  <div class= 'card card-header'>
   <h4><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $vereniging;?> - <?php echo $toernooi_select;?> - TOERNOOI AANPASSEN</h4>
   </div>
  	
    <div class= 'card card-body'>
	
		<div class ='row'>
		
	 <div class = 'col-11'>
	  <p style='font-size:1.4vh;text-align:justify;'>Hieronder staan de instellingen die rechtstreeks betrekking hebben op het toernooi. Via de UITLEG knop aan de rechterkant kan je uitleg krijgen over de diverse instellingen.
	  Instellingen die betrekking hebben op het formulier kan je aanpassen via de menu optie 'Formulier/Formulier aanpassen' of via deze <a href = 'formulier_aanpassen_stap1.php?toernooi=<?php echo $_GET['toernooi'];?>' target='_self'>link</a>.<br>
	  <br>Na aanpassen op een van beide 'Verzenden' knoppen klikken. Wijzigingen zijn direct actief voor het toernooi. Wilt u een ander toernooi aanpassen? Selecteer deze dan via Toernooi/Toernooi selectie.</p>
	  
	  <?php
	  $sql      = mysqli_query($con,"SELECT * FROM config where Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' and Variabele = 'toernooi_config_compleet'") or die(' Fout in select toernooi '.$toernooi_id);  
       $result   = mysqli_fetch_array( $sql );

      if ($result['Toernooi'] ==''){?>
 	  <p style='font-size:1.4vh;text-align:justify;color:blue;'><i class="fas fa-exclamation-triangle"></i> Het blijkt dat de database niet synchroon is met de instellingen hieronder. Het aanpassen van de waarden kan hierdoor mogelijk iets langer duren.</p>
	  <?php } else {
		  $sync_time = $result['Waarde'];
	  } ?>
      </div>
	  
	  <div class='col-1'>
	   <a href ='uitleg_toernooi_aanpassen.php' class ='btn btn-sm btn-success'>UITLEG</a>
	   </div>
	   <table  width=100%>
		 <tr>
	       <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden</button>	
			 </td>
          </tr>
     </table>
	   </div>
<hr>
 <div class= 'row'>
       <div class='col-6'>	
	     <label for="naam"><b>Systeem naam voor toernooi</b></label>
	     </div>
     
	   <div class='col-6'>	
	   <div class="form-group">
 		    <input type="text"  disabled   name ='toernooi'    class="form-control"   value='<?php echo $toernooi;?>'>
    
	      </div>
      </div>
   </div><!--- row-->
  
  <div class= 'row'>
       <div class='col-6'>	
	     <label for="naam"><b>Naam toernooi op scherm en lijsten</b></label>
	     </div>
     
	   <div class='col-6'>	
	   <div class="form-group">
 		    <input type="text"     name ='toernooi_voluit'    class="form-control"   value='<?php echo $toernooi_voluit;?>'>
        	    <span class="invalid-feedback">Geen toernooi ingevuld</span>	 
	      </div>
      </div>
   </div><!--- row-->

	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Toernooi gaat door</b></label>
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			   <select  name ='toernooi_gaat_door_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
		  $reden= haal_parameters($vereniging_id, $toernooi,'toernooi_gaat_door_jn');
		  
	       switch($toernooi_gaat_door_jn){
  		         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
 		 
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	 </div><!--- row-->

<?php
 if 	($toernooi_gaat_door_jn   !='J') {?>
 
	<div class= 'row'> 	
	  <div class='col-6'>	  
	 		<label for="exampleInputEmail1"><b>Reden voor niet doorgaan</b></label>
			  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	        <input type="text" required name ='reden' placeholder='Geef een reden'  class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value='<?php echo $reden;?>'>
          </div>
          </div>
 
	</div><!--- row--->
	<?php } else {?>
		<div class= 'row'> 	
	  <div class='col-6'>	  
	 		<label for="exampleInputEmail1"><b>Reden voor niet doorgaan</b></label>
			  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	        <input type="text" disabled name ='reden' placeholder='Geef een reden'  class="form-control"   value=''>
          </div>
          </div>
 
	</div><!--- row--->
	<?php	
 
	} ?>
	
 
<div class= 'row'> 
	 <div class='col-6'>	
        <label for="exampleInputEmail1"><b>Meerdaags toernooi</b></label>
	 </div>
         <div class='col-6'>	
          <div class="form-group"> 
		     <select  name ='meerdaags_toernooi_jn' required class="custom-select custom-select-sm mb-3 form-select"    >
			 
			  <?php
              switch($meerdaags_toernooi_jn){
			       case "J":
            	         echo "<option value='J' selected>Ja. Van begin datum tot eind datum</option>";
			             echo "<option value='N' >Nee. Eendaags toernooi</option>";
				         echo "<option value='X'>Cyclus. Meerdere, niet aaneengesloten, datums.</option>";
						 break;
       	           case "N":
                         echo "<option value='N' selected >Nee. Eendaags toernooi</option>";
				         echo "<option value='J' >Ja. Van begin datum tot eind datum</option>";
				         echo "<option value='X'>Cyclus. Meerdere, niet aaneengesloten, datums.</option>";
						 break;
	               case "X":
    			         echo "<option value='X' selected>Cyclus. Meerdere, niet aaneengesloten, datums.</option>";
	                     echo "<option value='N' >Nee. Eendaags toernooi</option>";
				         echo "<option value='J'>Ja. Van begin datum tot eind datum</option>";
						 break;
              }// end switch 
              ?>
           </select>
		
		 </div>
      </div>
    </div> <!-- row--> 

<?php
 if ($meerdaags_toernooi_jn !='X'){?>	
 <div class= 'row'>
	<div class='col-6'>	
	  <label for="datum">
	  <?php
	    if ($meerdaags_toernooi_jn =='J'){?>
	    <b>Begin datum meerdaags toernooi</b></label>	
		<?php } else {?>
	  <b>Datum toernooi</b></label>	
	  <?php } ?>
	</div>
    <div class='col-6'>	
	   <div class="form-group ">
      
		   <?php
				   $dag  = substr($datum,8,2);
				   $mnd  = substr($datum,5,2);
				   $jaar = substr($datum,0,4);
		   ?>
		    <input type='text' disabled size=1 name = 'weekdag' value ='<?php echo strftime("%a", mktime(0, 0, 0, $mnd , $dag, $jaar) );?>'>
			<input type="date"  id="datum"  name="datum" value ="<?php echo $datum;?>">
			<span class="invalid-feedback">Geen datum ingevuld</span>	
	      </div>
    </div>
  </div><!--- row-->
  
 <?php } ?>
 
<?php	
   if ($meerdaags_toernooi_jn =='J'){?>
   <div class= 'row'> 
	 <div class='col-6'>	
        <label for="exampleInputEmail1"><b>Eind datum meerdaags toernooi</b></label>
	 </div>
         <div class='col-6'>	
          <div class="form-group"> 
     	      <?php
				   $dag  = substr($eind_datum,8,2);
				   $mnd  = substr($eind_datum,5,2);
				   $jaar = substr($eind_datum,0,4);
		       ?>
		      <input type='text' disabled size=1 name = 'weekdag' value ='<?php echo strftime("%a", mktime(0, 0, 0, $mnd , $dag, $jaar) );?>'>
		     <input type="date"  name="eind_datum" value ="<?php echo $eind_datum;?>">
		<span class="invalid-feedback">Geen datum ingevuld</span>	
	  </div>
	  </div><!-- col-->
	  
</div> <!-- row--> 	
<br>
  <?php } // meerdaags = Ja
		?>
		
<?php
  if ($meerdaags_toernooi_jn =='X'){?>
    <div class= 'row'>
		<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Cyclus</b></label>
	      </div><!-- col-->
	   <div class='col-6'>
	   <?php
	    	$count = 0;
            $qry2    = mysqli_query($con,"SELECT count(*) as Aantal From toernooi_datums_cyclus where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' " )     or die(' Fout in select cyc');  
            $result    = mysqli_fetch_array( $qry2);
            $count       = $result['Aantal'];
	?>
	   <a href='beheer_cyclus_datums_stap1.php?toernooi=".$toernooi."' target='Toernooi'><i class="fa fa-calendar" aria-hidden="true"></i> Klik hier voor de <?php echo $count;?> datums</a>
	  </div><!-- col-->
 </div> <!-- row--> 	
<br> 
 <?php } ?>
  
<div class= 'row'>
	<div class='col-6'>	
	  <label for="datum"><b>Begin inschrijven</b></label>	
	</div>
    <div class='col-6'>	
	   <div class="form-group ">
      
	 <?php
				   $dag  = substr($begin_inschrijving,8,2);
				   $mnd  = substr($begin_inschrijving,5,2);
				   $jaar = substr($begin_inschrijving,0,4);
				   $uur  = substr($begin_inschrijving,11,2);
				   $min  = substr($begin_inschrijving,14,2);
		   ?>
		       <input type='text' disabled size=1 name = 'weekdag' value ='<?php echo strftime("%a", mktime(0, 0, 0, $mnd , $dag, $jaar) );?>'>
		       <input type="date"  name="datum_begin_inschrijving" value ="<?php echo substr($begin_inschrijving,0,10);?>">
		  
		  <select  name ='begin_inschrijving_uur' required width=3 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($u=1;$u<25;$u++){
					 if($u == $uur){
						 echo "<option value ='".sprintf('%02d', $u)."'  selected>".sprintf('%02d', $u)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $u)."'   >".sprintf('%02d', $u)."</option>";
					 } 
					  
				  }?>
				  </select> 
		    <select  name ='begin_inschrijving_min' required width=2 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($m=0;$m<60;$m=$m+15){
					 if($m == $min){
						 echo "<option value ='".sprintf('%02d', $m)."'  selected>".sprintf('%02d', $m)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $m)."'   >".sprintf('%02d', $m)."</option>";
					 } 
					  
				  }?>
				  </select> 
	   uur
	      </div>
    </div>
  </div><!--- row-->


<div class= 'row'>
	<div class='col-6'>	
	  <label for="datum"><b>Einde inschrijven</b></label>	
	</div>
    <div class='col-6'>	
	   <div class="form-group ">

    <?php
				   $dag  = substr($einde_inschrijving,8,2);
				   $mnd  = substr($einde_inschrijving,5,2);
				   $jaar = substr($einde_inschrijving,0,4);
				   $uur  = substr($einde_inschrijving,11,2);
				   $min  = substr($einde_inschrijving,14,2);
		   ?>
		     <input type='text' disabled size=1 name = 'weekdag' value ='<?php echo strftime("%a", mktime(0, 0, 0, $mnd , $dag, $jaar) );?>'>
		    <input type="date"  name="datum_einde_inschrijving" value ="<?php echo substr($einde_inschrijving,0,10);?>">
		  
		   
		          <select  name ='einde_inschrijving_uur' required width=3 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($u=1;$u<25;$u++){
					 if($u == $uur){
						 echo "<option value ='".sprintf('%02d', $u)."'  selected>".sprintf('%02d', $u)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $u)."'   >".sprintf('%02d', $u)."</option>";
					 } 
					  
				  }?>
				  </select> 
		         <select  name ='einde_inschrijving_min' required width=2 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($m=0;$m<60;$m=$m+15){
					 if($m == $min){
						 echo "<option value ='".sprintf('%02d', $m)."'  selected>".sprintf('%02d', $m)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $m)."'   >".sprintf('%02d', $m)."</option>";
					 } 
					  
				  }
				    echo "<option value ='59'   >59</option>";?>
				 
				  </select> 
               uur
	      </div>
    </div>
  </div><!--- row-->
 <br>

 <div class= 'row'>
       <div class='col-6'>	
	     <label for="naam"><b>Meld tijd op dag van toernooi</b></label>
	     </div>
     
	   <div class='col-6'>	
	   <div class="form-group">
	    <?php
		           $uur  = substr($meld_tijd,0,2);
				   $min  = substr($meld_tijd,3,2);
				   $parameters = haal_parameters($vereniging_id, $toernooi,'meld_tijd');
				   ?>
				   
 		 <select  name ='prefix_meldtijd' required width=3 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  if (substr($parameters,1,1) =='1'){
					 echo "<option value ='1'  selected>Voor</option>";  
				  } else{
					   echo "<option value ='2'  selected>Vanaf</option>";  
				   
				  }
				   echo "<option value ='1'   >Voor</option>";  
				   echo "<option value ='2'   >Vanaf</option>"; 
					 ?>
				  </select> 
		    <select  name ='meldtijd_uur' required width=3 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($u=1;$u<25;$u++){
					 if($u == $uur){
						 echo "<option value ='".sprintf('%02d', $u)."'  selected>".sprintf('%02d', $u)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $u)."'   >".sprintf('%02d', $u)."</option>";
					 } 
					  
				  }?>
				  </select> 
	  	          <select  name ='meldtijd_min' required width=2 class="custom-select-sm form-select-inline"  id="exampleInputEmail1" aria-describedby="naamHelp" >
                  <?php
				  for ($m=0;$m<60;$m=$m+15){
					 if($m == $min){
						 echo "<option value ='".sprintf('%02d', $m)."'  selected>".sprintf('%02d', $m)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $m)."'   >".sprintf('%02d', $m)."</option>";
					 } 
					  
				  }?>
				  </select> 
				    uur
	      </div>
       </div>
   </div><!--- row-->

<div class= 'row'>
       <div class='col-6'>	
	     <label for="naam"><b>Aanvang toernooi</b></label>
	     </div>
        <div class='col-6'>	
	     <div class="form-group">
	    <?php
		           $uur  = substr($aanvang_tijd,0,2);
				   $min  = substr($aanvang_tijd,3,2);
				 
				   ?>
		   
 		 
		    <select  name ='aanvang_uur' required width=3 class="custom-select-sm form-select-inline"    >
                  <?php
				  for ($u=1;$u<25;$u++){
					 if($u == $uur){
						 echo "<option value ='".sprintf('%02d', $u)."'  selected>".sprintf('%02d', $u)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $u)."'   >".sprintf('%02d', $u)."</option>";
					 } 
					  
				  }?>
				  </select> 
	  	          <select  name ='aanvang_min' required width=2 class="custom-select-sm form-select-inline"    >
                  <?php
				  for ($m=0;$m<60;$m=$m+15){
					 if($m == $min){
						 echo "<option value ='".sprintf('%02d', $m)."'  selected>".sprintf('%02d', $m)."</option>";
					 } else{
						 echo "<option value ='".sprintf('%02d', $m)."'   >".sprintf('%02d', $m)."</option>";
					 } 
					  
				  }?>
				  </select> 
				    uur
	      </div>
      </div>
   </div><!--- row-->
<br>
 <div class= 'row'>
      <div class='col-6'>	
	     <label for="naam"><b>Soort toernooi</b></label>
	     </div>
         <div class='col-6'>	
          <div class="form-group">
    
		   <select  name ='soort_inschrijving' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
          <?php 
          switch ($soort_inschrijving){
			  case "single":
			  echo "<option value='single' selected>Tête-a-Tête</option>";
			  break;
			  case "doublet":
			  echo "<option value='doublet' selected>Doublet</option>";
			  break;
			  case "triplet":
			  echo "<option value='triplet' selected>Triplet</option>";
			  break;  
		  }	   // end switch
		  ?>
	           <option value='1'>Tête-a-Tête</option>
		       <option value='2'>Doublet</option>
			   <option value='3'>Triplet</option>
			   <option value='4'>4x4</option>
		       <option value='5'>Kwintet</option>
		       <option value='6'>Sextet</option>
             </select>
             <span class="invalid-feedback">Geen soort ingevuld</span>
       </div>
      </div><!--  col-->
   </div><!--- row-->

 <div class= 'row'>
      <div class='col-6'><label><b>Inschrijven als...</b></label>
	     </div>
         <div class='col-6'>	
          <div class="form-group">
		 <select  name ='inschrijf_methode' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
 
            <?php
  	      $inschrijf_methode= haal_parameters($vereniging_id, $toernooi,'soort_inschrijving');
	       if ($soort_inschrijving == 'single' ){  
 	        $team = ' persoon';
          } else {
	         $team = $soort_inschrijving;
        }
 
          switch ($inschrijf_methode){
			  case "single":
			  echo "<option value='single' selected>Melee</option>";
			  $tekst ='deelnemers';
			  break;
			  case "vast":
			  echo "<option value='team' selected>".$soort_inschrijving."</option>";
			  $tekst = $soort_inschrijving." teams";
			  break;
	     }	   // end switch
		  ?>
              <option value='single'>Melee</option>
		      <option value='vast'><?php echo $soort_inschrijving;?></option>
	       </select>
        
       </div>
       </div> <!-- col--->
	 </div><!--- row-->   

<div class= 'row'> 	
	<div class='col-6'>	   
         <label for="exampleInputEmail1"><b>Kosten deelname inschrijving</b></label>
	 </div>
   	  <div class='col-3'>	
  	  <?php
		   $parameters = haal_parameters($vereniging_id, $toernooi,'kosten_team');
		   $parts = explode("#",$parameters);
		   $kosten_eenheid = $parts[0];
		   $euro_ind       = $parts[1];
		   ?>
	 
	    <div class="form-group">  
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='kosten_team' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value='<?php echo $kosten_team;?>'>
        </div>
       </div>
      <div class='col-3'>   
	  
	   <label for="exampleInputEmail1"><b>Euro teken </b></label>		  
	   <div class="form-group"> 
		  <?php
	if ($euro_ind =='m') {
    	   echo "<input type='checkbox' name= 'euro_sign' checked/> € teken toegevoegd </td>";
    	  }
        else {
      	 echo "<input type='checkbox' name= 'euro_sign' />  € teken toegevoegd";
       }
	   ?>
	 
	   <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen kosten ingevuld</span>
       </div>
	   </div>
</div> <!-- row-->

<?php
if ($inschrijf_methode !='single'){?>
<div class= 'row'> 		   
	   <div class='col-6'>	
	   <label for="exampleInputEmail1"><b>Kosten per</b></label>
	   </div>
	    <div class='col-6'>	
          <div class="form-group">  
	   	 	 <select  name ='kosten_eenheid' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
   
	   <?php
	         if ($kosten_eenheid == '1' ){
               	echo "<option value = '1'  selected/> per persoon.";
  	          	echo "<option value = '2'        /> per ".$team.".  ";
  	      } 
  	      else {
           	    echo "<option value = '1'  /> per persoon.";
  	          	echo "<option value = '2' selected       /> per ".$team.".  ";       	
        }?>
	   </select>
	    
           <span class="invalid-feedback">Geen kosten eenheid ingevuld</span>
       </div>
	   </div>
</div> <!-- row-->	
<?php } ?>

<?php
if ($inschrijf_methode =='single'){?>
<div class= 'row'> 		   
	   <div class='col-6'>	
	   <label for="exampleInputEmail1"><b>Kosten per</b></label>
	   </div>
	    <div class='col-6'>	
          <div class="form-group">  
	   	 	 <select  name ='kosten_eenheid' disabled required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
    
               	 <option value = '1'  selected/> per persoon.
	   </select>
	       </div>
	   </div>
</div> <!-- row-->	
<?php } ?>
	 
<div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Licentie verplicht</b></label>
		</div>
		
		   <div class='col-6'>	
          <div class="form-group">  
	   	 	 <select  name ='licentie_verplicht_jn' required class="custom-select custom-select-sm mb-3 form-select"   >
   
		 <?php
	     switch($licentie_verplicht_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	         	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
 		}// end switch    
		 ?>
		 </select>
	      </div>
	  </div>
</div> <!-- row-->	
	 
<div class= 'row'> 	
	<div class='col-6'>	
	  <label for="adres"><b>Adres speel locatie</b></label>
	 </div>
   	  <div class='col-6'>	
          <div class="form-group">  
		       <input type="text"  name ='adres' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value='<?php echo $adres;?>'>
           <span class="invalid-feedback">Geen adres ingevuld</span>
		   <em>; in de tekst zorgen voor nieuwe regel in adres</em>

       </div>
      </div>
</div> <!-- row-->
<br>	
	  <div class= 'row'> 
	    <div class='col-6'>	
	        <label for="min"><b>Mininimum aantal <?php echo $tekst;?></b></label>
		</div>
         <div class='col-6'>	
          <div class="form-group"> 
		   <input type="number"   name ='min_splrs' id='min'  min='0' max='<?php echo $max_splrs;?>'  placeholder ='aantal, mag 0 zijn' class="form-control" value='<?php echo $min_splrs;?>'>
         </div>
	   </div>
    </div><!--- row-->   
	
  <div class= 'row'> 
	 <div class='col-6'>	
	       <label for="max"><b>Maximum aantal <?php echo $tekst;?></b></label>
		 </div>
         <div class='col-6'>	
          <div class="form-group"> 
 	  <input type="number"  name ='max_splrs' id='max'  min='<?php echo $min_splrs;?>'  placeholder ='aantal, mag 0 zijn' class="form-control" value='<?php echo $max_splrs;?>'>
           
       </div>
	   
	  </div>
  </div><!--- row-->     
	
  <div class= 'row'> 	
	  <div class='col-6'>	
	      <label for="reserve"><b>Maximum aantal reserve <?php echo $tekst;?></b></label>
		  </div>
         <div class='col-6'>	
          <div class="form-group"> 
		  <input type="number" name ='aantal_reserves'    placeholder ='aantal' min='0'  max='<?php echo $max_splrs;?>' class="form-control"  id='reserve'  value='<?php echo $aantal_reserves;?>'>
            
       </div>	 
      </div>
 </div> <!-- row-->
 
<br>
 <div class= 'row'> 	
	  <div class='col-6'>	
         <label for="email"><b>Email voor ontvangst inschrijvingen</b></label>
		  </div>
         <div class='col-6'>	
          <div class="form-group">  
         <input type="email"   name ='email_organisatie' required class="form-control" id="email"  value='<?php echo $email_organisatie;?>'>
             <span class="invalid-feedback">Geen email adres ingevuld</span>
        </div>	 
      </div>
 </div> <!-- row-->
 
 <div class= 'row'> 	
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Email CC</b></label>
		  </div>
		     <div class='col-6'>	
          <div class="form-group">  
         <input type="email"   name ='email_cc'  placeholder='Max 1 email adres' class="form-control"  value='<?php echo $email_cc;?>'>
        </div>
      </div>
  </div> <!-- row-->
	 
 <div class= 'row'> 	
	<div class='col-6'>	
	           <label for="exampleInputEmail1"><b>Email notificaties</b></label>
		   </div>
		     <div class='col-6'>	
          <div class="form-group">  
		 	 <select  name ='email_notificaties_jn' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
  
		 <?php
	     switch($email_notificaties_jn){
  	         	case "J":
  	          	      echo "<option value = 'J'  selected/> Ja ";
  	                  echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	       	          echo "<option value = 'N'  selected/> Nee ";
  	                  echo "<option value = 'J'        /> Ja ";break;
 		}// end switch    
		 ?>
		 </select>
		 </div>
      </div>
	 </div> <!-- row-->
	 <br>
	 
<div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Bevestigen via SMS mogelijk</b></label>
		</div>
		
		   <div class='col-6'>	
          <div class="form-group">  
	   	 	 <select  name ='sms_bevestigen_zichtbaar_jn' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
   
		 <?php
	//	  $reden= haal_parameters($vereniging_id, $toernooi,'toernooi_gaat_door_jn');
		  
	     switch($sms_bevestigen_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	         	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
 		}// end switch    
		 ?>
		 </select>
	      </div>
	  </div>
</div> <!-- row-->	

<div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Voorlopige bevestiging</b></label>
		</div>
		
		   <div class='col-6'>	
          <div class="form-group">  
	   	 	 <select  name ='uitgestelde_bevestiging_jn' required class="custom-select custom-select-sm mb-3 form-select"  id="soort" aria-describedby="naamHelp" >
   
		 <?php
	//	  $reden= haal_parameters($vereniging_id, $toernooi,'toernooi_gaat_door_jn');
		  
	     switch($sms_bevestigen_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	         	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
 		}// end switch    
		 ?>
		 </select>
	      </div>
	  </div>
</div> <!-- row-->	

<div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Automatisch voorlopige bevestiging</b></label>
		</div>
		   <div class='col-6'>	
          <div class="form-group">  
		  <p style='font-size:1.2vh;'>
	        Bij meer dan <input type="text"   size = 1 name ='uitgestelde_bevestiging_vanaf'  placeholder='0' value='<?php echo $uitgestelde_bevestiging_vanaf;?>'>
            inschrijvingen wordt automatisch een voorlopige bevestiging gestuurd.(0 = niet)
		   </p>
		 </div>
      </div>
  </div> <!-- row-->
	<br>
<div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Toegang</b></label>
		 </div>
		  <div class='col-6'>	
           <div class="form-group">  
           <input type="text"   name ='toegang' placeholder='Geef een reden'  class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value='<?php echo $toegang;?>'>
      	</div>
      </div>
  </div> <!-- row-->
	          
 <div class= 'row'> 	
	<div class='col-6'>	
         <label for="systeem"><b>Wedstrijd systeem</b></label>
		  </div>
		  <div class='col-6'>	
           <div class="form-group">  
		   <select  name ='wedstrijd_schema' required class="custom-select custom-select-sm mb-3 form-select"  id="exampleInputEmail1" aria-describedby="naamHelp" >
   <?php
   		$qry_schema_sel     = mysqli_query($con,"SELECT * From wedstrijd_systemen  where Code = '".$wedstrijd_schema."'  ")     or die(' Fout in select wedstrijd schema 1');  
		$result_sel         = mysqli_fetch_array( $qry_schema_sel);
		$schema_sel         = $result_sel['Omschrijving']; 
        $qry_schema         = mysqli_query($con,"SELECT * From wedstrijd_systemen  order by Id ")     or die(' Fout in select wedstrijd schema');   
        ?>
         <option style='color:black;background:white;' value ='<?php echo $wedstrijd_schema;?>'  SELECTED>(<?php echo $wedstrijd_schema;?>) <?php echo $schema_sel;?></option>
       <?php
       while($row2 = mysqli_fetch_array( $qry_schema )) {
        ?>
          <option   value ='<?php echo $row2['Code'];?>'  >(<?php echo $row2['Code'];?>) <?php echo $row2['Omschrijving'];?></option>
        <?php
        }
        ?>
          <option   value =' '  >Geen</option>
        </select>
        </div>
       </div>
 </div> <!-- row-->
 
 <div class= 'row'> 	
	<div class='col-6'>	
         <label for="exampleInputEmail1"><b>Prijzen toernooi</b></label>
	   </div>
		  <div class='col-6'>	
            <div class="form-group">  	 
             <input type="text"   name ='prijzen' placeholder='Wat kan je winnen?'  class="form-control"   value='<?php echo $prijzen;?>'>
      </div>
      </div>
 </div> <!-- row-->
	<br>
 <div class= 'row'> 	
	<div class='col-6'>	  
        <label for="exampleInputEmail1"><b>Toernooi zichtbaar op kalender(s)</b></label>
	   </div>
		  <div class='col-6'>	
            <div class="form-group">
              <?php
              switch($toernooi_zichtbaar_op_kalender_jn){
				  case "0": $omschrijving ='Alle kalenders';break;
				  case "1": $omschrijving ='Kalender van de bond';break;
				  case "2": $omschrijving ='Kalender van de vereniging';break;
				  case "3": $omschrijving ='Geen kalender';break;
			  }
           
			  ?>
	 		  <select  name ='toernooi_zichtbaar_op_kalender_jn' required class="custom-select custom-select-sm mb-3 form-select"  >
                 <option value ='<?php echo $toernooi_zichtbaar_op_kalender_jn;?>' selected><?php echo $omschrijving;?></option>
			     <option value ='0' >Alle kalenders</option>
			     <option value ='1' >Kalender van de bond</option>
			     <option value ='2' >Kalender van de vereniging</option>
			     <option value ='3' >Geen kalender</option>
			</select>  
	   </div>
	 </div>
	</div> <!-- row--> 
	 
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Recensie invoer mogelijk</b></label><br>
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			   <select  name ='recensie_invoer_mogelijk_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($recensie_invoer_mogelijk_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
  </div> <!-- card body--->
  <div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
		       <td style ='font-size:1.0vh;text-align:left;'><i class="fas fa-sync"></i> Laatste synchronisatie: <?php echo $sync_time;?>
  
			 </td>
	       <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden  </button>	
			 </td>
          </tr>
     </table>
  	</div>
  </div> <!--- card ---->
</form> 
</div>  <!--  container ---->


 <!-- Footer -->
<?PHP
include('include_footer.php');
?>
<!-- Footer -->
  </body>
</html>
<script>
    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }
</script>

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
