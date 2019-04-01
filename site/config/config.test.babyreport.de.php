<?php
$stripeTestPublishableKey = file_get_contents('secrects/.stripeTestPublishableKey', FILE_USE_INCLUDE_PATH);
$stripeTestSecretKey = file_get_contents('secrects/.stripeTestSecretKey', FILE_USE_INCLUDE_PATH);
$paypalSandboxClientID = file_get_contents('secrects/.paypalSandboxClientID', FILE_USE_INCLUDE_PATH);
$paypalSandboxSecret = file_get_contents('secrects/.paypalSandboxSecret', FILE_USE_INCLUDE_PATH);

$mailHost = file_get_contents('secrects/.mailHost', FILE_USE_INCLUDE_PATH);
$mailPort = file_get_contents('secrects/.mailPort', FILE_USE_INCLUDE_PATH);
$mailUsername = file_get_contents('secrects/.mailUsername', FILE_USE_INCLUDE_PATH);
$mailPassword = file_get_contents('secrects/.mailPassword', FILE_USE_INCLUDE_PATH);

return [
  'debug' => true,
  'cache' => false,
  'ww.merx.ordersPage' => 'test-rechnungen',
  'ww.merx.stripe.test.publishable_key' => $stripeTestPublishableKey,
  'ww.merx.stripe.test.secret_key' => $stripeTestSecretKey,
  'ww.merx.paypal.sandbox.clientID' => $paypalSandboxClientID,
  'ww.merx.paypal.sandbox.secret' => $paypalSandboxSecret,
  'email' => [
    'transport' => [
      'type' => 'smtp',
      'host' => $mailHost,
      'port' => (int)$mailPort,
      'security' => false,
      'auth' => true,
      'username' => $mailUsername,
      'password' => $mailPassword,
    ],
  ],
];
