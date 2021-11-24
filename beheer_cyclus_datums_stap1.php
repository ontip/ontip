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


$sql      = mysqli_query($con,"SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres_md5 = '".$ip."' and Aangelogd = 'J'  ") or die(' Fout in select'); 
$result   = mysqli_fetch_array( $sql );
$rechten  = $result['Beheerder'];

if ($rechten != "A"  and $rechten != "I"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
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

// als er nog geen datum in zit,dan toernooi datum vast toevoegen

$count     = 0;
$qry      = mysqli_query($con,"SELECT * From toernooi_datums_cyclus where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' order by Datum" )     or die(' Fout in select1');  
$count    = mysqli_num_rows($qry);

if ($count == 0){
   mysqli_query($con,"insert into toernooi_datums_cyclus (Id, Vereniging_id, Vereniging, Toernooi,Datum, Laatst) 
                   values (0, ".$vereniging_id.",'".$vereniging."','".$toernooi."','".$datum."', now() )") ;	
}
  
  
  
?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - Beheer cyclus datums</title>
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
   <h4 ><i class="fa fa-calendar" aria-hidden="true"></i> Beheer datums voor Toernooi Cyclus "<?php echo $toernooi_voluit;?>"</h4>
   </div>
   
	
    <div class= 'card card-body'>
       <br>
       <span style='color:black;font-size:1.4vh;font-family:arial;'>Een toernooi cyclus bestaat uit een aantal toernooien (max 10). 
	   In dit scherm kan je datums (max 10) koppelen aan dit toernooi om een cyclus aan te maken. De eerste datum is gelijk aan de opgegeven datum voor het toernooi.<br>
  	    De datums worden automatisch op volgorde gesorteerd.Klik op het kalender icon <i class="fa fa-calendar" aria-hidden="true"></i> in het input veld om een datum te kiezen uit de kalender.<br>
		  	     
        De datum die gelijk is aan de initiele toernooi datum kan je niet verwijderen, wel aanpassen.   
		Indien gewenst kan je een afwijkende speellocatie opgeven die als extra informatie op het formulier wordt getoond.<br>	   
        </span>  
     	 <br><br>
  
			<table class='table table-bordered table-striped table-response w-100'>
			 <thead>
		   <tr>
		      <th style='font-size:1.8vh;font-family:verdana;text-align:center;color:red;'><i class="fas fa-trash-alt"></i></th>
		      <th>Datum nr</th>
			  <th>Invoer datum</th>
			  <th>Datum tekst</th>
		      <th>Afwijkende locatie</th>
			</tr>
		   	</thead>
			<tbody>
		        
			 <?php
			          $qry      = mysqli_query($con,"SELECT * From toernooi_datums_cyclus where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."' order by Datum" )     or die(' Fout in select2');  
                    
                    $i=1;
                    while($row = mysqli_fetch_array( $qry )) {
	
	                  $id     = $row['Id'];
	                  $_datum = $row['Datum'];
	                  $dag    = 	substr ($_datum , 8,2); 
                      $maand  = 	substr ($_datum , 5,2); 
                      $jaar   = 	substr ($_datum , 0,4); 
	                  
	                  ?>
		     		 <tr>
					 <td>
		        	 <?php
		        		// niet verwijderen als datum = toernooi datum
		        		 if ($datum != $_datum){?>
		                    <input type='checkbox' name= 'delete[]' class='trash d-print-none' id= 'trash_<?php echo $row['Id']; ?>' value='<?php echo $row['Id']; ?>' /><label for="trash_<?php echo $row['Id']; ?>"></label>
			         		<?php } else {?>
		        		
		     		 		<?php } ?>		         		 			
                      <td  style='font-weight:bold;font-family:verdana;'>Datum <?php echo $i;?></td>
					  <td style=' font-family:verdana;text-align:center;'>
					     <input type="date"  id='datum' required name="datum_<?php echo $id;?>" placeholder ='kies datum' value ="<?php echo $_datum;?>">
		                       <p style="display:none; color:#DA2C07;font-size:1.2vh;" id="datum_error">
                                        Er is geen datum geselecteerd
                              </p> 
			        	  <td><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ?></td>
		        	  <td style='padding-left: 2px;padding-right: 0px;' >
		        	  	   <input  style=' font-family:verdana;' type = 'text' name = 'locatie_<?php echo $id;?>'  value ="<?php echo $row['Locatie'];?>" size =40></td>
			 	<tr>
			 			
			 		<?php 
			 		$i++;
			 		}?> 		
			 			 
			 	<tr>
			 		<td  style='text-align:center;'>+</td><td>Volgende datum </td>
			 		<td  style='ffont-family:verdana;text-align:center;'>
				     <input type="date"  id='datum_new'   name="datum_new" placeholder ='kies datum' >
			
		<td colspan =2 style='padding-left: 2px;padding-right: 0px; color:blue;'>  <-- Vul hier de datum in  van de volgende dag.</td></tr>
  </tbody>
  </table>
  
  
  <br><span style='color:black;font-size:1.4vh;font-family:arial;'>Door een vinkje te zetten in het lege vierkant in de eerste kolom, kan je een datum verwijderen.<br></span>
  	<span style='color:red;font-size:1.4vh;font-family:arial;font-weight:bold;'>Vul alleen een locatie in als deze afwijkt van de standaard locatie!!</span><br><br></div>
  
  
   


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
