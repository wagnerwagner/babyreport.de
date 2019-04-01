<?php
$stripeLivePublishableKey = file_get_contents('secrects/.stripeLivePublishableKey', FILE_USE_INCLUDE_PATH);
$stripeLiveSecretKey = file_get_contents('secrects/.stripeLiveSecretKey', FILE_USE_INCLUDE_PATH);
$paypalLiveClientID = file_get_contents('secrects/.paypalLiveClientID', FILE_USE_INCLUDE_PATH);
$paypalLiveSecret = file_get_contents('secrects/.paypalLiveSecret', FILE_USE_INCLUDE_PATH);

$googleAnalticsTrackingId = file_get_contents('secrects/.googleAnalticsTrackingId', FILE_USE_INCLUDE_PATH);

$merxLicense = file_get_contents('secrects/.merxLicense', FILE_USE_INCLUDE_PATH);

$mailHost = file_get_contents('secrects/.mailHost', FILE_USE_INCLUDE_PATH);
$mailPort = file_get_contents('secrects/.mailPort', FILE_USE_INCLUDE_PATH);
$mailUsername = file_get_contents('secrects/.mailUsername', FILE_USE_INCLUDE_PATH);
$mailPassword = file_get_contents('secrects/.mailPassword', FILE_USE_INCLUDE_PATH);

return [
  'googleAnaltics.trackingId' => $googleAnalticsTrackingId,
  'ww.merx.production' => true,
  'ww.merx.license' => $merxLicense,
  'ww.merx.stripe.live.publishable_key' => $stripeLivePublishableKey,
  'ww.merx.stripe.live.secret_key' => $stripeLiveSecretKey,
  'ww.merx.paypal.live.clientID' => $paypalLiveClientID,
  'ww.merx.paypal.live.secret' => $paypalLiveSecret,
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
