<?php
$title = $page->title() . ' – ' . $site->title();
if ($page->isHomePage()) {
  $title = $site->title();
} else if ($page->template()->name() === 'order') {
  $title = 'Rechnung ' . $page->invoiceNumber() . ' – ' . $site->title();
}
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <?php if ($page->metaDescription()->isNotEmpty()): ?>
      <meta name="description" content="<?= $page->metaDescription() ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
    <script src="<?= url('assets/js/script.js') ?>" defer></script>
    <?php if ((string)$page->intendedTemplate() === 'order'): ?>
    <meta name="robots" content="noindex">
    <?php endif; ?>
  </head>
  <body>
