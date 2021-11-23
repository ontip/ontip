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
$today    = date('Y-m-d');
$ip       = $_SERVER['REMOTE_ADDR'];
$pageName = basename($_SERVER['SCRIPT_NAME']);
$toernooi_id = $_GET['toernooi'];

// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

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

//$toernooi_id = 'c96e45d7cf77b40acfd9464c7077daaf';

$toernooi_id = $_GET['toernooi'];
 
  $qry             = mysqli_query($con,"SELECT Toernooi From config WHERE Vereniging_id = ".$vereniging_id."  and md5(Toernooi) = '".$toernooi_id."'  and Variabele ='toernooi_voluit' ")     or die(' Fout in select config');  
  $result          = mysqli_fetch_array( $qry );
  $toernooi_select = $result['Toernooi'];
 
  if ($toernooi_select ==''){
	  echo "<br>Toernooi niet gevonden!";
	  exit;
  }
  
// Definieer variabelen en vul ze met waarde uit tabel config

$qry  = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select');  
while($row = mysqli_fetch_array( $qry )) {
	
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
	}   
 

?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - formulier aanpassen <?php echo $toernooi;?></title>
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

h6  {font-size:1.6vh;}
h4 {font-size:1.8vh;}	


/* If the screen size is 601px wide or more, set the font-size of <class> to 1.4 */
@media screen and (min-width: 601px) {
  p.koptekst,td.koptekst, a.koptekst, label, div.uitleg,span.uitleg {
    font-size: 1.4vh;
	color:black;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.koptekst,td.koptekst, div.uitleg,span.uitleg, label {
    font-size: 1.6vh;
	color:black;
  }
}

</style>

 </head>

<body >
 
 <?php
include('include_navbar.php') ;

function haal_parameters($vereniging_id,$toernooi,$arg){
		
	include('mysqli.php');
 			 
	$qry  = mysqli_query($con,"SELECT Parameters  From config where Vereniging_id = ".$vereniging_id ." and Toernooi = '".$toernooi ."'
                 and Variabele ='".$arg."'		  ")     or die(' Fout in select');  
    $result     = mysqli_fetch_array( $qry );
     $parameters = $result['Parameters'];
	 
  return($parameters);
  
	}
	
	
?>


<br>
<div class= 'container'   >

 <FORM class="needs-validation" novalidate  action='formulier_aanpassen_stap2.php' autocomplete="off" name= 'myForm' method='post' target="_top">	 
       <input type="hidden" name="zendform"          value="1" /> 
	   <input type="hidden" name="toernooi_id"   value="<?php echo $toernooi_id;?>" /> 
	   <input type="hidden" name="vereniging_id_md5" value="<?php echo md5($vereniging_id);?>" /> 
	
	
 <div class= 'card w-100'>
  <div class= 'card card-header'>
   <div class= 'card card-header' style='background-color:<?php echo $achtergrond_kleur ; ?>;'>
 <h4 style='font-family:<?php echo $font_koptekst; ?>;color: <?php echo $koptekst_kleur; ?>;'><i class="fa fa-cog" aria-hidden="true"></i> <?php echo $vereniging;?> - <?php echo $toernooi_select;?> - FORMULIER AANPASSEN</h4>	 
	</div> 
  	
    <div class= 'card card-body'>
	
			<div class ='row'>
		
	 <div class = 'col-11'>
	  <p style='font-size:1.4vh;text-align:justify;'>Hieronder staan de instellingen die rechtstreeks betrekking hebben op het formulier. Dus alle zaken die te maken hebben met afbeeldingen, kleuren en welke zaken af of niet aanwezig zijn op het inschrijfformulier. Via de UITLEG knop aan de rechterkant kan je uitleg krijgen over de diverse instellingen.
	  Instellingen die betrekking hebben op het toernooi kan je aanpassen via de menu optie 'Toernooi/Toernooi aanpassen' of via deze <a href = 'toernooi_aanpassen_stap1.php?toernooi=<?php echo $_GET['toernooi'];?>' target='_self'>link</a>.
	  	  <br>Na aanpassen op een van beide 'Verzenden' knoppen klikken. Wijzigingen zijn direct actief voor het toernooi. Wilt u een ander toernooi aanpassen? Selecteer deze dan via Toernooi/Toernooi selectie.
  
	  <?php
	  $sql      = mysqli_query($con,"SELECT * FROM config where Toernooi = '".$toernooi."'  and Vereniging  =  '".$vereniging."' and Variabele = 'formulier_config_compleet'") or die(' Fout in select toernooi '.$toernooi_id);  
       $result   = mysqli_fetch_array( $sql );

      if ($result['Toernooi'] ==''){?>
 	  <p style='font-size:1.4vh;text-align:justify;color:blue;'><i class="fas fa-exclamation-triangle"></i> Het blijkt dat de database niet synchroon is met de instellingen hieronder. Het aanpassen van de waarden kan hierdoor mogelijk iets langer duren.</p>
	  <?php } else {
		  $sync_time = $result['Waarde'];
	  } ?>
      </div>
	  
	  <div class='col-1'>
	   <a href ='uitleg_toernooi_aanpassen.php' class ='btn btn-sm btn-success'>UITLEG</a>
	   </div>
	   <table  width=100%>
		 <tr>
	       <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden</button>	
			 </td>
          </tr>
     </table>
	 
	 
	 
	   </div><!-- rOW--->
	   
	  <br>
  	
   <hr>
 <div class= 'row'>
       <div class='col-6'>	
	     <label for="naam"><b>Systeem naam voor toernooi</b></label>
	     </div>
     
	   <div class='col-6'>	
	   <div class="form-group">
 		    <input type="text"  disabled   name ='toernooi'    class="form-control"   value='<?php echo $toernooi;?>'>
    
	      </div>
      </div>
   </div><!--- row-->

   <!--div class= 'row'>
	   <div class='col-6'>	
	      <label for="exampleInputEmail1"><b>Afbeelding</b></label>
	     </div>
         <div class='col-6'>	
          <div class="form-group"> 	   
	        <?php
		   $parameters = haal_parameters($vereniging_id, $toernooi,'url_afbeelding');
		   $parameter  = explode('#', $parameters);
		   
           $afb_width   = 0;
           $afb_height  = 0;
		   $plaats_afb  = $parameter[1];
           $afb_width   = $parameter[2];
           $afb_height  = $parameter[3];
 	      ?>     
              <select name='url_afbeelding' class="custom-select custom-select-sm mb-3 form-select" STYLE='Courier; ;'>
          	   <option value='<?php echo $url_afbeelding; ?>' selected><?php echo $url_afbeelding; ?></option>
               	
  	
               	<?php
              $dir = "images";
			    	
           // Maak een gesorteerde lijst van images  
               $images= array();
			   if ($handle = @opendir($dir)) {
                  while (false !== ($images[] = @readdir($handle))); 
                  sort($images);
                  closedir($handle);
           }// end if handle 
              
			 foreach ($images as $file){
			 
                     $ext ='';
                       if (strpos($file,".")){      
                         $name = explode(".",$file);
                         $ext  = $name[1];
                        }
                
                      
                      if (strlen($file) > 3    and (strtoupper($ext) == 'JPG'  or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG')) {
                         ?>  
                              <option value='<?php echo $file; ?>' ><?php echo $file; ?></option>
                      <?php
                        }
               	          
                      }// end foreach
              
               ?>	
               	</SELECT>

	      </div>
		  </div>
	 </div><!--- row-->	  

<?php
if ($url_afbeelding !=''){?>
		  
 	<!--div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Positie afbeelding</b></label>
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			   <select  name ='positie' required  class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
		  $parameters= haal_parameters($vereniging_id, $toernooi,'url_afbeelding');
		  $parameter  = explode('#', $parameters);

           if ( $parameter[1] != '') { 
             $plaats_afb  = $parameter[1];
          }
          
          // 12 dec 2014 zowel breedte als hoogte voor afbeelding. Default wordt via PHP de grootte bepaald (in formulier_aanpassen_stap2.php)
          
	       switch($plaats_afb){
  		         	case "l":
  	          	        echo "<option value = '#l'  selected/> Links ";
  	                    echo "<option value = '#r'        /> Rechts ";break;
  	            default:
  	          	        echo "<option value = '#l'  /> Links ";
  	                    echo "<option value = '#r'  selected      /> Rechts ";break;
 		 
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	 </div><!--- row-->

 	<!--div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Grootte afbeelding in pixels</b></label>
		  </div>
		  
			<?php
              if ($afbeelding_grootte  > 0){
					 
		      $parameters= haal_parameters($vereniging_id, $toernooi,'url_afbeelding');
		      $parameter  = explode('#', $parameters);
		                
              $afb_width   = 0;
              $afb_height  = 0;
              
              if (isset($parameter[2]) ){ 
                 if ( $parameter[2] != '' )  { 
                    $afb_width  = $parameter[2];
                 }
              }
              
              if (isset($parameter[3]) ){ 
                  if ( $parameter[3] != '' ) { 
                     $afb_height  = $parameter[3];
                 }
              }
		      
		      ?>
			  <div class='col-3'>	
			  <div class="form-group">  
			   Breedte : <input  name= 'afbeelding_width' type='number'   class="form-control w-25"  value ='<?php echo $afb_width; ?>' >   
			   </div>
			   </div>
			   <div class='col-3'>
			     <div class="form-group">  
                   Hoogte  : <input  name= 'afbeelding_height' type='number'  class="form-control w-25"  value ='<?php echo $afb_height; ?>' >  
                 </div>
				</div>
	         <?php
            }	else {		
			   ?>
			    <div class='col-6'>
				 <div class="form-group">  
			       <input type="text"  name ='afbeelding_grootte' type='number'  class="form-control" placeholder='aantal pixels' value='<?php echo $afbeelding_grootte;?>'> 
                 </div>
			   </div>
			   
			<?php }
?>			

	 </div><!--- row-->
	<br> 
<?php } ?>		   
		   
  <div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Achtergrond kleur formulierkop scherm</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  
 		   
		   	 <SELECT name='achtergrond_kleur' class="custom-select custom-select-sm mb-2 form-select w-50"  STYLE='color:<?php echo $tekstkleur;?>;font-size:1.4vh;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox1" onchange="changeFunc1();">
  	           <option style='color:<?php echo $tekstkleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($achtergrond_kleur);?>' selected><?php echo strtoupper($achtergrond_kleur);?></option>
                 <?php   
               // ophalen kleurcodes tbv selectie
                 $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  
	         
               while($row = mysqli_fetch_array( $qry_kl1 )) {
 	             
	               echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
             	  echo "</keuze></OPTION>";	
             	 }  // end while kleur selectie achtergrond
              ?>
             </SELECT> 
			 </div>
			 </div>
			 <div class='col-3'>	
			 <input type='text' class ='btn btn-sm'  value ='tekst' disabled style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo $tekst_kleur;?>' size=1/>
 		     <input type='text' class ='btn btn-sm'  value ='link'  disabled style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo $link_kleur;?>' size=1/>
 		     <input type='text' class ='btn btn-sm'  value ='kop'   disabled style = 'background-color:<?php echo $achtergrond_kleur;?>;color:<?php echo $koptekst_kleur;?>' size=1/>
 
	      </div>
		  
    </div><!--- row-->	  
	 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Tekst kleur</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  
			
		   	<SELECT  class="custom-select custom-select-sm mb-2 form-select w-50"  name='tekst_kleur' STYLE='font-size:1.4vh;;color:<?php echo $tekstkleur;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox11" onchange="changeFunc11();">
        		<option style='color:<?php echo $tekstkleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($tekst_kleur);?>' selected><?php echo strtoupper($tekst_kleur);?></option>
  	       	  <?php
  	     	// ophalen kleurcodes tbv selectie
                $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  
        
                    while($row = mysqli_fetch_array( $qry_kl1 )) {
                     echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'>".strtoupper($row['Kleurcode'])."";
             	     echo "</OPTION>";	
           	 }  // end while kleur selectie achtergrond
            ?>
       </SELECT> 
	   </div>
	   </div>
	    <div class='col-3'>	
	       <input type='text' class ='btn btn-sm'  disabled style = 'background-color:<?php echo $tekst_kleur;?>' size=1/>
  	  </div>
	</div><!--- row-->	
	  
	 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Link kleur</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  	
		 
			  <SELECT class="custom-select custom-select-sm mb-2 form-select w-50" name='link_kleur' STYLE='font-size:1.4vh;color:<?php echo $link_kleur;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox12" onchange="changeFunc12();">
         		<option style='color:<?php echo $link_kleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($link_kleur);?>' selected><?php echo strtoupper($link_kleur);?></option>
        		<?php
        		// ophalen kleurcodes tbv selectie
              $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  
        
              while($row = mysqli_fetch_array( $qry_kl1 )) {
         	    
        	      echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
            	  echo "</keuze></OPTION>";	
            	 }  // end while kleur selectie achtergrond
             ?>
            </SELECT> 
			 </SELECT> 
	   </div>
	   </div>
	    <div class='col-3'>	
			 <input type='text' class ='btn btn-sm'  disabled style = 'background-color:<?php echo $link_kleur;?>' size=1/>
 	  </div>
  </div><!--- row-->	

 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Koptekst kleur</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  	
            <SELECT class="custom-select custom-select-sm mb-2 form-select w-50" name='koptekst_kleur' STYLE='font-size:10pt;color:<?php echo $koptekst_kleur;?>;background-color:<?php echo $achtergrond_kleur;?>;font-family: Courier;width:90px;'  id="selectBox13" onchange="changeFunc13();">
   	       	<option style='color:<?php echo $koptekst_kleur;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($koptekst_kleur);?>' selected><?php echo strtoupper($koptekst_kleur);?></option>
	        	<?php
	        	// ophalen kleurcodes tbv selectie
              $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  
          
              while($row = mysqli_fetch_array( $qry_kl1 )) {
  	           
	              echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
            	  echo "</keuze></OPTION>";	
            	 }  // end while kleur selectie achtergrond
             ?>
            </SELECT>
			  </div>
	   </div>
	    <div class='col-3'>	
			 <input type='text' class ='btn btn-sm'  disabled style = 'background-color:<?php echo $koptekst_kleur;?>' size=1/>
 	  </div>
  </div><!--- row-->	
 
 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Koptekst font</b></label> 
		  </div>
		  <div class='col-4'>	
            <div class="form-group">  
	   		<SELECT class="custom-select custom-select-sm mb-2 form-select w-75" name='font_koptekst' STYLE='font-size:1.4vh;font-family: Courier;background-color:white;?>'  id="selectBox5" onchange="changeFunc5();">
            <?php
			/// Ophalen fonts nodig voor configuratie item font_koptekst
            $sql        = "SELECT * from fonts        order by Font_family  ";
            $fonts      = mysqli_query($con,$sql);
            ?>
           <option value='<?php echo $font_koptekst;?>' selected><?php echo $font_koptekst;?></option>
           <?php
              $i=0; 
               while($row = mysqli_fetch_array( $fonts )) {
  	              	echo "<OPTION  value='".$row['Font_family']."'>";
                  echo $row['Font_family'];
                  echo "</OPTION>";	
                 $i++;
                } 
          ?>
             </select>
            </div>		
           </div>	 
           <div class='col-2'>	 			 
          <p style='font-family:<?php echo $font_koptekst;?>;font-size:1.5vh;text-align:center;'>Voorbeeld</p>			 

	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Achtergrond kleur invulvelden</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  	
 		   		<SELECT class="custom-select custom-select-sm mb-2 form-select w-50" name='achtergrond_kleur_invulvelden' STYLE='font-size:1.4vh;font-family: Courier;background-color:<?php echo $achtergrond_kleur_invulvelden;?>'  id="selectBox3" onchange="changeFunc3();">
  	     	   <option style='color:<?php echo $tekstkleur;?>;background-color:<?php echo $achtergrond_kleur_input;?>' value='<?php echo strtoupper($achtergrond_kleur_input);?>' selected><?php echo strtoupper($achtergrond_kleur_invulvelden);?></option>
             <?php
                 // ophalen kleurcodes tbv selectie
                $qry_kl1  = mysqli_query($con,"SELECT * From kleuren group by Kleurcode order by Kleurcode ")     or die(' Fout in select');  
            
                while($row = mysqli_fetch_array( $qry_kl1 )) {
  	             
	                echo "<OPTION style='color:".$row['Tekstkleur'].";background:".$row['Kleurcode'].";'  value='".strtoupper($row['Kleurcode'])."'><keuze>".strtoupper($row['Kleurcode'])."";
              	  echo "</keuze></OPTION>";	
              	 }  // end while kleur selectie achtergrond
               ?>
              </SELECT> 
			 </div>
	   </div>
	    <div class='col-3'>	
	   <input type='text' class ='btn btn-sm'  disabled style = 'background-color:<?php echo $achtergrond_kleur_invulvelden;?>' size=1/>
	  </div>
  </div><!--- row-->	
  
  <div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Achtergrondkleur knop 'VERZENDEN'</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group">  	
	 
	      	 <?php
	      	 $achtergrond_kleur_button = explode (';', $achtergrond_kleur_buttons);
               $achtergrond_kleur_verzenden   =  $achtergrond_kleur_button[0];
               $tekstkleur_verzenden          =  $achtergrond_kleur_button[1];
               $achtergrond_kleur_herstellen  =  $achtergrond_kleur_button[2];
               $tekstkleur_herstellen         =  $achtergrond_kleur_button[3];
	      	 ?>
			   		<SELECT class="custom-select custom-select-sm mb-2 form-select w-50" name='kleur_verzenden' STYLE='font-size:1.4vh;font-family: Courier;background-color:white;?>'  id="selectBox4" onchange="changeFunc4();">
   	                 <option style='color:<?php echo $tekstkleur_verzenden;?>;background:<?php echo $achtergrond_kleur;?>'  value='<?php echo strtoupper($achtergrond_kleur_verzenden ).";".strtoupper($tekstkleur_verzenden );?>' selected><?php echo strtoupper($achtergrond_kleur_verzenden);?></option>
                     <option style='color:black;background:#FFFFFF;' value='#FFFFFF;#000000' >#FFFFFF</option>
                     <option style='color:black;background:#CCCCFF;' value='#CCCCFF;#000000' >#CCCCFF</option>
                     <option style='color:black;background:#B1B3D9;' value='#B1B3D9;#000000' >#B1B3D9</option>
                     <option style='color:white;background:#162A51;' value='#162A51;#FFFFFF' >#162A51</option>
                     <option style='color:white;background:#CC0000;' value='#CC0000;#FFFFFF' >#CC0000</option>
                     <option style='color:black;background:#BDBDBD;' value='#BDBDBD;#000000' >#BDBDBD</option>
                     <option style='color:black;background:#E5E5E5;' value='#E5E5E5;#000000' >#E5E5E5</option>
                     <option style='color:white;background:#0000FF;' value='#0000FF;#FFFFFF' >#0000FF</option> 
                 </SELECT> 
    		 </div>
	   </div>
	    <div class='col-3'>	
         <input type='tekst' disabled class ='btn btn-sm' style= 'text-align:center;color:<?php echo $tekstkleur_verzenden;?>;background-color:<?php echo $achtergrond_kleur_verzenden;?>;'   id ='Verzenden'  value ='Verzenden'>
	  </div>
  </div><!--- row-->	
  
   	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Achtergrondkleur knop 'HERSTELLEN'</b></label>
		  </div>
		  <div class='col-3'>	
            <div class="form-group"> 
		   		<SELECT class="custom-select custom-select-sm mb-2 form-select w-50" name='kleur_herstellen' STYLE='font-size:1.4vh;font-family: Courier;background-color:white;?>'  id="selectBox5" onchange="changeFunc5();">
  			
   	  <!--SELECT  class="custom-select custom-select-sm mb-2 form-select w-50' name='kleur_herstellen' STYLE='font-size:1.4vh;background-color:white;font-family: Courier;'  id="selectBox5" onchange="changeFunc5();"-->
  	  	   <option style='color:<?php echo $tekstkleur_herstellen;?>;background:<?php echo $achtergrond_kleur;?>' value='<?php echo strtoupper($achtergrond_kleur_herstellen).";".strtoupper($tekstkleur_herstellen);?>' selected><?php echo strtoupper($achtergrond_kleur_herstellen);?></option>
           <option style='color:black;background:#FFFFFF;' value='#FFFFFF;#000000' >#FFFFFF</option>
           <option style='color:black;background:#CCCCFF;' value='#CCCCFF;#000000' >#CCCCFF</option>
           <option style='color:black;background:#B1B3D9;' value='#B1B3D9;#000000' >#B1B3D9</option>
           <option style='color:white;background:#162A51;' value='#162A51;#FFFFFF' >#162A51</option>
           <option style='color:white;background:#CC0000;' value='#CC0000;#FFFFFF' >#CC0000</option>
           <option style='color:black;background:#BDBDBD;' value='#BDBDBD;#000000' >#BDBDBD</option>
           <option style='color:black;background:#E5E5E5;' value='#E5E5E5;#000000' >#E5E5E5</option>
           <option style='color:white;background:#0000FF;' value='#0000FF;#FFFFFF' >#0000FF</option>  
      </SELECT> 
 		 </div>
	   </div>
	    <div class='col-3'>	
      <input type='text' disabled class ='btn btn-sm'  style= 'text-align:center;color:<?php echo $tekstkleur_herstellen;?>;background-color:<?php echo $achtergrond_kleur_herstellen;?>;'   id ='Herstellen' value ='Herstellen'>
  </div>
  </div><!--- row-->	
	<br>

<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Boulemaatje gezocht op formulier</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			   <select  name ='boulemaatje_gezocht_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($boulemaatje_gezocht_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra koptekst</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			    <input type="text"     name ='extra_koptekst'    class="form-control"  placeholder='tekst voor extra kopregel'  value='<?php echo $extra_koptekst;?>'>
		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Positie extra kopregel</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	<?php
                /// Eerste positie geeft aan of de extra tekst op de volgende regel moet
               /// % = met. (oude situatie)
     		   $parameters = haal_parameters($vereniging_id, $toernooi,'extra_koptekst');
       
               $parameter    = explode('#', $parameters);
               $text_effect  = $parameter[1];
                  
               /// Laatste positie geeft aan of de lichtkrant aan moet
               /// #m = met  , #z = zonder
               /// Als marquee is aan, dan wordt new line ongedaan gemaakt. Oude situatie

               /// Nieuwe situatie 
               /// Laatste positie geeft tekst effect aan 
               /// #n = newline  , #m = marquee , #z = zonder
               /// vanaf 11-10-2013 via parameter
               
               $new_line      =  substr($extra_koptekst,0,1);
               $_text_effect  =  substr($extra_koptekst,-2);
            
               /// conversie van oud naar nieuw
               if ($new_line == '%'){ 
                   $text_effect  =  'n';
               }
                                            
               if ($new_line == '%' ){
               	$extra_koptekst = substr($extra_koptekst,1,strlen($extra_koptekst));
               } 
              
              
              if ($_text_effect != '#m' and $_text_effect != '#z' and $_text_effect != '#n'){
                $extra_koptekst = $extra_koptekst;
        //       	$text_effect    = 'z';
               } 
               else { 
               	$extra_koptekst = substr($extra_koptekst,0,strlen($extra_koptekst)-2);
                }
              ?>
			   <select  name ='text_effect'  width=3 class="custom-select custom-select-sm mb-3 form-select"    >
			     <?php
				 switch($text_effect){
					 case 'n' : 
					  	    echo "<option  value = '#n' selected/>Op nieuwe regel ";
               	            echo "<option  value = '#m' />Als lichtkrant";  	
               	            echo "<option  value = '#z' />Geen van beiden";  
                            break;	
                     case 'm' : 
        	                echo "<option  value = '#n' />Op nieuwe regel ";
               	            echo "<option  value = '#m' selected/>Als lichtkrant";  	
               	            echo "<option  value = '#z' />Geen van beiden"; 
                            break;	
                      default:	
            	            echo "<option  value = '#n' />Op nieuwe regel ";
               	            echo "<option  value = '#m' />Als lichtkrant";  	
               	            echo "<option  value = '#z' selected/>Geen van beiden";  	
                            break;					
				  } // end switch
             	
             	?>
				</select>
		  </div>
	      </div>
	</div><!--- row--->
	
  <div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra invulveld vrije tekst</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			
			    <input type="text"     name ='extra_invulveld'    class="form-control"  placeholder='tekst voor extra invulveld'  value='<?php echo $extra_invulveld;?>'>
		  </div>
	 </div>
	</div><!--- row--->

<?php
if ($extra_invulveld !=''){?>	
 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra invulveld verplicht?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			<?php
			  $parameters = haal_parameters($vereniging_id, $toernooi,'extra_invulveld');
    
                 if ($parameters  !='') {
                 $keuze     = explode('#',$parameters );
                 $verplicht_jn  = $keuze[1];
                 $lijst_jn      = $keuze[2];
                 }
                else {
                	$verplicht_jn  = 'N';
                    $lijst_jn      = 'N';
                }
                ?>
			   <select  name ='verplicht_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($verplicht_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->

<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra invulveld zichtbaar op lijsten</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			<?php
			  $parameters = haal_parameters($vereniging_id, $toernooi,'extra_invulveld');
    
                 if ($parameters  !='') {
                 $keuze     = explode('#',$parameters );
                 $verplicht_jn  = $keuze[1];
                 $lijst_jn      = $keuze[2];
                 }
                else {
                	$verplicht_jn  = 'N';
                    $lijst_jn      = 'N';
                }
                ?>
			   <select  name ='lijst_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($lijst_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
<?php } ?>

 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra invulveld vraag met antwoord selecties</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			    <input type="text"     name ='extra_vraag'    class="form-control"  placeholder='tekst voor extra vraag en antwoorden, gescheiden door ;'  value='<?php echo $extra_invulvraag;?>'>
                <em style='font-size:1.2vh;'>Dit is altijd een verplicht veld. Vul in als 'Vraag;antwoord 1;antwoord 2;antwoord 3 (max 5 antwoorden)' * bij standaard keuze</em>
		  </div>
	 </div>
	</div><!--- row--->
<?php
if ($extra_invulveld !=''){?>	
<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Extra vraag zichtbaar op lijsten</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			<?php
			  $parameters = haal_parameters($vereniging_id, $toernooi,'extra_vraag');
    
                 if ($parameters  !='') {
                 $keuze     = explode('#',$parameters );
                   $lijst_jn      = $keuze[2];
                 }
                else {
                  $lijst_jn      = 'N';
                }
                ?>
			   <select  name ='op_lijst_2_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($lijst_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
<?php } ?>

<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Deelnemerslijst zichtbaar ?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	 
			   <select  name ='link_lijst_zichtbaar_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($link_lijst_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
 <div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Link website zichtbaar ?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	 
			   <select  name ='website_link_zichtbaar_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($website_link_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Toernooi selectie zichtbaar in koptekst ?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	 
			   <select  name ='toernooi_selectie_zichtbaar_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($toernooi_selectie_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Vereniging selectie zichtbaar   ?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	 
			   <select  name ='vereniging_selectie_zichtbaar_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($vereniging_selectie_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Gebruik alternatief logo bestand</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	          <select name='url_logo' class="custom-select custom-select-sm mb-3 form-select" STYLE='Courier; ;'>
          	   <option value='<?php echo $_url_logo; ?>' selected><?php echo $_url_logo; ?></option>
               <option value='' >Normaal logobestand</option>	
  	
               	<?php
              $dir = "images";
			    	
           // Maak een gesorteerde lijst van images  
               $images= array();
			   if ($handle = @opendir($dir)) {
                  while (false !== ($images[] = @readdir($handle))); 
                  sort($images);
                  closedir($handle);
           }// end if handle 
              
			 foreach ($images as $file){
			 
                     $ext ='';
                       if (strpos($file,".")){      
                         $name = explode(".",$file);
                         $ext  = $name[1];
                        }
                
                      
                      if (strlen($file) > 3    and (strtoupper($ext) == 'JPG'  or strtoupper($ext) == 'GIF' or strtoupper($ext) == 'PNG')) {
                         ?>  
                              <option value='<?php echo $file; ?>' ><?php echo $file; ?></option>
                      <?php
                        }
               	          
                      }// end foreach
              
               ?>	
               	</SELECT>

		  </div>
	 </div>
	</div><!--- row--->
	
	<div class= 'row'> 	
	   <div class='col-6'>	  
         <label for="exampleInputEmail1"><b>Grootte  alt logo in pixels</b></label>
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
			   <input type="number"  name ='grootte_logo'  class="form-control" placeholder='aantal pixels' value='<?php echo $grootte_logo;?>'>
 	  </div>
	 </div>
	 </div><!--- row-->
	
<div class= 'row'> 	
	   <div class='col-6'>	  
         <label ><b>Logo zichtbaar   ?</b></label> 
		  </div>
		  <div class='col-6'>	
            <div class="form-group">  
	 
			   <select  name ='logo_zichtbaar_jn'   class="custom-select custom-select-sm mb-3 form-select"  >
        <?php
	     switch($logo_zichtbaar_jn){
  	         	case "J":
  	          	        echo "<option value = 'J'  selected/> Ja ";
  	                    echo "<option value = 'N'        /> Nee ";break;
  	            default:
  	          	        echo "<option value = 'J'  /> Ja ";
  	                    echo "<option value = 'N'  selected      /> Nee ";break;
		 }// end switch
 		 ?>
		 </select>
		  </div>
	 </div>
	</div><!--- row--->
	
  </div> <!-- card body--->
  	<div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
		     <td style ='font-size:1.0vh;text-align:left;'><i class="fas fa-sync"></i> Laatste synchronisatie: <?php echo $sync_time;?>
  
			 </td>
            <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden <i style='font-size:1.6vh;' class='fa fa-paper-plane'></i></button>	
			 </td>
          </tr>
     </table>
     </form>	
	

	</div>
  </div> <!--- card ---->
	 
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

$('#sandbox-container .input-group.date').datepicker({
    calendarWeeks: true,
    todayHighlight: true
});

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-switch/highlight.js"></script>
    <script src="js/bootstrap-switch/bootstrap-switch.js"></script>
    <script src="js/bootstrap-switch/main.js"></script>
