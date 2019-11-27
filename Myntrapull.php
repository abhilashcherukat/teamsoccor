<?php

$url="https://www.myntra.com/web/offers/1917349";
$file = __DIR__ . DIRECTORY_SEPARATOR . "the_divine_comedy.html";
$handle = curl_init();
 
// Open the file on our server for writing.
$fileHandle = fopen($file, "w");
 
curl_setopt_array($handle,
  array(
     CURLOPT_URL           => $url,
      CURLOPT_FILE => $fileHandle,
  )
);
 
$data = curl_exec($handle);
 
curl_close($handle);
 
fclose($fileHandle);
?>
