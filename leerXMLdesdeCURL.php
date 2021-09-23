<?
///Muestra el xml completo

$url = 'https://xxxx/jasperserver/rest_v2/resources/';
$request = "{$url}"; // create the request URL
$headers = [
    'Authorization: Basic UEhQOlBIUENvbnN1bHRhMTIz',
    'Content-type: application/xml'
  ];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,  $request);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
curl_close($ch);



header("Content-Type: text/xml");
$decoded = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $result);
echo $decoded;
?>
