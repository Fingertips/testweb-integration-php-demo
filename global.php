<?php

require 'secret.php';

function get($path) {
  global $endpoint, $reseller_id, $secret_key;
  $http = curl_init($endpoint . 'resellers/' . $reseller_id . $path);
  curl_setopt($http, CURLOPT_HTTPHEADER, ['Authorization: SecretKey ' . $secret_key]);
  curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($http, CURLOPT_FAILONERROR, false);
  $json = json_decode(curl_exec($http), true);
  $status = curl_getinfo($http, CURLINFO_HTTP_CODE);
  curl_close($http);
  return ['status' => $status, 'data' => $json];
}

function post($path, $data) {
  global $endpoint, $reseller_id, $secret_key;
  $http = curl_init($endpoint . 'resellers/' . $reseller_id . $path);
  curl_setopt($http, CURLOPT_HTTPHEADER, ['Authorization: SecretKey ' . $secret_key, 'Content-type: application/json']);
  curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($http, CURLOPT_FAILONERROR, false);
  curl_setopt($http, CURLOPT_POST, true);
  curl_setopt($http, CURLOPT_POSTFIELDS, json_encode($data));
  $json = json_decode(curl_exec($http), true);
  $status = curl_getinfo($http, CURLINFO_HTTP_CODE);
  curl_close($http);
  return ['status' => $status, 'data' => $json];
}

?>