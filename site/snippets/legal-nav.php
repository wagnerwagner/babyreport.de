<nav class="legal-nav">
<?php foreach($site->pages()->filterBy('intendedTemplate', 'legal') as $item): ?>
  <a href="<?= $item->url() ?>"><?= $item->title() ?></a>
<?php endforeach; ?>
</nav>
