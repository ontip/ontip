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
 
	
$toernooi_naam = $_GET['toernooi'];
$toernooi = $_GET['toernooi'];
$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 $toernooi_naam = $toernooi_voluit;
?>
<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="css/fontface.css" rel="stylesheet" type="text/css" />
 <link href="css/standard.css" rel="stylesheet" type="text/css" />
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
 
 .verticaltext {
    position: relative; 
    padding-left:50px;
    margin:1em 0;
    min-height:120px;
}

.verticaltext_content {
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    left: -40px;
    top: 35px;
    position: absolute;
    color: #FFF;
    text-transform: uppercase;
    font-size:26px;
    font-weight:bold;
}
  
  


</style>
 
<script language="javascript">
function printPage() {
    window.print();
}
</script>

</head>
<body >
 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <a style='font-family:FredokaOne;font-size:2.0vh;' class="navbar-brand pb-2 mr-2" href="<?php echo $pageName;?>"><img src='../ontip/images/ontip_logo_zonder_bg.png'  width="55" border='0'><?php echo $toernooi_voluit;?></a>
 </nav>
  
<div class= 'container'   >
  <BR>
  <div class='card'>
  <div class ='card card-header'>
  <h5>Lijst uitslagen <?php echo $toernooi_voluit;?></h5>
  </div>
   <div class='card card-body'>
    <br>
	

 
  <table class ='table table-hovered table-striped w-100 verticaltext'>
<thead>
  <tr>
  <th class  ='text-center border-right' colspan = 2></th>
    <th colspan = 2 class ='text-center border-right'>Ronde 1</th>
    <th colspan = 2 class ='text-center border-right'>Ronde 2</th>
    <th colspan = 2 class ='text-center border-right'>Ronde 3</th>
  </tr>
    <tr>
  <th class  ='text-right border-right'>#</th>
  <th class  ='text-left border-right' >Naam</th>
  <th class ='text-center border-right' >V</th>
  <th class='text-center text-danger border-right'>T</th>
  <th class ='text-center border-right' >V</th>
  <th class='text-center text-danger border-right'>T</th>
  <th class ='text-center border-right' >V</th>
  <th class='text-center text-danger border-right'>T</th>
  <th class ='text-center border-right ' >Winst</th>
  <th class='text-center text-success border-right '>Saldo</th>
  </tr>
  </thead>
  <tbody>
  
  <?php
   $i=1;
   while ($row = mysqli_fetch_array( $qry )) {
		  
		  $saldo = 0;
		  $winst =0;
		  ?>
		     <tr>
        <td class='text-right border-right' ><?php echo $i; ?></td>
        <td class='text-left border-right' ><?php echo $row['Naam']; ?></td>
		<?php
       
         
		 if ($row['Voor1']== 13){
			 $winst++;
		 }
		 if ($row['Voor2']== 13){
			 $winst++;
		 }
		 if ($row['Voor3']== 13){
			 $winst++;
		 }
		 
		 	 $saldo =   ($row['Voor1'] - $row['Tegen1'])+($row['Voor2'] - $row['Tegen2'])+($row['Voor3'] - $row['Tegen3']) ;
	     ?>
	       <td class='text-right border-right' 		   ><?php echo $row['Voor1']; ?></td>
	       <td class='text-right text-danger border-right'><?php echo $row['Tegen1']; ?></td>      
	       <td class='text-right border-right' 		   ><?php echo $row['Voor2']; ?></td>
	       <td class='text-right text-danger border-right'><?php echo $row['Tegen2']; ?></td>      
	       <td class='text-right border-right' 		   ><?php echo $row['Voor3']; ?></td>
	       <td class='text-right text-danger border-right'><?php echo $row['Tegen3']; ?></td>      
	 
	    
	     <td class='text-right border-right bg-light' 		   ><?php echo $winst; ?></td>
		 <td class='text-right border-right bg-light' 		   ><?php echo $saldo; ?></td>
	   </tr>
	   <?php
	   $i++;
    }// end foreach namen
    ?>
 </tbody>
</table> 
<center>
             <button class="btn btn-primary d-print-none" onclick="printPage()"><i class="fa fa-print" aria-hidden="true"></i>Print</button>
	    </center>
	 </div> <!--- card body--->
	  
   
  
  </div><!--- card---->
	   </form>
</div>  <!--  container ---->
    
 </body>
</html>


<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>


<script>
  

$( "#myForm" ).validate({
  rules: {
   
	 voor: {
      required: true,
      digits: true,
	   min:0,
	   max:13
    },
	 tegen: {
       required: true,
       digits: true,
	    min:0,
	    max:13
    },
	 naam: {
       required: true,
       
    },
	 
  },// end rules
  
   messages: {
      voor: {
        required: "Invoer score is verplicht",
	    digits: "Mag alleen getallen bevatten",
		 min: "Getal tussen 0 en 13 invullen",
		 max: "Getal tussen 0 en 13 invullen",
     },   
	  tegen: {
        required: "Invoer score is verplicht",
        digits: "Mag alleen getallen bevatten",
        min: "Getal tussen 0 en 13 invullen",
		max: "Getal tussen 0 en 13 invullen",
     },     	 
	  
   },  // end messages
  errorPlacement: function(error, element) {
           
            if (element.attr("name") == "voor" ) {
                $("#errNm1").text($(error).text());
            }
   		
			if (element.attr("name") == "tegen" ) {
			    $("#errNm2").text($(error).text() );
            }
            
        }// end error placement


	
});

// end


</script>
 <script>
	  
 $("#myName").validate({
  rules: {
    // simple rule, converted to {required:true}
    naam: "required"
   
  },
   
  messages: {
    naam: "Naam moet ingevuld worden." 
  },
   errorPlacement: function(error, element) {
    if (element.attr("name") == "naam" ) {
			    $("#errNm0").text($(error).text() );
            }
            
        }// end error placement
			
});

$("button").click(function(){
  $("button").removeClass("active");
  $(this).addClass("active");
});
</script>