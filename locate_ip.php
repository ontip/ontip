<?php
$ip = $_GET['ip'];

if ($ip ==''){
$ip_adres     = $_SERVER['REMOTE_ADDR'];
} else {
$ip_adres = $_GET['ip'];
}

$details = json_decode(file_get_contents("http://ipinfo.io/{$ip_adres}/json"));
?>
<script language="javascript">
 document.title = "IP locator ";
</script> 
<?php

echo "<h1> IP adres locator</h1><hr color='green'><br>";



echo "<table border = 1>";
echo "<tr><td>Stad        </td><td>". $details->city."</td></tr>";
echo "<tr><td>Regio       </td><td> ". $details->region."</td></tr>";
echo "<tr><td>Land        </td><td> ". $details->country."</td></tr>";
echo "<tr><td>GPS locatie </td><td> ". $details->loc." <a href = 'http://maps.google.com/?ll=".$details->loc."' target ='_blank'>Google maps</a></td></tr>";
echo "<tr><td>Organisatie </td><td> ". $details->org."</td></tr>";
echo "<tr><td>Host        </td><td> ". $details->hostname."</td></tr>";
echo "</table>";

echo "<br><br>(c) Erik Hendrikx ";

/*
hostname": "google-public-dns-a.google.com",
  "loc": "37.385999999999996,-122.0838",
  "org": "AS15169 Google Inc.",
  "city": "Mountain View",
  "region": "CA",
  "country": "US",
  "phone": 650

*/



?>



