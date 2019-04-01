<div class="text text--half m-invoice__shipping-info">
  <h2>Versand</h2>
  <?php if ($page->shipped()->isFalse()): ?>
    <p>Deine Bestellung wird in den nächsten Tagen versendet.</p>
  <?php elseif ($shippingDate = $page->shippingDate()->toInt()): ?>
    <p>Deine Bestellung wurde am <?= date('d.m.Y', $shippingDate) ?>, <?= date('H:i', $shippingDate) ?> Uhr versandt.</p>
  <?php else: ?>
    <p>Deine Bestellung wurde versandt.</p>
  <?php endif; ?>
  <h3>Versandadresse</h3>
  <p>
    <?php if ($page->useInvoiceAddressAsShippingAddress()->toBool()) : ?>
      <?= $page->givenName() ?> <?= $page->familyName() ?><br>
      <?= $page->street() ?><br>
      <?= $page->postalCode() ?> <?= $page->city() ?>
    <?php else: ?>
      <?= $page->shippingAddressGivenName() ?> <?= $page->shippingAddressFamilyName() ?><br>
      <?= $page->shippingAddressStreet() ?><br>
      <?= $page->shippingAddressPostalCode() ?> <?= $page->shippingAddressCity() ?>
    <?php endif; ?>
  </p>
</div>
