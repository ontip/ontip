 <?php
# aanmelden_als_lid_sms.php
# op basis van invoer van licentie en laatste 3 cijfers van mobiel nummer wordt een random PIN code als SMS verstuurd.

# Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 25jun2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           None.
# Reference: 

ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');

include('mysqli.php'); 
$today = date('Y-m-d');
$ip              = $_SERVER['REMOTE_ADDR'];
$pageName        = basename($_SERVER['SCRIPT_NAME']);
$now             = date('d-m-Y H:i');  // 201701171234    
$return_url      = $_GET['url'] ;         
include('include_write_logfile.php');
include('versleutel_string.php'); 
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

// toernooi is nu bekend uit mysqli
// Ophalen toernooi gegevens
$var              = 'toernooi_voluit';
$qry2             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry2 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}

$qry        = mysqli_query($con,"SELECT * From config  where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'soort_inschrijving'  ") ;  
$result     = mysqli_fetch_array( $qry);
$inschrijf_methode   = $result['Parameters'];
 
 

?>
<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - Muteer inschrijving</title>
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
  
 
  input.trash[type=checkbox] {
    display:none;
  } 
 
  input.trash[type=checkbox]:checked + label
    {
	background:url('../ontip/images/trash_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
    }
    
 input.trash[type=checkbox] + label
   {
	   background:url('../ontip/images/not_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
       display:inline-block;
       padding: 0 0 0 0px;
   }
 

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.uitleg,li, card-text , label   {
    font-size: 1.6vh;
	color:black;
	text-align:justify;
  }
  
  keuze {
    margin-left:1.4vh;
    font-size: 1.4vh;
	color:blue;
  }
  
  th ,td, input.form-control {
    font-size: 1.4vh;
  }
}


@media screen and (min-width: 901px) {
  p.uitleg,li, card-text , label   {
    font-size: 1.6vh;
	color:black;
	text-align:justify;
  }
  
   a  {
    font-size: 1.4vh;
	color:black;
	text-align:justify;
  }
  
   th ,td, input.form-control {
    font-size: 1.2vh;
  }
}
 
h4 {font-size:1.4vh;}

</style>
 
<script language="javascript">
function printPage() {
    window.print();
}
</script>

</head>
<body >

 <?php
$short_menu='Ja';
include('include_navbar.php');

$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and md5(Id) ='".$_GET['id']."'  " )    or die(mysqli_error());  
$result   = mysqli_fetch_array( $qry ) ;
?>
 
  <BR>
   
  <div class= 'container'   >
   <FORM class="needs-validation inline" novalidate  action='beheer_inschrijving_detail_stap2.php' autocomplete="off" name= 'myForm' method='post' target="_top">	 
   	   <INPUT TYPE='hidden' NAME='zendform'                VALUE='1'>
 	   <INPUT TYPE='hidden' NAME='id'                      VALUE='<?php echo $result['Id'];?>'>

 
 <div class= 'card '>
    <div class= 'card card-header'>
    <h3>Beheer inschrijving <?php echo $toernooi_voluit;?></h3>
   
   </div>
 
   <div class= 'card card-body'>
  
   <h4>Speler 1</h4>
   <div class= 'row border-bottom'>
	<div class='col-4'>	
	     <div class="form-group">
           <label for="exampleInputEmail1"><b>Naam</b></label>
	       <input type="text" " name ='naam1' required  class="form-control"  value ='<?php echo $result['Naam1'];?>'  placeholder="Naam speler 1">
 		</div>
		</div>
		
		 <div class='col-4 '>	
	      <div class="form-group">
		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
          <input type="text"  name ='vereniging1' required  class="form-control"  value ='<?php echo $result['Vereniging1'];?>'  placeholder="Vereniging speler 1">
      
       </div>
      </div>
	  <?php
		 if ($licentie_jn == 'J'){?>
	  	 <div class='col-4'>	
	      <div class="form-group">
		    <label for="exampleInputEmail1"><b>Licentie</b></label>
          <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie1' required  class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value ='<?php echo $result['Licentie1'];?>'  placeholder="Licentie speler 1">
		 <?php } ?>
       </div>
      </div>
 </div> <!--  row--->
 
  	 <?php
     if ($soort_inschrijving !='single' and  $inschrijf_methode  != 'single'  ){?>			
       <br><h4>Speler 2</h4>
         <div class= 'row border-bottom'>
         	<div class='col-4  '>	
         	     <div class="form-group">
                    <label for="exampleInputEmail1"><b>Naam</b></label>
         	       <input type="text"   name ='naam2' required  class="form-control"   value ='<?php echo $result['Naam2'];?>'  placeholder="Naam speler 2">
          		</div>
         		</div>
         		
         		 <div class='col-4  '>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='vereniging2' required  class="form-control"   value ='<?php echo $result['Vereniging2'];?>'  placeholder="Vereniging speler 2">
               
                </div>
               </div>
         	  <?php
         		 if ($licentie_jn == 'J'){?>
         	  	 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Licentie</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie2' required  class="form-control"   value ='<?php echo $result['Licentie2'];?>'  placeholder="Licentie speler 2">
         		 <?php } ?>
                </div>
               </div>
         </div> <!--  row--->
	 <?php } // speler 2 
  
   if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
    <br><h4>Speler 3</h4>
         <div class= 'row border-bottom'>
         	<div class='col-4'>	
         	     <div class="form-group">
                    <label for="exampleInputEmail1"><b>Naam</b></label>
         	       <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam3' required  class="form-control"   value ='<?php echo $result['Naam3'];?>'  placeholder="Naam speler 3">
          		</div>
         		</div>
         		
         		 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='vereniging3' required  class="form-control"   value ='<?php echo $result['Vereniging3'];?>'  placeholder="Vereniging speler 3">
               
                </div>
               </div>
         	  <?php
         		 if ($licentie_jn == 'J'){?>
         	  	 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Licentie</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie3' required  class="form-control"   value ='<?php echo $result['Licentie3'];?>'  placeholder="Licentie speler 3">
         		 <?php } ?>
                </div>
               </div>
         </div> <!--  row---> 

        <?php } // speler 3
  
  if (  $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
     <br><h4>Speler 4</h4>
         <div class= 'row border-bottom'>
         	<div class='col-4'>	
         	     <div class="form-group">
                    <label for="exampleInputEmail1"><b>Naam</b></label>
         	       <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam4' required  class="form-control"   value ='<?php echo $result['Naam4'];?>'  placeholder="Naam speler 4">
          		</div>
         		</div>
         		
         		 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='vereniging4' required  class="form-control"   value ='<?php echo $result['Vereniging4'];?>'  placeholder="Vereniging speler 4">
               
                </div>
               </div>
         	  <?php
         		 if ($licentie_jn == 'J'){?>
         	  	 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Licentie</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie4' required  class="form-control"   value ='<?php echo $result['Licentie4'];?>'  placeholder="Licentie speler 4">
         		 <?php } ?>
                </div>
               </div>
         </div> <!--  row---> 

        <?php } // speler 4
		
    if (    $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
     <br><h4>Speler 5</h4>
         <div class= 'row border-bottom'>
         	<div class='col-4'>	
         	     <div class="form-group">
                    <label for="exampleInputEmail1"><b>Naam</b></label>
         	       <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam5' required  class="form-control"   value ='<?php echo $result['Naam5'];?>'  placeholder="Naam speler 5">
          		</div>
         		</div>
         		
         		 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
                   <input type="text"  name ='vereniging5' required  class="form-control"   value ='<?php echo $result['Vereniging5'];?>'  placeholder="Vereniging speler 5">
               
                </div>
               </div>
         	  <?php
         		 if ($licentie_jn == 'J'){?>
         	  	 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Licentie</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie5' required  class="form-control"   value ='<?php echo $result['Licentie5'];?>'  placeholder="Licentie speler 5">
         		 <?php } ?>
                </div>
               </div>
         </div> <!--  row---> 

        <?php } // speler 5
		
    if ($soort_inschrijving =='sextet'  ){?>	
     <br><h4>Speler 6</h4>
         <div class= 'row border-bottom'>
         	<div class='col-4'>	
         	     <div class="form-group">
                    <label for="exampleInputEmail1"><b>Naam</b></label>
         	       <input type="text"  name ='naam6' required  class="form-control"   value ='<?php echo $result['Naam6'];?>'  placeholder="Naam speler 6">
          		</div>
         		</div>
         		
         		 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Vereniging</b></label>
                   <input type="text" name ='vereniging6' required  class="form-control"   value ='<?php echo $result['Vereniging6'];?>'  placeholder="Vereniging speler 6">
               
                </div>
               </div>
         	  <?php
         		 if ($licentie_jn == 'J'){?>
         	  	 <div class='col-4'>	
         	      <div class="form-group">
         		    <label for="exampleInputEmail1"><b>Licentie</b></label>
                   <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie6' required  class="form-control"   value ='<?php echo $result['Licentie6'];?>'  placeholder="Licentie speler 6">
         		 <?php } ?>
                </div>
               </div>
         </div> <!--  row---> 

        <?php } // speler 6
    ?>
	 <br><h4>Inschrijving </h4>
	 
	  <div class= 'row '>
	  <div class='col-6'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b>Email</b></label>
		  <input type="email"   name ='email'  class="form-control"   value ='<?php echo versleutel_string($result['Email_encrypt']);?>'  placeholder="Email ">
          </div>
         </div>
		   <div class='col-6'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b>Telefoon</b></label>
		  <input type="telefoon"   name ='telefoon'    class="form-control"   value ='<?php echo versleutel_string($result['Telefoon_encrypt']);?>'  placeholder="Telefoon ">
          </div>
         </div>
       </div> <!--  row---> 
   
     <div class= 'row '>
	  <div class='col-6'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b>Reservering</b></label>
		  <select name ='reservering' class="form-control">
		      <option value = "<?php echo $result['Reservering'];?>" selected><?php echo $result['Reservering'];?></option>
		      <option value = "J" >Ja</option>
			  <option value = "N" >Nee</option>
		   </select>
	          </div>
         </div>
	    <div class='col-6'>	
         <div class="form-group">
		 <label for="exampleInputEmail1"><b>Status *</b></label>
		  <select name ='reservering' disabled class="form-control">
		      <option value = "<?php echo $result['Status'];?>" selected><?php echo $result['Status'];?></option>
			  <option value = "RE0" >RE0  -  Reservering aangemaakt. Geen email bekend. </option>
			  <option value = "RE1" >RE1  -  Reservering aangemaakt. Geen email bekend. </option>	  
			  <option value = "RE2" >RE2  -  Reservering geannuleerd en gemeld via Email.</option>
			  <option value = "RE3" >RE3  -  Reservering geannuleerd. Geen email bekend. </option>	  
			  <option value = "RE4" >RE4  -  Reservering aangemaakt en bevestigd via SMS.</option>
			  <option value = "RE5" >RE5  -  Reservering geannuleerd en gemeld via SMS.</option>
 		      <option value = "BE0" >BE0  -  Voorlopige inschrijving via Email gemeld.</option>
		      <option value = "BE1" >BE1  -  Voorlopige inschrijving. Geen Email bekend.</option>
		      <option value = "BE2" >BE2  -  Betaald maar nog niet bevestigd</option>
		      <option value = "BE3" >BE3  -  Betaald. Geen email bekend.</option>
		      <option value = "BE4" >BE4  -  Betaald en bevestigd</option>
              <option value = "BE5" >BE5  -  Geannuleerd maar nog niet gemeld.</option>
              <option value = "BE9" >BE9  -  Nog niet bevestigd. Betaling nvt. Geen email bekend.</option>
              <option value = "BEA" >BEA  -  Bevestigd. Betaling nvt. </option>
              <option value = "BEB" >BEB  -  Bevestigd. Betaling nvt. Geen email bekend</option>
 	          <option value = "BEC" >BEC  -  Bevestigd. Nog niet betaald.</option>
              <option value = "BED" >BED  -  Voorlopige inschrijving via SMS gemeld.</option>
              <option value = "BEE" >BEE  -  Bevestigd via SMS.</option>
              <option value = "BEF" >BEF  -  Geannuleerd en gemeld via SMS.</option>
              <option value = "BEG" >BEG  -  Inschrijving vervallen als gevolg van limiet.</option>
 	          <option value = "ID0" >ID0  -  Inschrijving wacht op betaling via IDEAL.</option>
 	          <option value = "ID1" >ID1  -  Inschrijving betaald via IDEAL.</option>
 	          <option value = "ID2" >ID2  -  Betaling via IDEAL mislukt of afgebroken.</option>
              <option value = "DE0" >DE0  -  Door deelnemer ingetrokken inschrijving (via mail).</option>
              <option value = "DE1" >DE1  -  Door deelnemer ingetrokken inschrijving (geen mail bekend).</option>
              <option value = "DE2" >DE2  -  Door deelnemer ingetrokken inschrijving (via SMS).</option>
              <option value = "IN0" >IN0  -  Ingeschreven en bevestigd via email.</option>
              <option value = "IN1" >IN1  -  Ingeschreven. Geen email bekend.</option>
              <option value = "IN2" >IN2  -  Ingeschreven en gemeld via SMS.</option>
	          <option value = "IN3" >IN3  -  Reservering omgezet naar inschrijving.Niet bevestigd</option>
              <option value = "IM0" >IM0  -  Inschrijving geimporteerd. Niet bevestigd.</option>
              <option value = "IM1" >IM1  -  Inschrijving geimporteerd. Bevestigd via Mail.</option>
              <option value = "IM2" >IM2  -  Inschrijving geimporteerd. Bevestigd via SMS.</option>
  		   </select>
	          </div>
         </div>
       </div> <!--  row---> 
   <div class= 'row '>
	  <div class='col-4'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b>Kenmerk</label>
		  <input type="text"   name ='extra_vraag' disabled  class="form-control"   value ='<?php echo $result['Kenmerk'];?>'  placeholder=" ">
          </div>
         </div>
       </div> <!--  row---> 
	   
   <?php
		if(isset($extra_vraag)and $extra_vraag !=''){
		 $opties = explode(";",$extra_vraag,6);
         $vraag  = $opties[0];
	?>
	
	 <div class= 'row '>
	  <div class='col-4'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b><?php echo $vraag;?></b></label>
		  <input type="text"   name ='extra_vraag' required  class="form-control"   value ='<?php echo $result['Extra'];?>'  placeholder=" ">
          </div>
         </div>
       </div> <!--  row---> 
	  
	  <?php
		 }
    if(isset($extra_invulveld) and $extra_invulveld != ''){?>
	 <div class= 'row '>
	  <div class='col-4'>	
         <div class="form-group">
          <label for="exampleInputEmail1"><b><?php echo $extra_invulveld;?></b></label>
		  <input type="text"   name ='extra_invulveld' required  class="form-control"   value ='<?php echo $result['Extra_invulveld'];?>'  placeholder=" ">
          </div>
         </div>
       </div> <!--  row---> 
	  
	  <?php
		 }
	?>
	<?php
	include('include_spam_check.php');
	?>
	<p style='font-size:1.2vh;'>* In het veld status wordt bijgehouden hoe de inschrijving is binnengekomen en of het een reservering of bevestiging betreft. Er is een apart beheerscherm voor het bijhouden van reserveringen en bevestigingen</p>
	 </div> <!--- card body--->
	   <div class='card card-footer'>
	
     <table  width=100%>
		 <tr>
	   <td width=25% style='text-align:left;'>
	  <a href ='beheer_inschrijvingen_stap1.php' class='btn btn-sm btn-info' target='_self'>Vorige pagina</a>
	      
         </td>	
            
		  <td style ='font-size:1.2vh;text-align:right;'>
			   <button type="submit" class="btn btn-primary responsive-width text-left">Verzenden</button>
  	 
    		</td>
		    
           </tr>
		 </table>
</div>
	</div> <!-- card--->
	</form>
	 
	
 
    
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