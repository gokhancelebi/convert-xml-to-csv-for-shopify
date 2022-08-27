<?php

$curl = curl_init();

$type = "POST";
$data = ["login" => "info@netrino-gmbh.de", "password" => "tonaki11T"];

curl_setopt($curl, CURLOPT_URL, "https://partnertele.com/api/frontend/en/tokens/login");

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = [];

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


if ($type != "GET") {
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
}

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookies.txt');
curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookies.txt');


curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIESESSION, true);

curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);


curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

curl_setopt($curl, CURLOPT_REFERER, 'https://partnertele.com/');

$resp = curl_exec($curl);

curl_close($curl);


var_dump($resp);


# https://partnertele.com/api/frontend/de/tariff_exports
