<div style= 'background-image:url("../ontip/images/OnTip_banner_green_fade.jpg");height:85pt;vertical-align:middle;border:0px solid #000000;position:relative;top:-10px;margin-left:5pt;margin-right:5pt;
	 -moz-border-radius-topleft: 10px;
   -webkit-border-top-left-radius: 10px;
   -moz-border-radius-topright: 10px;
   -webkit-border-top-right-radius: 10px;
   -moz-border-radius-bottomleft: 10px;
   -webkit-border-bottom-left-radius: 10px;
	 -moz-border-radius-bottomright: 10px;
   -webkit-border-bottom-right-radius: 10px;' cellpadding=0 cellspacing=0'> 
 
 <blockquote>
 	<br>
 	
<?php
 $size = getimagesize ($url_logo); 
 $logo_width  = $size[0];
 $logo_height = $size[1];  	
 
 // ongeveer uitkomen op 30 px voor height
$calc        = ($logo_width / 30) ;
$logo_width  = 30;
$logo_height = ( $logo_height / $calc) ;
 
 
 if ($logo_height < 15){
 	   $logo_height = $logo_height * 1.5;
 	   $logo_width =  $logo_width * 1.5;
 	 }
 	
 /*	/ 
$sql         = mysqli_query($con,"SELECT Toernooi FROM namen WHERE  IP_adres = '".$ip."' and  Vereniging_id = ".$vereniging_id." and Aangelogd ='J'  ") or die(' Fout in select toernooi');  
$result      = mysqli_fetch_array( $sql );
$toernooi    = $result['Toernooi'];
*/


if ($toernooi == '' and isset($_COOKIE['toernooi'])){
	$toernoi = $_COOKIE['toernooi'];
}

if ($toernooi == '' and isset($_GET['toernooi'])){
	$toernoi = $_COOKIE['toernooi'];
}


 ?> 	   
	<table width=95% border =0 >
   <tr>
   	
    	<td width= <?php echo $logo_width ; ?> pt  STYLE ='text-align:center;vertical-align:top;' ><img src="<?php echo $url_logo; ?>" width='<?php echo $logo_width ; ?>' height='<?php echo $logo_height ; ?>' border =0 ></td>
   		<td width= 30% STYLE ='font-size:14pt; ;color:black;text-align:left;color:yellow;font-weight:bold;vertical-align:top;' ><?php echo $_vereniging;?></td>
   		
       <?php
        if (isset($toernooi) and $toernooi !=''){
       	$sql      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'datum' ")     or die(' Fout in select');  
        $result   = mysqli_fetch_array( $sql );
        $datum    = $result['Waarde'];
        
         $dag   = 	substr ($datum , 8,2); 
         $maand = 	substr ($datum , 5,2); 
         $jaar  = 	substr ($datum , 0,4); 
         
         $now       = date ('Y-m-d H:i');
         
         // Definieer variabelen en vul ze met waarde uit tabel config
        
        $sql      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'toernooi_voluit' ")     or die(' Fout in select');  
        $result   = mysqli_fetch_array( $sql );
        $toernooi_voluit    = $result['Waarde'];
        $sql      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' and Variabele = 'toernooi_zichtbaar_op_kalender_jn' ")     or die(' Fout in select');  
        $result   = mysqli_fetch_array( $sql );
        $toernooi_zichtbaar_op_kalender_jn   = $result['Waarde'];
               
         $variabele = 'einde_inschrijving';
         $qry1      = mysqli_query($con,"SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."'  and Variabele = '".$variabele ."'")     or die(' Fout in select');  
         $result    = mysqli_fetch_array( $qry1);
         $einde_inschrijving =  $result['Waarde'];
         
      ?>
          	
       		<?php  		if ($toernooi_voluit !=''){  ?>	
       		
       		  <?php if (isset($toernooi_zichtbaar_op_kalender_jn)  and $toernooi_zichtbaar_op_kalender_jn  !='J') { ?>
          	<td width= 30% STYLE ='border-style:ridge;border-style:groove;border:inset 3pt orange;font-size:15pt;vertical-align:middle; background-color:#cccccc;color:black;text-align:left;font-weight:bold;' >
          <?php } else { ?>
          	<td width= 30% STYLE ='border-style:ridge;border-style:groove;border:inset 3pt orange;font-size:15pt;vertical-align:middle; background-color:#F3F781;color:black;text-align:left;font-weight:bold;' >
          <?php } ?>
          	
          		<?php echo $toernooi_voluit;?><br>  
          				<span style='font-size:12pt;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) ) ; ?></span>
     	   		</td>
     		<?php } ?>		
       <?php } ?>
  <td  style='color:white;font-size 9pt;font-style:italic;font-weight:bold'>Selectie ander toernooi via het Tab blad 'Start'<br>Standaard wordt de laatst gebruikte geselecteerd.
  	  <?php if (isset($toernooi_zichtbaar_op_kalender_jn)  and $toernooi_zichtbaar_op_kalender_jn  !='J') { ?>
  	             <span style = 'color:yellow;'><br>Dit toernooi is niet zichtbaar op de kalender.</span>
  	  <?php } ?>
  	  
  	  
  	</td>
  <td  WIDTH=240pt style='text-align:center;vertical-align :middle;color:white;font-family:Cooper black;font-size:10pt;;'>	
    <div id = 'rotate'  style='border:2pt solid #A9BCF5;padding:2pt;box-shadow: 3px 3px 3px #d8f6ce;position:relative;background-color:blue;'>
    <?php
   
 if ($datum > $today and $begin_inschrijving <= $today and $now < $einde_inschrijving  ){?>
  	Dit toernooi is open voor inschrijving.
  
  	<?php } else { ?>
     <?php if ($now > $einde_inschrijving  ){ ?>
    	      Er kan vanaf <br><font color = yellow> <?php echo $einde_inschrijving; ?></font> <br>niet meer worden ingeschreven voor dit toernooi.
         <?php } else { ?>
  	        Dit toernooi is vanaf<br><font color = yellow> <?php echo $begin_inschrijving; ?></font> <br>geopend voor inschrijving.
  <?php }}  ?>
  </td></tr>
  	
</table>
</div>
