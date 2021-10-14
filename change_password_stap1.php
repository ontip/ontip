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
 
  // schrijf gegevens naar tekst file tbv logging
   $pageName        = basename($_SERVER['SCRIPT_NAME']);
   $now             = date('d-m-Y H:i');  // 201701171234              
   include('include_write_logfile.php');

	
	

$ip        = $_SERVER['REMOTE_ADDR'];
$sql      = mysqli_query($con,"SELECT Naam,Beheerder , Toernooi FROM namen WHERE  IP_adres_md5 = '".md5($ip)."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select aantal');  
$result   = mysqli_fetch_array( $sql );
$naam     = $result['Naam'];
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
 	<FORM action='change_password_stap2.php' class="needs-validation" novalidate   autocomplete="off" name= 'myForm' id= 'myForm' method='post' target="_top">

 <div class= 'card w-100'>
 

  <div class= 'card card-header'>
    <h4>Aanpassen wachtwoord</h4>
   </div>
   
	
    <div class= 'card card-body'>
 
	

<input type="hidden" name="Vereniging_id"  value="<?php echo $vereniging_id; ?>" /> 
<input type="hidden" name="Vereniging"     value="<?php echo $vereniging; ?>" /> 
<input type="hidden" name="naam"           value="<?php echo $naam; ?>" /> 
  
  <div class="row mb-3">
    <label for="inputEmail3" class="col-sm-4 col-form-label text-left">Vereniging</label>
    <div class="col-sm-8">
          <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam' disabled class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value ='<?php echo $vereniging;?>'>
      
    </div>
  </div>
   <div class="row mb-3">
    <label for="inputEmail3" class="col-sm-4 col-form-label text-left">Toegangscode</label>
    <div class="col-sm-8">
          <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" placeholder="Naam">
      <span class='row mb-8'   id="errNm1" style='color:red;font-size:1.2vh;'></span>
    </div>
  </div>
  <div class="row mb-3">
    <label for="inputPassword3" class="col-sm-4 col-form-label">Bestaand wachtwoord</label>
    <div class="col-sm-8">
      <input type="password" autocomplete="autocomplete_off_hack_xfr4!k" name ='wachtwoord_bron' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" placeholder="Bestaand wachtwoord">
      <span class='row mb-8'   id="errNm2" style='color:red;font-size:1.2vh;'></span>
    </div>
  </div>
  
   <div class="row mb-3">
    <label for="inputPassword3" class="col-sm-4 col-form-label">Nieuw wachtwoord</label>
    <div class="col-sm-8">
       <input type="password" autocomplete="autocomplete_off_hack_xfr4!k" name ='wachtwoord_new1' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" placeholder="Wachtwoord (4-16 karakters)">
       <span class='row mb-8'   id="errNm3" style='color:red;font-size:1.2vh;'></span>
    </div>
  </div>
 
   <div class="row mb-3">
    <label for="inputPassword3" class="col-sm-4 col-form-label">Nieuw wachtwoord herhaling</label>
    <div class="col-sm-8">
       <input type="password" autocomplete="autocomplete_off_hack_xfr4!k" name ='wachtwoord_new2' required class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" placeholder="Wachtwoord (4-16 karakters)">
       <span class='row mb-8'   id="errNm4" style='color:red;font-size:1.2vh;'></span>
    </div>
  </div>
  
   
   
   
  
 
   
<table width=90%>

<tr>
	<td colspan =3 STYLE ='font-size: 10pt; background-color:white;color:black;'><br>Nadat op Verzenden gedrukt is, 
		wordt een mail met het wachtwoord gestuurd naar het email adres dat bij de toegangscode hoort. Via deze mail moet de wijziging geaccepteerd worden. <br><br>
			</td>
</tr>
</table>

</div> <!--- body--->
<div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
	     <td style ='font-size:1.2vh;text-align:left;'>
             <a href='<?php echo $pageName;?>' role='button' class="btn btn-secondary">Herstellen </button>	
			 </td>	
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
