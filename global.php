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

?>