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
 <div class= 'card w-100'>
    <div class= 'card card-header'>
    <h3>Import en Export "<?php echo $toernooi_voluit;?>"</h3>
   
   </div>
 
   <div class= 'card card-body'>
  
    <div class="list-group">
	    
	      <a href="export_inschrijf_alleen_namen_xlsx.php?toernooi=erik_test_toernooi" class="list-group-item list-group-item-action flex-column align-items-start ">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export - alleen namen</h5>
          
          </div>
          <p class="mb-1">
      	 <ul>
      	  <li>Van de lijst met deelnemers wordt een Excel bestand aangemaakt .</li>
      	  <li>De lijst bevat alleen de namen </li>
      	</ul>
		</p>
        </a>	
		<br>
        <a href="export_inschrijf_naam_ver_xlsx.php?toernooi=erik_test_toernooi" class="list-group-item list-group-item-action flex-column align-items-start ">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export - namen + verenigingen (gescheiden kolommen)</h5>
          
          </div>
          <p class="mb-1">
      	 <ul>
      	  <li>Van de lijst met deelnemers wordt een Excel bestand aangemaakt .</li>
      	  <li>De lijst bevat alleen namen + verenigingen (gescheiden kolommen)</li>
      	</ul>
		</p>
        </a>
	   <br>	
	      <a href="export_inschrijf_naam_ver_1kolom_xlsx.php?toernooi=erik_test_toernooi" class="list-group-item list-group-item-action flex-column align-items-start ">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export - namen + verenigingen (zelfde kolom)</h5>
          
          </div>
          <p class="mb-1">
      	 <ul>
      	  <li>Van de lijst met deelnemers wordt een Excel bestand aangemaakt .</li>
      	  <li>De lijst bevat alleen namen + verenigingen (dezelfde kolom)</li>
      	</ul>
		</p>
        </a>	
		
		  <br>	
	      <a href="export_inschrijf_uitgebreid_xlsx.php?toernooi=erik_test_toernooi" class="list-group-item list-group-item-action flex-column align-items-start ">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export - uitgebreid</h5>
          
          </div>
          <p class="mb-1">
      	 <ul>
      	  <li>Van de lijst met deelnemers wordt een Excel bestand aangemaakt .</li>
      	  <li>De lijst bevat namen , licenties en verenigingen  </li>
      	</ul>
		</p>
        </a>	
  </DIV>
      
	  
	  
		 <div class="flex-column align-items-start ">
          <div class="d-flex w-100 justify-content-between">
           
         </div>
		 
        </div>
		
		
	
		   
		 
		  
	  
	 
		
     
  </div> <!--- card body ---->
  
  <div class = 'card card-footer'>
  <table class='w-100'>
     <tr>
	   <td width=25% style='text-align:left;'>
	     <input type="button" value="Vorige pagina" class='btn btn-sm btn-info' onclick="history.back()" /> 
         </td>
	     
	 </tr>
	 </table>
  </DIV>
 
	 
</div>  <!--  card  ---->
	</div>  <!--  container ---->
 <!-- Footer -->
<?PHP
include('include_footer.php');
?>
<!-- Footer -->
 </body>
</html>
