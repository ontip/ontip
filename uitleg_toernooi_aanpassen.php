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
 
	

?>

<html>
 <head>
 <meta charset="utf-8">
 <title>OnTip - toernooi aanpassen <?php echo $toernooi;?></title>
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
  p.koptekst,td.uitleg, a.koptekst, label, div.uitleg,span.uitleg {
    font-size: 1.4vh;
	color:black;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  p.koptekst,td.uitleg, div.uitleg,span.uitleg, label {
    font-size: 1.6vh;
	color:black;
  }
}


/* If the screen size is 601px wide or more, set the font-size of <class> to 1.4 */
@media screen and (min-width: 601px) {
  span.keuze  {
	font-family:arial;
	font-weight:bold;
    font-size: 1.4vh;
	color:blue;
  }
}

/* If the screen size is 600px wide or less, set the font-size of <class> to 1.6 */
@media screen and (max-width: 600px) {
  span.keuze  {
	font-family:arial;
	font-weight:bold;
    font-size: 1.6vh;
	color:blue;
  }
}




</style>
 

 </head>

<body >
 
 <?php
include('include_navbar.php') ;
 
?>


<br>
<div class= 'container'   >
 
	
 <div class= 'card w-100'>
  <div class= 'card card-header'>
   <h4><i class="fas fa-chalkboard-teacher"></i></i> UITLEG - TOERNOOI AANPASSEN</h4>
   </div>
  	
    <div class= 'card card-body'>
	
	 <table class='table table-hovered table-striped w-100'>
	  <thead>
	  <tr>
	    <th width=25%>Onderwerp</th>
		<th>Uitleg</th>
	  </tr>
	  <tbody>
	   <tr>
	   <th>Systeem naam toernooi</th>
	   <td class='uitleg'>Dit is de naam die OnTip intern gebruikt om de gegevens van een toernooi (incl inschrijvingen) mee op te slaan. Deze naam wordt aangemaakt bij het toevoegen van een toernooi en kan niet gewijzigd worden.
	    </td>
		</tr>
	   <tr>
	   <th>Naam toernooi op scherm en lijsten</th>
	   <td class='uitleg'><span class='keuze'>Vrije tekst</span>. Deze naam kan willekeurig gekozen worden door de OnTip beheerder van de vereniging. Deze naam wordt getoond op het inschrijf formulier ,de deelnemerslijsten en Excel exports.
	   </td>
	   </tr> 
	   <tr>
	   <th>Toernooi gaat door</th>
	   <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee</span>. Hier kan aangegeven worden of het toernooi wel of niet doorgaat. Indien het toernooi niet doorgaat, wordt de mogelijkheid tot inschrijven geblokkeerd.
	   </tr>   
         <tr>	   
	   <th>Reden voor niet doorgaan</th>
	   <td class='uitleg'><span class='keuze'>Vrije tekst.</span>. Indien het toernooi niet doorgaat, kan hier een reden opgegeven worden, die ook op het inschrijf formulier getoond wordt.
	     </td>
		 </tr>  
		 <tr>
	    <th>Meerdaags toernooi</th>
	    <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee/Cyclus</span>. Hiermee kan je je inschrijven voor een toernooi dat meerdere dagen duurt. Een meerdaags toernooi heeft een begin- en een einddatum. Een cyclus is een toernooi dat uit meerdere niet aaneengesgloten dagen bestaat.
	     </td>
		 </tr>  
		<tr>
	    <th>(begin) Datum (meerdaags) toernooi</th>
	     <td class='uitleg'><span class='keuze'>Kalender invoer</span>. Door op het kalender icon te klikken kan je een datum aanklikken in de kalender. Dit is de datum van een eendaags toernooi of de begin datum van een meerdaags toernooi.
		 <br><i> Deze optie is NIET zichtbaar als er gekozen is voor een cyclus.</i>
		</td>
		</tr>     
	   	<tr>
	    <th>Eind Datum meerdaags toernooi</th>
	     <td class='uitleg'><span class='keuze'>Kalender invoer</span>. Door op het kalender icon te klikken kan je een datum aanklikken in de kalender. Dit is de eind datum van een  meerdaags toernooi.<br><i> Deze optie is alleen zichtbaar als er gekozen is voor een meerdags toernooi.</i>
		</td>
		</tr>     
	    	<tr>
	    <th>Cyclus</th>
	     <td class='uitleg'><span class='keuze'>Link</span>. Door op de link <i class="fa fa-calendar" aria-hidden="true"></i> te klikken kan je een aantal datums opgeven voor de cyclus.<br><i> Deze optie is alleen zichtbaar als er gekozen is voor een cyclus.</i>
		</td>
		</tr>    
	  <tr>
	    <th>Begin inschrijving</th>
	     <td class='uitleg'><span class='keuze'>Kalender invoer + tijd</span>. Begindatum en tijd waarop er ingeschreven worden. Voor deze tijd is het inschrijven geblokkeerd en is het toernooi ook niet zichtbaar op de OnTip kalender.
		</td>
		</tr>   
        <tr>
	    <th>Einde inschrijving</th>
	     <td class='uitleg'><span class='keuze'>Kalender invoer + tijd</span>. Einddatum en tijd tot wanneer er ingeschreven worden. Na deze tijd is het inschrijven geblokkeerd en is het toernooi ook niet zichtbaar op de OnTip kalender.
		</td>
		</tr>     
        <tr>
	    <th>Meldtijd op dag van toernooi</th>
	     <td class='uitleg'><span class='keuze'>Tijd + keuze: Voor/Vanaf</span>. Einddatum en tijd tot wanneer er ingeschreven worden. Na deze tijd is het inschrijven geblokkeerd en is het toernooi ook niet zichtbaar op de OnTip kalender.
		</td>
		</tr>
        <tr>
	    <th>Aanvang toernooi</th>
	     <td class='uitleg'><span class='keuze'>Tijd keuze:Uren en min</span>. Start tijd toernooi.
		</td>
		</tr>   
        <tr>
	    <th>Soort toernooi</th>
	     <td class='uitleg'><span class='keuze'>Keuze: tete-a-tete, doublet, triplex,4x4, kwintet, sextet</span>. Kies met hoeveel spelers je een team vormt.Het inschrijf formulier wordt hierop aangepast
		</td>
		</tr>     
        <tr>
	    <th>Inschrijven als..</th>
	     <td class='uitleg'><span class='keuze'>Keuze: Melee of team</span>. Inschrijven als individu (melee) of als team.
		</td>
		</tr>   
        <tr>
	    <th>Kosten deelname</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst + Euro teken</span>. Kosten voor deelname. Kan voorzien worden van een Euro teken.
		</td>
		</tr> 
      <tr>
	    <th>Licentie verplicht</th>
	     <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee</span>. Als een licentie verplicht is, dien je bij het inschrijven het licentie nummer te vermelden.
		</td>
		</tr>    
        <tr>
	    <th>Adres speel locatie</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst</span>. Adres waar het toernooi gespeeld wordt. Als in de tekst een ;  wordt gezet, zorgt voor een nieuwe regel in het adres.
		</td>
		</tr>    
        <tr>
	    <th>Minimum aantal spelers</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst, getal</span>. Aantal deelnemers dat minimaal moet inschrijven voordat het toernooi doorgaat.
		</td>
		</tr>
      <tr>
	    <th>Maximum aantal spelers</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst, getal</span>. Aantal deelnemers dat maximaal mag inschrijven. Reserves tellen hierbij niet mee.<br>
		          <i>Aantal moet groter zijn dan minimum aantal</i>
		</td>
		</tr> 
        <tr>
	    <th>Maximum aantal reserves</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst, getal</span>. Maximum aantal deelnemers dat op een reservelijst kan komen te staan.<br>
		  <i>Aantal moet kleiner zijn dan maximum aantal</i>
		</td>
		</tr>
         <tr>
	    <th>Email voor ontvangst inschrijvingen</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst, emailadres</span>. Email adres waarop de inschrijvingen binnen komen. 
		</td>
		</tr>	
       <tr>
	    <th>Email CC</th>
	     <td class='uitleg'><span class='keuze'>Vrije tekst, emailadres</span>. Extra Email adres waarop de inschrijvingen binnen komen. 
		</td>
		</tr>
       <tr>
	    <th>Email notificaties</th>
	     <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee</span>. Indien het toernooi vol is, kunnen er notificaties verstuurd worden naar deelnemers die zich niet konden inschrijven , maar wel interesse hebben. 
		 Als de OnTip beheerder van de vereniging inschrijvingen verwijderd, kan hij/zij aangeven dat er notificaties verstuurd moeten worden.
		</td>
		</tr>
         <tr>
	    <th>SMS bevestiging mogelijk</th>
	     <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee</span>. Indien een vereniging zich heeft aangemeld voor de SMS dienst, kunnen deelnemers een bevestiging van inschrijving ook via SMS ontvangen.<br>
		 <i>Aanvragen van SMS tegoed kan via het menu  Overig/Aanvragen SMS tegoed</i>
		</td>
		</tr>	
        <tr>
	    <th>Voorlopige bevestiging </th>
	     <td class='uitleg'><span class='keuze'>Keuze: Ja/Nee</span>. Inschrijvingen kunnen voorlopig bevestigd worden als een deelnemer bijvoorbeeld eerst nog moet betalen. Of dat er naast het OnTip formulier ook nog een papieren lijst op het prikbord gehanteerd wordt.
		  
		</td>
		</tr>				
	  </tbody>
	  </table>
	 
	
  </div> <!-- card body--->
  <div  class ='card-footer'>
	 
	<table  width=100%>
		 <tr>
		  <td width=25% style='text-align:left;'>
	     <input type="button" value="Vorige pagina" class='btn btn-sm btn-info' onclick="history.back()" /> 
         </td>
	       <td style ='font-size:1.2vh;text-align:right;'>
             <button type="submit" class="btn btn-primary">Verzenden  </button>	
			 </td>
          </tr>
     </table>
  	</div>
  </div> <!--- card ---->
</form> 
</div>  <!--  container ---->


 <!-- Footer -->
<?PHP
include('include_footer.php');
?>
<!-- Footer -->
  </body>
</html>
 