<?php

require 'global.php';

$response = get('/instruments/' . $_REQUEST['instrument_id']);

if ($response['status'] != 200) {
  exit('HTTP ' . $response['status'] . ' ' . $response['data']['message']);
}

$instrument = $response['data']

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

<form method="post">

<ul class="sections">
  <?php foreach ($instrument['sections'] as $section) { ?>
    <li>
      <?php if (!$section['title']) { ?>
        <h2><?php echo $section['title'] ?></h2>
      <?php } ?>
      <?php if (!$section['description']) { ?>
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
                <input type="radio" name="<?php echo $item['item_id'] ?>" value="<?php echo $option['value'] ?>">
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

<p class="note">TODO: Test with multiple sections and per-item answer options.</p>

<pre><?php var_dump($response); ?></pre>

</div>

</body>
</html>