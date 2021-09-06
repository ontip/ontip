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

# 14jul2021          1.0.1           E. Hendrikx
# Symptom:   		 None.
# Problem:       	 None.
# Fix:               None.
# Feature:           Indien uitslag bekend, geen mogelijkheid om ronde knop te gebruiken
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

$toernooi = $_GET['toernooi'];
$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}
	 $toernooi_naam = $toernooi_voluit;
	 
	 
  
 


//include('action.php');

 if (isset($_POST['naam']) and isset($_POST['onthoud']) ){
	 $naam = $_POST['naam'];
	 setcookie('naam',$_POST['naam'], time()+7200 );
	  }
 if (isset($_COOKIE['naam'])   ){
	 $naam = $_COOKIE['naam'];
	 
	  }

 
if (isset($_POST['reset']) ){
     setcookie('naam','' , time()-7200 );
     $naam = '';
   }

	$qry    = mysqli_query($con,"SELECT * FROM `toernooi_uitslag` where Vereniging_id = ".$vereniging_id." and Toernooi_naam = '".$_GET['toernooi']."' and Naam = '".$naam."'   ")            or die('fout in select');  
    $result     = mysqli_fetch_array( $qry );
	$id_md5     = md5($result['Id']);
    for ($i=1;$i<11;$i++)	{
	    $var = 'voor'.$i;
		$$var = $result['Voor'.$i];
	}
	

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
 
  
.shadow {border:0.1vh solid black;font-size:2.6vh;text-align;center; vertical-align:middle;height:9vh;padding: 1vh;width:12vh;
  box-shadow: 0.2vh 0.2vh #888888;
  }
  
.focusedInput {
    border-color: rgba(82,168,236,.8);
    outline: 0;
    outline: thin dotted \9;
    -moz-box-shadow: 0 0 8px rgba(82,168,236,.6);
    box-shadow: 0 0 8px rgba(82,168,236,.6) !important;
}

h6 {font-size:1.6vh;}
h5 {font-size:2.0vh;}

</style>
 </head>
<body >
 
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <a style='font-family:FredokaOne;font-size:2.0vh;' class="navbar-brand pb-2 mr-2" href="<?php echo $pageName;?>"><img src='../ontip/images/ontip_logo_zonder_bg.png'  width="55" border='0'><?php echo $toernooi_voluit;?></a>
 </nav>
  
<div class= 'container'   >
  
  <div class='card w-100'>
   <div class='card card-body'>
   
   <!--------------------  invoer naam ---------------------------------------------------/////------->
   
   <FORM class="needs-validation  " novalidate  action='<?php echo $pageName;?>?toernooi=<?php echo $_GET['toernooi'];?>'  autocomplete="off" name= 'myName' id= 'myName' method='post' target="_top" >	 
     <input type='hidden' name ='vereniging_id' value = '<?php echo $vereniging_id;?>' />
	 <h5 >Naam</h5>
	  
	   <div class="input-group ">
	   <?php
	    if ($naam == ''){?>
	      <input type="text" size=11 style='font-size:3.2vh;' data-error="#errNm0" name ='naam' required class="form-control form-control-lg focusedInput"  
		     placeholder="Naam zoals op lijst" value ='<?php echo $naam;?>' >
	    <?php } else {?>
			<div class='border shadow-sm w-100 mb-3 p3' style='font-size:2.2vh;padding:1vh;font-weight:bold;'><?php echo $naam;?></div>
			<?php
		}	
			?>
       </div>
	 
	 <div class='text-right'>
	   <?php
	    if ($naam ==''){?>
    	   <button   type="submit" name ='onthoud' aria-describedby="button-addon1" class="btn btn-sm   btn-primary">Vul in en klik hier</button>
		<?php }
		if ($naam !=''){?>
	   <button style='font-size:1.2vh;' aria-describedby="button-addon1"  type="submit" name ='reset' class="btn btn-sm btn-danger"><i class="fas fa-recycle"></i> naam</button>
	   <?php }?>
	  </div>
	 </FORM>
	 
		   
	  <?php
	   if (isset($_GET['naam'])){?>
		   <div class ='row errorTxt w-100'> 
           <div class='col-12 '     id=" " style='color:red;font-size:2.2vh;' >Geen naam ingevuld</div> 
	      </div>
		 <?php  
	   }
	   ?>
	  
	<div class ='row errorTxt w-100'> 
    <div class='col-12 '     id="errNm0" style='color:red;font-size:2.2vh;' ></div> 
	</div>
	
<!--------------------------------  invoer scores ----------------------------------------------////---->	
  
  <FORM class="needs-validation " novalidate  action='doorgeven_uitslag_stap2.php' autocomplete="off" name= 'myForm' id= 'myForm' method='post' target="_top"-->	 
  	   <input type='hidden'  name ='vereniging_id' value = '<?php echo $vereniging_id;?>' />
	   <input type='hidden'  name ='vereniging' value = '<?php echo $vereniging;?>' />
       <input type='hidden'  name ='naam'            value = '<?php echo $naam;?>'>
       <input type='hidden'  name ='toernooi_naam'   value = '<?php echo $_GET['toernooi'];?>'>
  
     <?php
     if ($voor1 ==''  and  $voor2 =='' and $voor3 =='' and  $voor4 =='' and $voor5 =='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
           $ronde =1;                ?>
          <input type="hidden" name="ronde"    value='1'    >
     	  
     <?php }  
     
         if ($voor1 !=''  and  $voor2 =='' and $voor3 =='' and  $voor4 =='' and $voor5 =='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
           $ronde = 2;   	  ?>
           <input type="hidden" name="ronde"    value='2'    >
     	  
     <?php }  
     
     if ($voor1 !=''  and  $voor2 !='' and $voor3 =='' and  $voor4 =='' and $voor5 =='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde =3;          ?>
           <input type="hidden" name="ronde"    value='3'    >
     	  
     <?php }  

     if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 =='' and $voor5 =='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde =4;          ?>
           <input type="hidden" name="ronde"    value='4'    >
     	  
     <?php }

     if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 =='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde =5;          ?>
           <input type="hidden" name="ronde"    value='5'    >
     	  
     <?php }

     if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 !='' and  $voor6 =='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde = 6;          ?>
           <input type="hidden" name="ronde"    value='6'    >
     	  
     <?php }

     if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 !='' and  $voor6 !='' and $voor7 =='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde = 7;          ?>
           <input type="hidden" name="ronde"    value='7'    >
     	  
     <?php }

    if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 !='' and  $voor6 !='' and $voor7 !='' and  $voor8 =='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde = 8;          ?>
           <input type="hidden" name="ronde"    value='8'    >
     	  
     <?php }

    if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 !='' and  $voor6 !='' and $voor7 !='' and  $voor8 !='' and $voor9 =='' and  $voor10 =='' ){	
            $ronde = 9;          ?>
           <input type="hidden" name="ronde"    value='9'    >
     	  
     <?php }
	 
	  if ($voor1 !=''  and  $voor2 !='' and $voor3 !='' and  $voor4 !='' and $voor5 !='' and  $voor6 !='' and $voor7 !='' and  $voor8 !='' and $voor9 !='' and  $voor10 =='' ){	
            $ronde = 10;          ?>
           <input type="hidden" name="ronde"    value='10'    >
     	  
     <?php }
	 ?>

<?php
 	$qry    = mysqli_query($con,"SELECT * FROM `toernooi_uitslag` where Vereniging_id = ".$vereniging_id." and Toernooi_naam = '".$_GET['toernooi']."' and Naam = '".$naam."'   ")            or die('fout in select');  
    $result     = mysqli_fetch_array( $qry );

if ($naam !='' ){
?>

	
  <div class="form-check w-100">
	
	<table class='table w-100 table-hovered '>
	<thead>
	 <tr>
	  <th style='font-size:1.2vh;'>Ronde</th>
	  <th style='font-size:1.2vh;'>Voor</th>
	  <th style='font-size:1.2vh;'>Tegen</th>
	  </tr>
	  <thead>
	  <tbody>
	  
  <?php
		
		
	for ($i=1;$i<11;$i++)	{
	
	$var1 = 'Voor'.$i;
	$var2 = 'Tegen'.$i;
	 
	$voor = $result[$var1];
	
	if (!is_null($voor)  ){
		
		if ($voor == 13){?>
		 <tr class='bg-success text-white'  >
		<?php } else {?>
		 <tr class='bg-danger text-white'>
		<?php	
		}
		?>
		 
		 <td style='font-size:1.2vh;'  ><?php echo $i;?></td>
          <td style='font-size:1.2vh;'><?php echo $result[$var1];?></td>
		  <td style='font-size:1.2vh;'><?php echo $result[$var2];?></td>
		</tr>
		<?php
	}// end if
	} /// end for i
	?>
	</tbody>
    </table>	
		
</DIV> <!--- form check ---->
	
<?php } ?>		 
</center>
<div class ='row errorTxt w-100'> 
    <div class='col-6'   id="errNm4" style='color:red;font-size:2.2vh;' ></div> 
</div>

<br>
  
   <center>
	 <div class ='row'>
	   <div class ='col-12'>
	    <h5 >Invoer score voor ronde <?php echo $ronde;?></h5>
       </div>
     </div><!--- row---> 
      

 <div class ='row '>
 <?php if ($naam != ''){?>
  
	 <div class ='col-6  '>
           <label><h6>Mijn score</h6></label>
	       <input   type="text" name ='voor' id='voor'  size=2  onchange ='vul13();' data-error="#errNm1" id="focusedInput" autofocus="autofocus"   required class="form-control form-control-lg" id="exampleInputEmail1"   placeholder="??">
	  </div> 
   
	 <div class ='col-6  '>
	     <label><h6>Tegenstander</h6></label>
         <input type="text"  name ='tegen' id='tegen'   size=2  onblur ='vul13();' data-error="#errNm2"  required class="form-control form-control-lg" id="exampleInputpassword" aria-describedby="plaatsHelp" placeholder="??">
        </div>
 	
<?php } else {?>
	 <div class ='col-6'  >
           <label><h6>Mijn score</h6></label>
	   <div class='border w-50 h-100 bg-light rounded-lg'><br> </div>
	    
		</div> 
	 
	 <div class ='col-6 '>
	     <label><h6>Tegenstander</h6></label>
           <div class='border w-50 h-100 bg-light rounded-lg'><br> </div>  
  	   
		 </div> 
		 <br>
		 <br>
		 
<?php
}
  ?>		
     </div><!--- row--->
	 </center>
  <?php
   
  if ($naam == ''){?> 
<br>
<br>

<?php
}
  ?>

    <?php
	   if (isset($_GET['score'])){?>
	    <br>
		   <div class ='row errorTxt w-100'> 
           <div class='col-12 '     id=" " style='color:red;font-size:2.2vh;' >Een van beide scores moet 13 zijn</div> 
	      </div>
		 <?php  
	   }
	   ?>
    <div class ='row errorTxt w-100'> 
    <div class='col-6'   id="errNm1" style='color:red;font-size:2.2vh;' ></div>
    <div class='col-6'   id="errNm2" style='color:red;font-size:2.2vh;'></div>
   </div>
   <br>
   <?php
  
  if ($naam ==''   ){	?>
 <div  class='w-100' id='melding' style='text-align:center;font-size:1.6vh;color:blue;'> Vul je naam in en klik op 'Vul in en klik hier'</div>
  
<?php
   }
   else {   

   ?>
   <div  class='w-100' id='melding' style='text-align:center;font-size:1.6vh;color:blue;'> Je hoeft alleen de score <b>ongelijk aan 13</b> in te vullen<br>bij 'Mijn score' of 'Tegenstander'!<br>Laatst ingevulde score kan je binnen <br>30 minuten na invoer verwijderen via <i style='font-size:1.8vh;' class="fa fa-trash-o"></i></div>
    <?php
   }?>
   <?php
	   if (isset($_GET['halfuur'])){?>
	    <br>
		   
           <div   id='melding2'      style='color:red;font-size:1.6vh;text-align:center;' >Score verwijderen kan alleen binnen een half uur na invoer.</div> 
	        
		 <?php  
	   }
	   ?>
	   
	   
   <!-----------------------------------  prullenbak. Mogelijkheid om binnen half uur score te verwijderen------------->
   <BR>
   <?php
    if ($ronde > 1){ ?>
   <table class='w-100' >
	<tr>
	<td style='text-align:right;'><a href='doorgeven_uitslag_stap3.php?id=<?php echo $id_md5;?>' target='_self'><i style='font-size:2.2vh;' class="fa fa-trash-o"></i></a></td>
	</tr>
	</table>
	<?php } ?>
	
	
	</div> <!--- card body--->
	 <div class ='card card-footer'>
	 <table>
	 <tr>
	 <td style ='font-size:1.2vh;text-align:left;'>
        <a href ='lijst_uitslag.php' target='_blank' style='font-size:1.2vh;' role='button' class="btn btn-sm btn-secondary <?php echo $status;?>"><i class="fas fa-list"></i></button>
  </td>
	  <td style ='font-size:1.2vh;text-align:right;'>
	 
        <button style='font-size:2.4 vh;' type="submit"  id='submit_button' class="btn btn-sm btn-primary <?php echo $status;?>">VERZENDEN </button>
	  
  </td>
  </tr>
  </table>
  </div>
   
  
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

$("#inputID").focus(); // will bring focus
$("#inputID").addClass("focusedInput"); // will give it the bootstrapped focus style
scrollTo("#confirm_deletion"); // actually make browser go to that input

/* scroll to the given element section of the page */
function scrollTo(element)
{
    $('html, body').animate({scrollTop: $(element).offset().top-60}, 500);
}
</script>

<script>
 $('input[name=voor]').on('change', function(){
	 
	if ($(this).val() < 13){
		$('#tegen').val('13'); 
        $('#melding').text('Vergeet niet op Verzenden of de Return of Enter-toets te drukken'); 
		$('#melding2').text(''); 
     	$('#errNm1').text(''); 
     	$('#errNm2').text(''); 
	}
	
	if ($(this).val() == 13){
		$('#tegen').val(''); 
     	$('#melding').text(''); 
		$('#melding2').text('');
     	$('#errNm1').text(''); 
     	$('#errNm2').text(''); 
	}
	
	if ($(this).val() > 13){
		$('#voor').val(''); 
     	$('#melding').text(''); 
     	$('#errNm1').text('Moet lager dan 14 zijn'); 
     	$('#errNm2').text(''); 
	}
	
	 
});

$('input[name=tegen]').on('change', function(){
	 
	if ($(this).val() < 13   ){
    	$('#voor').val('13'); 
    	$('#melding').text('Vergeet niet op Verzenden of de Return of Enter-toets te drukken'); 
    	$('#errNm1').text(''); 
    	$('#errNm2').text(''); 
	}
	
	if ($(this).val() == 13){
	   	$('#voor').val(''); 
    	$('#melding').text(''); 
    	$('#errNm1').text(''); 
    	$('#errNm2').text(''); 
	}
	
	if ($(this).val() > 13){
		$('#tegen').val(''); 
     	$('#melding').text(''); 
     	$('#errNm2').text('Moet lager dan 14 zijn'); 
     	$('#errNm1').text(''); 
	}
	
});


 </script>
 
