<?php
header("Content-Type: application/json; charset=utf-8");

$ch = curl_init("https://restcountries.com/v3.1/name/mexico");

curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "User-Agent: PHP"
  ]
]);

$response = curl_exec($ch);

if ($response === false) {
  http_response_code(500);
  echo json_encode(["error" => "No se pudo consumir la API"]);
  exit;
}

curl_close($ch);

$data = json_decode($response, true);
$country = $data[0] ?? [];

// --- Gentilicio con fallback ---
if (isset($country['demonyms']['spa']['m'])) {
  $demonym = $country['demonyms']['spa']['m'];
} elseif (isset($country['demonyms']['eng']['m'])) {
  $demonym = $country['demonyms']['eng']['m'];
} else {
  $demonym = 'No disponible';
}

$result = [
  "name" => $country['name']['common'] ?? '',
  "translation_spa" => $country['translations']['spa']['common'] ?? '',
  "language" => isset($country['languages'])
    ? implode(", ", $country['languages'])
    : '',
  "demonym" => $demonym,
  "calling_code" => ($country['idd']['root'] ?? '') . ($country['idd']['suffixes'][0] ?? '')
];

echo json_encode($result);


