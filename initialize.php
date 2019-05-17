<?php

$qry             = mysqli_query($con,"SELECT * from vereniging where Vereniging = '".$vereniging."' ")           or die(' Fout in select 1');  
$result          = mysqli_fetch_array( $qry);
$ideal_testmode  = $result['IDEAL_Test_Mode'];

// 22 dec 2016
require "../ontip/mollie/API/Autoloader.php";
//

if ($ideal_testmode  =='PROD'){ 

// prod

$mollie = new Mollie_API_Client;
$mollie->setApiKey("live_NVbhPbvEyQAcFEVz953nQGrqxVryDf");

} else { 

// test

$mollie = new Mollie_API_Client;
$mollie->setApiKey("test_gq3JBbEgiHCfM5F4RVMUhNwUybHBYv");

}
