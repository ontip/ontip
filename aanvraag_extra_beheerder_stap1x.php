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
 <link rel="shortcut icon" href="images/logo.ico" type="image/x-icon">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>

<style>
 
 
 input.form-control {
	   font-size:1.4vh;
 }
 
  
 

h6,label {font-size:1.6vh;}
h4 {font-size:1.8vh;}	
</style>
 </head>

<body >
 <br>
<div class= 'container'   >
   <FORM class="needs-validation" novalidate  action='aanvraag_extra_beheerder_stap2.php' autocomplete="off" role="form" name= 'myForm' method='post' target="_top">	 
 
 <div class= 'card w-100'>
  <div class= 'card card-header'>
    <h4>Aanvraag extra OnTip beheerder</h4>
   </div>
   
   
  
	
	
	<div class= 'card card-body'>
	
	     
    

	    <div class="form-group">
           	 <div class="g-recaptcha  " required data-sitekey="6LcuBVcUAAAAAHAIiFktH8ZZ22fLeBGKujfN-4ss"></div>
							       <span class="invalid-feedback">Vink captcha check aan om aan te geven dat u geen robot bent</span>
                        </div>

		                         <!--div class="g-recaptcha" data-sitekey="6LcuBVcUAAAAAHAIiFktH8ZZ22fLeBGKujfN-4ss" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
                            <input class="form-control d-none" data-recaptcha="true"  required  data-error="Please complete the Captcha"-->
  
  
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
	<script src='https://www.google.com/recaptcha/api.js'></script>