<?php

require 'secret.php';

function request($path, $data=NULL) {
  global $endpoint, $reseller_id, $secret_key;
  $http = curl_init($endpoint . 'resellers/' . $reseller_id . $path);
  curl_setopt($http, CURLOPT_HTTPHEADER, ['Authorization: SecretKey ' . $secret_key, 'Content-type: application/json']);
  curl_setopt($http, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($http, CURLOPT_FAILONERROR, false);
  if ($data) {
    curl_setopt($http, CURLOPT_POST, true);
    curl_setopt($http, CURLOPT_POSTFIELDS, json_encode($data));
  }
  $time_start = microtime(true);
  $json = json_decode(curl_exec($http), true);
  $time_end = microtime(true);
  $status = curl_getinfo($http, CURLINFO_HTTP_CODE);
  curl_close($http);
  return ['status' => $status, 'data' => $json, 'time' => round(($time_end - $time_start) * 1000)];
}

?>