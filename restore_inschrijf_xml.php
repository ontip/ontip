<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Restore inschrijf bestand</title>
<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">

<style type=text/css>
body {font-size: 8pt; font-family: Comic sans, sans-serif, Verdana; }	
td,th { text-align:left;padding:2pt;font-size:9pt;}
h2 {color:darkgreen;font-size:11pt;}
input:focus, input.sffocus { background: lightblue;cursor:underline; }
</style>

<!----// Javascript voor input focus ------------>
 <Script Language="Javascript">
 <!--
 sfFocus = function() {
    var sfEls = document.getElementsByTagName("INPUT");
    for (var i=0; i<sfEls.length; i++) {
        sfEls[i].onfocus=function() {
            this.className+=" sffocus";
        }
        sfEls[i].onblur=function() {
            this.className=this.className.replace(new RegExp(" sffocus\\b"), "");
        }
    }
}
if (window.attachEvent) window.attachEvent("onload", sfFocus);
     -->
</Script>	
	
</head>
<body>

<?php	
	
/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen
include 'mysql.php'; 
$aangelogd = 'N';

include('aanlog_check.php');	

if ($aangelogd !='J'){
?>	
<script language="javascript">
		window.location.replace("aanloggen.php");
</script>
<?php
exit;
}
?>

<table STYLE ='background-color:white;'>
<table >
   <tr><td style='background-color:white;' rowspan=2 width='280'><img src = '../ontip/images/ontip_logo.png' width='240'></td>
   	<td STYLE ='font-size: 36pt; background-color:white;color:green ;'>OnTip Restore inschrijf m.b.v XML</TD>
</TR>
</TABLE>
<hr color= red/>
<br>

<h2>Aanmaak SQL commando's tbv restore inschrijvingen toernooi m.b.v XML file</h2>

<?php

if ($rechten != "A"  and $rechten != "C"){
 echo '<script type="text/javascript">';
 echo 'window.location = "rechten.php"';
 echo '</script>'; 
}

if (!isset($_POST['xml_file']) or !isset($_GET['xml']) or !isset($_POST['action'])    ){
	?>
	 <FORM action='restore_inschrijf_xml.php?xml' method='post' name = 'myForm3'>
	
	 <table width =60%>
		<tr>
			<th  width = 50%>Naam xml file tbv restore (volledig path)</th>
			<td>	<input name= 'xml_file'   type='text' size='45' >
	  </td> 
	  <tr>
			<th  width = 50%>Update of Insert</th>
			<td>	<input style ='font-size:7pt;padding-right:25pt;' name= 'action'   type='radio' value='insert' >Insert <br>
				  <input name= 'action'   type='radio' value='update'  >Update 
	  </td>   
    </tr>
   </table>
   
   <INPUT type='submit' value='Verzenden'  name = 'myForm2' style='background-color:red;color:white;'>
  </FORM>   
  
 
<?php

?>
<div style ='margin-left:45pt;padding:5pt;'	>
<h1> XML files tbv backup en restore</h1>
<?php


echo "<table border = 1>";
echo "<tr><th>Nr</th><th>vereniging</th><th>Open</th><th>Folder</th><th>File</th><th>Size</th><th>Creation time</th></tr>";

$dir            = 'xml';
// Maak een gesorteerde lijst op naam
if ($handle = @opendir($dir)) {
    $files = array();
    while (false !== ($files[] = @readdir($handle))); 
    sort($files);
    closedir($handle);
}
$j=1; 
foreach ($files as $file) {
     	
       if (strlen($file) > 3 ){      	
          $bestand  = $dir."/".$file;
        	$filesize = 0;   
        	$filesize = filesize($bestand);
        	$last_mod = filectime($bestand);
        	
        	$part = explode('_', $file);
        	//echo $part[1];
        
        if ($part[1] <> ''){
               	
        	$qry      = mysql_query("SELECT vereniging from vereniging where Id = ".$part[1]." ")     or die(' Fout in select 1'); 
         	$result                    = mysql_fetch_array( $qry );
          $vereniging    = $result['vereniging'];
        	
 	   if ($part[0] =='ins'){
          echo "<tr><td>".$j.". </td><td>".$vereniging."</td><td><center><a href = '".$bestand."' target = '_blank'>open</a></center></td><td>".$dir."</td><td>".$file."</td><td style='text-align:right;'>".$filesize."</td><td style='text-align:right;'>".date("d-m-Y H:i:s", $last_mod)."</td></tr>";       
          $j++;
        }
       }  	
     }
}
	
 echo "</table>";
 echo "</div>";
 }  else {
 $xml_file = $_POST['xml_file'];
	
$xml_file = 'xml/'.$xml_file ;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$xml    = simplexml_load_file($xml_file) or die("Error: Cannot create object");

$sql_update  =   "";
$sql_insert  =   "";
$var_list = '';

?>

<?php

// Omzetten van Xml data in variables



// loop for inschrijvingen

 
$create_xml           = $xml->create_xml;
$vereniging           = $xml->vereniging->naam;
$vereniging_id        = $xml->vereniging->nr;
$plaats               = $xml->vereniging->plaats;

$toernooi             = $xml->toernooi->naam;
$datum                = $xml->toernooi->datum;
$soort_inschrijving   = $xml->toernooi->soort_inschrijving;
$inschrijf_methode    = $xml->toernooi->inschrijf_methode; 

 foreach($xml->inschrijvingen->inschrijving as $inschrijving) {

   // foreach($inschrijvingen as $inschrijving ) {
  	
            $naam1              = $inschrijving->personen->speler1->naam;
            $licentie1          = $inschrijving->personen->speler1->licentie;
            $vereniging1        = $inschrijving->personen->speler1->vereniging;
                         	           
            $naam2              = $inschrijving->personen->speler2->naam;
            $licentie2          = $inschrijving->personen->speler2->licentie;
            $vereniging2        = $inschrijving->personen->speler2->vereniging;         
              
            $naam3              = $inschrijving->personen->speler3->naam;
            $licentie3          = $inschrijving->personen->speler3->licentie;
            $vereniging3        = $inschrijving->personen->speler3->vereniging;
              
            $naam4              = $inschrijving->personen->speler4->naam;
            $licentie4          = $inschrijving->personen->speler4->licentie;
            $vereniging4        = $inschrijving->personen->speler4->vereniging;
            
            $naam5              = $inschrijving->personen->speler5->naam;
            $licentie5          = $inschrijving->personen->speler5->licentie;
            $vereniging5        = $inschrijving->personen->speler5->vereniging;
            
            $naam6              = $inschrijving->personen->speler6->naam;
            $licentie6          = $inschrijving->personen->speler6->licentie;
            $vereniging6        = $inschrijving->personen->speler6->vereniging;

      /// additionele inschrijf informatie  (opmerking, etc)
     
      $extra_vraag_vraag              = $inschrijving->extra_vraag->vraag;
      $extra_vraag_antwoord           = $inschrijving->extra_vraag->antwoord;
       if ($extra_vraag_vraag !=''){
		      	$extra_compl  = $extra_vraag_vraag . ";" . $extra_vraag_antwoord ;
	      }
      else {
		       $extra_compl ='';
      }

      $extra_invulveld_antwoord = $inschrijving->extra_gegevens->extra_invulveld->antwoord;
      $opmerking                = $inschrijving->extra_gegevens->opmerking;
         
      // uit contact info     
      $email                    = $inschrijving->extra_gegevens->contact_info->email;
      $telefoon                 = $inschrijving->extra_gegevens->contact_info->telefoon;
      
      // uit extra gegevens
      $adres                    = $inschrijving->extra_gegevens->adres;
      $status                   = $inschrijving->extra_gegevens->status;
      $reservering              = $inschrijving->extra_gegevens->reservering;
      $bevestiging_verzonden    = $inschrijving->extra_gegevens->bevestiging_verzonden;
      $bank_rekening            = $inschrijving->extra_gegevens->bank_rekening;
      $betaal_datum             = $inschrijving->extra_gegevens->betaal_datum;
      $meerdaags_datums         = $inschrijving->extra_gegevens->meerdaags_datums;
      $laatst                   = $inschrijving->extra_gegevens->laatst;      
    
    // echo "zz: ". $bevestiging_verzonden. "<br>";
     
     
     // opbouw commando
     //// string @#@# as eof because of explode

     $sql_insert .= "INSERT INTO inschrijf(Id, Toernooi, vereniging,vereniging_id, Datum, 
                                Naam1, licentie1, vereniging1, 
                                Naam2, licentie2, vereniging2, 
                                Naam3, licentie3, vereniging3, 
                                Naam4, licentie4, vereniging4, 
                                Naam5, licentie5, vereniging5, 
                                Naam6, licentie6, vereniging6, 
                                Telefoon,Email,   Bank_rekening,
                                Opmerkingen, Extra, Extra_invulveld, 
                                Bevestiging_verzonden, Betaal_datum,Reservering,Meerdaags_datums,
                                Status, Inschrijving)
               VALUES (0,'".$toernooi."'    , '".$vereniging ."'  , ".$vereniging_id.", '".$datum."',
                         '".$naam1."'       ,'".$licentie1."'   , '".$vereniging1."' ,
                         '".$naam2."'       ,'".$licentie2."'   , '".$vereniging2."' ,
                         '".$naam3."'       ,'".$licentie3."'   , '".$vereniging3."' ,
                         '".$naam4."'       ,'".$licentie4."'   , '".$vereniging4."' ,
                         '".$naam5."'       ,'".$licentie5."'   , '".$vereniging5."' ,
                         '".$naam6."'       ,'".$licentie6."'   , '".$vereniging6."' , 
                         '".$telefoon."'    ,'".$email."'       , '".$bank_rekening."',
                         '".$opmerking."'   ,'".$extra_compl."' , '".$extra_invulveld_antwoord."',
                         '".$bevestiging_verzonden."','".$betaal_datum."','".$reservering."','".$meerdaags_datums."','".$status."','".$laatst."'  );@#@#";
           
 //  }
}

 
?>

<blockquote>
	<table width = 40%>
		<tr>
			<th width = 60%>vereniging           :</th><td><?php echo $vereniging;?>  </td></tr>
			<th width = 60%>Plaats               :</th><td><?php echo $plaats;?>  </td></tr>
			<th width = 60%>Toernooi             :</th><td><?php echo $toernooi;?>     </td></tr>
			<th width = 60%>Soort toernooi       :</th><td><?php echo $soort_inschrijving;?>     </td></tr>
			<th width = 60%>Inschrijf methode    :</th><td><?php echo $inschrijf_methode;?>     </td></tr>
			<th width = 60%>Aanmaak xml          :</th><td><?php echo $create_xml;?>   </td></tr>
		</table>
	</blockquote>
	<br>
	<fieldset style='padding:5pt;font-family:couriew new;font-size:8pt;'><legend> Uit te voeren commandos</legend>
<?php

  $sql_line      = explode("@#@#", $sql_insert);   /// opsplitsen in aparte regels 
 $i=0;  // index vanaf 0
 $j=1;
    while ( $sql_line[$i] <> ''){    
  
    	  if (strlen($sql_line[$i]) > 2 ){
    	  	echo $sql_line[$i]."<br>";
          //////mysql_query($sql_line[$i]) or die ('Fout in insert line '.$i); 
        }
        $i++;
        $j++;
  } // while

?>
</fieldset>
<br>
<a href ='restore_inschrijf_xml.php' target='_top'>Klik hier voor opnieuw selecteren</a>
<?php

}// end if input

?>

</body>
</html>