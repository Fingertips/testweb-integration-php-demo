<?php

require 'global.php';

$response = get('/instruments/' . $_REQUEST['instrument_id']);
if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}
$instrument = $response['data'];

$completed = true;
$valid_responses = [];
foreach ($instrument['sections'] as $section) {
  foreach ($section['items'] as $item) {
    $options = $item['options'] ? $item['options'] : $instrument['options'];
    $option_values = array_map(function($o) { return $o['value']; }, $options);
    if (in_array($_POST[$item['item_id']], $option_values)) {
      $valid_responses[$item['item_id']] = $_POST[$item['item_id']];
    } else {
      $completed = false;
    }
  }
}
if ($completed) {
  $response = post('/administrations', [
    'instrument_id' => $instrument['instrument_id'],
    'responses' => $valid_responses
    ]);
  if ($response['status'] == 201) {
    header('Location: report.php?administration_id=' . $response['data']['administration_id']);
    exit();
  } else {
    exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
  }
}

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

<p><?php echo nl2br($instrument['instructions']) ?></p>

<?php if (!empty($valid_responses)) { ?>
  <p class="invalid">Beantwoord alle items om verder te gaan.</p>
<?php } ?>

<form method="post">

<ul class="sections">
  <?php foreach ($instrument['sections'] as $section) { ?>
    <li>
      <?php if ($section['title']) { ?>
        <h2><?php echo $section['title'] ?></h2>
      <?php } ?>
      <?php if ($section['description']) { ?>
        <p><?php echo nl2br($section['description']) ?></p>
      <?php } ?>
      <ol>
        <?php foreach ($section['items'] as $item) { ?>
          <li>
            <p><?php echo $item['stem']; ?></p>
            <div>
            <?php $options = $item['options'] ? $item['options'] : $instrument['options']; ?>
            <?php foreach ($options as $option) { ?>
              <label>
                <input type="radio" 
                  name="<?php echo $item['item_id'] ?>" 
                  value="<?php echo $option['value'] ?>"
                  <?php echo ($_POST[$item['item_id']] == $option['value']) ? 'checked' : '' ?>
                  >
                <?php echo $option['label'] ?>
              </label>
            <?php } ?>
            </div>
          </li>
        <?php } ?>
      </ol>
    </li>
  <?php } ?>
</ul>

<p><input type="submit" value="Ga verder"></p>

</form>

<div class="debug">
<h2>API response (instrument details):</h2>
<p>Completed in <?php echo $response['time'] ?>ms.</p>
<pre><?php var_dump($instrument) ?></pre>
</div>

</div>

</body>
</html>