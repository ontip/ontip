<table STYLE ='text-align:left;position:relative;top:-7px;border-collapse: collapse;margin-left:15pt;' width=90% border = 0 >
	<tr> 
		
		
		<!--// AANLOGGEN  -->

<?php

if ($aangelogd == 'J'){
	$ip_adres = $_SERVER['REMOTE_ADDR'];
	    $sql      = mysqli_query($con,"SELECT Beheerder,Naam FROM namen WHERE Vereniging_id = ".$vereniging_id." and IP_adres = '".$ip_adres."' and Aangelogd = 'J'  ") or die(' Fout in select');  
	    $result   = mysqli_fetch_array( $sql );
      $rechten  = $result['Beheerder'];         	
                
		            switch ($rechten) {
		              case "A":  $omschrijving = " Alle rechten.";
		                         break;
		              case "I":  $omschrijving = " Beheer inschrijvingen.";
		                         break;
		              case "C":  $omschrijving = " Beheer configuratie.";
		                         break;
		              case "W":  $omschrijving = " Beheer toernooi (beperkt).";
		                         break;
		           };// end switch               		
		     	           	
	      	?>
    		 
	            	<td STYLE ='font-size: 8pt;color:black;text-align:right;padding:5pt;width:140;vertical-align:top;'>
                   Aangelogd als <?php echo $result['Naam']."<br>".$omschrijving;?>
	              </td>
	              <td STYLE ='font-size: 8pt;color:black;text-align:center;padding:5pt;width:140;vertical-align:top;'>
	             	
	             	<form method = 'post' action='afloggen.php'>
	               	<input type='hidden'   name='vereniging'  value='<?php echo $vereniging;?>'  />
	                <input class="HoverBorder" style='padding:5pt;font size:12pt;color:blue;'type ='submit' value= 'Afloggen'> 
	              </form>
<?php	      }  // end if aangelogd

$dag    = substr($datum_verloop_licentie,8,2);
$maand  = substr($datum_verloop_licentie,5,2);
$jaar   = substr($datum_verloop_licentie,0,4);

$_datum_verloop = strftime("%d-%m-%Y",mktime(0,0,0,$maand,$dag,$jaar)) ;
?>
</td>
<td style= 'font-size:8pt;vertical-align:middle;font-weight:bold;font-family:verdana;'>Uw licentie verloopt:<br>
		
	
<?php echo $_datum_verloop; ?>

</td>
	<!--td style= 'font-size:8pt;'><a href='http://www.enquetemaken.be/toonenquete.php?id=258717 ' target = '_blank'><img src  ='../ontip/images/enquete.jpg' width=80 border  =0></a>
	<?php 
	if ($vereniging =='Boulamis'){?>
		
	<a href='	http://www.enquetemaken.be/results.php?id=258717target = '_blank'> - Resultaten</a>
<?php } ?>
	</td-->
	<td style='text-align:right;vertical-align:top;background-color:<?php echo $indexpagina_achtergrond_kleur; ?>;'>
		
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
 ?> 	   
 
	 <!--a  href= "<?php echo $url_website; ?>" class="old_tooltip"   title='Naar site'><img src="<?php echo $url_logo; ?>" width='<?php echo $logo_width ; ?>' height='<?php echo $logo_height ; ?>' border =0 target='_blank'></a--->
   
  <?php if ($aangelogd !='J'){ ?>
  	<a href= "aanloggen.php" class="old_tooltip"   title='Aanloggen'><img class="HoverBorder" class="HoverBorder" src='../ontip/images/logon_ico.png' border = 0 width =30 alt='Aanloggen' ></a>
 
   <?php } ?>
	   		
	
	 <?php if ($hussel_gebruiker  =='J'){ ?>
  	<a href='<?php echo $url_redirect."index_hussel.html"; ?>' class="old_tooltip"   title='Hussel'><img class="HoverBorder" src='../ontip/images/OnTip_hussel.png' border = 0 width =60 alt='Hussel' ></a>
   <?php } ?>
   
     <?php if ($rechten == 'A' or  $rechten == 'C' or $i==0){ ?>
	 <a  href= "toevoegen_toernooi_stap1.php?key=T" class="old_tooltip"  target='_self' title='Toevoegen toernooi'><img class="HoverBorder" src='../ontip/images/plus.png' border = 0 width =27 alt='Toevoegen toernooi' ></a>
  
  <a href= "index1.php" >         <img class="HoverBorder" src='../ontip/images/miniatuur.png' border = 0 width =35 alt ='' ></a>
   	<?php if(isset($toernooi) and $toernooi !=''){ 
   		
   		/*
     $qrc_link   = "images/qrc/qrcf_".$toernooi.".png";
    if (file_exists($qrc_link)) {         ?>
        <a href="<?php echo $qrc_link;?>" target='_blank' border= 0 class="old_tooltip"   title='QR code voor inschrijf formulier'><img class="HoverBorder" src='../ontip/images/qrc.png' border = 0 width = 32 alt ='' ></a>
      <?php } 
     
    $output_pdf = 'images/'.$toernooi.'.pdf';
              
    if (file_exists($output_pdf)){ ?>
        <a href="<?php echo $output_pdf;?>" target='_blank' border= 0 class="old_tooltip"   title='OnTip PDF Flyer voor toernooi'><img class="HoverBorder" src='../ontip/images/pdf_ontip_logo.gif' border = 0 width = 32 alt ='' ></a>
    <?php }
    */ ?>
        
    <a href= "Inschrijfform.php?toernooi=<?php echo $toernooi;?>"          class="old_tooltip"   title='Inschrijf formulier'><img class="HoverBorder" src='../ontip/images/icon_inschrijf.png' border = 0 width =35 alt ='' ></a>
    


	
    <?php if ($rechten == 'A' or $rechten =='I'){ ?>
  	  <a href="Inschrijfform.php?toernooi=<?php echo $toernooi; ?>&user_select=Yes"  class="old_tooltip"   title='Inschrijf formulier (eigen leden)'><img class="HoverBorder" src='../ontip/images/mensen.png' border = 0 width =35 alt ='' ></a>
	  <?php  } ?>  
	  
    <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "beheer_ontip.php?toernooi=<?php echo $toernooi;?>"          class="old_tooltip"   title='.Formulier aanpassen'><img class="HoverBorder" src='../ontip/images/Icon_tools.png' border = 0 width =35 alt ='' ></a>
	 <?php } ?>
	 
    <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "beheer_inschrijvingen.php?toernooi=<?php echo $toernooi; ?>" class="old_tooltip"   title='Muteren inschrijvingen'><img class="HoverBorder" src='../ontip/images/icon_muteer.png' border = 0 width =35 alt ='' ></a>
  <?php } ?>
	  
	  <a href= "lijst_inschrijf_kort.php?toernooi=<?php echo $toernooi; ?>&lijst_zichtbaar"  class="old_tooltip"   title='Simpele lijst'><img class="HoverBorder" src='../ontip/images/list_all_participants.png' border = 0 width = 33 alt ='' ></a>
	 
   	  
   <?php if ($rechten == 'A' or $rechten =='C'){ ?>
	  <a href= "image_gallery.php?toernooi=<?php echo $toernooi;?>" class="old_tooltip"   title='Selectie & upload afbeeldingen'><img class="HoverBorder" src='../ontip/images/gallery.jpg'  width =30 border =0 alt =''></a> 
   <?php } ?> 

  
	  <?php }  // er is nog geen toernooi bekend ?>
   
   
  <?php if ($rechten == 'A' or $rechten =='C'){ ?>
 
   <?php if ($aantal_toernooien > 0 or $count_oud_toernooi > 0){ ?>
       <a href= "select_verwijderen.php?key=V" class="old_tooltip"   title='Archiveren en verwijderen inschrijvingen'><img class="HoverBorder" src='../ontip/images/prullenbak.jpg' border = 0 width =31 ></a>
       <a href= "../ontip/stats_one.php?Id=<?php echo $vereniging_id;?>" class="old_tooltip"   title='Statistieken'><img class="HoverBorder" src='../ontip/images/grafiek_bar.jpg' border = 0 width =45  ></a>
	 <?php }?>    
  <?php  }?>    
   
   
<?php } ?>	
    <a href= "release_notes.php"          class="old_tooltip"   title='Release notes'><img class="HoverBorder" src='../ontip/images/new_release.jpg' border = 0 width =35 alt =''  ></a>
	  <!--a href="contact.php" class="old_tooltip"   title='Email naar beheer OnTip'><img src='../ontip/images/mail.jpg' width =27 border =0  alt='' ></a-->
	   <a href='../ontip/select_pdf_bestand.php' class="old_tooltip"   title='OnTip Nieuwsbrieven'><img class="HoverBorder" src='../ontip/images/pdf.gif' width =40 border =0 ></a>
    <a href='../ontip/pdf/Handleiding.pdf' class="old_tooltip"   title='Handleiding'><img class="HoverBorder" src='../ontip/images/boek.jpg' width =40 border =0 ></a>
    <!--a href= "http://www.webhelpje.be/forum/forum.php?name=Ontip" class="old_tooltip"   title='Naar OnTip forum'><img src="../ontip/images/forum.png" width=55 border =0 target='_blank'></a-->

<!--/div-->
</tr>
</table>