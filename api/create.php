<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


   
$data = json_decode(file_get_contents("php://input"));


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $data->url ,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_POSTFIELDS => array('authenticityToken' => 'ca1697d57f77b6d0e0955b2b5f054a16df1a48fb','customer.firstName' => $data->firstName,'customer.lastName' => $data->lastName,'customer.phone' => $data->phone,'customer.email' => $data->email,'customer.points' => $data->points),
  CURLOPT_HTTPHEADER => array(
    "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:82.0) Gecko/20100101 Firefox/82.0",
    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Language: en-US,en;q=0.5",
    "Content-Type: multipart/form-data; boundary=---------------------------29347128195731954393111850610",
    "Origin: https://d.pslot.io",
    "DNT: 1",
    "Connection: keep-alive",
    "Referer: https://d.pslot.io/l/yPNeIMF9o",
    "Cookie: passslot_SESSION=217df13a607ceb3b9c5c91f699831ce5f335c8ed-___AT=fa11848042ed01ef295f5fd5806b81115b61caad",
    "Upgrade-Insecure-Requests: 1",
    "TE: Trailers"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "CUSTOMER CREATED";

?>