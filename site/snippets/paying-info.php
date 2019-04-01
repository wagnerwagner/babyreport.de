<div class="text text--half m-invoice__paying-info">
  <h2>Zahlung</h2>
  <p>
    Du hast die Zahlungsweise „<?= $page->paymentMethodString() ?>“ gewählt.
    <?php if ($page->payed()->isTrue()): ?>
    Die Zahlung ist bei uns noch nicht eingegangen.
    <?php elseif ($payedDate = $page->payedDate()->toDate()): ?>
      Die Rechnung wurde am <?= date('d.m.Y', $payedDate) ?>, <?= date('H:i', $payedDate) ?> Uhr beglichen.
    <?php else: ?>
      Die Zahlung ist bei uns noch nicht eingegangen.
    <?php endif; ?>
    <?php if ((string)$page->paymentMethod() === 'invoice' && $page->paymentComplete()->isFalse()): ?>
      <br>Bitte überweise <?= $page->formattedSum() ?> auf folgendes Konto.
    <?php endif; ?>
  </p>

  <?php if ((string)$page->paymentMethod() === 'invoice'): ?>
    <table>
      <tr>
        <th>Empfänger</th>
        <td><?= $site->accountHolder() ?></td>
      </tr>
      <tr>
        <th>IBAN</th>
        <td><?= formatIBAN($site->iban()) ?></td>
      </tr>
      <tr>
        <th>Betrag</th>
        <td><?= $page->formattedSum() ?></td>
      </tr>
      <tr>
        <th>Verwendungs­zweck</th>
        <td>Baby Report <?= $page->invoiceNumber() ?></td>
      </tr>
    </table>
  <?php endif; ?>
</div>
