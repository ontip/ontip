<?php
////  aanmaak 100 voucher codes xxxx-xxxx-xxxx
////  generate_voucher_codes.php.  (c) Erik Hendrikx 2017
////
////  Programma voor het aanmaken van een xlsx bestand met 100 unieke voucher codes voor een toernooi. Dit bestand wordt verstuurd via email naar een opgegeven email adrs (default email organisatie)
////  De codes worden tevens toegevoegd aan de tabel voucher_codes
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<html>
	<head>
		<title>OnTip aanmaak Voucher codes</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="shortcut icon" type="image/x-icon" href="images/logo.ico">     
		<style type=text/css>
body { font-family:Verdana; }

a    {text-decoration:none;color:blue;font-size: 8pt}
</style>
	</head>
<body>

<?php	
// Database gegevens. 
include('mysql.php');
setlocale(LC_ALL, 'nl_NL');

/// Als eerste kontrole op laatste aanlog. Indien langer dan 2uur geleden opnieuw aanloggen

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



$toernooi = $_GET['toernooi'];
$bevestig = $_POST['bevestiging'];

$qry  = mysql_query("SELECT * From config where Vereniging = '".$vereniging ."' and Toernooi = '".$toernooi ."' ")     or die(' Fout in select mysql');  

// Definieeer variabelen en vul ze met waarde uit tabel

while($row = mysql_fetch_array( $qry )) {
	 $var = $row['Variabele'];
	 $$var = $row['Waarde'];
 }

// uit vereniging tabel	

$qry_v                    = mysql_query("SELECT * From vereniging where Vereniging = '".$vereniging ."'  ") ;  
$result_v                 = mysql_fetch_array( $qry_v);
$vereniging_id            = $result_v['Id'];
$url_logo                 = $result_v['Url_logo'];
$vereniging_output_naam   = $result_v['Vereniging_output_naam']; 	  	
 
$dag                      = substr($datum, 8,2);
$maand                    = substr($datum, 5,2);
$jaar                     = substr($datum, 0,4);  

/*-----------------------------------------------------------------------------------------------------------------//---------*/
/* Als eerste vragen om bevestiging                                                                                           */  

if (!isset($bevestig)){	?>
	
<FORM action='generate_voucher_codes.php?toernooi=<?php echo $toernooi;?>' method='post'>
 <input type='hidden' name = 'toernooi' value ='<?php echo $toernooi; ?>'  />
                                         
 <table>                                 
  <tr><td><img src= '<?php echo $url_logo;?>' width=80></td>
  <td style= 'font-family:verdana;font-size:14pt;color:blue;'><b><?php echo $toernooi_voluit;?>
 	       <br><span style= 'font-family:Ariale;font-size:14pt;color:green;'><?php echo strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) );?></span>
 	       <br><?php echo $vereniging_output_naam;?></b>
 	       </td>
 	 </tr>
 </table>
 <br><hr/>
 <br><div style= 'font-family:Verdana;font-size:12pt;color:black;'><u>Aanmaak voucher codes toernooi <?php echo $toernooi;?></u>.</div></br>
 <div style= 'font-family:Verdana;font-size:10pt;color:black;'>Door het accepteren van deze aanvraag worden eventueel al bestaande voucher codes voor dit toernooi overschreven. De bestaande codes worden dan onbruikbaar.<br>Maak een keuze door een van beide onderstaande regels te selecteren en klik op de knop :</div>
 <br>

 <div style= 'font-family:Verdana;font-size:10pt;color:black;'>
 <INPUT type='radio' NAME='bevestiging'   value = 'Ja'  />Ja, ik wil inderdaad nieuwe voucher codes aanmaken.<br>
 <span style='margin-left:15pt;'>* Email adres voor ontvangst Excel : <INPUT type='email' NAME='email'  size =30  value = '<?php echo $email_organisatie;?>' /></span>
 <br><br>
 <INPUT type='radio' NAME='bevestiging'   value = 'Nee' />Nee, ik wil geen nieuwe codes aanmaken.<br></div><br>

  <INPUT type='submit'  value = 'Verzenden keuze'/>
 </form>
<?php
exit;
}
?>

<?php
/*-----------------------------------------------------------------------------------------------------------------//---------*/
/* Als er bevestigd is                                                                                    */  
  
  if (isset($bevestig)  and $bevestig=='Ja' ){
  
  $email   = $_POST['email']; 
  $timest  = date('Ymdhis');
  $xlsx_file ="csv/voucher_codes_".$toernooi."_".$timest.".xlsx";
  // verwijder bestand indien aanwezig
  unlink($xlsx_file);
  
 // verwijder bestaande codes voor dit toernooi
 mysql_query("DELETE FROM `voucher_codes` where Toernooi ='".$toernooi."' and Vereniging_id = ".$vereniging_id." and Datum = '".$datum."'");

 // aanmaak xlsx
 /** Error reporting */
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  date_default_timezone_set('Europe/London');

  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

  /** Include PHPExcel */
  require_once dirname(__FILE__) . '../../ontip/Classes/PHPExcel.php';

  // Create new PHPExcel object
  echo date('H:i:s') , " Create new PHPExcel object" , EOL;
  $objPHPExcel = new PHPExcel();

  // Set document properties
  echo date('H:i:s') , " Set document properties" , EOL;
  $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");

  // Add header line
  echo date('H:i:s') , " Add some data" , EOL;
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nr.')
            ->setCellValue('B1', 'Voucher code')
            ->setCellValue('C1', $toernooi_voluit)
            ->setCellValue('E1', $vereniging)
            ->setCellValue('F1', 'Tijd: '.$timest);
            
   // pas breedte kolommen aan      
   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(2);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);   
   $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
             
   // add codes
   $code   ='';
   $string ='';
   $length = 4; 
   $characters = "23456789ABCDEFGKTSWXZFHQR";

   // eerste regel bevat toernooi en datum
  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', '-')
            ->setCellValue('B2', $toernooi)
            ->setCellValue('C2', $datum)
            ->setCellValue('E2', 'De codes hebben betrekking op dit toernooi');

   // set code font als Courier
   $styleArray = array('font'  => 
                 array('bold'  => true,
                   'color' => array('rgb' => 'ff0000'),
                   'size'  => 10,
                   'name'  => 'Verdana'
             ));
  $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArray);    



  for ($i=1;$i<101;$i++){
       // deel 1
       $string='';
       for ($p = 0; $p < $length ; $p++) {
           $string .= $characters[mt_rand(0, strlen($characters) - 1)]; 
       }
       $code = $string;
       
        // deel 2 
        $string='';
        for ($p = 0; $p < $length ; $p++) {
           $string .= $characters[mt_rand(0, strlen($characters) - 1)]; 
        }
      	$code = $code.'-'.$string;
           
        // deel 3 
        $string='';
        for ($p = 0; $p < $length ; $p++) {
           $string .= $characters[mt_rand(0, strlen($characters) - 1)]; 
        }
        
        $code = $code.'-'.$string;
        $j=$i+2;
        // write to Excel
        $objPHPExcel->setActiveSheetIndex(0)
                   ->setCellValue('A'.$j, $i.'.')
                   ->setCellValue('B'.$j, $code);
       
       // set code font als Courier
       $styleArray = array('font'  => 
             array('bold'  => false,
                   'color' => array('rgb' => '000000'),
                   'size'  => 11,
                   'name'  => 'Courier New'
       ));
       $objPHPExcel->getActiveSheet()->getStyle('B'.$j)->applyFromArray($styleArray);    
       
  
         // insert in table     
        $sqlcmd = "INSERT INTO `voucher_codes` (`Id`, `Vereniging_id`, `Vereniging`, `Toernooi`, `Datum`, `Voucher_code`, `Laatst`) 
               VALUES (0, ".$vereniging_id.", '".$vereniging."', '".$toernooi."', '".$datum."', '".$code."', now() );"; 
       
        mysql_query($sqlcmd) or die ('fout in insert'); 
        }// end i
       

  // Rename worksheet
  echo date('H:i:s') , " Rename worksheet" , EOL;
  $objPHPExcel->getActiveSheet()->setTitle('Voucher codes');
  // Set active sheet index to the first sheet, so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Save Excel 2007 file
  echo date('H:i:s') , " Write to Excel2007 format" , EOL;
//  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
  $objWriter->save($xlsx_file);

  echo date('H:i:s') . " File written to " . $xlsx_file ;
 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// send email
// recipients

$mailto   = $_POST['email'].', erik.hendrikx@gmail.com';

//sender
$from     = 'ontip.voucher@ontip.nl';
$fromName = 'OnTip admin';

//email subject
$subject = 'OnTip Email met Voucher codes voor toernooi '.$toernooi;

//attachment file path
$file = $xlsx_file;


//email body content
$htmlContent = "<table>"   . "\r\n";
$htmlContent .= "<tr><td><img src= '". $url_logo ."' width=80></td>"   . "\r\n";
$htmlContent .= "<td style= 'font-family:verdana;font-size:12pt;color:blue;'><b>". htmlentities($toernooi_voluit, ENT_QUOTES | ENT_IGNORE, "UTF-8") ."<br><span style= 'font-family:Ariale;font-size:14pt;color:green;'>". strftime("%A %e %B %Y", mktime(0, 0, 0, $maand , $dag, $jaar) )  ."</span><br>". htmlentities($vereniging_output_naam , ENT_QUOTES | ENT_IGNORE, "UTF-8") ."</b></td></tr>" . "\r\n";
$htmlContent .= "</table>"   . "\r\n";
$htmlContent .= "<br><hr/>".   "\r\n";

$htmlContent .= '<h2>OnTip Voucher codes</h2>
    <p></p>
    <p style="font-family:verdana;font-size:10pt;">Deze mail bevat de voucher codes voor onderstaand toernooi:
    </p>
    <table width=80%>
    <tr><td width=40% style="font-family:verdana;font-size:10pt;">Vereniging : </td><td style="font-family:verdana;font-size:10pt;">'.$vereniging.'</td></tr>
    <tr><td style="font-family:verdana;font-size:10pt;">Toernooi  : </td><td style="font-family:verdana;font-size:10pt;">'.$toernooi_voluit.'</td></tr>
    <tr><td style="font-family:verdana;font-size:10pt;">Datum     : </td><td style="font-family:verdana;font-size:10pt;">'.$datum.'</td></tr>
    </table>
   <br>
    <p style="font-family:verdana;font-size:10pt;">Open bijgevoegd Excel bestand voor de codes. Deze codes zijn nu ook bekend in het systeem.</p>
    <br><b>Denk eraan !! Deze codes worden maar 1 keer verstrekt.
    <p>
    
    
    </p>';

$htmlContent .= "<br><div style= 'font-family:verdana;font-size:8.5pt;color:black;padding-top:20pt;'><hr/><img src = 'http://www.ontip.nl/ontip/images/OnTip_banner_klein.jpg' width='40'> Deze automatische mail is aangemaakt vanuit OnTIP. (c) Erik Hendrikx 2011-".date('Y')."</div>" . "\r\n";

//header for sender info
$headers = "From: $fromName"." <".$from.">";
    
//boundary 
$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

//headers for attachment 
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

//multipart boundary 
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
           "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

//preparing attachment
if(!empty($file) > 0){
    if(is_file($file)){
        $message .= "--{$mime_boundary}\n";
        $fp =    @fopen($file,"rb");
        $data =  @fread($fp,filesize($file));

        @fclose($fp);
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
        "Content-Description: ".basename($file)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
}
$message .= "--{$mime_boundary}--";
$returnpath = "-f" . $from;

//send email
$mail = @mail($mailto, $subject, $message, $headers, $returnpath); 

//email sending status
    echo $mail?"<h1>Mail sent.</h1>":"<h1>Mail sending failed.</h1>";	


 }// bevestig = Ja  
    ?>
    <script language="javascript">
        alert("Het window kan veilig afgesloten worden."  )
    </script>
  <script language="javascript">
		window.location.replace('index.php?toernooi=<?php echo $toernooi; ?>');
</script>
</body>
</html>