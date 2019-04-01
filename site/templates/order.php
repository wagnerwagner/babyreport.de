<?php use Wagnerwagner\Merx; ?>
<?php use Kirby\Http\Url; ?>
<?php snippet('head') ?>

<main class="m-invoice">
  <a href="<?= $site->homePage()->url() ?>" class="button-back">
    Startseite
  </a>
  <div class="m-invoice__container">
    <?php if($page->invoiceDate()->toInt() + 60 * 30 > time()): ?>
      <div class="confirmation">
        <?= Str::replace($site->thankYouText()->kt(), '{{ email }}', $page->email()) ?>
      </div>
    <?php endif; ?>

    <?php snippet('invoice-header'); ?>

    <div class="m-invoice__overview">
      <h2>Übersicht</h2>
      <?php snippet('product-list', ['productList' => $page->cart()]) ?>
    </div>

    <?php snippet('shipping-info') ?>
    <?php snippet('paying-info') ?>
  </div>

  <div class="m-invoice__buttons">
    <button type="button" class="button" onclick="window.print()">
      Rechnung drucken
    </button>
  </div>

  <div class="invoice-footer">
    <div>
      <?= $site->seller()->kt() ?>
    </div>
    <div>
      <p>Konto-Inhaber: <?= $site->accountHolder() ?><br>
      IBAN: <?= formatIBAN($site->iban()) ?>
    </p>
    </div>
  </div>

  <?php snippet('legal-nav') ?>
</main>

<?php snippet('foot') ?>
