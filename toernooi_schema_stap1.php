 <?php
 # Record of Changes:
#
# Date              Version      Person
# ----              -------      ------
# 29apr2021          1.0.1           E. Hendrikx
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

$toernooi = $_GET['toernooi'];

//// SQL Queries
//$qry      = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'
//              and Status in ('BE0','BE1','BE2','BE3','BE8','BE9','BED', 'BEG', 'IM0', 'ID0')  order by Inschrijving ASC" )    or die(mysql_error());  
               
// Ophalen toernooi gegevens

$qry2             = mysqli_query($con,"SELECT * From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  

while($row2 = mysqli_fetch_array( $qry2 )) {
	 $var  = $row2['Variabele'];
	 $$var = $row2['Waarde'];
	}              
	
?>

<html>
 <head>
 <title>OnTip - import en export</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../ontip/css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="../ontip/css/standard.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">
 
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 <!-- my personal set for font awesome icons --->
<script src='https://kit.fontawesome.com/87a108c0d7.js' crossorigin='anonymous'></script>
 
<style>
 

 <?php
 include("css/standard.css")
  ?>
  h5 {font-weight:bold;}
</style>
<script language="javascript">
function changeColor(color,id) {
document.getElementById('item1').style.color = "red";
};
</script>

 </head>

<body >
 
 <?php
$short_menu='Ja';
include('include_navbar.php') ;
?>


<br>
<div class= 'container'   >
   <FORM class="needs-validation" novalidate  action='toernooi_schema_stap2.php' autocomplete="off" name= 'myForm' method='post' target="_top">	 
 
 
 <div class= 'card w-100'>
    <div class= 'card card-header'>
    <h3>Toernooi schema "<?php echo $vereniging; ?>"</h3>
   
   </div>
 
   <div class= 'card card-body'>
 <?php
ob_start();

if(isset($_GET['toernooi'])){ 
  	$toernooi = $_GET['toernooi'];   
include 'mysqli.php';   	

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
  	
/// Ophalen aantal spelers
$sql        = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Vereniging = '".$vereniging ."' and Toernooi ='".$toernooi."'  ")     or die(' Fout in select');  
$result     = mysqli_fetch_array( $sql );
$aantal     = $result['Aantal'];

$pageName = basename($_SERVER['SCRIPT_NAME']);
include('page_stats.php');
}
else {
	$vereniging = '';
}
 

ob_start();
if (isset ($_GET['toernooi'])){
$toernooi = $_GET['toernooi'];
	
// Ophalen toernooi gegevens
$qry1             = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select1');  

while($row = mysqli_fetch_array( $qry1 )) {
	 $var  = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	
	
$qry2    = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  ")     or die(' Fout in select2');  
$row     = mysqli_fetch_array( $qry2 );
$aantal  = $row['Aantal'];
}
else {
	$aantal = 0;
	$toernooi_voluit ='';
}



?>
<input type='hidden' name='toernooi'  value="<?php echo $toernooi_voluit; ?>"  /> 
<center>
<h3 style='padding:10pt;font size=2vh;color:green;'>Toernooi schema voorgeloot - <?php echo $toernooi_voluit;?></h3>

<div Style='font-family:verdana;color:blue;font size=1.6vhpt;'>Vul onderstaande gegevens in</div><br/><br/>
</center>

<div class= 'row'>
	  <div class='col-6'>	
	   
         <label for="exampleInputEmail1"><b>Naam toernooi op briefjes</b></label>
		 
		</div>
		 <div class='col-6'>	
	   <div class="form-group">
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='naam_toernooi'   class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value ='<?php echo $toernooi_voluit;?>'  placeholder="Naam toernooi">
      
       </div>
      </div>
</div> <!--  row--->

<div class= 'row'>
	  <div class='col-6'>	
	    
         <label for="exampleInputEmail1"><b>Naam organiserende vereniging</b></label>
		 </div>
	 
		 <div class='col-6'>	
	   <div class="form-group">
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='vereniging'   class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp" value ='<?php echo $vereniging;?>'  placeholder="Naam vereniging">
      
       </div>
      </div>
</div> <!--  row--->
	  
<div class= 'row'>
	  <div class='col-6'>	
	    
         <label for="exampleInputEmail1"><b>Aantal spelers of teams</b></label>
		 </div>
	 
		 <div class='col-6'>	
	   <div class="form-group">
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='aantal' required  size =5  class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp"  placeholder="Aantal">
          <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen aantal ingevuld</span>
		   </div>
      </div>
</div> <!--  row--->

<div class= 'row'>
	  <div class='col-6'>	
	   
         <label for="exampleInputEmail1"><b>Aantal rondes</b></label>
		 </div>
		 
		 <div class='col-6'>	
	   <div class="form-group">
         <input type="text" autocomplete="autocomplete_off_hack_xfr4!k" name ='rondes' required  size =5  class="form-control" id="exampleInputEmail1" aria-describedby="naamHelp"   placeholder="Aantal">
          <span class="valid-feedback">OK</span>
           <span class="invalid-feedback">Geen aantal ingevuld</span>
		   </div>
      </div>
</div> <!--  row---> 

<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Gebruik letters of cijfers voor teams</b></label>
	   </div>
		
		 <div class='col-3'>	
            <input type='radio'        name='tekens' Value='Letters' /> Letters 
		   </div>
		 <div class='col-3'>
             <input type='radio'      name='tekens' Value='Nummers' checked  /> Nummers 
	    </div>
	 
</div> <!--  row---> 
<?php
if(isset($_GET['toernooi'])){ ?>
<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Namen overnemen uit inschrijven toernooi?</b></label>
	   </div>
		
		 <div class='col-3'>	
            <input type='radio'        name='invul_namen' Value='J' /> Ja
		   </div>
		 <div class='col-3'>
             <input type='radio'      name='invul_namen' Value='N' checked  /> Nee
	    </div>
	 
</div> <!--  row---> 
<?php } ?>

<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Vrijloting toestaan (alleen bij oneven aantal)</b></label>
	   </div>
		
		 <div class='col-3'>	
            <input type='radio'        name='vrijloting' Value='J' /> Ja
		   </div>
		 <div class='col-3'>
             <input type='radio'      name='vrijloting' Value='N' checked  /> Nee
	    </div>
	 
</div> <!--  row---> 

<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Naam toernooi afdrukken ?</b></label>
	   </div>
		
		 <div class='col-3'>	
            <input type='radio'        name='naam_printen' Value='J' /> Ja
		   </div>
		 <div class='col-3'>
             <input type='radio'      name='naam_printen' Value='N' checked  /> Nee
	    </div>
	 
</div> <!--  row---> 

<div class= 'row'>
	  <div class='col-6'>	
         <label for="exampleInputEmail1"><b>Baan toewijzing gebruiken ?</b></label>
	   </div>
		
		 <div class='col-3'>	
            <input type='radio'        name='baan' Value='J' /> Ja
		   </div>
		 <div class='col-3'>
             <input type='radio'      name='baan' Value='N' checked  /> Nee
	    </div>
	 
</div> <!--  row---> 

  
<center><span style='color:black;'>In principe kan dit programma voor ook niet OnTip toernooien gebruikt worden.</span> </center>

</div> <!--- card body---->
	<div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
		
            <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden <i style='font-size:1.6vh;' class='fa fa-paper-plane'></i></button>	
			 </td>
          </tr>
     </table>
     </form>	
	

	</div>
	
</div>  <!--  card  ---->
	</div>  <!--  container ---->
 <!-- Footer -->

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
