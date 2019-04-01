<?php
use Wagnerwagner\Merx\Merx;
?>
<?php if($productList): ?>
<div class="cart cart--checkout">
  <div class="cart__update-overlay">
  </div>
  <div class="cart__error-overlay" hidden>
  </div>
  <table>
    <thead>
      <tr>
        <th>Produkt</th>
        <th>Anzahl</th>
        <th>Einzelpreis</th>
        <th>Summe</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($productList as $item): ?>
      <?php
        $itemPage = page($item['id']);
      ?>
      <tr class="cart-item" id="<?= $itemPage->id() ?>">
        <th>
          <?php if ($itemPage) : ?>
            <?php if ($itemPage->cover()): ?>
              <img src="<?= $itemPage->cover()->resize(48, 72)->url() ?>" srcset="<?= $itemPage->cover()->resize(48 * 2, 72 * 2)->url() ?> 2x" alt="">
            <?php endif; ?>
            <div>
              <strong><?= $itemPage->title(); ?></strong>
              <?= $itemPage->productInfo(); ?>
            </div>
          <?php else: ?>
            <strong><?= $item['title'] ?></strong>
          <?php endif; ?>
        </th>
        <td>
          <button name="decrease"><div><span></span></div></button>
          <span class="cart-item__quantity"><?= $item['quantity'] ?></span>
          <button name="increase"><div><span></span><span></span></div></button>
        </td>
        <td>
          <small>Einzelpreis</small>
          <?= Merx::formatPrice($item['price']) ?>
        </td>
        <td>
          <small>Summe</small>
          <span class="cart-item__sum"><?= Merx::formatPrice($item['sum']) ?></span>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">
          Enthaltene MwSt.
        </td>
        <th class="cart__tax">
          <?= Merx::formatPrice($productList->getTax()) ?>
        </th>
      </tr>
      <tr>
        <th colspan="3">
            Summe
        </th>
        <th class="cart__sum">
          <?= Merx::formatPrice($productList->getSum()) ?>
        </th>
      </tr>
    </tfoot>
  </table>
</div>
<?php endif; ?>
