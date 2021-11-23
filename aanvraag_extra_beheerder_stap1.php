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
$today = date('Y-m-d');
$ip    = $_SERVER['REMOTE_ADDR'];
$pageName        = basename($_SERVER['SCRIPT_NAME']);
$now             = date('d-m-Y H:i');  // 201701171234              
include('include_write_logfile.php');
 
 /// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

$aangelogd = 'N';
include('aanlog_checki.php');	
 
if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php?url=<?php echo $pageName;?>");
</script>
<?php
exit;
}
 

?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - aanvraag extra beheerder</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
 <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
  
 <script src='https://www.google.com/recaptcha/api.js'></script>
 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>

<style>
 
 
 input.form-control {
	   font-size:1.4vh;
 }
 
  
 input.send[type=checkbox] {
    display:none;
  }
  
   
input.send[type=checkbox] + label
   {
	   background:url('images/trash_not_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
       display:inline-block;
	   vertical-align:middle;
	   position:relative;
	 
       padding: 0 0 0 0px;
   }
    
input.send[type=checkbox]:checked + label
    {
	background:url('images/icon_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
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

h6,label {font-size:1.6vh;}
h4 {font-size:1.8vh;}	
</style>
 

 </head>

<body >
 
 
 <?php
include('include_navbar.php') ;
?>
<br>
<div class= 'container'   >
   <FORM class="needs-validation" novalidate  action='aanvraag_extra_beheerder_stap2.php' autocomplete="off" name= 'myForm' method='post' target="_top">	 
 
 <div class= 'card w-100'>
  <div class= 'card card-header'>
    <h4><i class="fas fa-user-lock"></i> Aanvraag extra OnTip beheerder "<?php echo $vereniging;; ?>"</h4>
   </div>
   
	<div class= 'card card-body'>

     <div class= 'row'>
	  <div class='col-6'>	
	   <div class="form-group">
         <label for="exampleInputEmail1"><b>Vereniging</b></label>
		 </div>
		</div>
         <div class='col-6'>
    <div class="form-group">
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='vereniging' required disabled class="form-control" value ="<?php echo $vereniging;; ?>" >
            <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen naam ingevuld</span>
       </div>
      </div>
	    </div> <!-- row-->
		
	<div class= 'row'>	
	  <div class='col-6'>	
	    <label for="exampleInputEmail1"><b>Voornaam beheerder(=toegangscode)</b></label>
		 </div>
	 
         <div class='col-6'> 
	  <div class="form-group">
       <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam' required   class="form-control" placeholder="Naam" >
 	       <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen naam ingevuld</span>
	   </div>
	</div>
 	  </div> <!-- row-->
	  
	<div class= 'row'>	
	  <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Email adres beheerder</b></label>
	  </div>
         <div class='col-6'> 
	  <div class="form-group">
       <input type="email" autocomplete="autocomplete_off_hack_xfr4!k" name ='email' required   class="form-control" placeholder="Email" >
  	
	       <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen email ingevuld</span>
		</div>
        </div>
	  </div> <!-- row-->

	<div class= 'row'>	
	  <div class='col-6'>	
	    <div class="form-group">
         <label for="exampleInputEmail1"><b>Soort beheerder</b></label>
		 </div>
		</div>
         <div class='col-6'> 
	      <div class="form-group">
	       <input  type ='radio' name='rechten' Value='A' checked /> Alles<br>
           <input  type ='radio' name='rechten' Value='C' /> Alleen aanmaak en aanpassen toernooien<br>
	       <input  type ='radio' name='rechten' Value='I' /> Alleen inschrijvingen<br>
	       <input  type ='radio' name='rechten' Value='W' /> Wedstrijd commissie (heel beperkt toernooi aanpassen) 
         </div>
		</div>
 	  </div> <!-- row-->

	   <h6><b>Vraag of opmerkingen</b></h6>
      <div class="form-outline">
       <textarea style='font-size:1.4vh;' class="form-control" name='opmerkingen'  id="textAreaExample2" rows="4"   placeholder= "Type hier uw vraag of opmerking"></textarea>
        </div> 
	
		<?php
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
	  
//    $characters = "23456789abcdefhijkmnprstuvwxyABCDEFG-+";
    $characters = "12345678901234567890";
    
    
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ?>
    
  
   <input type='hidden' name='challenge'    value='<?php echo $string;?>' /> 
  
	  <br>
	  <div class= 'row'>	
	  <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Ik ben geen robot</b></label>
	  </div>
         <div class='col-3'> 
	  <div class="form-group">
           <input TYPE="TEXT" NAME="respons" SIZE="5"  required autocomplete="autocomplete_off_hack_xfr4!k"   class="form-control" placeholder="code uit grijs vlak overnemen"  >
	       <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen code ingevuld</span>
		</div>
        </div>
		   <div class='col-3'>
		     <div style= 'font-size:14pt; color:black;background-color:lightgrey;width:55pt;text-align:center;font-family:courier;'><?php echo $string;?></div>
		    </div>
	  </div> <!-- row-->
<br>
<p class='ml-5'>Zodra de beheerder uw aanvraag geaccepteerd heeft ontvangt u hiervan een bevestiging op het hierboven aangegeven email adres. In de bevestiging vind u ook een wachtwoord.</p>		
	</div> <!-- card body-->
	<div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
		
            <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden <i style='font-size:1.6vh;' class='fa fa-paper-plane'></i></button>	
			 </td>
          </tr>
     </table>
    
	

	</div>
  </div> <!--- card ---->
	 </form>	 
</div>  <!--  container ---->
<br>
 
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