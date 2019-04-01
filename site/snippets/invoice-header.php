<header class="invoice-header">
  <div class="invoice-header__head">
    <h1>Rechnung</h1>
    <p class="invoice-header__infos">
      Rechunungsnummer: <?= $page->invoiceNumber() ?><br>
      Datum: <?= $page->invoiceDate()->toDate('d.m.Y') ?><br>
    </p>
  </div>
  <div class="invoice-header__contact">
    <p>
      <?= $page->givenName() ?> <?= $page->familyName() ?><br>
      <?= $page->street() ?><br>
      <?= $page->postalCode() ?> <?= $page->city() ?>
    </p>
    <p>
      <?= $page->email() ?>
    </p>
  </div>
</header>
