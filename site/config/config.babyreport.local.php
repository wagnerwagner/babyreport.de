<?php
$stripeTestPublishableKey = file_get_contents('secrects/.stripeTestPublishableKey', FILE_USE_INCLUDE_PATH);
$stripeTestSecretKey = file_get_contents('secrects/.stripeTestSecretKey', FILE_USE_INCLUDE_PATH);
$paypalSandboxClientID = file_get_contents('secrects/.paypalSandboxClientID', FILE_USE_INCLUDE_PATH);
$paypalSandboxSecret = file_get_contents('secrects/.paypalSandboxSecret', FILE_USE_INCLUDE_PATH);

return [
  'debug' => true,
  'cache' => false,
  'ww.merx.production' => false,
  'ww.merx.ordersPage' => 'test-rechnungen',
  'ww.merx.stripe.test.publishable_key' => $stripeTestPublishableKey,
  'ww.merx.stripe.test.secret_key' => $stripeTestSecretKey,
  'ww.merx.paypal.sandbox.clientID' => $paypalSandboxClientID,
  'ww.merx.paypal.sandbox.secret' => $paypalSandboxSecret,
];
