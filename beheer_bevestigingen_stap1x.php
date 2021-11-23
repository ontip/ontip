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
 <title>OnTip - Muteer bevestigingen</title>
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
 


</style>
 
<script language="javascript">
function printPage() {
    window.print();
}
</script>

</head>
<body >

 <?php
 
include('include_navbar.php') ;
?>
 
  <BR>
     <FORM class="needs-validation" novalidate  action='beheer_bevestigingen_stap2x.php' autocomplete="off" ame= 'myForm' method='post' target="_top">	 
 	   <INPUT TYPE='hidden' NAME='zendform'                VALUE='1'>
       <INPUT TYPE='hidden' NAME='toernooi_md5'            VALUE='<?php echo md5($toernooi);?>'>
	   <INPUT TYPE='hidden' NAME='vereniging_md5'          VALUE='<?php echo md5($vereniging_id);?>'>
	   <INPUT TYPE='hidden' NAME='aantal'                  VALUE='<?php echo $aantal_rows;?>'>
	   <INPUT TYPE='hidden' NAME='soort_inschrijving'      VALUE='<?php echo $soort_inschrijving;?>'>
	   <INPUT TYPE='hidden' NAME='inschrijf_methode'       VALUE='<?php echo $inschrijf_methode;?>'>
	   
 <center>
  
  <div class='card   ml-5 mr-5 '>
  <div class ='card card-header'>
  <h5>Beheer bevestigingen <?php echo $toernooi_voluit;?></h5>
  </div>
   <div class='card card-body'>
  
  
    
	<br><p class='uitleg'>Dit scherm bevat de inschrijvingen die nog niet bevestigd zijn. Hier kan je de inschrijvingen definitief bevestigen of annuleren.<br>
                    Als er een email adres bekend is, zal de deelnemer hiervan een email ontvangen.
 
  
	    
    </p>
	<center>
	

	
 </center>
 <br>
       <p style='color:black;font-size:1.6vh;font-family:arial;'>Soort toernooi : <?php echo $soort_inschrijving; ?></p>
	
  
 	 <table class='table table-hovered table-striped table-responsive table-sm w-100'>
         <thead>
	   	  <tr>
             <th   width= 5%  >Nr </th> 
	         <th   width= 10%  >Naam 1 </th>
			 <th   width= 15% class= 'border border-right'>Vereniging 1 </th>
             <th   width= 15% >Email</th>
			 <th   width= 15% >Telefoon</th>
             <th   width= 10%>Tijdstip Inschrijving</th>
			 <th   width= 15% class= 'border border-right'>Status </th>
			  <th   width= 15% class= 'border border-right'>Aanpassen </th>
    
           </tr>
        </thead>
        <tbody>
		<?php
 		
 		   $qry = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' and Status in ('BE1', 'BE2') order by Volgnummer,Inschrijving  " )    or die(mysqli_error());  
         $i=1;  
		   while($row = mysqli_fetch_array( $qry )) {
          ?>
		            <td style='text-align:right;padding:5pt;' id='normaal'><?php echo $i;?>.</td>
	           	<td><?php echo $row['Naam1'];?></td>
	           	<td><?php echo $row['Vereniging1'];?></td>
	             <?php
	           	 if ($row['Email'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo versleutel_string($row['Email_encrypt']);?></td>
	           	 	<?php }  ?>  		
	           	
	           		<?php
	           	 if ($row['Telefoon'] == ''){     
	           	 	?>
	           	    	<td>Onbekend</td>
	           	 <?php } else { ?>
	           	 	  	<td><?php echo versleutel_string($row['Telefoon_encrypt']);?></td>
	           	 	<?php }?>  	
	     	 	
	      	 <td><?php echo $row['Inschrijving'];?></td>
	      	 
	      	 <td><?php echo $row['Status'];?>  - 
	      	 	 <?php switch ($row['Status']){ 
	      	 	 	  case "BE1": $stats_oms="Voorlopige inschrijving. Geen Email bekend.";break;
	      	 	 	  case "BE2": $stats_oms="Betaald maar nog niet bevestigd.";break;                
                      case "BE3": $stats_oms="Betaald. Geen email bekend.";break;                     
                      case "BE5": $stats_oms="Geannuleerd maar nog niet gemeld.";break;               
                      case "BE8": $stats_oms="Nog niet bevestigd. Betaling nvt.";break;               
                      case "BE9": $stats_oms="Nog niet bevestigd. Betaling nvt. Geen email bekend.";break;
                      case "BEG" :$stats_oms="Inschrijving vervallen als gevolg van limiet.";break;
                      case "BED": $stats_oms="Voorlopige inschrijving via SMS gemeld.";break;         
                      case "ID0": $stats_oms="Inschrijving wacht op betaling via IDEAL.";break;       
                      case "ID2": $stats_oms="Betaling via IDEAL mislukt of afgebroken.";break;       
                    default   : $stats_oms="Onbekende status.";break;
	           } ;?>
 	   
 	   <?php echo $stats_oms;?>
	      	 </td>
	   	     <td><a href = "beheer_bevestigingen_stap2.php?id=<?php echo $row['Id'];?>&toernooi=<?php echo $toernooi;?>" role='button' class='btn btn-sm btn-primary'  target ='_self'>Aanpassen</a></td>
	           </tr> 
	  	        
			</tr>   
		<?php	   
			$i++; 
		   } // end while
		   ?>
		   
		   
		</tbody>
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