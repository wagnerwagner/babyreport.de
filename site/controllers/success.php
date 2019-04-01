<?php
try {
  $orderPage = merx()->completePayment($_GET);
  go($orderPage->url());
} catch (Exception $ex) {
  merx()->setMessage($ex->getMessage());
  go(option('checkoutPage'));
}
