<?php

require 'global.php';

$response = get('/administrations/' . $_REQUEST['administration_id'] . '?norm_id=' . $_REQUEST['norm_id']);
if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}
$administration = $response['data'];

$response = get('/instruments/' . $administration['instrument_id']);
if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}
$instrument = $response['data'];

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
  <?php foreach ($administration['scores'] as $score) { ?>
    <tr<?php echo $score['cumulative'] ? ' class="total"' : ''; ?>>
      <th><?php echo $score['name']; ?></th>
      <td><?php echo $score['raw_score']; ?></td>
      <td><?php echo $score['classification']['quantitative_label']; ?></td>
      <td><?php echo $score['classification']['qualitative_label']; ?></td>
    </tr>
  <?php } ?>
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

<!-- <pre><?php var_dump($administration) ?></pre> -->
<!-- <pre><?php var_dump($instrument) ?></pre> -->

</div>

</body>
</html>