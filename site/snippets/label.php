<?php
use Kirby\Toolkit\Str;

$orderPage = new OrderPage([
  'slug' => Str::random(16),
  'template' => 'order',
]);
?>
<?php if ($field = $orderPage->blueprint()->fields()[$fieldId] ?? false):
  $required = isset($field['required']);
  $class = isset($class) ? $class : '';
  $class .= $required ? ' is-required' : '';
?>
<label class="<?= $class ?>">
  <strong><?= $label ?? $field['label'] ?></strong>
  <input type="<?= $field['type'] ?>" name="<?= strtolower($fieldId) ?>" <?= $required ? 'required' : '' ?> <?= isset($autocomplete) ? 'autocomplete="'.$autocomplete.'"' : '' ?>>
</label>
<?php endif; ?>
