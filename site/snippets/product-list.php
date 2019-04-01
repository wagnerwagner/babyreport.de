<?php if($productList): ?>
<div class="cart">
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
      <tr class="cart-item">
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
          <small>Anzahl</small>
          <?= $item['quantity'] ?>
        </td>
        <td>
          <small>Einzelpreis</small>
          <?= formatPrice($item['price']) ?>
        </td>
        <td>
          <small>Summe</small>
          <?= formatPrice($item['sum']) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">
          Enthaltene MwSt.
        </td>
        <th>
          <?= formatPrice($productList->getTax()) ?>
        </th>
      </tr>
      <tr>
        <th colspan="3">
            Summe
        </th>
        <th>
          <?= formatPrice($productList->getSum()) ?>
        </th>
      </tr>
    </tfoot>
  </table>
</div>
<?php endif; ?>
