<?php

$Urls=array("https://paytmmall.com/asus-x507ua-ej562t-39-62-cm-15-6-inch-fhd-i5-8250u-8-gb-ddr4-1-tb-share-1b-grey-w10-home-802-11-b-g-n-bt-4-0-fp-1y-LAPASUS-X507UA-E-ST29032FD68C069-pdp",
"https://www.tatacliq.com/asus-vivobook-x507ua-ej562t-i5-8th-gen-8gb-1tb-15-6-inch-windows-10-1-68-kg-grey/p-mp000000003910089",
"https://www.flipkart.com/asus-core-i5-8th-gen-8-gb-1-tb-hdd-windows-10-home-x507ua-ej562t-laptop/p/itmf895nvbxyhyqk?pid=COMF895NU6TPUTHH&affid=storexerv");


foreach ($Urls as $key => $value) {
	request($value, "");	
}
function request($url, $payload) {
  $cmd = "curl -X POST -H 'Content-Type: text/html'";
  $cmd.= " -d '" . $payload . "' " . "'" . $url . "'";
  $cmd .= " > /dev/null 2>&1 &";
  echo "<br>".$cmd;
  exec($cmd, $output, $exit);
  echo "<br>";
  var_dump($output);
  return $exit == 0;
}
?>
