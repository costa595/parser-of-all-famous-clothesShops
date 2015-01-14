<?php

$request = curl_init();

curl_setopt_array($request, array
(
    CURLOPT_URL => 'http://www.adidas.ru/muzhchiny-odezhda?sz=240',
    
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER => FALSE,
    
    CURLOPT_SSL_VERIFYPEER => TRUE,
    CURLOPT_CAINFO => 'cacert.pem',

    CURLOPT_FOLLOWLOCATION => TRUE,
    CURLOPT_MAXREDIRS => 10,
));

$response = curl_exec($request);

curl_close($request);

$document = new DOMDocument();

if($response)
{
    libxml_use_internal_errors(true);
    $document->loadHTML($response);
    libxml_clear_errors();
}


foreach ($document->getElementsByTagName('img') as $img) 
{
    echo $img->getAttribute('src').'<br>';
}

?>