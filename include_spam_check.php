<?php

include('versleutel_string.php');
	///////////   Anti spam routine ////////////////////////////////////////////////////////////////////////////////////////
	$length = 4; 
	  if( !isset($string )) { $string = '' ; }
    $characters = "12345678901234567890";
 
    while ( strlen($string) < $length) { 
        $string .= $characters[mt_rand(1, strlen($characters))];
    }
    ?>
 
   <input type='hidden' name='challenge'    value='<?php echo versleutel_string('@##'.$string); ?>' /> 
   
   <div class= 'row'>	
	  <div class='col-6'>	
	     <label for="exampleInputEmail1"><b><i class="fas fa-robot"></i> Ik ben geen robot</b></label>
	  </div>
         <div class='col-3'> 
	  <div class="form-group">
           <input TYPE="TEXT" NAME="respons" SIZE="4"  required    class="form-control" placeholder="code uit grijs vlak overnemen"  >
             <span class="invalid-feedback">Geen code ingevuld</span>
			 </div>
        </div>
		   <div class='col-3'>
		     <div style= 'font-size:14pt; color:black;background-color:lightgrey;width:55pt;text-align:center;font-family:courier;'><?php echo $string;?></div>
		    </div>
	  </div> <!-- row-->
	  