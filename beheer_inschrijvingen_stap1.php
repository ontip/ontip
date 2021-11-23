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

$start_row = 1;
$qry      = mysqli_query($con,"SELECT count(*) as Aantal from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."'  " )    or die(mysqli_error());  
$result   = mysqli_fetch_array( $qry );
$aantal_rows = $result['Aantal'];
 
if (isset($_GET['start'])){
	$start_row = $_GET['start'];
}
 else {
	$start_row =1;
 }

if (isset($_GET['end'])){
	$end_row = $_GET['end'];
}

if ($end_row < 25){
	$end_row = $aantal_rows;
}

?>
<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - Muteer inschrijvingen</title>
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
include('include_navbar.php') ;
?>
 
  <BR>
     <FORM class="needs-validation" novalidate  action='beheer_inschrijvingen_stap2.php' autocomplete="off" ame= 'myForm' method='post' target="_top">	 
 	   <INPUT TYPE='hidden' NAME='zendform'                VALUE='1'>
       <INPUT TYPE='hidden' NAME='toernooi_md5'            VALUE='<?php echo md5($toernooi);?>'>
	   <INPUT TYPE='hidden' NAME='vereniging_md5'          VALUE='<?php echo md5($vereniging_id);?>'>
	   <INPUT TYPE='hidden' NAME='aantal'                  VALUE='<?php echo $aantal_rows;?>'>
	   <INPUT TYPE='hidden' NAME='soort_inschrijving'      VALUE='<?php echo $soort_inschrijving;?>'>
	   <INPUT TYPE='hidden' NAME='inschrijf_methode'       VALUE='<?php echo $inschrijf_methode;?>'>
	   
 <center>
  
  <div class='card   ml-5 mr-5 '>
  <div class ='card card-header'>
  <h5>Beheer inschrijvingen <?php echo $toernooi_voluit;?></h5>
  </div>
   <div class='card card-body'>
   <table  width=100%>
		 <tr>
		  <td style ='font-size:1.2vh;text-align:left;'>
	      </td>
		  <td style ='font-size:1.2vh;text-align:right;'>
			   <button type="submit" class="btn btn-primary responsive-width text-left">Verzenden</button>
    		</td>
		    
           </tr>
		 </table>
    
	<br><p class='uitleg'>Hier kan je eventuele typefouten in de naam corrigeren of records verwijderen uit de tabel.Op deze pagina kunnen enkele gegevens gewijzigd worden. Via de knop Details kunnen de andere gegevens aangepast worden.,<br>  Er worden maximaal 25 regels per pagina getoond. Via de navigatie knoppen kunt u bladeren.
  
	    
    </p>
	<center>
	<?php
	if ($end_row > 25){ ?>
	<div class='btn-group text-center' role='group'>
     <?php 
         
         // buttons voor navigatie knoppen
         $end_row == 88;
            for($r=1;$r<=$aantal_rows;$r=$r+25){
        		$s=$r+24;
        		if ($s > $aantal_rows){
        			$s=$aantal_rows;
        		}
        		 ?>
        		<a   href = '<?php echo $pageName;?>?start=<?php echo $r;?>&end=<?php echo $s;?>' target='_self' role='button' class='btn btn-sm btn-success ml-2'><?php echo $r;?> - <?php echo $s;?>  </a>
        		<?php 
         
        	}// end for
        	
        	?>
         </div>
  <?php } ?>

	
 </center>
 <br>
  
 <a href ='beheer_inschrijvingen_stap2.php?id1=<?php echo md5($toernooi);?>&id2=<?php echo md5($vereniging);?>&sort=time' role ='button' class="btn btn-success   col-1"  target= '_self'>Originele sortering</a>	 
  
 	 <table class='table table-hovered table-striped table-responsive table-sm w-100'>
         <thead>
		  <tr>
             <th  colspan=2 class= 'border border-right'>  </th>
	          <th colspan=2  style='text-align:center;' class= 'border border-right' >Speler 1 </th>
 			 <?php
         if ($soort_inschrijving !='single' and  $inschrijf_methode  != 'single'  ){?>			  
          	  <th colspan=2  style='text-align:center;' class= 'border border-right'>Speler 2 </th>
            <?php }  
          if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
 	           <th colspan=2 style='text-align:center;'  class= 'border border-right'>Speler 3 </th>

            <?php }  ?>
         
             <th   colspan =2 class= 'border border-right'> </th>
		 
           </tr>
		   	  <tr>
             <th   width= 3% class= 'border border-right' >VolgNr </th>
		     <th class= 'border border-right' style='text-align:center; '    width= 3%><img src='../ontip/images/trash_checked.png'       width=18 border =0 alt='Verwijderen'>
             <th   width= 10%  >Naam 1 </th>
			 <th   width= 15% class= 'border border-right'>Vereniging 1 </th>
			 <?php
         if ($soort_inschrijving !='single' and  $inschrijf_methode  != 'single'  ){?>			  
             <th   width= 10% >Naam 2 </th>
			 <th   width= 15% class= 'border border-right'>Vereniging 2 </th>
            <?php }  
            if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
              <th   width= 10% >Naam 3 </th>
			  <th   width= 15% class= 'border border-right'>Vereniging 3 </th>	
            <?php }  ?>
         
             <th   width= 10%>Inschrijving</th>
			 <th   width= 8% class= 'border border-right'>Aanpassen</th>
           </tr>
        </thead>
        <tbody>
		<?php
//		echo "SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Inschrijving  ";
		
 		   $qry = mysqli_query($con,"SELECT * from inschrijf Where Toernooi = '".$toernooi."' and Vereniging = '".$vereniging."' order by Volgnummer,Inschrijving  " )    or die(mysqli_error());  
           
            /// skip lines
            $i=1;
            if ($start_row > 1){
            	for ($i=1;$i< $start_row;$i++){
            	   $row = mysqli_fetch_array( $qry );
            	  }
            }
		   // vanaf start row
               for ($i=$start_row;$i<= $end_row;$i++){
                   $row = mysqli_fetch_array( $qry );
       		       $id   = $row['Id'];
	 
		?>
          <tr>
		  <td style='text-align:right;font-size:1.2vh;' class= 'border border-right'>
		     <div class="form-group"> 
		   	<input type="nummer"   name ='volgnummer-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Volgnummer'];?>'   >
            </div>
		  </td>
		  <td style='text-align:center; ' class= 'border border-right'   title='verwijderen'>
            <INPUT TYPE='hidden' NAME='Id-<?php echo $i?>' VALUE='<?php echo $row['Id'];?>'>
            <input type='checkbox' class = 'trash' name='delete[]' value ="<?php echo $row['Id'];?>" id="trash_<?php echo $row['Id'];?>"  unchecked ><label for="trash_<?php echo $row['Id'];?>"></label>   
          </td>
  
		  <td class= 'border '>
		   <div class="form-group">
		        <input type="text"   name ='naam1-<?php echo $id;?>' required  class="form-control "  size=14 value ='<?php echo $row['Naam1'];?>'  placeholder='Naam speler 1'  >
                 <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen naam  ingevuld</span>
          </div>
		  </td>
		  <td class= 'border '>
		  <div class="form-group">
		        <input type="text"   name ='vereniging1-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Vereniging1'];?>'  placeholder="Naam vereniging 1">
                  <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen vereniging  ingevuld</span>
          </div> 
		 </td>
		 			 <?php
        if ($soort_inschrijving !='single' and  $inschrijf_methode  != 'single'  ){?>	
           <td class= 'border'>		
   		<div class="form-group">
		        <input type="text"   name ='naam2-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Naam2'];?>'  placeholder='naam speler 2' >
                  <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen naam  ingevuld</span>
          </div>
		  </td>
		  <td class= 'border '>
		  <div class="form-group">
		        <input type="text"   name ='vereniging2-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Vereniging2'];?>'  placeholder="Naam vereniging 2">
                 <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen vereniging  ingevuld</span>
          </div> 
		 </td>
		 <?php }  
	 
	  if ($soort_inschrijving =='triplet' or $soort_inschrijving =='4x4' or $soort_inschrijving =='kwintet' or $soort_inschrijving =='sextet'  ){?>	
           <td class= 'border '>		
   		<div class="form-group">
		        <input type="text"   name ='naam3-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Naam3'];?>'  placeholder='naam speler 3' >
                  <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen naam  ingevuld</span>
          </div>
		  </td>
		  <td class= 'border border-right'>
		  <div class="form-group">
		        <input type="text"   name ='vereniging3-<?php echo $id;?>' required  class="form-control input-sm"   value ='<?php echo $row['Vereniging3'];?>'  placeholder="Naam vereniging 3">
                 <span class="valid-feedback">OK</span>
                  <span class="invalid-feedback">Geen vereniging  ingevuld</span>
          </div> 
		 </td>
		 <?php } ?>
	 
		  <td  class= 'border' >
		  <div class="form-group">
		        <input style='text-align:right;font-size:1.2vh;' type="text"   name ='inschrijving-<?php echo $id;?>' disabled  class="form-control input-sm"   value ='<?php echo $row['Inschrijving'];?>'  placeholder=" ">
            </div> 
		 </td>
		  	  <td class= 'border   text-center'>
		  <div class="form-group">
		        <a href ='beheer_inschrijving_detail_stap1.php?id=<?php echo md5($id);?>' role='button'  class='btn btn-sm btn-primary' >Details</a>
            </div> 
		 </td>
			</tr>   
		<?php	   
			 
		   } // end while
		   ?>
		   
		   
		</tbody>
		</table>
	 
	<?php
	include('include_spam_check.php');
	?>
	 </div> <!--- card body--->
	   <div class='card card-footer'>
	
     <table  width=100%>
		 <tr>
	 	   
		  <td style ='font-size:1.2vh;text-align:left;'>
          
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