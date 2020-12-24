<?php
require_once('../src/PassSlot.php');


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


   
$data = json_decode(file_get_contents("php://input"));

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.passslot.com/account/passes/search',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_POSTFIELDS => array('pidNumber' => $data->cardId,'authenticityToken' => 'ca1697d57f77b6d0e0955b2b5f054a16df1a48fb'),
  CURLOPT_HTTPHEADER => array(
    'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:82.0) Gecko/20100101 Firefox/82.0',
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Language: en-US,en;q=0.5',
    'Content-Type: multipart/form-data; boundary=---------------------------194859931514426677171394407230',
    'Origin: https://www.passslot.com',
    'DNT: 1',
    'Connection: keep-alive',
    'Referer: https://www.passslot.com/account/passes',
    'Cookie: __stripe_mid=7204a4d9-d74f-4190-b803-ee72c6ac0a5d68e539; passslot_RME=63382026efa2444cd0704cc1e420d97108fbfd8c-5624352824098816-1605787087462; passslot_SESSION=f463fa021eea110df215970de5ee8b97942e441a-s=e&___AT=ca1697d57f77b6d0e0955b2b5f054a16df1a48fb&userid=5624352824098816; passslot_SESSION=f463fa021eea110df215970de5ee8b97942e441a-s=e&___AT=ca1697d57f77b6d0e0955b2b5f054a16df1a48fb&userid=5624352824098816',
    'Upgrade-Insecure-Requests: 1',
    'TE: Trailers'
  ),
));

$response = curl_exec($curl);



$pieces = explode("pass.loyalty/", curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));

$serialNumber = $pieces[1];








$images = array(
	'thumbnail' => dirname(__FILE__) . '/thumbnail.png'
);

try {
	$engine = PassSlot::start($data->appKey);
	$url = $engine->getPassURL($data->passTypeId, $serialNumber);

    $values = $engine->getPassValues($data->passTypeId, $serialNumber);

    $engine->updatePassValue($data->passTypeId,$data->placeHolder,$serialNumber,$data->value);


    $myObj->url = $url;
    $myObj->customerId = $values->customerId;
    $myObj->serialNumber = $serialNumber;

    $myJSON = json_encode($myObj);

    echo $myJSON;

	

} catch (PassSlotApiException $e) {
	echo "Something went wrong:\n";
	echo $e;
}

