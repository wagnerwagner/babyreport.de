<?php
header("Cache-Control: max-age=600");
?>
<?php snippet('head') ?>

<main class="m-product">
  <div class="images">
    <ul>
    <?php foreach($page->images()->sortBy('sort') as $image): ?>
    <?php
    $image1x = $image->resize(912);
    $image2x = $image->resize(912 * 2);
    ?>
      <li>
        <figure>
          <div class="img" style="padding-top: <?= $image2x->height() / $image2x->width() * 100 ?>%">
            <img src="<?= $image1x->url() ?>" srcset="<?= $image1x->url() ?> <?= $image1x->width() ?>w, <?= $image2x->url() ?> <?= $image2x->width() ?>w" sizes="(max-width: 927px) 456px, 912px" alt="<?= $image->alt() ?>">
          </div>
        </figure>
      </li>
    <?php endforeach; ?>
    </ul>
  </div>
  <div class="product-content">
    <h1>
    <?php if ($logo = $site->files()->findBy('template', 'logo')): ?>
      <img src="<?= $site->files()->findBy('template', 'logo')->url() ?>" alt="<?= $site->title() ?>">
    <?php else: ?>
      <?= $site->title() ?>
    <?php endif; ?>
    </h1>
    <div class="product-content__text">
      <?= $page->text()->kt() ?>
      <?= $page->productInfo()->kt() ?>
    </div>
    <div class="product-content__price">
      <strong>
        <?= formatPrice($page->price()->float()); ?>
      </strong>
      <small>
        <?= $page->priceInfo() ?>
      </small>
    </div >
    <form class="form-buy" method="POST" action="/shop-api/add-to-cart">
      <input type="hidden" name="id" value="<?= $page->id() ?>">
      <input type="number" class="input" value="1" name="quantity" step="1" max="99" min="1" aria-label="Anzahl">
      <button type="submit" class="button">
        Bestellen
      </button>
      <div class="error"></div>
    </form>
    <?php snippet('legal-nav'); ?>
  </div>
</main>

<?php snippet('foot') ?>
