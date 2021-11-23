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
  
?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
 <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
 <link rel="icon" href="images/favicon.ico" type="image/x-icon">

 
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
 
  

input.trash[type=checkbox] {
    display:none;
  }
  
input.trash[type=checkbox] + label
   {
	   background:url('../ontip/images/trash_not_checked.png') no-repeat;
     height: 25px;
       width: 25px;  
       display:inline-block;
       padding: 0 0 0 0px;
   }
   
input.trash[type=checkbox]:checked + label
    {
	background:url('../ontip/images/trash_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
    }
h6,label {font-size:1.6vh;}
h4 {font-size:1.8vh;}	

td,th {font-size:1.4vh;}	


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
?>


<br>
<div class= 'container'   >
 		 <FORM class="needs-validation" novalidate  action='beheer_cyclus_datums_stap2.php' autocomplete="off" name= 'myForm' id= 'myForm' method='post' target="_top">	 
	       <input type='hidden'  name = 'vereniging_id'      value ="<?php echo $vereniging_id;?>" />
			   <input type='hidden'  name = 'vereniging_naam'    value ="<?php echo $vereniging;?>" />
	           <input type='hidden'  name = 'toernooi'           value ="<?php echo $toernooi;?>" />			
	           <input type='hidden'  name = 'return_page'                value ="<?php echo $pageName;?>" />			

 <div class= 'card w-100'>
 

  <div class= 'card card-header'>
   <h4 >Uitleg menu Inschrijvingen</h4>
   </div>
 
    <div class= 'card card-body'>
       <br>
       <span style='color:black;font-size:1.6vh;font-family:arial;'>Als een deelnemer zich inschrijft voor een toernooi, dan worden de gegevens van de inschrijving opgeslagen in hget OnTip systeem.<br>
	   Privacy gevoelige informatie als emailadres en telefoon nummer worden versleuteld (=onleesbaar voor onbevoegden) opgeslagen.<br>
	   Via beheer inschrijvingen kunnen fouten in de inschrijving hersteld worden door de OnTip verenigingsbeheerder.<br>
	   Er zijn aparte schermen voor het beheer van inschrijvingen, reserveringen en bevestigingen.<br>
	    <br>
		Via menu Toernooi/Selecteer toernooi kan een ander toernooi geselecteerd worden.
        <br> 
               <br>
               Door te klikken op het woord OnTip linksboven,kom je altijd terug in het beheerprogramma.	   
        </span>  
      


</div> <!--- body--->
<div  class ='card-footer'>
	 	  <table class='w-100'>
     <tr>
	   <td width=25% style='text-align:left;'>
	     <input type="button" value="Vorige pagina" class='btn btn-sm btn-info' onclick="history.back()" /> 
         </td>
	     
	 </tr>
	 </table>
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


<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


<script>
 

$( "#myForm" ).validate({
  rules: {
    naam: {
      required: true,
     },
	 wachtwoord_bron: {
       required: true,
       minlength:4,
	   maxlength:16,
    },
	 wachtwoord_new1: {
       required: true,
       minlength:4,
	   maxlength:16,
    },
	 wachtwoord_new2: {
       required: true,
       minlength:4,
	   maxlength:16,
    },
  },// end rules
  
   messages: {
      naam: {
        required: "Toegangscode (naam) is verplicht",
     },   
	  wachtwoord_bron: {
        required: "Wachtwoord is verplicht",
        minlength: "Wachtwoord moet minimaal 4 karakters bevatten",
        maxlength: "Wachtwoord mag maximaal 16 karakters bevatten",
     },     
      wachtwoord_new1: {
        required: "Nieuw wachtwoord is verplicht",
        minlength: "Wachtwoord moet minimaal 4 karakters bevatten",
        maxlength: "Wachtwoord mag maximaal 16 karakters bevatten",
     },     
       wachtwoord_new2: {
        required: "Nieuw herhaald wachtwoord is verplicht",
        minlength: "Wachtwoord moet minimaal 4 karakters bevatten",
        maxlength: "Wachtwoord mag maximaal 16 karakters bevatten",
     },     	 
   },  // end messages
  errorPlacement: function(error, element) {
           
            if (element.attr("name") == "naam" ) {
                $("#errNm1").text($(error).text());
            }
   	     	if (element.attr("name") == "wachtwoord_bron" ) {
			    $("#errNm2").text($(error).text() );
            }
			if (element.attr("name") == "wachtwoord_new1" ) {
			    $("#errNm3").text($(error).text() );
            }
				if (element.attr("name") == "wachtwoord_new2" ) {
			    $("#errNm4").text($(error).text() );
            }
            
        }// end error placement

	
});

</script>
