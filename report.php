<?php

require 'global.php';

// GET the report for the current administration.
$response_1 = request('/administrations/' . $_REQUEST['administration_id'] . '?norm_id=' . $_REQUEST['norm_id']);
if ($response_1['status'] != 200) {
  // Show an error message and exit if the response status code is not 200 OK.
  exit('HTTP ' . $response['status'] . ' ' . $response_1['data']['message']);
}
$administration = $response_1['data'];

// GET details of the instrument used in the administration so that we can show the list of available norms.
$response_2 = request('/instruments/' . $administration['instrument_id']);
if ($response_2['status'] != 200) {
  // Show an error message and exit if the response status code is not 200 OK.
  exit('HTTP ' . $response_2['status'] . ' ' . $response_2['data']['message']);
}
$instrument = $response_2['data'];

?>
<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="utf-8">
<title><?php echo $instrument['title'] ?></title>
<link rel="stylesheet" media="all" href="default.css">
</head>
<body>

<div>

<h1><?php echo $instrument['title'] ?></h1>

<?php if ($administration['scores']) { ?>
  <h2><?php echo $administration['norm_label'] ?></h2>
  
  <table>
  <thead>
    <tr>
      <th><?php echo $administration['labels']['name']; ?></th>
      <th><?php echo $administration['labels']['raw']; ?></th>
      <?php if ($administration['labels']['quantitative']) { ?>
        <th><?php echo $administration['labels']['quantitative']; ?></th>
      <?php } ?>
      <th><?php echo $administration['labels']['qualitative']; ?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($administration['scores'] as $score) { ?>
    <tr<?php echo $score['highlight'] ? ' class="highlight"' : ''; ?>>
      <th><?php echo $score['name']; ?></th>
      <td><?php echo $score['raw']; ?></td>
      <?php if ($administration['labels']['quantitative']) { ?>
        <td><?php echo $score['quantitative']; ?></td>
      <?php } ?>
      <td><?php echo $score['qualitative']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
  </table>
<?php } ?>

<h2>Kies een norm</h2>

<ul>
  <?php foreach ($instrument['norms'] as $norm) { ?>
    <li>
      <a href="report.php?administration_id=<?php echo $administration['administration_id']; ?>&amp;norm_id=<?php echo $norm['norm_id']; ?>">
        <?php echo $norm['label']; ?>
      </a>
    </li>
  <?php } ?>
</ul>

<div class="debug">
<h2>API response (administration):</h2>
<p>Completed in <?php echo $response_1['time'] ?>ms.</p>
<pre><?php var_dump($administration) ?></pre>
</div>

<div class="debug">
<h2>API response (instrument details):</h2>
<p>Completed in <?php echo $response_2['time'] ?>ms.</p>
<pre><?php var_dump($instrument) ?></pre>
</div>

</div>

</body>
</html>