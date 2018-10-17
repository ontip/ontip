<fieldset  style = 'border:1pt inset; '> 
		
 <?php if ( $aantal_toernooien > 0 ) {?>

<FORM action='select_toernooi.php' method='post' name="myForm">
 
 <?php
 // om terug te keren op de index pagina
    $pageName = 'index1.php';
   ?>
  <input type= 'hidden' name ='Toernooi'> 
  <input type= 'hidden' name ='Url' value = '<?php echo $pageName; ?>'> 

<div class="styled-select" >
 	
     <?php
       $i=0;
       // Indien er maar 1 toernooi is, wordt geen selectielijst getoond
      if ($aantal_toernooien == 1 ) {
      ?>
      <input type= 'hidden' name ='Toernooi' value = '<?php echo $toernooi;?>'>
      <table>
      	<tr>
      <td style='font-weight:bold;padding-right:15pt;font-size:12pt;'> Geselecteerd toernooi : </td>
      <td style= 'display:block;background-color:white;border: 4pt solid black;width:850px;color:blue;padding:2pt;font-size:10pt;' width=800px><?php echo substr($datum,0,10)." > ".$toernooi_voluit." (".$toernooi.")";?></td>
    </tr>
  </table>
  
 <?php	}   

  if ($aantal_toernooien > 1 ) { ?>

<table>
      	<tr>
 <td style='font-weight:bold;padding-right:15pt;font-size:12pt;vertical-align:top;'>Selecteer een toernooi<br><span style='padding-right:15pt;font-size:11pt;vertical-align:top;'>en klik op Ophalen</span></td>&nbsp&nbsp
 	<td><SELECT name='Toernooi' STYLE='font-size:12pt;background-color:white;font-family: Courier;width:850px;vertical-align:top;'  id="selectBox" onchange="changeFunc();" size= 7 >
  <?php
      echo "<OPTION style= 'color:blue;font-weight:bold;' value='".$toernooi."' > ".substr($datum,0,10)." > ".$toernooi_voluit. " (".$toernooi.") </option>";           
      
        while($row = mysql_fetch_array( $toernooien )) {
  	           $var = substr($row['Datum'],0,10);
 	           
 	           if ($today > $var){
 	           	 $color = 'red';
 	           	 $char  = '-'; 
 	           } else {
  	           	$color = 'black';
	           	 $char  = '*'; 
           	}

 	          if (isset($toernooi) and $toernooi == $row['Toernooi']){
 	           	$color = 'blue';
           	 $char  = '>'; 
           	}
 	           
 	       if ($toernooi !=  $row['Toernooi'] ){     
             echo "<OPTION style= 'color:".$color.";' value='".$row['Toernooi']."' >";
     	       echo $var . " ".$char." ". $row['Waarde']. "  (".$row['Toernooi'].") ";
            echo "</OPTION>";	
    	 } 
    	  
    	  
    	  $i++;
       }  // end while toernooien
       
     ?>
    </SELECT> 
   <?php 
     if ($aantal_toernooien > 1) {?>
     	     <INPUT style ='font-size:14pt;color;darkblue;font-weight:bold;font-famlily:verdana;border:1px solid #000000;box-shadow: 5px 5px 5px #888888;
            -moz-border-radius-topleft: 5px;
            -webkit-border-top-left-radius: 5px;
            -moz-border-radius-topright: 5px;
            -webkit-border-top-right-radius: 5px;
            -moz-border-radius-bottomleft: 5px;
            -webkit-border-bottom-left-radius: 5px;
	          -moz-border-radius-bottomright: 5px;
            -webkit-border-bottom-right-radius: 5px;padding:5pt;' type='submit' value='Ophalen'>
             <?php } ?> 	
         </td>
       </tr>
     </table>    
                   
    <?php
 
}
?>

</form>


	<?php }  ?>

  <!---//// Nog geen toernooien bekend ------------------------------------------------------------------------------//////---->  
	
	<?php if ( $aantal_toernooien == 0 ) {   ?>		
				
   <h2 style ='font-size:11pt;color;red;font-weight:bold;'>Er zijn nog geen toernooien bekend voor <?php echo $vereniging;?></h2><br>
				
		
		
   <?php } ?>


 </fieldset> 

