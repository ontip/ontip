<?php
require_once "ideal_payment.php"; 
include ('mysqli.php');

if (isset($_GET['transaction_id'])) 
{  
	echo "Transaction Id ". $_GET['transaction_id']. "<br>";
	
	//// ophalen gegevens vereniging
 $qry1          = mysqli_query($con,"SELECT * From vereniging where Vereniging = '".$vereniging ."' ")     or die(' Fout in select1');  
 $result1       = mysqli_fetch_array( $qry1 );
 $partner_id    = $result1['Ideal_partner_id']; // Uw mollie partner ID

	
	$iDEAL = new Mollie_iDEAL_Payment ($partner_id);
	$iDEAL->setTestMode();
	
	$iDEAL->checkPayment($_GET['transaction_id']);

	if ($iDEAL->getPaidStatus())
	{
		echo "Paid status gevonden <br>";
		/* De betaling is betaald, deze informatie kan opgeslagen worden (bijv. in de database).
	   	   Met behulp van $iDEAL->getConsumerInfo(); kunt u de consument gegevens ophalen (de 
		   functie returned een array). Met behulp van $iDEAL->getAmount(); kunt u het betaalde
		   bedrag vergelijken met het bedrag dat afgerekend zou moeten worden. */

   $sPaidStatus        = $iDEAL->getPaidStatus($_GET['transaction_id']);
   $sConsumer          = $iDEAL->getConsumerInfo($_GET['transaction_id']);
   $pAmount            = $iDEAL->getAmount();


  /*
     Status             Omschrijving 
     Success            De betaling is gelukt 
     Cancelled          De consument heeft de betaling geannuleerd. 
     Failure            De betaling is niet gelukt (er is geen verdere informatie beschikbaar) 
     Expired            De betaling is verlopen doordat de consument niets met de betaling heeft gedaan. 
  */


switch($sPaidStatus) {
	  case "1"   :  $sStatus = 'PAID';
	           break;
	  default    :  $sStatus = 'ONBEKEND:'.$sPaidStatus;
	           break;
}
 
                                     

foreach ($sConsumer  as $key => $value) {
       $$key = trim($value);    // maak variabelen
}

 if ($consumerCity    =='NOT PROVIDED'){
 	   $consumerCity    = 'Onbekend.';
 }	 
 
 
$querie = "UPDATE ideal_transacties SET Status      = '".$sStatus."',
                                   consumerName     = '".$consumerName."',
                                   consumerAccount  = '".$consumerAccount."',
                                   consumerCity     = '".$consumerCity."',
                                   paidAmount       = '".$pAmount."',
                                   Laatst = NOW()
                             WHERE Transaction_id = '".$_GET['transaction_id']."' ";
                            
	mysqli_query($con,$querie) or die ('Fout in update PAID status'); 

	} else {
		echo "Geen Paid status gevonden <br>";
	}
} else { echo "Geen transaction_id";
}
