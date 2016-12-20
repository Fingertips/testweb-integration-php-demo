<?php

require 'global.php';

$response = get('/administrations/' . $_REQUEST['administration_id'] . '?norm_id=' . $_REQUEST['norm_id']);
if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}
$instruments = $response['data'];

?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<title>Rapportage</title>
<link rel="stylesheet" media="all" href="default.css">
</head>
<body>

<div>

<pre><?php var_dump($response); ?></pre>

</div>

</body>
</html>