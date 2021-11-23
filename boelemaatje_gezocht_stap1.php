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

//// Check op rechten
$ip        = md5($_SERVER['REMOTE_ADDR']);

 
$toernooi = $_GET['toernooi'] ;

$qry              = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row = mysqli_fetch_array( $qry  )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
//	 echo "<br>".$var;
	}


 
$qry_sel      = mysqli_query($con,"SELECT count(*) as Aantal from boule_maatje Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Naam " )    or die(mysql_error());  
$result       = mysqli_fetch_array( $qry_sel  );
$aantal_boulemaatjes   = $result['Aantal'];	
	

$qry          = mysqli_query($con,"SELECT * from vereniging where Id = ".$vereniging_id." ")     or die(' Fout in select vereniging');  
$result       = mysqli_fetch_array( $qry  );
$vereniging   = $result['Vereniging'];
$plaats       = $result['Plaats'];

if ($result['Vereniging_output_naam']  !=''){
	$vereniging = $result['Vereniging_output_naam'];
}

 
  
?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - Boulemaatje gezocht</title>
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
 
  

input.trash[type=checkbox] {
    display:none;
  }
  
input.trash[type=checkbox] + label
   {
	   background:url('../ontip/images/not_checked.png') no-repeat;
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
 

<br>
<div class= 'container'   >
<FORM  action='boulemaatje_gezocht_stap2.php' autocomplete="off" name= 'myForm' id= 'myForm' method='post' target="_top">	 
 	       <input type='hidden'  name = 'vereniging_id'      value ="<?php echo $vereniging_id;?>" />
			   <input type='hidden'  name = 'vereniging_naam'    value ="<?php echo $vereniging;?>" />
	           <input type='hidden'  name = 'toernooi'           value ="<?php echo $toernooi;?>" />			
	           <input type='hidden'  name = 'return_page'                value ="<?php echo $pageName;?>" />			

 <div class= 'card w-100'>
 

  <div class= 'card card-header'>
   <h4 ><i class="fa fa-calendar" aria-hidden="true"></i> Boulemaatje gezocht -"<?php echo $toernooi_voluit;?>"</h4>
   </div>
   
	
    <div class= 'card card-body'>
       <br>
       <span style='color:black;font-size:1.4vh;font-family:arial;'>Wil je graag deelnemen aan dit toernooi, maar heb je geen boule maatje?
Via deze pagina kan je je opgeven als boule maatje of reserve of kan je ein contact komen met spelers die ook een maatje zoeken.
Na invullen van deze pagina wordt een mail gestuurd naar de organisatie.  
        </span>  
     	 <br>
  
   <h4 style='color:red;'>Toernooi gegevens</h4>
  <br>
   <table class='table table-striped w-100   table-bordered'>
     <tr>
	  <th class='w-50' width=50%  >Toernooi</th>
	  <td><?php echo $toernooi_voluit;?></td>
	  </tr>
	   <tr>
	  <th class='w-50' width=50%  >Vereniging</th>
	  <td><?php echo $vereniging;?> <?php echo $plaats;?></td>
	  </tr>
	 
      <tr>
	  <th>Datum toernooi</th>
   
	   <?php
	   $dag   = 	substr ($datum , 8,2); 
       $maand = 	substr ($datum , 5,2); 
       $jaar  = 	substr ($datum , 0,4); 
      ?>
      <td> <?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
	  </tr>
   <tr>
	  <th   width=50%  >Aantal boulemaatjes voor dit toernooi</th>
	  <td><?php echo $aantal_boulemaatjes;?></td>
	  </tr>
	  </table>
	  
	  <br>
	 <h4 style='color:red;'>Contact gegevens</h4>
  
  <div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Naam  </b></label>
        </div>
        <div class='col-6'>	
		 <div class="form-group">
	      <input type="naam" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam' required  class="form-control"  placeholder="Naam">
         </div>    
	</div>
	  </div> <!-- row-->
	  
	<div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Vereniging  </b></label>
        </div>
        <div class='col-6'>	
		 <div class="form-group">
	      <input type="text"   name ='vereniging' required class="form-control"  placeholder="Vereniging">
        </div>     
	 </div>
	  </div> <!-- row-->
	  
		<div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Licentie  </b></label>
        </div>
        <div class='col-6'>	
		 <div class="form-group">
	      <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='licentie'   class="form-control"  placeholder="Licentie">
        </div>
	  </div>
	  </div> <!-- row-->
	  
	  <div class= 'row'>
	 <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Email <i class="fas fa-key" style='font-size:1.2vh;'></i></b></label>
        </div>
        <div class='col-6'>	
		 <div class="form-group">
	      <input type="email" autocomplete="autocomplete_off_hack_xfr4!k" name ='email' required  class="form-control"  placeholder="Email adres">
        </div>
	   </div>
	  </div> <!-- row-->
	  
	 <div class= 'row'>
	  <div class='col-6'>	
	     <label for="exampleInputEmail1"><b>Telefoon <i class="fas fa-key" style='font-size:1.2vh;'></i></b></label>
            </div>
       <div class='col-6'>	
	    <div class="form-group">
	      <input type="number" autocomplete="autocomplete_off_hack_xfr4!k" name ='telefoon'   onchange="checkMobilenumber()" required class="form-control"   placeholder="Telefoon">
          </div>
		  </div>
	   </div> <!-- row-->		 
	
	<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Op zoek of reserve?</b></label>
		 </div>
		<div class='col-6'>	 
		 <div class="form-group">
		 <select name ='boulemaatje' required  class="form-control">
	              <option value =''  selected>Maak een keuze..</option>
	              <option value ='B'   >Ik wil graag spelen,maar heb nog geen maatje</option>
	              <option value ='R'   >Ik ben oproepbaar als reserve speler</option>
		 
			</select>
         </div>
	</div>
  </div> <!-- row-->
  
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
	 <hr>
	 <h4 style='color:red;'>Beschikbare spelers</h4>
	
   <?php 
    if ($aantal_boulemaatjes ==0){?>
	<p class='uitleg'> Er zijn geen boulemaatjes beschikbaar</p>
	<?php	
	} else {?>
	 
       <table class='table table-striped w-100   table-bordered'>
       <thead>
      <tr>
       <th >Naam</th>
      <th >Vereniging</th>
      <th >Licentie</th>
      <th >Tel.nr</th>
      <th >E-mail</th>
      <th >Opmerking</th>
      <th >Status</td>
      </tr>
      </thead>
      <tbody>
      <?php
      
      /// Detail regels
      
      $i=1;                        // intieer teller 
      $qry_sel      = mysqli_query($con,"SELECT * from boule_maatje Where Toernooi = '".$toernooi."' and Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'  order by Naam " )    or die(mysql_error());  
      
      while($row = mysqli_fetch_array( $qry_sel )) {
      
      switch($row['Status'] ){
          case 'B' :   $status = 'Op zoek naar boulemaatje';     break;
          case 'O' :   $status = 'Gekoppeld, team nog niet compleet'; break;
          case 'K' :   $status = 'Gekoppeld en ingeschreven'; break;
          default  :   $status = 'Op zoek naar boulemaatje';     break;
      
       }
      
      if ($row['Soort_aanvraag'] =='R') { $status = 'Reserve'; }
      ?>
       <tr>
          <td> <?php echo $row['Naam'];?></td>
         <td> <?php echo $row['Vereniging_speler'];?></td>
         <td> <?php echo $row['Licentie'];?></td>
         <td> <?php echo $row['Telefoon'];?></td>
         <td> <?php echo $row['Email'];?></td>
         <td> <?php echo $row['Opmerkingen'];?></td>
         <td> <?php echo $status;?></td>
        </tr>
      <?php  
      $i++;
      };
      
      ?>
      </tbody>
      </table>
	<?php	
		
	}
	?>
	
<br>
<?php
	include('include_spam_check.php');
	?>
	
  </div> <!--- body--->
<div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
	     
            <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Klik hier na invullen</button>	
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