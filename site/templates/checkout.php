<?php snippet('head') ?>
<main class="m-checkout">
  <a href="<?= $site->homePage()->url() ?>" class="button-back">
    Startseite
  </a>
  <?php if ($message = merx()->getMessage()): ?>
  <div class="error error--message">
    <strong><?= $message ?></strong><br>
  </div>
  <?php endif; ?>
  <div>
    <h2>Bestellübersicht</h2>
    <?php snippet('cart', ['productList' => merx()->cart()]) ?>
  </div>
  <form class="form-checkout" method="post" action="shop-api/submit">
    <h2>Kontakt</h2>
    <div class="form-checkout__section">
      <?php snippet('label', ['fieldId' => 'email', 'label' => 'E-Mail-Adresse', 'autocomplete' => 'email']); ?>
    </div>

    <h2>Rechnungsadresse</h2>
    <div class="form-checkout__section">
      <?php snippet('label', ['fieldId' => 'givenName', 'label' => 'Vorname', 'autocomplete' => 'given-name']); ?>
      <?php snippet('label', ['fieldId' => 'familyName', 'label' => 'Nachname', 'autocomplete' => 'family-name']); ?>
      <?php snippet('label', ['fieldId' => 'street', 'label' => 'Straße', 'class' => 'is-full', 'autocomplete' => 'street-address']); ?>
      <?php snippet('label', ['fieldId' => 'postalCode', 'label' => 'PLZ', 'class' => 'is-1-3', 'autocomplete' => 'postal-code']); ?>
      <?php snippet('label', ['fieldId' => 'city', 'label' => 'Stadt', 'class' => 'is-2-3', 'autocomplete' => 'locality']); ?>
      <input type="hidden" name="countryCode" value="DE" required>
    </div>

    <h2>Versandadresse</h2>
    <label class="is-checkbox">
      <input type="checkbox" name="useInvoiceAddressAsShippingAddress" checked>
      <em>Rechungsadresse verwenden</em>
    </label>

    <div id="shipping-address" class="form-checkout__section" hidden>
      <?php snippet('label', ['fieldId' => 'shippingAddressGivenName', 'label' => 'Vorname', 'class' => 'is-required', 'autocomplete' => 'shipping given-name']); ?>
      <?php snippet('label', ['fieldId' => 'shippingAddressFamilyName', 'label' => 'Nachname', 'class' => 'is-required', 'autocomplete' => 'shipping family-name']); ?>
      <?php snippet('label', ['fieldId' => 'shippingAddressStreet', 'label' => 'Straße', 'class' => 'is-full is-required', 'autocomplete' => 'shipping street-address']); ?>
      <?php snippet('label', ['fieldId' => 'shippingAddressPostalCode', 'label' => 'PLZ', 'class' => 'is-1-3 is-required', 'autocomplete' => 'shipping postal-code']); ?>
      <?php snippet('label', ['fieldId' => 'shippingAddressCity', 'label' => 'Stadt', 'class' => 'is-2-3 is-required', 'autocomplete' => 'shipping locality']); ?>
      <input type="hidden" name="shippingAddressCountryCode" value="DE">
    </div>

    <h2>Zahlungsmethode</h2>
    <div class="form-checkout__section--payment-selection">
      <?php foreach($site->paymentMethods()->toStructure() as $paymentMethod): ?>
        <label class="is-option">
          <input type="radio" name="paymentMethod" value="<?= $paymentMethod->value() ?>" __required data-submit-text="<?= $paymentMethod->buttonText() ?>">
          <em><?= $paymentMethod->text() ?></em>
        </label>
      <?php endforeach; ?>
    </div>

    <div class="form-checkout__section">
      <input type="hidden" name="stripePublishableKey" value="<?= option('ww.merx.production') === true ? option('ww.merx.stripe.live.publishable_key') : option('ww.merx.stripe.test.publishable_key') ?>">

      <label class="is-full is-required" hidden data-payment-method="credit-card-sca">
        <strong>Kreditkarte</strong>
        <div id="stripe-card"></div>
        <div class="error" role="alert"></div>
      </label>

      <label class="is-full is-required" hidden data-payment-method="sepa-debit">
        <strong>Lastschrift</strong>
        <div id="stripe-sepa-debit"></div>
        <small><?= $site->ibanInfo() ?></small>
        <div class="error" role="alert"></div>
      </label>
    </div>

    <div class="form-checkout__section">
      <label class="is-checkbox is-full">
        <input type="checkbox" name="legal" __required>
        <em>Hiermit akzeptiere ich die <a href="/widerrufsbelehrung" data-href="widerrufsbelehrung" data-target="popup">Widerrufsbelehrung</a>, die <a href="/datenschutzerklarung" data-href="datenschutzerklarung" data-target="popup">Datenschutzerklärung</a> und die <a href="/agb" data-href="agb" data-target="popup">AGB</a></em>
      </label>
    </div>

    <div class="form-checkout__submit">
      <div class="error" role="alert"></div>
      <button type="submit" class="button">
        Kaufen
      </button>
    </div>
  </form>
  <script src="https://js.stripe.com/v3/"></script>

  <section hidden id="widerrufsbelehrung" class="popup">
    <div class="text">
      <?= page('widerrufsbelehrung')->text()->kt() ?>
      <button class="button-close">
        <span></span>
        <span></span>
      </button>
    </div>
  </section>

  <section hidden id="datenschutzerklarung" class="popup">
    <div class="text">
      <?= page('datenschutzerklarung')->text()->kt() ?>
      <button class="button-close">
        <span></span>
        <span></span>
      </button>
    </div>
  </section>

  <section hidden id="agb" class="popup">
    <div class="text">
      <?= page('agb')->text()->kt() ?>
      <button class="button-close">
        <span></span>
        <span></span>
      </button>
    </div>
  </section>

  <?php snippet('legal-nav') ?>

</main>

<?php snippet('foot') ?>
