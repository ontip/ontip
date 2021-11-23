 <?php
 # Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 27jul2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           None.
# Reference: 


ini_set('default_charset','UTF-8');
setlocale(LC_ALL, 'nl_NL');
$ip = $_SERVER['REMOTE_ADDR'];

include('mysqli.php'); 
$today = date('Y-m-d');
$pageName        = basename($_SERVER['SCRIPT_NAME']);


// maak hulptabel leeg

mysqli_query($con,"Delete from hulp_toernooi where Vereniging_id = '".$vereniging_id."'  ") or die('Fout in schonen tabel');   

// Vul hulptabel 

 
$query = "insert into hulp_toernooi (Toernooi, Vereniging, Vereniging_id, Datum) 
  select Toernooi,Vereniging, Vereniging_id, Waarde from config     where Vereniging_id = '".$vereniging_id."' and Variabele ='datum' group by Vereniging, Vereniging_id, Toernooi,Waarde   " ;


mysqli_query($con,$query) or die ('Fout in vullen hulp_toernooi'); 

$update = mysqli_query($con,"UPDATE hulp_toernooi as h
 join config as c
  on c.Vereniging_id        = h.Vereniging_id 
  set h.Toernooi_voluit    = c.Waarde 
 where c.Toernooi         = h.Toernooi
   and c.Variabele        ='toernooi_voluit' 
   and c.Vereniging_id    = '".$vereniging_id."'  ");
  
$toernooien = mysqli_query($con,"SELECT h.Id as Id,h.Toernooi,  Waarde , Datum from config as c
 join hulp_toernooi as h
  on c.Vereniging_id        = h.Vereniging_id and
     c.Toernooi          = h.Toernooi 
   where c.Variabele     = 'toernooi_voluit' 
     and c.Vereniging_id    = '".$vereniging_id."' order by Datum ");
 
 mysqli_query($con,"OPTIMIZE table  hulp_toernooi ") or die('Fout in optimize tabel');   

$aantal_toernooien = mysqli_num_rows($toernooien);
 
$qry  = mysqli_query($con,"SELECT Toernooi From namen WHERE Aangelogd = 'J'  and Vereniging_id = ".$vereniging_id."  and IP_adres_md5 = '". md5($ip)."' ")     or die(' Fout in select namen');  
$result= mysqli_fetch_array( $qry );
$toernooi_select = $result['Toernooi'];
 
?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - select toernooi</title>
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
 
 
h6,label {font-size:1.6vh;}
h4 {font-size:1.8vh;}	
input.send[type=radio] {
    display:none;
  }
  
   
input.send[type=radio] + label
   {
	   background:url('../../ontip/images/not_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
       display:inline-block;
	   vertical-align:middle;
	   position:relative;
	 
       padding: 0 0 0 0px;
   }
    
input.send[type=radio]:checked + label
    {
	background:url('../../ontip/images/icon_checked.png') no-repeat;
       height: 25px;
       width: 25px;  
        display:inline-block;
        padding: 0 0 0 0px;
    }


/* If the screen size is 601px wide or more, set the font-size of <class> to 1.4 */
@media screen and (min-width: 601px) {
  p.koptekst,td.koptekst, a.koptekst, div.uitleg,span.uitleg {
    font-size: 1.4vh;
	color:black;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.koptekst,td.koptekst, div.uitleg,span.uitleg {
    font-size: 1.6vh;
	color:black;
  }
}
	
</style>
<Script Language="Javascript">
function showHide(id) {
  var x = document.getElementById("toevoegen");
  var y = document.getElementById("lijst");
  var z = document.getElementById("verwijderknop");  
  var t = document.getElementById("toevoegknop");  
   
  if (x.style.display === "none") {
      x.style.display = "block";
	  y.style.display = "none";
	  z.style.display = "none";
	  t.style.display = "none";
   
  } else {
      x.style.display = "none";
	  y.style.display = "block";
	  z.style.display = "none";
   t.style.display = "none";
  }
   
  
  
  
}
</script>

 </head>

<body >
 
 <?php
include('include_navbar.php') ;
 
?>


<br>
<div class= 'container'   >

   <FORM action='select_toernooi_stap2.php' method='post' name="myForm">
   
  <input type= 'hidden' name ='zendform' value = '1'> 
  <input type= 'hidden' name ='Url' value = '<?php echo $pageName; ?>'> 
  <input type='hidden'  name ='Vereniging'  value='<?php echo $vereniging;?>'  /> 
   
   
 <div class= 'card w-100'>
  <div class= 'card card-header'>
    <h4><?php echo $vereniging;?></h4>
   </div>
 
   <div class= 'card card-body'>
  
 
  	
     <?php
	 
	 
       $i=0;
       // Indien er maar 1 toernooi is, wordt geen selectielijst getoond
      if ($aantal_toernooien == 1 ) {
      ?>
      <input type= 'hidden' name ='Toernooi' value = '<?php echo $toernooi;?>'>
      <table>
      	<tr>
      <td style='font-weight:bold;padding-right:15pt;font-size:12pt;'> Geselecteerd toernooi : </td>
      <td style= 'display:block;background-color:white;border: 1pt solid black;width:850px;color:blue;padding:2pt;font-size:10pt;' width=800px><?php echo substr($datum,0,10)." > ".$toernooi_voluit." (".$toernooi.")";?></td>
    </tr>
  </table>
    
    <?php
      	}    	
   else { 
  ?>
  <h4>Selecteer een toernooi 	</h4> 
  <br>
   
     <?php 
     if ($aantal_toernooien > 1) {?>
     <p style= 'font-size:1.6vh;' >Selecteer een toernooi uit de lijst en klik op 'Ophalen'. Rood gekleurde toernooien zijn al gespeeld. Het blauw gekleurde toernooi is nu geselecteerd.<br>
	 </p>
     	<?php } ?> 	     
     	
     	</em>
  <table class='table table-responsive table-striped table-hovered w-100'>
   <thead>
    <tr>
	<th> Sel </th>
	<th> Datum </th>
	<th> Naam </th>
	<th> OnTip naam </th>
	</tr>
	</thead>
	<tbody>
	
	<?php
	
	 while($row = mysqli_fetch_array( $toernooien )) {
  	           $var = substr($row['Datum'],0,10);
 	           
 	           if ($today > $var){
 	           	 $color = 'red';
 	           } else {
  	           	$color = 'black';
	         	}

 	       
        $year = substr($row['Datum'],0,4);
        $mnth = substr($row['Datum'],5,2);
        $day  = substr($row['Datum'],8,2);
		 
		 $check_option = '';
		 if ($row['Toernooi'] == $toernooi_select){
			 $check_option = 'checked';
			 $color = 'blue';
		 }
		 
	  ?>
   <tr style ='color:<?php echo $color;?>' > 
   <td > 
    <input type='radio' name= 'toernooi' value = '<?php echo $row['Toernooi'];?>' <?php echo $check_option;?> class='send' id= 'select_<?php echo $row['Id'];?>'  /><label for="select_<?php echo $row['Id'];?>"></label>	 
    </td>
   <td> <?php echo strftime("%a %n %d %b %Y", mktime(0, 0, 0, $mnth , $day, $year) );;?></td>
   <td> <?php echo $row['Waarde'];?> </td>
   <td> <?php echo $row['Toernooi'];?> </td>
   </tr>
   <?php
    
	 }  // end while
	 ?>
  </table>
  <?php
  
       }  // end if 1 toernooi
     ?>
  
    
  </div> <!-- card body--->
  	<div class='card card-footer'>
	<?php
	 if ($aantal_toernooien > 1) {?>
	 <table  width=100%>
		 <tr>
		
            <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Ophalen toernooi</button>	
			 </td>
          </tr>
     </table>
	 <?php } ?>
	</div>
	
	</form>
  </div> <!--- card ---->
	 
</div>  <!--  container ---->

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
