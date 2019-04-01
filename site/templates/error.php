<?php snippet('head') ?>

<main class="m-text">
  <a href="<?= $site->homePage()->url() ?>" class="button-back">
    Startseite
  </a>
  <div>
    <?= $page->text()->kt() ?>
  </div>

  <?php snippet('legal-nav') ?>
</main>

<?php snippet('foot') ?>
