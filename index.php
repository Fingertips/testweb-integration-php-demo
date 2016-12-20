<?php

require 'global.php';

$response = get('/instruments');
if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}
$instruments = $response['data'];

?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<title>Instrumenten</title>
<link rel="stylesheet" media="all" href="default.css">
</head>
<body>

<div>

<h1>Kies een instrument</h1>

<ul>
  <?php foreach ($instruments as $instrument) { ?>
    <li>
      <a href="administration.php?instrument_id=<?php echo $instrument['instrument_id']; ?>">
        <?php echo $instrument['title']; ?>
      </a>
    </li>
  <?php } ?>
</ul>

<p class="note">Please note that you should not implement a selection menu like this as part of your integration. See the “Finding an instrument” section in the Integration API documentation for details.</p>

</div>

</body>
</html>