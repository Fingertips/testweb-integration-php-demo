<?php

require 'global.php';

// GET a list of all available instruments.
$response = request('/instruments');
if ($response['status'] != 200) {
  // Show an error message and exit if the response status code is not 200 OK.
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

<p class="note">Please note that you should not implement a selection menu like this as part of your integration. See the “Finding an instrument” section in the <a href="https://diagnose.testweb.bsl.nl/documentation/">Integration API documentation</a> for details.</p>

<div class="debug">
<h2>API response (available instruments):</h2>
<p>Completed in <?php echo $response['time'] ?>ms.</p>
<pre><?php var_dump($instruments) ?></pre>
</div>

</div>

</body>
</html>