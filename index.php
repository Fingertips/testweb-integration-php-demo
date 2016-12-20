<?php

require 'global.php';

$response = get('/instruments');

if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}

?>

<h1>Choose an instrument</h1>

<ul>
  <?php foreach ($response['data'] as $instrument) { ?>
    <li>
      <a href="instrument.php?instrument_id=<?php echo $instrument['instrument_id']; ?>">
        <?php echo $instrument['title']; ?>
      </a>
    </li>
  <?php } ?>
</ul>

<hr>

<pre><?php var_dump($response); ?></pre>