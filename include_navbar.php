<?php
$logon_option = 'disabled';
$logoff_option = 'enabled';
$href_ledenlijst   = '#';
$href_mededelingen = '#';
$href_ziekenboeg   = '#';
$href_documenten   = '#';
$href_gevraagd      = '#';
$href_registratie_boules ='#';
$href_change_password = '#';
$href_administratie = '#';
$href_contact = '#';

//include('aanlog_checki_lid.php');
$aangelogd ='N';
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


if ($aangelogd == 'J'){
	$logon_option = ' ';
	$logoff_option = 'hidden';
	//$naam = $user_naam;
	
    $href_qrcode                = 'create_qrcode_licentie.php';
    $href_select                = 'select_toernooi_stap1.php';
    $href_toernooi_aanpassen    = 'toernooi_aanpassen_stap1.php?toernooi='.$toernooi;
    $href_toernooi_toevoegen    = 'toernooi_toevoegen_stap1.php';
    $href_uitleg_toernooi_toevoegen       = 'uitleg_toernooi_toevoegen.php';
	$href_uitleg_toernooi       = 'uitleg_toernooi.php';
    $href_datum_cyclus          = 'beheer_cyclus_datums_stap1.php?toernooi='.$toernooi;
   
 
 
    $href_formulier_aanpassen   = 'formulier_aanpassen_stap1.php?toernooi='.$toernooi;
	
    $href_clubkleding   = 'clubkleding_stap1.php';
    $href_mededelingen  = 'leden_info_mededelingen.php';
    $href_ziekenboeg    = 'leden_info_ziekenboeg.php';
    $href_documenten    = 'leden_info_documenten.php';
    $href_contact       = 'contact_stap1.php';
    $href_registratie_boules ='registratie_boules.php';
 
    $href_change_password = 'change_password.php';

    
}

?>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style='background-color:#03035A;'>
 	 <a style='font-family:Contourg;font-size:4.2vh;color:yellow;' class="navbar-brand pb-2" href="index.php">ONTIP</a>
	
<!-- Collapse button -->
        <button class="navbar-toggler"  style='color:white;border:1px solid white;font-family:Contourg;' type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
               aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">MENU <?php echo $menu_indicator;?>
            <!--span class="navbar-toggler-icon"></span-->
        </button>

  <!-- Collapsible content -->
     <div class="collapse navbar-collapse" id="navbarNavDropdown">
       
       	   
        <ul class="navbar-nav " id="nav">
		
			<li class="nav-item ">
			<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn  dropdown-toggle btn-block col-sm-12 " type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Toernooi
               </button>
           
           <div class="dropdown-menu" >
  		     <a class="dropdown-item <?php echo $logon_option;?>" href="<?php echo $href_uitleg_toernooi   ;?>">Uitleg</a>
	       <a class="dropdown-item <?php echo $logon_option;?>" href="<?php echo $href_datum_cyclus  ;?>">Toernooi datum cyclus</a>
		   <div class="dropdown-divider"></div>
 		     <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_select;?>">Toernooi selectie</a>
			 <div class="dropdown-divider"></div>
		     <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_toernooi_toevoegen;?>">Toernooi toevoegen</a>
		     <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_toernooi_aanpassen;?>">Toernooi aanpassen</a>
		     <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_clubkleding;?>">Toernooi verwijderen</a>
		     <div class="dropdown-divider"></div>
		     <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_clubkleding;?>">Toernooi flyer maken</a>
	         <a class="dropdown-item disabled <?php echo $logon_option;?>" href="<?php echo $href_clubkleding;?>">Toernooi mailing </a>
	  
		   </div>
        </li>
	 
	 <li class="nav-item">
		<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled dropdown-toggle  btn-block col-sm-12" type="button" id="dropdownMenu1" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Formulier
               </button>
           <div class="dropdown-menu bg-light"  >
		     <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
			 <div class="dropdown-divider"></div>
  	     <a class="dropdown-item <?php echo $logon_option;?>" href="<?php echo $href_formulier_aanpassen;?>">Formulier aanpassen</a>
		   </div>
		  </div>   
         </li>
		  
		<li class="nav-item">
		<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled  dropdown-toggle  btn-block col-sm-12" type="button" id="dropdownMenu1" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Inschrijvingen
               </button>
           <div class="dropdown-menu bg-light"  >
		      <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
			  <div class="dropdown-divider"></div>
              <a class="dropdown-item " href="boulamis.php">Aanpassen inschrijvingen</a>
              <a class="dropdown-item " href="bestuur.php">Toevoegen inschrijvingen</a>
	          <a class="dropdown-item " href="bestuur.php">Excel import inschrijvingen</a>
     
           </div>
		  </div>   
	     </li>
		 
       <li class="nav-item">
		<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled  dropdown-toggle  btn-block col-sm-12" type="button" id="dropdownMenu1" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Vereniging
               </button>
             <div class="dropdown-menu bg-light"  >
			   <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
			   <div class="dropdown-divider"></div>
               <a class="dropdown-item " href="boulamis.php">Toevoegen beheerder</a>
             
           </div>
		  </div>   
	     </li>
      
		 <li class="nav-item ">
			<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled  dropdown-toggle btn-block col-sm-12 " type="button" id="dropdownMenu3" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Import-Export
               </button>
           
              <div class="dropdown-menu" >
			     <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
				 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="interne_competitie.php">Excel</a>
	      	    <a class="dropdown-item disabled" href="npc.php">PDF</a>
                <a class="dropdown-item disabled" href="zcc.php">QRC</a>
              </div>
		   </div>
        </li>
		 <li class="nav-item ">
			<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled  dropdown-toggle btn-block col-sm-12 " type="button" id="dropdownMenu3" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Bevestigingen
               </button>
           
              <div class="dropdown-menu" >
                <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
	      	    <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="interne_competitie.php">Aanpassen bevestigigingen</a>
	       
              </div>
		   </div>
        </li>
		 <li class="nav-item ">
			<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn disabled dropdown-toggle btn-block col-sm-12 " type="button" id="dropdownMenu3" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Reserveringen
               </button>
           
              <div class="dropdown-menu" >
			     <a class="dropdown-item" href="interne_competitie.php">Uitleg</a>
				 <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="interne_competitie.php">Aanpassen reserveringen</a>
	             </div>
		   </div>
        </li>
			 <li class="nav-item ">
			<div class="dropdown open" >
               <button style='color:yellow;font-family:verdana;font-size:1.8vh;background-color:#03035A;' class="btn  dropdown-toggle btn-block col-sm-12 " type="button" id="dropdownMenu3" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                     Overig
               </button>
           
              <div class="dropdown-menu" >
			     <a class="dropdown-item" href="uitleg_overig.php">Uitleg</a>
				 <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php  echo $href_change_password;?>">Aanpassen wachtwoord</a>
	            </div>
		   </div>
        </li>
	      
      </ul>
     <!---- einde links ----> 
	
	<!----  rechter kant ------>
	<ul class="nav navbar-nav navbar-right ml-auto " id="nav">
	  
	   
   <li class="nav-item">
          <?php echo $toernooi_select;?>
      </li>
      <li class="nav-item">
              <a style ='font-family:verdana;color:yellow;font-size:1.8vh;background-color:#03035A;' role='button' class="nav-link btn disabled  btn-block col-sm-12" href="<?php  echo $href_contact;?>"><span class='far fa-envelope mb-2'></span> Contact</a>
      </li>
	
     
	  </ul>
	  <!--- einde rechts--->
    </div> <!-- collapse--->
	 
</nav>
