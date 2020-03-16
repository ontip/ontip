<?php
function convert_num_to_alpha($num)
{
	$kol =  chr(64+$num);
	
	if ($num > 26){
    	  $kol = 'A'.chr(64+($num-26));
      }
    
  if ($num > 52){
     	  $kol = 'B'.chr(64+($num-52));
     }
    
  if ($num > 78){
     	  $kol = 'C'.chr(64+($num-78));
     }
    
  if ($num > 104){
     	  $kol = 'D'.chr(64+($num-104));
    } 
    
  if ($num > 130){
     	  $kol = 'E'.chr(64+($num-130));
    } 
    
  if ($num > 156){
     	  $kol = 'F'.chr(64+($num-156));
    } 
    
  if ($num > 182){
     	  $kol = 'G'.chr(64+($num-182));
    }
  
  if ($num > 208){
     	  $kol = 'H'.chr(64+($num-208));
    }
    
  if ($num > 234){
     	  $kol = 'I'.chr(64+($num-234));
    }
  
  if ($num > 260){
     	  $kol = 'J'.chr(64+($num-260));
    }
   
    return $kol;
}
 ?>