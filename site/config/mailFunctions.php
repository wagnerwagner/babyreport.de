<?php
use Wagnerwagner\Merx\Merx;

function sendConfirmationMail(OrderPage $orderPage): void
{
  try {
    $email = new Kirby\Cms\Email([
      'from' => option('ww.merx.email'),
      'to' => (string)$orderPage->email(),
      'subject' => 'Deine Bestellung bei ' . site()->title(),
      'template' => 'confirmation',
      'data' => [
        'site' => kirby()->site(),
        'orderPage' => $orderPage,
      ],
    ]);
    new Kirby\Email\PHPMailer($email->toArray());
    $logArray = $email->toArray();
    unset($logArray['data']);
    // Merx::createLog($orderPage, 'info', 'Confirmation mail sent', $logArray);
  } catch (Exception $ex) {
    // Merx::createLog($orderPage, 'error', 'Confirmation mail could not be sent to customer', $ex->getMessage());
  }
}

function sendNewOrderToAdmin(OrderPage $orderPage): void
{
  try {
    $email = new Kirby\Cms\Email([
      'from' => option('ww.merx.email'),
      'replyTo' => (string)$orderPage->email(),
      'to' => option('ww.merx.email'),
      'subject' => 'Neue Bestellung ' . (string)$orderPage->givenName() . ' ' . (string)$orderPage->familyName() . ', ' . (string)$orderPage->city() . ' (' . Merx::formatPrice($orderPage->cart()->getSum()) . ')',
      'template' => 'new-order',
      'data' => [
        'site' => kirby()->site(),
        'orderPage' => $orderPage,
      ],
    ]);
    new Kirby\Email\PHPMailer($email->toArray());
    $logArray = $email->toArray();
    unset($logArray['data']);
    // Merx::createLog($orderPage, 'info', 'New order mail to admin sent', $logArray);
  } catch (Exception $ex) {
    // Merx::createLog($orderPage, 'error', 'New order mail could not be sent to admin', $ex->getMessage());
  }
}

function sendShippedMail(OrderPage $orderPage): void
{
  try {
    $email = new Kirby\Cms\Email([
      'from' => option('ww.merx.email'),
      'to' => (string)$orderPage->email(),
      'subject' => 'Deine Bestellung bei ' . site()->title() . ' wurde versandt.',
      'template' => 'shipped',
      'data' => [
        'site' => kirby()->site(),
        'orderPage' => $orderPage,
      ],
    ]);
    new Kirby\Email\PHPMailer($email->toArray());
    $logArray = $email->toArray();
    unset($logArray['data']);
    // Merx::createLog($orderPage, 'info', 'Shipping mail sent', $logArray);
  } catch (Exception $ex) {
    // Merx::createLog($orderPage, 'error', 'Shipping mail could not be sent to customer', $ex->getMessage());
  }
}

function sendPayedMail(OrderPage $orderPage): void
{
  try {
    $email = new Kirby\Cms\Email([
      'from' => option('ww.merx.email'),
      'to' => (string)$orderPage->email(),
      'subject' => 'Deine Bestellung bei ' . site()->title() . ' wurde bezahlt.',
      'template' => 'payed',
      'data' => [
        'site' => kirby()->site(),
        'orderPage' => $orderPage,
      ],
    ]);
    new Kirby\Email\PHPMailer($email->toArray());
    $logArray = $email->toArray();
    unset($logArray['data']);
    // Merx::createLog($orderPage, 'info', 'Payed mail sent', $logArray);
  } catch (Exception $ex) {
    // Merx::createLog($orderPage, 'error', 'Payed mail could not be sent to customer', $ex->getMessage());
  }
}
